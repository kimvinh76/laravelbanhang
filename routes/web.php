<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

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

// Customer Routes
Route::get('/', [HomeController::class, 'index'])->name('homes');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'sendContact'])->name('contact.send');

// Product Routes for Customers
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::get('/category/{id}', [ProductController::class, 'category'])->name('category');
    Route::get('/{id}', [ProductController::class, 'show'])->name('show');
});

// Category Routes
Route::get('/categories', [HomeController::class, 'categories'])->name('categories');
Route::get('/category/{id}', [ProductController::class, 'category'])->name('category');

// API Routes for AJAX
Route::prefix('api')->group(function () {
    Route::get('/products/search', [ProductController::class, 'search']);
});

// Admin Routes (Protected)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [SanPhamController::class, 'index'])->name('sanpham.index');
    Route::get('/sanpham/create', [SanPhamController::class, 'create'])->name('sanpham.create');
    Route::post('/sanpham', [SanPhamController::class, 'store'])->name('sanpham.store');
    Route::get('/sanpham/{id}/edit', [SanPhamController::class, 'edit'])->name('sanpham.edit');
    Route::get('/sanpham/{id}', [SanPhamController::class, 'show'])->name('sanpham.show');
    Route::put('/sanpham/{id}', [SanPhamController::class, 'update'])->name('sanpham.update');
    Route::delete('/sanpham/{id}', [SanPhamController::class, 'destroy'])->name('sanpham.destroy');
});

// Direct Admin Routes (without prefix for backward compatibility)
Route::get('/sanpham', [SanPhamController::class, 'index'])->name('sanpham.index');
Route::get('/sanpham/create', [SanPhamController::class, 'create'])->name('sanpham.create');
Route::post('/sanpham', [SanPhamController::class, 'store'])->name('sanpham.store');
Route::get('/sanpham/{id}/edit', [SanPhamController::class, 'edit'])->name('sanpham.edit');
Route::get('/sanpham/{id}', [SanPhamController::class, 'show'])->name('sanpham.show');
Route::put('/sanpham/{id}', [SanPhamController::class, 'update'])->name('sanpham.update');
Route::delete('/sanpham/{id}', [SanPhamController::class, 'destroy'])->name('sanpham.destroy');
