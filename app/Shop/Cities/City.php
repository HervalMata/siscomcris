<?php

namespace App\Shop\Cities;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name',
        'province_id'
    ];
}
