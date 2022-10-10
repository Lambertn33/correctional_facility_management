<?php

use App\Http\Controllers\Admin\AppointmentsController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InmatesController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Common\MeetingsController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\Visitors\VisitorsController;
use Illuminate\Support\Facades\Route;
require __DIR__ . '../../vendor/autoload.php';

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
        Route::get('/', 'getLoginPage')->name('getLoginPage');
        Route::post('/', 'authenticate')->name('authenticate');
    });
    Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
});

Route::controller(MeetingsController::class)->prefix('meetings')->group(function() {
    Route::get('/', 'getMeetingPage')->name('getMeetingPage');
    Route::post('/', 'provideNationalId')->name('provideNationalId');
    Route::get('/join','joinMeeting')->name('joinMeeting');
});

//Appointments Requests Routes
Route::controller(VisitorsController::class)->group(function() {
    Route::get('/', 'getHomePage')->name('getHomePage');
    Route::prefix('appointments')->group(function() {
        Route::get('/','getAppointmentsPage')->name('getAppointmentsPage');
        Route::post('/', 'requestAppointment')->name('requestAppointment');        
    });
});

//SuperAdmin Routes

Route::controller(SuperAdminDashboardController::class)->prefix('super-admin')->group(function() {
    Route::prefix('dashboard')->group(function() {
        Route::get('/', 'getSuperAdminDashboardOverview')->name('getSuperAdminDashboardOverview');
    });
});

Route::prefix('admin')->group(function() {
    //Dashboard
    Route::controller(AdminDashboardController::class)->group(function() {
        Route::prefix('dashboard')->group(function() {
            Route::get('/', 'getAdminDashboardOverview')->name('getAdminDashboardOverview');
        });
    });
    //Appointments
    Route::controller(AppointmentsController::class)->prefix('appointments')->group(function() {
        //Pending Appointments
        Route::prefix('pending')->group(function() {
            Route::get('/', 'getPendingAppointments')->name('getPendingAppointments');
            Route::prefix('{appointment}')->group(function() {
                Route::get('/', 'getSinglePendingAppointment')->name('getSinglePendingAppointment');
                Route::put('/approve', 'approveSinglePendingAppointment')->name('approveSinglePendingAppointment');
                Route::put('/reject', 'rejectSinglePendingAppointment')->name('rejectSinglePendingAppointment');
            });
        });
        //Approved Appointments
        Route::prefix('approved')->group(function() {
            Route::get('/', 'getApprovedAppointments')->name('getApprovedAppointments');
        });
        
        //Rejected Appointments
        Route::prefix('rejected')->group(function() {
            Route::get('/', 'getRejectedAppointments')->name('getRejectedAppointments');
        });

        //outgoing appointments
        Route::prefix('outgoing')->group(function() {
            Route::get('/','createOutgoingAppointment')->name('createOutgoingAppointment');
            Route::post('/','sendOutgoingAppointmentRequest')->name('sendOutgoingAppointmentRequest');
        });

    });

    //Inmates
    Route::controller(InmatesController::class)->prefix('inmates')->group(function() {
        Route::get('/' ,'getPrisonInmates')->name('getPrisonInmates'); 
        Route::prefix('create')->group(function() {
            Route::get('/' ,'createNewPrisonInmate')->name('createNewPrisonInmate'); 
            Route::post('/' ,'saveNewPrisonInmate')->name('saveNewPrisonInmate'); 
            Route::prefix('{inmate}')->group(function() {
                Route::get('/', 'editPrisonInmate')->name('editPrisonInmate');
                Route::put('/', 'updatePrisonInmate')->name('updatePrisonInmate');
            });
        });
    });
});
