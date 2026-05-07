<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\KibController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('p/aset/{kode_aset}', [\App\Http\Controllers\PublicAsetController::class, 'show'])->name('public.aset.show');

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
    Route::get('kib/{type}/template', [KibController::class, 'downloadTemplate'])->name('kib.template');
    Route::post('kib/{type}/import', [KibController::class, 'import'])->name('kib.import');
    Route::get('scan', [\App\Http\Controllers\ScanController::class, 'index'])->name('scan.index');
    Route::post('scan/lookup', [\App\Http\Controllers\ScanController::class, 'lookup'])->name('scan.lookup');
    Route::post('stock-opname', [\App\Http\Controllers\StockOpnameController::class, 'store'])->name('stock-opname.store');
    Route::get('aset/{aset}/print-qr', [\App\Http\Controllers\AsetController::class, 'printQr'])->name('aset.print-qr');
    Route::resource('aset', \App\Http\Controllers\AsetController::class);
    Route::delete('aset-lampiran/{lampiran}', [\App\Http\Controllers\AsetController::class, 'destroyLampiran'])->name('aset.destroy-lampiran');

    Route::get('report', [\App\Http\Controllers\ReportController::class, 'index'])->name('report.index');
    Route::get('report/excel', [\App\Http\Controllers\ReportController::class, 'exportExcel'])->name('report.excel');
    Route::get('report/pdf', [\App\Http\Controllers\ReportController::class, 'exportPdf'])->name('report.pdf');

    // User Management
    Route::resource('users', UserController::class);

    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

    // Backup & Restore
    Route::get('backup', [\App\Http\Controllers\BackupController::class, 'index'])->name('backup.index');
    Route::get('backup/download', [\App\Http\Controllers\BackupController::class, 'download'])->name('backup.download');
    Route::post('backup/restore', [\App\Http\Controllers\BackupController::class, 'restore'])->name('backup.restore');
    Route::post('backup/delete-kib', [\App\Http\Controllers\BackupController::class, 'deleteKibData'])->name('backup.delete-kib');
});

require __DIR__.'/auth.php';
