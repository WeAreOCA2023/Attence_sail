<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // BOSS
        // if (Auth::check()) {
        //     $is_boss = \App\Models\User::where('user_id', Auth::user()->id)->first()->is_boss;
        //     Gate::define('boss', function () use ($is_boss) {
        //         return ($is_boss === "BOSS");
        //     });
        // }

        // default - works
        Gate::define('boss', function ($user) {
            $user_login_id = Auth::user()->id;
            $boss_check = User::where('user_id', $user_login_id)->first()->is_boss;
//            dump($user);
            return ($boss_check);
        });



    }
}
