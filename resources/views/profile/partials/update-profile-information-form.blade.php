<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @csrf
        @method('patch')

        <div class="space-y-6">
            <div>
                <label for="name" class="block text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-2">Nama Lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                       class="w-full px-6 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold text-slate-700">
                @error('name')<p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-wider">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="block text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-2">Alamat Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-6 py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold text-slate-700">
                @error('email')<p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-wider">{{ $message }}</p>@enderror
            </div>
            
            <div class="flex items-center gap-6 pt-4">
                <button type="submit" class="px-10 py-4 bg-slate-900 text-white rounded-2xl font-black shadow-xl shadow-slate-200 hover:bg-slate-800 transition active:scale-95 group">
                    SIMPAN PERUBAHAN
                </button>
                @if (session('status') === 'profile-updated')
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                         class="flex items-center text-teal-600 font-black text-[10px] uppercase tracking-[0.2em]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Tersimpan!
                    </div>
                @endif
            </div>
        </div>
        
        <div class="bg-slate-50 rounded-[2rem] p-8 border border-slate-100 flex flex-col items-center justify-center text-center">
            <div class="w-32 h-32 rounded-full overflow-hidden shadow-xl shadow-slate-200 flex items-center justify-center text-4xl font-black text-slate-900 mb-4 border-4 border-white bg-white">
                @if($user->foto_profil)
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                @else
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                @endif
            </div>
            
            <div class="w-full max-w-xs mt-2 mb-6">
                <label for="foto_profil" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 cursor-pointer hover:text-indigo-600 transition">
                    Ubah Foto Profil (Opsional)
                </label>
                <input id="foto_profil" name="foto_profil" type="file" accept="image/jpeg,image/png,image/jpg"
                       class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                @error('foto_profil')<p class="text-red-500 text-[10px] font-bold mt-2 uppercase tracking-wider">{{ $message }}</p>@enderror
            </div>

            <h4 class="font-black text-slate-900 text-xl">{{ $user->name }}</h4>
            <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-widest">{{ $user->role_display }}</p>
        </div>
    </form>
</section>
