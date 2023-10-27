@extends('layouts.auth')
@section('content')
<div class="registerBoss">
    <div class="main d-flex flex-column align-items-center justify-content-between">
        <div class="logo">
            <img src="{{ asset('img/logo-white.svg') }}" alt="logo">
        </div>
        <div class="loginBox d-flex flex-column align-items-center justify-content-center">
            <div class="loginBoxInner d-flex flex-column justify-content-center align-items-center">
                <h1>サインアップ（ボス）</h1>
                <form class="d-flex flex-column align-items-center justify-content-between" method="POST" action="{{ route('register-boss') }}">
                    @csrf
                    <div class="companyNameBox">
                        <label for="companyName" class="col-form-label">{{ __('会社名') }}</label>
                        <div class="companyNameInput">
                            <input id="companyName" type="text" class="form-control @error('companyName') is-invalid @enderror" name="companyName" value="{{ old('companyName') }}" required autocomplete="companyName" autofocus>
                            @error('companyName')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="companyCodeBox">
                        <label for="companyCode" class="col-form-label">{{ __('会社コード') }}</label>
                        <div class="companyCodeInput">
                            <input id="companyCode" type="text" class="form-control @error('companyCode') is-invalid @enderror" name="companyCode" minlength=12 maxlength=12 value="{{ old('companyCode') }}" required autocomplete="companyCode" >
                        </div>
                    </div>
                    <div class="companyPasswordBox">
                        <label for="companyPassword" class="col-form-label">{{ __('会社パスワード') }}</label>
                        <div class="companyPasswordInput">
                            <input id="companyPassword" type="password" class="form-control @error('companyPassword') is-invalid @enderror" name="companyPassword" value="{{ old('companyPassword') }}" required autocomplete="companyPassword">
                            @error('companyPassword')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="companyPostCodeBox">
                        <label for="companyPostCode" class="col-form-label">{{ __('会社の郵便番号') }}</label>
                        <div class="companyPostCodeInput">
                            <input id="companyPostCode" type="text" class="form-control @error('companyPostCode') is-invalid @enderror" name="companyPostCode" minlength=7 maxlength=7 value="{{ old('companyPostCode') }}" required autocomplete="companyPostCode">
                            @error('companyAddress')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="companyAddressBox">
                        <label for="companyAddress" class="col-form-label">{{ __('会社の住所') }}</label>
                        <div class="companyAddressInput">
                            <input id="companyAddress" type="text" class="form-control @error('companyAddress') is-invalid @enderror" name="companyAddress" value="{{ old('companyAddress') }}" required autocomplete="companyAddress">
                            @error('companyAddress')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="userNameBox">
                        <label for="userName" class="col-form-label">{{ __('ユーザー名') }}</label>
                        <div class="userNameInput">
                            <input id="userName" type="text" class="form-control @error('userName') is-invalid @enderror" name="userName" value="{{ old('userName') }}" required autocomplete="userName">
                            @error('userName')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="fullNameBox">
                        <label for="fullName" class="col-form-label">{{ __('名前') }}</label>
                        <div class="fullNameInput">
                            <input id="fullName" type="text" class="form-control @error('fullName') is-invalid @enderror" name="fullName" value="{{ old('fullName') }}" required autocomplete="fullName">
                            @error('fullName')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="emailBox">
                        <label for="email" class="col-form-label">{{ __('メールアドレス') }}</label>
                        <div class="emailInput">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="telephoneBox">
                        <label for="telephone" class="col-form-label">{{ __('電話番号') }}</label>
                        <div class="telephoneInput">
                            <input id="telephone" type="tel" class="form-control @error('telephone') is-invalid @enderror" minlength=11 maxlength=11 name="telephone" required autocomplete="telephone">
                            @error('telephone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="passwordBox">
                        <label for="password" class="col-form-label">{{ __('パスワード') }}</label>
                        <div class="passwordInput">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="passwordConfirmBox">
                        <label for="password-confirm" class="col-form-label">{{ __('パスワードの確認') }}</label>
                        <div class="passwordConfirmInput">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                    <input type="hidden" name="is_boss" value="1">
                    <div class="RegisterButton">
                        <button type="submit">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
