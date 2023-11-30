<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Blade;
use Livewire\Component;

class Next7Days extends Component
{
    function getWeekList(){
        $week = ['today', 'tomorrow'];
        $weekSetUp = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
//        $today = date('w'); //今日の曜日
        $num = 3;
        while ($num <= 7){
            $day = date('w', strtotime('+'.$num.' day'));
            array_push($week, $weekSetUp[$day]);
            $num++;
        }
        return $week;
    }

    public function render()
    {
        $weekList = $this->getWeekList();
        Blade::component('each-day', EachDay::class);
        return view('livewire.next-7-days',[
            'weekList' => $weekList,
        ]);
    }
}
