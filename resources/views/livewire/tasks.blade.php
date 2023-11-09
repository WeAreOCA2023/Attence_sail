<div class="myAllTasks d-flex w-100 justify-content-center align-items-center">
    <div class="jobList position-relative">
        <div class="title d-flex">
            <img src="{{ asset('img/Onprogress.svg') }}" alt="">
            <h2>未完了</h2>
        </div>
        <div class="position-absolute plusIcon">
            <a @click="$dispatch('showTaskCreate')"><img src="{{ asset('img/plus.svg') }}" alt=""></a>
        </div>
        <div>
            @foreach ($tasks as $task)
                <div>
                    <a @click="$dispatch('showTask', {{ $task->id }})">
                        <span>{{ $task->title }}</span>
                        <span>{{ $task->description }}</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <div class="job">
        <div>
            @if($taskCreate)
                <form wire:submit="save">
                    <input type="text" wire:model.lazy="title" placeholder="タイトルを入力">
                    <input type="text" wire:model.lazy="description" placeholder="詳細を入力">
                    <button type="submit">Save</button>
                </form>
            @endif
        </div>
        <div>
            @if($taskShow)
                <div>
                    <h2>{{ $this->eachTask }}</h2>
                </div>
            @endif
        </div>
    </div>
</div>
