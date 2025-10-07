<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ProductController; // public catalog (your existing one)
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AccountController;

// Admin controllers for the panel
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\OrderAdminController;

// ---------- Public ----------
Route::get('/', [HomeController::class, 'index'])->name('home'); // ✅ only ONE home route
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// ---------- Auth ----------
Route::middleware(['auth'])->group(function () {

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/item/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/item/{item}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

    // Dashboard → send admins to /admin, customers to /account
    Route::get('/dashboard', function () {
        return auth()->user()->can('admin')
            ? redirect()->route('admin.dashboard')
            : redirect()->route('account.index');
    })->middleware(['verified'])->name('dashboard');

    // Customer panel
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');

    // Cancel order (PATCH so we can update status)
    Route::patch('/account/orders/{order}/cancel', [AccountController::class, 'cancel'])
        ->name('account.orders.cancel');
});

// ---------- Admin (auth + can:admin) ----------
Route::middleware(['auth', 'can:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard (simple view)
        Route::view('/', 'admin.dashboard')->name('dashboard');

        // Products CRUD
        Route::get('/products', [ProductAdminController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductAdminController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductAdminController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductAdminController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductAdminController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductAdminController::class, 'destroy'])->name('products.destroy');

        // Orders management
        Route::get('/orders', [OrderAdminController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderAdminController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [OrderAdminController::class, 'updateStatus'])->name('orders.status');
        Route::patch('/orders/{order}/cancel', [OrderAdminController::class, 'cancel'])->name('orders.cancel');
        
            Route::get('/dashboard', function () {
    return auth()->user()->can('admin')
        ? redirect()->route('admin.dashboard')
        : redirect()->route('account.index');
})->middleware(['auth','verified'])->name('dashboard');

    
    });

