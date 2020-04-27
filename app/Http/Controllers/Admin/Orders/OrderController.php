<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Shop\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * OrderController constructor.
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $list = $this->orderRepository->listOrders('created_at', 'desc')->toArray();
        $orders = $this->orderRepository->paginateArrayResults($list, 25);
        return view('admin.orders.list', ['orders', $orders]);
    }

    /**
     * @param int $id
     * @return Factory|View
     */
    public function show(int $id)
    {
        $order = $this->orderRepository->findOrderById($id);
        $items = $this->orderRepository->findProducts($order);
        return view('admin.orders.show', [
            'order' => $order, 'items' => $items
        ]);
    }
}
