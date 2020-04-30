<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 25/04/2020
 * Time: 18:33
 */

namespace App\Shop\Products\Repositories;


use App\Shop\Addresses\Repositories\UploadableTrait;
use App\Shop\Base\BaseRepository;
use App\Shop\Products\Exceptions\ProductInavalidArgumentException;
use App\Shop\Products\Exceptions\ProductNotFoundException;
use App\Shop\Products\Exceptions\ProductTransformable;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    use ProductTransformable;
    use UploadableTrait;

    /**
     * ProductRepository constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    /**
     * @param string $order
     * @param bool $desc
     * @return array
     */
    public function ListProducts(string $order = 'id', bool $desc = false): array
    {
        $list = $this->all();

        return collect($list)
            ->sortBy($order, SORT_REGULAR, $desc)
            ->map(function (Product $product) {
                return $this->transformProduct($product);
            })->all();

    }

    /**
     * @param array $params
     * @return Product
     */
    public function createProduct(array $params): Product
    {
        try {
            $collection = collect($params)->except('_token');
            $slug = Str::slug($collection->get('name'));

            if (request()->hasFile('cover')) {
                $file = request()->file('cover', 'products');
                $cover = $this->uploadOneImage($file);
            }

            $merge = $collection->merge(compact('slug', 'cover'));

            $product = new Product($merge->all());
            $product->save();
            return $product;
        } catch (QueryException $e) {
            throw new ProductInavalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param array $params
     * @return Product
     */
    public function updateProduct(array $params): Product
    {
        try {
            $collection = collect($params)->except('_token');
            $slug = Str::slug($collection->get('name'));

            if (request()->hasFile('cover')) {
                $file = request()->file('cover', 'products');
                $cover = $this->uploadOneImage($file);
            }

            $merge = $collection->merge(compact('slug', 'cover'));

            $this->update($merge->all(), $this->model->id);
            return $this->find($this->model->id);
        } catch (QueryException $e) {
            throw new ProductInavalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return Product
     */
    public function findProductById(int $id): Product
    {
        try {
            return $this->transformProduct($this->findOrFail($id));
        } catch (ModelNotFoundException $e) {
            throw new ProductNotFoundException($e->getMessage());
        }
    }

    /**
     * @param Product $product
     * @return bool
     * @throws \Exception
     */
    public function deleteProduct(Product $product): bool
    {
        return $product->delete();
    }

    /**
     * @param Product $product
     */
    public function detachCategories(Product $product)
    {
        $product->categories()->detach();
    }

    /**
     * @param array $params
     */
    public function syncCategories(array $params)
    {
        $this->model->categories()->sync($params);
    }

    /**
     * @param array $file
     * @param null $disk
     * @return bool
     */
    public function deleteFile(array $file, $disk = null): bool
    {
        return $this->update(['cover' => null], $file['product']);
    }

    /**
     * @param array $slug
     * @return Product
     */
    public function findProductBySlug(array $slug): Product
    {
        try {
            return $this->findOneByOrFail($slug);
        } catch (ModelNotFoundException $e) {
            throw new ProductNotFoundException($e->getMessage());
        }
    }

    /**
     * @param $image
     * @param string $folder
     * @return mixed
     */
    public function uploadOneImage($image, $folder = 'products')
    {
        return $this->uploadOne($image, $folder);
    }
}
