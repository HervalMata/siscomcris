<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 17:34
 */

namespace App\Shop\OrderStatus\Repositories;


use App\Shop\Base\BaseRepository;
use App\Shop\OrderStatus\Exceptions\OrderStatusInvalidArgumentException;
use App\Shop\OrderStatus\Exceptions\OrderStatusNotFoundException;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\OrderStatuses\Repositories\Interfaces\OrderStatusRepositoryInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class OrderStatusRepository extends BaseRepository implements OrderStatusRepositoryInterface
{
    /**
     * OrderStatusRepository constructor.
     * @param OrderStatus $orderStatus
     */
    public function __construct(OrderStatus $orderStatus)
    {
        $this->model = $orderStatus;
    }

    /**
     * @param array $params
     * @return OrderStatus
     */
    public function createOrderStatus(array $params): OrderStatus
    {
        try {
            return $this->create($params);
        } catch (QueryException $e) {
            throw new OrderStatusInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param array $params
     * @return OrderStatus
     */
    public function updateOrderStatus(array $params): OrderStatus
    {
        try {
            $this->update($params, $this->model->id);
            return $this->find($this->model->id);
        } catch (QueryException $e) {
            throw new OrderStatusInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return OrderStatus
     */
    public function findOrderStatusById(int $id): OrderStatus
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new OrderStatusNotFoundException($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function ListOrderStatuses()
    {
        return $this->all();
    }

    /**
     * @param OrderStatus $os
     * @return bool
     */
    public function deleteOrderStatus(OrderStatus $os): bool
    {
        return $this->delete($os->id);
    }
}
