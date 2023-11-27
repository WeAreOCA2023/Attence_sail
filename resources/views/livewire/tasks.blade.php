<div class="myAllTasks d-flex w-100 justify-content-center align-items-center">
    <div class="jobList position-relative">
        <div class="title d-flex">
            <div class="icon"></div>
            <h2>未完了</h2>
        </div>
        <div class="position-absolute plusIcon">
            <div @click="$dispatch('showTaskCreate')"></div>
        </div>
        <ul class="tasks list-unstyled">
            @foreach ($tasks as $task)
                <li class="task mb-3 d-flex align-items-center" id="{{ $task->id }}" data-task-id="{{ $task->id }}">
                    <div class="check d-flex h-50"></div>
                    <span wire:click="showTask({{ $task->id }})" class="d-flex h-100 w-100 align-items-center">{{ $task->title }}</span>
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
        $('.check').on('click', function (e) {
            $(this).toggleClass('checked');
            let taskId = $(this).closest('.task').data('task-id');
            window.setTimeout(function(){
                Livewire.dispatch('doneTask', {taskId: taskId});
            }, 500);
        });
    })

    $(".select2-6r3r-container-choice-xm0f-testuser").select2({
        // width: 'resolve'
        color: 'black'// need to override the changed default
    });
</script>
