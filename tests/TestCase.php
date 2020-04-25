<?php

namespace Tests;

use App\Shop\Addresses\Address;
use App\Shop\Addresses\Repositories\AddressRepository;
use App\Shop\Cities\City;
use App\Shop\Cities\Repositories\CityRepository;
use App\Shop\Countries\Country;
use App\Shop\Countries\Repositories\CountryRepository;
use App\Shop\Customers\Customer;
use App\Shop\Employees\Employee;
use App\Shop\Provinces\Province;
use App\Shop\Provinces\Repositories\ProvinceRepository;
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

        $data = [
            'name' => $this->faker->name,
            'iso' => 'PH',
            'iso3' => 'PHL',
            'numcode' => '63',
            'phonecode' => '123',
            'status' => 1
        ];

        $countryRepository = new CountryRepository(new Country);
        $country = $countryRepository->createCountry($data);
        $this->country = $country;

        $provinceRepository = new ProvinceRepository(new Province);
        $province = $provinceRepository->create([
            'name' => $this->faker->name,
            'country_id' => $country->id
        ]);

        $this->province = $province;

        $cityRepository = new CityRepository(new City);
        $city = $cityRepository->create([
            'name' => $this->faker->name,
            'province_id' => $province->id
        ]);

        $this->city = $city;

        $addressData = [
            'alias' => 'Casa',
            'address_1' => $this->faker->sentence,
            'address_2' => $this->faker->sentence,
            'zip' => 1101,
            'city_id' => $city->id,
            'province_id' => $province->id,
            'country_id' => $country->id,
            'customer_id' => $this->customer->id,
            'status' => 1
        ];

        $addressRepository = new AddressRepository(new Address);
        $this->address = $addressRepository->createAddress($addressData, $this->customer);
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
