<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;

// Halaman utama hanya bisa diakses jika sudah login
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/makanan', function () {
    return view('makanan');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/menu', [MenuController::class, 'index'])->name('order.menu');
    Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');
// Menu Routes (hanya bisa diakses jika sudah login)

Route::get('/order/makanan', [MenuController::class, 'makanan'])->name('makanan');
Route::get('/order/minuman', [MenuController::class, 'minuman'])->name('minuman');
Route::get('/order/cemilan', [MenuController::class, 'cemilan'])->name('cemilan');


// Views
Route::view('/auth/login', 'auth.login')->middleware('guest');