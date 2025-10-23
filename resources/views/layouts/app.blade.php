<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KSR PMI Polines - Peminjaman Barang')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ksr-red': '#DC143C',
                        'ksr-maroon': '#8B0000',
                        'ksr-dark': '#1a1a1a',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-ksr-maroon shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                            <i class="fas fa-plus text-ksr-red text-xl"></i>
                        </div>
                        <span class="text-white font-bold text-lg">KSR PMI Polines</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">
                        <i class="fas fa-home mr-1"></i> Beranda
                    </a>
                    <a href="{{ route('katalog') }}" class="text-gray-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">
                        <i class="fas fa-box mr-1"></i> Katalog
                    </a>
                    
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">
                            <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">
                                <i class="fas fa-sign-out-alt mr-1"></i> Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-200 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition">
                            <i class="fas fa-sign-in-alt mr-1"></i> Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-ksr-dark text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">KSR PMI Unit Polines</h3>
                    <p class="text-gray-400 text-sm">Korps Sukarela Palang Merah Indonesia Unit Politeknik Negeri Semarang</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Lokasi</h3>
                    <p class="text-gray-400 text-sm">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        Gedung PKM Lantai 1<br>
                        Politeknik Negeri Semarang
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Kontak</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fas fa-envelope text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400 text-sm">
                <p>&copy; 2024 KSR PMI Unit Politeknik Negeri Semarang. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

