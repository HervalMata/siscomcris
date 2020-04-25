<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 25/04/2020
 * Time: 19:51
 */

namespace App\Shop\Categories\Requests;


use App\Shop\Base\BaseFormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('categories')->ignore($this->request()->segment(3))]
        ];
    }
}
