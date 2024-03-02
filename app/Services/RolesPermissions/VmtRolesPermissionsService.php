<?php

namespace App\Services\RolesPermissions;

use App\Models\VmtPermissionModule;
use App\Models\VmtPermodulePermission;
use App\Models\VmtRolesDescription;
use App\Models\VmtSubModulePermission;
use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use \DateTime;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\VmtClientMaster;
use Dompdf\Dompdf;
use Dompdf\Options;
use \stdClass;
use App\Models\User;
use App\Models\VmtEmployeeDocuments;
use App\Models\VmtDocuments;
use App\Notifications\ViewNotification;
use Illuminate\Support\Facades\Notification;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class VmtRolesPermissionsService
{


    public function getAllRoles()
    {

        try {

            $all_roles_in_database = Role::all()->pluck('name');


            return response()->json([
                "status" => "success",
                "message" => "",
                "data" => $all_roles_in_database,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error while fetching roles",
                "data" => $e,
            ]);
        }
    }

    /*
        Get all permissions for the given role

    */
    public function getAllPermissions()
    {

        // try{

        $all_permission_in_database = VmtPermissionModule::join('vmt_perm_sub_module', 'vmt_perm_sub_module.perm_module_id', '=', 'vmt_perm_module.id')
            ->join('vmt_perm_sm_link', 'vmt_perm_sm_link.sub_module_id', '=', 'vmt_perm_sub_module.id')
            ->join('permissions', 'permissions.id', '=', 'vmt_perm_sm_link.permission_id')
            ->get([
                'vmt_perm_module.id as per_module_id',
                'vmt_perm_module.module_name as per_module_name',
                'vmt_perm_sub_module.id as per_sub_module_id',
                'vmt_perm_sub_module.submodule_name as per_sub_module_name',
                'permissions.id as permission_id',
                'permissions.name as permission_name'
            ]);

        // return ($all_permission_in_database);

        // dd($all_permission_in_database);
        // ->groupBy('label');
        //     $count = 0;

        $permission = array();
        foreach ($all_permission_in_database as $single_details) {

            $simma['per_module_id'] = rand(200, 300);
            $simma['per_module_name'] = $single_details['per_module_name'];
            $simma['per_sub_module_id'] = rand(400, 500);
            $simma['per_sub_module_name'] = $single_details['per_sub_module_name'];
            $simma['children'] = [["key" => $single_details['permission_id'], "label" => $single_details['permission_name']]];

            array_push($permission, $simma);
        }

        // return $permission;

        $res = array();
        foreach ($permission as $single_perm) {

            $per_module['key'] = $single_perm['per_module_id'];
            $per_module['label'] = $single_perm['per_module_name'];
            $per_module['children'] = [["key" => $single_perm['per_sub_module_id'], "label" => $single_perm['per_sub_module_name'], "children" => $single_perm['children']]];

            array_push($res, $per_module);
        }

        return $res;




        //     if (!array_key_exists($single_details["label"], $all_permission_in_database)) {

        //         $all_permission_in_database[$single_details["label"]]=array();



        //         array_push($all_permission_in_database[$single_details["label"]],$single_details);


        // }
        // unset($all_permission_in_database[$count]);

        // $count++;





        //   return response()->json([
        //     "status" => "success",
        //     "message" => "",
        //     "data" => $all_permission_in_database
        //     ]);
        // }
        // catch (\Exception $e) {
        //     return response()->json([
        //         "status" => "failure",
        //         "message" => "Error while fetching permission ",
        //         "data" => $e,
        //     ]);
        // }

        // }
        // dd($all_permission_in_database);
        // return ($res);
    }



    public function getAssignedUsers_ForGivenRole()
    {

        try {

            $all_users_with_all_their_roles = User::with('roles')->get();

            return response()->json([
                "status" => "success",
                "message" => "",
                "data" => $all_users_with_all_their_roles,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error while fetching assign_userroles",
                "data" => $e,
            ]);
        }


    }

    public function createRole($role_name, $role_description)
    {

        $validator = Validator::make(
            $data = [
                'role_name' => $role_name,
                'role_description' => $role_description,

            ],
            $rules = [
                'role_name' => 'required',
                'role_description' => 'required',

            ],
            $messages = [
                'required' => 'Field :attribute is missing',

            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try {

            $create_roles = new Role;
            $create_roles->name = $role_name;
            $create_roles->guard_name = "web";
            $create_roles->save();

            //   $roles = $create_roles;

            $roles_description = new VmtRolesDescription;
            $roles_description->roles_id = $create_roles->id;
            $roles_description->description = $role_description;
            $roles_description->save();

            return response()->json([
                "status" => "success",
                "message" => "Saved",
                "data" => "",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "",
                "data" => $e,
            ]);
        }


    }


    /*
        Get the Role details such as description, title, permissions
    */
    public function getRoleDetails()
    {

        // $validator = Validator::make(
        //     $data = [
        //         'role_name' => $role_name
        //     ],
        //     $rules = [
        //         'role_name' => 'required|exists:roles,name'
        //     ],
        //     $messages = [
        //         'required' => 'Field :attribute is missing',
        //         'exists' => 'Field :attribute is invalid',

        //     ]
        // );

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 'failure',
        //         'message' => $validator->errors()->all()
        //     ]);
        // }
        // try{

        $role_details  = Role::join('vmt_roles_description','vmt_roles_description.roles_id','=','roles.id')
                    ->join('model_has_roles','model_has_roles.role_id','=','roles.id')
                    ->join('users','users.id','=','model_has_roles.model_id')
                    ->join('vmt_employee_office_details','vmt_employee_office_details.user_id','=','users.id')
                    ->join('vmt_department','vmt_department.id','=','vmt_employee_office_details.department_id')
                    ->get(
                        [
                        'roles.id as roles_id',
                        'roles.name as roles_name',
                        'vmt_roles_description.description',
                        'users.name',
                        'users.id as user_id',
                        'users.user_code',
                        'vmt_department.name as department_name'

                    ]
                    )->toArray();

        // return $role_details;
        $all_roles = Role::join('vmt_roles_description', 'vmt_roles_description.roles_id', '=', 'roles.id')->get(['roles.name', 'vmt_roles_description.description']);
         // dd($all_roles);

        $res = array();
         //dd($role_details);
        foreach ($all_roles as $single_roles) {
            $temp_ar = array(
                'name' => $single_roles['name'],
                'description' => $single_roles['description'],
                'assigned_emp'=>  Role::join('model_has_roles', 'model_has_roles.role_id', '=', 'roles.id')
                                      ->join('users', 'users.id', '=', 'model_has_roles.model_id')->where('roles.name', $single_roles['name'])->get()->count(),
                'assigned_privileged'=>  Role::join('role_has_permissions', 'role_has_permissions.role_id', '=', 'roles.id')
                                       ->leftjoin('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')->where('roles.name', $single_roles['name'])->get()->count(),
                'accordian'=>[],
            );
            $temp_ac = array();
            foreach ($role_details as $single_details) {
                // dd(in_array($single_roles['name'], $single_details));
                if (in_array($single_roles['name'], $single_details)) {

                          array_push($temp_ar['accordian'],$single_details);

                    array_push($temp_ac, $temp_ar);

                }
            }
            // dd($temp_ac);
           if(!empty($temp_ac)){
                // array_push(  $temp_ar,$temp_ac);
                array_push($res, $temp_ar);
            }
           // $temp_ar['acccc'] = $temp_ac;
           // dd($temp_ar);
            unset($temp_ac);
            unset($temp_ar);

        }
           return ($res);
        // $res = array();
        // dd($role_details);
        // foreach ($role_details as $single_roles) {

        //     $simma['role'] = $single_roles['roles_name'];
        //     $simma['description'] = $single_roles['description'];
        //     $simma['assigned_emp'] = Role::join('model_has_roles', 'model_has_roles.role_id', '=', 'roles.id')
        //         ->join('users', 'users.id', '=', 'model_has_roles.model_id')->where('roles.name', $single_roles['roles_name'])->get()->count();

        //     $simma['assigned_privileged'] = Role::join('role_has_permissions', 'role_has_permissions.role_id', '=', 'roles.id')
        //         ->leftjoin('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')->where('roles.name', $single_roles['roles_name'])->get()->count();

        //     $simma['accordian'] = $single_roles;
        //     dd();
        //     array_push($res, $simma);
        // }

        // return ($simma);

        // $roles_def = array();
        $res1 = array();
        $count = 0;
        foreach ($res as $res_details) {

            // dd($res_details['accordian']);

            // $simma1['assigned_emp'] = $res_details['assigned_emp'];
            // $simma1['assigned_privileged'] = $res_details['assigned_privileged'];

            // array_push($roles_def,$res_details['accordian']);

            // if(){

            $simma1['roles'] = $res_details['role'];
            $simma1['description'] = $res_details['description'];
            $simma1['assigned_emp'] = $res_details['assigned_emp'];
            $simma1['assigned_privileged'] = $res_details['assigned_privileged'];
            $simma1['accordion'] = $mass;

            // }


        }
        array_push($res1, $simma1);



        return ($res1);




        // $count = 0;
        //     foreach($res as $single_res){

        //         if(!array_key_exists($single_res["role"], $res)) {

        //             $res[$single_res["role"]]=array();
        //             array_push($res[$single_res["role"]],$single_res);
        //     }else{

        //         array_push($res[$single_res["role"]],$single_res);
        //     }

        //     unset($res[$count]);

        //     $count++;


        // }

        // return $res;





        // }
        // catch (\Exception $e) {
        //     return response()->json([
        //         "status" => "failure",
        //         "message" => "",
        //         "data" => $e,
        //     ]);
        // }


    }


    /*
        Updates the Role details such as description, title
    */
    public function updateRoleDetails($role_id, $updated_role_name, $updated_role_description, $updated_permissions_array)
    {

        $validator = Validator::make(
            $data = [
                'role_id' => $role_id,
                'updated_role_name' => $updated_role_name,
                'updated_role_description' => $updated_role_description
            ],
            $rules = [
                'role_id' => 'required|exists:roles,id',
                'updated_role_name' => 'required',
                'updated_role_description' => 'required'
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',

            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try {
            $update_role = Role::find($role_id);

            if (($update_role)->exists()) {
                $update_role->name = $updated_role_name;
                $update_role->save();
            }

            $updated_description = VmtRolesDescription::where('roles_id', $role_id)->first();

            if (($updated_description)->exists()) {
                $updated_description->description = $updated_role_description;
                $updated_description->save();
            }

            return response()->json([
                "status" => "success",
                "message" => "Updated successfully",
                "data" => "",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "",
                "data" => $e,
            ]);
        }

    }

    /*
        Updates the permissions for the given Role

    */
    public function updatePermissions_ForGivenRole()
    {




    }

    public function deleteRole($role_id)
    {

        $validator = Validator::make(
            $data = [
                'role_id' => $role_id,
            ],
            $rules = [
                'role_id' => 'required|exists:roles,id',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try {
            $del_description = VmtRolesDescription::where('roles_id', $role_id)->first();
            $del_description->delete();

            $del_role = Role::find($role_id);
            $del_role->delete();

            return response()->json([
                "status" => "success",
                "message" => "Deleted successfully",
                "data" => "",
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "",
                "data" => $e,
            ]);
        }



    }

    public function createPermission($permission_name, $permission_module)
    {

        $validator = Validator::make(
            $data = [
                'permission_name' => $permission_name,
                'permission_module' => $permission_module,
            ],
            $rules = [
                'permission_name' => 'required',
                'permission_module' => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try {
            //    $per_exist =  Permission::where('name',$permission_name)->first();
            $permodule_exist = VmtPermissionModule::where('module_name', $permission_module)->first();

            if (!empty($permodule_exist)) {

                $create_permission = Permission::create(['name' => $permission_name, 'guard_name' => "web"]);
                VmtPermodulePermission::create(['per_module_id' => $permodule_exist->id, 'permission_id' => $create_permission->id]);

            } else {

                $create_permission = Permission::create(['name' => $permission_name]);

                $create_module = VmtPermissionModule::create(['module_name' => $permission_module]);

                VmtPermodulePermission::create(['per_module_id' => $create_module->id, 'permission_id' => $create_permission->id]);
            }


            return response()->json([
                "status" => "success",
                "message" => "Saved successfully",
                "data" => "",
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "",
                "data" => $e,
            ]);
        }


        // $role_name ="master";
        // $role_permission = array("MANAGE_PAYSLIPS_can_view","MANAGE_PAYSLIPS_release_payslip");
        // $role_description = "worst";

        // $role_Exist  = Role::where('name',$role_name);

        //  if($role_Exist->exists()){

        //       $roles_des =  $role_Exist->first();
        //       VmtRolesDescription::create(['roles_id'=>$roles_des->id,'description'=>$role_description]);
        //       foreach($role_permission as $single_permission){
        //       $roles_des->givePermissionTo($single_permission);

        //     }

        //  }else{

        // $role1 = Role::create(['name' =>$role_name]);
        // VmtRolesDescription::create(['roles_id'=>$role1->id,'description'=>$role_description]);
        // foreach($role_permission as $single_permission){
        // $role1->givePermissionTo($single_permission);

        //     }

        // }


        // return "syn role permission";







    }

    /*
        Get Permission details such as description, title
    */
    public function getPermissionDetails()
    {

            $permission = VmtPermissionModule::join('vmt_perm_sub_module','vmt_perm_sub_module.perm_module_id','=','vmt_perm_module.id')
                                                ->join('vmt_perm_sm_link','vmt_perm_sm_link.sub_module_id','=','vmt_perm_sub_module.id')
                                                ->join('permissions','permissions.id','=','vmt_perm_sm_link.permission_id')
                                                ->get()->toArray();
                                                // ->groupBy(['module_name','submodule_name']);

                                                // return $permission;

                              $master = VmtPermissionModule::join('vmt_perm_sub_module','vmt_perm_sub_module.perm_module_id','=','vmt_perm_module.id')
                              ->join('vmt_perm_sm_link','vmt_perm_sm_link.sub_module_id','=','vmt_perm_sub_module.id')
                              ->join('permissions','permissions.id','=','vmt_perm_sm_link.permission_id')
                              ->get([
                                'vmt_perm_module.id as module_id',
                                'vmt_perm_module.module_name as module_name',
                                'vmt_perm_sub_module.id as submodule_id',
                                'vmt_perm_sub_module.submodule_name as submodule_name',
                              ]);
                                //   return $master;



                            // $masterss  =array();
                              $simma = array();
            foreach($master as $single_mas){

                        $temp = array(
                                      "id"=> $single_mas['submodule_id'],
                                      "sub_module"=>$single_mas['submodule_name'],
                                      "Privilege"=> [],
                        );

                                // dd($temp);
                        $res = array();
                foreach($permission as $single_per){

                    if(in_array($single_mas['submodule_name'],$single_per)){
                         array_push($temp['Privilege'],$single_per);
                        //  array_push($simma,$temp);

                    }

                }

                    dd($temp);

            }

            // dd($temp);






            // $permission =  Permission::all(['id','name']);
            // return($permission);

    }

    /*
        Updates the Permission details such as description, title
    */
    public function updatePermissionDetails()
    {

    }

    public function deletePermission($permission_id)
    {


    }

    /*
        Assign roles for the given array of users.
        This also handles updates
    */
    public function assignRoleToUsers($user_code, $role_name)
    {

        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
                'role_name' => $role_name,
            ],
            $rules = [
                'user_code' => 'required|exists:users.user_code',
                'role_name' => 'required|exists:roles.name',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
            ]
        );

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 'failure',
        //         'message' => $validator->errors()->all()
        //     ]);
        // }

        try {

            $user_code = User::where('user_code', $user_code);

            $user = $user_code->first();
            $user->assignRole($role_name);

            return response()->json([
                "status" => "success",
                "message" => "Emp assign to role",
                "data" => "",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "",
                "data" => $e,
            ]);
        }


    }

    public function removeRoleToUsers($user_code, $role_name)
    {

        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
                'role_name' => $role_name,
            ],
            $rules = [
                'user_code' => 'required|exists:users.user_code',
                'role_name' => 'required|exists:roles.name',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
            ]
        );

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 'failure',
        //         'message' => $validator->errors()->all()
        //     ]);
        // }

        try {

            $user_code = User::where('user_code', $user_code);

            $user = $user_code->first();
            $user->removeRole($role_name);

            return response()->json([
                "status" => "success",
                "message" => "Emp remove to role",
                "data" => "",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "",
                "data" => $e,
            ]);
        }


    }

}
