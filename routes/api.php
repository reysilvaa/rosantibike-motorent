<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminBookingController;
use App\Http\Controllers\Api\AdminTransaksiController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\JenisMotorController;


Route::get('invoice/preview/{type}/{id}', [InvoiceController::class, 'previewInvoice']);
Route::get('invoice/download/{type}/{id}', [InvoiceController::class, 'downloadInvoice']);

Route::middleware('throttle:1000,1')->prefix('admin/booking')->group(function () {
    Route::get('/', [AdminBookingController::class, 'index']);
    Route::get('/list', [AdminBookingController::class, 'bookings']);
    Route::get('/{id}', [AdminBookingController::class, 'show']);
    Route::put('/{id}', [AdminBookingController::class, 'update']);
    Route::delete('/{id}', [AdminBookingController::class, 'destroy']);
    Route::post('/bulk-delete', [AdminBookingController::class, 'bulkDelete']);
});

Route::middleware('throttle:1000,1')->prefix('admin/transaksi')->group(function () {
    Route::get('/', [AdminTransaksiController::class, 'index']);
    Route::get('/{id}', [AdminTransaksiController::class, 'show']);
    Route::post('/update/{id}', [AdminTransaksiController::class, 'update']);
    Route::delete('/delete/{id}', [AdminTransaksiController::class, 'destroy']);
    Route::post('/bulk-delete', [AdminTransaksiController::class, 'bulkDelete']);
    Route::get('/datatable', [AdminTransaksiController::class, 'getData']);
});

Route::middleware('throttle:1000,1')->apiResource('admin/jenis-motor', JenisMotorController::class);

Route::middleware('throttle:1000,1')->prefix('transaksi')->group(function () {
    Route::get('/', [TransaksiController::class, 'index']);
    Route::post('/create', [TransaksiController::class, 'create']);
    Route::post('/store', [TransaksiController::class, 'store']);
    Route::post('/check-booking-dates', [TransaksiController::class, 'checkBookingDates']);
});

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::get('me', [AuthController::class, 'me']);
