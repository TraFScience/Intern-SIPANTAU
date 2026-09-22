<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SIPANTAU')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    {{-- Navbar --}}
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('peta-bencana') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo-sipantau.png') }}" alt="SIPANTAU" class="h-9 w-9 object-contain">
                    <span class="font-bold text-gray-800">SIPANTAU</span>
                </a>

                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('peta-bencana') }}" class="text-gray-600 hover:text-green-700 font-medium">Peta Bencana</a>
                    <a href="{{ route('statistik-bencana') }}" class="text-gray-600 hover:text-green-700 font-medium">Statistik Bencana</a>
                    <a href="{{ route('wilayah-rawan.index') }}" class="text-gray-600 hover:text-green-700 font-medium">Wilayah Rawan</a>
                    <a href="{{ route('berita-page') }}" class="text-gray-600 hover:text-green-700 font-medium">Berita</a>
                    <a href="{{ route('kejadian-bencana.create') }}" class="text-gray-600 hover:text-green-700 font-medium">Lapor Kejadian</a>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                    @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-full text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        {{ Auth::user()->name }}
                    </a>
                    @else
                    <a href="{{ route('profil.index') }}" class="flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-full text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        {{ Auth::user()->name }}
                    </a>
                    @endif
                    @else
                    <a href="{{ route('login') }}" class="flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-full text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                            <polyline points="10 17 15 12 10 7" />
                            <line x1="15" y1="12" x2="3" y2="12" />
                        </svg>
                        Login
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Konten halaman --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-[#316244] text-center py-10">
        <div class="flex justify-center items-center gap-2 mb-2">
            <span class="text-white font-bold text-lg">SIPANTAU</span>
        </div>
        <p class="text-gray-200 text-sm">
            Sistem Informasi Peta Analisis &amp; Navigasi Teritorial Alam Utama<br>
            Kalimantan Selatan
        </p>
        <p class="text-gray-300 text-xs mt-4">&copy; {{ date('Y') }} SIPANTAU Web-GIS. All rights reserved.</p>
    </footer>

    @stack('scripts')
</body>
</html>

