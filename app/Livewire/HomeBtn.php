<?php

namespace App\Livewire;

use Livewire\Component;

class HomeBtn extends Component
{
    public $elapsedTime;
    public $breakTime;
    protected $listeners = ['updateTimes' => 'receiveVariable'];

    public function mount()
    {
        // デフォルト値を設定
        $this->elapsedTime = 0;
        $this->breakTime = 0;
    }

    public function receiveVariable($elapsedTime, $breakTime)
    {
        $this->elapsedTime = $elapsedTime;
        $this->breakTime = $breakTime;
        echo $this->elapsedTime;
    }
    public function render()
    {
        return view('livewire.home-btn');
    }
}
