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
    public function index()
    {
        return View('home');
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
