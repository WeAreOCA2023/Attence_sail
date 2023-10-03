@extends('layouts.app')
@section('content')
<div class="container h-100 d-flex justify-content-center align-items-center register">
    <div class="row justify-content-center">
        <div class="col-md-4 px-0">
            <div class="card h-100 reset-rounded">
                <div class="flex card-body">
                    <h2 class="text-center mb-1 h1 mainColor">REGISTER-BOSS</h2>
                    <form method="POST" action="{{ route('register-boss') }}">
                        @csrf

                        <div class="row mb-1 form-input w-50 mx-auto mainColor">
                            <label for="companyName" class="col-form-label">{{ __('会社名') }}</label>

                            <div class="col">
                                <input id="companyName" type="text" class="form-control @error('companyName') is-invalid @enderror" name="companyName" value="{{ old('companyName') }}" required autocomplete="companyName" autofocus>

                                @error('companyName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-1 form-input w-50 mx-auto mainColor">
                            <label for="companyPostCode" class="col-form-label">{{ __('会社の郵便番号') }}</label>

                            <div class="col">
                                <input id="companyPostCode" type="text" class="form-control @error('companyPostCode') is-invalid @enderror" name="companyPostCode" value="{{ old('companyPostCode') }}" required autocomplete="companyPostCode">

                                @error('companyAddress')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-1 form-input w-50 mx-auto mainColor">
                            <label for="companyAddress" class="col-form-label">{{ __('会社の住所') }}</label>

                            <div class="col">
                                <input id="companyAddress" type="text" class="form-control @error('companyAddress') is-invalid @enderror" name="companyAddress" value="{{ old('companyAddress') }}" required autocomplete="companyAddress">

                                @error('companyAddress')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-1 form-input w-50 mx-auto mainColor">
                            <label for="userName" class="col-form-label">{{ __('ユーザー名') }}</label>

                            <div class="col">
                                <input id="userName" type="text" class="form-control @error('userName') is-invalid @enderror" name="userName" value="{{ old('userName') }}" required autocomplete="userName">

                                @error('userName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-1 form-input w-50 mx-auto mainColor">
                            <label for="fullName" class="col-form-label">{{ __('名前') }}</label>

                            <div class="col">
                                <input id="fullName" type="text" class="form-control @error('fullName') is-invalid @enderror" name="fullName" value="{{ old('fullName') }}" required autocomplete="fullName" autofocus>

                                @error('fullName')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-1 form-input w-50 mx-auto mainColor">
                            <label for="email" class="col-form-label">{{ __('メールアドレス') }}</label>

                            <div class="col">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-1 form-input w-50 mx-auto mainColor">
                            <label for="telephone" class="col-form-label">{{ __('電話番号') }}</label>
                            <div class="col">
                                <input id="telephone" type="tel" class="form-control @error('telephone') is-invalid @enderror" name="telephone" required autocomplete="telephone">

                                @error('telephone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-1 form-input w-50 mx-auto mainColor">
                            <label for="password" class="col-form-label">{{ __('パスワード') }}</label>

                            <div class="col">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-1 form-input w-50 mx-auto mainColor">
                            <label for="password-confirm" class="col-form-label">{{ __('パスワードの確認') }}</label>

                            <div class="col">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <input type="hidden" name="is_boss" value="1">





                        <div class="row mb-0">
                            <div class="login-form col-md-8 offset-md-4 text-center mx-auto d-flex align-items-start">
                                <button type="submit" class="text-decoration-none mx-auto">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 title px-0 d-flex align-items-center">
            <img src="{{ asset('img/tree.png') }}" class="img-fluid rounded-end float-start" alt="木">
            <div class="text-center mb-1 logo">
                <img src="{{ asset('img/logo-gray-150.png') }}" alt="logo">
            </div>
            <h1>ATTENCE</h1>
        </div>

    </div>
</div>
@endsection
