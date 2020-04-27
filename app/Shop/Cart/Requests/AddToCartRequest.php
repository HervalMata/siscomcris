<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 27/04/2020
 * Time: 11:40
 */

namespace App\Shop\Cart\Requests;


use App\Shop\Base\BaseFormRequest;

class AddToCartRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'quantity' => 'required'
        ];
    }
}
