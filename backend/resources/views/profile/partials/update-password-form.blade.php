<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-8">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="col-span-full">
                <label for="update_password_current_password" class="block text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-2">Password Saat Ini</label>
                <div class="relative max-w-md">
                    <input id="update_password_current_password" name="current_password" type="password"
                           class="w-full px-6 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-bold text-slate-700 pr-14">
                    <button type="button" onclick="togglePasswordProfile('update_password_current_password')" class="absolute inset-y-0 right-0 flex items-center pr-5 text-slate-300 hover:text-teal-600 transition-colors">
                        <svg id="update_password_current_password-eye" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg id="update_password_current_password-eye-off" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                    </button>
                </div>
                @error('current_password', 'updatePassword')<p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-wider">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="update_password_password" class="block text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-2">Password Baru</label>
                <div class="relative">
                    <input id="update_password_password" name="password" type="password"
                           class="w-full px-6 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-bold text-slate-700 pr-14">
                    <button type="button" onclick="togglePasswordProfile('update_password_password')" class="absolute inset-y-0 right-0 flex items-center pr-5 text-slate-300 hover:text-teal-600 transition-colors">
                        <svg id="update_password_password-eye" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg id="update_password_password-eye-off" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                    </button>
                </div>
                @error('password', 'updatePassword')<p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-wider">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="update_password_password_confirmation" class="block text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-2">Konfirmasi Password Baru</label>
                <div class="relative">
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                           class="w-full px-6 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-bold text-slate-700 pr-14">
                    <button type="button" onclick="togglePasswordProfile('update_password_password_confirmation')" class="absolute inset-y-0 right-0 flex items-center pr-5 text-slate-300 hover:text-teal-600 transition-colors">
                        <svg id="update_password_password_confirmation-eye" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg id="update_password_password_confirmation-eye-off" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-6 pt-6">
            <button type="submit" class="px-10 py-4 bg-teal-600 text-white rounded-2xl font-black shadow-xl shadow-teal-100 hover:bg-teal-700 transition active:scale-95">
                PERBARUI PASSWORD
            </button>
            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                     class="flex items-center text-teal-600 font-black text-[10px] uppercase tracking-[0.2em]">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Berhasil Diubah!
                </div>
            @endif
        </div>
    </form>

    <script>
        function togglePasswordProfile(inputId) {
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
</section>
