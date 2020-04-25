<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 25/04/2020
 * Time: 17:20
 */

namespace App\Shop\Categories\Exceptions;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryNotFoundException extends NotFoundHttpException
{

    /**
     * CategoryNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Categoria não encontrada.');
    }
}
