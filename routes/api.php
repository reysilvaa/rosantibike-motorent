<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminBookingController;
use App\Http\Controllers\Api\AdminTransaksiController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\JenisMotorController;

Route::prefix('admin/booking')->group(function () {
    Route::get('/', [AdminBookingController::class, 'index']);
    Route::get('/list', [AdminBookingController::class, 'bookings']);
    Route::get('/{id}', [AdminBookingController::class, 'show']);
    Route::put('/{id}', [AdminBookingController::class, 'update']);
    Route::delete('/{id}', [AdminBookingController::class, 'destroy']);
    Route::post('/bulk-delete', [AdminBookingController::class, 'bulkDelete']);
});

Route::prefix('admin/transaksi')->group(function () {
    Route::get('/', [AdminTransaksiController::class, 'index']); // Endpoint untuk mengambil semua data transaksi
    Route::get('/{id}', [AdminTransaksiController::class, 'show']); // Endpoint untuk detail transaksi
    Route::post('/update/{id}', [AdminTransaksiController::class, 'update']); // Endpoint untuk memperbarui transaksi
    Route::delete('/delete/{id}', [AdminTransaksiController::class, 'destroy']); // Endpoint untuk menghapus transaksi
    Route::post('/bulk-delete', [AdminTransaksiController::class, 'bulkDelete']); // Endpoint untuk menghapus banyak transaksi
    Route::get('/datatable', [AdminTransaksiController::class, 'getData']); // Endpoint untuk DataTables
});

Route::apiResource('admin/jenis-motor', JenisMotorController::class);

Route::prefix('transaksi')->group(function () {
    Route::get('/', [TransaksiController::class, 'index']); // GET /api/transaksi
    Route::post('/create', [TransaksiController::class, 'create']); // POST /api/transaksi/create
    Route::post('/store', [TransaksiController::class, 'store']); // POST /api/transaksi/store
    Route::post('/check-booking-dates', [TransaksiController::class, 'checkBookingDates']); // POST /api/transaksi/check-booking-dates
});



Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::get('me', [AuthController::class, 'me']);

// Route::post('/login', [AuthController::class, 'login']);
