<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use \DateTime;
use App\Models\VmtClientMaster;
use App\Models\User;
use App\Models\VmtConfigApps;
use App\Models\VmtAppModules;
use App\Models\Department;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\State;
use App\Models\VmtClientModules;
use App\Models\VmtClientSubModules;
use App\Models\VmtAppSubModuleslink;
use App\Models\VmtAppSubModules;
use App\Models\VmtEmpSubModules;
use App\Models\VmtEmpConfigApps;
use Illuminate\Support\Facades\Validator;

// VmtAppPermissions
class VmtAppPermissionsService
{


    public function updateClientModuleStatus($client_id, $module_id, $status)
    {
        $validator = Validator::make(
            $data = [
                'module_id' => $module_id,
                'status' => $status,
            ],
            $rules = [
                'module_id' => 'required',
                'status' => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'numeric' => 'Field <b>:attribute</b> is invalid',
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try {


            $app_config_data = VmtClientSubModules::where('client_id', $client_id)->where("app_sub_module_link_id", $module_id);

            if ($app_config_data->exists()) {

                $app_config_data = $app_config_data->first();
                $app_config_data->status = $status;
                $app_config_data->save();

                $response = ([
                    "status" => "success",
                    "message" => "Configuration done successfully",
                    "data" => "",
                ]);
            } else {

                $response = ([
                    "status" => "failure",
                    "message" => "data not found",
                    "data" => "",
                ]);
            }

            return $response;
        } catch (\Exception $e) {

            return $response = ([

                "status" => "failure",
                "message" => "error while Configuration",
                "data" => $e->getmessage(),

            ]);
        }
    }

    /*
        Used to update single or multiple employees permission for a given module .

        $selected_employees_user_code : Contains user_code and their status values.
    */

    public function updateEmployeesPermissionStatus($client_id, $app_sub_modules_link_id, $selected_employees_user_code)
    {
        $validator = Validator::make(
            $data = [
                'app_sub_modules_link_id' => $app_sub_modules_link_id,
                'selected_employees_user_code' => $selected_employees_user_code,
            ],
            $rules = [
                'app_sub_modules_link_id' => 'required',
                'selected_employees_user_code' => 'nullable',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'numeric' => 'Field <b>:attribute</b> is invalid',
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try {

            $drop_emp_app_config_data = VmtEmpSubModules::where("app_sub_module_link_id", $app_sub_modules_link_id)->where('client_id', $client_id);
            $drop_emp_app_config_data->delete();

            foreach ($selected_employees_user_code as $user_key => $single_user_code) {

                $save_emp_app_config_data = new VmtEmpSubModules;
                $save_emp_app_config_data->client_id = $single_user_code['client_id'];
                $save_emp_app_config_data->user_id = $single_user_code['id'];
                $save_emp_app_config_data->status = $single_user_code['isEnabled'];
                $save_emp_app_config_data->app_sub_module_link_id = $app_sub_modules_link_id;
                $save_emp_app_config_data->save();
            }


            $response = ([
                "status" => "success",
                "message" => "Employee Assigned successfully",
            ]);

            return $response;
        } catch (\Exception $e) {

            return response()->json([

                "status" => "failure",
                "message" => "error while Configuration",
                "data" => $e->getmessage() . " line " . $e->getline(),

            ]);
        }
    }

    public function getEmployee_AllModulePermissionsDetails($user_code)
    {

        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
            ],
            $rules = [
                'user_code' => 'required',
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

            $user_data = User::where('user_code', $user_code)->first();

            $module_data = VmtAppModules::get('id')->toarray();
            // $sub_module_data = VmtAppSubModuleslink::get('id')->toarray();




            $single_emp_config_data = array();
            $i = 0;
            foreach ($module_data as $key => $single_module_data) {


                $employee_config_details = VmtAppSubModuleslink::join("vmt_app_sub_modules", "vmt_app_sub_modules.id", "=", "vmt_app_sub_modules_links.sub_module_id")
                    ->join("vmt_app_modules", "vmt_app_modules.id", "=", "vmt_app_sub_modules_links.module_id")
                    ->join("vmt_client_sub_modules", "vmt_client_sub_modules.app_sub_module_link_id", "=", "vmt_app_sub_modules_links.id")
                    ->where("vmt_app_sub_modules_links.module_id", "=", $single_module_data['id'])
                    ->where("vmt_client_sub_modules.client_id", "=", $user_data->client_id)
                    ->get([
                        "vmt_app_sub_modules_links.id as id",
                        "vmt_app_modules.module_name",
                        "vmt_app_sub_modules.sub_module_name",
                        "vmt_client_sub_modules.status as sub_module_status"
                    ])->toarray();


                array_push($single_emp_config_data, $employee_config_details);
            }

            $employee_all_modules_details = array();
            $i = 0;
            foreach ($single_emp_config_data as $module_key => $single_module_data) {

                foreach ($single_module_data as $subModule_key => $single_subModule_data) {

                    $employee_all_modules_details[$i]['module_name'] = $single_subModule_data["module_name"];

                    for ($j = 0; $j < count($single_module_data); $j++) {

                        $employee_all_modules_details[$i]['sub_module_details'][$j]['sub_module_name'] = $single_module_data[$j]["sub_module_name"];

                        $employee_all_modules_details[$i]['sub_module_details'][$j]['sub_module_status'] = $single_module_data[$j]["sub_module_status"];

                        $emp_module_status = VmtEmpSubModules::where('user_id', $user_data->id)->where('app_sub_module_link_id', $single_subModule_data['id']);

                        if ($emp_module_status->exists()) {

                            $employee_all_modules_details[$i]['sub_module_details'][$j]['employee_status'] = $emp_module_status->first()->status;
                        } else {

                            $employee_all_modules_details[$i]['sub_module_details'][$j]['employee_status'] = '0';
                        }
                    }
                }
                $i++;
            }


            return response()->json([
                "status" => "success",
                "message" => "Employee config data fetch successfully ",
                "data" => $employee_all_modules_details,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error fetching employee Config data",
                "data" => $e->getmessage() . " error_line " . $e->getline(),
            ]);
        }
    }
    public function getEmployee_MobileModulePermissionsDetails($user_code, $mobile_module_id)
    {

        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
                'mobile_module_id' => $mobile_module_id,
            ],
            $rules = [
                'user_code' => 'required',
                'mobile_module_id' => 'required',
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

            $employee_all_modules_details = $this->getEmployee_SingleModulePermissionsDetails($user_code, $mobile_module_id);


            return response()->json([
                "status" => "success",
                "message" => "Employee config data fetch successfully ",
                "data" => $employee_all_modules_details,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error fetching employee Config data",
                "data" => $e->getmessage() . " error_line " . $e->getline(),
            ]);
        }
    }
    private function getEmployee_SingleModulePermissionsDetails($user_code, $mobile_module_id)
    {

        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
                'mobile_module_id' => $mobile_module_id,
            ],
            $rules = [
                'user_code' => 'required',
                'mobile_module_id' => 'required',
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

            $user_data = User::where('user_code', $user_code)->first();

            $single_emp_config_data = VmtAppSubModuleslink::join("vmt_app_sub_modules", "vmt_app_sub_modules.id", "=", "vmt_app_sub_modules_links.sub_module_id")
                ->join("vmt_app_modules", "vmt_app_modules.id", "=", "vmt_app_sub_modules_links.module_id")
                ->join("vmt_client_sub_modules", "vmt_client_sub_modules.app_sub_module_link_id", "=", "vmt_app_sub_modules_links.id")
                ->where("vmt_app_sub_modules_links.module_id", "=", $mobile_module_id)
                ->where("vmt_client_sub_modules.client_id", "=", $user_data->client_id)
                ->get([
                    "vmt_app_sub_modules_links.id as id",
                    "vmt_app_modules.module_name",
                    "vmt_app_sub_modules.sub_module_name",
                    "vmt_client_sub_modules.status as sub_module_status"
                ])->toarray();


            $employee_all_modules_details = array();
            $i = 0;
            $sub_module_details['sub_module_details'] = array();

            // ['sub_module_details']
            foreach ($single_emp_config_data as $module_key => $single_module_data) {

                $employee_all_modules_details['module_name'] = $single_module_data["module_name"];

                $employee_all_modules_details['sub_module_details'][$i]['sub_module_name'] = $single_module_data["sub_module_name"];

                $employee_all_modules_details['sub_module_details'][$i]['sub_module_status'] = $single_module_data["sub_module_status"];

                $emp_module_status = VmtEmpSubModules::where('user_id', $user_data->id)->where('app_sub_module_link_id', $single_module_data['id']);

                if ($emp_module_status->exists()) {

                    $employee_all_modules_details['sub_module_details'][$i]['employee_status'] = $emp_module_status->first()->status;
                } else {

                    $employee_all_modules_details['sub_module_details'][$i]['employee_status'] = 0;
                }


                $i++;
            }
            // array_push($employee_all_modules_details, $sub_module_details['sub_module_details']);

            return $employee_all_modules_details;
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error fetching employee Config data",
                "data" => $e->getmessage() . " error_line " . $e->getline(),
            ]);
        }
    }

    /*
        Get all the module permissions for the given client.
        Dont fetch the employee level data

        Currently used in Web

    */
    public function getClient_AllModulePermissionDetails($client_id)
    {

        $validator = Validator::make(
            $data = [
                'client_id' => $client_id,
            ],
            $rules = [
                'client_id' => 'required|exists:vmt_client_master,id',
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


            $module_id = VmtAppModules::get('id')->toarray();

            $all_modules_config_data = array();

            foreach ($module_id as $key => $single_module_id) {
                $all_modules_data = VmtAppSubModuleslink::join("vmt_app_sub_modules", "vmt_app_sub_modules.id", "=", "vmt_app_sub_modules_links.sub_module_id")
                    ->join("vmt_app_modules", "vmt_app_modules.id", "=", "vmt_app_sub_modules_links.module_id")
                    ->join("vmt_client_sub_modules", "vmt_client_sub_modules.app_sub_module_link_id", "=", "vmt_app_sub_modules_links.id")
                    ->where("vmt_app_sub_modules_links.module_id", "=", $single_module_id['id'])
                    ->where("vmt_client_sub_modules.client_id", "=", $client_id)
                    ->get([
                        "vmt_app_modules.module_name",
                        "vmt_app_sub_modules.sub_module_name",
                        "vmt_client_sub_modules.id as sub_module_id",
                        "vmt_client_sub_modules.status as sub_module_status"
                    ])->toarray();


                array_push($all_modules_config_data, $all_modules_data);
            }

            $all_modules_settings_details = array();
            $i = 0;
            foreach ($all_modules_config_data as $module_key => $single_module_data) {

                foreach ($single_module_data as $subModule_key => $single_subModule_data) {
                    $all_modules_settings_details[$i]['module_name'] = $single_subModule_data["module_name"];
                    $all_modules_settings_details[$i]['sub_module_name'][$single_subModule_data["sub_module_name"]] = $single_subModule_data["sub_module_status"];
                }
                $i++;
            }

            return response()->json([
                "status" => "success",
                "message" => "Data fetch successfully",
                "role" => auth()->user()->org_role,
                "data" => $all_modules_settings_details,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                "status" => "failure",
                "message" => "error while fetching data",
                "data" => $e->getmessage() . " error_line " . $e->getline(),

            ]);
        }
    }

    /*
        Used to show in Mobile Settings page.
        Fetch only the MOBILE_SETTINGS module sub-module details.

                Currently used in Web (Mobile Settings page)

    */

    /*
        Get all the sub-module permissions for a given client and module id

    */
    //getClientPermissions
    public function getClient_MobileModulePermissionDetails($client_id, $module_id, $user_code)
    {

        $validator = Validator::make(
            $data = [
                'client_id' => $client_id,
                'module_id' => $module_id,
                'user_code' => $user_code,
            ],
            $rules = [
                'client_id' => 'required|exists:vmt_client_master,id',
                'module_id' => 'required|exists:vmt_app_modules,id',
                'user_code' => 'nullable|exists:users,user_code',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field <b>:attribute</b> is invalid',
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }
        try {

            if (!empty($user_code)) {
                $user_data = User::where('user_code', $user_code)->first();
                $client_id = $user_data->client_id;
            } else {
                $client_id = $client_id;
            }


            $mobile_settings_data = $this->getClient_SingleModulePermissionDetails($client_id, $module_id);

            return response()->json([
                "status" => "success",
                "message" => "Data fetch successfully",
                "data" => $mobile_settings_data,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                "status" => "failure",
                "message" => "error while fetching data",
                "data" => $e->getmessage(),

            ]);
        }
    }
    private function getClient_SingleModulePermissionDetails($client_id, $module_id)
    {

        $validator = Validator::make(
            $data = [
                'client_id' => $client_id,
                'module_id' => $module_id,
            ],
            $rules = [
                'client_id' => 'required|exists:vmt_client_master,id',
                'module_id' => 'required|exists:vmt_app_modules,id',
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




            $mobile_settings_data = VmtAppSubModuleslink::join("vmt_app_sub_modules", "vmt_app_sub_modules.id", "=", "vmt_app_sub_modules_links.sub_module_id")
                ->join("vmt_app_modules", "vmt_app_modules.id", "=", "vmt_app_sub_modules_links.module_id")
                ->join("vmt_client_sub_modules", "vmt_client_sub_modules.app_sub_module_link_id", "=", "vmt_app_sub_modules_links.id")
                ->where("vmt_app_sub_modules_links.module_id", "=", $module_id)
                ->where("vmt_client_sub_modules.client_id", "=", $client_id)
                ->get([
                    "vmt_client_sub_modules.app_sub_module_link_id as id",
                    "vmt_app_sub_modules_links.module_id",
                    "vmt_app_sub_modules_links.sub_module_id",
                    "vmt_app_modules.title as module_name",
                    "vmt_app_sub_modules.title as sub_module_name",
                    "vmt_client_sub_modules.status",
                    "vmt_client_sub_modules.client_id"
                ]);


            foreach ($mobile_settings_data as $key => $single_value) {

                $emp_data = VmtEmpSubModules::where("client_id", $single_value['client_id'])->where("app_sub_module_link_id", $single_value['id'])->pluck('user_id');
                $emp_data = $emp_data->toarray();

                if (!empty($emp_data)) {

                    $emp_count = count($emp_data);
                } else {
                    $emp_count = 0;
                }
                $mobile_settings_data[$key]['employee_count'] =  $emp_count;
            }

            return $mobile_settings_data;
        } catch (\Exception $e) {

            return response()->json([
                "status" => "failure",
                "message" => "error while fetching data",
                "data" => $e->getmessage(),

            ]);
        }
    }

    public function getClient_AllModuleDetails($client_id)
    {

        $validator = Validator::make(
            $data = [
                'client_id' => $client_id,
            ],
            $rules = [

                'client_id' => 'required|exists:vmt_client_master,id',
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


            $all_module_id = VmtAppModules::pluck('id');

            $client_all_modules_details = array();

            foreach ($all_module_id as $key => $single_module_id) {

                $single_client_config_data = VmtAppSubModuleslink::join("vmt_app_sub_modules", "vmt_app_sub_modules.id", "=", "vmt_app_sub_modules_links.sub_module_id")
                    ->join("vmt_app_modules", "vmt_app_modules.id", "=", "vmt_app_sub_modules_links.module_id")
                    ->join("vmt_client_sub_modules", "vmt_client_sub_modules.app_sub_module_link_id", "=", "vmt_app_sub_modules_links.id")
                    ->where("vmt_app_sub_modules_links.module_id", $single_module_id)
                    ->where("vmt_client_sub_modules.client_id", "=", $client_id)
                    ->get([

                        "vmt_app_modules.id",
                        "vmt_app_modules.module_name",
                        "vmt_app_modules.title as module_title",
                        "vmt_app_sub_modules.sub_module_name",
                        "vmt_app_sub_modules.title as sub_module_title",
                        "vmt_client_sub_modules.id as sub_module_id",
                        "vmt_client_sub_modules.status as sub_module_status"
                    ])->toarray();

                $client_single_modules_data = array();
                $i = 0;

                foreach ($single_client_config_data as $module_key => $single_module_data) {
                    $module_id = "";
                    $module_status = "";
                    $module_data = VmtClientModules::where('module_id', $single_module_data['id'])->where('client_id', $client_id);

                    if ($module_data->exists()) {

                        $module_data = $module_data->first();
                        $module_id = $module_data->id;
                        $module_status = $module_data->status;
                    }

                    $client_single_modules_data['module_id'] = $module_id;
                    $client_single_modules_data['module_name'] = $single_module_data["module_title"];
                    $client_single_modules_data['module_status'] = $module_status;
                    $client_single_modules_data['sub_module_details'][$i]['module_id'] = $module_id;
                    $client_single_modules_data['sub_module_details'][$i]['sub_module_name'] = $single_module_data["sub_module_title"];
                    $client_single_modules_data['sub_module_details'][$i]['sub_module_id'] = $single_module_data["sub_module_id"];
                    $client_single_modules_data['sub_module_details'][$i]['sub_module_status'] = $single_module_data["sub_module_status"];

                    $i++;
                }
                array_push($client_all_modules_details, $client_single_modules_data);
            }


            return response()->json([
                "status" => "success",
                "message" => "Employee config data fetch successfully ",
                "data" => $client_all_modules_details,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error fetching employee Config data",
                "data" => $e->getmessage() . " error_line " . $e->getline(),
            ]);
        }
    }

    public function update_AllClientModuleStatus($client_id,$module_id,$sub_module_id ,$module_status ,$sub_module_status)
    {
        $validator = Validator::make(
            $data = [
                'client_id' => $client_id,
                'module_id' => $module_id,
                'sub_module_id' => $sub_module_id,
                'module_status' => $module_status,
                'sub_module_status' => $sub_module_status,
            ],
            $rules = [
                'module_id' => 'nullable',
                'sub_module_id' => 'nullable',
                'module_status' => 'nullable',
                'sub_module_status' => 'nullable',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'numeric' => 'Field <b>:attribute</b> is invalid',
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try {

            $app_config_data = "";
            if(!empty($module_id)){

                $app_config_data = VmtClientModules::where('client_id', $client_id)->where("module_id", $module_id);
            }
            if(!empty($sub_module_id)){

                $app_config_data = VmtClientSubModules::where('client_id', $client_id)->where("id", $sub_module_id);
            }



            if ($app_config_data->exists()) {

                $app_config_data = $app_config_data->first();

                $app_config_data->status = $module_status ?? $sub_module_status;

                $app_config_data->save();

                $response = ([
                    "status" => "success",
                    "message" => "Configuration done successfully",
                    "data" => "",
                ]);
            } else {

                $response = ([
                    "status" => "failure",
                    "message" => "data not found",
                    "data" => "",
                ]);
            }

            return $response;
        } catch (\Exception $e) {

            return $response = ([

                "status" => "failure",
                "message" => "error while Configuration",
                "data" => $e->getmessage(),

            ]);
        }
    }
    function getAllDropdownFilterSetting()
    {

        $current_user_role = auth()->user()->org_role;

        $option_all = ['id' => 0, 'name' => 'All'];

        try {

            $queryGetDept = Department::select('id', 'name')->get();
            $queryGetDept->push($option_all);

            $queryGetDesignation = VmtEmployeeOfficeDetails::select('designation')->where('designation', '<>', 'S2 Admin')->whereNotNull("designation")->distinct()->get();
            $queryGetDesignation->push($option_all);

            $queryGetLocation = VmtEmployeeOfficeDetails::select('work_location')->whereNotNull("work_location")->distinct()->get();
            $queryGetLocation->push($option_all);

            $queryGetstate = State::select('id', 'state_name')->distinct()->get();
            $queryGetstate->push($option_all);

            if (($current_user_role == 1 || $current_user_role == 2) && sessionGetSelectedClientid() == "1") {

                $queryGetlegalentity = VmtClientMaster::get(['id', 'client_name']);
            } else {
                $queryGetlegalentity = VmtClientMaster::where('id', sessionGetSelectedClientid())->get(['id', 'client_name']);
            }


            $getsalary = ["department" => $queryGetDept, "designation" => $queryGetDesignation, "location" => $queryGetLocation, "state" => $queryGetstate, "legalEntity" => $queryGetlegalentity];


            return response()->json($getsalary);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error fetching the dropdown value",
                "data" => $e,
            ]);
        }
    }

    /*
    Input JSON :
        {
            "module_name" : "core",
            "sub_module_names" : [
                { "name" : "is_web_enabled", "status" : "true"  },
                { "name" : "is_enabled", "status" : "true"  },
            ]

        }


    */
    function createModule_Submodules($module_name, $array_sub_modules,$client_id){

        $validator = Validator::make(
            $data = [
                'module_name' => $module_name,
                'array_sub_modules' => $array_sub_modules,
                'client_id' => $client_id,
            ],
            $rules = [
                'module_name' => 'required|unique:vmt_app_modules,module_name',
                'array_sub_modules' => 'required|array',
                'client_id' => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'unique' => 'Field <b>:attribute</b> is invalid',
                'array' => 'Field <b>:attribute</b> is datatype mismatch',
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try{

         $app_modules = new VmtAppModules;
         $app_modules->module_name = strtoupper($module_name);
         $app_modules->title = $module_name;
         $app_modules->save();

         foreach($array_sub_modules as $single_value){
            $app_submodule = new VmtAppSubModules;
            $app_submodule->sub_module_name = 'IS_' . strtoupper($single_value);
            $app_submodule->title = $single_value;
            $app_submodule->save();
         }

        $app_module_link = new VmtAppSubModuleslink;
        $app_module_link->module_id = $app_modules->id;
        $app_module_link->sub_module_id = $app_submodule->id;
        $app_module_link->save();

        $app_client_module = new VmtClientModules;
        $app_client_module->client_id = $client_id;
        $app_client_module->module_id = $app_modules->id;
        $app_client_module->status = 0;
        $app_client_module->save();

        return $response = ([
            "status" => "success",
            "message" => "saved module_settings",
        ]);

        }catch (\Exception $e) {
            return $response = ([
                "status" => "failure",
                "message" => "error while Configuration",
                "data" => $e->getmessage(),

            ]);
        }



    }
}
