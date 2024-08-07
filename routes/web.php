<?php

use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AdminTransaksiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JenisMotorController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WipeDataController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Landing routes
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return (new LandingController)->index();
})->name('landing');

// Landing Component
Route::get('/motor-matic', [LandingController::class, 'motorMatic'])->name('landing.motor-matic');
Route::get('/motor-manual', [LandingController::class, 'motorManual'])->name('landing.motor-manual');
Route::get('/faq', [LandingController::class, 'faq'])->name('landing.faqs');
Route::get('/petualangan', [LandingController::class, 'galeri'])->name('landing.galeri');
Route::get('/testimoni', [LandingController::class, 'testimoni'])->name('landing.testimoni');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Transaction Routes
Route::prefix('transaksi')->name('transaksi.')->group(function () {
    // Transaction Routes
    Route::get('/', [TransaksiController::class, 'index'])->name('index');
    Route::post('/store', [TransaksiController::class, 'store'])->name('store');
    Route::get('/check-booking-dates', [TransaksiController::class, 'checkBookingDates'])->name('checkBookingDates');
    Route::get('/get-available-stock', [TransaksiController::class, 'getAvailableStock'])->name('getAvailableStock');
    // Route::get('/check-booking-dates', [TransaksiController::class, 'checkBookingDates'])->name('checkBookingDates');

    // Invoice Routes for Transaksi
    Route::prefix('invoice/transaksi')->name('invoice.')->group(function () {
        Route::get('{id}/preview', [InvoiceController::class, 'previewInvoice'])->name('preview');
        Route::get('{id}/download', [InvoiceController::class, 'downloadInvoice'])->name('download');
        Route::get('{id}/english/preview', [InvoiceController::class, 'previewInvoiceEnglish'])->name('EnglishPreview');
        Route::get('{id}/english/download', [InvoiceController::class, 'downloadInvoiceEnglish'])->name('EnglishDownload');
    });

    // Invoice Routes for Booking
    Route::prefix('invoice/booking')->name('invoice.booking.')->group(function () {
        Route::get('{id}/preview', [InvoiceController::class, 'previewInvoiceBooking'])->name('preview');
        Route::get('{id}/download', [InvoiceController::class, 'downloadInvoiceBooking'])->name('download');
    });
});

// In your web.php (or routes file)
Route::post('/transaksi/available-stock', [TransaksiController::class, 'getAvailableStock']);

// Admin Routes
Route::get('/send-reminder/{id}', [EmailController::class, 'sendReminder'])->name('send.reminder');
Route::middleware(['auth'])->group(function () {
    // Admin dashboard
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminTransaksiController::class, 'index'])->name('dashboard');

        // Rating Routes
        Route::prefix('rating')->name('admin.rating.')->group(function () {
            Route::get('/', [RatingController::class, 'index'])->name('index');
            Route::get('create', [RatingController::class, 'create'])->name('create');
            Route::post('/', [RatingController::class, 'store'])->name('store');
            Route::get('{id}', [RatingController::class, 'show'])->name('show');
            Route::get('{id}/edit', [RatingController::class, 'edit'])->name('edit');
            Route::put('{id}', [RatingController::class, 'update'])->name('update');
            Route::delete('{id}', [RatingController::class, 'destroy'])->name('destroy');
        });
        // Galeri resource routes
        Route::prefix('galeri')->name('admin.galeri.')->group(function () {
            Route::get('/', [GaleriController::class, 'index'])->name('index');
            Route::get('create', [GaleriController::class, 'create'])->name('create');
            Route::post('/', [GaleriController::class, 'store'])->name('store');
            Route::get('{galeri}', [GaleriController::class, 'show'])->name('show');
            Route::get('{galeri}/edit', [GaleriController::class, 'edit'])->name('edit');
            Route::put('{galeri}', [GaleriController::class, 'update'])->name('update');
            Route::delete('{galeri}', [GaleriController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('booking')->name('admin.booking.')->group(function () {
            // Data tables
            Route::get('/data', [AdminBookingController::class, 'getData'])->name('data');

            // Booking CRUD routes
            Route::get('/', [AdminBookingController::class, 'booking'])->name('index');
            Route::get('/{booking}', [AdminBookingController::class, 'show'])->name('show');
            Route::get('/{booking}/edit', [AdminBookingController::class, 'edit'])->name('edit');
            Route::put('/{booking}', [AdminBookingController::class, 'update'])->name('update');
            Route::delete('/{booking}', [AdminBookingController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-delete', [AdminBookingController::class, 'bulkDelete'])->name('bulkDelete');
        });

        // Transaksi routes
        Route::prefix('transaksi')->name('admin.transaksi.')->group(function () {
            // Data tables
            Route::get('/data', [AdminTransaksiController::class, 'getData'])->name('data');

            // Transaksi CRUD routes
            Route::get('/', [AdminTransaksiController::class, 'transaksi'])->name('index');
            Route::get('/{transaksi}', [AdminTransaksiController::class, 'show'])->name('show');
            Route::get('/{transaksi}/edit', [AdminTransaksiController::class, 'edit'])->name('edit');
            Route::put('/{transaksi}', [AdminTransaksiController::class, 'update'])->name('update');
            Route::delete('/{transaksi}', [AdminTransaksiController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-delete', [AdminTransaksiController::class, 'bulkDelete'])->name('bulkDelete');
        });

        // Jenis Motor routes
        Route::prefix('jenis-motor')->name('admin.jenisMotor.')->group(function () {
            Route::get('/', [JenisMotorController::class, 'index'])->name('index');
            Route::get('/create', [JenisMotorController::class, 'create'])->name('create');
            Route::post('/', [JenisMotorController::class, 'store'])->name('store');
            Route::get('/{jenisMotor}', [JenisMotorController::class, 'show'])->name('show');
            Route::get('/{jenisMotor}/edit', [JenisMotorController::class, 'edit'])->name('edit');
            Route::put('/{jenisMotor}', [JenisMotorController::class, 'update'])->name('update');
            Route::delete('/{jenisMotor}', [JenisMotorController::class, 'destroy'])->name('destroy');
        });

        // Wipe Data routes
        Route::prefix('wipe-data')->name('admin.wipe.')->group(function () {
            Route::get('/', [WipeDataController::class, 'index'])->name('index');
            Route::post('/wipe', [WipeDataController::class, 'wipe'])->name('wipe');
        });

        // User routes
        Route::prefix('user')->name('admin.users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('stok')->name('admin.stok.')->group(function () {
            Route::get('/', [StokController::class, 'index'])->name('index');
            Route::get('/create', [StokController::class, 'create'])->name('create');
            Route::post('/', [StokController::class, 'store'])->name('store');
            Route::get('/{stok}', [StokController::class, 'show'])->name('show');
            Route::get('/{stok}/edit', [StokController::class, 'edit'])->name('edit');
            Route::put('/{stok}', [StokController::class, 'update'])->name('update');
            Route::delete('/{stok}', [StokController::class, 'destroy'])->name('destroy');
        });
    });
});
