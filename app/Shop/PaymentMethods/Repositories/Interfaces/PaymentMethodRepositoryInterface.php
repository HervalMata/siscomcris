<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 19:01
 */

namespace App\Shop\PaymentMethods\Repositories\Interfaces;


use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\PaymentMethods\PaymentMethod;
use Illuminate\Support\Collection;

interface PaymentMethodRepositoryInterface extends BaseRepositoryInterface
{
    public function ListPaymentMethods(string $order = 'id', string $sort = 'desc') : Collection;

    public function createPaymentMethod(array $params) : PaymentMethod;

    public function updatePaymentMethod(array $params) : PaymentMethod;

    public function findPaymentMethodById(int $id) : PaymentMethod;

    public function getClientId() : string;

    public function getClientSecret() : string;
}
