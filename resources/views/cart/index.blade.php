@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-crimson mb-2">Keranjang Belanja</h1>
            <p class="text-gray-600">Review barang yang akan Anda pinjam</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if($cartItems->isEmpty())
            <!-- Empty Cart State -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-700 mb-2">Keranjang Kosong</h2>
                <p class="text-gray-500 mb-6">Belum ada barang di keranjang Anda</p>
                <a href="{{ route('katalog') }}" class="inline-block bg-ksr-red text-white px-6 py-3 rounded-lg hover:bg-ksr-maroon transition duration-300">
                    <i class="fas fa-box mr-2"></i>Lihat Katalog
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-center mb-4 pb-4 border-b">
                            <h3 class="text-lg font-bold text-gray-800">Item di Keranjang ({{ $cartItems->count() }})</h3>
                            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Hapus semua item dari keranjang?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                    <i class="fas fa-trash mr-1"></i>Kosongkan Keranjang
                                </button>
                            </form>
                        </div>

                        <div class="space-y-4">
                            @foreach($cartItems as $cartItem)
                                <div class="flex items-center space-x-4 p-4 border rounded-lg hover:bg-gray-50 transition">
                                    <!-- Foto Barang -->
                                    <div class="flex-shrink-0">
                                        @if($cartItem->item->photo)
                                            <img src="{{ asset('storage/' . $cartItem->item->photo) }}" 
                                                 alt="{{ $cartItem->item->name }}" 
                                                 class="w-24 h-24 object-cover rounded-lg">
                                        @else
                                            <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-box text-gray-400 text-2xl"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Detail Barang -->
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-800 text-lg">{{ $cartItem->item->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $cartItem->item->category }}</p>
                                        <p class="text-sm text-ksr-red font-semibold mt-1">
                                            Rp {{ number_format($cartItem->item->price, 0, ',', '.') }} / hari
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">Stok tersedia: {{ $cartItem->item->available_quantity }} unit</p>
                                    </div>

                                    <!-- Quantity Controls -->
                                    <div class="flex items-center space-x-3">
                                        <form action="{{ route('cart.update', $cartItem) }}" method="POST" class="flex items-center space-x-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" 
                                                   name="quantity" 
                                                   value="{{ $cartItem->quantity }}" 
                                                   min="1" 
                                                   max="{{ $cartItem->item->available_quantity }}"
                                                   class="w-20 px-3 py-2 border border-gray-300 rounded-lg text-center focus:ring-2 focus:ring-ksr-red focus:border-transparent"
                                                   onchange="this.form.submit()">
                                            <noscript>
                                                <button type="submit" class="text-blue-600 hover:text-blue-800">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </noscript>
                                        </form>

                                        <!-- Delete Button -->
                                        <form action="{{ route('cart.remove', $cartItem) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800 p-2"
                                                    onclick="return confirm('Hapus item ini dari keranjang?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Ringkasan</h3>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Jenis Barang:</span>
                                <span class="font-semibold">{{ $cartItems->count() }} item</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Unit:</span>
                                <span class="font-semibold">{{ $cartItems->sum('quantity') }} unit</span>
                            </div>
                            <div class="border-t pt-3">
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">Estimasi Biaya/Hari:</span>
                                    <span class="font-bold text-ksr-red">
                                        Rp {{ number_format($cartItems->sum(function($item) { return $item->quantity * $item->item->price; }), 0, ',', '.') }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500">*Biaya aktual dihitung berdasarkan jumlah hari peminjaman</p>
                            </div>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <p class="text-xs text-blue-800">
                                <i class="fas fa-info-circle mr-1"></i>
                                Total biaya final akan dihitung berdasarkan tanggal pinjam dan tanggal kembali yang Anda pilih di halaman checkout.
                            </p>
                        </div>

                        <a href="{{ route('borrowings.create') }}" 
                           class="block w-full bg-ksr-red text-white text-center px-6 py-3 rounded-lg hover:bg-ksr-maroon transition duration-300 font-semibold mb-3 text-lg">
                            <i class="fas fa-shopping-bag mr-2"></i>Lanjut ke Checkout
                        </a>

                        <a href="{{ route('katalog') }}" 
                           class="block w-full border border-gray-300 text-gray-700 text-center px-6 py-3 rounded-lg hover:bg-gray-50 transition duration-300">
                            <i class="fas fa-arrow-left mr-2"></i>Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
