<?php

namespace App\Http\Controllers;
use App\Http\Controllers\VmtClientController;

use App\Models\VmtMasterConfig;
use App\Models\VmtClientMaster;
use App\Models\User;
use App\Models\VmtAppSubModuleslink;
use App\Models\VmtAppSubModules;
use App\Models\VmtAppModules;
use App\Models\VmtEmpSubModules;
use App\Models\VmtClientSubModules;
use App\Models\VmtEmpAssignSalaryAdvSettings;
use App\Services\VmtAppPermissionsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VmtMasterConfigController extends Controller
{
    public function index(Request $request) {
        //Fetch all master configs
        $masterData = VmtMasterConfig::all(['config_name','config_value']);
        $employees_hr = User::where('is_ssa','0')
                        ->where('active','1')
                        ->whereIn('org_role',['3','2'])
                        ->select('id','name','user_code')
                        ->get();

        //$employees_hr = json_encode($employees_hr);
        //dd($employees_hr);

        //Convert to KV pair
        $data = $masterData->mapWithKeys(function ($item, $key) {
            return [$item['config_name'] => $item['config_value']];
        });


        return view('vmt_config_master', compact('data','employees_hr'));
    }

    public function store(Request $request) {

        $input = $request->all();
        //remove unwanted array fields
        unset($input['_token']);


        foreach($input as $key => $value)
        {

            //Update client code
            if($key == "client_code")
            {
                $clientData  = VmtClientMaster::first()->update(['client_code' => $value]);
            }
            else
            {

                $clinet_id =0;
                $query_client = VmtClientMaster::find(session('client_id'));
                if (!empty($query_client)){
                    $clinet_id = $query_client->id;
                 }
                 $temp = VmtMasterConfig::where('config_name',$key)->update(['config_value' => $value]);
                 $update_client_id = VmtMasterConfig::where('config_name',"client_id")->update(['config_value' => $clinet_id]);

            }




        }

        //dd($queryData);
        //update in db
        //VmtMasterConfig::where()
        return redirect()->back();

    }

    public function getMaxClientCode()
    {
        //Get the most recent employee emp_code from USERS table

        //Increment it

        //return the value

    }

    public function showMobileSettingsPage(Request $request){

        return view('vmt_mobile_settings_page');

    }

    public function  updateClientModuleStatus(Request $request,VmtAppPermissionsService $serviceVmtMasterConfigService){
         $client_id = sessionGetSelectedClientid();

        $response = $serviceVmtMasterConfigService->updateClientModuleStatus( $client_id,$request->module_id,$request->status);

        return response()->json($response);

    }

    public function updateEmployeesPermissionStatus(Request $request,VmtAppPermissionsService $serviceVmtAppPermissionsService){

        $client_id = sessionGetSelectedClientid();
        $response = $serviceVmtAppPermissionsService->updateEmployeesPermissionStatus($client_id,$request->app_sub_modules_link_id,$request->selected_employees_user_code);


        return $response;

    }

    public function getClient_MobileModulePermissionDetails( Request $request ,VmtAppPermissionsService $serviceVmtAppPermissionsService){

         $module_id =VmtAppModules::where('module_name',"MOBILE APP SETTINGS")->pluck('id');

        return  $serviceVmtAppPermissionsService->getClient_MobileModulePermissionDetails($request->client_id,$module_id,$user_code=null);
    }
    public function getClient_AllModulePermissionDetails( Request $request ,VmtAppPermissionsService $serviceVmtAppPermissionsService){

        $client_id =sessionGetSelectedClientid();

        return  $serviceVmtAppPermissionsService->getClient_AllModulePermissionDetails($client_id);

    }
    public function getClient_AllModuleDetails( Request $request ,VmtAppPermissionsService $serviceVmtAppPermissionsService){

        $client_id =sessionGetSelectedClientid();


        return  $serviceVmtAppPermissionsService->getClient_AllModuleDetails($client_id);
    }

    public function getAllDropdownFilterSetting(Request $request,VmtAppPermissionsService $serviceVmtAppPermissionsService){

        return  $serviceVmtAppPermissionsService->getAllDropdownFilterSetting();


    }

    public function  update_AllClientModuleStatus(Request $request,VmtAppPermissionsService $serviceVmtMasterConfigService){

        $client_id = sessionGetSelectedClientid();

       $response = $serviceVmtMasterConfigService->update_AllClientModuleStatus( $client_id,$request->module_id,$request->sub_module_id ,$request->module_status ,$request->sub_module_status);

       return response()->json($response);

   }
    public function getEmployeesFilterData(Request $request){

        $filtered_data = $this->employees_filter_data($request->department_id , $request->designation, $request->work_location, $request->client_name,$request->sub_module_id);

        foreach ($filtered_data as $key => $single_value) {
             $emp_module_status =VmtEmpSubModules::where('client_id',sessionGetSelectedClientid())->where('app_sub_module_link_id',$request->sub_module_id)->where('user_id', $single_value['id']);
             if($emp_module_status->exists()){
                $filtered_data[$key]['status'] = $emp_module_status->first()->status;
             }else{
                $filtered_data[$key]['status'] = 0;
             }
        }


        return $filtered_data;

    }
   public function employees_filter_data($department_id, $designation, $work_location, $client_name)
    {

        try {

            $select_employee = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->leftjoin('vmt_department', 'vmt_department.id', '=', 'vmt_employee_office_details.department_id')
                ->join('vmt_client_master', 'vmt_client_master.id', '=', 'users.client_id')
                ->where('is_ssa','0')
                ->select(
                    'users.id',
                    'users.name',
                    'users.user_code',
                    'vmt_department.name as department_name',
                    'vmt_employee_office_details.designation',
                    'vmt_employee_office_details.work_location',
                    'vmt_client_master.client_name',
                    'vmt_client_master.id as client_id',
                );

            if (!empty($department_id)) {
                $select_employee = $select_employee->where('department_id', $department_id);
            }
            if (!empty($designation)) {
                $select_employee = $select_employee->where('designation', $designation);
            }
            if (!empty($work_location)) {
                $select_employee = $select_employee->where('work_location', $work_location);
            }
            if (!empty($client_name)) {
                $select_employee = $select_employee->where('client_id', $client_name);
            }
            // dd($select_employee->get());

            $employee_data = $select_employee->get();


             return $employee_data->toarray();

        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error fetching the employee",
                "data" => $e,
            ]);
        }
    }

}
