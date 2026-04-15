<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <a href="{{ route('laporan.rekap') }}" class="w-12 h-12 rounded-2xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 transition-all active:scale-90 shadow-sm border border-slate-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Laporan Bulanan</h2>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-0.5">{{ $namaBulan }} {{ $tahun }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 space-y-12 pb-32">
        {{-- Hero Header --}}
        <div class="bg-slate-900 rounded-[3.5rem] p-10 md:p-14 shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-10">
            <div class="absolute top-0 right-0 p-16 opacity-[0.03] pointer-events-none">
                <svg class="w-80 h-80" fill="currentColor" viewBox="0 0 24 24"><path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>

            <div class="relative z-10 flex items-center gap-8">
                <div class="w-20 h-20 rounded-[2.5rem] bg-teal-500 flex items-center justify-center text-white shadow-2xl shadow-teal-500/40 transform rotate-3">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <div>
                    <h1 class="text-4xl font-black text-white tracking-tight">Detail Periode</h1>
                    <p class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.4em] mt-1">{{ count($arsip) }} Rekaman Ditemukan</p>
                </div>
            </div>

            <div class="relative z-10 flex flex-wrap justify-center gap-4">
                @if($arsip->count() > 0)
                <a href="{{ route('laporan.export-pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}" 
                   class="inline-flex items-center px-10 py-5 bg-teal-600 text-white rounded-[1.5rem] font-black shadow-xl shadow-teal-600/20 hover:bg-teal-500 transition-all active:scale-95 group">
                    <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    UNDUH LAPORAN PDF
                </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            {{-- Filter Panel --}}
            <div class="lg:col-span-4 lg:sticky lg:top-10 h-fit">
                <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-xl shadow-slate-200/40">
                    <h3 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-3">
                        <span class="w-2 h-8 bg-teal-500 rounded-full"></span>
                        Navigasi Periode
                    </h3>
                    
                    <form method="GET" action="{{ route('laporan.bulanan') }}" class="space-y-8">
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Bulan Pernikahan</label>
                                <div class="relative group">
                                    <select name="bulan" class="w-full px-6 py-4 pr-12 bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-black text-slate-700 appearance-none shadow-inner">
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                    <div class="absolute right-6 top-5 text-slate-300 pointer-events-none group-focus-within:text-teal-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tahun Arsip</label>
                                <div class="relative group">
                                    <select name="tahun" class="w-full px-6 py-4 pr-12 bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-black text-slate-700 appearance-none shadow-inner">
                                        @foreach($availableYears as $year)
                                            <option value="{{ $year }}" {{ $tahun == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-6 top-5 text-slate-300 pointer-events-none group-focus-within:text-teal-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-black shadow-xl shadow-slate-900/10 hover:bg-slate-800 transition active:scale-95 uppercase tracking-widest text-[10px]">
                            LIHAT LAPORAN
                        </button>
                    </form>
                </div>

                {{-- Statistics Card --}}
                <div class="mt-10 bg-white rounded-[3rem] p-10 border border-slate-100 shadow-xl shadow-slate-200/40 overflow-hidden relative">
                    <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-slate-50 rounded-full"></div>
                    <div class="relative z-10 space-y-8">
                        @php
                            $total = $summary['total'] > 0 ? $summary['total'] : 1;
                            $digitalWidth = ($summary['dengan_dokumen'] / $total) * 100;
                            $fisikWidth = ($summary['tanpa_dokumen'] / $total) * 100;
                        @endphp
                        
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kapasitas Digital</span>
                                <span class="text-xs font-black text-teal-600">{{ round($digitalWidth) }}%</span>
                            </div>
                            <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-teal-500 rounded-full" style="--width: {{ $digitalWidth }}%; width: var(--width);"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Arsip Fisik Saja</span>
                                <span class="text-xs font-black text-orange-500">{{ round($fisikWidth) }}%</span>
                            </div>
                            <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-orange-500 rounded-full" style="--width: {{ $fisikWidth }}%; width: var(--width);"></div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            {{-- Table Content --}}
            <div class="lg:col-span-8">
                <div class="bg-white rounded-[3.5rem] shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
                    <div class="overflow-x-auto overflow-y-visible">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50/50">
                                <tr>
                                    <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Identitas Pasangan</th>
                                    <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Administrasi</th>
                                    <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($arsip as $item)
                                <tr class="hover:bg-slate-50/80 transition-all duration-300 group/row">
                                    <td class="px-10 py-10">
                                        <div class="flex flex-col gap-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center font-black text-xs border border-teal-100">S</div>
                                                <span class="text-base font-black text-slate-900 tracking-tight">{{ $item->nama_suami }}</span>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center font-black text-xs border border-pink-100">I</div>
                                                <span class="text-base font-black text-slate-900 tracking-tight">{{ $item->nama_istri }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-10 py-10">
                                        <div class="space-y-3">
                                            <div class="inline-flex items-center px-4 py-2 bg-slate-100 rounded-xl border border-slate-200">
                                                <span class="text-xs font-black text-slate-700 tracking-wider tabular-nums">{{ $item->nomor_akta }}</span>
                                            </div>
                                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest pl-1">
                                                Akad: {{ \Carbon\Carbon::parse($item->tanggal_akad)->translatedFormat('d M Y') }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-10 py-10 text-center">
                                        @if($item->hasDocument())
                                            <div class="inline-flex flex-col items-center">
                                                <div class="w-14 h-14 rounded-2xl bg-teal-50 flex items-center justify-center text-teal-600 border border-teal-100 shadow-sm relative group-hover/row:scale-110 transition-transform">
                                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                                    <div class="absolute -top-1 -right-1 w-4 h-4 bg-teal-500 rounded-full border-2 border-white"></div>
                                                </div>
                                                <span class="mt-3 text-[10px] font-black text-teal-600 uppercase tracking-widest">DIGITAL</span>
                                            </div>
                                        @else
                                            <div class="inline-flex flex-col items-center opacity-40">
                                                <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 border border-slate-200">
                                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                                </div>
                                                <span class="mt-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">FISIK</span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-10 py-32 text-center bg-slate-50/20">
                                        <div class="flex flex-col items-center">
                                            <div class="w-24 h-24 bg-slate-200/50 rounded-[2.5rem] flex items-center justify-center mb-8">
                                                <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                            </div>
                                            <h4 class="text-2xl font-black text-slate-800 tracking-tight">Data Tidak Ditemukan</h4>
                                            <p class="text-slate-400 mt-2 max-w-sm font-bold text-center leading-relaxed">Belum ada arsip yang masuk untuk periode {{ $namaBulan }} {{ $tahun }}.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
