<?php

use App\Http\Controllers\TshirtImageController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\UserController;
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
Route::get('tshirt_images_private/{image}', function($image) {
    $file = storage_path('app/tshirt_images_private/'.$image);
    return response()->file($file);
})->name('tshirt_images.private');



Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);Auth::routes();
Route::get('/password/change', [ChangePasswordController::class, 'show'])
    ->name('password.change.show');
Route::post('/password/change', [ChangePasswordController::class, 'store'])
    ->name('password.change.store');

Route::get('/home', [TshirtImageController::class, 'index'])->name('home');


Route::get('/', [TshirtImageController::class, 'index'])->name('root');

Route::view('teste', 'template.layout');
//Route::view('teste', 'template.layout');

//Tshirt_images Routes
Route::get('tshirt_images', [TshirtImageController::class, 'index']);
// Route que devolve uma imagem privada
Route::get('tshirt_images_private/{image}', function($image) {
    $file = storage_path('app/tshirt_images_private/'.$image);
    return response()->file($file);
})->name('tshirt_images.private');


Route::resource('tshirt_images', TshirtImageController::class);
Route::resource('orders', OrderController::class);


Route::resource('customers', CustomerController::class);
Route::delete('customers/{customer}/foto', [CustomerController::class, 'destroy_foto'])
    ->name('customers.foto.destroy');

Route::resource('users', UserController::class);
Route::delete('users/{user}/foto', [UserController::class, 'destroy_foto'])
    ->name('users.foto.destroy');

// Cart routes
Route::post('cart/add', [CartController::class, 'addToCart'])->name('cart.add'); // add item to cart
Route::delete('cart/{cartIndex}', [CartController::class, 'removeFromCart'])->name('cart.remove'); // remove item from cart
Route::get('cart', [CartController::class, 'show'])->name('cart.show'); // show cart items
Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy'); // clear cart
Route::get('cart/edit/{cartIndex}', [CartController::class, 'edit'])->name('cart.edit'); // view para editar
Route::put('cart/{cartIndex}', [CartController::class, 'update'])->name('cart.update'); // editar item
Route::middleware('can:completeOrder')->group(function () {
    Route::post('cart', [CartController::class, 'store'])->name('cart.store'); // confirm order
    Route::get('cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout'); // clear cart
});
