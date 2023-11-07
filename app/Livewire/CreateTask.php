<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Task;
use App\Models\UserLogin;
use Livewire\Attributes\On;


class CreateTask extends Component
{

    public $title = '';
    public $description = '';
    public $status = 1;
    public $deadline = null;
    public $done_at = null;

    public bool $buttonVisible = true;

    #[On('showTask')]
    public function showTask()
    {
        $this->buttonVisible = true;
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
        return view('livewire.create-task');
    }
}
