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
                    <a wire:click="showTask({{ $task->id }})">
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
                    <label>
                        <span>タイトル</span>
                        <input type="text" wire:model.lazy="title" placeholder="タイトルを入力">
                        @error('title') <span>{{ $message }}</span> @enderror
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
        <div>
            @if($taskShow)
                <div>
                    <h2>{{ $title }}</h2>
                    <p>{{ $description }}</p>
                    <p>{{ $deadline }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
