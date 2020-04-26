<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 17:43
 */

namespace App\Shop\OrderStatus\Exceptions;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderStatusNotFoundException extends NotFoundHttpException
{

    /**
     * OrderStatusNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Status da ordem não encontrado.');
    }
}
