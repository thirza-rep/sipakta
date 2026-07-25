<section>
    <div class="flex items-center justify-between">
        <div class="max-w-xl">
            <p class="text-slate-500 font-medium text-sm leading-relaxed">
                Setelah akun Anda dihapus, semua sumber daya dan data yang terkait akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.
            </p>
        </div>

        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="px-8 py-4 bg-red-600 text-white rounded-2xl font-black shadow-xl shadow-red-900/20 hover:bg-red-700 transition active:scale-95 whitespace-nowrap">
            HAPUS AKUN SAYA
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-10 bg-white rounded-[3rem]">
            @csrf
            @method('delete')

            <div class="mb-8">
                <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-2">Apakah Anda yakin?</h2>
                <p class="text-slate-400 font-medium">
                    Masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.
                </p>
            </div>

            <div class="mb-8">
                <label for="password" class="block text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-2">Konfirmasi Password</label>
                <div class="relative">
                    <input id="password" name="password" type="password" placeholder="••••••••"
                           class="w-full px-6 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-red-500/10 focus:border-red-500 transition-all font-bold text-slate-700 pr-14">
                    <button type="button" onclick="togglePasswordDelete('password')" class="absolute inset-y-0 right-0 flex items-center pr-5 text-slate-300 hover:text-red-600 transition-colors">
                        
                        
                    </button>
                </div>
                @error('password', 'userDeletion')<p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-wider">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-4">
                <button type="button" x-on:click="$dispatch('close')" class="flex-1 px-6 py-4 bg-slate-100 text-slate-400 rounded-2xl font-black hover:bg-slate-200 transition active:scale-95">
                    BATAL
                </button>
                <button type="submit" class="flex-1 px-6 py-4 bg-red-600 text-white rounded-2xl font-black shadow-xl shadow-red-100 hover:bg-red-700 transition active:scale-95">
                    HAPUS PERMANEN
                </button>
            </div>
        </form>
    </x-modal>

    <script>
        function togglePasswordDelete(inputId) {
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
