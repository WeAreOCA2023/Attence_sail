<?php

namespace App\Constants;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CheckConstants
{
    //デフォチェック
    public static function defaultAgreement(): bool
    {
        $user = User::where('user_id', Auth::user()->id)->first();
        $agreement = $user->agreement_36;
        if ($agreement == 0 || 3){
            return true;
        }else{
            return false;
        }
    }

}
