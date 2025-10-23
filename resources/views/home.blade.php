@extends('layouts.app')

@section('title', 'Beranda - KSR PMI Polines')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-ksr-maroon to-ksr-red text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-5xl font-bold mb-4">Sistem Peminjaman Barang</h1>
            <p class="text-xl mb-8">KSR PMI Unit Politeknik Negeri Semarang</p>
            <p class="text-lg mb-8 max-w-2xl mx-auto">
                Ajukan peminjaman barang logistik KSR PMI dengan mudah dan cepat. 
                Kami siap mendukung kegiatan kemanusiaan Anda.
            </p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('katalog') }}" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg font-bold hover:bg-white hover:text-ksr-red transition">
                    <i class="fas fa-box mr-2"></i>Lihat Katalog
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-xl shadow-lg p-8 text-center">
            <div class="w-20 h-20 bg-ksr-red/10 rounded-full flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-box text-ksr-red text-4xl"></i>
            </div>
            <h3 class="text-4xl font-bold text-gray-800">{{ \App\Models\Item::count() }}</h3>
            <p class="text-gray-600 text-lg">Total Barang</p>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-8 text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-check-circle text-green-600 text-4xl"></i>
            </div>
            <h3 class="text-4xl font-bold text-gray-800">{{ \App\Models\Item::where('available_quantity', '>', 0)->count() }}</h3>
            <p class="text-gray-600 text-lg">Barang Tersedia</p>
        </div>
    </div>
</div>


<!-- Available Items Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-800 mb-4">Barang Tersedia</h2>
        <p class="text-gray-600">Beberapa barang yang tersedia untuk dipinjam</p>
    </div>

    @if($items->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($items as $item)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        @if($item->photo)
                            <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-box text-6xl text-gray-400"></i>
                        @endif
                    </div>
                    <div class="p-6">
                        <span class="inline-block bg-ksr-red/10 text-ksr-red px-3 py-1 rounded-full text-sm font-semibold mb-2">
                            {{ $item->category }}
                        </span>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $item->name }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $item->description }}</p>
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500">Tersedia</p>
                                <p class="text-lg font-bold text-ksr-red">{{ $item->available_quantity }} unit</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm {{ $item->condition == 'Good' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $item->condition }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center">
            <a href="{{ route('katalog') }}" class="inline-block bg-ksr-red text-white px-8 py-3 rounded-lg font-bold hover:bg-ksr-maroon transition">
                Lihat Semua Barang <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">Belum ada barang tersedia saat ini</p>
        </div>
    @endif
</div>

<!-- How It Works Section -->
<div class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">Cara Peminjaman</h2>
            <p class="text-gray-600">Proses peminjaman yang mudah dan cepat</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-ksr-red rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-3xl font-bold">1</span>
                </div>
                <h3 class="text-xl font-bold mb-2">Pilih Barang</h3>
                <p class="text-gray-600">Lihat katalog dan pilih barang yang ingin dipinjam</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 bg-ksr-red rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-3xl font-bold">2</span>
                </div>
                <h3 class="text-xl font-bold mb-2">Isi Formulir</h3>
                <p class="text-gray-600">Lengkapi data dan keperluan peminjaman</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 bg-ksr-red rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-3xl font-bold">3</span>
                </div>
                <h3 class="text-xl font-bold mb-2">Menunggu Persetujuan</h3>
                <p class="text-gray-600">Admin akan memverifikasi pengajuan Anda</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 bg-ksr-red rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-3xl font-bold">4</span>
                </div>
                <h3 class="text-xl font-bold mb-2">Ambil Barang</h3>
                <p class="text-gray-600">Ambil barang sesuai jadwal yang ditentukan</p>
            </div>
        </div>
    </div>
</div>
@endsection

