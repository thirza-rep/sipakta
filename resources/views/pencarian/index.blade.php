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
        <div class="rounded-2xl shadow-xl text-white overflow-hidden" style="background: linear-gradient(135deg, #0f766e 0%, #134e4a 100%);">
            <div class="p-5 md:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                    {{-- Kiri: Avatar + Nama --}}
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(255,255,255,0.15);">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest mb-0.5" style="color: #99f6e4;">Pemohon Terverifikasi</p>
                            <h3 class="text-lg font-bold text-white leading-tight">
                                {{ $profil?->nama_lengkap ?? Auth::user()->name }}
                            </h3>
                            @if($profil?->nik)
                                <p class="text-xs font-mono mt-0.5" style="color: #99f6e4;">NIK: {{ $profil->nik }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Kanan: Keperluan + Status --}}
                    <div class="flex flex-wrap gap-2 sm:flex-nowrap sm:gap-3">
                        @if($profil?->keperluan)
                            <div class="rounded-xl px-4 py-2.5 flex-1 sm:flex-none sm:max-w-xs" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                <p class="text-xs font-bold uppercase tracking-wider mb-0.5" style="color: #99f6e4;">Keperluan</p>
                                <p class="text-white text-sm font-medium leading-snug">{{ Str::limit($profil->keperluan, 60) }}</p>
                            </div>
                        @endif
                        <div class="rounded-xl px-4 py-2.5 flex items-center gap-2.5 flex-shrink-0" style="background: rgba(34,197,94,0.2); border: 1px solid rgba(134,239,172,0.3);">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0" style="background: rgba(34,197,94,0.3);">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="#86efac" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider" style="color: #86efac;">Status</p>
                                <p class="text-white text-xs font-bold">Terverifikasi</p>
                            </div>
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
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h4 class="font-bold text-red-700 text-base">Informasi yang Dapat Dijadikan Kata Kunci</h4>
                    </div>
                    <p class="text-red-500 text-xs font-medium mb-4 ml-7">Gunakan salah satu informasi yang Anda ingat dari dokumen pernikahan.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">

                        {{-- Nama --}}
                        <div>
                            <p class="text-xs font-bold text-red-500 uppercase tracking-widest mb-2.5">👤 Nama Pasangan</p>
                            <ul class="space-y-2">
                                <li class="flex items-start gap-2">
                                    <span class="text-red-400 font-bold mt-0.5 flex-shrink-0">•</span>
                                    <span class="text-red-700 text-sm font-medium">
                                        <strong>Nama Suami</strong>
                                        <span class="text-red-400 font-normal"> — nama lengkap mempelai pria</span>
                                    </span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-400 font-bold mt-0.5 flex-shrink-0">•</span>
                                    <span class="text-red-700 text-sm font-medium">
                                        <strong>Nama Istri</strong>
                                        <span class="text-red-400 font-normal"> — nama lengkap mempelai wanita</span>
                                    </span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-400 font-bold mt-0.5 flex-shrink-0">•</span>
                                    <span class="text-red-700 text-sm font-medium">
                                        <strong>Nama Wali Nikah</strong>
                                        <span class="text-red-400 font-normal"> — nama wali yang hadir saat akad</span>
                                    </span>
                                </li>
                            </ul>
                        </div>

                        {{-- Akad --}}
                        <div>
                            <p class="text-xs font-bold text-red-500 uppercase tracking-widest mb-2.5">📅 Waktu & Tempat Akad</p>
                            <ul class="space-y-2">
                                <li class="flex items-start gap-2">
                                    <span class="text-red-400 font-bold mt-0.5 flex-shrink-0">•</span>
                                    <span class="text-red-700 text-sm font-medium">
                                        <strong>Tanggal Akad Nikah</strong>
                                        <span class="text-red-400 font-normal"> — contoh: <em>2023-07-15</em> atau <em>Juli 2023</em></span>
                                    </span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-400 font-bold mt-0.5 flex-shrink-0">•</span>
                                    <span class="text-red-700 text-sm font-medium">
                                        <strong>Lokasi/Tempat Akad</strong>
                                        <span class="text-red-400 font-normal"> — masjid, rumah, atau nama tempat akad</span>
                                    </span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-red-400 font-bold mt-0.5 flex-shrink-0">•</span>
                                    <span class="text-red-700 text-sm font-medium">
                                        <strong>Tempat Lahir Suami/Istri</strong>
                                        <span class="text-red-400 font-normal"> — kota/kabupaten kelahiran</span>
                                    </span>
                                </li>
                            </ul>
                        </div>

                        {{-- Nomor Akta --}}
                        <div class="sm:col-span-2 pt-3 border-t border-red-200">
                            <p class="text-xs font-bold text-red-500 uppercase tracking-widest mb-2.5">📄 Nomor Dokumen (Jika Tersedia)</p>
                            <div class="flex items-start gap-2">
                                <span class="text-red-400 font-bold mt-0.5 flex-shrink-0">•</span>
                                <span class="text-red-700 text-sm font-medium">
                                    <strong>Nomor Akta Nikah</strong>
                                    <span class="text-red-400 font-normal"> — tertera di lembar kutipan akta nikah Anda, contoh: <em>001/KUA/2023</em></span>
                                </span>
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
