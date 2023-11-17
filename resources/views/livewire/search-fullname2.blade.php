<div class="responsible">
    <label class="d-block" for="bossName">{{ __('責任者名') }}</label>
    <div class="responsibleInput d-flex flex-column">
        <input wire:model.live.debounce.500ms="search" type="text" name="bossEmail" value="{{ old('bossEmail') }}">
        @error ('bossEmail')
            <span class="error d-block text-center" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        @if (strlen($search) > 0)
            <ul class="list-group text-center">
                @foreach($boss_users as $boss_user)
                    @php 
                        $boss_email = DB::table('user_logins')->where('id', $boss_user->user_id)->get()[0]->email 
                    @endphp
                    <li wire:click="selectedData('{{ $boss_email }}')" class="list-group-item">{{ $boss_user->full_name }}, {{ $boss_email }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

