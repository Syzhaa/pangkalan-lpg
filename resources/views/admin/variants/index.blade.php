@extends('layouts.admin')

@section('header')
    Manajemen Varian
@endsection

@section('content')
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-end mb-4">
            <a href="{{ route('variants.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                + Tambah Varian
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4 uppercase font-semibold text-sm text-left">No</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Nama Varian</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($variants as $index => $variant)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $variants->firstItem() + $index }}</td>
                            <td class="py-3 px-4">{{ $variant->name }}</td>
                            <td class="py-3 px-4">
                                <a href="{{ route('variants.edit', $variant->id) }}"
                                    class="text-blue-500 hover:text-blue-700">Edit</a>
                                <form action="{{ route('variants.destroy', $variant->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus varian ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 ml-2">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-3 px-4 text-center">Tidak ada data varian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $variants->links() }}
        </div>
    </div>
@endsection
