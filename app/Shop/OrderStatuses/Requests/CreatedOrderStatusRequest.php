<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 23:49
 */

namespace App\Shop\OrderStatuses\Requests;


use App\Shop\Base\BaseFormRequest;

class CreatedOrderStatusRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|unique:order_statuses'
        ];
    }
}
