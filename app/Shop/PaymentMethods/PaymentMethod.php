<?php

namespace App\Shop\PaymentMethods;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'status'
    ];

    protected $hidden = [];
}
