<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 25/04/2020
 * Time: 18:16
 */

namespace App\Shop\Products\Repositories\Interfaces;


use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Categories\Category;
use App\Shop\Products\Product;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function ListProducts(string $order = 'id', string $sort = 'desc') : array;

    public function createProduct(array $params) : Product;

    public function updateProduct(array $params) : Product;

    public function findProductById(int $id) : Product;

    public function deleteProduct(Product $product) : bool;

    public function detachCategories();

    public function syncCategories(array $params);

    public function deleteFile(array $file, $disk = null) : bool;

    public function findProductBySlug(array $slug) : Product;

    public function uploadOneImage($image, $folder = 'products');
}
