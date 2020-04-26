<?php
/**
 * Created by PhpStorm.
 * User: Herval
 * Date: 26/04/2020
 * Time: 19:31
 */

namespace App\Shop\PaymentMethods\Paypal;


use App\Shop\PaymentMethods\Paypal\Exceptions\PaypalRequestError;
use Illuminate\Support\Collection;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;

class PaypalExpress
{
    /**
     * @var ApiContext
     */
    private $apiContext;
    /**
     * @var Payer
     */
    private $payer;
    /**
     * @var ItemList
     */
    private $itemList;
    /**
     * @var Details
     */
    private $others;
    /**
     * @var Amount
     */
    private $amount;
    /**
     * @var Transaction
     */
    private $transactions = 0;

    private $orderDetails;

    /**
     * PaypalExpress constructor.
     * @param $clientId
     * @param $clientSecret
     * @param string $mode
     * @param string $url
     */
    public function __construct($clientId, $clientSecret, $mode = 'sandbox', $url = 'https://api.sandbox.paypal.com')
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                $clientId, $clientSecret
            )
        );
        $apiContext->setConfig(
            array(
                'mode' => $mode,
                'log.LogEnabled' => env('APP_DEBUG'),
                'log.FileName' => storage_path('logs/paypal.log'),
                'log.LogLevel' => env('APP_LOG_LEVEL'),
                'cache.enabled' => true,
                'cache.FileName' => storage_path('logs/paypal.cache')
            )
        );
        $this->apiContext = $apiContext;
    }

    /**
     * @return ApiContext
     */
    public function getApiContext()
    {
        return $this->apiContext;
    }

    /**
     *
     */
    public function setPayer()
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $this->payer = $payer;
    }

    /**
     * @param Collection $products
     */
    public function setItems(Collection $products)
    {
        $items = [];
        foreach ($products as $product) {
            $item = new Item();
            $item->setName($product->name)
                ->setDescription($product->description)
                ->setQuantity($product->quantity)
                ->setCurrency('PHP')
                ->setPrice($product->price);
            $items[] = $item;
        }

        $itemList = new ItemList();
        $itemList->setItems($items);
        $this->itemList = $itemList;
    }

    /**
     * @param $subTotal
     * @param int $tax
     * @param int $shipping
     */
    public function setOtherFees($subTotal, $tax = 0, $shipping = 0)
    {
        $details = new Details();
        $details->setTax($tax)
            ->setSubtotal($subTotal);
        $this->others = $details;

    }

    /**
     * @param $amt
     * @param string $currency
     */
    public function setAmount($amt, $currency = 'PHP')
    {
        $amount = new Amount();
        $amount->setCurrency($currency)
            ->setTotal($amt)
            ->setDetails($this->others);
        $this->amount = $amount;
    }

    /**
     *
     */
    public function setTransactions()
    {
        $transaction = new Transaction();
        $transaction->setAmount($this->amount)
            ->setItemList($this->itemList)
            ->setDescription("Pagamento Com Paypal")
            ->setInvoiceNumber(uniqid());
        $this->transactions = $transaction;
    }

    /**
     * @param string $returnUrl
     * @param string $cancelUrl
     * @return Payment
     */
    public function createPayment(string $returnUrl = '', string $cancelUrl = '')
    {
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($this->payer)
            ->setTransactions([$this->transaction]);

        $redirectUrls = new RedirectUrls();
        $redirectUrls
            ->setReturnUrl($returnUrl)
            ->setCancelUrl($cancelUrl);
        $payment->setRedirectUrls($redirectUrls);
        try {
            return $payment->create($this->apiContext);
        } catch (PayPalConnectionException $e) {
            throw new PaypalRequestError($e->getMessage());
        }
    }

    public function executePayment(string $paymentId)
    {

    }
}
