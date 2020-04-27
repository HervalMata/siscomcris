<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Front\HomeController@index')->name('home');
Route::get('logout', 'Auth\LoginController@logout');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('accounts', 'Front\AccountsController@index')->name('accounts');
});

Route::get('admin/login', 'Admin\LoginController@showLoginForm');
Route::post('admin/login', 'Admin\LoginController@login')->name('admin.login');
Route::get('admin/logout', 'Admin\LoginController@logout')->name('admin.logout');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', 'Admin\DashboardController@index')->name('dashboard');
    Route::resource('employees', 'Admin\Employees\EmployeeController');
    Route::resource('customers', 'Admin\Customers\CustomerController');
    Route::resource('customers.addresses', 'Admin\Customers\CustomerAddressController');
    Route::resource('addresses', 'Admin\Addresses\AddressController');
    Route::resource('countries', 'Admin\Countries\CountryController');
    Route::resource('countries.provinces', 'Admin\Provinces\ProvinceController');
    Route::resource('countries.provinces.cities', 'Admin\Cities\CityController');
    Route::get('remove-image-product', 'Admin\Products\ProductController@removeImage')->name('product.remove.image');
    Route::resource('products', 'Admin\Products\ProductController');
    Route::get('remove-image-category', 'Admin\Categories\CategorytController@removeImage')->name('category.remove.image');
    Route::resource('categories', 'Admin\Categories\CategorytController');
    Route::resource('orders', 'Admin\Orders\OrderController');
    Route::resource('order-statuses', 'Admin\Orders\OrderStatusController');
    Route::resource('courriers', 'Admin\Courriers\CourrierController');
    Route::resource('payment-methods', 'Admin\PaymentMethods\PaymentMethodController');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('cart/login', 'Auth\CartLoginController@showLoginForm')->name('cart.login');
Route::post('cart/login', 'Auth\CartLoginController@login')->name('cart.login');
Route::resource("cart", 'Front\CartController');
Route::get('checkout', 'Front\CheckoutController@index')->name('checkout.index');
Route::post('checkout', 'Front\CheckoutController@store')->name('checkout.store');
Route::get('checkout/execute', 'Front\CheckoutController@execute')->name('checkout.execute');
Route::get('checkout/cancel', 'Front\CheckoutController@cancel')->name('checkout.cancel');
Route::get('checkout/success', 'Front\CheckoutController@success')->name('checkout.success');
#Route::post('paypal', 'Front\Paymets\PaypalController@store')->name('paypal.store');
Route::get("category/{name}", 'Front\Categories\CategoryController@getCategory')->name('front.category.slug');
Route::get("{product}", 'Front\Products\ProductController@getCategory')->name('front.get.product');
Route::post('inquire', function (SendInquiryRequest $request) {
    Mail::to(env('F12_INQUIRY_MAIL', 'firstwelve@gmail.com'))->send(new Inquiry($request));
    $request->session()->flash('message', 'Sua mensagem foi entregue com sucesso! Por favor espere que nós retornaremos pra vocÊ. <3');
    return redirect()->route('home');
});

