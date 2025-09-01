<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('backend/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container login-container">
        <div class="col-12">
            <h2>Login</h2>
            <form method="post" action="{{ route('frontend.login.store') }}">
                @csrf
                <div class="col-12">
                    <label class="form-label">Email</label>
                    <input name="email" type="email" placeholder="Email" class="form-control" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Password</label>
                    <input name="password" type="password" placeholder="Password" class="form-control" required>
                </div>
                @if ($errors->has('credentials'))
                    <div class="text-danger" role="alert">{{ $errors->first('credentials') }}
                    </div>
                @endif
                @if (session('alert-type') == 'success')
                    <div class="text-success" role="alert">{{ session('message') }}
                    </div>
                @endif
                <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <a href="{{ route('frontend.signUp') }}">Don’t have an account? Sign Up</a>
        </div>
    </div>
</body>

</html>
