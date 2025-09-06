@extends('frontend.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <h1>Orders</h1>
    <div class="row row-cols-1 row-cols-md-5 g-4">
        @forelse ($orders as $or)
            <div class="col">
                <div class="card" style="width: 200px">
                    <img src="{{ asset('storage/images/products/' . $or->product->image) }}" class="card-img-top"
                        alt="product" style="height: 150px">
                    <div class="card-body">
                        <h5 class="card-title">{{ $or->product->name }}</h5>
                        <p class="card-text">Rs.{{ $or->product->price }}</p>
                        <p class="card-text">Quantity : {{ $or->quantity }}</p>
                        <span class="btn btn-primary" id="status-{{ $or->id }}">{{ $or->status }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div>No orders found</div>
        @endforelse
    </div>
@endsection
<script type="module">
    document.addEventListener('DOMContentLoaded', () => {
        if (!window.Echo) {
            console.warn("Laravel Echo not loaded yet.");
            return;
        }
        const orders = @json($orders->pluck('id')); // all order IDs
        const userId = @json(auth()->id());
        // console.log(userId);
        orders.forEach(orderId => {
            window.Echo.private(`orders.${orderId}`)
                .listen('.OrderStatusUpdated', (notification) => {
                    // console.log("📢 Notification:", notification);
                    document.getElementById(`status-${notification.order_id}`).textContent =
                        notification.status;
                    showNotification(notification.message);
                });

        });

        // Simple function for popup (can replace with SweetAlert, Toastify, etc.)
        function showNotification(message) {
            // console.log(status);
            Snackbar.show({
                text: message,
                pos: 'top-right',
                actionTextColor: '#fff',
                backgroundColor: '#1abc9c'
            });
        }

        window.Echo.private(`App.Models.User.${userId}`)
            .notification((notification) => {
                console.log(notification.product_name); // App\Notifications\NewMessageNotification
                console.log(notification.status); // "Hello from broadcast!"
            });
    });
</script>
