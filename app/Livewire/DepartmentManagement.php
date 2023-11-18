<?php
namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Department;
use App\Models\Position;

class DepartmentManagement extends Component
{
    use WithPagination;

    #[Rule('required', message: '部署名を入力してください')]
    #[Rule('max:128', message: '部署名が長すぎます')]
    #[Rule('unique:department,department_name', message: 'その部署名は既に登録されています')]
    public $department_name;

    #[Rule('required', message: '責任者名を入力してください')]
    // #[Rule('exists:user_logins,email', message: '責任者が見つかりませんでした。')]
    public $search;

    public $editDepartmentId;
    public $editing = false;

    public function selectedData($boss_email)
    {
        $this->search = $boss_email;
    }


    public function render()
    {
        $departments_info = [];
        $departments_table_pagination = Department::paginate(18);
        foreach ($departments_table_pagination as $department_pagination) {
            $department = Department::where('id', $department_pagination->id)->first();
            $user = User::where('user_id', $department->boss_id)->first();
            $user_login = UserLogin::where('id', $user->user_id)->first();
            $department_id = $user->department_id;
            $departments_info[$department_id] = [
                'department_id' => $department_id,
                'boss_name' => $user->full_name,
                'email' => $user_login->email
            ];
        }
        return view('livewire.department-management', [
            'departments' => $departments_table_pagination,
            'departments_info' => $departments_info,
            'boss_users' => User::where('full_name', 'like', '%' . $this->search . '%')->get(),

        ]);
    }
    public function edit($id)
    {
        $this->editing = true;
        $this->editDepartmentId = $id;
    }

    public function save()
    {
        $this->validate();
        $user = User::where('user_id', Auth::user()->id)->first();
        $boss_id = UserLogin::where('email', $this->search)->first();
        if ($boss_id == null) {
            session()->flash('errorDepartment', '責任者が見つかりませんでした。');
            return redirect('/department-management');
        }
        session()->forget('errorDepartment'); 
        Department::create([
            'department_name' => $this->department_name,
            'company_id' => $user->company_id,
            'boss_id' => $boss_id->id
        ]);
        session()->flash('successDepartment', '部署を作成しました。');
        return redirect('/department-management');
    }

    public function update()
    {
        $this->validate();
        $user = User::where('user_id', Auth::user()->id)->first();
        $boss_id = UserLogin::where('email', $this->search)->first();
        if ($boss_id == null) {
            session()->flash('errorDepartment', '責任者が見つかりませんでした。');
            return redirect('/department-management');
        }
        session()->forget('errorDepartment'); 
        $department = Department::find($this->editDepartmentId);
        $department->department_name = $this->department_name;
        $department->boss_id = $boss_id->id;
        $department->save();
        session()->flash('successDepartment', '部署を更新しました。');
        return redirect('/department-management');
    }
}

