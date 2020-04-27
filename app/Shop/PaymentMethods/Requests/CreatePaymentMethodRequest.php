<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 27/04/2020
 * Time: 11:05
 */

namespace App\Shop\PaymentMethods\Requests;


use App\Shop\Base\BaseFormRequest;

class CreatePaymentMethodRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:payment_methods'
        ];
    }
}
