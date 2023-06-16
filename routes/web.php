<?php

use App\Http\Controllers\TshirtImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [TshirtImageController::class, 'index'])->name('root');
Route::get('/home', [TshirtImageController::class, 'index'])->name('home');

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::view('teste', 'template.layout');

//Tshirt_images Routes
Route::get('tshirt_images', [TshirtImageController::class, 'index']);


Route::resource('tshirt_images', TshirtImageController::class);
Route::resource('orders', OrderController::class);

// Cart routes
Route::post('cart/add', [CartController::class, 'addToCart'])->name('cart.add'); // add item to cart
Route::delete('cart/{cartIndex}', [CartController::class, 'removeFromCart'])->name('cart.remove'); // remove item from cart
Route::get('cart', [CartController::class, 'show'])->name('cart.show'); // show cart items
Route::post('cart', [CartController::class, 'store'])->name('cart.store'); // confirm order
Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy'); // clear cart
