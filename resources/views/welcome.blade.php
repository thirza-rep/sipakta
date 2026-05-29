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

            {{-- CTA Grid & Promo --}}
            <div class="flex flex-col items-center gap-6 w-full max-w-xl">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-premium btn-teal w-full text-lg shadow-teal-500/20 py-5">
                        🏠 Buka Dashboard
                    </a>
                @else
                    {{-- Promo Registration Box --}}
                    <div class="w-full bg-white/60 backdrop-blur-md border border-teal-200/50 p-6 rounded-3xl shadow-xl shadow-teal-500/5 relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-r from-teal-500/10 to-indigo-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="relative z-10 flex flex-col items-center text-center space-y-4">
                            <h3 class="text-slate-800 font-bold text-lg md:text-xl">Butuh Salinan Akta Nikah Keluarga?</h3>
                            <p class="text-slate-500 text-sm md:text-base leading-relaxed">
                                Masyarakat kini dapat melakukan pencarian digital untuk dokumen pernikahan keluarga secara mandiri. Daftar sekarang untuk mendapatkan akses pemohon.
                            </p>
                            <div class="flex flex-col sm:flex-row gap-4 w-full pt-2">
                                <a href="{{ route('login') }}" class="w-full sm:w-1/3 px-6 py-4 rounded-2xl bg-white text-teal-700 border border-teal-100 font-bold hover:bg-teal-50 hover:-translate-y-1 transition-all duration-300 shadow-sm flex justify-center items-center">
                                    🔑 Masuk
                                </a>
                                <a href="{{ route('register') }}" class="w-full sm:w-2/3 px-6 py-4 rounded-2xl bg-gradient-to-r from-teal-600 to-teal-500 text-white font-bold hover:shadow-lg hover:shadow-teal-500/30 hover:-translate-y-1 transition-all duration-300 flex justify-center items-center gap-2">
                                    <span>📝 Daftar Pencari Akta</span>
                                    <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                                </a>
                            </div>
                        </div>
                    </div>
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

    {{-- Floating WhatsApp Button --}}
    <a href="https://wa.me/6285171739541?text=Halo%20Admin%20SIPAKTA,%20saya%20membutuhkan%20bantuan%20mengenai%20pencarian%20akta%20nikah." 
       target="_blank" 
       rel="noopener noreferrer" 
       class="fixed bottom-6 right-6 md:bottom-8 md:right-8 z-50 flex items-center justify-center w-14 h-14 md:w-16 md:h-16 bg-[#25D366] text-white rounded-full shadow-2xl hover:scale-110 hover:shadow-emerald-500/50 transition-all duration-300 group"
       aria-label="Hubungi via WhatsApp">
        <span class="absolute right-full mr-4 bg-white text-slate-800 text-xs font-bold px-3 py-2 rounded-xl shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none whitespace-nowrap">
            Hubungi Admin
        </span>
        <svg class="w-7 h-7 md:w-8 md:h-8" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
        </svg>
    </a>

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