<?php

use App\Http\Controllers\ProductController;
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

Route::resource('/products', ProductController::class);
Route::get('/products/{product}', [ProductController::class, 'edit'])->name('products.edit');
Route::post('/products/{product}/update', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}/delete', [ProductController::class, 'destroy'])->name('products.delete');
