<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Riwayat Aktivitas</h2>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-0.5">Audit Log & Jejak Audit Sistem</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 space-y-10 pb-32">
        {{-- Hero Audit Banner --}}
        <div class="bg-slate-900 rounded-[3.5rem] p-10 md:p-14 shadow-2xl relative overflow-hidden text-white">
            <div class="absolute top-0 right-0 p-16 opacity-[0.03] pointer-events-none">
                <svg class="w-80 h-80" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-12">
                <div class="flex items-center gap-8 text-left">
                    <div class="w-20 h-20 rounded-[2.5rem] bg-indigo-600 flex items-center justify-center text-white shadow-2xl shadow-indigo-500/40">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-black tracking-tight leading-tight">Log Transaksi</h1>
                        <p class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.4em] mt-2">Historical Audit Trail</p>
                    </div>
                </div>
                <div class="hidden md:block w-px h-16 bg-white/10"></div>
                <div class="space-y-4">
                    <div class="px-6 py-4 bg-white/5 border border-white/10 rounded-2xl flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-teal-500/20 text-teal-400 flex items-center justify-center font-black">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest leading-none mb-1">Integritas Data</span>
                            <span class="text-xs font-black text-teal-400">AKTIF & TERPANTAU</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Log Table --}}
        <div class="bg-white rounded-[4rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto overflow-y-visible">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Waktu Kejadian</th>
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Pelaku</th>
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kata Kunci Pencarian</th>
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Audit Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($riwayat as $log)
                        <tr class="hover:bg-slate-50/80 transition-all duration-300 group/row">
                            <td class="px-10 py-10">
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-900 tracking-tight">{{ $log->waktu->translatedFormat('d M Y') }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $log->waktu->format('H:i:s') }} WIB</span>
                                </div>
                            </td>
                            <td class="px-10 py-10">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-black text-[10px] group-hover/row:scale-110 transition-transform shadow-sm">
                                        {{ strtoupper(substr($log->user->name ?? 'SYS', 0, 1)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-black text-slate-800">{{ $log->user->name ?? 'System Process' }}</span>
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ $log->user->role_display ?? 'INTERNAL' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-10">
                                <div class="flex items-center gap-4">
                                    <span class="px-4 py-2 bg-slate-100 text-teal-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-slate-200">
                                        SEARCH
                                    </span>
                                    <div class="flex flex-col">
                                        <p class="text-sm font-bold text-slate-600 leading-relaxed">Mencari: <span class="italic">"{{ $log->kata_kunci }}"</span></p>
                                        @if($log->hasil_count)
                                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Ditemukan {{ $log->hasil_count }} data</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-10 text-right">
                                <div class="inline-flex items-center px-4 py-2 bg-teal-50 border border-teal-100 rounded-xl text-[9px] font-black text-teal-600 uppercase tracking-widest">
                                    VERIFIED
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-10 py-32 text-center bg-slate-50/20">
                                <div class="flex flex-col items-center">
                                    <div class="w-24 h-24 bg-slate-100 rounded-[2.5rem] flex items-center justify-center mb-8 text-slate-200">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <h4 class="text-2xl font-black text-slate-800 tracking-tight">Belum Ada Riwayat</h4>
                                    <p class="text-slate-400 mt-2 font-bold max-w-sm mx-auto">Database log saat ini masih kosong atau belum ada aktivitas yang tercatat dalam periode ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($riwayat->hasPages())
                <div class="px-10 py-10 bg-slate-50/50 border-t border-slate-100">
                    {{ $riwayat->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
