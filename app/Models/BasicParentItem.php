<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

// Auto Models By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.37]
// Copyright Reserved  [it v 1.6.37]
class BasicParentItem extends Model {

protected $table    = 'basic_parent_items';
protected $fillable = [
		'id',
		'admin_id',
        'name',
        'price',
        'discount',
        'date',
        'amount',
        'note',
        'basic_id',
		'created_at',
		'updated_at',
	];

	/**
    * basic_id relation method
    * @param void
    * @return object data
    */
   public function basic_id(){
      return $this->hasOne(\App\Models\BasicParent::class,'id','basic_id');
   }

 	/**
    * Static Boot method to delete or update or sort Data
    * @param void
    * @return void
    */
   protected static function boot() {
      parent::boot();
      // if you disable constraints should by run this static method to Delete children data
         static::deleting(function($basicparentitem) {
			//$basicparentitem->basic_id()->delete();
         });
   }
		
}
