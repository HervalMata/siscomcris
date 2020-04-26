<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 16:50
 */

namespace App\Shop\OrderProducts\Repositories;


use App\Shop\Base\BaseRepository;
use App\Shop\OrderProducts\OrderProduct;
use App\Shop\OrderProducts\Repositories\Interfaces\OrderDetailRepositoryInterface;
use App\Shop\Orders\Order;
use App\Shop\Products\Product;

class OrderDetailRepository extends BaseRepository implements OrderDetailRepositoryInterface
{
    /**
     * OrderDetailRepository constructor.
     * @param OrderProduct $orderDetail
     */
    public function __construct(OrderProduct $orderDetail)
    {
        $this->model = $orderDetail;
    }

    /**
     * @param Order $order
     * @param Product $product
     * @param int $quantity
     * @return mixed
     */
    public function createOrderDetail(Order $order, Product $product, int $quantity)
    {
        $order->products()->attach([$product->id => ['quantity' => $quantity]]);
        return $order->products;
    }
}
