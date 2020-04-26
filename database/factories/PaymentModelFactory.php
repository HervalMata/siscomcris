<?php

/** @var Factory $factory */

use App\Shop\PaymentMethods\PaymentMethod;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(PaymentMethod::class, function (Faker $faker) {
    $name = 'Paypal';
    return [
        'name' => $name,
        'slug' => Str::slug($name),
        'description' => 'Paypal payment',
        'status' => 1
    ];
});
