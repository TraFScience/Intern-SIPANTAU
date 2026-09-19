@extends('layouts.admin')

@section('page-title', 'Edit Artikel')

@section('content')
<div class="max-w-4xl mx-auto">

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-900">Edit Artikel</h2>
            <p class="text-sm text-gray-500 mt-1">
                Perbarui informasi artikel.
            </p>
        </div>

        <form action="{{ route('berita.update', $berita->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="p-6">

            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Artikel
                </label>

                <input
                    type="text"
                    id="judul"
                    name="judul"
                    value="{{ old('judul', $berita->judul) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm"
                    required
                >

                @error('judul')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                    Kategori
                </label>

                <select
                    id="kategori"
                    name="kategori"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm"
                >
                    <option value="">Pilih kategori</option>

                    <option value="Edukasi" {{ old('kategori', $berita->kategori) == 'Edukasi' ? 'selected' : '' }}>
                        Edukasi
                    </option>

                    <option value="Berita" {{ old('kategori', $berita->kategori) == 'Berita' ? 'selected' : '' }}>
                        Berita
                    </option>

                    <option value="Informasi" {{ old('kategori', $berita->kategori) == 'Informasi' ? 'selected' : '' }}>
                        Informasi
                    </option>
                </select>

                @error('kategori')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="isi" class="block text-sm font-medium text-gray-700 mb-2">
                    Isi Artikel
                </label>

                <textarea
                    id="isi"
                    name="isi"
                    rows="8"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm"
                    required
                >{{ old('isi', $berita->isi) }}</textarea>

                @error('isi')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">
                    Gambar Artikel
                </label>

                @if($berita->gambar)
                    <img
                        src="{{ asset('storage/'.$berita->gambar) }}"
                        alt="{{ $berita->judul }}"
                        class="w-48 h-32 object-cover rounded-lg mb-3"
                    >
                @endif

                <input
                    type="file"
                    id="gambar"
                    name="gambar"
                    accept=".jpg,.jpeg,.png"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm"
                >

                <p class="text-xs text-gray-400 mt-1">
                    Kosongkan jika tidak ingin mengganti gambar.
                </p>

                @error('gambar')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Publikasi
                </label>

                <input
                    type="datetime-local"
                    id="tanggal"
                    name="tanggal"
                    value="{{ old('tanggal', \Carbon\Carbon::parse($berita->tanggal)->format('Y-m-d\TH:i')) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm"
                    required
                >

                @error('tanggal')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">

                <a
                    href="{{ route('admin.kelola-berita') }}"
                    class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="bg-green-700 hover:bg-green-800 text-white px-5 py-2.5 rounded-lg text-sm font-medium"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>
    </div>

</div>
@endsection