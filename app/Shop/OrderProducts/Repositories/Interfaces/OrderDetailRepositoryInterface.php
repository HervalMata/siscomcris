<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 16:48
 */

namespace App\Shop\OrderProducts\Repositories\Interfaces;


use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Orders\Order;
use App\Shop\Products\Product;

interface OrderDetailRepositoryInterface extends BaseRepositoryInterface
{
    public function createOrderDetail(Order $order, Product $product, int $quantity);
}
