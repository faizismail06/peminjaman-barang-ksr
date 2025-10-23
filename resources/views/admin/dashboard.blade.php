@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-box text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Total Barang</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalItems }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Pending</p>
                <p class="text-2xl font-bold text-gray-800">{{ $pendingBorrowings }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Disetujui</p>
                <p class="text-2xl font-bold text-gray-800">{{ $approvedBorrowings }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-clipboard-list text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Total Peminjaman</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalBorrowings }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Peminjaman -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Peminjaman Terbaru</h2>
        @if($recentBorrowings->count() > 0)
            <div class="space-y-4">
                @foreach($recentBorrowings as $borrowing)
                    <div class="border-l-4 {{ $borrowing->status == 'pending' ? 'border-yellow-500' : ($borrowing->status == 'approved' ? 'border-green-500' : 'border-gray-500') }} pl-4 py-2">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $borrowing->borrower_name }}</p>
                                <p class="text-sm text-gray-600">{{ $borrowing->item->name }} ({{ $borrowing->quantity }} unit)</p>
                                <p class="text-xs text-gray-500">{{ $borrowing->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $borrowing->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $borrowing->status == 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $borrowing->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $borrowing->status == 'returned' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ ucfirst($borrowing->status) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('admin.borrowings.index') }}" class="mt-4 block text-center text-ksr-red hover:text-ksr-maroon">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        @else
            <p class="text-gray-500 text-center py-8">Belum ada peminjaman</p>
        @endif
    </div>

    <!-- Low Stock Alert -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Peringatan Stok Rendah</h2>
        @if($lowStockItems->count() > 0)
            <div class="space-y-4">
                @foreach($lowStockItems as $item)
                    <div class="flex justify-between items-center p-4 bg-red-50 rounded-lg border border-red-200">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $item->name }}</p>
                            <p class="text-sm text-gray-600">{{ $item->code }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-red-600">{{ $item->available_quantity }}</p>
                            <p class="text-xs text-gray-500">unit tersisa</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-check-circle text-green-500 text-4xl mb-2"></i>
                <p class="text-gray-500">Semua stok barang aman</p>
            </div>
        @endif
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
    <a href="{{ route('admin.items.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg p-6 hover:from-blue-600 hover:to-blue-700 transition shadow-md">
        <i class="fas fa-plus-circle text-3xl mb-2"></i>
        <h3 class="text-xl font-bold">Tambah Barang Baru</h3>
        <p class="text-sm opacity-90">Tambahkan barang ke inventaris</p>
    </a>

    <a href="{{ route('admin.borrowings.index', ['status' => 'pending']) }}" class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-lg p-6 hover:from-yellow-600 hover:to-yellow-700 transition shadow-md">
        <i class="fas fa-hourglass-half text-3xl mb-2"></i>
        <h3 class="text-xl font-bold">Verifikasi Peminjaman</h3>
        <p class="text-sm opacity-90">{{ $pendingBorrowings }} pengajuan menunggu</p>
    </a>

    <a href="{{ route('admin.items.index') }}" class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg p-6 hover:from-purple-600 hover:to-purple-700 transition shadow-md">
        <i class="fas fa-warehouse text-3xl mb-2"></i>
        <h3 class="text-xl font-bold">Kelola Inventaris</h3>
        <p class="text-sm opacity-90">Lihat dan update barang</p>
    </a>
</div>
@endsection

