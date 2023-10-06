<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // View::composers(
        // [
        //     HeaderComposer::class => 'home',  // 全てのbladeファイルに渡される
            // AppComposer::class => 'user.*',  // userディレクトリ以下全てのbladeファイルに渡される
            // AppComposer::class => 'user.index'  // userディレクトリのindex.blade.phpに渡される
    //     ]
    // );

    

    // View::composer('home', function ($view) {
    //     $user = Auth::user();
    //     $username = $user->user->userName;

    
    //     $view->with([
    //         'username' => $username,

    //     ]);
    // });
    
    }
}
