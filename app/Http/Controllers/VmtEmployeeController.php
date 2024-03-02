<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\VmtEmployeeHierarchy;
use App\Models\VmtEmployee;
use App\Models\Countries;
use App\Models\State;
use App\Models\Department;
use App\Models\Bank;
use App\Models\VmtBloodGroup;
use App\Imports\VmtEmployeeManagerImport;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ViewNotification;
use Illuminate\Support\Facades\Notification;
use App\Imports\VmtEmployeeImport;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtEmployeeStatutoryDetails;
use App\Models\VmtClientMaster;
use App\Models\VmtMasterConfig;

use App\Models\Compensatory;
use App\Models\VmtEmployeeDocuments;
use App\Models\VmtEmployeePMSGoals;
use App\Models\VmtAppraisalQuestion;
use Illuminate\Support\Facades\Hash;
use App\Mail\WelcomeMail;
use App\Mail\QuickOnboardLink;
use Validator;
use PhpOffice\PhpSpreadsheet\Shared;
use Dompdf\Options;
use Dompdf\Dompdf;
use League\CommonMark\Extension\SmartPunct\EllipsesParser;
use PDF;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

use App\Models\VmtEmployeeFamilyDetails;
use App\Models\VmtMaritalStatus;
use App\Services\VmtEmployeeService;
use App\Services\VmtApprovalsService;

class VmtEmployeeController extends Controller
{

    /*
    Called from VmtMainDashboardController ,if quick onboarded employee logs in.
    Also used by HR to restore saved drafts of particular employee's normal onboarding.

    Here, we will handle both normal onboarding and quick-onboarded form viewing
    */
    // public function showEmployeeOnboardingPage($user_id=null)
    // {
    //     // Used for Quick onboarding
    //     //dd($request->email);

    //     $is_employeeCode_editable = fetchMasterConfigValue("is_employee_code_editable_in_normal_onboarding");

    //     $countries = Countries::all();
    //     $emp = VmtEmployeeOfficeDetails::all();
    //     $department = Department::all();
    //     $state = State::where('country_code','IN')->get(['id','state_name']);
    //     $blood_group = VmtBloodGroup::all();

    //     $bank = Bank::all();

    //     if (!empty($user_id)) {

    //         $employee_user  =  User::where('id', $user_id)->first();
    //         $employee_details  = VmtEmployee::where('userid', $employee_user->id)->first();
    //         $emp_office_details = VmtEmployeeOfficeDetails::where('user_id', $employee_user->id)->first();
    //         $compensatory = Compensatory::where('user_id', $employee_user->id)->first();
    //         $emp_statutory_details = VmtEmployeeStatutoryDetails::where('user_id', $employee_user->id)->first();
    //         //dd($employee_details);
    //         $empNo = '';
    //         if ($employee_details) {
    //             $empNo = $employee_user->user_code;
    //         }


    //         $allEmployeesUserCode = User::where('id','<>',$employee_user->id)
    //                         ->where('is_ssa', 0)->where('active', 1)->whereNotNull('user_code')->get(['user_code', 'name']);

    //         $assigned_l1_manager_name = User::where('user_code', $emp_office_details->l1_manager_code)->value('name');
    //         $emp_family_details = VmtEmployeeFamilyDetails::where('user_id', $user_id)->get();

    //         return view('vmt_employeeOnboarding', compact('empNo','user_id','is_employeeCode_editable','emp_family_details', 'emp_office_details', 'emp_statutory_details','employee_user','blood_group', 'employee_details', 'countries','state', 'compensatory', 'bank', 'emp', 'department', 'allEmployeesUserCode','assigned_l1_manager_name'));
    //     }
    //     else
    //     {
    //         $empNo = $this->generateEmployeeCode();

    //         $emp = VmtEmployeeOfficeDetails::all();
    //         $allEmployeesUserCode = User::where('is_ssa', 0)->where('active', 1)->whereNotNull('user_code')->get(['user_code', 'name']);
    //         //dd($allEmployeesCode);
    //         return view('vmt_employeeOnboarding', compact('empNo','is_employeeCode_editable', 'countries', 'state', 'emp', 'bank', 'department', 'allEmployeesUserCode','blood_group'));
    //     }
    // }

    public function getEmployeeName(Request $request)
    {
        if (isset($request->user_code))
            return User::where('user_code', $request->user_code)->value('name');
        else
            return "";
    }

    /*
        Generate Employee Code based on the master config

    */
    // private function generateEmployeeCode()
    // {
    //     $employeeCode_Format = VmtMasterConfig::where('config_name', '=', 'employee_code_prefix')->value('config_value') .
    //                            VmtMasterConfig::where('config_name', '=', 'employee_code_median')->value('config_value');

    //     //dd("Emp code format : " .$employeeCode_Format);

    //     $number_series = VmtMasterConfig::where('config_name', '=', 'employee_code_suffix_series')->value('config_value');

    //     //Get the recently created employee based on DOJ
    //     //$employee  =  User::orderBy('created_at', 'DESC')->where('user_code', 'LIKE', '%' . $employeeCode_Format . '%')->first();
    //     $recentlyJoinedEmployee_usercode = User::leftJoin('vmt_employee_details','vmt_employee_details.userid', '=' , 'users.id')
    //                             //->get('users.user_code');
    //                             ->orderBy('vmt_employee_details.doj','DESC')
    //                             ->first('users.user_code');
    //                            // ->get(['users.user_code', 'vmt_employee_details.doj']);


    //     //dd($recentlyJoinedEmployee_usercode);
    //     if (empty($recentlyJoinedEmployee_usercode)) {
    //         $maxId = (int)($number_series) + 1;
    //     } else {
    //         $ucode = (int) filter_var($recentlyJoinedEmployee_usercode, FILTER_SANITIZE_NUMBER_INT);
    //         $maxId  = $ucode + 1;
    //     }

    //     return $employeeCode_Format.$maxId;

    // }


    // Show quick onboard form to employee
    // public function showQuickOnboardForEmployee(Request $request)
    // {
    //     if ($request->has('email')) {
    //         $employee  =  User::where('email', $request->email)->first();
    //         $clientData  = VmtEmployee::where('userid', $employee->id)->first();
    //         $empNo = '';
    //         if ($clientData) {
    //             $empNo = $clientData->emp_no;
    //         }
    //         $countries = Countries::all();
    //         $compensatory = Compensatory::where('user_id', $employee->id)->first();
    //         $india = Countries::where('country_code', 'IN')->first();
    //         $emp = VmtEmployeeOfficeDetails::all();
    //         $emp_details = VmtEmployeeOfficeDetails::where('user_id', $clientData->id)->first();
    //         // dd($emp);
    //         $department = Department::all();
    //         $bank = Bank::all();

    //         return view('vmt_employeeOnboarding_QuickUpload', compact('empNo', 'emp_details', 'countries', 'compensatory', 'bank', 'emp', 'department'));
    //     }
    // }

    /*
     *  Quick Onboarding Employee
     *
     */
    // Showing view for uploading quick onboaring excel sheet
    // public function showQuickOnboardUploadPage()
    // {
    //     return view('vmt_quick_employee_upload');
    // }

    // show bulk upload form
    // public function showBulkOnboardUploadPage(Request $request)
    // {
    //     return view('vmt_employeeOnboarding_BulkUpload');
    // }

    // public function processEmployeeOnboardForm_Normal_Quick(Request $request, VmtEmployeeService $employeeService)
    // {
    //     $user_id = $request->input('user_id');
    //     $response = "";
    //     $isEmailSent = "";
    //     $onboard_form_data =  array();
    //     //parse_str($request->all(), $onboard_form_data); (Removing this line, input from data is alreay in array)
    //     $onboard_form_data  = $request->all();

    //     $currentLoggedinInUser = auth()->user();


    //     //Check whether we are updating existing user or adding new user.
    //     $existingUser = User::where('id',$user_id);

    //     if($existingUser->exists())
    //     {

    //         //If current user is Admin, then its normal onboarding or updating existing user details.
    //         if(Str::contains( currentLoggedInUserRole(), ["Super Admin","Admin","HR"]) )
    //         {
    //             $result = $employeeService->createOrUpdate_OnboardFormData($onboard_form_data, $request->input('can_onboard_employee'), $existingUser->first()->id);

    //             $message = "";

    //             if($result->status == "success")
    //             {

    //                 if($request->input('can_onboard_employee') == "1")
    //                 {
    //                     $isEmailSent  = $employeeService->attachApoinmentPdf($onboard_form_data);
    //                     $message="Employee onboarded successfully";
    //                 }
    //                 else
    //                 {
    //                     $message="Employee details updated in draft";
    //                 }

    //                 $response = [
    //                     'status' => 'success',
    //                     'message' => $message,
    //                     'mail_status' => $isEmailSent ? "success" : "failure",
    //                     'error' => '',
    //                     'error_verbose' =>''
    //                 ];
    //             }
    //             else
    //             {
    //                 //When error occured while storing User, then show error to UI

    //                 $response = [
    //                     'status' => $result->status,
    //                     'message' => "Error while creating/update User details",
    //                     'error' => $result->message,
    //                     'error_verbose' =>''
    //                 ];

    //             }

    //         }
    //         else //If the currentuser is quick onboareded emp and not yet onboarded, then save the form.
    //         if($currentLoggedinInUser->is_onboarded == 0 && $currentLoggedinInUser->onboard_type  == "quick")
    //         {
    //             //check whether if emp_code is tampered
    //             if($onboard_form_data['employee_code'] == $currentLoggedinInUser->user_code)
    //             {
    //                 //$response = $this->storeEmployeeNormalOnboardForm($onboard_form_data, $request->input('can_onboard_employee'));

    //                 $result = $employeeService->createOrUpdate_OnboardFormData($onboard_form_data, $request->input('can_onboard_employee'), $existingUser->first()->id);

    //                 $message = "";

    //                 if($result->status == "success")
    //                 {
    //                     $response = [
    //                         'status' => 'success',
    //                         'message' => 'Your Onboard information Saved in draft',
    //                         'mail_status' => '',
    //                         'error' => '',
    //                         'error_verbose' =>''
    //                     ];
    //                 }
    //                 else
    //                 {
    //                     //When error occured while storing User, then show error to UI
    //                     $response = [
    //                             'status' => $result->status,
    //                             'message' => "Error while creating/update User details",
    //                             'error' => $result->message,
    //                             'error_verbose' =>''
    //                     ];

    //                 }
    //             }
    //             else
    //             {
    //                 //dd("Emp code mismatch. Please contact HR immediately");

    //                 $response = [
    //                     'status' => 'failure',
    //                     'message' => 'Unauthorized Action :: Emp code mismatch. Please contact HR immediately',
    //                     'mail_status' => '',
    //                     'error' => '',
    //                     'error_verbose' =>''
    //                 ];

    //             }
    //         }
    //         else
    //         {
    //             //dd("You are not authorized to perform this action. Please contact the Admin immediately. Log : ".$currentLoggedinInUser);

    //             $response = [
    //                 'status' => 'failure',
    //                 'message' => 'You are not authorized to perform this action. Please contact the Admin immediately. Log : '.$currentLoggedinInUser,
    //                 'mail_status' => '',
    //                 'error' => '',
    //                 'error_verbose' =>''
    //             ];
    //         }

    //     }
    //     else
    //     {
    //         //we are inserting new user.
    //         //Check whether current login is admin
    //         if(Str::contains( currentLoggedInUserRole(), ["Super Admin","Admin","HR"]) )
    //         {
    //             $result = $employeeService->createOrUpdate_OnboardFormData($onboard_form_data, $request->input('can_onboard_employee'), null);

    //             if($result->status == "success")
    //             {
    //                 $response = [
    //                     'status' => 'success',
    //                     'message' => 'New Employee information Saved in draft',
    //                     'mail_status' => '',
    //                     'error' => '',
    //                     'error_verbose' =>'',
    //                     'user_id' => $result->response_object->id  //send the user id to front-end

    //                 ];
    //             }
    //             else
    //             {
    //                 //When error occured while storing User, then show error to UI
    //                 $response = [
    //                         'status' => $result->status,
    //                         'message' => "Error while creating/update User details",
    //                         'error' => $result->message,
    //                         'error_verbose' =>''
    //                 ];

    //             }

    //         }
    //         else
    //         {

    //             $response = [
    //                 'status' => 'failure',
    //                 'message' => 'You are not authorized to perform this action. Please contact the Admin immediately. Log : '.$currentLoggedinInUser,
    //                 'mail_status' => '',
    //                 'error' => '',
    //                 'error_verbose' =>''
    //             ];

    //         }
    //     }

    //     return $response;
    // }



    /*
        Save employee onboarding details
        -Normal Onboarding, Quick


    */
    // private function storeEmployeeNormalOnboardForm($row, $can_onboard_employee)
    // {
    //     // code...
    //     try {

    //         $is_new_user = true;

    //         //Check if user already exists
    //         $user = User::where('email',$row["email"])->first();

    //         if(empty($user))
    //         {
    //           //  dd("emp doesnt exist");
    //             $user =  User::create([
    //                 'name' => $row['employee_name'],
    //                 'email' => $row["email"],
    //                 'password' => Hash::make('Abs@123123'),
    //                 'avatar' =>  $row['employee_name'] . '_avatar.jpg',
    //                 'user_code' => strtoupper($row['employee_code']),
    //                 'active' => '0',
    //                 'is_onboarded' => $can_onboard_employee,
    //                 'onboard_type' => 'normal',
    //                 'org_role' => '5',
    //                 'is_ssa' => '0'
    //             ]);

    //             $is_new_user = true;
    //         }
    //         else
    //         {
    //            // dd("emp exists");
    //            $is_new_user = false;

    //         }


    //         if($user)
    //         {
    //             //STORE EMPLOYEE DETAILS
    //             //Delete old data
    //             VmtEmployee::where('userid', $user->id)->delete();

    //             $newEmployee = new VmtEmployee;

    //             $newEmployee->userid = $user->id;
    //             $newEmployee->emp_no   =    $row["employee_code"] ?? '';
    //             //$newEmployee->emp_name   =    $row["employee_name"];
    //             $newEmployee->gender   =    $row["gender"] ?? '';
    //             //$newEmployee->designation   =    $row["designation"];
    //             //$newEmployee->department   =    $row["department"];
    //             //$newEmployee->status   =    $row["status"];
    //             $newEmployee->doj   =    $row["doj"] ?? '';
    //             $newEmployee->dol   =    $row["doj"] ?? '';
    //             $newEmployee->location   =    $row["work_location"] ?? '';
    //             $newEmployee->dob   =    $row["dob"] ?? '';
    //             $newEmployee->father_name   =  $row["father_name"] ?? '';
    //             $newEmployee->pan_number   =  isset($row["pan_no"]) ? ($row["pan_no"]) : "";
    //             $newEmployee->dl_no   =  $row["dl_no"] ?? '';
    //             $newEmployee->passport_number = $row["passport_no"] ?? '';
    //             //$newEmployee->pan_ack   =    $row["pan_ack"];
    //             $newEmployee->aadhar_number = $row["aadhar"] ?? '';
    //             $newEmployee->epf_number = $row["epf_number"] ?? '';

    //             $newEmployee->esic_number = $row["esic_number"] ?? '';
    //             $newEmployee->marital_status = $row["marital_status"] ?? '';

    //             $newEmployee->mobile_number  = strval($row["mobile_no"]);
    //             $newEmployee->blood_group  = $row["blood_group"] ?? '';
    //             //$newEmployee->email_id   = $row["email"];
    //             $newEmployee->bank_name   = $row["bank_name"] ?? '';
    //             $newEmployee->bank_ifsc_code  = $row["bank_ifsc"] ?? '';
    //             $newEmployee->bank_account_number  = $row["account_no"] ?? '';
    //             // $newEmployee->current_address_line_1   = $row["current_address_line_1"] ?? '';
    //             // $newEmployee->current_address_line_2   = $row["current_address_line_2"] ?? '' ;
    //             // $newEmployee->permanent_address_line_1   = $row["permanent_address_line_1"] ?? '';
    //             // $newEmployee->permanent_address_line_2   = $row["permanent_address_line_2"] ?? '';
    //             // $newEmployee->current_city   = $row["current_city"] ?? '';
    //             // $newEmployee->permanent_city   = $row["permanent_city"] ?? '';

    //             //$newEmployee->father_age   = $row["father_age"];
    //             $newEmployee->mother_name   = $row["mother_name"] ?? '';
    //             //$newEmployee->mother_age  = $row["mother_age"];
    //             if (!empty($row['marital_status'] ))
    //             {
    //                 if($row['marital_status'] <> 'unmarried')
    //                 {
    //                     $newEmployee->spouse_name   = $row["spouse_name"];
    //                     $newEmployee->spouse_age   = $row["spouse_dob"];
    //                     if ($row['no_child'] > 0) {
    //                         $newEmployee->kid_name   = json_encode($row["child_name"]);
    //                         $newEmployee->kid_age  = json_encode($row["child_dob"]);
    //                     }
    //                 }
    //             }
    //             else
    //             {
    //                 $row['marital_status'] = '';
    //             }

    //             $newEmployee->aadhar_card_file = $this->fileUpload('aadhar_card_file',$user->user_code);
    //             $newEmployee->aadhar_card_backend_file = $this->fileUpload('aadhar_card_backend_file',$user->user_code);
    //             $newEmployee->pan_card_file = $this->fileUpload('pan_card_file',$user->user_code);
    //             $newEmployee->passport_file = $this->fileUpload('passport_file',$user->user_code);
    //             $newEmployee->voters_id_file = $this->fileUpload('voters_id_file',$user->user_code);
    //             $newEmployee->dl_file = $this->fileUpload('dl_file',$user->user_code);
    //             $newEmployee->education_certificate_file = $this->fileUpload('education_certificate_file',$user->user_code);
    //             $newEmployee->reliving_letter_file = $this->fileUpload('reliving_letter_file',$user->user_code);
    //             $docReviewArray = array(
    //                 'aadhar_card_file' => -1,
    //                 'aadhar_card_backend_file' => -1,
    //                 'pan_card_file' => -1,
    //                 'passport_file' => -1,
    //                 'voters_id_file' => -1,
    //                 'dl_file' => -1,
    //                 'education_certificate_file' => -1,
    //                 'reliving_letter_file' => -1
    //             );
    //             $newEmployee->docs_reviewed = json_encode($docReviewArray);
    //             $newEmployee->save();

    //             // store family member in vmt_employee_family_details tables
    //             $this->storeEmployeeFamilyMembers($row, $user->id);

    //         }

    //         if ($newEmployee) {

    //             //Delete old record
    //             VmtEmployeeStatutoryDetails::where('user_id', $user->id)->delete();

    //             //Statutory Details
    //             $newEmployee_statutoryDetails = new VmtEmployeeStatutoryDetails;
    //             $newEmployee_statutoryDetails->user_id = $user->id;
    //             $newEmployee_statutoryDetails->uan_number = $row["uan_number"] ?? '';
    //             $newEmployee_statutoryDetails->pf_applicable = $row["pf_applicable"] ?? '';
    //             $newEmployee_statutoryDetails->esic_applicable = $row["esic_applicable"] ?? '';
    //             $newEmployee_statutoryDetails->ptax_location = $row["ptax_location"] ?? '';
    //             $newEmployee_statutoryDetails->tax_regime = $row["tax_regime"] ?? '';
    //             $newEmployee_statutoryDetails->lwf_location = $row["lwf_location"] ?? '';
    //             $newEmployee_statutoryDetails->save();

    //             //Delete old record
    //             VmtEmployeeOfficeDetails::where('user_id', $user->id)->delete();

    //             //Create Employee Details
    //             $empOffice  = new VmtEmployeeOfficeDetails;
    //             $empOffice->user_id = $newEmployee->userid; //Link between USERS and VmtEmployeeOfficeDetails table
    //             $empOffice->department_id = $row["department"] ?? ''; // => "lk"
    //             $empOffice->process = $row["process"] ?? ''; // => "k"
    //             $empOffice->designation = $row["designation"] ?? ''; // => "k"
    //             $empOffice->cost_center = $row["cost_center"] ?? ''; // => "k"
    //             $empOffice->confirmation_period  = $row['confirmation_period'] ?? ''; // => "k"
    //             $empOffice->holiday_location  = $row["holiday_location"] ?? ''; // => "k"
    //             $empOffice->l1_manager_code  = $row["l1_manager_code"] ?? ''; // => "k"


    //             if ( !empty($row["l1_manager_code"]) && $this->isUserExist($row["l1_manager_code"]))
    //             {
    //                 $empOffice->l1_manager_code  = $row["l1_manager_code"];
    //                 updateUserRole($empOffice->l1_manager_code,"Manager");

    //             }

    //             $empOffice->l1_manager_name  = $row["l1_manager_name"] ?? ''; // => "k"
    //             $empOffice->work_location  = $row["work_location"] ?? ''; // => "k"
    //             $empOffice->officical_mail  = $row["officical_mail"] ?? ''; // => "k@k.in"
    //             $empOffice->official_mobile  = $row["official_mobile"] ?? ''; // => "1234567890"
    //             $empOffice->emp_notice  = $row["emp_notice"] ?? ''; // => "0"
    //             $empOffice->save();
    //         }

    //         if ($empOffice) {

    //             //Delete old record
    //             Compensatory::where('user_id', $user->id)->delete();

    //             $compensatory = new Compensatory;
    //             $compensatory->user_id = $newEmployee->userid;
    //             $compensatory->basic = $row["basic"] ?? '';
    //             $compensatory->hra = $row["hra"] ?? '';
    //             $compensatory->Statutory_bonus = $row["statutory_bonus"] ?? '' ;
    //             $compensatory->child_education_allowance = $row["child_education_allowance"] ?? '' ;
    //             $compensatory->food_coupon = $row["food_coupon"] ?? '' ;
    //             $compensatory->lta = $row["lta"] ?? '' ;
    //             $compensatory->special_allowance = $row["special_allowance"] ?? '' ;
    //             $compensatory->other_allowance = $row["other_allowance"] ?? '' ;
    //             $compensatory->gross = $row["gross"] ?? '' ;
    //             $compensatory->epf_employer_contribution = $row["epf_employer_contribution"] ?? '' ;
    //             $compensatory->esic_employer_contribution = $row["esic_employer_contribution"] ?? '' ;
    //             $compensatory->insurance = $row["insurance"] ?? '' ;
    //             $compensatory->graduity = $row["graduity"] ?? '' ;
    //             $compensatory->cic = $row["cic"] ?? '' ;
    //             $compensatory->epf_employee = $row["epf_employee"] ?? '' ;
    //             $compensatory->esic_employee = $row["esic_employee"] ?? '' ;
    //             $compensatory->professional_tax = $row["professional_tax"] ?? '' ;
    //             $compensatory->labour_welfare_fund = $row["labour_welfare_fund"] ?? '' ;
    //             $compensatory->net_income = $row["net_income"] ?? '' ;
    //             $compensatory->save();
    //         }

    //         $message_part = "---";
    //         $mail_status ="---";

    //         //If SAVE button pressed, dont onboard. Onboard if Submit button was pressed
    //         if($can_onboard_employee == "1")
    //         {
    //             // sent welcome email along with appointment Letter

    //             $isEmailSent  = $this->attachApoinmentPdf($row);

    //             if ($isEmailSent) {
    //                 $mail_status="success";
    //             } else {
    //                 $mail_status="failure";
    //             }

    //             $message_part =" onboarded successfully";
    //         }
    //         else
    //         if($can_onboard_employee == "0")
    //         {
    //             $message_part =" saved in draft.";

    //         }

    //         return $response = [
    //             'status' => 'success',
    //             'message' => $row["employee_code"].$message_part,
    //             'mail_status' => $mail_status,
    //             'error' => "",
    //         ];
    //     } catch (\Exception $e) {

    //         $user->is_onboarded = '0';
    //         $user->save();

    //         $message = "";
    //         $error_field = "";

    //         //This error occurs when the form field is empty in UI.
    //         if(str_contains($e->getMessage(),"Undefined array key") )
    //         {
    //             $message = " not added due to missing field";
    //             $error_field = trim($e->getMessage(), "Undefined array key"); //get the field name only

    //         }
    //         else
    //         {
    //             $message = " not added due to following error";
    //             $error_field = $e->getMessage();
    //         }

    //         return $response = [
    //             'status' => 'failure',
    //             'message' => $row["employee_code"].$message,
    //             'mail_status' => '',
    //             'error' => $error_field,
    //             'error_verbose' =>$e
    //         ];
    //     }
    // }

    // store employeess from excel sheet to database
    // public function importBulkOnboardEmployeesExcelData(Request $request)
    // {

    //     $validator =    Validator::make(
    //         $request->all(),
    //         ['file' => 'required|file|mimes:xls,xlsx'],
    //         ['required' => 'The :attribute is required.']
    //     );

    //     if ($validator->passes()) {
    //         $importDataArry = \Excel::toArray(new VmtEmployeeImport, request()->file('file'));
    //         return $this->storeBulkOnboardEmployees($importDataArry);
    //     } else {
    //         $data['failed'] = $validator->errors()->all();
    //         return response()->json($data);
    //     }
    //     // linking Manager To the employees;
    //     // $linkToManager  = \Excel::import(new VmtEmployeeManagerImport, request()->file('file'));
    // }

    /*
        For bulk upload employees
    */
    // private function storeBulkOnboardEmployees($data)
    // {
    //     ini_set('max_execution_time', 300);
    //     //For output jsonresponse
    //     $data_array = [];
    //     //For validation
    //     $isAllRecordsValid = true;

    //     $rules = [];
    //     $responseJSON = [
    //         'status' => 'none',
    //         'message' => 'none',
    //         'data' => [],
    //     ];

    //     // $excelRowdata = $data[0][0];
    //     $excelRowdata_row = $data;
    //     $currentRowInExcel = 0;
    //     foreach ($excelRowdata_row[0]  as $key => $excelRowdata) {
    //         // dd($excelRowdata);
    //         $currentRowInExcel++;
    //         //Validation
    //         $rules = [
    //             'employee_code' => 'nullable|unique:users,user_code',
    //             'employee_name' => 'required|regex:/(^([a-zA-z. ]+)(\d+)?$)/u',
    //             'email' => 'required|email:strict|unique:users,email',
    //             'gender' => 'required|in:Male,male,Female,female,other',
    //             'doj' => 'required|date',
    //             'work_location' => 'required|regex:/(^([a-zA-z. ]+)(\d+)?$)/u',
    //             'dob' => 'required|date|before:-18 years',
    //             'father_name' => 'required|regex:/(^([a-zA-z. ]+)(\d+)?$)/u',
    //             'father_gender' => 'required|in:Male,male,Female,female,other',
    //             'father_dob' => 'required|date',

    //             'pan_no' => 'nullable|required_if:pan_ack,null|regex:/(^([A-Z]){3}P([A-Z]){1}([0-9]){4}([A-Z]){1}$)/u',
    //             'pan_ack' => 'required_if:pan_no,null',
    //             'aadhar' => 'required|regex:/(^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$)/u',
    //             'marital_status' => 'required|in:unmarried,married,widowed,separated,divorced',
    //             'mobile_no' => 'required|regex:/^([0-9]{10})?$/u|numeric',
    //             'bank_name' => 'required|regex:/(^([a-zA-z. ]+)(\d+)?$)/u',
    //             'bank_ifsc' => 'required|regex:/(^([A-Z]){4}0([A-Z0-9]){6}?$)/u',
    //             'account_no' => 'required',
    //             'current_address' => 'required',
    //             'permanent_address' => 'required',
    //             'mother_name' => 'required|regex:/(^([a-zA-z. ]+)(\d+)?$)/u',
    //             'mother_gender' => 'required|in:Male,male,Female,female,other',
    //             'mother_dob' => 'required|date',
    //             'spouse_name' => 'nullable|required_unless:marital_status,unmarried|regex:/(^([a-zA-z. ]+)(\d+)?$)/u',
    //             'spouse_dob' => 'nullable|required_unless:marital_status,unmarried|date',
    //             'no_of_child' => 'nullable|numeric',
    //             'child_name' => 'nullable|required_unless:no_of_child,null,0|regex:/(^([a-zA-z. ]+)(\d+)?$)/u',
    //             'child_dob' => 'nullable||required_unless:no_of_child,null,0|date',
    //             'department' => 'required',
    //             'process' => 'required',
    //             'designation' => 'required',
    //             'cost_center' => 'required',
    //             'confirmation_period' => 'required|numeric',
    //             'holiday_location' => 'required|regex:/(^([a-zA-z. ]+)(\d+)?$)/u',
    //             'l1_manager_code' => 'nullable|regex:/(^([a-zA-z0-9.]+)(\d+)?$)/u',
    //             'l1_manager_name' => 'nullable|regex:/(^([a-zA-z. ]+)(\d+)?$)/u',
    //             'work_location' => 'required|regex:/(^([a-zA-z. ]+)(\d+)?$)/u',
    //             'official_mail' => 'required|email',
    //             'official_mobile' => 'nullable|regex:/^([0-9]{10})?$/u|numeric',
    //             'emp_notice' => 'required|numeric',
    //             'basic' => 'required|numeric',
    //             'hra' => 'required|numeric',
    //             'statutory_bonus' => 'required|numeric',
    //             'child_education_allowance' => 'required|numeric',
    //             'food_coupon' => 'required|numeric',
    //             'lta' => 'required|numeric',
    //             'special_allowance' => 'required|numeric',
    //             'other_allowance' => 'required|numeric',
    //             'epf_employer_contribution' => 'required|numeric',
    //             'insurance' => 'required|numeric',
    //             'graduity' => 'required|numeric',
    //             'epf_employee' => 'required|numeric',
    //             'esic_employee' => 'required|numeric',
    //             'professional_tax' => 'required|numeric',
    //             'labour_welfare_fund' => 'required|numeric',
    //             'uan_number' => 'required|numeric',
    //             'pf_applicable' => 'required|in:yes,Yes,no,No',
    //             'esic_applicable' => 'required|in:yes,Yes,no,No',
    //             'ptax_location' => 'required',
    //             'tax_regime' => 'required|in:old,Old,new,New',
    //             'lwf_location' => 'required',
    //             'esic_employer_contribution' => 'required|numeric',

    //         ];

    //         $messages = [
    //             'numeric' => 'Field <b>:attribute</b> should be numeric',
    //             'date' => 'Field <b>:attribute</b> should have the following format DD-MM-YYYY ',
    //             'in' => 'Field <b>:attribute</b> should have the following values : :values .',
    //             'required' => 'Field <b>:attribute</b> is required',
    //             'regex' => 'Field <b>:attribute</b> is invalid',
    //             'employee_name.regex' => 'Field <b>:attribute</b> should not have special characters',
    //             'unique' => 'Field <b>:attribute</b> should be unique',
    //             'dob.before' => 'Field <b>:attribute</b> should be above 18 years',
    //             'email' => 'Field <b>:attribute</b> is invalid',
    //             'pan_no.required_if' =>'Field <b>:attribute</b> is required if <b>pan ack</b> not provided ',
    //             'pan_ack.required_if' =>'Field <b>:attribute</b> is required if <b>pan no</b> not provided ',
    //             'required_unless' => 'Field <b>:attribute</b> is invalid',
    //         ];

    //         $validator = Validator::make($excelRowdata, $rules, $messages);

    //         if (!$validator->passes()) {

    //             $rowDataValidationResult = [
    //                 'row_number' => $currentRowInExcel,
    //                 'status' => 'failure',
    //                 'message' => 'In Excel Row : ' . $currentRowInExcel . ' has following error(s)',
    //                 'error_fields' => json_encode($validator->errors()),
    //             ];

    //             array_push($data_array, $rowDataValidationResult);

    //             $isAllRecordsValid = false;
    //         }
    //     } //for loop

    //     //Runs only if all excel records are valid
    //     if ($isAllRecordsValid) {
    //         foreach ($excelRowdata_row[0]  as $key => $excelRowdata) {
    //             $rowdata_response = $this->storeSingleRecord_BulkEmployee($excelRowdata);

    //             array_push($data_array, $rowdata_response);
    //         }

    //         $responseJSON['status'] = 'success';
    //         $responseJSON['message'] = "Excelsheet data import success";
    //         $responseJSON['data'] = $data_array;
    //     } else {
    //         $responseJSON['status'] = 'failure';
    //         $responseJSON['message'] = "Please fix the below excelsheet data";
    //         $responseJSON['data'] = $data_array;
    //     }

    //     //dd($responseJSON);

    //     //$data = ['success'=> $returnsuccessMsg, 'failed'=> $returnfailedMsg, 'failure_json' => $failureJSON, 'success_count'=> $addedCount, 'failed_count'=> $failedCount];
    //     return response()->json($responseJSON);
    // }


    private function storeSingleRecord_BulkEmployee_v2($row)
    {
    }


    /*

        $outputArray should be passed from parent function.
    */
    // private function storeSingleRecord_BulkEmployee($row)
    // {
    //     //DB level validation

    //     if (isset($row['employee_code'])) {
    //         $empNo = $row['employee_code'];
    //     } else {
    //         $clientData  = VmtClientMaster::first();
    //         $maxId  = VmtEmployee::max('id') + 1;
    //         if ($clientData) {
    //             $empNo = $clientData->client_code . $maxId;
    //         } else {
    //             $empNo = $maxId;
    //         }
    //     }


    //     try {
    //         $user =  User::create([
    //             'name' => $row['employee_name'],
    //             'email' => $row["email"],
    //             'password' => Hash::make('Abs@123123'),
    //             'avatar' =>  $row['employee_name'] . '_avatar.jpg',
    //             'user_code' =>  strtoupper($empNo),
    //             'can_login' => '1',
    //             'active' => '0',
    //             'is_onboarded' => '0',
    //             'onboard_type' => 'bulk',
    //             'is_ssa' => '0',
    //             'org_role' =>'5', //employee role
    //             'is_default_password_updated' => '0'
    //         ]);
    //         $user->save();

    //         // var_dump($row['dob']);
    //         //  dd($row['dob'];
    //         $newEmployee = new VmtEmployee;
    //         $newEmployee->userid = $user->id;
    //         $newEmployee->emp_no   =    $empNo;
    //         $newEmployee->gender   =    $row["gender"];
    //         $newEmployee->doj   =   \DateTime::createFromFormat('d-m-Y', $row['doj'])->format('Y-m-d');
    //         $newEmployee->dol   =   \DateTime::createFromFormat('d-m-Y', $row['doj'])->format('Y-m-d');
    //         $newEmployee->location   =    $row["work_location"];
    //         $newEmployee->dob   =   \DateTime::createFromFormat('d-m-Y', $row['dob'])->format('Y-m-d');
    //         $newEmployee->father_name   =  $row["father_name"];
    //         $newEmployee->father_gender   =  $row["father_gender"];
    //         $newEmployee->father_dob   =  $row['father_dob'];

    //         $newEmployee->pan_number   =  isset($row["pan_no"]) ? ($row["pan_no"]) : "";
    //         //$newEmployee->pan_ack   =    $row["pan_ack"];
    //         $newEmployee->aadhar_number = $row["aadhar"];
    //         $newEmployee->marital_status = $row["marital_status"];
    //         $newEmployee->mobile_number  = strval($row["mobile_no"]);
    //         $newEmployee->bank_id   = Bank::where('bank_name',$row['bank_name'])->first()->id;
    //         $newEmployee->bank_ifsc_code  = $row["bank_ifsc"];
    //         $newEmployee->bank_account_number  = $row["account_no"];
    //         $newEmployee->current_address_line_1   = $row["current_address"];
    //         $newEmployee->permanent_address_line_1   = $row["permanent_address"];
    //         $newEmployee->mother_name   = $row["mother_name"];
    //         $newEmployee->mother_gender   = $row["mother_gender"];
    //         $newEmployee->mother_dob   = $row["mother_dob"];


    //         if ($row['marital_status'] <> 'unmarried') {
    //             $newEmployee->spouse_name   = $row["spouse_name"];
    //             $newEmployee->spouse_age   = $row["spouse_dob"];
    //             if ($row['no_of_child'] > 0) {
    //                 $newEmployee->no_of_children = $row['no_of_child'];
    //                 $newEmployee->kid_name   = json_encode($row["child_name"]);
    //                 $newEmployee->kid_age  = json_encode($row["child_dob"]);
    //             }
    //         }
    //         $docReviewArray = array(
    //             'aadhar_card_file' => -1,
    //             'aadhar_card_backend_file' => -1,
    //             'pan_card_file' => -1,
    //             'passport_file' => -1,
    //             'voters_id_file' => -1,
    //             'dl_file' => -1,
    //             'education_certificate_file' => -1,
    //             'reliving_letter_file' => -1
    //         );
    //         $newEmployee->docs_reviewed = json_encode($docReviewArray);
    //         $newEmployee->save();

    //         // Storing family member in vmt_employee_family_details
    //         $this->storeEmployeeFamilyMembers($row, $user->id);

    //         if ($newEmployee) {
    //             $empOffice  = new VmtEmployeeOfficeDetails;
    //             $empOffice->user_id = $newEmployee->userid;
    //             $empOffice->department_id = $row["department"];
    //             $empOffice->process = $row["process"];
    //             $empOffice->designation = $row["designation"];
    //             $empOffice->cost_center = $row["cost_center"];
    //             $empOffice->confirmation_period  = $row['confirmation_period'];
    //             $empOffice->holiday_location  = $row["holiday_location"];

    //             if ( !empty($row["l1_manager_code"]))
    //             {
    //                 $empOffice->l1_manager_code  = $row["l1_manager_code"];

    //                 if($this->isUserExist($row["l1_manager_code"]))
    //                     updateUserRole($empOffice->l1_manager_code,"Manager");
    //             }

    //             // $empOffice->l1_manager_name  = $row["l1_manager_name"];
    //             $empOffice->work_location  = $row["work_location"];
    //             $empOffice->officical_mail  = $row["official_mail"];
    //             $empOffice->official_mobile  = $row["official_mobile"];
    //             $empOffice->emp_notice  = $row["emp_notice"];
    //             $empOffice->save();
    //         }

    //         if ($empOffice) {

    //             //Statutory Details
    //             $newEmployee_statutoryDetails = new VmtEmployeeStatutoryDetails;
    //             $newEmployee_statutoryDetails->user_id = $user->id;
    //             $newEmployee_statutoryDetails->uan_number = $row["uan_number"];
    //             $newEmployee_statutoryDetails->epf_number = $row["epf_number"] ?? '';
    //             $newEmployee_statutoryDetails->esic_number = $row["esic_number"] ?? '';
    //             $newEmployee_statutoryDetails->pf_applicable = $row["pf_applicable"];
    //             $newEmployee_statutoryDetails->esic_applicable = $row["esic_applicable"];
    //             $newEmployee_statutoryDetails->ptax_location_state_id = $row["ptax_location"];
    //             $newEmployee_statutoryDetails->tax_regime = $row["tax_regime"];
    //             $newEmployee_statutoryDetails->lwf_location_state_id = $row["lwf_location"];
    //             $newEmployee_statutoryDetails->save();

    //             $compensatory = new Compensatory;
    //             $compensatory->user_id = $newEmployee->userid;
    //             $compensatory->basic = $row["basic"];
    //             $compensatory->hra = $row["hra"];
    //             $compensatory->Statutory_bonus = $row["statutory_bonus"];
    //             $compensatory->child_education_allowance = $row["child_education_allowance"];
    //             $compensatory->food_coupon = $row["food_coupon"];
    //             $compensatory->lta = $row["lta"];
    //             $compensatory->special_allowance = $row["special_allowance"];
    //             $compensatory->other_allowance = $row["other_allowance"];
    //             $compensatory->gross = $row["basic"] + $row["hra"] + $row["statutory_bonus"] + $row["child_education_allowance"] + $row["food_coupon"] + $row["lta"] + $row["special_allowance"] + $row["other_allowance"];
    //             $compensatory->epf_employer_contribution = $row["epf_employer_contribution"];
    //             $compensatory->esic_employer_contribution = $row["esic_employer_contribution"];
    //             $compensatory->insurance = $row["insurance"];
    //             $compensatory->graduity = $row["graduity"];
    //             $compensatory->cic = $compensatory->gross + $row["epf_employer_contribution"] + $row["esic_employer_contribution"] + $row["insurance"] + $row["graduity"];
    //             $compensatory->epf_employee = $row["epf_employee"];
    //             $compensatory->esic_employee = $row["esic_employee"];
    //             $compensatory->professional_tax = $row["professional_tax"];
    //             $compensatory->labour_welfare_fund = $row["labour_welfare_fund"];
    //             $compensatory->net_income = $compensatory->gross + $row["epf_employee"] + $row["esic_employee"] + $row["professional_tax"] + $row["labour_welfare_fund"] - ($row["epf_employer_contribution"] - $row["esic_employer_contribution"] - $row["insurance"] - $row["graduity"]);
    //             $compensatory->save();
    //         }

    //         //Add new items into $row
    //         $row['net_income'] = $compensatory->gross + $row["epf_employee"] + $row["esic_employee"] + $row["professional_tax"] + $row["labour_welfare_fund"] - ($row["epf_employer_contribution"] - $row["esic_employer_contribution"] - $row["insurance"] - $row["graduity"]);


    //         if (fetchMasterConfigValue("can_send_appointmentmail_after_onboarding") == "true") {
    //             $isEmailSent  = $this->attachApoinmentPdf($row);
    //         }

    //         return $rowdata_response = [
    //             'row_number' => '',
    //             'status' => 'success',
    //             'message' => $empNo . ' added successfully<br/>',
    //             'error_fields' => [],
    //         ];
    //     } catch (\Exception $e) {
    //         //dd($e);
    //         $this->deleteUser($user->id);


    //         return $rowdata_response = [
    //             'row_number' => '',
    //             'status' => 'failure',
    //             'message' => $empNo . ' not added',
    //             'error_fields' => json_encode(['error' => $e->getMessage()]),
    //         ];
    //     }
    // }

    public function getAllEmployees()
    {
        $query_employee = User::where('is_ssa', '0')->get(['id', 'name', 'user_code']);
        return ($query_employee);
    }



    public function getState(Request $request)
    {
        $state = State::where('country_code', $request->code)->get();
        return response()->json($state);
    }

    public function fetchDepartmentDetails(Request $request)
    {
        $query = Department::all(['id', 'name']);
        return response()->json($query);
    }

    public function fetchLocationDetails(Request $request)
    {
        $query = VmtEmployeeOfficeDetails::all(['id','work_location'])->toarray();

        $work_location_data = array();
        foreach ($query as $key => $single_location) {

            if (!in_array(trim(ucfirst(strtolower(trim($single_location['work_location'])))), $work_location_data) && $single_location['work_location'] != null) {

                $loc_data[$key]['id'] = $single_location['id'];
                $loc_data[$key]['name'] = ucfirst(strtolower(trim($single_location['work_location'])));


                array_push($work_location_data,  ucfirst(strtolower(trim($single_location['work_location']))));
            }
        }

        $work_location = array_unique($loc_data, SORT_REGULAR);
        $location_data= $work_location;
        return response()->json($location_data);
    }


    public function fetchMaritalStatus(Request $request)
    {
        $query = VmtMaritalStatus::all(['id', 'name']);
        return response()->json($query);
    }

    public function fetchclientcode(Request $request)
    {
        $employee_code_prefix = VmtMasterConfig::where('config_name', 'employee_code_prefix')->first()->config_value;
        return response()->json($employee_code_prefix);
    }

    public function fetchBloodGroups(Request $request)
    {
        $query = VmtBloodGroup::all(['id', 'name']);
        return response()->json($query);
    }

    public function updateUserAccountStatus(Request $request)
    {
        $user = User::find($request->id);
        $user->active = $request->input('status'); // 1 or 0
        $user->save();
        return 'User Account Status : ' . $request->input('status');
    }

    /*
        TODO: Need to check query execution count and speed for this...


    */
    public function fetchAllActiveEmployees(Request $request)
    {
        $query_vmtEmployees = VmtEmployee::join('users', 'users.id', '=', 'vmt_employee_details.userid')
            ->leftJoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
            ->select(
                'users.name as emp_name',
                'users.user_code as emp_code',
                'users.active as emp_status',
                'users.is_onboarded as is_onboarded',
                'users.email as email_id',
                'users.id as user_id',
                'users.avatar as avatar',
                'vmt_employee_details.doj as doj',
                'vmt_employee_details.blood_group_id as blood_group_id',
                'vmt_employee_office_details.department_id',
                'vmt_employee_office_details.designation as emp_designation',
                'vmt_employee_office_details.l1_manager_code as l1_manager_code',
                'vmt_employee_office_details.l1_manager_name',
                'vmt_employee_office_details.l1_manager_designation'
            )
            ->orderBy('users.name', 'ASC')
            ->where('users.active', '1')
            ->where('users.is_ssa', '0');

        //if '1', then show all client's employees
        if (session('client_id') == '1')
            $query_vmtEmployees = $query_vmtEmployees->get();
        else
            $query_vmtEmployees = $query_vmtEmployees->where('client_id', session('client_id'))->get();

        //Add reporting manager name, bloodgroup, profile completeness
        foreach ($query_vmtEmployees as $singleEmp) {
            $singleEmp['enc_user_id'] = Crypt::encryptString($singleEmp['user_id']);
            //unset($singleEmp['user_id']);
            $singleEmp['reporting_manager_name'] = User::where('user_code', $singleEmp->l1_manager_code)->value('name');
            $singleEmp['emp_avatar'] = newgetEmployeeAvatarOrShortName($singleEmp['user_id']);

            $singleEmp['profile_completeness'] = calculateProfileCompleteness($singleEmp['user_id']);

            if (!empty($singleEmp['blood_group_id']))
                $singleEmp['blood_group_name'] = VmtBloodGroup::find($singleEmp['blood_group_id'])->name ?? '';
            else
                $singleEmp['blood_group_name'] = '';
        }

        // dd($query_vmtEmployees);

        return json_encode($query_vmtEmployees);
    }

    public function fetchAllYetToActiveEmployees(Request $request, VmtApprovalsService $serviceVmtApprovalsService)
    {

        $query_vmtEmployees = VmtEmployee::join('users', 'users.id', '=', 'vmt_employee_details.userid')
            ->leftJoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
            ->select(
                'users.name as emp_name',
                'users.user_code as emp_code',
                'users.active as emp_status',
                'users.is_onboarded as is_onboarded',
                'users.email as email_id',
                'users.id as user_id',
                'users.avatar as avatar',
                'vmt_employee_details.doj as doj',
                'vmt_employee_details.blood_group_id as blood_group_id',
                'vmt_employee_office_details.department_id',
                'vmt_employee_office_details.designation as emp_designation',
                'vmt_employee_office_details.l1_manager_code as l1_manager_code',
                'vmt_employee_office_details.l1_manager_name',
                'vmt_employee_office_details.l1_manager_designation'
            )
            ->orderBy('users.name', 'ASC')
            ->where('users.active', '0')
            ->where('users.is_ssa', '0');

        //if '1', then show all client's employees
        if (session('client_id') == '1')
            $query_vmtEmployees = $query_vmtEmployees->get();
        else
            $query_vmtEmployees = $query_vmtEmployees->where('client_id', session('client_id'))->get();

        //Add reporting manager name
        foreach ($query_vmtEmployees as $singleEmp) {
            $singleEmp['enc_user_id'] = Crypt::encryptString($singleEmp['user_id']);
            //unset($singleEmp['user_id']);
            $singleEmp['reporting_manager_name'] = User::where('user_code', $singleEmp->l1_manager_code)->value('name');
            $singleEmp['emp_avatar'] = newgetEmployeeAvatarOrShortName($singleEmp['user_id']);
            $singleEmp['blood_group_name'] = VmtBloodGroup::find($singleEmp['blood_group_id'])->name ?? "";
            $singleEmp['doc_status'] = $serviceVmtApprovalsService->isAllOnboardingDocumentsApproved($singleEmp['emp_code'])->getData()->data;
        }

        return json_encode($query_vmtEmployees);
    }

    public function fetchAllExitEmployees(Request $request)
    {

        $query_vmtEmployees = VmtEmployee::join('users', 'users.id', '=', 'vmt_employee_details.userid')
            ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
            ->select(
                'users.name as emp_name',
                'users.user_code as emp_code',
                'users.active as emp_status',
                'users.is_onboarded as is_onboarded',
                'users.email as email_id',
                'users.id as user_id',
                'users.avatar as avatar',
                'vmt_employee_details.doj as doj',
                'vmt_employee_details.dol as dol',
                'vmt_employee_details.blood_group_id as blood_group_id',
                'vmt_employee_office_details.department_id',
                'vmt_employee_office_details.designation as emp_designation',
                'vmt_employee_office_details.l1_manager_code as l1_manager_code',
                'vmt_employee_office_details.l1_manager_name',
                'vmt_employee_office_details.l1_manager_designation'
            )
            ->orderBy('users.name', 'ASC')
            ->where('users.active', '-1')
            ->where('users.is_ssa', '0');

        //if '1', then show all client's employees
        if (session('client_id') == '1')
            $query_vmtEmployees = $query_vmtEmployees->get();
        else
            $query_vmtEmployees = $query_vmtEmployees->where('client_id', session('client_id'))->get();

        //Add reporting manager name
        foreach ($query_vmtEmployees as $singleEmp) {
            $singleEmp['enc_user_id'] = Crypt::encryptString($singleEmp['user_id']);
            //unset($singleEmp['user_id']);
            $singleEmp['reporting_manager_name'] = User::where('user_code', $singleEmp->l1_manager_code)->value('name');
            $singleEmp['emp_avatar'] = newgetEmployeeAvatarOrShortName($singleEmp['user_id']);
        }

        return json_encode($query_vmtEmployees);
    }

    //
    public function showManageEmployeePage(Request $request)
    {
        //Read session value
        $client_id = 0;

        return view('vmt_manageEmployee', compact('client_id'));
    }

    public function showManageEmployeePage_v2(Request $request)
    {
        //Read session value
        $client_id = 0;

        return view('vmt_manageEmployee_v2');
    }

    public function isUserExist($t_emp_code)
    {
        if (empty(User::where('user_code', $t_emp_code)->where('is_ssa', '0')->first()))
            return false;
        else
            return true;
    }

    // Generate Employee Apoinment PDF after onboarding
    public function attachApoinmentPdf($employeeData)
    {
        //dd($employeeData);
        $empNameString  = $employeeData['employee_name'];
        $filename = 'appoinment_letter_' . $empNameString . '_' . time() . '.pdf';
        $data = $employeeData;
        $data['basic_monthly'] = $employeeData['basic'];
        $data['basic_yearly'] = intval($employeeData['basic']) * 12;
        $data['hra_monthly'] = $employeeData['hra'];
        $data['hra_yearly'] = intval($employeeData['hra']) * 12;
        $data['spl_allowance_monthly'] = $employeeData['special_allowance'];
        $data['spl_allowance_yearly'] = intval($employeeData['special_allowance']) * 12;
        $data['gross_monthly'] = $employeeData["basic"] + $employeeData["hra"] + $employeeData["statutory_bonus"] + $employeeData["child_education_allowance"] + $employeeData["food_coupon"] + $employeeData["lta"] + $employeeData["special_allowance"] + $employeeData["other_allowance"];
        $data['gross_yearly'] = intval($data['gross_monthly']) * 12;
        $data['employer_epf_monthly'] = $employeeData['epf_employer_contribution'];
        $data['employer_epf_yearly'] = intval($employeeData['epf_employer_contribution']) * 12;
        $data['employer_esi_monthly'] = $employeeData['esic_employer_contribution'];
        $data['employer_esi_yearly'] = intval($employeeData['esic_employer_contribution']) * 12;
        $data['ctc_monthly'] = $data['gross_monthly'];
        $data['ctc_yearly'] = intval($data['gross_monthly']) * 12;
        $data['employee_epf_monthly'] =  $employeeData["epf_employer_contribution"];
        $data['employee_epf_yearly'] = intval($employeeData["epf_employer_contribution"]) * 12;
        $data['employer_pt_monthly'] = $employeeData["professional_tax"];
        $data['employer_pt_yearly'] =  intval($employeeData["professional_tax"]) * 12;
        $data['net_take_home_monthly'] = $employeeData["net_income"];
        $data['net_take_home_yearly'] = intval($employeeData["net_income"]) * 12;

        $client_id = User::where('user_code', $employeeData['employee_name'])->first();

        $VmtClientMaster = VmtClientMaster::where('id', $client_id->client_id)->first();

        $image_view = url('/') . $VmtClientMaster->client_logo;
        $appoinmentPath = "";

        if (fetchMasterConfigValue("can_send_appointmentletter_after_onboarding") == "true") {

            //Fetch appointment letter based on client name
            $client_name = Str::lower(str_replace(' ', '', getCurrentClientName()));
            $viewfile_appointmentletter = 'vmt_appointment_templates.mailtemplate_appointmentletter_' . $client_name;

            //check if template exists
            if (view()->exists($viewfile_appointmentletter)) {

                $html =  view($viewfile_appointmentletter, compact('data'));

                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isRemoteEnabled', true);

                $pdf = new Dompdf($options);
                $pdf->loadHtml($html, 'UTF-8');
                $pdf->setPaper('A4', 'portrait');
                $pdf->render();
                $docUploads =  $pdf->output();
                \File::put(public_path('appoinmentLetter/') . $filename, $docUploads);
                $appoinmentPath = public_path('appoinmentLetter/') . $filename;
            }
        }

        $notification_user = User::where('id', auth::user()->id)->first();
        $message = "Employee Bulk OnBoard was Created   ";

        Notification::send($notification_user, new ViewNotification($message . $employeeData['employee_name']));
        $isSent    = \Mail::to($employeeData['email'])->send(new WelcomeMail($employeeData['employee_code'], 'Abs@123123', request()->getSchemeAndHttpHost(),  $appoinmentPath, $image_view, $client_code->abs_client_code));

        return $isSent;
    }



    // Store employees with partial details for quick onboarding
    // public function importQuickOnboardEmployeesExcelData(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|file|mimes:xls,xlsx'
    //     ]);
    //     $importDataArry = \Excel::toArray(new VmtEmployeeImport, request()->file('file'));
    //     return $this->storeQuickOnboardEmployees($importDataArry);
    // }

    // insert the employee to database for quick onboarding
    // private function storeQuickOnboardEmployees($data)
    // {

    //     //For output jsonresponse
    //     $data_array = [];

    //     //For validation
    //     $isAllRecordsValid = true;

    //     $VmtClientMaster = VmtClientMaster::first();

    //     $rules = [];
    //     $responseJSON = [
    //         'status' => 'none',
    //         'message' => 'none',
    //         'data' => [],
    //     ];

    //     $excelRowdata_row = $data;
    //     $currentRowInExcel = 0;

    //     foreach ($excelRowdata_row[0]  as $key => $excelRowdata) {

    //         $currentRowInExcel++;

    //         // var_dump($excelRowdata);exit();
    //         //Validation
    //         $rules = [
    //             'employee_code' => 'nullable|unique:users,user_code',
    //             'employee_name' => 'required|regex:/(^([a-zA-z. ]+)(\d+)?$)/u',
    //             'email' => 'required|email:strict|unique:users,email',
    //             'l1_manager_code' => 'nullable|regex:/(^([a-zA-z0-9.]+)(\d+)?$)/u',
    //             'doj' => 'required|date',
    //             'mobile_no' => 'required|regex:/^([0-9]{10})?$/u|numeric',
    //             'designation' => 'required',
    //             'basic' => 'required|numeric',
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
    //             'required' => 'Field <b>:attribute</b> is required',
    //             'regex' => 'Field <b>:attribute</b> is invalid',
    //             'employee_name.regex' => 'Field <b>:attribute</b> should not have special characters',
    //             'unique' => 'Field <b>:attribute</b> should be unique',
    //             'numeric' => 'Field <b>:attribute</b> is invalid',
    //             'email' => 'Field <b>:attribute</b> is invalid'
    //         ];

    //         // var_dump($excelRowdata);exit();

    //         $validator = Validator::make($excelRowdata, $rules, $messages);
    //         // var_dump($validator);

    //         if (!$validator->passes()) {
    //             // $returnfailedMsg .= $empNo." not get added because of error ".json_encode($validator->errors()->all())." <br/>";
    //             $rowDataValidationResult = [
    //                 'row_number' => $currentRowInExcel,
    //                 'status' => 'failure',
    //                 'message' => 'In Excel Row : ' . $currentRowInExcel . ' has following error(s)',
    //                 'error_fields' => json_encode($validator->errors()),
    //             ];

    //             array_push($data_array, $rowDataValidationResult);

    //             $isAllRecordsValid = false;
    //         }
    //     }//for each

    //     //Runs only if all excel records are valid
    //     if ($isAllRecordsValid) {
    //         foreach ($excelRowdata_row[0]  as $key => $excelRowdata) {
    //             $rowdata_response = $this->storeSingleRecord_QuickEmployee($excelRowdata);

    //             array_push($data_array, $rowdata_response);
    //         }

    //         $responseJSON['status'] = 'success';
    //         $responseJSON['message'] = "Excelsheet data import success";
    //         $responseJSON['data'] = $data_array;
    //     } else {
    //         $responseJSON['status'] = 'failure';
    //         $responseJSON['message'] = "Please fix the below excelsheet data";
    //         $responseJSON['data'] = $data_array;
    //     }

    //     return response()->json($responseJSON);

    // }

    // private function storeSingleRecord_QuickEmployee($row)
    // {

    //     //DB level validation
    //     if (isset($row['employee_code'])) {
    //         $empNo = $row['employee_code'];
    //     } else {
    //         $clientData  = VmtClientMaster::first();
    //         $maxId  = VmtEmployee::max('id') + 1;
    //         if ($clientData) {
    //             $empNo = $clientData->client_code . $maxId;
    //         } else {
    //             $empNo = $maxId;
    //         }
    //     }

    //     try {

    //         $user =  User::create([
    //             'name' => $row['employee_name'],
    //             'email' => $row["email"],
    //             'password' => Hash::make('Abs@123123'),
    //             'avatar' =>  $row['employee_name'] . '_avatar.jpg',
    //             'user_code' =>  strtoupper($empNo),
    //             'can_login' => '1',
    //             'active' => '0',
    //             'is_onboarded' => '0',
    //             'onboard_type' => 'quick',
    //             'is_ssa' => '0',
    //             'is_default_password_updated' => '0',
    //             'org_role' => '5',
    //         ]);

    //         $user->save();

    //         $newEmployee = new VmtEmployee;
    //         $newEmployee->userid = $user->id;
    //         $newEmployee->emp_no   =    $empNo;
    //         //$newEmployee->gender   =    $row["gender"];
    //         $newEmployee->doj   =   \DateTime::createFromFormat('d-m-Y', $row['doj'])->format('Y-m-d');
    //         $newEmployee->dol   =   \DateTime::createFromFormat('d-m-Y', $row['doj'])->format('Y-m-d');
    //         $newEmployee->mobile_number   =    strval($row['mobile_no']);
    //         $docReviewArray = array(
    //             'aadhar_card_file' => -1,
    //             'aadhar_card_backend_file' => -1,
    //             'pan_card_file' => -1,
    //             'passport_file' => -1,
    //             'voters_id_file' => -1,
    //             'dl_file' => -1,
    //             'education_certificate_file' => -1,
    //             'reliving_letter_file' => -1
    //         );
    //         $newEmployee->docs_reviewed = json_encode($docReviewArray);
    //         $newEmployee->save();

    //         if ($newEmployee) {
    //             $empOffice  = new VmtEmployeeOfficeDetails;
    //             $empOffice->user_id     = $newEmployee->userid;
    //             $empOffice->designation = $row["designation"];

    //             if ( !empty($row["l1_manager_code"]) && $this->isUserExist($row["l1_manager_code"]))
    //             {
    //                 $empOffice->l1_manager_code  = $row["l1_manager_code"];
    //                 updateUserRole($empOffice->l1_manager_code,"Manager");

    //             }


    //             $empOffice->save();
    //         }

    //         if ($empOffice) {
    //             $compensatory = new Compensatory;
    //             $compensatory->user_id = $newEmployee->userid;
    //             $compensatory->basic = $row["basic"];
    //             $compensatory->hra = $row["hra"];
    //             $compensatory->Statutory_bonus = $row["statutory_bonus"];
    //             $compensatory->child_education_allowance = $row["child_education_allowance"];
    //             $compensatory->food_coupon = $row["food_coupon"];
    //             $compensatory->lta = $row["lta"];
    //             $compensatory->special_allowance = $row["special_allowance"];
    //             $compensatory->other_allowance = $row["other_allowance"];
    //             $compensatory->gross = $row["basic"] + $row["hra"] + $row["statutory_bonus"] + $row["child_education_allowance"] + $row["food_coupon"] + $row["lta"] + $row["special_allowance"] + $row["other_allowance"];
    //             $compensatory->epf_employer_contribution = $row["epf_employer_contribution"];
    //             $compensatory->esic_employer_contribution = $row["esic_employer_contribution"];
    //             $compensatory->insurance = $row["insurance"];
    //             $compensatory->graduity = $row["graduity"];
    //             $compensatory->cic = $compensatory->gross + $row["epf_employer_contribution"] + $row["esic_employer_contribution"] + $row["insurance"] + $row["graduity"];
    //             $compensatory->epf_employee = $row["epf_employee"];
    //             $compensatory->esic_employee = $row["esic_employee"];
    //             $compensatory->professional_tax = $row["professional_tax"];
    //             $compensatory->labour_welfare_fund = $row["labour_welfare_fund"];
    //             $compensatory->net_income = $compensatory->gross + $row["epf_employee"] + $row["esic_employee"] + $row["professional_tax"] + $row["labour_welfare_fund"] - ($row["epf_employer_contribution"] - $row["esic_employer_contribution"] - $row["insurance"] - $row["graduity"]);
    //             $compensatory->save();
    //         }

    //         $notification_user = User::where('id',auth::user()->id)->first();
    //         $message = "Employee OnBoard was Created   ";
    //         $VmtClientMaster = VmtClientMaster::first();
    //         $image_view = url('/') . $VmtClientMaster->client_logo;
    //         Notification::send($notification_user ,new ViewNotification($message.$row['employee_name']));
    //         \Mail::to($row["email"])->send(new QuickOnboardLink($row['employee_name'], $empNo, 'Abs@123123', request()->getSchemeAndHttpHost(), $image_view));

    //         return $rowdata_response = [
    //             'row_number' => '',
    //             'status' => 'success',
    //             'message' => $empNo . ' added successfully',
    //             'error_fields' => [],
    //         ];


    //     } catch (\Exception $e) {

    //         $this->deleteUser($user->id);


    //         return $rowdata_response = [
    //             'row_number' => '',
    //             'status' => 'failure',
    //             'message' => $empNo . ' not added',
    //             'error_fields' => json_encode(['error' => $e->getMessage()]),
    //         ];


    //         //$responseJSON['status'] = 'failure';
    //         //$responseJSON['message'] = $empNo . " not get added because of error " . $e->getMessage();
    //         //$responseJSON['data'] = json_encode(['error' => $e->getMessage()]);
    //         //$responseJSON['stacktrace'] = json_encode(report($e));
    //         //dd($e->getMessage());
    //         //$returnfailedMsg .= $empNo." not get added because of error ".$e->getMessage()." <br/>";
    //     }

    // }

    // DELETE USER BASE ALL DATA IN DB

    public function deleteUser($data_id)
    {
        $user = User::where('id', $data_id)->delete();
        $Compensatory = Compensatory::where('user_id', $data_id)->delete();
        $VmtEmployeeOfficeDetails = VmtEmployeeOfficeDetails::where('user_id', $data_id)->delete();
        $VmtEmployee = VmtEmployee::where('userid', $data_id)->delete();
    }

    /*
        Show the documents page for the current user.
        If employee already uploaded the docs, it will show the
    */
    public function showEmployeeDocumentsPage(Request $request)
    {

        //Get the existing filenames
        $existing_doc_filenames = VmtEmployeeDocuments::where('user_id', auth()->user()->id)->pluck('doc_url');
        //  dd($existing_doc_filenames);
        //check employee is onboarded or not

        $is_emp_onboarded = User::where('id', auth()->user()->id)->first()->is_onboarded;
        //Check if all necessary docs are Approved or not


        // check the login epolyee is active or not



        //($is_emp_onboarded);
        // dd('asd');
        if ($is_emp_onboarded == '1') {

            return redirect()->route('index');
        } else {

            return view('vmt_documents');
        }
    }

    /*
        Called when quick onboarded employee submits the documents from their login.
        After this, the employee is onboarded sucessfully.
    */
    // public function storeEmployeeDocuments(Request $request)
    // {
    //     $rowdata_response = [
    //         'status' => 'empty',
    //         'message' => 'empty',
    //     ];

    //     //This wont work for super-admin for now.
    //     $currentEmployeeDetails = VmtEmployee::where('userid', auth()->user()->id)->first();

    //     //dd($currentEmployeeDetails->toArray());

    //     try
    //     {
    //         if(isset($request->aadhar_card_file))
    //             $currentEmployeeDetails->aadhar_card_file = $this->fileUpload('aadhar_card_file',auth()->user()->user_code);

    //         if(isset($request->aadhar_card_backend_file))
    //             $currentEmployeeDetails->aadhar_card_backend_file = $this->fileUpload('aadhar_card_backend_file',auth()->user()->user_code);

    //         if(isset($request->pan_card_file))
    //             $currentEmployeeDetails->pan_card_file = $this->fileUpload('pan_card_file',auth()->user()->user_code);

    //         if(isset($request->passport_file))
    //             $currentEmployeeDetails->passport_file = $this->fileUpload('passport_file',auth()->user()->user_code);

    //         if(isset($request->voters_id_file))
    //             $currentEmployeeDetails->voters_id_file = $this->fileUpload('voters_id_file',auth()->user()->user_code);

    //         if(isset($request->dl_file))
    //             $currentEmployeeDetails->dl_file = $this->fileUpload('dl_file',auth()->user()->user_code);

    //         if(isset($request->education_certificate_file))
    //             $currentEmployeeDetails->education_certificate_file = $this->fileUpload('education_certificate_file',auth()->user()->user_code);

    //         if(isset($request->reliving_letter_file))
    //             $currentEmployeeDetails->reliving_letter_file = $this->fileUpload('reliving_letter_file',auth()->user()->user_code);

    //         $currentEmployeeDetails->save();

    //         if( $this->isAllDocumentsUploaded(auth()->user()->id) == 1)
    //         {
    //             //dd("all docs uploaded");

    //             // //set the onboard status to 1
    //             $currentUser = User::where('id', auth()->user()->id)->first();
    //             $currentUser->is_onboarded = '1';
    //             $currentUser->save();

    //             return $rowdata_response = [
    //                 'status' => 'success',
    //                 'message' => 'All documents uploaded. You have been successfully onboarded',
    //             ];
    //         }
    //         else
    //         {

    //             return $rowdata_response = [
    //                 'status' => 'success',
    //                 'message' => 'Documents uploaded. Please upload the remaining documents to successfully onboard',
    //             ];
    //         }

    //     }
    //     catch (\Throwable $e) {
    //         //dd("error! ".$e);
    //         return $rowdata_response = [
    //             'status' => 'failure',
    //             'message' => 'Error while uploading documents',
    //             'error_message' => $e->getMessage()
    //         ];
    //     }
    // }

    private function isAllDocumentsUploaded($emp_id)
    {
        $is_alldocs_uploaded = 1;

        $column_filenames = [
            'aadhar_card_file',
            'aadhar_card_backend_file',
            'pan_card_file',
            'passport_file',
            'voters_id_file',
            'dl_file',
            'education_certificate_file',
            'reliving_letter_file',
        ];

        $uploaded_doc_filenames = VmtEmployee::where('userid', $emp_id)->first($column_filenames);

        $t_array = $uploaded_doc_filenames->toArray();

        //dd($existing_doc_filenames['aadhar_card_file']);
        foreach ($column_filenames as $value) {
            //For now, we are checking only these documents.
            if (
                $value == 'aadhar_card_file' ||
                $value == 'aadhar_card_backend_file' ||
                $value == 'pan_card_file'
            ) {
                if (empty($uploaded_doc_filenames[$value])) {
                    $is_alldocs_uploaded = 0;
                    break;
                }
            }
        }

        return $is_alldocs_uploaded;
    }

    public function updatePassword(Request $request)
    {
        $current_user_id = '';

        if (Auth::check()) {
            //If user already logged in
            $current_user_id = auth()->user()->id;
        } else {
            //If password reset link used, then fetch from url req
            $current_user_id = $request->uid;
        }

        if (isset($request->password)) {
            $currentUser = User::where('id', $current_user_id)->first();
            $currentUser->password = Hash::make($request->password);
            $currentUser->is_default_password_updated = '1';
            $currentUser->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Password updated successfully.',
            ]);
        } else {
            return response()->json([
                'status' => 'failure',
                'message' => 'Password should not be empty.',
            ]);
        }
    }

    public function fileUpload($file, $emp_code)
    {

        if (request()->has($file)) {
            $docUploads = request()->file($file);
            $docUploadsName = 'doc_' . $emp_code . '_' . $file . "_" . time() . '.' . $docUploads->getClientOriginalExtension();

            $emp_document_path = public_path('employee_documents/' . $emp_code);
            // dd($emp_document_path);
            if (!File::isDirectory($emp_document_path)) {
                File::makeDirectory($emp_document_path, 0777, true, true);
            } else {
                //get the filename
                $user_id = User::where('user_code', $emp_code)->first('id');
                $existing_file = VmtEmployee::where('userid', $user_id->id)->value($file);

                //Delete the old file
                if (isset($existing_file) && File::isFile($emp_document_path . '/' . $existing_file)) {
                    // dd("File found : ".$emp_document_path.'/'.$existing_file);
                    File::delete($emp_document_path . '/' . $existing_file);
                } else {
                    //If file doesnt exists, delete the entry

                }
            }

            //Upload the new file
            $docUploads->move($emp_document_path, $docUploadsName);
            return $docUploadsName;
        } else {
            return "";
        }
    }


    /**
     *  storeEmployeeFamilyMembers()
     *  table: vmt_employee_family_details
     */
    protected function storeEmployeeFamilyMembers($familyData, $userId)
    {
        //delete old records
        VmtEmployeeFamilyDetails::where('user_id', $userId)->delete();

        if (!empty($familyData['father_name'])) {
            $familyMember =  new VmtEmployeeFamilyDetails;
            $familyMember->user_id  = $userId;
            $familyMember->name =   $familyData['father_name'];
            $familyMember->relationship = 'Father';

            if (!empty($familyData["father_dob"]))
                $familyMember->dob = \DateTime::createFromFormat('d-m-Y', $familyData['father_dob'])->format('Y-m-d');

            $familyMember->save();
        }

        if (!empty($familyData['mother_name'])) {
            $familyMember =  new VmtEmployeeFamilyDetails;
            $familyMember->user_id  = $userId;
            $familyMember->name =   $familyData['mother_name'];
            $familyMember->relationship = 'Mother';

            if (!empty($familyData["mother_dob"]))
                $familyMember->dob = \DateTime::createFromFormat('d-m-Y', $familyData['mother_dob'])->format('Y-m-d');
            //$familyData["mother_dob"];

            $familyMember->save();
        }
        if ($familyData['marital_status'] <> 'unmarried') {
            $familyMember =  new VmtEmployeeFamilyDetails;
            $familyMember->user_id  = $userId;
            $familyMember->name =   $familyData['spouse_name'];
            $familyMember->relationship = 'Spouse';

            if (!empty($familyData["spouse_dob"]))
                $familyMember->dob = \DateTime::createFromFormat('d-m-Y', $familyData['spouse_dob'])->format('Y-m-d');
            //$familyData["spouse_dob"];

            $familyMember->save();

            if (!empty($familyData['child_name'])) {
                $familyMember =  new VmtEmployeeFamilyDetails;
                $familyMember->user_id  = $userId;
                $familyMember->name =   $familyData['child_name'];
                $familyMember->relationship = 'Children';

                if (isset($familyData["child_dob"]))
                    $familyMember->dob = \DateTime::createFromFormat('d-m-Y', $familyData['child_dob'])->format('Y-m-d');
                //$familyData["child_dob"];

                $familyMember->save();
            }
        }

        return "saved";
    }

    public function getCurrentEmployeeDetails(Request $request)
    {

        $user_id = User::where('user_code', auth()->user()->user_code)->first();
        $user =  User::where('user_code', 'SA100')->get();

        dd($user_id);
    }

    public function fetchManagerName()
    {
        $reportingManagers = User::join('vmt_org_roles', 'vmt_org_roles.id', '=', 'users.org_role')
            //->whereIn('vmt_org_roles.id',[3,4])
            ->where('users.is_ssa', 0)
            ->where('users.active', 1)
            ->get(['users.user_code', 'users.name']);
        // dd($reportingManagers);
        return $reportingManagers;
    }


    public function getEmployeeLoanDetails(Request $request)
    {

        try {
            $data = array();

            //get existing employee_code
            $employees_user_code = User::where("active", "1")->where("is_ssa", "0")->pluck('user_code')->toarray();
            $user_code = array_filter($employees_user_code, static function ($data) {
                return !is_null($data) && $data != 'NULL';
            });
            $data['user_code'] = array_values($user_code);


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
}
