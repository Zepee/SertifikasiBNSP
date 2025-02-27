<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PenerbitController;
use App\Models\Buku;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama (menampilkan semua buku + pencarian)
Route::get('/', [BukuController::class, 'index'])->name('home');



// Halaman admin (pengelolaan buku & penerbit)
Route::get('/admin', [BukuController::class, 'admin'])->name('admin');

// Halaman pengadaan (laporan buku stok rendah)
Route::get('/pengadaan', [BukuController::class, 'pengadaan'])->name('pengadaan');

// Resource untuk Buku dan Penerbit (CRUD)
Route::resource('buku', BukuController::class);
Route::resource('penerbit', PenerbitController::class);
