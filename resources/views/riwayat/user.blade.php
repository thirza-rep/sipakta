<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <h2 class="text-2xl font-black text-white tracking-tight">Detail Aktivitas</h2>
            <p class="text-slate-100/60 text-[10px] font-bold uppercase tracking-[0.2em] mt-0.5">Audit Log Spesifik Pengguna</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 space-y-10 pb-32">
        {{-- User Profile Header --}}
        <div class="bg-indigo-950 rounded-[3.5rem] p-10 md:p-14 shadow-2xl relative overflow-hidden text-white group">
            <div class="absolute top-0 right-0 p-16 opacity-[0.03] pointer-events-none group-hover:scale-110 transition-transform duration-700">
                <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-12">
                <div class="flex items-center gap-10">
                    <div class="w-24 h-24 rounded-[2.5rem] bg-white text-indigo-950 flex items-center justify-center font-black text-4xl shadow-2xl transform rotate-3 group-hover:-rotate-3 transition-transform duration-700">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-4 mb-3">
                            <span class="px-5 py-2 bg-white/10 backdrop-blur-md rounded-xl text-[10px] font-black uppercase tracking-widest border border-white/10 uppercase">{{ $user->role_display }}</span>
                        </div>
                        <h1 class="text-4xl font-black tracking-tight leading-tight">{{ $user->name }}</h1>
                        <p class="text-indigo-400 font-bold text-sm mt-1">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="flex gap-6">
                    <div class="px-8 py-6 bg-white/5 border border-white/10 rounded-[2rem] text-center backdrop-blur-md">
                        <span class="block text-[10px] font-black text-indigo-500 uppercase tracking-[0.2em] mb-1">Total Riwayat</span>
                        <span class="text-3xl font-black">{{ $logs->total() }}</span>
                    </div>
                    <a href="{{ route('riwayat.index') }}" class="w-16 h-16 rounded-[2rem] bg-white/10 border border-white/10 flex items-center justify-center text-white hover:bg-white hover:text-indigo-950 transition-all active:scale-90 shadow-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Activity Timeline --}}
        <div class="bg-white rounded-[4rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="p-10 md:p-16">
                <div class="flex items-center gap-4 mb-12">
                    <span class="w-2 h-8 bg-indigo-600 rounded-full"></span>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Timeline Aktivitas</h2>
                </div>

                <div class="space-y-12 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                    @forelse($logs as $log)
                    <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group/item">
                        <!-- Icon -->
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-900 text-teal-400 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <!-- Content -->
                        <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-slate-50 border border-slate-100 p-8 rounded-[2.5rem] shadow-sm hover:shadow-xl hover:bg-white transition-all duration-500 group-hover/item:border-indigo-100 group-hover/item:scale-[1.02]">
                            <div class="flex items-center justify-between space-x-2 mb-4">
                                <div class="font-black text-slate-900 text-lg tracking-tight">{{ $log->action }}</div>
                                <time class="font-bold text-[10px] text-indigo-500 uppercase tracking-widest tabular-nums">{{ $log->created_at->format('H:i:s') }}</time>
                            </div>
                            <div class="text-slate-500 font-bold leading-relaxed text-sm mb-6">{{ $log->description }}</div>
                            <div class="flex items-center justify-between gap-4 pt-6 border-t border-slate-100/50">
                                <div class="px-4 py-1.5 bg-slate-200/50 text-slate-500 rounded-xl text-[9px] font-black uppercase tracking-widest">
                                    IP: {{ $log->ip_address }}
                                </div>
                                <div class="text-[10px] font-black text-slate-300 uppercase tracking-widest">
                                    {{ $log->created_at->translatedFormat('d F Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-20">
                        <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mx-auto mb-6 text-slate-200">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <p class="text-slate-400 font-bold text-[10px] uppercase tracking-widest">Belum ada riwayat tercatat</p>
                    </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if($logs->hasPages())
                    <div class="mt-20 pt-12 border-t border-slate-50">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
