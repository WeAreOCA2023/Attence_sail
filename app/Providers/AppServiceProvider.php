<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;



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
            $username = $user->user->userName;
            $is_boss = $user->user->is_boss;
    
        
            $view->with([
                'username' => $username,
                'is_boss' => $is_boss
    
            ]);
        });
        
    }

}

