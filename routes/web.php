<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\KibController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('lokasi', \App\Http\Controllers\LokasiController::class);
    Route::get('kib/{type}', [KibController::class, 'index'])->name('kib.index');
    Route::get('kib/{type}/print-qr', [KibController::class, 'printBulkQr'])->name('kib.print-bulk-qr');
    Route::get('scan', [\App\Http\Controllers\ScanController::class, 'index'])->name('scan.index');
    Route::post('scan/lookup', [\App\Http\Controllers\ScanController::class, 'lookup'])->name('scan.lookup');
    Route::post('stock-opname', [\App\Http\Controllers\StockOpnameController::class, 'store'])->name('stock-opname.store');
    Route::get('aset/{aset}/print-qr', [\App\Http\Controllers\AsetController::class, 'printQr'])->name('aset.print-qr');
    Route::resource('aset', \App\Http\Controllers\AsetController::class);

    Route::get('report', [\App\Http\Controllers\ReportController::class, 'index'])->name('report.index');
    Route::get('report/excel', [\App\Http\Controllers\ReportController::class, 'exportExcel'])->name('report.excel');
    Route::get('report/pdf', [\App\Http\Controllers\ReportController::class, 'exportPdf'])->name('report.pdf');

    // User Management
    Route::resource('users', UserController::class);

    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';
