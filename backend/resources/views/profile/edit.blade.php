    <div class="px-4 sm:px-6 lg:px-8 py-12">
        {{-- Glass Header --}}
        <div class="mb-12 bg-white/40 backdrop-blur-xl border border-white/20 p-8 rounded-[3rem] shadow-xl shadow-slate-200/50 flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-[2rem] bg-indigo-600 flex items-center justify-center text-white mr-6 shadow-xl shadow-indigo-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Profil Saya</h1>
                    <p class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.2em] mt-1">Pengaturan Akun & Keamanan</p>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-indigo-50 rounded-2xl border border-indigo-100">
                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest block mb-1">Status Akun</span>
                <span class="text-sm font-black text-indigo-900 block flex items-center">
                    <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2 animate-pulse"></span>
                    TER-VERIFIKASI
                </span>
            </div>
        </div>

        <div class="max-w-4xl mx-auto space-y-12">
            {{-- Update Profile --}}
            <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-indigo-600/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10">
                    <div class="mb-8">
                        <h3 class="text-xl font-black text-slate-900 mb-2">Informasi Profil</h3>
                        <p class="text-slate-400 font-medium text-sm">Perbarui informasi dasar akun dan alamat email Anda.</p>
                    </div>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div class="bg-white rounded-[3rem] p-10 border border-slate-100 shadow-sm relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-teal-600/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10">
                    <div class="mb-8">
                        <h3 class="text-xl font-black text-slate-900 mb-2">Ubah Password</h3>
                        <p class="text-slate-400 font-medium text-sm">Gunakan kata sandi yang kuat untuk menjaga keamanan akun Anda.</p>
                    </div>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="bg-slate-950 rounded-[3rem] p-10 shadow-2xl shadow-slate-200 relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-red-600/10 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10">
                    <div class="mb-8">
                        <h3 class="text-xl font-black text-white mb-2">Hapus Akun</h3>
                        <p class="text-slate-500 font-medium text-sm">Tindakan ini permanen. Seluruh data Anda akan dihapus selamanya.</p>
                    </div>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
