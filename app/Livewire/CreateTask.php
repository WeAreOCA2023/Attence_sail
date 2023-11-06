<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;


class CreateTask extends Component
{
    public $title;
    public $description;
    public $status;
    public $deadline;
    public $done_at;

    public function index()
    {
        return view('my-all-tasks');
    }
    public function save()
    {
        Task::create([
            'title' => $this->title,
//            'description' => $this->description,
//            'status' => $this->status,
//            'deadline' => $this->deadline,
//            'done_at' => $this->done_at,
        ]);

//        $this->redirect('/tasks');
    }
    public function render()
    {
        return view('livewire.create-task');
    }
}
