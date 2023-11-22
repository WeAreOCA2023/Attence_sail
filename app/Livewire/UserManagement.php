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
    protected $paginationTheme = 'bootstrap';

    // 検索用
    public $search_user = '';
    
    // 編集用
    public $editUserId;
    public $editing = false;

    // 部署・役職割り当て用
    public $assignDepartmentId;
    public $assignPositionId;

    // フィルター用
    public $filter = false;
    public $filterDepartmentId = '';
    public $filterPositionId = '';

    function departmentFilter(int $company_id){
        $users_table_pagination = User::where('company_id', $company_id)
                ->search('full_name', $this->search_user)
                ->where('department_id', $this->filterDepartmentId)
                // ->where('position_id', $this->filterPositionId)
                ->orderBy('user_id', 'asc')->get();
                // ->paginate(12);
        // dd(gettype($users_table_pagination));
        // dd(count($users_table_pagination));
        return $users_table_pagination;
    }

    function positionFilter(object $test){
        if (!is_null($this->filterPositionId)){
            // dd($test);
            // foreach ($test as $yay){
            //     $count++;
            // }
            // dd($count);
            foreach ($test as $yay){
                $test2 = $yay->where('position_id', $this->filterPositionId)->get();
                dd($test2);
            }
            dd ($test2);
            return $test2;
        }
        return $test;
    }

    public function render()
    {
        $assinable_departments = Department::select('id', 'department_name')->get();
        $assignable_positions = Position::select('id', 'position_name')->get();
        $users_info = [];
        $company_id = User::where('user_id', Auth::user()->id)->first()->company_id;
        if ($this->filter == true) {
            if (!is_null($this->filterDepartmentId) || !is_null($this->filterPositionId)) {
                $obj = $this->departmentFilter($company_id);
                // dd(gettype($obj));
                $obj2 = $this->positionFilter($obj);
                $users_table_pagination = $obj2;
                dd($users_table_pagination);
            } else {
                $this->filter = false;
                $users_table_pagination = User::where('company_id', $company_id)->search('full_name', $this->search_user)->orderBy('user_id', 'asc')->paginate(12);

            }
        } else {
            $users_table_pagination = User::where('company_id', $company_id)->search('full_name', $this->search_user)->orderBy('user_id', 'asc')->paginate(12);
        }
        // if ($this->filter == true) {
        //     if ($this->filterDepartmentId == null && $this->filterPositionId == null) {
        //         $this->filter = false;
        //     } else {
        //         if ($this->filterPositionId != null) {
        //             if (strlen($this->search_user >= 0)) {
        //                 $users_table_pagination = User::where('company_id', $company_id)
        //                 ->where('position_id', $this->filterPositionId)
        //                 ->search('full_name', $this->search_user)
        //                 ->orderBy('user_id', 'asc')
        //                 ->paginate(12);
        //             } else{
        //                 $users_table_pagination = User::where('company_id', $company_id)
        //                 ->where('position_id', $this->filterPositionId)
        //                 ->orderBy('user_id', 'asc')
        //                 ->paginate(12);
        //             }
        //         } else {
        //             $users_table_pagination = User::where('company_id', $company_id)->search('full_name', $this->search_user)->orderBy('user_id', 'asc')->paginate(12);
        //         }
        //         if ($this->filterDepartmentId != null) {
        //             if ($this->filterPositionId != null) {
        //                 if (strlen($this->search_user >= 0)) {
        //                     $users_table_pagination = User::where('company_id', $company_id)
        //                     ->where('department_id', $this->filterDepartmentId)
        //                     ->where('position_id', $this->filterPositionId)
        //                     ->search('full_name', $this->search_user)
        //                     ->orderBy('user_id', 'asc')
        //                     ->paginate(12);
        //                 } else{
        //                     $users_table_pagination = User::where('company_id', $company_id)
        //                     ->where('department_id', $this->filterDepartmentId)
        //                     ->where('position_id', $this->filterPositionId)
        //                     ->orderBy('user_id', 'asc')
        //                     ->paginate(12);
        //                 }
        //             } else {
        //                 if (strlen($this->search_user >= 0)) {
        //                     $users_table_pagination = User::where('company_id', $company_id)
        //                     ->where('department_id', $this->filterDepartmentId)
        //                     ->search('full_name', $this->search_user)
        //                     ->orderBy('user_id', 'asc')
        //                     ->paginate(12);
        //                 } else{
        //                     $users_table_pagination = User::where('company_id', $company_id)
        //                     ->where('department_id', $this->filterDepartmentId)
        //                     ->orderBy('user_id', 'asc')
        //                     ->paginate(12);
        //                 }                        
        //             }
        //         } else {
        //             $users_table_pagination = User::where('company_id', $company_id)->search('full_name', $this->search_user)->orderBy('user_id', 'asc')->paginate(12); 
        //         }


        //     }
        // } else {
        //     $users_table_pagination = User::where('company_id', $company_id)->search('full_name', $this->search_user)->orderBy('user_id', 'asc')->paginate(12);
        // }
        // if ($this->filter == true){
        //     if ($this->filterDepartmentId == null && $this->filterPositionId == null) {
        //         $this->filter = false;
        //         $users_table_pagination = User::where('company_id', $company_id)->search('full_name', $this->search_user)->orderBy('user_id', 'asc')->paginate(12);

        //     } else {
        //         if ($this->filterDepartmentId != null && $this->filterPositinoId) {

        //         }
        //         if ($this->filterDepartmentId != null) {
        //             if (strlen($this->search_user >= 0)) {
        //                 $users_table_pagination = User::where('company_id', $company_id)
        //                 ->where('department_id', $this->filterDepartmentId)
        //                 ->search('full_name', $this->search_user)
        //                 ->orderBy('user_id', 'asc')
        //                 ->paginate(12);
        //             } else{
        //                 $users_table_pagination = User::where('company_id', $company_id)
        //                 ->where('department_id', $this->filterDepartmentId)
        //                 ->orderBy('user_id', 'asc')
        //                 ->paginate(12);
        //             }
        //         } else {
        //             $users_table_pagination = User::where('company_id', $company_id)->search('full_name', $this->search_user)->orderBy('user_id', 'asc')->paginate(12);
        //         }


        //     }
        // } else {
        //     $users_table_pagination = User::where('company_id', $company_id)->search('full_name', $this->search_user)->orderBy('user_id', 'asc')->paginate(12);
        // }

        foreach ($users_table_pagination as $user_pagination) {
            $user = User::where('user_id', $user_pagination->user_id)->first();
            $user_login = UserLogin::where('id', $user->user_id)->first();
            $department_id = $user->department_id;
            if ($department_id == 0) {
                $department_name = '<span class="unset">' . '未設定' . '</span>';
            } elseif($department_id == -1){
                $department_name = '<span class="unaffliated">' . '無し' . '</span>';
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
                $status = '<span class="status-offboarding">' . '退職済' . '</span>';
            }
            $over_work = $user->over_work;
            if ($over_work == 0) {
                $over_work = '<span class="status-unoverwork">' . '正常' . '</span>';
            } else {
                $over_work = '<span class="status-overwork">' . '警告' . '</span>';
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
                'assignable_positions' => $assignable_positions,
            ];      
        }
        // if ($this->filterDepartmentId != null) {
        //     dd($users_info);
        // }
        $all_departments = Department::select('id', 'department_name')->get();
        $all_positions = Position::select('id', 'position_name')->get();
        return view('livewire.user-management', [
            'search_users' => $users_table_pagination,
            'users_info' => $users_info,
            'all_departments' => $all_departments,
            'all_positions' => $all_positions,
        ]);
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
        $user = User::where('user_id', $this->editUserId)->first();
        $user->department_id = $this->assignDepartmentId;
        $user->position_id = $this->assignPositionId;
        $user->save();
        session()->flash('successUser', 'ユーザー情報を更新しました。');
        return redirect('/user-management');
    }

    public function filterDepartment($id)
    {
        if ($id == 0) {
            $this->filterDepartmentId = '';
        }
        $this->filter = true;
        $this->filterDepartmentId = $id;
    }

    public function filterPosition($id)
    {
        if ($id == 0) {
            $this->filterPositionId = '';
        }
        $this->filter = true;
        $this->filterPositionId = $id;
    }

    public function filterDepartmentPagination()
    {
        return a;
    }
}
