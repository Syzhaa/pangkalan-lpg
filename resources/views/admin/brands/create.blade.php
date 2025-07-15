@extends('layouts.admin')

@section('header', 'Tambah Merek Baru')

@section('content')
    <div class="p-6 bg-white border-b border-gray-200">
        <form method="POST" action="{{ route('brands.store') }}">
            @csrf
            <div>
                <label for="name" class="block font-medium text-sm text-gray-700">Nama Merek</label>
                <input type="text" name="name" id="name"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('name') }}" required
                    autofocus>
                @error('name')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('brands.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
