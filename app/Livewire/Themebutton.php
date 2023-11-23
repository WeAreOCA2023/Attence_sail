<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;

class Themebutton extends Component
{
    public $mode;
    public $type;

    public function mount()
    {
        $user_mode = User::where('user_id', auth()->user()->id)->value('theme');
        $this->type = $user_mode;
        if ($user_mode == 'light') {
            $this->mode = false;
        } else {
            $this->mode = true;
            $this->dispatch('default-theme');
        }
    }
    public function render()
    {
        return view('livewire.themebutton');
    }

    public function UpdatedMode()
    {
        $user_mode = User::where('user_id', auth()->user()->id)->value('theme');
        $this->type = $user_mode;
        if ($user_mode == 'light') {
            $this->mode = true;
            User::where('user_id', auth()->user()->id)->update(['theme' => 'dark']);
        } else {
            $this->mode = false;
            User::where('user_id', auth()->user()->id)->update(['theme' => 'light']);
        }
        $this->mode !=$this->mode;
        if ($this->mode) {
            $this->type = 'Dark';
        } else {
            $this->type = 'Light';
        }
        $this->dispatch('change-theme');
    }
}
