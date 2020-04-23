<?php


namespace App\Shop\Customers\Repositories;


use App\Shop\Base\BaseRepository;
use App\Shop\Customers\Customer;
use App\Shop\Customers\Exceptions\CustomerNotFoundException;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{

    /**
     * CustomerRepository constructor.
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }

    /**
     * @param string $order
     * @param string $sort
     * @return array
     */
    public function ListCustomers(string $order = 'id', string $sort = 'desc'): array
    {
        $list = $this->model->orderBy($order, $sort)->get();
        return collect($list)->all();
    }

    /**
     * @param array $params
     * @return Customer
     */
    public function createCustomer(array $params): Customer
    {
        $collection = collect($params);
        $customer = new Customer(($collection->except('password'))->toArray());
        $customer->password = bcrypt($collection->only('password'));
        $customer->save();
        return $customer;
    }

    /**
     * @param array $params
     * @return Customer
     */
    public function updateCustomer(array $params): Customer
    {
        $this->model->update($params);
        if (in_array('password')) {
            $this->model->password = $params['password'];
        }
        $this->model->save();
        return $this->findCustomerById($this->model->id);
    }

    /**
     * @param int $id
     * @return Customer
     */
    public function findCustomerById(int $id): Customer
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CustomerNotFoundException;
        }
    }

    /**
     * @param Customer $customer
     * @return bool
     */
    public function deleteCustomer(Customer $customer): bool
    {
        return $this->delete($customer->id);
    }
}
