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
        'balance',
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

    public function AddPayments($amount_p){

        $amount= $amount_p;
        $fules= RevenueFule::whereIn('filling_id', Filling::where('supplier_id', $this->id)->pluck('id'))
            ->where('is_paid','0')
            ->orderBy('quantity')
            ->get()
            ->map(function ($q){ $q->filling_date= $q->filling_date; return $q;})
            ->sortBy('filling_date');
        if (count($fules) > 0){
                foreach ($fules as $revenueFule){
                    $fule_price_amount= ($revenueFule->price* $revenueFule->quantity) - $revenueFule->paid_amount;
                    if ($amount >= $fule_price_amount){
                        RevenueFule::whereId($revenueFule->id)->first()->update(
                            ['paid_amount' => InsertLargeNumber($revenueFule->paid_amount + ($fule_price_amount)),
                                'is_paid'=> '1'
                            ]);
                        $amount -= $fule_price_amount;
                        if ($amount == 0){
                            break;
                        }
                    }
                    else{
                        RevenueFule::whereId($revenueFule->id)->first()->update(
                            ['paid_amount' => InsertLargeNumber($revenueFule->paid_amount + ($amount))]);
                        break;
                    }
                }

        };

        Supplier::withTrashed()->where('id',$this->id)->update(
            [
                'balance'=> InsertLargeNumber($this->balance + $amount_p)
            ]);
        return;
    }
    public function DeletePaymentsFromFule($dPrice){

        $deleted_price = $dPrice;

        $minus_price = $this->balance > 0 ? $this->balance - $deleted_price : -$deleted_price;

        if ($minus_price < 0){
            $minus_price= abs($minus_price);
            $fules= RevenueFule::whereIn('filling_id', Filling::where('supplier_id', $this->id)->pluck('id'))
                ->where('paid_amount','!=',0)
                ->orderByDesc('quantity')
                ->get()
                ->map(function ($q){ $q->filling_date= $q->filling_date; return $q;})
                ->sortByDesc('filling_date');

            foreach ($fules as $fule){

                if ($minus_price >= $fule->paid_amount){
                    RevenueFule::where('id', $fule->id)  // find your user by their email
                        ->limit(1)  // optional - to ensure only one record is updated.
                        ->update(['paid_amount' => InsertLargeNumber(0),'is_paid'=> '0']);
                    $minus_price -= $fule->paid_amount;
                }
                else{
                    RevenueFule::where('id', $fule->id)  // find your user by their email
                        ->limit(1)  // optional - to ensure only one record is updated.
                        ->update(
                            ['paid_amount' => InsertLargeNumber($fule->paid_amount - $minus_price),
                                'is_paid'=> 0]);
                    $minus_price= 0;
                }
                if ($minus_price == 0){
                    break;
                }
            }
        }

        Supplier::withTrashed()->where('id',$this->id)->update(
            [
                'balance'=> InsertLargeNumber($this->balance - $deleted_price)
            ]);

        return;
    }
    public function AddFillingsForSupplier($amount_price){
        $price = $amount_price;
        $minus_price = $this->balance > 0 ? $this->balance : 0;
        if ($minus_price > 0){
            $fules= RevenueFule::whereIn('filling_id', Filling::where('supplier_id', $this->id)->pluck('id'))
                ->where('is_paid','0')
                ->orderBy('quantity')
                ->get()
                ->map(function ($q){ $q->filling_date= $q->filling_date; return $q;})
                ->sortBy('filling_date');
            if (count($fules) > 0){
                foreach ($fules as $revenueFule){
                    $fule_price_amount= ($revenueFule->price* $revenueFule->quantity) - $revenueFule->paid_amount;
                    if ($minus_price >= $fule_price_amount){
                        RevenueFule::whereId($revenueFule->id)->first()->update(
                            ['paid_amount' => InsertLargeNumber($revenueFule->paid_amount + ($fule_price_amount)),
                                'is_paid'=> '1'
                            ]);
                        $minus_price -= $fule_price_amount;
                        if ($minus_price == 0){
                            break;
                        }
                    }
                    else{
                        RevenueFule::whereId($revenueFule->id)->first()->update(
                            ['paid_amount' => InsertLargeNumber($revenueFule->paid_amount + ($minus_price))]);
                        break;
                    }
                }
            }
        }
        Supplier::withTrashed()->where('id',$this->id)->update(
            [
                'balance'=> InsertLargeNumber($this->balance - $price)
            ]);
        return;
    }
    public function DeleteFillingFromSupplier($amount_p, $filling_amount){

        $fuel_amount= 0;
        $amount= $amount_p;
        $fules= RevenueFule::whereIn('filling_id', Filling::where('supplier_id', $this->id)->pluck('id'))
            ->where('is_paid','0')
            ->orderBy('quantity')
            ->get()
            ->map(function ($q){ $q->filling_date= $q->filling_date; return $q;})
            ->sortBy('filling_date');
        if (count($fules) > 0){
            foreach ($fules as $revenueFule){
                $fule_price_amount= ($revenueFule->price* $revenueFule->quantity) - $revenueFule->paid_amount;
                if ($amount >= $fule_price_amount){
                    RevenueFule::whereId($revenueFule->id)->first()->update(
                        ['paid_amount' => InsertLargeNumber($revenueFule->paid_amount + ($fule_price_amount)),
                            'is_paid'=> '1'
                        ]);
                    $amount -= $fule_price_amount;
                    $fuel_amount+= $fule_price_amount;
                    if ($amount == 0){
                        break;
                    }
                }
                else{
                    RevenueFule::whereId($revenueFule->id)->first()->update(
                        ['paid_amount' => InsertLargeNumber($revenueFule->paid_amount + ($amount))]);
                    $fuel_amount+= $amount;
                    $amount-= $amount;
                    break;
                }
            }

        };

        Supplier::withTrashed()->where('id',$this->id)->update(
            [
                'balance'=> InsertLargeNumber($this->balance + ($filling_amount - $amount_p +$amount) + $fuel_amount)
            ]);
        return;
    }


}
