<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-slate-900">
                    Rincian Arsip Akta Nikah
                </h2>
                <p class="text-slate-600 text-sm mt-1">Detail informasi dari pencarian dokumen arsip digital</p>
            </div>
            
            <a href="{{ route('pencarian.search', ['keyword' => request('keyword')]) }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-slate-200 text-slate-700 rounded-xl font-bold hover:bg-slate-300 transition shadow-sm">
                ← Kembali ke Hasil
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto pb-32 mt-8 space-y-8">
        
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            {{-- Header Card --}}
            <div class="bg-slate-800 p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <span class="inline-block px-4 py-1.5 bg-teal-500/20 text-teal-300 rounded-lg font-bold text-sm border border-teal-500/30 mb-3">
                        AKTA NO: {{ $arsip->nomor_akta }}
                    </span>
                    <h3 class="text-2xl font-bold text-white">Data Otentik KUA Tegalrejo</h3>
                </div>
                @if($arsip->file_path)
                    <div class="px-5 py-3 bg-green-500/10 border border-green-500/30 rounded-xl flex items-center gap-3">
                        <span class="text-green-400 text-xl">✅</span>
                        <span class="text-green-300 font-bold text-sm">Arsip Digital Tersedia</span>
                    </div>
                @endif
            </div>

            {{-- Grid Info --}}
            <div class="p-6 md:p-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    {{-- Suami --}}
                    <div class="bg-slate-50 p-6 rounded-2xl border-2 border-slate-200">
                        <p class="text-sm font-bold text-slate-500 mb-2 uppercase tracking-wide">Identitas Suami</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $arsip->nama_suami }}</p>
                    </div>

                    {{-- Istri --}}
                    <div class="bg-slate-50 p-6 rounded-2xl border-2 border-slate-200">
                        <p class="text-sm font-bold text-slate-500 mb-2 uppercase tracking-wide">Identitas Istri</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $arsip->nama_istri }}</p>
                    </div>

                    {{-- Tanggal --}}
                    <div class="bg-slate-50 p-6 rounded-2xl border-2 border-slate-200">
                        <p class="text-sm font-bold text-slate-500 mb-2 uppercase tracking-wide">Tanggal Akad Nikah</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $arsip->tanggal_akad ? \Carbon\Carbon::parse($arsip->tanggal_akad)->translatedFormat('d F Y') : '-' }}</p>
                    </div>

                    {{-- Lokasi --}}
                    <div class="bg-slate-50 p-6 rounded-2xl border-2 border-slate-200">
                        <p class="text-sm font-bold text-slate-500 mb-2 uppercase tracking-wide">Lokasi Fisik Arsip</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $arsip->lokasi_fisik ?? '-' }}</p>
                    </div>

                </div>

                {{-- Action Area (Form Cetak PDF & Validasi) --}}
                <form action="{{ route('pencarian.cetak-pdf', $arsip->id) }}" method="GET" target="_blank" class="mt-12 bg-slate-50 p-6 md:p-8 rounded-2xl border-2 border-slate-200">
                    <h4 class="font-bold text-slate-800 text-lg mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Validasi & Alasan Pengambilan Dokumen
                    </h4>
                    
                    <div class="mb-6">
                        <label for="alasan_cetak" class="block text-sm font-bold text-slate-700 mb-2">Jelaskan Tujuan/Alasan Mengambil Salinan Arsip Fisik</label>
                        <textarea name="alasan_cetak" id="alasan_cetak" rows="2" required 
                                  class="w-full px-4 py-3 text-base bg-white border-2 border-slate-300 rounded-xl focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-medium text-slate-800 resize-none" 
                                  placeholder="Contoh: Mengurus pembuatan KK baru, syarat pensiun, dll."></textarea>
                    </div>

                    <div class="bg-amber-50 border-2 border-amber-200 rounded-xl p-5 mb-6">
                        <h5 class="font-bold text-amber-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Note: Persyaratan yang Wajib Dibawa ke KUA
                        </h5>
                        <ul class="list-disc list-inside text-amber-800 text-sm space-y-1.5 font-medium ml-2">
                            <li>KTP Asli Pemohon (Sesuai identitas Anda)</li>
                            <li>Fotokopi Kartu Keluarga (KK)</li>
                            <li>Hasil Cetak (Print Out) Salinan Bukti Pencarian ini</li>
                            <li>Surat Kuasa bermaterai (Jika pengambilan diwakilkan oleh pihak lain)</li>
                        </ul>
                    </div>

                    <div class="flex flex-col items-center">
                        <button type="submit" class="w-full px-10 py-4 bg-teal-600 text-white rounded-xl font-bold text-lg hover:bg-teal-700 transition active:scale-95 shadow-lg flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Cetak Salinan Bukti Pencarian (PDF)
                        </button>
                        <p class="text-sm text-slate-500 font-medium mt-3 text-center">
                            Cetak dokumen ini sebagai bukti awal bahwa data arsip telah ditemukan di sistem.
                        </p>
                    </div>
                </form>
            </div>
    </div>
</x-app-layout>
