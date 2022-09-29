<?php

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

Route::controller(VisitorsController::class)->group(function() {
    Route::get('/','index');
    Route::post('/','requestAppointment')->name('requestAppointment');
});