<?php

namespace App\Http\Controllers\Front\Categories;

use App\Http\Controllers\Controller;
use App\Shop\Categories\Repositories\CategoryRepository;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categotyRepository;

    /**
     * CategoryController constructor.
     * @param CategoryRepositoryInterface $categotyRepository
     */
    public function __construct(CategoryRepositoryInterface $categotyRepository)
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
