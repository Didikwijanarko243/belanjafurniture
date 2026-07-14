@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('page-title', 'Edit: ' . $product->name)

@section('content')
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="max-w-3xl space-y-6">
    @csrf
    @method('PUT')
    @include('admin.products._form')

    <button type="submit"
        class="px-6 py-3 rounded-lg bg-rust text-canvas text-sm font-semibold hover:bg-rust/90 transition-colors">
        Simpan Perubahan
    </button>
</form>
@endsection