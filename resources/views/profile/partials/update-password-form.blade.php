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
