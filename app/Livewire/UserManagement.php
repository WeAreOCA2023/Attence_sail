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

class UserManagement extends Component
{
    use WithPagination;
    public $search_user = '';
    // 検索結果

    public $editUserId;
    public $editing = false;

    public $assignDepartmentId;
    public $assignPositionId;

   
    public function render()
    {
        $assinable_departments = Department::select('id', 'department_name')->get();
        $assignable_positions = Position::select('id', 'position_name')->get();
        $users_info = [];
        $company_id = User::where('user_id', Auth::user()->id)->first()->company_id;
        $users_table_pagination = User::where('company_id', $company_id)->search('full_name', $this->search_user)->orderBy('user_id', 'asc')->paginate(12);
        foreach ($users_table_pagination as $user_pagination) {
            $user = User::where('user_id', $user_pagination->user_id)->first();
            $user_login = UserLogin::where('id', $user->user_id)->first();
            $department_id = $user->department_id;
            if ($department_id == 0) {
                $department_name = '<span class="unset">' . '未設定' . '</span>';
            } else {
                $department_name = Department::where('id', $department_id)->first()->department_name;
            }
            $position_id = $user->position_id;
            if ($position_id == 0) {
                $position_name = '<span class="unset">' . '未設定' . '</span>';
            } else {
                $position_name = Position::where('id', $position_id)->first()->position_name;
            }
            $agreement_36 = $user->agreement_36;
            if ($agreement_36 == 0) {
                $agreement_36 = '<span class="unset">' . '未設定' . '</span>';
            } elseif ($agreement_36 == 1) {
                $agreement_36 = '有り';
            } elseif ($agreement_36 == 2) {
                $agreement_36 = '特別条項付き';
            } else {
                $agreement_36 = '無し';
            }
            $variable_working_hours_system = $user->variable_working_hours_system;
            if ($variable_working_hours_system == 0) {
                $variable_working_hours_system = '<span class="unset">' . '未設定' . '</span>';
            } elseif ($variable_working_hours_system == 1) {
                $variable_working_hours_system = '有り';
            } else {
                $variable_working_hours_system = '無し';
            }
            $status = $user->status;
            if ($status == 0) {
                $status = '<span class="status-offline">' . '未出勤' . '</span>';
            } elseif ($status == 1) {
                $status = '<span class="status-online">' . '出勤中' . '</span>';
            } elseif ($status == 2) {
                $status = '<span class="status-break">' . '休憩中' . '</span>';
            } elseif ($status == 3) {
                $status = '<span class="status-leave">' . '休職中' . '</span>';
            } else {
                $status = '<span class="status-offboarding">' . '退職済み' . '</span>';
            }
            $over_work = $user->over_work;
            if ($over_work == 0) {
                $over_work = '<span class="status-unoverwork">' . '正常' . '</span>';
            } else {
                $over_work = '<span class="status-overwork">' . '過労警告' . '</span>';
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
                'status' => $status,
                'over_work' => $over_work,
                'assignable_departments' => $assinable_departments,
                'assignable_positions' => $assignable_positions
            ];      
        }
    

        return view('livewire.user-management', [
            'search_users' => $users_table_pagination,
            'users_info' => $users_info
        ]);
    }

    public function setAssignDepartmentId($id)
    {
        dd($id);
        $this->assingDepartmentId = $id;
    }
    public function setAssignPositionId($id)
    {
        dd($id);
        $this->assingPositionId = $id;
    }

    public function edit($id)
    {
        $this->editing = true;
        $this->editUserId = $id;
    }

    public function update()
    {
        if ($this->assignDepartmentId == null or $this->assignPositionId == null) {
            session()->flash('unselect', '部署と役職を選択してください。');
            return redirect('/user-management');
        }
        $user = User::find($this->editUserId)->first();
        dd($user->full_name);
        $user->department_id = $this->assignDepartmentId;
        $user->position_id = $this->assignPositionId;
        $user->save();
        session()->flash('successUser', 'ユーザー情報を更新しました。');
        return redirect('/user-management');
    }
}
