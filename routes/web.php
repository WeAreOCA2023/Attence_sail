<?php

// namespace App\Http\Controllers;


use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/register-boss', function () {return view('/auth/register-boss');})->name('register-boss');
Route::post('/register-boss', 'Auth\RegisterController@register');


// Route::get('register-boss', function () {
//     return view('/auth/register-boss');
// })->name('register-boss');
// Route::post('register-boss', 'Auth\RegisterController@register')->name('register-boss');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('tasks', TaskController::class);