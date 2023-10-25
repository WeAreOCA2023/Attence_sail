<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Department;


class DepartmentManagementController extends Controller
{
    public function index(): View
    {
        return view('department-management', [
            'departments' => DB::table('department')->paginate(15)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'departmentName' => 'required',
            'bossName' => 'required'
        ]);
        // 現在ログイン中のユーザーのusers_tableの情報
        $users = User::where('user_id', Auth::user()->id)->first();

        if ($users->full_name <> $request->get('bossName')) {
            return redirect('/department-management')->with('error', 'You are not responsible for this department!');
        }

        $department = new Department ([
            'department_name' => $request->get('departmentName'),
            'company_id' => $users->company_id,
            'boss_id' => $users->user_id
        ]);
        $department->save();
        return redirect('/department-management')->with('success', 'Department saved!');
    }
}
