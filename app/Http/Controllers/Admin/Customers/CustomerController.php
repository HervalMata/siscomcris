<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 23/04/2020
 * Time: 13:49
 */

namespace App\Http\Controllers\Admin\Customers;


use App\Http\Controllers\Controller;
use App\Http\Shop\Customers\Requests\CreateCustomerRequest;
use App\Http\Shop\Customers\Requests\UpdateCustomerRequest;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * CustomerController constructor.
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $list = $this->customerRepository->ListCustomers('created_at', 'desc');

        return view('admin.customers.list', ['customers' => $this->customerRepository->paginateArrayResults($list)]);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * @param CreateCustomerRequest $request
     * @return RedirectResponse
     */
    public function store(CreateCustomerRequest $request)
    {
        $this->customerRepository->createCustomer($request->all());

        return redirect()->route('customers.index');
    }

    /**
     * @param int $id
     * @return Factory|View
     */
    public function show(int $id)
    {
        $customer = $this->customerRepository->findCustomerById($id);

        return view('admin.customers.show', [
            'customers' => $customer,
        ]);
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function edit($id)
    {
        return view('admin.customers.edit', ['customer' => $this->customerRepository->findCustomerById($id)]);
    }

    /**
     * @param UpdateCustomerRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        $customer = $this->customerRepository->findCustomerById($id);

        $update = new CustomerRepository($customer);
        $update->updateCustomer($request->all());

        $request->session()->flash('message', 'Cliente atualizado com sucesso.');
        return redirect()->route('customers.edit', $id);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $this->customerRepository->delete($id);

        request()->session()->flash('message', 'Cliente removido com sucesso.');
        return redirect()->route('customers.index');
    }
}
