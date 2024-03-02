<?php

namespace App\Services;

use App\Models\User;
use App\Models\VmtEmpPaygroup;
use App\Models\VmtPaygroup;
use App\Models\VmtPaygroupComps;
use App\Models\VmtPayrollEpf;
use App\Models\VmtPayrollEsi;
use App\Models\VmtEmployeeStatutoryDetails;
use App\Models\VmtPayrollEpfCalculation;
use App\Models\VmtProfessionalTaxSettings;
use App\Models\VmtPayrollCompCategory;
use App\Models\VmtLabourWelfareFundSettings;
use App\Models\VmtAppIntegration;
use App\Models\Department;
use App\Models\VmtPayrollCompTypes;
use Illuminate\Support\Facades\DB;
use App\Models\VmtPayrollComponents;
use Illuminate\Support\Facades\Validator;

class VmtPayrollComponentsService{



    public function getPayrollEpfDetails(){
        try{

            $payroll_epf_data =VmtPayrollEpf::get(['epf_number','epf_deduction_cycle as deduction_cycle','epf_rule','epf_contrib_type','is_epf_enabled as status']);

            foreach( $payroll_epf_data as $key=>$single_data){
                    $payroll_epf_data[$key]['employees_assigned'] ='0';
                   $epf_rule =VmtPayrollEpfCalculation::where('id',$single_data['epf_rule'])->first();
                   $epf_contribution_type =VmtPayrollEpfCalculation::where('id',$single_data['epf_contrib_type'])->first();
                    $payroll_epf_data[$key]['epf_rule']=!empty( $epf_rule)? $epf_rule->epf_rule:'';
                    $payroll_epf_data[$key]['epf_contrib_type']=!empty($epf_contribution_type)?$epf_contribution_type->epf_contribution_type:'';
            }
            return response()->json([
                "status" => "success",
                "message" => "data fetch successfully",
                "data" =>$payroll_epf_data,
            ]);

        }
            catch(\Exception $e){

                return $response=([
                    "status" => "failure",
                    "message" => "error while fetch data",
                    "data" => $e->getmessage(),
                ]);
            }
    }
    public function getNonPfEmployeesDetails(){
        try{

            $payroll_epf_data =User::leftjoin('vmt_employee_statutory_details','vmt_employee_statutory_details.id','=','users.id')
                                     ->leftjoin('vmt_employee_details','vmt_employee_details.userid','=','users.id')
                                     ->leftjoin('vmt_employee_office_details','vmt_employee_office_details.user_id','=','users.id')
                                     ->leftjoin('vmt_client_master','vmt_client_master.id','=','users.client_id')
                                     ->where('active','<>',"-1")
                                     ->where('is_ssa',"0")
                                     ->whereNull('epf_number')
                                     ->get(['users.name','vmt_employee_office_details.designation','vmt_employee_office_details.department_id','vmt_employee_office_details.work_location','vmt_client_master.client_fullname']);

            foreach ($payroll_epf_data as $key => $single_data) {

                $department_name=Department::where('id', $single_data['department_id'])->first();
                $payroll_epf_data[$key]['department_name'] = !empty($department_name) ? $department_name->name: null;
            }

            return response()->json([
                "status" => "success",
                "message" => "data fetch successfully",
                "data" =>$payroll_epf_data,
            ]);

        }
            catch(\Exception $e){

                return $response=([
                    "status" => "failure",
                    "message" => "error while fetch data",
                    "data" => $e->getmessage(),
                ]);
            }
    }
    public function saveOrUpdatePayrollEpfDetails( $record_id,$client_id,$epf_number, $epf_deduction_cycle, $is_epf_policy_default, $epf_rule, $epf_contrib_type, $pro_rated_lop_status, $can_consider_salcomp_pf, $employer_contrib_in_ctc,
                                      $employer_edli_contri_in_ctc,$admin_charges_in_ctc,$override_pf_contrib_rate,$is_epf_enabled)
    {
        $validator = Validator::make(
            $data = [
                'client_id' => $client_id,
                'record_id' => $client_id,
                'epf_number' => $epf_number,
                'epf_deduction_cycle' => $epf_deduction_cycle,
                'is_epf_policy_default' => $is_epf_policy_default,
                'epf_rule' =>$epf_rule,
                'epf_contrib_type' =>$epf_contrib_type,
                'pro_rated_lop_status' => $pro_rated_lop_status,
                'can_consider_salcomp_pf' => $can_consider_salcomp_pf,
                'employer_contrib_in_ctc' => $employer_contrib_in_ctc,
                'employer_edli_contri_in_ctc' => $employer_edli_contri_in_ctc,
                'admin_charges_in_ctc' => $admin_charges_in_ctc,
                'override_pf_contrib_rate' => $override_pf_contrib_rate,
                'is_epf_enabled' => $is_epf_enabled,
            ],
            $rules = [
                'record_id' => 'nullable',
                'client_id' => 'required',
                'epf_number' => 'required',
                'epf_deduction_cycle' => 'required',
                'is_epf_policy_default' => 'required',
                'epf_rule' => 'required',
                'epf_contrib_type' => 'required',
                'pro_rated_lop_status' => 'required',
                'can_consider_salcomp_pf' => 'required',
                'employer_contrib_in_ctc' => 'required',
                'employer_edli_contri_in_ctc' => 'required',
                'admin_charges_in_ctc' => 'required',
                'override_pf_contrib_rate' => 'required',
                'is_epf_enabled' => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'numeric' => 'Field <b>:attribute</b> is invalid',
            ]

        );

        if($validator->fails()){
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try{
            $save_payroll_epf_data = VmtPayrollEpf::where('id',$record_id);

          if( $save_payroll_epf_data->exists()){

            $save_payroll_epf_data = $save_payroll_epf_data->first();
            $message="epf data updated successfully";

          }else{

            $save_payroll_epf_data = new VmtPayrollEpf;
            $message="epf data saved successfully";
          }

            $save_payroll_epf_data->client_id =$client_id;
            $save_payroll_epf_data->epf_number = $epf_number;
            $save_payroll_epf_data->epf_deduction_cycle =$epf_deduction_cycle ;
            $save_payroll_epf_data->is_epf_policy_default =$is_epf_policy_default ;
            $save_payroll_epf_data->epf_rule =$epf_rule ;
            $save_payroll_epf_data->epf_contrib_type = $epf_contrib_type;
            $save_payroll_epf_data->pro_rated_lop_status =$pro_rated_lop_status ;
            $save_payroll_epf_data->can_consider_salcomp_pf = $can_consider_salcomp_pf;
            $save_payroll_epf_data->employer_contrib_in_ctc =$employer_contrib_in_ctc ;
            $save_payroll_epf_data->employer_edli_contri_in_ctc =$employer_edli_contri_in_ctc ;
            $save_payroll_epf_data->admin_charges_in_ctc =$admin_charges_in_ctc ;
            $save_payroll_epf_data->override_pf_contrib_rate =$override_pf_contrib_rate ;
            $save_payroll_epf_data->is_epf_enabled = $is_epf_enabled;
            $save_payroll_epf_data->save();

            return $response=([
                "status" => "success",
                "message" => $message,
                "data" => '',
            ]);

         }catch(\Exception $e){
            return response()->json([
                "status" => "failure",
                "message" => "Unable to create epf employee ",
                "data" => $e->getmessage(),
            ]);
        }
    }

    public function deleteEpfEmployee($epf_id){

        //Validate
        $validator = Validator::make(
         $data = [
             'epf_id' => $epf_id,
         ],
         $rules = [
             'epf_id' => 'required|numeric',
         ],
         $messages = [
             'required' => 'Field :attribute is missing',
             'numeric' => 'Field <b>:attribute</b> is invalid',
         ]

     );

     if($validator->fails()){
         return response()->json([
             'status' => 'failure',
             'message' => $validator->errors()->all()
         ]);
     }

     try{
           $delete_payroll_epf_data =VmtPayrollEpf::where('id',$epf_id)->first();
           if(!empty($delete_payroll_epf_data)){
             $delete_payroll_epf_data->delete();

             return response()->json([
                 "status" => "success",
                 "message" => "Epf employees deleted successfully",
             ]);

           }else{

             return response()->json([
                 "status" => "failure",
                 "message" => "No record found",
             ]);
           }

     }
     catch(\Exception $e){

         return response()->json([
             "status" => "failure",
             "message" => "Unable to delete Epf employee",
             "data" => $e->getmessage(),
         ]);

     }
    }

    public function getPayrollEsiDetails(){
        try{

               $payroll_esi_data =VmtPayrollEsi::get(['esi_number','state','location','esi_deduction_cycle as deduction_cycle','status']);

               foreach( $payroll_esi_data as $key=>$single_data){

                $payroll_esi_data[$key]['employees_assigned'] ='0';

               }
                return response()->json([
                    "status" => "success",
                    "message" => "data fetch successfully",
                    "data" =>$payroll_esi_data,
                ]);

     }catch(\Exception $e){

            return $response=([
                "status" => "failure",
                "message" => "error while fetch data",
                "data" => $e->getmessage(),
            ]);
        }
}
    public function saveOrUpdatePayrollEsiDetails( $record_id,$client_id, $esi_number,$esi_deduction_cycle,$state,$location,$employer_contribution_in_ctc)
    {
        $validator = Validator::make(
            $data = [
                'client_id' => $client_id,
                'record_id' => $record_id,
                'esi_number' => $esi_number,
                'esi_deduction_cycle' => $esi_deduction_cycle,
                'state' => $state,
                'location' =>$location,
                'employer_contribution_in_ctc' => $employer_contribution_in_ctc,

            ],
            $rules = [
                'client_id' => 'required',
                'record_id' => 'nullable',
                'esi_number' => 'required',
                'esi_deduction_cycle' => 'required',
                'state' => 'required',
                'location' => 'required',
                'employer_contribution_in_ctc' => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'numeric' => 'Field <b>:attribute</b> is invalid',
            ]

        );

        if($validator->fails()){
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try{

            $save_payroll_esi_data = VmtPayrollEsi::where('id',$record_id);

            if( $save_payroll_esi_data->exists()){

            $save_payroll_esi_data = $save_payroll_esi_data->first() ;
            $message="esi data updated successfully";

            }else{

            $save_payroll_esi_data = new VmtPayrollEsi;
            $message="esi data saved successfully";
            }
            $save_payroll_esi_data = new VmtPayrollEsi;
            $save_payroll_esi_data->client_id = $client_id;
            $save_payroll_esi_data->esi_number = $esi_number;
            $save_payroll_esi_data->esi_deduction_cycle =$esi_deduction_cycle ;
            $save_payroll_esi_data->state =$state ;
            $save_payroll_esi_data->location =$location ;
            $save_payroll_esi_data->employer_contribution_in_ctc = $employer_contribution_in_ctc;
            $save_payroll_esi_data->save();

            return response()->json([
                "status" => "success",
                "message" => $message,
                "data" =>$save_payroll_esi_data,
            ]);

        }catch(\Exception $e){
            return response()->json([
                "status" => "failure",
                "message" => "Unable to create esi employee ",
                "data" => $e->getmessage(),
            ]);
        }
    }

    public function deleteEsiEmployee($esi_id){

           //Validate
           $validator = Validator::make(
            $data = [
                'esi_id' => $esi_id,
            ],
            $rules = [
                'esi_id' => 'required|numeric',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'numeric' => 'Field <b>:attribute</b> is invalid',
            ]

        );

        if($validator->fails()){
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try{
              $delete_payroll_epf_data =VmtPayrollEsi::where('id',$esi_id)->first();
              if(!empty($delete_payroll_epf_data)){
                $delete_payroll_epf_data->delete();

                return response()->json([
                    "status" => "success",
                    "message" => "Esi employee deleted successfully",
                ]);

              }else{

                return response()->json([
                    "status" => "failure",
                    "message" => "No record found",
                ]);
              }

        }
        catch(\Exception $e){

            return response()->json([
                "status" => "failure",
                "message" => "Unable to delete Esi employee",
                "data" => $e->getmessage(),
            ]);

        }

    }

    public function fetchProfessionalTaxSettings(){
        try{
            $Pf_setings_data =VmtProfessionalTaxSettings::all();

            $response =([
                'status' =>"success",
                'message'=>"data fetch successfully",
                'data'=> $Pf_setings_data
            ]);

            return $response ;

        }catch(\Exception $e){

           return $response =([
                'status' =>"failure",
                'message'=>"error while fetching data successfully",
                'data'=> $Pf_setings_data
            ]);

        }
    }
    public function saveUpdateProfessionalTaxSettings($client_id,$record_id,$pt_number,$state,$location,$deduction_cycle)
    {
        $validator = Validator::make(
            $data = [
                'client_id' => $client_id,
                'record_id' => $record_id,
                'pt_number' => $pt_number,
                'state' => $state,
                'location' => $location,
                'deduction_cycle' =>$deduction_cycle,
            ],
            $rules = [
                'record_id' => 'nullable',
                'pt_number' => 'required',
                'state' => 'required',
                'location' => 'required',
                'deduction_cycle' => 'required',

            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'numeric' => 'Field <b>:attribute</b> is invalid',
            ]
        );

        if($validator->fails()){
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try{
            $update_pt_settings =VmtProfessionalTaxSettings::where('id',$record_id)->where('client_id',$client_id );

        if($update_pt_settings->exists()){
           $update_pt_settings =$update_pt_settings->first();
           $message ="professional tax settings saved successfully";

        }else{
            $update_pt_settings =new VmtProfessionalTaxSettings;
            $message="professional tax settings updated successfully";
        }

            $update_pt_settings->client_id = $client_id;
            $update_pt_settings->pt_number = $pt_number;
            $update_pt_settings->state = $state;
            $update_pt_settings->location =$location ;
            $update_pt_settings->deduction_cycle = $deduction_cycle;
            $update_pt_settings->save();

            return $response=([
                "status" => "success",
                "message" => $message,
                "data" =>$update_pt_settings,
            ]);



         }catch(\Exception $e){
            return response()->json([
                "status" => "failure",
                "message" => "error while updating professional tax settings",
                "data" => $e->getmessage(),
            ]);
        }
    }
    public function fetchlwfSettingsDetails(){
        try{
            $lwf_setings_data =VmtLabourWelfareFundSettings::all();

            $response =([
                'status' =>"success",
                'message'=>"data fetch successfully",
                'data'=>$lwf_setings_data
            ]);

            return $response ;

        }catch(\Exception $e){

           return $response =([
                'status' =>"failure",
                'message'=>"error while fetching data successfully",
                'data'=>$e->getmessage()."  Line ".$e->getline(),
            ]);

        }
    }

    public function saveUpdatelwfSettings($client_id,$record_id,$state,$employees_contrib,$employer_contrib,$location,$lwf_number,$district,$deduction_cycle,$status)
    {
        $validator = Validator::make(
            $data = [
                'record_id' => $record_id,
                'client_id' => $client_id,
                'state' => $state,
                'employees_contrib' => $employees_contrib,
                'employer_contrib' => $employer_contrib,
                'deduction_cycle' =>$deduction_cycle,
                'status' => $status,
                'location' => $location,
                'lwf_number' => $lwf_number,
                'district' => $district,
            ],
            $rules = [
                'record_id' => 'nullable',
                'client_id' => 'required',
                'state' => 'required',
                'employees_contrib' => 'required',
                'employer_contrib' => 'required',
                'deduction_cycle' => 'required',
                'location' => 'required',
                'status' => 'required',
                'district' => 'required',
                'lwf_number' => 'nullable',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'numeric' => 'Field <b>:attribute</b> is invalid',
            ]
        );

        if($validator->fails()){
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try{

            $update_lwf_settings =VmtLabourWelfareFundSettings::where('id',$record_id)->where('client_id',$client_id );

            if($update_lwf_settings->exists()){

                $update_lwf_settings =$update_lwf_settings->first();
                $message = "LWF settings updated successfully";

            }else{

                $update_lwf_settings =new VmtLabourWelfareFundSettings;
                $message = "LWF settings saved successfully";
            }
            $update_lwf_settings->client_id = $client_id;
            $update_lwf_settings->employees_contribution = $employees_contrib;
            $update_lwf_settings->state = $state;
            $update_lwf_settings->location = $location;
            $update_lwf_settings->lwf_number = $lwf_number;
            $update_lwf_settings->district = $district;
            $update_lwf_settings->employers_contribution =$employer_contrib ;
            $update_lwf_settings->deduction_cycle = $deduction_cycle;
            $update_lwf_settings->status =$status ;
            $update_lwf_settings->save();


            return $response=([
                "status" => "success",
                "message" => $message,
                "data" => "",
            ]);

            }catch(\Exception $e){
            return response()->json([
                "status" => "failure",
                "message" => "error while update LWF settings",
                "data" => $e->getmessage(),
            ]);
        }
    }

    public function fetchPayRollComponents(){
        try{
            $paygroup_components =VmtPayrollComponents::get();
            unset($paygroup_components[0]);
            unset($paygroup_components[1]);
            unset($paygroup_components[2]);

           $comp_response=array();
           $res_data=array();
            foreach($paygroup_components as $key=>$single_comp_data){
                 $comp_type =   VmtPayrollCompTypes::where('id',$single_comp_data['comp_type_id'])->first();
                 $comp_catogery =   VmtPayrollCompCategory::where('id',$single_comp_data['category_id'])->first();

                $comp_response['id']= $single_comp_data['id'];
                $comp_response['comp_name']= $single_comp_data['comp_name'];
                $comp_response['calculation_desc']= $single_comp_data['calculation_desc'];
                $comp_response['enabled_status']= $single_comp_data['enabled_status'];
                $comp_response['is_part_of_epf']= $single_comp_data['is_part_of_epf'];
                $comp_response['category_id']= $single_comp_data['category_id'];
                $comp_response['category_name']= !empty($comp_catogery) ?  $comp_catogery->name: null;
                $comp_response['is_part_of_esi']= $single_comp_data['is_part_of_esi'];
                $comp_response['comp_type']= !empty($comp_type) ?  $comp_type->name: null;
                $comp_response['sequence']=$single_comp_data['comp_order'];
                $comp_response['reimburst_max_limit']=$single_comp_data['reimburst_max_limit'];
                $comp_response['after_gross']=$single_comp_data['is_deduc_impacton_gross'];
                array_push($res_data,$comp_response);
            }

          // return $res_data;
                $response =([
                    'status' =>"success",
                    'message'=>"data fetch successfully",
                    'data'=>$res_data
                ]);

           return $response ;

        }catch(\Exception $e){

           return $response =([
                'status' =>"failure",
                'message'=>"error while fetching data successfully",
                'data'=>$e->getmessage()."  Line ".$e->getline(),
            ]);

        }
    }
    public function CreatePayRollComponents(
        $comp_name,
        $comp_type_id,
        $category_id,
        $comp_nature_id,
        $calculation_method_id,
        $calculation_desc,
        $is_part_of_epf,
        $is_part_of_esi,
        $is_part_of_empsal_structure,
        $is_taxable,
        $calculate_on_prorate_basis,
        $can_show_inpayslip,
        $enabled_status){

           //Validate
           $validator = Validator::make(
            $data = [
                'comp_name' => $comp_name,
                'comp_type_id' => $comp_type_id,
                'comp_nature_id' => $comp_nature_id,
                'calculation_method_id' => $calculation_method_id,
                'calculation_desc' =>$calculation_desc,
                'is_part_of_epf' => $is_part_of_epf,
                'is_part_of_esi' => $is_part_of_esi,
                'category_id' => $category_id,
                'is_part_of_empsal_structure' => $is_part_of_empsal_structure,
                'is_taxable' => $is_taxable,
                'calculate_on_prorate_basis' => $calculate_on_prorate_basis,
                'can_show_inpayslip' => $can_show_inpayslip,
                'enabled_status' => $enabled_status
            ],
            $rules = [
                'comp_name' => 'required',
                'comp_type_id' => 'required|numeric',
                'comp_nature_id' => 'required|numeric',
                'calculation_method_id' => 'required',
                'calculation_desc' => 'nullable',
                'is_part_of_epf' => 'required|numeric',
                'is_part_of_esi' => 'required|numeric',
                'category_id' => 'required',
                'is_part_of_empsal_structure' => 'required|numeric',
                'is_taxable' => 'required|numeric',
                'calculate_on_prorate_basis' => 'required|numeric',
                'can_show_inpayslip' => 'required|numeric',
                'enabled_status' => 'required|numeric',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'numeric' => 'Field <b>:attribute</b> is invalid',
            ]

        );

        if($validator->fails()){
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try{
              $paygroup_components =VmtPayrollComponents::where('comp_name',$comp_name)->where('comp_type_id',$comp_type_id)->first();
                     if(!empty($paygroup_components)){
                    //     return response()->json([
                    //         "status" => "Failure",
                    //         "message" => "Component is already created",
                    //     ]);
                    $save_paygroup_comp= $paygroup_components ;
              }else{
                $save_paygroup_comp =new VmtPayrollComponents;
              }

              $save_paygroup_comp->comp_name = $comp_name;
              $save_paygroup_comp->comp_type_id =$comp_type_id ;
              $save_paygroup_comp->category_id =$category_id;
              $save_paygroup_comp->comp_nature_id =$comp_nature_id;
              $save_paygroup_comp->calculation_method_id =$calculation_method_id;
            //   if($calculation_type == '1'){
            //     $save_paygroup_comp->flat_amount =$amount;
            //   }else if($calculation_type == '2'){
            //     $save_paygroup_comp->percentage =$percentage;
            //   }
              $save_paygroup_comp->calculation_desc=$calculation_desc;
              $save_paygroup_comp->is_part_of_epf=$is_part_of_epf ;
              $save_paygroup_comp->is_part_of_esi =$is_part_of_esi ;
              $save_paygroup_comp->is_part_of_empsal_structure =$is_part_of_empsal_structure ;
              $save_paygroup_comp->is_taxable =$is_taxable ;
              $save_paygroup_comp->calculate_on_prorate_basis =$calculate_on_prorate_basis ;
              $save_paygroup_comp->can_show_inpayslip =$can_show_inpayslip ;
              $save_paygroup_comp->enabled_status =$enabled_status;
              $save_paygroup_comp->save();
            $response=([
                    "status" => "success",
                    "message" => "Component added successfully",
                ]);
                  return $response;
            }
           catch(\Exception $e){
                    return response()->json([
                        "status" => "failure",
                        "message" => "Unable to add new component",
                        "data" => $e->getmessage(),
                    ]);

        }
    }

    public function UpdatePayRollEarningsComponents( $record_id, $comp_name,
    $comp_type_id,
    $category_id,
    $comp_nature_id,
    $calculation_method_id,
    $calculation_desc,
    $is_part_of_epf,
    $is_part_of_esi,
    $is_part_of_empsal_structure,
    $is_taxable,
    $calculate_on_prorate_basis,
    $can_show_inpayslip,
    $enabled_status){

           //Validate
           $validator = Validator::make(
            $data = [
                'record_id'=>$record_id,
                'comp_name' => $comp_name,
                'comp_type_id' => $comp_type_id,
                'comp_nature_id' => $comp_nature_id,
                'calculation_method_id' => $calculation_method_id,
                'calculation_desc' =>$calculation_desc,
                'is_part_of_epf' => $is_part_of_epf,
                'is_part_of_esi' => $is_part_of_esi,
                'category_id' => $category_id,
                'is_part_of_empsal_structure' => $is_part_of_empsal_structure,
                'is_taxable' => $is_taxable,
                'calculate_on_prorate_basis' => $calculate_on_prorate_basis,
                'can_show_inpayslip' => $can_show_inpayslip,
                'enabled_status' => $enabled_status
            ],
            $rules = [
                'record_id' => 'required|numeric',
                'comp_name' => 'required',
                'comp_type_id' => 'required|numeric',
                'comp_nature_id' => 'required|numeric',
                'calculation_method_id' => 'required',
                'calculation_desc' => 'nullable',
                'is_part_of_epf' => 'required|numeric',
                'is_part_of_esi' => 'required|numeric',
                'category_id' => 'required',
                'is_part_of_empsal_structure' => 'required|numeric',
                'is_taxable' => 'required|numeric',
                'calculate_on_prorate_basis' => 'required|numeric',
                'can_show_inpayslip' => 'required|numeric',
                'enabled_status' => 'required|numeric',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'numeric' => 'Field <b>:attribute</b> is invalid',
            ]

        );

        if($validator->fails()){
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try{
              $paygroup_components =VmtPayrollComponents::where('id',$record_id)->first();
              if(!empty($paygroup_components)){
                $save_paygroup_comp =$paygroup_components;
                $save_paygroup_comp->comp_name = $comp_name;
                $save_paygroup_comp->comp_type_id =$comp_type_id ;
                $save_paygroup_comp->category_id =$category_id;
                $save_paygroup_comp->comp_nature_id =$comp_nature_id;
                $save_paygroup_comp->calculation_method_id =$calculation_method_id;
              //   if($calculation_type == '1'){
              //     $save_paygroup_comp->flat_amount =$amount;
              //   }else if($calculation_type == '2'){
              //     $save_paygroup_comp->percentage =$percentage;
              //   }
                $save_paygroup_comp->calculation_desc=$calculation_desc;
                $save_paygroup_comp->is_part_of_epf=$is_part_of_epf ;
                $save_paygroup_comp->is_part_of_esi =$is_part_of_esi ;
                $save_paygroup_comp->is_part_of_empsal_structure =$is_part_of_empsal_structure ;
                $save_paygroup_comp->is_taxable =$is_taxable ;
                $save_paygroup_comp->calculate_on_prorate_basis =$calculate_on_prorate_basis ;
                $save_paygroup_comp->can_show_inpayslip =$can_show_inpayslip ;
                $save_paygroup_comp->enabled_status =$enabled_status;
                $save_paygroup_comp->save();

                $response=([
                    "status" => "success",
                    "message" => "Component updated successfully",
                ]);

              }else{
                $response=([
                    "status" => "failure",
                    "message" => "No component is present for given id",
                ]);
              }
              return $response;

        }
        catch(\Exception $e){
            return response()->json([
                "status" => "failure",
                "message" => "Unable to update component",
                "data" => $e->getmessage(),
            ]);

        }

    }

    public function DeletePayRollComponents($record_id){

           //Validate
           $validator = Validator::make(
            $data = [
                'comp_id' => $record_id,
            ],
            $rules = [
                'comp_id' => 'required|numeric',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'numeric' => 'Field <b>:attribute</b> is invalid',
            ]

        );

        if($validator->fails()){
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try{
              $paygroup_components =VmtPayrollComponents::where('id',$record_id)->first();
              if(!empty($paygroup_components)){
                $paygroup_components->delete();

                return response()->json([
                    "status" => "success",
                    "message" => "Component deleted successfully",
                ]);

              }else{

                return response()->json([
                    "status" => "failure",
                    "message" => "No component is present for given id",
                ]);
              }

        }
        catch(\Exception $e){

            return response()->json([
                "status" => "failure",
                "message" => "Unable to delete component",
                "data" => $e->getmessage(),
            ]);

        }

    }
    public function EnableDisableComponents($record_id,$status){

           //Validate
           $validator = Validator::make(
            $data = [
                'record_id' => $record_id,
                'status' => $status,
            ],
            $rules = [
                'record_id' => 'required',
                'status' => 'required|numeric',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'numeric' => 'Field <b>:attribute</b> is invalid',
            ]

        );

        if($validator->fails()){
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try{
              $paygroup_components =VmtPayrollComponents::where('id',$record_id)->first();
              if(!empty($paygroup_components)){
                $save_paygroup_comp =$paygroup_components;
                $save_paygroup_comp->status =$status;
                $save_paygroup_comp->save();

                if($paygroup_components->status== '0'){
                    $message ="Component disable successfully";
                }else{
                    $message ="Component enable successfully";
                }
                return response()->json([
                    "status" => "success",
                    "message" => $message,
                ]);

              }else{

                return response()->json([
                    "status" => "failure",
                    "message" => "No component is present for given id",
                ]);
              }

        }
        catch(\Exception $e){
            if($paygroup_components->status== '0'){
                $message ="Unable to disable component";
            }else{
                $message = "Unable to enable component";
            }
            return response()->json([
                "status" => "failure",
                "message" => $message,
                "data" => $e->getmessage(),
            ]);

        }

    }
    public function AddAdhocAllowanceDetectionComp($comp_name,$category_type,$is_taxable,$is_tptax_deduc_samemonth,$is_separate_payment_allowed,$is_deduc_impacton_gross){
            //Validate
            $validator = Validator::make(
            $data = [
                'comp_name' => $comp_name,
                'category_type' => $category_type,
                'is_taxable' => $is_taxable,
                'is_tptax_deduc_samemonth' => $is_tptax_deduc_samemonth,
                'is_separate_payment_allowed' => $is_separate_payment_allowed,
                'is_deduc_impacton_gross' => $is_deduc_impacton_gross,
            ],
            $rules = [
                'comp_name' => 'required',
                'category_type' => 'required',
                'is_taxable' => 'nullable',
                'is_tptax_deduc_samemonth' =>'required' ,
                'is_separate_payment_allowed' =>'required' ,
                'is_deduc_impacton_gross' => 'nullable',

            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'numeric' => 'Field <b>:attribute</b> is invalid',
            ]

        );

        if($validator->fails()){
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try{
            $paygroup_components =VmtPayrollComponents::where('comp_name',$comp_name)->first();
                        if(!empty($paygroup_components)){
                            return response()->json([
                                "status" => "Failure",
                                "message" => "Component is already Added",
                            ]);
                }else{
                    $save_paygroup_comp =new VmtPayrollComponents;
                }
                $category_id =VmtPayrollCompCategory::where('name',$category_type)->first()->id ;
                $save_paygroup_comp->comp_name = $comp_name;
                $save_paygroup_comp->category_id =$category_id;
                if($category_type =='adhoc'){
                    $save_paygroup_comp->is_taxable =$is_taxable;
                    $save_paygroup_comp->is_tptax_deduc_samemonth =$is_tptax_deduc_samemonth;
                    $save_paygroup_comp->is_separate_payment_allowed =$is_separate_payment_allowed;
                }else if($category_type =='deduction'){
                    $save_paygroup_comp->is_deduc_impacton_gross =$is_deduc_impacton_gross;
                }
                $save_paygroup_comp->save();


                $response=([
                    "status" => "success",
                    "message" => "Component added successfully",
                ]);

                return $response;
                }
            catch(\Exception $e){
                        return response()->json([
                            "status" => "failure",
                            "message" => "Unable to add new component",
                            "data" => $e->getmessage(),
                        ]);
                    }

    }

    public function UpdateAdhocAllowanceDetectionComp($record_id,$comp_name,$category_type,$is_taxable,$is_tptax_deduc_samemonth,$is_separate_payment_allowed,$is_deduc_impacton_gross){
            //Validate
            $validator = Validator::make(
            $data = [
                'record_id'=>$record_id,
                'comp_name' => $comp_name,
                'category_type' => $category_type,
                'is_taxable' => $is_taxable,
                'is_tptax_deduc_samemonth' => $is_tptax_deduc_samemonth,
                'is_separate_payment_allowed' => $is_separate_payment_allowed,
                'is_deduc_impacton_gross' => $is_deduc_impacton_gross,
            ],
            $rules = [
                'record_id' => 'required|numeric',
                'comp_name' => 'required',
                'category_type' => 'required',
                'is_taxable' => 'nullable',
                'is_tptax_deduc_samemonth' =>'required' ,
                'is_separate_payment_allowed' =>'required' ,
                'is_deduc_impacton_gross' => 'nullable',

            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'numeric' => 'Field <b>:attribute</b> is invalid',
            ]

        );

        if($validator->fails()){
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try{

            $paygroup_components =VmtPayrollComponents::where('id',$record_id)->first();
            $category_id =VmtPayrollCompCategory::where('name',$category_type)->first()->id ;
            if(!empty($paygroup_components)){
                $save_paygroup_comp =$paygroup_components;
                $save_paygroup_comp->comp_name = $comp_name;
                $save_paygroup_comp->category_id =$category_id ;
                if($category_type =='adhoc'){
                    $save_paygroup_comp->is_taxable =$is_taxable;
                    $save_paygroup_comp->is_tptax_deduc_samemonth =$is_tptax_deduc_samemonth;
                    $save_paygroup_comp->is_separate_payment_allowed =$is_separate_payment_allowed;
                }else if($category_type =='deduction'){
                    $save_paygroup_comp->is_deduc_impacton_gross =$is_deduc_impacton_gross;
                }
                $save_paygroup_comp->save();

                $response=([
                    "status" => "success",
                    "message" => "Component updated successfully",
                ]);

            }else{
                $response=([
                    "status" => "failure",
                    "message" => "No component is present for given id",
                ]);
            }
            return $response;

        }
        catch(\Exception $e){
            return response()->json([
                "status" => "failure",
                "message" => "Unable to update component",
                "data" => $e->getmessage(),
            ]);

        }

    }

    public function AddReimbursementComponents($comp_name,$category_id,$reimburst_max_limit,$reimburst_status){
        //Validate
        $validator = Validator::make(
        $data = [
            'comp_name' => $comp_name,
            'category_id' => $category_id,
            'reimburst_max_limit' => $reimburst_max_limit,
            'reimburst_status' => $reimburst_status,

        ],
        $rules = [
            'comp_name' => 'required',
            'category_id' => 'required',
            'reimburst_max_limit' => 'required|numeric',
            'reimburst_status' => 'required|numeric',

        ],
        $messages = [
            'required' => 'Field :attribute is missing',
            'numeric' => 'Field <b>:attribute</b> is invalid',
        ]

    );

    if($validator->fails()){
        return response()->json([
            'status' => 'failure',
            'message' => $validator->errors()->all()
        ]);
    }

    try{
        $paygroup_components =VmtPayrollComponents::where('comp_name',$comp_name)->first();
                    if(!empty($paygroup_components)){
                        return response()->json([
                            "status" => "Failure",
                            "message" => "Component is already Added",
                        ]);
            }else{
                $save_paygroup_comp =new VmtPayrollComponents;
            }

            $save_paygroup_comp =$save_paygroup_comp;
            $save_paygroup_comp->comp_name = $comp_name;
            $save_paygroup_comp->category_id =$category_id ;
            $save_paygroup_comp->reimburst_max_limit =$reimburst_max_limit ;
            $save_paygroup_comp->enabled_status =$reimburst_status ;
            $save_paygroup_comp->save();


            $response=([
                "status" => "success",
                "message" => "Component added successfully",
            ]);

            return $response;
            }
        catch(\Exception $e){
                    return response()->json([
                        "status" => "failure",
                        "message" => "Unable to add new component",
                        "data" => $e->getmessage(),
                    ]);
                }

    }
    public function UpdateReimbursementComponents($record_id,$comp_name,$category_id,$reimburst_max_limit,$reimburst_status){
                //Validate
                $validator = Validator::make(
                $data = [
                    'record_id' => $record_id,
                    'comp_name' => $comp_name,
                    'category_id' => $category_id,
                    'reimburst_max_limit' => $reimburst_max_limit,
                    'reimburst_status' => $reimburst_status,

                ],
                $rules = [
                    'comp_name' => 'required',
                    'category_id' => 'required',
                    'reimburst_max_limit' => 'required|numeric',
                    'reimburst_status' => 'required|numeric',

                ],
                $messages = [
                    'required' => 'Field :attribute is missing',
                    'numeric' => 'Field <b>:attribute</b> is invalid',
                ]

            );

            if($validator->fails()){
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->all()
                ]);
            }

            try{

                $paygroup_components =VmtPayrollComponents::where('id',$record_id)->first();
                if(!empty($paygroup_components)){
                    $save_paygroup_comp =$paygroup_components;
                    $save_paygroup_comp->comp_name = $comp_name;
                    $save_paygroup_comp->category_id =$category_id ;
                    $save_paygroup_comp->reimburst_max_limit =$reimburst_max_limit ;
                    $save_paygroup_comp->enabled_status =$reimburst_status ;
                    $save_paygroup_comp->save();
                $response=([
                    "status" => "success",
                    "message" => "Component updated successfully",
                ]);

                }else{
                $response=([
                    "status" => "failure",
                    "message" => "No component is present ",
                ]);
                }
                return $response;

            }
            catch(\Exception $e){
            return response()->json([
                "status" => "failure",
                "message" => "Unable to update component",
                "data" => $e->getmessage(),
            ]);

            }
    }

    public function fetchPayGroupEmpComponents()
    {
        try{

            $paygroup_structure_comps =VmtPaygroup::get();
                $i=0;
            foreach ($paygroup_structure_comps as $key => $Single_structure) {

            $creator_user_name =User::where('id',$Single_structure->creator_user_id)->first();
            $paygroup_structure_comps[$i]['creator_user_name']=$creator_user_name->name;
            $paygroup_structure_comps[$i]['paygroup_comps'] =$this->fetchPaygroupAssignedComponents($Single_structure->id);
            $paygroup_structure_comps[$i]['paygroup_assign_employees'] =$this->fetchPaygroupAssignedEmployee($Single_structure->id);
            $paygroup_structure_comps[$i]['no_of_employees']=count($paygroup_structure_comps[$i]['paygroup_assign_employees']);

                $i++;

            }

        return $paygroup_structure_comps;



        }catch(\Exception $e){
            return response()->json([
                "status" => "failure",
                "message" => "Unable to get data",
                "data" => $e->getmessage(),

            ]);

        }
    }

    public function fetchPaygroupAssignedEmployee($paygroup_id){
            try{


                $paygroup_assigned_emp_id =VmtEmpPaygroup::where('paygroup_id',$paygroup_id)->pluck('user_id');

                $paygroup_assigned_employees = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                                            ->join('vmt_department', 'vmt_department.id', '=', 'vmt_employee_office_details.department_id')
                                            ->join('vmt_client_master', 'vmt_client_master.id', '=', 'users.client_id')
                                            ->where('process', '<>', 'S2 Admin')
                                            ->whereIn('users.id',$paygroup_assigned_emp_id)
                                            ->select(
                                                'users.name',
                                                'users.user_code',
                                                'vmt_department.name as department_name',
                                                'vmt_employee_office_details.designation',
                                                'vmt_employee_office_details.work_location',
                                                'vmt_client_master.client_name',
                                                )
                                            ->get();

                return  $paygroup_assigned_employees;


            }catch(\Exception $e){
                        return response()->json([
                            "status" => "failure",
                            "message" => "Unable to get data",
                            "data" => $e->getmessage(),
                        ]);
            }

    }
    public function fetchPaygroupAssignedComponents($paygroup_id){

        try{

                $paygroup_assign_comps_id =VmtPaygroupComps::where('paygroup_id',$paygroup_id)->pluck('comp_id');


                $paygroup_assign_comps =VmtPayrollComponents::whereIn('id', $paygroup_assign_comps_id)->get();

                return  $paygroup_assign_comps ;

            }catch(\Exception $e){
                return response()->json([
                    "status" => "failure",
                    "message" => "Unable to get data",
                    "data" => $e->getmessage(),
                ]);
            }

    }

    public function addPayrollAppIntegrations($accounting_soft_name,$accounting_soft_logo,$description,$status){
                //Validate
                $validator = Validator::make(
                $data = [
                    'accounting_soft_name' => $accounting_soft_name,
                    'accounting_soft_logo' => $accounting_soft_logo,
                    'description' => $description,
                    'status' => $status,

                ],
                $rules = [
                    'accounting_soft_name' => 'required',
                    'description' => 'required',
                    'status' => 'nullable|numeric',

                ],
                $messages = [
                    'required' => 'Field :attribute is missing',
                    'numeric' => 'Field <b>:attribute</b> is invalid',
                ]

            );

            if($validator->fails()){
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->all()
                ]);
            }

            try{

                $paygroup_components =VmtAppIntegration::where('accounting_soft_name',$accounting_soft_name)->first();

                if(empty($paygroup_components)){
                    $save_paygroup_comp =new VmtAppIntegration;
                    $save_paygroup_comp->accounting_soft_name = $accounting_soft_name;
                    $save_paygroup_comp->accounting_soft_logo =$accounting_soft_logo ?? null;
                    $save_paygroup_comp->description =$description ;
                    $save_paygroup_comp->status =$status ;
                    $save_paygroup_comp->save();

                $response=([
                    "status" => "success",
                    "message" => "app integration created successfully",
                ]);
                }
                else{
                    $response=([
                        "status" => "success",
                        "message" => "app integration already created successfully",
                    ]);
                    }

                return $response;

            }
            catch(\Exception $e){
            return response()->json([
                "status" => "failure",
                "message" => "Unable to create integration",
                "data" => $e->getmessage(),
            ]);

            }

    }
    public function EnableDisableAppIntegration($app_id,$status){

            //Validate
            $validator = Validator::make(
                $data = [
                    'app_id' => $app_id,
                    'status' => $status,
                ],
                $rules = [
                    'app_id' => 'required',
                    'status' => 'required|numeric',
                ],
                $messages = [
                    'required' => 'Field :attribute is missing',
                    'numeric' => 'Field <b>:attribute</b> is invalid',
                ]

            );

            if($validator->fails()){
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->all()
                ]);
            }

            try{
                $paygroup_components =VmtAppIntegration::where('id',$app_id)->first();
                if(!empty($paygroup_components)){
                    $save_paygroup_comp =$paygroup_components;
                    $save_paygroup_comp->status =$status;
                    $save_paygroup_comp->save();

                    if($paygroup_components->status== '0'){
                        $message ="appintegration disable successfully";
                    }else{
                        $message ="appintegration enable successfully";
                    }
                    return response()->json([
                        "status" => "success",
                        "message" => $message,
                    ]);

                }else{

                    return response()->json([
                        "status" => "failure",
                        "message" => "No appintegration is present ",
                    ]);
                }

            }
            catch(\Exception $e){
                if($paygroup_components->status== '0'){
                    $message ="Unable to disable appintegration";
                }else{
                    $message = "Unable to enable appintegration";
                }
                return response()->json([
                    "status" => "failure",
                    "message" => $message,
                    "data" => $e->getmessage(),
                ]);

            }

    }


//   public function ShowAssignEmployeelist($department_id, $designation, $work_location, $client_name)
//   {

//       try {

//           $select_employee = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
//               ->join('vmt_department', 'vmt_department.id', '=', 'vmt_employee_office_details.department_id')
//               ->join('vmt_client_master', 'vmt_client_master.id', '=', 'users.client_id')
//               ->where('process', '<>', 'S2 Admin')
//               ->select(
//                   'users.name',
//                   'users.user_code',
//                   'vmt_department.name as department_name',
//                   'vmt_employee_office_details.designation',
//                   'vmt_employee_office_details.work_location',
//                   'vmt_client_master.client_name',
//               );

//           if (!empty($department_id)) {
//               $select_employee = $select_employee->where('department_id', $department_id);
//           }
//           if (!empty($designation)) {
//               $select_employee = $select_employee->where('designation', $designation);
//           }
//           if (!empty($work_location)) {
//               $select_employee = $select_employee->where('work_location', $work_location);
//           }
//           if (!empty($client_name)) {
//               $select_employee = $select_employee->where('client_id', $client_name);
//           }

//           return $select_employee->get();
//       } catch (\Exception $e) {
//           return response()->json([
//               "status" => "failure",
//               "message" => "Error fetching the employee",
//               "data" => $e,
//           ]);
//       }
//   }

//   public function getAllDropdownFilterSetting()
//   {

//       $current_client_id = auth()->user()->client_id;


//       try {

//           $queryGetDept = Department::select('id', 'name')->get();

//           $queryGetDesignation = VmtEmployeeOfficeDetails::select('designation')->where('designation', '<>', 'S2 Admin')->distinct()->get();

//           $queryGetLocation = VmtEmployeeOfficeDetails::select('work_location')->distinct()->get();

//           $queryGetstate = State::select('id', 'state_name')->distinct()->get();

//           if ($current_client_id == 1) {

//               $queryGetlegalentity = VmtClientMaster::select('id', 'client_name')->distinct()->get();
//           } elseif ($current_client_id == 0) {

//               $queryGetlegalentity = VmtClientMaster::select('id', 'client_name')->distinct()->get();
//           } elseif ($current_client_id == 2) {

//               $queryGetlegalentity = VmtClientMaster::where('id', $current_client_id)->distinct()->get(['id', 'client_name']);
//           } elseif ($current_client_id == 3) {

//               $queryGetlegalentity = VmtClientMaster::where('id', $current_client_id)->distinct()->get(['id', 'client_name']);
//           } elseif ($current_client_id == 4) {

//               $queryGetlegalentity = VmtClientMaster::where('id', $current_client_id)->distinct()->get(['id', 'client_name']);
//           }


//           $getsalary  = ["department" => $queryGetDept, "designation" => $queryGetDesignation, "location" => $queryGetLocation, "state" => $queryGetstate, "legalEntity" => $queryGetlegalentity];


//           return  response()->json($getsalary);
//       } catch (\Exception $e) {
//           return response()->json([
//               "status" => "failure",
//               "message" => "Error fetching the dropdown value",
//               "data" => $e,
//           ]);
//       }
//   }


    public function addPaygroupCompStructure($user_code,$client_id,$paygroup_name,$description,$pf,$esi,$tds,$fbp,$sal_components,$assigned_employees)
    {
           //Validate
           $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
                'client_id' => $client_id,
                'paygroup_name' => $paygroup_name,
                'description' => $description,
                'pf' => $pf,
                'esi' => $esi,
                'tds' => $tds,
                'fbp' => $fbp,
                'sal_components' =>$sal_components,
                'assigned_employees' => $assigned_employees
            ],
            $rules = [
                'user_code' => 'required',
                'client_id' => 'required',
                'paygroup_name' => 'required',
                'description' => 'required',
                'pf' => 'required|numeric',
                'esi' => 'required|numeric',
                'tds' => 'required|numeric',
                'fbp' => 'required|numeric',
                'sal_components' => 'required',
                'assigned_employees' => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'numeric' => 'Field <b>:attribute</b> is invalid',
            ]
        );

        if($validator->fails()){
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try{


            $emp_data =User::where('user_code',$user_code)->first();

              $paygroup_components =VmtPaygroup::where('paygroup_name',$paygroup_name)->first();

              if(!empty($paygroup_components)) {
                    // return response()->json([
                    //     "status" => "Failure",
                    //     "message" => "Salary Structure is already created",
                    // ]);
                    //dd($paygroup_components);
                    $save_paygroup_comp=$paygroup_components;
               }
               else {
                $save_paygroup_comp =new VmtPaygroup;
               }
              $save_paygroup_comp-> client_id = $client_id;
              $save_paygroup_comp->paygroup_name = $paygroup_name;
              $save_paygroup_comp->description =$description ;
              $save_paygroup_comp->pf =$pf ;
              $save_paygroup_comp->esi =$esi ;
              $save_paygroup_comp->tds =$tds ;
              $save_paygroup_comp->fbp =$fbp ;
              $save_paygroup_comp->creator_user_id = $emp_data->id;
              $save_paygroup_comp->save();

              $assign_comps_to_paygroup="";

            if(empty($paygroup_components)){

                $assign_comps_to_paygroup =$this->assignComponents_to_Paygroup($sal_components,$save_paygroup_comp->id);

            }

              $assign_paygroupcomps_to_emp =$this->assignPaygroupComponents_to_Employee($assigned_employees,$save_paygroup_comp->id);

                if((!empty($assign_comps_to_paygroup)?$assign_comps_to_paygroup['status'] =='success':false||empty($assign_comps_to_paygroup)) && $assign_paygroupcomps_to_emp['status'] =='success' ){
                    $response=([
                        "status" => "success",
                        "message" => "Salary Structure  added successfully",
                    ]);
                }else{
                    $emp_paygroup_components =VmtEmpPaygroup::where('paygroup_id',$save_paygroup_comp->id)->get(['id']);
                    $paygroup_comps =VmtPaygroupComps::where('paygroup_id',$save_paygroup_comp->id)->get(['id']);
                    $paygroup =VmtPaygroup::where('id',$save_paygroup_comp->id)->first();
                    if(!empty($emp_paygroup_components)){
                        $delete_assign_emp_comp_data = VmtEmpPaygroup::destroy($emp_paygroup_components);
                    }
                    if(!empty($paygroup_comps)){
                        $delete_assign_comp_data = VmtPaygroupComps::destroy($paygroup_comps);
                    }
                    if(!empty($paygroup)){
                        $paygroup->delete();
                    }

                    $response=([
                        "status" => "failure",
                        "message" => "Error while add Salary Structure ",
                        "data1" => $assign_comps_to_paygroup['data'],
                        "data2" => $assign_paygroupcomps_to_emp['data'],
                    ]);
                }
                 return response()->json($response);


        }
        catch(\Exception $e){
            return response()->json([
                "status" => "failure",
                "message" => "Unable to add new Salary Structure ",
                "data" => $e->getmessage(),
            ]);
        }

    }
    public function updatePaygroupCompStructure($paygroup_id,$user_code,$client_id,$paygroup_name,$description,$pf,$esi,$tds,$fbp,$sal_components,$assigned_employees)
    {
           //Validate
           $validator = Validator::make(
            $data = [
                'paygroup_id' => $paygroup_id,
                'user_code' => $user_code,
                'client_id' => $client_id,
                'paygroup_name' => $paygroup_name,
                'description' => $description,
                'pf' => $pf,
                'esi' => $esi,
                'tds' => $tds,
                'fbp' => $fbp,
                'sal_components' =>$sal_components,
                'assigned_employees' => $assigned_employees
            ],
            $rules = [
                'paygroup_id' => 'required',
                'user_code' => 'required',
                'client_id' => 'required',
                'paygroup_name' => 'required',
                'description' => 'required',
                'pf' => 'required|numeric',
                'esi' => 'required|numeric',
                'tds' => 'required|numeric',
                'fbp' => 'required|numeric',
                'sal_components' => 'required',
                'assigned_employees' => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'numeric' => 'Field <b>:attribute</b> is invalid',
            ]

        );

        if($validator->fails()){
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try{

            $emp_data =User::where('user_code',$user_code)->first();

              $paygroup_components =VmtPaygroup::where('id',$paygroup_id)->first();

              if(!empty($paygroup_components))
              {
              $update_paygroup_comp = $paygroup_components;
              $update_paygroup_comp-> client_id = $client_id;
              $update_paygroup_comp->paygroup_name = $paygroup_name;
              $update_paygroup_comp->description =$description ;
              $update_paygroup_comp->pf =$pf ;
              $update_paygroup_comp->esi =$esi ;
              $update_paygroup_comp->tds =$tds ;
              $update_paygroup_comp->fbp =$fbp ;
              $update_paygroup_comp->creator_user_id = $emp_data->id;
              $update_paygroup_comp->save();

                $assign_comps_to_paygroup =$this->assignComponents_to_Paygroup($sal_components,$paygroup_id);

                $assign_paygroupcomps_to_emp =$this->assignPaygroupComponents_to_Employee($assigned_employees,$paygroup_id);

                if($assign_comps_to_paygroup['status'] =='success'&&$assign_paygroupcomps_to_emp['status'] =='success' ){

                    $delete_assign_comp_data = VmtPaygroupComps::destroy($assign_comps_to_paygroup['data']);
                    $delete_assign_emp_comp_data = VmtEmpPaygroup::destroy($assign_paygroupcomps_to_emp['data']);
                    $response=([
                        "status" => "success",
                        "message" => "Salary Structure updated successfully",
                    ]);
                }else{
                    //delete currently  saved data in VmtPaygroup while getting error in assign structure to comp and comp to emp

                    $emp_paygroup_components =VmtEmpPaygroup::where('paygroup_id',$update_paygroup_comp->id)->get(['id']);
                    $paygroup_comps =VmtPaygroupComps::where('paygroup_id',$update_paygroup_comp->id)->get(['id']);
                    $paygroup =VmtPaygroup::where('id',$update_paygroup_comp->id)->first();
                    if(!empty($emp_paygroup_components)){
                        $delete_assign_emp_comp_data=VmtEmpPaygroup::destroy($emp_paygroup_components);
                    }
                   if(!empty($paygroup_comps)){
                       $delete_assign_comp_data= VmtPaygroupComps::destroy($paygroup_comps);
                    }
                    if(!empty($paygroup)){
                        $paygroup->delete();
                    }
                    $response=([
                        "status" => "failure",
                        "message" => "Error while add Salary Structure ",

                    ]);
                }
               }else{
                $response=([
                    "status" => "failure",
                    "message" => "No component is present ",
                ]);
               }

            return response()->json($response);
        }
        catch(\Exception $e){

            //dd("Error :: uploadDocument() ".$e);

            return response()->json([
                "status" => "failure",
                "message" => "Unable to add new Salary Structure ",
                "data" => $e->getmessage(),
            ]);

        }

    }

    public function assignComponents_to_Paygroup($sal_components,$paygroup_id){
            try{

                $paygroup_comps =VmtPaygroupComps::where('paygroup_id',$paygroup_id);
                if(!empty($paygroup_comps)){
                    $data =$paygroup_comps->get(['id']);
                }else{

                    $data='null';
                }

                    foreach ($sal_components as $key => $singlecomp) {

                        $assign_comp_paygroup = new VmtPaygroupComps;
                        $assign_comp_paygroup->paygroup_id=$paygroup_id;
                        $assign_comp_paygroup->comp_id=$singlecomp;
                        $assign_comp_paygroup->save();
                    }
                    $response=([
                        "status" => "success",
                        "message" => "",
                        "data"=>$data
                    ]);
                return $response;

            }catch(\Exception $e){

                $response=([
                    "status" => "failure",
                    "message" => "Unable to assign components ",
                    "data" => $e->getmessage(),
                ]);

                return $response;
            }
    }
    public function assignPaygroupComponents_to_Employee($assigned_employees,$paygroup_id){

                try{
                    $emp_paygroup_components =VmtEmpPaygroup::where('paygroup_id',$paygroup_id);

                    if(!empty($emp_paygroup_components)){
                        $data =$emp_paygroup_components->get(['id']);
                    }else{
                        $data='null';
                    }

                    foreach ($assigned_employees as  $key => $single_emp) {

                        $assign_comp_paygroup = new VmtEmpPaygroup;
                        $assign_comp_paygroup->user_id=$single_emp;
                        $assign_comp_paygroup->paygroup_id=$paygroup_id;
                        $assign_comp_paygroup->save();
                    }

                    $response=([
                        "status" => "success",
                        "message" => "",
                        "data"=>$data
                    ]);
                return $response;

            }catch(\Exception $e){

                    return  $response=([
                        "status" => "failure",
                        "message" => "Unable to assign components ",
                        "data" => $e->getmessage(),
                    ]);
                    return  $response;
            }
    }
    public function deletePaygroupComponents($paygroup_id){

            //Validate
            $validator = Validator::make(
                $data = [
                    'paygroup_id' => $paygroup_id,
                ],
                $rules = [
                    'paygroup_id' => 'required|numeric',
                ],
                $messages = [
                    'required' => 'Field :attribute is missing',
                    'numeric' => 'Field <b>:attribute</b> is invalid',
                ]

            );

            if($validator->fails()){
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->all()
                ]);
            }

            try{

                $paygroup_components =VmtPaygroup::where('id',$paygroup_id)->first();

                if(!empty($paygroup_components)){
                    $emp_paygroup_components =VmtEmpPaygroup::where('paygroup_id',$paygroup_components->id)->get(['id']);
                    $paygroup_comps =VmtPaygroupComps::where('paygroup_id',$paygroup_components->id)->get(['id']);
                //delete the assign values
                    $delete_assign_emp_comp_data=  VmtEmpPaygroup::destroy($emp_paygroup_components);
                    $delete_assign_comp_data=VmtPaygroupComps::destroy($paygroup_comps);
                    $paygroup_components->delete();

                    return response()->json([
                        "status" => "success",
                        "message" => "Component deleted successfully",
                    ]);

                }//else{

                //     return response()->json([
                //         "status" => "failure",
                //         "message" => "No component is present for given id",
                //     ]);
                // }

            }
            catch(\Exception $e){

                return $response=([
                    "status" => "failure",
                    "message" => "Unable to delete component",
                    "data" => $e->getmessage(),
                ]);

            }

    }

}
