@extends('layouts.fixed')

@section('content')
<div class="positionManagement d-flex justify-content-center h-100 mx-auto py-4">
    <div class="allPositionsBox">
        @foreach ($positions as $position)
            <h3>{{ $position->position_name }}</h3>
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
            <div class="createButton">
                <button type="submit">
                    {{ __('作成') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
