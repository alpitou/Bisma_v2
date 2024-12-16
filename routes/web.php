<?php

use App\Http\Controllers\Backend\CityController;
use App\Http\Controllers\Backend\DepartmentController;
use App\Http\Controllers\Backend\DistrictController;
use App\Http\Controllers\Backend\DivisionController;
use App\Http\Controllers\Backend\HomebaseController;
use App\Http\Controllers\Backend\MasterApprovalController;
use App\Http\Controllers\Backend\ProvinceController;
use App\Http\Controllers\Backend\ShiftController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Backend\AdminsController;
use App\Http\Controllers\Backend\Auth\ForgotPasswordController;
use App\Http\Controllers\Backend\Auth\LoginController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\Backend\ModulsController;
use App\Http\Controllers\Backend\MenusController;
use App\Http\Controllers\Backend\SubmenusController;
use App\Http\Controllers\Backend\LevelsController;
use App\Http\Controllers\Backend\PendudukController;
use App\Http\Controllers\Backend\CompanyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@redirectAdmin')->name('index');
Route::get('/home', 'HomeController@index')->name('home');


/**
 * Admin routes
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('roles', RolesController::class);
    Route::resource('admins', AdminsController::class);
    Route::resource('users', UsersController::class);
    Route::any('users/{id}', [UsersController::class, 'update']);
    Route::resource('moduls', ModulsController::class);
    Route::any('moduls/{id}', [ModulsController::class, 'update']);
    Route::get('combomodul', [ModulsController::class, 'combo']);
    Route::resource('menus', MenusController::class);
    Route::any('menus/{id}', [MenusController::class, 'update']);
    Route::get('combomenu', [MenusController::class, 'combo']);
    Route::resource('submenus', SubmenusController::class);
    Route::any('submenus/{id}', [SubmenusController::class, 'update']);
    Route::resource('levels', LevelsController::class);
    Route::any('levels/{id}', [LevelsController::class, 'update']);

    // Login Routes.
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login/submit', [LoginController::class, 'login'])->name('login.submit');

    // Logout Routes.
    Route::post('/logout/submit', [LoginController::class, 'logout'])->name('logout.submit');

    // Forget Password Routes.
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/reset/submit', [ForgotPasswordController::class, 'reset'])->name('password.update');

    Route::get('penduduk/importexcel', [PendudukController::class, 'importExcel'])->name('penduduk.importexcel');
    Route::post('penduduk/import', [PendudukController::class, 'import'])->name('penduduk.import');
    Route::get('penduduk/export', [PendudukController::class, 'export'])->name('penduduk.export');
    Route::resource('penduduk', PendudukController::class);

    // Company routes
    Route::resource('companies', CompanyController::class);
    Route::any('companies/{id}', [CompanyController::class, 'update']);

    // Division routes
    Route::resource('divisions', DivisionController::class);
    Route::any('divisions/{id}', [DivisionController::class, 'update']);

    // Department Routes
    Route::resource('departments', DepartmentController::class);
    Route::resource('departments', DepartmentController::class);
    Route::any('departments/{id}', [DepartmentController::class, 'update']);
    
    // Homebase Routes
    Route::resource('homebases', HomebaseController::class);
    Route::any('homebases/{id}', [HomebaseController::class, 'update']);

    // Shift Routes
    Route::resource('shifts', ShiftController::class);
    Route::any('shifts/{id}', [ShiftController::class, 'update']);

    // Master Approval Routes
    Route::resource('master_approvals', MasterApprovalController::class);
    Route::any('master_approvals/{id}', [MasterApprovalController::class, 'update']);

    //Province Routes
    Route::resource('provinces', ProvinceController::class);
    Route::any('provinces/{id}', [ProvinceController::class, 'update']);
    
    //City Routes
    Route::resource('cities', CityController::class);
    Route::any('cities/{id}', [CityController::class, 'update']);

    //District Routes
    Route::resource('districts', DistrictController::class);
    Route::any('districts/{id}', [DistrictController::class, 'update']);
})->middleware('auth:admin');
