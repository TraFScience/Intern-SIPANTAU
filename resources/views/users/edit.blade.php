@extends('layouts.admin')

@section('page-title', 'Edit User')

@section('content')
<div class="bg-white border border-gray-200 rounded-xl p-8 w-full">

    <h2 class="font-bold text-gray-900 text-lg mb-6">Edit Data Pengguna</h2>

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

    <form action="{{ route('user.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <label class="text-sm font-medium text-gray-700 block mb-1.5">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700 focus:ring-green-600 focus:border-green-600">
        </div>

        <div class="mb-5">
            <label class="text-sm font-medium text-gray-700 block mb-1.5">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700 focus:ring-green-600 focus:border-green-600">
        </div>

        <div class="mb-5">
            <label class="text-sm font-medium text-gray-700 block mb-1.5">Password Baru</label>
            <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700 focus:ring-green-600 focus:border-green-600">
            <p class="text-xs text-gray-400 mt-1">Kosongkan jika password tidak ingin diubah.</p>
        </div>

        <div class="mb-6">
            <label class="text-sm font-medium text-gray-700 block mb-3">Role / Hak Akses</label>

            <div class="grid grid-cols-3 gap-4 mb-8">
                <label class="role-card border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-green-300">
                    <div class="flex justify-between items-start mb-2">
                        <span class="inline-block text-xs font-semibold text-green-700 bg-green-50 px-2.5 py-1 rounded-full">Admin</span>
                        <input type="radio" name="role" value="admin" class="text-green-700 focus:ring-green-600" {{ old('role', $user->role) == 'admin' ? 'checked' : '' }}>
                    </div>
                    <p class="text-xs text-gray-500">Akses penuh ke semua menu, manajemen pengguna, dan pengaturan sistem.</p>
                </label>

                <label class="role-card border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-green-300">
                    <div class="flex justify-between items-start mb-2">
                        <span class="inline-block text-xs font-semibold text-teal-700 bg-teal-50 px-2.5 py-1 rounded-full">Petugas Lapangan</span>
                        <input type="radio" name="role" value="petugas" class="text-green-700 focus:ring-green-600" {{ old('role', $user->role) == 'petugas' ? 'checked' : '' }}>
                    </div>
                    <p class="text-xs text-gray-500">Mengelola entri bencana harian, data posko bencana, dan siaran berita BPBD.</p>
                </label>

                <label class="role-card border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-green-300">
                    <div class="flex justify-between items-start mb-2">
                        <span class="inline-block text-xs font-semibold text-green-700 bg-green-50 px-2.5 py-1 rounded-full">User Biasa</span>
                        <input type="radio" name="role" value="masyarakat" class="text-green-700 focus:ring-green-600" {{ old('role', $user->role) == 'masyarakat' ? 'checked' : '' }}>
                    </div>
                    <p class="text-xs text-gray-500">Akses pelaporan lapangan (Input Kejadian) serta verifikasi titik koordinat evakuasi.</p>
                </label>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.akun-pengguna') }}" class="border border-gray-300 text-gray-600 px-6 py-2.5 rounded-lg font-medium hover:bg-gray-50">
                    Kembali
                </a>
                <button type="submit" class="bg-green-700 hover:bg-green-800 text-white px-6 py-2.5 rounded-lg font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    Simpan Perubahan
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
@endsection

