<?php

namespace App\Livewire;

use Livewire\Component;

class HomeBtn extends Component
{
    public $elapsedTime;
    public $breakTime;
    public function receiveVariable()
    {
        $this->elapsedTime = $elapsedTime;
        $this->breakTime = $breakTime;
    }
    public function render()
    {
        return view('livewire.home-btn');
    }
}
