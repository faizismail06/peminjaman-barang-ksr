@extends('layouts.admin')

@section('page-title', 'Kelola Peminjaman')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Daftar Peminjaman</h2>
    <p class="text-gray-600">Kelola pengajuan peminjaman barang</p>
</div>

<!-- Filter Tabs -->
<div class="mb-6 flex space-x-2 border-b">
    <a href="{{ route('admin.borrowings.index') }}" 
       class="px-4 py-2 {{ !request('status') ? 'border-b-2 border-ksr-red text-ksr-red' : 'text-gray-600 hover:text-gray-800' }}">
        Semua
    </a>
    <a href="{{ route('admin.borrowings.index', ['status' => 'pending']) }}" 
       class="px-4 py-2 {{ request('status') == 'pending' ? 'border-b-2 border-ksr-red text-ksr-red' : 'text-gray-600 hover:text-gray-800' }}">
        Pending
    </a>
    <a href="{{ route('admin.borrowings.index', ['status' => 'approved']) }}" 
       class="px-4 py-2 {{ request('status') == 'approved' ? 'border-b-2 border-ksr-red text-ksr-red' : 'text-gray-600 hover:text-gray-800' }}">
        Disetujui
    </a>
    <a href="{{ route('admin.borrowings.index', ['status' => 'rejected']) }}" 
       class="px-4 py-2 {{ request('status') == 'rejected' ? 'border-b-2 border-ksr-red text-ksr-red' : 'text-gray-600 hover:text-gray-800' }}">
        Ditolak
    </a>
    <a href="{{ route('admin.borrowings.index', ['status' => 'returned']) }}" 
       class="px-4 py-2 {{ request('status') == 'returned' ? 'border-b-2 border-ksr-red text-ksr-red' : 'text-gray-600 hover:text-gray-800' }}">
        Dikembalikan
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode / Peminjam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Unit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Biaya</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($borrowings as $borrowing)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="text-xs font-mono text-blue-600 mb-1">{{ $borrowing->code_number }}</div>
                            <div class="text-sm font-medium text-gray-900">{{ $borrowing->borrower_name }}</div>
                            <div class="text-sm text-gray-500">{{ $borrowing->phone }}</div>
                            <div class="text-sm text-gray-500">{{ $borrowing->organization }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($borrowing->borrowingItems->count() == 1)
                                <div class="text-sm font-medium text-gray-900">{{ $borrowing->borrowingItems->first()->item->name }}</div>
                                <div class="text-sm text-gray-500">{{ $borrowing->borrowingItems->first()->quantity }} unit</div>
                            @else
                                <div class="text-sm font-medium text-gray-900">{{ $borrowing->borrowingItems->count() }} jenis barang</div>
                                <div class="text-sm text-gray-500">
                                    @foreach($borrowing->borrowingItems->take(2) as $bItem)
                                        • {{ $bItem->item->name }}<br>
                                    @endforeach
                                    @if($borrowing->borrowingItems->count() > 2)
                                        <span class="text-blue-600">+{{ $borrowing->borrowingItems->count() - 2 }} lainnya</span>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $borrowing->borrowingItems->sum('quantity') }} unit</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Rp {{ number_format($borrowing->total_cost, 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-500">{{ $borrowing->total_days }} hari</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $borrowing->borrow_date->format('d/m/Y') }}</div>
                            <div class="text-sm text-gray-500">s/d {{ $borrowing->return_date->format('d/m/Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $borrowing->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $borrowing->status == 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $borrowing->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $borrowing->status == 'returned' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ ucfirst($borrowing->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.borrowings.show', $borrowing) }}" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-clipboard-list text-4xl mb-2"></i>
                            <p>Belum ada peminjaman</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($borrowings->hasPages())
        <div class="px-6 py-4 bg-gray-50">
            {{ $borrowings->links() }}
        </div>
    @endif
</div>
@endsection

