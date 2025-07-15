{{-- Menggunakan layout admin baru yang telah kita buat --}}
@extends('layouts.admin') {{-- Pastikan nama file layout Anda benar, misal: layouts/admin.blade.php --}}

{{-- Mengisi bagian header dari layout --}}
@section('header')
    {{ __('Profile') }}
@endsection

{{-- Mengisi bagian konten utama dari layout --}}
@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        {{-- Card untuk Update Profile Information --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Card untuk Update Password --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

    </div>
@endsection