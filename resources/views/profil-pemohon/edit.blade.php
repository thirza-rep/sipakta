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
                <h3 class="text-white font-bold text-lg">📋 Checklist Kelengkapan Pendaftaran</h3>
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
                    <h4 class="font-bold text-blue-900 text-lg">⏳ Menunggu Persetujuan Admin KUA</h4>
                    <p class="text-blue-700 text-sm mt-1">Data Anda sedang diperiksa oleh petugas. Anda akan mendapat akses pencarian akta setelah disetujui. Harap menunggu.</p>
                </div>
            </div>
        @elseif($isVerified)
            <div class="bg-green-50 border-2 border-green-300 p-6 rounded-2xl flex items-start gap-4">
                <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white shrink-0 text-2xl">✓</div>
                <div>
                    <h4 class="font-bold text-green-900 text-lg">✅ Akun Anda Sudah Aktif & Terverifikasi</h4>
                    <p class="text-green-700 text-sm mt-1">Selamat! Anda dapat menggunakan seluruh fitur pencarian akta nikah. Silakan menuju halaman <a href="{{ route('pencarian.index') }}" class="underline font-bold">Cari Arsip</a>.</p>
                </div>
            </div>
        @elseif($isRejected)
            <div class="bg-red-50 border-2 border-red-300 p-6 rounded-2xl flex items-start gap-4">
                <div class="w-12 h-12 rounded-full bg-red-500 flex items-center justify-center text-white shrink-0 text-2xl">✕</div>
                <div>
                    <h4 class="font-bold text-red-900 text-lg">❌ Pengajuan Ditolak oleh Admin</h4>
                    <p class="text-red-700 text-sm mt-1">
                        Alasan penolakan: <strong class="block bg-white p-3 rounded-lg border border-red-200 mt-2">"{{ $profil->rejected_reason }}"</strong>
                    </p>
                    <p class="text-red-700 text-sm mt-2">Silakan perbaiki data Anda lalu ajukan ulang.</p>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-teal-50 border-2 border-teal-300 p-5 rounded-2xl flex items-center gap-4">
                <span class="text-2xl">✅</span>
                <p class="text-teal-900 font-bold">{{ session('success') }}</p>
            </div>
        @endif
        @if(session('warning'))
            <div class="bg-amber-50 border-2 border-amber-300 p-5 rounded-2xl flex items-center gap-4">
                <span class="text-2xl">⚠️</span>
                <p class="text-amber-900 font-bold">{{ session('warning') }}</p>
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border-2 border-red-300 p-5 rounded-2xl flex flex-col gap-2">
                <div class="flex items-center gap-4">
                    <span class="text-2xl">❌</span>
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
                        <h3 class="text-lg font-bold text-slate-800 border-b-2 border-teal-500 pb-3 mb-6">📝 Data Personal</h3>
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

                            <div>
                                <label for="alamat" class="block text-sm font-bold text-slate-700 mb-2">Alamat Domisili Lengkap</label>
                                <textarea name="alamat" id="alamat" rows="3" required
                                          class="w-full px-4 py-4 text-base bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-semibold text-slate-800 resize-none"
                                          {{ $isPending ? 'disabled' : '' }}>{{ old('alamat', $profil->alamat ?? '') }}</textarea>
                                @error('alamat')<p class="mt-2 text-sm font-bold text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Section: Kontak & WhatsApp --}}
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 border-b-2 border-indigo-500 pb-3 mb-6">📱 Nomor WhatsApp</h3>
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

                </div>

                {{-- Submit Area --}}
                <div class="bg-slate-50 border-t-2 border-slate-200 px-6 sm:px-8 py-6">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-sm text-slate-500 text-center sm:text-left">
                            ℹ️ Pastikan semua data asli. Setelah diajukan, data akan diperiksa oleh Admin KUA.
                        </p>
                        @if(!$isPending && !$isVerified)
                            <button type="submit" id="btn-submit-form"
                                    class="w-full sm:w-auto px-10 py-4 bg-teal-600 text-white rounded-xl font-bold text-base shadow-lg hover:bg-teal-700 active:scale-95 transition-all disabled:opacity-40 disabled:cursor-not-allowed">
                                📤 Ajukan Verifikasi Profil
                            </button>
                        @elseif($isPending)
                            <button type="button" disabled
                                    class="w-full sm:w-auto px-10 py-4 bg-slate-300 text-slate-600 rounded-xl font-bold text-base cursor-not-allowed">
                                ⏳ Dalam Proses Verifikasi Admin
                            </button>
                        @elseif($isVerified)
                            <a href="{{ route('pencarian.index') }}"
                               class="w-full sm:w-auto px-10 py-4 bg-green-600 text-white rounded-xl font-bold text-base text-center shadow-lg hover:bg-green-700 transition-all">
                                🔍 Mulai Pencarian Akta
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>
