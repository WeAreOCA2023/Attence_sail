<?php

namespace App\Http\Controllers;

use App\Models\WeeklyWorkHours;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DailyWorkHours;
use App\Models\AllWorkHours;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public static function testFunc():void
    {
        echo "testFuncが呼ばれたよ！";
    }

    function defaultCheck(): void{
        if (count(AllWorkHours::where('user_id', Auth::user()->id)->get()) == 0){
            $allUpdate = new AllWorkHours([
                'user_id' => Auth::user()->id,
                'weekly_total_work_hours' => 0,
                'monthly_total_work_hours' => 0,
                'yearly_total_work_hours' => 0,
                'total_over_work_hours' => 0,
            ]);
            $allUpdate->save();
        }
    }
    // 週が終わった時の処理 ↓
    public static function weeklyProcess(): void
    {
        $allWork = AllWorkHours::all();
        foreach ($allWork as $eachWork){
            $totalWeekHour = $eachWork->weekly_total_work_hours;
            $eachWork->weekly_total_work_hours = 0;
            $eachWork->save();

            $weeklyWork = new WeeklyWorkHours([
                'user_id' => $eachWork->user_id,
                'weekly_at' => date("Y-m-d"),
                'worked_hours' => $totalWeekHour,
            ]);
            $weeklyWork->save();
        }

    }

//    function testWeekly(): void
//    {
//        $allWork = AllWorkHours::all();
//        foreach ($allWork as $eachWork){
//            $eachWork->weekly_total_work_hours = 0;
//            $eachWork->save();
//        }
//        dd($allWork);
//    }



    //一ヶ月が終わった時の処理
    function monthlyProcess(){
        $userAllWork = AllWorkHours::where('user_id', Auth::user()->id)->first();
        // 今年の合計時間を更新
        $currentYearHour = $userAllWork->yearly_total_work_hours;
        $newYearHour = $currentYearHour + $userAllWork->monthly_total_work_hours;
        $userAllWork->monthly_total_work_hours = 0;
        $userAllWork->yearly_total_work_hours = $newYearHour;
        $userAllWork->save();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->defaultCheck(); //関数呼び出し(初期チェック)
//        $this->testWeekly();
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

        $userAllWork = AllWorkHours::where('user_id', Auth::user()->id)->first();
        // 今年の合計時間を更新
        $currentWeeklyHour = $userAllWork->weekly_total_work_hours;
        $currentMonthlyHour = $userAllWork->monthly_total_work_hours;
        $currentYearlyHour = $userAllWork->yearly_total_work_hours;
        $newWeeklyHour = $currentWeeklyHour + $workHours;
        $newMonthlyHour = $currentMonthlyHour + $workHours;
        $newYearlyHour = $currentYearlyHour + $workHours;
        $userAllWork->weekly_total_work_hours = $newWeeklyHour;
        $userAllWork->monthly_total_work_hours = $newMonthlyHour;
        $userAllWork->yearly_total_work_hours = $newYearlyHour;
        $userAllWork->save();

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
