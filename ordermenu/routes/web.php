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
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TukarPoinController;
use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\ListOrderController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DetailPesananController;

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

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

// Menu Routes
Route::get('/menu', [MenuController::class, 'index'])->name('order.menu');
Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.detail');
Route::get('/menu/{id}/reviews', [ReviewController::class, 'show'])->name('menu.reviews');

Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews/{id}', [ReviewController::class, 'show'])->name('reviews.show');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/tukarpoin', [TukarPoinController::class, 'index'])->name('tukarpoin');

// Menu Routes
Route::get('/menu', [MenuController::class, 'index'])->name('order.menu');
Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.detail');

Route::get('/order/makanan', [MenuController::class, 'makanan'])->name('makanan');
Route::get('/order/minuman', [MenuController::class, 'minuman'])->name('minuman');
Route::get('/order/cemilan', [MenuController::class, 'cemilan'])->name('cemilan');

Route::middleware('auth')->group(function () {
    Route::post('/pesanan/add', [PesananController::class, 'add'])->name('pesanan.add');
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan');
    Route::post('/pesanan/submit', [PesananController::class, 'submit'])->name('pesanan.submit');
    Route::post('/pesanan/remove/{nama}', [PesananController::class, 'remove'])->name('pesanan.remove');
    Route::post('/pesanan/cancel/{id}', [PesananController::class, 'cancel'])->name('pesanan.cancel');
});

Route::get('/menus', [MenuController::class, 'index']);
Route::post('/tambah-pesanan', [MenuController::class, 'addToCart']);
Route::get('/api/menus', [MenuController::class, 'apiMenus']);

// Dashboard route TANPA middleware auth
Route::get('/listOrder', [ListOrderController::class, 'index'])->name('dashboard');
Route::get('/listOrder/waiting', [ListOrderController::class, 'showWaiting']);
Route::get('/listOrder/process', [ListOrderController::class, 'showProcess'])->name('listOrder.process');
Route::get('/listOrder/complete', [ListOrderController::class, 'showComplete'])->name('listOrder.complete');

Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');

Route::get('/order-detail/{id}', [DetailPesananController::class, 'show'])->name('order.detail');
Route::patch('/orders/{order}/status', [DetailPesananController::class, 'updateStatus'])->name('orders.updateStatus');
Route::delete('/orders/{order}', [ListOrderController::class, 'destroy'])->name('orders.destroy');
Route::delete('/orders/{order}/done', [DetailPesananController::class, 'done'])->name('orders.done');

Route::get('/create-accounts', [AccountController::class, 'create'])->name('create-accounts.index');
Route::post('/create-accounts', [AccountController::class, 'store'])->name('create-accounts.store');
Route::delete('/delete-account/{id}', [AccountController::class, 'destroy'])->name('delete-account');





// Import tambahan
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';