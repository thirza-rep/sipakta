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
                    <div class="p-3 bg-teal-600 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold">Total Arsip Akta</h3>
                </div>
                <div class="text-5xl font-extrabold">{{ number_format(\App\Models\AktaNikah::count()) }}</div>
                <p class="mt-2 text-teal-200 font-medium text-sm">Dokumen pernikahan terdaftar di sistem</p>
            </div>

            {{-- Card 2 --}}
            <div class="bg-white border-2 border-slate-200 rounded-2xl p-8 shadow-sm">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Tahun {{ date('Y') }}</h3>
                </div>
                <div class="text-5xl font-extrabold text-slate-900">{{ number_format(\App\Models\AktaNikah::whereYear('tanggal_akad', date('Y'))->count()) }}</div>
                <p class="mt-2 text-slate-500 font-medium text-sm">Akta yang terdaftar tahun ini</p>
            </div>

            {{-- Card 3 --}}
            <div class="bg-white border-2 border-slate-200 rounded-2xl p-8 shadow-sm">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-purple-50 text-purple-600 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Tersedia Digital</h3>
                </div>
                <div class="text-5xl font-extrabold text-slate-900">{{ number_format(\App\Models\AktaNikah::whereNotNull('file_path')->count()) }}</div>
                <p class="mt-2 text-slate-500 font-medium text-sm">Arsip dengan salinan dokumen digital</p>
            </div>
        </div>

        @if(auth()->user()->isAdmin() || auth()->user()->isPengelolaData())
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Grafik Tren Pengarsipan --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-slate-800">Grafik Tren Pengarsipan ({{ date('Y') }})</h3>
                </div>
                <div class="flex items-end gap-2 h-48 mt-4">
                    @foreach($trendPengarsipan as $trend)
                    <div class="flex-1 flex flex-col items-center justify-end group h-full">
                        <div class="w-full bg-teal-100 rounded-t-md relative overflow-visible transition-all duration-300 group-hover:bg-teal-200" style="height: {{ max($trend['persentase'], 5) }}%;">
                            <div class="absolute inset-x-0 bottom-0 bg-teal-500 rounded-t-md w-full" style="height: 100%;"></div>
                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-xs font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10 pointer-events-none">
                                {{ $trend['jumlah'] }} Arsip
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-slate-500 mt-2 uppercase">{{ $trend['bulan'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Antrean Permohonan Verifikasi --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                        Antrean Verifikasi Profil
                    </h3>
                    <a href="{{ route('admin.verification.index') }}" class="text-sm font-bold text-teal-600 hover:text-teal-700">Lihat Semua &rarr;</a>
                </div>
                <div class="flex-1 overflow-y-auto space-y-3">
                    @forelse($antreanVerifikasi as $queue)
                    <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-slate-100 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center font-bold">
                                {{ substr($queue->nama_lengkap, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $queue->nama_lengkap }}</p>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-0.5">NIK: {{ $queue->nik }} &bull; {{ $queue->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.verification.show', $queue->id) }}" class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-700 hover:bg-slate-50 transition active:scale-95">
                            Proses
                        </a>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center h-full text-slate-400 py-8">
                        <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-sm font-bold text-slate-500">Semua permohonan telah diverifikasi</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        @endif

        @if(auth()->user()->isKepalaKua())
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Daftar Laporan Terbaru --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-8 h-8 bg-teal-50 text-teal-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </span>
                        Laporan Siap Unduh
                    </h3>
                    <a href="{{ route('laporan.index') }}" class="text-sm font-bold text-teal-600 hover:text-teal-700">Pusat Laporan &rarr;</a>
                </div>
                <div class="flex-1 overflow-y-auto space-y-3">
                    @forelse($laporanTerbaru as $laporan)
                    <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-slate-100 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-teal-600 text-white flex items-center justify-center font-bold shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $laporan->judul_laporan }}</p>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-0.5">Disusun: {{ $laporan->created_at->translatedFormat('d M Y') }}</p>
                            </div>
                        </div>
                        <a href="{{ route('laporan.download-tersimpan', $laporan->id) }}" class="px-4 py-2 bg-slate-900 text-white rounded-lg text-xs font-bold hover:bg-teal-600 transition active:scale-95 shadow-sm">
                            Unduh PDF
                        </a>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center h-full text-slate-400 py-8">
                        <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p class="text-sm font-bold text-slate-500">Belum ada laporan yang di-generate</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Ringkasan Aktivitas Sistem --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-8 h-8 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                        Aktivitas Penggunaan Terkini
                    </h3>
                    <a href="{{ route('riwayat.index') }}" class="text-sm font-bold text-teal-600 hover:text-teal-700">Lihat Riwayat &rarr;</a>
                </div>
                <div class="flex-1 overflow-y-auto space-y-3">
                    @forelse($aktivitasTerbaru as $log)
                    <div class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 bg-slate-50 hover:bg-slate-100 transition">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                            {{ substr($log->user->name ?? 'S', 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-slate-800">{{ $log->user->name ?? 'System Process' }}</p>
                            <p class="text-xs text-slate-600 mt-0.5">Pencarian: <span class="font-semibold italic">"{{ $log->kata_kunci }}"</span></p>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest whitespace-nowrap">{{ $log->waktu->diffForHumans() }}</span>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center h-full text-slate-400 py-8">
                        <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-sm font-bold text-slate-500">Belum ada aktivitas tercatat</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        @endif

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
                                    <div class="w-16 h-16 bg-slate-100 text-slate-300 flex items-center justify-center rounded-2xl mx-auto mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
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
