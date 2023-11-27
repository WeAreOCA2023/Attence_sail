<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\UserLogin;
use App\Models\User;
use App\Models\Department;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(): View
    {
        return view('user-management');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user->department_id > 0 && Department::find($user->department_id)->boss_id == $user->user_id) {
            return redirect('/user-management')->with('errorBossDepartment', 'このユーザーは部署の責任者のため削除できません。');
        }
        $user = UserLogin::find($id);
        $user->delete();
        return redirect('/user-management')->with('successDeleteUser', 'ユーザーを削除しました。');
    }
}
