<?php

namespace App\Services;

use App\Models\Compensatory;
use App\Models\User;

use App\Models\VmtEmployee;
use App\Models\VmtInvestmentForm;
use App\Models\VmtInvEmpFormdata;
use App\Models\VmtInvFEmpAssigned;
use App\Mail\VmtAttendanceMail_Regularization;
use App\Mail\RequestLeaveMail;
use App\Models\VmtInvForm;
use App\Models\VmtInvFormSection;
use App\Models\VmtOrgTimePeriod;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VmtInvSectionImport;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DatePeriod;
use DateInterval;
use \Datetime;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VmtInvestmentsService
{

    /*
        Get the investments form detail template

    */
    public function getInvestmentsFormDetailsTemplate($form_name)
    {
        //Validate
        $validator = Validator::make(
            $data = [
                'form_name' => $form_name
            ],
            $rules = [
                'form_name' => 'required|exists:vmt_inv_form,form_name',
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
            //get the current active form id
            $query_form_details = VmtInvForm::where('form_name', $form_name)->first();
            $user_id = User::where('user_code', auth()->user()->user_code)->first()->id;
            $query_is_sumbitted = VmtInvFEmpAssigned::where('user_id', $user_id)->first();
            $query_doj = VmtEmployee::where('userid', $user_id)->first();
            $org_timeperiod = VmtOrgTimePeriod::where('status','1')->first();
            $start_date = Carbon::parse($org_timeperiod->start_date);
            $doj = Carbon::parse($query_doj->doj);



            //Get the form template
            $query_inv_form_template = VmtInvFormSection::leftjoin('vmt_inv_section', 'vmt_inv_section.id', '=', 'vmt_inv_formsection.section_id')
                ->leftjoin('vmt_inv_section_group', 'vmt_inv_section_group.id', '=', 'vmt_inv_section.sectiongroup_id')
                // ->where('vmt_inv_formsection.form_id', $assigned_form_id)

                ->get(
                    [
                        'vmt_inv_formsection.section_id',
                        'vmt_inv_section.section',
                        'vmt_inv_section.particular',
                        'vmt_inv_section.reference',
                        'vmt_inv_section.max_amount',
                        'vmt_inv_section_group.section_group',
                        'vmt_inv_formsection.id as fs_id',
                        'vmt_inv_section.section_option_1',
                        'vmt_inv_section.section_option_2',
                        'vmt_inv_formsection.form_id',

                    ]
                )->toArray();

                $emp_comp = Compensatory::where('user_id',$user_id)->first();


                if($emp_comp){

                    for($i=0; $i <count($query_inv_form_template); $i++){
                        if($query_inv_form_template[$i]['particular'] == "Communications Allowance ( Telephone)"){
                            if($emp_comp->communication_allowance == "" || (int)$emp_comp->communication_allowance == 0){
                                unset($query_inv_form_template[$i]);
                            }else{
                                $emp_communication =  empty($emp_comp->communication_allowance) ? 0 : $emp_comp->communication_allowance;
                                $yearly_communication = ((int)$emp_communication) * 12;
                                $query_inv_form_template[$i]['max_amount'] = $yearly_communication;

                            }
                        }else
                        if($query_inv_form_template[$i]['particular'] == "Driver Reimbursement"){
                            if($emp_comp->driver_reimbursement == "" || $emp_comp->driver_reimbursement == 0){
                                unset($query_inv_form_template[$i]);
                            }else{

                                $emp_driver_rem =  empty($emp_comp->driver_reimbursement) ? 0 : $emp_comp->driver_reimbursement ;
                                $yearly_driver_rem = ((int)$emp_driver_rem) * 12;
                                $query_inv_form_template[$i]['max_amount'] = $yearly_driver_rem;
                            }
                        }else
                        if($query_inv_form_template[$i]['particular'] == "Vehicle Reimbursement"){
                            if($emp_comp->vehicle_reimbursement == "" || $emp_comp->vehicle_reimbursement == 0){
                                unset($query_inv_form_template[$i]);
                            }else{

                                $emp_vehicle_reim =  empty($emp_comp->vehicle_reimbursement) ? 0 : $emp_comp->vehicle_reimbursement ;
                                $yearly_vehicle_reim = ((int)$emp_vehicle_reim) * 12;
                                $query_inv_form_template[$i]['max_amount'] = $yearly_vehicle_reim;
                            }
                        }else
                        if($query_inv_form_template[$i]['particular'] == "Leave Travel Allowance (LTA)"){
                            if($emp_comp->lta == "" || $emp_comp->lta == 0){
                                unset($query_inv_form_template[$i]);
                            }else{

                                $emp_lta =  empty($emp_comp->lta ) ? 0 : $emp_comp->lta;
                                $yearly_lta = ((int)$emp_lta) * 12;
                                $query_inv_form_template[$i]['max_amount'] = $yearly_lta;
                            }
                        }
                    }
                }


            // employee declaration amount
            $inv_emp_value = VmtInvFEmpAssigned::leftjoin('vmt_inv_emp_formdata', 'vmt_inv_emp_formdata.f_emp_id', '=', 'vmt_inv_f_emp_assigned.id')
                ->where('vmt_inv_f_emp_assigned.user_id', $user_id)->get()->toArray();

            // dd($inv_emp_value);
            // json decode popup value;
            $popdecode = array();
            foreach ($inv_emp_value as $details_tem) {

                $rentalDetail['id'] = $details_tem["id"];
                $rentalDetail['user_id'] = $details_tem["user_id"];
                $rentalDetail['form_id'] = $details_tem["form_id"];
                $rentalDetail['f_emp_id'] = $details_tem["f_emp_id"];
                $rentalDetail['year'] = $details_tem["year"];
                $rentalDetail['fs_id'] = $details_tem["fs_id"];
                $rentalDetail['dec_amount'] = $details_tem["dec_amount"];
                $rentalDetail['is_submit'] = $details_tem["is_sumbit"];
                $rentalDetail['selected_section_options'] = $details_tem["selected_section_options"];
                $rentalDetail['json_popups_value'] = (json_decode($details_tem["json_popups_value"], true));
                array_push($popdecode, $rentalDetail);

            };

            $arr = array();
            foreach ($query_inv_form_template as $single_template) {
                foreach ($popdecode as $single_emp_env_value) {
                    if ($single_template['fs_id'] == $single_emp_env_value['fs_id']) {
                        $single_template['id'] = $single_emp_env_value['id'];
                        $single_template['user_id'] = $single_emp_env_value['user_id'];
                        $single_template['form_id'] = $single_emp_env_value['form_id'];
                        $single_template['year'] = $single_emp_env_value['year'];
                        $single_template['f_emp_id'] = $single_emp_env_value['f_emp_id'];
                        $single_template['dec_amount'] = $single_emp_env_value['dec_amount'];
                        $single_template['json_popups_value'] = $single_emp_env_value['json_popups_value'];
                        $single_template['is_submit'] = $single_emp_env_value['is_submit'];
                        $single_template['selected_section_options'] = $single_emp_env_value['selected_section_options'];
                    }
                }
                array_push($arr, $single_template);
            }
            //dd($arr);

            $query_inv_form_template = $arr;


            $count = 0;
            foreach ($query_inv_form_template as $single_inv_form_template) {

                if (!array_key_exists($single_inv_form_template["section_group"], $query_inv_form_template)) {
                    $query_inv_form_template[$single_inv_form_template["section_group"]] = array();
                    array_push($query_inv_form_template[$single_inv_form_template["section_group"]], $single_inv_form_template);
                } else {
                    array_push($query_inv_form_template[$single_inv_form_template["section_group"]], $single_inv_form_template);

                }

                //remove from outer json
                unset($query_inv_form_template[$count]);

                $count++;

            }

            if($doj->lte($start_date)){
                unset($query_inv_form_template['Previous Employer Income']);
            }

            if($emp_comp){
                if(($emp_comp->communication_allowance == "" || (int)$emp_comp->communication_allowance == 0) &&
                ($emp_comp->driver_reimbursement == "" || $emp_comp->driver_reimbursement == 0) &&
                ($emp_comp->vehicle_reimbursement == "" || $emp_comp->vehicle_reimbursement == 0) &&
                ($emp_comp->lta == "" || $emp_comp->lta == 0)){
                    unset($query_inv_form_template["Reimbersument "]);
                }
            }else{
                unset($query_inv_form_template["Reimbersument "]);
            }



            $response["form_name"] = $query_form_details->form_name;
            $response["is_submitted"] = $query_is_sumbitted->is_sumbit ?? 0;
            $response["doj"] = $query_doj->doj;
            $response["emp_epf"] = $emp_comp->epf_employee ?? " -- ";
            $response["emp_vpf"] = 0;
            $response["form_details"] = $query_inv_form_template;

            return response()->json([
                "status" => "success",
                "message" => "",
                "data" => $response,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error while fetching investments form template",
                "data" => $e->getMessage(),
            ]);
        }

    }

    /*
        Get the emp investment form details

    */
    public function SaveInvDetails($user_code, $form_id, $is_submitted, $formDataSource)
    {

        //Validate
        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
                'form_id' => $form_id,
                'is_submitted' => $is_submitted,
                'formDataSource' => $formDataSource,

            ],
            $rules = [
                'user_code' => 'required|exists:users,user_code',
                'form_id' => 'required',
                'is_submitted' => 'required',
                'formDataSource' => 'required',
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

            // $form_id = $request->form_id;
            $user_id = User::where('user_code', $user_code)->first()->id;
            // $form_data = $request->formDataSource;
            $current_date = date("Y-m-d");


            $query_femp = VmtInvFEmpAssigned::where('user_id', $user_id);

            if ($query_femp->exists()) {
                $query_assign = $query_femp->first();

            } else {

                $emp_assign_form = new VmtInvFEmpAssigned;
                $emp_assign_form->user_id = $user_id;
                $emp_assign_form->form_id = $form_id;
                $emp_assign_form->year = $current_date;
                $emp_assign_form->is_sumbit = $is_submitted;

                $emp_assign_form->save();
                $query_assign = $emp_assign_form;

            }

            // dd($form_data);
            $assigned_form_user_id = VmtInvFEmpAssigned::where('user_id', $user_id)->first()->id;

            if (isset($formDataSource)) {

                foreach ($formDataSource as $singleFormData) {

                    $emp_formdata = VmtInvEmpFormdata::where('f_emp_id', $assigned_form_user_id)->where('fs_id', $singleFormData['fs_id'])->first();

                    if (empty($emp_formdata)) {

                        $emp_formdata = new VmtInvEmpFormdata;
                        $emp_formdata->f_emp_id = $query_assign->id;
                        $emp_formdata->fs_id = $singleFormData['fs_id'];
                        $emp_formdata->dec_amount = $singleFormData['declaration_amount'];
                        $emp_formdata->selected_section_options = $singleFormData['select_option'] ?? '';
                        //   $emp_formdata->json_popups_value = $sima ?? "none";
                        $emp_formdata->save();

                    } else {

                        $emp_formdata->f_emp_id = $query_assign->id;
                        $emp_formdata->fs_id = $singleFormData['fs_id'];
                        $emp_formdata->dec_amount = $singleFormData['declaration_amount'];
                        $emp_formdata->selected_section_options = $singleFormData['select_option'] ?? '';
                        //    $emp_formdata->json_popups_value = $singleFormData['json_popups_value'];

                        //   $emp_formdata->json_popups_value = $sima ?? "none";
                        $emp_formdata->save();

                    }

                }
            } else {

                $assigned_form_user_id = VmtInvFEmpAssigned::where('user_id', $user_id)->first();

                if ($assigned_form_user_id->exists()) {

                    $assigned_form_user_id->is_sumbit = $is_submitted;
                    $assigned_form_user_id->save();

                }

                // return "sumbit";
            }




            return response()->json([
                "status" => "success",
                "message" => "",
                "data" => "submit successfully",
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error while fetching investments form template",
                "data" => $e,
            ]);
        }


    }


    public function saveSectionPopups($allrequest)
    {

        try {

            $json_encodepopups = json_encode($allrequest);

            $current_date = date("Y-m-d");


            $form_id = "1";

            $user_id = User::where('user_code', $allrequest['user_code'])->first()->id;

            $query_femp = VmtInvFEmpAssigned::where('user_id', $user_id);


            if ($query_femp->exists()) {
                $query_assign = $query_femp->first();

            } else {

                $emp_assign_form = new VmtInvFEmpAssigned;
                $emp_assign_form->user_id = $user_id;
                $emp_assign_form->form_id = $form_id;
                $emp_assign_form->year = $current_date;
                $emp_assign_form->save();
                $query_assign = $emp_assign_form;
            }

            if (empty($allrequest['id'])) {

                $Hra_save = new VmtInvEmpFormdata;
                $Hra_save->fs_id = $allrequest['fs_id'];
                $Hra_save->f_emp_id = $query_assign->id;
                $Hra_save->dec_amount = "0";
                $Hra_save->json_popups_value = $json_encodepopups;
                $Hra_save->save();

            } else {

                $assigned_form_user_id = VmtInvFEmpAssigned::where('user_id', $user_id)->first()->id;

                $emp_formdata = VmtInvEmpFormdata::where('f_emp_id', $assigned_form_user_id)->where('id', $allrequest['id'])->first();

                $emp_formdata->f_emp_id = $query_assign->id;
                $emp_formdata->fs_id = $allrequest['fs_id'];
                $emp_formdata->dec_amount = "0";
                $emp_formdata->json_popups_value = $json_encodepopups;
                $emp_formdata->save();

            }

            return response()->json([
                'status' => 'success',
                'message' => "submit successfully",
                'data' => "",
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Form not saved",
                "data" => $e,
            ]);
        }

    }

    /*
     "user_code" => "LAL0013"
      "fs_id" => 30
      "loan_sanction_date" => "2017-03-15T18:30:00.000Z"
      "lender_type" => "Financial Institution"
      "property_value" => 600
      "loan_amount" => 700
      "interest_amount_paid" => 5000
      "section" => "80EE"

       "user_code" => "LAL0013"
      "fs_id" => 31
      "loan_sanction_date" => "2020-03-17T18:30:00.000Z"
      "lender_type" => "Others"
      "property_value" => 300
      "loan_amount" => 900
      "interest_amount_paid" => 900
      "section" => "80EEA"

       "user_code" => "LAL0013"
      "fs_id" => 32
      "loan_sanction_date" => "2023-03-14T18:30:00.000Z"
      "lender_type" => null
      "property_value" => null
      "loan_amount" => null
      "interest_amount_paid" => 777777
      "vechicle_brand" => "Hyundai"
      "vechicle_model" => "Hyundai IONIQ 5"
      "section" => "80EEB"
    */
    public function saveSection80($allrequest)
    {

        try {

            $json_decodeHra = json_encode($allrequest);
            $current_date = date("Y-m-d");

            $form_id = "1";

            $user_id = User::where('user_code', $allrequest['user_code'])->first()->id;

            $query_femp = VmtInvFEmpAssigned::where('user_id', $user_id);

            if ($query_femp->exists()) {
                $query_assign = $query_femp->first();

            } else {

                $emp_assign_form = new VmtInvFEmpAssigned;
                $emp_assign_form->user_id = $user_id;
                $emp_assign_form->form_id = $form_id;
                $emp_assign_form->year = $current_date;
                $emp_assign_form->save();
                $query_assign = $emp_assign_form;
            }

            $assigned_form_user_id = VmtInvFEmpAssigned::where('user_id', $user_id)->first()->id;

            $emp_formdata = VmtInvEmpFormdata::where('f_emp_id', $assigned_form_user_id)->where('fs_id', $allrequest['fs_id'])->first();

            if (empty($emp_formdata)) {

                $Hra_save = new VmtInvEmpFormdata;
                $Hra_save->f_emp_id = $query_assign->id;
                $Hra_save->fs_id = $allrequest['fs_id'];
                $Hra_save->dec_amount = $allrequest['interest_amount_paid'];
                $Hra_save->json_popups_value = $json_decodeHra;
                $Hra_save->selected_section_options = '0';
                $Hra_save->save();

            } else {
                $emp_formdata->f_emp_id = $query_assign->id;
                $emp_formdata->fs_id = $allrequest['fs_id'];
                $emp_formdata->dec_amount =  $allrequest['interest_amount_paid'];
                $emp_formdata->json_popups_value = $json_decodeHra;
                $emp_formdata->selected_section_options = '0';
                $emp_formdata->save();
            }


            return response()->json([
                'status' => 'success',
                'message' => "save successfully",
                'data' => "",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "don't save details",
                "data" => $e,
            ]);
        }


    }
    public function fetchEmpRentalDetails($user_code, $fs_id)
    {

        $validator = Validator::make(
            $data = [

                'user_code' => $user_code,
                'fs_id' => $fs_id,

            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "fs_id" => "required",

            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try {

            $user_id = User::where('user_code', auth()->user()->user_code)->first()->id;

            $form_assignrd_id = VmtInvFEmpAssigned::where('user_id', $user_id)->first()->id;

            $rentalDetails = VmtInvEmpFormdata::where('fs_id', $fs_id)->where('f_emp_id', $form_assignrd_id)->get();

            $sumOfHra = 0;
            $res = array();

            foreach ($rentalDetails as $item) {

                $hraDecAmt = (json_decode($item->json_popups_value, true));
                $sumOfHra += $hraDecAmt['total_rent_paid'];
                $sumosRentPaid['sumofRentPaid'] = $sumOfHra;
            }
            array_push($res, $sumosRentPaid);


            $popupjson = $rentalDetails->map(function ($item, $key) {
                $rentalDetail['id'] = $item->id;
                $rentalDetail['f_emp_id'] = $item->f_emp_id;
                $rentalDetail['fs_id'] = $item->fs_id;
                $rentalDetail['dec_amount'] = $item->dec_amount;
                $rentalDetail['json_popups_value'] = (json_decode($item->json_popups_value, true));


                return $rentalDetail;
            });

            return ["rent_details" => $popupjson, "dec_amt" => $res];

        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error while fetch Emp Rental Details",
                "data" => $e,
            ]);
        }



    }

    public function fetchHousePropertyDetails($user_code, $fs_id)
    {

        $validator = Validator::make(
            $data = [

                'user_code' => $user_code,
                'fs_id' => $fs_id,

            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "fs_id" => "required",

            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try {

            $user_id = User::where('user_code', $user_code)->first()->id;

            $form_assigned_id = VmtInvFEmpAssigned::where('user_id', $user_id)->first()->id;

            $res = array("data"=>[]);
            foreach ($fs_id as $single_fs_id) {
                $query_rentalDetails = VmtInvEmpFormdata::where('fs_id', $single_fs_id)->where('f_emp_id', $form_assigned_id);

                if ($query_rentalDetails->exists()) {
                    $rentalDetails = $query_rentalDetails->first();
                    $rentalDetail['id'] = $rentalDetails->id;
                    $rentalDetail['f_emp_id'] = $rentalDetails->f_emp_id;
                    $rentalDetail['fs_id'] = $rentalDetails->fs_id;
                    $rentalDetail['dec_amount'] = $rentalDetails->dec_amount;
                    $rentalDetail['json_popups_value'] = (json_decode($rentalDetails->json_popups_value, true));
                    array_push($res['data'], $rentalDetail);
                }

            }
            return $res;


        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error while fetch House Property Details",
                "data" => $e,
            ]);
        }


    }

    public function deleteEmpRentalDetails($currentTableId)
    {

        $validator = Validator::make(
            $data = [

                'currentTableId' => $currentTableId,

            ],
            $rules = [
                "currentTableId" => 'required',


            ],
            $messages = [
                "required" => "Field :attribute is missing",
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try {
            $rentalDetails = VmtInvEmpFormdata::where('id', $currentTableId)->delete();

            return $response = [
                'status' => 'success',
                'message' => "Rental details deleted successfully"
            ];

        } catch (\Exception $e) {
            return $response = [
                'status' => 'failure',
                'message' => 'Error while Deleting Rental Information ',
                'error_message' => $e->getMessage()
            ];
        }


    }
    public function deleteHousePropertyDetails($currentTableId)
    {

        $validator = Validator::make(
            $data = [

                'currentTableId' => $currentTableId,

            ],
            $rules = [
                "currentTableId" => 'required',


            ],
            $messages = [
                "required" => "Field :attribute is missing",
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }
        try {
            $houseProperty = VmtInvEmpFormdata::where('id', $currentTableId)->delete();

            return $response = [
                'status' => 'success',
                'message' => "Rental details deleted successfully"
            ];

        } catch (\Exception $e) {
            return $response = [
                'status' => 'failure',
                'message' => 'Error while Deleting Rental Information ',
                'error_message' => $e->getMessage()
            ];
        }

    }


    public function ImportInvestmentForm_Excel($form_name, $excel_file)
    {

        $validator = Validator::make(
            $data = [
                'form_name' => $form_name,
                'excel_file' => $excel_file,
            ],
            $rules = [
                "form_name" => 'required',
                "excel_file" => 'required',
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

            //Create Form name
            $invform = new VmtInvForm;
            $invform->form_name = $form_name;
            $invform->save();

            //Import excel data
            $response = Excel::import(new VmtInvSectionImport($invform->id), $excel_file);

            return response()->json([
                'status' => 'success',
                'message' => 'Investment Form uploaded successfully',
                'data' => $response
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'failure',
                'message' => 'Investment Form upload failed',
                'data' => $e
            ]);
        }

    }

    public function monthTaxDeductionDetails()
    {

        $user_id = auth()->user()->id;

        $time_period = VmtOrgTimePeriod::where('status', '1')->first();

        $start_date = Carbon::parse($time_period->start_date);

        $end_date = Carbon::parse($time_period->end_date);

        $current_date = Carbon::now();
        $month_cal = 0;
        $res1 = array();
        while ($start_date->lte($end_date)) {
            $start_date = Carbon::parse($start_date)->addMonth();

            $simm['dates'] = $start_date;

            if ($start_date->lte($current_date)) {
                $monthy_tax_cal = 264000 / 12;
                $simm['monthy_tax'] = $monthy_tax_cal;

                $month_cal += $monthy_tax_cal;

            } else {

                $simm['monthy_tax'] = 0;
            }
            array_push($res1, $simm);
        }

        $mos['date'] = $res1;
        $mos['total'] = $month_cal;

        return $mos;

    }



    public function grossEarningsFromEmployment()
    {

        $user_id = auth()->user()->id;

        $time_period = VmtOrgTimePeriod::where('status', '1')->first();

        $start_date = Carbon::parse($time_period->start_date);

        $end_date = Carbon::parse($time_period->end_date);

        $current_date = Carbon::now();

        // $month_cal = 0;
        $res1 = array();
        $res9 = array();
        $res2 = array('total' => []);


        while ($start_date->lte($end_date)) {
            $start_date = Carbon::parse($start_date)->addMonth();

            $simm['date'] = $start_date->format('M y');

            if ($start_date->lte($current_date)) {

                $payslip_data = User::join('vmt_emp_payroll', 'vmt_emp_payroll.user_id', '=', 'users.id')
                    ->join('vmt_payroll', 'vmt_payroll.id', '=', 'vmt_emp_payroll.payroll_id')
                    ->join('vmt_employee_payslip_v2', 'vmt_employee_payslip_v2.emp_payroll_id', '=', 'vmt_emp_payroll.id')
                    ->where('vmt_emp_payroll.user_id', $user_id)
                    ->where('payroll_date', $start_date)
                    ->get([
                        'vmt_employee_payslip_v2.basic',
                        'vmt_employee_payslip_v2.hra',
                        'vmt_employee_payslip_v2.spl_alw as special_allowance',
                        'vmt_employee_payslip_v2.travel_conveyance as transport_allowance',
                        'vmt_employee_payslip_v2.canteen_dedn as food_coupon',

                    ]);

                $total_earnings = 0;

                foreach ($payslip_data as $single_payslip) {

                    $basic = $single_payslip['basic'];
                    $hra = $single_payslip['hra'];
                    $spl_alw = $single_payslip['special_allowance'];
                    $travel_conveyance = $single_payslip['transport_allowance'];
                    $canteen_dedn = $single_payslip['food_coupon'];

                    $total_earnings += $basic + $hra + $spl_alw + $travel_conveyance + $canteen_dedn;

                    $simm['all'] = $payslip_data;
                    $simm['total_earnings'] = $total_earnings;

                }


            } else {

                $compensatory_details = User::join('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'users.id')
                    ->where('user_id', $user_id)->get([
                            'vmt_employee_compensatory_details.basic',
                            'vmt_employee_compensatory_details.hra',
                            'vmt_employee_compensatory_details.special_allowance',
                            'vmt_employee_compensatory_details.transport_allowance',
                            'vmt_employee_compensatory_details.food_coupon',
                        ])->toarray();

                $total_earnings1 = 0;
                foreach ($compensatory_details as $single_compensatory) {

                    $basic = $single_compensatory['basic'];
                    $hra = $single_compensatory['hra'];
                    $spl_alw = $single_compensatory['special_allowance'];
                    $travel_conveyance = $single_compensatory['transport_allowance'];
                    $canteen_dedn = $single_compensatory['food_coupon'];

                    $total_earnings1 += $basic + $hra + $spl_alw + $travel_conveyance + $canteen_dedn;

                    $simm['all'] = $compensatory_details;
                    $simm['total_earnings'] = $total_earnings1;

                }

            }

            array_push($res1, $simm['all'][0]);

            $single_basic = 0;
            $single_hra = 0;
            $single_special_allowance = 0;
            $single_transport_allowance = 0;
            $single_food_coupon = 0;
            $total_earnings = 0;

            foreach ($res1 as $single_all) {

                $single_basic += $single_all['basic'];
                $single_hra += $single_all['hra'];
                $single_special_allowance += $single_all['special_allowance'];
                $single_transport_allowance += $single_all['transport_allowance'];
                $single_food_coupon += $single_all['food_coupon'];

                $total_cal['single_basic'] = $single_basic;
                $total_cal['single_hra'] = $single_hra;
                $total_cal['single_special_allowance'] = $single_special_allowance;
                $total_cal['single_transport_allowance'] = $single_transport_allowance;
                $total_cal['single_food_coupon'] = $single_food_coupon;

                $total_earnings += $single_basic + $single_hra + $single_special_allowance + $single_transport_allowance + $single_food_coupon;

                $total_cal['total_earnings'] = $total_earnings;

            }

            array_push($res2, $simm);
        }

        array_push($res2['total'], $total_cal);

        return ($res2);
    }

    public function taxableIncomeFromAllHeads()
    {

        //   $simma11   = $this->grossEarningsFromEmployment()['total'][0];

        //     dd($simma11);


        $user_id = User::where('user_code', auth()->user()->user_code)->first()->id;


        //Get the form template
        $query_inv_form_template = VmtInvFormSection::leftjoin('vmt_inv_section', 'vmt_inv_section.id', '=', 'vmt_inv_formsection.section_id')
            ->leftjoin('vmt_inv_section_group', 'vmt_inv_section_group.id', '=', 'vmt_inv_section.sectiongroup_id')
            ->get(
                [
                    // 'vmt_inv_formsection.section_id',
                    'vmt_inv_section.section',
                    'vmt_inv_section.particular',
                    // 'vmt_inv_section.reference',
                    'vmt_inv_section.max_amount',
                    'vmt_inv_section_group.section_group',
                    'vmt_inv_formsection.id as fs_id',
                    // 'vmt_inv_section.section_option_1',
                    // 'vmt_inv_section.section_option_2',
                    // 'vmt_inv_formsection.form_id',

                ]
            )->toArray();

        // dd($query_inv_form_template);

        // employee declaration amount
        $inv_emp_value = VmtInvFEmpAssigned::leftjoin('vmt_inv_emp_formdata', 'vmt_inv_emp_formdata.f_emp_id', '=', 'vmt_inv_f_emp_assigned.id')
            ->where('vmt_inv_f_emp_assigned.user_id', $user_id)->get()->toArray();

        $arr = array();
        foreach ($query_inv_form_template as $single_template) {
            foreach ($inv_emp_value as $single_emp_env_value) {
                if ($single_template['fs_id'] == $single_emp_env_value['fs_id']) {
                    // $single_template['id'] = $single_emp_env_value['id'];
                    $single_template['user_id'] = $single_emp_env_value['user_id'];
                    // $single_template['form_id'] = $single_emp_env_value['form_id'];
                    // $single_template['year'] = $single_emp_env_value['year'];
                    // $single_template['f_emp_id'] = $single_emp_env_value['f_emp_id'];
                    $single_template['dec_amount'] = $single_emp_env_value['dec_amount'];
                    $single_template['json_popups_value'] = (json_decode($single_emp_env_value["json_popups_value"], true));
                    // $single_template['is_submit'] = $single_emp_env_value['is_sumbit'];
                    // $single_template['selected_section_options'] = $single_emp_env_value['selected_section_options'];
                }
            }
            array_push($arr, $single_template);
        }

        // dd($arr);

        foreach($arr as $single_arr){

        //  if($single_arr['particular'] == "Employee PF (Payroll Deduction)"){



        //         dd($single_arr);
        //  }
            $res= array('dec_amount'=>0);
        if($single_arr['section_group'] == "Other Excemptions " ){

                     $simma['dec_amount']  = $single_arr['dec_amount'];

                // $simma['total'] =  $single_arr['max_amount'] - $single_arr['dec_amount'];

                array_push($res, $simma);
             }
        }

        dd($res);
// dd();
























        // $query_inv_form_template = $arr;


        // $count = 0;
        // foreach ($query_inv_form_template as $single_inv_form_template) {

        //     if (!array_key_exists($single_inv_form_template["section_group"], $query_inv_form_template)) {
        //         $query_inv_form_template[$single_inv_form_template["section_group"]] = array();
        //         array_push($query_inv_form_template[$single_inv_form_template["section_group"]], $single_inv_form_template);
        //     } else {
        //         array_push($query_inv_form_template[$single_inv_form_template["section_group"]], $single_inv_form_template);

        //     }

        //     //remove from outer json
        //     unset($query_inv_form_template[$count]);

        //     $count++;

        // }
        //  dd($query_inv_form_template);


    }





}
