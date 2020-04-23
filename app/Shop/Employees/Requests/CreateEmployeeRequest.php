<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 23/04/2020
 * Time: 14:02
 */

namespace App\Http\Shop\Employees\Requests;


use App\Shop\Base\BaseFormRequest;

class CreateEmployeeRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:employees',
            'password' => 'required|min:8',
        ];
    }
}
