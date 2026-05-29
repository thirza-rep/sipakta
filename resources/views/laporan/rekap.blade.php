<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <a href="{{ route('laporan.index') }}" class="w-12 h-12 rounded-2xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 transition-all active:scale-90 shadow-sm border border-slate-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Rekapitulasi Tahunan</h2>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-0.5">Statistik Akta Nikah Tahun {{ $tahun }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-10 pb-20">
        {{-- Banner: Overview --}}
        <div class="bg-slate-900 rounded-[3.5rem] p-10 md:p-14 text-white shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 p-16 opacity-[0.03] pointer-events-none">
                <svg class="w-80 h-80" fill="currentColor" viewBox="0 0 24 24"><path d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            </div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-12">
                <div class="flex items-center gap-8">
                    <div class="w-20 h-20 rounded-[2.5rem] bg-teal-500 flex items-center justify-center text-white shadow-2xl shadow-teal-500/40">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-black tracking-tight">Ringkasan Grafik</h1>
                        <p class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.4em] mt-1">Yearly Performance Analysis</p>
                    </div>
                </div>
                <div class="flex items-center gap-10">
                    <div class="text-center md:text-right">
                        <div class="text-6xl font-black text-teal-400 leading-none tabular-nums animate-pulse-slow">{{ number_format($totalTahun) }}</div>
                        <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest mt-3">TOTAL ARSIP MASUK</div>
                    </div>
                    <div class="hidden md:block w-px h-16 bg-white/10"></div>
                    <div class="hidden md:flex flex-col gap-2">
                        <div class="px-6 py-3 bg-white/5 border border-white/10 rounded-2xl flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-teal-500"></div>
                            <span class="text-[10px] font-black uppercase tracking-widest">Update Realtime</span>
                        </div>
                        <div class="px-6 py-3 bg-white/5 border border-white/10 rounded-2xl flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-orange-500"></div>
                            <span class="text-[10px] font-black uppercase tracking-widest">Tahun Aktif: {{ $tahun }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            {{-- Filter Sidebar --}}
            <div class="lg:col-span-4 lg:sticky lg:top-10">
                <div class="bg-white rounded-[3rem] p-8 md:p-10 border border-slate-100 shadow-xl shadow-slate-200/40">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center font-black">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">Filter Periode</h3>
                    </div>
                    
                    <form method="GET" action="{{ route('laporan.rekap') }}" class="space-y-6">
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Pilih Tahun</label>
                            <div class="relative group">
                                <select name="tahun" class="w-full pl-14 pr-8 py-5 bg-slate-50 border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-black text-slate-700 appearance-none shadow-inner">
                                    @foreach($availableYears as $year)
                                        <option value="{{ $year }}" {{ $tahun == $year ? 'selected' : '' }}>
                                            Tahun {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute left-5 top-5 text-slate-300 group-hover:text-teal-600 transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <div class="absolute right-5 top-6 text-slate-300 pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[1.5rem] font-black shadow-xl shadow-slate-900/20 hover:bg-slate-800 transition active:scale-95 uppercase tracking-widest text-[10px]">
                            PERBARUI DATA
                        </button>
                    </form>
                </div>

                {{-- Quick Tip Card --}}
                <div class="mt-10 bg-teal-600 rounded-[3rem] p-8 text-white relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform duration-700">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                    </div>
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-60 mb-3">Informasi Sistem</p>
                    <p class="text-sm font-bold leading-relaxed">Pilih salah satu bulan di tabel samping untuk melihat detail daftar pasangan serta data administrasi lengkap.</p>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="lg:col-span-8 space-y-10">
                {{-- Chart Card --}}
                <div class="bg-white rounded-[3.5rem] p-10 md:p-14 border border-slate-100 shadow-sm relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-12">
                        <div>
                            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Visualisasi Data</h3>
                            <p class="text-[10px] font-black text-teal-600 uppercase tracking-[0.2em] mt-1">Monthly Traffic Distribution</p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" /></svg>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        @php
                            $maxCount = max(array_column($monthlyStats, 'jumlah'));
                            $maxCount = $maxCount > 0 ? $maxCount : 1;
                        @endphp
                        @foreach($monthlyStats as $month => $data)
                        <div class="group/bar">
                            <div class="flex items-center justify-between mb-3 px-2">
                                <span class="text-xs font-black text-slate-500 uppercase tracking-[0.1em] group-hover/bar:text-teal-600 transition-colors">{{ $data['bulan'] }}</span>
                                <div class="flex items-center gap-2">
                                    <span class="text-lg font-black text-slate-900 tabular-nums">{{ $data['jumlah'] }}</span>
                                    <span class="text-[10px] font-black text-slate-300 uppercase">Arsip</span>
                                </div>
                            </div>
                            <div class="w-full h-10 bg-slate-50 rounded-2xl overflow-hidden shadow-inner flex items-center p-2 group-hover/bar:bg-slate-100 transition-colors">
                                <div class="h-full bg-teal-600 rounded-xl group-hover/bar:bg-teal-500 transition-all duration-1000 ease-[cubic-bezier(0.16,1,0.3,1)] shadow-xl shadow-teal-500/20"
                                     style="width: {{ ($data['jumlah'] / $maxCount) * 100 }}%">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Detail Table Card --}}
                <div class="bg-white rounded-[3.5rem] shadow-sm border border-slate-100 overflow-hidden transform transition-all duration-500 hover:shadow-2xl hover:shadow-slate-200/40">
                    <div class="p-10 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                        <div>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight">Rincian Per-Bulan</h3>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">Detailed Monthly Records</p>
                        </div>
                        <div class="px-6 py-2 bg-teal-600 text-white rounded-xl text-[10px] font-black tracking-widest">
                            JAN - DES
                        </div>
                    </div>
                    <div class="overflow-x-auto overflow-y-visible">
                        <table class="w-full text-left">
                            <tbody class="divide-y divide-slate-50">
                                @foreach($monthlyStats as $month => $data)
                                <tr class="hover:bg-slate-50/80 transition-all duration-300 group/row">
                                    <td class="px-10 py-8">
                                        <div class="text-lg font-black text-slate-800 uppercase tracking-wider group-hover/row:text-teal-600 transition-colors">{{ $data['bulan'] }}</div>
                                        <div class="text-[10px] font-black text-slate-300 uppercase tracking-widest mt-1">Bulan ke-{{ $loop->iteration }}</div>
                                    </td>
                                    <td class="px-10 py-8">
                                        <div class="inline-flex items-center px-6 py-3 bg-white border border-slate-100 rounded-2xl shadow-sm group-hover/row:border-teal-100 group-hover/row:bg-teal-50 transition-all">
                                            <span class="text-xl font-black text-slate-900 tabular-nums group-hover/row:text-teal-700">{{ $data['jumlah'] }}</span>
                                            <span class="ml-3 text-[10px] font-black text-slate-400 uppercase tracking-widest group-hover/row:text-teal-600">Arsip</span>
                                        </div>
                                    </td>
                                    <td class="px-10 py-8 text-right">
                                        @if($data['jumlah'] > 0)
                                        <a href="{{ route('laporan.bulanan', ['bulan' => $month, 'tahun' => $tahun]) }}" 
                                           class="inline-flex items-center px-8 py-4 bg-slate-900 text-white text-[10px] font-black rounded-2xl hover:bg-teal-600 transition-all active:scale-95 shadow-xl shadow-slate-900/10 hover:shadow-teal-500/20 group/btn">
                                            LIHAT DATA
                                            <svg class="w-5 h-5 ml-3 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                        </a>
                                        @else
                                        <div class="px-8 py-4 bg-slate-100 text-slate-400 text-[10px] font-black rounded-2xl uppercase tracking-[0.2em]">
                                            NIHIL
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-slate-900 overflow-hidden">
                                <tr>
                                    <td class="px-10 py-10">
                                        <div class="text-xs font-black text-teal-500 uppercase tracking-[0.3em] mb-1">TOTAL DATA KESELURUHAN</div>
                                        <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Akumulasi Selama 1 Tahun</div>
                                    </td>
                                    <td class="px-10 py-10">
                                        <div class="text-4xl font-black text-white tabular-nums tracking-tighter">
                                            {{ number_format($totalTahun) }}
                                        </div>
                                    </td>
                                    <td class="px-10 py-10 text-right opacity-20 group-hover:opacity-40 transition-opacity">
                                        <svg class="w-16 h-16 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        .animate-pulse-slow { animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    </style>
</x-app-layout>
