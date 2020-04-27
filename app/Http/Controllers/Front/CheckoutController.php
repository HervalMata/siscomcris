<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Cart\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Cart\Requests\CartCheckoutRequest;
use App\Shop\Courriers\Repositories\Interfaces\CourrierRepositoryInterface;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Shop\OrderProducts\OrderProduct;
use App\Shop\OrderProducts\Repositories\OrderDetailRepository;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\Shop\PaymentMethods\PaymentMethod;
use App\Shop\PaymentMethods\Paypal\Exceptions\PaypalRequestError;
use App\Shop\PaymentMethods\Paypal\PaypalExpress;
use App\Shop\PaymentMethods\Repositories\Interfaces\PaymentMethodRepositoryInterface;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Repositories\ProductRepository;
use Gloudemans\Shoppingcart\CartItem;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;
use Ramsey\Uuid\Uuid;
use Exception;

class CheckoutController extends Controller
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;
    /**
     * @var CourrierRepositoryInterface
     */
    private $courrierRepository;
    /**
     * @var PaymentMethodRepositoryInterface
     */
    private $methodRepository;
    /**
     * @var AddressRepositoryInterface
     */
    private $addressRepository;
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * CheckoutController constructor.
     * @param CartRepositoryInterface $cartRepository
     * @param CourrierRepositoryInterface $courrierRepository
     * @param PaymentMethodRepositoryInterface $methodRepository
     * @param AddressRepositoryInterface $addressRepository
     * @param CustomerRepositoryInterface $customerRepository
     * @param ProductRepositoryInterface $productRepository
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        CartRepositoryInterface $cartRepository,
        CourrierRepositoryInterface $courrierRepository,
        PaymentMethodRepositoryInterface $methodRepository,
        AddressRepositoryInterface $addressRepository,
        CustomerRepositoryInterface $customerRepository,
        ProductRepositoryInterface $productRepository,
        OrderRepositoryInterface $orderRepository
    )
    {
        $this->middleware('checkout');
        $this->cartRepository = $cartRepository;
        $this->courrierRepository = $courrierRepository;
        $this->methodRepository = $methodRepository;
        $this->addressRepository = $addressRepository;
        $this->customerRepository = $customerRepository;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
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

        $customer = $this->customerRepository->findCustomerById(Auth::id());

        $paynents = collect($this->methodRepository->ListPaymentMethods())->filter(function (PaymentMethod $method) {
            return $method->status == 1;
        });

        return view('front.checkout', [
            'products' => $items,
            'subTotal' => $this->cartRepository->getSubTotal(),
            'tax' => $this->cartRepository->getTax(),
            'total' => $this->cartRepository->getTotal(),
            'customers' => $this->courrierRepository->listCourriers(),
            'payments' => $paynents,
            'addresses' => $this->addressRepository->findAddressById($customer)
        ]);
    }

    /**
     * @param CartCheckoutRequest $request
     * @return RedirectResponse
     */
    public function store(CartCheckoutRequest $request)
    {
        $cartItems = collect($this->cartRepository->getCartItems())->map(function (CartItem $item) use ($products) {
            $product = $products->findProductById($item->id);
            $item->product = $this->productRepository->findProductById($item->id);
            $item->description = $product-description;
            return $item;
        });

        $method = $this->methodRepository->findPaymentMethodById($request->input('payment'));

        if ($method->slug == 'paypal') {
            $paypal = new PaypalExpress(config('paypal.client_id'), config('paypal.clent_secret'));
            $paypal->setPayer();
            $paypal->setItems($cartItems);
            $paypal->setOtherFees(
                $this->cartRepository->getSubTotal(),
                $this->cartRepository->getTax()
            );
            $paypal->setAmount($this->cartRepository->getTotal());
            $paypal->setTransactions();
            try {
                $response = $paypal->createPayment(route('checkout.execute', $request->except('_token')), route('checkout.cancel'));
                if ($response) {
                    $redirectUrl = $response->links[1]->href;
                    return redirect()->to($redirectUrl);
                }
            } catch (PayPalConnectionException $e) {
                throw new PaypalRequestError($e->getMessage());
            }
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function execute(Request $request)
    {
        $paypal = new PaypalExpress(config('paypal.client_id'), config('paypal.clent_secret'));
        $apiContext = $paypal->getApiContext();

        $payment = Payment::get($request->input('paymentId'), $apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));
        try {
            if ($payment->execute($execution, $apiContext)) {
                foreach ($payment->getTransactions() as $t) {
                    return $this->buildOrder([
                        'reference' => Uuid::uuid4()->toString(),
                        'courrier_id' => $request->input('courrier'),
                        'customer_id' => Auth::id(),
                        'address_id' => $request->input('address'),
                        'order_status_id' => 1,
                        'payment_method_id' => $request->input('payment'),
                        'discounts' => 0,
                        'total_products' => $this->cartRepository->getSubTotal(),
                        'total' => $this->cartRepository->getTotal(),
                        'total_paid' => $t->setAmount()->getTotal(),
                        'tax' => $this->cartRepository->getTax()
                    ]);
                }
            }
        } catch (PayPalConnectionException $e) {
            throw new PaypalRequestError($e->getData());
        } catch (Exception $e) {
            throw new PaypalRequestError($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function cancel(Request $request)
    {
        return view('front.checkout-cancel');
    }

    /**
     * @return Factory|View
     */
    public function success()
    {
        return view('front.checkout-success');
    }

    /**
     * @param array $params
     * @return mixed
     */
    private function buildOrder(array $params)
    {
        $order = $this->orderRepository->createOrder($params);
        return $this->buildOrderDetails($order);
    }

    /**
     * @param Order $order
     * @return mixed
     */
    private function buildOrderDetails(Order $order)
    {
        foreach ($this->cartRepository->getCartItems() as $item) {
            $product = $this->productRepository->find($item->id);
            $orderDetail = new OrderDetailRepository(new OrderProduct);
            $orderDetail->createOrderDetail($order, $product, $item->qty);
        }

        return $this->clearCart();
    }

    /**
     * @return RedirectResponse
     */
    private function clearCart()
    {
        $this->cartRepository->clearCart();
        return redirect()->route('checkout.success');
    }
}
