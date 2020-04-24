<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 24/04/2020
 * Time: 15:52
 */

namespace App\Shop\Cities\Repositories\Interfaces;


use App\Shop\Base\Interfaces\BaseRepositoryInterface;

interface CityRepositoryInterface extends BaseRepositoryInterface
{
    public function findCityById(int $id);

    public function updateCity(array $params);
}
