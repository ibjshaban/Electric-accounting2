<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Auto Models By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class Employee extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $appends = ['debt'];
    protected $table = 'employees';
    protected $fillable = [
        'id',
        'admin_id',
        'name',
        'id_number',
        'address',
        'phone',
        'type_id',
        'city_id',
        'photo_profile',
        'salary',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();
        // if you disable constraints should by run this static method to Delete children data
        static::deleting(function ($employee) {
            //$employee->city_id()->delete();
            //$employee->city_id()->delete();
        });
    }

    /**
     * city_id relation method
     * @param void
     * @return object data
     */
    public function city_id()
    {
        return $this->hasOne(\App\Models\City::class, 'id', 'city_id');
    }

    /**
     * type_id relation method
     * @param void
     * @return object data
     */
    public function type_id()
    {
        return $this->hasOne(\App\Models\EmployeeType::class, 'id', 'type_id');
    }

    public function getDebtAttribute()
    {
        return $this->debt();
    }

    /**
     * Static Boot method to delete or update or sort Data
     * @param void
     * @return void
     */
    public function debt()
    {
        return \App\Models\Debt::where('employee_id', $this->id)->sum('remainder');
    }

}
