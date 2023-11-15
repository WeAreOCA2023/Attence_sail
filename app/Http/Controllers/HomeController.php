<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DailyWorkHours;
use App\Models\AllWorkHours;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //週が変わったら行う処理 ↓
        $flag = count(DailyWorkHours::where('user_id', Auth::user()->id)->get());
//        dd($flag);
        if ($flag != 0){
            $allTest = DailyWorkHours::where('user_id', Auth::user()->id)->get();
            if (date('w') == "3"){
                //１週間の合計時間の初期値設定 ↓
                $WeeklyTotalSec = 0;
                //１週間の合計時間の計算
                foreach ($allTest as $test){
                    $WeeklyTotalSec += $test->worked_hours;
                }
                $userAllWork = AllWorkHours::where('user_id', Auth::user()->id)->get();
                if (count($userAllWork) == 0){
                    $allUpdate = new AllWorkHours([
                        'user_id' => Auth::user()->id,
                        'weekly_total_work_hours' => $WeeklyTotalSec,
                        'monthly_total_work_hours' => $WeeklyTotalSec,
                    ]);
                    $allUpdate->save();
                    DailyWorkHours::where('user_id', Auth::user()->id)->delete();
                }else{
//                    dd($userAllWork);
                    $currentMonthHour = $userAllWork[0]->monthly_total_work_hours;
//                    dd($userAllWork[0]);
                    $newMonthHour = $currentMonthHour + $WeeklyTotalSec;
                    //この下でallWorkHoursにデータを追加↓
                    $allUpdate = AllWorkHours::where('user_id', Auth::user()->id)->first();
                    $allUpdate->weekly_total_work_hours = $WeeklyTotalSec;
                    $allUpdate->monthly_total_work_hours = $newMonthHour;
                    $allUpdate->save();
                    //dailyWorkHoursのデータを削除↓
                    DailyWorkHours::where('user_id', Auth::user()->id)->delete();
                }

            }
//            $flag2 = count(AllWorkHours::where('user_id', Auth::user()->id)->get());
//            // allworkhoursのテーブルがからじゃなかった場合
//            if ($flag2 != 0){
//                $allWorkData = AllWorkHours::where('user_id', Auth::user()->id)->get();
//                //月が変わった時の処理
//                $today = date("d"); //今日の日にち
//                $target_day = "15"; //
//                if (strtotime($today) === strtotime($target_day)){
//                    //１ヶ月の合計時間の初期値設定 ↓
//                    $MonthlyTotalSec = 0;
//                    //１ヶ月の合計時間の計算
//                    foreach ($allWorkData as $singleData){
//                        $MonthlyTotalSec += $singleData->weekly_total_work_hours;
//                    }
//                    //この下でallWorkHoursにデータを追加↓
//                    $allUpdate = new AllWorkHours([
//                        'user_id' => Auth::user()->id,
//                        'monthly_total_work_hours' => $MonthlyTotalSec,
//                    ]);
//                    $allUpdate->save();
//                    //dailyWorkHoursのデータを削除↓
//                }
//            }
        }

        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $raw = file_get_contents('php://input'); // POSTされた生のデータを受け取る
        $data = json_decode($raw); // json形式をphp変数に変換

        $currentDate = date("Y-m-d");
        $workHours = abs($data->elapsed_time);
//        $newHours = date("H:i:s", $workHours / 1000);
//        $finalHours = date('H:i:s', strtotime($newHours. ' -9 hours'));


        echo json_encode($workHours);

        // ここでデータベースに保存するなどの処理を行う
        $dailyWork = new DailyWorkHours([
            'user_id' => Auth::user()->id,
            'worked_at' => $currentDate,
            'worked_hours' => $workHours
        ]);
        $dailyWork->save();

//        return redirect('/home');
        // echoすると返せる
//        echo json_encode($data); // json形式にして返す
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
