<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 25/04/2020
 * Time: 16:22
 */

namespace App\Shop\Categories\Repositories;


use App\Shop\Addresses\Repositories\UploadableTrait;
use App\Shop\Base\BaseRepository;
use App\Shop\Categories\Category;
use App\Shop\Categories\Exceptions\CategoryInavalidArgumentException;
use App\Shop\Categories\Exceptions\CategoryNotFoundException;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Products\Exceptions\ProductTransformable;
use App\Shop\Products\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    use ProductTransformable;
    use UploadableTrait;
    /**
     * CategoryRepository constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    /**
     * @param string $order
     * @param string $sort
     * @return array
     */
    public function ListCategories(string $order = 'id', string $sort = 'desc'): array
    {
        $list = $this->model->orderBy($order, $sort)->get();
        return collect($list)->all();
    }

    /**
     * @param array $params
     * @return Category
     */
    public function createCategory(array $params): Category
    {
        try {
            $collection = collect($params)->except('_token');
            $slug = Str::slug($collection->get('name'));

            if (request()->hasFile('cover')) {
                $file = request()->file('cover', 'products');
                $cover = $this->uploadOne($file, 'categories');
            }

            $merge = $collection->merge(compact('slug', 'cover'));

            $category = new Category($merge->all());
            $category->save();
            return $category;
        } catch (QueryException $e) {
            throw new CategoryInavalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param array $params
     * @return Category
     */
    public function updateCategory(array $params): Category
    {
        $category = $this->findCategoryById($this->model->id);
        $collection = collect($params)->except('_token');
        $slug = Str::slug($collection->get('name'));

        if (request()->hasFile('cover')) {
            $file = request()->file('cover', 'products');
            $cover = $this->uploadOne($file, 'categories');
        }

        $merge = $collection->merge(compact('slug', 'cover'));
        $category->update($merge->all());
        return $category;

    }

    /**
     * @param int $id
     * @return Category
     */
    public function findCategoryById(int $id): Category
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundException($e->getMessage());
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteCategory(): bool
    {
        return $this->model->delete();
    }

    /**
     *
     */
    public function detachProducts()
    {
        $this->model->products()->detach();
    }

    /**
     * @return Collection
     */
    public function findProducts()
    {
        return collect($this->model->products)->map(function (Product $product) {
            return $this->transformProduct($product);
        })->sortByDesc('id');
    }

    /**
     * @param Product $product
     * @return Model
     */
    public function asociateProduct(Product $product)
    {
        return $this->model->products()->save($product);
    }

    /**
     * @param array $params
     */
    public function syncProducts(array $params)
    {
        $this->model->products()->sync($params);
    }

    /**
     * @param array $file
     * @param null $disk
     * @return bool
     */
    public function deleteFile(array $file, $disk = null): bool
    {
        return $this->update(['cover' => null], $file['category']);
    }

    /**
     * @param array $slug
     * @return Category
     */
    public function findCategoryBySlug(array $slug): Category
    {
        try {
            return $this->findOneByOrFail($slug);
        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundException($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function findProductsInCategory(int $id)
    {
        $products = [];
        foreach ($this->all() as $category) {
            if ($category->id == $id) {
                $products[] = ($this->findCategoryById($id))->products;
            }
        }

        return collect($products[0])->map(function (Product $product) {
            return $this->transformProduct($product);
        });
    }
}
