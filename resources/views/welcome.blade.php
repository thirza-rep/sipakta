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
                        <a href="{{ route('pencarian.index') }}" class="block w-full px-8 py-5 bg-teal-600 text-white rounded-xl font-bold text-lg md:text-xl shadow-lg hover:bg-teal-700 transition active:scale-95">
                            🔍 Cari Arsip Sekarang
                        </a>
                    @else
                        <p class="text-slate-600 font-medium mb-6 text-base">Silakan daftar atau masuk terlebih dahulu untuk mengakses layanan pencarian.</p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('register') }}" class="flex-1 px-8 py-4 bg-teal-600 text-white rounded-xl font-bold text-lg shadow-lg hover:bg-teal-700 transition">
                                📝 Daftar Akun Baru
                            </a>
                            <a href="{{ route('login') }}" class="flex-1 px-8 py-4 bg-white text-teal-700 border-2 border-teal-200 rounded-xl font-bold text-lg hover:bg-teal-50 transition">
                                🔑 Masuk ke Akun
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            {{-- Info Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-20 w-full text-left">
                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="text-4xl mb-4">📂</div>
                    <h4 class="text-xl font-bold text-slate-800 mb-2">Arsip Digital</h4>
                    <p class="text-base text-slate-600 leading-relaxed">Data pernikahan tersimpan aman dalam format digital yang mudah diakses kapan saja dibutuhkan.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="text-4xl mb-4">🔍</div>
                    <h4 class="text-xl font-bold text-slate-800 mb-2">Pencarian Mudah</h4>
                    <p class="text-base text-slate-600 leading-relaxed">Cukup masukkan nama suami/istri atau nomor akta nikah untuk menemukan dokumen yang dicari.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="text-4xl mb-4">🖨️</div>
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
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
        </svg>
    </a>
</body>
</html>