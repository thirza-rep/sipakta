<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold text-slate-900">
                    Dashboard SIPAKTA
                </h2>
                <p class="text-slate-600 text-sm mt-1">Sistem Informasi Pencarian dan Pengarsipan Akta Nikah</p>
            </div>
            <div class="px-5 py-3 bg-white border-2 border-slate-200 rounded-xl font-bold text-slate-700 shadow-sm text-sm">
                📅 {{ now()->translatedFormat('d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="space-y-10 pb-20">
        {{-- Statistik Ringkas --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Card 1 --}}
            <div class="bg-teal-700 rounded-2xl p-8 shadow-xl text-white">
                <div class="flex items-center gap-4 mb-4">
                    <span class="text-4xl">📂</span>
                    <h3 class="text-lg font-bold">Total Arsip Akta</h3>
                </div>
                <div class="text-5xl font-extrabold">{{ number_format(\App\Models\AktaNikah::count()) }}</div>
                <p class="mt-2 text-teal-200 font-medium text-sm">Dokumen pernikahan terdaftar di sistem</p>
            </div>

            {{-- Card 2 --}}
            <div class="bg-white border-2 border-slate-200 rounded-2xl p-8 shadow-sm">
                <div class="flex items-center gap-4 mb-4">
                    <span class="text-4xl">📅</span>
                    <h3 class="text-lg font-bold text-slate-800">Tahun {{ date('Y') }}</h3>
                </div>
                <div class="text-5xl font-extrabold text-slate-900">{{ number_format(\App\Models\AktaNikah::whereYear('tanggal_akad', date('Y'))->count()) }}</div>
                <p class="mt-2 text-slate-500 font-medium text-sm">Akta yang terdaftar tahun ini</p>
            </div>

            {{-- Card 3 --}}
            <div class="bg-white border-2 border-slate-200 rounded-2xl p-8 shadow-sm">
                <div class="flex items-center gap-4 mb-4">
                    <span class="text-4xl">🖨️</span>
                    <h3 class="text-lg font-bold text-slate-800">Tersedia Digital</h3>
                </div>
                <div class="text-5xl font-extrabold text-slate-900">{{ number_format(\App\Models\AktaNikah::whereNotNull('file_path')->count()) }}</div>
                <p class="mt-2 text-slate-500 font-medium text-sm">Arsip dengan salinan dokumen digital</p>
            </div>
        </div>

        {{-- Form Pencarian Cepat --}}
        <div class="bg-white p-6 rounded-2xl shadow-md border border-slate-200">
            <h3 class="text-lg font-bold text-slate-800 mb-4">🔍 Pencarian Cepat Akta Nikah</h3>
            <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Ketik Nama Suami / Istri atau Nomor Akta..."
                       class="flex-1 px-4 py-4 text-base bg-slate-50 border-2 border-slate-300 rounded-xl focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 font-semibold text-slate-800">
                
                <button type="submit" class="px-10 py-4 bg-teal-600 text-white rounded-xl font-bold text-base hover:bg-teal-700 transition active:scale-95 shadow-md">
                    Cari Sekarang
                </button>
                @if(request('search'))
                    <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-slate-200 text-slate-700 rounded-xl font-bold text-base hover:bg-slate-300 transition text-center">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Tabel Data --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-200 bg-slate-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h3 class="text-xl font-bold text-slate-800">Daftar Arsip Akta Nikah</h3>
                <span class="text-sm font-bold text-teal-700 bg-teal-100 px-4 py-2 rounded-lg">Menampilkan {{ $arsip->count() }} dari {{ $arsip->total() }} data</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-100 border-b-2 border-slate-200">
                            <th class="px-6 py-4 text-sm font-bold text-slate-700">Nomor Akta & Lokasi Fisik</th>
                            <th class="px-6 py-4 text-sm font-bold text-slate-700">Nama Pasangan (Suami & Istri)</th>
                            <th class="px-6 py-4 text-sm font-bold text-slate-700">Tanggal Akad</th>
                            <th class="px-6 py-4 text-sm font-bold text-slate-700">Status Digital</th>
                            <th class="px-6 py-4 text-sm font-bold text-slate-700 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($arsip as $item)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900 text-base">{{ $item->no_akta }}</div>
                                    <div class="text-sm text-slate-600 mt-1">Rak: {{ $item->lokasi_fisik ?? 'Belum Diatur' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900 text-base">{{ $item->nama_suami }}</div>
                                    <div class="text-sm font-semibold text-slate-600 mt-1">Istri: {{ $item->nama_istri }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-base font-semibold text-slate-800">{{ $item->tanggal_akad ? \Carbon\Carbon::parse($item->tanggal_akad)->translatedFormat('d M Y') : '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->file_path)
                                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-sm font-bold rounded-lg border border-green-200">✅ Tersedia PDF</span>
                                    @else
                                        <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 text-sm font-bold rounded-lg border border-amber-200">⚠️ Hanya Fisik</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('akta-nikah.show', $item->id) }}" class="px-4 py-2 bg-slate-800 text-white font-bold text-sm rounded-lg hover:bg-slate-700 transition">
                                            Lihat Detail
                                        </a>
                                        @if(auth()->user()->isPengelolaData())
                                            <a href="{{ route('akta-nikah.edit', $item->id) }}" class="px-4 py-2 bg-amber-500 text-white font-bold text-sm rounded-lg hover:bg-amber-600 transition">
                                                Edit
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                    <span class="text-4xl block mb-2">📂</span>
                                    <p class="font-bold text-lg text-slate-700">Tidak Ada Data Ditemukan</p>
                                    <p class="text-sm">Silakan gunakan kata kunci lain untuk mencari.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($arsip->hasPages())
                <div class="p-6 bg-slate-50 border-t border-slate-200">
                    {{ $arsip->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
