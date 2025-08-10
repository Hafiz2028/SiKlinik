<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\Master\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'role:admin'])->prefix('master')->group(function () {
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
});

require __DIR__ . '/auth.php';
