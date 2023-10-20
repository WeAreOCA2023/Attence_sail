<?php




use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\DepartmentManagementController;
use App\Http\Controllers\PositionManagementController;

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

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('tasks', TaskController::class);

Route::group(['middleware' => ['auth', 'can:boss']], function () {
    Route::get('/department-management', [AdminController::class, 'departmentManagement'])->name('department-management');
    Route::get('/department-management', [DepartmentManagementController::class, 'index'])->name('department-management');
    Route::get('/position-management', [AdminController::class, 'positionManagement'])->name('position-management');
    Route::get('/position-management', [PositionManagementController::class, 'index'])->name('position-management');
    Route::get('/user-management', [AdminController::class, 'userManagement'])->name('user-management');
    Route::get('/user-management', [UserManagementController::class, 'index'])->name('user-management');

});


