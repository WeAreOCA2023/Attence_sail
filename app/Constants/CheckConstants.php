<?php

namespace App\Constants;

use App\Models\MonthlyWorkHours;
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

//----------------------チェック---------------------
    // 日デフォチェック(毎日)
    public static function dailyDefaultOverCheck(int $time): void{
        if ($time > 5000){
            $user = User::where('user_id', Auth::user()->id)->first();
            $user->over_work = 1;
            $user->save();
        }
    }

    // 週デフォチェック(隔週)
    public static function weeklyDefaultOverCheck(): void
    {
        if (self::defaultAgreement()){
            $baseData = WeeklyWorkHours::where('user_id', Auth::user()->id)->get();
            $latestData = $baseData->sortByDesc('id')->first();
            $weekHours = $latestData->worked_hours;
            if ($weekHours > 10000){
                $user = User::where('user_id', Auth::user()->id)->first();
                $user->over_work = 1;
                $user->save();
            }
        }
    }

    // 月の36チェック(隔週)
    public static function monthlyThreeOverCheck(): void
    {
        if (self::threeCheck()){
            $baseData = MonthlyWorkHours::where('user_id', Auth::user()->id)->get();
            $latestData = $baseData->sortByDesc('id')->first();
            $monthHours = $latestData->overwork;
            if ($monthHours > 10000){
                $user = User::where('user_id', Auth::user()->id)->first();
                $user->over_work = 1;
                $user->save();
            }
        }
    }
}
