<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

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
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get("category/{name}", 'Front\Categories\CategoryController')->name('front.category.slug');
Route::get("{product}", 'Front\Products\ProductController')->name('front.get.product');

