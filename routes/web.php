<?php

use App\Http\Controllers\AdminTransaksiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JenisMotorController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Landing routes
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return (new LandingController)->index();
})->name('landing');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Transaction Routes
Route::prefix('transaksi')->name('transaksi.')->group(function () {
    Route::get('/', [TransaksiController::class, 'index'])->name('index');
    Route::post('/store', [TransaksiController::class, 'store'])->name('store');
    Route::get('invoice/{id}/preview', [InvoiceController::class, 'previewInvoice'])->name('invoice.preview');
    Route::get('invoice/{id}/download', [InvoiceController::class, 'downloadInvoice'])->name('invoice.download');
});

// Admin Routes
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminTransaksiController::class, 'index'])->name('dashboard');

        Route::prefix('transaksi')->name('admin.transaksi.')->group(function () {
            Route::get('/data', [AdminTransaksiController::class, 'getData'])->name('data');
            Route::get('/', [AdminTransaksiController::class, 'transaksi'])->name('transaksi');
            Route::get('/{transaksi}', [AdminTransaksiController::class, 'show'])->name('show');
            Route::get('/{transaksi}/edit', [AdminTransaksiController::class, 'edit'])->name('edit');
            Route::get('/{transaksi}/detail', [AdminTransaksiController::class, 'edit'])->name('detail');
            Route::put('/{transaksi}', [AdminTransaksiController::class, 'update'])->name('update');
            Route::delete('/{transaksi}', [AdminTransaksiController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-delete', [AdminTransaksiController::class, 'bulkDelete'])->name('bulkDelete');
        });
        Route::prefix('jenis-motor')->name('admin.jenisMotor.')->group(function () {
            Route::get('/', [JenisMotorController::class, 'index'])->name('index');
            Route::get('/create', [JenisMotorController::class, 'create'])->name('create');
            Route::post('/', [JenisMotorController::class, 'store'])->name('store');
            Route::get('/{jenisMotor}', [JenisMotorController::class, 'show'])->name('show');
            Route::get('/{jenisMotor}/edit', [JenisMotorController::class, 'edit'])->name('edit');
            Route::put('/{jenisMotor}', [JenisMotorController::class, 'update'])->name('update');
            Route::delete('/{jenisMotor}', [JenisMotorController::class, 'destroy'])->name('destroy');
        });

    });
});
