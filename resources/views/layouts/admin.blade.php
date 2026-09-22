<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin SIPANTAU')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 bg-[#316244] text-white flex flex-col shrink-0">
            <div class="flex items-center gap-2 px-6 py-6">
                <img src="{{ asset('images/logo-sipantau.png') }}" alt="SIPANTAU" class="h-8 w-8 object-contain">
                <span class="font-bold text-lg">Admin SIPANTAU</span>
            </div>

            <nav class="flex-1 px-4 space-y-1">
                <p class="text-green-300 text-xs uppercase px-2 mt-2 mb-1">Menu Utama</p>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-green-600 font-semibold' : 'hover:bg-white/10' }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="12" width="4" height="8" rx="1" />
                        <rect x="10" y="8" width="4" height="12" rx="1" />
                        <rect x="17" y="4" width="4" height="16" rx="1" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.kelola-bencana') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.kelola-bencana') ? 'bg-green-600 font-semibold' : 'hover:bg-white/10' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    Kelola Bencana
                </a>
                <a href="{{ route('admin.input-kejadian') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.input-kejadian') ? 'bg-green-600 font-semibold' : 'hover:bg-white/10' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6m-5 5H6a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2h-1" />
                    </svg>
                    Input Kejadian
                </a>

                <p class="text-green-300 text-xs uppercase px-2 mt-6 mb-1">Manajemen Konten</p>
                <a href="{{ route('admin.kelola-berita') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.kelola-berita') || request()->routeIs('admin.berita-create') ? 'bg-green-600 font-semibold' : 'hover:bg-white/10' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="16" rx="2" stroke-width="2" />
                        <circle cx="8" cy="10" r="1.5" stroke-width="2" />
                        <path stroke-linecap="round" stroke-width="2" d="M6 15h4M13 9h5M13 13h5" />
                    </svg>
                    Kelola Berita
                </a>
                <a href="{{ route('admin.akun-pengguna') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('admin.akun-pengguna') ? 'bg-green-600 font-semibold' : 'hover:bg-white/10' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-8a4 4 0 11-8 0 4 4 0 018 0zm8 4a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Akun Pengguna
                </a>
            </nav>

            <div class="p-4 border-t border-white/10">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-9 h-9 rounded-full bg-green-400 flex items-center justify-center font-bold text-[#0d3d26]">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="text-sm">
                        <p class="font-semibold">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-green-300 text-xs">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-medium flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- Konten --}}
        <div class="flex-1 flex flex-col">
            <header class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-900">@yield('page-title', 'Admin SIPANTAU')</h1>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </div>
                    <div class="flex items-center gap-2 bg-gray-100 px-3 py-1.5 rounded-full text-sm text-gray-700">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                        {{ Auth::user()->name ?? 'Admin' }}
                    </div>
                </div>
            </header>

            <main class="flex-1 p-8">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
