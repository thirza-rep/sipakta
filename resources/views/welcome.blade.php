<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SIPAKTA') }}</title>
    <link rel="icon" href="{{ asset('images/logo-kua.jpg') }}" type="image/jpeg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Outfit', sans-serif; }</style>
</head>
<body class="antialiased bg-slate-50 text-slate-800">
    <div class="min-h-screen flex flex-col">
        
        {{-- Header / Navigation --}}
        <header class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo-kua.jpg') }}" alt="Logo KUA" class="w-12 h-12 rounded-xl object-cover">
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-teal-800 leading-tight">SIPAKTA</h1>
                        <p class="text-xs md:text-sm font-semibold text-slate-500 hidden sm:block">KUA Kemantren Tegalrejo</p>
                    </div>
                </div>
                <div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-teal-600 text-white rounded-xl font-bold text-base hover:bg-teal-700 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-slate-100 text-teal-800 border border-slate-300 rounded-xl font-bold text-base hover:bg-slate-200 transition">Masuk</a>
                    @endauth
                </div>
            </div>
        </header>

        {{-- Main Hero Section --}}
        <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-20 flex flex-col items-center text-center">
            
            <div class="max-w-3xl space-y-8">
                <span class="inline-block px-5 py-2 bg-teal-100 text-teal-800 rounded-full font-bold text-sm border border-teal-200">
                    Sistem Informasi Kearsipan Digital
                </span>

                <h2 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Layanan Pencarian <br> <span class="text-teal-600">Arsip Akta Nikah</span>
                </h2>

                <p class="text-lg md:text-xl font-medium text-slate-600 leading-relaxed">
                    Selamat datang di layanan pencarian arsip akta nikah KUA Kemantren Tegalrejo, Kota Yogyakarta. Kini Anda dapat mencari dan melihat salinan digital dokumen pernikahan keluarga dengan mudah dan cepat.
                </p>

                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl border border-slate-200 mt-10">
                    <h3 class="text-xl font-bold text-slate-800 mb-4">Mulai Pencarian Arsip</h3>
                    @auth
                        <a href="{{ route('pencarian.index') }}" class="flex items-center justify-center w-full px-8 py-5 bg-teal-600 text-white rounded-xl font-bold text-lg md:text-xl shadow-lg hover:bg-teal-700 transition active:scale-95">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Cari Arsip Sekarang
                        </a>
                    @else
                        <p class="text-slate-600 font-medium mb-6 text-base">Silakan daftar atau masuk terlebih dahulu untuk mengakses layanan pencarian.</p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('register') }}" class="flex flex-1 items-center justify-center px-8 py-4 bg-teal-600 text-white rounded-xl font-bold text-lg shadow-lg hover:bg-teal-700 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                Daftar Akun Baru
                            </a>
                            <a href="{{ route('login') }}" class="flex flex-1 items-center justify-center px-8 py-4 bg-white text-teal-700 border-2 border-teal-200 rounded-xl font-bold text-lg hover:bg-teal-50 transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                Masuk ke Akun
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            {{-- Info Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-20 w-full text-left">
                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="mb-4 text-teal-600">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-2">Arsip Digital</h4>
                    <p class="text-base text-slate-600 leading-relaxed">Data pernikahan tersimpan aman dalam format digital yang mudah diakses kapan saja dibutuhkan.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="mb-4 text-teal-600">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-2">Pencarian Mudah</h4>
                    <p class="text-base text-slate-600 leading-relaxed">Cukup masukkan nama suami/istri atau nomor akta nikah untuk menemukan dokumen yang dicari.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="mb-4 text-teal-600">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-800 mb-2">Salinan Cetak</h4>
                    <p class="text-base text-slate-600 leading-relaxed">Anda dapat mencetak salinan hasil pencarian sebagai bukti awal arsip telah ditemukan.</p>
                </div>
            </div>
            
        </main>

        {{-- Footer --}}
        <footer class="bg-slate-900 py-10 text-center mt-auto">
            <div class="max-w-7xl mx-auto px-4">
                <p class="text-slate-400 font-bold text-sm md:text-base">
                    &copy; {{ date('Y') }} KUA Kemantren Tegalrejo &bull; Kementerian Agama Republik Indonesia
                </p>
                <p class="text-slate-500 font-medium text-sm mt-2">
                    Jl. Magelang KM 4,5 No.03, Tegalrejo, Kota Yogyakarta
                </p>
            </div>
        </footer>
    </div>

    {{-- Floating WhatsApp --}}
    <a href="https://wa.me/6285171739541?text=Halo%20Admin%20SIPAKTA,%20saya%20membutuhkan%20bantuan." 
       target="_blank" 
       rel="noopener noreferrer" 
       class="fixed bottom-6 right-6 md:bottom-8 md:right-8 z-50 flex items-center justify-center w-16 h-16 bg-[#25D366] text-white rounded-full shadow-xl hover:scale-110 transition-transform"
       title="Hubungi Admin KUA">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12c0 2.17.69 4.18 1.86 5.82L3 21l3.31-.85C7.8 21.36 9.81 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm4.31 14.54c-.19.53-.98.98-1.42 1.05-.44.07-.94.22-3.04-.65-2.52-1.05-4.14-3.66-4.26-3.82-.12-.16-1.02-1.36-1.02-2.59s.64-1.84.86-2.07c.22-.22.48-.28.64-.28.16 0 .32.01.45.02.15.01.35-.06.54.4.19.46.66 1.62.72 1.74.06.12.09.26.02.4-.07.14-.11.23-.21.35-.11.12-.23.26-.33.37-.09.09-.19.19-.08.38.11.19.49.81 1.05 1.31.72.64 1.32.84 1.51.93.19.09.31.08.43-.05.12-.14.52-.61.66-.82.14-.21.28-.17.46-.11.18.06 1.15.54 1.35.64.2.1.33.15.38.24.05.09.05.52-.14 1.05z"/></svg>
    </a>
</body>
</html>