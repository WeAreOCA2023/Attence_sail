<?php

namespace App\Livewire;

use GuzzleHttp\Promise\Create;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Task;
use App\Livewire\CreateTask as CreateTask;
class TaskDetail extends Component
{
    public $task;
    public bool $taskShow = false;

    #[On('showTaskCreate')]
    public function showTaskCreate()
    {
        $this->taskShow = false;

    }
    #[On('showTask')]
    public function showTask($taskId)
    {
        $this->taskShow = true;
        $this->task = $taskId;
    }

    public function render()
    {
        return view('livewire.task-detail', [
            'tasks' => Task::all(),
        ]);
    }
}
