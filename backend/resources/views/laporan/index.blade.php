<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                    {{ __('Pusat Laporan') }}
                </h2>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mt-1">Sistem Pengarsipan Akta Nikah</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="px-5 py-2.5 bg-white border border-slate-100 rounded-2xl shadow-sm flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
                    <span class="text-xs font-black text-slate-600 uppercase tracking-widest">{{ now()->translatedFormat('d F Y') }}</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-10 pb-20">
        {{-- Glass Header --}}
        <div class="bg-white/40 backdrop-blur-xl border border-white/20 p-8 rounded-[3rem] shadow-xl shadow-slate-200/50 flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-[2rem] bg-slate-900 flex items-center justify-center text-teal-400 mr-6 shadow-xl shadow-slate-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Pusat Laporan</h1>
                    <p class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.2em] mt-1">Sistem Pengarsipan Akta Nikah</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="px-6 py-4 bg-teal-50 rounded-2xl border border-teal-100">
                    <span class="text-[10px] font-black text-teal-600 uppercase tracking-widest block mb-1 text-center">Update Terakhir</span>
                    <span class="text-sm font-black text-teal-900 block text-center">{{ now()->translatedFormat('d F Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-teal-600/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                <div class="w-12 h-12 rounded-2xl bg-teal-50 flex items-center justify-center text-teal-600 mb-6 border border-teal-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1">Total Data Arsip</p>
                <h4 class="text-4xl font-black text-slate-900 tabular-nums mb-2">{{ number_format($stats['total_arsip']) }}</h4>
                <div class="text-[10px] font-bold text-teal-500 bg-teal-50 px-3 py-1 rounded-full w-fit border border-teal-100">SELURUH WAKTU</div>
            </div>

            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-blue-600/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 mb-6 border border-blue-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1">Arsip Bulan Ini</p>
                <h4 class="text-4xl font-black text-slate-900 tabular-nums mb-2">{{ number_format($stats['arsip_bulan_ini']) }}</h4>
                <div class="text-[10px] font-bold text-blue-500 bg-blue-50 px-3 py-1 rounded-full w-fit border border-blue-100">{{ now()->translatedFormat('F Y') }}</div>
            </div>

            <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-orange-600/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-600 mb-6 border border-orange-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1">Arsip Tahun Ini</p>
                <h4 class="text-4xl font-black text-slate-900 tabular-nums mb-2">{{ number_format($stats['arsip_tahun_ini']) }}</h4>
                <div class="text-[10px] font-bold text-orange-500 bg-orange-50 px-3 py-1 rounded-full w-fit border border-orange-100">TAHUN {{ date('Y') }}</div>
            </div>
        </div>

        {{-- Report Modules --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            {{-- Bulanan --}}
            <a href="{{ route('laporan.bulanan') }}" class="group relative bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-slate-200 transition-all duration-500 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-teal-600/5 rounded-bl-[5rem] group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 rounded-[2rem] bg-teal-600 flex items-center justify-center text-white mb-8 shadow-xl shadow-teal-100 group-hover:rotate-6 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 mb-4 tracking-tight">Laporan Bulanan</h3>
                    <p class="text-slate-400 font-medium leading-relaxed mb-8 max-w-sm">
                        Modul laporan detail untuk melihat data kearsipan berdasarkan filter bulan dan tahun secara spesifik.
                    </p>
                    <div class="flex items-center text-teal-600 font-black text-sm tracking-widest uppercase group-hover:translate-x-3 transition-transform">
                        Buka Modul Laporan
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </div>
                </div>
            </a>

            {{-- Rekap --}}
            <a href="{{ route('laporan.rekap') }}" class="group relative bg-slate-900 rounded-[3rem] p-10 shadow-xl hover:shadow-2xl hover:shadow-slate-300 transition-all duration-500 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-[5rem] group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 rounded-[2rem] bg-white/10 backdrop-blur-md flex items-center justify-center text-teal-400 mb-8 border border-white/5 group-hover:-rotate-6 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-white mb-4 tracking-tight">Rekap Tahunan</h3>
                    <p class="text-slate-500 font-medium leading-relaxed mb-8 max-w-sm">
                        Visualisasi statistik data tahunan yang dirangkum per bulan untuk melihat tren dan performa pengarsipan.
                    </p>
                    <div class="flex items-center text-teal-400 font-black text-sm tracking-widest uppercase group-hover:translate-x-3 transition-transform">
                        Buka Rekap Tahunan
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
</x-app-layout>
