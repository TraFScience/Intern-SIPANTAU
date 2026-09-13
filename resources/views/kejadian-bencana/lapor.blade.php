@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">

    <div class="bg-white border border-gray-200 rounded-xl p-8">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-xl font-bold text-gray-900">Form Laporan Bencana</h1>
            <p class="text-gray-400 text-sm mt-1">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <hr class="mb-6 border-gray-200">

        <form action="{{ route('kejadian-bencana.store') }}" method="POST" enctype="multipart/form-data" id="formLapor">
            @csrf
            <input type="hidden" name="tanggal_kejadian" value="{{ now()->format('Y-m-d') }}">
            <input type="hidden" name="judul" id="judulHidden">

            {{-- Lokasi Kejadian --}}
            <div class="mb-6">
                <label class="text-gray-600 text-sm block mb-2">Lokasi Kejadian:</label>

                <div id="mapLapor" class="w-full h-64 rounded-lg border border-gray-200 mb-3"></div>

                <div class="grid grid-cols-2 gap-3">
                    <select name="jenis_bencana_id" required
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700">
                        <option value="">-- Jenis Bencana --</option>
                        @foreach($jenisBencana as $jenis)
                            <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                        @endforeach
                    </select>
                    <select name="wilayah_id" required
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700">
                        <option value="">-- Wilayah --</option>
                        @foreach($wilayah as $w)
                            <option value="{{ $w->id }}">{{ $w->nama_wilayah }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Upload Foto --}}
            <div class="mb-6">
                <label class="text-gray-600 text-sm block mb-2">Upload Foto Kejadian :</label>
                <input type="file" name="gambar" accept="image/*"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-full text-gray-600">
            </div>

            {{-- Deskripsi --}}
            <div class="mb-6">
                <label class="text-gray-600 text-sm block mb-2">Deskripsi :</label>
                <textarea name="deskripsi" id="deskripsiInput" rows="5" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700"></textarea>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3">
                <button type="reset"
                    class="border border-gray-300 text-gray-700 px-8 py-2.5 rounded-lg font-medium hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                    class="bg-[#172B6D] hover:opacity-90 text-white px-8 py-2.5 rounded-lg font-medium flex items-center gap-2">
                    Submit
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="4" stroke-width="1.8"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12l2.5 2.5L16 9" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const map = L.map('mapLapor').setView([-3.3194, 114.5908], 8);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 18,
        }).addTo(map);
        L.marker([-3.3194, 114.5908]).addTo(map);

        document.getElementById('formLapor').addEventListener('submit', function () {
            const deskripsi = document.getElementById('deskripsiInput').value.trim();
            document.getElementById('judulHidden').value = deskripsi.split('.')[0].substring(0, 100) || 'Laporan Bencana';
        });
    });
</script>
@endpush