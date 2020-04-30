<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 16:29
 */

namespace App\Shop\Courriers\Repositories;


use App\Shop\Base\BaseRepository;
use App\Shop\Courriers\Courrier;
use App\Shop\Courriers\Exceptions\CourrierInvalidArgumentException;
use App\Shop\Courriers\Exceptions\CourrierNotFoundException;
use App\Shop\Courriers\Repositories\Interfaces\CourrierRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class CourrierRepository extends BaseRepository implements CourrierRepositoryInterface
{
    /**
     * CourrierRepository constructor.
     * @param Courrier $courrier
     */
    public function __construct(Courrier $courrier)
    {
        $this->model = $courrier;
    }

    /**
     * @param array $params
     * @return Courrier
     */
    public function createCourrier(array $params): Courrier
    {
        try {
            return $this->create($params);
        } catch (QueryException $e) {
            throw new CourrierInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param array $params
     * @return Courrier
     */
    public function updateCourrier(array $params): Courrier
    {
        try {
            $this->update($params, $this->model->id);
            return $this->find($this->model->id);
        } catch (QueryException $e) {
            throw new CourrierInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return Courrier
     */
    public function findCourrierById(int $id): Courrier
    {
        try {
            return $this->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CourrierNotFoundException($e->getMessage());
        }
    }

    /**
     * @param string $order
     * @param string $sort
     * @return array
     */
    public function ListCourriers(string $order = 'id', string $sort = 'desc'): array
    {
        return $this->model->orderBy($order, $sort)->get();
    }
}
