<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

// Auto Models By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.37]
// Copyright Reserved  [it v 1.6.37]
class SubItem extends Model {

protected $table    = 'sub_items';
protected $fillable = [
		'id',
        'price',
        'amount',
        'note',
        'parent_item_id',
		'created_at',
		'updated_at',
	];

	/**
    * parent_item_id relation method
    * @param void
    * @return object data
    */
   public function parent_item_id(){
      return $this->belongsTo(\App\Models\BasicParentItem::class,'parent_item_id');
   }

 	/**
    * Static Boot method to delete or update or sort Data
    * @param void
    * @return void
    */
   protected static function boot() {
      parent::boot();
      // if you disable constraints should by run this static method to Delete children data
         static::deleting(function($subitem) {
			//$subitem->parent_item_id()->delete();
         });
   }

}
