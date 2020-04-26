<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 18:41
 */

namespace App\Shop\Orders\Exceptions;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderNotFoundException extends NotFoundHttpException
{

    /**
     * OrderNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Ordem não encontrada.');
    }
}
