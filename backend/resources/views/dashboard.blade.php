<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mt-1">Sistem Informasi Kearsipan Digital</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="px-5 py-2.5 bg-white border border-slate-100 rounded-2xl shadow-sm flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
                    <span class="text-xs font-black text-slate-600 uppercase tracking-widest">{{ now()->translatedFormat('d F Y') }}</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8 pb-12">
        {{-- Bento Grid Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            {{-- Big Card: Total Data --}}
            <div class="md:col-span-2 group relative overflow-hidden bg-slate-900 rounded-[2.5rem] p-8 shadow-2xl transition-all duration-500 hover:-translate-y-1">
                <div class="absolute top-0 right-0 w-80 h-80 bg-teal-500/10 blur-[100px] rounded-full translate-x-1/2 -translate-y-1/2 transition-all duration-700 group-hover:bg-teal-500/20"></div>
                <div class="relative z-10 flex flex-col justify-between h-full">
                    <div>
                        <div class="w-14 h-14 bg-teal-600/20 rounded-2xl flex items-center justify-center text-teal-400 mb-8 group-hover:scale-110 transition-transform duration-500">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </div>
                        <h3 class="text-slate-400 text-xs font-black uppercase tracking-[0.2em]">Total Akta Terarsip</h3>
                    </div>
                    <div class="mt-12 flex items-baseline gap-4">
                        <span class="text-7xl font-black text-white tracking-tighter tabular-nums">{{ number_format(\App\Models\AktaNikah::count()) }}</span>
                        <span class="text-teal-500 font-black text-[10px] uppercase tracking-[0.3em]">Dokumen Aktif</span>
                    </div>
                </div>
            </div>

            {{-- Medium Card: Tahun Ini --}}
            <div class="group relative overflow-hidden bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-sm transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 mb-8 transition-all duration-500 group-hover:bg-indigo-600 group-hover:text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <h3 class="text-slate-400 text-[10px] font-black uppercase tracking-widest leading-tight">Pendaftaran<br>Tahun {{ date('Y') }}</h3>
                <div class="mt-8">
                    <span class="text-5xl font-black text-slate-800 tracking-tighter tabular-nums">{{ number_format(\App\Models\AktaNikah::whereYear('tanggal_akad', date('Y'))->count()) }}</span>
                </div>
            </div>

            {{-- Medium Card: Digital --}}
            <div class="group relative overflow-hidden bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-sm transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 mb-8 transition-all duration-500 group-hover:bg-amber-500 group-hover:text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
                <h3 class="text-slate-400 text-[10px] font-black uppercase tracking-widest leading-tight">Digitalisasi<br>Dokumen</h3>
                <div class="mt-8">
                    <span class="text-5xl font-black text-slate-800 tracking-tighter tabular-nums">{{ number_format(\App\Models\AktaNikah::whereNotNull('file_path')->count()) }}</span>
                </div>
            </div>
        </div>

        {{-- Integrated Search Section --}}
        <div class="glass-card rounded-[2.5rem] p-3 flex flex-col lg:flex-row items-stretch gap-3 shadow-xl shadow-slate-200/50">
            <div class="flex-1 relative group">
                <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none text-slate-300 group-focus-within:text-teal-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <form action="{{ route('dashboard') }}" method="GET" id="searchForm" class="w-full h-full">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari berdasarkan Nama Suami, Istri, atau Nomor Akta..."
                           class="w-full h-full pl-16 pr-8 py-5 bg-transparent border-none focus:ring-0 text-slate-700 font-bold placeholder:text-slate-300">
                </form>
            </div>
            <div class="flex items-center gap-2 p-1.5 bg-white rounded-[1.8rem] shadow-sm">
                @if(request('search'))
                    <a href="{{ route('dashboard') }}" class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-red-500 transition">Reset</a>
                @endif
                <button type="submit" form="searchForm" class="px-10 py-4 bg-teal-600 text-white rounded-[1.4rem] text-[10px] font-black uppercase tracking-widest shadow-lg shadow-teal-600/20 hover:bg-teal-700 hover:shadow-teal-600/40 active:scale-95 transition-all">
                    Cari Sekarang
                </button>
            </div>
        </div>

        {{-- Main Data Section --}}
        <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-10 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Data Pencarian Akta</h3>
                    <div class="flex items-center gap-3 mt-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Ditemukan {{ $arsip->total() }} Menampilkan {{ $arsip->count() }} Entri</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-[9px] font-black text-slate-300 uppercase tracking-widest mr-2">Baris per Halaman:</div>
                    <form action="{{ route('dashboard') }}" method="GET" class="flex p-1 bg-slate-50 rounded-xl">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        @foreach([10, 25, 50] as $size)
                            <button type="submit" name="per_page" value="{{ $size }}" 
                                    class="px-4 py-1.5 rounded-lg text-[10px] font-black transition-all {{ request('per_page', 10) == $size ? 'bg-white text-teal-600 shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                                {{ $size }}
                            </button>
                        @endforeach
                    </form>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Identitas Akta</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Data Pasangan</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Waktu Akad</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Digitalisasi</th>
                            <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($arsip as $item)
                            <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                                <td class="px-10 py-8">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-slate-900 group-hover:text-teal-600 transition-colors uppercase tabular-nums tracking-tight">{{ $item->no_akta }}</span>
                                        <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest mt-1">{{ $item->lokasi_fisik ?? 'Lokasi Belum Diatur' }}</span>
                                    </div>
                                </td>
                                <td class="px-10 py-8">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-slate-700">{{ $item->nama_suami }}</span>
                                        <div class="flex items-center gap-2 mt-1">
                                            <div class="h-px w-3 bg-slate-200"></div>
                                            <span class="text-xs font-bold text-slate-400 italic">{{ $item->nama_istri }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-10 py-8">
                                    <div class="inline-flex items-center px-4 py-1.5 bg-slate-100 rounded-full border border-slate-200">
                                        <span class="text-[10px] font-black text-slate-500 uppercase tabular-nums">TAHUN {{ \Carbon\Carbon::parse($item->tanggal_akad)->year }}</span>
                                    </div>
                                </td>
                                <td class="px-10 py-8">
                                    @if($item->file_path)
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-teal-50 flex items-center justify-center text-teal-600">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" /></svg>
                                            </div>
                                            <span class="text-[10px] font-black text-teal-600 uppercase tracking-widest">Tersertifikasi</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                            </div>
                                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Fisik Saja</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-10 py-8 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('akta-nikah.show', $item->id) }}" class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-slate-900 hover:text-white hover:border-slate-900 hover:shadow-xl transition-all duration-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </a>
                                        @if(auth()->user()->isPengelolaData())
                                            <a href="{{ route('akta-nikah.edit', $item->id) }}" class="w-12 h-12 rounded-2xl bg-white border border-slate-100 flex items-center justify-center text-amber-500 hover:bg-amber-500 hover:text-white hover:border-amber-500 transition-all duration-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-10 py-32 text-center bg-slate-50/10">
                                    <div class="flex flex-col items-center">
                                        <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center text-4xl mb-6 grayscale opacity-40">📂</div>
                                        <h4 class="text-xl font-black text-slate-900 tracking-tight">Tidak Ada Data Ditemukan</h4>
                                        <p class="text-slate-400 text-xs font-bold mt-2 max-w-xs mx-auto uppercase tracking-widest leading-loose">Silakan periksa kembali kata kunci pencarian Anda atau tambahkan data arsip baru.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($arsip->hasPages())
                <div class="px-10 py-10 bg-slate-50/50 border-t border-slate-100">
                    {{ $arsip->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
