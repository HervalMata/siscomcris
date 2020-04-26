<?php

namespace App\Shop\OrderStatuses;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = [
        'name',
        'color'
    ];

    protected $hidden = [];
}
