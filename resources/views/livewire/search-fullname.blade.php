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
            @if (count($search_users) > 0)
                @foreach ($search_users as $search_user)
                    @foreach ($users_info as $user_info)
                    <tr>
                        <th scope="row">{{ $search_user['user_id'] }}</th>
                        <td>{{ $search_user['full_name'] }}</td>
                        <td>{{ $user_info['email'] }}</td>
                        <td>{!! $user_info['department_name'] !!}</td>
                        <td>{!! $user_info['position_name'] !!}</td>
                        <td>{!! $user_info['agreement_36'] !!}</td>
                        <td>{!! $user_info['variable_working_hours_system'] !!}</td>
                        <td></td>
                        <td></td>
                        <td>
                            <div class="edit-delete">
                                <img src="{{ asset('img/edit.svg') }}" alt="editing icon">
                                <button class="deleteBtn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $search_user['user_id'] }}" style="border: none; background: none;">
                                    <img src="{{ asset('img/delete.svg') }}" alt="deleting icon">
                                </button>
                            </div>
                        </td>
                    </tr>
                    <div class="modal fade" id="confirmDeleteModal{{ $search_user['user_id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">本当に削除しますか？</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>メールアドレス: {{ $user_info['email'] }}</p>
                                            <p>名前: {{ $search_user['full_name'] }}</p>
                                            <p>を削除すると、元には戻せません</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                            <form class="delete" method="POST" action="{{ route('user-management.destroy',$search_user['user_id']) }}">
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
            @endif
            </tbody>
        </table>
    </div>
</div>
