<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('akta-nikah.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-400 hover:text-teal-600 hover:bg-teal-50 transition-all border border-slate-100 shadow-sm active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Detail Akta Nikah</h2>
                    <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-0.5">Arsip No: {{ $aktaNikah->nomor_akta }}</p>
                </div>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('akta-nikah.edit', $aktaNikah) }}" class="bg-white text-slate-700 border border-slate-200 px-6 py-3 rounded-2xl font-black shadow-sm hover:bg-slate-50 hover:text-amber-600 active:scale-95 transition-all flex items-center text-[10px] uppercase tracking-widest">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    Edit Data
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8 pb-32">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Col 1 & 2: Informasi Utama --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- Data Suami --}}
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden relative group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-bl-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
                    <div class="p-8 md:p-10 border-b border-slate-50">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <h3 class="text-xl font-black text-slate-800 tracking-tight">Data Suami</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                            <div>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1.5">Nama Lengkap</p>
                                <p class="text-sm font-bold text-slate-700">{{ $aktaNikah->nama_suami }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1.5">NIK Suami</p>
                                <p class="text-sm font-bold text-slate-700 tabular-nums">{{ $aktaNikah->nik_suami ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1.5">Tempat & Tanggal Lahir</p>
                                <p class="text-sm font-bold text-slate-700">{{ $aktaNikah->tempat_lahir_suami ?? '-' }}, {{ $aktaNikah->tanggal_lahir_suami ? \Carbon\Carbon::parse($aktaNikah->tanggal_lahir_suami)->translatedFormat('d M Y') : '-' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1.5">Alamat Lengkap</p>
                                <p class="text-sm font-bold text-slate-700 leading-relaxed">{{ $aktaNikah->alamat_suami ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Data Istri --}}
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden relative group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-rose-500/5 rounded-bl-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
                    <div class="p-8 md:p-10 border-b border-slate-50">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-black text-slate-800 tracking-tight">Data Istri</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                            <div>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1.5">Nama Lengkap</p>
                                <p class="text-sm font-bold text-slate-700">{{ $aktaNikah->nama_istri }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1.5">NIK Istri</p>
                                <p class="text-sm font-bold text-slate-700 tabular-nums">{{ $aktaNikah->nik_istri ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1.5">Tempat & Tanggal Lahir</p>
                                <p class="text-sm font-bold text-slate-700">{{ $aktaNikah->tempat_lahir_istri ?? '-' }}, {{ $aktaNikah->tanggal_lahir_istri ? \Carbon\Carbon::parse($aktaNikah->tanggal_lahir_istri)->translatedFormat('d M Y') : '-' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1.5">Alamat Lengkap</p>
                                <p class="text-sm font-bold text-slate-700 leading-relaxed">{{ $aktaNikah->alamat_istri ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Detail Pelaksanaan --}}
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden relative group">
                    <div class="p-8 md:p-10">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-black text-slate-800 tracking-tight">Pelaksanaan Akad</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                            <div>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1.5">Penghulu</p>
                                <p class="text-sm font-bold text-slate-700">{{ $aktaNikah->penghulu ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1.5">Lokasi Akad</p>
                                <p class="text-sm font-bold text-slate-700">{{ $aktaNikah->lokasi_akad ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1.5">Wali Nikah</p>
                                <p class="text-sm font-bold text-slate-700">{{ $aktaNikah->nama_wali ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1.5">Jenis Wali</p>
                                <p class="text-sm font-bold text-slate-700 capitalize">{{ $aktaNikah->jenis_wali ?? '-' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1.5">Mas Kawin / Mahar</p>
                                <p class="text-sm font-bold text-slate-700">{{ $aktaNikah->mas_kawin ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Col 3: Arsip Info --}}
            <div class="space-y-8">
                
                {{-- Kartu Status & Info Fisik --}}
                <div class="bg-gradient-to-br from-teal-500 to-teal-700 rounded-[2.5rem] shadow-xl shadow-teal-600/30 p-8 text-white relative overflow-hidden">
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="absolute -top-6 -left-6 w-24 h-24 bg-teal-400/20 rounded-full blur-xl"></div>
                    
                    <h3 class="text-lg font-black tracking-tight mb-8 relative z-10">Informasi Arsip</h3>
                    
                    <div class="space-y-6 relative z-10">
                        <div>
                            <p class="text-[10px] font-black text-teal-200 uppercase tracking-[0.2em] mb-1.5">Nomor Akta</p>
                            <p class="text-lg font-bold">{{ $aktaNikah->nomor_akta }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-teal-200 uppercase tracking-[0.2em] mb-1.5">Nomor Buku Nikah</p>
                            <p class="text-base font-bold">{{ $aktaNikah->nomor_buku ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-teal-200 uppercase tracking-[0.2em] mb-1.5">Tanggal Akad</p>
                            <p class="text-base font-bold">{{ $aktaNikah->tanggal_akad ? \Carbon\Carbon::parse($aktaNikah->tanggal_akad)->translatedFormat('d M Y') : '-' }}</p>
                        </div>
                        
                        <div class="h-px bg-teal-400/30 my-4"></div>
                        
                        <div>
                            <p class="text-[10px] font-black text-teal-200 uppercase tracking-[0.2em] mb-1.5">Lokasi Fisik (Rak)</p>
                            <p class="text-base font-bold flex items-center">
                                <svg class="w-4 h-4 mr-2 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                {{ $aktaNikah->lokasi_fisik ?? 'Belum Ditentukan' }}
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-[10px] font-black text-teal-200 uppercase tracking-[0.2em] mb-1.5">Status Arsip</p>
                            <span class="inline-flex items-center px-3 py-1 bg-white/20 text-white rounded-lg text-xs font-black uppercase tracking-wider backdrop-blur-sm border border-white/10">
                                {{ $aktaNikah->status_arsip }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Arsip Digital --}}
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-8">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-slate-50 text-slate-600 rounded-2xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">Dokumen Digital</h3>
                    </div>

                    @if($aktaNikah->file_path)
                        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 text-center">
                            <svg class="w-12 h-12 mx-auto text-teal-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <h4 class="font-bold text-slate-700 mb-1">Dokumen Tersedia</h4>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-6">PDF Terenkripsi</p>
                            
                            <a href="{{ Storage::url($aktaNikah->file_path) }}" target="_blank" class="w-full bg-slate-900 text-white py-3 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition active:scale-95 flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Unduh / Lihat File
                            </a>
                        </div>
                    @else
                        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 border-dashed text-center">
                            <svg class="w-12 h-12 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <h4 class="font-bold text-slate-500 mb-1">Belum Ada File</h4>
                            <p class="text-xs text-slate-400 mb-4">Silakan edit data ini untuk mengunggah salinan digital Akta Nikah.</p>
                            
                            <a href="{{ route('akta-nikah.edit', $aktaNikah) }}" class="inline-block px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-100 transition active:scale-95">
                                Upload Sekarang
                            </a>
                        </div>
                    @endif
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
