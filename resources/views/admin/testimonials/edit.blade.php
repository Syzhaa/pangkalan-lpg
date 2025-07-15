@extends('layouts.admin')
@section('header', 'Edit Testimoni')
@section('content')
    <div class="p-6 bg-white border-b border-gray-200">
        <form method="POST" action="{{ route('testimonials.update', $testimonial->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.testimonials._form')
        </form>
    </div>
@endsection
