<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 23/04/2020
 * Time: 14:26
 */

namespace App\Http\Shop\Employees\Requests;


use App\Shop\Base\BaseFormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('employees')->ignore($this->segment(3))],
        ];
    }
}
