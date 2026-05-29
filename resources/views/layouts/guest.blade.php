<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIPAKTA') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-teal-800 flex flex-col items-center justify-center px-4">
        {{-- Logo --}}
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center mb-3">
                <img src="{{ asset('images/logo-kua.jpg') }}" alt="Logo KUA" class="w-16 h-16 rounded-xl object-cover shadow-lg">
            </div>
            <h1 class="text-2xl font-bold text-white">SIPAKTA</h1>
            <p class="text-teal-200 text-sm">Sistem Informasi Pencarian dan Pengarsipan Akta Nikah</p>
        </div>

        {{-- Form Card --}}
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-6">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        <p class="text-teal-300 text-sm mt-6">&copy; {{ date('Y') }} KUA Tegalrejo</p>
    </div>
</body>
</html>
