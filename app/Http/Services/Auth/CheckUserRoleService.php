<?php 
 namespace App\Http\Services\Auth;
 use App\Models\Role;
 use Illuminate\Support\Facades\Auth;

 class CheckUserRoleService {

    public function isAdministrator($user)
    {
        return $this->checkRole($user, \App\Models\Role::ADMINISTRATOR) ? true : false;
    }
    public function isSuperAdministrator($user)
    {
        return $this->checkRole($user, \App\Models\Role::SUPER_ADMINISTRATOR) ? true : false;
    }


    public function checkRole($currentUser, $role)
    {
        $RoleId = Role::where('name', $role)->first();
        return $currentUser->role_id == $RoleId->id ? true : false;
    }
 }

?>