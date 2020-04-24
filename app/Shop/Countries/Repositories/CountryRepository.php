<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 24/04/2020
 * Time: 13:49
 */

namespace App\Shop\Countries\Repositories;


use App\Shop\Base\BaseRepository;
use App\Shop\Countries\Country;
use App\Shop\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class CountryRepository extends BaseRepository implements CountryRepositoryInterface
{
    /**
     * CountryRepository constructor.
     * @param Country $country
     */
    public function __construct(Country $country)
    {
        $this->model = $country;
    }

    /**
     * @param string $order
     * @param string $sort
     * @return array
     */
    public function ListCountries(string $order = 'id', string $sort = 'desc'): array
    {
        $list = $this->model->where('id', '!=', 169)->where('status', 1)->orderBy($order, $sort)->get();
        $ph = $this->model->where('id', 169)->first();
        return collect($list)->prepend($ph)->all();
    }

    /**
     * @param array $params
     * @return Country
     */
    public function createCountry(array $params): Country
    {
        return $this->create($params);
    }

    /**
     * @param array $params
     * @return Country
     */
    public function updateCountry(array $params): Country
    {
        try {
            return $this->update($params);
        } catch (QueryException $e) {
            throw new CountryInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return Country
     */
    public function findCountryById(int $id): Country
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CountryNotFoundException($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function findProvinces()
    {
        return $this->model->provinces;
    }
}
