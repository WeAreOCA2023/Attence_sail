@extends('layouts.fixed')

@section('content')
<div class="departmentManagement d-flex justify-content-center h-100 mx-auto py-4">
    <div class="allDepartmentsBox">
        <div class="title d-flex">
            <img src="{{ asset('img/department.svg') }}" alt="department icon">
            <h2>部署</h2>
        </div>

        @foreach ($departments as $department)
            <div class="department d-flex justify-content-around">
                <h3>{{ $department->department_name }}</h3>
                @php
                    $bossName = DB::table('users')->where('user_id', $department->boss_id)->first()->full_name;
                @endphp
                <h3>責任者:{{ $bossName }}</h3>
                <h3>責任者ID:{{ $department->boss_id }}</h3>
                <div class="edit-delete">
                    <img src="{{ asset('img/edit.svg') }}" alt="editing icon">
                    <img src="{{ asset('img/delete.svg') }}" alt="deleting icon">
                </div>
        </div>
        @endforeach

    </div>
    <div class="addDepartmentsBox">
        <form method="POST" action="">
            @csrf
            <div class="department">
                <label for="departmentName">{{ __('部署名') }}</label>
                <input id="departmentName" type="text" name="departmentName" value="{{ old('departmentName') }}" required autocomplete="departmentName" autofocus>
            </div>

            <div class="responsible">
                <label for="bossName">{{ __('責任者名') }}</label>
                <input id="bossName" type="text" name="bossName" value="{{ old('bossName') }}" required autocomplete="bossName">
            </div>

            <div class="createButton">
                <button type="submit">
                    {{ __('作成') }}
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
