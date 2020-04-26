<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 16:08
 */

namespace App\Shop\Cart\Exceptions;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductInCartNotFoundException extends NotFoundHttpException
{

    /**
     * ProductInCartNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Produto do carrinho de compras não encontrado.');
    }
}
