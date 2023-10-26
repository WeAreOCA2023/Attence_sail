<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Position;

class PositionManagementController extends Controller
{
    public function index(): View
    {
        return view('position-management');
    }
}
