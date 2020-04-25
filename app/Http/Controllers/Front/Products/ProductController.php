<?php

namespace App\Http\Controllers\Front\Products;

use App\Http\Controllers\Controller;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * ProductController constructor.
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param string $slug
     * @return Factory|View
     */
    public function getProduct(string $slug)
    {
        return view('front.products.product', [
            'products' => $this->productRepository->findProductBySlug(['slug' => $slug])
        ]);
    }
}
