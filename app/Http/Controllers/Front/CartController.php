<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Shop\Cart\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Cart\Requests\AddToCartRequest;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Repositories\ProductRepository;
use Gloudemans\Shoppingcart\CartItem;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * CartController constructor.
     * @param CartRepositoryInterface $cartRepository
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(CartRepositoryInterface $cartRepository, ProductRepositoryInterface $productRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $products = new ProductRepository(new Product());

        $items = collect($this->cartRepository->getCartItems())->map(function (CartItem $item) use ($products) {
            $product = $products->findProductById($item->id);
            $item->product = $product;
            $item->cover = $product->cover;
            return $item;
        });

        return view('front.carts.cart', [
            'products' => $items,
            'subTotal' => $this->cartRepository->getSubTotal(),
            'tax' => $this->cartRepository->getTax(),
            'total' => $this->cartRepository->getTotal()
        ]);
    }

    /**
     * @param AddToCartRequest $request
     * @return RedirectResponse
     */
    public function store(AddToCartRequest $request)
    {
        $product = $this->productRepository->findProductById($request->input('product'));
        $this->cartRepository->addToCart($product, $request->input('quantity'));

        $request->session()->flash('message', 'Produto adicionado ao carrinho com sucesso.');
        return redirect()->route('cart.index');
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->cartRepository->updateQuantityInCart($id, $request->input('quantity'));

        $request->session()->flash('message', 'Carrinho atualizado com sucesso.');
        return redirect()->route('cart.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $this->cartRepository->removeToCart($id);

        $request->session()->flash('message', 'Carrinho removido com sucesso.');
        return redirect()->route('cart.index');
    }
}
