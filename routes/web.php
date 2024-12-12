<?php

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


// Routes Order
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/checkout', [OrderController::class, 'checkout']);
    Route::get('/invoice/{id}', [OrderController::class, 'invoice']);
});
