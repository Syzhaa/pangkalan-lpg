@extends('layouts.admin')
@section('header', 'Tambah Testimoni Baru')
@section('content')
    <div class="p-6 bg-white border-b border-gray-200">
        <form method="POST" action="{{ route('testimonials.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.testimonials._form')
        </form>
    </div>
@endsection
