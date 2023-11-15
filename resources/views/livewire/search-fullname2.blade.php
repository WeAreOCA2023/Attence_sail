<div class="responsible">
    <label for="bossName">{{ __('責任者名') }}</label>
    <input wire:model.live.debounce.500ms="search" type="text" name="bossName" value="{{ old('bossName') }}" required autocomplete="bossName">
    @if (strlen($search) > 0)
        <ul>
            @foreach($boss_users as $boss_user)
                @php 
                    $boss_email = DB::table('user_logins')->where('id', $boss_user->user_id)->get()[0]->email 
                @endphp
                <li>{{ $boss_user->full_name }}, {{ $boss_email }}</li>
            @endforeach
        </ul>
    @endif
</div>