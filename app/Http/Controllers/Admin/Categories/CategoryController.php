<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\Controller;
use App\Shop\Categories\Repositories\CategoryRepository;
use App\Shop\Categories\Repositories\Interfaces\CategotyRepositoryInterface;
use App\Shop\Categories\Requests\CreateCategoryRequest;
use App\Shop\Categories\Requests\UpdateCategoryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $list = $this->categotyRepository->ListCategories('created_at', 'desc');

        return view('admin.categories.list', ['categories' => $this->categotyRepository->paginateArrayResults($list)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCategoryRequest $request
     * @return Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $this->categotyRepository->createCategory($request->all());

        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $category = $this->categotyRepository->findCategoryById($id);
        $categoryRepository = new CategoryRepository($category);

        return view('admin.categories.show', [
            'category' => $category,
            'products' => $categoryRepository->findProducts()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        return view('admin.categories.edit', ['category' => $this->categotyRepository->findCategoryById($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->categotyRepository->findCategoryById($id);
        $update = new CategoryRepository($category);
        $update->updateCategory($request->all());

        $request->session()->flash('message', 'Categoria atualizada com sucesso.');
        return redirect()->route('categories.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->categotyRepository->delete($id);

        request()->session()->flash('message', 'Categoria removida com sucesso.');
        return redirect()->route('categories.index');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function removeImage(Request $request)
    {
        $this->categotyRepository->deleteFile($request->only('category'));
        request()->session()->flash('message', 'Imagem da categoria removida com sucesso.');
        return redirect()->back();
    }
}
