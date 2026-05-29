<x-app-layout>
    <div class="min-h-screen bg-slate-50 pb-32">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            {{-- Navigation Back --}}
            <div class="mb-10">
                <a href="{{ route('pencarian.search', ['keyword' => request('keyword')]) }}" 
                   class="inline-flex items-center px-6 py-3 bg-white border border-slate-100 rounded-2xl text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-teal-600 transition-all shadow-sm group">
                    <svg class="w-4 h-4 mr-3 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    KEMBALI KE HASIL PENCARIAN
                </a>
            </div>

            <div class="bg-white rounded-[4rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden transform transition-all duration-700 hover:shadow-teal-900/10">
                {{-- Hero Header --}}
                <div class="bg-slate-900 px-10 md:px-16 py-12 text-white relative overflow-hidden">
                    <div class="absolute right-0 top-0 p-16 opacity-[0.03] pointer-events-none">
                        <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" /></svg>
                    </div>
                    
                    <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-8">
                        <div>
                            <div class="flex items-center gap-4 mb-4">
                                <span class="px-5 py-1.5 bg-teal-500 text-white rounded-full text-[10px] font-black uppercase tracking-widest border border-teal-400/30">
                                    AKTA NO: {{ $arsip->nomor_akta }}
                                </span>
                            </div>
                            <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight leading-tight">Detail Arsip Digital</h1>
                            <p class="text-slate-500 font-bold text-[10px] uppercase tracking-[0.4em] mt-2">Daftar Informasi Terotentikasi</p>
                        </div>
                        
                        @if($arsip->file_path)
                            <div class="flex items-center gap-4 px-6 py-4 bg-white/5 border border-white/10 rounded-2xl backdrop-blur-md">
                                <div class="w-3 h-3 bg-teal-500 rounded-full animate-pulse shadow-[0_0_15px_rgba(20,184,166,0.6)]"></div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-teal-400">Arsip Digital Terverifikasi</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Information Grid --}}
                <div class="p-10 md:p-16 space-y-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        {{-- Husband --}}
                        <div class="space-y-3 p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100 group/item transition-all hover:bg-white hover:border-teal-100 hover:shadow-lg hover:shadow-teal-900/5">
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest group-hover/item:text-teal-600 transition-colors">Identitas Suami</span>
                            <p class="text-2xl font-black text-slate-900 tracking-tight">{{ $arsip->nama_suami }}</p>
                        </div>

                        {{-- Wife --}}
                        <div class="space-y-3 p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100 group/item transition-all hover:bg-white hover:border-pink-100 hover:shadow-lg hover:shadow-pink-900/5">
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest group-hover/item:text-pink-600 transition-colors">Identitas Istri</span>
                            <p class="text-2xl font-black text-slate-900 tracking-tight">{{ $arsip->nama_istri }}</p>
                        </div>

                        {{-- Date --}}
                        <div class="space-y-3 p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100 group/item transition-all hover:bg-white hover:border-indigo-100 hover:shadow-lg hover:shadow-indigo-900/5">
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest group-hover/item:text-indigo-600 transition-colors">Tanggal Akad</span>
                            <p class="text-2xl font-black text-slate-900 tracking-tight">{{ $arsip->tanggal_akad ? $arsip->tanggal_akad->translatedFormat('d F Y') : '-' }}</p>
                        </div>

                        {{-- Location --}}
                        <div class="space-y-3 p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100 group/item transition-all hover:bg-white hover:border-orange-100 hover:shadow-lg hover:shadow-orange-900/5">
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest group-hover/item:text-orange-600 transition-colors">Penyimpanan Fisik</span>
                            <p class="text-2xl font-black text-slate-900 tracking-tight">{{ $arsip->lokasi_fisik ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- Admin Info Box --}}
                    <div class="bg-indigo-950 rounded-[3rem] p-10 md:p-14 text-white relative overflow-hidden group/info">
                        <div class="absolute -right-10 -bottom-10 opacity-[0.05] group-hover/info:scale-110 transition-transform duration-1000">
                            <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                        </div>
                        <div class="relative z-10 space-y-8">
                            <div class="flex items-center gap-6">
                                <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-teal-400 border border-white/10 shadow-xl">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <h3 class="text-2xl font-black tracking-tight leading-tight">Prosedur Pengambilan<br>Salinan Resmi</h3>
                            </div>
                            <p class="text-indigo-200/70 font-bold leading-extrarelaxed text-base max-w-2xl">
                                Pemohon yang ingin mendapatkan kutipan atau legalisir dokumen resmi diwajibkan datang langsung ke Kantor KUA Kemantren Tegalrejo dengan membawa kartu identitas asli (KTP) dan mencantumkan nomor registrasi akta tersebut di atas.
                            </p>
                            <div class="pt-6">
                                <span class="px-8 py-3 bg-teal-600 text-[10px] font-black uppercase tracking-widest rounded-xl shadow-2xl shadow-teal-500/20">SIAP MELAYANI</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
