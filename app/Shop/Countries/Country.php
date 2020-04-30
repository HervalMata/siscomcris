<?php

namespace App\Shop\Countries;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'iso',
        'iso3',
        'numcode',
        'phonecode',
        'status'
    ];
}
