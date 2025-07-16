@extends('layouts.admin')
@section('header', 'Tambah Produk Baru')
@section('content')
    <div class="p-6 bg-white rounded-lg shadow-md">
        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Produk -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk *</label>
                    <input type="text" name="name" id="name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Gambar -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="image"
                            class="flex flex-col w-full h-32 border-2 border-dashed rounded-lg hover:bg-gray-50 hover:border-gray-300">
                            <div class="flex flex-col items-center justify-center pt-7">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="pt-1 text-sm tracking-wider text-gray-400">Upload gambar produk</p>
                            </div>
                            <input id="image" name="image" type="file" class="opacity-0" accept="image/*">
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Format: JPEG, PNG, JPG (Maks. 2MB)</p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Varian -->
                <div>
                    <label for="variant_id" class="block text-sm font-medium text-gray-700 mb-1">Varian *</label>
                    <select name="variant_id" id="variant_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="">Pilih Varian</option>
                        @foreach ($variants as $variant)
                            <option value="{{ $variant->id }}" {{ old('variant_id') == $variant->id ? 'selected' : '' }}>
                                {{ $variant->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('variant_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Merek -->
                <div>
                    <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-1">Merek *</label>
                    <select name="brand_id" id="brand_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="">Pilih Merek</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga Beli -->
                <div>
                    <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Beli *</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" name="purchase_price" id="purchase_price"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('purchase_price') }}" required>
                    </div>
                    @error('purchase_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga Jual -->
                <div>
                    <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Jual *</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" name="selling_price" id="selling_price"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('selling_price') }}" required>
                    </div>
                    @error('selling_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stok -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stok *</label>
                    <input type="number" name="stock" id="stock"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('stock') }}" required>
                    @error('stock')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label for="is_restricted" class="inline-flex items-center">
                        <input type="checkbox" name="is_restricted" id="is_restricted" class="rounded" value="1" {{ (isset($product) && $product->is_restricted) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-600">Batasi Pembelian (1 Member / 1 Gas per Bulan)</span>
                    </label>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                <a href="{{ route('products.index') }}"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Batal
                </a>
                <button type="submit"
                    class="ml-3 inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>

    <!-- Preview Gambar Script -->
    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewContainer = document.querySelector('label[for="image"]');
                    previewContainer.innerHTML = `
                        <div class="w-full h-full flex items-center justify-center">
                            <img src="${e.target.result}" alt="Preview" class="max-h-full max-w-full object-contain rounded-lg">
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
