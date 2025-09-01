@extends('backend.layouts.app')
@section('title', 'Create Product - Admin')
@section('content')
    <h1>Create Product</h1>
    <form method="post" action="{{ route('backend.product.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-6">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter name" minlength="3" maxlength="60"
                    value="{{ old('name') }}" required>
                @if ($errors->has('name'))
                    <div class="text-danger" role="alert">{{ $errors->first('name') }}</div>
                @endif
            </div>
            <div class="col-6">
                <label class="form-label">Category</label>
                <select name="category" class="form-control" required>
                    <option value="">Select Any Category</option>
                    <option value="category 1" {{ old('category') == 'category 1' ? 'selected' : '' }}>Category 1</option>
                    <option value="category 2" {{ old('category') == 'category 2' ? 'selected' : '' }}>Category 2</option>
                    <option value="category 3" {{ old('category') == 'category 3' ? 'selected' : '' }}>Category 3</option>
                    <option value="category 4" {{ old('category') == 'category 4' ? 'selected' : '' }}>Category 4</option>
                </select>
                @if ($errors->has('category'))
                    <div class="text-danger" role="alert">{{ $errors->first('category') }}</div>
                @endif
            </div>
            <div class="col-6 mt-2">
                <label class="form-label">Price</label>
                <input type="text" name="price" class="form-control" placeholder="Enter Price"
                    value="{{ old('price') }}" required>
                @if ($errors->has('price'))
                    <div class="text-danger" role="alert">{{ $errors->first('price') }}</div>
                @endif
            </div>
            <div class="col-6 mt-2">
                <label class="form-label">Stock</label>
                <input type="text" name="stock" class="form-control" placeholder="Enter Stock"
                    value="{{ old('stock') }}" required>
                @if ($errors->has('stock'))
                    <div class="text-danger" role="alert">{{ $errors->first('stock') }}</div>
                @endif
            </div>
            <div class="col-6 mt-2">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control" required>
                @if ($errors->has('image'))
                    <div class="text-danger" role="alert">{{ $errors->first('image') }}</div>
                @endif
            </div>
            <div class="col-12 mt-2">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="10" minlength="3" maxlength="20000" required>{{ old('description') }}</textarea>
                @if ($errors->has('description'))
                    <div class="text-danger" role="alert">{{ $errors->first('description') }}</div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary mt-2 mb-2">Submit</button>
        </div>
    </form>
@endsection
