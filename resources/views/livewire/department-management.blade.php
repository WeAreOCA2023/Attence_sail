<div class="departmentManagement d-flex justify-content-center h-100 mx-auto py-4">
    <div class="allDepartmentsBox">
        <div class="title d-flex justify-content-between align-items-center mb-4">
            <span class="department"></span>
            <h2 class="m-0">部署</h2>
        </div>
        @if(session('userExistsOnDepartment'))
            <div class="error d-block text-center">
                <strong>{{ session('userExistsOnDepartment') }}</strong>
            </div>
        @endif
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>部署名</th>
                    <th>責任者名</th>
                    <th>責任者Eメール</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            
                @foreach ($departments_info as $department_info)
                    <tr>
                        <td>{{ $department_info['department_name'] }}</td>
                        <td>{{ $department_info['boss_name'] }}</td>
                        <td>{{ $department_info['email'] }}</td>
                        <td>
                            @if ($editing == true && $editDepartmentId == $department_info['department_id'])
                            <div class="editing d-flex justify-content-center align-items-center text-center">
                                <h3 class="m-0">編集中</h3>
                            </div>
                            @else
                                <div class="edit-delete d-flex">
                                    <span wire:click="edit({{ $department_info['department_id'] }})" class="edit"></span>
                                    <span class="delete" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $department_info['department_id'] }}"></span>
                                </div>
                            @endif
                        </td>
                    </tr>   
                    <div class="modal fade" id="confirmDeleteModal{{ $department_info['department_id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">本当に削除しますか？</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>「{{ $department_info['department_name'] }}」を削除すると、元には戻せません</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                        <button wire:click="destroy({{ $department_info['department_id'] }})" class="btn btn-primary">削除</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
        <div class="pagination-link d-flex justify-content-center align-items-center">
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
                <input id="departmentName" type="text" wire:model="update_department_name" value="{{ old('departmentName') }}" autocomplete="off" autofocus>
                @error ('update_department_name')
                    <span class="error d-flex justify-content-center" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="responsible mx-auto">
                <label class="d-block" for="bossName">{{ __('責任者名またはEメール') }}</label>
                <div class="responsibleInput d-flex flex-column">
                    <input wire:model.live.debounce.500ms="search" type="text" name="bossEmail" value="{{ old('bossEmail') }}" autocomplete="off">
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
                    @error ('needBoss')
                        <span class="error d-block text-center" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @if (strlen($search) > 0)
                    <ul class="list-group">
                            @foreach($boss_users_info as $boss_user_info)
                                @php 
                                    $boss_email = DB::table('user_logins')->where('id', $boss_user_info->user_id)->get()[0]->email;
                                    $profile_image = DB::table('users')->where('user_id', $boss_user_info->user_id)->get()[0]->profile_image;
                                @endphp
                                <li wire:click="selectedData('{{ $boss_email }}')" class="list-group-item d-flex">
                                    @if (is_null($profile_image))
                                    <span class="defaultProfileImageBoss"></span>
                                    @else
                                    <img class="setProfileImageBoss" src="{{ $profile_image }}" alt="Profile Icon">
                                    @endif
                                    <div class="d-flex flex-column text-start">
                                        <p class="m-0">{{ $boss_user_info->full_name }}</p>
                                        <p class="m-0">{{ $boss_email }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
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
                <div class="departmentInput">
                    <input id="departmentName" type="text" wire:model="save_department_name" value="{{ old('departmentName') }}" autocomplete="off" autofocus>
                    @error ('save_department_name')
                        <span class="error d-flex justify-content-center" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="responsible mx-auto">
                <label class="d-block" for="bossName">{{ __('責任者名またはEメール') }}</label>
                <div class="responsibleInput d-flex flex-column">
                    <input wire:model.live.debounce.500ms="search" type="text" name="bossEmail" value="{{ old('bossEmail') }}" autocomplete="off">
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
                    @if (strlen($search) > 0)
                        <ul class="list-group">
                            @foreach($boss_users_info as $boss_user_info)
                                @php 
                                    $boss_email = DB::table('user_logins')->where('id', $boss_user_info->user_id)->get()[0]->email;
                                    $profile_image = DB::table('users')->where('user_id', $boss_user_info->user_id)->get()[0]->profile_image;
                                @endphp
                                <li wire:click="selectedData('{{ $boss_email }}')" class="list-group-item d-flex">
                                    @if (is_null($profile_image))
                                    <span class="defaultProfileImageBoss"></span>
                                    @else
                                    <img class="setProfileImageBoss" src="{{ $profile_image }}" alt="Profile Icon">
                                    @endif
                                    <div class="d-flex flex-column text-start">
                                        <p class="m-0">{{ $boss_user_info->full_name }}</p>
                                        <p class="m-0">{{ $boss_email }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
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