<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Position;
use App\Models\User;

class PositionManagementController extends Controller
{
    public function index(): View
    {
        return view('position-management', [
            'positions' => DB::table('positions')->paginate(15)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'positionName' => 'required',
        ]);

        $user = User::where('user_id', Auth::user()->id)->first();

        $position = new Position ([
            'position_name' => $request->get('positionName'),
            'rank' => $request->get('rank'),
            'company_id' => $user->company_id
        ]);
        $position->save();
        return redirect('/position-management');
    }

    public function destroy($id, Request $request)
    {
        $position = Position::find($id);
        $position->delete();
        $currentPage = $request->input('page', 1);
        $redirectTo = '/position-management?page=' . $currentPage;
        return redirect($redirectTo);
    }
}
