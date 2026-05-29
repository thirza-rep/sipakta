<x-app-layout>
    <div class="min-h-screen bg-slate-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-12">
            {{-- Header/Title Section --}}
            <div class="text-center space-y-4">
                <div class="inline-flex items-center px-4 py-2 bg-teal-50 text-teal-600 rounded-full text-[10px] font-black uppercase tracking-[0.2em] border border-teal-100 mb-2">
                    Database Digital KUA
                </div>
                <h1 class="text-5xl font-black text-slate-900 tracking-tight leading-tight">Penelusuran Arsip<br>Akta Nikah</h1>
                <p class="text-slate-400 font-bold max-w-xl mx-auto leading-relaxed">Akses database digital untuk menemukan informasi akta nikah dengan cepat menggunakan nama atau nomor registrasi.</p>
            </div>

            {{-- Main Search Card --}}
            <div class="bg-white rounded-[4rem] shadow-2xl shadow-teal-900/10 p-10 md:p-16 border border-slate-100 relative overflow-hidden">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-teal-50 rounded-full opacity-50"></div>
                
                <form action="{{ route('pencarian.search') }}" method="GET" class="relative z-10 space-y-10">
                    <div class="space-y-4">
                        <label for="keyword" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-2">Parameter Pencarian</label>
                        <div class="relative group">
                            <input type="text" name="keyword" id="keyword" required
                                   class="w-full pl-8 pr-20 py-8 bg-slate-50 border-slate-100 rounded-[2.5rem] focus:ring-8 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-black text-2xl text-slate-800 placeholder:text-slate-300 placeholder:font-bold shadow-inner"
                                   placeholder="Nama Suami / Istri / No. Akta"
                                   autofocus>
                            <div class="absolute right-6 top-6">
                                <button type="submit" class="w-14 h-14 bg-teal-600 text-white rounded-2xl flex items-center justify-center shadow-xl shadow-teal-500/30 hover:bg-teal-500 transition-all active:scale-90 group/btn">
                                    <svg class="w-7 h-7 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-6 bg-slate-50/50 rounded-3xl border border-slate-100 flex items-start gap-4">
                            <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-600 flex items-center justify-center font-black text-xs shrink-0">1</div>
                            <p class="text-xs font-bold text-slate-500 leading-relaxed">Gunakan nama lengkap untuk hasil yang lebih spesifik dan akurat.</p>
                        </div>
                        <div class="p-6 bg-slate-50/50 rounded-3xl border border-slate-100 flex items-start gap-4">
                            <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center font-black text-xs shrink-0">2</div>
                            <p class="text-xs font-bold text-slate-500 leading-relaxed">Nomor akta biasanya berformat angka dengan kode KUA setempat.</p>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Footer Info --}}
            <div class="flex flex-col md:flex-row items-center justify-between gap-8 pt-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-relaxed">
                        Sistem ini mematuhi protokol keamanan data<br>dan kerahasiaan informasi publik.
                    </div>
                </div>

                @if(auth()->user()->profilPemohon)
                    <a href="{{ route('profil-pemohon.edit') }}" class="px-8 py-4 bg-white border border-slate-100 rounded-2xl text-[10px] font-black text-slate-600 uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm">
                        PERBARUI PROFIL SAYA
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
