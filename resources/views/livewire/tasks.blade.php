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
        @if($taskCreate)
            <div class="createJob h-100">
                <form wire:submit="save" class="h-100">
                    <label class="d-block title">
                        <input type="text" wire:model.lazy="title" placeholder="タイトルを入力" class="title">
                        @error('title') <span>{{ $message }}</span> @enderror
                    </label>
                    <label class="d-block assign" wire:ignore>
                        <select class="userSelect" multiple="multiple" wire:model="assignUsers">
                            @foreach($users as $user)
                                <option>{{ $user->user_name }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="d-block deadline">
                        <span>期限</span>
                        <input type="datetime-local" wire:model.lazy="deadline" class="ms-5">
                        @error('deadline') <span>{{ $message }}</span> @enderror
                    </label>
                    <label class="d-block description">
                        <span>詳細</span>
                        @error('description') <span>{{ $message }}</span> @enderror
                        <textarea type="text" wire:model.lazy="description" placeholder="詳細を入力" class="d-block w-100"></textarea>
                    </label>
                    <label class="submit d-block text-center">
                        <button type="submit"><img src="{{ asset('img/submit.svg') }}" alt="登録"></button>
                    </label>
                </form>
            </div>
        @endif
        @if($taskShow)
            <div class="taskDetail d-flex h-100">
                <div class="taskMain">
                    <h2>{{ $title }}</h2>
                    <p>{{ $description }}</p>
                </div>
                <div class="taskSidebar">
                    <p>{{ $deadline }}</p>
                </div>
            </div>
        @endif
    </div>
</div>
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('buttonClicked', () => {
            $('.userSelect').on('change', function (e) {
                let data = $(this).val();
                @this.set('assignUsers', data);
            });
            $(document).ready(function() {
                $('.userSelect').select2();
            });
        })
    })
</script>
