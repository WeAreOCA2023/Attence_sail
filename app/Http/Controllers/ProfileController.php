<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\User;
use App\Models\Position;
use App\Models\Department;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user = User::where('user_id', Auth::user()->id)->first();
        $company = Company::where('id', $user->company_id)->first();
        $position = Position::where('id', $user->position_id)->first();
        $department = Department::where('id', $user->department_id)->first();
        $phone_number = $user->phone_number;
        $company_name = $company->company_name;
        $company_id = $company->id;

        $position_id = $user->position_id;
        if ($position_id == 0) {
            $position_name = '<span class="unset">' . '未設定' . '</span>';
        } else {
            $position_name = $position->position_name;
        }

        $department_id = $user->department_id;
        if ($department_id == 0) {
            $department_name = '<span class="unset">' . '未設定' . '</span>';
        } else {
            $deparmtent_name = $department->department_name;
        }


        $agreement_36 = $user->agreement_36;
        if ($agreement_36 == 1) {
            $agreement_36 = '有り';
        } elseif ($agreement_36 == 2) {
            $agreement_36 = '<span>' . '特別条項付き' . '</span>';
        } elseif ($agreement_36 == 3) {
            $agreement_36 = '無し';
        } else {
            $agreement_36 = '<span class="unset">' . '未設定' . '</span>';
        }

        $variable_working_hours_system = $user->variable_working_hours_system;
        if ($variable_working_hours_system == 1) {
            $variable_working_hours_system = '有り';
        } elseif ($variable_working_hours_system == 2) {
            $variable_working_hours_system = '無し';
        } else {
            $variable_working_hours_system = '<span class="unset">' . '未設定' . '</span>';
        }
        return view('profile', [
            'phone_number' => $phone_number,
            'company_name' => $company_name,
            'company_id' => $company_id,
            'department_name' => $department_name,
            'position_name' => $position_name,
            'agreement_36' => $agreement_36,
            'variable_working_hours_system' => $variable_working_hours_system
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * 36協定の有無を保存する
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'agreement36' => ['required', 'string', 'agreement36_and_variableWorkingHoursSystem'],
            'variableWorkingHoursSystem' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return redirect('/profile')->withErrors($validator)->withInput();
        }
        $user = User::where('user_id', Auth::user()->id)->first();
        $user->agreement_36 = $request->get('agreement36');
        $user->variable_working_hours_system = $request->get('variableWorkingHoursSystem');
        $user->save();
        return redirect('/profile');
    }

    /**
     * 会社情報を更新する
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $company = Company::find($id);
        $company->company_name = $request->get('companyName');
        $company->post_code = $request->get('companyPostCode');
        $company->address = $request->get('companyAddress');
        $company->update();
        return redirect('/profile');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
