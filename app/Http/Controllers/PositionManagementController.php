<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Position;
use App\Models\User;

class PositionManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(): View
    {
        return view('position-management');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'positionName' => ['required', 'string', 'max:255', 'unique:positions,position_name'],
            'rank' => ['required', 'numeric', 'between:0,100'],
        ], [
            'positionName.required' => '役職名は必須です。',
            'positionName.string' => '役職名は文字列で入力してください。',
            'positionName.max' => '役職名は255文字以内で入力してください。',
            'positionName.unique' => 'その役職名は既に登録されています。',
            'rank.required' => '権威レベルは必須です。',
            'rank.numeric' => '数字で入力してください。',
            'rank.between' => '0から100の範囲で入力してください。',
        ]);
        if ($validator->fails()) {
            return redirect('/position-management')->withErrors($validator)->withInput();
        }

        $user = User::where('user_id', Auth::user()->id)->first();

        $position = new Position ([
            'position_name' => $request->get('positionName'),
            'rank' => $request->get('rank'),
            'company_id' => $user->company_id
        ]);
        $position->save();
        return redirect('/position-management')->with('successPosition', '役職を作成しました。');
    }

    public function destroy($id, Request $request): RedirectResponse
    {
        $match = User::where('position_id', $id)->first();
        if ($match == null) {
            $position = Position::find($id);
            $position->delete();
            return redirect('/position-management');
        }
        return redirect('/position-management')->with('userExistsOnPosition', 'この役職を持つユーザーがいるため削除できません。');

    }
}
