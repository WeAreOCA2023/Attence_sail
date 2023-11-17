<?php
namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Department;
use App\Models\Position;

class SearchName extends Component
{
    use WithPagination;
    public $search_user = '';
    // 検索結果

   
    public function render()
    {
        $users_info = [];
        $users_table_pagination = User::search('full_name', $this->search_user)->paginate(15);
        foreach ($users_table_pagination as $user_pagination) {
            $user = User::where('user_id', $user_pagination->user_id)->first();
            $user_login = UserLogin::where('id', $user->user_id)->first();
            if ($user->department_id == 0) {;
                $department_name = '<span class="unset">' . '未設定' . '</span>';
            } else {
                $department_name = Department::where('id', $user->department_id)->first()->department_name;
            }
            if ($user->position_id == 0) {
                $position_name = '<span class="unset">' . '未設定' . '</span>';
            } else {
                $position_name = Position::where('id', $user->position_id)->first()->position_name;
            }
            if ($user->agreement_36 == 0) {
                $agreement_36 = '<span class="unset">' . '未設定' . '</span>';
            } else {
                $agreement_36 = 'あり';
            }
            if ($user->variable_working_hours_system == 0) {
                $variable_working_hours_system = '<span class="unset">' . '未設定' . '</span>';
            } else {
                $variable_working_hours_system = 'あり';
            }
            // user-managementで使用するデータ
            $users_info[$user->user_id] = [
                'user_id' => $user->user_id,
                'full_name' => $user->full_name,
                'email' => $user_login->email,
                'department_name' => $department_name,
                'position_name' => $position_name,
                'agreement_36' => $agreement_36,
                'variable_working_hours_system' => $variable_working_hours_system,
            ];      
        }
    

        return view('livewire.search-fullname', [
            'search_users' => $users_table_pagination,
            'users_info' => $users_info
        ]);
    }
}
