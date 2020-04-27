<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 23:14
 */

namespace App\Shop\Courriers\Requests;


use App\Shop\Base\BaseFormRequest;

class CreateCourrierRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:courriers'
        ];
    }
}
