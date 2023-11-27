<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Department;


class DepartmentManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(): View
    {
        return view('department-management');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'departmentName' => ['required', 'max:128', 'unique:department,department_name'],
            'bossEmail' => ['required', 'exists:user_logins,email']
        ], [
            'departmentName.required' => '部署名は必須です。',
            'departmentName.max' => '部署名は128文字以内で入力してください。',
            'departmentName.unique' => 'その部署名は既に登録されています。',
            'bossEmail.required' => '責任者メールアドレスは必須です。',
            'bossEmail.exists' => '責任者が見つかりませんでした。'
        ]);

        if ($validator->fails()) {
            return redirect('/department-management')->withErrors($validator)->withInput();
        }
        // UserLoginテーブルからEmailが一致するレコードを取得
        $user_logins = UserLogin::where('email', $request->get('bossEmail'))->first();
        if ($user_logins == null) {
            return redirect('/department-management');
        }
        $boss_id = $user_logins->id;
        $boss_email = $user_logins->email;

        // Usersテーブルからuser_idが一致するレコードを取得
        $users = User::where('user_id', $boss_id)->first();
        $boss_full_name = $users->full_name;



        $department = new Department ([
            'department_name' => $request->get('departmentName'),
            'company_id' => $users->company_id,
            'boss_id' => $users->user_id
        ]);
        $department->save();
        return redirect('/department-management')->with('successDepartment', '部署を作成しました。');
    }


    public function update(Request $request, string $id)
    {
        //
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
