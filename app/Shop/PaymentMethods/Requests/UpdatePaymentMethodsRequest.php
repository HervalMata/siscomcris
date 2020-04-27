<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 27/04/2020
 * Time: 11:12
 */

namespace App\Shop\PaymentMethods\Requests;


use App\Shop\Base\BaseFormRequest;
use Illuminate\Validation\Rule;

class UpdatePaymentMethodsRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('payment_methods')->ignore($this->segment(3))]
        ];
    }
}
