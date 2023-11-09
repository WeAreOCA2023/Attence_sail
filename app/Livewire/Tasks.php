<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Attributes\On;
use Livewire\Component;

class Tasks extends Component
{
    public bool $taskShow = false;
    public bool $taskCreate = false;
    public $title;
    public $description;
    public $status = 0;
    public $deadline;
    public $done_at;

    public $TaskID;

    #[On('showTaskCreate')]
    public function showTaskCreate()
    {
        $this->taskCreate = true;
        $this->taskShow = false;
    }
    #[On('showTask')]
    public function showTask($taskId)
    {
        $this->taskCreate = false;
        $this->taskShow = true;
        $this->TaskID = $taskId;

    }

    public function save()
    {
        Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'deadline' => $this->deadline,
            'done_at' => $this->done_at,
        ]);

        return $this->redirect('/tasks');
    }
    public function render()
    {
        return view('livewire.tasks', [
            'tasks' => Task::all(),
        ]);
    }
}
