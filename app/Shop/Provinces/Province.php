<?php

namespace App\Shop\Provinces;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = [
        'name',
        'country_id',
        'status'
    ];
}
