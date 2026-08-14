<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-slate-900">
                    Pencarian Arsip Akta Nikah
                </h2>
                <p class="text-slate-600 text-sm mt-1">
                    Selamat datang, <strong>{{ Auth::user()->profilPemohon?->nama_lengkap ?? Auth::user()->name }}</strong>. Temukan arsip dokumen pernikahan Anda di sini.
                </p>
            </div>
            <a href="{{ route('profil-pemohon.show') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border-2 border-slate-200 text-slate-700 rounded-xl font-bold text-sm hover:border-teal-400 hover:text-teal-700 transition shadow-sm whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Lihat Profil Saya
            </a>
        </div>
    </x-slot>

    @php
        $profil = Auth::user()->profilPemohon;
    @endphp

    <div class="max-w-4xl mx-auto space-y-8 pb-32 mt-8">

        {{-- Kartu Identitas Pemohon --}}
        <div class="bg-gradient-to-br from-teal-700 to-teal-900 rounded-2xl p-6 md:p-8 shadow-xl text-white">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-white/15 flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-teal-200 text-xs font-bold uppercase tracking-widest mb-1">Pemohon Terverifikasi</p>
                        <h3 class="text-xl font-bold text-white leading-tight">
                            {{ $profil?->nama_lengkap ?? Auth::user()->name }}
                        </h3>
                        @if($profil?->nik)
                            <p class="text-teal-200 text-sm font-mono mt-0.5">NIK: {{ $profil->nik }}</p>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    @if($profil?->keperluan)
                        <div class="bg-white/10 border border-white/20 rounded-xl px-4 py-3">
                            <p class="text-teal-200 text-xs font-bold uppercase tracking-wider mb-1">Keperluan</p>
                            <p class="text-white text-sm font-semibold leading-snug max-w-xs">{{ Str::limit($profil->keperluan, 80) }}</p>
                        </div>
                    @endif
                    <div class="bg-green-500/20 border border-green-400/30 rounded-xl px-4 py-3 flex items-center gap-2">
                        <span class="text-green-300 text-lg">✅</span>
                        <div>
                            <p class="text-green-200 text-xs font-bold uppercase tracking-wider">Status</p>
                            <p class="text-green-100 text-sm font-bold">Akun Terverifikasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search Card --}}
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-slate-800 p-6 md:p-8 text-white">
                <div class="flex items-center gap-3 mb-2">
                    <div class="p-2 bg-teal-500/20 rounded-lg">
                        <svg class="w-6 h-6 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold">Cari Arsip Akta Nikah Anda</h3>
                </div>
                <p class="text-slate-300 text-sm font-medium">
                    Masukkan salah satu informasi dari dokumen akta nikah yang ingin Anda temukan.
                </p>
            </div>

            <div class="p-6 md:p-8 space-y-6">
                <form action="{{ route('pencarian.search') }}" method="GET" class="space-y-5">
                    <div>
                        <label for="keyword" class="block text-base font-bold text-slate-800 mb-2">Kata Kunci Pencarian</label>
                        <div class="relative">
                            <input type="text" name="keyword" id="keyword" required autofocus
                                   class="w-full pl-12 pr-5 py-4 text-lg bg-slate-50 border-2 border-slate-300 rounded-xl focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-semibold text-slate-900 transition"
                                   placeholder="Masukkan nama, nomor akta, NIK, atau informasi lain...">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full py-4 bg-teal-600 text-white rounded-xl font-bold text-lg hover:bg-teal-700 transition active:scale-[0.98] shadow-lg flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari Arsip Sekarang
                    </button>
                </form>

                {{-- Kata Kunci yang Bisa Digunakan --}}
                <div class="bg-red-50 border-2 border-red-200 rounded-xl p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h4 class="font-bold text-red-700 text-base">Kata Kunci yang Dapat Digunakan untuk Pencarian</h4>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- Administrasi --}}
                        <div>
                            <p class="text-xs font-bold text-red-500 uppercase tracking-widest mb-2">📋 Data Administrasi</p>
                            <ul class="space-y-1.5">
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500 font-bold mt-0.5">•</span>
                                    <span class="text-red-700 text-sm font-medium"><strong>Nomor Akta</strong> — contoh: <em>001/KUA/2023</em></span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500 font-bold mt-0.5">•</span>
                                    <span class="text-red-700 text-sm font-medium"><strong>Nomor Buku</strong> — nomor buku register akta</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500 font-bold mt-0.5">•</span>
                                    <span class="text-red-700 text-sm font-medium"><strong>Tanggal Akad</strong> — contoh: <em>2023-07-15</em></span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500 font-bold mt-0.5">•</span>
                                    <span class="text-red-700 text-sm font-medium"><strong>Lokasi Akad</strong> — tempat ijab kabul dilaksanakan</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500 font-bold mt-0.5">•</span>
                                    <span class="text-red-700 text-sm font-medium"><strong>Kategori Arsip</strong> — kategori pengelompokan dokumen</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500 font-bold mt-0.5">•</span>
                                    <span class="text-red-700 text-sm font-medium"><strong>Lokasi Fisik</strong> — lokasi penyimpanan berkas fisik</span>
                                </li>
                            </ul>
                        </div>

                        {{-- Data Suami & Istri --}}
                        <div>
                            <p class="text-xs font-bold text-red-500 uppercase tracking-widest mb-2">👤 Data Suami & Istri</p>
                            <ul class="space-y-1.5">
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500 font-bold mt-0.5">•</span>
                                    <span class="text-red-700 text-sm font-medium"><strong>Nama Suami</strong> — nama lengkap mempelai pria</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500 font-bold mt-0.5">•</span>
                                    <span class="text-red-700 text-sm font-medium"><strong>NIK Suami</strong> — 16 digit nomor KTP suami</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500 font-bold mt-0.5">•</span>
                                    <span class="text-red-700 text-sm font-medium"><strong>Tempat Lahir Suami</strong> — kota/kabupaten kelahiran</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500 font-bold mt-0.5">•</span>
                                    <span class="text-red-700 text-sm font-medium"><strong>Alamat Suami</strong> — alamat domisili mempelai pria</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500 font-bold mt-0.5">•</span>
                                    <span class="text-red-700 text-sm font-medium"><strong>Nama Istri</strong> — nama lengkap mempelai wanita</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500 font-bold mt-0.5">•</span>
                                    <span class="text-red-700 text-sm font-medium"><strong>NIK Istri</strong> — 16 digit nomor KTP istri</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500 font-bold mt-0.5">•</span>
                                    <span class="text-red-700 text-sm font-medium"><strong>Tempat Lahir Istri</strong> — kota/kabupaten kelahiran</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-500 font-bold mt-0.5">•</span>
                                    <span class="text-red-700 text-sm font-medium"><strong>Alamat Istri</strong> — alamat domisili mempelai wanita</span>
                                </li>
                            </ul>
                        </div>

                        {{-- Wali, Penghulu, Lainnya --}}
                        <div class="sm:col-span-2">
                            <p class="text-xs font-bold text-red-500 uppercase tracking-widest mb-2">🕌 Wali, Penghulu & Lainnya</p>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                <div class="flex items-start gap-2">
                                    <span class="text-red-500 font-bold mt-0.5">•</span>
                                    <span class="text-red-700 text-sm font-medium"><strong>Nama Wali</strong> — nama wali nikah</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <span class="text-red-500 font-bold mt-0.5">•</span>
                                    <span class="text-red-700 text-sm font-medium"><strong>Nama Penghulu</strong> — petugas pencatat nikah</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <span class="text-red-500 font-bold mt-0.5">•</span>
                                    <span class="text-red-700 text-sm font-medium"><strong>Mas Kawin</strong> — mahar pernikahan</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Informasi Penting --}}
        <div class="bg-amber-50 border-2 border-amber-200 rounded-2xl p-6">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div>
                    <h4 class="font-bold text-amber-900 text-base mb-1">Informasi Penting untuk Pemohon</h4>
                    <p class="text-amber-800 font-medium leading-relaxed text-sm">
                        Hasil pencarian ini merupakan data referensi digital. Jika Anda membutuhkan
                        <strong>kutipan atau legalisir dokumen resmi</strong>, Anda tetap harus datang langsung ke
                        <strong>Kantor KUA Kemantren Tegalrejo</strong> dengan membawa KTP asli dan dokumen pendukung.
                    </p>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
