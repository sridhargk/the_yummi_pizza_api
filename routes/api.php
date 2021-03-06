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

Route::apiResource('/customers', 'API\CustomerController');
Route::apiResource('/products', 'API\ProductController');
Route::apiResource('/product_categories', 'API\ProductCategoryController');
Route::apiResource('/orders', 'API\OrderController');
Route::get('customer_orders/{id}', 'API\OrderController@show_customers');
Route::post('customer_by_email', 'API\CustomerController@show_customer_by_email');
