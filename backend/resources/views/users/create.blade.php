<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <a href="{{ route('users.index') }}" class="w-12 h-12 rounded-2xl bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-all active:scale-90 shadow-lg shadow-black/5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h2 class="text-2xl font-black text-white tracking-tight">Tambah Pengguna</h2>
                <p class="text-indigo-100/60 text-[10px] font-bold uppercase tracking-[0.2em] mt-0.5">Inisialisasi Akun Sistem Baru</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8 space-y-12 pb-32">
        {{-- Hero Section --}}
        <div class="bg-indigo-900 rounded-[3.5rem] p-10 md:p-14 shadow-2xl relative overflow-hidden text-white">
            <div class="absolute top-0 right-0 p-16 opacity-[0.03] pointer-events-none">
                <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
            </div>
            <div class="relative z-10 flex items-center gap-8">
                <div class="w-20 h-20 rounded-[2.5rem] bg-indigo-500 flex items-center justify-center text-white shadow-2xl shadow-indigo-500/40 transform -rotate-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" /></svg>
                </div>
                <div>
                    <h1 class="text-4xl font-black tracking-tight leading-tight">Registrasi<br>Akun Baru</h1>
                    <p class="text-indigo-300 font-bold text-[10px] uppercase tracking-[0.4em] mt-2">Personal Data & Security Setup</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[4rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <form method="POST" action="{{ route('users.store') }}" class="p-10 md:p-16 space-y-12">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    {{-- Left Column: Identity --}}
                    <div class="space-y-10">
                        <div class="flex items-center gap-4 mb-2">
                            <span class="w-1.5 h-6 bg-indigo-600 rounded-full"></span>
                            <h3 class="text-xl font-black text-slate-900">Identitas Diri</h3>
                        </div>

                        <div class="space-y-6">
                            {{-- Name --}}
                            <div>
                                <label for="name" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                                <div class="relative group">
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                           class="w-full pl-6 pr-6 py-5 bg-slate-50 border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-black text-slate-700 placeholder:text-slate-300"
                                           placeholder="Contoh: Ahmad Fauzi">
                                    @error('name')
                                        <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider ml-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Alamat Email</label>
                                <div class="relative group">
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                           class="w-full pl-6 pr-6 py-5 bg-slate-50 border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-black text-slate-700 placeholder:text-slate-300"
                                           placeholder="ahmad@kua.go.id">
                                    @error('email')
                                        <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider ml-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Role --}}
                            <div>
                                <label for="role" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Otoritas Sistem</label>
                                <div class="relative group">
                                    <select name="role" id="role" required
                                            class="w-full pl-6 pr-12 py-5 bg-slate-50 border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-black text-slate-700 appearance-none">
                                        <option value="">-- PILIH ROLE --</option>
                                        @foreach($roles as $value => $label)
                                            <option value="{{ $value }}" {{ old('role') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-6 top-6 text-slate-300 pointer-events-none">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                                    </div>
                                    @error('role')
                                        <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider ml-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Security --}}
                    <div class="space-y-10">
                        <div class="flex items-center gap-4 mb-2">
                            <span class="w-1.5 h-6 bg-red-500 rounded-full"></span>
                            <h3 class="text-xl font-black text-slate-900">Keamanan</h3>
                        </div>

                        <div class="space-y-6">
                            {{-- Password --}}
                            <div class="group/field">
                                <label for="password" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Kata Sandi</label>
                                <div class="relative group">
                                    <input type="password" name="password" id="password" required
                                           class="w-full pl-14 pr-6 py-5 bg-slate-50 border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-red-500/10 focus:border-red-500 transition-all font-black text-slate-700 placeholder:text-slate-300"
                                           placeholder="••••••••">
                                    <div class="absolute left-6 top-6 text-slate-300 group-focus-within/field:text-red-500 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    </div>
                                    <button type="button" onclick="togglePassword('password')" class="absolute right-6 top-6 text-slate-300 hover:text-slate-600 transition-colors">
                                        <svg id="password-eye" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg id="password-eye-off" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    </button>
                                    @error('password')
                                        <p class="mt-2 text-[10px] font-bold text-red-500 uppercase tracking-wider ml-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Password Confirmation --}}
                            <div class="group/field2">
                                <label for="password_confirmation" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Ulangi Sandi</label>
                                <div class="relative group">
                                    <input type="password" name="password_confirmation" id="password_confirmation" required
                                           class="w-full pl-14 pr-14 py-5 bg-slate-50 border-slate-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-black text-slate-700 placeholder:text-slate-300"
                                           placeholder="••••••••">
                                    <div class="absolute left-6 top-6 text-slate-300 group-focus-within/field2:text-indigo-600 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
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
                        BATALKAN
                    </a>
                    <button type="submit" 
                            class="px-12 py-5 bg-indigo-900 text-white rounded-2xl font-black shadow-2xl shadow-indigo-900/20 hover:bg-slate-800 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                        SIMPAN PENGGUNA BARU
                    </button>
                </div>
            </form>
        </div>
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
