<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CustomDataSeriveProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // 現在ログイン中のユーザーのログイン情報 -> database/'migrations/create_user_login_table
        // $current_user = Auth::user();

        // user_login_table の id の取得
        // $userLoginId = $current_user->id;

        //  users_table の user_id = user_login_table の id が一致する一番最初のレコード 
        // $users = User::where('user_id', $userLoginId)->first();

        // $userName = $users->user_name; 
        // $isBoss = ($users->is_boss == 1) ? 'BOSS' : 'USER';

        // $this->app->singleton('user_name', function () use ($userName) {
        //     return $userName;
        // });
        
        // $this->app->singleton('is_boss', function () use ($isBoss) {
        //     return $isBoss;
        // });

        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
