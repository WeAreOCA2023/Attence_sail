<?php
namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\UserLogin;

class SearchName2 extends Component
{
    use WithPagination;
    public $search_user = '';
    // 検索結果

   
    public function render()
    {

    }
}
