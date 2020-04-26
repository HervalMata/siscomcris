<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 25/04/2020
 * Time: 22:33
 */

namespace Tests\Unit\Products;


use App\Shop\Products\Exceptions\ProductInavalidArgumentException;
use App\Shop\Products\Exceptions\ProductNotFoundException;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProductUnitTest extends TestCase
{
    /** @test */
    public function it_can_delete_the_file_only_by_updating_the_database()
    {
        $product = new ProductRepository($this->product);
        $product->deleteFile(['product' => $this->product->id]);
    }

    /** @test */
    public function it_errors_When_the_slug_is_not_found()
    {
        $this->expectException(ProductNotFoundException::class);

        $product = new ProductRepository($this->product);
        $product->findCategoryBySlug(['slug' => 'unknown']);
    }

    /** @test */
    public function it_can_find_the_product_with_the_slug()
    {
        $product = new ProductRepository($this->product);
        $found = $product->findProductBySlug(['slug' => $this->product->slug]);

        $this->assertEquals($this->product->name, $found->name);
    }

    /** @test */
    public function it_errors_updating_the_product_when_required_fields_are_not_passed()
    {
        $this->expectException(ProductInavalidArgumentException::class);

        $product = new ProductRepository($this->product);
        $product->updateProduct(['name' => null]);
    }

    /** @test */
    public function it_errors_creating_the_product_when_required_fields_are_not_passed()
    {
        $this->expectException(ProductInavalidArgumentException::class);

        $product = new ProductRepository($this->product);
        $product->createProduct([]);
    }

    /** @Test */
    public function it_can_delete_a_product()
    {
        $product = new ProductRepository($this->product);
        $product->deleteProduct();

        $this->assertDatabaseHas('products', collect($this->product)->all());
    }

    /** @test */
    public function it_can_list_all_the_products()
    {
        $product = new ProductRepository(new Product());
        $list = $product->listProducts();

        $this->arrayHasKey(array_keys($list));
    }

    /** @test */
    public function it_errors_finding_a_product()
    {
        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage('Produto não encontrado.');

        $product = new ProductRepository(new Product());
        $product->findCategoryById(9999);
    }

    /** @test */
    public function it_can_find_the_product()
    {
        $product = new ProductRepository(new Product());
        $found = $product->findCategoryById($this->product->id);

        $this->assertInstanceOf(Product::class, $found);
        $this->assertEquals($this->product->sku, $found->sku);
        $this->assertEquals($this->product->name, $found->nome);
        $this->assertEquals($this->product->slug, $found->slug);
        $this->assertEquals($this->product->description, $found->description);
        $this->assertEquals($this->product->quantity, $found->quantity);
        $this->assertEquals($this->product->price, $found->price);
        $this->assertEquals($this->product->status, $found->status);
    }

    /** @test */
    public function it_can_update_the_product()
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
            'status' => 1
        ];

        $product = new ProductRepository(new Product());
        $updated = $product->updateProduct($params);

        $this->assertEquals($params['sku'], $updated->sku);
        $this->assertEquals($params['name'], $updated->name);
        $this->assertEquals($params['slug'], $updated->slug);
        $this->assertEquals($params['description'], $updated->description);
        $this->assertEquals($params['quantity'], $updated->quantity);
        $this->assertEquals($params['price'], $updated->price);
        $this->assertEquals($params['status'], $updated->status);
        $this->assertDatabaseHas('products', $params);
    }

    /** @test */
    public function it_can_create_the_product()
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
            'status' => 1
        ];

        $product = new ProductRepository(new Product());
        $created = $product->createProduct($params);

        $this->assertInstanceOf(Product::class, $created);
        $this->assertEquals($params['sku'], $created->sku);
        $this->assertEquals($params['name'], $created->name);
        $this->assertEquals($params['slug'], $created->slug);
        $this->assertEquals($params['description'], $created->description);
        $this->assertEquals($params['quantity'], $created->quantity);
        $this->assertEquals($params['price'], $created->price);
        $this->assertEquals($params['status'], $created->status);
        $this->assertDatabaseHas('products', $params);
    }
}
