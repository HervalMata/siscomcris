<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 23/04/2020
 * Time: 13:49
 */

namespace App\Http\Controllers\Admin\Employees;


use App\Http\Controllers\Controller;
use App\Http\Shop\Employees\Requests\CreateEmployeeRequest;
use App\Http\Shop\Employees\Requests\UpdateEmployeeRequest;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Shop\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    /**
     * @var EmployeeRepositoryInterface     */
    private $employeeRepository;

    /**
     * CustomerController constructor.
     * @param EmployeeRepositoryInterface $employeeRepository
     */
    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $list = $this->employeeRepository->ListEmployees('created_at', 'desc');

        return view('admin.employees.list', ['employees' => $this->employeeRepository->paginateArrayResults($list)]);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.employees.create');
    }

    /**
     * @param CreateEmployeeRequest $request
     * @return RedirectResponse
     */
    public function store(CreateEmployeeRequest $request)
    {
        $this->employeeRepository->createEmployee($request->all());

        return redirect()->route('employees.index');
    }

    /**
     * @param int $id
     * @return Factory|View
     */
    public function show(int $id)
    {
        $employee = $this->employeeRepository->findEmployeeById($id);

        return view('admin.employees.show', [
            'employees' => $employee,
        ]);
    }

    /**
     * @param $id
     * @return Factory|View
     */
    public function edit($id)
    {
        return view('admin.employees.edit', ['employee' => $this->employeeRepository->findEmployeeById($id)]);
    }

    /**
     * @param UpdateEmployeeRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(UpdateEmployeeRequest $request, $id)
    {
        $employee = $this->employeeRepository->findEmployeeById($id);

        $update = new EmployeeRepository($employee);
        $update->updateEmployee($request->all());

        $request->session()->flash('message', 'Funcionário atualizado com sucesso.');
        return redirect()->route('employees.edit', $id);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $this->employeeRepository->delete($id);

        request()->session()->flash('message', 'Funcionário removido com sucesso.');
        return redirect()->route('employees.index');
    }
}
