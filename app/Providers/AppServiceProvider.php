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
use Cloudinary\Configuration\Configuration;




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
        View::composer(['home', 'user-management', 'my-all-tasks', 'department-management', 'department-management-edit' , 'position-management', 'profile'], function ($view) {


            // user_login_table の id の取得
            $user_login_id = Auth::user()->id;

            // users_table の user_id = user_login_table の id が一致する一番最初のレコード
            $users = User::where('user_id', $user_login_id)->first();
            
            // companies_table の company_id = users_table の company_id が一致する一番最初のレコード
            $company = Company::where('id', $users->company_id)->first();

            $view->with([
                'user_name' => $users->user_name,
                'is_boss' => $users->is_boss,
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

