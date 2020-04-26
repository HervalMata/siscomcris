<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 16:00
 */

namespace App\Shop\Cart\Repositories;


use App\Shop\Base\BaseRepository;
use App\Shop\Cart\Exceptions\ProductInCartNotFoundException;
use App\Shop\Cart\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Cart\ShoppingCart;
use App\Shop\Products\Product;
use Gloudemans\Shoppingcart\CartItem;
use Gloudemans\Shoppingcart\Exceptions\InvalidRowIDException;
use Illuminate\Support\Collection;

class CartRepository extends BaseRepository implements CartRepositoryInterface
{
    /**
     * CartRepository constructor.
     * @param ShoppingCart $cart
     */
    public function __construct(ShoppingCart $cart)
    {
        $this->model = $cart;
    }

    /**
     * @param Product $product
     * @param int $int
     * @param array $options
     */
    public function addToCart(Product $product, int $int, $options = [])
    {
        $this->model->add($product, $int, $options);
    }

    /**
     * @return Collection
     */
    public function getCartItems()
    {
        return $this->model->content();
    }

    /**
     * @param string $rowId
     */
    public function removeToCart(string $rowId)
    {
        try {
            $this->model->remove($rowId);
        } catch (InvalidRowIDException $e) {
            throw new ProductInCartNotFoundException($e->getMessage());
        }
    }

    /**
     * @return int
     */
    public function countItems(): int
    {
        return $this->model->count();
    }

    /**
     * @return float
     */
    public function getSubTotal()
    {
        return $this->model->subtotal();
    }

    /**
     * @param int $decimals
     * @return string
     */
    public function getTotal(int $decimals = 2)
    {
        return $this->model->total($decimals);
    }

    /**
     * @param string $rowId
     * @param int $quantity
     */
    public function updateQuantityInCart(string $rowId, int $quantity)
    {
        $this->model->update($rowId, $quantity);
    }

    /**
     * @param string $rowId
     * @return CartItem
     */
    public function findItem(string $rowId)
    {
        return $this->model->get($rowId);
    }

    /**
     * @return float
     */
    public function getTax(): float
    {
        return $this->model->tax();
    }

    /**
     *
     */
    public function clearCart()
    {
        $this->model->destroy();
    }
}
