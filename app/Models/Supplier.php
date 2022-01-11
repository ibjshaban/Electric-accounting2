<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

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
       return Payment::where('supplier_id', $this->id)->sum('amount') - Filling::where('supplier_id', $this->id)->sum(DB::raw('price * quantity'));
    }

    public function PayFillingsAutoFromPayments(){

        $sum_payments_amount= Payment::where('supplier_id', $this->id)->sum('amount');

        $sum_paid_fules_amount= RevenueFule::whereIn('filling_id', Filling::where('supplier_id', $this->id)->pluck('id'))->where('paid_amount','!=', 0)->sum('paid_amount');;
        $revenueFuleNotPaid=collect(DB::select('SELECT * FROM revenue_fules WHERE filling_id IN
                                  (SELECT id FROM fillings WHERE supplier_id = '.$this->id.')
                                   AND price * quantity != paid_amount ORDER BY price * quantity , created_at ASC'));

        if (count($revenueFuleNotPaid) > 0){
            $remaining_amount= $sum_payments_amount - $sum_paid_fules_amount;
            if ($remaining_amount > 0){
                foreach ($revenueFuleNotPaid as $revenueFule){
                    $amount= ($revenueFule->price* $revenueFule->quantity) - $revenueFule->paid_amount;
                    if ($remaining_amount >= $amount){
                        DB::table('revenue_fules')
                            ->where('id', $revenueFule->id)  // find your user by their email
                            ->limit(1)  // optional - to ensure only one record is updated.
                            ->update(array('paid_amount' => InsertLargeNumber($revenueFule->paid_amount + ($amount))));
                        $remaining_amount -= $amount;
                        if ($remaining_amount == 0){
                            break;
                        }
                    }
                    if ($remaining_amount < $amount){
                        DB::table('revenue_fules')
                            ->where('id', $revenueFule->id)  // find your user by their email
                            ->limit(1)  // optional - to ensure only one record is updated.
                            ->update(array('paid_amount' => InsertLargeNumber($revenueFule->paid_amount + ($remaining_amount))));
                        break;
                    }
                }
            }
            return;
        };
    }
}
