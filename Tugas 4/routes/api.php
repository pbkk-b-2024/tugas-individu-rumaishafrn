<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ObatController;
use App\Http\Controllers\API\KategoriObatController;
use App\Http\Controllers\API\StokObatController;
use App\Http\Controllers\API\LaporanStokController;
use App\Http\Controllers\API\TransaksiController;
use App\Http\Controllers\API\PembayaranController;
use App\Http\Controllers\API\LaporanPenjualanController;
use App\Http\Controllers\API\PenerimaanObatController;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'Halaman tidak ditemukan.',
        'code' => 404
    ], 404);
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::resource('kategori', KategoriObatController::class)->middleware('can:manage-obat');
    Route::resource('obat', ObatController::class);
    Route::resource('stok', StokObatController::class)->middleware('can:manage-stok');
    Route::resource('laporan_stok', LaporanStokController::class)->middleware('can:show-laporan');
    Route::resource('transaksi', TransaksiController::class)->middleware('can:manage-transaksi');
    Route::post('transaksi/{id}/bukti', [TransaksiController::class, 'bukti'])->middleware('can:manage-transaksi');
    Route::put('transaksi/{id}/confirm', [TransaksiController::class, 'confirm'])->middleware('can:confirm-transaksi');
    Route::put('transaksi/{id}/reject', [TransaksiController::class, 'reject'])->middleware('can:confirm-transaksi');
    Route::get('pembayaran/{id}', [PembayaranController::class, 'show'])->middleware('can:manage-transaksi');
    Route::resource('laporan_penjualan', LaporanPenjualanController::class)->middleware('can:show-laporan');
    Route::resource('penerimaan_obat', PenerimaanObatController::class)->middleware('can:penerimaan-obat');
});

Route::get('/obat', [ObatController::class, 'index']);
