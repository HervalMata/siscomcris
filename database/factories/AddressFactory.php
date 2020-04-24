<?php

/** @var Factory $factory */

use App\Shop\Addresses\Address;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Address::class, function (Faker $faker) {
    return [
        'alias' => $faker->word,
        'address_1' => $faker->sentence,
        'address_2' => $faker->sentence,
        'zip' => 1101,
        'city_id' => 1,
        'province_id' => 1,
        'country_id' => 160,
        'customer_id' => 1,
        'status' => 1
    ];
});
