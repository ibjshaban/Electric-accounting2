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
        $sum_paid_fules_amount= RevenueFule::whereIn('filling_id', Filling::where('supplier_id', $this->id)->pluck('id'))
            ->where('paid_amount','!=', 0)
            ->sum('paid_amount');

        /*$revenueFuleNotPaid= collect(DB::select('SELECT * FROM revenue_fules WHERE filling_id IN
                                  (SELECT id FROM fillings WHERE supplier_id = '.$this->id.')
                                   AND price * quantity != paid_amount'));*/

        $revenueFuleNotPaid= RevenueFule::whereIn('filling_id', Filling::where('supplier_id', $this->id)->pluck('id'))
            ->fuleNotPaid()
            ->get();
        $revenueFuleNotPaid->map(function ($query){
            $query->filling_date= Filling::whereId($query->filling_id)->first()->filling_date;
            $query->total_price= $query->total_price;
        })
        ->sortBy('filling_date');
        dd($revenueFuleNotPaid);
        if (count($revenueFuleNotPaid) > 0){
            $remaining_amount= $sum_payments_amount - $sum_paid_fules_amount;
                foreach ($revenueFuleNotPaid as $revenueFule){
                    $amount= ($revenueFule->price* $revenueFule->quantity) - $revenueFule->paid_amount;
                    dd($remaining_amount, $amount,$this->FinancialDifferenceBetweenPaymentsAndFillings(),$sum_payments_amount , $sum_paid_fules_amount);
                    if ($remaining_amount >= $amount){
                        dd('2');
                        RevenueFule::where('id', $revenueFule->id)  // find your user by their email
                            ->limit(1)  // optional - to ensure only one record is updated.
                            ->update(array('paid_amount' => InsertLargeNumber($revenueFule->paid_amount + ($amount))));
                        $remaining_amount -= $amount;
                        if ($remaining_amount == 0){
                            break;
                        }
                    }
                    if ($remaining_amount < $amount){
                        dd('3');
                        RevenueFule::where('id', $revenueFule->id)  // find your user by their email
                            ->limit(1)  // optional - to ensure only one record is updated.
                            ->update(array('paid_amount' => InsertLargeNumber($revenueFule->paid_amount + ($remaining_amount))));
                        break;
                    }
                }
            return;
        };
    }

    public function DeletePiadPriceFromFillingWhenDeletePayment($dPrice){

        $deleted_price = $dPrice;
        $remain_price= $this->FinancialDifferenceBetweenPaymentsAndFillings();
        if ($remain_price > 0){
            $deleted_price -= $remain_price;
        }
        if ($deleted_price > 0){
            $revenueFulePaid= collect(DB::select('SELECT * FROM revenue_fules WHERE filling_id IN
                                  (SELECT id FROM fillings WHERE supplier_id = '.$this->id.')
                                   AND paid_amount != 0'));
            $revenueFulePaid->map(function ($query){
                $query->filling_date= Filling::whereId($query->filling_id)->first()->filling_date;
            })
            ->sortByDesc('filling_date');

            foreach ($revenueFulePaid as $fule){
                if ($deleted_price >= $fule->paid_amount){
                    $deleted_price -= $fule->paid_amount;
                    RevenueFule::where('id', $fule->id)  // find your user by their email
                        ->limit(1)  // optional - to ensure only one record is updated.
                        ->update(array('paid_amount' => InsertLargeNumber(0)));
                }
                else{
                    RevenueFule::where('id', $fule->id)  // find your user by their email
                        ->limit(1)  // optional - to ensure only one record is updated.
                        ->update(array('paid_amount' => InsertLargeNumber($fule->paid_amount - $deleted_price)));
                    $deleted_price= 0;
                }
                if ($deleted_price == 0){
                    break;
                }
            }
        }
        //$this->PayFillingsAutoFromPayments();
        return;
    }


}
