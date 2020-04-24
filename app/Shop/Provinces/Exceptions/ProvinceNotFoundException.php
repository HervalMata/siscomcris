<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 24/04/2020
 * Time: 14:49
 */

namespace App\Shop\Provinces\Exceptions;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProvinceNotFoundException extends NotFoundHttpException
{

    /**
     * ProvinceNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Estado não encontrado.');
    }
}
