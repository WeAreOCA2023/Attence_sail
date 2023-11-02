@extends('layouts.fixed')

@section('content')
    <div class="myAllTasks d-flex w-100 justify-content-center align-items-center">
        <div class="jobList">
            <div class="title d-flex">
                <img src="{{ asset('img/Onprogress.svg') }}" alt="">
                <h2>未完了</h2>
            </div>
        </div>
        <div class="job">

        </div>
    </div>
@endsection
