<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\DailyWorkHours;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allTest = DailyWorkHours::where('user_id', Auth::user()->id)->get();

        $Date = date("Y-m-d");
        $InTime = $Date." 10:00:00";
        $OutTime = $Date." 18:00:00";

        $WorkTime = (strtotime($OutTime) - strtotime($InTime))/3600;

        $base = date("H:i:s", strtotime("00:00:00"));
//        $base = "00:00:00" . $format;
//        dd(gettype($format));
        $testList = [];
        foreach ($allTest as $test){
            $getData = $test->worked_hours;
//            $testList[] = $getData;
            $base = strtotime($base) + strtotime($getData);
//            $base = date("H:i:s", $base);
            $base = date($base, strtotime('-9 hours'));
            $testList[] = $base;
        }
        dd($testList);
        $base = date("H:i:s", $base);
        return view('home',[
            'finalHours' => $base
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

        $currentDate = date("Y-m-d");
        $workHours = abs($data->elapsed_time);
        $newHours = date("H:i:s", $workHours / 1000);
        $finalHours = date('H:i:s', strtotime($newHours. ' -9 hours'));


        echo json_encode($finalHours);

        // ここでデータベースに保存するなどの処理を行う
        $dailyWork = new DailyWorkHours([
            'user_id' => Auth::user()->id,
            'worked_at' => $currentDate,
            'worked_hours' => $finalHours
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
