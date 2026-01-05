<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\KategoriSkpiController;
use App\Http\Controllers\Admin\PeriodeInputController;
use App\Http\Controllers\Admin\ProgramStudiController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboard;
use App\Http\Controllers\Mahasiswa\SkpiController as MahasiswaSkpiController;
use App\Http\Controllers\Dosen\SkpiReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Mahasiswa Management
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::post('mahasiswa/import', [MahasiswaController::class, 'import'])->name('mahasiswa.import');

    // Kategori SKPI
    Route::resource('kategori', KategoriSkpiController::class);
    Route::get('kategori/{kategori}/sub-kategori', [KategoriSkpiController::class, 'showSubKategori'])->name('kategori.sub-kategori');
    Route::post('kategori/{kategori}/sub-kategori', [KategoriSkpiController::class, 'storeSubKategori'])->name('kategori.sub-kategori.store');
    Route::put('kategori/{kategori}/sub-kategori/{subKategori}', [KategoriSkpiController::class, 'updateSubKategori'])->name('kategori.sub-kategori.update');
    Route::delete('kategori/{kategori}/sub-kategori/{subKategori}', [KategoriSkpiController::class, 'destroySubKategori'])->name('kategori.sub-kategori.destroy');

    // Periode Input
    Route::resource('periode', PeriodeInputController::class);
    Route::post('periode/{periode}/toggle', [PeriodeInputController::class, 'toggleActive'])->name('periode.toggle');

    // Program Studi
    Route::resource('program-studi', ProgramStudiController::class);

    // Export
    Route::get('export/excel', [ExportController::class, 'exportExcel'])->name('export.excel');
    Route::get('export/pdf', [ExportController::class, 'exportPdf'])->name('export.pdf');
    Route::get('export/mahasiswa', [ExportController::class, 'exportMahasiswaExcel'])->name('export.mahasiswa');
});

// Mahasiswa Routes
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [MahasiswaDashboard::class, 'index'])->name('dashboard');

    // SKPI Management
    Route::resource('skpi', MahasiswaSkpiController::class);
    Route::get('kategori/{kategori}/sub-kategori', [MahasiswaSkpiController::class, 'getSubKategori'])->name('get-sub-kategori');
    Route::post('check-url', [MahasiswaSkpiController::class, 'checkUrl'])->name('check-url');
});

// Dosen Routes
Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/dashboard', [SkpiReviewController::class, 'dashboard'])->name('dashboard');

    // SKPI Review
    Route::get('/skpi', [SkpiReviewController::class, 'index'])->name('skpi.index');
    Route::get('/skpi/{skpi}', [SkpiReviewController::class, 'show'])->name('skpi.show');
    Route::post('/skpi/{skpi}/review', [SkpiReviewController::class, 'review'])->name('skpi.review');
    Route::post('/skpi/bulk-review', [SkpiReviewController::class, 'bulkReview'])->name('skpi.bulk-review');
});

require __DIR__ . '/auth.php';
