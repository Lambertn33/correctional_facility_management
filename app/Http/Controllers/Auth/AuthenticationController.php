<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\Auth\CheckUserRoleService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    public function getLoginPage()
    {
        return view('auth.login');
    }

    public function updateUserOnAuthentication($user, $isLoggedIn) {
        $user->update([
            'is_logged_in' => $isLoggedIn ? true : false
        ]);
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
                    //TODO update Password
                    return 'need to update password';
                } else {
                    if ($authenticatedUser->is_logged_in) {
                        Auth::logout();
                        return back()->withInput()->with('error','Please logout from the other devices first');
                    } else {
                        DB::beginTransaction();
                        $this->updateUserOnAuthentication(User::find($authenticatedUser->id), true);
                        DB::commit();
                        return redirect()->route('getAdminDashboardOverview');
                    }
                }
            }
        } else {
            return back()->withInput()->with('error','Invalid credentials..');
        }
    }

    public function logout()
    {
       DB::beginTransaction();
       $authenticatedUser = Auth::user();
       $this->updateUserOnAuthentication(User::find($authenticatedUser->id), false);
       DB::commit();
       Auth::logout();
       return redirect()->route('getHomePage');
    }
}
