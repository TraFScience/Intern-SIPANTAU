<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin SIPANTAU')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 overflow-x-hidden">
    <div class="flex min-h-screen w-full">

        <!-- Backdrop untuk Mobile -->
        <div id="sidebarBackdrop" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden transition-opacity"></div>

        {{-- Sidebar / Navbar Admin --}}
        <aside id="adminSidebar" class="w-64 bg-[#316244] text-white flex flex-col shrink-0 transition-all duration-300 ease-in-out fixed inset-y-0 left-0 z-40 md:static md:translate-x-0 -translate-x-full">
            <div class="flex items-center justify-between px-6 py-6 border-b border-white/10">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logo-sipantau.png') }}" alt="SIPANTAU" class="h-8 w-8 object-contain">
                    <span class="font-bold text-lg">Admin SIPANTAU</span>
                </div>
                <button type="button" id="sidebarCloseBtn" class="text-green-200 hover:text-white p-1.5 rounded-lg hover:bg-white/10 transition-colors focus:outline-none" title="Tutup Navigasi">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-4 space-y-1 py-4 overflow-y-auto">
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
        <script>
            // Cegah flash sidebar terbuka saat halaman dimuat jika status tersimpan tertutup
            if (window.innerWidth >= 768 && localStorage.getItem('admin_sidebar_collapsed') === 'true') {
                document.getElementById('adminSidebar').classList.add('md:-ml-64');
            }
        </script>

        {{-- Konten --}}
        <div class="flex-1 flex flex-col min-w-0 transition-all duration-300 ease-in-out">
            <header class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <button type="button" id="sidebarToggleBtn" class="p-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors" title="Buka/Tutup Navigasi">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-xl font-bold text-gray-900">@yield('page-title', 'Admin SIPANTAU')</h1>
                </div>
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

    {{-- Script Kontrol Penutup Navbar / Sidebar --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('adminSidebar');
            const toggleBtn = document.getElementById('sidebarToggleBtn');
            const closeBtn = document.getElementById('sidebarCloseBtn');
            const backdrop = document.getElementById('sidebarBackdrop');

            if (!sidebar) return;

            function isMobile() {
                return window.innerWidth < 768;
            }

            function triggerMapResize() {
                setTimeout(function() {
                    window.dispatchEvent(new Event('resize'));
                }, 310);
            }

            function openSidebar() {
                if (isMobile()) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                    if (backdrop) backdrop.classList.remove('hidden');
                } else {
                    sidebar.classList.remove('md:-ml-64');
                    localStorage.setItem('admin_sidebar_collapsed', 'false');
                    triggerMapResize();
                }
            }

            function closeSidebar() {
                if (isMobile()) {
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                    if (backdrop) backdrop.classList.add('hidden');
                } else {
                    sidebar.classList.add('md:-ml-64');
                    localStorage.setItem('admin_sidebar_collapsed', 'true');
                    triggerMapResize();
                }
            }

            function toggleSidebar() {
                if (isMobile()) {
                    if (sidebar.classList.contains('translate-x-0')) {
                        closeSidebar();
                    } else {
                        openSidebar();
                    }
                } else {
                    if (sidebar.classList.contains('md:-ml-64')) {
                        openSidebar();
                    } else {
                        closeSidebar();
                    }
                }
            }

            if (toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (isMobile() && sidebar.classList.contains('translate-x-0')) {
                        closeSidebar();
                    }
                }
            });

            window.addEventListener('resize', function() {
                if (isMobile()) {
                    sidebar.classList.remove('md:-ml-64');
                    if (!sidebar.classList.contains('translate-x-0')) {
                        sidebar.classList.add('-translate-x-full');
                    }
                } else {
                    sidebar.classList.remove('-translate-x-full', 'translate-x-0');
                    if (backdrop) backdrop.classList.add('hidden');
                    const isCollapsed = localStorage.getItem('admin_sidebar_collapsed') === 'true';
                    if (isCollapsed) {
                        sidebar.classList.add('md:-ml-64');
                    } else {
                        sidebar.classList.remove('md:-ml-64');
                    }
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
