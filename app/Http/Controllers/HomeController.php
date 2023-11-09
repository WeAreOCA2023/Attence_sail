<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        if ($request){
            var_dump("no data sent");
        }else{
            $elapsed = $request->get('elapsedTime');
            $break = $request->get('breakTime');
            var_dump($elapsed);
            var_dump($break);
        }


//        return ('/home');
    }
}
