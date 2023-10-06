<?php

namespace App\ViewComposers;

use App\Repositories\Contracts\AuthContract;
use Illuminate\View\View;

class HeaderComposer
{
    protected $authRepository;

    /**
     * constructor
     *
     * @param AuthContract $authRepository
     */
    public function __construct(AuthContract $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * viewにログインユーザーのステータスを常に結合して渡す
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $authUser = Auth::user();
        $username = $authUser->user->userName;
        $is_boss = $authUser->user->is_boss;
        if ($is_boss == 1) {
            $is_boss = "BOSS";
        } else {
            $is_boss = "USER";
        }

        $view->with([
            'username' => $username,
            'is_boss' => $is_boss
        ]);
    }
}