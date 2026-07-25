<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Data Akta Nikah</h2>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mt-1">Manajemen Arsip KUA Kemantren Tegalrejo</p>
            </div>
            <a href="{{ route('akta-nikah.create') }}" 
               class="bg-teal-600 text-white px-8 py-4 rounded-[1.4rem] font-black shadow-xl shadow-teal-600/20 hover:bg-teal-700 active:scale-95 transition-all flex items-center justify-center uppercase tracking-widest text-[10px]">
                
                TAMBAH DATA BARU
            </a>
        </div>
    </x-slot>

    <div class="space-y-8 pb-12">
        @if(session('success'))
            <div class="p-6 bg-teal-50 border border-teal-100 rounded-[2rem] flex items-center justify-between text-teal-800 shadow-sm animate-fade-in">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-teal-500 rounded-2xl flex items-center justify-center text-white mr-4 shadow-teal-200 shadow-lg">
                        
                    </div>
                    <span class="font-black tracking-tight">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- Integrated Search & Filter --}}
        <div class="glass-card rounded-[2.5rem] p-3 flex flex-col lg:flex-row items-stretch gap-3 shadow-xl shadow-slate-200/50">
            <div class="flex-1 relative group">
                <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none text-slate-300 group-focus-within:text-teal-500 transition-colors">
                    
                </div>
                <form action="{{ route('akta-nikah.index') }}" method="GET" id="listingSearch" class="h-full">
                    <input type="text" name="q" value="{{ request('q') }}" 
                           placeholder="Cari Nomor Akta, Nama Suami, atau Istri..." 
                           class="w-full h-full pl-16 pr-8 py-5 bg-transparent border-none focus:ring-0 text-slate-700 font-bold placeholder:text-slate-300">
                </form>
            </div>
            <div class="flex items-center gap-2 p-1.5 bg-white rounded-[1.8rem] shadow-sm">
                @if(request('q'))
                    <a href="{{ route('akta-nikah.index') }}" class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-red-500 transition">Reset</a>
                @endif
                <button type="submit" form="listingSearch" class="px-10 py-4 bg-slate-900 text-white rounded-[1.4rem] text-[10px] font-black uppercase tracking-widest shadow-lg shadow-slate-900/10 hover:bg-slate-800 transition active:scale-95">
                    Filter Data
                </button>
            </div>
        </div>

        {{-- Desktop Listing --}}
        <div class="hidden md:block bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Data Pasangan</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Identitas Arsip</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Waktu Akad</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @if ($akta->count() > 0)
                        @foreach ($akta as $item)
                        <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                            <td class="px-10 py-8">
                                <div class="flex items-center">
                                    <div class="w-1.5 h-12 bg-teal-500/20 rounded-full mr-6 group-hover:bg-teal-500 transition-colors"></div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-slate-900 group-hover:text-teal-700 transition-colors">{{ $item->nama_suami }}</span>
                                        <div class="flex items-center gap-2 mt-1">
                                            <div class="h-px w-3 bg-slate-200"></div>
                                            <span class="text-xs font-bold text-slate-400">{{ $item->nama_istri }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="flex flex-col">
                                    <span class="text-xs font-black text-slate-800 uppercase tabular-nums tracking-tight bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200 w-fit">{{ $item->nomor_akta }}</span>
                                    <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest mt-2">Buku: {{ $item->nomor_buku ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <span class="text-sm font-bold text-slate-600 tabular-nums">
                                    {{ $item->tanggal_akad?->translatedFormat('d M Y') }}
                                </span>
                            </td>
                            <td class="px-10 py-8">
                                @if($item->file_path)
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-lg bg-teal-50 flex items-center justify-center text-teal-600 border border-teal-100">
                                            
                                        </div>
                                        <span class="text-[9px] font-black text-teal-600 uppercase tracking-[0.15em]">Digital</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2.5 opacity-40 grayscale">
                                        <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 border border-slate-200">
                                            
                                        </div>
                                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.15em]">Fisik</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ route('akta-nikah.show', $item->id) }}" class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-slate-900 hover:text-white hover:border-slate-900 hover:shadow-xl transition-all duration-300">
                                        
                                    </a>
                                    <a href="{{ route('akta-nikah.edit', $item) }}" class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-amber-500 hover:bg-amber-500 hover:text-white hover:border-amber-500 transition-all duration-300">
                                        
                                    </a>
                                    <form action="{{ route('akta-nikah.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data ini permanent?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-rose-400 hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all duration-300">
                                            
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center bg-slate-50/10">
                                <div class="flex flex-col items-center">
                                    <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center text-4xl mb-6 grayscale opacity-40">📂</div>
                                    <h4 class="text-xl font-black text-slate-900 tracking-tight">Data Belum Tersedia</h4>
                                    <p class="text-slate-400 text-xs font-bold mt-2 max-w-xs mx-auto uppercase tracking-widest leading-loose">Silakan tambahkan data arsip baru atau ubah filter pencarian Anda.</p>
                                </div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Mobile Card Listing --}}
        <div class="md:hidden space-y-4">
            @if ($akta->count() > 0)
            @foreach ($akta as $item)
           <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm relative overflow-hidden group">
                <div class="flex flex-col gap-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-teal-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-teal-100">
                                <span class="text-lg font-black">{{ strtoupper(substr($item->nama_suami, 0, 1)) }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-lg font-black text-slate-900 leading-tight">{{ $item->nama_suami }}</span>
                                <span class="text-sm font-bold text-slate-400 italic">& {{ $item->nama_istri }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-6 pt-6 border-t border-slate-50">
                        <div>
                            <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest block mb-1">Nomor Akta</span>
                            <span class="text-xs font-black text-slate-700 tracking-tight">{{ $item->nomor_akta }}</span>
                        </div>
                        <div>
                            <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest block mb-1">Tanggal Akad</span>
                            <span class="text-xs font-black text-slate-700 tabular-nums">{{ $item->tanggal_akad?->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                        @if($item->file_path)
                            <span class="inline-flex items-center px-4 py-1.5 bg-teal-50 text-teal-600 rounded-full text-[9px] font-black uppercase tracking-widest border border-teal-100/50">Digital</span>
                        @else
                            <span class="inline-flex items-center px-4 py-1.5 bg-slate-50 text-slate-400 rounded-full text-[9px] font-black uppercase tracking-widest border border-slate-100/50">Fisik</span>
                        @endif
                        <div class="flex items-center gap-3">
                            <a href="{{ route('akta-nikah.edit', $item) }}" class="p-2 text-amber-500 hover:bg-amber-50 rounded-xl transition">
                                
                            </a>
                            <a href="{{ route('akta-nikah.show', $item->id) }}" class="px-5 py-2 bg-slate-900 text-white rounded-xl text-[9px] font-black uppercase tracking-widest transition active:scale-95">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="bg-white rounded-[2.5rem] p-12 text-center border border-slate-100">
                <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest">Belum ada data tersedia.</p>
            </div>
            @endif
        </div>

        {{-- Custom Premium Pagination --}}
        <div class="premium-pagination">
            {{ $akta->withQueryString()->links() }}
        </div>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fade-in 0.5s ease-out; }
        
        .premium-pagination nav { border-radius: 2rem; overflow: hidden; background: white; padding: 0.6rem; border: 1px solid #f1f5f9; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05); }
        .premium-pagination [aria-current="page"] span { background-color: rgb(13 148 136) !important; border-color: rgb(13 148 136) !important; border-radius: 1.2rem; color: white !important; font-weight: 900; }
        .premium-pagination a, .premium-pagination span { border-radius: 1.2rem !important; margin: 0 0.125rem; border: none !important; font-weight: 800; color: #64748b !important; font-family: 'Outfit', sans-serif !important; }
        .premium-pagination a:hover { background-color: #f8fafc !important; color: #0d9488 !important; }
    </style>
</x-app-layout>
