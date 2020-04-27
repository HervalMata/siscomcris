<?php

use App\Shop\Base\BaseFormRequest;

/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 22:34
 */

class SendInquiryRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email'
        ];
    }
}
