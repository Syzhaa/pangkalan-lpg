@extends('layouts.admin')
@section('header', 'Pengaturan Website')

@section('content')
    <div class="p-6 bg-white border-b border-gray-200 rounded-lg shadow-sm">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-8">

                {{-- Pengaturan Teks --}}
                <div>
                    <label for="base_name" class="block font-medium text-sm text-gray-700">Nama Pangkalan</label>
                    <input type="text" name="base_name" id="base_name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        value="{{ old('base_name', $settings['base_name'] ?? '') }}">
                </div>
                <div>
                    <label for="slogan" class="block font-medium text-sm text-gray-700">Slogan</label>
                    <input type="text" name="slogan" id="slogan"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        value="{{ old('slogan', $settings['slogan'] ?? '') }}">
                </div>
                <div>
                    <label for="address" class="block font-medium text-sm text-gray-700">Alamat</label>
                    <textarea name="address" id="address" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('address', $settings['address'] ?? '') }}</textarea>
                </div>
                <div>
                    <label for="email" class="block font-medium text-sm text-gray-700">Email Kontak</label>
                    <input type="email" name="email" id="email"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        value="{{ old('email', $settings['email'] ?? '') }}">
                </div>
                <div>
                    <label for="phone" class="block font-medium text-sm text-gray-700">No. Telepon</label>
                    <input type="text" name="phone" id="phone"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        value="{{ old('phone', $settings['phone'] ?? '') }}">
                </div>

                {{-- Pengaturan Gambar --}}
                <div class="border-t pt-6">
                    <label for="logo" class="block font-medium text-sm text-gray-700">Logo (Kosongkan jika tidak ingin
                        ganti)</label>
                    <input type="file" name="logo" id="logo"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    @if (!empty($settings['logo']))
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 mb-2">Logo Saat Ini:</p>
                            {{-- 
                                KOREKSI: Gunakan Storage::url() untuk membuat URL yang benar.
                                Controller menyimpan path relatif seperti 'settings/logo_123.png'.
                                Storage::url() akan mengubahnya menjadi URL publik yang benar: '/storage/settings/logo_123.png'.
                            --}}
                            <img src="{{ Storage::url($settings['logo']) }}" alt="Logo Saat Ini"
                                class="h-20 bg-gray-100 p-2 rounded shadow-sm">
                        </div>
                    @endif
                </div>
                <div class="border-t pt-6">
                    <label for="hero_image" class="block font-medium text-sm text-gray-700">Gambar Hero (Kosongkan jika
                        tidak ingin ganti)</label>
                    <input type="file" name="hero_image" id="hero_image"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    @if (!empty($settings['hero_image']))
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 mb-2">Gambar Hero Saat Ini:</p>
                            {{-- KOREKSI: Sama seperti logo, gunakan Storage::url() --}}
                            <img src="{{ Storage::url($settings['hero_image']) }}" alt="Gambar Hero Saat Ini"
                                class="h-32 w-auto bg-gray-100 p-2 rounded shadow-sm">
                        </div>
                    @endif
                </div>

            </div>

            <div class="flex items-center justify-end mt-8 border-t pt-6">
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
@endsection
