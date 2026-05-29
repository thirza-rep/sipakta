<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIPAKTA') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Outfit', sans-serif; }</style>
</head>
<body class="font-sans antialiased bg-teal-700">
    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-8">
        {{-- Logo --}}
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center mb-3">
                <img src="{{ asset('images/logo-kua.jpg') }}" alt="Logo KUA" class="w-20 h-20 rounded-2xl object-cover shadow-xl">
            </div>
            <h1 class="text-3xl font-bold text-white">SIPAKTA</h1>
            <p class="text-teal-100 text-base mt-1">Sistem Informasi Pencarian & Pengarsipan Akta Nikah</p>
        </div>

        {{-- Form Card --}}
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 sm:p-8">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        <p class="text-teal-200 text-sm mt-6 font-semibold">&copy; {{ date('Y') }} KUA Kemantren Tegalrejo — Yogyakarta</p>
    </div>
</body>
</html>
