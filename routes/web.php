<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DetailPenjualanController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Smk3Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Route 
Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);

Route::get('/user/tambah', [UserController::class, 'tambah']);
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

Route::get('/landing', [LandingPageController::class, 'index'])->name('landing');

// (routes kept simple - no friendly slug redirects)


// Jobsheet 8
Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'postregister']);

Route::middleware(['auth'])->group(function () { // artinya semua route di dalam group ini harus login dulu
    Route::get('/', [WelcomeController::class, 'index']);
    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/update-photo', [UserController::class, 'update_photo']);

    // masukkan semua route yang perlu autentikasi di sini
    Route::group(['prefix' => 'user'], function () {
        Route::middleware(['authorize:ADM,MNG'])->group(function () {
            Route::get('/', [UserController::class, 'index']);                              // menampilkan halaman awal user
        });
    });

    // (APD route removed - APD handled via /barang or other existing pages)
    

    Route::group(['prefix' => 'level'], function () {
        Route::middleware(['authorize:ADM'])->group(function () {
            Route::get('/', [LevelController::class, 'index']);                             // Menampilkan halaman awal level user                    // menghapus level user
        });
    });

    Route::group(['prefix' => 'kategori'], function () {
        Route::middleware(['authorize:ADM,MNG'])->group(function () {
            Route::get('/', [KategoriController::class, 'index']);                          // Menampilkan halaman awal daftar kategori   
        });
    });

    Route::group(['prefix' => 'barang'], function () {
        Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
            Route::get('/', [BarangController::class, 'index']);                                // menampilkan halaman awal barang      
        });
    });

    Route::group(['prefix' => 'stok'], function () {
        Route::middleware(['authorize:ADM,MNG'])->group(function () {
            Route::get('/', [StokController::class, 'index']);                              // menampilkan halaman awal stok   
        });
    });

    Route::group(['prefix' => 'supplier'], function () {
        Route::middleware(['authorize:ADM,MNG'])->group(function () {
            Route::get('/', [SupplierController::class, 'index']);
        });
    });

    Route::group(['prefix' => 'penjualan'], function () {
        Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
            Route::get('/', [PenjualanController::class, 'index']);
        });
    });

     Route::group(['prefix' => 'penjualan'], function () {
        Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
            Route::get('/', [Smk3Controller::class, 'index']);
        });
    });
});
