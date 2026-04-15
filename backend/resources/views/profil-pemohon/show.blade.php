<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <a href="{{ route('dashboard') }}" class="w-12 h-12 rounded-2xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 transition-all active:scale-90 shadow-sm border border-slate-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Detail Profil Pemohon</h2>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-0.5">Informasi Identitas Terdaftar</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8 space-y-12 pb-32">
        {{-- Profile Header Card --}}
        <div class="bg-teal-900 rounded-[3.5rem] p-10 md:p-14 shadow-2xl relative overflow-hidden text-white group">
            <div class="absolute top-0 right-0 p-16 opacity-[0.03] pointer-events-none group-hover:scale-110 transition-transform duration-700">
                <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </div>
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-10">
                <div class="w-24 h-24 rounded-[2.5rem] bg-white text-teal-900 flex items-center justify-center font-black text-4xl shadow-2xl transform rotate-3 transition-transform duration-700">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-4xl font-black tracking-tight leading-tight">{{ $profil->nama_lengkap ?? $user->name }}</h1>
                    <div class="flex items-center gap-4 mt-3">
                        <span class="px-5 py-2 bg-white/10 backdrop-blur-md rounded-xl text-[10px] font-black uppercase tracking-widest border border-white/10">DATA TERVERIFIKASI</span>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-teal-400 rounded-full animate-pulse"></div>
                            <span class="text-teal-300 font-bold text-[10px] uppercase tracking-widest">PROFIL PEMOHON</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[4rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="p-10 md:p-16 space-y-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    {{-- Identity Section --}}
                    <div class="space-y-10">
                        <div class="flex items-center gap-4 mb-2">
                            <span class="w-1.5 h-6 bg-teal-600 rounded-full"></span>
                            <h3 class="text-xl font-black text-slate-900">Data Personal</h3>
                        </div>

                        <div class="space-y-8">
                            <div>
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</h4>
                                <p class="text-base font-black text-slate-700 px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 shadow-inner">
                                    {{ $profil->nama_lengkap ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nomor Induk Kependudukan</h4>
                                <p class="text-base font-black text-slate-700 px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 shadow-inner tracking-widest">
                                    {{ $profil->nik ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Contact Section --}}
                    <div class="space-y-10">
                        <div class="flex items-center gap-4 mb-2">
                            <span class="w-1.5 h-6 bg-indigo-600 rounded-full"></span>
                            <h3 class="text-xl font-black text-slate-900">Kontak & Alamat</h3>
                        </div>

                        <div class="space-y-8">
                            <div>
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nomor Telepon/WA</h4>
                                <p class="text-base font-black text-slate-700 px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 shadow-inner">
                                    {{ $profil->no_telepon ?? '-' }}
                                </p>
                            </div>

                            <div>
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Alamat Lengkap</h4>
                                <p class="text-base font-black text-slate-700 px-6 py-4 bg-slate-50 rounded-2xl border border-slate-100 shadow-inner leading-relaxed">
                                    {{ $profil->alamat ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between gap-8 pt-12 border-t border-slate-50">
                    <div class="flex items-center gap-4 text-slate-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="text-[10px] font-bold uppercase tracking-widest leading-loose">Data ini digunakan untuk keperluan administrasi resmi<br>di Kantor KUA Kemantren Tegalrejo.</p>
                    </div>
                    
                    <a href="{{ route('profil-pemohon.edit') }}" 
                       class="px-10 py-5 bg-slate-900 text-white rounded-2xl font-black shadow-2xl shadow-slate-900/20 hover:bg-teal-600 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                        EDIT PROFIL SAYA
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
