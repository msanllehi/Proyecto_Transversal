<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;

// ...rutes públiques existents...

// Rutes d'administració (només admin)
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Rutas de productos
    Route::resource('products', ProductController::class);

    Route::get('/get-subcategories', [ProductController::class, 'getSubcategories'])->name('get-subcategories');
    
    // Rutas de categorías
    Route::resource('categories', CategoryController::class);
    
    // Rutas de subcategorías
    Route::resource('subcategories', SubcategoryController::class);
    Route::post('/subcategories/{subcategory}/change-category', [SubcategoryController::class, 'changeCategory'])->name('subcategories.change-category');
    
    // Rutas de usuarios y pedidos
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::put('/orders/{order}', [AdminController::class, 'updateOrder'])->name('orders.update');
    Route::delete('/orders/{order}', [AdminController::class, 'destroyOrder'])->name('orders.destroy');
    
    // Rutas de ventas
    Route::get('/sales', [AdminController::class, 'sales'])->name('sales');
    Route::post('/sales/apply-discount', [AdminController::class, 'applyDiscount'])->name('sales.apply-discount');
});

// Rutes de client (autenticat)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::resource('products', ProductController::class)->only(['index', 'show']);
});
