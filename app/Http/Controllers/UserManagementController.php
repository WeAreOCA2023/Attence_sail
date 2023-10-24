<?php

namespace App\Http\Controllers;

use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(): View
    {
        return view('user-management', [
            'users' => DB::table('user_logins')->paginate(15)
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
}
