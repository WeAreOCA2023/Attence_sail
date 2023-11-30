<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Blade;
use Livewire\Component;

class Next7Days extends Component
{
    public function getIdList($idList){
        dd($idList);
    }
    function getWeekList(){
        $week = [ 0=>'today', 1=>'tomorrow'];
        $weekSetUp = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
//        $today = date('w'); //今日の曜日
        $num = 3;
        $count = 2;
        while ($num <= 7){
            $day = date('w', strtotime('+'.$num.' day'));
            $week[$count] = $weekSetUp[$day];
            $count++;
            $num++;
        }
        return $week;
    }

    public function render()
    {
        $weekList = $this->getWeekList();
//        Blade::component('each-day', EachDay::class);
        return view('livewire.next-7-days',[
            'weekList' => $weekList,
        ]);
    }
}
