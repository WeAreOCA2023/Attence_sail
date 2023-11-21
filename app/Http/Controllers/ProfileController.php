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
        $phone_number = $user->telephone;
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
        } elseif($department_id == -1){
            $department_name = '<span class=>' . '無し' . '</span>';
        } else {
            $department_name = $department->department_name;
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
    public function updateContract(Request $request, User $user): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'agreement36' => ['required', 'string', 'agreement36_and_variableWorkingHoursSystem'],
            'variableWorkingHoursSystem' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return redirect('/profile')->withErrors($validator)->withInput();
        }
        $user->agreement_36 = $request->get('agreement36');
        $user->variable_working_hours_system = $request->get('variableWorkingHoursSystem');
        $user->save();
        return redirect('/profile')->with('successAgreement', '契約情報を更新しました。');
    }

    /**
     * 会社情報を更新する
     */
    public function updateCompany(Request $request, Company $company): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'companyName' => ['required', 'string'],
            'companyPostCode' => ['required', 'numeric','digits:7'],
            'companyAddress' => ['required', 'max:255'],
        ], [
            'companyName.required' => '会社名は必須です。',
            'companyName.string' => '会社名は文字列で入力してください。',
            'companyPostCode.required' => '郵便番号は必須です。',
            'companyPostCode.numeric' => '郵便番号は数字で入力してください。',
            'companyPostCode.digits' => '郵便番号は7桁で入力してください。',
            'companyAddress.required' => '住所は必須です。',
            'companyAddress.max' => '住所は255文字以内で入力してください。'
        ]);
        if ($validator->fails()) {
            return redirect('/profile')->withErrors($validator)->withInput();
        }
        $company->company_name = $request->get('companyName');
        $company->post_code = $request->get('companyPostCode');
        $company->address = $request->get('companyAddress');
        $company->update();
        return redirect('/profile')->with('successCompany', '会社情報を更新しました。');
    }
    /**
     * アカウント情報を更新する
     */
    public function updateAccount(Request $request, User $user): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'fullName' => ['required'],
            'userName' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user_logins'],
            'phoneNumber' => ['required', 'numeric', 'digits_between:10,11'],
        ], [
            'fullName.required' => '氏名は必須です。',
            'userName.required' => 'ユーザー名は必須です。',
            'email.required' => 'メールアドレスは必須です。',
            'email.string' => 'メールアドレスは文字列で入力してください。',
            'email.email' => 'メールアドレスの形式で入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'email.unique' => 'このメールアドレスは既に登録されています。',
            'phoneNumber.required' => '電話番号は必須です。',
            'phoneNumber.numeric' => '電話番号は数字で入力してください。',
            'phoneNumber.digits_between' => '電話番号は10桁か11桁で入力してください。',
        ]);
        if ($validator->fails()) {
            return redirect('/profile')->withErrors($validator)->withInput();
        }
        $user->full_name = $request->get('fullName');
        $user->user_name = $request->get('userName');
        $user->email = $request->get('email');
        $user->telephone = $request->get('phoneNumber');
        $user->update();
        return redirect('/profile')->with('successAccount', 'アカウント情報を更新しました。');

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
