<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 24/04/2020
 * Time: 15:54
 */

namespace App\Shop\Cities\Repositories;


use App\Shop\Base\BaseRepository;
use App\Shop\Cities\City;
use App\Shop\Cities\Exceptions\CityNotFoundException;
use App\Shop\Cities\Repositories\Interfaces\CityRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CityRepository extends BaseRepository implements CityRepositoryInterface
{

    /**
     * CityRepository constructor.
     * @param City $city
     */
    public function __construct(City $city)
    {
        $this->model = $city;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findCityById(int $id)
    {
        try {
            return $this->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CityNotFoundException($e->getMessage());
        }
    }

    /**
     * @param array $params
     * @return City
     */
    public function updateCity(array $params) : City
    {
        $this->model->update($params);
        $this->model->save();
        return $this->findCityById($this->model->id);

    }
}
