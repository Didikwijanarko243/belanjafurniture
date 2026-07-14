@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit: ' . $category->name)

@section('content')
<form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="max-w-2xl space-y-6">
    @csrf
    @method('PUT')
    @include('admin.categories._form')

    <button type="submit"
        class="px-6 py-3 rounded-lg bg-rust text-canvas text-sm font-semibold hover:bg-rust/90 transition-colors">
        Simpan Perubahan
    </button>
</form>
@endsection