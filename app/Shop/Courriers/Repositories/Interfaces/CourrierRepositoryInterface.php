<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 16:25
 */

namespace App\Shop\Courriers\Repositories\Interfaces;


use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Courriers\Courrier;

interface CourrierRepositoryInterface extends BaseRepositoryInterface
{
    public function ListCourriers(string $order = 'id', string $sort = 'desc') : array;

    public function createCourrier(array $params) : Courrier;

    public function updateCourrier(array $params) : Courrier;

    public function findCourrierById(int $id) : Courrier;
}
