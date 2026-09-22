@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pusat Berita & Informasi</h1>
            <p class="text-gray-500 mt-1">Informasi terkini dan artikel edukasi kesiapsiagaan bencana</p>
        </div>
        <input type="text" placeholder="Cari berita..."
               class="border border-gray-300 rounded-lg px-4 py-2 w-64">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($berita as $b)
            <div class="border border-gray-200 rounded-xl overflow-hidden {{ $b['gelap'] ? 'bg-[#316244] text-white' : 'bg-white' }}">
    <div class="h-40 flex items-center justify-center {{ $b['gelap'] ? 'bg-[#316244]' : 'bg-gray-200' }}">
                    @if($b->gambar)
                        <img src="{{ asset('storage/'.$b->gambar) }}" alt="{{ $b->judul }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900">{{ $b->judul }}</h3>
                    <p class="text-sm mt-2 text-gray-500">{{ Str::limit(strip_tags($b->isi), 120) }}</p>
                    <div class="flex justify-between items-center mt-4 text-xs text-gray-400">
                        <span>{{ $b->user->name ?? 'Admin SIPANTAU' }} · {{ \Carbon\Carbon::parse($b->tanggal)->format('d M Y') }}</span>
                        <a href="{{ route('berita.show', $b->id) }}" class="text-green-700 font-medium hover:underline">Baca Selengkapnya →</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-400 col-span-3">Belum ada berita yang diterbitkan.</p>
        @endforelse
    </div>
</div>
@endsection