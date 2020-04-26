<?php

use App\Shop\Categories\Category;
use App\Shop\Products\Product;
use Illuminate\Database\Seeder;

class CategoryProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class, 5)->create()->each(function ($category) {
            factory(Product::class, 5)->make()->each(function ($product) use ($category) {
                $category->products()->save($product);
            });
        });
    }
}
