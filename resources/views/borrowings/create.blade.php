@extends('layouts.app')

@section('title', 'Form Peminjaman Barang')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-crimson mb-2">Form Peminjaman Barang</h1>
            <p class="text-gray-600">Lengkapi formulir di bawah ini untuk mengajukan peminjaman barang</p>
        </div>

        <!-- Item Info -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Barang</h2>
            <div class="flex items-center space-x-4">
                @if($item->photo)
                    <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}" class="w-24 h-24 object-cover rounded-lg">
                @else
                    <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-3xl text-gray-400"></i>
                    </div>
                @endif
                <div>
                    <h3 class="text-lg font-bold text-gray-800">{{ $item->name }}</h3>
                    <p class="text-gray-600">{{ $item->code }}</p>
                    <p class="text-sm text-gray-500">Kategori: {{ $item->category }}</p>
                    <p class="text-sm font-semibold text-green-600">Tersedia: {{ $item->available_quantity }} unit</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('borrowings.store') }}" method="POST">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">

                <!-- Data Peminjam -->
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Data Peminjam</h3>
                    
                    <div class="mb-4">
                        <label for="borrower_name" class="block text-gray-700 font-semibold mb-2">Nama Lengkap *</label>
                        <input type="text" name="borrower_name" id="borrower_name" value="{{ old('borrower_name') }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-crimson focus:border-transparent @error('borrower_name') border-red-500 @enderror" 
                            required>
                        @error('borrower_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">Email *</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-crimson focus:border-transparent @error('email') border-red-500 @enderror" 
                            required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 font-semibold mb-2">No. Telepon *</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-crimson focus:border-transparent @error('phone') border-red-500 @enderror" 
                            required>
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="organization" class="block text-gray-700 font-semibold mb-2">Instansi/Organisasi *</label>
                        <input type="text" name="organization" id="organization" value="{{ old('organization') }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-crimson focus:border-transparent @error('organization') border-red-500 @enderror" 
                            required>
                        @error('organization')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Detail Peminjaman -->
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Detail Peminjaman</h3>
                    
                    <div class="mb-4">
                        <label for="quantity" class="block text-gray-700 font-semibold mb-2">Jumlah yang Dipinjam *</label>
                        <input type="number" name="quantity" id="quantity" min="1" max="{{ $item->available_quantity }}" value="{{ old('quantity', 1) }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-crimson focus:border-transparent @error('quantity') border-red-500 @enderror" 
                            required>
                        <p class="text-sm text-gray-500 mt-1">Maksimal: {{ $item->available_quantity }} unit</p>
                        @error('quantity')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="borrow_date" class="block text-gray-700 font-semibold mb-2">Tanggal Pinjam *</label>
                            <input type="date" name="borrow_date" id="borrow_date" value="{{ old('borrow_date') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-crimson focus:border-transparent @error('borrow_date') border-red-500 @enderror" 
                                required>
                            @error('borrow_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="return_date" class="block text-gray-700 font-semibold mb-2">Tanggal Kembali *</label>
                            <input type="date" name="return_date" id="return_date" value="{{ old('return_date') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-crimson focus:border-transparent @error('return_date') border-red-500 @enderror" 
                                required>
                            @error('return_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="purpose" class="block text-gray-700 font-semibold mb-2">Keperluan *</label>
                        <textarea name="purpose" id="purpose" rows="4" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-crimson focus:border-transparent @error('purpose') border-red-500 @enderror" 
                            required>{{ old('purpose') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Jelaskan untuk keperluan apa barang akan dipinjam</p>
                        @error('purpose')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center pt-4 border-t">
                    <a href="{{ route('katalog') }}" class="text-gray-600 hover:text-gray-800">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <button type="submit" class="bg-crimson text-white px-6 py-3 rounded-lg hover:bg-maroon transition duration-300 font-semibold">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Permohonan
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-semibold text-blue-800">Informasi Penting</h3>
                    <p class="text-sm text-blue-700 mt-1">
                        Permohonan peminjaman akan diproses oleh admin. Anda akan dihubungi melalui email/telepon setelah permohonan disetujui atau ditolak.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('borrow_date').setAttribute('min', today);
    document.getElementById('return_date').setAttribute('min', today);

    // Auto-update return date min when borrow date changes
    document.getElementById('borrow_date').addEventListener('change', function() {
        document.getElementById('return_date').setAttribute('min', this.value);
    });
</script>
@endsection
