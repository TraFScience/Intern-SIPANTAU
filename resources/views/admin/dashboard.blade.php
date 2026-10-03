@extends('layouts.admin')

@section('page-title', 'Dashboard Utama')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <p class="text-gray-500 text-sm">Total Bencana Aktif</p>
        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalBencana }}</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <p class="text-gray-500 text-sm">Laporan Menunggu</p>
        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $laporanMenunggu }}</p>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <p class="text-gray-500 text-sm">Wilayah Terdampak</p>
        <p class="text-3xl font-bold text-green-700 mt-1">{{ $wilayahTerdampak }} <span class="text-lg font-medium">Kab/Kota</span></p>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <p class="text-gray-500 text-sm">Total Pengguna</p>
        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalPengguna }}</p>
    </div>
</div>

{{-- Statistik ringkas --}}
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-8">
    <div class="bg-[#316244] text-white px-4 py-3 font-medium text-sm">Total Kejadian per Jenis Bencana</div>
    <div class="p-4 h-64">
        <canvas id="chartDashboard"></canvas>
    </div>
    <div class="px-4 pb-4 text-right">
        <a href="{{ route('statistik-bencana') }}" class="text-sm text-green-700 font-medium hover:underline">Lihat statistik lengkap →</a>
    </div>
</div>

<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="font-bold text-gray-900">Kejadian Bencana Terbaru</h2>
    </div>

    <table class="w-full text-left text-sm">
        <thead>
            <tr class="text-gray-500 border-b border-gray-100">
                <th class="px-6 py-3">Waktu</th>
                <th class="px-6 py-3">Kejadian</th>
                <th class="px-6 py-3">Pelapor</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($aktivitasTerbaru as $item)
                <tr class="border-b border-gray-50">
                    <td class="px-6 py-3.5 text-gray-500">
                        {{ $item->created_at->diffForHumans() }}
                    </td>
                    <td class="px-6 py-3.5 text-gray-800">
                        {{ $item->jenisBencana->nama_jenis ?? 'Bencana' }} di {{ $item->kecamatan ?? '' }} {{ $item->wilayah->nama_wilayah ?? '' }}
                    </td>
                    <td class="px-6 py-3.5 text-gray-700">
                        {{ $item->pelapor->name ?? 'Tidak diketahui' }}
                    </td>
                    <td class="px-6 py-3.5">
                        @if($item->status_verifikasi === 'terverifikasi')
                            <span class="bg-green-50 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">Terverifikasi</span>
                        @elseif($item->status_verifikasi === 'ditolak')
                            <span class="bg-red-50 text-red-700 text-xs font-medium px-2.5 py-1 rounded-full">Ditolak</span>
                        @else
                            <span class="bg-yellow-50 text-yellow-700 text-xs font-medium px-2.5 py-1 rounded-full">Menunggu</span>
                        @endif
                    </td>
                    <td class="px-6 py-3.5">
                        @if($item->status_verifikasi !== 'terverifikasi')
                            <form action="{{ route('kejadian-bencana.verifikasi', $item->id) }}" method="POST" onsubmit="return confirm('Verifikasi kejadian ini?')">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="text-green-600 hover:text-green-800 flex items-center gap-1 text-xs font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Verifikasi
                                </button>
                            </form>
                        @else
                            <span class="text-gray-300 text-xs">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                        Belum ada kejadian bencana tercatat.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="px-6 py-3 flex justify-between items-center text-sm text-gray-500">
        <span>Menampilkan {{ count($aktivitasTerbaru) }} kejadian terbaru</span>
        <a href="{{ route('admin.kelola-bencana') }}" class="text-green-700 font-medium hover:underline">Lihat semua kejadian →</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const labels = @json($kejadianPerJenis->keys());
        const data = @json($kejadianPerJenis->values());

        new Chart(document.getElementById('chartDashboard'), {
            type: 'bar',
            data: {
                labels: labels.length ? labels : ['Belum ada data'],
                datasets: [{
                    label: 'Total Kejadian',
                    data: data.length ? data : [0],
                    backgroundColor: '#316244',
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    });
</script>
@endpush