<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 27/04/2020
 * Time: 12:31
 */

namespace App\Shop\Cart\Requests;


use App\Shop\Base\BaseFormRequest;

class CartCheckoutRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'courrier' => 'required',
            'address' => 'required',
            'payment' => 'required',
        ];
    }
}
