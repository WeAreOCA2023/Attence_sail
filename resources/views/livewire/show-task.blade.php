<div>
    @foreach ($tasks as $task)
        <div>
            <a @click="$dispatch('showTask')">
                <span>{{ $task->title }}</span>
                <span>{{ $task->description }}</span>
            </a>
        </div>
    @endforeach
</div>
