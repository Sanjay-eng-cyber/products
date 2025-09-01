<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('backend/style.css') }}" rel="stylesheet">
<link href="{{ asset('backend/plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />
@vite('resources/js/app.js')
 <meta name="csrf-token" content="{{ csrf_token() }}">
<div class="nav">
    <div class="links">
        <a href="{{ route('backend.product.index') }}">Products</a>
        <a href="{{ route('backend.orders.index') }}">Orders</a>
        <a href="{{ route('backend.logout') }}">Logout</a>
    </div>
</div>
