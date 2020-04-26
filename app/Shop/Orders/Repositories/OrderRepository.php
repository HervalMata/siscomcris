<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 18:34
 */

namespace App\Shop\Orders\Repositories;


use App\Shop\Addresses\Address;
use App\Shop\Addresses\Repositories\AddressRepository;
use App\Shop\Base\BaseRepository;
use App\Shop\Courriers\Courrier;
use App\Shop\Courriers\Repositories\CourrierRepository;
use App\Shop\Customers\Customer;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Orders\Exceptions\OrderInvalidArgumentException;
use App\Shop\Orders\Exceptions\OrderNotFoundException;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\Shop\OrderStatus\Repositories\OrderStatusRepository;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\PaymentMethods\PaymentMethod;
use App\Shop\PaymentMethods\Repositories\PaymentMethodRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    /**
     * OrderRepository constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->model = $order;
    }

    /**
     * @param array $params
     * @return Order
     */
    public function createOrder(array $params): Order
    {
        try {
            return $this->create($params);
        } catch (QueryException $e) {
            throw new OrderInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param array $params
     * @return Order
     */
    public function updateOrder(array $params): Order
    {
        try {
            $this->update($params, $this->model->id);
            return $this->find($this->model->id);
        } catch (QueryException $e) {
            throw new OrderInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return Order
     */
    public function findOrderById(int $id): Order
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new OrderNotFoundException($e->getMessage());
        }
    }

    /**
     * @param string $order
     * @param string $sort
     * @return array
     */
    public function ListOrders(string $order = 'id', string $sort = 'desc'): array
    {
        $orders = $this->model->orderBy($order, $sort)->get();
        return collect($orders)->map(function ($order) {
            return $this->transformOrder($order);
        });
    }

    /**
     * @param Order $order
     * @return mixed
     */
    public function findProducts(Order $order)
    {
        return $order->products;
    }

    private function transformOrder(Order $order)
    {
        $prop = new Order;
        $prop->id = (int) $order->id;
        $prop->reference = $order->reference;

        $courrierRepopsitory = new CourrierRepository(new Courrier);
        $prop->courrier = $courrierRepopsitory->findCourrierById($order->courrier_id);

        $customerRepopsitory = new CustomerRepository(new Customer);
        $prop->customer = $customerRepopsitory->findCustomerById($order->customer_id);

        $addressRepopsitory = new AddressRepository(new Address);
        $prop->address = $addressRepopsitory->findAddressById($order->address_id);

        $OrderStatusRepopsitory = new OrderStatusRepository(new OrderStatus());
        $prop->OrderStatus = $OrderStatusRepopsitory->findCOrderStatusById($order->Order_status_id);

        $paymentMethodRepopsitory = new PaymentMethodRepository(new PaymentMethod);
        $prop->paymentMethod = $paymentMethodRepopsitory->findPaymentMethodById($order->payment_method_id);

        $prop->discounts = $order->discounts;
        $prop->total_products = $order->total_products;
        $prop->tax = $order->tax;
        $prop->total = $order->total;
        $prop->total_paid = $order->total_paid;
        $prop->invoice = $order->invoice;
        $prop->created_at = $order->created_at;
        $prop->updated_at = $order->updated_at;

        return $prop;
    }
}
