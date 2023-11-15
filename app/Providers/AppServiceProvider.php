<?php

namespace App\Providers;


use App\Models\Company;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\CustomDataServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot()
    {

        // livewireの検索用のmacro(App\Http\Livewire\SearchName.php)
        Builder::macro('search', function ($field, $string) {
            return $string ? $this->where($field, 'LIKE', "%{$string}%") : $this;
        });

        // paginationはdefaultでtailwindだから、bootstrapに切り替える
        Paginator::useBootstrapFive();

        // ここで指定するのは bladeテンプレート
        View::composer(['home', 'user-management', 'my-all-tasks', 'department-management', 'position-management', 'profile'], function ($view) {

            // 現在ログイン中のユーザーのログイン情報 -> database/'migrations/create_user_login_table
            $user_login_all = Auth::user();

            // user_login_table の id の取得
            $user_login_id = $user_login_all->id;

            // users_table の user_id = user_login_table の id が一致する一番最初のレコード
            $users = User::where('user_id', $user_login_id)->first();
            
            // companies_table の company_id = users_table の company_id が一致する一番最初のレコード
            $company = Company::where('id', $users->company_id)->first();
           
            // department_table の department_id = users_table の department_id が一致する一番最初のレコード
            $department = Department::where('id', $users->department_id)->first();

            // position_table の position_id = users_table の position_id が一致する一番最初のレコード
            $position = Position::where('id', $users->position_id)->first();

            if (isset($department)) {
                $department_name = $department->department_name;
            } else {
                $department_name = '<span class="unset">' . '未設定' . '</span>';
            }

            if (isset($position)) {
                $position_name = $position->position_name;
            } else {
                $position_name = '<span class="unset">' . '未設定' . '</span>';
            }
            $phone_number = $users->telephone;
            $user_name = $users->user_name;
            $company_id = $company->id;
            $company_name = $company->company_name;
            $is_boss = ($users->is_boss == 1) ? 'BOSS' : 'USER';
            if ($users->agreement_36 == 1) {
                $agreement36 = '<span>' . '有り' . '</span>';
            } elseif ($users->agreement_36 == 2) {
                $agreement36 = '<span>' . '無し' . '</span>';
            } else {
                $agreement36 = '<span class="unset">' . '未設定' . '</span>';
            }
            if ($users->variable_working_hours_system == 1) {
                $variable_working_hours_system = '<span>' . '有り' . '</span>';
            } elseif ($users->variable_working_hours_system == 2) {
                $variable_working_hours_system = '<span>' . '無し' . '</span>';
            } else {
                $variable_working_hours_system = '<span class="unset">' . '未設定' . '</span>';
            }
            $view->with([
                'user_name' => $user_name,
                'is_boss' => $is_boss,
                'phone_number' => $phone_number,
                'company_name' => $company_name,
                'company_id' => $company_id,
                'department_name' => $department_name,
                'position_name' => $position_name,
                'agreement36' => $agreement36,
                'variable_working_hours_system' => $variable_working_hours_system
            ]);
        });

        // ユーザーの入力した会社コードがcompany_tableと一致するかの判定(RegisterController.php)
        Validator::extend('matches_company_code_and_password', function ($attribute, $value, $parameters, $validator) {
            $companyCode = $value;
            $inputPassword = $validator->getData()['companyPassword'];
            $company = Company::where('company_code', $companyCode)->first();
            if ($company && Hash::check($inputPassword, $company->company_password)) {
                return true;
            }
            return false;

        });

        // ユーザーが36協定と変形時間労働制をどちらも同意した際 or どちらも未選択の際 に、profileにerror文と共にリダイレクトする
        Validator::extend('agreement36_and_variableWorkingHoursSystem', function ($attribute, $value, $parameters, $validator) {
            $agreement36 = $validator->getData()['agreement36'];
            $variableWorkingHoursSystem = $validator->getData()['variableWorkingHoursSystem'];
            if ($agreement36 == 0 || $variableWorkingHoursSystem == 0  || $agreement36 == 1 && $variableWorkingHoursSystem == 1 || $agreement36 == 2 && $variableWorkingHoursSystem == 1) {
                return false;
            }
            return true;
        }, __('36協定と変形労働時間制は同時に選択/未選択にはできません。'));
    }

}

