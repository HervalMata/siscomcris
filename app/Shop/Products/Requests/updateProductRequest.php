<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 25/04/2020
 * Time: 20:24
 */

namespace App\Shop\Products\Requests;


use App\Shop\Base\BaseFormRequest;
use Illuminate\Validation\Rule;

class updateProductRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'sku' => 'required',
            'name' => ['required', Rule::unique('products')->ignore($this->request($this->segment(3)))],
            'quantity' => 'required|numeric',
            'price' => 'required'
        ];
    }
}
