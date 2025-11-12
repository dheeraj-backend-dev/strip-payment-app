<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'cart_id',
        'payment_method',
        'payment_status',
        'transaction_id',
        'amount',
    ];

    // Additional relationships and methods can be defined here
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
