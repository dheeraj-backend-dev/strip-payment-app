<?php

use App\Http\Controllers\{
    CartController,
    PaymentController,
    ProfileController,
    ProductController
};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/products', ProductController::class);

    // Cart route
    Route::get('/carts', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('products.addToCart');

    // Payment route
    Route::post('/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payment/success/{user}', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/cancel/{user}', [PaymentController::class, 'cancel'])->name('payment.cancel');
});

require __DIR__ . '/auth.php';
