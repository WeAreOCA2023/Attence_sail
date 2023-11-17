@extends('layouts.fixed')

@section('content')
<div class="departmentManagement d-flex justify-content-center h-100 mx-auto py-4">
    <div class="allDepartmentsBox">
        <div class="title d-flex justify-content-between mb-4">
            <img src="{{ asset('img/department.svg') }}" alt="department icon">
            <h2 class="m-0">部署</h2>
        </div>
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>部署名</th>
                    <th>責任者名</th>
                    <th>責任者メールアドレス</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($departments as $department)
                @php
                    $users_table = DB::table('users')->where('user_id', $department->boss_id)->first();
                    $user_logins_table = DB::table('user_logins')->where('id', $users_table->user_id)->first();
            @endphp
            </tbody>
                <tr>
                    <td>{{ $department->department_name }}</td>
                    <td>{{ $users_table->full_name }}</td>
                    <td>{{ $user_logins_table->email }}</td>
                    <td>
                        <div class="edit-delete">
                            <img src="{{ asset('img/edit.svg') }}" alt="editing icon">
                            <button class="deleteBtn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $department->id }}" style="border: none; background: none;">
                                <img src="{{ asset('img/delete.svg') }}" alt="deleting icon">
                            </button>
                        </div>
                    </td>
                </tr>   
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
        </tbody>
    </table>
        {{ $departments->links() }}
    </div>
    <div class="addDepartmentsBox d-flex justify-content-center align-items-center">
        <form class="d-flex flex-column justify-content-between" method="POST" action="{{ route('department-management.store') }}">
            @csrf
            <div class="department">
                @if(session('successDepartment'))
                    <div class="success d-block text-center">
                        <strong>{{ session('successDepartment') }}</strong>
                    </div>
                @endif
                <label class="d-block" for="departmentName">{{ __('部署名') }}</label>
                <input id="departmentName" type="text" name="departmentName" value="{{ old('departmentName') }}" autocomplete="departmentName" autofocus>
                @error ('departmentName')
                    <span class="error d-block text-center" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="responsible">
                <label class="d-block" for="bossName">{{ __('責任者名') }}</label>
                <livewire:SearchName2 />
                @error ('bossEmail')
                    <span class="error d-block text-center" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="createButton d-block text-center">
                <button type="submit">
                    {{ __('作成') }}
                </button>
            </div>
        </form>
    </div>
</div>


@endsection
