<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 24/04/2020
 * Time: 14:34
 */

namespace App\Shop\Provinces\Repositories\Interfaces;


use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Provinces\Province;

interface ProvinceRepositoryInterface extends BaseRepositoryInterface
{
    public function ListProvinces(string $order = 'id', string $sort = 'desc') : array;

    public function updateProvince(array $params) : Province;

    public function findProvinceById(int $id) : Province;

    public function listCities(Province $province);
}
