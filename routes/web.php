<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| 1. AUTENTIKASI (Mitra, Admin, Staff)
|--------------------------------------------------------------------------
*/
Route::post('/proses-login', [AuthController::class, 'prosesLogin'])->name('proses.login');
Route::post('/proses-daftar', [AuthController::class, 'prosesDaftar'])->name('proses.daftar');
Route::post('/proses-admin-login', [AuthController::class, 'prosesAdminLogin'])->name('proses.admin.login');
Route::post('/admin/tambah', [ProductController::class, 'store']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 2. AKTOR: MITRA E-RETAIL (PELANGGAN)
|--------------------------------------------------------------------------
*/
Route::get('/', [ProductController::class, 'index'])->name('pelanggan.index');
Route::get('/pelanggan', [ProductController::class, 'index'])->name('pelanggan');

// Pemesanan Online
Route::post('/proses-pesan', [OrderController::class, 'prosesPesan'])->name('proses.pesan');
Route::get('/faktur/{id}', [OrderController::class, 'fakturPenjualan'])->name('pelanggan.faktur');
Route::get('/tracking/{id}', [OrderController::class, 'trackingPengiriman'])->name('pelanggan.tracking');

/*
|--------------------------------------------------------------------------
| 3. AKTOR: ADMIN DISTRIBUTOR
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/', [ProductController::class, 'adminIndex'])->name('admin');
    
    // Kelola Produk & Inventaris
    Route::post('/tambah', [ProductController::class, 'store'])->name('admin.products.store');
    Route::post('/update-stok', [ProductController::class, 'updateStok'])->name('admin.products.updateStok');
    Route::post('/edit-gambar', [ProductController::class, 'editGambar'])->name('admin.products.editGambar');
    Route::get('/hapus/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    // Kelola Data Mitra
    Route::get('/mitra', [MitraController::class, 'index'])->name('admin.mitra.index');
    Route::post('/mitra/tambah', [MitraController::class, 'store'])->name('admin.mitra.store');
    Route::get('/mitra/hapus/{id}', [MitraController::class, 'destroy'])->name('admin.mitra.destroy');

    // Laporan & Verifikasi Pembayaran
    Route::get('/verifikasi/{id}', [OrderController::class, 'verifikasiPembayaran'])->name('admin.verifikasi');
    Route::get('/laporan', [ReportController::class, 'laporanPenjualan'])->name('admin.laporan');
});

/*
|--------------------------------------------------------------------------
| 4. AKTOR: STAFF DISTRIBUTOR
|--------------------------------------------------------------------------
*/
Route::prefix('staff')->group(function () {
    Route::get('/penjualan', [StaffController::class, 'kelolaPenjualan'])->name('staff.penjualan');
    Route::post('/proses-pesanan/{id}', [StaffController::class, 'prosesPesanan'])->name('staff.proses');
    Route::post('/atur-pengiriman/{id}', [StaffController::class, 'aturPengiriman'])->name('staff.pengiriman');
    Route::get('/verifikasi/{id}', [OrderController::class, 'verifikasiPembayaran'])->name('staff.verifikasi');
    Route::get('/laporan', [ReportController::class, 'laporanPenjualan'])->name('staff.laporan');
});