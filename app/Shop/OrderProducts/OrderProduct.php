<?php

namespace App\Shop\OrderProducts;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity'
    ];

    protected $hidden = [];
}
