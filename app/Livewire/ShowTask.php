<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;

class ShowTask extends Component
{
    public function render()
    {
        return view('livewire.show-task', [
            'tasks' => Task::all(),
        ]);
    }
}
