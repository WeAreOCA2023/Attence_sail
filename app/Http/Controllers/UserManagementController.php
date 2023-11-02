<?php

namespace App\Http\Controllers;

use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\User;

class UserManagementController extends Controller
{
    public function index(): View
    {
//        $userId = Auth::user()->id;
        $users = DB::table('user_logins')->paginate(15);
        $userFullNameList = [];
        foreach ($users as $user){
            $userId = $user->id;
            $userTable = User::query()->where('user_id', $userId)->first();
            $userFullName = $userTable->full_name;
            $userSet[$userId] = $userFullName;
            $userFullNameList[] = $userSet;
            $userSet = array();
//            dd($userFullNameList);
        }
        return view('user-management', [
            'users' => DB::table('user_logins')->paginate(15),
            'fullNameList' => $userFullNameList,
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

//    public function getModalData(): View{
//        $userId = Auth::user()->id;
//        $userTable = User::query()->where('user_id', $userId)->first();
//        return view('user-management', [
//            'userTable' => $userTable
//        ]);
//    }
}
