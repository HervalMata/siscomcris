<?php

namespace Tests;

use App\Shop\Customers\Customer;
use App\Shop\Employees\Employee;
use Faker\Factory;
use Faker\Factory as faker;
use Faker\Generator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * @var Generator
     */
    protected $faker;
    /**
     * @var Collection|Model
     */
    protected $employee;
    /**
     * @var Collection|Model
     */
    protected $customer;

    /**
     *
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
        $this->employee = factory(Employee::class)->create();
        $this->customer = factory(Customer::class)->create();

    }

    /**
     * @throws \Throwable
     */
    public function tearDown(): void
    {
        $this->artisan('migrate:reset');
        parent::tearDown();
    }
}
