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
        return view('profile');
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
