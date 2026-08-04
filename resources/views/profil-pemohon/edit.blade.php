<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Profil Pemohon</h2>
            <p class="text-slate-500 text-sm mt-1">Kelola informasi identitas Anda untuk pengajuan verifikasi</p>
        </div>
    </x-slot>

    @php
        $emailVerified = $user->email_verified_at !== null;
        $dataLengkap = $profil && $profil->nik && $profil->nama_lengkap && $profil->alamat;
        $waFilled = $profil && !empty($profil->no_telepon);
        $allComplete = $emailVerified && $dataLengkap && $waFilled;
        $isPending = $profil && $profil->status === 'pending_verification';
        $isVerified = $profil && $profil->status === 'verified';
        $isRejected = $profil && $profil->status === 'rejected';
    @endphp

    <div class="max-w-4xl mx-auto space-y-8 pb-32">

        {{-- ======================================= --}}
        {{-- CHECKLIST PROGRESS VERIFIKASI           --}}
        {{-- ======================================= --}}
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <div class="bg-slate-800 px-6 py-5 sm:px-8">
                <h3 class="text-white font-bold text-lg flex items-center">
                    <svg class="w-6 h-6 mr-2 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Checklist Kelengkapan Pendaftaran
                </h3>
                <p class="text-slate-300 text-sm mt-1">Selesaikan semua langkah di bawah ini sebelum mengajukan verifikasi</p>
            </div>
            <div class="p-6 sm:p-8 space-y-4">
                {{-- Step 1: Email --}}
                <div class="flex items-start gap-4 p-4 rounded-xl {{ $emailVerified ? 'bg-green-50 border border-green-200' : 'bg-amber-50 border border-amber-200' }}">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 text-lg {{ $emailVerified ? 'bg-green-500 text-white' : 'bg-amber-400 text-white' }}">
                        @if($emailVerified) ✓ @else 1 @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-base {{ $emailVerified ? 'text-green-800' : 'text-amber-800' }}">Verifikasi Email</h4>
                        <p class="text-sm {{ $emailVerified ? 'text-green-700' : 'text-amber-700' }} mt-0.5">
                            @if($emailVerified)
                                Email <strong>{{ $user->email }}</strong> sudah terverifikasi pada {{ $user->email_verified_at->translatedFormat('d F Y, H:i') }}.
                            @else
                                Email Anda belum diverifikasi. Silakan cek inbox email <strong>{{ $user->email }}</strong> untuk kode OTP.
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Step 2: Data Diri --}}
                <div class="flex items-start gap-4 p-4 rounded-xl {{ $dataLengkap ? 'bg-green-50 border border-green-200' : 'bg-amber-50 border border-amber-200' }}">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 text-lg {{ $dataLengkap ? 'bg-green-500 text-white' : 'bg-amber-400 text-white' }}">
                        @if($dataLengkap) ✓ @else 2 @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-base {{ $dataLengkap ? 'text-green-800' : 'text-amber-800' }}">Isi Data Diri Lengkap</h4>
                        <p class="text-sm {{ $dataLengkap ? 'text-green-700' : 'text-amber-700' }} mt-0.5">
                            @if($dataLengkap)
                                Data diri (Nama, NIK, Alamat) sudah lengkap terisi.
                            @else
                                Lengkapi formulir di bawah: Nama Lengkap, NIK (16 digit), dan Alamat Domisili.
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Step 3: WhatsApp --}}
                <div class="flex items-start gap-4 p-4 rounded-xl {{ $waFilled ? 'bg-green-50 border border-green-200' : 'bg-amber-50 border border-amber-200' }}">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 text-lg {{ $waFilled ? 'bg-green-500 text-white' : 'bg-amber-400 text-white' }}">
                        @if($waFilled) ✓ @else 3 @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-base {{ $waFilled ? 'text-green-800' : 'text-amber-800' }}">Isi Nomor WhatsApp</h4>
                        <p class="text-sm {{ $waFilled ? 'text-green-700' : 'text-amber-700' }} mt-0.5">
                            @if($waFilled)
                                Nomor <strong>{{ $profil->no_telepon }}</strong> sudah tersimpan.
                            @else
                                Masukkan nomor HP/WhatsApp aktif Anda pada formulir di bawah.
                            @endif
                        </p>
                    </div>
                </div>

            </div>
        </div>

        {{-- ======================================= --}}
        {{-- STATUS ALERTS                           --}}
        {{-- ======================================= --}}
        @if($isPending)
            <div class="bg-blue-50 border-2 border-blue-300 p-6 rounded-2xl flex items-start gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white shrink-0">
                    
                </div>
                <div>
                    <h4 class="font-bold text-blue-900 text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Menunggu Persetujuan Admin KUA
                    </h4>
                    <p class="text-blue-700 text-sm mt-1">Data Anda sedang diperiksa oleh petugas. Anda akan mendapat akses pencarian akta setelah disetujui. Harap menunggu.</p>
                </div>
            </div>
        @elseif($isVerified)
            <div class="bg-green-50 border-2 border-green-300 p-6 rounded-2xl flex items-start gap-4">
                <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-green-900 text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Akun Anda Sudah Aktif & Terverifikasi
                    </h4>
                    <p class="text-green-700 text-sm mt-1">Selamat! Anda dapat menggunakan seluruh fitur pencarian akta nikah. Silakan menuju halaman <a href="{{ route('pencarian.index') }}" class="underline font-bold">Cari Arsip</a>.</p>
                </div>
            </div>
        @elseif($isRejected)
            <div class="bg-red-50 border-2 border-red-300 p-6 rounded-2xl flex items-start gap-4">
                <div class="w-12 h-12 rounded-full bg-red-500 flex items-center justify-center text-white shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-red-900 text-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Pengajuan Ditolak oleh Admin
                    </h4>
                    <p class="text-red-700 text-sm mt-1">
                        Alasan penolakan: <strong class="block bg-white p-3 rounded-lg border border-red-200 mt-2">"{{ $profil->rejected_reason }}"</strong>
                    </p>
                    <p class="text-red-700 text-sm mt-2">Silakan perbaiki data Anda lalu ajukan ulang.</p>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-teal-50 border-2 border-teal-300 p-5 rounded-2xl flex items-center gap-4">
                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <p class="text-teal-900 font-bold">{{ session('success') }}</p>
            </div>
        @endif
        @if(session('warning'))
            <div class="bg-amber-50 border-2 border-amber-300 p-5 rounded-2xl flex items-center gap-4">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <p class="text-amber-900 font-bold">{{ session('warning') }}</p>
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border-2 border-red-300 p-5 rounded-2xl flex flex-col gap-2">
                <div class="flex items-center gap-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <p class="text-red-900 font-bold">Gagal menyimpan profil. Silakan periksa pesan error di bawah ini:</p>
                </div>
                <ul class="list-disc list-inside text-sm text-red-700 ml-10 font-bold">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ======================================= --}}
        {{-- FORMULIR DATA PEMOHON                  --}}
        {{-- ======================================= --}}
        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
            <form method="POST" action="{{ route('profil-pemohon.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="p-6 sm:p-8 space-y-8">
                    {{-- Section: Data Personal --}}
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 border-b-2 border-teal-500 pb-3 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Data Personal
                        </h3>
                        <div class="space-y-6">
                            <div>
                                <label for="nama_lengkap" class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap (sesuai KTP)</label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap"
                                       value="{{ old('nama_lengkap', $profil->nama_lengkap ?? $user->name) }}" required
                                       class="w-full px-4 py-4 text-base bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-semibold text-slate-800"
                                       {{ $isPending ? 'disabled' : '' }}>
                                @error('nama_lengkap')<p class="mt-2 text-sm font-bold text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="nik" class="block text-sm font-bold text-slate-700 mb-2">Nomor Induk Kependudukan (NIK)</label>
                                <input type="text" name="nik" id="nik" maxlength="16"
                                       value="{{ old('nik', $profil->nik ?? '') }}" required
                                       class="w-full px-4 py-4 text-base bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-semibold text-slate-800"
                                       placeholder="Masukkan 16 digit angka NIK"
                                       {{ $isPending ? 'disabled' : '' }}>
                                @error('nik')<p class="mt-2 text-sm font-bold text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="tempat_lahir" class="block text-sm font-bold text-slate-700 mb-2">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir"
                                           value="{{ old('tempat_lahir', $profil->tempat_lahir ?? '') }}" required
                                           class="w-full px-4 py-4 text-base bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-semibold text-slate-800"
                                           placeholder="Contoh: Yogyakarta"
                                           {{ $isPending ? 'disabled' : '' }}>
                                    @error('tempat_lahir')<p class="mt-2 text-sm font-bold text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="tanggal_lahir" class="block text-sm font-bold text-slate-700 mb-2">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                           value="{{ old('tanggal_lahir', $profil->tanggal_lahir ? (\Carbon\Carbon::parse($profil->tanggal_lahir)->format('Y-m-d')) : '') }}" required
                                           class="w-full px-4 py-4 text-base bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-semibold text-slate-800"
                                           {{ $isPending ? 'disabled' : '' }}>
                                    @error('tanggal_lahir')<p class="mt-2 text-sm font-bold text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div>
                                <label for="alamat" class="block text-sm font-bold text-slate-700 mb-2">Alamat Domisili Lengkap</label>
                                <textarea name="alamat" id="alamat" rows="3" required
                                          class="w-full px-4 py-4 text-base bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-semibold text-slate-800 resize-none"
                                          {{ $isPending ? 'disabled' : '' }}>{{ old('alamat', $profil->alamat ?? '') }}</textarea>
                                @error('alamat')<p class="mt-2 text-sm font-bold text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="keperluan" class="block text-sm font-bold text-slate-700 mb-2">Tujuan / Keperluan Pencarian Arsip</label>
                                <textarea name="keperluan" id="keperluan" rows="3" required
                                          class="w-full px-4 py-4 text-base bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-semibold text-slate-800 resize-none"
                                          placeholder="Contoh: Mengurus KK baru, keperluan pensiun, dll."
                                          {{ $isPending ? 'disabled' : '' }}>{{ old('keperluan', $profil->keperluan ?? '') }}</textarea>
                                @error('keperluan')<p class="mt-2 text-sm font-bold text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Section: Kontak & WhatsApp --}}
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 border-b-2 border-indigo-500 pb-3 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Nomor WhatsApp
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label for="no_telepon" class="block text-sm font-bold text-slate-700 mb-2">Nomor Telepon / WhatsApp Aktif</label>
                                    <input type="text" name="no_telepon" id="no_telepon"
                                           value="{{ old('no_telepon', $profil->no_telepon ?? '') }}" required
                                           class="flex-1 px-4 py-4 text-base bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 font-semibold text-slate-800"
                                           placeholder="Contoh: 08123456789"
                                           {{ $isPending ? 'readonly' : '' }}>
                                </div>

                                <p class="mt-2 text-sm text-slate-500">
                                    Masukkan nomor WhatsApp aktif Anda.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Upload Dokumen (Google Drive) --}}
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 border-b-2 border-amber-500 pb-3 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Upload Dokumen Persyaratan
                        </h3>
                        <div class="space-y-6">
                            <div>
                                <label for="foto_ktp" class="block text-sm font-bold text-slate-700 mb-2">Unggah Foto KTP Asli (Opsional) <span class="text-xs text-slate-500 font-normal ml-1">Maks 2MB, JPG/PNG</span></label>
                                <input type="file" name="foto_ktp" id="foto_ktp" accept="image/jpeg,image/png,image/jpg"
                                       class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 cursor-pointer border-2 border-slate-200 rounded-xl"
                                       {{ $isPending ? 'disabled' : '' }}>
                                @if($profil && $profil->foto_ktp)
                                    <p class="text-xs text-green-600 mt-2 font-semibold">✓ KTP sudah terunggah sebelumnya.</p>
                                @endif
                                @error('foto_ktp')<p class="mt-2 text-sm font-bold text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="dokumen_pendukung" class="block text-sm font-bold text-slate-700 mb-2">Unggah Dokumen Pendukung (Wajib) <span class="text-xs text-slate-500 font-normal ml-1">Maks 5MB, PDF/JPG/PNG</span></label>
                                <p class="text-xs text-slate-500 mb-3 leading-relaxed">Dokumen pendukung dapat berupa Surat Keterangan dari instansi, Surat Kuasa, atau dokumen lain yang memperkuat alasan pencarian arsip Anda.</p>
                                <input type="file" name="dokumen_pendukung" id="dokumen_pendukung" accept="application/pdf,image/jpeg,image/png,image/jpg" {{ !$profil || !$profil->dokumen_pendukung ? 'required' : '' }}
                                       class="block w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 cursor-pointer border-2 border-slate-200 rounded-xl"
                                       {{ $isPending ? 'disabled' : '' }}>
                                @if($profil && $profil->dokumen_pendukung)
                                    <p class="text-xs text-green-600 mt-2 font-semibold">✓ Dokumen Pendukung sudah terunggah sebelumnya.</p>
                                @endif
                                @error('dokumen_pendukung')<p class="mt-2 text-sm font-bold text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Submit Area --}}
                <div class="bg-slate-50 border-t-2 border-slate-200 px-6 sm:px-8 py-6">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-sm text-slate-500 text-center sm:text-left flex items-center justify-center sm:justify-start">
                            <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Pastikan semua data asli. Setelah diajukan, data akan diperiksa oleh Admin KUA.
                        </p>
                        @if(!$isPending && !$isVerified)
                            <button type="submit" id="btn-submit-form"
                                    class="w-full sm:w-auto px-10 py-4 bg-teal-600 text-white rounded-xl font-bold text-base shadow-lg hover:bg-teal-700 active:scale-95 transition-all disabled:opacity-40 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                {{ $isRejected ? 'Simpan & Ajukan Ulang Verifikasi' : 'Ajukan Verifikasi Profil' }}
                            </button>
                        @elseif($isPending)
                            <button type="button" disabled
                                    class="w-full sm:w-auto px-10 py-4 bg-slate-300 text-slate-600 rounded-xl font-bold text-base cursor-not-allowed flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Dalam Proses Verifikasi Admin
                            </button>
                        @elseif($isVerified)
                            <a href="{{ route('pencarian.index') }}"
                               class="w-full sm:w-auto px-10 py-4 bg-green-600 text-white rounded-xl font-bold text-base text-center shadow-lg hover:bg-green-700 transition-all flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                Mulai Pencarian Akta
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
