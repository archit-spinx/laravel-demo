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
Route::view('/add-product','addproduct')->name('create.product')->middleware(['admin']);
Route::post('/add-product', [App\Http\Controllers\ProductController::class, 'validateproduct']);
Route::get('/products', [App\Http\Controllers\ProductController::class, 'showProducts']);
Route::get('deleteproduct/{id}', [App\Http\Controllers\ProductController::class, 'deleteProduct']);
Route::get('edit/{id}', [App\Http\Controllers\ProductController::class, 'editproduct']);
Route::post('edit/{id}', [App\Http\Controllers\ProductController::class, 'updateProduct']);
Route::get('/restricted', [App\Http\Controllers\HomeController::class, 'restricted'])->middleware(['admin']);
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
