@extends('layouts.admin')
@section('header', 'Tambah Member Baru')

@section('content')
    <div class="p-6 bg-white border-b border-gray-200">
        <form method="POST" action="{{ route('members.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md"
                        value="{{ old('email') }}" required>
                    @error('email')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="phone_number" class="block font-medium text-sm text-gray-700">No. HP</label>
                    <input type="text" name="phone_number" id="phone_number" class="mt-1 block w-full rounded-md"
                        value="{{ old('phone_number') }}" required>
                    @error('phone_number')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="ktp_number" class="block font-medium text-sm text-gray-700">No. KTP</label>
                    <input type="text" name="ktp_number" id="ktp_number" class="mt-1 block w-full rounded-md"
                        value="{{ old('ktp_number') }}" required>
                    @error('ktp_number')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label for="address" class="block font-medium text-sm text-gray-700">Alamat</label>
                    <textarea name="address" id="address" rows="3" class="mt-1 block w-full rounded-md">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('members.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Simpan
                    Member</button>
            </div>
        </form>
    </div>
@endsection
