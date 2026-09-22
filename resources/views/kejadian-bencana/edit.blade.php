@extends('layouts.admin')

@section('page-title', 'Edit Laporan Kejadian')

@section('content')
<div class="bg-white border border-gray-200 rounded-xl p-8 w-full">

    <h2 class="font-bold text-gray-900 mb-6">Edit Laporan Kejadian Bencana</h2>

    <form action="{{ route('kejadian-bencana.update', $kejadian->id) }}" method="POST" enctype="multipart/form-data" id="formEditAdmin">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1.5">Jenis Bencana <span class="text-red-500">*</span></label>
                <select name="jenis_bencana_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700">
                    <option value="">Pilih Jenis Bencana...</option>
                    @foreach($jenisBencana as $jenis)
                    <option value="{{ $jenis->id }}" @selected($kejadian->jenis_bencana_id == $jenis->id)>
                        {{ $jenis->nama_jenis }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1.5">Tanggal & Waktu Kejadian <span class="text-red-500">*</span></label>
                <input type="datetime-local" name="tanggal_kejadian" required value="{{ \Carbon\Carbon::parse($kejadian->tanggal_kejadian)->format('Y-m-d\TH:i') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6 mb-6">
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1.5">Kabupaten / Kota <span class="text-red-500">*</span></label>
                <select name="wilayah_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700">
                    <option value="">Pilih Kabupaten/Kota...</option>
                    @foreach($wilayah as $w)
                    <option value="{{ $w->id }}" @selected($kejadian->wilayah_id == $w->id)>
                        {{ $w->nama_wilayah }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1.5">Kecamatan / Detail Lokasi</label>
                <input type="text" name="kecamatan" value="{{ $kejadian->kecamatan }}" placeholder="Contoh: Kec. Martapura, Desa Bincau" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1.5">Jumlah Korban <span class="text-gray-400 font-normal">(Jiwa)</span></label>
                <input type="number" name="jumlah_korban" value="{{ $kejadian->jumlah_korban ?? 0 }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700">
            </div>
        </div>

        <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 mb-6">
            <label class="text-sm font-medium text-gray-700 block mb-1">Koordinat Peta (Latitude, Longitude) <span class="text-red-500">*</span></label>
            <p class="text-xs text-gray-500 mb-3">Geser pin pada peta atau masukkan koordinat secara manual untuk memperbarui titik di Web-GIS.</p>

            <div class="grid grid-cols-2 gap-3 mb-3">
                <input type="text" id="latInput" name="latitude" value="{{ $kejadian->latitude }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700">
                <input type="text" id="lngInput" name="longitude" value="{{ $kejadian->longitude }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700">
            </div>

            <div id="mapEditAdmin" style="width:100%; height:300px;" class="rounded-lg border border-gray-200"></div>
        </div>

        <div class="mb-6">
            <label class="text-sm font-medium text-gray-700 block mb-1.5">Deskripsi Kejadian <span class="text-gray-400 font-normal">(Opsional)</span></label>
            <textarea name="deskripsi" rows="4" placeholder="Tuliskan rincian kejadian, kondisi terkini, dampak kerugian, atau keterangan penanganan tambahan..." class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700">{{ $kejadian->deskripsi }}</textarea>
        </div>

        @if($kejadian->gambar)
        <div class="mb-6">
            <label class="text-sm font-medium text-gray-700 block mb-1.5">Gambar Saat Ini</label>
            <img src="{{ asset('storage/' . $kejadian->gambar) }}" class="w-40 h-28 object-cover rounded-lg border border-gray-200">
        </div>
        @endif

        <div class="mb-6">
            <label class="text-sm font-medium text-gray-700 block mb-1.5">Ganti Gambar <span class="text-gray-400 font-normal">(Opsional)</span></label>
            <input type="file" name="gambar" accept="image/jpeg,image/png,image/jpg" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700">
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.kelola-bencana') }}" class="border border-gray-300 text-gray-600 px-6 py-2.5 rounded-lg font-medium hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="bg-green-700 hover:bg-green-800 text-white px-6 py-2.5 rounded-lg font-medium flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const latInput = document.getElementById('latInput');
        const lngInput = document.getElementById('lngInput');

        const startLat = parseFloat(latInput.value) || -3.3194;
        const startLng = parseFloat(lngInput.value) || 114.5908;

        const map = L.map('mapEditAdmin', {
            zoomControl: false
        }).setView([startLat, startLng], 12);
        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
            , maxZoom: 18
        , }).addTo(map);

        const marker = L.marker([startLat, startLng], {
            draggable: true
        }).addTo(map);

        marker.on('dragend', function(e) {
            const pos = e.target.getLatLng();
            latInput.value = pos.lat.toFixed(6);
            lngInput.value = pos.lng.toFixed(6);
        });

        setTimeout(function() {
            map.invalidateSize();
        }, 200);
    });

</script>
@endpush
