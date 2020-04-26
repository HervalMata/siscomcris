<?php

/** @var Factory $factory */

use App\Shop\Courriers\Courrier;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Courrier::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->paragraph,
        'url' => $faker->sentence,
        'is_free' => 0,
        'status' => 1
    ];
});
