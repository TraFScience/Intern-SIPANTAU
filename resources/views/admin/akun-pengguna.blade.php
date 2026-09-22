@extends('layouts.admin')

@section('page-title', 'Kelola Pengguna (User & Petugas)')

@section('content')
@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-5 text-sm flex items-center gap-2">
    <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
    </svg>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-5 text-sm flex items-center gap-2">
    <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
    </svg>
    <span>{{ session('error') }}</span>
</div>
@endif

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

    <div class="flex justify-between items-center px-6 py-5">
        <a href="{{ route('admin.tambah-pengguna') }}" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
            Tambah User
        </a>
        <input type="text" placeholder="Cari user..." class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-64">
    </div>

    <table class="w-full text-left text-sm table-fixed">
        <thead>
            <tr class="text-gray-500 border-t border-b border-gray-100 uppercase text-xs">
                <th class="px-6 py-3 w-16">No</th>
                <th class="px-6 py-3">Nama Lengkap</th>
                <th class="px-6 py-3">Email</th>
                <th class="px-6 py-3 text-center w-48">Role / Hak Akses</th>
                <th class="px-6 py-3 w-32">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $i => $u)
            <tr class="border-b border-gray-50">
                <td class="px-6 py-4 text-gray-500">{{ $i + 1 }}</td>
                <td class="px-6 py-4 font-medium text-gray-900">{{ $u->name }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $u->email }}</td>
                <td class="px-6 py-4 text-center">
                    <span class="inline-flex justify-center text-xs font-medium px-2.5 py-1 rounded-full bg-blue-50 text-blue-700">
                        {{ $u->role ?? '-' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('user.edit', $u->id) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </a>
                        <form action="{{ route('user.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-red-600 hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada pengguna terdaftar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="px-6 py-4 flex justify-between items-center text-sm text-gray-500">
        <span>Menampilkan 1 hingga {{ count($users) }} dari {{ count($users) }} user</span>
    </div>
</div>
@endsection

