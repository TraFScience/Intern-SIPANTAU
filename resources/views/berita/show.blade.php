@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">

    <a href="{{ route('berita.index') }}"
       class="inline-flex items-center text-green-700 font-medium hover:underline mb-6">
        ← Kembali ke Berita
    </a>

    <article class="bg-white border border-gray-200 rounded-xl overflow-hidden">

        @if($berita->gambar)
            <img
                src="{{ asset('storage/' . $berita->gambar) }}"
                alt="{{ $berita->judul }}"
                class="w-full h-80 object-cover"
            >
        @endif

        <div class="p-6">

            <span class="inline-block text-xs font-medium px-2.5 py-1 rounded-full bg-green-50 text-green-700">
                {{ $berita->kategori ?? 'Umum' }}
            </span>

            <h1 class="text-3xl font-bold text-gray-900 mt-4">
                {{ $berita->judul }}
            </h1>

            <div class="text-sm text-gray-400 mt-2">
                {{ $berita->user->name ?? 'Admin SIPANTAU' }}
                ·
                {{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y') }}
            </div>

            <div class="mt-6 text-gray-700 leading-relaxed whitespace-pre-line">
                {{ $berita->isi }}
            </div>

        </div>
    </article>

</div>
@endsection