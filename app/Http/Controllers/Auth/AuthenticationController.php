<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\Auth\CheckUserRoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function getLoginPage()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        if ( Auth::attempt(['email' => $username, 'password' => $password]) || Auth::attempt(['telephone' => $username, 'password' => $password])) {
            $authenticatedUser = Auth::user();
            if ((new CheckUserRoleService)->isSuperAdministrator($authenticatedUser)) {
                return redirect()->route('getSuperAdminDashboardOverview');
            } else {
                if (!$authenticatedUser->admin->has_changed_password || $authenticatedUser->admin->password_expiration_days == 0) {
                    return 'need to update password';
                } else {
                    return redirect()->route('getAdminDashboardOverview');
                }
            }
        } else {
            return back()->withInput()->with('error','Invalid credentials..');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('getHomePage');
    }
}
