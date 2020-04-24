<?php


namespace App\Shop\Customers\Repositories\Interfaces;


use App\Shop\Addresses\Address;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Customers\Customer;
use Illuminate\Support\Collection;

interface CustomerRepositoryInterface extends BaseRepositoryInterface
{
        public function ListCustomers(string $order = 'id', string $sort = 'desc') : array;

        public function createCustomer(array $params) : Customer;

        public function updateCustomer(array $params) : Customer;

        public function findCustomerById(int $id) : Customer;

        public function deleteCustomer(Customer $customer) : bool ;

        public function attachAddress(Address $address) : Address;

        public function findAddresses(Customer $customer) : Collection;
}
