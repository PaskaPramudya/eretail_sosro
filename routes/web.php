<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EretailController;
use App\Http\Controllers\AuthController;

// Rute Pelanggan
Route::get('/', [ProductController::class, 'index'])->name('pelanggan.index');
Route::get('/pelanggan', [ProductController::class, 'index'])->name('pelanggan');

// Rute Otentikasi (Login, Daftar, Logout)
Route::post('/proses-login', [AuthController::class, 'prosesLogin'])->name('proses.login');
Route::post('/proses-daftar', [AuthController::class, 'prosesDaftar'])->name('proses.daftar');
Route::post('/proses-admin-login', [AuthController::class, 'prosesAdminLogin'])->name('proses.admin.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Pemesanan Pelanggan
Route::post('/proses-pesan', [OrderController::class, 'prosesPesan'])->name('proses.pesan');
Route::get('/order/{id}', [OrderController::class, 'create'])->name('order.create');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

// Rute Admin
Route::prefix('admin')->group(function () {
    // URL: http://127.0.0.1:8000/admin
    Route::get('/', [ProductController::class, 'adminIndex'])->name('admin');
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('admin.products');
    
    // Aksi Manajemen Produk Admin
    Route::post('/tambah', [ProductController::class, 'store'])->name('admin.products.store');
    Route::post('/update-stok', [ProductController::class, 'updateStok'])->name('admin.products.updateStok');
    Route::post('/edit-gambar', [ProductController::class, 'editGambar'])->name('admin.products.editGambar');
    Route::get('/hapus/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    // Pesanan Admin
    Route::get('/orders', [OrderController::class, 'adminOrders'])->name('admin.orders');
});