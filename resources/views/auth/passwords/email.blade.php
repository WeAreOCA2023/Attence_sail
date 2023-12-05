
@extends('layouts.auth')
@section('content')
<div class="container d-flex justify-content-center align-items-center h-100 mx-auto py-4">
    <div class="card">
        <div class="card-header">{{ __('パスワード再設定') }}</div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="row mt-4">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Eメール :') }}</label>
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="mt-5 d-block mx-auto">
                    {{ __('メールを送信') }}
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
