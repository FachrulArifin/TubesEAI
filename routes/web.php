<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'homePage'])->name('homePage');

// Routes Login Controll
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showPageLogin'])->name('showLogin');
    Route::post('/login', [AuthController::class, 'loginAccount'])->name('loginAccount');
    Route::get('/register', [AuthController::class, 'showPageRegister'])->name('showRegister');
    Route::post('/register', [AuthController::class, 'createAccount'])->name('createAccount');
});


// Untuk admin
Route::middleware(['auth', 'CheckRole:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/addProduct', [AdminController::class, 'viewAddProduct'])->name('admin.viewAddProduct');
    Route::get('/admin/viewHistory', [AdminController::class, 'viewHistory'])->name('admin.viewHistory');
    Route::post('/admin/addProduct', [AdminController::class, 'addProduct'])->name('admin.addProduct');
    Route::get('/admin/addProducts', [AdminController::class, 'getProducts'])->name('admin.getProducts');
    Route::get('/admin/addProducts/{id}', [AdminController::class, 'getProductById'])->name('admin.getProductById');
    Route::delete('/admin/addProducts/{id}', [AdminController::class, 'deleteProduct'])->name('admin.deleteProduct');
    Route::put('/admin/addProducts/{id}', [AdminController::class, 'updateProduct'])->name('admin.updateProduct');
});


// Routes Order
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/checkout', [OrderController::class, 'checkout']);
    Route::get('/invoice/{id}', [OrderController::class, 'invoice']);
});
