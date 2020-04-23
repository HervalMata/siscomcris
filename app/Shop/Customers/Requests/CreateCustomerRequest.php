<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 23/04/2020
 * Time: 14:02
 */

namespace App\Http\Shop\Customers\Requests;


use App\Shop\Base\BaseFormRequest;

class CreateCustomerRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:customers',
            'password' => 'required|min:8',
        ];
    }
}
