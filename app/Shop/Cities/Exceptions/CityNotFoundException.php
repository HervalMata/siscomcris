<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 24/04/2020
 * Time: 15:56
 */

namespace App\Shop\Cities\Exceptions;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CityNotFoundException extends NotFoundHttpException
{

    /**
     * CityNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Cidade não encontrada.');
    }
}
