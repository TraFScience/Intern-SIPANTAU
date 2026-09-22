@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    <a href="{{ route('berita-page') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Pusat Berita & Informasi
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Konten utama --}}
        <div class="lg:col-span-2">
            @if($berita->kategori ?? false)
                <span class="inline-block bg-red-50 text-red-700 text-xs font-bold uppercase px-3 py-1 rounded-full mb-3">
                    Bencana {{ $berita->kategori }}
                </span>
            @endif

            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-snug mb-3">
                {{ $berita->judul }}
            </h1>

            <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
                <span>{{ $berita->user->name ?? 'Admin SIPANTAU' }}</span>
                <span>&middot;</span>
                <span>{{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y, H:i') }}</span>
            </div>

            @if($berita->gambar)
                <img src="{{ asset('storage/'.$berita->gambar) }}" alt="{{ $berita->judul }}"
                    class="w-full h-72 md:h-96 object-cover rounded-xl mb-6">
            @endif

            <div class="prose prose-sm md:prose-base max-w-none text-gray-700" style="word-break: break-word;">
                {!! $berita->isi !!}
            </div>

            <div class="bg-green-800 rounded-xl p-6 mt-8 flex items-center justify-between gap-4 flex-wrap">
                <div>
                    <p class="text-white font-semibold">Ingin melihat titik terdampak di wilayah ini?</p>
                    <p class="text-green-200 text-sm mt-1">Pantau sebaran dan status verifikasi langsung di Peta Bencana.</p>
                </div>
                <a href="{{ route('peta-bencana') }}"
                    class="bg-white text-green-800 font-medium px-5 py-2.5 rounded-lg whitespace-nowrap hover:bg-green-50">
                    Buka Peta Bencana
                </a>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                    <span class="font-semibold text-gray-800 text-sm">Peta Pantauan Bencana</span>
                    <a href="{{ route('peta-bencana') }}" class="text-xs text-green-700 hover:underline">Lihat Detail</a>
                </div>
                <div id="miniMap" style="width:100%; height:180px;"></div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-100">
                    <span class="font-semibold text-gray-800 text-sm">Berita Terkait & Terpopuler</span>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($beritaTerkait as $item)
                        <a href="{{ route('berita.show', $item->id) }}" class="flex gap-3 px-4 py-3 hover:bg-gray-50">
                            <div class="w-14 h-14 rounded-lg bg-gray-100 shrink-0 overflow-hidden">
                                @if($item->gambar)
                                    <img src="{{ asset('storage/'.$item->gambar) }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-800 line-clamp-2">{{ $item->judul }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-6">Belum ada berita lain.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const map = L.map('miniMap', { zoomControl: false, dragging: false, scrollWheelZoom: false })
            .setView([-3.3194, 114.5908], 8);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 18,
        }).addTo(map);

        setTimeout(function () {
            map.invalidateSize();
        }, 200);
    });
</script>
@endpush