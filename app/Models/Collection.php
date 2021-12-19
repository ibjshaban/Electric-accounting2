<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

// Auto Models By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class Collection extends Model {

protected $table    = 'collections';
protected $fillable = [
		'id',
		'admin_id',
        'employee_id',

        'revenue_id',

        'amount',
        'collection_date',
        'source',
        'note',
        'status',
		'created_at',
		'updated_at',
	];

	/**
    * employee_id relation method
    * @param void
    * @return object data
    */
   public function employee_id(){
      return $this->hasOne(\App\Models\Employee::class,'id','employee_id');
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
         static::deleting(function($collection) {
			//$collection->employee_id()->delete();
			//$collection->employee_id()->delete();
         });
   }

}
