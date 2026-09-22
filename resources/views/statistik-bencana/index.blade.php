@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    <h1 class="text-2xl font-bold text-gray-900 mb-6">Statistik Bencana</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        {{-- Line Chart --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="bg-[#316244] text-white px-4 py-3 font-medium text-sm">Tren Kejadian Bencana Tahunan</div>
            <div class="p-4 h-64">
                <canvas id="chartTren"></canvas>
            </div>
        </div>

        {{-- Bar Chart --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="bg-[#316244] text-white px-4 py-3 font-medium text-sm">Total Kejadian Per Kategori</div>
            <div class="p-4 h-64">
                <canvas id="chartKategori"></canvas>
            </div>
        </div>
    </div>

    {{-- Log Kejadian --}}
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="bg-[#316244] text-white px-6 py-5 font-bold text-lg">Log Kejadian Terakhir</div>

        {{-- Header --}}
        <div class="grid grid-cols-[140px_120px_1fr_140px_100px] bg-gray-100 text-gray-800 font-bold px-6 py-4">
            <div>Tanggal</div>
            <div>Jenis</div>
            <div>Lokasi</div>
            <div>Status</div>
            <div>Aksi</div>
        </div>

        {{-- Rows --}}
        @forelse($logTerbaru as $item)
            <div class="grid grid-cols-[140px_120px_1fr_140px_100px] px-6 py-4 border-t border-gray-100 items-center">
                <div class="text-gray-700">{{ \Carbon\Carbon::parse($item->tanggal_kejadian)->translatedFormat('d M Y') }}</div>
                <div class="text-gray-700">{{ $item->jenisBencana->nama_jenis ?? '-' }}</div>
                <div class="text-gray-700">{{ $item->kecamatan ?? '' }} {{ $item->wilayah->nama_wilayah ?? '' }}</div>
                @if($item->status_verifikasi === 'terverifikasi')
                    <div class="text-green-600 font-semibold">Terverifikasi</div>
                @elseif($item->status_verifikasi === 'ditolak')
                    <div class="text-red-600 font-semibold">Ditolak</div>
                @else
                    <div class="text-yellow-600 font-semibold">Menunggu</div>
                @endif
                <div><a href="{{ route('peta-bencana') }}" class="text-green-700 hover:underline">Detail</a></div>
            </div>
        @empty
            <div class="px-6 py-8 text-center text-gray-400 border-t border-gray-100">
                Belum ada data kejadian bencana tercatat.
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tahunLabels = @json($kejadianPerTahun->keys());
        const tahunData = @json($kejadianPerTahun->values());

        const jenisLabels = @json($kejadianPerJenis->keys());
        const jenisData = @json($kejadianPerJenis->values());

        new Chart(document.getElementById('chartTren'), {
            type: 'line',
            data: {
                labels: tahunLabels.length ? tahunLabels : ['Belum ada data'],
                datasets: [{
                    label: 'Jumlah Kejadian',
                    data: tahunData.length ? tahunData : [0],
                    borderColor: '#316244',
                    backgroundColor: 'rgba(49,98,68,0.1)',
                    fill: true,
                    tension: 0.3,
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        new Chart(document.getElementById('chartKategori'), {
            type: 'bar',
            data: {
                labels: jenisLabels.length ? jenisLabels : ['Belum ada data'],
                datasets: [{
                    label: 'Total Kejadian',
                    data: jenisData.length ? jenisData : [0],
                    backgroundColor: '#316244',
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>
@endpush