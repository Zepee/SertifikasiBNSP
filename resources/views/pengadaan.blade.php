@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="space-y-6">
        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-red-500">
                <div class="flex items-center">
                    <div class="p-3 bg-red-100 rounded-full">
                        <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Perlu Restok</h3>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $bukus->where('stok', '<=', 10)->count() }}
                        </p>
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
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $bukus->where('stok', '>', 10)->where('stok', '<=', 20)->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <i class="fas fa-check text-green-500 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Stok Aman</h3>
                        <p class="text-2xl font-bold text-gray-800">
                            {{ $bukus->where('stok', '>', 20)->count() }}
                        </p>
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
                                <i class="fas fa-boxes text-2xl text-white"></i>
                            </div>
                        </div>
                        
                        <!-- Title & Subtitle dengan styling yang lebih menarik -->
                        <div>
                            <div class="flex items-center space-x-3 mb-1">
                                <h1 class="text-3xl font-bold text-gray-800">Monitoring Stok</h1>
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                                    Pengadaan
                                </span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <span class="flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-2 text-red-500"></i>
                                    Perlu Restok: {{ $bukus->where('stok', '<=', 10)->count() }}
                                </span>
                                <span class="mx-2">•</span>
                                <span class="flex items-center">
                                    <i class="fas fa-exclamation mr-2 text-yellow-500"></i>
                                    Stok Menipis: {{ $bukus->where('stok', '>', 10)->where('stok', '<=', 20)->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 1000)">
                <!-- Skeleton loading -->
                <template x-if="loading">
                    <div class="animate-pulse space-y-4">
                        <div class="h-8 bg-gray-200 rounded w-1/4"></div>
                        <div class="space-y-3">
                            @for ($i = 0; $i < 5; $i++)
                            <div class="grid grid-cols-4 gap-4">
                                <div class="h-4 bg-gray-200 rounded col-span-2"></div>
                                <div class="h-4 bg-gray-200 rounded"></div>
                                <div class="h-4 bg-gray-200 rounded"></div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </template>

                <!-- Actual content -->
                <template x-if="!loading">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border-b px-4 py-3 text-left">Nama Buku</th>
                                    <th class="border-b px-4 py-3 text-left">Penerbit</th>
                                    <th class="border-b px-4 py-3 text-center">Stok</th>
                                    <th class="border-b px-4 py-3 text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bukus as $buku)
                                <tr class="hover:bg-gray-50">
                                    <td class="border-b px-4 py-3">{{ $buku->nama_buku }}</td>
                                    <td class="border-b px-4 py-3">{{ $buku->penerbit->nama }}</td>
                                    <td class="border-b px-4 py-3 text-center">{{ $buku->stok }}</td>
                                    <td class="border-b px-4 py-3">
                                        @if($buku->stok <= 10)
                                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">
                                                Segera Restok
                                            </span>
                                        @elseif($buku->stok <= 20)
                                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                                                Stok Menipis
                                            </span>
                                        @else
                                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                                Stok Aman
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </template>
            </div>
        </div>
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