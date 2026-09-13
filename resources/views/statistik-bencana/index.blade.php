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
        @php
            $log = [
                ['tanggal' => '1 Sep 2026', 'jenis' => 'Banjir', 'lokasi' => 'Kecamatan Martapura Kab. Banjar', 'status' => 'Waspada'],
            ];
        @endphp
        @foreach($log as $item)
            <div class="grid grid-cols-[140px_120px_1fr_140px_100px] px-6 py-4 border-t border-gray-100 items-center">
                <div class="text-gray-700">{{ $item['tanggal'] }}</div>
                <div class="text-gray-700">{{ $item['jenis'] }}</div>
                <div class="text-gray-700">{{ $item['lokasi'] }}</div>
                <div class="text-yellow-600 font-semibold">{{ $item['status'] }}</div>
                <div><a href="#" class="text-green-700 hover:underline">Detail</a></div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Chart(document.getElementById('chartTren'), {
            type: 'line',
            data: {
                labels: ['2020', '2021', '2022', '2023', '2024', '2025', '2026'],
                datasets: [{
                    label: 'Jumlah Kejadian',
                    data: [150, 320, 480, 600, 700, 900, 1080],
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
                    y: { beginAtZero: true, suggestedMax: 1200 }
                }
            }
        });

        new Chart(document.getElementById('chartKategori'), {
            type: 'bar',
            data: {
                labels: ['Banjir', 'Kebakaran', 'Puting Beliung', 'Longsor'],
                datasets: [{
                    label: 'Total Kejadian',
                    data: [780, 550, 1050, 920],
                    backgroundColor: '#316244',
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, suggestedMax: 1200 }
                }
            }
        });
    });
</script>
@endpush