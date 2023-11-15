<?php
namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Department;

class SearchName2 extends Component
{
    // 検索クエリ
    public $search = "";
    // 検索結果
    public $results = [];

    public function render()
    {
        if (strlen($this->search)) {
            $this->results = User::where('full_name', 'like', '%' . $this->search . '%')->get();
        } 

        return view('livewire.search-fullname2');
    }
}
