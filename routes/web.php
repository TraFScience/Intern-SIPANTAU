<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JenisBencanaController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\WilayahRawanController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KejadianBencanaController;

// Halaman Utama Website
Route::get('/', function () {
    return view('welcome');
});

// Route CRUD Data Utama SIPANTAU
Route::resource('users', UserController::class);
Route::resource('jenis-bencana', JenisBencanaController::class);
Route::resource('wilayah', WilayahController::class);
Route::resource('wilayah-rawan', WilayahRawanController::class);
Route::resource('berita', BeritaController::class);

// Route Kejadian Bencana & Verifikasi
Route::resource('kejadian-bencana', KejadianBencanaController::class);
Route::put('kejadian-bencana/{id}/verifikasi', [KejadianBencanaController::class, 'verifikasi'])->name('kejadian-bencana.verifikasi');