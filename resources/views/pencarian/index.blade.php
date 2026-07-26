<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-slate-900">
            Pencarian Arsip Akta Nikah
        </h2>
        <p class="text-slate-600 text-sm mt-1">Temukan salinan digital dokumen pernikahan Anda dengan cepat dan mudah.</p>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-10 pb-32 mt-8">
        
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-teal-700 p-8 text-white">
                <h3 class="text-2xl font-bold mb-2">Mulai Pencarian Dokumen</h3>
                <p class="text-teal-100 font-medium text-sm">Anda bisa mencari menggunakan salah satu informasi berikut:</p>
            </div>
            
            <div class="p-8">
                <form action="{{ route('pencarian.search') }}" method="GET" class="space-y-6">
                    <div>
                        <label for="keyword" class="block text-base font-bold text-slate-800 mb-3">Kata Kunci Pencarian</label>
                        <input type="text" name="keyword" id="keyword" required
                               class="w-full px-5 py-5 text-lg bg-slate-50 border-2 border-slate-300 rounded-xl focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-bold text-slate-900"
                               placeholder="Contoh: Nomor Akta, Nama Suami, atau Nama Istri...">
                        <p class="mt-3 text-sm text-slate-500 font-medium">Tips: Masukkan nomor akta nikah lengkap untuk hasil yang paling akurat.</p>
                    </div>

                    <div class="pt-4 border-t border-slate-200">
                        <button type="submit" class="w-full py-5 bg-teal-600 text-white rounded-xl font-bold text-xl hover:bg-teal-700 transition active:scale-[0.98] shadow-lg flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg> Cari Arsip Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6">
            <h4 class="font-bold text-blue-900 text-lg mb-2">Informasi Penting</h4>
            <p class="text-blue-800 font-medium leading-relaxed">
                Hasil pencarian arsip ini berupa data referensi digital. Jika Anda membutuhkan <strong>kutipan atau legalisir dokumen resmi</strong>, Anda tetap harus datang langsung ke Kantor KUA Kemantren Tegalrejo dengan membawa KTP asli.
            </p>
        </div>
    </div>
</x-app-layout>
