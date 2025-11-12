<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image_url',
        'stock_quantity',
        'status',
    ];

    // Additional relationships and methods can be defined here
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

}
