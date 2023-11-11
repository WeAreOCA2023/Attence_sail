<div class="myAllTasks d-flex w-100 justify-content-center align-items-center">
    <div class="jobList position-relative">
        <div class="title d-flex">
            <img src="{{ asset('img/Onprogress.svg') }}" alt="">
            <h2>未完了</h2>
        </div>
        <div class="position-absolute plusIcon">
            <a @click="$dispatch('showTaskCreate')"><img src="{{ asset('img/plus.svg') }}" alt=""></a>
        </div>
        <ul class="tasks list-unstyled">
            @foreach ($tasks as $task)
                <li class="task mb-3">
                    <a wire:click="showTask({{ $task->id }})" class="d-block h-100 text-decoration-none">
                        <span>{{ $task->title }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="job">
        <div>
            @if($taskCreate)
                <form wire:submit="save">
                    <label>
                        <span>タイトル</span>
                        <input type="text" wire:model.lazy="title" placeholder="タイトルを入力">
                        @error('title') <span>{{ $message }}</> @enderror
                    </label>
                    <label>
                        <span>詳細</span>
                        <input type="text" wire:model.lazy="description" placeholder="詳細を入力">
                        @error('description') <span>{{ $message }}</span> @enderror
                    </label>
                    <label>
                        <span>期限</span>
                        <input type="datetime-local" wire:model.lazy="deadline">
                        @error('deadline') <span>{{ $message }}</span> @enderror
                    </label>
                    <button type="submit">Save</button>
                </form>
            @endif
        </div>
        <div class="taskDetail d-flex h-100">
            @if($taskShow)
                <div class="taskMain">
                    <h2>{{ $title }}</h2>
                    <p>{{ $description }}</p>
                </div>
                <div class="taskSidebar">
                    <p>{{ $deadline }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
