<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Profil Pemohon</h2>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-0.5">Kelola Informasi Identitas Anda</p>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8 space-y-12 pb-32">
        {{-- Profile Header Card --}}
        <div class="bg-teal-900 rounded-[3.5rem] p-10 md:p-14 shadow-2xl relative overflow-hidden text-white group">
            <div class="absolute top-0 right-0 p-16 opacity-[0.03] pointer-events-none group-hover:scale-110 transition-transform duration-700">
                <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </div>
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-10">
                <div class="w-24 h-24 rounded-[2.5rem] bg-white text-teal-900 flex items-center justify-center font-black text-4xl shadow-2xl transform rotate-3 group-hover:-rotate-3 transition-transform duration-700">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-4xl font-black tracking-tight leading-tight">{{ $user->name }}</h1>
                    <div class="flex items-center gap-4 mt-3">
                        <span class="px-5 py-2 bg-white/10 backdrop-blur-md rounded-xl text-[10px] font-black uppercase tracking-widest border border-white/10">AKUN PEMOHON</span>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-teal-400 rounded-full animate-pulse"></div>
                            <span class="text-teal-300 font-bold text-[10px] uppercase tracking-widest">AKSES AKTIF</span>
                        </div>
                    </div>
                </div>
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

        @if(session('warning'))
            <div class="bg-orange-50 border-l-4 border-orange-500 p-6 rounded-2xl shadow-sm animate-bounce-slow flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <p class="text-orange-900 font-bold">{{ session('warning') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-[4rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <form method="POST" action="{{ route('profil-pemohon.update') }}" class="p-10 md:p-16 space-y-12">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    {{-- Identity Section --}}
                    <div class="space-y-10">
                        <div class="flex items-center gap-4 mb-2">
                            <span class="w-1.5 h-6 bg-teal-600 rounded-full"></span>
                            <h3 class="text-xl font-black text-slate-900">Data Personal</h3>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label for="nama_lengkap" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Nama Lengkap Sesuai KTP</label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" 
                                       value="{{ old('nama_lengkap', $profil->nama_lengkap ?? $user->name) }}" required
                                       class="w-full pl-6 pr-6 py-5 bg-slate-50 border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-black text-slate-700 shadow-inner">
                                @error('nama_lengkap')
                                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nik" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Nomor Induk Kependudukan (NIK)</label>
                                <input type="text" name="nik" id="nik" 
                                       value="{{ old('nik', $profil->nik ?? '') }}" required
                                       class="w-full pl-6 pr-6 py-5 bg-slate-50 border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-black text-slate-700 shadow-inner"
                                       placeholder="16 digit angka KTP">
                                @error('nik')
                                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Contact Section --}}
                    <div class="space-y-10">
                        <div class="flex items-center gap-4 mb-2">
                            <span class="w-1.5 h-6 bg-indigo-600 rounded-full"></span>
                            <h3 class="text-xl font-black text-slate-900">Kontak & Alamat</h3>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label for="no_telepon" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Nomor Telepon/WA</label>
                                <div class="relative group">
                                    <input type="text" name="no_telepon" id="no_telepon" 
                                           value="{{ old('no_telepon', $profil->no_telepon ?? '') }}" required
                                           class="w-full pl-14 pr-6 py-5 bg-slate-50 border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-black text-slate-700 shadow-inner"
                                           placeholder="08xxxxxxxxxx">
                                    <div class="absolute left-6 top-6 text-slate-300 group-focus-within:text-indigo-600 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5.25a.75.75 0 00-1.5 0v13.5a.75.75 0 001.5 0V5.25zM21 5.25a.75.75 0 00-1.5 0v13.5a.75.75 0 001.5 0V5.25zM15.75 9h-7.5a.75.75 0 000 1.5h7.5a.75.75 0 000-1.5zM15.75 13.5h-7.5a.75.75 0 000 1.5h7.5a.75.75 0 000-1.5z" /></svg>
                                    </div>
                                </div>
                                @error('no_telepon')
                                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="alamat" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Alamat Domisili Lengkap</label>
                                <textarea name="alamat" id="alamat" rows="3" required
                                          class="w-full pl-6 pr-6 py-5 bg-slate-50 border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-black text-slate-700 shadow-inner resize-none">{{ old('alamat', $profil->alamat ?? '') }}</textarea>
                                @error('alamat')
                                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between gap-8 pt-12 border-t border-slate-50">
                    <div class="flex items-center gap-4 text-slate-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="text-[10px] font-bold uppercase tracking-widest leading-loose">Pastikan semua data sesuai dengan KTP asli untuk<br>memudahkan verifikasi di Kantor KUA.</p>
                    </div>
                    
                    <div class="flex items-center gap-6 w-full md:w-auto">
                        <button type="submit" 
                                class="flex-1 md:flex-none px-12 py-5 bg-slate-900 text-white rounded-2xl font-black shadow-2xl shadow-slate-900/20 hover:bg-teal-600 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                            PERBARUI DATA PROFIL
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
