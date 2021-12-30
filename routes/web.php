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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::view('/add-product','addproduct')->name('create.product');
Route::post('/add-product', [App\Http\Controllers\ProductController::class, 'validateproduct']);
Route::get('/products', [App\Http\Controllers\ProductController::class, 'showProducts']);
Route::get('deleteproduct/{id}', [App\Http\Controllers\ProductController::class, 'deleteProduct']);
Route::get('edit/{id}', [App\Http\Controllers\ProductController::class, 'editproduct']);
Route::post('edit/{id}', [App\Http\Controllers\ProductController::class, 'updateProduct']);