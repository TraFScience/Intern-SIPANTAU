@extends('layouts.admin')

@section('page-title', 'Tambah Akun Baru')

@section('content')
<div class="bg-white border border-gray-200 rounded-xl p-8 w-full">

    <h2 class="font-bold text-gray-900 text-lg mb-1">Formulir Pendaftaran Akun Pengguna</h2>
    <p class="text-sm text-gray-500 mb-6">Isi data lengkap untuk memberikan akses hak peran sistem informasi pemantauan bencana.</p>

    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-5">
        <strong class="block mb-1">Terjadi kesalahan:</strong>
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.tambah-pengguna.store') }}" method="POST">
        @csrf

        <div class="flex items-center gap-2 mb-4">
            <span class="w-6 h-6 flex items-center justify-center rounded-full bg-green-700 text-white text-xs font-bold">1</span>
            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Informasi Personal & Kredensial</h3>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-5">
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Muhammad Ilham Pratama, S.T." class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700 focus:ring-green-600 focus:border-green-600">
                <p class="text-xs text-gray-400 mt-1">Nama lengkap beserta gelar kedinasan jika ada.</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1.5">Alamat Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh: petugas@kalsel.go.id" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700 focus:ring-green-600 focus:border-green-600">
                <p class="text-xs text-gray-400 mt-1">Gunakan email aktif @kalsel.go.id atau @sipantau.id</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-8">
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1.5">Kata Sandi Baru <span class="text-red-500">*</span></label>
                <div class="flex items-center border border-gray-300 rounded-lg px-3 focus-within:ring-1 focus-within:ring-green-600 focus-within:border-green-600">
                    <input type="password" name="password" id="password" required placeholder="Minimal 8 karakter" class="flex-1 min-w-0 py-2.5 text-sm text-gray-700 border-0 focus:ring-0 focus:outline-none">
                    <button type="button" onclick="togglePassword('password', this)" class="text-gray-400 hover:text-gray-600 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-gray-400 mt-1">Kombinasi huruf besar, kecil, angka, dan simbol.</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1.5">Konfirmasi Kata Sandi <span class="text-red-500">*</span></label>
                <div class="flex items-center border border-gray-300 rounded-lg px-3 focus-within:ring-1 focus-within:ring-green-600 focus-within:border-green-600">
                    <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Ulangi kata sandi di atas" class="flex-1 min-w-0 py-2.5 text-sm text-gray-700 border-0 focus:ring-0 focus:outline-none">
                    <button type="button" onclick="togglePassword('password_confirmation', this)" class="text-gray-400 hover:text-gray-600 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-gray-400 mt-1">Pastikan kedua kata sandi sama persis.</p>
            </div>
        </div>

        <div class="flex items-center gap-2 mb-4">
            <span class="w-6 h-6 flex items-center justify-center rounded-full bg-green-700 text-white text-xs font-bold">2</span>
            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Peran Pengguna & Hak Akses</h3>
        </div>

        <label class="text-sm font-medium text-gray-700 block mb-3">Pilih Role / Hak Akses <span class="text-red-500">*</span></label>

        <div class="grid grid-cols-3 gap-4 mb-8">
            <label class="role-card border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-green-300">
                <div class="flex justify-between items-start mb-2">
                    <span class="inline-block text-xs font-semibold text-green-700 bg-green-50 px-2.5 py-1 rounded-full">Admin</span>
                    <input type="radio" name="role" value="admin" required class="text-green-700 focus:ring-green-600" {{ old('role') == 'admin' ? 'checked' : '' }}>
                </div>
                <p class="text-xs text-gray-500">Akses penuh ke semua menu, manajemen pengguna, dan pengaturan sistem.</p>
            </label>

            <label class="role-card border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-green-300">
                <div class="flex justify-between items-start mb-2">
                    <span class="inline-block text-xs font-semibold text-teal-700 bg-teal-50 px-2.5 py-1 rounded-full">Petugas Lapangan</span>
                    <input type="radio" name="role" value="petugas" class="text-green-700 focus:ring-green-600" {{ old('role') == 'petugas' ? 'checked' : '' }}>
                </div>
                <p class="text-xs text-gray-500">Mengelola entri bencana harian, data posko bencana, dan siaran berita BPBD.</p>
            </label>

            <label class="role-card border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-green-300">
                <div class="flex justify-between items-start mb-2">
                    <span class="inline-block text-xs font-semibold text-green-700 bg-green-50 px-2.5 py-1 rounded-full">User Biasa</span>
                    <input type="radio" name="role" value="masyarakat" class="text-green-700 focus:ring-green-600" {{ old('role', 'masyarakat') == 'masyarakat' ? 'checked' : '' }}>
                </div>
                <p class="text-xs text-gray-500">Akses pelaporan lapangan (Input Kejadian) serta verifikasi titik koordinat evakuasi.</p>
            </label>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.akun-pengguna') }}" class="border border-gray-300 text-gray-600 px-6 py-2.5 rounded-lg font-medium hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="bg-green-700 hover:bg-green-800 text-white px-6 py-2.5 rounded-lg font-medium flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                Simpan Akun Pengguna
            </button>
        </div>
    </form>
</div>

<style>
    .role-card:has(input:checked) {
        border-color: #15803d;
        background-color: #f0fdf4;
    }

</style>

@push('scripts')
<script>
    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

</script>
@endpush
@endsection

