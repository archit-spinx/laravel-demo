<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\ProductController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', function () {
    return ProductResource::collection(Product::where('status', 1)->orderBy('updated_at', 'desc')->paginate(6));
});
Route::get('/all-products', function () {
    return ProductResource::collection(Product::where('status', 1)->get());
});
//Route::get('products', 'App\Http\Controllers\API\ProductController@index');
//Route::get('products', 'App\Http\Controllers\API\ProductController@index');
Route::get('product/single/{id}', 'App\Http\Controllers\API\ProductController@show');
Route::post('product/create', 'App\Http\Controllers\API\ProductController@store');
Route::post('product/update/{id}', 'App\Http\Controllers\API\ProductController@update');
Route::delete('product/delete/{id}', 'App\Http\Controllers\API\ProductController@destroy');

Route::get('/filter', [ProductController::class, 'filterPrice']);
