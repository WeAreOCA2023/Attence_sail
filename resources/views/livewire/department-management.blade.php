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
                @foreach ($departments_info as $department_info)
                    <tr class="{{ $editDepartmentId === $department->id ? 'editing-row' : '' }}">
                        <td>{{ $department->department_name }}</td>
                        <td>{{ $department_info['boss_name'] }}</td>
                        <td>{{ $department_info['email'] }}</td>
                        <td>
                            <div class="edit-delete d-flex">
                            <button  wire:click="edit({{ $department->id }})" class="editBtn btn-primary">
                                <img src="{{ asset('img/edit.svg') }}" alt="editing icon">
                            </button>
                                <button class="deleteBtn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $department->id }}">
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
        @endforeach
        </tbody>
    </table>
    <div class="mt-4 text-center">
        {{ $departments->links() }}
    </div>
    </div>
    <div class="addDepartmentsBox d-flex justify-content-center align-items-center">
        @if ($editing == true)
        <form wire:submit="update" class="d-flex flex-column justify-content-between">
            @csrf
            <div class="department mx-auto">
                @if(session('successDepartment'))
                    <div class="success d-block text-center">
                        <strong>{{ session('successDepartment') }}</strong>
                    </div>
                @endif
                <label class="d-block" for="departmentName">{{ __('部署名') }}</label>
                <input id="departmentName" type="text" wire:model="department_name" value="{{ old('departmentName') }}" autocomplete="departmentName" autofocus>
                @error ('department_name')
                    <span class="error d-flex justify-content-center" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="responsible mx-auto">
                <label class="d-block" for="bossName">{{ __('責任者名') }}</label>
                <div class="responsibleInput d-flex flex-column">
                    <input wire:model.live.debounce.500ms="search" type="text" name="bossEmail" value="{{ old('bossEmail') }}">
                    @if (strlen($search) > 0)
                        <ul class="list-group d-flex flex-column justify-content-center align-items-center">
                            @foreach($boss_users as $boss_user)
                                @php 
                                    $boss_email = DB::table('user_logins')->where('id', $boss_user->user_id)->get()[0]->email 
                                @endphp
                                <li wire:click="selectedData('{{ $boss_email }}')" class="list-group-item">{{ $boss_user->full_name }}, {{ $boss_email }}</li>
                            @endforeach
                        </ul>
                    @endif
                    @error ('search')
                        <span class="error d-block text-center" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @error ('errorDepartment')
                   
                        <span class="error d-block text-center" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="BtnGroup d-flex justify-content-between align-items-center">
                <div class="cancelButton">
                    <button wire:click="$set('editing', false)">
                        {{ __('キャンセル') }}
                    </button>
                </div>
                <div class="createButton">
                    <button type="submit">
                        {{ __('保存') }}
                    </button>
                </div>
            </div>
        </form>
        @else
        <form wire:submit="save" class="d-flex flex-column justify-content-between">
            @csrf
            <div class="department mx-auto">
                @if(session('successDepartment'))
                    <div class="success d-block text-center">
                        <strong>{{ session('successDepartment') }}</strong>
                    </div>
                @endif
                <label class="d-block" for="departmentName">{{ __('部署名') }}</label>
                <input id="departmentName" type="text" wire:model="department_name" value="{{ old('departmentName') }}" autocomplete="departmentName" autofocus>
                @error ('department_name')
                    <span class="error d-flex justify-content-center" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="responsible mx-auto">
                <label class="d-block" for="bossName">{{ __('責任者名') }}</label>
                <div class="responsibleInput d-flex flex-column">
                    <input wire:model.live.debounce.500ms="search" type="text" name="bossEmail" value="{{ old('bossEmail') }}">
                    @if (strlen($search) > 0)
                        <ul class="list-group d-flex flex-column justify-content-center align-items-center">
                            @foreach($boss_users as $boss_user)
                                @php 
                                    $boss_email = DB::table('user_logins')->where('id', $boss_user->user_id)->get()[0]->email 
                                @endphp
                                <li wire:click="selectedData('{{ $boss_email }}')" class="list-group-item">{{ $boss_user->full_name }}, {{ $boss_email }}</li>
                            @endforeach
                        </ul>
                    @endif
                    @error ('search')
                        <span class="error d-block text-center" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @error ('errorDepartment')
                        <span class="error d-block text-center" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="createButton d-block text-center">
                <button type="submit">
                    {{ __('作成') }}
                </button>
            </div>
        </form>
        @endif
    </div>
</div>