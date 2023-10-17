{{--@extends('layouts.app')--}}
{{--@section('content')--}}
{{--@endsection--}}

<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('index.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/48efdb6da3.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body class="login">
    <div class="main d-flex flex-column align-items-center justify-content-between">
        <div class="logo">
            <img src="{{ asset('img/logo-white.svg') }}" alt="logo">
        </div>
        <div class="loginBox d-flex flex-column align-items-center justify-content-center">
            <div class="loginBoxInner d-flex flex-column justify-content-center align-items-center">
                <h1>LOGIN</h1>
                <form class="d-flex flex-column align-items-center justify-content-between" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="emailBox">
                        <label for="email">{{ __('メールアドレス') }}</label>
                        <div class="emailInput">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>
                    <div class="passwordBox">
                        <label for="password" class="col-form-label">{{ __('パスワード') }}</label>
                        <div class="passwordInput">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="keepLogin d-flex align-items-center">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('ログインしたままにする') }}
                        </label>
                    </div>
                    <div class="loginButton">
                        <button type="submit">
                            {{ __('LOGIN') }}
                        </button>
                    </div>
                    <div class="forgotPass">
                        @if (Route::has('password.request'))
                            <a class="text-decoration-none mx-auto text-decoration-underline" href="{{ route('password.request') }}">
                                {{ __('パスワードをお忘れの方') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
