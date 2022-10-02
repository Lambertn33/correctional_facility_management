<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\Visitors\VisitorsController;
use Illuminate\Support\Facades\Route;

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

//Authentication Routes
Route::controller(AuthenticationController::class)->group(function (){
    Route::prefix('login')->group(function() {
        Route::get('/','getLoginPage')->name('getLoginPage');
        Route::post('/','authenticate')->name('authenticate');
    });
    Route::post('logout', [AuthenticationController::class,'logout'])->name('logout');
});

//Appointments Requests Routes
Route::controller(VisitorsController::class)->group(function() {
    Route::get('/','getHomePage')->name('getHomePage');
    Route::post('/','requestAppointment')->name('requestAppointment');
});

//SuperAdmin Routes

Route::controller(SuperAdminDashboardController::class)->prefix('super-admin')->group(function() {
    Route::prefix('dashboard')->group(function() {
        Route::get('/','getSuperAdminDashboardOverview')->name('getSuperAdminDashboardOverview');
    });
});

//Admin Routes

Route::controller(AdminDashboardController::class)->prefix('admin')->group(function() {
    Route::prefix('dashboard')->group(function() {
        Route::get('/','getAdminDashboardOverview')->name('getAdminDashboardOverview');
    });
});
