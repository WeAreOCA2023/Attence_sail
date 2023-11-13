<?php


use App\Http\Controllers\DepartmentManagementController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PositionManagementController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Livewire\CreateTask;

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

//Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');

//Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::resource('home', HomeController::class, ['only' => ['index', 'store']]);
Route::post('/home/store',[HomeController::class, 'store'])->name('home.store');
//Route::post('/insert', 'HomeController@insert')->name('home.insert');

Route::resource('tasks', TaskController::class);

Route::group(['middleware' => ['auth', 'can:boss']], function () {
    Route::resource('department-management', DepartmentManagementController::class);
    Route::resource('position-management', PositionManagementController::class);
    Route::resource('user-management', UserManagementController::class);
});

//Route::get('/tasks', CreateTask::class)->name('tasks');

//Route::get('/counter', Counter::class);
