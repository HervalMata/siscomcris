<?php

namespace App\Shop\Courriers;

use Illuminate\Database\Eloquent\Model;

class Courrier extends Model
{
    protected $fillable = [
        'name',
        'description',
        'url',
        'is_free',
        'status'
    ];

    protected $hidden = [];
}
