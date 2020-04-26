<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 17:30
 */

namespace App\Shop\OrderStatuses\Repositories\Interfaces;

use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\OrderStatuses\OrderStatus;

interface OrderStatusRepositoryInterface extends BaseRepositoryInterface
{
    public function ListOrderStatuses();

    public function createOrderStatus(array $params) : OrderStatus;

    public function updateOrderStatus(array $params) : OrderStatus;

    public function findOrderStatusById(int $id) : OrderStatus;

    public function deleteOrderStatus(OrderStatus $os) : bool;
}
