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

                {{-- Action Area (PDF) --}}
                <div class="mt-12 flex flex-col items-center">
                    <a href="{{ route('pencarian.cetak-pdf', $arsip->id) }}" target="_blank"
                       class="w-full md:w-auto px-10 py-5 bg-teal-600 text-white rounded-xl font-bold text-lg hover:bg-teal-700 transition active:scale-95 shadow-lg flex items-center justify-center gap-3">
                        <span class="text-2xl">🖨️</span> Cetak Salinan Bukti Pencarian (PDF)
                    </a>
                    <p class="text-sm text-slate-500 font-medium mt-4 text-center">
                        Cetak dokumen ini sebagai bukti awal bahwa data arsip telah ditemukan di sistem.
                    </p>
                </div>
            </div>
        </div>

        {{-- Info Box Penting --}}
        <div class="bg-amber-50 border-2 border-amber-200 rounded-2xl p-6 md:p-8 flex gap-6 items-start">
            <span class="text-4xl">⚠️</span>
            <div>
                <h4 class="text-lg font-bold text-amber-900 mb-2">Prosedur Pengambilan Dokumen Resmi</h4>
                <p class="text-amber-800 font-medium leading-relaxed text-base">
                    Salinan PDF dari sistem ini <strong>bukanlah pengganti Akta Nikah resmi</strong>. 
                    Jika Anda membutuhkan kutipan akta nikah fisik berlegalisir, Anda <strong>wajib</strong> datang langsung ke Kantor KUA Kemantren Tegalrejo. Jangan lupa membawa KTP asli dan menunjukkan hasil cetak pencarian ini (atau menyebutkan Nomor Akta) kepada petugas loket.
                </p>
            </div>
        </div>

    </div>
</x-app-layout>
