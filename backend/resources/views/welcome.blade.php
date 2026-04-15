<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SIPAKTA') }}</title>
    <link rel="icon" href="{{ asset('images/logo-kua.jpg') }}" type="image/jpeg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased selection:bg-teal-500/30">
    <div class="min-h-screen bg-slate-50 relative overflow-hidden flex flex-col items-center justify-center font-sans">
        {{-- Decorative Background --}}
        <div class="absolute top-0 left-0 w-full h-full -z-10">
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-teal-500/10 blur-[120px] rounded-full animate-pulse"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-indigo-500/10 blur-[150px] rounded-full animate-float"></div>
        </div>

        {{-- Main Hero Container --}}
        <main class="max-w-5xl w-full px-6 py-12 flex flex-col items-center text-center animate-fade-in relative z-10">
            {{-- Floating Badge --}}
            <div class="mb-10 px-6 py-2 bg-teal-600/5 border border-teal-600/10 rounded-full inline-flex items-center gap-2 group cursor-default transition-all duration-500 hover:bg-teal-600/10">
                <span class="w-2 h-2 bg-teal-500 rounded-full animate-ping"></span>
                <span class="text-[10px] font-black text-teal-700 uppercase tracking-[0.2em]">Sistem Informasi Terpadu KUA</span>
            </div>

            {{-- Brand Section --}}
            <div class="mb-12 relative">
                <div class="absolute inset-0 bg-teal-600/20 blur-[60px] rounded-full -z-10 animate-float opacity-50"></div>
                <div class="relative w-32 h-32 md:w-40 md:h-40 mx-auto rounded-[2.5rem] bg-white p-1 shadow-2xl shadow-teal-600/20 rotate-3 transition-transform duration-700 hover:rotate-0 hover:scale-105">
                    <img src="{{ asset('images/logo-kua.jpg') }}" alt="Logo KUA" class="w-full h-full rounded-[2.3rem] object-cover">
                </div>
                <h1 class="mt-10 text-6xl md:text-8xl font-black text-slate-900 tracking-tighter leading-none mb-6">
                    SIPA<span class="text-teal-600">KTA</span>
                </h1>
                <p class="text-lg md:text-2xl font-bold text-slate-400 max-w-2xl mx-auto leading-relaxed">
                    Sistem Informasi Pencarian dan <span class="text-slate-900">Pengarsipan Digital</span> Akta Nikah Kemantren Tegalrejo.
                </p>
            </div>

            {{-- Glass Card Description --}}
            <div class="glass-card rounded-[2.5rem] p-8 md:p-10 mb-12 max-w-2xl w-full translate-y-4 shadow-2xl">
                <p class="text-slate-500 font-medium leading-loose text-sm md:text-base">
                    Layanan terpadu kearsipan digital untuk mempermudah akses dan pengelolaan data pernikahan di lingkungan KUA Kemantren Tegalrejo, Kota Yogyakarta. Aman, Cepat, dan Akurat.
                </p>
            </div>

            {{-- CTA Grid --}}
            <div class="flex flex-col sm:flex-row items-center gap-6 w-full max-w-lg">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-premium btn-teal w-full text-lg shadow-teal-500/20 py-5">
                        🏠 Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-premium btn-teal w-full text-lg shadow-teal-500/20 py-5 flex items-center justify-center gap-3 group">
                        <span>🚀 Mulai Sekarang</span>
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                @endauth
            </div>

            {{-- Feature Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-8 mt-24 w-full">
                <div class="group p-8 rounded-[2.5rem] bg-white border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500">
                    <div class="w-14 h-14 rounded-2xl bg-teal-50 flex items-center justify-center text-3xl mb-6 group-hover:bg-teal-600 group-hover:text-white transition-all duration-500">📂</div>
                    <h3 class="text-slate-900 font-black text-sm uppercase tracking-widest mb-2">Arsip Digital</h3>
                    <p class="text-slate-400 text-[11px] font-bold leading-relaxed">Akses dan pengelolaan ribuan data akta nikah terintegrasi.</p>
                </div>
                <div class="group p-8 rounded-[2.5rem] bg-white border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-3xl mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500">🔍</div>
                    <h3 class="text-slate-900 font-black text-sm uppercase tracking-widest mb-2">Pencarian Cerdas</h3>
                    <p class="text-slate-400 text-[11px] font-bold leading-relaxed">Temukan data berdasarkan nama, nomor akta, atau tahun pernikahan.</p>
                </div>
                <div class="col-span-2 md:col-span-1 group p-8 rounded-[2.5rem] bg-white border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-3xl mb-6 group-hover:bg-amber-500 group-hover:text-white transition-all duration-500">⚡</div>
                    <h3 class="text-slate-900 font-black text-sm uppercase tracking-widest mb-2">Layanan Cepat</h3>
                    <p class="text-slate-400 text-[11px] font-bold leading-relaxed">Stonished dengan kecepatan proses kearsipan digital kami.</p>
                </div>
            </div>
        </main>

        {{-- Minimal Footer --}}
        <footer class="py-12 mt-auto relative z-10 w-full">
            <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6 opacity-40">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em]">
                    &copy; {{ date('Y') }} SIPAKTA &bull; KUA KEMANTREN TEGALREJO
                </p>
                <div class="flex items-center gap-8">
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">KEMENTRIAN AGAMA RI</span>
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">KOTA YOGYAKARTA</span>
                </div>
            </div>
        </footer>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</body>
</html>