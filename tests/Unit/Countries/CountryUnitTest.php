<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 25/04/2020
 * Time: 12:52
 */

namespace Tests\Unit\Countries;


use App\Shop\Countries\Exceptions\CountryInvalidArgumentException;
use App\Shop\Countries\Exceptions\CountryNotFoundException;
use App\Shop\Countries\Repositories\CountryRepository;
use Tests\TestCase;

class CountryUnitTest extends TestCase
{
    /** @test */
    public function it_errors_when_updating_the_country()
    {
        $this->expectException(CountryInvalidArgumentException::class);

        $countryRepository = new CountryRepository($this->country);
        $countryRepository->updateCountry(['name' => null]);
    }

    /** @test */
    public function it_can_update_the_country()
    {
        $countryRepository = new CountryRepository($this->country);
        $countryRepository->updateCountry(['name' => 'bobobo']);

        $this->assertEquals('bobobo', $country->name);
    }

    /** @test */
    public function it_can_find_the_provinces_associated_with_the_country()
    {
        $countryRepository = new CountryRepository($this->country);
        $provinces = $countryRepository->findProvinces();

        foreach ($provinces as $province) {
            $this->assertEquals($this->province->id, $province->id);
        }

    }

    /** @test */
    public function it_errors_when_the_country_it_not_found()
    {
        $this->expectException(CountryNotFoundException::class);

        $countryRepository = new CountryRepository($this->country);
        $countryRepository->findCountryById(99999);
    }

    /** @test */
    public function it_can_find_the_country()
    {
        $countryRepository = new CountryRepository($this->country);
        $country = $countryRepository->findCountryById($this->country->id);


        $this->assertEquals($this->country->name, $country->name);
    }

    /** @test */
    public function it_can_find_all_countries()
    {
        $countryRepository = new CountryRepository($this->country);
        $list = $countryRepository->listCountries();


        $this->assertEquals($this->country->name, $list[1]->name);
    }
}
