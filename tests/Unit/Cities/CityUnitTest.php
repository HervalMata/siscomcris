<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 25/04/2020
 * Time: 13:24
 */

namespace Tests\Unit\Cities;


use App\Shop\Cities\City;
use App\Shop\Cities\Exceptions\CityNotFoundException;
use App\Shop\Cities\Repositories\CityRepository;
use Monolog\Test\TestCase;

class CityUnitTest extends TestCase
{
    /** @test */
    public function it_can_update_the_city()
    {
        $cityRepository = new CityRepository($this->city);
        $cy = $cityRepository->updateCity(['name' => 'Manilha']);

        $this->assertEquals($cy->name, $this->city->name);
    }

    /** @test */
    public function it_errors_when_city_is_not_found()
    {
        $this->expectException(CityNotFoundException::class);

        $cityRepository = new CityRepository(new City);
        $cityRepository->findCityById(9999);
    }

    /** @test */
    public function it_can_find_the_country()
    {
        $cityRepository = new CityRepository(new City);
        $city = $cityRepository->findCityById($this->city->id);


        $this->assertEquals($this->city->name, $city->name);
    }
}
