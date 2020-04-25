<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 25/04/2020
 * Time: 18:47
 */

namespace App\Shop\Products\Exceptions;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductNotFoundException extends NotFoundHttpException
{

    /**
     * ProductNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Produto não encontrado.');
    }
}
