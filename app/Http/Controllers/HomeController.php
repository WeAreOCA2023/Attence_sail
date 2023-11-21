<?php

namespace App\Http\Controllers;

use App\Constants\AgreementConstants;
use App\Constants\CheckConstants;
use App\Models\AllTasksAssign;
use App\Models\MonthlyWorkHours;
use App\Models\Task;
use App\Models\User;
use App\Models\WeeklyWorkHours;
use App\Models\YearlyWorkHours;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DailyWorkHours;
use App\Models\AllWorkHours;
use PHPUnit\Runner\Exception;
use function Faker\Provider\pt_BR\check_digit;

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

    function hourCalc(int $num){
        $num = $num / 3600000;
        $newNum = round($num, 2);
//        $newNum = floor($num);
//        return $num;
        return $newNum;
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
                'overwork' => 0
            ]);
            $weeklyWork->save();
        }
        CheckConstants::weeklyDefaultOverCheck(); // デフォの週チェック(労働:週-40h)
    }

    //一ヶ月が終わった時の処理
    public static function monthlyProcess(): void
    {
        $allWork = AllWorkHours::all();
        foreach ($allWork as $eachWork){
            $totalMonthHour = $eachWork->monthly_total_work_hours;
            $eachWork->monthly_total_work_hours = 0;
            $eachWork->save();

            $monthlyWork = new MonthlyWorkHours([
                'user_id' => $eachWork->user_id,
                'monthly_at' => date("Y-m-d"),
                'worked_hours' => $totalMonthHour,
            ]);
            $monthlyWork->save();
            CheckConstants::monthlyThreeOverCheck(); // 36協定の週チェック(残業:月45h)
            CheckConstants::monthlySpecialOverCheck(); // 特別36協定の週チェック(残業:月80h)
        }
    }

    public static function yearlyProcess(): void{
        $allWork = AllWorkHours::all();
        foreach ($allWork as $eachWork){
            $totalYearHour = $eachWork->yearly_total_work_hours;
            $eachWork->yearly_total_work_hours = 0;
            $eachWork->save();

            $yearlyWork = new YearlyWorkHours([
                'user_id' => $eachWork->user_id,
                'yearly_at' => date("Y-m-d"),
                'worked_hours' => $totalYearHour,
            ]);
            $yearlyWork->save();
            CheckConstants::yearlyThreeOverCheck(); // 36協定の年チェック(残業:年360h)
            CheckConstants::yearlySpecialOverCheck(); // 特別36の年チェック(残業:年720h)
        }
    }
    /**
     * Display a listing of the resource.
     */

    function storeSetUp(int $workHours, int $overWork): void{
        $userAllWork = AllWorkHours::where('user_id', Auth::user()->id)->first();
        // 今年の合計時間を更新
        $currentWeeklyHour = $userAllWork->weekly_total_work_hours;
        $currentMonthlyHour = $userAllWork->monthly_total_work_hours;
        $currentYearlyHour = $userAllWork->yearly_total_work_hours;
        $currentOverTime = $userAllWork->total_over_work_hours;
        $newWeeklyHour = $currentWeeklyHour + $workHours;
        $newMonthlyHour = $currentMonthlyHour + $workHours;
        $newYearlyHour = $currentYearlyHour + $workHours;
        $newOverTime = $currentOverTime + $overWork;
        $userAllWork->weekly_total_work_hours = $newWeeklyHour;
        $userAllWork->monthly_total_work_hours = $newMonthlyHour;
        $userAllWork->yearly_total_work_hours = $newYearlyHour;
        $userAllWork->total_over_work_hours = $newOverTime;
        $userAllWork->save();
    }
    function getTaskData()
    {
        $giveTask = [];
        //taskを持ってくる↓
//        $allTask = AllTasksAssign::where('assignee_id', Auth::user()->id);
        $allTask = AllTasksAssign::where('assignee_id', Auth::user()->id)->orderBy('created_at', 'asc')->paginate(3);
        foreach ($allTask as $eachTask){
            $task = Task::where('id', $eachTask->task_id)->first();
            $time = strtotime($task->deadline);
            $newTime = date("Y-m-d h:i", $time);
//            dd($newTime);
            $giveTask[$task->title] = $newTime;
        }
        return $giveTask;
    }

    function getWorkData()
    {
        if (!is_null(AllWorkHours::where('user_id', Auth::user()->id)->first()->weekly_total_work_hours)){
            $weekWorkTime = AllWorkHours::where('user_id', Auth::user()->id)->first()->weekly_total_work_hours;
        }else{
            $weekWorkTime = 0;
        }
        if (!is_null(AllWorkHours::where('user_id', Auth::user()->id)->first()->monthly_total_work_hours)){
            $monthWorkTime = AllWorkHours::where('user_id', Auth::user()->id)->first()->monthly_total_work_hours;
        }else{
            $monthWorkTime = 0;
        }
        if (!is_null(WeeklyWorkHours::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first())){
            $weekOverTime = WeeklyWorkHours::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first()->overwork;
        }else{
            $weekOverTime = 0;
        }
        if (!is_null(MonthlyWorkHours::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first())){
            $monthOverTime = MonthlyWorkHours::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first()->overwork;
        }else{
            $monthOverTime = 0;
        }

        return [$weekWorkTime, $monthWorkTime, $weekOverTime, $monthOverTime];
    }
    public function index()
    {
        $this->defaultCheck(); //関数呼び出し(初期チェック)

        $giveTask = $this->getTaskData();

        $weekWorkTime = $this->getWorkData()[0];
        $monthWorkTime = $this->getWorkData()[1];
        $weekOverTime = $this->getWorkData()[2];
        $monthOverTime = $this->getWorkData()[3];

//        $this->weeklyProcess();
        return view('home', [
            'tasks' => $giveTask,
            'weekWorkTime' => $this->hourCalc($weekWorkTime),
            'monthWorkTime' => $this->hourCalc($monthWorkTime),
            'weekOverTime' => $this->hourCalc($weekOverTime),
            'monthOverTime' => $this->hourCalc($monthOverTime),
        ]);
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
        $currentDate = date("Y-m-d");//今の日付を取得
        $workHours = abs($data->elapsed_time);
        // overtimeチェック
        $overWork = 0; //overworkの初期値
        if ($workHours > 5000){
            $overWork = $workHours - 5000;
        }

        CheckConstants::dailyDefaultOverCheck($workHours); // デフォの日チェック(労働:日-8h)
        $this->storeSetUp($workHours, $overWork); // allWorkTableの合計時間の更新

        // ここでデータベースに保存するなどの処理を行う
        $dailyWork = new DailyWorkHours([
            'user_id' => Auth::user()->id,
            'worked_at' => $currentDate,
            'worked_hours' => $workHours,
            'overwork' => $overWork,
        ]);
        $dailyWork->save();
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
