<?php

namespace App\Http\Controllers\Admin;

use App\Charts\Admin\InmatesChart;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function getAdminDashboardOverview(InmatesChart $inmatesChart)
    {
        $authenticatedUser = Auth::user();
        $authenticatedAdmin = $authenticatedUser->admin;
        $currentPrison = $authenticatedAdmin->prison;
        $activeInmates = $currentPrison->inmates()->where('status', \App\Models\Inmate::ACTIVE)->count();
        $inactiveInmates = $currentPrison->inmates()->where('status', \App\Models\Inmate::INACTIVE)->count();
        $currentMonth = date('m');
        $currentMonthAppointments = 0;
        $todayAppointments = 0;
        $currentPrisonInmates = $currentPrison->inmates()->get();
        $currentPrisonPendingAppointments = $currentPrison->appointments()->where('status', Appointment::PENDING)->latest()->limit(5)->get();
        $inmatesChart = $inmatesChart->build();
        foreach ($currentPrisonInmates as $inmate) {
            $currentMonthAppointments = $currentMonthAppointments + $inmate->appointments()->whereMonth('created_at', $currentMonth)->count();
            $todayAppointments = $todayAppointments + $inmate->appointments()->whereDate('created_at', Carbon::today())->count();
        }
        return view('admin.dashboard.dashboard',
         compact('authenticatedUser',
          'authenticatedAdmin',
          'currentPrison', 
          'inmatesChart', 
          'activeInmates', 
          'inactiveInmates',
          'todayAppointments',
          'currentMonthAppointments',
          'currentPrisonPendingAppointments'
        ));
    }
}
