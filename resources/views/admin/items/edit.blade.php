@extends('layouts.admin')

@section('page-title', 'Edit Barang')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.items.index') }}" class="text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
</div>

<div class="bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Barang</h2>

    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <p class="font-semibold">Data belum dapat diperbarui:</p>
            <ul class="mt-2 list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.items.update', $item) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Barang <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $item->name) }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ksr-red focus:border-transparent @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jumlah Total <span class="text-red-500">*</span>
                </label>
                <input type="number" name="total_quantity" value="{{ old('total_quantity', $item->total_quantity) }}" min="0" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ksr-red focus:border-transparent @error('total_quantity') border-red-500 @enderror">
                <p class="text-sm text-gray-500 mt-1">Tersedia saat ini: {{ $item->available_quantity }} unit</p>
                @error('total_quantity')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select name="category" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ksr-red focus:border-transparent @error('category') border-red-500 @enderror">
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" @selected(old('category', $item->category) === $category)>{{ $category }}</option>
                    @endforeach
                </select>
                @error('category')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Harga (Rp) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="price" value="{{ old('price', $item->price) }}" min="0" step="0.01" required
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
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ksr-red focus:border-transparent @error('condition') border-red-500 @enderror">
                    <option value="Good" {{ old('condition', $item->condition) == 'Good' ? 'selected' : '' }}>Baik</option>
                    <option value="Minor Damage" {{ old('condition', $item->condition) == 'Minor Damage' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="Major Damage" {{ old('condition', $item->condition) == 'Major Damage' ? 'selected' : '' }}>Rusak Berat</option>
                </select>
                @error('condition')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Foto Barang
                </label>
                @if($item->photo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}" class="w-32 h-32 object-cover rounded">
                    </div>
                @endif
                <input type="file" name="photo" accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ksr-red focus:border-transparent @error('photo') border-red-500 @enderror">
                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF, WEBP (Maksimal 5MB). Kosongkan jika tidak ingin mengubah foto.</p>
                @error('photo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                </label>
                <textarea name="description" rows="4"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ksr-red focus:border-transparent @error('description') border-red-500 @enderror"
                           placeholder="Deskripsi barang (opsional)">{{ old('description', $item->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.items.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-ksr-red text-white rounded-lg hover:bg-ksr-maroon transition">
                <i class="fas fa-save mr-2"></i>Update
            </button>
        </div>
    </form>
</div>
@endsection

