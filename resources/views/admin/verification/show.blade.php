<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <a href="{{ route('admin.verification.index') }}" class="w-12 h-12 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 transition-all">
                
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Detail Pengajuan Verifikasi</h2>
                <p class="text-slate-500 text-sm mt-0.5">Tinjau data dan dokumen KTP pemohon</p>
            </div>
        </div>
    </x-slot>

    @php
        $emailVerified = $requestData->user->email_verified_at !== null;
        $waFilled = !empty($requestData->no_telepon);
        $nikValid = $requestData->nik && strlen($requestData->nik) === 16;
    @endphp

    <div class="max-w-7xl mx-auto space-y-8 pb-32">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- Identity Info --}}
            <div class="lg:col-span-8 lg:col-start-3 space-y-8">

                {{-- =============================== --}}
                {{-- CHECKLIST KELENGKAPAN PEMOHON   --}}
                {{-- =============================== --}}
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                    <div class="bg-slate-800 px-6 py-4">
                        <h4 class="text-white font-bold text-base flex items-center">
                            <svg class="w-5 h-5 mr-2 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            Checklist Kelengkapan
                        </h4>
                        <p class="text-slate-300 text-sm">Ringkasan status verifikasi pemohon</p>
                    </div>
                    <div class="p-5 space-y-3">
                        {{-- Email --}}
                        <div class="flex items-center gap-3 p-3 rounded-lg {{ $emailVerified ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                            @if($emailVerified)
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            @else
                                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </div>
                            @endif
                            <div>
                                <span class="font-bold text-sm {{ $emailVerified ? 'text-green-800' : 'text-red-800' }}">Email {{ $emailVerified ? 'Terverifikasi' : 'Belum Verifikasi' }}</span>
                                <span class="block text-xs {{ $emailVerified ? 'text-green-600' : 'text-red-600' }}">{{ $requestData->user->email }}</span>
                            </div>
                        </div>

                        {{-- WhatsApp --}}
                        <div class="flex items-center gap-3 p-3 rounded-lg {{ $waFilled ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                            @if($waFilled)
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            @else
                                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </div>
                            @endif
                            <div>
                                <span class="font-bold text-sm {{ $waFilled ? 'text-green-800' : 'text-red-800' }}">WhatsApp {{ $waFilled ? 'Sudah Diisi' : 'Belum Diisi' }}</span>
                                <span class="block text-xs {{ $waFilled ? 'text-green-600' : 'text-red-600' }}">{{ $requestData->no_telepon }}</span>
                            </div>
                        </div>

                        {{-- NIK --}}
                        <div class="flex items-center gap-3 p-3 rounded-lg {{ $nikValid ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                            @if($nikValid)
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            @else
                                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </div>
                            @endif
                            <div>
                                <span class="font-bold text-sm {{ $nikValid ? 'text-green-800' : 'text-red-800' }}">NIK {{ $nikValid ? '16 Digit Valid' : 'Tidak Valid' }}</span>
                                <span class="block text-xs {{ $nikValid ? 'text-green-600' : 'text-red-600' }}">{{ $requestData->nik ?? 'Kosong' }}</span>
                            </div>
                        </div>

                        </div>
                </div>

                {{-- Data Pemohon --}}
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 space-y-5">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-teal-600 text-white flex items-center justify-center font-bold text-xl uppercase">
                            {{ substr($requestData->nama_lengkap, 0, 2) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg">{{ $requestData->nama_lengkap }}</h3>
                            <span class="text-sm text-slate-500">Akun Pemohon Publik</span>
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-5 space-y-4">
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">NIK</span>
                            <span class="font-bold text-slate-700 text-base tracking-wider">{{ $requestData->nik }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tempat, Tanggal Lahir</span>
                            <span class="font-semibold text-slate-700">{{ $requestData->tempat_lahir ?? '-' }}, {{ $requestData->tanggal_lahir ? \Carbon\Carbon::parse($requestData->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Email</span>
                            <span class="font-semibold text-slate-700">{{ $requestData->user->email }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat Domisili</span>
                            <p class="font-semibold text-slate-600 text-sm leading-relaxed">{{ $requestData->alamat }}</p>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tujuan / Keperluan Mencari Arsip</span>
                            <p class="font-bold text-slate-700 text-sm bg-slate-50 p-3 rounded-xl border border-slate-100">{{ $requestData->keperluan ?? 'Tidak ada keterangan' }}</p>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Status Saat Ini</span>
                            @if($requestData->status === 'pending_verification')
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-100 text-blue-700 border border-blue-200 rounded-lg text-sm font-bold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Menunggu Review
                                </span>
                            @elseif($requestData->status === 'verified')
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-green-100 text-green-700 border border-green-200 rounded-lg text-sm font-bold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Disetujui (Aktif)
                                </span>
                            @elseif($requestData->status === 'rejected')
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-100 text-red-700 border border-red-200 rounded-lg text-sm font-bold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Ditolak
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 text-slate-600 border border-slate-200 rounded-lg text-sm font-bold">
                                    Belum Diajukan
                                </span>
                            @endif
                        </div>

                        @if($requestData->status === 'rejected' && $requestData->rejected_reason)
                            <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
                                <span class="block text-xs font-bold text-red-500 uppercase tracking-wider mb-1">Alasan Penolakan</span>
                                <p class="text-sm text-red-800 font-bold">"{{ $requestData->rejected_reason }}"</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Dokumen Pemohon (KTP & Dokumen Pendukung) --}}
                <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 space-y-5">
                    <h4 class="font-bold text-slate-800 text-base flex items-center mb-4">
                        <svg class="w-5 h-5 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        Berkas Dokumen Terlampir
                    </h4>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- KTP Card --}}
                        <div class="border border-slate-200 rounded-xl p-4 flex flex-col justify-between h-full bg-slate-50">
                            <div>
                                <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Foto KTP (Opsional)</span>
                                @if($requestData->foto_ktp)
                                    <div class="border border-slate-200 rounded-lg overflow-hidden bg-white flex items-center justify-center shadow-sm">
                                        <img src="{{ route('admin.verification.download', ['id' => $requestData->id, 'type' => 'ktp']) }}" alt="Foto KTP" class="max-h-48 w-full object-contain hover:scale-105 transition-transform duration-300">
                                    </div>
                                    
                                    <a href="{{ route('admin.verification.download', ['id' => $requestData->id, 'type' => 'ktp']) }}" target="_blank" class="mt-4 w-full py-2 bg-white border border-slate-300 text-slate-700 font-bold text-sm rounded-lg hover:bg-slate-50 transition-colors text-center flex items-center justify-center gap-2 shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        Buka Ukuran Penuh
                                    </a>
                                @else
                                    <div class="flex items-center gap-2 mt-2">
                                        <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                        </div>
                                        <span class="text-sm font-bold text-slate-500">Tidak dilampirkan</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Dokumen Pendukung Card --}}
                        <div class="border border-slate-200 rounded-xl p-4 flex flex-col justify-between h-full bg-slate-50">
                            <div>
                                <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Dokumen Pendukung</span>
                                @if($requestData->dokumen_pendukung)
                                    <div class="border border-slate-200 rounded-lg overflow-hidden bg-white shadow-sm flex items-center justify-center" style="height: 192px;">
                                        <iframe src="{{ route('admin.verification.download', ['id' => $requestData->id, 'type' => 'dokumen']) }}" class="w-full h-full border-0 bg-slate-100"></iframe>
                                    </div>
                                    
                                    <a href="{{ route('admin.verification.download', ['id' => $requestData->id, 'type' => 'dokumen']) }}" target="_blank" class="mt-4 w-full py-2 bg-white border border-slate-300 text-slate-700 font-bold text-sm rounded-lg hover:bg-slate-50 transition-colors text-center flex items-center justify-center gap-2 shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        Buka Ukuran Penuh
                                    </a>
                                @else
                                    <div class="flex items-center gap-2 mt-2">
                                        <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </div>
                                        <span class="text-sm font-bold text-red-600">Belum dilampirkan</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Panel --}}
                @if($requestData->status === 'pending_verification')
                    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 space-y-5">
                        <h4 class="font-bold text-slate-800 text-base flex items-center">
                            <svg class="w-5 h-5 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Keputusan Verifikasi
                        </h4>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <form method="POST" action="{{ route('admin.verification.approve', $requestData->id) }}" class="flex-1" onsubmit="return confirm('Yakin ingin MENYETUJUI dan mengaktifkan akun pemohon ini?');">
                                @csrf
                                <button type="submit" class="w-full py-4 bg-green-600 text-white font-bold text-sm rounded-xl hover:bg-green-700 active:scale-95 transition-all shadow-lg flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Setujui & Aktifkan
                                </button>
                            </form>

                            <button type="button" onclick="document.getElementById('reject-form-container').classList.toggle('hidden')" class="flex-1 py-4 bg-red-600 text-white font-bold text-sm rounded-xl hover:bg-red-700 active:scale-95 transition-all shadow-lg flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Tolak Verifikasi
                            </button>
                        </div>

                        <div id="reject-form-container" class="hidden border-t border-slate-100 pt-5">
                            <form method="POST" action="{{ route('admin.verification.reject', $requestData->id) }}" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="rejected_reason" class="block text-sm font-bold text-slate-700 mb-2">Alasan Penolakan:</label>
                                    <textarea name="rejected_reason" id="rejected_reason" rows="3" required placeholder="Contoh: Foto KTP buram, NIK tidak cocok, dll."
                                              class="w-full p-4 bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-red-500/20 focus:border-red-500 font-semibold text-slate-700 text-sm resize-none"></textarea>
                                </div>
                                <button type="submit" class="w-full py-3 bg-slate-800 text-white font-bold text-sm rounded-xl hover:bg-slate-700 transition-colors">
                                    Kirim Penolakan
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                {{-- Cetak PDF Button --}}
                <a href="{{ route('admin.verification.cetak-pdf', $requestData->id) }}" target="_blank"
                   class="flex items-center justify-center gap-2 w-full py-4 bg-slate-100 text-slate-700 font-bold text-sm rounded-xl hover:bg-slate-200 transition-all text-center border border-slate-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Salinan Data Pemohon (PDF)
                </a>
            </div>

            </div>

        </div>
    </div>
</x-app-layout>
