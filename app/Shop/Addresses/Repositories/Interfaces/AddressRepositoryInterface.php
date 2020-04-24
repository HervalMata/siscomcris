<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 24/04/2020
 * Time: 16:04
 */

namespace App\Shop\Addresses\Repositories\Interfaces;


use App\Shop\Addresses\Address;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Customers\Customer;

interface AddressRepositoryInterface extends BaseRepositoryInterface
{
    public function ListAddresses(string $order = 'id', string $sort = 'desc') : array;

    public function createAddress(array $params, Customer $customer) : Address;

    public function updateAddress(array $update) : Address;

    public function findAddressById(int $id) : Address;

    public function deleteAddress();

    public function attachToCustomer(Address $address, Customer $customer);

    public function findCustomer() : Customer;

    public function findCustomerAddresses(Customer $customer);
}
