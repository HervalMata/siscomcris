<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 25/04/2020
 * Time: 19:42
 */

namespace App\Shop\Categories\Requests;


use App\Shop\Base\BaseFormRequest;

class CreateCategoryRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:categories'
        ];
    }
}
