<div>
    @foreach ($tasks as $task)
        <div>
            <a href="">
                <span>{{ $task->title }}</span>
                <span>{{ $task->description }}</span>
            </a>
        </div>
    @endforeach
</div>
