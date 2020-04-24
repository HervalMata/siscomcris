<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 24/04/2020
 * Time: 13:45
 */

namespace App\Shop\Countries\Repositories\Interfaces;


use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Countries\Country;

interface CountryRepositoryInterface extends BaseRepositoryInterface
{
    public function ListCountries(string $order = 'id', string $sort = 'desc') : array;

    public function createCountry(array $params) : Country;

    public function updateCountry(array $params) : Country;

    public function findCountryById(int $id) : Country;

    public function findProvinces();
}
