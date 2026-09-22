@extends('layouts.admin')

@section('page-title', 'Detail Berita')

@section('content')
<div class="max-w-4xl mx-auto">

    <a href="{{ route('admin.kelola-berita') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Kembali ke Kelola Berita
    </a>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden p-6 md:p-8">

        <div class="flex justify-between items-center mb-3">
            @if($berita->kategori ?? false)
            <span class="inline-block bg-green-50 text-green-700 text-xs font-bold uppercase px-3 py-1 rounded-full">
                {{ $berita->kategori }}
            </span>
            @else
            <span></span>
            @endif
            <span class="text-xs text-gray-400">
                Diperbarui: {{ \Carbon\Carbon::parse($berita->updated_at)->translatedFormat('d M Y, H:i') }} WITA
            </span>
        </div>

        <h1 class="text-xl md:text-2xl font-bold text-gray-900 leading-snug mb-4">
            {{ $berita->judul }}
        </h1>

        <div class="flex justify-between items-center mb-6 pb-6 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center font-bold text-green-700 text-sm">
                    {{ substr($berita->user->name ?? 'A', 0, 1) }}
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">{{ $berita->user->name ?? 'Admin SIPANTAU' }}</p>
                </div>
            </div>
            <div class="flex items-center gap-4 text-xs text-gray-400">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    {{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d F Y') }}
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    0 Pembaca
                </span>
            </div>
        </div>

        @if($berita->gambar)
        <img src="{{ asset('storage/'.$berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full max-h-[500px] object-contain rounded-xl mb-6 bg-gray-50">
        @endif

        <div class="prose prose-sm md:prose-base max-w-none text-gray-700" style="word-break: break-word;">
            {!! $berita->isi !!}
        </div>

        <div class="flex flex-wrap items-center gap-3 mt-8 pt-6 border-t border-gray-100">
            <a href="{{ route('berita.edit', $berita->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                Ubah Artikel
            </a>

            <button type="button" onclick="salinTautan()" class="border border-gray-300 text-gray-600 px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 010 5.656l-3 3a4 4 0 01-5.656-5.656l1.5-1.5M10.172 13.828a4 4 0 010-5.656l3-3a4 4 0 015.656 5.656l-1.5 1.5" /></svg>
                Salin Tautan Publik
            </button>

            <button type="button" onclick="window.print()" class="border border-gray-300 text-gray-600 px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H7v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Cetak
            </button>

            <form action="{{ route('berita.destroy', $berita->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus artikel ini?');" class="ml-auto">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-700 px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    Hapus Artikel
                </button>
            </form>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function salinTautan() {
        const url = "{{ route('berita.show', $berita->id) }}";
        navigator.clipboard.writeText(url).then(function() {
            alert('Tautan publik berhasil disalin!');
        });
    }

</script>
@endpush
@endsection

