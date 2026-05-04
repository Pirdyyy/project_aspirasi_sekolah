<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\AuthSiswaController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== HALAMAN UTAMA ====================
Route::get('/', function () {
    if (session('admin')) {
        return redirect('/dashboard-admin');
    }
    if (session('nis')) {
        return redirect('/dashboard-siswa');
    }
    return view('home');
});

// ==================== ROUTE SISWA (TANPA LOGIN) ====================
Route::post('/register', [AuthSiswaController::class, 'register'])->name('register');
Route::post('/login-siswa', [AuthSiswaController::class, 'login'])->name('login');

// ==================== ROUTE SISWA (WAJIB LOGIN) ====================
Route::middleware(['auth.siswa'])->group(function () {
    // Dashboard siswa
    Route::get('/dashboard-siswa', [SiswaController::class, 'dashboard'])->name('dashboard.siswa');
    Route::get('/logout-siswa', [AuthSiswaController::class, 'logout'])->name('logout.siswa');

    // Aspirasi / Pengaduan
    Route::get('/input-aspirasi', [AspirasiController::class, 'form'])->name('aspirasi.form');
    Route::post('/input-aspirasi', [AspirasiController::class, 'store'])->name('aspirasi.store');
    Route::get('/edit-aspirasi/{id}', [AspirasiController::class, 'edit'])->name('aspirasi.edit');
    Route::get('/hapus-aspirasi/{id}', [AspirasiController::class, 'delete'])->name('aspirasi.delete');
    Route::get('/histori', [AspirasiController::class, 'histori'])->name('aspirasi.histori');

    // Ganti Password
    Route::get('/siswa/ganti-password', [SiswaController::class, 'formGantiPassword'])->name('siswa.ganti.password');
    Route::post('/siswa/ganti-password', [SiswaController::class, 'gantiPassword'])->name('siswa.ganti.password.post');
});

// ==================== ROUTE ADMIN (LOGIN) ====================
Route::post('/login-admin', [AuthAdminController::class, 'login'])->name('login.admin');

// ==================== ROUTE ADMIN (WAJIB LOGIN) ====================
Route::middleware(['auth.admin'])->group(function () {
    // Dashboard admin
    Route::get('/dashboard-admin', [AdminController::class, 'dashboard'])->name('dashboard.admin');
    Route::get('/logout-admin', [AuthAdminController::class, 'logout'])->name('logout.admin');

    // Statistik
    Route::get('/admin/statistik', [AdminController::class, 'statistik'])->name('admin.statistik');

    // Manajemen Kategori
    Route::get('/admin/kategori', [AdminController::class, 'kategoriPage'])->name('admin.kategori');
    Route::post('/tambah-kategori', [AdminController::class, 'tambahKategori'])->name('kategori.tambah');
    Route::post('/edit-kategori/{id}', [AdminController::class, 'editKategori'])->name('kategori.edit');
    Route::get('/hapus-kategori/{id}', [AdminController::class, 'hapusKategori'])->name('kategori.hapus');

    // Manajemen Aspirasi
    Route::get('/hapus-aspirasi-admin/{id}', [AdminController::class, 'delete'])->name('aspirasi.admin.delete');
    Route::post('/update/status/{id}', [AdminController::class, 'update'])->name('aspirasi.update');
    
    // Ganti Password Admin
Route::post('/admin/ganti-password', [AdminController::class, 'gantiPassword'])->name('admin.ganti.password');

    // Kelola Siswa (Registrasi, Edit, Hapus, Lihat Laporan)
    Route::get('/admin/kelola-siswa', [AdminController::class, 'kelolaSiswa'])->name('admin.kelola.siswa');
    Route::get('/admin/siswa/{nis}/laporan', [AdminController::class, 'laporanSiswa'])->name('admin.siswa.laporan');
    Route::post('/admin/kelola-siswa/registrasi', [AdminController::class, 'registrasiSiswaStore'])->name('admin.kelola.siswa.registrasi');
    Route::post('/admin/siswa/{nis}/edit-kelas', [AdminController::class, 'editKelasSiswa'])->name('admin.siswa.edit.kelas');
    Route::delete('/admin/siswa/{nis}/hapus', [AdminController::class, 'hapusSiswa'])->name('admin.siswa.hapus');
    Route::post('/admin/reset-password-siswa/{nis}', [AdminController::class, 'resetPasswordSiswa'])->name('admin.reset.password');
});

// ==================== HALAMAN PUBLIK ====================
Route::get('/laporan-publik', [App\Http\Controllers\LaporanPublikController::class, 'index'])->name('laporan.publik');

// ==================== ROUTE DEFAULT ====================
Route::fallback(function () {
    return redirect('/');
});
