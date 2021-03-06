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

Route::get('/', [App\Http\Controllers\ProductController::class, 'getProductsCounter'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\ProductController::class, 'getProductsCounter'])->name('home');
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


Route::get('/admin', [App\Http\Controllers\AdminController::class, 'dashboard'])->middleware(['admin','auth']);


Route::get('/admin/pages', [App\Http\Controllers\AdminController::class, 'pages'])->middleware(['admin','auth'])->name('pages');
Route::get('/admin/pages/add', [App\Http\Controllers\AdminController::class, 'addPages'])->middleware(['admin','auth']);
Route::post('/admin/pages/add', [App\Http\Controllers\AdminController::class, 'savePage'])->middleware(['admin','auth']);
Route::get('/admin/pages/edit/{id}', [App\Http\Controllers\AdminController::class, 'editPages'])->middleware(['admin','auth']);
Route::post('/admin/pages/edit/{id}', [App\Http\Controllers\AdminController::class, 'updatePage'])->middleware(['admin','auth']);
Route::get('/admin/pages/delete/{id}', [App\Http\Controllers\AdminController::class, 'deletePages'])->middleware(['admin','auth']);
Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'userslist'])->middleware(['admin','auth'])->name('users');

Route::get('/admin/users/edit/{id}', [App\Http\Controllers\AdminController::class, 'editUser'])->middleware(['admin','auth']);
Route::post('/admin/users/edit/{id}', [App\Http\Controllers\AdminController::class, 'updateUser'])->middleware(['admin','auth']);

Route::get('/admin/users/add', [App\Http\Controllers\AdminController::class, 'addUsers'])->middleware(['admin','auth']);
Route::post('/admin/users/add', [App\Http\Controllers\AdminController::class, 'saveUsers'])->middleware(['admin','auth']);
Route::get('/admin/users/delete/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->middleware(['admin','auth']);



Route::get('/admin/products', [App\Http\Controllers\AdminProductController::class, 'getProducts'])->middleware(['admin','auth']);

Route::get('/admin/profile',[App\Http\Controllers\UserController::class, 'show'])->name('profile')->middleware(['admin','auth']);
Route::post('/admin/profile',[App\Http\Controllers\UserController::class, 'profileUpdate'])->name('profile')->middleware(['admin','auth']);

Route::get('/profile',[App\Http\Controllers\UserController::class, 'show'])->name('profile')->middleware(['auth']);;
Route::post('/profile',[App\Http\Controllers\UserController::class, 'profileUpdate'])->name('profile')->middleware(['auth']);;



Route::get('/admin/products', [App\Http\Controllers\AdminProductController::class, 'getProducts'])->middleware(['admin','auth'])->name('adminproducts.getProducts');


Route::get('/{slug}',[App\Http\Controllers\HomeController::class, 'show']); 

Route::post('/search-products',[App\Http\Controllers\ProductController::class, 'searchProducts'])->name('search-products');

