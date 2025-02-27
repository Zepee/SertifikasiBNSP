<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UNIBOOKSTORE')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="bg-gray-50">
    <nav class="bg-[#1e3a8a] shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center space-x-3 group">
                    <i class="fas fa-book-open text-2xl text-white/90 group-hover:text-white transition-colors duration-300"></i>
                    <span class="text-2xl font-bold text-white/90 group-hover:text-white transition-colors duration-300">
                        UNIBOOKSTORE
                    </span>
                </a>

                <!-- Menu untuk Desktop -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('buku.index') }}"
                        class="flex items-center space-x-2 text-white/80 hover:text-white px-4 py-2 rounded-lg hover:bg-[#2c4b9e] transition-all duration-300">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                    <a href="{{ route('admin') }}"
                        class="flex items-center space-x-2 text-white/80 hover:text-white px-4 py-2 rounded-lg hover:bg-[#2c4b9e] transition-all duration-300">
                        <i class="fas fa-cog"></i>
                        <span>Admin</span>
                    </a>
                    <a href="{{ route('pengadaan') }}"
                        class="flex items-center space-x-2 text-white/80 hover:text-white px-4 py-2 rounded-lg hover:bg-[#2c4b9e] transition-all duration-300">
                        <i class="fas fa-boxes"></i>
                        <span>Pengadaan</span>
                    </a>
                </div>
                
                <!-- Menu Hamburger untuk Mobile -->
                <button class="md:hidden text-white" @click="mobileMenu = !mobileMenu">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
            
            <!-- Sidebar Mobile -->
            <div x-show="mobileMenu" 
                 class="md:hidden fixed inset-y-0 right-0 w-64 bg-[#1e3a8a] shadow-lg transform transition-transform duration-300"
                 x-transition:enter="translate-x-0"
                 x-transition:leave="translate-x-full">
                <!-- Menu Mobile -->
                <div class="flex flex-col space-y-4 p-4">
                    <a href="{{ route('buku.index') }}"
                        class="flex items-center space-x-2 text-white/80 hover:text-white px-4 py-2 rounded-lg hover:bg-[#2c4b9e] transition-all duration-300">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                    <a href="{{ route('admin') }}"
                        class="flex items-center space-x-2 text-white/80 hover:text-white px-4 py-2 rounded-lg hover:bg-[#2c4b9e] transition-all duration-300">
                        <i class="fas fa-cog"></i>
                        <span>Admin</span>
                    </a>
                    <a href="{{ route('pengadaan') }}"
                        class="flex items-center space-x-2 text-white/80 hover:text-white px-4 py-2 rounded-lg hover:bg-[#2c4b9e] transition-all duration-300">
                        <i class="fas fa-boxes"></i>
                        <span>Pengadaan</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-6 min-h-screen">
        @yield('content')
    </div>

    <!-- Modern Footer with Navbar Color -->
    <footer class="mt-8">
        <!-- Top Border Gradient -->
        <div class="h-1 bg-gradient-to-r from-blue-500 via-sky-500 to-teal-500"></div>
        
        <div class="bg-gray-900">
            <div class="max-w-7xl mx-auto px-6 py-8">
                <div class="flex flex-col items-center justify-center space-y-4">
                    <!-- Logo & Brand -->
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-white rounded-lg">
                            <i class="fas fa-book-reader text-blue-600 text-xl"></i>
                        </div>
                        <span class="text-xl font-bold text-white">UNIBOOKSTORE</span>
                    </div>
                    
                    <!-- Navigation -->
                    <nav class="flex items-center justify-center space-x-8">
                        <a href="{{ route('buku.index') }}" 
                           class="px-4 py-2 text-white/80 hover:text-white transition-colors duration-300">
                            Katalog
                        </a>
                        <a href="{{ route('admin') }}" 
                           class="px-4 py-2 text-white/80 hover:text-white transition-colors duration-300">
                            Admin
                        </a>
                        <a href="{{ route('pengadaan') }}" 
                           class="px-4 py-2 text-white/80 hover:text-white transition-colors duration-300">
                            Pengadaan
                        </a>
                    </nav>
                    
                    <!-- Copyright -->
                    <div class="text-sm text-white/70">
                        &copy; {{ date('Y') }} UNIBOOKSTORE. All rights reserved.
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <div x-data="{ showNotification: false, message: '' }" x-show="showNotification"
        @notify.window="showNotification = true; message = $event.detail; setTimeout(() => showNotification = false, 3000)"
        class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg" x-transition>
        <span x-text="message"></span>
    </div>


    <div x-data="{ show: false, message: '' }" x-show="show"
        @notify.window="show = true; message = $event.detail; setTimeout(() => show = false, 3000)"
        class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg" style="display: none;">
        <span x-text="message"></span>
    </div>
    
    <script>
        // Trigger notifikasi
        window.dispatchEvent(new CustomEvent('notify', {
            detail: 'Data berhasil disimpan!'
        }));
    </script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
