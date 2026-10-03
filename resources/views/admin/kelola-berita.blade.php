@extends('layouts.admin')

@section('page-title', 'Kelola Berita')

@section('content')
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

    {{-- Toolbar --}}
    <div class="flex justify-between items-center px-6 py-5">
        <a href="{{ route('berita.create') }}" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Artikel Baru
        </a>

        <div class="relative flex items-center">
            <svg class="w-4 h-4 text-gray-400 absolute pointer-events-none" style="left: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z"/></svg>
            <input type="text" id="cari-berita" placeholder="Cari artikel..." style="padding-left: 36px;"
                class="border border-gray-300 rounded-lg pr-4 py-2 text-sm w-64">
        </div>
    </div>

    @if(session('success'))
        <div class="mx-6 mb-4 rounded-lg bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- Grid Card --}}
    <div class="px-6 pb-6">
        <div id="grid-berita" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @forelse($berita as $b)
                @php
                    $kategoriColor = match($b->kategori ?? '') {
                        'Edukasi'   => 'bg-green-50 text-green-700',
                        'Mitigasi'  => 'bg-orange-50 text-orange-700',
                        'Informasi' => 'bg-blue-50 text-blue-700',
                        'Berita'    => 'bg-purple-50 text-purple-700',
                        default     => 'bg-gray-100 text-gray-600',
                    };
                @endphp

                <div class="kartu-berita flex flex-col border border-gray-200 rounded-xl overflow-hidden bg-white hover:shadow-md transition"
                     data-judul="{{ strtolower($b->judul) }}">

                    {{-- Gambar --}}
                    <div class="h-40 bg-gray-100 flex items-center justify-center">
                        @if($b->gambar)
                            <img src="{{ asset('storage/'.$b->gambar) }}" alt="{{ $b->judul }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-10 h-10 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </div>

                    {{-- Isi --}}
                    <div class="p-4 flex-1 flex flex-col">
                        <div>
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $kategoriColor }}">
                                {{ $b->kategori ?? 'Umum' }}
                            </span>
                        </div>
                        <h3 class="font-semibold text-gray-900 mt-3 line-clamp-2">{{ $b->judul }}</h3>
                        <p class="text-sm text-gray-500 mt-2 line-clamp-3">{{ Str::limit(strip_tags($b->isi), 120, '...') }}</p>
                    </div>

                    {{-- Footer: tanggal + aksi --}}
                    <div class="flex items-center justify-between gap-2 border-t border-gray-100 px-4 py-3">
                        <span class="text-xs text-gray-500 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($b->tanggal)->translatedFormat('d F Y') }}
                        </span>

                        <div class="flex items-center gap-2">
                            {{-- Lihat --}}
                            <a href="{{ route('admin.berita.show-admin', $b->id) }}" title="Lihat"
                               class="w-8 h-8 flex items-center justify-center rounded-lg bg-green-600 text-white hover:bg-green-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('berita.edit', $b->id) }}" title="Edit"
                               class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>

                            {{-- Hapus --}}
                            <form action="{{ route('berita.destroy', $b->id) }}" method="POST"
                                  onsubmit="return confirm('Apakah kamu yakin ingin menghapus artikel ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Hapus"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-600 text-white hover:bg-red-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-center py-8 md:col-span-2 xl:col-span-3">
                    Belum ada artikel yang diterbitkan.
                </p>
            @endforelse
        </div>

        <p id="berita-kosong" class="hidden text-gray-400 text-center py-8">Tidak ada artikel yang cocok dengan pencarian.</p>
    </div>

    {{-- Footer: info + pagination --}}
    <div class="px-6 py-4 border-t border-gray-100 flex justify-between items-center text-sm text-gray-500">
        <span>
            @if(method_exists($berita, 'total') && $berita->total() > 0)
                Menampilkan {{ $berita->firstItem() }} hingga {{ $berita->lastItem() }} dari {{ $berita->total() }} artikel
            @else
                Menampilkan {{ count($berita) }} artikel
            @endif
        </span>

        @if(method_exists($berita, 'links'))
            <div>
                {{ $berita->links() }}
            </div>
        @endif
    </div>

</div>

{{-- Pencarian sederhana: menyaring kartu pada halaman yang sedang dibuka --}}
<script>
    (function () {
        const input = document.getElementById('cari-berita');
        const kosong = document.getElementById('berita-kosong');
        if (!input) return;

        input.addEventListener('input', function () {
            const q = this.value.trim().toLowerCase();
            let tampil = 0;
            document.querySelectorAll('.kartu-berita').forEach(function (el) {
                const cocok = el.dataset.judul.includes(q);
                el.style.display = cocok ? '' : 'none';
                if (cocok) tampil++;
            });
            kosong.classList.toggle('hidden', tampil > 0 || q === '');
        });
    })();
</script>
@endsection