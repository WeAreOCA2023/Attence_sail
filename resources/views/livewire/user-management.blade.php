<div class="userManagement d-flex justify-content-center h-100 mx-auto py-4">
    <div class="whiteBox">
        <div class="input-group d-flex justify-content-center">
           <span class="svg">
                <img src="{{ asset('img/search.svg') }}" alt="searching icon">
                <input type="text" wire:model.live.debounce.250ms="search_user" placeholder="名前を入力して検索" >
            </span>
        </div>
        <div class="filterOptions d-flex justify-content-around mx-auto">
            <p>フィルター</p>
            <p>部署</p>
            <p>役職</p>
        </div>
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th></th>
                    <th>名前</th>
                    <th>メールアドレス</th>
                    <th>部署</th>
                    <th>役職</th>
                    <th>36協定</th>
                    <th>変形時間労働制</th>
                    <th>ステータス</th>
                    <th>オーバーワーク</th>
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
                        <td>{!! $user_info['department_name'] !!}</td>
                        <td>{!! $user_info['position_name'] !!}</td>
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
                        <td>{{ $user_info['full_name'] }}</td>
                        <td>{{ $user_info['email'] }}</td>
                        <td>{!! $user_info['department_name'] !!}</td>
                        <td>{!! $user_info['position_name'] !!}</td>
                        <td>{!! $user_info['agreement_36'] !!}</td>
                        <td>{!! $user_info['variable_working_hours_system'] !!}</td>
                        <td>{!! $user_info['status'] !!}</td>
                        <td>{!! $user_info['over_work'] !!}</td>
                        <td>
                            <div class="edit-delete">
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
        <div class="text-center">
            {{ $search_users->links() }}
        </div>
    </div>
</div>