<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ActivityLog extends Model
{
    //use HasFactory;
    protected $guarded=[];

    public function city(){
        return $this->hasOne(City::class,'city_id');
    }
    
    public function revenue(){
        return $this->hasOne(revenue::class,'revenue_id');
    }
}
