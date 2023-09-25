@extends('layouts.app')
@section('content')
    <div class="container h-100 d-flex justify-content-center align-items-center login">
        <div class="row justify-content-center">
            <div class="col-md-6 title px-0 d-flex align-items-center">
                <img src="{{ asset('img/tree.png') }}" class="img-fluid rounded float-start" alt="木">
                <h1>ATTENCE</h1>
            </div>
            <div class="col-md-6 px-0">
                <div class="card h-100">
                    <div class="flex card-body">
                        <h2 class="text-center mb-5 h1">LOGIN</h2>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row mb-3 form-input w-50 mx-auto">
                                <label for="email" class="col-form-label">{{ __('メールアドレス') }}</label>

                                <div class="col">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3 form-input w-50 mx-auto">
                                <label for="password" class="col-form-label">{{ __('パスワード') }}</label>

                                <div class="col">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6 mx-auto d-inline-block w-auto">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('ログインしたままにする') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="login-form col-md-8 offset-md-4 text-center mx-auto d-flex align-items-start">
                                    <button type="submit" class="mb-3 w-50">
                                        {{ __('ログイン') }}
                                    </button>
                                    @if (Route::has('password.request'))
                                        <a class="text-decoration-none mx-auto" href="{{ route('password.request') }}">
                                            {{ __('パスワードをお忘れの方') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
