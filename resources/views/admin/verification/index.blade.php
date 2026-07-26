<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-6">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Verifikasi Berkas Pemohon</h2>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-0.5">Validasi Identitas & Berkas Pemohon</p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 space-y-12 pb-32">
        {{-- Status info card --}}
        @if(session('success'))
            <div class="bg-teal-50 border-l-4 border-teal-500 p-6 rounded-2xl shadow-sm flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <p class="text-teal-900 font-bold">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Filter & Search Panel --}}
        <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-slate-100 border border-slate-100">
            <form method="GET" action="{{ route('admin.verification.index') }}" class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex flex-wrap items-center gap-4 w-full md:w-auto">
                    <a href="{{ route('admin.verification.index') }}" 
                       class="px-5 py-3 rounded-xl text-xs font-black uppercase tracking-wider transition-colors {{ !request('status') ? 'bg-slate-900 text-white' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">
                        Semua Status
                    </a>
                    <a href="{{ route('admin.verification.index', ['status' => 'pending_verification']) }}" 
                       class="px-5 py-3 rounded-xl text-xs font-black uppercase tracking-wider transition-colors {{ request('status') === 'pending_verification' ? 'bg-blue-600 text-white' : 'bg-blue-50 text-blue-600 hover:bg-blue-100' }}">
                        Menunggu Verifikasi
                    </a>
                    <a href="{{ route('admin.verification.index', ['status' => 'verified']) }}" 
                       class="px-5 py-3 rounded-xl text-xs font-black uppercase tracking-wider transition-colors {{ request('status') === 'verified' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100' }}">
                        Disetujui (Terverifikasi)
                    </a>
                    <a href="{{ route('admin.verification.index', ['status' => 'rejected']) }}" 
                       class="px-5 py-3 rounded-xl text-xs font-black uppercase tracking-wider transition-colors {{ request('status') === 'rejected' ? 'bg-rose-600 text-white' : 'bg-rose-50 text-rose-600 hover:bg-rose-100' }}">
                        Ditolak
                    </a>
                </div>

                <div class="flex items-center gap-4 w-full md:w-80">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / NIK..." 
                           class="w-full px-5 py-3 bg-slate-50 border-slate-100 rounded-xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all font-bold text-slate-600">
                    <button type="submit" class="px-5 py-3 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-wider hover:bg-teal-600 transition-colors">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        {{-- Verification Request Table --}}
        <div class="bg-white rounded-[3.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="p-8 md:p-12">
                @if($requests->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100">
                                    <th class="pb-6 text-[10px] font-black text-slate-400 uppercase tracking-widest pl-4">Pemohon</th>
                                    <th class="pb-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">NIK</th>
                                    <th class="pb-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">No. WhatsApp</th>
                                    <th class="pb-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal Pengajuan</th>
                                    <th class="pb-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                                    <th class="pb-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center pr-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requests as $req)
                                    <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors group">
                                        <td class="py-6 pl-4">
                                            <div class="flex items-center gap-4">
                                                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center font-black text-sm uppercase">
                                                    {{ substr($req->nama_lengkap, 0, 2) }}
                                                </div>
                                                <div>
                                                    <h4 class="font-black text-slate-700 leading-none">{{ $req->nama_lengkap }}</h4>
                                                    <span class="text-[10px] text-slate-400 mt-1 block">{{ $req->user->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-6 font-bold text-slate-500 text-sm">
                                            {{ $req->nik }}
                                        </td>
                                        <td class="py-6 text-sm">
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-slate-600">{{ $req->no_telepon }}</span>
                                                @if($req->phone_verified_at)
                                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full" title="No WA Terverifikasi"></span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-6 text-xs font-bold text-slate-400">
                                            {{ $req->updated_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="py-6">
                                            @if($req->status === 'pending_verification')
                                                <span class="px-3 py-1.5 bg-blue-50 text-blue-600 border border-blue-100 rounded-lg text-[9px] font-black uppercase tracking-wider">
                                                    Menunggu Review
                                                </span>
                                            @elseif($req->status === 'verified')
                                                <span class="px-3 py-1.5 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-lg text-[9px] font-black uppercase tracking-wider">
                                                    Disetujui
                                                </span>
                                            @elseif($req->status === 'rejected')
                                                <span class="px-3 py-1.5 bg-rose-50 text-rose-600 border border-rose-100 rounded-lg text-[9px] font-black uppercase tracking-wider" title="Alasan: {{ $req->rejected_reason }}">
                                                    Ditolak
                                                </span>
                                            @else
                                                <span class="px-3 py-1.5 bg-slate-50 text-slate-500 border border-slate-100 rounded-lg text-[9px] font-black uppercase tracking-wider">
                                                    Belum Diajukan
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-6 text-center pr-4">
                                            <a href="{{ route('admin.verification.show', $req->id) }}" 
                                               class="inline-block px-5 py-2.5 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-wider hover:bg-teal-600 transition-colors shadow">
                                                Review Berkas
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8">
                        {{ $requests->links() }}
                    </div>
                @else
                    <div class="py-16 text-center">
                        <div class="w-16 h-16 bg-slate-50 text-slate-300 flex items-center justify-center rounded-2xl mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <h3 class="font-black text-slate-800 text-lg">Tidak Ada Pengajuan Verifikasi</h3>
                        <p class="text-slate-400 text-sm mt-1 max-w-sm mx-auto">Saat ini tidak ada berkas identitas pemohon yang masuk dalam antrean verifikasi atau sesuai dengan filter.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
