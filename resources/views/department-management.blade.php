@extends('layouts.fixed')

@section('content')
<div class="departmentManagement d-flex justify-content-center h-100 mx-auto py-4">
    <div class="allDepartmentsBox">
        <div class="title d-flex">
            <img src="{{ asset('img/department.svg') }}" alt="department icon">
            <h2>部署</h2>
        </div>
            <div class="department">
              
                <div class="edit-delete">
                    <img src="{{ asset('img/edit.svg') }}" alt="editing icon">
                    <img src="{{ asset('img/delete.svg') }}" alt="deleting icon">
                </div>
            </div>
    </div>
    <div class="addDepartmentsBox">
        <form method="POST" action="">
            @csrf
            <div class="department">
                <label for="department">{{ __('部署名') }}</label>
                <input id="department" type="text" name="email" value="{{ old('department') }}" required autocomplete="department">
            </div>

            <div class="responsible">
                <label for="responsible">{{ __('責任者名') }}</label>
                <input id="responsible" type="responsible" name="responsible" value="{{ old('responsible') }}" required autocomplete="responsible"> 
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
