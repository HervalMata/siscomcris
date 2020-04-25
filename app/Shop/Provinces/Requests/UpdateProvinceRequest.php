<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 24/04/2020
 * Time: 19:37
 */

namespace App\Shop\Provinces\Requests;


use App\Shop\Base\BaseFormRequest;

class UpdateProvinceRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }
}
