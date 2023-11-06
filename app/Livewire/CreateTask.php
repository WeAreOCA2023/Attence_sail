<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Task;
use App\Models\UserLogin;


class CreateTask extends Component
{

    public $title = '';
    public $description = '';
    public $status = '';
    public $deadline = '';
    public $done_at = '';

    public function save()
    {
        Task::create([
            $this -> only([
                'title',
                'description',
                'status',
                'deadline',
                'done_at',
            ])
        ]);

        return $this->redirect('/tasks');
    }
    public function render()
    {
        return view('livewire.create-task');
    }
}