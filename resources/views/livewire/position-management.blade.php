<div class="positionManagement d-flex justify-content-center h-100 mx-auto py-4">
    <div class="allPositionsBox">
        <div class="title d-flex justify-content-between align-items-center mb-4">
            <span class="position"></span>
            <h2 class="m-0">役職</h2>
        </div>
        @if(session('userExistsOnPosition'))
            <div class="error d-block text-center">
                <strong>{{ session('userExistsOnPosition') }}</strong>
            </div>
        @endif
        <div class="positionOuterBox d-flex flex-column justify-content-between">
            @foreach ($positions as $position)
            <div class="positionBox d-flex justify-content-center">
                <div class="positionInnerBox d-flex align-items-center">
                    <div class="content d-flex justify-content-around">
                        <h3 class="positionName m-0 d-flex align-items-center">{{ $position->position_name }}</h3>
                        <h3 class="rank m-0 d-flex align-items-center">権威レベル:{{ $position->rank }}</h3>
                        @if ($editing == true && $editPositionId == $position->id)
                        <div class="editing d-flex justify-content-center align-items-center text-center">
                            <h3 class="m-0">編集中</h3>
                        </div>
                        @else
                        <div class="edit-delete d-flex justify-content-between">
                            <span wire:click="edit({{ $position->id }})"  class="edit"></span>
                            <span class="delete" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $position->id }}"></span>
                        </div>
                        @endif
                    </div>
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
            <div class="pagination-link d-flex justify-content-center">
                {{ $positions->links() }}
            </div>
        </div>
    </div>
    <div class="addPositionsBox d-flex justify-content-center align-items-center">
        @if ($editing == true)
        <form wire:submit="update" class="d-flex flex-column justify-content-between">
            @csrf
            <div class="position">
                <label class="d-block" for="positionName">{{ __('役職名') }}</label>
                <input id="positionName" type="text" wire:model='update_position_name' value="{{ old('positionName') }}" autocomplete="off" autofocus>
                @error ('update_position_name')
                    <span class="error d-block text-center" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="rank">
                <label class="d-block" for="rank">{{ __('権威レベル (0~100の範囲)') }}</label>
                <input id="rank" type="text" wire:model="rank" value="{{ old('rank') }}" autocomplete="off">
                @error ('rank')
                    <span class="error d-block text-center" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @error ('typeNumber')
                    <span class="error d-block text-center" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
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
        @else
        <form wire:submit="save" class="d-flex flex-column justify-content-between">
            @csrf
            <div class="position">
                @if(session('successPosition'))
                    <div class="success d-block text-center">
                        <strong>{{ session('successPosition') }}</strong>
                    </div>
                @endif
                <label class="d-block" for="positionName">{{ __('役職名') }}</label>
                <input id="positionName" type="text" wire:model='save_position_name' value="{{ old('positionName') }}" autocomplete="off" autofocus>
                @error ('save_position_name')
                    <span class="error d-block text-center" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="rank">
                <label class="d-block" for="rank">{{ __('権威レベル (0~100の範囲)') }}</label>
                <input id="rank" type="text" wire:model="rank" value="{{ old('rank') }}" autocomplete="off">
                @error ('rank')
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
        @endif
    </div>
</div>