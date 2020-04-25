<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Shop\Categories\Repositories\Interfaces\CategotyRepositoryInterface;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Repositories\ProductRepository;
use App\Shop\Products\Requests\CreateProductRequest;
use App\Shop\Products\Requests\updateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductsController extends Controller
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var CategotyRepositoryInterface
     */
    private $categotyRepository;

    /**
     * ProductsController constructor.
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository, CategotyRepositoryInterface $categotyRepository)
    {
        $this->productRepository = $productRepository;
        $this->categotyRepository = $categotyRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $list = $this->productRepository->ListProducts('created_at', 'desc');

        return view('admin.products.list', ['products' => $this->productRepository->paginateArrayResults($list, 10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateProductRequest $request
     * @return Response
     */
    public function store(CreateProductRequest $request)
    {
        $this->productRepository->createProduct($request->all());
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $product = $this->productRepository->findProductById($id);

        return view('admin.products.show', [
            'products' => $product
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
        $product = $this->productRepository->findProductById($id);
        $productCategories = $product->categories;

        $ids = [];
        foreach ($productCategories as $category) {
            $ids[] = $category->id;
        }

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $this->categotyRepository->ListCategories('name', 'asc'),
            'selectCategories' => $ids
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param updateProductRequest $request
     * @param int $id
     * @return Response
     */
    public function update(updateProductRequest $request, $id)
    {
        $product = $this->productRepository->findProductById($id);
        $update = new ProductRepository($product);
        $update->updateProduct($request->except('categories'));

        if ($request->has('categories')) {
            $collection = collect($request->input('categories'));
            $categories = $collection->all();
            $update->syncCategories($categories);
        } else {
            $update->detachCategories($product);
        }

        $request->session()->flash('message', 'Produto atualizado com sucesso.');
        return redirect()->route('products.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->productRepository->delete($id);

        request()->session()->flash('message', 'Produto removido com sucesso.');
        return redirect()->route('products.index');
    }

    public function removeImage(Request $request)
    {
        $this->productRepository->deleteFile($request->only('product', 'image'), 'uploads');
        request()->session()->flash('message', 'Imagem do produto removida com sucesso.');
        return redirect()->back();
    }
}
