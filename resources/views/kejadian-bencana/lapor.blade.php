@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">

    <div class="bg-white border border-gray-200 rounded-xl p-8">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-xl font-bold text-gray-900">Form Laporan Bencana</h1>
            <p class="text-gray-400 text-sm mt-1">
                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
            </p>
        </div>
        <hr class="mb-6 border-gray-200">

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

        <form action="{{ route('kejadian-bencana.store') }}" method="POST" enctype="multipart/form-data" id="formLapor">
            @csrf
            <input type="hidden" name="judul" id="judulHidden">
            <input type="hidden" name="latitude" id="latInput" value="{{ old('latitude', '-3.319400') }}">
            <input type="hidden" name="longitude" id="lngInput" value="{{ old('longitude', '114.590800') }}">

            {{-- Lokasi Kejadian --}}
            <div class="mb-6">
                <label class="text-gray-600 text-sm block mb-2">Lokasi Kejadian :</label>
                <div id="mapLapor" class="w-full h-64 rounded-lg border border-gray-200 z-0"></div>
                <div class="flex items-center justify-between gap-3 mt-2">
                    <p id="infoLokasi" class="text-xs text-gray-400">Klik pada peta atau geser pin untuk menentukan lokasi kejadian.</p>
                    <button type="button" id="btnLokasiSaya" class="text-xs font-medium shrink-0" style="color:#172B6D; text-decoration:underline;">
                        Gunakan lokasi saya
                    </button>
                </div>
            </div>

            {{-- Upload Foto --}}
            <div class="mb-6">
                <label class="text-gray-600 text-sm block mb-2">Upload Foto Kejadian :</label>
                <input type="file" name="gambar" accept="image/*" class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-full text-gray-600
                           file:mr-3 file:rounded-md file:border file:border-gray-300 file:bg-white
                           file:px-3 file:py-1 file:text-xs file:text-gray-700 hover:file:bg-gray-50">
            </div>

            {{-- Jenis Bencana & Tanggal --}}
            <div class="grid grid-cols-2 gap-3 mb-6">
                <div>
                    <label class="text-gray-600 text-sm block mb-2">Jenis Bencana :</label>
                    <select name="jenis_bencana_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700">
                        <option value="">-- Pilih Jenis Bencana --</option>
                        @foreach($jenisBencana as $jenis)
                        <option value="{{ $jenis->id }}" {{ old('jenis_bencana_id') == $jenis->id ? 'selected' : '' }}>
                            {{ $jenis->nama_jenis }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-gray-600 text-sm block mb-2">Tanggal Kejadian :</label>
                    <input type="date" name="tanggal_kejadian" required value="{{ old('tanggal_kejadian', now()->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700">
                </div>
            </div>

            {{-- Kabupaten/Kota & Kecamatan --}}
            <div class="grid grid-cols-2 gap-3 mb-6">
                <div>
                    <label class="text-gray-600 text-sm block mb-2">Kabupaten/Kota :</label>
                    <select name="wilayah_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700">
                        <option value="">-- Pilih Kabupaten/Kota --</option>
                        @foreach($wilayah as $w)
                        <option value="{{ $w->id }}" {{ old('wilayah_id') == $w->id ? 'selected' : '' }}>
                            {{ $w->nama_wilayah }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-gray-600 text-sm block mb-2">Kecamatan :</label>
                    <input type="text" name="kecamatan" value="{{ old('kecamatan') }}" placeholder="Contoh: Kec. Martapura" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700">
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-6">
                <label class="text-gray-600 text-sm block mb-2">Deskripsi (opsional) :</label>
                <textarea name="deskripsi" id="deskripsiInput" rows="5" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700">{{ old('deskripsi') }}</textarea>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3">
                <button type="reset" class="border border-gray-300 text-gray-700 px-8 py-2.5 rounded-lg font-medium hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" class="bg-[#172B6D] hover:opacity-90 text-white px-8 py-2.5 rounded-lg font-medium flex items-center gap-2">
                    Submit
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="4" stroke-width="1.8" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12l2.5 2.5L16 9" />
                    </svg>
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
            <h3 class="text-xl font-bold text-gray-900 mb-2">Laporan Berhasil Disubmit!</h3>
            <p class="text-sm text-gray-600 mb-6">
                {{ session('success') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <button type="button" onclick="closeSuccessModal()" class="w-full sm:w-1/2 px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Tutup
                </button>
                <a href="{{ route('peta-bencana') }}" class="w-full sm:w-1/2 px-4 py-2.5 bg-[#172B6D] hover:opacity-90 text-white rounded-lg text-sm font-medium flex items-center justify-center gap-1.5 transition-all">
                    Lihat di Peta
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const defaultLat = -3.3194;
        const defaultLng = 114.5908;

        const form = document.getElementById('formLapor');
        const latInput = document.getElementById('latInput');
        const lngInput = document.getElementById('lngInput');

        // Kalau form dikembalikan karena error, pakai lagi koordinat yang tadi dipilih
        const startLat = parseFloat(latInput.value) || defaultLat;
        const startLng = parseFloat(lngInput.value) || defaultLng;

        const map = L.map('mapLapor', {
            zoomControl: false
        }).setView([startLat, startLng], 8);

        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
            , maxZoom: 18
        , }).addTo(map);

        // Pin merah (SVG), tidak bergantung pada gambar bawaan Leaflet
        const pinIcon = L.divIcon({
            className: ''
            , html: '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="36" viewBox="0 0 24 32" style="display:block">' +
                '<path fill="#B91C1C" d="M12 0C5.4 0 0 5.4 0 12c0 9 12 20 12 20s12-11 12-20C24 5.4 18.6 0 12 0z"/>' +
                '<circle cx="12" cy="12" r="4.5" fill="#ffffff"/></svg>'
            , iconSize: [28, 36]
            , iconAnchor: [14, 36]
        , });

        const marker = L.marker([startLat, startLng], {
            icon: pinIcon
            , draggable: true
        }).addTo(map);

        function setKoordinat(lat, lng) {
            latInput.value = lat.toFixed(6);
            lngInput.value = lng.toFixed(6);
        }
        setKoordinat(startLat, startLng);

        // Geser pin
        marker.on('dragend', function(e) {
            const pos = e.target.getLatLng();
            setKoordinat(pos.lat, pos.lng);
        });

        // Klik peta
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            setKoordinat(e.latlng.lat, e.latlng.lng);
        });

        // Deteksi lokasi pelapor (otomatis saat halaman dibuka, atau lewat tombol)
        const infoLokasi = document.getElementById('infoLokasi');
        const teksAwal = infoLokasi.textContent;
        const sudahAdaLokasi = {{ old('latitude') ? 'true' : 'false' }};

        function gunakanLokasiSaya() {
            if (!navigator.geolocation) {
                infoLokasi.textContent = 'Browser tidak mendukung deteksi lokasi. ' + teksAwal;
                return;
            }
            infoLokasi.textContent = 'Mencari lokasi Anda...';
            navigator.geolocation.getCurrentPosition(
                function(pos) {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;
                    marker.setLatLng([lat, lng]);
                    map.setView([lat, lng], 15);
                    setKoordinat(lat, lng);
                    infoLokasi.textContent = 'Lokasi Anda terdeteksi. Geser pin jika lokasi kejadian berbeda.';
                }
                , function() {
                    infoLokasi.textContent = 'Lokasi tidak bisa dideteksi. ' + teksAwal;
                }, {
                    enableHighAccuracy: true
                    , timeout: 10000
                }
            );
        }

        document.getElementById('btnLokasiSaya').addEventListener('click', gunakanLokasiSaya);

        // Jalan otomatis, kecuali form dikembalikan karena error (pin sudah dipilih pelapor)
        if (!sudahAdaLokasi) {
            gunakanLokasiSaya();
        }

        // Tombol Batal: kembalikan pin ke titik awal
        form.addEventListener('reset', function() {
            marker.setLatLng([defaultLat, defaultLng]);
            map.setView([defaultLat, defaultLng], 8);
            setTimeout(function() {
                setKoordinat(defaultLat, defaultLng);
            }, 0);
        });

        setTimeout(function() {
            map.invalidateSize();
        }, 200);

        // Judul otomatis dari deskripsi saat form disubmit
        form.addEventListener('submit', function() {
            const deskripsi = document.getElementById('deskripsiInput').value.trim();
            document.getElementById('judulHidden').value = deskripsi.split('.')[0].substring(0, 100) || 'Laporan Bencana';
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