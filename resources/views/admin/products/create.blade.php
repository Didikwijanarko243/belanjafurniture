@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

@section('content')
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="max-w-3xl space-y-6">
    @csrf
    @include('admin.products._form')

    <button type="submit"
        class="px-6 py-3 rounded-lg bg-rust text-canvas text-sm font-semibold hover:bg-rust/90 transition-colors">
        Simpan Produk
    </button>
</form>
@endsection