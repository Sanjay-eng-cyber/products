@extends('backend.layouts.app')
@section('title', 'Import Products - Admin')
@section('content')
    <h1>Import Products</h1>
    <form method="post" action="{{ route('backend.product.import.submit') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-6 mb-2">
                {{-- <label class="form-label">Import</label><br> --}}
                <input type="file" name="file" class="form-control" placeholder="Enter file" required>
                @if ($errors->has('file'))
                    <div class="text-danger" role="alert">{{ $errors->first('file') }}</div>
                @endif
            </div>
            <button type="submit" class="btn btn-primary mt-2 mb-2">Import</button>
        </div>
    </form>
@endsection
