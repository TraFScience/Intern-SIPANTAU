@extends('layouts.app')

@section('content')
@php
function iconJenisBencanaPeta($nama) {
$nama = strtolower($nama);
if (str_contains($nama, 'banjir')) return 'icon-banjir.svg';
if (str_contains($nama, 'karhutla') || str_contains($nama, 'kebakaran')) return 'icon-kebakaran.svg';
if (str_contains($nama, 'puting') || str_contains($nama, 'angin')) return 'icon-putingbeliung.svg';
if (str_contains($nama, 'longsor')) return 'icon-longsor.svg';
return 'icon-banjir.svg';
}

// Data marker untuk JavaScript (disiapkan di sini supaya aman dari auto-format)
$kejadianPeta = $semuaKejadian->map(fn ($k) => [
'judul' => $k->judul,
'lat' => $k->latitude,
'lng' => $k->longitude,
'jenis_bencana' => $k->jenisBencana->nama_jenis ?? '-',
'wilayah' => $k->wilayah->nama_wilayah ?? '-',
'tanggal' => $k->tanggal_kejadian?->locale('id')->translatedFormat('d M Y H:i'),
])->values();
@endphp

<div class="max-w-7xl mx-auto px-6 py-8" x-data="{
    aktif: { banjir: false, kebakaran: false, angin: false, longsor: false }
}" x-init="$watch('aktif', () => renderKejadianMarkers(), true)">

    {{-- Header --}}
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Peta Navigasi Bencana Terkini</h1>
            <p class="text-gray-500 mt-1">Pemantauan visual sebaran bencana di Kalimantan Selatan</p>
        </div>
        <a href="{{ route('kejadian-bencana.create') }}" class="bg-green-700 hover:bg-green-800 text-white px-5 py-2.5 rounded-full font-medium">
            + Lapor Kejadian
        </a>
    </div>

    <div class="flex gap-6">
        {{-- Sidebar Filter --}}
        <div class="w-72 shrink-0 space-y-4">

            {{-- Toggle jenis bencana --}}
            <div class="bg-white border border-gray-200 rounded-xl p-4 space-y-3">
                @php
                $jenis = [
                ['key' => 'banjir', 'label' => 'Banjir', 'icon' => 'icon-banjir.svg'],
                ['key' => 'kebakaran', 'label' => 'Karhutla', 'icon' => 'icon-kebakaran.svg'],
                ['key' => 'angin', 'label' => 'Badai Angin', 'icon' => 'icon-putingbeliung.svg'],
                ['key' => 'longsor', 'label' => 'Longsor', 'icon' => 'icon-longsor.svg'],
                ];
                @endphp
                @foreach($jenis as $j)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/'.$j['icon']) }}" alt="{{ $j['label'] }}" class="w-6 h-8 object-contain">
                        <span class="text-gray-700">{{ $j['label'] }}</span>
                    </div>
                    <button type="button" @click="aktif.{{ $j['key'] }} = !aktif.{{ $j['key'] }}" class="w-10 h-6 rounded-full relative transition" :class="aktif.{{ $j['key'] }} ? 'bg-green-700' : 'bg-gray-300'">
                        <span class="absolute top-0.5 w-5 h-5 bg-white rounded-full shadow transition-all" :class="aktif.{{ $j['key'] }} ? 'right-0.5' : 'left-0.5'"></span>
                    </button>
                </div>
                @endforeach

                {{-- Reset Filter --}}
                <div class="flex justify-end">
                    <button type="button" @click="aktif = { banjir: false, kebakaran: false, angin: false, longsor: false }" class="text-sm text-gray-400 hover:text-gray-600">
                        Reset Filter
                    </button>
                </div>

                {{-- Filter Tahun & Kabupaten --}}
                <div class="space-y-4" style="padding-top: 0.5rem;">
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Tahun</label>
                        <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-700">
                            <option>2026</option>
                            <option>2025</option>
                            <option>2024</option>
                            <option>2023</option>
                            <option>2022</option>
                            <option>2021</option>
                            <option>2020</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600 block mb-1">Kabupaten</label>
                        <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-gray-700">
                            <option>Kab. Banjar</option>
                            <option>Kota Banjarmasin</option>
                            <option>Kab. Tanah Laut</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Ringkasan --}}
            <div class="bg-green-800 text-white rounded-xl p-5">
                <p class="text-green-200 text-sm">Total Kejadian Aktif</p>
                <p class="text-3xl font-bold mb-3">{{ $semuaKejadian->count() }}</p>
                <p class="text-green-200 text-sm">Wilayah Terdampak</p>
                <p class="text-xl font-semibold">Kab. Banjar</p>
            </div>

            {{-- Kejadian Terbaru --}}
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <p class="font-semibold text-gray-800 mb-3">Kejadian Terbaru</p>
                <div class="space-y-3 pr-1" style="max-height: 90px; overflow-y: auto;">
                    @forelse($kejadianTerbaru as $kejadian)
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-red-600 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <p class="text-xs text-gray-400">{{ $kejadian->tanggal_kejadian->locale('id')->diffForHumans() }}</p>
                            <p class="text-sm text-gray-700">
                                {{ $kejadian->jenisBencana->nama_jenis ?? '-' }} di Sekitar {{ $kejadian->wilayah->nama_wilayah ?? '-' }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400">Belum ada kejadian terbaru.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Peta --}}
        <div class="flex-1 rounded-xl border border-gray-200 overflow-hidden">
            <div id="peta-bencana" class="w-full h-full z-0"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let petaBencanaMap;
    let kejadianMarkers = [];

    window.allKejadianBencana = @json($kejadianPeta);

    function iconUrlFor(jenis) {
        const j = (jenis || '').toLowerCase();
        if (j.includes('banjir')) return "{{ asset('images/icon-banjir.svg') }}";
        if (j.includes('karhutla') || j.includes('kebakaran')) return "{{ asset('images/icon-kebakaran.svg') }}";
        if (j.includes('puting') || j.includes('angin')) return "{{ asset('images/icon-putingbeliung.svg') }}";
        if (j.includes('longsor')) return "{{ asset('images/icon-longsor.svg') }}";
        return "{{ asset('images/icon-banjir.svg') }}";
    }

    function keyFor(jenis) {
        const j = (jenis || '').toLowerCase();
        if (j.includes('banjir')) return 'banjir';
        if (j.includes('karhutla') || j.includes('kebakaran')) return 'kebakaran';
        if (j.includes('puting') || j.includes('angin')) return 'angin';
        if (j.includes('longsor')) return 'longsor';
        return null;
    }

    window.renderKejadianMarkers = function() {
        kejadianMarkers.forEach(m => petaBencanaMap.removeLayer(m));
        kejadianMarkers = [];

        const alpineEl = document.querySelector('[x-data]');
        const aktif = Alpine.$data(alpineEl).aktif;

        window.allKejadianBencana.forEach(item => {
            if (!item.lat || !item.lng) return;

            const key = keyFor(item.jenis_bencana);
            if (!key || !aktif[key]) return;

            const icon = L.icon({
                iconUrl: iconUrlFor(item.jenis_bencana)
                , iconSize: [24, 30]
                , iconAnchor: [12, 30]
                , popupAnchor: [0, -28]
            , });

            const marker = L.marker([item.lat, item.lng], {
                    icon
                })
                .bindPopup(`
                    <b>${item.judul}</b><br>
                    ${item.jenis_bencana}<br>
                    Wilayah: ${item.wilayah}<br>
                    ${item.tanggal ?? ''}
                `)
                .addTo(petaBencanaMap);

            kejadianMarkers.push(marker);
        });
    };

    document.addEventListener('DOMContentLoaded', function() {
        petaBencanaMap = L.map('peta-bencana', {
            zoomControl: false
        }).setView([-3.3194, 114.5908], 8);

        L.control.zoom({
            position: 'bottomright'
        }).addTo(petaBencanaMap);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
            , maxZoom: 18
        , }).addTo(petaBencanaMap);

        renderKejadianMarkers();
    });

</script>
@endpush
@endsection
