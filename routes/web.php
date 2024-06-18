<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

Route::get('/', [ProductController::class, 'index'])->name('products.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/category/{categorySlug}', [ProductController::class, 'category'])->name('products.category');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create')->middleware(['auth', 'isAdmin']);
    Route::post('/', [ProductController::class, 'store'])->name('products.store')->middleware(['auth', 'isAdmin']);;
    Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('products.edit')->middleware(['auth', 'isAdmin']);;
    Route::put('/{product}', [ProductController::class, 'update'])->name('products.update')->middleware(['auth', 'isAdmin']);;
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware(['auth', 'isAdmin']);;
});

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(['auth']);
    Route::get('/products', [DashboardController::class, 'products'])->name('dashboard.products')->middleware(['auth', 'isAdmin']);
    Route::get('/categories', [DashboardController::class, 'categories'])->name('dashboard.categories')->middleware(['auth', 'isAdmin']);
    Route::get('/orders', [DashboardController::class, 'orders'])->name('dashboard.orders')->middleware(['auth']);
    Route::get('/orders-all', [DashboardController::class, 'orders_all'])->name('dashboard.allOrders')->middleware(['auth', 'isAdmin']);
});

Route::prefix('categories')->group(function () {
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
})->middleware(['auth', 'isAdmin']);


Route::prefix('cart')->group(
    function () {
        Route::post('/add', [CartController::class, 'add'])->name('cart.add');
        Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
    }
);

Route::prefix('orders')->group(
    function () {
        Route::get('/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');
    }
);
require __DIR__ . '/auth.php';
