@extends('layouts.admin')

@section('page-title', 'Tambah Barang')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.items.index') }}" class="text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Barang Baru</h2>

    <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Barang <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('nama_barang') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ksr-red focus:border-transparent @error('nama_barang') border-red-500 @enderror">
                @error('nama_barang')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jumlah Total <span class="text-red-500">*</span>
                </label>
                <input type="number" name="total_quantity" value="{{ old('jumlah_total', 0) }}" min="0" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ksr-red focus:border-transparent @error('jumlah_total') border-red-500 @enderror">
                @error('jumlah_total')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Harga (Rp) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="price" value="{{ old('price', 0) }}" min="0" step="0.01" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ksr-red focus:border-transparent @error('price') border-red-500 @enderror">
                @error('price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Kondisi <span class="text-red-500">*</span>
                </label>
                <select name="condition" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ksr-red focus:border-transparent @error('kondisi') border-red-500 @enderror">
                    <option value="Good" {{ old('kondisi') == 'Good' ? 'selected' : '' }}>Baik</option>
                    <option value="Minor Damage" {{ old('kondisi') == 'Minor Damage' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="Major Damage" {{ old('kondisi') == 'Major Damage' ? 'selected' : '' }}>Rusak Berat</option>
                </select>
                @error('kondisi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Foto Barang
                </label>
                <input type="file" name="photo" accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ksr-red focus:border-transparent @error('foto') border-red-500 @enderror">
                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF (Max: 2MB)</p>
                @error('foto')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                </label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ksr-red focus:border-transparent @error('deskripsi') border-red-500 @enderror"
                          placeholder="Deskripsi barang (opsional)">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.items.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-ksr-red text-white rounded-lg hover:bg-ksr-maroon transition">
                <i class="fas fa-save mr-2"></i>Simpan
            </button>
        </div>
    </form>
</div>
@endsection

