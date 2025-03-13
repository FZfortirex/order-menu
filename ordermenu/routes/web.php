<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;

// Halaman utama (Login page)
Route::get('/', function () {
    return view('auth.login'); // Redirect ke halaman login
})->name('home');

// Halaman welcome setelah login
Route::get('/welcome', function () {
    return view('welcome');
})->middleware('auth')->name('welcome');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Middleware auth untuk halaman yang membutuhkan login
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard'); // Blade template untuk dashboard
    })->middleware('verified')->name('dashboard');

    // Menu Routes
    Route::get('/menu', [MenuController::class, 'index'])->name('order.menu');
    Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');
});

// View login
Route::view('/auth/login', 'auth.login')->middleware('guest');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
