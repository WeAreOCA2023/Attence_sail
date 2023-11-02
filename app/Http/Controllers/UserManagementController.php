<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Department;

class UserManagementController extends Controller
{
    public function index(): View
    {
        $users = DB::table('users')->paginate(15);
        $userLoginlData = [];
        foreach ($users as $user) {
            $userLoginlData[$user->user_id] = UserLogin::query()->where('id', $user->user_id)->first();
            $department = Department::query()->where('id', $user->department_id)->first();
            if ($user->department_id == null) {
                $department = '未設定';
            } else {
                $department = $department->department_name;
            }
        }

        return view('user-management', [
            'users' => DB::table('users')->paginate(15),
            'userLoginData' => $userLoginlData,
            'department' => $department
        ]);
    }

    public function search(Request $request): View
    {
        $search = $request->input('search');
        $users = User::query()
            ->where('full_name', 'LIKE', "%{$search}%")
            ->paginate(15);

        return view('user-management', [
            'users' => $users
        ]);
    }

    public function destroy($id)
    {
        $user = UserLogin::find($id);
        $user->delete();
        return redirect('/user-management');
    }
}
