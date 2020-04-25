<?php

namespace App\Http\Controllers\Front\Categories;

use App\Http\Controllers\Controller;
use App\Shop\Categories\Repositories\CategoryRepository;
use App\Shop\Categories\Repositories\Interfaces\CategotyRepositoryInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * @var CategotyRepositoryInterface
     */
    private $categotyRepository;

    /**
     * CategoryController constructor.
     * @param CategotyRepositoryInterface $categotyRepository
     */
    public function __construct(CategotyRepositoryInterface $categotyRepository)
    {
        $this->categotyRepository = $categotyRepository;
    }

    /**
     * @param string $slug
     * @return Factory|View
     */
    public function getCategory(string $slug)
    {
        $category = $this->categotyRepository->findCategoryBySlug($slug);
        $categoryRepo = new CategoryRepository($category);
        return view('front.categories.category', [
            'category' => $category,
            'products' => $categoryRepo->findProducts()
        ]);
    }
}
