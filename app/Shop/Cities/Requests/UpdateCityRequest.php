<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 24/04/2020
 * Time: 22:34
 */

namespace App\Shop\Cities\Requests;


use App\Shop\Base\BaseFormRequest;
use Illuminate\Validation\Rule;

class UpdateCityRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('cities')->ignore(request()->segment(7))]
        ];
    }
}
