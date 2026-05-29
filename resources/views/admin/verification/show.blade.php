<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <a href="{{ route('admin.verification.index') }}" class="text-slate-400 hover:text-slate-900 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Detail Pengajuan Verifikasi</h2>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-0.5">Tinjau Dokumen KTP Pemohon</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 space-y-12 pb-32">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            {{-- Left Side: Identity Info --}}
            <div class="lg:col-span-5 space-y-10">
                <div class="bg-white rounded-[3rem] shadow-xl shadow-slate-100 border border-slate-100 p-8 md:p-10 space-y-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-teal-900 text-white flex items-center justify-center font-black text-lg uppercase">
                            {{ substr($requestData->nama_lengkap, 0, 2) }}
                        </div>
                        <div>
                            <h3 class="font-black text-slate-800 text-lg leading-tight">{{ $requestData->nama_lengkap }}</h3>
                            <span class="text-xs text-slate-400 mt-1 block">Tipe Akun: Pemohon Publik</span>
                        </div>
                    </div>

                    <div class="border-t border-slate-50 pt-8 space-y-6">
                        <div>
                            <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">NIK (Nomor Induk Kependudukan)</span>
                            <span class="font-black text-slate-700 text-md tracking-wider">{{ $requestData->nik }}</span>
                        </div>

                        <div>
                            <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Nomor WhatsApp</span>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-700">{{ $requestData->no_telepon }}</span>
                                @if($requestData->phone_verified_at)
                                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded text-[8px] font-black uppercase tracking-wider">Terverifikasi OTP</span>
                                @else
                                    <span class="px-2 py-0.5 bg-amber-50 text-amber-600 border border-amber-100 rounded text-[8px] font-black uppercase tracking-wider">Belum Verifikasi OTP</span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Email Terdaftar</span>
                            <span class="font-bold text-slate-700">{{ $requestData->user->email }}</span>
                        </div>

                        <div>
                            <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Alamat Domisili</span>
                            <p class="font-bold text-slate-600 text-sm leading-relaxed">{{ $requestData->alamat }}</p>
                        </div>

                        <div>
                            <span class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Verifikasi</span>
                            @if($requestData->status === 'pending_verification')
                                <span class="inline-block px-3 py-1.5 bg-blue-50 text-blue-600 border border-blue-100 rounded-lg text-[9px] font-black uppercase tracking-wider">Menunggu Review</span>
                            @elseif($requestData->status === 'verified')
                                <span class="inline-block px-3 py-1.5 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-lg text-[9px] font-black uppercase tracking-wider">Disetujui (Aktif)</span>
                            @elseif($requestData->status === 'rejected')
                                <span class="inline-block px-3 py-1.5 bg-rose-50 text-rose-600 border border-rose-100 rounded-lg text-[9px] font-black uppercase tracking-wider">Ditolak</span>
                            @else
                                <span class="inline-block px-3 py-1.5 bg-slate-50 text-slate-500 border border-slate-100 rounded-lg text-[9px] font-black uppercase tracking-wider">Belum Diajukan</span>
                            @endif
                        </div>

                        @if($requestData->status === 'rejected' && $requestData->rejected_reason)
                            <div class="p-4 bg-rose-50 border border-rose-100 rounded-2xl">
                                <span class="block text-[9px] font-black text-rose-500 uppercase tracking-widest mb-1">Alasan Penolakan</span>
                                <p class="text-xs text-rose-900 font-bold">"{{ $requestData->rejected_reason }}"</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Action Panel (Only if Pending) --}}
                @if($requestData->status === 'pending_verification')
                    <div class="bg-white rounded-[3rem] shadow-xl shadow-slate-100 border border-slate-100 p-8 md:p-10 space-y-8">
                        <h4 class="font-black text-slate-800 uppercase tracking-wider text-xs">Persetujuan Berkas</h4>
                        
                        <div class="flex gap-4">
                            <!-- Approve Form -->
                            <form method="POST" action="{{ route('admin.verification.approve', $requestData->id) }}" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui verifikasi data diri pemohon ini?');">
                                @csrf
                                <button type="submit" class="w-full py-4 bg-emerald-600 text-white font-black text-[10px] uppercase tracking-widest rounded-2xl hover:bg-emerald-700 active:scale-95 transition-all shadow-lg shadow-emerald-600/20">
                                    Setujui Verifikasi
                                </button>
                            </form>
                            
                            <button type="button" onclick="document.getElementById('reject-form-container').classList.toggle('hidden')" class="flex-1 py-4 bg-rose-600 text-white font-black text-[10px] uppercase tracking-widest rounded-2xl hover:bg-rose-700 active:scale-95 transition-all shadow-lg shadow-rose-600/20">
                                Tolak Verifikasi
                            </button>
                        </div>

                        <!-- Reject Reason Box (Hidden initially) -->
                        <div id="reject-form-container" class="hidden border-t border-slate-100 pt-6 animate-fade-in">
                            <form method="POST" action="{{ route('admin.verification.reject', $requestData->id) }}" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="rejected_reason" class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Alasan Penolakan</label>
                                    <textarea name="rejected_reason" id="rejected_reason" rows="3" required placeholder="Contoh: Foto KTP tidak jelas, NIK tidak sesuai dengan KTP asli, dll."
                                              class="w-full p-4 bg-slate-50 border-slate-200 rounded-xl focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 font-bold text-slate-700 text-xs resize-none"></textarea>
                                </div>
                                <button type="submit" class="w-full py-3 bg-slate-900 text-white font-black text-[9px] uppercase tracking-widest rounded-xl hover:bg-slate-800 transition-colors">
                                    Kirim Penolakan
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Right Side: Document Image --}}
            <div class="lg:col-span-7 space-y-6">
                <div class="bg-white rounded-[3.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 p-8 md:p-12 space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-50 pb-6">
                        <h4 class="font-black text-slate-800 uppercase tracking-wider text-xs">Foto KTP / Kartu Identitas</h4>
                        @if($requestData->foto_ktp)
                            <a href="{{ asset('storage/' . $requestData->foto_ktp) }}" target="_blank" class="text-xs text-indigo-600 hover:underline font-bold flex items-center gap-1">
                                Buka di Tab Baru
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                            </a>
                        @endif
                    </div>

                    @if($requestData->foto_ktp)
                        <div class="rounded-[2rem] overflow-hidden border border-slate-200 shadow-inner bg-slate-900/5 flex items-center justify-center p-4">
                            <img src="{{ asset('storage/' . $requestData->foto_ktp) }}" alt="KTP Pemohon" class="max-w-full max-h-[500px] object-contain rounded-xl shadow-lg">
                        </div>
                    @else
                        <div class="py-20 text-center border-2 border-dashed border-slate-200 rounded-[2.5rem] bg-slate-50">
                            <div class="w-12 h-12 bg-slate-100 text-slate-400 flex items-center justify-center rounded-xl mx-auto mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <p class="text-slate-400 text-sm font-bold">Foto KTP Tidak Tersedia</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
