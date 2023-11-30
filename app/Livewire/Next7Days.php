<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Blade;
use Livewire\Component;

class Next7Days extends Component
{
    public function render()
    {
        Blade::component('each-day', EachDay::class);
        return view('livewire.next-7-days');
    }
}
