<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 24/04/2020
 * Time: 19:21
 */

namespace App\Shop\Contries\Requests;


use App\Shop\Base\BaseFormRequest;

class UpdateCountryRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'iso' => 'required|max:2',
            'iso3' => 'max:3',
            'numcode' => 'numeric',
            'phonecode' => 'required'
        ];
    }
}
