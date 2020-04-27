<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 23:14
 */

namespace App\Shop\Courriers\Requests;


use App\Shop\Base\BaseFormRequest;
use Illuminate\Validation\Rule;

class UpdateCourrierRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('courriers')->ignore($this->segment('3'))]
        ];
    }
}
