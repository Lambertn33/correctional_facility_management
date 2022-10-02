<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('superAdmin');
    }

    public function getSuperAdminDashboardOverview()
    {
        return 'Super Admin Dashboard Overview';
    }
}
