<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\User;


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
        View::composer('home', function ($view) {
            
            $user = Auth::user();
            // $user は user_loginsテーブルの情報
            // $user->user は usersテーブルの情報
            // user は UserLoginモデルで定義している user()メソッドを指している
            $username = $user->user->userName;
            $is_boss = $user->user->is_boss;
            if ($is_boss == 1) {
                $is_boss = 'BOSS';
            } else {
                $is_boss = 'USER';
            }

            $view->with([
                'username'=> $username,
                'is_boss'=> $is_boss,
            ]);
        
        });
    }
}
