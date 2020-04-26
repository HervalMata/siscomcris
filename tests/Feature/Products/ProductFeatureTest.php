<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 25/04/2020
 * Time: 23:02
 */

namespace Tests\Feature\Products;


use App\Shop\Categories\Category;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProductFeatureTest extends TestCase
{
    /** @test */
    public function it_can_detach_the_categories_associated_with_the_product()
    {
        $product = 'apple';

        $params = [
            'sku' => $this->faker->numberBetween(1111111, 9999999),
            'name' => $product,
            'slug' => Str::slug($product),
            'description' => $this->faker->paragraph,
            'cover' => null,
            'quantity' => 10,
            'price' => 9.95,
            'status' => 1,
            'categories' => []
        ];

        $this->actingAs($this->employee, 'admin')
            ->post(route('products.update', $this->product->id, $params))
            ->assertSessionHas('message')
            ->assertRedirect(route('products.edit',$this->product->id ));
    }

    /** @test */
    public function it_can_sync_the_categories_associated_with_the_product()
    {
        $categories = [];
        $cats = factory(Category::class)->create();
        foreach ($cats as $cat) {
            $categories[] = $cat['id'];
        }
        $product = 'apple';
        $params = [
            'sku' => $this->faker->numberBetween(1111111, 9999999),
            'name' => $product,
            'slug' => Str::slug($product),
            'description' => $this->faker->paragraph,
            'cover' => null,
            'quantity' => 10,
            'price' => 9.95,
            'status' => 1,
            'categories' => []
        ];

        $this->actingAs($this->employee, 'admin')
            ->post(route('products.update', $this->product->id, $params))
            ->assertSessionHas('message')
            ->assertRedirect(route('products.edit',$this->product->id ));
    }
}
