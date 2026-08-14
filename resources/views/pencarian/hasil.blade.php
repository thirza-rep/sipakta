<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-slate-900">Hasil Pencarian</h2>
                <p class="text-slate-600 text-sm mt-1">
                    Ditemukan <strong class="text-teal-700">{{ $results->total() }} data</strong>
                    untuk kata kunci: <strong class="text-slate-800">"{{ $keyword }}"</strong>
                </p>
            </div>
            <a href="{{ route('pencarian.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border-2 border-slate-200 text-slate-700 rounded-xl font-bold text-sm hover:border-teal-400 hover:text-teal-700 transition shadow-sm whitespace-nowrap">
                ← Pencarian Baru
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto pb-32 mt-8 space-y-6">

        {{-- Sticky Search Bar --}}
        <div class="bg-white px-4 py-3 rounded-2xl shadow-md border border-slate-200 sticky top-24 z-40">
            <form action="{{ route('pencarian.search') }}" method="GET" class="flex gap-3">
                <div class="relative flex-1">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="keyword" value="{{ $keyword }}" required
                           class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-medium text-slate-800"
                           placeholder="Cari dengan kata kunci lain...">
                </div>
                <button type="submit"
                        class="px-6 py-2.5 bg-teal-600 text-white rounded-xl font-bold text-sm hover:bg-teal-700 transition shadow-sm whitespace-nowrap">
                    🔍 Cari Ulang
                </button>
            </form>
        </div>

        @if($results->count() > 0)
            <div class="space-y-4">
                @foreach($results as $arsip)
                <div class="bg-white rounded-2xl border-2 border-slate-200 shadow-sm hover:shadow-md hover:border-teal-300 transition-all">
                    <div class="p-5 md:p-6">

                        {{-- Row 1: Badges --}}
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <span class="inline-flex items-center px-3 py-1 bg-teal-50 text-teal-700 rounded-lg font-bold text-xs border border-teal-200">
                                📄 No. Akta: {{ $arsip->nomor_akta }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-lg">
                                🗓 {{ $arsip->tanggal_akad ? \Carbon\Carbon::parse($arsip->tanggal_akad)->translatedFormat('d M Y') : '-' }}
                            </span>
                            @if($arsip->file_path)
                                <span class="inline-flex items-center px-2.5 py-1 bg-green-50 text-green-700 rounded-lg text-xs font-bold border border-green-200">
                                    ✅ Arsip Digital Ada
                                </span>
                            @endif
                        </div>

                        {{-- Row 2: Nama + Tombol --}}
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 leading-snug">
                                    {{ $arsip->nama_suami }}
                                    <span class="text-slate-400 mx-1 font-normal">&</span>
                                    {{ $arsip->nama_istri }}
                                </h3>
                                @if($arsip->lokasi_akad)
                                    <p class="mt-1 text-xs font-medium text-slate-400">
                                        📍 Lokasi Akad: {{ $arsip->lokasi_akad }}
                                    </p>
                                @endif
                            </div>

                            <a href="{{ route('pencarian.detail', $arsip) }}"
                               class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-slate-900 text-white rounded-xl font-bold text-sm hover:bg-teal-600 transition-colors whitespace-nowrap shadow-sm flex-shrink-0">
                                Lihat Rincian →
                            </a>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>

            @if($results->hasPages())
                <div class="p-5 bg-white rounded-2xl border border-slate-200 shadow-sm">
                    {{ $results->appends(['keyword' => $keyword])->links() }}
                </div>
            @endif

        @else
            {{-- Empty State --}}
            <div class="bg-white rounded-3xl p-14 text-center border-2 border-slate-200 shadow-sm">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-5">
                    <svg class="w-9 h-9 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Data Tidak Ditemukan</h3>
                <p class="text-slate-500 text-sm max-w-sm mx-auto mb-7 leading-relaxed">
                    Tidak ada data akta nikah dengan kata kunci
                    <strong class="text-slate-700">"{{ $keyword }}"</strong>.
                    Periksa kembali ejaan atau coba kata kunci lain.
                </p>
                <a href="{{ route('pencarian.index') }}"
                   class="inline-flex items-center gap-2 px-7 py-3 bg-teal-600 text-white rounded-xl font-bold text-sm hover:bg-teal-700 transition shadow-md">
                    ← Kembali ke Pencarian
                </a>
            </div>
        @endif

    </div>
</x-app-layout>






