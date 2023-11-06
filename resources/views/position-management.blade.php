@extends('layouts.fixed')

@section('content')
<div class="positionManagement d-flex justify-content-center h-100 mx-auto py-4">
    <div class="allPositionsBox">
        <div class="title d-flex">
            <img src="{{ asset('img/position.svg') }}" alt="department icon">
            <h2>役職</h2>
        </div>
        @foreach ($positions as $position)
        <div class="position d-flex justify-content-around">
            <h3>{{ $position->position_name }}</h3>
            <h3>権威レベル:{{ $position->rank }}</h3>
                <div class="edit-delete">
                    <img src="{{ asset('img/edit.svg') }}" alt="editing icon">
                    <button class="deleteBtn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $position->id }}" style="border: none; background: none;">
                        <img src="{{ asset('img/delete.svg') }}" alt="deleting icon">
                    </button>
                </div>
            </div>
            
            <div class="modal fade" id="confirmDeleteModal{{ $position->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">本当に削除しますか？</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>「{{ $position->position_name }}」を削除すると、元には戻せません</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                <form class="delete" method="POST" action="{{ route('position-management.destroy',$position->id) }}">
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
        {{ $positions->links() }}
    </div>
    <div class="addPositionsBox">
        <form method="POST" action="{{ route('position-management.store') }}">
            @csrf
            <div class="position">
                <label for="positionName">{{ __('役職名') }}</label>
                <input id="positionName" type="text" name="positionName" value="{{ old('positionName') }}" required autocomplete="positionName" autofocus>
            </div>
            <div class="rank">
                <label for="rank">{{__('権威レベル')}}</label>
                <input id="rank" type="number" name="rank" value="{{ old('rank') }}" required>
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
