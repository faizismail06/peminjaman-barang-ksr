@extends('layouts.admin')

@section('page-title', 'Detail Peminjaman')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.borrowings.index') }}" class="text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Detail -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Detail Peminjaman</h2>
                    <p class="text-gray-600 mt-1">
                        <i class="fas fa-barcode mr-1"></i>
                        <span class="font-mono font-semibold">{{ $borrowing->code_number }}</span>
                    </p>
                </div>
                <span class="px-4 py-2 rounded-full text-sm font-semibold
                    {{ $borrowing->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                    {{ $borrowing->status == 'approved' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $borrowing->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                    {{ $borrowing->status == 'returned' ? 'bg-gray-100 text-gray-800' : '' }}">
                    {{ ucfirst($borrowing->status) }}
                </span>
            </div>

            <!-- Data Peminjam -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user text-ksr-red mr-2"></i>
                    Data Peminjam
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Nama Lengkap</p>
                        <p class="font-medium text-gray-800">{{ $borrowing->borrower_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">No. Telepon</p>
                        <p class="font-medium text-gray-800">{{ $borrowing->phone }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm text-gray-500">Instansi</p>
                        <p class="font-medium text-gray-800">{{ $borrowing->organization }}</p>
                    </div>
                </div>
            </div>

            <!-- Data Barang -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-box text-ksr-red mr-2"></i>
                    Barang yang Dipinjam ({{ $borrowing->borrowingItems->count() }} jenis)
                </h3>
                <div class="space-y-3">
                    @foreach($borrowing->borrowingItems as $borrowingItem)
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                            @if($borrowingItem->item->photo)
                                <img src="{{ asset('storage/' . $borrowingItem->item->photo) }}" alt="{{ $borrowingItem->item->name }}" class="w-16 h-16 rounded object-cover flex-shrink-0">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-box text-gray-400 text-xl"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800">{{ $borrowingItem->item->name }}</h4>
                                <p class="text-sm text-gray-600">Kategori: {{ $borrowingItem->item->category }}</p>
                                <p class="text-sm text-gray-600">{{ $borrowingItem->quantity }} unit × Rp {{ number_format($borrowingItem->price_per_day, 0, ',', '.') }}/hari × {{ $borrowing->total_days }} hari</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-ksr-red">Rp {{ number_format($borrowingItem->subtotal, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500">Subtotal</p>
                            </div>
                        </div>
                    @endforeach
                    <div class="flex justify-between items-center p-4 bg-crimson text-white rounded-lg">
                        <div>
                            <p class="text-sm opacity-90">Total Unit: {{ $borrowing->borrowingItems->sum('quantity') }} unit</p>
                            <p class="text-sm opacity-90">Durasi: {{ $borrowing->total_days }} hari</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs opacity-90">Total Biaya</p>
                            <p class="text-2xl font-bold">Rp {{ number_format($borrowing->total_cost, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jadwal -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-calendar text-ksr-red mr-2"></i>
                    Jadwal Peminjaman
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Pinjam</p>
                        <p class="font-medium text-gray-800">{{ $borrowing->borrow_date->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Kembali</p>
                        <p class="font-medium text-gray-800">{{ $borrowing->return_date->format('d F Y') }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm text-gray-500">Durasi</p>
                        <p class="font-medium text-gray-800">{{ $borrowing->total_days }} hari</p>
                    </div>
                </div>
            </div>

            <!-- SPJ Document -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-file-pdf text-ksr-red mr-2"></i>
                    Dokumen SPJ
                </h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    @if($borrowing->spj)
                        <a href="{{ asset('storage/' . $borrowing->spj) }}" target="_blank" class="flex items-center text-blue-600 hover:text-blue-800">
                            <i class="fas fa-download mr-2"></i>
                            <span class="font-medium">Download SPJ.pdf</span>
                        </a>
                    @else
                        <p class="text-gray-500">SPJ tidak tersedia</p>
                    @endif
                </div>
            </div>

            <!-- Keperluan -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Keperluan Peminjaman</h3>
                <p class="text-gray-700 bg-gray-50 p-4 rounded-lg">{{ $borrowing->purpose }}</p>
            </div>

            <!-- Catatan Admin -->
            @if($borrowing->admin_notes)
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Catatan Admin</h3>
                    <p class="text-gray-700 bg-blue-50 p-4 rounded-lg">{{ $borrowing->admin_notes }}</p>
                </div>
            @endif

            <!-- Info Approval -->
            @if($borrowing->approved_by)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-1"></i>
                        Diproses oleh <strong>{{ $borrowing->approver->name }}</strong> pada {{ $borrowing->approved_at->format('d F Y H:i') }}
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Actions -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi</h3>

            @if($borrowing->status == 'pending')
                <!-- Approve Form -->
                <form action="{{ route('admin.borrowings.approve', $borrowing) }}" method="POST" class="mb-4">
                    @csrf
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                    <textarea name="admin_notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-3" placeholder="Tambahkan catatan..."></textarea>
                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-check mr-2"></i>Setujui Peminjaman
                    </button>
                </form>

                <!-- Reject Form -->
                <form action="{{ route('admin.borrowings.reject', $borrowing) }}" method="POST">
                    @csrf
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                    <textarea name="admin_notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-3" placeholder="Alasan penolakan..." required></textarea>
                    <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition" onclick="return confirm('Yakin ingin menolak peminjaman ini?')">
                        <i class="fas fa-times mr-2"></i>Tolak Peminjaman
                    </button>
                </form>
            @elseif($borrowing->status == 'approved')
                <!-- Mark as Returned -->
                <form action="{{ route('admin.borrowings.returned', $borrowing) }}" method="POST">
                    @csrf
                    <div class="bg-blue-50 p-4 rounded-lg mb-4">
                        <p class="text-sm text-blue-700">
                            <i class="fas fa-info-circle mr-1"></i>
                            Tandai barang sudah dikembalikan untuk mengembalikan stok
                        </p>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition" onclick="return confirm('Konfirmasi bahwa barang sudah dikembalikan?')">
                        <i class="fas fa-undo mr-2"></i>Barang Dikembalikan
                    </button>
                </form>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-check-circle text-gray-400 text-4xl mb-2"></i>
                    <p class="text-gray-500">Peminjaman sudah diproses</p>
                </div>
            @endif

            <!-- Timeline Info -->
            <div class="mt-6 pt-6 border-t">
                <h4 class="text-sm font-bold text-gray-700 mb-3">Informasi</h4>
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex items-start">
                        <i class="fas fa-calendar-plus w-5 text-gray-400 mt-1"></i>
                        <div class="ml-2">
                            <p class="text-xs text-gray-500">Diajukan</p>
                            <p>{{ $borrowing->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    @if($borrowing->approved_at)
                        <div class="flex items-start">
                            <i class="fas fa-check w-5 text-gray-400 mt-1"></i>
                            <div class="ml-2">
                                <p class="text-xs text-gray-500">Diproses</p>
                                <p>{{ $borrowing->approved_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

