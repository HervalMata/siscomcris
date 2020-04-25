<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 25/04/2020
 * Time: 16:13
 */

namespace App\Shop\Categories\Repositories\Interfaces;


use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Categories\Category;
use App\Shop\Products\Product;

interface CategotyRepositoryInterface extends BaseRepositoryInterface
{
    public function ListCategories(string $order = 'id', string $sort = 'desc') : array;

    public function createCategory(array $params) : Category;

    public function updateCategory(array $params) : Category;

    public function findCategoryById(int $id) : Category;

    public function deleteCategory() : bool;

    public function detachProducts();

    public function findProducts();

    public function asociateProduct(Product $product);

    public function syncProducts(array $params);

    public function deleteFile(array $file, $disk = null) : bool;

    public function findCategoryBySlug(array $slug) : Category;

    public function findProductsInCategory(int $id);
}
