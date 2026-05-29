<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-slate-900">
            Hasil Pencarian
        </h2>
        <p class="text-slate-600 text-sm mt-1">Ditemukan {{ $results->total() }} data untuk kata kunci: <strong class="text-teal-700">"{{ $keyword }}"</strong></p>
    </x-slot>

    <div class="max-w-5xl mx-auto pb-32 mt-8">
        {{-- Sticky Search Bar --}}
        <div class="bg-white p-4 rounded-2xl shadow-md border border-slate-200 mb-10 sticky top-24 z-40">
            <form action="{{ route('pencarian.search') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <input type="text" name="keyword" value="{{ $keyword }}" required
                       class="flex-1 px-4 py-3 text-lg bg-slate-50 border-2 border-slate-300 rounded-xl focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-bold text-slate-800"
                       placeholder="Cari lagi...">
                <button type="submit" class="px-8 py-3 bg-teal-600 text-white rounded-xl font-bold text-lg hover:bg-teal-700 transition shadow-sm">
                    🔍 Cari Ulang
                </button>
            </form>
        </div>

        @if($results->count() > 0)
            <div class="space-y-6">
                @foreach($results as $arsip)
                <div class="bg-white rounded-2xl p-6 md:p-8 border-2 border-slate-200 shadow-sm hover:shadow-lg hover:border-teal-300 transition-all">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        
                        <div class="space-y-4 flex-1">
                            <div class="flex items-center gap-3">
                                <span class="px-4 py-1.5 bg-teal-100 text-teal-800 rounded-lg font-bold text-sm border border-teal-200">
                                    No. Akta: {{ $arsip->nomor_akta }}
                                </span>
                                <span class="text-sm font-bold text-slate-500">
                                    {{ $arsip->tanggal_akad ? \Carbon\Carbon::parse($arsip->tanggal_akad)->translatedFormat('d M Y') : '-' }}
                                </span>
                            </div>
                            
                            <div>
                                <h3 class="text-2xl font-bold text-slate-900 leading-tight">
                                    {{ $arsip->nama_suami }}
                                    <span class="text-slate-400 mx-2">&amp;</span>
                                    {{ $arsip->nama_istri }}
                                </h3>
                                <div class="mt-2 flex flex-col sm:flex-row gap-4 text-sm font-semibold text-slate-600">
                                    <span class="flex items-center gap-1">
                                        📍 Lokasi: {{ $arsip->lokasi_fisik ?? 'Belum terdaftar' }}
                                    </span>
                                    @if($arsip->file_path)
                                        <span class="flex items-center gap-1 text-green-700">
                                            ✅ Tersedia File Digital
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('pencarian.detail', $arsip) }}" 
                           class="w-full md:w-auto px-8 py-4 bg-slate-900 text-white rounded-xl font-bold text-base hover:bg-teal-600 transition-colors text-center whitespace-nowrap shadow-md">
                            Lihat Rincian ↗
                        </a>

                    </div>
                </div>
                @endforeach
            </div>

            @if($results->hasPages())
                <div class="mt-10 p-6 bg-white rounded-2xl border border-slate-200 shadow-sm">
                    {{ $results->appends(['keyword' => $keyword])->links() }}
                </div>
            @endif
        @else
            <div class="bg-white rounded-3xl p-12 text-center border-2 border-slate-200 shadow-sm">
                <span class="text-6xl block mb-6">🔍</span>
                <h3 class="text-2xl font-bold text-slate-900 mb-3">Pencarian Tidak Ditemukan</h3>
                <p class="text-slate-600 font-medium text-lg max-w-lg mx-auto mb-8">
                    Kami tidak menemukan data akta nikah dengan kata kunci <strong>"{{ $keyword }}"</strong>. Coba periksa kembali ejaan nama atau nomor yang Anda masukkan.
                </p>
                <a href="{{ route('pencarian.index') }}" class="inline-block px-8 py-4 bg-teal-600 text-white rounded-xl font-bold text-lg hover:bg-teal-700 transition shadow-md">
                    Kembali ke Pencarian Utama
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
