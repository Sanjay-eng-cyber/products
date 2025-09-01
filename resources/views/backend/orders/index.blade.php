@extends('backend.layouts.app')
@section('title', 'Orders - Admin')
@section('content')
    <h1>Orders</h1>
    <div class="col-12">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">S.No.</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $index => $o)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>{{ $o->user->name }}</td>
                        <td>{{ $o->product->name }}</td>
                        <td>{{ $o->product->price }}</td>
                        <td>{{ $o->quantity }}</td>
                        <td>
                            <form method="post" action="{{ route('backend.orders.status.update') }}">
                                @csrf
                                <input type="hidden" value="{{ $o->id }}" name="order_id">
                                <div class="col-6">
                                    <label class="form-label">Update Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">Select Any</option>
                                        <option value="Pending" {{ $o->status == 'Pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="Shipped" {{ $o->status == 'Shipped' ? 'selected' : '' }}>Shipped
                                        </option>
                                        <option value="Delivered" {{ $o->status == 'Delivered' ? 'selected' : '' }}>
                                            Delivered
                                        </option>
                                    </select>
                                </div>
                                <button class="btn btn-primary mt-2" type="submit">Update</button>
                            </form>
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
            {{ $orders->appends(Request::all())->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
