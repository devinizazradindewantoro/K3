<?php

use App\Http\Controllers\AuditController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProsedurController;
use App\Http\Controllers\KebijakanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\P3KController;
use App\Http\Controllers\PelindungController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DetailP3KController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ManajemenController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\SMK3Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Semua bebas diakses tanpa login)
|--------------------------------------------------------------------------
*/

// halaman default
Route::get('/', [WelcomeController::class, 'index']);

Route::view('/welcome', 'welcome');
Route::get('/landing', [LandingPageController::class, 'index'])->name('landing');

/* Informasi / User */
Route::get('/informasi', [InformasiController::class, 'index']);
Route::get('/user/tambah', [InformasiController::class, 'tambah']);
Route::post('/user/tambah_simpan', [InformasiController::class, 'tambah_simpan']);
Route::get('/user/ubah/{id}', [InformasiController::class, 'ubah']);
Route::put('/user/ubah_simpan/{id}', [InformasiController::class, 'ubah_simpan']);
Route::get('/user/hapus/{id}', [InformasiController::class, 'hapus']);

// PROFIL
Route::get('/profil', [ProfilController::class, 'index']);

// Kebijakan
Route::get('/kebijakan', [KebijakanController::class, 'index']);

// Prosedur Darurat
Route::get('/prosedur', [ProsedurController::class, 'index']);

// Materi
Route::get('/materi', [MateriController::class, 'index']);

// Pelindung diri
Route::get('/pelindung', [PelindungController::class, 'index']);

// P3K
Route::get('/p3k', [P3KController::class, 'index']);

// SMK3
Route::get('/smk3', [SMK3Controller::class, 'index']);

// Audit K3
Route::get('/audit', [AuditController::class, 'index']);

// Audit K3
Route::get('/manajemen', [ManajemenController::class, 'index']);


/*
|--------------------------------------------------------------------------
| Auth Routing (tetap aktif, tapi tidak wajib login)
|--------------------------------------------------------------------------
*/

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'postregister']);
Route::get('logout', [AuthController::class, 'logout']);
