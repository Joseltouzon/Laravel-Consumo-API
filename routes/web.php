<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Route::get('/', [App\Http\Controllers\WelcomeController::class, 'showWelcomePage'])->name('welcome');

Route::get('authorization', [App\Http\Controllers\Auth\loginController::class, 'authorization'])->name('authorization');

Route::get('categories/{title}-{id}/products', [App\Http\Controllers\CategoryProductController::class, 'showProducts'])->name('categories.products.show');

Route::get('products/{title}-{id}', [App\Http\Controllers\ProductController::class, 'showProduct'])->name('products.show');

Auth::routes(['register' => false, 'reset' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


