<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JenisBencanaController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\WilayahRawanController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KejadianBencanaController;
use App\Http\Controllers\ProfileController;
use App\Models\Berita;

// Halaman Utama Website
Route::get('/', function () {
    return view('welcome');
});

// Route CRUD Data Utama SIPANTAU
Route::resource('user', UserController::class);
Route::resource('jenis-bencana', JenisBencanaController::class);
Route::resource('wilayah', WilayahController::class);
Route::resource('wilayah-rawan', WilayahRawanController::class);
Route::resource('berita', BeritaController::class);

// Route Kejadian Bencana & Verifikasi
Route::resource('kejadian-bencana', KejadianBencanaController::class);
Route::put('kejadian-bencana/{id}/verifikasi', [KejadianBencanaController::class, 'verifikasi'])->name('kejadian-bencana.verifikasi');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/peta-bencana', function () {
    $kejadianTerbaru = \App\Models\KejadianBencana::with(['jenisBencana', 'wilayah'])
        ->latest('tanggal_kejadian')
        ->take(5)
        ->get();
    return view('peta-bencana.index', compact('kejadianTerbaru'));
})->name('peta-bencana');

// Halaman Statistik Bencana (Frontend)
Route::get('/statistik-bencana', function () {
    return view('statistik-bencana.index');
})->name('statistik-bencana');

// Halaman Wilayah Rawan (Frontend)
Route::get('/wilayah-rawan', function () {
    $wilayahRawan = \App\Models\WilayahRawan::with(['wilayah', 'jenisBencana'])->get();
    $jenisBencanaList = \App\Models\JenisBencana::all();
    return view('wilayah-rawan.index', compact('wilayahRawan', 'jenisBencanaList'));
})->name('wilayah-rawan.index');

// Halaman Berita (Frontend)
Route::get('/berita-terkini', function () {
    $berita = Berita::with('user')->latest()->get();
    return view('berita.index', compact('berita'));
})->name('berita-page');

// Panel Admin (sementara: siapa saja yang login dianggap admin)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/kelola-bencana', function () {
    $kejadian = \App\Models\KejadianBencana::with(['jenisBencana', 'wilayah'])->latest()->get();
    return view('admin.kelola-bencana', compact('kejadian'));
    })->name('kelola-bencana');

    Route::get('/input-kejadian', function () {
        $jenisBencana = \App\Models\JenisBencana::all();
        $wilayah = \App\Models\Wilayah::all();
        return view('admin.input-kejadian', compact('jenisBencana', 'wilayah'));
    })->name('input-kejadian');

    Route::get('/kelola-berita', function () {
        $berita = \App\Models\Berita::with('user')->latest()->get();
        return view('admin.kelola-berita', compact('berita'));
    })->name('kelola-berita');

    Route::get('/akun-pengguna', function () {
        $users = \App\Models\User::all();
        return view('admin.akun-pengguna', compact('users'));
    })->name('akun-pengguna');
});