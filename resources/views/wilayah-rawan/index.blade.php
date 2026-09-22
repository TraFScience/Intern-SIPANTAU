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
    selectedRisiko: [],
    keteranganMap: {
        'banjir': { Tinggi: 'Genangan > 1.5 m', Sedang: 'Genangan 0.5 - 1.5 m', Rendah: 'Genangan < 0.5 m' },
        'karhutla': { Tinggi: 'Titik api & asap pekat', Sedang: 'Potensi titik api sedang', Rendah: 'Potensi titik api rendah' },
        'kebakaran': { Tinggi: 'Titik api & asap pekat', Sedang: 'Potensi titik api sedang', Rendah: 'Potensi titik api rendah' },
        'puting': { Tinggi: 'Angin > 60 km/jam', Sedang: 'Angin 30 - 60 km/jam', Rendah: 'Angin < 30 km/jam' },
        'angin': { Tinggi: 'Angin > 60 km/jam', Sedang: 'Angin 30 - 60 km/jam', Rendah: 'Angin < 30 km/jam' },
        'longsor': { Tinggi: 'Kemiringan lereng > 40°', Sedang: 'Kemiringan lereng 15 - 40°', Rendah: 'Kemiringan lereng < 15°' },
    },
    keteranganRisiko(tingkat) {
        if (!this.selectedJenis) return '-';
        const jenis = this.selectedJenis.toLowerCase();
        const key = Object.keys(this.keteranganMap).find(k => jenis.includes(k));
        return key ? this.keteranganMap[key][tingkat] : '-';
    },
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
class="relative h-[620px] overflow-hidden">

    {{-- Peta --}}
    <div id="map-wilayah-rawan" class="absolute inset-0 z-0"></div>

    {{-- Kartu Filter Mengambang --}}
    <div class="absolute top-4 left-4 w-72 bg-white rounded-2xl shadow-xl z-10 max-h-[380px] overflow-hidden">
        <div class="p-4 max-h-[380px] overflow-y-auto">

        <div class="flex items-center gap-2 mb-3">
            <div class="bg-green-100 p-2 rounded-lg">
                <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
            </div>
            <h2 class="font-bold text-gray-900 text-sm">Filter Zona Rawan</h2>
            <button @click="selectedJenis = null; selectedRisiko = []" class="ml-auto text-xs text-gray-400 hover:text-gray-600">Reset Filter</button>
        </div>

        {{-- Dropdown wilayah --}}
        <div class="border border-gray-200 rounded-xl px-3 py-2 mb-3 flex justify-between items-center text-xs text-gray-700">
            <span>Kalimantan Selatan ({{ $wilayahRawan->count() }} Titik Aktif)</span>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

        {{-- Jenis bencana --}}
        <div class="flex justify-between items-center mb-2">
            <p class="text-[10px] font-semibold text-gray-500">1. PILIH JENIS BENCANA</p>
            <template x-if="selectedJenis">
                <span class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full" x-text="selectedJenis + ' Terpilih'"></span>
            </template>
        </div>
        <div class="flex flex-wrap gap-2 mb-3">
            @foreach($jenisBencanaList as $jenis)
                @php $info = iconJenisBencana($jenis->nama_jenis); @endphp
                <button
                    @click="selectedJenis = (selectedJenis === '{{ $jenis->nama_jenis }}') ? null : '{{ $jenis->nama_jenis }}'"
                    :class="selectedJenis === '{{ $jenis->nama_jenis }}' ? 'border-blue-500 ring-1 ring-blue-500' : 'border-gray-200'"
                    class="relative border rounded-lg p-1.5 text-left hover:border-gray-300 transition w-28"
                >
                    <template x-if="selectedJenis === '{{ $jenis->nama_jenis }}'">
                        <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                    </template>
                    <div class="w-6 h-6 rounded-md {{ $info['color'] }} border flex items-center justify-center mb-1">
                        <img src="{{ asset('images/'.$info['icon']) }}" alt="{{ $jenis->nama_jenis }}" class="w-3.5 h-3.5 object-contain">
                    </div>
                    <p class="text-xs font-semibold text-gray-800">{{ $jenis->nama_jenis }}</p>
                    <p class="text-[10px] text-gray-400">{{ $info['kategori'] }}</p>
                </button>
            @endforeach
        </div>

        {{-- Tingkat risiko --}}
        <p class="text-[10px] font-semibold text-gray-500 mb-2">2. FILTER TINGKAT RISIKO</p>
        <div class="flex gap-2 mb-3">
            @foreach(['Tinggi' => 'bg-gray-700', 'Sedang' => 'bg-gray-400', 'Rendah' => 'bg-gray-200'] as $tingkat => $dot)
                <button
                    @click="toggleRisiko('{{ $tingkat }}')"
                    :class="selectedRisiko.includes('{{ $tingkat }}') ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-gray-200 text-gray-500'"
                    class="flex-1 flex items-center justify-center gap-1 border rounded-full py-1 text-xs font-medium"
                >
                    <span class="w-2 h-2 rounded-full {{ $dot }}"></span>
                    {{ $tingkat }}
                </button>
            @endforeach
        </div>

        <hr class="mb-3">

        {{-- Legenda --}}
        <p class="text-[10px] font-semibold text-gray-500 mb-2">LEGENDA ZONA TERPILIH</p>
        <div class="space-y-1 text-xs">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-gray-700 inline-block"></span>
                    <span class="text-gray-700">Risiko Tinggi</span>
                </div>
                <span class="text-[10px] text-gray-400" x-text="keteranganRisiko('Tinggi')"></span>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-gray-400 inline-block"></span>
                    <span class="text-gray-700">Risiko Sedang</span>
                </div>
                <span class="text-[10px] text-gray-400" x-text="keteranganRisiko('Sedang')"></span>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-gray-200 inline-block"></span>
                    <span class="text-gray-700">Risiko Rendah</span>
                </div>
                <span class="text-[10px] text-gray-400" x-text="keteranganRisiko('Rendah')"></span>
            </div>
        </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
let map, markers = [], polygons = [];

document.addEventListener('DOMContentLoaded', () => {
    const kalselBounds = L.latLngBounds(
        L.latLng(-4.4, 113.8),
        L.latLng(-1.5, 116.5)
    );

    map = L.map('map-wilayah-rawan', {
        zoomControl: false,
        maxBounds: kalselBounds,
        maxBoundsViscosity: 1.0,
        minZoom: 7
    }).setView([-3.0, 115.2], 8);

    map.fitBounds(kalselBounds);

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

    function getBaseColorRGB(jenis) {
        const j = (jenis || '').toLowerCase();
        if (j.includes('banjir')) return [37, 99, 235];
        if (j.includes('karhutla') || j.includes('kebakaran')) return [220, 38, 38];
        if (j.includes('puting') || j.includes('angin')) return [217, 119, 6];
        if (j.includes('longsor')) return [120, 53, 15];
        return [107, 114, 128];
    }

    function getOpacityByTingkat(tingkat) {
        if (tingkat === 'Tinggi') return 0.85;
        if (tingkat === 'Sedang') return 0.5;
        if (tingkat === 'Rendah') return 0.25;
        return 0.5;
    }

    window.renderMarkers = function() {
        markers.forEach(m => map.removeLayer(m));
        markers = [];

        polygons.forEach(p => map.removeLayer(p));
        polygons = [];

        const alpineEl = document.querySelector('[x-data]');
        const alpineData = Alpine.$data(alpineEl);
        const data = alpineData.filteredData();

        data.forEach(item => {

            const [r, g, b] = getBaseColorRGB(item.jenis_bencana);
            const opacity = getOpacityByTingkat(item.tingkat_kerawanan);
            const color = `rgb(${r}, ${g}, ${b})`;

            // POLYGON
            if (item.polygon && item.polygon.length > 0) {

                const polygon = L.polygon(item.polygon, {
                    color: color,
                    fillColor: color,
                    fillOpacity: opacity,
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
                fillOpacity: opacity
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
@endsection