@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6" x-data="{ 
        showEditModal: false,
        showAddModal: false,
        showAddPenerbitModal: false,
        showEditPenerbitModal: false,
        editingBuku: null,
        editingPenerbit: null
    }">
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
                        
                        <!-- Title & Subtitle dengan styling yang lebih menarik -->
                        <div>
                            <div class="flex items-center space-x-3 mb-1">
                                <h1 class="text-3xl font-bold text-gray-800">Manajemen Buku</h1>
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                                    Admin
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

                    <!-- Bagian Kanan: Action Buttons -->
                    <div class="flex items-center space-x-3">
                        <button @click="showAddModal = true" 
                                class="group relative inline-flex items-center px-6 py-3 overflow-hidden text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all duration-300">
                            <i class="fas fa-plus-circle mr-2"></i>
                            <span>Tambah Buku</span>
                        </button>
                    
                        <button class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                            <i class="fas fa-ellipsis-v text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Controls yang lebih modern -->
        <div class="mb-6 flex gap-4">
            <form method="GET" class="flex gap-4 w-full">
                <!-- Search Bar -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Buku</label>
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari berdasarkan nama buku..."
                               onchange="this.form.submit()"
                               class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-blue-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Filter Kategori -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select name="kategori" 
                            onchange="this.form.submit()"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                        <option value="">Semua Kategori</option>
                        <option value="Keilmuan" {{ request('kategori') == 'Keilmuan' ? 'selected' : '' }}>Keilmuan</option>
                        <option value="Bisnis" {{ request('kategori') == 'Bisnis' ? 'selected' : '' }}>Bisnis</option>
                        <option value="Novel" {{ request('kategori') == 'Novel' ? 'selected' : '' }}>Novel</option>
                    </select>
                </div>

                <!-- Pengurutan -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                    <select name="sort" 
                            onchange="this.form.submit()"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none bg-white">
                        <option value="">Urutkan Berdasarkan</option>
                        <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                        <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                        <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>Harga (Terendah)</option>
                        <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>Harga (Tertinggi)</option>
                    </select>
                </div>

                <!-- Tombol Reset -->
                <div class="flex items-end">
                    <a href="{{ route('admin') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg transition duration-200 flex items-center space-x-2">
                        <i class="fas fa-undo"></i>
                        <span>Reset</span>
                    </a>
                </div>
            </form>
        </div>

        <div x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 1000)">
            <!-- Skeleton loading -->
            <template x-if="loading">
                <div class="animate-pulse space-y-4">
                    <!-- Skeleton untuk header -->
                    <div class="flex justify-between items-center mb-6">
                        <div class="h-8 bg-gray-200 rounded w-1/4"></div>
                        <div class="h-8 bg-gray-200 rounded w-32"></div>
                    </div>

                    <!-- Skeleton untuk tabel -->
                    <div class="border rounded-lg">
                        <!-- Header skeleton -->
                        <div class="border-b bg-gray-50 p-4">
                            <div class="grid grid-cols-4 gap-4">
                                <div class="h-4 bg-gray-200 rounded"></div>
                                <div class="h-4 bg-gray-200 rounded"></div>
                                <div class="h-4 bg-gray-200 rounded"></div>
                                <div class="h-4 bg-gray-200 rounded"></div>
                            </div>
                        </div>

                        <!-- Rows skeleton -->
                        <div class="divide-y">
                            @for ($i = 0; $i < 5; $i++)
                            <div class="p-4">
                                <div class="grid grid-cols-4 gap-4">
                                    <div class="h-4 bg-gray-200 rounded"></div>
                                    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                    <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                                    <div class="h-4 bg-gray-200 rounded w-1/4"></div>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </template>

            <!-- Actual content -->
            <template x-if="!loading">
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
                                <th class="px-6 py-4 bg-gray-50 text-center">
                                    <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</span>
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
                                <td class="px-6 py-4">
                                    <div class="flex justify-center space-x-2">
                                        <button @click="editingBuku = {{ $buku }}; showEditModal = true"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <i class="fas fa-edit mr-1.5"></i>
                                            Edit
                                        </button>
                                        <form onsubmit="return confirmDelete(event)" 
                                              action="{{ route('buku.destroy', $buku->id) }}" 
                                              method="POST" 
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                <i class="fas fa-trash mr-1.5"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </template>
        </div>

        <!-- Modal Tambah Buku -->
        <x-modal id="showAddModal" title="Tambah Buku Baru">
            <form action="{{ route('buku.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-5">
                    <!-- Kode Buku -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kode Buku
                        </label>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-barcode text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   name="kode_buku" 
                                   class="pl-10 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>
                    </div>

                    <!-- Nama Buku -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Buku
                        </label>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-book text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   name="nama_buku" 
                                   class="pl-10 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kategori
                        </label>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-gray-400"></i>
                            </div>
                            <select name="kategori" 
                                    class="pl-10 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">Pilih Kategori</option>
                                <option value="Keilmuan">Keilmuan</option>
                                <option value="Bisnis">Bisnis</option>
                                <option value="Novel">Novel</option>
                            </select>
                        </div>
                    </div>

                    <!-- Harga -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Harga
                        </label>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-400">Rp</span>
                            </div>
                            <input type="number" 
                                   name="harga" 
                                   class="pl-10 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>
                    </div>

                    <!-- Stok -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Stok
                        </label>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-boxes text-gray-400"></i>
                            </div>
                            <input type="number" 
                                   name="stok" 
                                   class="pl-10 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                        </div>
                    </div>

                    <!-- Penerbit -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Penerbit
                        </label>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-building text-gray-400"></i>
                            </div>
                            <select name="penerbit_id" 
                                    class="pl-10 w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                                <option value="">Pilih Penerbit</option>
                                @foreach($penerbits as $penerbit)
                                    <option value="{{ $penerbit->id }}">{{ $penerbit->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-2 pt-4 border-t">
                    <button type="button" 
                            @click="showAddModal = false"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 flex items-center space-x-2">
                        <i class="fas fa-times"></i>
                        <span>Batal</span>
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>Simpan</span>
                    </button>
                </div>
            </form>
        </x-modal>

        <!-- Modal Edit yang sudah ada -->
        <x-modal id="showEditModal" title="Edit Buku">
            <form x-bind:action="`/buku/${editingBuku?.id}`" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Buku</label>
                        <input type="text" 
                               name="nama_buku" 
                               x-bind:value="editingBuku?.nama_buku"
                               class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="kategori" 
                                x-bind:value="editingBuku?.kategori"
                                class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <option value="Keilmuan">Keilmuan</option>
                            <option value="Bisnis">Bisnis</option>
                            <option value="Novel">Novel</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                        <input type="number" 
                               name="harga" 
                               x-bind:value="editingBuku?.harga"
                               class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                        <input type="number" 
                               name="stok" 
                               x-bind:value="editingBuku?.stok"
                               class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Penerbit</label>
                        <select name="penerbit_id" 
                                x-bind:value="editingBuku?.penerbit_id"
                                class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            @foreach($penerbits as $penerbit)
                                <option value="{{ $penerbit->id }}">{{ $penerbit->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end space-x-2 pt-4">
                        <button type="button" 
                                @click="showEditModal = false"
                                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </x-modal>

        <!-- Daftar Penerbit Section -->
        <div class="mt-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                <!-- Top accent bar dengan gradient animasi -->
                <div class="h-2 bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 animate-gradient"></div>
                
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <!-- Bagian Kiri: Title & Subtitle -->
                        <div class="flex items-center space-x-6">
                            <!-- Icon dengan background pattern -->
                            <div class="relative group">
                                <div class="absolute inset-0 bg-green-100 rounded-lg rotate-6 transition-transform group-hover:rotate-12"></div>
                                <div class="relative p-4 bg-green-600 rounded-lg shadow-lg group-hover:shadow-xl transition-all duration-300">
                                    <i class="fas fa-building text-2xl text-white"></i>
                                </div>
                            </div>
                            
                            <!-- Title & Subtitle -->
                            <div>
                                <div class="flex items-center space-x-3 mb-1">
                                    <h1 class="text-3xl font-bold text-gray-800">Daftar Penerbit</h1>
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                                        Admin
                                    </span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <span class="flex items-center">
                                        <i class="fas fa-building mr-2 text-green-500"></i>
                                        Total Penerbit: {{ $penerbits->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian Kanan: Action Button -->
                        <div class="flex items-center space-x-3">
                            <button @click="showAddPenerbitModal = true"
                                    class="group relative inline-flex items-center px-6 py-3 overflow-hidden text-white bg-green-600 rounded-lg hover:bg-green-700 transition-all duration-300">
                                <i class="fas fa-plus-circle mr-2"></i>
                                <span>Tambah Penerbit</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Penerbit -->
            <div class="overflow-x-auto bg-white rounded-lg shadow mt-8">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr>
                            <th class="px-6 py-4 bg-gray-50 text-left">
                                <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">ID Penerbit</span>
                            </th>
                            <th class="px-6 py-4 bg-gray-50 text-left">
                                <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Penerbit</span>
                            </th>
                            <th class="px-6 py-4 bg-gray-50 text-left">
                                <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Alamat</span>
                            </th>
                            <th class="px-6 py-4 bg-gray-50 text-left">
                                <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Kota</span>
                            </th>
                            <th class="px-6 py-4 bg-gray-50 text-left">
                                <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Telepon</span>
                            </th>
                            <th class="px-6 py-4 bg-gray-50 text-center">
                                <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Total Buku</span>
                            </th>
                            <th class="px-6 py-4 bg-gray-50 text-center">
                                <span class="text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($penerbits as $penerbit)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-medium bg-gray-100 text-gray-800">
                                    {{ $penerbit->kode_penerbit }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $penerbit->nama }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600 max-w-xs truncate">{{ $penerbit->alamat }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-medium bg-blue-100 text-blue-800">
                                    {{ $penerbit->kota }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600">{{ $penerbit->telepon }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-medium 
                                        {{ $penerbit->bukus_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $penerbit->bukus_count }} Buku
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center space-x-2">
                                    <button @click="editingPenerbit = {{ $penerbit }}; showEditPenerbitModal = true"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <i class="fas fa-edit mr-1.5"></i>
                                        Edit
                                    </button>
                                    <form onsubmit="return confirmDeletePenerbit(event)" 
                                          action="{{ route('penerbit.destroy', $penerbit->id) }}" 
                                          method="POST" 
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            <i class="fas fa-trash mr-1.5"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($penerbits->isEmpty())
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-building text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Tidak ada penerbit</h3>
                    <p class="text-gray-500">Belum ada penerbit yang ditambahkan</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Modal Tambah Penerbit -->
        <x-modal id="showAddPenerbitModal" title="Tambah Penerbit Baru">
            <form action="{{ route('penerbit.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-4">
                    <!-- Kode Penerbit -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kode Penerbit
                        </label>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-building text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   name="kode_penerbit" 
                                   class="pl-10 w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500"
                                   required>
                        </div>
                    </div>

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Penerbit
                        </label>
                        <input type="text" 
                               name="nama" 
                               class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500"
                               required>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Alamat
                        </label>
                        <textarea name="alamat" 
                                  class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500"
                                  required></textarea>
                    </div>

                    <!-- Kota -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kota
                        </label>
                        <input type="text" 
                               name="kota" 
                               class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500"
                               required>
                    </div>

                    <!-- Telepon -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Telepon
                        </label>
                        <input type="text" 
                               name="telepon" 
                               class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500"
                               required>
                    </div>
                </div>

                <div class="flex justify-end space-x-2 pt-4 border-t">
                    <button type="button" 
                            @click="showAddPenerbitModal = false"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 flex items-center space-x-2">
                        <i class="fas fa-times"></i>
                        <span>Batal</span>
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 flex items-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>Simpan</span>
                    </button>
                </div>
            </form>
        </x-modal>

        <!-- Modal Edit Penerbit -->
        <x-modal id="showEditPenerbitModal" title="Edit Penerbit">
            <form x-bind:action="`/penerbit/${editingPenerbit?.id}`" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerbit</label>
                        <input type="text" 
                               name="nama" 
                               x-model="editingPenerbit ? editingPenerbit.nama : ''"
                               class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500"
                               required>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea name="alamat" 
                                  x-model="editingPenerbit ? editingPenerbit.alamat : ''"
                                  class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500"
                                  required></textarea>
                    </div>

                    <!-- Kota -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kota</label>
                        <input type="text" 
                               name="kota" 
                               x-model="editingPenerbit ? editingPenerbit.kota : ''"
                               class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500"
                               required>
                    </div>

                    <!-- Telepon -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                        <input type="text" 
                               name="telepon" 
                               x-model="editingPenerbit ? editingPenerbit.telepon : ''"
                               class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500"
                               required>
                    </div>
                </div>

                <div class="flex justify-end space-x-2 pt-4 border-t">
                    <button type="button" 
                            @click="showEditPenerbitModal = false; editingPenerbit = null"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Update
                    </button>
                </div>
            </form>
        </x-modal>
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

    <script>
    function confirmDelete(event) {
        event.preventDefault();
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data buku akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form jika user mengkonfirmasi
                event.target.submit();
            }
        });
        
        return false;
    }

    function confirmDeletePenerbit(event) {
        event.preventDefault();
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data penerbit akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
        
        return false;
    }

    // Tampilkan SweetAlert untuk pesan sukses
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 1500,
            showConfirmButton: false
        });
    @endif
    </script>
@endsection