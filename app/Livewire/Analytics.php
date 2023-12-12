<?php

namespace App\Livewire;

use App\Models\DailyWorkHours;
use Livewire\Component;
use Livewire\Attributes\On;

class Analytics extends Component
{

    public $currentDate;
    public $secondDate;
    public $thirdDate;
    public $fourthDate;
    public $fifthDate;
    public $sixthDate;
    public $seventhDate;
    public $workedAt = 0;
    public $currentWorkHours = 0;
    public $secondWorkHours = 0;
    public $thirdWorkHours = 0;
    public $fourthWorkHours = 0;
    public $fifthWorkHours = 0;
    public $sixthWorkHours = 0;
    public $seventhWorkHours = 0;
    public function mount()
    {
        $this->currentDate = intval(date('d'));
        $this->secondDate = intval(date('d', strtotime("-1 day")));
        $this->thirdDate = intval(date('d', strtotime("-2 day")));
        $this->fourthDate = intval(date('d', strtotime("-3 day")));
        $this->fifthDate = intval(date('d', strtotime("-4 day")));
        $this->sixthDate = intval(date('d', strtotime("-5 day")));
        $this->seventhDate = intval(date('d', strtotime("-6 day")));
    }
    public function incrementWeek()
    {
        $this->currentDate++;
    }

    public function decrementWeek()
    {
        $this->currentDate--;
    }
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
    public function render()
    {

        $dailyWorkHours = DailyWorkHours::where('user_id', auth()->user()->id)->get();
        foreach ($dailyWorkHours as $dailyWorkHour) {
            $workedAt = $dailyWorkHour->worked_at;
            $workedAt = date('d', strtotime($workedAt));
            $workedAt = intval($workedAt);
            if ($workedAt == $this->currentDate) {
                $this->currentWorkHours += $dailyWorkHour->worked_hours;
            } elseif ($workedAt == $this->secondDate) {
                $this->secondWorkHours += $dailyWorkHour->worked_hours;
            } elseif ($workedAt == $this->thirdDate) {
                $this->thirdWorkHours += $dailyWorkHour->worked_hours;
            } elseif ($workedAt == $this->fourthDate) {
                $this->fourthWorkHours += $dailyWorkHour->worked_hours;
            } elseif ($workedAt == $this->fifthDate) {
                $this->fifthWorkHours += $dailyWorkHour->worked_hours;
            } elseif ($workedAt == $this->sixthDate) {
                $this->sixthWorkHours += $dailyWorkHour->worked_hours;
            } elseif ($workedAt == $this->seventhDate) {
                $this->seventhWorkHours += $dailyWorkHour->worked_hours;
            }
        }

        $this->currentWorkHours = $this->calcWorkHours($this->currentWorkHours);
        $this->secondWorkHours = $this->calcWorkHours($this->secondWorkHours);
        $this->thirdWorkHours = $this->calcWorkHours($this->thirdWorkHours);
        $this->fourthWorkHours = $this->calcWorkHours($this->fourthWorkHours);
        $this->fifthWorkHours = $this->calcWorkHours($this->fifthWorkHours);
        $this->sixthWorkHours = $this->calcWorkHours($this->sixthWorkHours);
        $this->seventhWorkHours = $this->calcWorkHours($this->seventhWorkHours);

        return view('livewire.analytics', [
            'currentDate' => $this->currentDate,
            'secondDate' => $this->secondDate,
            'thirdDate' => $this->thirdDate,
            'fourthDate' => $this->fourthDate,
            'fifthDate' => $this->fifthDate,
            'sixthDate' => $this->sixthDate,
            'seventhDate' => $this->seventhDate,
            'workedAt' => $this->workedAt,
            'currentWorkHours' => $this->currentWorkHours,
            'secondWorkHours' => $this->secondWorkHours,
            'thirdWorkHours' => $this->thirdWorkHours,
            'fourthWorkHours' => $this->fourthWorkHours,
            'fifthWorkHours' => $this->fifthWorkHours,
            'sixthWorkHours' => $this->sixthWorkHours,
            'seventhWorkHours' => $this->seventhWorkHours,
        ]);
    }
}
