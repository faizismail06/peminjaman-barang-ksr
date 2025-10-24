@extends('layouts.app')

@section('title', 'Checkout Peminjaman')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-crimson mb-2">Checkout Peminjaman</h1>
            <p class="text-gray-600">Lengkapi data peminjaman dan upload SPJ</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <form action="{{ route('borrowings.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Data Peminjam -->
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Data Peminjam</h3>
                            
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
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Detail Peminjaman</h3>

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

                            <div class="mb-4">
                                <label for="spj" class="block text-gray-700 font-semibold mb-2">Upload SPJ (PDF) *</label>
                                <input type="file" name="spj" id="spj" accept=".pdf"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-crimson focus:border-transparent @error('spj') border-red-500 @enderror" 
                                    required>
                                <p class="text-sm text-gray-500 mt-1">Format: PDF, Maksimal: 5MB</p>
                                @error('spj')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-between items-center pt-4 border-t">
                            <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-gray-800">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Keranjang
                            </a>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300 font-semibold">
                                <i class="fas fa-paper-plane mr-2"></i>Kirim Permohonan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Barang yang Dipinjam</h3>
                    
                    <div class="space-y-3 mb-4 max-h-60 overflow-y-auto">
                        @foreach($cartItems as $cartItem)
                            <div class="flex items-start space-x-2 text-sm">
                                <div class="flex-shrink-0">
                                    @if($cartItem->item->photo)
                                        <img src="{{ asset('storage/' . $cartItem->item->photo) }}" alt="{{ $cartItem->item->name }}" class="w-12 h-12 object-cover rounded">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                            <i class="fas fa-box text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">{{ $cartItem->item->name }}</p>
                                    <p class="text-gray-500">{{ $cartItem->quantity }} unit × Rp {{ number_format($cartItem->item->price, 0, ',', '.') }}/hari</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t pt-4">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Total Barang:</span>
                            <span class="font-semibold">{{ $cartItems->count() }} item</span>
                        </div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Total Unit:</span>
                            <span class="font-semibold">{{ $cartItems->sum('quantity') }} unit</span>
                        </div>
                        <div class="flex justify-between text-sm mb-4 pb-4 border-b">
                            <span class="text-gray-600">Estimasi Biaya/Hari:</span>
                            <span class="font-semibold text-crimson">Rp {{ number_format($cartItems->sum(function($item) { return $item->quantity * $item->item->price; }), 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                            <p class="text-xs text-yellow-800">
                                <i class="fas fa-info-circle mr-1"></i>
                                Total biaya akan dihitung otomatis berdasarkan jumlah hari peminjaman
                            </p>
                        </div>

                        <!-- Calculated Cost Section -->
                        <div id="calculated-cost-section" class="mt-4 hidden">
                            <div class="border-t pt-4">
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">Jumlah Hari:</span>
                                    <span class="font-semibold" id="total-days">0 hari</span>
                                </div>
                                <div class="flex justify-between text-lg font-bold">
                                    <span class="text-gray-800">Total Biaya:</span>
                                    <span class="text-crimson" id="total-cost">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>
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

    // Cart items data for calculation
    const cartItems = @json($cartItems->map(function($item) {
        return [
            'quantity' => $item->quantity,
            'price' => $item->item->price
        ];
    }));

    // Calculate cost per day
    const costPerDay = cartItems.reduce((total, item) => {
        return total + (item.quantity * item.price);
    }, 0);

    // Auto-update return date min when borrow date changes
    document.getElementById('borrow_date').addEventListener('change', function() {
        document.getElementById('return_date').setAttribute('min', this.value);
        calculateTotalCost();
    });

    // Calculate total cost when return date changes
    document.getElementById('return_date').addEventListener('change', calculateTotalCost);

    function calculateTotalCost() {
        const borrowDate = document.getElementById('borrow_date').value;
        const returnDate = document.getElementById('return_date').value;
        
        if (borrowDate && returnDate) {
            const borrow = new Date(borrowDate);
            const returnD = new Date(returnDate);
            
            // Calculate difference in days + 1 (include first day)
            const diffTime = Math.abs(returnD - borrow);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            
            if (diffDays > 0) {
                const totalCost = costPerDay * diffDays;
                
                // Update display
                document.getElementById('total-days').textContent = diffDays + ' hari';
                document.getElementById('total-cost').textContent = 'Rp ' + totalCost.toLocaleString('id-ID');
                document.getElementById('calculated-cost-section').classList.remove('hidden');
            } else {
                document.getElementById('calculated-cost-section').classList.add('hidden');
            }
        } else {
            document.getElementById('calculated-cost-section').classList.add('hidden');
        }
    }

    // Form validation before submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const borrowDate = document.getElementById('borrow_date').value;
        const returnDate = document.getElementById('return_date').value;
        
        if (borrowDate && returnDate) {
            const borrow = new Date(borrowDate);
            const returnD = new Date(returnDate);
            
            if (returnD <= borrow) {
                e.preventDefault();
                alert('Tanggal kembali harus setelah tanggal pinjam!');
                return false;
            }
        }
    });
</script>
@endsection