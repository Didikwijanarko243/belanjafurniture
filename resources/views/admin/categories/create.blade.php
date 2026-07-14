@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')

@section('content')
<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="max-w-2xl space-y-6">
    @csrf
    @include('admin.categories._form')

    <button type="submit"
        class="px-6 py-3 rounded-lg bg-rust text-canvas text-sm font-semibold hover:bg-rust/90 transition-colors">
        Simpan Kategori
    </button>
</form>
@endsection