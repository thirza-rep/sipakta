<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIPAKTA') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass-nav {
            background: rgba(15, 118, 110, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="font-sans antialiased text-slate-900 bg-slate-50/50 selection:bg-teal-500/30">
    <div class="min-h-screen flex flex-col relative overflow-x-hidden">
        {{-- Decorative Background Elements --}}
        <div class="fixed top-0 right-0 -z-10 w-[500px] h-[500px] bg-teal-500/5 blur-[120px] rounded-full translate-x-1/2 -translate-y-1/2"></div>
        <div class="fixed bottom-0 left-0 -z-10 w-[400px] h-[400px] bg-indigo-500/5 blur-[100px] rounded-full -translate-x-1/2 translate-y-1/2"></div>

        @include('layouts.navigation')

        @if (isset($header))
            <div class="pt-6 pb-2">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </div>
        @endif

        <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @isset($slot)
                {{ $slot }}
            @endisset
            @yield('content')
        </main>
        
        <footer class="bg-white border-t border-slate-100 py-10">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex items-center gap-3 grayscale opacity-40 hover:grayscale-0 hover:opacity-100 transition duration-500">
                        <img src="{{ asset('images/logo-kua.jpg') }}" alt="Logo KUA" class="w-6 h-6 rounded">
                        <span class="text-xs font-black tracking-widest text-slate-900 uppercase">SIPAKTA</span>
                    </div>
                    <div class="text-center md:text-right">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">&copy; {{ date('Y') }} KUA Kemantren Tegalrejo</p>
                        <p class="text-[9px] text-slate-400 mt-1">Kementerian Agama Republik Indonesia</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
