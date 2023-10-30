@extends('layouts.fixed')

@section('content')
@vite(['resources/js/confirm-delete.js'])
<div class="departmentManagement d-flex justify-content-center h-100 mx-auto py-4">
    <div class="allDepartmentsBox">
        <div class="title d-flex">
            <img src="{{ asset('img/department.svg') }}" alt="department icon">
            <h2>部署</h2>
        </div>

        <div id="modalContainer"></div>

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
                    <button class="deleteBtn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $department->id }}" style="border: none; background: none;">
                        <img src="{{ asset('img/delete.svg') }}" alt="deleting icon">
                    </button>
                </div>
            </div>

            <div class="modal fade" id="confirmDeleteModal{{ $department->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">本当に削除しますか？</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>「{{ $department->department_name }}」を削除すると、元には戻せません</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                <form class="delete" method="POST" action="{{ route('department-management.destroy',$department->id) }}">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-primary">削除</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <div class="addDepartmentsBox">
        <form method="POST" action="{{ route('department-management.store') }}">
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
