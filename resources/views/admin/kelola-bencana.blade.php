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
            <a href="{{ route('admin.input-kejadian') }}"
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
            @forelse($kejadian as $item)
                <tr class="border-b border-gray-50">
                    <td class="px-6 py-3.5 font-medium text-gray-900">#BCN-{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-3.5 text-gray-600">
                        {{ \Carbon\Carbon::parse($item->tanggal_kejadian)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-3.5">
                        <span class="bg-blue-50 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full">
                            {{ $item->jenisBencana->nama_jenis ?? 'Bencana' }}
                        </span>
                    </td>
                    <td class="px-6 py-3.5 text-gray-700">
                        {{ $item->kecamatan ?? 'Detail lokasi' }}, {{ $item->wilayah->nama_wilayah ?? '' }}
                    </td>
                    <td class="px-6 py-3.5 text-gray-700">{{ $item->jumlah_korban ?? 0 }} Jiwa</td>
                    <td class="px-6 py-3.5">
                        <div class="flex gap-2">
                            {{-- Tombol Edit --}}
                            <a href="{{ url('/admin/kejadian-bencana/' . $item->id . '/edit') }}" class="text-green-600 hover:text-green-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>

                            {{-- Tombol Hapus --}}
                            <form action="{{ url('/admin/kejadian-bencana/' . $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Belum ada data kejadian bencana tersimpan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="px-6 py-3 flex justify-between items-center text-sm text-gray-500">
        <span>Menampilkan {{ count($kejadian) }} data</span>
    </div>
</div>
@endsection