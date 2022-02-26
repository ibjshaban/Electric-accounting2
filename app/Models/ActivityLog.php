<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ActivityLog extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $casts = ['query' => 'array','information' => 'array'];

    public function admin(){
        $info= json_decode($this->information);
         if (is_numeric(intval($info->admin_id))){
            $admin= Admin::whereId($info->admin_id)->first();
            if (isset($admin)){
                return $admin;
            }
            return null;
        }
        return null;
    }

    public function item(){
        $info= json_decode($this->information);
        if (is_null($info->table) && is_null($info->item_id)){
            return null;
        }
        $item= DB::table($info->table)->where('id',$info->item_id)->first();
        $item= $this->DataFormat($info->table,$item);
        return $item;
    }

    public function show_new_data(){
        $info= json_decode($this->information);

        if (is_null($info->new_data)){
            return null;
        }
        $data= $info->new_data;
        $item= $this->DataFormat($info->table,$data);
        return $item;
    }

    public function DataFormat($table,$data){
        $item=[];
        if ($table == "admins"){
            $group= AdminGroup::whereId($data->group_id)->first();
            $item["name"]= $data->name;
            $item["mobile"]= $data->mobile;
            $item["email"]= $data->email;
            $item["group_id"]= $group ? $group->group_name : '';
        }
        return $item;
    }
}
