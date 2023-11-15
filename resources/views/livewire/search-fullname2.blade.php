<div class="responsible">
    <label for="bossName">{{ __('責任者名') }}</label>
    <input wire:model.live.debounce.500ms="search" type="text" name="bossName" value="{{ old('bossName') }}" required autocomplete="bossName">
    @if (sizeof($results) > 0)
        <ul>
            @foreach ($results as $result)
                <li class="flex-center break-all p-4">
                  <span>{{$result->full_name}}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>