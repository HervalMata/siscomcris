<?php

/** @var Factory $factory */

use App\Shop\Categories\Category;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->unique()->randomElement([
        'Laços',
        'Tiaras',
        'Viseiras'
    ]);

    return [
        'name' => $name,
        'slug' => Str::slug($name),
        'description' => $faker->paragraph,
        'cover' => null,
        'status' => 1
    ];
});
