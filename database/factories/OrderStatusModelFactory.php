<?php

/** @var Factory $factory */

use App\Shop\OrderStatuses\OrderStatus;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(OrderStatus::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'color' => $faker->hexColor
    ];
});
