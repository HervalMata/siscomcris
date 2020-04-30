<?php


namespace App\Shop\Employees\Repositories;


use App\Shop\Base\BaseRepository;
use App\Shop\Employees\Employee;
use App\Shop\Employees\Exceptions\EmployeeNotFoundException;
use App\Shop\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{

    /**
     * CustomerRepository constructor.
     * @param Employee $employee
     */
    public function __construct(Employee $employee)
    {
        $this->model = $employee;
    }

    /**
     * @param string $order
     * @param string $sort
     * @return array
     */
    public function ListEmployees(string $order = 'id', string $sort = 'desc'): array
    {
        $list = $this->model->orderBy($order, $sort)->get();
        return collect($list)->all();
    }

    /**
     * @param array $params
     * @return Employee
     */
    public function createEmployee(array $params): Employee
    {
        $collection = collect($params);
        $employee = new Employee(($collection->except('password'))->toArray());
        $employee->password = bcrypt($collection->only('password'));
        $employee->save();
        return $employee;
    }

    /**
     * @param array $params
     * @return Employee
     */
    public function updateEmployee(array $params): Employee
    {
        $this->model->update($params);
        if (in_array('password')) {
            $this->model->password = $params['password'];
        }
        $this->model->save();
        return $this->findEmployeeById($this->model->id);
    }

    /**
     * @param int $id
     * @return Employee
     */
    public function findEmployeeById(int $id): Employee
    {
        try {
            return $this->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new EmployeeNotFoundException;
        }
    }
}
