<?php

namespace App\Http\Controllers;

use App\Models\DailyWorkHours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        return view('home');
    }

    public function store(Request $request)
    {
        $request->validate([
            'elapsedTime' => 'required',
            'breakTime' => 'required'
        ]);
        $dailyWorkHours = new DailyWorkHours([
            'user_id' => Auth::user()->id,
            'worked_at' => now(),
            'worked_hours' => $request->get('elapsedTime')
        ]);
        $dailyWorkHours->save();
//        return ('/home');
    }
}
