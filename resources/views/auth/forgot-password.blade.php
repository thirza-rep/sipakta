<x-guest-layout>
    <h2 class="text-xl font-bold text-teal-800 text-center mb-2">Lupa Password?</h2>
    <p class="text-sm text-gray-600 text-center mb-4">Masukkan email Anda untuk reset password.</p>
    
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
            @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="w-full bg-teal-700 text-white py-2 rounded-lg font-semibold hover:bg-teal-600 transition shadow">
            Kirim Link Reset
        </button>
        
        <p class="text-center text-sm mt-4">
            <a href="{{ route('login') }}" class="text-teal-600 font-semibold hover:underline">← Kembali ke login</a>
        </p>
    </form>
</x-guest-layout>
