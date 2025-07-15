@extends('layouts.admin')
@section('header', 'Edit Produk')
@section('content')
    <div class="p-6 bg-white border-b border-gray-200">
        <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" name="name" id="name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        value="{{ old('name', $product->name) }}" required>
                </div>
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Gambar Produk (Kosongkan jika
                        tidak ganti)</label>
                    <input type="file" name="image" id="image"
                        class="mt-1 block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100">
                    @if ($product->image)
                        <div class="mt-2">
                            <img src="{{ Storage::url($product->image) }}" alt="Gambar Produk"
                                class="h-20 w-20 object-cover rounded">
                            <p class="mt-1 text-xs text-gray-500">Gambar saat ini</p>
                        </div>
                    @endif
                </div>
                <div>
                    <label for="variant_id" class="block text-sm font-medium text-gray-700">Varian</label>
                    <select name="variant_id" id="variant_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                        @foreach ($variants as $variant)
                            <option value="{{ $variant->id }}"
                                {{ $product->variant_id == $variant->id ? 'selected' : '' }}>{{ $variant->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="brand_id" class="block text-sm font-medium text-gray-700">Merek</label>
                    <select name="brand_id" id="brand_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="purchase_price" class="block text-sm font-medium text-gray-700">Harga Beli</label>
                    <input type="number" name="purchase_price" id="purchase_price"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        value="{{ old('purchase_price', $product->purchase_price) }}" required>
                </div>
                <div>
                    <label for="selling_price" class="block text-sm font-medium text-gray-700">Harga Jual</label>
                    <input type="number" name="selling_price" id="selling_price"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        value="{{ old('selling_price', $product->selling_price) }}" required>
                </div>
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
                    <input type="number" name="stock" id="stock"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        value="{{ old('stock', $product->stock) }}" required>
                </div>
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="description" id="description" rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('products.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Update
                    Produk</button>
            </div>
        </form>
    </div>
@endsection
