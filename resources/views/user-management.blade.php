@extends('layouts.fixed')

@section('content')
<div class="userManagement d-flex justify-content-center h-100 mx-auto py-4">
    <div class="whiteBox">
        <div class="input-group d-flex justify-content-center">
           <span class="svg">
                <img src="{{ asset('img/search.svg') }}" alt="searching icon">
            </span>
            <form method="GET" action="">
                <input style="width: 250px; font-size: 1.3rem; background: none; border: none; border-bottom: 2px solid #1C1C1C;"  type="text" placeholder="検索したいユーザーを入力してください" aria-label="Search" aria-describedby="search-addon" />
                <button style="width: 100px; font-size: 1.3rem; color: white; background-color: #1C1C1C;" type="button" name="search">検索</button>
            </form>
        </div>
        <div class="filterOptions d-flex justify-content-around mx-auto">
            <p>フィルター</p>
            <p>部署</p>
            <p>役職</p>
        </div>
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <!-- 設定 or 未設定用 -->
                    <th></th>
                    <th>名前</th>
                    <th>部署</th>
                    <th>役職</th>
                    <th>36協定</th>
                    <th>変形時間労働制</th>
                    <th>ステータス</th>
                    <th>オーバーワーク</th>
                    <!-- 編集 & 削除用 -->
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->email }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                        <div class="edit-delete">
                            <img src="{{ asset('img/edit.svg') }}" alt="editing icon">
                            <button class="deleteBtn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $user->id }}" style="border: none; background: none;">
                                <img src="{{ asset('img/delete.svg') }}" alt="deleting icon">
                            </button>
                        </div>
                    </td>
                    </tr>
                    <div class="modal fade" id="confirmDeleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">本当に削除しますか？</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @php 
                                        $users_table = DB::table('users')->where('user_id', $user->id)->get();
                                    @endphp
                                    <p>{{ $users_table->full_name }}</p>
                                    <p>「{{ $user->email }}」</p>
                                    <p>を削除すると、元には戻せません</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                    <form class="delete" method="POST" action="{{ route('user-management.destroy',$user->id) }}">
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
        {{ $users->links() }}
    </div>
</div>
@endsection
