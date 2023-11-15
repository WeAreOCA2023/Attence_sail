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
    //１週間の合計時間を計算する関数
    function getWeeklyHours(){
        $allTest = DailyWorkHours::where('user_id', Auth::user()->id)->get();
        //１週間の合計時間の初期値設定 ↓
        $WeeklyTotalSec = 0;
        //１週間の合計時間の計算
        foreach ($allTest as $test){
            $WeeklyTotalSec += $test->worked_hours;
        }
        return ($WeeklyTotalSec);
    }

    // 週が終わった時の処理 ↓
    function weeklyProcess(int $WeeklyTotalSec){
        // AllWorkHoursを取得
        $userAllWork = AllWorkHours::where('user_id', Auth::user()->id)->get();
        //allWorkHoursがなかった時にのデータを追加 ↓
        if (count($userAllWork) == 0){
            $allUpdate = new AllWorkHours([
                'user_id' => Auth::user()->id,
                'weekly_total_work_hours' => $WeeklyTotalSec,
                'monthly_total_work_hours' => $WeeklyTotalSec,
            ]);
            $allUpdate->save();
            DailyWorkHours::where('user_id', Auth::user()->id)->delete();
        }else{
            //現在の月の合計時間を取得&加算 ↓
            $currentMonthHour = $userAllWork[0]->monthly_total_work_hours;
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flag = count(DailyWorkHours::where('user_id', Auth::user()->id)->get());
        if ($flag == 0){return view('home');} //カラムがあるかどうかのチェック
        // 関数呼び出し ↓
        $WeeklyTotalSec = $this->getWeeklyHours();
        if (date('w') == "3"){
            // 関数呼び出し ↓
            $this->weeklyProcess($WeeklyTotalSec);
        }
        //ここから ↓ に月が変わった時の処理を書く
//        if (date('d') == "01"){
//            //一年の初期値を決める
//            $yearlyTotalSec = 0;
//            $userAllWork = AllWorkHours::where('user_id', Auth::user()->id)->get();
//            if(count($userAllWork) == 0){
//
//            }else{
//
//            }
//        }
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
