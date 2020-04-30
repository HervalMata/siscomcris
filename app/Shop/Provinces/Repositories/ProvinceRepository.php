<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 24/04/2020
 * Time: 14:39
 */

namespace App\Shop\Provinces\Repositories;


use App\Shop\Base\BaseRepository;
use App\Shop\Provinces\Exceptions\ProvinceNotFoundException;
use App\Shop\Provinces\Province;
use App\Shop\Provinces\Repositories\Interfaces\ProvinceRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class ProvinceRepository extends BaseRepository implements ProvinceRepositoryInterface
{
    /**
     * ProvinceRepository constructor.
     * @param Province $province
     */
    public function __construct(Province $province)
    {
        $this->model = $province;
    }

    /**
     * @param string $order
     * @param string $sort
     * @return array
     */
    public function ListProvinces(string $order = 'id', string $sort = 'desc'): array
    {
        $list = $this->model->orderBy($order, $sort)->get();
        return collect($list)->all();
    }

    /**
     * @param array $params
     * @return Province
     */
    public function updateProvince(array $params): Province
    {
        try {
            return $this->update($params);
        } catch (QueryException $e) {
            throw new ProvinceNotFoundException($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return Province
     */
    public function findProvinceById(int $id): Province
    {
        try {
            return $this->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ProvinceNotFoundException($e->getMessage());
        }
    }

    /**
     * @param Province $province
     * @return mixed
     */
    public function listCities(Province $province)
    {
        return $province->cities;
    }
}
