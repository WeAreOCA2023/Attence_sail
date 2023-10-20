<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PositionManagementController extends Controller
{
    public function index(): View
    {
        return view('position-management');
    }
}
