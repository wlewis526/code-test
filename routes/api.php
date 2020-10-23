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

Route::post('token', 'LoginController@token');

Route::group(['middleware' => ['auth:api', 'subscription']], function(){
	Route::post('products', 'ProductsController@store');
});
Route::group(['middleware' => ['auth:api']], function(){
	Route::get('products', 'ProductsController@index');
	Route::get('products/{id}', 'ProductsController@get');
	Route::put('products/{id}', 'ProductsController@update');
	Route::delete('products/{id}', 'ProductsController@destroys');
});
