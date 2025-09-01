<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('backend/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container col-12 signup-container">
        <h2>Sign Up</h2>
        <form method="post" action="{{ route('frontend.signUp.store') }}">
            @csrf
            <div class="col-12 mt-3">
                <label class="form-label">Name</label>
                <input name="name" class="form-control" value="{{ old('name') }}" placeholder="Name" minlength="3"
                    maxlength="60" required>
                @if ($errors->has('name'))
                    <div class="text-danger" role="alert">{{ $errors->first('name') }}</div>
                @endif
            </div>
            <div class="col-12 mt-3">
                <label class="form-label">Email</label>
                <input name="email" class="form-control" value="{{ old('email') }}" placeholder="email"
                    minlength="5" maxlength="40" required>
                @if ($errors->has('email'))
                    <div class="text-danger" role="alert">{{ $errors->first('email') }}</div>
                @endif
            </div>
            <div class="col-12 mt-3">
                <label class="form-label">Password</label>
                <input name="password" class="form-control" placeholder="Password" minlength="8" maxlength="16"
                    required>
            </div>
            <div class="col-12 mt-3">
                <label class="form-label">Confirm Password</label>
                <input name="password_confirmation" class="form-control" placeholder="Confirm password" minlength="8"
                    maxlength="16" required>
                @if ($errors->has('password'))
                    <div class="text-danger" role="alert">{{ $errors->first('password') }}</div>
                @endif
            </div>
            <div>
                <button class="btn btn-primary mt-3">Submit</button>
            </div>
        </form>
    </div>
</body>

</html>
