<?php

namespace App\Http\Controllers;

use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categotyRepository;

    /**
     * Create a new controller instance.
     *
     * @param CategoryRepositoryInterface $categotyRepository
     */
    public function __construct(CategoryRepositoryInterface $categotyRepository)
    {
        $this->categotyRepository = $categotyRepository;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $newests = $this->categotyRepository->findProductsInCategory(1);
        $features = $this->categotyRepository->findProductsInCategory(2);

        return view('front.index', compact('newests', 'features'));
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function landing()
    {
        return view('layouts.front.landing');
    }
}
