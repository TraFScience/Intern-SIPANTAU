@extends('layouts.admin')

@section('page-title', 'Kelola Artikel & Informasi Edukasi')

@section('content')
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

    <div class="flex justify-between items-center px-6 py-5">
        <a href="{{ route('berita.create') }}" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Artikel Baru
        </a>

        <input type="text" placeholder="Cari artikel..."
            class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-64">
    </div>

    <table class="w-full text-left text-sm">
        <thead>
            <tr class="text-gray-500 border-t border-b border-gray-100 uppercase text-xs">
                <th class="px-6 py-3">No</th>
                <th class="px-6 py-3">Judul Artikel</th>
                <th class="px-6 py-3">Kategori</th>
                <th class="px-6 py-3">Tanggal Publikasi</th>
                <th class="px-6 py-3">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($berita as $i => $b)
                <tr class="border-b border-gray-50">
                    <td class="px-6 py-4 text-gray-500">{{ $i + 1 }}</td>

                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $b->judul }}
                    </td>

                    <td class="px-6 py-4">
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-green-50 text-green-700">
                            {{ $b->kategori ?? 'Umum' }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-gray-600">
                        {{ \Carbon\Carbon::parse($b->tanggal)->translatedFormat('d F Y') }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">

                            {{-- Lihat --}}
                            <a href="{{ route('berita.show', $b->id) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-green-700 hover:bg-green-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('berita.edit', $b->id) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>

                            {{-- Hapus --}}
                            <form action="{{ route('berita.destroy', $b->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Apakah kamu yakin ingin menghapus artikel ini?');">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-red-600 hover:bg-red-50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                        Belum ada artikel yang diterbitkan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="px-6 py-4 flex justify-between items-center text-sm text-gray-500">
        <span>
            Menampilkan 1 hingga {{ count($berita) }} dari {{ count($berita) }} artikel
        </span>
    </div>

</div>
@endsection