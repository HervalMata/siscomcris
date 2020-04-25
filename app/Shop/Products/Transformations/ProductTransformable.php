<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 25/04/2020
 * Time: 18:01
 */

namespace App\Shop\Products\Exceptions;


use App\Shop\Products\Product;

trait ProductTransformable
{
    /**
     * @param Product $product
     * @return Product
     */
    protected function transformProduct(Product $product)
    {
        $prop = new Product;
        $prop->id = (int) $product->id;
        $prop->name = $product->name;
        $prop->sku = $product->sku;
        $prop->slug = $product->slug;
        $prop->description = $product->description;
        $prop->cover = $product->cover;
        $prop->quantity = $product->quantity;
        $prop->price = $product->price;
        $prop->ststus = $product->ststus;

        return $prop;
    }
}
