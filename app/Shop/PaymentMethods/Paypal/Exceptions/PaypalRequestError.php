<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 20:05
 */

namespace App\Shop\PaymentMethods\Paypal\Exceptions;


use Doctrine\Instantiator\Exception\InvalidArgumentException;

class PaypalRequestError extends InvalidArgumentException
{
}
