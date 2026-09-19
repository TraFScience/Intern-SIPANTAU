@extends('layouts.app')

@section('content')
@php
    // Mapping icon & kategori berdasarkan kata kunci nama jenis bencana
    function iconJenisBencana($nama) {
        $nama = strtolower($nama);
        if (str_contains($nama, 'banjir')) return ['icon' => 'icon-banjir.svg', 'kategori' => 'Hidrologi', 'color' => 'bg-blue-50 border-blue-500'];
        if (str_contains($nama, 'karhutla') || str_contains($nama, 'kebakaran')) return ['icon' => 'icon-kebakaran.svg', 'kategori' => 'Hutan & Lahan', 'color' => 'bg-orange-50 border-orange-500'];
        if (str_contains($nama, 'puting') || str_contains($nama, 'angin')) return ['icon' => 'icon-putingbeliung.svg', 'kategori' => 'Cuaca Ekstrem', 'color' => 'bg-amber-50 border-amber-500'];
        if (str_contains($nama, 'longsor')) return ['icon' => 'icon-longsor.svg', 'kategori' => 'Geologi', 'color' => 'bg-stone-50 border-stone-500'];
        return ['icon' => 'icon-banjir.svg', 'kategori' => '-', 'color' => 'bg-gray-50 border-gray-400'];
    }
@endphp

<div x-data="{
    selectedJenis: null,
    selectedRisiko: ['Tinggi', 'Sedang'],
    toggleRisiko(r) {
        if (this.selectedRisiko.includes(r)) {
            this.selectedRisiko = this.selectedRisiko.filter(x => x !== r);
        } else {
            this.selectedRisiko.push(r);
        }
    },
    filteredData() {
        return {{ Js::from($wilayahRawan->map(fn($w) => [
            'id' => $w->id,
            'nama_wilayah' => $w->wilayah->nama_wilayah ?? '-',
            'lat' => $w->wilayah->latitude ?? null,
            'lng' => $w->wilayah->longitude ?? null,
            'jenis_bencana' => $w->jenisBencana->nama_jenis ?? '-',
            'tingkat_kerawanan' => $w->tingkat_kerawanan,
            'keterangan' => $w->keterangan,
            'polygon' => $w->polygon,
        ])) }}.filter(item => {
            if (this.selectedJenis && item.jenis_bencana !== this.selectedJenis) return false;
            if (!this.selectedRisiko.includes(item.tingkat_kerawanan)) return false;
            return item.lat && item.lng;
        });
    }
}" x-init="$watch('selectedJenis', () => renderMarkers()); $watch('selectedRisiko', () => renderMarkers(), true)"
class="relative h-[calc(100vh-64px)] overflow-hidden">

    {{-- Peta full-screen --}}
    <div id="map-wilayah-rawan" class="absolute inset-0 z-0"></div>

    {{-- Kartu Filter Mengambang --}}
    <div class="absolute top-4 left-4 w-96 bg-white rounded-2xl shadow-xl p-5 z-10 max-h-[calc(100%-2rem)] overflow-y-auto">

        <div class="flex items-center gap-2 mb-4">
            <div class="bg-green-100 p-2 rounded-lg">
                <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
            </div>
            <h2 class="font-bold text-gray-900">Filter Zona Rawan</h2>
            <button @click="selectedJenis = null; selectedRisiko = ['Tinggi', 'Sedang']" class="ml-auto text-sm text-gray-400 hover:text-gray-600">Reset Filter</button>
        </div>

        {{-- Dropdown wilayah --}}
        <div class="border border-gray-200 rounded-xl px-4 py-3 mb-5 flex justify-between items-center text-sm text-gray-700">
            <span>Kalimantan Selatan ({{ $wilayahRawan->count() }} Titik Aktif)</span>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

        {{-- Jenis bencana --}}
        <div class="flex justify-between items-center mb-2">
            <p class="text-xs font-semibold text-gray-500">1. PILIH JENIS BENCANA</p>
            <template x-if="selectedJenis">
                <span class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full" x-text="selectedJenis + ' Terpilih'"></span>
            </template>
        </div>
        <div class="grid grid-cols-2 gap-3 mb-5">
            @foreach($jenisBencanaList as $jenis)
                @php $info = iconJenisBencana($jenis->nama_jenis); @endphp
                <button
                    @click="selectedJenis = (selectedJenis === '{{ $jenis->nama_jenis }}') ? null : '{{ $jenis->nama_jenis }}'"
                    :class="selectedJenis === '{{ $jenis->nama_jenis }}' ? 'border-blue-500 ring-1 ring-blue-500' : 'border-gray-200'"
                    class="relative border rounded-xl p-3 text-left hover:border-gray-300 transition"
                >
                    <template x-if="selectedJenis === '{{ $jenis->nama_jenis }}'">
                        <span class="absolute top-2 right-2 w-2 h-2 bg-blue-500 rounded-full"></span>
                    </template>
                    <div class="w-9 h-9 rounded-lg {{ $info['color'] }} border flex items-center justify-center mb-2">
                        <img src="{{ asset('images/'.$info['icon']) }}" alt="{{ $jenis->nama_jenis }}" class="w-5 h-5 object-contain">
                    </div>
                    <p class="text-sm font-semibold text-gray-800">{{ $jenis->nama_jenis }}</p>
                    <p class="text-xs text-gray-400">{{ $info['kategori'] }}</p>
                </button>
            @endforeach
        </div>

        {{-- Tingkat risiko --}}
        <p class="text-xs font-semibold text-gray-500 mb-2">2. FILTER TINGKAT RISIKO</p>
        <div class="flex gap-2 mb-5">
            @foreach(['Tinggi' => 'bg-blue-600', 'Sedang' => 'bg-blue-400', 'Rendah' => 'bg-blue-200'] as $tingkat => $dot)
                <button
                    @click="toggleRisiko('{{ $tingkat }}')"
                    :class="selectedRisiko.includes('{{ $tingkat }}') ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-gray-200 text-gray-500'"
                    class="flex-1 flex items-center justify-center gap-1.5 border rounded-full py-2 text-sm font-medium"
                >
                    <span class="w-2 h-2 rounded-full {{ $dot }}"></span>
                    {{ $tingkat }}
                </button>
            @endforeach
        </div>

        <hr class="mb-4">

        {{-- Legenda --}}
        <p class="text-xs font-semibold text-gray-500 mb-2">LEGENDA ZONA TERPILIH</p>
        <div class="space-y-2 text-sm">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-blue-600 inline-block"></span>
                <span class="text-gray-700">Risiko Tinggi</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-blue-400 inline-block"></span>
                <span class="text-gray-700">Risiko Sedang</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-blue-200 inline-block"></span>
                <span class="text-gray-700">Risiko Rendah</span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let map, markers = [], polygons = [];

document.addEventListener('DOMContentLoaded', () => {
    map = L.map('map-wilayah-rawan', { zoomControl: false }).setView([-3.3186, 114.5944], 8);

    L.control.zoom({ position: 'bottomright' }).addTo(map);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    window.allWilayahRawan = {!! Js::from($wilayahRawan->map(fn($w) => [
        'nama_wilayah' => $w->wilayah->nama_wilayah ?? '-',
        'lat' => $w->wilayah->latitude ?? null,
        'lng' => $w->wilayah->longitude ?? null,
        'jenis_bencana' => $w->jenisBencana->nama_jenis ?? '-',
        'tingkat_kerawanan' => $w->tingkat_kerawanan,
        'keterangan' => $w->keterangan,
        'polygon' => $w->polygon,
    ])) !!};

    window.renderMarkers = function() {
        markers.forEach(m => map.removeLayer(m));
        markers = [];

        polygons.forEach(p => map.removeLayer(p));
        polygons = [];

        const alpineEl = document.querySelector('[x-data]');
        const alpineData = Alpine.$data(alpineEl);
        const data = alpineData.filteredData();

        const colorMap = {
            'Tinggi': '#2563eb',
            'Sedang': '#60a5fa',
            'Rendah': '#bfdbfe'
        };

        data.forEach(item => {

            const color = colorMap[item.tingkat_kerawanan] || '#6b7280';

            // POLYGON
            if (item.polygon && item.polygon.length > 0) {

                const polygon = L.polygon(item.polygon, {
                    color: color,
                    fillColor: color,
                    fillOpacity: 0.3,
                    weight: 2
                })
                .bindPopup(`
                    <b>${item.nama_wilayah}</b><br>
                    ${item.jenis_bencana}<br>
                    Kerawanan: ${item.tingkat_kerawanan}<br>
                    ${item.keterangan ?? ''}
                `)
                .addTo(map);

                polygons.push(polygon);
            }

            const marker = L.circleMarker([item.lat, item.lng], {
                radius: 10,
                fillColor: color,
                color: '#fff',
                weight: 2,
                fillOpacity: 0.9
            })
            .bindPopup(`
                <b>${item.nama_wilayah}</b><br>
                ${item.jenis_bencana}<br>
                Kerawanan: ${item.tingkat_kerawanan}<br>
                ${item.keterangan ?? ''}
            `)
            .addTo(map);

            markers.push(marker);
        });
    };

    renderMarkers();
});
</script>
@endpush