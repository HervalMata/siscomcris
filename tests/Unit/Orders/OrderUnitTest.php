<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 27/04/2020
 * Time: 17:23
 */

namespace Tests\Unit\Orders;


use App\Shop\Orders\Exceptions\OrderInvalidArgumentException;
use App\Shop\Orders\Exceptions\OrderNotFoundException;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\OrderRepository;
use Tests\TestCase;

class OrderUnitTest extends TestCase
{
    /** @test */
    public function it_errors_updating_the_product_with_needed_fields_not_passed()
    {
        $this->expectException(OrderInvalidArgumentException::class);

        $order = factory(Order::class);
        $orderRepository = new OrderRepository($order);
        $orderRepository->updateOrder(['total_products' => null]);
    }

    /** @test */
    public function it_can_list_all_the_orders()
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
        $orderRepository->createOrder($data);

        $lists = $orderRepository->listOrders($data);

        foreach ($lists as $list) {
            $this->assertEquals($data['reference'], $list->reference);
            $this->assertEquals($this->courrier->id, $list->courrier->id);
            $this->assertEquals($this->customer->id, $list->customer->id);
            $this->assertEquals($this->address->id, $list->address->id);
            $this->assertEquals($this->orderStatus->id, $list->orderStatus->id);
            $this->assertEquals($this->paymentMethod->id, $list->paymentMethod->id);
            $this->assertEquals($data['discounts'], $list->discounts);
            $this->assertEquals($data['total_products'], $list->total_products);
            $this->assertEquals($data['total_paid'], $list->total_paid);
            $this->assertEquals($data['invoice'], $list->invoice);
        }
    }

    /** @test */
    public function it_errors_looking_for_the_order_that_is_not_found()
    {
        $this->expectException(OrderNotFoundException::class);
        $this->expectExceptionMessage('Ordem não encontrada.');

        $orderRepository = new OrderRepository(new Order);
        $orderRepository->findOrderById(99999);
    }

    /** @test */
    public function it_can_get_the_order()
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
        $created = $orderRepository->createOrder($data);

        $found = $orderRepository->findOrderById($created->id);

        $this->assertEquals($data['reference'], $found->reference);
        $this->assertEquals($this->courrier->id, $found->courrier->id);
        $this->assertEquals($this->customer->id, $found->customer->id);
        $this->assertEquals($this->address->id, $found->address->id);
        $this->assertEquals($this->orderStatus->id, $found->orderStatus->id);
        $this->assertEquals($this->paymentMethod->id, $found->paymentMethod->id);
        $this->assertEquals($data['discounts'], $found->discounts);
        $this->assertEquals($data['total_products'], $found->total_products);
        $this->assertEquals($data['total_paid'], $found->total_paid);
        $this->assertEquals($data['invoice'], $found->invoice);
    }

    /** @test */
    public function it_can_update_the_order()
    {
        $order = factory(Order::class);
        $orderRepository = new OrderRepository($order);

        $update = [
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

        $updated = $orderRepository->updateOrder($update);

        $this->assertEquals($update['reference'], $updated->reference);
        $this->assertEquals($update['courrier_id'], $updated->courrier->id);
        $this->assertEquals($update['customer_id'], $updated->customer->id);
        $this->assertEquals($update['address_id'], $updated->address->id);
        $this->assertEquals($update['orderStatus_id'], $updated->orderStatus->id);
        $this->assertEquals($update['paymentMethod_id'], $updated->paymentMethod->id);
        $this->assertEquals($update['discounts'], $updated->discounts);
        $this->assertEquals($update['total_products'], $updated->total_products);
        $this->assertEquals($update['total_paid'], $updated->total_paid);
        $this->assertEquals($update['invoice'], $updated->invoice);
    }

    /** @test */
    public function it_errors_when_the_required_fields_are_not_passed()
    {
        $this->expectException(OrderInvalidArgumentException::class);

        $data = [
            'reference' => $this->faker->uuid,
            'courrier_id' => $this->courrier->id,
            'customer_id' => $this->customer->id,
            'address_id' => $this->address->id,
            'order_status_id' => $this->orderStatus->id,
            'payment_method_id' => $this->paymentMethod->id,
            'invoice' => null,
        ];

        $orderRepository = new OrderRepository(new Order);
        $orderRepository->createOrder($data);
    }

    /** @test */
    public function it_errors_when_foreign_keys_are_not_found()
    {
        $this->expectException(OrderInvalidArgumentException::class);

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
        $orderRepository->createOrder($data);
    }

    /** @test */
    public function it_can_create_the_order()
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
        $created = $orderRepository->updateOrder($data);

        $this->assertEquals($data['reference'], $created->reference);
        $this->assertEquals($data['courrier_id'], $created->courrier->id);
        $this->assertEquals($data['customer_id'], $created->customer->id);
        $this->assertEquals($data['address_id'], $created->address->id);
        $this->assertEquals($data['orderStatus_id'], $created->orderStatus->id);
        $this->assertEquals($data['paymentMethod_id'], $created->paymentMethod->id);
        $this->assertEquals($data['discounts'], $created->discounts);
        $this->assertEquals($data['total_products'], $created->total_products);
        $this->assertEquals($data['total_paid'], $created->total_paid);
        $this->assertEquals($data['invoice'], $created->invoice);
    }
}
