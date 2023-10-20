<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userManagement()
    {
        return view('user-management');
    }

    public function departmentManagement()
    {
        return view('department-management');
    }

    public function positionManagement()
    {
        return view('position-management');
    }
}
