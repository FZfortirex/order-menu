<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;

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

    // Menu Routes
    Route::get('/menu', [MenuController::class, 'index'])->name('order.menu');
    Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');
});

// Import tambahan
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
