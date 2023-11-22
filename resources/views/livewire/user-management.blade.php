<div class="userManagement d-flex justify-content-center h-100 mx-auto py-4">
    <div class="whiteBox">
        <div class="input-group d-flex justify-content-center">
           <span class="svg">
                <img src="{{ asset('img/search.svg') }}" alt="searching icon">
                <input type="text" wire:model.live.debounce.250ms="search_user" placeholder="名前を入力して検索" >
            </span>
        </div>
        <div class="filter-group d-flex justify-content-center align-items-center">
            <div class="filter-position dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    部署
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" wire:click="isClickedDepartment(0)">取り消す</a></li>
                    @foreach ($all_departments as $department)
                        <li><a class="dropdown-item" wire:click="isClickedDepartment({{ $department->id }})">{{ $department->department_name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="filter-department dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    役職
                </a>

                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" wire:click="isClickedPosition(0)">取り消す</a></li>
                    @foreach ($all_positions as $position)
                        <li><a class="dropdown-item" wire:click="isClickedPosition({{ $position->id }})">{{ $position->position_name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="filter-status dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    ステータス
                </a>

                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">未出勤</a></li>
                    <li><a class="dropdown-item" href="#">出勤中</a></li>
                    <li><a class="dropdown-item" href="#">休憩中</a></li>
                    <li><a class="dropdown-item" href="#">休職中</a></li>
                    <li><a class="dropdown-item" href="#">退職済</a></li>
                </ul>
            </div>
            <div class="filter-overwork dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    超過労働
                </a>

                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">正常</a></li>
                    <li><a class="dropdown-item" href="#">警告</a></li>
                </ul>
            </div>
            <div class="">
                <h3>filter:{{ $this->filter }}</h3>
                <h3>filterDepartment:{{ $this->filterDepartmentId }}</h3>
                <h3>filterPosition:{{ $this->filterPositionId }}</h3>
            </div>
        </div>


        @if(session('unselect'))
            <div class="error d-block text-center">
                <strong>{{ session('unselect') }}</strong>
            </div>
        @endif
        @if(session('errorBossDepartment'))
            <div class="error d-block text-center">
                <strong>{{ session('errorBossDepartment') }}</strong>
            </div>
        @endif
        @if(session('successDeleteUser'))
            <div class="success d-block text-center">
                <strong>{{ session('successUser') }}</strong>
            </div>
        @endif
        @if(session('successUser'))
            <div class="success d-block text-center">
                <strong>{{ session('successUser') }}</strong>
            </div>
        @endif
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th></th>
                    <th>名前</th>
                    <th>メールアドレス</th>
                    <th>部署</th>
                    <th>役職</th>
                    <th class="th-agreement36">36協定</th>
                    <th class="th-variable_working_hours_system">変形労働時間制</th>
                    <th class="th-status">ステータス</th>
                    <th class="th-overwork">超過労働</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @if (strlen($search_users) > 0)
                @foreach ($users_info as $user_info)
                    @if ($editing == true && $editUserId === $user_info['user_id'])
                    <tr>
                        <th scope="row">{{ $user_info['user_id'] }}</th>
                        <td>{{ $user_info['full_name'] }}</td>
                        <td>{{ $user_info['email'] }}</td>
                        <td class="td-department">
                            <select wire:click="filterDepartment({{ $user_info['department_id'] }})" class="form-select" aria-label="assignable departments">
                                <option selected>選択してください</option>
                                <option value="1">無し</option>
                                @foreach ($user_info['assignable_departments'] as $assignable_department)
                                    <option value="{{ $assignable_department->id }}">{{ $assignable_department->department_name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select wire:model="assignPositionId" class="form-select" aria-label="asignable positions">
                                <option selected>選択してください</option>
                                @foreach ($user_info['assignable_positions'] as $assignable_position)
                                    <option value="{{ $assignable_position->id }}">{{ $assignable_position->position_name }}</option>
                                @endforeach
                        </td>
                        <td>{!! $user_info['agreement_36'] !!}</td>
                        <td>{!! $user_info['variable_working_hours_system'] !!}</td>
                        <td>{!! $user_info['status'] !!}</td>
                        <td>{!! $user_info['over_work'] !!}</td>
                        <td>
                            <div class="save-cancel d-flex justify-content-between align-items-center">
                                <button wire:click="update({{ $user_info['user_id'] }})">
                                    <img class="saveImg" src="{{ asset('img/save.svg') }}" alt="saving icon">
                                </button>
                                <button wire:click="$set('editing', false)" class="cancelBtn btn-primary">
                                    <img class="cancelImg" src="{{ asset('img/cancel.svg') }}" alt="canceling icon">
                                </button>
                            </div>
                        </td>
                    </tr>
                    @else
                    <tr>
                        <th scope="row">{{ $user_info['user_id'] }}</th>
                        <td class="td-fullName">{{ $user_info['full_name'] }}</td>
                        <td class="td-email">{{ $user_info['email'] }}</td>
                        <td class="td-department">{!! $user_info['department_name'] !!}</td>
                        <td  class="td-position">{!! $user_info['position_name'] !!}</td>
                        <td>{!! $user_info['agreement_36'] !!}</td>
                        <td>{!! $user_info['variable_working_hours_system'] !!}</td>
                        <td>{!! $user_info['status'] !!}</td>
                        <td>{!! $user_info['over_work'] !!}</td>
                        <td class="td-Btn">
                            <div class="edit-delete d-flex justify-content-between align-items-center">
                                <button wire:click="edit({{ $user_info['user_id'] }})">
                                    <img src="{{ asset('img/edit.svg') }}" alt="editing icon">
                                </button>                                
                                <button class="deleteBtn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $user_info['user_id'] }}">
                                    <img src="{{ asset('img/delete.svg') }}" alt="deleting icon">
                                </button>
                            </div>
                        </td>
                    </tr>
                    <div class="modal fade" id="confirmDeleteModal{{ $user_info['user_id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">本当に削除しますか？</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>メールアドレス: {{ $user_info['email'] }}</p>
                                            <p>名前: {{ $user_info['full_name'] }}</p>
                                            <p>を削除すると、元には戻せません</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                            <form class="delete" method="POST" action="{{ route('user-management.destroy',$user_info['user_id']) }}">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-primary">削除</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    
                @endforeach
            @endif
            </tbody>
        </table>

    </div>
</div>
