<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 16:41
 */

namespace App\Shop\Courriers\Exceptions;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CourrierNotFoundException extends NotFoundHttpException
{

    /**
     * CourrierNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Moeda não encontrada.');
    }
}
