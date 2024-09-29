<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\KategoriObatController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\StokObatController;
use App\Http\Controllers\LaporanStokController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\PenerimaanObatController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index'])->name('home');

Route::fallback(function () {
    return abort(404);
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [MainController::class, 'login'])->name('login');
    Route::post('/login', [MainController::class, 'doLogin']);
    Route::get('/register', [MainController::class, 'register'])->name('register');
    Route::post('/register', [MainController::class, 'doRegister']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [MainController::class, 'logout'])->name('logout');

    Route::resource('kategori', KategoriObatController::class)->middleware('can:manage-obat');
    Route::resource('obat', ObatController::class)->middleware('can:manage-obat');
    Route::resource('stok', StokObatController::class)->middleware('can:manage-stok');
    Route::resource('laporan_stok', LaporanStokController::class)->middleware('can:show-laporan');
    Route::resource('transaksi', TransaksiController::class)->middleware('can:manage-transaksi');
    Route::post('transaksi/{transaksi}/bukti', [TransaksiController::class, 'bukti'])->name('transaksi.bukti')->middleware('can:manage-transaksi');
    Route::get('transaksi/{transaksi}/confirm', [TransaksiController::class, 'confirm'])->name('transaksi.confirm')->middleware('can:confirm-transaksi');
    Route::get('transaksi/{transaksi}/reject', [TransaksiController::class, 'reject'])->name('transaksi.reject')->middleware('can:confirm-transaksi');
    Route::resource('laporan_penjualan', LaporanPenjualanController::class)->middleware('can:show-laporan');
    Route::resource('penerimaan_obat', PenerimaanObatController::class)->middleware('can:penerimaan-obat');
});
Route::get('/obat', [ObatController::class, 'index'])->name('obat.index');

Route::get('api/scheme', [MainController::class, 'apiScheme'])->name('api.scheme');
