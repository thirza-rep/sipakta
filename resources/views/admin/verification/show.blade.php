<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <a href="{{ route('admin.verification.index') }}" class="w-12 h-12 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
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
                        <h4 class="text-white font-bold text-base">📋 Checklist Kelengkapan</h4>
                        <p class="text-slate-300 text-sm">Ringkasan status verifikasi pemohon</p>
                    </div>
                    <div class="p-5 space-y-3">
                        {{-- Email --}}
                        <div class="flex items-center gap-3 p-3 rounded-lg {{ $emailVerified ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                            <span class="text-xl">{{ $emailVerified ? '✅' : '❌' }}</span>
                            <div>
                                <span class="font-bold text-sm {{ $emailVerified ? 'text-green-800' : 'text-red-800' }}">Email {{ $emailVerified ? 'Terverifikasi' : 'Belum Verifikasi' }}</span>
                                <span class="block text-xs {{ $emailVerified ? 'text-green-600' : 'text-red-600' }}">{{ $requestData->user->email }}</span>
                            </div>
                        </div>

                        {{-- WhatsApp --}}
                        <div class="flex items-center gap-3 p-3 rounded-lg {{ $waFilled ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                            <span class="text-xl">{{ $waFilled ? '✅' : '❌' }}</span>
                            <div>
                                <span class="font-bold text-sm {{ $waFilled ? 'text-green-800' : 'text-red-800' }}">WhatsApp {{ $waFilled ? 'Sudah Diisi' : 'Belum Diisi' }}</span>
                                <span class="block text-xs {{ $waFilled ? 'text-green-600' : 'text-red-600' }}">{{ $requestData->no_telepon }}</span>
                            </div>
                        </div>

                        {{-- NIK --}}
                        <div class="flex items-center gap-3 p-3 rounded-lg {{ $nikValid ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                            <span class="text-xl">{{ $nikValid ? '✅' : '❌' }}</span>
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
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Email</span>
                            <span class="font-semibold text-slate-700">{{ $requestData->user->email }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat Domisili</span>
                            <p class="font-semibold text-slate-600 text-sm leading-relaxed">{{ $requestData->alamat }}</p>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Status Saat Ini</span>
                            @if($requestData->status === 'pending_verification')
                                <span class="inline-block px-4 py-2 bg-blue-100 text-blue-700 border border-blue-200 rounded-lg text-sm font-bold">⏳ Menunggu Review</span>
                            @elseif($requestData->status === 'verified')
                                <span class="inline-block px-4 py-2 bg-green-100 text-green-700 border border-green-200 rounded-lg text-sm font-bold">✅ Disetujui (Aktif)</span>
                            @elseif($requestData->status === 'rejected')
                                <span class="inline-block px-4 py-2 bg-red-100 text-red-700 border border-red-200 rounded-lg text-sm font-bold">❌ Ditolak</span>
                            @else
                                <span class="inline-block px-4 py-2 bg-slate-100 text-slate-600 border border-slate-200 rounded-lg text-sm font-bold">Belum Diajukan</span>
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

                {{-- Action Panel --}}
                @if($requestData->status === 'pending_verification')
                    <div class="bg-white rounded-2xl shadow-lg border border-slate-200 p-6 space-y-5">
                        <h4 class="font-bold text-slate-800 text-base">🔑 Keputusan Verifikasi</h4>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <form method="POST" action="{{ route('admin.verification.approve', $requestData->id) }}" class="flex-1" onsubmit="return confirm('Yakin ingin MENYETUJUI dan mengaktifkan akun pemohon ini?');">
                                @csrf
                                <button type="submit" class="w-full py-4 bg-green-600 text-white font-bold text-sm rounded-xl hover:bg-green-700 active:scale-95 transition-all shadow-lg">
                                    ✅ Setujui & Aktifkan
                                </button>
                            </form>

                            <button type="button" onclick="document.getElementById('reject-form-container').classList.toggle('hidden')" class="flex-1 py-4 bg-red-600 text-white font-bold text-sm rounded-xl hover:bg-red-700 active:scale-95 transition-all shadow-lg">
                                ❌ Tolak Verifikasi
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
                   class="block w-full py-4 bg-slate-100 text-slate-700 font-bold text-sm rounded-xl hover:bg-slate-200 transition-all text-center border border-slate-200">
                    🖨️ Cetak Salinan Data Pemohon (PDF)
                </a>
            </div>

            </div>

        </div>
    </div>
</x-app-layout>
