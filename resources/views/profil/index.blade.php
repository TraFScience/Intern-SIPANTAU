@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10">

    <h1 class="text-xl font-bold text-gray-900 mb-6">Profil & Pengaturan Akun</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kartu Profil --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden h-fit">
            <div class="h-20 bg-green-800"></div>
            <div class="px-6 pb-6 -mt-10 text-center">
                <div class="w-20 h-20 mx-auto rounded-full border-4 border-white bg-gray-200 flex items-center justify-center overflow-hidden">
                    <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                </div>

                <h2 class="font-bold text-gray-900 mt-3">{{ $user->name }}</h2>
                <span class="inline-flex items-center gap-1 text-xs font-medium text-green-700 bg-green-50 px-2.5 py-1 rounded-full mt-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                    @if($user->role === 'petugas')
                    Petugas Lapangan
                    @else
                    Warga Terverifikasi
                    @endif
                </span>

                <div class="text-left mt-5 space-y-2 text-sm text-gray-600">
                    <p class="flex items-center gap-2 break-all">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        {{ $user->email }}
                    </p>
                </div>

                <div class="grid grid-cols-3 gap-2 mt-5">
                    <div class="bg-gray-50 rounded-lg py-2.5">
                        <p class="font-bold text-gray-900">{{ $stats['total'] }}</p>
                        <p class="text-xs text-gray-500">Total Lapor</p>
                    </div>
                    <div class="bg-green-50 rounded-lg py-2.5">
                        <p class="font-bold text-green-700">{{ $stats['terverifikasi'] }}</p>
                        <p class="text-xs text-gray-500">Terverifikasi</p>
                    </div>
                    <div class="bg-yellow-50 rounded-lg py-2.5">
                        <p class="font-bold text-yellow-700">{{ $stats['proses'] }}</p>
                        <p class="text-xs text-gray-500">Proses</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="mt-5">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 text-red-600 bg-red-50 hover:bg-red-100 py-2.5 rounded-lg text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Keluar Akun
                    </button>
                </form>
            </div>
        </div>

        {{-- Kanan: form Breeze + Riwayat Laporan --}}
        <div class="lg:col-span-2 space-y-4">

            <div class="bg-white border border-gray-200 rounded-xl p-6">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Riwayat Laporan (accordion) --}}
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <button type="button" onclick="document.getElementById('riwayatBox').classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-90')" class="w-full flex items-center justify-between px-6 py-4 text-left">
                    <span class="font-medium text-gray-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        Riwayat Laporan
                    </span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>

                <div id="riwayatBox" class="hidden border-t border-gray-100">
                    @forelse($semuaLaporan as $laporan)
                    <div class="flex items-center justify-between px-6 py-3 border-b border-gray-50 last:border-0">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $laporan->judul }}</p>
                            <p class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($laporan->tanggal_kejadian)->translatedFormat('d F Y') }}
                            </p>
                        </div>
                        @if($laporan->status_verifikasi === 'terverifikasi')
                        <span class="bg-green-50 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">Terverifikasi</span>
                        @elseif($laporan->status_verifikasi === 'ditolak')
                        <span class="bg-red-50 text-red-700 text-xs font-medium px-2.5 py-1 rounded-full">Ditolak</span>
                        @else
                        <span class="bg-yellow-50 text-yellow-700 text-xs font-medium px-2.5 py-1 rounded-full">Menunggu</span>
                        @endif
                    </div>
                    @empty
                    <p class="text-sm text-gray-400 text-center py-6">Belum ada laporan yang dikirim.</p>
                    @endforelse
                </div>
            </div>

            {{-- Settings (accordion) --}}
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <button type="button" onclick="document.getElementById('settingsBox').classList.toggle('hidden'); this.querySelector('svg').classList.toggle('rotate-90')" class="w-full flex items-center justify-between px-6 py-4 text-left">
                    <span class="font-medium text-gray-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Settings
                    </span>
                    <svg class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>

                <div id="settingsBox" class="hidden border-t border-gray-100 p-6 space-y-8">
                    @include('profile.partials.update-password-form')
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
