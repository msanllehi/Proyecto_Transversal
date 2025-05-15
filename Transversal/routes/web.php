<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
});

Route::get('/location', function () {
    return view('location');
});

Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\AuthController::class, 'verify'])->name('verification.verify');

Route::get('/services', function () {
    $products = \App\Models\Product::all();
    return view('services', ['products' => $products]);
})->name('services');

Route::get('/products/{product}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::post('/products/{product}/opinions', [\App\Http\Controllers\OpinionController::class, 'store'])->name('products.opinions.store');

Route::get('/contact', function () {
    return view('contact');
});

Route::post('/contact', [App\Http\Controllers\ContactController::class, 'submitForm'])->name('contact.submit');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

// Rutas de checkout
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/confirmation/{order}', [App\Http\Controllers\CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
    
    // Rutas de facturas
    Route::get('/invoice/{order}/download', [App\Http\Controllers\InvoiceController::class, 'download'])->name('invoice.download');
    Route::get('/invoice/{order}/preview', [App\Http\Controllers\InvoiceController::class, 'preview'])->name('invoice.preview');
    
    // Rutas de pedidos
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    
    // Rutas para sistema de comentarios
    Route::get('/comment-reminders', [App\Http\Controllers\OrderController::class, 'getCommentReminders'])->name('comment-reminders');
    Route::post('/comment-reminders/{orderItem}/decision', [App\Http\Controllers\OrderController::class, 'commentDecision'])->name('comment-reminders.decision');
});

Route::get('/legal', function () {
    return view('legal');
});

Route::get('/cookies', function () {
    return view('cookies');
});

Route::get('/terms', function () {
    return view('terms');
});

Route::get('/privacy', function () {
    return view('privacy');
});

require __DIR__.'/roles.php';