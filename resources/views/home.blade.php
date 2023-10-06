@extends('layouts.index')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <!-- usersテーブルの情報 -->
                    <!-- {{ Auth::user()->user }} -->

                    <!-- user_loginsテーブルの情報 -->
                    <!-- {{ Auth::user() }} -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
