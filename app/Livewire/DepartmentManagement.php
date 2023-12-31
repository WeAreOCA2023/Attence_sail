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

class DepartmentManagement extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $editDepartmentId;
    public $editing = false;

    #[Rule('required', message: '部署名を入力してください')]
    #[Rule('max:128', message: '部署名が長すぎます')]
    #[Rule('unique:department,department_name', message: 'その部署名は既に登録されています')]
    public $save_department_name;

    public $update_department_name;

    #[Rule('required', message: '責任者名を入力してください')]
    public $search;



    public function selectedData($boss_email)
    {
        $this->search = $boss_email;
    }


    public function render()
    {
        $departments_info = [];
        $user = User::where('user_id', Auth::user()->id)->first();
        $company_id = $user->company_id;
        $departments_table_pagination = Department::where('company_id', $company_id)->paginate(17);
        foreach ($departments_table_pagination as $department_pagination) {
            $department = Department::where('id', $department_pagination->id)->first();
            $user = User::where('user_id', $department->boss_id)->first();
            $user_login = UserLogin::where('id', $user->user_id)->first();
            $departments_info[$department->id] = [
                'department_id' => $department->id,
                'department_name' => $department->department_name,
                'boss_name' => $user->full_name,
                'email' => $user_login->email,
            ];
        }
        return view('livewire.department-management', [
            'departments' => $departments_table_pagination,
            'departments_info' => $departments_info,
            'boss_users_info' => User::where(function ($query) {
                $query->where('full_name', 'like', '%' . $this->search . '%')
                      ->orWhereHas('UserLogin', function ($subQuery) {
                          $subQuery->where('email', 'like', '%' . $this->search . '%');
                      });
            })->get(),
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
        Department::create([
            'department_name' => $this->save_department_name,
            'company_id' => $user->company_id,
            'boss_id' => $boss_id->id
        ]);
        session()->flash('successDepartment', '部署を作成しました。');
        return redirect('/department-management');
    }

    public function update()
    {
        if ($this->editing == false || ($this->update_department_name == null && $this->search == null)) {
            return;
        }

        $this->validate([
            'update_department_name' => 'max:128|unique:department,department_name,' . $this->editDepartmentId,
            'search' => 'max:255'
        ], [
            'update_department_name.max' => '部署名が長すぎます',
            'update_department_name.unique' => 'その部署名は既に登録されています',
            'search.max' => '責任者名が長すぎます'
        ]);
        $user = User::where('user_id', Auth::user()->id)->first();

        $department = Department::find($this->editDepartmentId);

        // もし部署名が空 or nullじゃないなら値をsetする
        if (!empty(trim($this->update_department_name))) {
            $department->department_name = $this->update_department_name;
        }

        if (is_null($this->search))  {
            $department->save();
            session()->flash('successDepartment', '部署を更新しました。');
            return redirect('/department-management');
        }
        
        $boss_id = UserLogin::where('email', $this->search)->first();
        if ($boss_id == null) {
            session()->flash('errorDepartment', '責任者が見つかりませんでした。');
            return redirect('/department-management');
        }
        $department->boss_id = $boss_id->id;
        $department->save();
        session()->flash('successDepartment', '部署を更新しました。');
        return redirect('/department-management');
    }

    public function destroy($id)
    {
        $match = User::where('department_id', $id)->first();
        if ($match == null) {
            $department = Department::find($id);
            $department->delete();
            return redirect('/department-management');
        }
        return redirect('/department-management')->with('userExistsOnDepartment', 'この部署に所属するユーザーがいるため削除できません。');
    }
}

