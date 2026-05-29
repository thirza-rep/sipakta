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
        $waVerified = $profil && $profil->phone_verified_at !== null;
        $ktpUploaded = $profil && $profil->foto_ktp !== null;
        $allComplete = $emailVerified && $dataLengkap && $waVerified && $ktpUploaded;
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
                <div class="flex items-start gap-4 p-4 rounded-xl {{ $waVerified ? 'bg-green-50 border border-green-200' : 'bg-amber-50 border border-amber-200' }}">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 text-lg {{ $waVerified ? 'bg-green-500 text-white' : 'bg-amber-400 text-white' }}">
                        @if($waVerified) ✓ @else 3 @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-base {{ $waVerified ? 'text-green-800' : 'text-amber-800' }}">Verifikasi Nomor WhatsApp</h4>
                        <p class="text-sm {{ $waVerified ? 'text-green-700' : 'text-amber-700' }} mt-0.5">
                            @if($waVerified)
                                Nomor <strong>{{ $profil->no_telepon }}</strong> sudah terverifikasi via OTP WhatsApp.
                            @else
                                Masukkan nomor HP/WhatsApp aktif Anda, lalu tekan "Kirim OTP" untuk verifikasi.
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Step 4: KTP --}}
                <div class="flex items-start gap-4 p-4 rounded-xl {{ $ktpUploaded ? 'bg-green-50 border border-green-200' : 'bg-amber-50 border border-amber-200' }}">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 text-lg {{ $ktpUploaded ? 'bg-green-500 text-white' : 'bg-amber-400 text-white' }}">
                        @if($ktpUploaded) ✓ @else 4 @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-base {{ $ktpUploaded ? 'text-green-800' : 'text-amber-800' }}">Unggah Foto KTP</h4>
                        <p class="text-sm {{ $ktpUploaded ? 'text-green-700' : 'text-amber-700' }} mt-0.5">
                            @if($ktpUploaded)
                                Foto KTP sudah diunggah. Anda bisa mengganti jika diperlukan.
                            @else
                                Unggah foto KTP asli Anda (format JPG/PNG, maks 2MB).
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
                    <svg class="w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
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
                    <p class="text-red-700 text-sm mt-2">Silakan perbaiki data/foto KTP Anda lalu ajukan ulang.</p>
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
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <input type="text" name="no_telepon" id="no_telepon"
                                           value="{{ old('no_telepon', $profil->no_telepon ?? '') }}" required
                                           class="flex-1 px-4 py-4 text-base bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 font-semibold text-slate-800"
                                           placeholder="Contoh: 08123456789"
                                           {{ ($waVerified || $isPending) ? 'readonly' : '' }}>

                                    @if($waVerified)
                                        <span id="wa-verified-badge" class="inline-flex items-center gap-2 px-5 py-4 bg-green-100 text-green-800 border-2 border-green-300 rounded-xl font-bold text-sm whitespace-nowrap">
                                            ✓ Terverifikasi
                                        </span>
                                    @else
                                        <button type="button" id="btn-send-wa-otp"
                                                class="px-6 py-4 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 active:scale-95 transition-all whitespace-nowrap disabled:opacity-50 disabled:cursor-not-allowed">
                                            Kirim OTP
                                        </button>
                                    @endif
                                </div>

                                <p class="mt-2 text-sm text-slate-500" id="phone-meta-container">
                                    @if($waVerified)
                                        ✅ Nomor terverifikasi via OTP WhatsApp.
                                        @if(!$isPending)
                                            <button type="button" id="btn-change-phone" class="text-indigo-600 font-bold ml-1 hover:underline">Ganti Nomor</button>
                                        @endif
                                    @else
                                        Masukkan nomor WhatsApp aktif, lalu tekan "Kirim OTP" untuk verifikasi.
                                    @endif
                                </p>

                                @error('no_telepon')<p class="mt-2 text-sm font-bold text-red-600">{{ $message }}</p>@enderror

                                {{-- OTP Input Panel --}}
                                <div id="phone-otp-panel" class="hidden mt-4 bg-indigo-50 border-2 border-indigo-200 p-5 rounded-xl space-y-3">
                                    <label class="block text-sm font-bold text-indigo-800">Masukkan 6 Digit Kode OTP dari WhatsApp:</label>
                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <input type="text" id="phone-otp-code" maxlength="6" placeholder="______"
                                               class="w-full sm:w-40 text-center tracking-[0.5em] font-bold text-lg py-3 border-2 border-indigo-300 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500">
                                        <button type="button" id="btn-verify-wa-otp"
                                                class="px-6 py-3 bg-slate-800 text-white rounded-xl font-bold text-sm hover:bg-slate-700 transition-all">
                                            Verifikasi OTP
                                        </button>
                                    </div>
                                    <p id="wa-otp-msg" class="text-sm font-bold hidden"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Upload KTP --}}
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 border-b-2 border-amber-500 pb-3 mb-6">🪪 Foto Kartu Identitas (KTP)</h3>
                        <div class="space-y-4">
                            @if($ktpUploaded)
                                <div class="rounded-xl overflow-hidden border-2 border-slate-200 max-w-sm">
                                    <img src="{{ asset('storage/' . $profil->foto_ktp) }}" alt="Foto KTP" class="w-full h-48 object-cover">
                                    <div class="p-3 bg-slate-50 text-center">
                                        <a href="{{ asset('storage/' . $profil->foto_ktp) }}" target="_blank" class="text-sm text-indigo-600 font-bold hover:underline">Lihat Ukuran Penuh</a>
                                    </div>
                                </div>
                            @endif

                            @if(!$isPending)
                                <input type="file" name="foto_ktp" id="foto_ktp" {{ !$ktpUploaded ? 'required' : '' }}
                                       class="w-full px-4 py-4 bg-slate-50 border-2 border-dashed border-slate-300 rounded-xl text-base font-semibold text-slate-600 cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-teal-600 file:text-white file:font-bold file:cursor-pointer">
                                <p class="text-sm text-slate-500 mt-1">Format: JPG, JPEG, PNG — Ukuran maks. 2MB</p>
                            @else
                                <div class="p-4 bg-slate-100 border-2 border-slate-200 text-slate-500 text-sm font-bold rounded-xl text-center">
                                    🔒 Foto KTP terkunci — sedang dalam proses verifikasi
                                </div>
                            @endif

                            @error('foto_ktp')<p class="mt-2 text-sm font-bold text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Submit Area --}}
                <div class="bg-slate-50 border-t-2 border-slate-200 px-6 sm:px-8 py-6">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <p class="text-sm text-slate-500 text-center sm:text-left">
                            ℹ️ Pastikan semua data sesuai KTP asli. Setelah diajukan, data akan diperiksa oleh Admin KUA.
                        </p>
                        @if(!$isPending && !$isVerified)
                            <button type="submit"
                                    class="w-full sm:w-auto px-10 py-4 bg-teal-600 text-white rounded-xl font-bold text-base shadow-lg hover:bg-teal-700 active:scale-95 transition-all disabled:opacity-40 disabled:cursor-not-allowed"
                                    {{ !$allComplete ? 'disabled title=Lengkapi semua checklist di atas terlebih dahulu' : '' }}>
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

    {{-- Script AJAX untuk OTP WhatsApp --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btnSendOtp = document.getElementById('btn-send-wa-otp');
            const btnVerifyOtp = document.getElementById('btn-verify-wa-otp');
            const btnChangePhone = document.getElementById('btn-change-phone');
            const inputPhone = document.getElementById('no_telepon');
            const inputOtp = document.getElementById('phone-otp-code');
            const otpPanel = document.getElementById('phone-otp-panel');
            const otpMsg = document.getElementById('wa-otp-msg');
            const phoneMeta = document.getElementById('phone-meta-container');

            if (btnSendOtp) {
                btnSendOtp.addEventListener('click', async () => {
                    const phone = inputPhone.value.trim();
                    if (!phone) { alert('Masukkan nomor WhatsApp terlebih dahulu.'); return; }

                    btnSendOtp.disabled = true;
                    btnSendOtp.textContent = 'Mengirim...';
                    otpMsg.classList.add('hidden');

                    try {
                        const response = await fetch("{{ route('profil-pemohon.send-otp') }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                            body: JSON.stringify({ no_telepon: phone })
                        });
                        const result = await response.json();

                        if (response.ok && result.success) {
                            otpPanel.classList.remove('hidden');
                            let cooldown = 60;
                            btnSendOtp.disabled = true;
                            const interval = setInterval(() => {
                                cooldown--;
                                btnSendOtp.textContent = `Tunggu (${cooldown}s)`;
                                if (cooldown <= 0) { clearInterval(interval); btnSendOtp.textContent = 'Kirim OTP'; btnSendOtp.disabled = false; }
                            }, 1000);
                            showMsg('Kode OTP dikirim ke WhatsApp ' + phone + '. Cek pesan Anda.', 'text-indigo-700');
                        } else {
                            btnSendOtp.textContent = 'Kirim OTP'; btnSendOtp.disabled = false;
                            showMsg(result.message || 'Gagal mengirim OTP.', 'text-red-600');
                        }
                    } catch (e) {
                        btnSendOtp.textContent = 'Kirim OTP'; btnSendOtp.disabled = false;
                        showMsg('Koneksi gagal. Coba lagi.', 'text-red-600');
                    }
                });
            }

            if (btnVerifyOtp) {
                btnVerifyOtp.addEventListener('click', async () => {
                    const phone = inputPhone.value.trim();
                    const otp = inputOtp.value.trim();
                    if (otp.length !== 6) { alert('Masukkan 6 digit kode OTP.'); return; }

                    btnVerifyOtp.disabled = true;
                    btnVerifyOtp.textContent = 'Memverifikasi...';

                    try {
                        const response = await fetch("{{ route('profil-pemohon.verify-otp') }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                            body: JSON.stringify({ no_telepon: phone, otp: otp })
                        });
                        const result = await response.json();

                        if (response.ok && result.success) {
                            window.location.reload();
                        } else {
                            btnVerifyOtp.textContent = 'Verifikasi OTP'; btnVerifyOtp.disabled = false;
                            showMsg(result.message || 'Kode OTP salah.', 'text-red-600');
                        }
                    } catch (e) {
                        btnVerifyOtp.textContent = 'Verifikasi OTP'; btnVerifyOtp.disabled = false;
                        showMsg('Gagal memverifikasi. Coba lagi.', 'text-red-600');
                    }
                });
            }

            if (btnChangePhone) {
                btnChangePhone.addEventListener('click', () => {
                    if (confirm('Mengganti nomor WhatsApp akan mereset verifikasi. Anda harus verifikasi ulang. Lanjutkan?')) {
                        inputPhone.removeAttribute('readonly');
                        const badge = document.getElementById('wa-verified-badge');
                        if (badge) {
                            const btn = document.createElement('button');
                            btn.type = 'button'; btn.id = 'btn-send-wa-otp';
                            btn.className = 'px-6 py-4 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 active:scale-95 transition-all whitespace-nowrap';
                            btn.textContent = 'Kirim OTP';
                            badge.parentNode.replaceChild(btn, badge);
                            btn.addEventListener('click', () => { if(btnSendOtp) btnSendOtp.click(); });
                        }
                        phoneMeta.textContent = 'Masukkan nomor WhatsApp baru lalu verifikasi.';
                        btnChangePhone.remove();
                    }
                });
            }

            function showMsg(text, colorClass) {
                otpMsg.className = `text-sm font-bold mt-2 ${colorClass}`;
                otpMsg.textContent = text;
                otpMsg.classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>
