<?php

namespace App\Providers;


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
            $user = Auth::user();
            $username = $user->user->userName;
            $is_boss = $user->user->is_boss;
            if ($is_boss == 1) {
                $is_boss = 'BOSS';
            } else {
                $is_boss = 'USER';
            }
    
        
            $view->with([
                'username' => $username,
                'is_boss' => $is_boss
    
            ]);
        });
        
    }

}

