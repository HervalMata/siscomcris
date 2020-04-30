<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 19:06
 */

namespace App\Shop\PaymentMethods\Repositories;


use App\Shop\Base\BaseRepository;
use App\Shop\PaymentMethods\Exceptions\PaymentMethodInvalidArgumentException;
use App\Shop\PaymentMethods\Exceptions\PaymentMethodNotFoundException;
use App\Shop\PaymentMethods\PaymentMethod;
use App\Shop\PaymentMethods\Repositories\Interfaces\PaymentMethodRepositoryInterface;
use ErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PaymentMethodRepository extends BaseRepository implements PaymentMethodRepositoryInterface
{
    /**
     * PaymentMethodRepository constructor.
     * @param PaymentMethod $paymentMethod
     */
    public function __construct(PaymentMethod $paymentMethod)
    {
        $this->model = $paymentMethod;
    }

    /**
     * @param array $data
     * @return PaymentMethod
     */
    public function createPaymentMethod(array $data): PaymentMethod
    {
        $collection = collect($data)->merge(['slug' => Str::slug($data['name'])]);

        try {
            return $this->create($collection->all());
        } catch (QueryException $e) {
            throw new PaymentMethodInvalidArgumentException($e->getMessage());
        } catch (ErrorException $e) {
            throw new PaymentMethodInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param array $update
     * @return PaymentMethod
     */
    public function updatePaymentMethod(array $update): PaymentMethod
    {
        $collection = collect($update)->merge(['slug' => Str::slug($update['name'])]);

        try {
            $this->update($collection->all(), $this->model->id);
            return $this->find($this->model->id);
        } catch (QueryException $e) {
            throw new PaymentMethodInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return PaymentMethod
     */
    public function findPaymentMethodById(int $id): PaymentMethod
    {
        try {
            return $this->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new PaymentMethodNotFoundException($e->getMessage());
        }
    }

    /**
     * @param string $order
     * @param string $sort
     * @return Collection
     */
    public function ListPaymentMethods(string $order = 'id', string $sort = 'desc'): Collection
    {
        return $this->model->orderBy($order, $sort)->get();
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->model->getClientId();
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->model->getClientSecret();
    }
}
