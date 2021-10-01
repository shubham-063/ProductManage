<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
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
Route::get('/', [ProductController::class, 'index'])->name('products');
Route::get('/product/creatre', [ProductController::class, 'create'])->name('create_product');
Route::post('/product/store', [ProductController::class, 'store'])->name('store_product');
Route::post('/product/delete', [ProductController::class, 'destroy'])->name('delete_product');
Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('edit_product');
Route::post('/product/update', [ProductController::class, 'update'])->name('update_product');