<?php

use App\Http\Controllers\AdminTransaksiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JenisMotorController;
use App\Http\Controllers\LandingController;
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

// New route for motor-matic
Route::get('/motor-matic', [LandingController::class, 'motorMatic'])->name('landing.motor-matic');

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
// In your web.php (or routes file)
Route::post('/transaksi/available-stock', [TransaksiController::class, 'getAvailableStock']);


// Admin Routes
Route::middleware(['auth'])->group(function () {
    // Admin dashboard
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminTransaksiController::class, 'index'])->name('dashboard');

        // Transaksi routes
        Route::prefix('transaksi')->name('admin.transaksi.')->group(function () {
            Route::get('/data', [AdminTransaksiController::class, 'getData'])->name('data');
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
