<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield('title')
    </title>
</head>

<body>
    @include('backend.layouts.header')
    <div class="container">
        @yield('content')
    </div>
    @include('backend.layouts.footer')
    {{-- js files --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('backend/plugins/notification/snackbar/snackbar.min.js') }}"></script>
    <script>
        @if (Session::get('alert-type') == 'success')
            @if (Session::has('message'))
                Snackbar.show({
                    text: "{{ Session::get('message') }}",
                    pos: 'top-right',
                    actionTextColor: '#fff',
                    backgroundColor: '#1abc9c'
                });
            @endif
        @elseif (Session::get('alert-type') == 'info')
            @if (Session::has('message'))
                Snackbar.show({
                    text: "{{ Session::get('message') }}",
                    pos: 'top-right',
                    actionTextColor: '#fff',
                    backgroundColor: '#2196f3'
                });
            @endif
        @elseif (Session::get('alert-type') == 'error')
            @if (Session::has('message'))
                Snackbar.show({
                    text: "{{ Session::get('message') }}",
                    pos: 'top-right',
                    actionTextColor: '#fff',
                    backgroundColor: '#e7515a'
                });
            @endif
        @else
            @if (Session::has('message'))
                Snackbar.show({
                    text: "{{ Session::get('message') }}",
                    pos: 'top-right',
                    actionTextColor: '#fff',
                    backgroundColor: '#3b3f5c'
                });
            @endif
        @endif
    </script>
</body>

</html>
