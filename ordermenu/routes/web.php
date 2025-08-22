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
use App\Http\Controllers\MyDiscountController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\AdminBannerController;
use App\Http\Controllers\QrMenuController;
use App\Http\Controllers\AdminVoucherController;

Route::get('/', [WelcomeController::class, 'index'])->name('home');
Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/login-table', [AuthController::class, 'loginByQr'])->name('qr.login');
Route::get('/qr/{meja}', [AuthController::class, 'showQr'])->name('qr.view');
Route::get('/qr-menu', [QrMenuController::class, 'index'])->name('qr.menu');

Route::get('/loginAccount', [AuthController::class, 'showLogin'])->name('loginAccount');
Route::post('/loginAccount', [AuthController::class, 'login']);
Route::post('/logoutAccount', [AuthController::class, 'logout'])->name('logoutAccount')->middleware('auth');

Route::middleware(['auth', 'check.session'])->group(function () {
    Route::get('/menu', [MenuController::class, 'index'])->name('order.menu');
    Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.detail');
    Route::get('/menu/{id}/reviews', [ReviewController::class, 'show'])->name('menu.reviews');

    Route::get('/reviews/{id}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/riwayat/{id}', [ProfileController::class, 'show']);

    Route::get('/tukarpoin', [TukarPoinController::class, 'index'])->name('tukarpoin');
    Route::post('/tukarpoin', [TukarPoinController::class, 'store'])->name('tukarpoin.store');

    Route::get('/my-discount', [MyDiscountController::class, 'index'])->name('my-discount.index');

    Route::get('/order/makanan', [MenuController::class, 'makanan'])->name('makanan');
    Route::get('/order/minuman', [MenuController::class, 'minuman'])->name('minuman');
    Route::get('/order/cemilan', [MenuController::class, 'cemilan'])->name('cemilan');

    Route::post('/pesanan/add', [PesananController::class, 'add'])->name('pesanan.add');
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan');
    Route::post('/pesanan/submit', [PesananController::class, 'submit'])->name('pesanan.submit');
    Route::post('/pesanan/remove/{nama}', [PesananController::class, 'remove'])->name('pesanan.remove');
    Route::post('/pesanan/cancel/{id}', [PesananController::class, 'cancel'])->name('pesanan.cancel');

    Route::get('/menus', [MenuController::class, 'index']);
    Route::post('/tambah-pesanan', [MenuController::class, 'addToCart']);
    Route::get('/api/menus', [MenuController::class, 'apiMenus']);

    Route::get('/listOrder', [ListOrderController::class, 'index'])->name('dashboard');
    Route::get('/listOrder/waiting', [ListOrderController::class, 'showWaiting']);
    Route::get('/listOrder/process', [ListOrderController::class, 'showProcess'])->name('listOrder.process');
    Route::get('/listOrder/complete', [ListOrderController::class, 'showComplete'])->name('listOrder.complete');

    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('/create-accounts', [AccountController::class, 'create'])->name('create-accounts.index');
    Route::post('/create-accounts', [AccountController::class, 'store'])->name('create-accounts.store');
    Route::delete('/delete-account/{id}', [AccountController::class, 'destroy'])->name('delete-account');

    Route::get('admin/menu', [AdminMenuController::class, 'adminMenu'])->name('admin.menu');
    Route::get('admin/menu/create', [AdminMenuController::class, 'create'])->name('menu.create');
    Route::post('admin/menu', [AdminMenuController::class, 'store'])->name('menu.store');
    Route::get('admin/menu/{id}/edit', [AdminMenuController::class, 'edit'])->name('menu.edit');
    Route::put('admin/menu/{id}', [AdminMenuController::class, 'update'])->name('menu.update');
    Route::delete('admin/menu/{id}', [AdminMenuController::class, 'delete'])->name('menu.delete');
    Route::post('/menu/restock', [AdminMenuController::class, 'restock'])->name('menu.restock');

    Route::get('/admin/banner', [AdminBannerController::class, 'index'])->name('admin.banner');
    Route::post('/admin/banner/save', [AdminBannerController::class, 'storeOrUpdate'])->name('admin.banner.save');
    Route::post('/admin/banner/clear/{id}', [AdminBannerController::class, 'clear'])->name('admin.banner.clear');

    Route::get('/order-detail/{id}', [DetailPesananController::class, 'show'])->name('order.detail');
    Route::patch('/orders/{order}/status', [DetailPesananController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/orders/{order}', [ListOrderController::class, 'destroy'])->name('orders.destroy');
    Route::delete('/orders/{order}/done', [DetailPesananController::class, 'done'])->name('orders.done');
    
    Route::get('/rekap-penjualan', [RekapController::class, 'grafikPenjualan'])->name('rekap.penjualan');
});

Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
Route::get('/galeri/create', [GaleriController::class, 'create']);
Route::post('/galeri/store', [GaleriController::class, 'store'])->name('galeri.store');
Route::delete('/galeri/{id}', [GaleriController::class, 'destroy'])->name('galeri.destroy');

Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
