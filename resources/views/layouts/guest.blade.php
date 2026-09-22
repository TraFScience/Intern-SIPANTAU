<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIPANTAU') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center bg-gray-50 px-4 py-10">

            <div class="w-full sm:max-w-md bg-white shadow-sm border border-gray-200 rounded-xl px-8 py-8">

                <div class="flex flex-col items-center mb-6">
                    <img src="{{ asset('images/logo-sipantau.png') }}" alt="SIPANTAU" class="h-16 w-16 object-contain mb-2">
                    <span class="font-bold text-green-800 tracking-wide text-sm">SIPANTAU</span>
                </div>

                {{ $slot }}
            </div>

        </div>
    </body>
</html>