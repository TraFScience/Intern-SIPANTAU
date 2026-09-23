<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    return redirect()->route('peta-bencana');
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
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('peta-bencana');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/peta-bencana', function () {
    $semuaKejadian = \App\Models\KejadianBencana::with(['jenisBencana', 'wilayah'])
        ->where('status_verifikasi', 'terverifikasi')
        ->latest('tanggal_kejadian')
        ->get();
    $kejadianTerbaru = $semuaKejadian->take(5);
    return view('peta-bencana.index', compact('kejadianTerbaru', 'semuaKejadian'));
})->name('peta-bencana');

// Halaman Statistik Bencana (Frontend)
Route::get('/statistik-bencana', function () {
    $kejadianPerTahun = \App\Models\KejadianBencana::where('status_verifikasi', 'terverifikasi')
        ->selectRaw('YEAR(tanggal_kejadian) as tahun, COUNT(*) as total')
        ->groupBy('tahun')->orderBy('tahun')->pluck('total', 'tahun');

    $kejadianPerJenis = \App\Models\KejadianBencana::where('kejadian_bencana.status_verifikasi', 'terverifikasi')
        ->join('jenis_bencana', 'kejadian_bencana.jenis_bencana_id', '=', 'jenis_bencana.id')
        ->selectRaw('jenis_bencana.nama_jenis, COUNT(*) as total')
        ->groupBy('jenis_bencana.nama_jenis')->pluck('total', 'nama_jenis');

    $logTerbaru = \App\Models\KejadianBencana::with(['jenisBencana', 'wilayah'])
        ->where('status_verifikasi', 'terverifikasi')
        ->latest('tanggal_kejadian')->take(10)->get();

    return view('statistik-bencana.index', compact('kejadianPerTahun', 'kejadianPerJenis', 'logTerbaru'));
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
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
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
        $berita = \App\Models\Berita::with('user')->latest()->paginate(4);
        return view('admin.kelola-berita', compact('berita'));
    })->name('kelola-berita');

    Route::get('/kelola-berita/{id}', function ($id) {
        $berita = \App\Models\Berita::with('user')->findOrFail($id);
        return view('berita.show-admin', compact('berita'));
    })->name('berita.show-admin');

    Route::get('/akun-pengguna', function () {
        $users = \App\Models\User::all();
        return view('admin.akun-pengguna', compact('users'));
    })->name('akun-pengguna');

    Route::get('/tambah-pengguna', function () {
        return view('admin.tambah-pengguna');
    })->name('tambah-pengguna');

    Route::post('/tambah-pengguna', [App\Http\Controllers\UserController::class, 'store'])
        ->name('tambah-pengguna.store');
});

Route::get('/profil', function () {
    $user = Auth::user();

    $semuaLaporan = \App\Models\KejadianBencana::where('user_id', $user->id)->latest()->get();

    $stats = [
        'total'         => $semuaLaporan->count(),
        'terverifikasi' => $semuaLaporan->where('status_verifikasi', 'terverifikasi')->count(),
        'proses'        => $semuaLaporan->where('status_verifikasi', 'menunggu')->count(),
    ];

    return view('profil.index', compact('user', 'semuaLaporan', 'stats'));
})->name('profil.index');
