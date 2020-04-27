<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 27/04/2020
 * Time: 15:33
 */

namespace Tests\Unit\OrderDetails;


use App\Shop\OrderProducts\OrderProduct;
use App\Shop\OrderProducts\Repositories\OrderDetailRepository;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\OrderRepository;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;
use Illuminate\Support\Str;
use Tests\TestCase;

class OrderDetailsUnitTest extends TestCase
{
    /** @test */
    public function it_can_show_all_the_products_attached_to_an_order()
    {
        $data = [
            'reference' => $this->faker->uuid,
            'courrier_id' => $this->courrier->id,
            'customer_id' => $this->customer->id,
            'address_id' => $this->address->id,
            'order_status_id' => $this->orderStatus->id,
            'payment_method_id' => $this->paymentMethod->id,
            'discounts' => 10.50,
            'total_products' => 100,
            'tax' => 10.00,
            'total' => 100.00,
            'total_paid' => 100,
            'invoice' => null,
        ];

        $orderRepository = new OrderRepository(new Order);
        $order = $orderRepository->createOrder($data);

        $productRepo = new ProductRepository(new Product);
        $p = $this->faker->word;

        $params = [
            'sku' => $this->faker->numberBetween(1111111, 9999999),
            'name' => $p,
            'slug' =>Str::slug($p),
            'description' => $this->faker->paragraph,
            'cover' => null,
            'quantity' => $this->faker->randomDigit,
            'price' => $this->faker->randomFloat(2,10, 999),
            'status' => 1
        ];

        $product = $productRepo->createProduct($params);
        $quantity = $this->faker->randomDigit;

        $orderDetailRepo = new OrderDetailRepository(new OrderProduct);
        $orderDetailRepo->createOrderDetail($order, $product, $quantity);
        $lists = $orderRepository->findProducts($order);
        foreach ($lists as $list) {
            $this->assertEquals($product->id, $list->id);
            $this->assertEquals($product->name, $list->name);
        }
    }

    /** @test */
    public function it_can_create_an_order_detail()
    {
        $data = [
            'reference' => $this->faker->uuid,
            'courrier_id' => $this->courrier->id,
            'customer_id' => $this->customer->id,
            'address_id' => $this->address->id,
            'order_status_id' => $this->order_status->id,
            'payment_method_id' => $this->payment_method->id,
            'discounts' => 10.50,
            'total_products' => 100,
            'tax' => 10.00,
            'total' => 100.00,
            'total_paid' => 100,
            'invoice' => null,
        ];

        $orderRepository = new OrderRepository(new Order);
        $order = $orderRepository->createOrder($data);

        $productRepo = new ProductRepository(new Product);
        $p = $this->faker->word;

        $params = [
            'sku' => $this->faker->numberBetween(1111111, 9999999),
            'name' => $p,
            'slug' =>Str::slug($p),
            'description' => $this->faker->paragraph,
            'cover' => null,
            'quantity' => $this->faker->randomDigit,
            'price' => $this->faker->randomFloat(2,10, 999),
            'status' => 1
        ];

        $product = $productRepo->createProduct($params);
        $quantity = $this->faker->randomDigit;

        $orderDetailRepo = new OrderDetailRepository(new OrderProduct);
        $orderDetails = $orderDetailRepo->createOrderDetail($order, $product, $quantity);

        foreach ($orderDetails as $detail) {
            $this->assertEquals($product->id, $detail->pivot->product_id);
            $this->assertEquals($order->id, $detail->pivot->order_id);
            $this->assertEquals($quantity, $detail->pivot->quantity);
        }
    }
}
