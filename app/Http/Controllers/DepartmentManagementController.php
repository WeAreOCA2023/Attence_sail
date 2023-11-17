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
    public function index(): View
    {
        $departments_info = [];
        $department_table_pagination =  DB::table('department')->paginate(18);
        foreach ($department_table_pagination as $department_pagination) {
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
        return view('department-management', [
            'departments' => $department_table_pagination,
            'departments_info' => $departments_info
        ]);
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

    public function destroy($id)
    {
        $department = Department::find($id);
        $department->delete();
        return redirect('/department-management');
    }
}
