<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WaiterController;
use App\Http\Middleware\AuthenticateUser;
use App\Http\Middleware\DetectDevice;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\WelcomeController;

// Halaman Utama (Redirect ke login)
Route::get('/', function () {
    return redirect()->route('loginAccount');
})->name('home');

// Authentication Routes (Menggunakan versi temanmu)
Route::get('/loginAccount', [AuthController::class, 'showLogin'])->name('loginAccount');
Route::post('/loginAccount', [AuthController::class, 'login']);
Route::post('/logoutAccount', [AuthController::class, 'logout'])->name('logoutAccount')->middleware('auth');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');
});

Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');

// Middleware untuk halaman setelah login
Route::middleware([AuthenticateUser::class, DetectDevice::class, 'auth'])->group(function () {

    // Order Routes
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');

    // Menu Routes
    Route::get('/menu', [MenuController::class, 'index'])->name('order.menu');
    Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');

    // Waiter Routes
    Route::get('/waiter', [WaiterController::class, 'index'])->name('waiter.index');
    Route::post('/waiter/update/{id}', [WaiterController::class, 'update'])->name('waiter.update');
});

// Import tambahan
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
