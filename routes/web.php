<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\InfografisController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PublikController;
use App\Http\Controllers\TentangController;
use Illuminate\Support\Facades\Route;

// Rute Publik
// Route::get('/', function () {
//     return redirect('/comingsoon');
// });

// Route::get('/sensor', function () {
//     return view('pages.public.sensor');
// });

Route::get('/', [PublikController::class, 'beranda'])->name('beranda.publik');

Route::get('/tentang', [PublikController::class, 'tentang'])->name('tentang.publik');

Route::get('/infografis', [PublikController::class, 'infografis'])->name('infografis.publik');

Route::get('/edukasi', [PublikController::class, 'edukasi'])->name('edukasi.publik');

Route::get('/edukasi/detail/{id}', [EdukasiController::class, 'show'])->name('edukasi.detail');

Route::get('/comingsoon', [PublikController::class, 'coming'])->name('coming.publik');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dash');
    Route::get('/admin/profil/edit', [AdminController::class, 'editProf'])->name('prof.edit');
    Route::post('/admin/profil/updateProfil', [AdminController::class, 'updateProf'])->name('prof.update');
    Route::get('/admin/profil/editSandi', [AdminController::class, 'editPass'])->name('prof.edit.pass');
    Route::post('/admin/profil/updateSandi', [AdminController::class, 'updatePass'])->name('prof.update.pass');

    Route::get('/admin/tentang', [TentangController::class, 'index'])->name('tentang.data');
    Route::post('/admin/tentang/edit', [TentangController::class, 'edit'])->name('tentang.edit');
    Route::post('/admin/tentang/update', [TentangController::class, 'update'])->name('tentang.update');

    Route::get('/admin/infografis', [InfografisController::class, 'index'])->name('infografis.data');
    Route::get('/admin/infografis/tambah', [InfografisController::class, 'create'])->name('infografis.tambah');
    Route::post('/admin/infografis/add', [InfografisController::class, 'store'])->name('infografis.store');
    Route::get('/admin/infografis/edit/{id}', [InfografisController::class, 'edit'])->name('infografis.edit');
    Route::post('/admin/infografis/update/{id}', [InfografisController::class, 'update'])->name('infografis.update');
    Route::get('/admin/infografis/hapus/{id}', [InfografisController::class, 'destroy'])->name('infografis.hapus');

    Route::get('/admin/edukasi', [EdukasiController::class, 'index'])->name('edukasi.data');
    Route::get('/admin/edukasi/tambah', [EdukasiController::class, 'create'])->name('edukasi.tambah');
    Route::post('/admin/edukasi/add', [EdukasiController::class, 'store'])->name('edukasi.store');
    Route::get('/admin/edukasi/edit/{id}', [EdukasiController::class, 'edit'])->name('edukasi.edit');
    Route::post('/admin/edukasi/update/{id}', [EdukasiController::class, 'update'])->name('edukasi.update');
    Route::get('/admin/edukasi/hapus/{id}', [EdukasiController::class, 'destroy'])->name('edukasi.hapus');

    Route::get('/admin/lokasi', [LokasiController::class, 'index'])->name('lokasi.data');
    Route::post('/admin/lokasi/edit', [LokasiController::class, 'edit'])->name('lokasi.edit');
    Route::post('/admin/lokasi/update', [LokasiController::class, 'update'])->name('lokasi.update');

    Route::get('/admin/kontak', [KontakController::class, 'index'])->name('kontak.data');
    Route::post('/admin/kontak/edit', [KontakController::class, 'edit'])->name('kontak.edit');
    Route::post('/admin/kontak/update', [KontakController::class, 'update'])->name('kontak.update');

    Route::get('/admin/akun', [AkunController::class, 'index'])->name('akun.data');
    Route::get('/admin/akun/tambah', [AkunController::class, 'create'])->name('akun.tambah');
    Route::post('/admin/akun/add', [AkunController::class, 'store'])->name('akun.store');
    Route::get('/admin/akun/edit/{id}', [AkunController::class, 'edit'])->name('akun.edit');
    Route::post('/admin/akun/update/{id}', [AkunController::class, 'update'])->name('akun.update');
    Route::get('/admin/akun/hapus/{id}', [AkunController::class, 'destroy'])->name('akun.hapus');
    Route::get('/admin/akun/resetPass/{id}', [AkunController::class, 'resetPass'])->name('akun.resetpass');

});

require __DIR__.'/auth.php';
