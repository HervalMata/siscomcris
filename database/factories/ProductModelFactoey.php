<?php

/** @var Factory $factory */

use App\Shop\Products\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Product::class, function (Faker $faker) {
    $product = $faker->unique()->sentence;

    return [
        'sku' => $this->faker->numberBetween(1111111, 9999999),
        'name' => $product,
        'slug' => Str::slug($product),
        'description' => $this->faker->paragraph,
        'cover' => null,
        'quantity' => 10,
        'price' => 5.00,
        'status' => 1
    ];
});
