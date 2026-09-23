@extends('layouts.admin')

@section('page-title', 'Input Laporan Kejadian')

@section('content')
<div class="bg-white border border-gray-200 rounded-xl p-8 w-full">

    <h2 class="font-bold text-gray-900 mb-6">Form Pelaporan Kejadian Bencana Baru</h2>

    {{-- Pesan sukses --}}
    @if (session('success'))
    <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800 font-bold ml-4 text-base leading-none">&times;</button>
    </div>
    @endif

    {{-- Pesan error validasi --}}
    @if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('kejadian-bencana.store') }}" method="POST" enctype="multipart/form-data" id="formInputAdmin">
        @csrf
        <input type="hidden" name="judul" id="judulHidden">

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1.5">Jenis Bencana <span class="text-red-500">*</span></label>
                <select name="jenis_bencana_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700">
                    <option value="">Pilih Jenis Bencana...</option>
                    @foreach($jenisBencana as $jenis)
                    <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1.5">Tanggal & Waktu Kejadian <span class="text-red-500">*</span></label>
                <input type="datetime-local" name="tanggal_kejadian" required value="{{ now()->format('Y-m-d\TH:i') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1.5">Kabupaten / Kota <span class="text-red-500">*</span></label>
                <select name="wilayah_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700">
                    <option value="">Pilih Kabupaten/Kota...</option>
                    @foreach($wilayah as $w)
                    <option value="{{ $w->id }}">{{ $w->nama_wilayah }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1.5">Kecamatan / Detail Lokasi</label>
                <input type="text" name="kecamatan" placeholder="Contoh: Kec. Martapura, Desa Bincau" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700">
            </div>
        </div>

        <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 mb-6">
            <label class="text-sm font-medium text-gray-700 block mb-1">Koordinat Peta (Latitude, Longitude) <span class="text-red-500">*</span></label>
            <p class="text-xs text-gray-500 mb-3">Geser pin pada peta atau masukkan koordinat secara manual untuk memunculkan marker di Web-GIS.</p>

            <div class="grid grid-cols-2 gap-3 mb-3">
                <input type="text" id="latInput" name="latitude" value="-3.3194" class="border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700">
                <input type="text" id="lngInput" name="longitude" value="114.5908" class="border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700">
            </div>

            <div id="mapInputAdmin" style="width:100%; height:300px;" class="rounded-lg border border-gray-200 relative z-0"></div>
        </div>

        <div class="mb-6">
            <label class="text-sm font-medium text-gray-700 block mb-1.5">Deskripsi Kejadian <span class="text-gray-400 font-normal">(Opsional)</span></label>
            <textarea name="deskripsi" id="deskripsiInputAdmin" rows="4" placeholder="Tuliskan rincian kejadian, kondisi terkini, dampak kerugian, atau keterangan penanganan tambahan..." class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700"></textarea>
        </div>

        <div class="flex justify-end gap-3">
            <button type="reset" class="border border-gray-300 text-gray-600 px-6 py-2.5 rounded-lg font-medium hover:bg-gray-50">
                Batal
            </button>
            <button type="submit" class="bg-green-700 hover:bg-green-800 text-white px-6 py-2.5 rounded-lg font-medium flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                Simpan Laporan
            </button>
        </div>
    </form>
</div>

{{-- Modal Konfirmasi Sukses Setelah Submit --}}
@if (session('success'))
<div id="successModal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6 text-center transform transition-all relative border border-gray-100">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 text-green-600 mb-4">
            <svg class="h-9 w-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Laporan Berhasil Disimpan!</h3>
        <p class="text-sm text-gray-600 mb-6">
            {{ session('success') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <button type="button" onclick="closeSuccessModal()" class="w-full sm:w-1/2 px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                Tutup
            </button>
            <a href="{{ route('admin.kelola-bencana') }}" class="w-full sm:w-1/2 px-4 py-2.5 bg-green-700 hover:bg-green-800 text-white rounded-lg text-sm font-medium flex items-center justify-center gap-1.5 transition-all">
                Kelola Bencana
            </a>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const latInput = document.getElementById('latInput');
        const lngInput = document.getElementById('lngInput');

        const map = L.map('mapInputAdmin', {
            zoomControl: false
        }).setView([-3.3194, 114.5908], 8);
        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
            , maxZoom: 18
        , }).addTo(map);

        const customIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png'
            , shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png'
            , iconSize: [25, 41]
            , iconAnchor: [12, 41]
            , popupAnchor: [1, -34]
            , shadowSize: [41, 41]
        });

        const marker = L.marker([-3.3194, 114.5908], {
            draggable: true
            , icon: customIcon
        }).addTo(map);

        marker.on('dragend', function(e) {
            const pos = e.target.getLatLng();
            latInput.value = pos.lat.toFixed(6);
            lngInput.value = pos.lng.toFixed(6);
        });

        setTimeout(function() {
            map.invalidateSize();
        }, 200);

        document.getElementById('formInputAdmin').addEventListener('submit', function() {
            const deskripsi = document.getElementById('deskripsiInputAdmin').value.trim();
            document.getElementById('judulHidden').value = deskripsi.split('.')[0].substring(0, 100) || 'Laporan Kejadian';
        });

        // Kontrol Modal Konfirmasi Sukses (Post-Submit)
        window.closeSuccessModal = function() {
            const successModal = document.getElementById('successModal');
            if (successModal) {
                successModal.classList.add('hidden');
                successModal.classList.remove('flex');
            }
        };

        const successModal = document.getElementById('successModal');
        if (successModal) {
            successModal.addEventListener('click', function(e) {
                if (e.target === successModal) {
                    closeSuccessModal();
                }
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSuccessModal();
            }
        });
    });

</script>
@endpush

