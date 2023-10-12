<?php

namespace App\Providers;


use App\Models\Department;
use Illuminate\Support\ServiceProvider;
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
            // ↓の中にはuserLoginテーブル
            $user = Auth::user();
            $user_id = $user->user->id;
            $user_name = $user->user->user_name;
            $is_boss = $user->user->is_boss;
            $department_name = Department::where('id', $user_id)->department_name;
            if ($is_boss == 1) {
                $is_boss = 'BOSS';
            } else {
                $is_boss = 'USER';
            }


            $view->with([
                'user_name' => $user_name,
                'is_boss' => $is_boss,
                'department_name' => $department_name,

            ]);
        });

    }

}

