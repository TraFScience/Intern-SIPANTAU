<x-guest-layout>
    <h2 class="text-center font-bold text-green-800 text-lg mb-6">Buat Akun Baru</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label for="name" class="text-sm font-medium text-gray-700 block mb-1.5">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                placeholder="Masukkan nama lengkap Anda"
                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700 focus:ring-green-600 focus:border-green-600">
            @error('name')
                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="text-sm font-medium text-gray-700 block mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                placeholder="Masukkan alamat email Anda"
                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700 focus:ring-green-600 focus:border-green-600">
            @error('email')
                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="text-sm font-medium text-gray-700 block mb-1.5">Kata Sandi</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                placeholder="Masukkan kata sandi Anda"
                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700 focus:ring-green-600 focus:border-green-600">
            @error('password')
                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="text-sm font-medium text-gray-700 block mb-1.5">Konfirmasi Sandi</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="Ulangi sandi Anda"
                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm text-gray-700 focus:ring-green-600 focus:border-green-600">
            @error('password_confirmation')
                <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="inline-flex items-start gap-2">
                <input type="checkbox" required
                    class="rounded border-gray-300 text-green-700 focus:ring-green-600 mt-0.5">
                <span class="text-sm text-gray-600">
                    Saya menyetujui <a href="#" class="text-green-700 font-medium hover:text-green-800">Syarat Ketentuan</a>
                    dan <a href="#" class="text-green-700 font-medium hover:text-green-800">Kebijakan Privasi</a> yang berlaku.
                </span>
            </label>
        </div>

        <button type="submit"
            class="w-full bg-green-700 hover:bg-green-800 text-white py-2.5 rounded-lg font-medium">
            Masuk
        </button>

        <p class="text-center text-sm text-gray-600 mt-4">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-green-700 font-medium hover:text-green-800">Masuk Disini</a>
        </p>
    </form>
</x-guest-layout>