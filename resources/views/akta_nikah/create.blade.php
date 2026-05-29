<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <a href="{{ route('akta-nikah.index') }}" class="w-12 h-12 rounded-2xl bg-white border border-slate-100 hover:bg-slate-50 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-all active:scale-90 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Input Data Akta Nikah</h2>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-0.5">Penambahan Arsip Baru ke Sistem</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-10 pb-20">
        <form method="POST" action="{{ route('akta-nikah.store') }}" enctype="multipart/form-data" class="space-y-10">
            @csrf

            @if($errors->any())
                <div class="p-8 bg-rose-50 border border-rose-100 rounded-[2.5rem] flex gap-6 animate-fade-in shadow-xl shadow-rose-100/50">
                    <div class="w-14 h-14 bg-rose-500 rounded-2xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-rose-200">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                    <div>
                        <h4 class="font-black text-rose-800 text-lg tracking-tight">Terjadi Kesalahan Validasi</h4>
                        <p class="text-rose-600/70 text-sm font-bold mt-1">Mohon periksa kembali kolom-kolom berikut:</p>
                        <ul class="text-rose-600 text-sm font-bold mt-3 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-1 list-disc list-inside opacity-90">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Card: Administrasi --}}
            <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden transform transition-all duration-500 hover:shadow-xl hover:shadow-slate-200/40">
                <div class="p-8 md:p-10 border-b border-slate-50 flex items-center bg-slate-50/30">
                    <div class="w-14 h-14 bg-teal-600 rounded-[1.2rem] flex items-center justify-center text-white mr-6 shadow-xl shadow-teal-200">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight">Detail Administrasi</h3>
                        <p class="text-[10px] font-black text-teal-600 uppercase tracking-[0.25em] mt-1">Informasi Utama Dokumen</p>
                    </div>
                </div>
                <div class="p-8 md:p-12 grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400驱动 uppercase tracking-[0.2em] ml-2">Nomor Akta <span class="text-rose-500 font-black">*</span></label>
                        <input type="text" name="nomor_akta" value="{{ old('nomor_akta') }}" required placeholder="Contoh: 0123/045/V/2023"
                               class="w-full px-8 py-5 bg-slate-50 border-slate-100 rounded-[1.4rem] focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-bold text-slate-700 shadow-inner">
                    </div>
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Nomor Buku / Halaman</label>
                        <input type="text" name="nomor_buku" value="{{ old('nomor_buku') }}" placeholder="No. Vol / Hal"
                               class="w-full px-8 py-5 bg-slate-50 border-slate-100 rounded-[1.4rem] focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-bold text-slate-700 shadow-inner">
                    </div>
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Tanggal Akad <span class="text-rose-500 font-black">*</span></label>
                        <input type="date" name="tanggal_akad" value="{{ old('tanggal_akad') }}" required
                               class="w-full px-8 py-5 bg-slate-50 border-slate-100 rounded-[1.4rem] focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-bold text-slate-700 shadow-inner">
                    </div>
                    <div class="space-y-3">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Lokasi Akad</label>
                        <input type="text" name="lokasi_akad" value="{{ old('lokasi_akad') }}" placeholder="Contoh: Masjid Agung / Rumah"
                               class="w-full px-8 py-5 bg-slate-50 border-slate-100 rounded-[1.4rem] focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-bold text-slate-700 shadow-inner">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                {{-- Data Suami --}}
                <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden group hover:shadow-xl transition-all duration-500">
                    <div class="p-8 border-b border-slate-50 flex items-center bg-teal-50/20">
                        <div class="w-14 h-14 bg-slate-900 rounded-[1.2rem] flex items-center justify-center text-2xl mr-6 shadow-xl shadow-slate-200">👨</div>
                        <div>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight">Data Suami</h3>
                            <p class="text-[10px] font-black text-teal-600 uppercase tracking-[0.2em] mt-1">Groom Information</p>
                        </div>
                    </div>
                    <div class="p-8 md:p-10 space-y-8">
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Nama Suami <span class="text-rose-500 font-black">*</span></label>
                            <input type="text" name="nama_suami" value="{{ old('nama_suami') }}" required
                                   class="w-full px-8 py-5 bg-slate-50 border-slate-100 rounded-[1.4rem] focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-bold text-slate-700 shadow-inner">
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">NIK Suami</label>
                            <input type="text" name="nik_suami" value="{{ old('nik_suami') }}" maxlength="20"
                                   class="w-full px-8 py-5 bg-slate-50 border-slate-100 rounded-[1.4rem] focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-bold text-slate-700 shadow-inner">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir_suami" value="{{ old('tempat_lahir_suami') }}"
                                       class="w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 font-bold text-slate-700 shadow-inner text-sm">
                            </div>
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Tgl Lahir</label>
                                <input type="date" name="tanggal_lahir_suami" value="{{ old('tanggal_lahir_suami') }}"
                                       class="w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 font-bold text-slate-700 shadow-inner text-sm">
                            </div>
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Alamat Lengkap</label>
                            <textarea name="alamat_suami" rows="3" class="w-full px-8 py-5 bg-slate-50 border-slate-100 rounded-[1.4rem] focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-bold text-slate-700 shadow-inner">{{ old('alamat_suami') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Data Istri --}}
                <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden group hover:shadow-xl transition-all duration-500">
                    <div class="p-8 border-b border-slate-50 flex items-center bg-rose-50/20">
                        <div class="w-14 h-14 bg-rose-500 rounded-[1.2rem] flex items-center justify-center text-2xl mr-6 shadow-xl shadow-rose-100">👩</div>
                        <div>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight">Data Istri</h3>
                            <p class="text-[10px] font-black text-rose-500 uppercase tracking-[0.2em] mt-1">Bride Information</p>
                        </div>
                    </div>
                    <div class="p-8 md:p-10 space-y-8">
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Nama Istri <span class="text-rose-500 font-black">*</span></label>
                            <input type="text" name="nama_istri" value="{{ old('nama_istri') }}" required
                                   class="w-full px-8 py-5 bg-slate-50 border-slate-100 rounded-[1.4rem] focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-bold text-slate-700 shadow-inner">
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">NIK Istri</label>
                            <input type="text" name="nik_istri" value="{{ old('nik_istri') }}" maxlength="20"
                                   class="w-full px-8 py-5 bg-slate-50 border-slate-100 rounded-[1.4rem] focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-bold text-slate-700 shadow-inner">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir_istri" value="{{ old('tempat_lahir_istri') }}"
                                       class="w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 font-bold text-slate-700 shadow-inner text-sm">
                            </div>
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Tgl Lahir</label>
                                <input type="date" name="tanggal_lahir_istri" value="{{ old('tanggal_lahir_istri') }}"
                                       class="w-full px-5 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 font-bold text-slate-700 shadow-inner text-sm">
                            </div>
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Alamat Lengkap</label>
                            <textarea name="alamat_istri" rows="3" class="w-full px-8 py-5 bg-slate-50 border-slate-100 rounded-[1.4rem] focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-bold text-slate-700 shadow-inner">{{ old('alamat_istri') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Wali & Berkas (Dark Section) --}}
            <div class="bg-slate-900 rounded-[3.5rem] p-8 md:p-14 text-white shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 p-16 opacity-[0.03] pointer-events-none">
                    <svg class="w-80 h-80" fill="currentColor" viewBox="0 0 24 24"><path d="M4 19h16v2H4v-2zm1.61-12.2a2 2 0 011.33-1.8l8-2.67a2 2 0 012.12.84l1.6 2.4a2 2 0 01.34 1.2V17h-12a2 2 0 01-1.39-3.43l-.01-6.77zm11.39-1.93L9.61 7.2l.6 1.4L17 5.27l-.6-1.4z" /></svg>
                </div>
                
                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
                    <div class="lg:col-span-6 space-y-10">
                        <div>
                            <h3 class="text-3xl font-black tracking-tight mb-3">Wali & Penghulu</h3>
                            <p class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.4em]">Legal Witnesses & Officiants</p>
                        </div>
                        <div class="space-y-6">
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-2">Nama Lengkap Wali</label>
                                <input type="text" name="nama_wali" value="{{ old('nama_wali') }}"
                                       class="w-full bg-white/5 border-white/10 rounded-[1.2rem] px-8 py-5 focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 transition-all font-black text-lg">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-3">
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-2">Jenis Wali</label>
                                    <select name="jenis_wali" class="w-full bg-white/5 border-white/10 rounded-[1.2rem] px-6 py-5 focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-black">
                                        <option value="" class="bg-slate-900">Pilih</option>
                                        <option value="nasab" {{ old('jenis_wali') == 'nasab' ? 'selected' : '' }} class="bg-slate-900">Nasab</option>
                                        <option value="hakim" {{ old('jenis_wali') == 'hakim' ? 'selected' : '' }} class="bg-slate-900">Hakim</option>
                                    </select>
                                </div>
                                <div class="space-y-3">
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-2">Mas Kawin</label>
                                    <input type="text" name="mas_kawin" value="{{ old('mas_kawin') }}"
                                           class="w-full bg-white/5 border-white/10 rounded-[1.2rem] px-6 py-5 focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-black">
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-2">Nama Penghulu</label>
                                <input type="text" name="penghulu" value="{{ old('penghulu') }}"
                                       class="w-full bg-white/5 border-white/10 rounded-[1.2rem] px-8 py-5 focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 transition-all font-black">
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-6 space-y-10">
                        <div>
                            <h3 class="text-3xl font-black tracking-tight mb-3">Arsip & Berkas</h3>
                            <p class="text-slate-400 font-bold text-[10px] uppercase tracking-[0.4em]">Archiving & Scan Documents</p>
                        </div>
                        <div class="space-y-6">
                            <div class="grid grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-2">Kategori</label>
                                    <select name="kategori" class="w-full bg-white/5 border-white/10 rounded-[1.2rem] px-6 py-5 focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-black">
                                        <option value="" class="bg-slate-900">Pilih</option>
                                        <option value="Lama" {{ old('kategori') == 'Lama' ? 'selected' : '' }} class="bg-slate-900">Lama</option>
                                        <option value="Baru" {{ old('kategori') == 'Baru' ? 'selected' : '' }} class="bg-slate-900">Baru</option>
                                        <option value="Duplikat" {{ old('kategori') == 'Duplikat' ? 'selected' : '' }} class="bg-slate-900">Duplikat</option>
                                    </select>
                                </div>
                                <div class="space-y-3">
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-2">Lokasi Rak/Fisik</label>
                                    <input type="text" name="lokasi_fisik" value="{{ old('lokasi_fisik') }}" placeholder="Contoh: Rak B-12"
                                           class="w-full bg-white/5 border-white/10 rounded-[1.2rem] px-6 py-5 focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-black">
                                </div>
                            </div>
                            
                            <div class="p-8 rounded-[2rem] bg-white/5 border border-white/10 space-y-6 relative group overflow-hidden transition-all hover:bg-white/[0.07]">
                                <div class="flex items-center gap-6 relative z-10">
                                    <div class="w-16 h-16 rounded-2xl bg-teal-500 flex items-center justify-center shadow-2xl shadow-teal-500/40">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                                    </div>
                                    <div>
                                        <p class="text-lg font-black tracking-tight">Unggah Scan Dokumen</p>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em] mt-1">PDF / JPG / PNG (Max 2MB)</p>
                                    </div>
                                </div>
                                <div class="relative z-10">
                                    <input type="file" name="file" class="w-full text-sm text-slate-400 file:mr-6 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-teal-500 file:text-white hover:file:bg-teal-400 transition-all cursor-pointer">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Additional & Action --}}
            <div class="bg-white rounded-[3rem] p-4 border border-slate-100 shadow-sm flex flex-col md:flex-row items-stretch md:items-center gap-4">
                <div class="flex-1 p-2">
                    <textarea name="keterangan" rows="1" placeholder="Catatan tambahan (opsional)..."
                              class="w-full px-8 py-5 bg-slate-50 border-none rounded-[1.8rem] focus:ring-4 focus:ring-teal-500/10 transition-all font-bold text-slate-700 placeholder:text-slate-300 h-full min-h-[70px]">{{ old('keterangan') }}</textarea>
                </div>
                <div class="flex gap-4 p-2 shrink-0 h-full">
                    <a href="{{ route('akta-nikah.index') }}" 
                       class="px-10 py-5 bg-slate-100 text-slate-400 rounded-[1.8rem] font-black text-center hover:bg-slate-200 transition-all active:scale-95 uppercase tracking-widest text-[10px] flex items-center justify-center">
                        BATAL
                    </a>
                    <button type="submit" 
                            class="px-14 py-5 bg-teal-600 text-white rounded-[1.8rem] font-black text-center shadow-xl shadow-teal-600/20 hover:bg-teal-700 transition-all active:scale-95 uppercase tracking-widest text-[10px] flex items-center justify-center">
                        SIMPAN ARSIP
                    </button>
                </div>
            </div>
        </form>
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fade-in 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
    </style>
</x-app-layout>ayout>