<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 23/04/2020
 * Time: 16:40
 */

namespace Tests\Unit\Customers;


use App\Shop\Customers\Customer;
use App\Shop\Customers\Exceptions\CustomerNotFoundException;
use App\Shop\Customers\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;


class CustomerUniTest extends TestCase
{
    /** @test */
    public function it_can_update_customers_password()
    {
        $customer = new CustomerRepository($this->customer);
        $customer->updateCustomer([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'status' => 1,
            'password' => 'unknown'
        ]);

        $this->assertTrue(Hash::check('ubknown', bcrypt($this->customer->password)));
    }

    /** @test */
    public function it_can_soft_delete_a_customer()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'secret'
        ];

        $customer = new CustomerRepository(new Customer);
        $created = $customer->createCustomer($data);
        $customer->deleteCustomer($created);
        $collection = collect($data)->except('password');

        $this->assertDatabaseHas('customers', $collection->all());
    }

    /** @test */
    public function it_fails_when_the_customer_is_not_found()
    {
        $this->expectException(CustomerNotFoundException::class);
        $this->expectExceptionMessage('Cliente não encontrado.');
        $customer = new CustomerRepository(new Customer);
        $customer->findCustomerById(9999);
    }

    /** @test */
    public function it_can_find_a_customer()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'secret'
        ];

        $customer = new CustomerRepository(new Customer);
        $created = $customer->createCustomer($data);
        $found = $customer->findCustomerById($created->id);

        $this->assertInstanceOf(Customer::class, $found);
        $this->assertEquals($data['name'], $found->name);
        $this->assertEquals($data['email'], $found->email);
    }

    /** @test */
    public function it_can_update_the_customer()
    {
        $customer = new CustomerRepository($this->customer);

        $update = [ 'name' => $this->faker->name ];
        $updated = $customer->updateCustomer($update);

        $this->assertInstanceOf(Customer::class, $updated);
        $this->assertEquals($update['name'], $updated->name);
        $this->assertDatabaseHas('customers', $update);
    }

    /** @test */
    public function it_can_create_a_customer()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'secret'
        ];

        $customer = new CustomerRepository(new Customer);
        $created = $customer->createCustomer($data);

        $this->assertInstanceOf(Customer::class, $created);
        $this->assertEquals($data['name'], $created->name);
        $this->assertEquals($data['email'], $created->email);

        $collection = collect($data)->except('password');

        $this->assertDatabaseHas('customers', $collection->all());
    }
}
