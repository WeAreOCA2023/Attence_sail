<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('profile');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * 36協定の有無を保存する
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'agreement36' => ['required', 'string', 'agreement36_and_variableWorkingHoursSystem'],
            'variableWorkingHoursSystem' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            // dd($validator);
            return redirect('/profile');
        }
        return redirect('/profile');
    }

    /**
     * 会社情報を保存する
     */
    public function store2(Request $request)
    {
        $request->validate([
            'positionName' => 'required',
        ]);
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
