<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//GUEST
	Route::post('shop/products' ,['as' => 'shop/products' , 'uses' => 'Api\GuestApiController@products']);

	Route::post('shop/cart' ,['as' => 'shop/cart' , 'uses' => 'Api\GuestApiController@cart']);

// ADMIN
	Route::post('login' ,['as' => 'login' , 'uses' => 'Auth\AuthController@login']);
	Route::post('logout',['as' => 'logout', 'uses' => 'Auth\AuthController@logout']);
	Route::post('admin/users' ,['as' => 'admin/users' , 'uses' => 'Api\AdminApiController@users']);
	Route::post('admin/products' ,['as' => 'admin/products' , 'uses' => 'Api\AdminApiController@products']);