<?php

namespace App\Livewire;

use App\Models\Task as TaskModel;
use App\Models\AllTasksAssign;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
// 検索クエリ
    public $search;
    public $assigner;
    public $assignUsers = [];

    #[On('showTaskCreate')]
    public function showTaskCreate()
    {
        $this->reset();
        $this->taskCreate = true;
        $this->taskShow = false;
    }
    #[On('showTask')]
    public function showTask(int $taskId)
    {
        $this->reset();
        $this->taskCreate = false;
        $this->taskShow = true;
        $this->title = TaskModel::find($taskId)->title;
        $this->description = TaskModel::find($taskId)->description;
        $this->deadline = TaskModel::find($taskId)->deadline;
        $this->assigner = User::where('user_id', TaskModel::find($taskId)->assigner_id)->value('full_name');
        $this->assignUsers = AllTasksAssign::where('task_id', $taskId)->pluck('assignee_id')->toArray();
        $this->assignUsers = User::whereIn('user_id', $this->assignUsers)->pluck('full_name')->toArray();
        dd($this->assignUsers);
    }

    #[On('doneTask')]
    public function doneTask($taskId)
    {

        $this->reset();
        $this->done_at = now();
        $deadline = TaskModel::where('id', $taskId)->value('deadline');
        if ($deadline < $this->done_at) {
            $this->status = 2;
        } else {
            $this->status = 1;
        }
        TaskModel::where('id', $taskId)->update([
            'status' => $this->status,
            'done_at' => $this->done_at,
        ]);
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
        foreach ($this->assignUsers as $assignUser) {
            $assignee_id = User::where('user_name', $assignUser)->value('user_id');
            AllTasksAssign::create([
                'assignee_id' => $assignee_id,
                'task_id' => TaskModel::latest()->first()->id,
                'assigned_at' => now(),
            ]);
        }
        return $this->redirect('/tasks');
    }
    public function render()
    {
        $user_id = Auth::user()->id;
        $company_id = User::where('user_id', $user_id)->value('company_id');
        // ログインユーザーに関連づけられたタスクを取得
        $tasks1 = TaskModel::where('assigner_id', auth()->id())
            ->where('status', 0)
            ->get();
        $tasks2Id = AllTasksAssign::where('assignee_id', auth()->id())->pluck('task_id')->toArray();
        $tasks2 = TaskModel::whereIn('id', $tasks2Id)
            ->where('status', 0)
            ->get();

        $this->tasks = $tasks1->merge($tasks2)->unique();

        $this->dispatch('buttonClicked');
        return view('livewire.tasks', [
            'users' => User::where(function ($query) use ($company_id) {
                $query->where('full_name', 'like', '%' . $this->search . '%')
                    ->Where('user_name', 'like', '%' . $this->search . '%')
                    ->where('company_id', '=', $company_id); // 会社IDが一致するユーザーを取得
            })->get()
        ]);
    }
}
