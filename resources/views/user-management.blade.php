@extends('layouts.fixed')

@section('content')
<div class="userManagement d-flex justify-content-center h-100 mx-auto py-4">
    <div class="whiteBox">
        <div class="input-group">
           <span class="svg">
                <img src="{{ asset('img/search.svg') }}" alt="searching icon">
            </span>
            <input style="font-size: 1.3rem; background: none; border: none; border-bottom: 2px solid #1C1C1C;"  class="form-control" type="text" placeholder="検索したいユーザーを入力してください" aria-label="Search" aria-describedby="search-addon" />
            <button style="width: 100px; font-size: 1.3rem; color: white; background-color: #1C1C1C" type="button" class="btn btn-outline-primary">検索</button>
        </div>    
        <div class="filterOptions d-flex justify-content-around">
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
                <!-- <tr>
                    <th scope="row">1</th>
                    <td>テスト太郎1</td>
                    <td>営業</td>
                    <td>部長</td>
                    <td>有</td>
                    <td>無</td>
                    <td>出勤中</td>
                    <td>いいえ</td>
                    <td>
                        <div class="edit-delete d-flex justify-content-around">
                            <img src="{{ asset('img/edit.svg') }}" alt="editing icon">
                            <img src="{{ asset('img/delete.svg') }}" alt="deleting icon">
                        </div>
                    </td>
                </tr> -->
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
                        <div class="edit-delete d-flex justify-content-around">
                            <img src="{{ asset('img/edit.svg') }}" alt="editing icon">
                            <img src="{{ asset('img/delete.svg') }}" alt="deleting icon">
                        </div>
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>
@endsection
