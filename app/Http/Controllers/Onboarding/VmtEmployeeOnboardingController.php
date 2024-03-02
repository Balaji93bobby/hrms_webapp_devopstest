<?php

namespace App\Http\Controllers\Onboarding;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\User;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\State;
use App\Models\Department;
use App\Models\VmtBloodGroup;
use App\Models\Bank;
use App\Models\VmtEmployee;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\VmtMaritalStatus;

use App\Imports\VmtEmployeeManagerImport;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ViewNotification;
use Illuminate\Support\Facades\Notification;
use App\Imports\VmtEmployeeImport;
use App\Models\VmtEmployeeStatutoryDetails;
use App\Models\VmtDocuments;
use App\Models\VmtEmployeeDocuments;
use App\Models\VmtClientMaster;
use App\Models\VmtMasterConfig;

use App\Models\Compensatory;
use App\Models\VmtEmployeePMSGoals;
use App\Models\VmtAppraisalQuestion;
use Illuminate\Support\Facades\Hash;
use App\Mail\WelcomeMail;
use App\Mail\QuickOnboardLink;

use PhpOffice\PhpSpreadsheet\Shared;
use Dompdf\Options;
use Dompdf\Dompdf;
use League\CommonMark\Extension\SmartPunct\EllipsesParser;
use PDF;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Models\VmtEmployeeFamilyDetails;
use App\Services\VmtEmployeeService;
use App\Services\VmtEmployeeDocumentsService;
use App\Services\Admin\VmtEmployeeMailNotifMgmtService;

class VmtEmployeeOnboardingController extends Controller
{

    public function isEmployeePersonalEmailAlreadyExists(Request $request)
    {
        //dd($request->all());
        //dd(User::where('email',$request->mail)->exists());

        if (!empty($request->mail))
            return User::where('email', $request->mail)->exists() ? "true" : "false";
        else
            return false;
    }

    public function isEmployeeCodeAlreadyExists(Request $request)
    {
        //dd($request->all());
        //dd(User::where('email',$request->mail)->exists());

        if (!empty($request->user_code))
            return User::where('user_code', $request->user_code)->exists() ? "true" : "false";
        else
            return false;
    }
    public function isAadharNoAlreadyExists(Request $request)
    {
        //dd($request->aadhar_number);
        //dd(User::where('email',$request->mail)->exists());

        $aadhar_number = str_replace(" ", '', $request->aadhar_number);

        if (!empty($request->aadhar_number))
            return VmtEmployee::where('aadhar_number', $aadhar_number)->exists() ? "true" : "false";
        else
            return false;
    }
    public function isPanCardAlreadyExists(Request $request)
    {



        if (!empty($request->pan_number) && !empty($request->user_code)) {
            $user_id = User::where('user_code', $request->user_code)->first()->id;

            //Check if pan exists for user other than given user_code user
            return VmtEmployee::where('pan_number', $request->pan_number)
                ->where('userid', '<>', $user_id)
                ->exists() ? "true" : "false";
        } else
        if (!empty($request->pan_number))
            return VmtEmployee::where('pan_number', $request->pan_number)->exists() ? "true" : "false";
        else
            return false;
    }

    public function isMobileNoAlreadyExists(Request $request)
    {
        // dd($request->all());
        //dd(User::where('email',$request->mail)->exists());

        if (!empty($request->mobile_number)) {

            return VmtEmployee::where('mobile_number', $request->mobile_number)->exists() ? "true" : "false";
        } else
            return false;
    }
    public function isAcNoAlreadyExists(Request $request)
    {
        //dd($request->all());
        //dd(User::where('email',$request->mail)->exists());

        if (!empty($request->mobile_number))
            return User::where('user_code', $request->AccountNumber)->exists() ? "true" : "false";
        else
            return false;
    }

    private function generateEmployeeCode()
    {
        $employeeCode_Format = VmtMasterConfig::where('config_name', '=', 'employee_code_prefix')->value('config_value') .
            VmtMasterConfig::where('config_name', '=', 'employee_code_median')->value('config_value');

        //dd("Emp code format : " .$employeeCode_Format);

        $number_series = VmtMasterConfig::where('config_name', '=', 'employee_code_suffix_series')->value('config_value');

        //Get the recently created employee based on DOJ
        //$employee  =  User::orderBy('created_at', 'DESC')->where('user_code', 'LIKE', '%' . $employeeCode_Format . '%')->first();
        $recentlyJoinedEmployee_usercode = User::leftJoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
            //->get('users.user_code');
            ->orderBy('vmt_employee_details.doj', 'DESC')
            ->first('users.user_code');
        // ->get(['users.user_code', 'vmt_employee_details.doj']);


        //dd($recentlyJoinedEmployee_usercode);
        if (empty($recentlyJoinedEmployee_usercode)) {
            $maxId = (int)($number_series) + 1;
        } else {
            $ucode = (int) filter_var($recentlyJoinedEmployee_usercode, FILTER_SANITIZE_NUMBER_INT);
            $maxId  = $ucode + 1;
        }

        return $employeeCode_Format . $maxId;
    }
    public function showEmployeeOnboardingPage($user_id = null)
    {
        // Used for Quick onboarding
        //dd($request->email);

        $is_employeeCode_editable = fetchMasterConfigValue("is_employee_code_editable_in_normal_onboarding");

        $countries = Countries::all();
        $emp = VmtEmployeeOfficeDetails::all();
        $department = Department::all();
        $state = State::where('country_code', 'IN')->get(['id', 'state_name']);
        $blood_group = VmtBloodGroup::all();

        $bank = Bank::all();

        if (!empty($user_id)) {

            $employee_user  =  User::where('id', $user_id)->first();
            $employee_details  = VmtEmployee::where('userid', $employee_user->id)->first();
            $emp_office_details = VmtEmployeeOfficeDetails::where('user_id', $employee_user->id)->first();
            $compensatory = Compensatory::where('user_id', $employee_user->id)->first();
            $emp_statutory_details = VmtEmployeeStatutoryDetails::where('user_id', $employee_user->id)->first();
            //dd($employee_details);
            $empNo = '';
            if ($employee_details) {
                $empNo = $employee_user->user_code;
            }


            $allEmployeesUserCode = User::where('id', '<>', $employee_user->id)
                ->where('is_ssa', 0)->where('active', 1)->whereNotNull('user_code')->get(['user_code', 'name']);

            $assigned_l1_manager_name = User::where('user_code', $emp_office_details->l1_manager_code)->value('name');
            $emp_family_details = VmtEmployeeFamilyDetails::where('user_id', $user_id)->get();

            return view('vmt_employeeOnboarding', compact('empNo', 'user_id', 'is_employeeCode_editable', 'emp_family_details', 'emp_office_details', 'emp_statutory_details', 'employee_user', 'blood_group', 'employee_details', 'countries', 'state', 'compensatory', 'bank', 'emp', 'department', 'allEmployeesUserCode', 'assigned_l1_manager_name'));
        } else {
            $empNo = $this->generateEmployeeCode();

            $emp = VmtEmployeeOfficeDetails::all();
            $allEmployeesUserCode = User::where('is_ssa', 0)->where('active', 1)->whereNotNull('user_code')->get(['user_code', 'name']);
            //dd($allEmployeesCode);
            return view('vmt_employeeOnboarding', compact('empNo', 'is_employeeCode_editable', 'countries', 'state', 'emp', 'bank', 'department', 'allEmployeesUserCode', 'blood_group'));
        }
    }

    public function showNormalOnboardingPage(Request $request)
    {

        if (empty($request->all())) {
            return view('onboarding.vmt_normal_onboarding_v2');
        } else {
            $user_id = Crypt::decrypt($request->uid);
            $can_onboard_employee = User::where('id', $user_id)->first()->is_onboarded;

            if ($can_onboard_employee == '0') {
                return view('onboarding.vmt_normal_onboarding_v2');
            } else {
                return redirect()->route('index');
            }
        }
    }

    /*
        Fetches all the required data for the normal onboarding page.
        These data are shown in onboarding form. Only standard selection data are sent
    */
    public function fetchNormalOnboardingPageData(Request $request)
    {
        $is_employeeCode_editable = fetchMasterConfigValue("is_employee_code_editable_in_normal_onboarding");

        $db_countries = Countries::all();
        $employee_office_details = VmtEmployeeOfficeDetails::all();
        $db_departments = Department::all();
        $db_indianStates = State::where('country_code', 'IN')->get(['id', 'state_name']);
        $db_bloodGroups = VmtBloodGroup::all();

        $db_banks = Bank::all();

        // dd("un-implemented");
    }

    /*
        Fetches the quickonboarded emp data.


    */
    public function fetchQuickOnboardedEmployeeData(Request $request, VmtEmployeeService $employeeService)
    {

        // try {


        //     $user_id = Crypt::decrypt($request->encr_uid);
        //     $response = $employeeService->getQuickOnboardedEmployeeData($user_id);

        //     return response()->json($response, 200);
        // } catch (\Exception $e) {
        //     return response()->json("Decrypt Error : " . $e->getMessage(), 500);
        // }

        $user_id = $request->user_id;
        $response = $employeeService->getQuickOnboardedEmployeeData($user_id);
        return $response;
    }

    // Show quick onboard form to employee
    public function showQuickOnboardForEmployee(Request $request)
    {
        if ($request->has('email')) {
            $employee  =  User::where('email', $request->email)->first();
            $clientData  = VmtEmployee::where('userid', $employee->id)->first();
            $empNo = '';
            if ($clientData) {
                $empNo = $employee->user_code;
            }
            $countries = Countries::all();
            $compensatory = Compensatory::where('user_id', $employee->id)->first();
            $india = Countries::where('country_code', 'IN')->first();
            $emp = VmtEmployeeOfficeDetails::all();
            $emp_details = VmtEmployeeOfficeDetails::where('user_id', $clientData->id)->first();
            // dd($emp);
            $department = Department::all();
            $bank = Bank::all();

            return view('vmt_employeeOnboarding_QuickUpload', compact('empNo', 'emp_details', 'countries', 'compensatory', 'bank', 'emp', 'department'));
        }
    }

    // Showing view for uploading quick onboaring excel sheet
    public function showQuickOnboardUploadPage()
    {

        return view('vmt_quick_employee_upload');
    }

    // show bulk upload form
    public function showBulkOnboardUploadPage(Request $request)
    {
        return view('vmt_employeeOnboarding_BulkUpload');
    }

    public function processEmployeeOnboardForm_Normal(Request $request, VmtEmployeeService $employeeService)
    {

        try {
            $data = $request->all();

               $query_client = VmtClientMaster::find(session('client_id'));
            if(!empty( $query_client )){
                $client_name = $query_client->client_fullname;
            }else{
                $client_name =" ";
            }

           if($client_name == "All"){
                return $response = [
                    'status' => 'failure',
                    'message' => 'you are not authorized to do this action',
                    'data' => '',
                ];
           }

            $user_code = $data['employee_code'];

            $onboard_form_data =  array();

            $onboard_form_data  = $data;

            $currentLoggedinInUser = auth()->user();

            //Check whether we are updating existing user or adding new user.

            $existingUser = User::where('user_code', $user_code);

            if ($existingUser->exists()) {

                //If current user is Admin, then its normal onboarding or updating existing user details.
                if (Str::contains(currentLoggedInUserRole(), ["Super Admin", "Admin", "HR"])) {
                    $result = $employeeService->createOrUpdate_OnboardData($onboard_form_data, $onboard_form_data['can_onboard_employee'], $existingUser->first()->id, $onboard_type = 'normal');

                    $message = "";
                    $isEmailSent = '';

                    if ($result['status'] == "success") {
                        if ($request->input('can_onboard_employee') == "1") {
                            $user_mail = User::where('user_code', $data['employee_code'])->first('email');

                            $VmtClientMaster = VmtClientMaster::first();
                            $image_view = url('/') . $VmtClientMaster->client_logo;

                            if (sessionGetSelectedClientCode() == 'LAL' || sessionGetSelectedClientCode() == 'PSC'  || sessionGetSelectedClientCode() ==  'IMA' ||   sessionGetSelectedClientCode() ==  'ABS') {

                                $isEmailSent  = $employeeService->attachAppointmentLetterPDF($onboard_form_data, "normal");
                            } else {

                                $isEmailSent = \Mail::to($user_mail)->send(new WelcomeMail($data['employee_code'], 'Abs@123123', request()->getSchemeAndHttpHost(), "", $image_view, $VmtClientMaster->abs_client_code));
                            }

                            $message = "Employee onboarded successfully";
                        } else {
                            $message = "Employee details updated in draft";
                        }

                        $response = [
                            'status' => $result['status'],
                            'message' => $message,
                            'mail_status' => $isEmailSent ? "success" : "failure",
                            'data' => $result['data'],
                        ];
                    } else {
                        //When error occured while storing User, then show error to UI
                        $response = [
                            'status' => $result['status'],
                            'message' => "Error while creating/update User details. LINE : " . __LINE__,
                            'data' => $result,
                        ];
                    }
                } else //If the currentuser is quick onboareded emp and not yet onboarded, then save the form.
                    if ($onboard_form_data['employee_code'] == $currentLoggedinInUser->user_code &&  $currentLoggedinInUser->onboard_type  == "quick") {
                        $result = $employeeService->createOrUpdate_OnboardData($onboard_form_data, $request->input('can_onboard_employee'), $existingUser->first()->id, $onboard_type = 'quick');

                        $message = "";

                        if ($result['status'] == "success") {
                            if ($request->input('can_onboard_employee') == "1") {
                                $message = "Employee onboarded successfully";
                            } else {
                                $message = "Your Onboard information Saved in draft";
                            }

                            $response = [
                                'status' => $result['status'],
                                'message' => $message,
                                'can_redirect' => $request->input('can_onboard_employee'), //if its "1", then redirect from onboarding form to under review page
                                'data' => $result['data'],

                            ];
                        } else { //When error occured while storing User, then show error to UI
                            $response = [
                                'status' => $result['status'],
                                'message' => "Error while creating/update User details : LINE : " . __LINE__,
                                'data' => $result['data'],
                            ];
                        }
                    }
            } else { //we are inserting new user as NORMAL onboard.
                //Check whether current login is admin

                if (Str::contains(currentLoggedInUserRole(), ["Super Admin", "Admin", "HR"])) {
                    $result = $employeeService->createOrUpdate_OnboardData($onboard_form_data, $onboard_form_data['can_onboard_employee'], '', $onboard_type = 'normal');

                    if ($result['status'] == "success") {
                        $response = [
                            'status' => 'success',
                            'message' => 'New Employee information Saved in draft',
                            'data' => $result['data']
                        ];
                    } else { //When error occured while storing User, then show error to UI
                        $response = [
                            'status' => $result['status'],
                            'message' => "Error while creating/update User details : LINE : " . __LINE__,
                            'data' => $result['data']
                        ];
                    }
                }
            }
        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => "Error while creating/update Employee details",
                'data' => $e->getmessage() . " " . $e->getline(),
                'erreo_line' => $e->getTraceAsString(),
            ];
        }
        return response()->json($response);
    }

    public function storeQuickOnboardEmployees(Request $request, VmtEmployeeService $employeeService)
    {
        try {
            $data = $request->all();
            $data_array = array();
            $onboard_data = array();
            foreach ($data  as $key => $excelRowdata) {

                $processed_data = str_replace(array(' (dd-mmm-yyyy)', ' '), array('', '_'), array_keys($excelRowdata));

                $Emp_data = array_combine(array_map('strtolower', $processed_data), array_values($excelRowdata));

                array_push($onboard_data, $Emp_data);
            }

        //     foreach ($onboard_data[0]  as $key => $excelRowdata) {

        //         $currentRowInExcel++;
        //         //Validation
        //         $rules = [
        //             'employee_name' => 'required|regex:/(^([a-zA-z. ]+)(\d+)?$)/u',
        //             'email' => 'nullable|email:strict|unique:users,email',
        //             'l1_manager_code' => 'nullable|regex:/(^([a-zA-z0-9.]+)(\d+)?$)/u',
        //             'doj' => 'required|date',
        //             'mobile_number' => 'required|regex:/^([0-9]{10})?$/u|numeric|unique:vmt_employee_details,mobile_number',
        //             'designation' => 'required',
        //             'basic' => 'required|numeric|min:0|not_in:0',
        //             'hra' => 'required|numeric',
        //             'statutory_bonus' => 'required|numeric',
        //             'child_education_allowance' => 'required|numeric',
        //             'food_coupon' => 'required|numeric',
        //             'lta' => 'required|numeric',
        //             'special_allowance' => 'required|numeric',
        //             'other_allowance' => 'required|numeric',
        //             'epf_employer_contribution' => 'required|numeric',
        //             'esic_employer_contribution' => 'required|numeric',
        //             'insurance' => 'required|numeric',
        //             'graduity' => 'required|numeric',
        //             'epf_employee' => 'required|numeric',
        //             'esic_employee' => 'required|numeric',
        //             'professional_tax' => 'required|numeric',
        //             'labour_welfare_fund' => 'required|numeric',
        //         ];

        //         $messages = [
        //             'date' => 'Field <b>:attribute</b> should have the following format DD-MM-YYYY ',
        //             'in' => 'Field <b>:attribute</b> should have the following values : :values .',
        //             'not_in' => 'Field <b>:attribute</b> should be greater than zero: :values .',
        //             'required' => 'Field <b>:attribute</b> is required',
        //             'regex' => 'Field <b>:attribute</b> is invalid',
        //             'employee_name.regex' => 'Field <b>:attribute</b> should not have special characters',
        //             'unique' => 'Field <b>:attribute</b> should be unique',
        //             'numeric' => 'Field <b>:attribute</b> is invalid',
        //             'email' => 'Field <b>:attribute</b> is invalid'
        //         ];

        //         $validator = Validator::make($excelRowdata, $rules, $messages);

        //         if (!$validator->passes()) {

        //             $rowDataValidationResult = [
        //                 'row_number' => $currentRowInExcel,
        //                 'status' => 'failure',
        //                 'message' => 'In Excel Row : ' . $currentRowInExcel . ' has following error(s)',
        //                 'data' => json_encode($validator->errors()),
        //             ];

        //             array_push($data_array, $rowDataValidationResult);
        //             $isAllRecordsValid = false;
        //           }
        //      }
        //  }

        //    //for each
        //     //Runs only if all excel records are valid
        //     if ($isAllRecordsValid) {
        //         foreach ($excelRowdata_row[0]  as $key => $excelRowdata) {
        //             $rowdata_response = $this->storeSingleRecord_QuickEmployee($excelRowdata,$VmtOnboardingTestingService);
        //             array_push($data_array, $rowdata_response);
        //         }
        //      $response = [
        //          'status' => $rowdata_response['status'],
        //          'message' => "Excelsheet data import success",
        //          'data' =>$data_array
        //       ];

        //     }else{
        //      $response = [
        //          'status' => 'failure',
        //          'message' =>"Please fix the below excelsheet data",
        //          'data' =>$data_array
        //       ];
        //     }

        //     return response()->json($response);

        // }

            $existing_user_data = array();
            foreach ($onboard_data  as $key => $excelRowdata) {

                $user_id = User::where('user_code',  $excelRowdata['employee_code'])->first();

                if (!empty($user_id)) {
                    $user_id = $user_id->id;

                    $emp_data = VmtEmployee::where('userid',  $user_id);
                    $emp_office_data = VmtEmployeeOfficeDetails::where('user_id',  $user_id);
                    $emp_compensatory_data = Compensatory::where('user_id',  $user_id);

                    if ($emp_data->exists() && $emp_office_data->exists() && $emp_compensatory_data->exists()) {


                        $message = $excelRowdata['employee_code'] . "Employee already added";

                        array_push($existing_user_data, $message);
                    } else {
                        $emp_data->delete();
                        $emp_office_data->delete();
                        $emp_compensatory_data->delete();
                    }
                }
            }

            foreach ($onboard_data  as $key => $excelRowdata) {

                $rowdata_response = $this->storeSingleRecord_QuickEmployee($excelRowdata, $employeeService);
                array_push($data_array, $rowdata_response);
            }

            if ($rowdata_response['status'] == 'success') {
                $message = "Excelsheet data import success";
            } else {
                $message = "Errorwhile importing Excelsheet data ";
            }
            $response = [
                'status' => $rowdata_response['status'],
                'message' => $message,
                'data' => $data_array
            ];

            return response()->json($response);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'failure',
                'message' => 'Error while uploading Excel data',
                'mail_status' => 'failure',
                'error_fields' =>  $e->getMessage() . " " . $e->getline(),
            ]);
        }
    }


    private function storeSingleRecord_QuickEmployee($row, VmtEmployeeService $employeeService)
    {

        $message = $row['employee_code']  . " not imported ";
        $mail_message = '';
        $status = 'failure';
        try {
            $isEmailSent = "";
            $existing_user_id = User::where('user_code', $row['employee_code']);
            if($existing_user_id->exists()){
                $existing_user_id = $existing_user_id->first()->id;
            }else{
                $existing_user_id =null;
            }
            $response = $employeeService->createOrUpdate_QuickOnboardData(data: $row, can_onboard_employee: "0", existing_user_id: $existing_user_id, onboard_type: 'quick');

            $status = $response['status'];

            if ($response['status'] == "success") {
                $message =  $row['employee_code'] . ' added successfully';

                $VmtClientMaster = User::where('user_code',$row['employee_code'])->first();

                $VmtClientMaster = VmtClientMaster::find( $VmtClientMaster->client_id);

                $image_view = url('/') . $VmtClientMaster->client_logo;

                if (sessionGetSelectedClientCode() == 'LAL' || sessionGetSelectedClientCode() == 'PSC'  || sessionGetSelectedClientCode() ==  'IMA' ||   sessionGetSelectedClientCode() ==  'ABS') {

                    $isEmailSent  = $employeeService->attachAppointmentLetterPDF($row, "quick");
                } else {

                    $isEmailSent = \Mail::to($row['email'])->send(new WelcomeMail($row['employee_code'], 'Abs@123123', request()->getSchemeAndHttpHost(), "", $image_view, $VmtClientMaster->abs_client_code));
                }
                if ($isEmailSent) {
                    $mail_message = 'success';
                } else {
                    $mail_message = 'failure';
                }
            } else {
                $message = $row['employee_code']  . ' has failed';
            }
            //Sending mail

            $rowdata_response = [
                'status' => $status,
                'message' => $message,
                'Employee_Name' => $row['employee_name'],
                'mail_status' => $mail_message ?? '',
                'data' => $response['data']
            ];
            return $rowdata_response;
        } catch (\Exception $e) {
            $rowdata_response = [
                'status' => $status,
                'message' => $message,
                'mail_status' => 'failure',
                'error_fields' =>  $e->getMessage() . " " . $e->getline(),
            ];
            return $rowdata_response;
        }
    }

    public function storeBulkOnboardEmployees(Request $request, VmtEmployeeService $employeeService)
    {
        try {


            $data = $request->all();

            $data_array = array();
            $onboard_data = array();
            foreach ($data  as $key => $excelRowdata) {

                $processed_data = str_replace(array(' (dd-mmm-yyyy)', ' '), array('', '_'), array_keys($excelRowdata));

                $Emp_data = array_combine(array_map('strtolower', $processed_data), array_values($excelRowdata));

                array_push($onboard_data, $Emp_data);
            }

            foreach ($onboard_data  as $key => $excelRowdata) {

                $user_id = User::where('user_code',  $excelRowdata['employee_code'])->first();

                if (!empty($user_id)) {
                    $user_id = $user_id->id;

                    $emp_data = VmtEmployee::where('userid',  $user_id);
                    $emp_office_data = VmtEmployeeOfficeDetails::where('user_id',  $user_id);
                    $emp_fam_data = VmtEmployeeFamilyDetails::where('user_id',  $user_id);
                    $emp_compensatory_data = Compensatory::where('user_id',  $user_id);
                    $emp_statutory_data = VmtEmployeeStatutoryDetails::where('user_id',  $user_id);

                    if ($emp_data->exists() && $emp_office_data->exists() && $emp_fam_data->exists() && $emp_compensatory_data->exists() &&    $emp_statutory_data->exists()) {


                        $response = [
                            'status' => 'failure',
                            'message' => $excelRowdata['employee_code'] . " Employee already added",
                        ];

                        return response()->json($response);
                    } else {

                        $emp_data->delete();
                        $emp_office_data->delete();
                        $emp_fam_data->delete();
                        $emp_compensatory_data->delete();
                        $emp_statutory_data->delete();
                    }
                }
            }

            $rowdata_response = "";

            foreach ($onboard_data  as $key => $excelRowdata) {
                $rowdata_response = $this->storeSingleRecord_BulkEmployee($excelRowdata, $employeeService);
                array_push($data_array, $rowdata_response);
            }
            // dd($data_array);

            if(!empty($rowdata_response)) {
                if ($rowdata_response['status'] == 'success') {
                    $message = "Excelsheet data import success";
                } else {
                    $message = "Error while importing Excelsheet data ";
                }
            }

            return response()->json([
                'status' => $rowdata_response['status'],
                'message' => $message,
                'data' => $data_array
            ],200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'failure',
                'message' => 'Error while uploading Excel data',
                'mail_status' => 'failure',
                'error_fields' =>  $e->getMessage() . " at Line : " . $e->getline(),
            ],400);
        }
    }

    private function storeSingleRecord_BulkEmployee($row, $employeeService)
    {
        //DB level validation

        try {

            $existing_user_id = User::where('user_code', $row['employee_code']);
            if($existing_user_id->exists()){
                $existing_user_id = $existing_user_id->first()->id;
            }else{
                $existing_user_id =null;
            }

            $response = $employeeService->createOrUpdate_BulkOnboardData(data: $row, can_onboard_employee: "0", existing_user_id: $existing_user_id, onboard_type: "bulk");

            $mail_message = '';

            $status = $response['status'];

            if ($status == "success") {

                $message = $row['employee_code'] . ' added successfully';

                $VmtClientMaster = User::where('user_code',$row['employee_code'])->first();
                $VmtClientMaster = VmtClientMaster::find( $VmtClientMaster->client_id);
                $image_view = url('/') . $VmtClientMaster->client_logo;

                if (sessionGetSelectedClientCode() == 'LAL' || sessionGetSelectedClientCode() == 'PSC'  || sessionGetSelectedClientCode() ==  'IMA' ||   sessionGetSelectedClientCode() ==  'ABS') {
                    $isEmailSent  = $employeeService->attachAppointmentLetterPDF($row, "bulk");
                } else {

                    $isEmailSent = \Mail::to($row['email'])->send(new WelcomeMail($row['employee_code'], 'Abs@123123', request()->getSchemeAndHttpHost(), "", $image_view, $VmtClientMaster->abs_client_code));
                }


                // $isEmailSent = new WelcomeMailJobs($row['email'],$row['employee_code'], 'Abs@123123', request()->getSchemeAndHttpHost(), "", $image_view, $VmtClientMaster->abs_client_code)
                //   ->delay(Carbon::now()->addSeconds(5));

                // dispatch($isEmailSent);

                if ($isEmailSent) {
                    $mail_message = 'success';
                } else {
                    $mail_message = 'failure';
                }
            } else {
                $message = $row['employee_code']  . ' has failed';
            }

            //  if($status != 'success'){

            //     $user_data = User::where('user_code',  $row['employee_code'])->first();
            //     $emp_user_data = User::where('user_code',  $row['employee_code'])->first()->delete();
            //     $emp_data = VmtEmployee::where('userid', $user_data->id)->delete();
            //     $emp_office_data = VmtEmployeeOfficeDetails::where('user_id',  $user_data->id)->delete();
            //     $emp_fam_data = VmtEmployeeFamilyDetails::where('user_id',  $user_data->id)->delete();
            //     $emp_compensatory_data = Compensatory::where('user_id',  $user_data->id)->delete();
            //     $emp_statutory_data = VmtEmployeeStatutoryDetails::where('user_id',$user_data->id)->delete();
            //  }
            //  $message = "Employee OnBoard was Created   ";
            //      $VmtClientMaster = VmtClientMaster::first();
            //      $image_view = url('/') . $VmtClientMaster->client_logo;


            return  $rowdata_response = [
                'row_number' => '',
                'status' => $status,
                'message' => $message,
                'Employee_Name' => $row['employee_name'],
                'mail_status' => $mail_message,
                'data' => $response['data'],
            ];
        } catch (\Exception $e) {

            return $rowdata_response = [
                'status' => "failure",
                'message' => 'error while save employee data',
                'mail_status' => 'failure',
                'data' => json_encode(['error' => $e->getMessage()."  ".$e->getline()]),
            ];
        }
    }

    /*
        Called when quick onboarded employee submits the documents from their login.
        After this, the employee is onboarded sucessfully.
    */
    public function storeEmployeeDocuments(Request $request, VmtEmployeeService $employeeService)
    {

        $bulkonboard_docs = $request->all();
        $rowdata_response = [
            'status' => 'empty',
            'message' => 'empty',
        ];


        try {
            $doc_upload_status = array();

            foreach ($bulkonboard_docs as $doc_name => $doc_obj) {

                $processed_doc_name = str_replace('_', ' ', $doc_name);

                $doc_upload_status[$doc_name] = $employeeService->uploadDocument(auth()->user()->id, $doc_obj, $processed_doc_name);
            }


            //Check if all mandatory docs are uploaded by user
            $mandatory_doc_ids = VmtDocuments::where('is_mandatory', '1')->pluck('id');
            $user_uploaded_docs_ids = VmtEmployeeDocuments::whereIn('doc_id', $mandatory_doc_ids)
                ->where('vmt_employee_documents.user_id', auth()->user()->id)
                ->pluck('doc_id');

            $missing_mandatory_doc_ids = array_diff($mandatory_doc_ids->toArray(), $user_uploaded_docs_ids->toArray());


            // foreach($missing_mandatory_doc_ids as $single_mandatory_id){

            //     $missing_mandatory_doc_name[] = VmtDocuments::where('id',$single_mandatory_id)->first()->document_name;
            // }
            //dd("DOc upload status : ".$pending_docs);
            //dd(count($mandatory_doc_ids) == count($user_uploaded_docs_ids));

            if (count($mandatory_doc_ids) == count($user_uploaded_docs_ids)) {
                //set the onboard status to 1
                $currentUser = User::where('id', auth()->user()->id)->first();
                $currentUser->is_onboarded = '1';
                $currentUser->save();

                return  $rowdata_response = [
                    'status' => 'Success',
                    'message' => 'All documents uploaded. You have been successfully onboarded',
                    'data' => $doc_upload_status
                ];
            } else {
                return $rowdata_response = [
                    'status' => 'Failure',
                    'message' => 'Please upload all mandatory documents',
                ];
            }
        } catch (\Throwable $e) {
            //dd("error! ".$e);
            return $rowdata_response = [
                'status' => 'failure',
                'message' => 'Error while uploading documents',
                'error_message' => $e->getMessage()
            ];
        }
    }

    public function viewProfilePagePrivateFile(Request $request)
    {

        $private_file = 'employees/' . $request->user_code . "/onboarding_documents";
        // dd(file(storage_path('employees'.$private_file)));
        return response()->file(storage_path($private_file));
    }

    public function updateEmployeeActiveStatus(Request $request, VmtEmployeeService $employeeService, VmtEmployeeMailNotifMgmtService $serviceVmtEmployeeMailNotifMgmtService)
    {

        $response = $employeeService->updateEmployeeActiveStatus($request->user_code, $request->active_status);

        // $Activation_mail_status =$serviceVmtEmployeeMailNotifMgmtService->send_AccActivationMailNotification($request->user_code);

        return $response;
    }

    public function getEmployeeAllDocumentDetails(Request $request, VmtEmployeeDocumentsService $serviceVmtEmployeeDocumentsService)
    {
        return $serviceVmtEmployeeDocumentsService->getEmployeeAllDocumentDetails($request->user_code);
    }
    public function getMandatoryDocumentDetails(Request $request)
    {
        $response = VmtDocuments::get([
            'id',
            "document_name",
            "is_mandatory"
        ]);

        return $response;
    }



    public function getEmployeeMandatoryDetails(Request $request)
    {

        try {
            $data = array();

            // Get Existing Client Code's

            $existing_clients = VmtClientMaster::pluck('client_code')->toarray();
            $client_code = array_filter($existing_clients, static function ($data) {
                return !is_null($data) && trim($data) != '';
            });

            $data['client_code'] = $client_code;

            //get existing employee_code
            $employees_user_code = User::pluck('user_code')->toarray();
            $user_code = array_filter($employees_user_code, static function ($data) {
                return !is_null($data) && $data != 'NULL';
            });
            $data['user_code'] = array_values($user_code);
            //get existing employee_email

            $employees_email = User::pluck('email')->toarray();
            $email = array_filter($employees_email, static function ($data) {
                return !is_null($data) && $data != 'NULL';
            });
            $data['email'] = array_values($email);

            //get existing employee_mobile_number
            $employees_mobile_number = VmtEmployee::pluck('mobile_number')->toarray();
            $mobile_number = array_filter($employees_mobile_number, static function ($data) {
                return !is_null($data) && $data != 'NULL';
            });
            $data['mobile_number'] = array_values($mobile_number);

            //get existing employee_aadhar_number
            $employees_aadhar_number = VmtEmployee::pluck('aadhar_number')->toarray();
            $aadhar_number = array_filter($employees_aadhar_number, static function ($data) {
                return !is_null($data) && $data != 'NULL';
            });
            $data['aadhar_number'] = array_values($aadhar_number);

            //get existing employee_pan_number
            $employees_pan_number = VmtEmployee::pluck('pan_number')->toarray();
            $pan_number = array_filter($employees_pan_number, static function ($data) {
                return !is_null($data) && $data != 'NULL';
            });
            $data['pan_number'] = array_values($pan_number);

            //get existing bank_name
            $bank_name = Bank::pluck('bank_name')->toarray();
            $bank_name = array_filter($bank_name, static function ($data) {
                return !is_null($data) && $data != 'NULL';
            });
            $data['bank_name'] = array_values($bank_name);

            //get existing department_name
            $department_name = Department::pluck('name')->toarray();
            $department_name = array_filter($department_name, static function ($data) {
                return !is_null($data) && $data != 'NULL';
            });
            $data['department_name'] = array_values($department_name);

            //get existing employees_bankaccount_number
            $employees_bankaccount_number = VmtEmployee::pluck('bank_account_number')->toarray();
            $bankaccount_number = array_filter($employees_bankaccount_number, static function ($data) {
                return !is_null($data) && $data != 'NULL';
            });
            $data['bankaccount_number'] = array_values($bankaccount_number);

            //get existing employees_bankaccount_number
            $employees_blood_group = VmtBloodGroup::pluck('name')->toarray();
            $bankaccount_number = array_filter($employees_blood_group, static function ($data) {
                return !is_null($data) && $data != 'NULL';
            });
            $data['employees_blood_group'] = array_values($employees_blood_group);

            //get existing employees_bankaccount_number
            $employees_marital_status = VmtMaritalStatus::pluck('name')->toarray();
            $bankaccount_number = array_filter($employees_marital_status, static function ($data) {
                return !is_null($data) && $data != 'NULL';
            });
            $data['employees_marital_status'] = array_values($employees_marital_status);

            //get existing employees_bankaccount_number
            $employees_officical_mail = VmtEmployeeOfficeDetails::join('users', 'users.id', '=', 'vmt_employee_office_details.user_id')
                ->where('active', '<>', '-1')
                ->pluck('officical_mail')->toarray();
            $official_mail = array_filter($employees_officical_mail, static function ($data) {
                return !is_null($data) && $data != 'NULL';
            });
            $data['official_mail'] = array_values($official_mail);

            $client_data = VmtClientMaster::all('client_fullname')->toarray();
            $client_data = array_filter($client_data, static function ($data) {
                return !is_null($data) && $data != 'NULL';
            });
            $data['client_details'] = $client_data;

            $quick_onboarding_column_data =["Employee Code","Employee Name","Legal Entity","Email","DOJ","Mobile Number","Designation","Work Location",
                                            "L1 Manager Code","Basic","HRA","Statutory Bonus","Child Education Allowance","Food Coupon","LTA",
                                            "Special Allowance","Other Allowance" ,"Gross","EPF Employer Contribution","ESIC Employer Contribution","Insurance","Graduity","CTC",
                                             "Net Income","EPF Employee","ESIC Employee","Professional Tax","Labour Welfare Fund"
            ];
            $data['quick_onboard_column_data'] = $quick_onboarding_column_data;

            $bulk_onboarding_column_data =["Employee Code","Employee Name","Legal Entity","Email","Gender","DOJ","Location","DOB","Pan No","Aadhar","Marital Status","Mobile Number","Bank Name",
            "Bank ifsc","Account No","Current Address","Permanent Address","Father name","Mother Name","Spouse Name","Department","Process","Designation",
            "Cost Center","Confirmation Period","Holiday Location","L1 Manager Code","Work Location","Official Mail","Official Mobile","Emp Notice","Basic",
            "HRA","Statutory Bonus","dearness  allowance","Child Education Allowance","Food Coupon","LTA","Special Allowance","Other Allowance","Gross",
            "EPF Employer Contribution","ESIC Employer Contribution","Insurance","CTC","Graduity","EPf Employee","ESIC Employee","Professional Tax",
            "Labour Welfare Fund","Net Income","uan number","Pf applicable","Esic applicable","Ptax location","tax regime"
            ];
            $data['bulk_onboard_column_data'] = $bulk_onboarding_column_data;

            $response = ([
                'status' => 'success',
                'message' => '',
                "data" => $data
            ]);
        } catch (\Exception $e) {
            $response = ([
                'status' => 'success',
                'message' => '',
                "data" => $e->getmessage() . " " . $e->getline()
            ]);
        }

        return response()->json($response);
    }


    public function updateMasterConfigClientCode(Request $request, VmtEmployeeService $employeeService){

        $query_client = VmtClientMaster::find(session('client_id'));

        $client_id =$query_client->id;

        $response = $employeeService->updateMasterConfigClientCode( $client_id);

        return $response;
    }


}
