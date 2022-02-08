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
Route::get('/product/{id}', [App\Http\Controllers\ProductController::class, 'singleProduct'])->name('singleProduct');
Route::post('/review-submit', [App\Http\Controllers\RatingController::class, 'reviewsubmit']);
Route::get('/product-categories', [App\Http\Controllers\ProductController::class, 'getProductCategories'])->name('product.categories');
Route::view('/add-product-category', 'add-product-category');
Route::post('/add-product-category', [App\Http\Controllers\ProductController::class, 'createCategory'])->name('add.product.category');
Route::get('/add-product-category/{id}', [App\Http\Controllers\ProductController::class, 'editCategory'])->name('edit.product.category');
Route::post('/add-product-category/{id}', [App\Http\Controllers\ProductController::class, 'updateCategory'])->name('edit.product.category');
Route::get('/product-categories/remove/{id}', [App\Http\Controllers\ProductController::class, 'destroyCategory'])->name('remove.product.category');

Route::get('/shop', [App\Http\Controllers\ProductAPIController::class, 'index'])->name('shop');


Route::get('/admin', [App\Http\Controllers\AdminController::class, 'dashboard'])->middleware(['admin']);


Route::get('/admin/pages', [App\Http\Controllers\AdminController::class, 'pages'])->middleware(['admin']);
Route::get('/admin/pages/add', [App\Http\Controllers\AdminController::class, 'addPages'])->middleware(['admin']);
Route::post('/admin/pages/add', [App\Http\Controllers\AdminController::class, 'savePage'])->middleware(['admin']);
Route::get('/admin/pages/edit/{id}', [App\Http\Controllers\AdminController::class, 'editPages'])->middleware(['admin']);
Route::post('/admin/pages/edit/{id}', [App\Http\Controllers\AdminController::class, 'updatePage'])->middleware(['admin']);
Route::get('/admin/pages/delete/{id}', [App\Http\Controllers\AdminController::class, 'deletePages'])->middleware(['admin']);
Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'userslist'])->middleware(['admin']);

Route::get('/admin/users/edit/{id}', [App\Http\Controllers\AdminController::class, 'editUser'])->middleware(['admin']);
Route::post('/admin/users/edit/{id}', [App\Http\Controllers\AdminController::class, 'updateUser'])->middleware(['admin']);

Route::get('/admin/users/add', [App\Http\Controllers\AdminController::class, 'addUsers'])->middleware(['admin']);
Route::post('/admin/users/add', [App\Http\Controllers\AdminController::class, 'saveUsers'])->middleware(['admin']);
Route::get('/admin/users/delete/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->middleware(['admin']);

Route::get('/admin/profile',[App\Http\Controllers\UserController::class, 'show'])->name('profile');
Route::post('/admin/profile',[App\Http\Controllers\UserController::class, 'profileUpdate'])->name('profile');
Route::get('/admin/products', [App\Http\Controllers\AdminProductController::class, 'getProducts'])->middleware(['admin']);