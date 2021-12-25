<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpensesItem extends Model
{
    use HasFactory;
    protected $fillable=['item','item_number','amount','price','expenses_id'];

    public function expenses(){
        return $this->belongsTo(Expenses::class,'expenses_id');
    }
}
