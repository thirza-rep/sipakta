<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Komparasi Pencarian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Form Pencarian -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('komparasi.index') }}" method="GET" class="flex gap-4 items-center">
                        <div class="flex-1">
                            <x-text-input id="q" name="q" type="text" class="mt-1 block w-full" :value="$keyword" placeholder="Masukkan nama, nomor akta, atau lokasi..." />
                        </div>
                        <x-primary-button type="submit">
                            {{ __('Bandingkan') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>

            @if(request()->filled('q'))
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom Meilisearch -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h3 class="text-lg font-bold text-teal-700">Meilisearch</h3>
                            <div class="text-sm bg-teal-50 text-teal-700 px-3 py-1 rounded-full font-medium">
                                {{ $meiliLatency }} ms
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mb-4">Ditemukan {{ $meiliTotal }} data.</p>
                        
                        <div class="space-y-4">
                            @forelse($meiliResults as $item)
                                <div class="p-4 border rounded hover:bg-gray-50 transition-colors">
                                    <div class="font-semibold text-gray-800">No: {{ $item->nomor_akta }}</div>
                                    <div class="text-sm text-gray-600 mt-1">
                                        <span class="font-medium">Suami:</span> {{ $item->nama_suami }}<br>
                                        <span class="font-medium">Istri:</span> {{ $item->nama_istri }}
                                    </div>
                                    <div class="text-xs text-gray-400 mt-2">
                                        {{ $item->lokasi_fisik }} | {{ $item->tanggal_akad ? date('d M Y', strtotime($item->tanggal_akad)) : '' }}
                                    </div>
                                </div>
                            @empty
                                <div class="text-gray-500 text-sm text-center py-4">Tidak ada data.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Kolom Elasticsearch -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h3 class="text-lg font-bold text-orange-600">Elasticsearch</h3>
                            <div class="text-sm bg-orange-50 text-orange-600 px-3 py-1 rounded-full font-medium">
                                @if($elasticLatency < 0) Error @else {{ $elasticLatency }} ms @endif
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mb-4">Ditemukan {{ $elasticTotal }} data.</p>
                        
                        <div class="space-y-4">
                            @forelse($elasticResults as $item)
                                <div class="p-4 border rounded hover:bg-gray-50 transition-colors">
                                    <div class="font-semibold text-gray-800">No: {{ $item->nomor_akta ?? '' }}</div>
                                    <div class="text-sm text-gray-600 mt-1">
                                        <span class="font-medium">Suami:</span> {{ $item->nama_suami ?? '' }}<br>
                                        <span class="font-medium">Istri:</span> {{ $item->nama_istri ?? '' }}
                                    </div>
                                    <div class="text-xs text-gray-400 mt-2">
                                        {{ $item->lokasi_fisik ?? '' }} | {{ isset($item->tanggal_akad) && $item->tanggal_akad ? date('d M Y', strtotime($item->tanggal_akad)) : '' }}
                                    </div>
                                </div>
                            @empty
                                <div class="text-gray-500 text-sm text-center py-4">Tidak ada data.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
