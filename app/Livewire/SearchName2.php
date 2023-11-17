<?php
namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Department;

class SearchName2 extends Component
{
    // 検索クエリ
    public $search;

    public function selectedData($boss_email)
    {
        $this->search = $boss_email;
    }

    public function render()
    {
        return view('livewire.search-fullname2', [
            'boss_users' => User::where('full_name', 'like', '%' . $this->search . '%')->get(),
        ]);

        
    }
}
