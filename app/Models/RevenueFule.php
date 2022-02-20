<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

// Auto Models By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class RevenueFule extends Model {

protected $table    = 'revenue_fules';
protected $appends=['filling_date','filling_name'];
protected $fillable = [
		'id',
		'admin_id',
        'quantity',
        'price',
        'paid_amount',
        'filling_id',
        'stock_id',
        'revenue_id',
        'city_id',
        'is_paid',
        'note',
		'created_at',
		'updated_at',
	];

	/**
    * filling_id relation method
    * @param void
    * @return object data
    */
	public function getFillingDateAttribute(){
	    return  $this->filling_id()->first()->filling_date;
    }
    public function getFillingNameAttribute(){
	    return  $this->filling_id()->first()->name;
    }
   public function filling_id(){
      return $this->hasOne(\App\Models\Filling::class,'id','filling_id');
   }

	/**
    * stock_id relation method
    * @param void
    * @return object data
    */
   public function stock_id(){
      return $this->hasOne(\App\Models\Stock::class,'id','stock_id');
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
         static::deleting(function($revenuefule) {

         });
   }

}
