<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaketController;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::post('/simpan', [PublicController::class, 'store'])->name('simpan');

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [PaketController::class, 'dashboard'])->name('dashboard');
    Route::get('/semua', [PaketController::class, 'semua'])->name('semua');
    Route::get('/mingguan', [PaketController::class, 'mingguan'])->name('mingguan');
    Route::get('/bulanan', [PaketController::class, 'bulanan'])->name('bulanan');
    Route::get('/belum-konfirmasi', [PaketController::class, 'belumKonfirmasi'])->name('belum_konfirmasi');
    Route::get('/selesai', [PaketController::class, 'selesai'])->name('selesai');
    
    Route::get('/konfirmasi/{id}/{status}', [PaketController::class, 'konfirmasiStatus'])->name('konfirmasi');
    Route::get('/peringatan/{id}', [PaketController::class, 'kirimPeringatan'])->name('peringatan');
    Route::get('/export/{filter}', [PaketController::class, 'exportExcel'])->name('export');
});
