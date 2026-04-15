<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <a href="{{ route('users.index') }}" class="w-12 h-12 rounded-2xl bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-all active:scale-90 shadow-lg shadow-black/5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h2 class="text-2xl font-black text-white tracking-tight">Edit Profil</h2>
                <p class="text-indigo-100/60 text-[10px] font-bold uppercase tracking-[0.2em] mt-0.5">Modifikasi Data Pengguna Sistem</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8 space-y-12 pb-32">
        {{-- Profile Header Card --}}
        <div class="bg-indigo-900 rounded-[3.5rem] p-10 md:p-14 shadow-2xl relative overflow-hidden text-white group">
            <div class="absolute top-0 right-0 p-16 opacity-[0.03] pointer-events-none group-hover:scale-110 transition-transform">
                <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
            </div>
            <div class="relative z-10 flex items-center gap-10">
                <div class="w-24 h-24 rounded-[2.5rem] bg-white text-indigo-900 flex items-center justify-center font-black text-4xl shadow-2xl transform -rotate-3 group-hover:rotate-3 transition-transform duration-700">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-4xl font-black tracking-tight leading-tight">{{ $user->name }}</h1>
                    <div class="flex items-center gap-4 mt-3">
                        <span class="px-5 py-2 bg-indigo-500/30 backdrop-blur-md rounded-xl text-[10px] font-black uppercase tracking-widest border border-white/10">{{ $user->role_display }}</span>
                        <span class="text-indigo-300 font-bold text-[10px] uppercase tracking-widest">ID: #{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-teal-50 border-l-4 border-teal-500 p-6 rounded-2xl shadow-sm animate-fade-in flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                </div>
                <p class="text-teal-900 font-bold">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-[4rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <form method="POST" action="{{ route('users.update', $user) }}" class="p-10 md:p-16 space-y-12">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    {{-- Identity --}}
                    <div class="space-y-10">
                        <div class="flex items-center gap-4 mb-2">
                            <span class="w-1.5 h-6 bg-indigo-600 rounded-full"></span>
                            <h3 class="text-xl font-black text-slate-900">Ubah Identitas</h3>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                       class="w-full pl-6 pr-6 py-5 bg-slate-50 border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-black text-slate-700">
                                @error('name')
                                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Email Aktif</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                       class="w-full pl-6 pr-6 py-5 bg-slate-50 border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-black text-slate-700">
                                @error('email')
                                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="role" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Otoritas Sistem</label>
                                <div class="relative">
                                    <select name="role" id="role" required
                                            {{ $user->id === auth()->id() ? 'disabled' : '' }}
                                            class="w-full pl-6 pr-12 py-5 bg-slate-50 border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-black text-slate-700 appearance-none disabled:opacity-50 disabled:cursor-not-allowed">
                                        @foreach($roles as $value => $label)
                                            <option value="{{ $value }}" {{ old('role', $user->role) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-6 top-6 text-slate-300 pointer-events-none">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                </div>
                                @if($user->id === auth()->id())
                                    <input type="hidden" name="role" value="{{ $user->role }}">
                                    <p class="mt-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-loose flex items-center gap-2">
                                        <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        Anda tidak dapat mengubah role sendiri.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Security --}}
                    <div class="space-y-10">
                        <div class="flex items-center gap-4 mb-2">
                            <span class="w-1.5 h-6 bg-red-500 rounded-full"></span>
                            <h3 class="text-xl font-black text-slate-900">Keamanan</h3>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label for="password" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Sandi Baru (Opsional)</label>
                                <div class="relative group/field">
                                    <input type="password" name="password" id="password"
                                           class="w-full pl-14 pr-6 py-5 bg-slate-50 border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-red-500/10 focus:border-red-500 transition-all font-black text-slate-700"
                                           placeholder="Kosongkan jika tetap">
                                    <div class="absolute left-6 top-6 text-slate-300 group-focus-within/field:text-red-500 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    </div>
                                    <button type="button" onclick="togglePassword('password')" class="absolute right-6 top-6 text-slate-300 hover:text-slate-600 transition-colors">
                                        <svg id="password-eye" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg id="password-eye-off" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="group/field2">
                                <label for="password_confirmation" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Konfirmasi Sandi Baru</label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="w-full pl-14 pr-14 py-5 bg-slate-50 border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-black text-slate-700"
                                           placeholder="Ulangi jika diubah">
                                    <div class="absolute left-6 top-6 text-slate-300 group-focus-within/field2:text-indigo-600 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7" /></svg>
                                    </div>
                                    <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-6 top-6 text-slate-300 hover:text-slate-600 transition-colors">
                                        <svg id="password_confirmation-eye" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg id="password_confirmation-eye-off" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-6 pt-12 border-t border-slate-50">
                    <a href="{{ route('users.index') }}" 
                       class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition-all">
                        ABAIKAN PERUBAHAN
                    </a>
                    <button type="submit" 
                            class="px-12 py-5 bg-indigo-900 text-white rounded-2xl font-black shadow-2xl shadow-indigo-900/20 hover:bg-slate-800 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                        SIMPAN PERUBAHAN PROFIL
                    </button>
                </div>
            </form>
        </div>

        {{-- Danger Zone Actions --}}
        @if($user->id !== auth()->id())
        <div class="bg-white rounded-[4rem] p-10 md:p-16 border border-red-50 shadow-xl shadow-red-100/30 overflow-hidden relative">
            <div class="absolute right-0 top-0 p-10 opacity-[0.05] text-red-600">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-12">
                <div class="space-y-6 max-w-xl">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center font-black border border-red-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight">Manajemen Akun Lanjutan</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex flex-col gap-1">
                            <span class="text-sm font-black text-slate-800">Status Keaktifan</span>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Akun saat ini sedang @if($user->is_active) <span class="text-teal-600">Beroperasi Penuh</span> @else <span class="text-red-500">Ditangguhkan</span> @endif</p>
                        </div>
                        <form method="POST" action="{{ route('users.toggle-active', $user) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full md:w-fit px-10 py-4 {{ $user->is_active ? 'bg-orange-50 text-orange-600 border border-orange-100 hover:bg-orange-600 hover:text-white' : 'bg-teal-50 text-teal-600 border border-teal-100 hover:bg-teal-600 hover:text-white' }} rounded-2xl font-black transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                                {{ $user->is_active ? 'NONAKTIFKAN AKSES' : 'AKTIFKAN KEMBALI' }}
                            </button>
                        </form>
                    </div>

                    <div class="pt-8 border-t border-slate-100 space-y-4">
                        <div class="flex flex-col gap-1">
                            <span class="text-sm font-black text-red-600">Hapus Permanen</span>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Semua data kaitan dengan akun ini akan dihapus selamanya.</p>
                        </div>
                        <form method="POST" action="{{ route('users.destroy', $user) }}" 
                              onsubmit="return confirm('Hapus profil ini selamanya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full md:w-fit px-10 py-4 bg-red-50 text-red-600 border border-red-100 hover:bg-red-600 hover:text-white rounded-2xl font-black transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                                HAPUS AKUN SELAMANYA
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const eyeIcon = document.getElementById(inputId + '-eye');
            const eyeOffIcon = document.getElementById(inputId + '-eye-off');
            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>
