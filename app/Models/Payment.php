<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
    'order_id',
    'payment_reference',
    'payment_method',
    'amount',
    'paid_at',
];
    public function order()
{
    return $this->belongsTo(Order::class);
}
public function payments()
{
    return $this->hasMany(Payment::class);
}

}
