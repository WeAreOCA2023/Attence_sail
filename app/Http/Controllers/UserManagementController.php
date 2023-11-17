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
        return view('user-management');
    }

    public function destroy($id)
    {
        $user = UserLogin::find($id);
        $user->delete();
        return redirect('/user-management');
    }
}
