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
use App\Models\UserLogin;
use App\Models\Position;
use App\Models\Department;
use App\Models\Task;
use App\Models\AllTasksAssign;

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
        $full_name = $user->full_name;
        $assigned_tasks = count(AllTasksAssign::where('assignee_id', $user->user_id)->get());
        $tasks = Task::where('assigner_id', $user->user_id)->get();
        $tasks_within_deadline = 0;
        $tasks_after_deadline = 0;
        if (count($tasks) > 0) {
            foreach($tasks as $task) {
                if ($task->status == 1) {
                    $tasks_within_deadline++;
                } elseif ($task->status == 2) {
                    $tasks_after_deadline++;
                } else {
                    continue;
                } 
            }
        } 
        $trust_score = $this->calculateTrustScore($tasks_within_deadline, $tasks_after_deadline);
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
            'full_name' => $full_name,
            'phone_number' => $phone_number,
            'company_name' => $company_name,
            'company_id' => $company_id,
            'department_name' => $department_name,
            'position_name' => $position_name,
            'agreement_36' => $agreement_36,
            'variable_working_hours_system' => $variable_working_hours_system,
            'assigned_tasks' => $assigned_tasks,
            'tasks_within_deadline' => $tasks_within_deadline,
            'tasks_after_deadline' => $tasks_after_deadline,
            'trust_score' => $trust_score,
        ]);
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
     * 名前の更新
     */
    public function updateFullName(Request $request, User $user): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'fullName' => ['required'],
        ], [
            'fullName.required' => '氏名は必須です。',
        ]);
        if ($validator->fails()) {
            return redirect('/profile')->withErrors($validator)->withInput();
        }
        $user->full_name = $request->get('fullName');
        $user->update();
        return redirect('/profile')->with('successFullName', '氏名を更新しました。');
    }


    /**
     * ユーザー名の更新
     */
    public function updateUserName(Request $request, User $user): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'userName' => ['required'],
        ], [
            'userName.required' => 'ユーザー名は必須です。',
        ]);
        if ($validator->fails()) {
            return redirect('/profile')->withErrors($validator)->withInput();
        }
        $user->user_name = $request->get('userName');
        $user->update();
        return redirect('/profile')->with('successUserName', 'ユーザー名を更新しました。');
    }

    /**
     * メールアドレスの更新
     */
    public function updateEmail(Request $request, UserLogin $user_logins): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user_logins'],
        ], [
            'email.required' => 'メールアドレスは必須です。',
            'email.string' => 'メールアドレスは文字列で入力してください。',
            'email.email' => 'メールアドレスの形式で入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'email.unique' => 'このメールアドレスは既に登録されています。',
        ]);
        if ($validator->fails()) {
            return redirect('/profile')->withErrors($validator)->withInput();
        }
        $user_logins->email = $request->get('email');
        $user_logins->update();
        return redirect('/profile')->with('successEmail', 'メールアドレスを更新しました。');
    }

    /**
     * 電話番号の更新
     */
    public function updateTelephone(Request $request, User $user): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'telephone' => ['required', 'numeric', 'digits_between:10,11', 'unique:users'],
        ], [
            'telephone.required' => '電話番号は必須です。',
            'telephone.numeric' => '電話番号は数字で入力してください。',
            'telephone.digits_between' => '電話番号は10桁か11桁で入力してください。',
            'telephone.unique' => 'この電話番号は既に登録されています。'
        ]);
        if ($validator->fails()) {
            return redirect('/profile')->withErrors($validator)->withInput();
        }
        $user->telephone = $request->get('telephone');
        $user->update();
        return redirect('/profile')->with('successTelephone', '電話番号を更新しました。');
    }

    /**
     * 信頼スコアの計算
     */
    public function calculateTrustScore($tasks_within_deadline, $tasks_after_deadline)
    {
        $total_tasks = $tasks_within_deadline + $tasks_after_deadline;

        if ($total_tasks == 0) {
            return 0;  # タスクがない場合は信頼スコアをゼロに設定
        }    
        $within_deadline_percentage = number_format($tasks_within_deadline / $total_tasks, 2);
        $after_deadline_percentage = number_format($tasks_after_deadline / $total_tasks, 2);
    
        # 期限内達成率が高いほど、期限後達成率が低いほど、信頼スコアが高くなる例
        $trust_score = ($within_deadline_percentage - $after_deadline_percentage) * 100;

    
        # 信頼スコアが負にならないように調整
        $trust_score = max(0, $trust_score);
    
        return $trust_score;
    }
}
