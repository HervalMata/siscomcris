<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 19:17
 */

namespace App\Shop\PaymentMethods\Exceptions;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaymentMethodNotFoundException extends NotFoundHttpException
{

    /**
     * PaymentMethodNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Método de pagamento não encontrado.');
    }
}
