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
        return $this->belongsTo(City::class,'city_id');
    }

    public function revenue(){
        return $this->belongsTo(revenue::class,'revenue_id');
    }
    public function admin(){
        return $this->belongsTo(Admin::class,'admin_id');
    }

    public function note_name(){
        if ($this->note_type == 1){
            return 'دفعات الموردين';
        }
        elseif ($this->note_type == 2){
            return 'الرواتب';
        }
        elseif ($this->note_type == 3){
            return 'المصاريف التشغيلية';
        }elseif ($this->note_type == 4){
            return 'المصاريف الأخرى';
        }elseif ($this->note_type == 5){
            return 'الديون';
        }elseif ($this->note_type == 6){
            return 'المصاريف التأسيسية';
        }elseif ($this->note_type == 7){
            return 'المصاريف الثقيلة';
        }elseif ($this->note_type == 8){
            return 'دفعات الأجارات';
        }elseif ($this->note_type == 9){
            return 'دفاتر أخرى';
        }elseif ($this->note_type == 10){
            return 'السحوبات الشخصية';
        }elseif ($this->note_type == 11){
            return 'دفعات التجار';
        }elseif ($this->note_type == 12){
            return 'تحصيلات الموظفين';
        }elseif ($this->note_type == 13){
            return 'تحصيلات جهات أخرى';
        }elseif ($this->note_type == 14){
            return 'الايرادات العامة';
        }
        return '';
    }

    public function oper_type(){
        if ($this->operation_type == 'store'){
            return 'إضافة';
        }
        elseif ($this->operation_type == 'update'){
            return 'تعديل';
        }
        elseif ($this->operation_type == 'delete'){
            return 'حذف';
        }
        return '';
    }
}
