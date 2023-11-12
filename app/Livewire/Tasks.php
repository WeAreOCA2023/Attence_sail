<?php

namespace App\Livewire;

use App\Models\Task as TaskModel;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Tasks extends Component
{
    public bool $taskShow = false;
    public bool $taskCreate = false;
    public $tasks;

    #[Rule('required', message: 'タイトルを入力してください')]
    #[Rule('max:50', message: 'タイトルが長すぎます')]
    public $title;

    #[Rule('required', message: '説明を入力してください')]
    public $description;

    public $status = 0;
    public $deadline;
    public $done_at;


    #[On('showTaskCreate')]
    public function showTaskCreate()
    {
        $this->reset();
        $this->taskCreate = true;
        $this->taskShow = false;
    }
    #[On('showTask')]
    public function showTask($taskId)
    {
        $this->reset();
        $this->taskCreate = false;
        $this->taskShow = true;
        $this->title = TaskModel::find($taskId)->title;
        $this->description = TaskModel::find($taskId)->description;
        $this->deadline = TaskModel::find($taskId)->deadline;
    }

    public function save()
    {
        $this->validate();

        TaskModel::create([
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
        // ログインユーザーに関連づけられたタスクを取得
        $this->tasks = TaskModel::where('assigner_id', auth()->id())->get();

        return view('livewire.tasks');
    }
}
