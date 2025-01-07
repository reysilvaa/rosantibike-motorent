<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InvoiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminBookingController;
use App\Http\Controllers\Api\AdminTransaksiController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\JenisMotorController;
use App\Http\Controllers\Api\NotificationController;

// Endpoint notifikasi tetap terbuka
Route::post('/send-notification', [NotificationController::class, 'sendNotification']);

// Endpoint invoice tetap terbuka
Route::get('invoice/preview/{type}/{id}', [InvoiceController::class, 'previewInvoice']);
Route::get('invoice/download/{type}/{id}', [InvoiceController::class, 'downloadInvoice']);

// Endpoint Admin Booking dengan proteksi JWT
Route::middleware(['auth:api', 'throttle:1000,1'])->prefix('admin/booking')->group(function () {
    Route::get('/', [AdminBookingController::class, 'index']);
    Route::get('/list', [AdminBookingController::class, 'bookings']);
    Route::get('/{id}', [AdminBookingController::class, 'show']);
    Route::put('/{id}', [AdminBookingController::class, 'update']);
    Route::delete('/{id}', [AdminBookingController::class, 'destroy']);
    Route::post('/bulk-delete', [AdminBookingController::class, 'bulkDelete']);
});

// Endpoint Admin Transaksi dengan proteksi JWT
Route::middleware(['auth:api', 'throttle:1000,1'])->prefix('admin/transaksi')->group(function () {
    Route::get('/', [AdminTransaksiController::class, 'index']);
    Route::get('/{id}', [AdminTransaksiController::class, 'show']);
    Route::post('/update/{id}', [AdminTransaksiController::class, 'update']);
    Route::delete('/delete/{id}', [AdminTransaksiController::class, 'destroy']);
    Route::post('/bulk-delete', [AdminTransaksiController::class, 'bulkDelete']);
    Route::get('/datatable', [AdminTransaksiController::class, 'getData']);
});

// Endpoint Jenis Motor dengan proteksi JWT
Route::middleware(['auth:api', 'throttle:1000,1'])->apiResource('admin/jenis-motor', JenisMotorController::class);

// Endpoint Transaksi dengan proteksi JWT
Route::middleware(['throttle:1000,1'])->prefix('transaksi')->group(function () {
    Route::get('/', [TransaksiController::class, 'index']);
    Route::post('/create', [TransaksiController::class, 'create']);
    Route::post('/store', [TransaksiController::class, 'store']);
    Route::post('/check-booking-dates', [TransaksiController::class, 'checkBookingDates']);
});


// Endpoint login, logout, dan profil
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::get('me', [AuthController::class, 'me'])->middleware('auth:api');
