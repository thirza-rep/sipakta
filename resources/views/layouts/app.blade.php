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
<body class="font-sans antialiased text-slate-800 bg-slate-50 selection:bg-teal-500/30">
    <div class="min-h-screen flex flex-col relative overflow-x-hidden">
        {{-- Decorative Background --}}
        <div class="fixed top-0 right-0 -z-10 w-[400px] h-[400px] bg-teal-500/5 blur-[100px] rounded-full translate-x-1/2 -translate-y-1/2"></div>

        @include('layouts.navigation')

        @if (isset($header))
            <div class="pt-6 pb-2">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </div>
        @endif

        <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            @isset($slot)
                {{ $slot }}
            @endisset
            @yield('content')
        </main>

        <footer class="bg-white border-t border-slate-200 py-8">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-kua.jpg') }}" alt="Logo KUA" class="w-8 h-8 rounded-lg">
                        <span class="text-sm font-bold text-slate-700">SIPAKTA</span>
                    </div>
                    <div class="text-center md:text-right">
                        <p class="text-xs font-semibold text-slate-500">&copy; {{ date('Y') }} KUA Kemantren Tegalrejo</p>
                        <p class="text-xs text-slate-400 mt-0.5">Kementerian Agama Republik Indonesia</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    {{-- Floating WhatsApp Button --}}
    <a href="https://wa.me/6285171739541?text=Halo%20Admin%20SIPAKTA,%20saya%20membutuhkan%20bantuan%20mengenai%20pencarian%20akta%20nikah."
       target="_blank" rel="noopener noreferrer"
       class="fixed bottom-5 right-5 z-[9999] flex items-center justify-center w-16 h-16 bg-[#25D366] text-white rounded-full shadow-xl hover:scale-110 transition-all duration-300 group"
       aria-label="Hubungi via WhatsApp">
        <span class="absolute right-full mr-3 bg-white text-slate-800 text-sm font-bold px-4 py-2 rounded-xl shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
            Hubungi Admin
        </span>
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12c0 2.17.69 4.18 1.86 5.82L3 21l3.31-.85C7.8 21.36 9.81 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm4.31 14.54c-.19.53-.98.98-1.42 1.05-.44.07-.94.22-3.04-.65-2.52-1.05-4.14-3.66-4.26-3.82-.12-.16-1.02-1.36-1.02-2.59s.64-1.84.86-2.07c.22-.22.48-.28.64-.28.16 0 .32.01.45.02.15.01.35-.06.54.4.19.46.66 1.62.72 1.74.06.12.09.26.02.4-.07.14-.11.23-.21.35-.11.12-.23.26-.33.37-.09.09-.19.19-.08.38.11.19.49.81 1.05 1.31.72.64 1.32.84 1.51.93.19.09.31.08.43-.05.12-.14.52-.61.66-.82.14-.21.28-.17.46-.11.18.06 1.15.54 1.35.64.2.1.33.15.38.24.05.09.05.52-.14 1.05z"/></svg>
    </a>
</body>
</html>
