<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 25/04/2020
 * Time: 13:46
 */

namespace Tests\Unit\Addresses;


use App\Shop\Addresses\Address;
use App\Shop\Addresses\Exceptions\AddressInvalidArgumentException;
use App\Shop\Addresses\Exceptions\AddressNotFoundException;
use App\Shop\Addresses\Repositories\AddressRepository;
use App\Shop\Customers\Repositories\AddressTransformable;
use App\Shop\Customers\Repositories\CustomerRepository;
use Tests\TestCase;

class AddressUnitTest extends TestCase
{
    use AddressTransformable;

    /** test */
    public function it_returns_the_customer_associated_with_the_address()
    {
        $address = new AddressRepository($this->address);
        $customer = $address->findCustomer();

        $this->assertEquals($this->customer->id, $customer-id);
    }

    /** @test */
    public function it_errors_when_the_address_it_not_found()
    {
        $this->expectException(AddressNotFoundException::class);

        $addressRepository = new AddressRepository(new Address);
        $addressRepository->findAddressById(99999);
    }

    /** @test */
    public function it_can_list_all_the_addresses()
    {
        $addressRepository = new AddressRepository($this->address);
        $addresses = $addressRepository->listAddresses();

        foreach ($addresses as $address) {
            $this->assertDatabaseHas('addresses', [ 'alias' => $address->alias ]);
        }
    }

    /** @test */
    public function it_errors_when_creating_an_address()
    {
        $this->expectException(AddressInvalidArgumentException::class);

        $addressRepository = new AddressRepository(new Address);
        $addressRepository->createAddress(['alias' => null], $this->customer);
    }

    /** @test */
    public function it_can_show_the_address()
    {
        $params = [
            'alias' => $this->faker->unique()->word,
            'address_1' => $this->faker->unique()->word,
            'address_2' => null,
            'zip' => 1101,
            'country_id' => $this->country->id,
            'province_id' => $this->province->id,
            'city_id' => $this->city->id,
            'status' => 1
        ];

        $address = new AddressRepository(new Address);
        $created = $address->createAddress($params, $this->customer);

        $list = $address->findAddressById($created->id);

        $this->assertEquals($params['alias'], $list->alias);
        $this->assertEquals($params['address_1'], $list->address_1);
        $this->assertEquals($params['address_2'], $list->address_2);
        $this->assertEquals($params['zip'], $list->zip);
        $this->assertEquals($params['status'], $list->status);
        $this->assertEquals($this->country->id, $list->country->id);
        $this->assertEquals($this->province->id, $list->province->id);
        $this->assertEquals($this->city->id, $list->city->id);
    }

    /** @test */
    public function it_can_list_all_the_addresses_of_the_customer()
    {
        $params = [
            'alias' => 'babababa',
            'address_1' => $this->faker->unique()->word,
            'address_2' => null,
            'zip' => 1101,
            'country_id' => $this->country->id,
            'province_id' => $this->province->id,
            'city_id' => $this->city->id,
            'status' => 1
        ];

        $address = new AddressRepository(new Address);
        $created = $address->createAddress($params, $this->customer);

        $customerRepository = new CustomerRepository($this->customer);
        $lists = $customerRepository->findAddresses($this->customer);

        foreach ($lists as $list) {
            $this->assertDatabaseHas('addresses', ['alias' => $list->alias]);
            $this->assertDatabaseHas('addresses', ['province_id' => $list->province_id]);
            $this->assertDatabaseHas('addresses', ['city_id' => $list->city_id]);
            $this->assertDatabaseHas('addresses', ['country_id' => $list->country_id]);
        }
    }

    /** @test */
    public function it_can_soft_delete_the_address()
    {
        $address = new AddressRepository($this->address);
        $address->deleteAddress();

        $this->assertDatabaseHas('addresses', ['alias' => $this->address->alias]);
    }

    /** @test */
    public function it_can_update_the_address()
    {
        $params = [
            'alias' => $this->faker->unique()->word,
            'address_1' => $this->faker->unique()->word,
            'address_2' => null,
            'zip' => 1101,
            'country_id' => $this->country->id,
            'province_id' => $this->province->id,
            'city_id' => $this->city->id,
            'status' => 1
        ];

        $address = new AddressRepository(new Address);
        $updated = $address->updateAddress($params);

        $this->assertEquals($params['alias'], $updated->alias);
        $this->assertEquals($params['address_1'], $updated->address_1);
        $this->assertEquals($params['address_2'], $updated->address_2);
        $this->assertEquals($params['zip'], $updated->zip);
        $this->assertEquals($params['status'], $updated->status);
        $this->assertEquals($params['country_id'], $updated->country->id);
        $this->assertEquals($params['province_id'], $updated->province->id);
        $this->assertEquals($params['city_id'], $updated->city->id);
    }

    /** @test */
    public function it_can_create_the_address()
    {
        $params = [
            'alias' => $this->faker->unique()->word,
            'address_1' => $this->faker->unique()->word,
            'address_2' => null,
            'zip' => 1101,
            'country_id' => $this->country->id,
            'province_id' => $this->province->id,
            'city_id' => $this->city->id,
            'status' => 1
        ];

        $address = new AddressRepository(new Address);
        $created = $address->transformAddress($address->createAddress($params, $this->customer));

        $this->assertInstanceOf(Address::class, $created);
        $this->assertEquals($params['alias'], $created->alias);
        $this->assertEquals($params['address_1'], $created->address_1);
        $this->assertEquals($params['address_2'], $created->address_2);
        $this->assertEquals($params['zip'], $created->zip);
        $this->assertEquals($params['status'], $created->status);
        $this->assertEquals($params['country_id'], $created->country->id);
        $this->assertEquals($params['province_id'], $created->province->id);
        $this->assertEquals($params['city_id'], $created->city->id);
        $this->assertEquals($this->customer->id, $created->customer_id);
    }
}
