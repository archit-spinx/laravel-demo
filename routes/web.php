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

Route::view('/home', 'home');
Route::get('/products', [App\Http\Controllers\ProductController::class, 'getProducts'])->name('products');
Route::get('/add-product', [App\Http\Controllers\ProductController::class, 'getProductCategories'])->name('add-product');
Route::post('/add-product', [App\Http\Controllers\ProductController::class, 'create'])->name('add-product');
Route::get('/add-product/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('edit-product');
Route::post('/add-product/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('edit-product');
Route::get('/products/remove/{id}', [App\Http\Controllers\ProductController::class, 'destroy']);
Route::get('/search', [App\Http\Controllers\ProductController::class, 'search']);
Route::get('/product/{id}', [App\Http\Controllers\ProductController::class, 'singleProduct']);
Route::post('/review-submit', [App\Http\Controllers\RatingController::class, 'reviewsubmit']);
Route::get('/product-categories', [App\Http\Controllers\ProductController::class, 'getProductCategories'])->name('product.categories');
Route::view('/add-product-category', 'add-product-category');
Route::post('/add-product-category', [App\Http\Controllers\ProductController::class, 'createCategory'])->name('add.product.category');
Route::get('/add-product-category/{id}', [App\Http\Controllers\ProductController::class, 'editCategory'])->name('edit.product.category');
Route::post('/add-product-category/{id}', [App\Http\Controllers\ProductController::class, 'updateCategory'])->name('edit.product.category');
Route::get('/product-categories/remove/{id}', [App\Http\Controllers\ProductController::class, 'destroyCategory'])->name('remove.product.category');