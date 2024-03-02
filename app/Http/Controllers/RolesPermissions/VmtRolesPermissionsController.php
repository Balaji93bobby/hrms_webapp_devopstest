<?php

namespace App\Http\Controllers\RolesPermissions;

use App\Http\Controllers\Controller;
use App\Services\VmtRolesPermissionsService;
use Illuminate\Http\Request;

class VmtRolesPermissionsController extends Controller
{


    public function showRolesPermissionsPage(Request $request){
        return view('roles_permissions.vmt_roles_permissions_main_view');
    }

    public function getAllRoles(Request $request, VmtRolesPermissionsService $serviceVmtRolesPermissionsService){
        //serviceVmtRolesPermissionsService

        return $serviceVmtRolesPermissionsService->getAllRoles();
    }

    /*
        Get all permissions for the given role

    */
    public function getAllPermissions(Request $request , VmtRolesPermissionsService $serviceVmtRolesPermissionsService){

        return $serviceVmtRolesPermissionsService->getAllPermissions();
    }



    public function getAssignedUsers_ForGivenRole(Request $request  , VmtRolesPermissionsService $serviceVmtRolesPermissionsService){

        return $serviceVmtRolesPermissionsService->getAssignedUsers_ForGivenRole();

    }

    public function createRole(Request $request, VmtRolesPermissionsService $serviceVmtRolesPermissionsService){

        // $request->role_name = "CEO";
        // $request->role_description = "all access of the company";

        return $serviceVmtRolesPermissionsService->createRole($request->role_name ,$request->role_description);
    }


    /*
        Get the Role details such as description, title, permissions
    */
    public function getRoleDetails(Request $request, VmtRolesPermissionsService $serviceVmtRolesPermissionsService){

        // $request->role_name = "superadmin";
        return $serviceVmtRolesPermissionsService->getRoleDetails();
    }

    /*
        Updates the Role details such as description, title
    */
    public function updateRoleDetails(Request $request , VmtRolesPermissionsService $serviceVmtRolesPermissionsService){

        // $request->role_id = "17";
        // $request->updated_role_name = "developer";
        // $request->updated_role_description = "simma is bad boy";

        return $serviceVmtRolesPermissionsService->updateRoleDetails($request->role_id, $request->updated_role_name, $request->updated_role_description, $request->updated_permissions_array);
    }

    /*
        Updates the permissions for the given Role

    */
    public function updatePermissions_ForGivenRole(Request $request){

    }

    public function deleteRole(Request $request , VmtRolesPermissionsService $serviceVmtRolesPermissionsService){

        // $request->role_id = "17";

        return $serviceVmtRolesPermissionsService->deleteRole($request->role_id);

    }

    public function createPermission(Request $request, VmtRolesPermissionsService $serviceVmtRolesPermissionsService){

        // $request->permission_name = "emp" ;
        // $request->permission_module = "inve" ;

        return $serviceVmtRolesPermissionsService->createPermission($request->permission_name,$request->permission_module);
    }

    /*
        Get Permission details such as description, title
    */
    public function getPermissionDetails(Request $request, VmtRolesPermissionsService $serviceVmtRolesPermissionsService){

        return $serviceVmtRolesPermissionsService->getPermissionDetails();

    }

    /*
        Updates the Permission details such as description, title
    */
    public function updatePermissionDetails(Request $request){

    }

    public function deletePermission(Request $request, VmtRolesPermissionsService $serviceVmtRolesPermissionsService){

        // $request->permission_id = "6" ;

        return $serviceVmtRolesPermissionsService->createPermission($request->permission_id);
    }

    /*
        Assign roles for the given array of users.
        This also handles updates
    */
    public function assignRoleToUsers(Request $request, VmtRolesPermissionsService $serviceVmtRolesPermissionsService){

        $request->user_code ="PSC0075";
        $request->role_name = "superadmin";

        return $serviceVmtRolesPermissionsService->assignRoleToUsers($request->user_code,$request->role_name);

    }

    public function removeRoleToUsers(Request $request, VmtRolesPermissionsService $serviceVmtRolesPermissionsService){

        // $request->user_code = "PSC0075";
        // $request->role_name = "superadmin";

        return $serviceVmtRolesPermissionsService->removeRoleToUsers($request->user_code,$request->role_name);
    }

}
