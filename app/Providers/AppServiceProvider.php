<?php

namespace App\Providers;


use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\CustomDataServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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
        // ここで指定するのは bladeテンプレート
        View::composer(['home', 'user-management', 'my-all-tasks'], function ($view) {

            // 現在ログイン中のユーザーのログイン情報 -> database/'migrations/create_user_login_table
            $user_login_all = Auth::user();

            // user_login_table の id の取得
            $user_login_id = $user_login_all->id;

            // users_table の user_id = user_login_table の id が一致する一番最初のレコード 
            $users = User::where('user_id', $user_login_id)->first();

            $user_name = $users->user_name; 
            $is_boss = ($users->is_boss == 1) ? 'BOSS' : 'USER';


            $view->with([
                'user_name' => $user_name,
                'is_boss' => $is_boss,
                // 'department_name' => $department_name,
                // 'company_name' => $company_name,

            ]);
        });


    }

}

