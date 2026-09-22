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
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi Anda" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700 focus:ring-green-600 focus:border-green-600">
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
</x-guest-layout>
