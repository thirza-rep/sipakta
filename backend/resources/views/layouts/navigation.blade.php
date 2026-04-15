<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-slate-200/60 shadow-sm transition-all duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="flex items-center group gap-4">
                    <div class="w-11 h-11 bg-teal-600 rounded-2xl flex items-center justify-center shadow-xl shadow-teal-600/20 transition-all duration-500 group-hover:rotate-6 group-hover:scale-110">
                        <img src="{{ asset('images/logo-kua.jpg') }}" alt="Logo KUA" class="w-8 h-8 rounded-lg object-cover brightness-110">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-slate-900 font-black text-xl tracking-tight leading-none group-hover:text-teal-600 transition">SIPAKTA</span>
                        <span class="text-[9px] font-black text-slate-300 uppercase tracking-[0.3em] mt-1 group-hover:text-teal-400 transition">KUA TEGALREJO</span>
                    </div>
                </a>

                {{-- Navigation Links --}}
                <div class="hidden lg:flex lg:ml-12 items-center gap-1">
                    @php
                        $isPemohon = auth()->user()->isPemohon();
                        $isAdmin = auth()->user()->isAdmin();
                        $isStaf = auth()->user()->isPengelolaData() || auth()->user()->isKepalaKUA();
                        $isKepala = auth()->user()->isKepalaKUA();
                    @endphp

                    @if($isPemohon)
                        <x-nav-link-premium :href="route('pencarian.index')" :active="request()->routeIs('pencarian.*')" icon="search">Cari Arsip</x-nav-link-premium>
                        <x-nav-link-premium :href="route('profil-pemohon.edit')" :active="request()->routeIs('profil-pemohon.*')" icon="user">Profil</x-nav-link-premium>
                    @else
                        <x-nav-link-premium :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="grid">Dashboard</x-nav-link-premium>
                    @endif

                    @if($isAdmin)
                        <x-nav-link-premium :href="route('users.index')" :active="request()->routeIs('users.*')" icon="users">Pengguna</x-nav-link-premium>
                    @endif

                    @if($isStaf)
                        <x-nav-link-premium :href="route('akta-nikah.index')" :active="request()->routeIs('akta-nikah.*')" icon="book">Data Akta</x-nav-link-premium>
                        <x-nav-link-premium :href="route('laporan.index')" :active="request()->routeIs('laporan.*')" icon="chart">Laporan</x-nav-link-premium>
                    @endif

                    @if($isKepala)
                        <x-nav-link-premium :href="route('riwayat.index')" :active="request()->routeIs('riwayat.*')" icon="clock">Riwayat</x-nav-link-premium>
                    @endif
                </div>
            </div>

            {{-- User Dropdown --}}
            <div class="hidden lg:flex lg:items-center">
                <x-dropdown align="right" width="64">
                    <x-slot name="trigger">
                        <button class="flex items-center pl-4 pr-1 py-1 rounded-2xl border border-slate-100 bg-slate-50/50 hover:bg-white hover:border-teal-200 hover:shadow-lg hover:shadow-teal-600/5 transition-all duration-300 group">
                            <div class="mr-3 text-right hidden xl:block">
                                <div class="text-xs font-black text-slate-900 leading-tight group-hover:text-teal-700 transition">{{ Auth::user()->name }}</div>
                                <div class="text-[9px] text-slate-400 font-bold uppercase tracking-wider mt-0.5 group-hover:text-teal-400 transition">{{ Auth::user()->role_display }}</div>
                            </div>
                            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center text-white shadow-lg shadow-teal-600/20 group-hover:scale-105 transition duration-300 uppercase font-black text-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <svg class="w-4 h-4 mx-2 text-slate-400 group-hover:text-teal-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-5 py-4 bg-slate-900 text-white rounded-t-2xl">
                            <p class="text-[10px] text-teal-400 font-black uppercase tracking-[0.2em] mb-1">Identitas Sesi</p>
                            <p class="text-sm font-bold truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="p-2 space-y-1">
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-sm font-bold text-slate-600 rounded-xl hover:bg-teal-50 hover:text-teal-700 transition group">
                                <svg class="w-4 h-4 mr-3 text-slate-400 group-hover:text-teal-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Pengaturan Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-3 text-sm font-bold text-red-500 rounded-xl hover:bg-red-50 transition group">
                                    <svg class="w-4 h-4 mr-3 text-red-400 group-hover:text-red-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Keluar Sistem
                                </button>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Mobile Menu Button --}}
            <div class="flex items-center lg:hidden">
                <button @click="open = !open" class="p-3 bg-slate-50 text-slate-400 rounded-2xl hover:text-teal-600 hover:bg-teal-50 transition-all duration-300 border border-slate-100 active:scale-90">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden lg:hidden bg-white border-t border-slate-100 shadow-2xl overflow-hidden transition-all duration-300">
        <div class="px-4 pt-4 pb-8 space-y-2">
            @if($isPemohon)
                <x-responsive-nav-link-premium :href="route('pencarian.index')" :active="request()->routeIs('pencarian.*')" icon="search">Cari Arsip</x-responsive-nav-link-premium>
                <x-responsive-nav-link-premium :href="route('profil-pemohon.edit')" :active="request()->routeIs('profil-pemohon.*')" icon="user">Profil Saya</x-responsive-nav-link-premium>
            @else
                <x-responsive-nav-link-premium :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="grid">Dashboard</x-responsive-nav-link-premium>
            @endif
            
            @if($isAdmin)
                <x-responsive-nav-link-premium :href="route('users.index')" :active="request()->routeIs('users.*')" icon="users">Kelola Pengguna</x-responsive-nav-link-premium>
            @endif

            @if($isStaf)
                <x-responsive-nav-link-premium :href="route('akta-nikah.index')" :active="request()->routeIs('akta-nikah.*')" icon="book">Data Akta Nikah</x-responsive-nav-link-premium>
                <x-responsive-nav-link-premium :href="route('laporan.index')" :active="request()->routeIs('laporan.*')" icon="chart">Laporan</x-responsive-nav-link-premium>
            @endif

            @if($isKepala)
                <x-responsive-nav-link-premium :href="route('riwayat.index')" :active="request()->routeIs('riwayat.*')" icon="clock">Riwayat Aktifitas</x-responsive-nav-link-premium>
            @endif

            <div class="pt-6 mt-6 border-t border-slate-100">
                <div class="flex items-center px-4 mb-6">
                    <div class="h-12 w-12 rounded-2xl bg-teal-600 flex items-center justify-center text-white shadow-lg font-black uppercase">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="ml-4">
                        <div class="text-base font-black text-slate-900 leading-tight">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ Auth::user()->role_display }}</div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3 pb-2">
                    <a href="{{ route('profile.edit') }}" class="flex items-center justify-center px-4 py-3 bg-slate-50 text-slate-600 rounded-xl font-bold text-sm hover:bg-teal-50 hover:text-teal-700 transition">Profil</a>
                    <form method="POST" action="{{ route('logout') }}" class="flex">
                        @csrf
                        <button type="submit" class="flex-1 px-4 py-3 bg-red-50 text-red-500 rounded-xl font-bold text-sm hover:bg-red-100 transition">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
