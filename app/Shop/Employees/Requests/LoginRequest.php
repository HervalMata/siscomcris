<?php

use App\Shop\Base\BaseFormRequest;

/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 23/04/2020
 * Time: 16:08
 */

class LoginRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }
}
