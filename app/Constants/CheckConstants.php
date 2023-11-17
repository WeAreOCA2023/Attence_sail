<?php

namespace App\Constants;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\WeeklyWorkHours;

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
    //36チェック
    public static function threeCheck(): bool
    {
        $user = User::where('user_id', Auth::user()->id)->first();
        $agreement = $user->agreement_36;
        if ($agreement == 1){
            return true;
        }else{
            return false;
        }
    }
    //特別36チェック
    public static function specialCheck(): bool{
        $user = User::where('user_id', Auth::user()->id)->first();
        $agreement = $user->agreement_36;
        if ($agreement == 2){
            return true;
        }else{
            return false;
        }
    }

    //月チェック
    public static function defaultOverCheck(){
        if (CheckConstants::defaultAgreement()){
            $weekHours = WeeklyWorkHours::where('user_id', Auth::user()->id)->last()->worked_hours;
            if ($weekHours > 10000){
                $user = User::where('user_id', Auth::user()->id)->first();
                $user->over_work = 1;
                $user->save();
            }
        }
    }
}
