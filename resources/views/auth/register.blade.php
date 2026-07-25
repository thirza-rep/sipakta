<x-guest-layout>
    <h2 class="text-2xl font-bold text-teal-800 text-center mb-6">Daftar Akun Pemohon</h2>
    <p class="text-slate-500 text-sm text-center mb-6">Buat akun untuk mencari arsip akta nikah keluarga Anda</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-5">
            <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="w-full border-2 border-slate-200 rounded-xl px-4 py-4 text-base focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-semibold">
            @error('name')<p class="text-red-600 text-sm font-bold mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-5">
            <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                   class="w-full border-2 border-slate-200 rounded-xl px-4 py-4 text-base focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-semibold">
            @error('email')<p class="text-red-600 text-sm font-bold mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-5">
            <label for="password" class="block text-sm font-bold text-slate-700 mb-2">Kata Sandi</label>
            <div class="relative">
                <input id="password" type="password" name="password" required
                       class="w-full border-2 border-slate-200 rounded-xl px-4 py-4 text-base pr-12 focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-semibold">
                <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-600">
                    <svg id="password-eye" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg id="password-eye-off" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            @error('password')<p class="text-red-600 text-sm font-bold mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-2">Ulangi Kata Sandi</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   class="w-full border-2 border-slate-200 rounded-xl px-4 py-4 text-base focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-semibold">
        </div>

        <button type="submit" class="w-full bg-teal-600 text-white py-4 rounded-xl font-bold text-base flex items-center justify-center hover:bg-teal-700 transition shadow-lg active:scale-[0.98]">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            Daftar Sekarang
        </button>

        <p class="text-center text-sm text-slate-600 mt-5 font-semibold">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-teal-600 font-bold hover:underline">Masuk di sini</a>
        </p>
    </form>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const eyeIcon = document.getElementById(inputId + '-eye');
            const eyeOffIcon = document.getElementById(inputId + '-eye-off');
            if (input.type === 'password') {
                input.type = 'text'; eyeIcon.classList.add('hidden'); eyeOffIcon.classList.remove('hidden');
            } else {
                input.type = 'password'; eyeIcon.classList.remove('hidden'); eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
</x-guest-layout>
