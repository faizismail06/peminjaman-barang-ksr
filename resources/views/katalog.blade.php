@extends('layouts.app')

@section('title', 'Katalog Barang - KSR PMI Polines')

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-ksr-maroon to-ksr-red text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-2">Katalog Barang</h1>
        <p class="text-lg">Lihat semua barang yang tersedia untuk dipinjam</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('katalog') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Cari Barang</label>
                <input type="text" name="search" placeholder="Cari nama barang..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ksr-red focus:border-transparent"
                       value="{{ request('search') }}">
            </div>
            <div class="w-full md:w-auto">
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ksr-red focus:border-transparent">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $kategori)
                        <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-ksr-red text-white px-6 py-2 rounded-lg hover:bg-ksr-maroon transition">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Items Grid -->
    @if($items->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @foreach($items as $item)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1 flex flex-col">
                    <!-- Gambar -->
                    <div class="h-48 bg-gray-200 flex items-center justify-center relative">
                        @if($item->photo)
                            <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-box text-6xl text-gray-400"></i>
                        @endif
                        @if($item->available_quantity <= 0)
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                <span class="bg-red-600 text-white px-4 py-2 rounded-lg font-bold">Tidak Tersedia</span>
                            </div>
                        @endif
                    </div>

                    <!-- Konten -->
                    <div class="p-4 flex flex-col flex-grow">
                        <div class="flex justify-between items-start mb-2">
                            <span class="inline-block bg-ksr-red/10 text-ksr-red px-2 py-1 rounded-full text-xs font-semibold">
                                {{ $item->category }}
                            </span>
                            <span class="text-xs text-gray-500">{{ $item->code }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $item->name }}</h3>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $item->description ?? 'Tidak ada deskripsi' }}</p>
                        
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <p class="text-xs text-gray-500">Tersedia</p>
                                <p class="text-sm font-bold text-ksr-red">{{ $item->available_quantity }}/{{ $item->total_quantity }} unit</p>
                            </div>
                            <span class="px-2 py-1 rounded-full text-xs {{ $item->condition == 'Good' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $item->condition }}
                            </span>
                        </div>

                        <!-- Tombol (nempel di bawah) -->
                        <div class="mt-auto">
                            @if($item->available_quantity > 0)
                                <a href="{{ route('borrowings.create', ['item' => $item->id]) }}"
                                    class="flex items-center justify-center gap-2 w-full bg-ksr-red text-white px-4 py-2 rounded-lg hover:bg-ksr-maroon transition">
                                    <i class="fas fa-file-alt text-base self-center"></i>
                                    <span class="leading-none">Pinjam</span>
                                </a>
                            @else
                                <button disabled 
                                    class="flex items-center justify-center gap-2 w-full bg-gray-400 text-white text-center px-4 py-2 rounded-lg cursor-not-allowed">
                                    <i class="fas fa-times-circle"></i>
                                    <span>Tidak Tersedia</span>
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            @endforeach
        </div>


        <!-- Pagination -->
        <div class="mt-8">
            {{ $items->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg mb-4">Tidak ada barang yang ditemukan</p>
            <a href="{{ route('katalog') }}" class="text-ksr-red hover:text-ksr-maroon">
                <i class="fas fa-redo mr-1"></i>Reset Filter
            </a>
        </div>
    @endif
</div>
@endsection

