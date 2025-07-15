@extends('layouts.admin')

@section('header', 'Manajemen Merek')

@section('content')
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-end mb-4">
            <a href="{{ route('brands.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                + Tambah Merek
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">No</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Nama Merek</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($brands as $index => $brand)
                    <tr class="border-b">
                        <td class="py-3 px-4">{{ $brands->firstItem() + $index }}</td>
                        <td class="py-3 px-4">{{ $brand->name }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('brands.edit', $brand->id) }}"
                                class="text-blue-500 hover:text-blue-700">Edit</a>
                            <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin hapus?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-3 px-4 text-center">Tidak ada data merek.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $brands->links() }}
        </div>
    </div>
@endsection
