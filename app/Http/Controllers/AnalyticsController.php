<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AllWorkHours;
use App\Models\DailyWorkHours;
use App\Models\WeeklyWorkHours;
use App\Models\MonthlyWorkHours;
use App\Models\YearlyWorkHours;

class AnalyticsController extends Controller
{
    protected function calcWorkHours($workedHours)
    {
        $hours = ($workedHours / 1000 / 60 / 60) % 24;
        $minutes = ($workedHours / 1000 / 60) % 60;
        $formattedTime = $hours . '時間' . $minutes . '分';
        $raw = $hours + $minutes / 60;
        return [
            'formattedTime' => $formattedTime,
            'raw' => $raw
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentDate = intval(date('d'));
        $secondDate = $currentDate - 1;
        $thirdDate = $currentDate - 2;
        $fourthDate = $currentDate - 3;
        $fifthDate = $currentDate - 4;
        $sixthDate = $currentDate - 5;
        $seventhDate = $currentDate - 6;
        $workedAt = 0;
        $currentWorkHours = 0;
        $secondWorkHours = 0;
        $thirdWorkHours = 0;
        $fourthWorkHours = 0;
        $fifthWorkHours = 0;
        $sixthWorkHours = 0;
        $seventhWorkHours = 0;
        $dailyWorkHours = DailyWorkHours::where('user_id', auth()->user()->id)->get();
        foreach ($dailyWorkHours as $dailyWorkHour) {
            $workedAt = $dailyWorkHour->worked_at;
            $workedAt = date('d', strtotime($workedAt));
            if ($workedAt == $currentDate) {
                $currentWorkHours += $dailyWorkHour->worked_hours;
            } elseif ($workedAt == $secondDate) {
                $secondWorkHours += $dailyWorkHour->worked_hours;

            } elseif ($workedAt == $thirdDate) {
                $thirdWorkHours += $dailyWorkHour->worked_hours;
            } elseif ($workedAt == $fourthDate) {
                $fourthWorkHours += $dailyWorkHour->worked_hours;
            } elseif ($workedAt == $fifthDate) {
                $fifthWorkHours += $dailyWorkHour->worked_hours;
            } elseif ($workedAt == $sixthDate) {
                $sixthWorkHours += $dailyWorkHour->worked_hours;
            } elseif ($workedAt == $seventhDate) {
                $seventhWorkHours += $dailyWorkHour->worked_hours;
            }
        }
        $currentWorkHours = $this->calcWorkHours($currentWorkHours);
        $secondWorkHours = $this->calcWorkHours($secondWorkHours);
        $thirdWorkHours = $this->calcWorkHours($thirdWorkHours);
        $fourthWorkHours = $this->calcWorkHours($fourthWorkHours);
        $fifthWorkHours = $this->calcWorkHours($fifthWorkHours);
        $sixthWorkHours = $this->calcWorkHours($sixthWorkHours);
        $seventhWorkHours = $this->calcWorkHours($seventhWorkHours);

        return view('analytics', [
            'currentDate' => $currentDate,
            'secondDate' => $secondDate,
            'thirdDate' => $thirdDate,
            'fourthDate' => $fourthDate,
            'fifthDate' => $fifthDate,
            'sixthDate' => $sixthDate,
            'seventhDate' => $seventhDate,
            'workedAt' => $workedAt,
            'currentWorkHours' => $currentWorkHours,
            'secondWorkHours' => $secondWorkHours,
            'thirdWorkHours' => $thirdWorkHours,
            'fourthWorkHours' => $fourthWorkHours,
            'fifthWorkHours' => $fifthWorkHours,
            'sixthWorkHours' => $sixthWorkHours,
            'seventhWorkHours' => $seventhWorkHours,
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
