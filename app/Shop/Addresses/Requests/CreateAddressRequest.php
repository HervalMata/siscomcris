<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 24/04/2020
 * Time: 23:01
 */

namespace App\Shop\Addresses\Requests;


use App\Shop\Base\BaseFormRequest;

class CreateAddressRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'alias' => 'required',
            'address_1' => 'required'
        ];
    }
}
