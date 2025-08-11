<?php

use App\Models\Kunjungan;
use App\Models\JenisKunjungan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\PemeriksaanController;
use App\Http\Controllers\JenisKunjunganController;

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::post('/get-kabupaten', [PasienController::class, 'getKabupaten'])->name('get.kabupaten');
Route::post('/get-kecamatan', [PasienController::class, 'getKecamatan'])->name('get.kecamatan');
Route::middleware(['auth', 'role:admin'])->prefix('master')->group(function () {
    // data master
    Route::resource('pegawai', PegawaiController::class);
    Route::put('/pegawai/{pegawai}/restore', [PegawaiController::class, 'restore'])->name('pegawai.restore');
    Route::delete('/pegawai/{pegawai}/force-delete', [PegawaiController::class, 'forceDelete'])->name('pegawai.forceDelete');

    Route::resource('wilayah', WilayahController::class);
    Route::put('/wilayah/{wilayah}/restore', [WilayahController::class, 'restore'])->name('wilayah.restore');
    Route::delete('/wilayah/{wilayah}/force-delete', [WilayahController::class, 'forceDelete'])->name('wilayah.forceDelete');
    Route::get('/api/provinsis/{provinsi}/kabupatens', [WilayahController::class, 'getKabupatensByProvinsi'])->name('api.kabupatens.by.provinsi');

    Route::resource('tindakan', TindakanController::class);
    Route::put('/tindakan/{tindakan}/restore', [TindakanController::class, 'restore'])->name('tindakan.restore');
    Route::delete('/tindakan/{tindakan}/force-delete', [TindakanController::class, 'forceDelete'])->name('tindakan.forceDelete');

    Route::resource('obat', ObatController::class);
    Route::put('/obat/{obat}/restore', [ObatController::class, 'restore'])->name('obat.restore');
    Route::delete('/obat/{obat}/force-delete', [ObatController::class, 'forceDelete'])->name('obat.forceDelete');

    Route::resource('user', UserController::class);
    Route::put('/user/{user}/restore', [UserController::class, 'restore'])->name('user.restore');
    Route::delete('/user/{user}/force-delete', [UserController::class, 'forceDelete'])->name('user.forceDelete');
    Route::get('/api/users/search', [UserController::class, 'search'])->name('api.users.search');

    Route::resource('obat', ObatController::class);
    Route::put('/obat/{obat}/restore', [ObatController::class, 'restore'])->name('obat.restore');
    Route::delete('/obat/{obat}/force-delete', [ObatController::class, 'forceDelete'])->name('obat.forceDelete');

    Route::resource('pasien', PasienController::class);
    Route::put('/pasien/{pasien}/restore', [PasienController::class, 'restore'])->name('pasien.restore');
    Route::delete('/pasien/{pasien}/force-delete', [PasienController::class, 'forceDelete'])->name('pasien.forceDelete');

    Route::resource('jkunjungan', JenisKunjunganController::class);
    Route::put('/jkunjungan/{jkunjungan}/restore', [JenisKunjunganController::class, 'restore'])->name('jkunjungan.restore');
    Route::delete('/jkunjungan/{jkunjungan}/force-delete', [JenisKunjunganController::class, 'forceDelete'])->name('jkunjungan.forceDelete');
    // end data master
});
Route::middleware('auth')->prefix('transaksi')->group(function () {
    Route::get('/kunjungan', [KunjunganController::class, 'index'])->name('kunjungan.index');
});
Route::middleware(['auth', 'role:admin,dokter'])->prefix('transaksi')->group(function () {

    Route::get('/pemeriksaan/{kunjungan}', [PemeriksaanController::class, 'edit'])->name('pemeriksaan.edit');
    Route::put('/pemeriksaan/{kunjungan}', [PemeriksaanController::class, 'update'])->name('pemeriksaan.update');
});
Route::middleware(['auth', 'role:admin,petugas-pendaftaran'])->prefix('transaksi')->group(function () {

    Route::get('/kunjungan/create', [KunjunganController::class, 'create'])->name('kunjungan.create');
    Route::post('/kunjungan', [KunjunganController::class, 'store'])->name('kunjungan.store');
});
Route::middleware(['auth', 'role:admin,kasir'])->prefix('transaksi')->group(function () {

    Route::get('/pembayaran/{kunjungan}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::put('/pembayaran/{kunjungan}', [PembayaranController::class, 'update'])->name('pembayaran.update');
});
Route::middleware(['auth', 'role:admin,kasir,petugas-pendaftaran'])->prefix('transaksi')->group(function () {
    Route::get('/kunjungan/{kunjungan}', [KunjunganController::class, 'show'])->name('kunjungan.show');
});


require __DIR__ . '/auth.php';
