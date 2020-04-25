<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 25/04/2020
 * Time: 20:07
 */

namespace App\Shop\Products\Requests;


use App\Shop\Base\BaseFormRequest;

class CreateProductRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'sku' => 'required',
            'name' => 'required|unique:products',
            'quantity' => 'required|numeric',
            'price' => 'required'
        ];
    }
}
