<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-slate-900">
                    Hasil Pencarian
                </h2>
                <p class="text-slate-600 text-sm mt-1">
                    Ditemukan <strong class="text-teal-700">{{ $results->total() }} data</strong>
                    untuk kata kunci: <strong class="text-slate-800">"{{ $keyword }}"</strong>
                </p>
            </div>
            <a href="{{ route('pencarian.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border-2 border-slate-200 text-slate-700 rounded-xl font-bold text-sm hover:border-teal-400 hover:text-teal-700 transition shadow-sm whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Cari Ulang
            </a>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto pb-32 mt-8 space-y-8">

        {{-- Sticky Search Bar --}}
        <div class="bg-white p-4 rounded-2xl shadow-md border border-slate-200 sticky top-24 z-40">
            <form action="{{ route('pencarian.search') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-1">
                    <input type="text" name="keyword" value="{{ $keyword }}" required
                           class="w-full pl-11 pr-4 py-3 text-base bg-slate-50 border-2 border-slate-300 rounded-xl focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-semibold text-slate-800"
                           placeholder="Cari dengan kata kunci lain...">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <button type="submit"
                        class="px-8 py-3 bg-teal-600 text-white rounded-xl font-bold text-base hover:bg-teal-700 transition shadow-sm flex items-center gap-2 justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari Ulang
                </button>
            </form>
        </div>

        @if($results->count() > 0)
            <div class="space-y-5">
                @foreach($results as $arsip)
                <div class="bg-white rounded-2xl border-2 border-slate-200 shadow-sm hover:shadow-lg hover:border-teal-300 transition-all overflow-hidden">
                    <div class="p-6 md:p-7 flex flex-col md:flex-row justify-between items-start md:items-center gap-5">

                        <div class="space-y-3 flex-1">
                            {{-- Nomor Akta & Tanggal --}}
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-3 py-1.5 bg-teal-100 text-teal-800 rounded-lg font-bold text-sm border border-teal-200">
                                    No. Akta: {{ $arsip->nomor_akta }}
                                </span>
                                <span class="text-sm font-semibold text-slate-500 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $arsip->tanggal_akad ? \Carbon\Carbon::parse($arsip->tanggal_akad)->translatedFormat('d M Y') : '-' }}
                                </span>
                                @if($arsip->file_path)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold border border-green-200">
                                        ✅ Arsip Digital Ada
                                    </span>
                                @endif
                            </div>

                            {{-- Nama Pasangan --}}
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 leading-tight">
                                    {{ $arsip->nama_suami }}
                                    <span class="text-slate-400 mx-1.5">&</span>
                                    {{ $arsip->nama_istri }}
                                </h3>
                                @if($arsip->lokasi_akad)
                                    <p class="mt-1 text-sm font-medium text-slate-500 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        Lokasi Akad: {{ $arsip->lokasi_akad }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('pencarian.detail', $arsip) }}"
                           class="w-full md:w-auto px-7 py-3.5 bg-slate-900 text-white rounded-xl font-bold text-base hover:bg-teal-600 transition-colors text-center whitespace-nowrap shadow-md flex items-center justify-center gap-2">
                            Lihat Rincian
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>

                    </div>
                </div>
                @endforeach
            </div>

            @if($results->hasPages())
                <div class="mt-8 p-5 bg-white rounded-2xl border border-slate-200 shadow-sm">
                    {{ $results->appends(['keyword' => $keyword])->links() }}
                </div>
            @endif
        @else
            <div class="bg-white rounded-3xl p-12 text-center border-2 border-slate-200 shadow-sm">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-3">Data Tidak Ditemukan</h3>
                <p class="text-slate-600 font-medium text-base max-w-md mx-auto mb-8">
                    Kami tidak menemukan data akta nikah dengan kata kunci
                    <strong class="text-slate-800">"{{ $keyword }}"</strong>.
                    Coba periksa kembali ejaan nama atau nomor yang Anda masukkan.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('pencarian.index') }}"
                       class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-teal-600 text-white rounded-xl font-bold text-base hover:bg-teal-700 transition shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Coba Pencarian Lain
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>



