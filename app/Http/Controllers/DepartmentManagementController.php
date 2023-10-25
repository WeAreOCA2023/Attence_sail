<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;


class DepartmentManagementController extends Controller
{
    public function index(): View
    {
        return view('department-management');
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required',
            'responsible_id' => 'required'
        ]);

        $department = new Department([
            'department_name' => $request->get('department_name'),
            'company_id' => User::where('user_id', Auth::user()->id)->first()->company_id,
            'responsible_id' => $request->get('responsible_id')
        ]);
        $department->save();
        return redirect('/department-management')->with('success', 'Department saved!');
    }
}
