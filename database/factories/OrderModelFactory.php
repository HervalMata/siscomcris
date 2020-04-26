<?php

/** @var Factory $factory */

use App\Shop\Orders\Order;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'reference' => $faker->uuid,
        'courrier_id' =>1,
        'customer_id' => 1,
        'address_id' => 1,
        'order_status_id' => 1,
        'payment_method_id' => 1,
        'discounts' => $faker->randomFloat(2, 10, 999),
        'total_products' => $faker->randomFloat(2, 10, 5555),
        'tax' => $faker->randomFloat(2, 10, 9999),
        'total' => $faker->randomFloat(2, 10, 9999),
        'total_paid' => $faker->randomFloat(2,10, 9999),
        'invoice' => null
    ];
});
