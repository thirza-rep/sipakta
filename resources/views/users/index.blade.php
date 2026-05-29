<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Manajemen Pengguna</h2>
        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-0.5">Kelola Hak Akses & Akun Sistem</p>
    </x-slot>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 space-y-10 pb-32">
        {{-- Hero Actions --}}
        <div class="bg-indigo-900 rounded-[3.5rem] p-10 md:p-14 shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-10">
            <div class="absolute top-0 right-0 p-16 opacity-[0.03] pointer-events-none">
                <svg class="w-80 h-80" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" /></svg>
            </div>

            <div class="relative z-10 flex items-center gap-8">
                <div class="w-20 h-20 rounded-[2.5rem] bg-indigo-500 flex items-center justify-center text-white shadow-2xl shadow-indigo-500/40 transform -rotate-3">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
                <div>
                    <h1 class="text-4xl font-black text-white tracking-tight">Daftar Pengguna</h1>
                    <p class="text-indigo-200 font-bold text-[10px] uppercase tracking-[0.4em] mt-1">{{ $users->total() }} Akun Terdaftar</p>
                </div>
            </div>

            <div class="relative z-10">
                <a href="{{ route('users.create') }}" 
                   class="inline-flex items-center px-10 py-5 bg-white text-indigo-900 rounded-[1.5rem] font-black shadow-xl shadow-black/10 hover:bg-slate-50 transition-all active:scale-95 group">
                    <svg class="w-6 h-6 mr-3 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    TAMBAH PENGGUNA BARU
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-teal-50 border-l-4 border-teal-500 p-6 rounded-2xl shadow-sm animate-fade-in flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                </div>
                <p class="text-teal-900 font-bold">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Filters --}}
        <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-xl shadow-slate-200/40">
            <form method="GET" action="{{ route('users.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Pencarian Cepat</label>
                    <div class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Nama atau Email..." 
                               class="w-full pl-12 pr-6 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold text-slate-700">
                        <svg class="w-5 h-5 absolute left-4 top-4 text-slate-300 group-focus-within:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Role Akses</label>
                    <select name="role" class="w-full px-6 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-black text-slate-700 appearance-none">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                        <option value="admin_data" {{ request('role') == 'admin_data' ? 'selected' : '' }}>Administrator Data</option>
                        <option value="kepala_kua" {{ request('role') == 'kepala_kua' ? 'selected' : '' }}>Kepala KUA</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Status Keaktifan</label>
                    <select name="status" class="w-full px-6 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-black text-slate-700 appearance-none">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div class="flex items-end gap-3">
                    <button type="submit" class="flex-1 py-4 bg-indigo-600 text-white rounded-2xl font-black shadow-xl shadow-indigo-600/20 hover:bg-indigo-700 transition active:scale-95 uppercase tracking-widest text-[10px]">
                        FILTER DATA
                    </button>
                    <a href="{{ route('users.index') }}" class="p-4 bg-slate-100 text-slate-400 rounded-2xl hover:bg-slate-200 transition active:scale-90 shadow-inner">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    </a>
                </div>
            </form>
        </div>

        {{-- Table Content --}}
        <div class="bg-white rounded-[3.5rem] shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto overflow-y-visible">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50 border-b border-slate-100">
                        <tr>
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Data Pengguna</th>
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Otoritas</th>
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Akses Terakhir</th>
                            <th class="px-10 py-8 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Manajemen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($users as $user)
                        <tr class="hover:bg-slate-50/80 transition-all duration-300 group/row">
                            <td class="px-10 py-10">
                                <div class="flex items-center gap-6">
                                    <div class="w-16 h-16 rounded-[1.5rem] bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-black text-xl shadow-inner group-hover/row:scale-110 transition-transform">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-3">
                                            <span class="text-base font-black text-slate-900 tracking-tight">{{ $user->name }}</span>
                                            @if($user->id === auth()->id())
                                                <span class="px-2 py-0.5 bg-indigo-100 text-indigo-600 rounded text-[8px] font-black uppercase tracking-widest">SAYA</span>
                                            @endif
                                        </div>
                                        <span class="text-sm font-bold text-slate-400 mt-1">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-10">
                                @php
                                    $roleStyles = [
                                        'admin' => 'bg-purple-50 text-purple-600 border-purple-100',
                                        'admin_data' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'kepala_kua' => 'bg-teal-50 text-teal-600 border-teal-100',
                                    ];
                                    $style = $roleStyles[$user->role] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                                @endphp
                                <span class="px-5 py-2.5 rounded-2xl border {{ $style }} text-[10px] font-black uppercase tracking-widest shadow-sm">
                                    {{ $user->role_display }}
                                </span>
                            </td>
                            <td class="px-10 py-10">
                                @if($user->is_active)
                                    <div class="flex items-center text-teal-600 font-black text-[10px] uppercase tracking-[0.2em]">
                                        <span class="w-2.5 h-2.5 bg-teal-500 rounded-full mr-3 animate-pulse shadow-[0_0_10px_rgba(20,184,166,0.5)]"></span>
                                        Aktif Beroperasi
                                    </div>
                                @else
                                    <div class="flex items-center text-slate-400 font-black text-[10px] uppercase tracking-[0.2em]">
                                        <span class="w-2.5 h-2.5 bg-slate-300 rounded-full mr-3"></span>
                                        Akun Ditangguhkan
                                    </div>
                                @endif
                            </td>
                            <td class="px-10 py-10">
                                <div class="flex items-center justify-end gap-4">
                                    <a href="{{ route('users.edit', $user) }}" 
                                       class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-slate-400 border border-slate-100 hover:bg-slate-900 hover:text-white transition-all shadow-sm hover:shadow-xl hover:-translate-y-1" title="Edit Profil">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('users.toggle-active', $user) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="w-12 h-12 rounded-2xl flex items-center justify-center transition-all shadow-sm hover:shadow-xl hover:-translate-y-1 {{ $user->is_active ? 'bg-orange-50 text-orange-500 border-orange-100 hover:bg-orange-600' : 'bg-teal-50 text-teal-600 border-teal-100 hover:bg-teal-600' }} hover:text-white" 
                                                    title="{{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}">
                                                @if($user->is_active)
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                                @else
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7" /></svg>
                                                @endif
                                            </button>
                                        </form>
                                        
                                        <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline" 
                                              onsubmit="return confirm('Hapus pengguna ini secara permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-12 h-12 rounded-2xl bg-red-50 text-red-500 border-red-100 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all shadow-sm hover:shadow-xl hover:-translate-y-1" title="Hapus Permanen">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-10 py-32 text-center bg-slate-50/20">
                                <div class="flex flex-col items-center">
                                    <div class="w-24 h-24 bg-slate-200/50 rounded-[2.5rem] flex items-center justify-center mb-8">
                                        <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    </div>
                                    <h4 class="text-2xl font-black text-slate-800 tracking-tight">Pengguna Tidak Ditemukan</h4>
                                    <p class="text-slate-400 mt-2 font-bold">Kriteria filter tidak mencocokkan akun manapun.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="px-10 py-10 bg-slate-50/50 border-t border-slate-100">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
