<?php

use App\Http\Middleware\AuthenticateUser;
use App\Http\Middleware\DetectDevice;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WaiterController;

Route::get('/login', function () {
    return view(view()->shared('isMobile') ? 'auth.login-mobile' : 'auth.login-desktop');
})->name('login')->middleware('guest');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/welcome', function () {
    return view(view()->shared('isMobile') ? 'welcome-mobile' : 'welcome-desktop');
})->name('welcome'); // Hapus middleware dulu

Route::get('/kontak', function () {
    return view(view()->shared('isMobile') ? 'user.kontak-mobile' : 'user.kontak-desktop');
})->name('kontak'); // Pastikan nama route didefinisikan di sini


// Middleware untuk halaman setelah login
Route::middleware([AuthenticateUser::class, DetectDevice::class])->group(function () {

    // Order Routes
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');

    // Waiter Routes
    Route::get('/waiter', [WaiterController::class, 'index'])->name('waiter.index');
    Route::post('/waiter/update/{id}', [WaiterController::class, 'update'])->name('waiter.update');
});
