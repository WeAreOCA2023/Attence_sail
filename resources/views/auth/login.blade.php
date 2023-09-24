@extends('layouts.app')
@section('content')
    <div class="container login-main">
        <div class="row justify-content-center">
            <div class="col-md-6 title px-0 d-flex align-items-center">
                <img src="{{ asset('img/tree.png') }}" class="img-fluid rounded float-start" alt="木">
                <p>Attence</p>
            </div>
            <div class="col-md-6 px-0">
                <div class="card login">
                    <!-- <div class="card-header">{{ __('Login') }}</div> -->

                    <div class="card-body">
                        <h1 class="text-center login-title">ログイン</h1>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('メールアドレス') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('パスワード') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('ログインしたままにする') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="login-btn">
                                        {{ __('ログイン') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="reset-btn" href="{{ route('password.request') }}">
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
