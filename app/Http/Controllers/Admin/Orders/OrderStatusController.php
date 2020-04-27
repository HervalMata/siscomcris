<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Shop\OrderStatus\Repositories\OrderStatusRepository;
use App\Shop\OrderStatuses\Repositories\Interfaces\OrderStatusRepositoryInterface;
use App\Shop\OrderStatuses\Requests\CreatedOrderStatusRequest;
use App\Shop\OrderStatuses\Requests\UpdateOrderStatusRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderStatusController extends Controller
{
    /**
     * @var OrderStatusRepositoryInterface
     */
    private $orderStatusRepository;

    /**
     * OrderStatusController constructor.
     * @param OrderStatusRepositoryInterface $orderStatusRepository
     */
    public function __construct(OrderStatusRepositoryInterface $orderStatusRepository)
    {
        $this->orderStatusRepository = $orderStatusRepository;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('admin.order-statuses.list', ['orderStatuses', $this->orderStatusRepository->listOrderStatuses()]);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.order-statuses.create');
    }

    /**
     * @param CreatedOrderStatusRequest $request
     * @return RedirectResponse
     */
    public function store(CreatedOrderStatusRequest $request)
    {
        $this->orderStatusRepository->createOrderStatus($request->all());
        $request->session()->flash('message', 'Status da ordem criado com sucesso.');
        return redirect()->route('order-statuses.index');
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function edit($id)
    {
        return view('admin.order-statuses.edit', ['orderStatus' => $this->orderStatusRepository->findOrderStatusById($id)]);
    }

    /**
     * @param UpdateOrderStatusRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(UpdateOrderStatusRequest $request, $id)
    {
        $orderStatus = $this->orderStatusRepository->findOrderStatusById($id);
        $update = new OrderStatusRepository($orderStatus);
        $update->updateOrderStatus($request->all());
        $request->session()->flash('message', 'Status da ordem atualizada com sucesso.');
        return redirect()->route('order-statuses.edit', $id);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        $os = $this->orderStatusRepository->findOrderStatusById($id);
        try {
            $this->orderStatusRepository->delete($os);
        } catch (QueryException $e) {
            request()->session()->flash('message', 'Desculpe, nós não podemos remover este status. Existe ordem usando ela.');
            return redirect()->route('order-statuses.index');
        }
        request()->session()->flash('message', 'Status da ordem removida com sucesso.');
        return redirect()->route('order-statuses.index');
    }
}
