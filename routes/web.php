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
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/products', [App\Http\Controllers\ProductController::class, 'getProducts'])->name('products');
Route::view('/add-product', 'add-product');
Route::post('/add-product', [App\Http\Controllers\ProductController::class, 'create'])->name('add-product');
Route::get('/add-product/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('edit-product');
Route::post('/add-product/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('edit-product');
Route::get('/products/remove/{id}', [App\Http\Controllers\ProductController::class, 'destroy']);
Route::get('/search', [App\Http\Controllers\ProductController::class, 'search']);
Route::get('/product/{id}', [App\Http\Controllers\ProductController::class, 'singleProduct']);
Route::post('/review-submit', [App\Http\Controllers\RatingController::class, 'reviewsubmit']);