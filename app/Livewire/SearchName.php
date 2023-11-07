<?php
namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\UserLogin;

class SearchName extends Component
{
    use WithPagination;
    public $search_user = '';
    // 検索結果

   
    public function render()
    {
        $user_login_info = UserLogin::all();
        $user_logins = [];

        foreach ($user_login_info as $user_login) {
            $user_logins[$user_login->id] = $user_login;
        }


        return view('livewire.search-fullname', [
            'test_users' => User::search('full_name', $this->search_user)->paginate(15),
            'users_login_info' => $user_logins,
        ]);
    }

    // public function updatedSearch()
    // {
    //     $this->resetPage();
    // }


    // public function render()
    // {
        // $searched_users = User::where('full_name', 'like', '%'.$this->search.'%')->paginate(10);
    //     $test_users = User::paginate(10);
    //     $user_login_info = UserLogin::all();
    //     $user_logins = [];
    //     foreach ($user_login_info as $user_login) {
    //         $user_logins[$user_login->id] = $user_login;
    //     }
    //     return view('livewire.search-fullname', [
    //         'test_users' => $test_users,
    //         'users_login_info' => $user_logins
    //     ]);
 
    // }
}
