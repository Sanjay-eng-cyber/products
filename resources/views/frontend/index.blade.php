@extends('frontend.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <h1>Products</h1>
    <div>
        <form action="{{ route('frontend.dashboard') }}" method="GET">
            <div class="row">
                <div class="col-4">
                    <input type="number" name="min_price" placeholder="Min Price" value="{{ request('min_price') }}">
                </div>
                <div class="col-4">

                    <input type="number" name="max_price" placeholder="Max Price" value="{{ request('max_price') }}">
                </div>
                <div class="col-4">
                    <input class="form-control form-control-sm app_form_input col-md-2 mt-md-0 mt-3" type="text"
                        placeholder="Enter product name" name="q" value="{{ request('q') ?? '' }}" minlength="3"
                        maxlength="40">
                </div>
            </div>
            <input type="submit" value="Search" class="btn btn-success mt-3">
        </form>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
        @forelse ($products as $p)
            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset('storage/images/products/' . $p->image) }}" class="card-img-top" alt="product"
                        style="height: 200px">
                    <div class="card-body">
                        <h5 class="card-title">{{ ucWords($p->name) }}</h5>
                        <h5 class="card-title" style="color: red">Rs.{{ $p->price }}</h5>
                        <h5 class="card-title">{{ ucWords($p->category) }}</h5>
                        <p class="card-text">{{ $p->description }}</p>
                        <form method="post" action="{{ route('frontend.order.store') }}">
                            @csrf
                            <input name="product_id" type="hidden" value="{{ $p->id }}">
                            @if (in_array($p->id, $orderArray))
                                <p class="text-primary">Order Placed</p>
                            @else
                                <button type="submit" class="btn btn-primary">Place Order</button>
                            @endif
                            @if ($errors->has('product_id'))
                                <div role="alert" class="text-danger">{{ $errors->first('product_id') }}</div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

        @empty
            <div style="text-align: center">
                No products found
            </div>
        @endforelse
    </div>
    <div class="mt-5">
        {{ $products->appends(Request::all())->links('pagination::bootstrap-5') }}
    </div>
@endsection
