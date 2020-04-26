<?php

namespace App\Shop\Orders;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'reference',
        'courrier_id',
        'customer_id',
        'address_id',
        'order_status_id',
        'payment_method_id',
        'discounts',
        'total_products',
        'total',
        'tax',
        'total_paid',
        'invoice'
    ];

    protected $hidden = [];
}
