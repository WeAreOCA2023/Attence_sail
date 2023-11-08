{{--<div>--}}
{{--    @foreach ($tasks as $task)--}}
{{--        <div>--}}
{{--            <a x-data="{ taskId: {{ $task->id }} }" x-on:click="$dispatch('showTask', taskId)">--}}
{{--                <span>{{ $task->title }}</span>--}}
{{--                <span>{{ $task->description }}</span>--}}
{{--            </a>--}}
{{--        </div>--}}
{{--    @endforeach--}}
{{--</div>--}}
<div x-data>
    @foreach ($tasks as $task)
        <div>
            <a @click="$dispatch('showTask', {id: '$task->id' })">
                <span>{{ $task->title }}</span>
                <span>{{ $task->description }}</span>
            </a>
        </div>
    @endforeach
</div>
