<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 27/04/2020
 * Time: 18:19
 */

namespace Tests\Unit\Cart;


use App\Shop\Cart\Exceptions\ProductInCartNotFoundException;
use App\Shop\Cart\Repositories\CartRepository;
use App\Shop\Cart\ShoppingCart;
use Tests\TestCase;

class CartUnitTest extends TestCase
{
    /** @test */
    public function it_returns_all_the_items_in_the_cart()
    {
        $qty = 1;
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, $qty);

        $lists = $cartRepo->getCartItems();

        foreach ($lists as $list) {
            $this->assertEquals($this->product->name, $list->name);
            $this->assertEquals($this->product->price, $list->price);
            $this->assertEquals($qty, $list->qty);
        }
    }

    /** @test */
    public function it_can_show_the_specific_item_in_the_cart()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);
        $items = $cartRepo->getCartItems();

        $product = [];
        foreach ($items as $item) {
            $product[] = $cartRepo->findItem($item->rowId);
        }
        $this->assertEquals($product[0]->name, $this->product->name);
    }

    /** @test */
    public function it_can_update_the_cart_qty_in_the_cart()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);
        $items = $cartRepo->getCartItems();

        $rowId = [];
        foreach ($items as $item) {
            $rowId[] = $item->rowId;
            $cartRepo->updateQuantityInCart($item->rowId, 3);
        }
        $this->assertEquals(3, $cartRepo->updateQuantityInCart($rowId[0])->qty);
    }

    /** @test */
    public function it_can_return_the_total_value_of_the_items_in_the_cart()
    {
        $qty = 3;
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, $qty);
        $total = $cartRepo->getTotal();
        $totalPrice = $this->product->price * $qty;
        $grandTotal = $totalPrice + $cartRepo->getTax();

        $this->assertEquals($grandTotal, $total);
    }

    /** @test */
    public function it_can_return_the_sub_total_of_the_items()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);
        $cartRepo->addToCart($this->product, 1);
        $subTotal = $cartRepo->getSubTotal();

        $this->assertEquals(10, $subTotal);
    }

    /** @test */
    public function it_can_count_the_total_of_the_items_in_the_cart()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);
        $count = $cartRepo->countItems();

        $this->assertEquals(1, $count);
    }

    /** @test */
    public function it_errors_when_removing_item_in_the_cart()
    {
        $this->expectException(ProductInCartNotFoundException::class);

        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);
        $cartRepo->removeToCart('unknown');
    }

    /** @test */
    public function it_can_remove_item_in_the_cart()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);
        $items = $cartRepo->getCartItems();

        foreach ($items as $item) {
            $cartRepo->removeToCart($item->rowId);
        }

        foreach ($items as $item) {
            $this->assertNotEquals($this->product->id, $item->id);
        }

    }

    /** @test */
    public function it_can_add_in_the_cart()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);
        $items = $cartRepo->getCartItems();

        foreach ($items as $item) {
            $this->assertEquals($this->product->name, $item->name);
        }
    }
}
