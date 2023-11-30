<?php


use App\Http\Controllers\DepartmentManagementController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PositionManagementController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnalyticsController;
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
//Route::post('/home/store',[HomeController::class, 'store'])->name('home.store');
//Route::post('/insert', 'HomeController@insert')->name('home.insert');

Route::resource('tasks', TaskController::class);

Route::resource('user-management', UserManagementController::class);

Route::resource('department-management', DepartmentManagementController::class);
Route::resource('position-management', PositionManagementController::class);
Route::resource('analytics', AnalyticsController::class);

Route::resource('profile', ProfileController::class, ['only' => ['index']]);
Route::put('profile/update-contract/{user}', [ProfileController::class, 'updateContract'])->name('profile.updateContract');
Route::put('profile/updateCompany/{company}', [ProfileController::class, 'updateCompany'])->name('profile.updateCompany');
Route::put('profile/updateFullName/{user}', [ProfileController::class, 'updateFullName'])->name('profile.updateFullName');
Route::put('profile/updateUserName/{user}', [ProfileController::class, 'updateUserName'])->name('profile.updateUserName');
Route::put('profile/updateEmail/{user_logins}', [ProfileController::class, 'updateEmail'])->name('profile.updateEmail');
Route::put('profile/updateTelephone/{user}', [ProfileController::class, 'updateTelephone'])->name('profile.updateTelephone');
Route::put('profile/uploadImage/{user}', [FileUploadController::class, 'storeUploadImage'])->name('profile.storeUploadImage');
