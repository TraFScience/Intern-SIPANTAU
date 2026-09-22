@extends('layouts.admin')

@section('page-title', 'Edit Artikel')

@section('content')
<div class="w-full">

    <a href="{{ route('admin.kelola-berita') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Kembali ke Daftar Berita
    </a>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-900">Edit Berita & Artikel Edukasi</h2>
            <p class="text-sm text-gray-500 mt-1">
                Perbarui informasi berita berikut untuk portal informasi masyarakat SIPANTAU.
            </p>
        </div>

        <form action="{{ route('berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data" class="p-6" id="formBerita">
            @csrf
            @method('PUT')

            {{-- Judul --}}
            <div class="mb-5">
                <label for="judul" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                    Judul Berita / Artikel <span class="text-red-500">*</span>
                </label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                @error('judul')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal & Kategori --}}
            <div class="grid grid-cols-2 gap-5 mb-5">
                <div>
                    <label for="tanggal" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                        Tanggal & Waktu Publikasi <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" id="tanggal" name="tanggal"
                        value="{{ old('tanggal', \Carbon\Carbon::parse($berita->tanggal)->format('Y-m-d\TH:i')) }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                    @error('tanggal')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kategori" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                        Kategori
                    </label>
                    <select id="kategori" name="kategori" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Pilih kategori</option>
                        <option value="Edukasi" {{ old('kategori', $berita->kategori) == 'Edukasi' ? 'selected' : '' }}>Edukasi</option>
                        <option value="Berita" {{ old('kategori', $berita->kategori) == 'Berita' ? 'selected' : '' }}>Berita</option>
                        <option value="Mitigasi" {{ old('kategori', $berita->kategori) == 'Mitigasi' ? 'selected' : '' }}>Mitigasi</option>
                        <option value="Informasi" {{ old('kategori', $berita->kategori) == 'Informasi' ? 'selected' : '' }}>Informasi</option>
                    </select>
                    @error('kategori')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Gambar Utama / Thumbnail --}}
            <div class="mb-5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">
                    Gambar Utama Berita / Thumbnail
                </label>

                <div class="grid grid-cols-2 gap-4" id="uploadGrid">
                    <div id="dropZone" class="{{ $berita->gambar ? 'col-span-1' : 'col-span-2' }} h-36 border-2 border-dashed border-green-300 bg-green-50/30 rounded-xl flex flex-col items-center justify-center text-center px-4 cursor-pointer hover:bg-green-50 transition">
                        <svg class="w-7 h-7 text-green-600 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M12 12v9m0-9l-3 3m3-3l3 3" />
                        </svg>
                        <p class="text-xs text-gray-600">
                            Tarik & letakkan file foto di sini, atau
                            <span class="text-green-700 font-medium underline">pilih dari komputer</span>
                        </p>
                        <p class="text-xs text-gray-400 mt-1">Format JPG, PNG, WebP. Maks. 5 MB. Rasio 16:9 (1200x675px)</p>
                        <input type="file" id="gambar" name="gambar" accept=".jpg,.jpeg,.png,.webp" class="hidden">
                    </div>

                    <div id="previewBox" class="{{ $berita->gambar ? '' : 'hidden' }} h-36 relative rounded-xl overflow-hidden border border-gray-200">
                        <img id="previewImg" src="{{ $berita->gambar ? asset('storage/'.$berita->gambar) : '' }}" alt="Preview" class="w-full h-full object-cover">
                        <button type="button" id="removePreview" class="absolute top-2 right-2 w-6 h-6 flex items-center justify-center rounded-full bg-red-600 text-white text-xs hover:bg-red-700">
                            &times;
                        </button>
                        <div class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-xs px-2 py-1 flex items-center justify-between">
                            <span id="previewStatus" class="flex items-center gap-1">
                                <svg class="w-3 h-3 text-green-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                Gambar saat ini
                            </span>
                            <button type="button" id="changeImage" class="underline">Ganti Gambar</button>
                        </div>
                    </div>
                </div>

                <p class="text-xs text-gray-400 mt-2">Kosongkan jika tidak ingin mengganti gambar.</p>

                @error('gambar')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Isi Berita (rich text) --}}
            <div class="mb-2">
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wide">
                        Isi Berita / Konten Artikel <span class="text-red-500">*</span>
                    </label>
                    <span id="wordCount" class="text-xs text-gray-400">Total Kata: 0 kata</span>
                </div>

                <div class="border border-gray-300 rounded-lg overflow-hidden">
                    <div class="flex items-center flex-wrap gap-0.5 bg-gray-50 border-b border-gray-200 px-2 py-1.5">
                        <button type="button" class="toolbar-btn font-bold" data-cmd="bold" title="Bold">B</button>
                        <button type="button" class="toolbar-btn italic" data-cmd="italic" title="Italic">I</button>
                        <button type="button" class="toolbar-btn underline" data-cmd="underline" title="Underline">U</button>
                        <span class="w-px h-5 bg-gray-300 mx-1"></span>
                        <button type="button" class="toolbar-btn text-xs font-semibold" data-cmd="formatBlock" data-val="H2" title="Heading 2">H2</button>
                        <button type="button" class="toolbar-btn text-xs font-semibold" data-cmd="formatBlock" data-val="H3" title="Heading 3">H3</button>
                        <span class="w-px h-5 bg-gray-300 mx-1"></span>
                        <button type="button" class="toolbar-btn" data-cmd="insertUnorderedList" title="Bullet List">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" /></svg>
                        </button>
                        <button type="button" class="toolbar-btn" data-cmd="insertOrderedList" title="Numbered List">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h13M8 12h13M8 18h13M4 6h1v2H4V6zm0 5h2v2H4v-2zm0 5h2v2H4v-2z" /></svg>
                        </button>
                        <button type="button" class="toolbar-btn" data-cmd="formatBlock" data-val="BLOCKQUOTE" title="Quote">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z" /></svg>
                        </button>
                        <span class="w-px h-5 bg-gray-300 mx-1"></span>
                        <button type="button" class="toolbar-btn" data-cmd="createLink" data-prompt="Masukkan URL tautan:" title="Link">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 010 5.656l-3 3a4 4 0 01-5.656-5.656l1.5-1.5M10.172 13.828a4 4 0 010-5.656l3-3a4 4 0 015.656 5.656l-1.5 1.5" /></svg>
                        </button>
                        <button type="button" class="toolbar-btn" data-cmd="insertImage" data-prompt="Masukkan URL gambar:" title="Sisipkan Gambar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 10h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </button>
                        <button type="button" class="toolbar-btn" data-cmd="insertHorizontalRule" title="Sisipkan Tabel/Garis">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M9 4v16M15 4v16M4 4h16v16H4V4z" /></svg>
                        </button>
                    </div>

                    <div id="editor" contenteditable="true"
                        style="word-break: break-all; overflow-wrap: anywhere;"
                        class="min-h-[180px] max-h-[400px] overflow-y-auto overflow-x-hidden px-4 py-3 text-sm text-gray-700 focus:outline-none"
                        data-placeholder="Tulis isi berita di sini...">
                    </div>
                </div>

                <textarea name="isi" id="isiHidden" class="hidden">{{ old('isi', $berita->isi) }}</textarea>
                @error('isi')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('admin.kelola-berita') }}"
                    class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="bg-green-700 hover:bg-green-800 text-white px-5 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

</div>

<style>
    .toolbar-btn {
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        color: #4b5563;
    }

    .toolbar-btn:hover {
        background-color: #e5e7eb;
    }

    #editor:empty:before {
        content: attr(data-placeholder);
        color: #9ca3af;
    }

    #editor blockquote {
        border-left: 3px solid #15803d;
        background: #f0fdf4;
        padding: 0.5rem 1rem;
        margin: 0.5rem 0;
        color: #166534;
        font-style: italic;
    }

    #editor h2 { font-size: 1.1rem; font-weight: 700; margin: 0.5rem 0; }
    #editor h3 { font-size: 1rem; font-weight: 700; margin: 0.5rem 0; }
    #editor ul { list-style: disc; padding-left: 1.5rem; }
    #editor ol { list-style: decimal; padding-left: 1.5rem; }
    #editor a { color: #15803d; text-decoration: underline; }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== Drag & drop gambar =====
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('gambar');
        const previewBox = document.getElementById('previewBox');
        const previewImg = document.getElementById('previewImg');
        const previewStatus = document.getElementById('previewStatus');
        const removePreview = document.getElementById('removePreview');
        const changeImage = document.getElementById('changeImage');

        function showPreview(file) {
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewStatus.innerHTML = '<svg class="w-3 h-3 text-green-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Siap diunggah';
                previewBox.classList.remove('hidden');
                dropZone.classList.remove('col-span-2');
                dropZone.classList.add('col-span-1');
            };
            reader.readAsDataURL(file);
        }

        dropZone.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', () => showPreview(fileInput.files[0]));
        changeImage.addEventListener('click', () => fileInput.click());

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('bg-green-50');
        });
        dropZone.addEventListener('dragleave', () => dropZone.classList.remove('bg-green-50'));
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('bg-green-50');
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                showPreview(fileInput.files[0]);
            }
        });

        removePreview.addEventListener('click', (e) => {
            e.stopPropagation();
            fileInput.value = '';
            previewBox.classList.add('hidden');
            dropZone.classList.remove('col-span-1');
            dropZone.classList.add('col-span-2');
        });

        // ===== Rich text editor =====
        const editor = document.getElementById('editor');
        const isiHidden = document.getElementById('isiHidden');
        const wordCount = document.getElementById('wordCount');

        if (isiHidden.value.trim()) {
            editor.innerHTML = isiHidden.value;
        }

        function updateWordCount() {
            const text = editor.innerText.trim();
            const count = text ? text.split(/\s+/).length : 0;
            wordCount.textContent = 'Total Kata: ' + count + ' kata';
        }
        updateWordCount();
        editor.addEventListener('input', updateWordCount);

        document.querySelectorAll('[data-cmd]').forEach(btn => {
            btn.addEventListener('click', () => {
                const cmd = btn.dataset.cmd;
                let val = btn.dataset.val || null;

                if (btn.dataset.prompt) {
                    val = prompt(btn.dataset.prompt);
                    if (!val) return;
                }

                editor.focus();
                document.execCommand(cmd, false, val);
            });
        });

        document.getElementById('formBerita').addEventListener('submit', function(e) {
            isiHidden.value = editor.innerHTML;

            if (!editor.innerText.trim()) {
                e.preventDefault();
                alert('Isi berita tidak boleh kosong.');
                editor.focus();
            }
        });
    });
</script>
@endpush
@endsection