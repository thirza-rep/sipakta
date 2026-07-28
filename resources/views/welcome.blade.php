<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPAKTA — Sistem Pengarsipan Akta Nikah KUA Tegalrejo</title>
    <meta name="description" content="Layanan pencarian arsip akta nikah digital KUA Kemantren Tegalrejo, Kota Yogyakarta. Cari dan akses salinan digital dokumen pernikahan Anda dengan mudah, cepat, dan aman.">
    <link rel="icon" href="{{ asset('images/logo-kua.jpg') }}" type="image/jpeg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
        
        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }
        @keyframes float-slow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-18px) rotate(3deg); }
        }
        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 1; }
            100% { transform: scale(2.2); opacity: 0; }
        }
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-float-slow { animation: float-slow 8s ease-in-out infinite; }
        .animate-float-delay { animation: float 6s ease-in-out 2s infinite; }
        .animate-slide-up { animation: slide-up 0.8s ease-out forwards; }
        .animate-slide-up-delay { animation: slide-up 0.8s ease-out 0.2s forwards; opacity: 0; }
        .animate-slide-up-delay-2 { animation: slide-up 0.8s ease-out 0.4s forwards; opacity: 0; }
        .animate-slide-up-delay-3 { animation: slide-up 0.8s ease-out 0.6s forwards; opacity: 0; }
        .animate-fade-in { animation: fade-in 1s ease-out 0.3s forwards; opacity: 0; }
        
        /* Grain texture overlay */
        .grain::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 1;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 999px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-800 overflow-x-hidden">
    <div class="min-h-screen flex flex-col">
        
        {{-- ===== NAVIGATION ===== --}}
        <header class="fixed top-0 w-full z-50 transition-all duration-500" 
                x-data="{ scrolled: false }"
                x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
                :class="scrolled ? 'bg-white/90 backdrop-blur-2xl shadow-lg shadow-slate-200/50 border-b border-slate-100' : 'bg-transparent'">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-teal-600 rounded-2xl flex items-center justify-center shadow-xl shadow-teal-600/20 hover:rotate-6 hover:scale-110 transition-all duration-500">
                        <img src="{{ asset('images/logo-kua.jpg') }}" alt="Logo KUA" class="w-9 h-9 rounded-lg object-cover">
                    </div>
                    <div>
                        <h1 class="text-xl font-black tracking-tight leading-none" :class="scrolled ? 'text-slate-900' : 'text-white'">SIPAKTA</h1>
                        <p class="text-[9px] font-black uppercase tracking-[0.3em] mt-0.5" :class="scrolled ? 'text-slate-400' : 'text-white/60'">KUA Tegalrejo</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-7 py-3 bg-teal-600 text-white rounded-2xl font-bold text-sm hover:bg-teal-500 transition-all shadow-lg shadow-teal-600/20 active:scale-95">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2.5 font-bold text-sm rounded-xl transition-all" :class="scrolled ? 'text-slate-600 hover:text-teal-600' : 'text-white/80 hover:text-white'">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-7 py-3 bg-teal-600 text-white rounded-2xl font-bold text-sm hover:bg-teal-500 transition-all shadow-lg shadow-teal-600/20 active:scale-95">
                            Daftar Akun
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        {{-- ===== HERO SECTION ===== --}}
        <section class="relative min-h-[100vh] flex items-center justify-center overflow-hidden grain">
            {{-- Dark gradient background --}}
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-teal-900"></div>
            
            {{-- Decorative blobs --}}
            <div class="absolute top-20 left-10 w-72 h-72 bg-teal-500/10 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-teal-600/[0.08] rounded-full blur-3xl animate-float-slow"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-teal-500/5 rounded-full blur-3xl"></div>
            
            {{-- Grid pattern --}}
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg width=%2760%27 height=%2760%27 viewBox=%270 0 60 60%27 xmlns=%27http://www.w3.org/2000/svg%27%3E%3Cg fill=%27none%27 fill-rule=%27evenodd%27%3E%3Cg fill=%27%23ffffff%27 fill-opacity=%271%27%3E%3Cpath d=%27M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z%27/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>

            {{-- Floating decorative elements --}}
            <div class="absolute top-32 right-[15%] hidden lg:block animate-float">
                <div class="w-20 h-20 rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 flex items-center justify-center rotate-12">
                    <svg class="w-10 h-10 text-teal-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
            <div class="absolute bottom-40 left-[10%] hidden lg:block animate-float-delay">
                <div class="w-16 h-16 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 flex items-center justify-center -rotate-12">
                    <svg class="w-8 h-8 text-teal-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
            <div class="absolute top-1/2 right-[8%] hidden lg:block animate-float-slow">
                <div class="w-14 h-14 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 flex items-center justify-center rotate-6">
                    <svg class="w-7 h-7 text-teal-400/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
            </div>

            {{-- Hero Content --}}
            <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center pt-32 pb-20">
                {{-- Badge --}}
                <div class="animate-slide-up">
                    <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 backdrop-blur-md text-teal-300 rounded-full font-bold text-xs border border-white/10 uppercase tracking-widest">
                        <span class="w-2 h-2 rounded-full bg-teal-400 animate-pulse"></span>
                        Sistem Pengarsipan Digital KUA
                    </span>
                </div>

                {{-- Title --}}
                <h2 class="mt-10 text-5xl md:text-6xl lg:text-7xl font-black text-white tracking-tight leading-[1.1] animate-slide-up-delay">
                    Layanan Pencarian<br>
                    <span class="bg-gradient-to-r from-teal-300 via-teal-400 to-emerald-400 bg-clip-text text-transparent">Arsip Akta Nikah</span>
                </h2>

                {{-- Subtitle --}}
                <p class="mt-8 text-lg md:text-xl text-slate-400 leading-relaxed max-w-2xl mx-auto font-medium animate-slide-up-delay-2">
                    Selamat datang di layanan pencarian arsip akta nikah <strong class="text-slate-300">KUA Kemantren Tegalrejo</strong>, Kota Yogyakarta. Akses salinan digital dokumen pernikahan Anda dengan mudah, cepat, dan aman.
                </p>

                {{-- CTA Buttons --}}
                <div class="mt-12 flex flex-col sm:flex-row items-center justify-center gap-4 animate-slide-up-delay-3">
                    @auth
                        <a href="{{ route('pencarian.index') }}" class="group inline-flex items-center gap-3 px-10 py-5 bg-teal-500 text-white rounded-2xl font-black text-lg shadow-2xl shadow-teal-500/30 hover:bg-teal-400 hover:shadow-teal-400/40 transition-all duration-300 active:scale-95">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Cari Arsip Sekarang
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="group inline-flex items-center gap-3 px-10 py-5 bg-teal-500 text-white rounded-2xl font-black text-lg shadow-2xl shadow-teal-500/30 hover:bg-teal-400 hover:shadow-teal-400/40 transition-all duration-300 active:scale-95">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            Daftar Akun Baru
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-8 py-5 bg-white/10 backdrop-blur-sm text-white rounded-2xl font-bold text-lg border border-white/10 hover:bg-white/20 transition-all duration-300 active:scale-95">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            Masuk ke Akun
                        </a>
                    @endauth
                </div>

                {{-- Trust Indicators --}}
                <div class="mt-16 flex flex-wrap items-center justify-center gap-8 animate-fade-in">
                    <div class="flex items-center gap-2 text-slate-500">
                        <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <span class="text-sm font-bold">Terenkripsi & Aman</span>
                    </div>
                    <div class="w-px h-4 bg-slate-700 hidden sm:block"></div>
                    <div class="flex items-center gap-2 text-slate-500">
                        <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-sm font-bold">Akses 24 Jam</span>
                    </div>
                    <div class="w-px h-4 bg-slate-700 hidden sm:block"></div>
                    <div class="flex items-center gap-2 text-slate-500">
                        <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span class="text-sm font-bold">Kementerian Agama RI</span>
                    </div>
                </div>
            </div>

            {{-- Bottom curve --}}
            <div class="absolute bottom-0 left-0 right-0">
                <svg viewBox="0 0 1440 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
                    <path d="M0 100L60 90C120 80 240 60 360 50C480 40 600 40 720 45C840 50 960 60 1080 65C1200 70 1320 70 1380 70L1440 70V100H1380C1320 100 1200 100 1080 100C960 100 840 100 720 100C600 100 480 100 360 100C240 100 120 100 60 100H0Z" fill="#f8fafc"/>
                </svg>
            </div>
        </section>

        {{-- ===== HOW IT WORKS SECTION ===== --}}
        <section class="py-24 bg-slate-50 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Section Header --}}
                <div class="text-center mb-20">
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-teal-50 text-teal-700 rounded-full font-bold text-xs border border-teal-100 uppercase tracking-widest">
                        Panduan Layanan
                    </span>
                    <h3 class="mt-6 text-4xl md:text-5xl font-black text-slate-900 tracking-tight">
                        Bagaimana Cara Kerjanya?
                    </h3>
                    <p class="mt-4 text-lg text-slate-500 max-w-2xl mx-auto font-medium leading-relaxed">
                        Tiga langkah mudah untuk mengakses arsip akta nikah Anda secara digital.
                    </p>
                </div>

                {{-- Steps --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                    {{-- Step 1 --}}
                    <div class="group relative">
                        <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-500 relative overflow-hidden h-full">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-teal-500/5 rounded-bl-[4rem] group-hover:scale-150 transition-transform duration-700"></div>
                            <div class="relative z-10">
                                <div class="flex items-center gap-4 mb-8">
                                    <div class="w-14 h-14 bg-teal-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-teal-600/20 group-hover:rotate-6 transition-transform">
                                        <span class="text-xl font-black">01</span>
                                    </div>
                                    <div class="h-px flex-1 bg-gradient-to-r from-teal-200 to-transparent"></div>
                                </div>
                                <h4 class="text-2xl font-black text-slate-900 mb-4 tracking-tight">Daftarkan Akun</h4>
                                <p class="text-slate-500 font-medium leading-relaxed">
                                    Buat akun pemohon dengan mengisi data diri dan melengkapi verifikasi identitas melalui KTP Anda.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Step 2 --}}
                    <div class="group relative md:mt-8">
                        <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-500 relative overflow-hidden h-full">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/5 rounded-bl-[4rem] group-hover:scale-150 transition-transform duration-700"></div>
                            <div class="relative z-10">
                                <div class="flex items-center gap-4 mb-8">
                                    <div class="w-14 h-14 bg-slate-900 rounded-2xl flex items-center justify-center text-teal-400 shadow-xl shadow-slate-900/20 group-hover:-rotate-6 transition-transform">
                                        <span class="text-xl font-black">02</span>
                                    </div>
                                    <div class="h-px flex-1 bg-gradient-to-r from-slate-200 to-transparent"></div>
                                </div>
                                <h4 class="text-2xl font-black text-slate-900 mb-4 tracking-tight">Cari Arsip Anda</h4>
                                <p class="text-slate-500 font-medium leading-relaxed">
                                    Masukkan nama suami, istri, atau nomor akta nikah untuk menemukan dokumen arsip yang Anda butuhkan.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Step 3 --}}
                    <div class="group relative md:mt-16">
                        <div class="bg-white rounded-[2.5rem] p-10 border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-500 relative overflow-hidden h-full">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/5 rounded-bl-[4rem] group-hover:scale-150 transition-transform duration-700"></div>
                            <div class="relative z-10">
                                <div class="flex items-center gap-4 mb-8">
                                    <div class="w-14 h-14 bg-teal-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-teal-600/20 group-hover:rotate-6 transition-transform">
                                        <span class="text-xl font-black">03</span>
                                    </div>
                                    <div class="h-px flex-1 bg-gradient-to-r from-teal-200 to-transparent"></div>
                                </div>
                                <h4 class="text-2xl font-black text-slate-900 mb-4 tracking-tight">Unduh Salinan</h4>
                                <p class="text-slate-500 font-medium leading-relaxed">
                                    Dapatkan salinan digital arsip akta nikah Anda dalam format PDF yang siap diunduh dan dicetak.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===== FEATURES SECTION ===== --}}
        <section class="py-24 bg-white relative overflow-hidden">
            {{-- Background decoration --}}
            <div class="absolute top-0 right-0 w-96 h-96 bg-teal-50 rounded-full blur-3xl opacity-50 -translate-y-1/2 translate-x-1/2"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-20">
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-teal-50 text-teal-700 rounded-full font-bold text-xs border border-teal-100 uppercase tracking-widest">
                        Keunggulan Kami
                    </span>
                    <h3 class="mt-6 text-4xl md:text-5xl font-black text-slate-900 tracking-tight">
                        Mengapa Menggunakan SIPAKTA?
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    {{-- Feature 1 --}}
                    <div class="group text-center">
                        <div class="w-20 h-20 bg-teal-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6 border border-teal-100 group-hover:bg-teal-600 group-hover:border-teal-600 transition-all duration-500 shadow-sm group-hover:shadow-xl group-hover:shadow-teal-600/20">
                            <svg class="w-10 h-10 text-teal-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                        </div>
                        <h4 class="text-lg font-black text-slate-900 mb-2 tracking-tight">Arsip Digital</h4>
                        <p class="text-sm text-slate-500 font-medium leading-relaxed">Data pernikahan tersimpan aman dalam format digital yang mudah diakses kapan saja.</p>
                    </div>

                    {{-- Feature 2 --}}
                    <div class="group text-center">
                        <div class="w-20 h-20 bg-blue-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6 border border-blue-100 group-hover:bg-slate-900 group-hover:border-slate-900 transition-all duration-500 shadow-sm group-hover:shadow-xl group-hover:shadow-slate-900/20">
                            <svg class="w-10 h-10 text-blue-600 group-hover:text-teal-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h4 class="text-lg font-black text-slate-900 mb-2 tracking-tight">Pencarian Cepat</h4>
                        <p class="text-sm text-slate-500 font-medium leading-relaxed">Cukup masukkan nama atau nomor akta untuk menemukan dokumen yang dicari.</p>
                    </div>

                    {{-- Feature 3 --}}
                    <div class="group text-center">
                        <div class="w-20 h-20 bg-amber-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6 border border-amber-100 group-hover:bg-teal-600 group-hover:border-teal-600 transition-all duration-500 shadow-sm group-hover:shadow-xl group-hover:shadow-teal-600/20">
                            <svg class="w-10 h-10 text-amber-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        </div>
                        <h4 class="text-lg font-black text-slate-900 mb-2 tracking-tight">Cetak Salinan</h4>
                        <p class="text-sm text-slate-500 font-medium leading-relaxed">Cetak salinan hasil pencarian sebagai bukti awal arsip telah ditemukan.</p>
                    </div>

                    {{-- Feature 4 --}}
                    <div class="group text-center">
                        <div class="w-20 h-20 bg-pink-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6 border border-pink-100 group-hover:bg-slate-900 group-hover:border-slate-900 transition-all duration-500 shadow-sm group-hover:shadow-xl group-hover:shadow-slate-900/20">
                            <svg class="w-10 h-10 text-pink-600 group-hover:text-teal-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <h4 class="text-lg font-black text-slate-900 mb-2 tracking-tight">Keamanan Data</h4>
                        <p class="text-sm text-slate-500 font-medium leading-relaxed">Sistem terenkripsi dan dilindungi verifikasi berlapis untuk menjaga privasi Anda.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===== CTA SECTION ===== --}}
        <section class="py-24 bg-slate-50 relative">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative bg-slate-900 rounded-[3.5rem] p-12 md:p-16 text-center overflow-hidden shadow-2xl">
                    {{-- Decorative --}}
                    <div class="absolute top-0 left-0 w-40 h-40 bg-teal-500/10 rounded-br-[6rem]"></div>
                    <div class="absolute bottom-0 right-0 w-60 h-60 bg-teal-500/5 rounded-tl-[8rem]"></div>
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] bg-teal-500/5 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10">
                        <div class="w-20 h-20 bg-teal-500/20 rounded-[2rem] flex items-center justify-center mx-auto mb-8 border border-teal-500/20">
                            <svg class="w-10 h-10 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h3 class="text-3xl md:text-4xl font-black text-white tracking-tight mb-4">
                            Butuh Bantuan Pencarian?
                        </h3>
                        <p class="text-slate-400 font-medium text-lg max-w-xl mx-auto leading-relaxed mb-10">
                            Jika Anda mengalami kesulitan dalam mencari arsip atau memerlukan informasi lebih lanjut, silakan hubungi kami melalui WhatsApp.
                        </p>
                        <a href="https://wa.me/6285171739541?text=Halo%20Admin%20SIPAKTA,%20saya%20membutuhkan%20bantuan." 
                           target="_blank" rel="noopener noreferrer"
                           class="group inline-flex items-center gap-3 px-10 py-5 bg-[#25D366] text-white rounded-2xl font-black text-lg shadow-2xl shadow-[#25D366]/30 hover:shadow-[#25D366]/50 hover:bg-[#22c55e] transition-all active:scale-95">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12c0 2.17.69 4.18 1.86 5.82L3 21l3.31-.85C7.8 21.36 9.81 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm4.31 14.54c-.19.53-.98.98-1.42 1.05-.44.07-.94.22-3.04-.65-2.52-1.05-4.14-3.66-4.26-3.82-.12-.16-1.02-1.36-1.02-2.59s.64-1.84.86-2.07c.22-.22.48-.28.64-.28.16 0 .32.01.45.02.15.01.35-.06.54.4.19.46.66 1.62.72 1.74.06.12.09.26.02.4-.07.14-.11.23-.21.35-.11.12-.23.26-.33.37-.09.09-.19.19-.08.38.11.19.49.81 1.05 1.31.72.64 1.32.84 1.51.93.19.09.31.08.43-.05.12-.14.52-.61.66-.82.14-.21.28-.17.46-.11.18.06 1.15.54 1.35.64.2.1.33.15.38.24.05.09.05.52-.14 1.05z"/></svg>
                            Hubungi Admin KUA
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===== FOOTER ===== --}}
        <footer class="bg-slate-900 pt-16 pb-8 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 pb-12 border-b border-slate-800">
                    {{-- Brand --}}
                    <div>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 bg-teal-600 rounded-2xl flex items-center justify-center shadow-xl shadow-teal-600/20">
                                <img src="{{ asset('images/logo-kua.jpg') }}" alt="Logo KUA" class="w-9 h-9 rounded-lg object-cover">
                            </div>
                            <div>
                                <h4 class="text-white font-black text-xl tracking-tight">SIPAKTA</h4>
                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-[0.3em]">KUA Tegalrejo</p>
                            </div>
                        </div>
                        <p class="text-slate-500 font-medium leading-relaxed text-sm">
                            Sistem Pengarsipan Akta Nikah berbasis digital untuk melayani masyarakat dengan lebih efisien dan transparan.
                        </p>
                    </div>

                    {{-- Quick Links --}}
                    <div>
                        <h5 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Tautan Cepat</h5>
                        <ul class="space-y-3">
                            <li><a href="{{ route('login') }}" class="text-slate-500 hover:text-teal-400 font-medium text-sm transition-colors">Masuk</a></li>
                            <li><a href="{{ route('register') }}" class="text-slate-500 hover:text-teal-400 font-medium text-sm transition-colors">Daftar Akun</a></li>
                            <li><a href="https://wa.me/6285171739541" target="_blank" class="text-slate-500 hover:text-teal-400 font-medium text-sm transition-colors">Hubungi Admin</a></li>
                        </ul>
                    </div>

                    {{-- Contact --}}
                    <div>
                        <h5 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Alamat Kantor</h5>
                        <div class="space-y-3">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-teal-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <p class="text-slate-500 font-medium text-sm">Jl. Tompeyan No.200A, Tegalrejo, Kec. Tegalrejo, Kota Yogyakarta, DIY 55244</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-teal-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <p class="text-slate-500 font-medium text-sm">kua.tegalrejo@kemenag.go.id</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Copyright --}}
                <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                    <p class="text-slate-600 font-bold text-sm">
                        &copy; {{ date('Y') }} KUA Kemantren Tegalrejo &bull; Kementerian Agama Republik Indonesia
                    </p>
                    <p class="text-slate-700 text-xs font-medium">
                        Powered by <span class="text-teal-500 font-bold">SIPAKTA</span>
                    </p>
                </div>
            </div>
        </footer>
    </div>

    {{-- Floating WhatsApp --}}
    <a href="https://wa.me/6285171739541?text=Halo%20Admin%20SIPAKTA,%20saya%20membutuhkan%20bantuan." 
       target="_blank" 
       rel="noopener noreferrer" 
       class="fixed bottom-6 right-6 md:bottom-8 md:right-8 z-50 flex items-center justify-center w-16 h-16 bg-[#25D366] text-white rounded-full shadow-xl shadow-[#25D366]/30 hover:scale-110 hover:shadow-2xl hover:shadow-[#25D366]/50 transition-all"
       title="Hubungi Admin KUA">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12c0 2.17.69 4.18 1.86 5.82L3 21l3.31-.85C7.8 21.36 9.81 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm4.31 14.54c-.19.53-.98.98-1.42 1.05-.44.07-.94.22-3.04-.65-2.52-1.05-4.14-3.66-4.26-3.82-.12-.16-1.02-1.36-1.02-2.59s.64-1.84.86-2.07c.22-.22.48-.28.64-.28.16 0 .32.01.45.02.15.01.35-.06.54.4.19.46.66 1.62.72 1.74.06.12.09.26.02.4-.07.14-.11.23-.21.35-.11.12-.23.26-.33.37-.09.09-.19.19-.08.38.11.19.49.81 1.05 1.31.72.64 1.32.84 1.51.93.19.09.31.08.43-.05.12-.14.52-.61.66-.82.14-.21.28-.17.46-.11.18.06 1.15.54 1.35.64.2.1.33.15.38.24.05.09.05.52-.14 1.05z"/></svg>
    </a>
</body>
</html>