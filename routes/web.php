<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

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
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/', [ProductController::class, 'store'])->name('products.store');
    Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});

Route::prefix('images')->group(function () {
    Route::get('/', [ImageController::class, 'index'])->name('images.index');
    Route::get('/create', [ImageController::class, 'create'])->name('images.create');
    Route::post('/', [ImageController::class, 'store'])->name('images.store');
    Route::get('/{product}', [ImageController::class, 'show'])->name('images.show');
    Route::get('/edit/{product}', [ImageController::class, 'edit'])->name('images.edit');
    Route::put('/{product}', [ImageController::class, 'update'])->name('images.update');
    Route::delete('/{product}', [ImageController::class, 'destroy'])->name('images.destroy');
});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/{product}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/edit/{product}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/{product}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/{product}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

require __DIR__ . '/auth.php';
