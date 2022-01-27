<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Auto Models By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class OtherOperation extends Model {

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table    = 'other_operations';
    protected $fillable = [
        'id',
        'admin_id',
        'name',
        'price',
        'date',
        'note',
        'revenue_id',

        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * admin id relation method to get how add this data
     * @type hasOne
     * @param void
     * @return object data
     */
    public function admin_id() {
        return $this->hasOne(\App\Models\Admin::class, 'id', 'admin_id');
    }


    /**
     * revenue_id relation method
     * @param void
     * @return object data
     */
    public function revenue_id(){
        return $this->hasOne(\App\Models\revenue::class,'id','revenue_id');
    }

    /**
     * Static Boot method to delete or update or sort Data
     * @param void
     * @return void
     */
    protected static function boot() {
        parent::boot();
        // if you disable constraints should by run this static method to Delete children data
        static::deleting(function($otheroperation) {
            //$otheroperation->revenue_id()->delete();
        });
    }

}
