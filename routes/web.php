<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\ProfileController;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pasien
    Route::resource('pasien', PasienController::class);

    // Antrian / Kunjungan
    Route::get('/antrian',                        [AntrianController::class, 'index'])->name('antrian.index');
    Route::get('/antrian/daftar',                 [AntrianController::class, 'daftar'])->name('antrian.daftar');
    Route::post('/antrian',                       [AntrianController::class, 'store'])->name('antrian.store');
    Route::get('/antrian/{kunjungan}',            [AntrianController::class, 'show'])->name('antrian.show');
    Route::patch('/antrian/{kunjungan}/status',   [AntrianController::class, 'updateStatus'])->name('antrian.status');

    // Rekam Medis
    Route::get('/rekam-medis/{kunjungan}',        [RekamMedisController::class, 'show'])->name('rekam-medis.show');
    Route::get('/rekam-medis/{kunjungan}/create', [RekamMedisController::class, 'create'])->name('rekam-medis.create');
    Route::post('/rekam-medis/{kunjungan}',       [RekamMedisController::class, 'store'])->name('rekam-medis.store');
    Route::get('/pasien/{pasien}/riwayat',        [RekamMedisController::class, 'riwayat'])->name('rekam-medis.riwayat');

    // Resep & Apotek
    Route::get('/resep',                          [ResepController::class, 'index'])->name('resep.index');
    Route::get('/resep/{kunjungan}/create',       [ResepController::class, 'create'])->name('resep.create');
    Route::post('/resep/{kunjungan}',             [ResepController::class, 'store'])->name('resep.store');
    Route::get('/resep/{resep}',                  [ResepController::class, 'show'])->name('resep.show');
    Route::patch('/resep/{resep}/proses',         [ResepController::class, 'proses'])->name('resep.proses');

    // Obat
    Route::resource('obat', ObatController::class)->except(['show']);

    // Billing
    Route::get('/billing',                        [BillingController::class, 'index'])->name('billing.index');
    Route::get('/billing/{kunjungan}/create',     [BillingController::class, 'create'])->name('billing.create');
    Route::post('/billing/{kunjungan}',           [BillingController::class, 'store'])->name('billing.store');
    Route::get('/billing/{billing}',              [BillingController::class, 'show'])->name('billing.show');
    Route::get('/billing/{billing}/kwitansi',     [BillingController::class, 'kwitansi'])->name('billing.kwitansi');

    // Surat Keterangan Sakit
    Route::get('/surat/{kunjungan}',              [RekamMedisController::class, 'suratSakit'])->name('surat.sakit');

    // Laporan
    Route::get('/laporan/kunjungan',              [LaporanController::class, 'kunjungan'])->name('laporan.kunjungan');
    Route::get('/laporan/pendapatan',             [LaporanController::class, 'pendapatan'])->name('laporan.pendapatan');

    // Master Data
    Route::resource('dokter', DokterController::class)->except(['show']);
    Route::resource('poli',   PoliController::class)->except(['show']);
});

require __DIR__ . '/auth.php';
