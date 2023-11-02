<?php

namespace App\Livewire;

use Livewire\Component;

class Task extends Component
{
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }
    public $count = 1;

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }
    public function render()
    {
        return view('task');
    }
}
