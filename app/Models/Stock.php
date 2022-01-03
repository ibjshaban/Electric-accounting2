<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Auto Models By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class Stock extends Model {

	use SoftDeletes;
	protected $dates = ['deleted_at'];

protected $table    = 'stocks';
protected $fillable = [
		'id',
		'admin_id',
        'name',
        'city_id',
		'created_at',
		'updated_at',
		'deleted_at',
	];

	/**
    * city_id relation method
    * @param void
    * @return object data
    */
   public function city_id(){
      return $this->hasOne(\App\Models\City::class,'id','city_id');
   }

 	/**
    * Static Boot method to delete or update or sort Data
    * @param void
    * @return void
    */
   protected static function boot() {
      parent::boot();
      // if you disable constraints should by run this static method to Delete children data
         static::deleting(function($stock) {
			//$stock->city_id()->delete();
         });
   }

}
