<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 24/04/2020
 * Time: 16:13
 */

namespace App\Shop\Addresses\Repositories;


use App\Shop\Addresses\Address;
use App\Shop\Addresses\Exceptions\AddressInvalidArgumentException;
use App\Shop\Addresses\Exceptions\AddressNotFoundException;
use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Base\BaseRepository;
use App\Shop\Customers\Customer;
use App\Shop\Customers\Repositories\AddressTransformable;
use App\Shop\Customers\Transformations\CustomerTransformable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class AddressRepository extends BaseRepository implements AddressRepositoryInterface
{

    use AddressTransformable;
    use CustomerTransformable;

    /**
     * AddressRepository constructor.
     * @param Address $address
     */
    public function __construct(Address $address)
    {
        $this->model = $address;
    }

    /**
     * @param string $order
     * @param string $sort
     * @return array
     */
    public function ListAddresses(string $order = 'id', string $sort = 'desc'): array
    {
        $list = $this->model->orderBy($order, $sort)->get();
        return collect($list)->map(function (Address $address) {
            return $this->transformAddress($address);
        })->all();

    }

    /**
     * @param array $params
     * @param Customer $customer
     * @return Address
     */
    public function createAddress(array $params, Customer $customer): Address
    {
        try {
            $collection = collect($params)->except('_token');
            $address = new Address($collection->all());
            $this->attachToCustomer($address, $customer);
            $address->save();
            return $this->find($address->id);
        } catch (QueryException $e) {
            throw new AddressInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param array $update
     * @return Address
     */
    public function updateAddress(array $update): Address
    {
        $this->update($update, $this->model->id);
        return $this->findAddressById($this->model->id);
    }

    /**
     * @param int $id
     * @return Address
     */
    public function findAddressById(int $id): Address
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new AddressNotFoundException($e->getMessage());
        }
    }

    /**
     * @return bool|null
     * @throws \Exception
     */
    public function deleteAddress()
    {
        return $this->model->delete();
    }

    /**
     * @param Address $address
     * @param Customer $customer
     */
    public function attachToCustomer(Address $address, Customer $customer)
    {
        $customer->address()->save($address);
    }

    /**
     * @return Customer
     */
    public function findCustomer(): Customer
    {
        return $this->transformCustomer($this->model->customer);
    }

    /**
     * @param Customer $customer
     * @return array
     */
    public function findCustomerAddresses(Customer $customer)
    {
        return collect($customer->address)->map(function (Address $address) {
            return $this->transformAddress($address);
        })->all();
    }
}
