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
use Illuminate\Http\Request;

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
    public $filterDepartmentId = null;
    public $filterPositionId = null;
    public $filterStatusId = null;
    public $filterOverWorkId = null;
    public $filterUnset = false;

    // フィルター内容表示
    public $filterDepartmentName = '部署';
    public $filterPositionName = '役職';
    public $filterStatusName = 'ステータス';
    public $filterOverWorkName = '超過労働';



    public function render()
    {
        $assinable_departments = Department::select('id', 'department_name')->get();
        $assignable_positions = Position::select('id', 'position_name')->get();
        $users_info = [];
        $company_id = User::where('user_id', Auth::user()->id)->first()->company_id;
        if ($this->filter == true) {
            $filteredDepartment = $this->departmentFilter($company_id);
            $filteredPosition = $this->positionFilter($filteredDepartment);
            $filteredStatus = $this->statusFilter($filteredPosition);
            $filteredOverWork = $this->overWorkFilter($filteredStatus);
            $users_table_pagination = $filteredOverWork;
        } else {
            $users_table_pagination = User::where('company_id', $company_id)->search('full_name', $this->search_user)->orderBy('user_id', 'asc')->get();
        }
        foreach ($users_table_pagination as $user_pagination) {
            $unsetCount = 0;
            $user = User::where('user_id', $user_pagination->user_id)->first();
            $user_login = UserLogin::where('id', $user->user_id)->first();
            $department_id = $user->department_id;
            if ($department_id == 0) {
                $department_name = '<span class="unset">' . '未設定' . '</span>';
                $unsetCount++;
            } elseif($department_id == -1){
                $department_name = '<span class="unaffliated">' . '無し' . '</span>';
            } else {
                $department_name = Department::where('id', $department_id)->first()->department_name;
            }
            $position_id = $user->position_id;
            if ($position_id == 0) {
                $position_name = '<span class="unset">' . '未設定' . '</span>';
                $unsetCount++;
            } else {
                $position_name = Position::where('id', $position_id)->first()->position_name;
            }
            $agreement_36 = $user->agreement_36;
            if ($agreement_36 == 0) {
                $agreement_36 = '<span class="unset">' . '未設定' . '</span>';
                $unsetCount++;
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
                $unsetCount++;
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
            if ($this->filterUnset == true && !$unsetCount > 0) {
                continue;
            }
            // user-managementで使用するデータ
            $users_info[$user->user_id] = [
                'user_id' => $user->user_id,
                'full_name' => $user->full_name,
                'email' => $user_login->email,
                'department_id' => $department_id,
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
        // dd($users_info);


        $all_departments = Department::select('id', 'department_name')->get();
        $all_positions = Position::select('id', 'position_name')->get();
        return view('livewire.user-management', [
            'search_users' => $users_table_pagination,
            'users_info' => $users_info,
            'all_departments' => $all_departments,
            'all_positions' => $all_positions
        ]);
    }

    /**
     * ユーザーを編集する
     */
    public function edit(int $id): void
    {
        $this->editing = true;
        $this->editUserId = $id;
    }

    /**
     * 部署・役職を更新する
     */
    public function update()
    {
        if ($this->assignDepartmentId == null || $this->assignPositionId == null)
        {
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

    /**
     * 役職でフィルターをかける
     */
    public function filterPosition(int $id): void
    {
        $this->filterPositionId = $id;
        if ($this->filter == true && $this->filterPositionId == null && $this->filterDepartmentId == null && $this->filterStatusId == null && $this->filterOverWorkId == null) {
            $this->filterPositionId = null;
            $this->filter = false;
        } elseif (($this->filter == false && $this->filterPositionId == -2) || ($this->filter == true && $this->filterPositionId == -2)) {
            $this->filterPositionId = null;
            $this->filterPositionName = null;
        } else {
            $this->filter = true;
            $this->filterPositionId = $id;
        }
    }

    /**
     * 役職でフィルターをかける際に使用する関数
     */
    public function positionFilter(object $filteredDepartment): object
    {
        if (!is_null($this->filterPositionId)) {
            $filteredPosition  = $filteredDepartment->where('position_id', $this->filterPositionId);
            $this->filterPositionName = Position::where('id', $this->filterPositionId)->first()->position_name;
            return $filteredPosition;
        }
        return $filteredDepartment;
    }
    /**
     * 部署でフィルターをかける
     */
    public function filterDepartment(int $id): void
    {
        $this->filterDepartmentId = $id;
        if ($this->filter == true && $this->filterDepartmentId == null && $this->filterPositionId == null && $this->filterDepartmentId == null && $this->filterStatusId == null && $this->filterOverWorkId == null) {
            $this->filterDepartmentId = null;
            $this->filter = false;
        } elseif (($this->filter == false && $this->filterDepartmentId == -2) || ($this->filter == true && $this->filterDepartmentId == -2)) {
            $this->filterDepartmentId = null;
        } else {
            $this->filter = true;
            $this->filterDepartmentId = $id;
        }
    }

    /**
     * 部署でフィルターをかける際に使用する関数
     */
    public function departmentFilter(int $company_id): object
    {
        if (!is_null($this->filterDepartmentId)) {
            $filteredDepartment = User::where('company_id', $company_id)
                ->search('full_name', $this->search_user)
                ->where('department_id', $this->filterDepartmentId)
                ->orderBy('user_id', 'asc')->get();
            $this->filterDepartmentName = Department::where('id', $this->filterDepartmentId)->first()->department_name;
            return $filteredDepartment;
        }
        $noFilter = User::where('company_id', $company_id)->search('full_name', $this->search_user)->orderBy('user_id', 'asc')->get();
        return  $noFilter;
    }

    /**
     * ステータスでフィルターをかける
     */
    public function filterStatus(int $id): void
    {
        $this->filterStatusId = $id;
        if ($this->filter == true && $this->filterPositionId == null && $this->filterDepartmentId == null && $this->filterStatusId == null && $this->filterOverWorkId == null) {
            $this->filterStatusId = null;
            $this->filter = false;
        } elseif (($this->filter == false && $this->filterStatusId == -2) || ($this->filter == true && $this->filterStatusId == -2)) {
            $this->filterStatusId = null;
        } else {
            $this->filter = true;
            $this->filterStatusId = $id;
        }
    }

    /**
     * ステータスでフィルターをかける際に使用する関数
     */
    public function statusFilter($filteredPosition): object
    {
        if (!is_null($this->filterStatusId)) {
            $filteredStatus = $filteredPosition->where('status', $this->filterStatusId);
            if ($this->filterStatusId == 0) {
                $this->filterStatusName = '未出勤';
            } elseif ($this->filterStatusId == 1) {
                $this->filterStatusName = '出勤中';
            } elseif ($this->filterStatusId == 2) {
                $this->filterStatusName =  '休憩中';
            } elseif ($this->filterStatusId == 3) {
                $this->filterStatusName = '休職中';
            } else {
                $this->filterStatusName = '退職済';
            }
            return $filteredStatus;
        }
        return $filteredPosition;
    }

    /**
     * 超過労働でフィルターをかける
     */
    public function filterOverWork(int $id): void
    {
        $this->filterOverWorkId = $id;
        if ($this->filter == true && $this->filterPositionId == null && $this->filterDepartmentId == null && $this->filterStatusId == null && $this->filterOverWorkId == null) {
            $this->filterOverWorkId = null;
            $this->filter = false;
        } elseif (($this->filter == false && $this->filterOverWorkId == -2) || ($this->filter == true && $this->filterOverWorkId == -2)) {
            $this->filterOverWorkId = null;
        } else {
            $this->filter = true;
            $this->filterOverWorkId = $id;
        }
    }
    /**
     * 超過労働でフィルターをかける際に使用する関数
     */
    public function overWorkFilter($filteredStatus): object
    {
        if (!is_null($this->filterOverWorkId)) {
            $filteredOverWork = $filteredStatus->where('over_work', $this->filterOverWorkId);
            if ($this->filterOverWorkId == 0) {
                $this->filterOverWorkName = '正常';
            } elseif($this->filterOverWorkId == 1) {
                $this->filterOverWorkName = '警告';
            } else {
                $this->filterOverWorkName = '超過労働';
            }
            return $filteredOverWork;
        }
        return $filteredStatus;
    }

    /**
     * 未設定に対してフィルターをかける
     */
    public function unsetFilter(): void
    {
        $this->filterUnset = true;
    }

    /**
     * フィルターをクリアする
     */
    public function clearFilter(): void
    {
        $this->filter = false;
        $this->filterDepartmentId = null;
        $this->filterPositionId = null;
        $this->filterStatusId = null;
        $this->filterOverWorkId = null;
        $this->filterUnset = false;
    }
}
