@extends('backend.layouts.app')
@section('title', 'Products - Admin')
@section('content')
    <h1>Products</h1>
    <div class="col-12">
        <div class="table-head">
            <a type="button" class="btn btn-primary mb-2" href="{{ route('backend.product.create') }}">Create Product</a>
            <a type="button" class="btn btn-primary mb-2" href="{{ route('backend.product.import') }}">Import Product</a>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">S.No.</th>
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Price</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $index => $p)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->category }}</td>
                        <td>{{ $p->price }}</td>
                        <td>{{ $p->stock }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('backend.product.edit', $p->id) }}">Edit</a>
                            <a class="btn btn-primary" href="{{ route('backend.product.show', $p->id) }}">View</a>
                            <a class="btn btn-danger" href="{{ route('backend.product.delete', $p->id) }}">Delete</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center">No Products Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $products->appends(Request::all())->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
