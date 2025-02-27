@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-book text-blue-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm">Total Buku</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $bukus->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-check text-green-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm">Stok Tersedia</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $bukus->where('stok', '>', 20)->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-exclamation text-yellow-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm">Stok Menipis</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $bukus->where('stok', '<=', 20)->where('stok', '>', 10)->count() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-red-500">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-full">
                    <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm">Perlu Restok</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $bukus->where('stok', '<=', 10)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Container -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
        <!-- Top accent bar dengan gradient animasi -->
        <div class="h-2 bg-gradient-to-r from-blue-500 via-sky-500 to-teal-500 animate-gradient"></div>
        
        <div class="p-6">
            <div class="flex justify-between items-center">
                <!-- Bagian Kiri: Title & Subtitle -->
                <div class="flex items-center space-x-6">
                    <!-- Icon dengan background pattern -->
                    <div class="relative group">
                        <div class="absolute inset-0 bg-blue-100 rounded-lg rotate-6 transition-transform group-hover:rotate-12"></div>
                        <div class="relative p-4 bg-blue-600 rounded-lg shadow-lg group-hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-book text-2xl text-white"></i>
                        </div>
                    </div>
                    
                    <!-- Title & Subtitle -->
                    <div>
                        <div class="flex items-center space-x-3 mb-1">
                            <h1 class="text-3xl font-bold text-gray-800">Daftar Buku</h1>
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                                Katalog
                            </span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <span class="flex items-center">
                                <i class="fas fa-chart-bar mr-2 text-blue-500"></i>
                                Total Buku: {{ $bukus->count() }}
                            </span>
                            <span class="mx-2">•</span>
                            <span class="flex items-center">
                                <i class="fas fa-layer-group mr-2 text-blue-500"></i>
                                {{ $bukus->pluck('kategori')->unique()->count() }} Kategori
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Controls -->
    <div class="mb-6">
        <form method="GET" class="flex flex-wrap gap-4">
            <!-- Search Bar -->
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Buku</label>
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari berdasarkan nama buku..."
                           class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-blue-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>

            <!-- Filter Kategori -->
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select name="kategori" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    <option value="Novel" {{ request('kategori') == 'Novel' ? 'selected' : '' }}>Novel</option>
                    <option value="Komik" {{ request('kategori') == 'Komik' ? 'selected' : '' }}>Komik</option>
                    <option value="Majalah" {{ request('kategori') == 'Majalah' ? 'selected' : '' }}>Majalah</option>
                    <option value="Kamus" {{ request('kategori') == 'Kamus' ? 'selected' : '' }}>Kamus</option>
                </select>
            </div>

            <!-- Pengurutan -->
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                <select name="sort" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Urutan</option>
                    <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama Z-A</option>
                    <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                </select>
            </div>

            <!-- Tombol Filter & Reset -->
            <div class="flex items-end space-x-2">
                
                <a href="{{ url('/') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg transition duration-200 flex items-center space-x-2">
                    <i class="fas fa-undo"></i>
                    <span>Reset</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Table Container -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full whitespace-nowrap">
            <thead>
                <tr>
                    <th class="px-6 py-4 bg-gray-50 text-left">
                        <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">ID Buku</span>
                    </th>
                    <th class="px-6 py-4 bg-gray-50 text-left">
                        <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Kategori</span>
                    </th>
                    <th class="px-6 py-4 bg-gray-50 text-left">
                        <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Buku</span>
                    </th>
                    <th class="px-6 py-4 bg-gray-50 text-right">
                        <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Harga</span>
                    </th>
                    <th class="px-6 py-4 bg-gray-50 text-center">
                        <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Stok</span>
                    </th>
                    <th class="px-6 py-4 bg-gray-50 text-left">
                        <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Penerbit</span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($bukus as $buku)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-medium bg-gray-100 text-gray-800">
                            {{ $buku->kode_buku }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-medium 
                            {{ $buku->kategori == 'Keilmuan' ? 'bg-blue-100 text-blue-800' : 
                               ($buku->kategori == 'Bisnis' ? 'bg-purple-100 text-purple-800' : 
                               'bg-pink-100 text-pink-800') }}">
                            {{ $buku->kategori }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $buku->nama_buku }}</div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="text-sm font-medium text-gray-900">
                            Rp {{ number_format($buku->harga, 0, ',', '.') }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center">
                            @if($buku->stok <= 10)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-medium bg-red-100 text-red-800">
                                    {{ $buku->stok }}
                                </span>
                            @elseif($buku->stok <= 20)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-medium bg-yellow-100 text-yellow-800">
                                    {{ $buku->stok }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-medium bg-green-100 text-green-800">
                                    {{ $buku->stok }}
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-medium bg-green-100 text-green-800">
                            {{ $buku->penerbit->nama }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($bukus->isEmpty())
        <div class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <i class="fas fa-book text-6xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Tidak ada buku</h3>
            <p class="text-gray-500">Belum ada buku yang ditambahkan</p>
        </div>
        @endif
    </div>
</div>

<style>
    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .animate-gradient {
        background-size: 200% 200%;
        animation: gradient 8s ease infinite;
    }
</style>
@endsection
