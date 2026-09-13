@extends('layouts.admin')

@section('page-title', 'Kelola Data Bencana')

@section('content')
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

    <div class="flex justify-between items-center px-6 py-5">
        <div>
            <h2 class="font-bold text-gray-900 text-lg">Database Kejadian Bencana</h2>
        </div>
        <div class="flex items-center gap-3">
            <input type="text" placeholder="Cari lokasi/jenis..."
                class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-64">
            <a href="{{ route('kejadian-bencana.create') }}"
                class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm font-medium">
                Tambah Data
            </a>
        </div>
    </div>

    <table class="w-full text-left text-sm">
        <thead>
            <tr class="text-gray-500 border-y border-gray-100 bg-gray-50">
                <th class="px-6 py-3">ID</th>
                <th class="px-6 py-3">Tanggal</th>
                <th class="px-6 py-3">Jenis Bencana</th>
                <th class="px-6 py-3">Lokasi</th>
                <th class="px-6 py-3">Korban</th>
                <th class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $data = [
                    ['id' => '#BCN-001', 'tanggal' => '01 Sep 2026', 'jenis' => 'Banjir', 'warna' => 'bg-blue-50 text-blue-700', 'lokasi' => 'Kec. Martapura, Kab. Banjar', 'korban' => '120 Jiwa'],
                    ['id' => '#BCN-002', 'tanggal' => '28 Agu 2026', 'jenis' => 'Kebakaran', 'warna' => 'bg-yellow-50 text-yellow-700', 'lokasi' => 'Landasan Ulin, Banjarbaru', 'korban' => '0 Jiwa'],
                ];
            @endphp
            @foreach($data as $item)
                <tr class="border-b border-gray-50">
                    <td class="px-6 py-3.5 font-medium text-gray-900">{{ $item['id'] }}</td>
                    <td class="px-6 py-3.5 text-gray-600">{{ $item['tanggal'] }}</td>
                    <td class="px-6 py-3.5">
                        <span class="{{ $item['warna'] }} text-xs font-medium px-2.5 py-1 rounded-full">{{ $item['jenis'] }}</span>
                    </td>
                    <td class="px-6 py-3.5 text-gray-700">{{ $item['lokasi'] }}</td>
                    <td class="px-6 py-3.5 text-gray-700">{{ $item['korban'] }}</td>
                    <td class="px-6 py-3.5">
                        <div class="flex gap-2">
                            <button class="text-green-600 hover:text-green-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button class="text-red-500 hover:text-red-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="px-6 py-3 flex justify-between items-center text-sm text-gray-500">
        <span>Menampilkan 1 hingga {{ count($data) }} dari {{ count($data) }} data</span>
        <div class="flex gap-1">
            <button class="border border-gray-300 rounded-lg px-3 py-1.5 text-gray-500">Prev</button>
            <button class="bg-green-700 text-white rounded-lg px-3 py-1.5">1</button>
            <button class="border border-gray-300 rounded-lg px-3 py-1.5 text-gray-500">2</button>
            <button class="border border-gray-300 rounded-lg px-3 py-1.5 text-gray-500">Next</button>
        </div>
    </div>
</div>
@endsection