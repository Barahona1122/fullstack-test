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
    return redirect("shop/home");
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {

	Route::group(['prefix' => 'admin'], function () {
		Route::get('/home', 'HomeController@index')->name('home');

		//PRODUCTS
		Route::get("products",['as' => "products", 'uses' => 'ProductsController@index']);
		Route::post("product/list",['as' => "product/list", 'uses' => 'ProductsController@listProducts']);
		Route::post("product/store",['as' => "product/store", 'uses' => 'ProductsController@store']);
		Route::post("product/edit",['as' => "product/edit", 'uses' => 'ProductsController@edit']);
		Route::post("product/update",['as' => "product/update", 'uses' => 'ProductsController@update']);
		Route::post("product/destroy",['as' => "product/destroy", 'uses' => 'ProductsController@destroy']);

		//USERS
		Route::get("users",['as' => "users", 'uses' => 'UsersController@index']);
		Route::post("user/list",['as' => "user/list", 'uses' => 'UsersController@listUsers']);
		Route::post("user/store",['as' => "user/store", 'uses' => 'UsersController@store']);
		Route::post("user/edit",['as' => "user/edit", 'uses' => 'UsersController@edit']);
		Route::post("user/update",['as' => "user/update", 'uses' => 'UsersController@update']);
		Route::post("user/destroy",['as' => "user/destroy", 'uses' => 'UsersController@destroy']);

	});
});


// Route::group(['middleware' => 'guest'], function() {
	Route::group(['prefix' => 'shop'], function () {
		Route::get("home",['as' => "home", 'uses' => 'GuestController@index']);
		Route::post("products",['as' => "products", 'uses' => 'GuestController@products']);
		Route::get("product/{slug}",['as' => "product/{slug}", 'uses' => 'GuestController@details']);

		Route::post("detail",['as' => "detail", 'uses' => 'GuestController@detail']);


		//CART
		Route::get("cart",['as' => "cart", 'uses' => 'GuestController@cart']);
		Route::post("list/cart",['as' => "list/cart", 'uses' => 'GuestController@listCart']);
		Route::post("addCart",['as' => "addCart", 'uses' => 'GuestController@addCart']);
		Route::post("changeQuantity",['as' => "changeQuantity", 'uses' => 'GuestController@changeQuantity']);
		Route::post("DestroyCart",['as' => "DestroyCart", 'uses' => 'GuestController@DestroyCart']);

		//CHECKOUT
		Route::get("checkout",['as' => "checkout", 'uses' => 'GuestController@checkout']);

	});
// });