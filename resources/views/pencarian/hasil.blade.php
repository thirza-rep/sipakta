<x-app-layout>
    <div class="min-h-screen bg-slate-50 pb-32">
        {{-- Sticky Search Header --}}
        <div class="sticky top-[80px] z-40 bg-white/80 backdrop-blur-xl border-b border-slate-100 py-6 mb-12 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center gap-6">
                <a href="{{ route('pencarian.index') }}" class="w-12 h-12 rounded-2xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-400 transition-all active:scale-90 shadow-sm border border-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </a>
                <form action="{{ route('pencarian.search') }}" method="GET" class="flex-1 w-full max-w-2xl relative group">
                    <input type="text" name="keyword" value="{{ $keyword }}"
                           class="w-full pl-12 pr-6 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-bold text-slate-700 placeholder:text-slate-300"
                           placeholder="Cari lagi...">
                    <div class="absolute left-4 top-4 text-slate-300 group-focus-within:text-teal-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </form>
                <div class="hidden md:flex flex-col items-end">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Temuan</span>
                    <span class="text-xl font-black text-teal-600">{{ $results->total() }} Data</span>
                </div>
            </div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            @if($results->count() > 0)
                <div class="grid grid-cols-1 gap-6">
                    @foreach($results as $arsip)
                    <div class="bg-white rounded-[3rem] p-8 md:p-10 border border-slate-100 shadow-xl shadow-slate-200/30 hover:shadow-teal-900/10 transition-all duration-500 group/card relative overflow-hidden transform hover:-translate-y-1">
                        <div class="absolute right-0 top-0 p-10 opacity-[0.02] pointer-events-none group-hover/card:scale-110 transition-transform duration-700">
                            <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" /></svg>
                        </div>
                        
                        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-8">
                            <div class="space-y-6 flex-1">
                                <div class="flex items-center gap-4">
                                    <div class="px-5 py-1.5 bg-teal-50 text-teal-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-teal-100 shadow-sm">
                                        {{ $arsip->nomor_akta }}
                                    </div>
                                    <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">
                                        {{ $arsip->tanggal_akad?->translatedFormat('d F Y') }}
                                    </span>
                                </div>
                                
                                <div class="space-y-2">
                                    <h3 class="text-2xl font-black text-slate-900 tracking-tight leading-tight group-hover/card:text-teal-600 transition-colors">
                                        {{ $arsip->nama_suami }}
                                        <span class="text-slate-300 mx-2">&</span>
                                        {{ $arsip->nama_istri }}
                                    </h3>
                                    <div class="flex items-center gap-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ $arsip->lokasi_fisik ?? 'Lokasi tidak terdaftar' }}
                                        </div>
                                        @if($arsip->file_path)
                                            <div class="flex items-center gap-2 text-teal-600">
                                                <div class="w-2 h-2 bg-teal-500 rounded-full animate-pulse"></div>
                                                SALINAN DIGITAL TERSEDIA
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('pencarian.detail', $arsip) }}" 
                               class="w-full md:w-auto px-10 py-5 bg-slate-900 text-white rounded-2xl font-black shadow-2xl shadow-slate-900/10 hover:bg-teal-600 transition-all active:scale-95 text-[10px] uppercase tracking-widest text-center group/btn shadow-xl shadow-black/5">
                                LIHAT RINCIAN
                                <svg class="w-5 h-5 ml-4 inline group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($results->hasPages())
                    <div class="pt-10">
                        {{ $results->appends(['keyword' => $keyword])->links() }}
                    </div>
                @endif
            @else
                <div class="bg-white rounded-[4rem] p-20 text-center border border-slate-100 shadow-xl shadow-slate-200/50">
                    <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mx-auto mb-8 text-slate-200">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-3xl font-black text-slate-900 tracking-tight mb-4">Nihil. Pencarian Tidak Cocok.</h3>
                    <p class="text-slate-400 font-bold max-w-md mx-auto leading-relaxed mb-10">Kami tidak berhasil menemukan data yang sesuai dengan kata kunci "{{ $keyword }}". Coba gunakan variasi nama atau periksa kembali nomor akta.</p>
                    <a href="{{ route('pencarian.index') }}" class="inline-flex items-center px-12 py-5 bg-teal-600 text-white rounded-2xl font-black shadow-2xl shadow-teal-500/20 hover:bg-teal-500 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                        ULANGI PENCARIAN
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
