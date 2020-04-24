<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 24/04/2020
 * Time: 13:59
 */

namespace App\Shop\Countries\Exceptions;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CountryNotFoundException extends NotFoundHttpException
{

    /**
     * CountryNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('País não encontrado.');
    }
}
