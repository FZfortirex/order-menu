<?php

use App\Http\Middleware\AuthenticateUser;
use App\Http\Middleware\DetectDevice;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WaiterController;

// Halaman utama (Login page)
Route::get('/', function () {
    return redirect()->route('loginAccount'); // Redirect ke halaman login custom
})->name('home');

// Authentication Routes (Tanpa middleware 'guest')
Route::get('/loginAccount', [AuthController::class, 'showLogin'])->name('loginAccount');
Route::post('/loginAccount', [AuthController::class, 'login']);

// Logout Route
Route::post('/logoutAccount', [AuthController::class, 'logout'])->name('logoutAccount')->middleware('auth');

// Middleware auth untuk halaman yang membutuhkan login
Route::middleware(['auth'])->group(function () {
    Route::get('/welcome', function () {
        return view('welcome');
    })->middleware('verified')->name('welcome');
});

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

// Import tambahan
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
