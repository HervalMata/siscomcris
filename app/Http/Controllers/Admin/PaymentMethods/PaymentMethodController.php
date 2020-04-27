<?php

namespace App\Http\Controllers\Admin\PaymentMethods;

use App\Http\Controllers\Controller;
use App\Shop\PaymentMethods\Repositories\Interfaces\PaymentMethodRepositoryInterface;
use App\Shop\PaymentMethods\Repositories\PaymentMethodRepository;
use App\Shop\PaymentMethods\Requests\CreatePaymentMethodRequest;
use App\Shop\PaymentMethods\Requests\UpdatePaymentMethodsRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentMethodController extends Controller
{
    /**
     * @var PaymentMethodRepositoryInterface
     */
    private $methodRepository;

    /**
     * PaymentMethodController constructor.
     * @param PaymentMethodRepositoryInterface $methodRepository
     */
    public function __construct(PaymentMethodRepositoryInterface $methodRepository)
    {
        $this->methodRepository = $methodRepository;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('admin.payment-methods.list', [
            'paymentMethods' => $this->methodRepository->listPaymentMethods('name', 'asc')
        ]);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.payment-methods.create');
    }

    /**
     * @param CreatePaymentMethodRequest $request
     * @return RedirectResponse
     */
    public function store(CreatePaymentMethodRequest $request)
    {
        $this->methodRepository->createPaymentMethodById($request->all());
        $request->session()->flash('message', 'Método de pagamento criado com sucesso.');
        return redirect()->route('payment-methods.index');

    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function edit($id)
    {
        return view('admin.payment-methods.edit', ['paymentMethod' => $this->methodRepository->findPaymentMethodById($id)]);
    }

    /**
     * @param UpdatePaymentMethodsRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(UpdatePaymentMethodsRequest $request, $id)
    {
        $paymentMethod = $this->methodRepository->findPaymentMethodById($id);
        $update = new PaymentMethodRepository($paymentMethod);
        $update->updatePaymentMethod($request->all());
        $request->session()->flash('message', 'Método de pagamento atualizado com sucesso.');
        return redirect()->route('payment-methods.edit', $id);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        try {
            $this->methodRepository->delete($id);
        } catch (QueryException $e) {
            request()->session()->flash('message', 'Desculpe, nós não podemos remover este método de pagamento. Existe ordem usando ele.');
            return redirect()->route('payment-methods.index');
        }
        request()->session()->flash('message', 'Método de pagamento removido com sucesso.');
        return redirect()->route('payment-methods.index');
    }
}
