<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

// Auto Models By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class Payment extends Model {

protected $table    = 'payments';
protected $fillable = [
		'id',
		'admin_id',
        'amount',
        'supplier_id',

		'created_at',
		'updated_at',
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
    * supplier_id relation method
    * @param void
    * @return object data
    */
   public function supplier_id(){
      return $this->hasOne(\App\Models\Supplier::class,'id','supplier_id');
   }

 	/**
    * Static Boot method to delete or update or sort Data
    * @param void
    * @return void
    */
   protected static function boot() {
      parent::boot();
      // if you disable constraints should by run this static method to Delete children data
         static::deleting(function($payment) {
			//$payment->supplier_id()->delete();
         });
   }
		
}
