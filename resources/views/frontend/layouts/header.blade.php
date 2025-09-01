<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('frontend/style.css') }}" rel="stylesheet">
<link href="{{ asset('backend/plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />
@vite('resources/js/app.js')

<div class="nav">
    <div class="links">
        <a href="{{ route('frontend.order.index') }}">Orders</a>
        <a href="{{ route('frontend.logout') }}">Logout</a>
    </div>
</div>
