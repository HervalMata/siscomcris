<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 17:52
 */

namespace App\Shop\Orders\Repositories\Interfaces;


use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Orders\Order;

interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function ListOrders(string $order = 'id', string $sort = 'desc') : array;

    public function createOrder(array $params) : Order;

    public function updateOrder(array $params) : Order;

    public function findOrderById(int $id) : Order;

    public function findProducts(Order $order);
}
