<?php


namespace App\Shop\Customers\Repositories\Interfaces;


use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Customers\Customer;

interface CustomerRepositoryInterface extends BaseRepositoryInterface
{
        public function ListCustomers(string $order = 'id', string $sort = 'desc') : array;

        public function createCustomer(array $params) : Customer;

        public function updateCustomer(array $params) : Customer;

        public function findCustomerById(int $id) : Customer;

        public function deleteCustomer(Customer $customer) : bool ;
}
