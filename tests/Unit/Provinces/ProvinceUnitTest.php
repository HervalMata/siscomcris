<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 25/04/2020
 * Time: 13:11
 */

namespace Tests\Unit\Provinces;


use App\Shop\Provinces\Exceptions\ProvinceNotFoundException;
use App\Shop\Provinces\Province;
use App\Shop\Provinces\Repositories\ProvinceRepository;
use Tests\TestCase;

class ProvinceUnitTest extends TestCase
{
    /** @test */
    public function it_errors_when_the_country_it_not_found()
    {
        $this->expectException(ProvinceNotFoundException::class);
        $this->expectExceptionMessage('Estado não encontrado.');

        $provinceRepository = new ProvinceRepository(new Province);
        $provinceRepository->findProvinceById(99999);
    }

    /** @test */
    public function it_can_show_the_province()
    {
        $provinceRepository = new ProvinceRepository(new Province);
        $province = Province::find(1);
        $found = $provinceRepository->findProvinceById($province->id);

        $this->assertEquals($province->name, $found->name);
    }

    /** @test */
    public function it_can_list_all_the_cities_within_the_province()
    {
        $provinceRepository = new ProvinceRepository(new Province);
        $cities = $provinceRepository->listCities(Province::find(1));

        foreach ($cities as $city) {
            $this->assertDatabaseHas('cities', $city->toArray());
        }
    }

    /** @test */
    public function it_can_list_all_the_provinces()
    {
        $provinceRepository = new ProvinceRepository(new Province);
        $provinces = $provinceRepository->listProvinces();

        foreach ($provinces as $province) {
            $this->assertDatabaseHas('provinces', $province->toArray());
        }
    }
}
