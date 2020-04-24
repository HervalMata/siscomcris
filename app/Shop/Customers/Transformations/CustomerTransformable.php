<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 24/04/2020
 * Time: 16:33
 */

namespace App\Shop\Customers\Transformations;


use App\Shop\Customers\Customer;

trait CustomerTransformable
{
    /**
     * @param Customer $customer
     * @return Customer
     */
    protected function transformCustomer(Customer $customer)
    {
        $prop = new Customer;
        $prop->id = (int) $customer->id;
        $prop->name = $customer->name;
        $prop->email = $customer->email;
        $prop->status = (int) $customer->status;

        return $prop;
    }
}
