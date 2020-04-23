<?php


namespace App\Shop\Customers\Exceptions;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomerNotFoundException extends NotFoundHttpException
{

    /**
     * CustomerNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Cliente não encontrado.');
    }
}
