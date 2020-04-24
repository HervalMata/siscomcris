<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 24/04/2020
 * Time: 16:26
 */

namespace App\Shop\Addresses\Exceptions;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AddressNotFoundException extends NotFoundHttpException
{

    /**
     * AddressNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Endereço do cliente não encontrado.');
    }
}
