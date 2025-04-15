<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WaiterController;
use App\Http\Middleware\AuthenticateUser;
use App\Http\Middleware\DetectDevice;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\ProfileController;

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

Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
Route::get('/galeri/create', [GaleriController::class, 'create']);
Route::post('/galeri/store', [GaleriController::class, 'store'])->name('galeri.store');
Route::delete('/galeri/{id}', [GaleriController::class, 'destroy'])->name('galeri.destroy');

Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

// Menu Routes
Route::get('/menu', [MenuController::class, 'index'])->name('order.menu');
Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');

Route::get('/order/makanan', [MenuController::class, 'makanan'])->name('makanan');
Route::get('/order/minuman', [MenuController::class, 'minuman'])->name('minuman');
Route::get('/order/cemilan', [MenuController::class, 'cemilan'])->name('cemilan');

Route::post('/tambah-pesanan', [PesananController::class, 'tambah'])->name('tambah.pesanan');
Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan');
Route::post('/pesanan/submit', [PesananController::class, 'submit'])->name('pesanan.submit');
Route::post('/pesanan/remove/{nama}', [PesananController::class, 'remove'])->name('pesanan.remove');

Route::get('/menus', [MenuController::class, 'index']);
Route::post('/tambah-pesanan', [MenuController::class, 'addToCart']);
Route::get('/api/menus', [MenuController::class, 'apiMenus']);



// Import tambahan
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
