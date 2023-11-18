<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class UserManagementController extends Controller
{
    public function index(): View
    {
        return view('user-management');
    }

    public function destroy($id): View
    {
        $user = UserLogin::find($id);
        $user->delete();
        return redirect('/user-management');
    }
}
