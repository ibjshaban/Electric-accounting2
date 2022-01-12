<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

// Auto Models By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.36]
// Copyright Reserved  [it v 1.6.36]
class Supplier extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'suppliers';
    protected $fillable = [
        'id',
        'admin_id',
        'name',
        'phone',
        'photo_profile',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Static Boot method to delete or update or sort Data
     * @param void
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        // if you disable constraints should by run this static method to Delete children data
        static::deleting(function ($supplier) {
        });
    }

    /**
     * admin id relation method to get how add this data
     * @type hasOne
     * @param void
     * @return object data
     */
    public function admin_id()
    {
        return $this->hasOne(\App\Models\Admin::class, 'id', 'admin_id');
    }

    public function FinancialDifferenceBetweenPaymentsAndFillings(){
       return Payment::where('supplier_id', $this->id)->sum('amount') - RevenueFule::whereIn('filling_id', Filling::where('supplier_id', $this->id)->pluck('id'))->sum('paid_amount');
    }
    public function PayFillingsAutoFromPayments(){
        $revenueFule=
            //RevenueFule::whereIn('filling_id', Filling::where('supplier_id', $this->id)->pluck('id'))
                //->whereRaw("paid_amount != (price*quantity)")
        DB::select('SELECT * FROM `revenue_fules` WHERE filling_id IN (SELECT `id` FROM `fillings` WHERE `supplier_id` = '.$this->id.') AND price * quantity != paid_amount');
                //->select('(price * quantity)  AS total_price')
                //->whereRaw("ORDER BY total_price DESC , ORDER BY created_at DESC")
                //->get();
        dd($revenueFule);
    }
}
