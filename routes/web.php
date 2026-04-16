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
    // Cek apakah sudah login sebagai admin
    if (session('admin')) {
        return redirect('/dashboard-admin');
    }

    // Cek apakah sudah login sebagai siswa
    if (session('nis')) {
        return redirect('/dashboard-siswa');
    }

    // Jika belum login, tampilkan halaman home
    return view('home');
});

// ==================== ROUTE SISWA (TANPA LOGIN - BISA AKSES) ====================
// Registrasi
Route::post('/register', [AuthSiswaController::class, 'register'])->name('register');

// Login
Route::post('/login-siswa', [AuthSiswaController::class, 'login'])->name('login');
Route::get('/login-admin', [AuthAdminController::class, 'showLoginForm'])->name('login.admin.form');
Route::post('/login-admin', [AuthAdminController::class, 'login'])->name('login.admin');

// ==================== ROUTE SISWA (WAJIB LOGIN) ====================
Route::middleware(['auth.siswa'])->group(function () {
    // Dashboard siswa
    Route::get('/dashboard-siswa', [SiswaController::class, 'dashboard'])->name('dashboard.siswa');

    // Logout siswa
    Route::get('/logout-siswa', [AuthSiswaController::class, 'logout'])->name('logout.siswa');

    // Aspirasi / Pengaduan
    Route::get('/input-aspirasi', [AspirasiController::class, 'form'])->name('aspirasi.form');
    Route::post('/input-aspirasi', [AspirasiController::class, 'store'])->name('aspirasi.store');

    // Edit aspirasi
    Route::get('/edit-aspirasi/{id}', [AspirasiController::class, 'edit'])->name('aspirasi.edit');

    // Hapus aspirasi
    Route::get('/hapus-aspirasi/{id}', [AspirasiController::class, 'delete'])->name('aspirasi.delete');

    // Histori
    Route::get('/histori', [AspirasiController::class, 'histori'])->name('aspirasi.histori');
});

// ==================== ROUTE ADMIN (WAJIB LOGIN) ====================
Route::middleware(['auth.admin'])->group(function () {
    // Dashboard admin
    Route::get('/dashboard-admin', [AdminController::class, 'dashboard'])->name('dashboard.admin');

    // STATISTIK
    Route::get('/admin/statistik', [AdminController::class, 'statistik'])->name('admin.statistik');

    // MANAJEMEN KATEGORI
    Route::get('/admin/kategori', [AdminController::class, 'kategoriPage'])->name('admin.kategori');

    // Logout admin
    Route::get('/logout-admin', [AuthAdminController::class, 'logout'])->name('logout.admin');

    // Manajemen Kategori (CRUD)
    Route::post('/tambah-kategori', [AdminController::class, 'tambahKategori'])->name('kategori.tambah');
    Route::post('/edit-kategori/{id}', [AdminController::class, 'editKategori'])->name('kategori.edit');
    Route::get('/hapus-kategori/{id}', [AdminController::class, 'hapusKategori'])->name('kategori.hapus');

    // Manajemen Aspirasi
    Route::get('/hapus-aspirasi-admin/{id}', [AdminController::class, 'delete'])->name('aspirasi.admin.delete');
    Route::post('/update/status/{id}', [AdminController::class, 'update'])->name('aspirasi.update');
});

// ==================== ROUTE DEFAULT ====================
// Jika user mencoba akses halaman yang tidak ditemukan
Route::fallback(function () {
    return redirect('/');
});
