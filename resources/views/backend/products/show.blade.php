@extends('backend.layouts.app')
@section('title', 'Create Product - Admin')
@section('content')
    <h1>Create Product</h1>
    <div class="row mt-2">
        <div class="col-4">
            <label class="form-label">Product Name</label><br>
            {{ $product->name }}
        </div>
        <div class="col-4">
            <label class="form-label">Product Price</label><br>
            Rs.{{ $product->price }}
        </div>
        <div class="col-4">
            <label class="form-label">Product Stock</label><br>
            {{ $product->stock }}
        </div>
        <div class="col-4">
            <label class="form-label">Category</label><br>
            {{ $product->category }}
        </div>
        <div class="col-4">
            <label class="form-label">Image</label><br>
            <img width="100" height="100" src="{{ asset('storage/images/products/' . $product->image) }}">
        </div>
        <div class="col-12">
            <label class="form-label">Description</label><br>
            {{ $product->description }}
        </div>
    </div>
@endsection
