<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 27/04/2020
 * Time: 16:19
 */

namespace Tests\Unit\OrderStatuses;


use App\Shop\OrderStatus\Exceptions\OrderStatusInvalidArgumentException;
use App\Shop\OrderStatus\Exceptions\OrderStatusNotFoundException;
use App\Shop\OrderStatus\Repositories\OrderStatusRepository;
use App\Shop\OrderStatuses\OrderStatus;
use Tests\TestCase;

class OrderStatusUnitTest extends TestCase
{
    /** @test */
    public function it_errors_updating_the_order_status()
    {
        $this->expectException(OrderStatusInvalidArgumentException::class);

        $orderStatusRepository = new OrderStatusRepository($this->orderStatus);
        $orderStatusRepository->updateOrderStatus(['name' => null]);
    }

    /** @test */
    public function it_can_delete_the_order_status()
    {
        $create = [
            'name' => $this->faker->name,
            'color' => $this->faker->word
        ];

        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $os = $orderStatusRepo->createOrderStatus($create);

        $orderStatusRepo->deleteOrderStatus($os);
        $this->assertDatabaseMissing('order_statuses', $os->toArray());
    }

    /** @test */
    public function it_can_lists_all_the_order_statuses()
    {
        $create = [
            'name' => $this->faker->name,
            'color' => $this->faker->word
        ];

        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $orderStatusRepo->createOrderStatus($create);

        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);

        $lists = $orderStatusRepo->listOrderStatuses();
        foreach ($lists as $list) {
            $this->assertDatabaseHas('order_statuses', ['name' => $list->name]);
            $this->assertDatabaseHas('order_statuses', ['color' => $list->color]);
        }

    }

    /** @test */
    public function it_errors_getting_not_existing_order_status()
    {
        $this->expectException(OrderStatusNotFoundException::class);
        $this->expectExceptionMessage('Status da ordem não encontrada.');

        $orderStatusRepository = new OrderStatusRepository(new OrderStatus);
        $orderStatusRepository->findOrderStatusById(99999);
    }

    /** @test */
    public function it_can_get_the_order_status()
    {
        $create = [
            'name' => $this->faker->name,
            'color' => $this->faker->word
        ];

        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $orderStatus = $orderStatusRepo->createOrderStatus($create);

        $os = $orderStatusRepo->findOrderStatusById($orderStatus->id);

        $this->assertEquals($create['name'], $os->name);
        $this->assertDatabaseHas($create['color'], $os->color);
    }

    /** @test */
    public function it_can_update_the_order_status()
    {
        $orderStatusRepo = new OrderStatusRepository($this->orderStatus);

        $update = [
            'name' => $this->faker->name,
            'color' => $this->faker->word
        ];


        $orderStatus = $orderStatusRepo->updateOrderStatus($update);

        $this->assertEquals($update['name'], $orderStatus->name);
        $this->assertDatabaseHas($update['color'], $orderStatus->color);
    }

    /** @test */
    public function it_errors_creating_the_order_status()
    {
        $this->expectException(OrderStatusInvalidArgumentException::class);

        $orderStatusRepository = new OrderStatusRepository($this->orderStatus);
        $orderStatusRepository->createOrderStatus([]);
    }

    /** @test */
    public function it_can_create_the_order_statuses()
    {
        $create = [
            'name' => $this->faker->name,
            'color' => $this->faker->word
        ];

        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $orderStatus =$orderStatusRepo->createOrderStatus($create);

        $this->assertEquals($create['name'], $orderStatus->name);
        $this->assertEquals($create['color'], $orderStatus->color);

    }
}
