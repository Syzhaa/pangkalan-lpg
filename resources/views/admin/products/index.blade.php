@extends('layouts.admin')
@section('header', 'Manajemen Produk')
@section('content')
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-end mb-4">
            <a href="{{ route('products.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">+
                Tambah Produk</a>
        </div>
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">{{ session('success') }}</div>
        @endif
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4">Gambar</th>
                        <th class="py-2 px-4 text-left">Nama Produk</th>
                        <th class="py-2 px-4 text-left">Varian & Merek</th>
                        <th class="py-2 px-4 text-left">Harga Jual</th>
                        <th class="py-2 px-4 text-left">Stok</th>
                        <th class="py-2 px-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($products as $product)
                        <tr class="border-b">
                            <td class="py-2 px-4 text-center">
                                @if ($product->image)
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                        class="h-16 w-16 object-cover rounded">
                                @else
                                    <span class="text-xs">No Image</span>
                                @endif
                            </td>
                            <td class="py-2 px-4">{{ $product->name }}</td>
                            <td class="py-2 px-4">{{ $product->variant->name }} / {{ $product->brand->name }}</td>
                            <td class="py-2 px-4">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                            <td class="py-2 px-4">{{ $product->stock }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('products.edit', $product->id) }}"
                                    class="text-blue-500 hover:text-blue-700">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin hapus produk ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 ml-2">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 px-4 text-center">Tidak ada data produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $products->links() }}</div>
    </div>
@endsection
