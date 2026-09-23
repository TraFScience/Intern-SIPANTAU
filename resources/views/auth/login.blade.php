<x-guest-layout>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="text-sm font-medium text-gray-700 block mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Masukkan alamat email Anda" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700 focus:ring-green-600 focus:border-green-600">
            @error('email')
            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
            @enderror
        </div> 

        <div class="mb-4">
            <label for="password" class="text-sm font-medium text-gray-700 block mb-1.5">Kata Sandi</label>
            <div class="relative">
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi Anda" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 pr-10 text-sm text-gray-700 focus:ring-green-600 focus:border-green-600">
                <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none" title="Lihat kata sandi">
                    <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {{-- Ikon mata terbuka (muncul saat password terlihat) --}}
                    <svg class="w-5 h-5 eye-open hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg class="w-5 h-5 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {{-- Ikon mata tertutup (muncul saat password tertutup) --}}
                    <svg class="w-5 h-5 eye-closed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </button>
            </div>
            @error('password')
            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-green-700 focus:ring-green-600">
                <span class="ms-2 text-sm text-gray-600">Ingat Saya</span>
            </label>

            @if (Route::has('password.request'))
            <a class="text-sm font-medium text-green-700 hover:text-green-800" href="{{ route('password.request') }}">
                Lupa Sandi?
            </a>
            @endif
        </div>

        <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white py-2.5 rounded-lg font-medium">
            Masuk
        </button>

        <p class="text-center text-sm text-gray-600 mt-4">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-green-700 font-medium hover:text-green-800">Daftar Sekarang</a>
        </p>
    </form>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;

            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            const willBeVisible = input.type === 'password';
            input.type = willBeVisible ? 'text' : 'password';

            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');

            if (eyeOpen && eyeClosed) {
                if (isPassword) {
                if (willBeVisible) {
                    // Password terlihat -> ikon mata terbuka
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                    btn.setAttribute('title', 'Tutup kata sandi');
                } else {
                    // Password tertutup -> ikon mata tertutup
                    eyeOpen.classList.add('hidden');
                    eyeClosed.classList.remove('hidden');
                    btn.setAttribute('title', 'Tutup kata sandi');
                } else {
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                    btn.setAttribute('title', 'Lihat kata sandi');
                }
            }
        }
    </script>
</x-guest-layout>
