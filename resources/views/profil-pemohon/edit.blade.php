<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Profil Pemohon</h2>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-0.5">Kelola Informasi Identitas Anda</p>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8 space-y-12 pb-32">
        {{-- Profile Header Card --}}
        <div class="bg-teal-900 rounded-[3.5rem] p-10 md:p-14 shadow-2xl relative overflow-hidden text-white group">
            <div class="absolute top-0 right-0 p-16 opacity-[0.03] pointer-events-none group-hover:scale-110 transition-transform duration-700">
                <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </div>
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-10">
                <div class="w-24 h-24 rounded-[2.5rem] bg-white text-teal-900 flex items-center justify-center font-black text-4xl shadow-2xl transform rotate-3 group-hover:-rotate-3 transition-transform duration-700">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-4xl font-black tracking-tight leading-tight">{{ $user->name }}</h1>
                    <div class="flex items-center gap-4 mt-3">
                        <span class="px-5 py-2 bg-white/10 backdrop-blur-md rounded-xl text-[10px] font-black uppercase tracking-widest border border-white/10">AKUN PEMOHON</span>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 {{ $profil && $profil->status === 'verified' ? 'bg-emerald-400' : 'bg-amber-400' }} rounded-full animate-pulse"></div>
                            <span class="text-teal-300 font-bold text-[10px] uppercase tracking-widest">
                                STATUS: {{ $profil ? strtoupper($profil->status) : 'BELUM LENGKAP' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Verification & Status Alerts --}}
        @if($profil)
            @if($profil->status === 'unverified')
                <div class="bg-amber-50 border-l-4 border-amber-500 p-6 rounded-2xl shadow-sm flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-black text-amber-900 text-sm uppercase tracking-wide">Profil Belum Terverifikasi</h4>
                        <p class="text-amber-700 text-xs mt-1">Silakan lengkapi formulir di bawah ini, pastikan NIK valid, nomor WhatsApp terverifikasi via OTP, dan unggah foto KTP asli Anda, kemudian ajukan untuk diverifikasi oleh petugas KUA.</p>
                    </div>
                </div>
            @elseif($profil->status === 'pending_verification')
                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-2xl shadow-sm flex items-start gap-4 animate-pulse">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                        <svg class="w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-black text-blue-900 text-sm uppercase tracking-wide">Menunggu Verifikasi Petugas KUA</h4>
                        <p class="text-blue-700 text-xs mt-1">Berkas pendaftaran Anda telah berhasil diajukan dan saat ini sedang ditinjau secara manual oleh Admin/Petugas KUA. Anda belum dapat menggunakan fitur pencarian akta nikah sebelum status disetujui.</p>
                    </div>
                </div>
            @elseif($profil->status === 'verified')
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-6 rounded-2xl shadow-sm flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <div>
                        <h4 class="font-black text-emerald-900 text-sm uppercase tracking-wide">Profil Terverifikasi Resmi</h4>
                        <p class="text-emerald-700 text-xs mt-1">Selamat! Akun Anda telah sukses diverifikasi oleh petugas KUA. Seluruh fitur pencarian akta nikah keluarga sekarang dapat diakses secara penuh.</p>
                    </div>
                </div>
            @elseif($profil->status === 'rejected')
                <div class="bg-rose-50 border-l-4 border-rose-500 p-6 rounded-2xl shadow-sm flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                    </div>
                    <div>
                        <h4 class="font-black text-rose-900 text-sm uppercase tracking-wide">Pengajuan Verifikasi Ditolak</h4>
                        <p class="text-rose-700 text-xs mt-1">Maaf, berkas verifikasi Anda ditolak oleh petugas KUA karena alasan berikut:<br>
                            <strong class="text-rose-950 font-bold block mt-1 bg-white/50 p-3 rounded-lg border border-rose-200">"{{ $profil->rejected_reason }}"</strong>
                            Silakan lakukan koreksi data atau unggah ulang foto KTP yang lebih jelas untuk mengajukan verifikasi kembali.
                        </p>
                    </div>
                </div>
            @endif
        @else
            <div class="bg-amber-50 border-l-4 border-amber-500 p-6 rounded-2xl shadow-sm flex items-start gap-4">
                <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h4 class="font-black text-amber-900 text-sm uppercase tracking-wide">Profil Belum Lengkap</h4>
                    <p class="text-amber-700 text-xs mt-1">Lengkapi data diri Anda terlebih dahulu. Pastikan NIK Anda valid, verifikasi WhatsApp Anda, dan unggah foto KTP guna memverifikasi identitas Anda untuk akses pencarian data akta.</p>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-teal-50 border-l-4 border-teal-500 p-6 rounded-2xl shadow-sm animate-fade-in flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                </div>
                <p class="text-teal-900 font-bold">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-[4rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <form method="POST" action="{{ route('profil-pemohon.update') }}" enctype="multipart/form-data" class="p-10 md:p-16 space-y-12">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    {{-- Identity Section --}}
                    <div class="space-y-10">
                        <div class="flex items-center gap-4 mb-2">
                            <span class="w-1.5 h-6 bg-teal-600 rounded-full"></span>
                            <h3 class="text-xl font-black text-slate-900">Data Personal</h3>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label for="nama_lengkap" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Nama Lengkap Sesuai KTP</label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" 
                                       value="{{ old('nama_lengkap', $profil->nama_lengkap ?? $user->name) }}" required
                                       class="w-full pl-6 pr-6 py-5 bg-slate-50 border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-black text-slate-700 shadow-inner"
                                       {{ $profil && $profil->status === 'pending_verification' ? 'disabled' : '' }}>
                                @error('nama_lengkap')
                                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nik" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Nomor Induk Kependudukan (NIK)</label>
                                <input type="text" name="nik" id="nik" maxlength="16"
                                       value="{{ old('nik', $profil->nik ?? '') }}" required
                                       class="w-full pl-6 pr-6 py-5 bg-slate-50 border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-black text-slate-700 shadow-inner"
                                       placeholder="16 digit angka KTP"
                                       {{ $profil && $profil->status === 'pending_verification' ? 'disabled' : '' }}>
                                @error('nik')
                                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="foto_ktp" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Foto KTP / Kartu Identitas</label>
                                @if($profil && $profil->foto_ktp)
                                    <div class="mb-4 relative rounded-[1.5rem] overflow-hidden border border-slate-100 shadow-sm max-w-xs group">
                                        <img src="{{ asset('storage/' . $profil->foto_ktp) }}" alt="Foto KTP" class="w-full h-40 object-cover">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <a href="{{ asset('storage/' . $profil->foto_ktp) }}" target="_blank" class="px-4 py-2 bg-white text-slate-900 rounded-lg text-xs font-bold shadow-lg">Lihat Ukuran Penuh</a>
                                        </div>
                                    </div>
                                @endif
                                
                                @if(!$profil || $profil->status !== 'pending_verification')
                                    <input type="file" name="foto_ktp" id="foto_ktp" {{ !$profil || !$profil->foto_ktp ? 'required' : '' }}
                                           class="w-full pl-6 pr-6 py-4 bg-slate-50 border border-slate-200 border-dashed rounded-[1.5rem] focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-bold text-slate-500 cursor-pointer">
                                    <p class="mt-2 text-[9px] text-slate-400 font-bold uppercase tracking-wider ml-1">Format: JPG, JPEG, PNG (Maks. 2MB)</p>
                                @else
                                    <div class="p-4 bg-slate-50 border border-slate-100 text-slate-400 text-xs font-bold rounded-[1.5rem] uppercase tracking-wide text-center">
                                        Berkas KTP Terkunci (Sedang Diverifikasi)
                                    </div>
                                @endif
                                
                                @error('foto_ktp')
                                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Contact Section --}}
                    <div class="space-y-10">
                        <div class="flex items-center gap-4 mb-2">
                            <span class="w-1.5 h-6 bg-indigo-600 rounded-full"></span>
                            <h3 class="text-xl font-black text-slate-900">Kontak & Alamat</h3>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label for="no_telepon" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Nomor Telepon/WhatsApp</label>
                                <div class="flex gap-4">
                                    <div class="relative group flex-1">
                                        <input type="text" name="no_telepon" id="no_telepon" 
                                               value="{{ old('no_telepon', $profil->no_telepon ?? '') }}" required
                                               class="w-full pl-14 pr-6 py-5 bg-slate-50 border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-black text-slate-700 shadow-inner"
                                               placeholder="08xxxxxxxxxx"
                                               {{ ($profil && $profil->phone_verified_at) || ($profil && $profil->status === 'pending_verification') ? 'readonly' : '' }}>
                                        <div class="absolute left-6 top-5 text-slate-300 group-focus-within:text-indigo-600 transition-colors">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5.25a.75.75 0 00-1.5 0v13.5a.75.75 0 001.5 0V5.25zM21 5.25a.75.75 0 00-1.5 0v13.5a.75.75 0 001.5 0V5.25zM15.75 9h-7.5a.75.75 0 000 1.5h7.5a.75.75 0 000-1.5zM15.75 13.5h-7.5a.75.75 0 000 1.5h7.5a.75.75 0 000-1.5z" /></svg>
                                        </div>
                                    </div>
                                    
                                    <div class="shrink-0 flex items-center">
                                        @if($profil && $profil->phone_verified_at)
                                            <span id="wa-verified-badge" class="px-5 py-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-[1.5rem] text-[10px] font-black uppercase tracking-wider flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                AKTIF
                                            </span>
                                        @else
                                            <button type="button" id="btn-send-wa-otp"
                                                    class="px-6 py-5 bg-indigo-600 text-white rounded-[1.5rem] text-[10px] font-black uppercase tracking-wider hover:bg-indigo-700 active:scale-95 transition-all shadow-lg shadow-indigo-600/20 disabled:opacity-50">
                                                Kirim OTP
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                
                                <p class="mt-2 text-[9px] font-bold text-slate-400 uppercase tracking-wider ml-1" id="phone-meta-container">
                                    @if($profil && $profil->phone_verified_at)
                                        Diverifikasi via WhatsApp
                                        @if($profil->status !== 'pending_verification')
                                            <button type="button" id="btn-change-phone" class="text-indigo-600 ml-2 hover:underline focus:outline-none">Ubah Nomor</button>
                                        @endif
                                    @else
                                        Kirim OTP untuk memverifikasi nomor handphone Anda.
                                    @endif
                                </p>
                                
                                @error('no_telepon')
                                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider ml-1">{{ $message }}</p>
                                @enderror

                                {{-- OTP Input Panel (Hidden by default) --}}
                                <div id="phone-otp-panel" class="hidden mt-6 bg-slate-50 border border-slate-200/60 p-6 rounded-[1.5rem] space-y-4">
                                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Masukkan 6 Digit OTP WhatsApp</label>
                                    <div class="flex gap-4">
                                        <input type="text" id="phone-otp-code" maxlength="6" placeholder="******" 
                                               class="w-36 text-center tracking-[0.5em] font-black text-lg py-3 border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500">
                                        <button type="button" id="btn-verify-wa-otp"
                                                class="px-6 bg-slate-900 text-white text-[10px] font-black uppercase tracking-wider rounded-xl hover:bg-slate-800 transition-all">
                                            Verifikasi OTP
                                        </button>
                                    </div>
                                    <p id="wa-otp-msg" class="text-[9px] font-bold uppercase tracking-wider ml-1 hidden"></p>
                                </div>
                            </div>

                            <div>
                                <label for="alamat" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Alamat Domisili Lengkap</label>
                                <textarea name="alamat" id="alamat" rows="3" required
                                          class="w-full pl-6 pr-6 py-5 bg-slate-50 border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-black text-slate-700 shadow-inner resize-none"
                                          {{ $profil && $profil->status === 'pending_verification' ? 'disabled' : '' }}>{{ old('alamat', $profil->alamat ?? '') }}</textarea>
                                @error('alamat')
                                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between gap-8 pt-12 border-t border-slate-50">
                    <div class="flex items-center gap-4 text-slate-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="text-[10px] font-bold uppercase tracking-widest leading-loose">Pastikan semua data sesuai dengan KTP asli untuk<br>memudahkan verifikasi di Kantor KUA.</p>
                    </div>
                    
                    <div class="flex items-center gap-6 w-full md:w-auto">
                        @if(!$profil || $profil->status !== 'pending_verification')
                            <button type="submit" 
                                    class="flex-1 md:flex-none px-12 py-5 bg-slate-900 text-white rounded-2xl font-black shadow-2xl shadow-slate-900/20 hover:bg-teal-600 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                                AJUKAN VERIFIKASI PROFIL
                            </button>
                        @else
                            <button type="button" disabled
                                    class="flex-1 md:flex-none px-12 py-5 bg-slate-300 text-slate-500 rounded-2xl font-black uppercase tracking-widest text-[10px] cursor-not-allowed">
                                DALAM VERIFIKASI ADMIN
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Script AJAX untuk pengiriman dan verifikasi OTP WhatsApp -->
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
                    if (!phone) {
                        alert('Silakan masukkan nomor telepon/WhatsApp terlebih dahulu.');
                        return;
                    }

                    btnSendOtp.disabled = true;
                    btnSendOtp.textContent = 'Mengirim...';
                    otpMsg.classList.add('hidden');

                    try {
                        const response = await fetch("{{ route('profil-pemohon.send-otp') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ no_telepon: phone })
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            otpPanel.classList.remove('hidden');
                            btnSendOtp.textContent = 'Kirim Ulang';
                            btnSendOtp.disabled = false;
                            
                            // Countdown cooldown to resend (60s)
                            let cooldown = 60;
                            btnSendOtp.disabled = true;
                            const cooldownInterval = setInterval(() => {
                                cooldown--;
                                btnSendOtp.textContent = `Kirim (${cooldown}s)`;
                                if (cooldown <= 0) {
                                    clearInterval(cooldownInterval);
                                    btnSendOtp.textContent = 'Kirim OTP';
                                    btnSendOtp.disabled = false;
                                }
                            }, 1000);

                            showMsg('Kode OTP telah dikirim melalui WhatsApp ke ' + phone + '. Silakan cek pesan Anda (atau laravel.log di server local).', 'text-indigo-600');
                        } else {
                            btnSendOtp.textContent = 'Kirim OTP';
                            btnSendOtp.disabled = false;
                            showMsg(result.message || 'Gagal mengirim OTP.', 'text-red-500');
                        }
                    } catch (error) {
                        btnSendOtp.textContent = 'Kirim OTP';
                        btnSendOtp.disabled = false;
                        showMsg('Koneksi bermasalah. Gagal menghubungi server.', 'text-red-500');
                    }
                });
            }

            if (btnVerifyOtp) {
                btnVerifyOtp.addEventListener('click', async () => {
                    const phone = inputPhone.value.trim();
                    const otp = inputOtp.value.trim();

                    if (otp.length !== 6) {
                        alert('Harap masukkan 6 digit kode OTP secara lengkap.');
                        return;
                    }

                    btnVerifyOtp.disabled = true;
                    btnVerifyOtp.textContent = 'Memverifikasi...';

                    try {
                        const response = await fetch("{{ route('profil-pemohon.verify-otp') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ no_telepon: phone, otp: otp })
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            // Reload page to reflect verified state or dynamically change DOM
                            window.location.reload();
                        } else {
                            btnVerifyOtp.textContent = 'Verifikasi OTP';
                            btnVerifyOtp.disabled = false;
                            showMsg(result.message || 'Kode OTP salah.', 'text-red-500');
                        }
                    } catch (error) {
                        btnVerifyOtp.textContent = 'Verifikasi OTP';
                        btnVerifyOtp.disabled = false;
                        showMsg('Terjadi kesalahan verifikasi.', 'text-red-500');
                    }
                });
            }

            if (btnChangePhone) {
                btnChangePhone.addEventListener('click', () => {
                    if (confirm('Mengubah nomor telepon akan mereset status verifikasi Anda. Anda harus memverifikasi nomor baru sebelum dapat menyimpan profil. Lanjutkan?')) {
                        // We will call a soft-reset on the frontend
                        inputPhone.removeAttribute('readonly');
                        // Replace the badge with Send OTP button
                        const verifiedBadge = document.getElementById('wa-verified-badge');
                        if (verifiedBadge) {
                            const newBtn = document.createElement('button');
                            newBtn.type = 'button';
                            newBtn.id = 'btn-send-wa-otp';
                            newBtn.className = 'px-6 py-5 bg-indigo-600 text-white rounded-[1.5rem] text-[10px] font-black uppercase tracking-wider hover:bg-indigo-700 active:scale-95 transition-all shadow-lg shadow-indigo-600/20';
                            newBtn.textContent = 'Kirim OTP';
                            verifiedBadge.parentNode.replaceChild(newBtn, verifiedBadge);
                            
                            // Re-bind click event
                            newBtn.addEventListener('click', async () => {
                                // Trigger send event
                                btnSendOtp.click(); 
                            });
                        }
                        phoneMeta.textContent = 'Masukkan nomor WhatsApp baru Anda dan lakukan verifikasi.';
                        btnChangePhone.remove();
                    }
                });
            }

            function showMsg(text, colorClass) {
                otpMsg.className = `text-[9px] font-bold uppercase tracking-wider ml-1 mt-2 ${colorClass}`;
                otpMsg.textContent = text;
                otpMsg.classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>
