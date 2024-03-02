<?php

use Illuminate\Support\Facades\Storage;
use App\Models\VmtDocuments;
use App\Models\VmtEmployeeDocuments;
use App\Models\VmtEmployee;
use App\Models\VmtPMS_KPIFormAssignedModel;
use App\Models\VmtPMS_KPIFormDetailsModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use Carbon\Carbon;

use App\Models\VmtTempEmployeeProofDocuments;
use App\Models\VmtMaritalStatus;
use App\Models\VmtInvFormSection;
use App\Models\VmtInvFEmpAssigned;
use App\Models\VmtMasterConfig;
use App\Models\VmtEmployeeLeaves;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtClientMaster;
use App\Mail\ApproveRejectEmpDetails;
use App\Mail\VmtPMSMail_Assignee;
use App\Mail\VmtAttendanceMail_Regularization;
use App\Models\User;
use App\Models\VmtEmpPaygroup;
use App\Models\VmtPaygroup;
use App\Models\vmtHolidays;
use App\Models\VmtEmployeeAttendance;
use App\Models\VmtEmployeePayroll;
use App\Models\VmtEmployeePaySlip;
use App\Models\VmtEmployeePaySlipV2;
use App\Models\VmtPMS_KPIFormModel;
use App\Models\VmtLoanInterestSettings;
use App\Models\VmtUserMailStatus;
use App\Models\VmtEmployeePayslipStatus;
use App\Models\VmtEmployeeMailStatus;
use App\Models\VmtEmployeeStatutoryDetails;
use App\Models\VmtPayroll;
use App\Models\Compensatory;
use App\Mail\QuickOnboardLink;
use App\Services\VmtApprovalsService;
use App\Mail\WelcomeMail;

?>

@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('/assets/premassets/css/onboarding.css') }}">
@endsection
@endsection
@section('content')
<?php

//     foreach ($emp_payroll_user_id as $key => $singleuser) {

// $user_code = User::where('id',$singleuser)->first()->user_code;
//     $emp_client_code = preg_replace('/\d+/', '',strtoupper($user_code));
// $client_data = VmtClientMaster::where('client_code',$emp_client_code)->first();
// $client_id = array();
// if(!empty($client_data)){
// $client_id[]=$client_data->id;

// }
// }

/*Get all employee payslip details */

$query_all_payslip = VmtEmployeePayslip::all();

/* save single payrollmonth in vmt_payroll*/
$emp_payroll_month = VmtEmployeePayslip::whereYear('created_at', '2022')
    ->orwhereYear('created_at', '2023')
    ->distinct('created_at')
    ->orderBy('PAYROLL_MONTH', 'ASC')
    ->pluck('PAYROLL_MONTH');

//  $client_details_id = VmtClientMaster::get("id");

//  foreach ($client_details_id as $key => $singleclient) {

//             foreach ($emp_payroll_month as $key => $singlepayrollmonth) {
//                 $query_payroll = new Vmtpayroll;
//                 $query_payroll->client_id=$singleclient->id;
//                 $query_payroll->payroll_date=$singlepayrollmonth;
//                 $query_payroll->save();
//             }
// }

// /* save user id and payroll id in the table vmt_emp_payroll*/
//           foreach ($query_all_payslip as $key => $singleuserdata) {
//                 $query_payroll_data= new VmtEmployeePayroll;
//                 $query_payroll_data->user_id=$singleuserdata->user_id;
//                 $client_id = User::where('id',$singleuserdata->user_id)->first()->client_id;
//                 $payroll_id =VmtPayroll::where('payroll_date',$singleuserdata->PAYROLL_MONTH)
//                                          ->where('client_id',$client_id)->first()->id;
//                 $query_payroll_data->payroll_id=$payroll_id;
//                 $query_payroll_data->save();
//             }

//  /*save all employee payslip details in vmt_employee_payslipv2 */

//         foreach ($query_all_payslip as $key => $singlepayslipdetails) {

//             $emppayslip = new VmtEmployeePaySlipV2;
//  /*get payroll id from vmt_emp_payroll in order to filter payroll_date and find emp_payroll_id */

//                $client_id = User::where('id',$singlepayslipdetails->user_id)->first()->client_id;
//                 $payroll_id =VmtPayroll::where('payroll_date',$singlepayslipdetails->PAYROLL_MONTH)
//                                          ->where('client_id',$client_id)->first()->id;
//            $emp_payroll_id=VmtEmployeePayroll::where('user_id',$singlepayslipdetails->user_id)->where('payroll_id',$payroll_id)->first()->id;
//            $emppayslip->emp_payroll_id= $emp_payroll_id;
//            $emppayslip->basic=$singlepayslipdetails->BASIC;
//            $emppayslip->hra=$singlepayslipdetails->HRA;
//            $emppayslip->child_edu_allowance=$singlepayslipdetails->CHILD_EDU_ALLOWANCE;
//            $emppayslip->spl_alw=$singlepayslipdetails->SPL_ALW;
//            $emppayslip->total_fixed_gross=$singlepayslipdetails->TOTAL_FIXED_GROSS;
//            $emppayslip->month_days=$singlepayslipdetails->MONTH_DAYS;
//            $emppayslip->worked_Days=$singlepayslipdetails->Worked_Days;
//            $emppayslip->arrears_Days=$singlepayslipdetails->Arrears_Days;
//            $emppayslip->lop=$singlepayslipdetails->LOP;
//            $emppayslip->earned_basic=$singlepayslipdetails->Earned_BASIC;
//            $emppayslip->basic_arrear=$singlepayslipdetails->BASIC_ARREAR;
//            $emppayslip->earned_hra=$singlepayslipdetails->Earned_HRA;
//            $emppayslip->hra_arrear=$singlepayslipdetails->HRA_ARREAR;
//            $emppayslip->earned_child_edu_allowance=$singlepayslipdetails->Earned_CHILD_EDU_ALLOWANCE;
//            $emppayslip->child_edu_allowance_arrear=$singlepayslipdetails->CHILD_EDU_ALLOWANCE_ARREAR;
//            $emppayslip->earned_spl_alw=$singlepayslipdetails->Earned_SPL_ALW;
//            $emppayslip->spl_alw_arrear=$singlepayslipdetails->SPL_ALW_ARREAR;
//            $emppayslip->overtime=$singlepayslipdetails->Overtime;
//            $emppayslip->total_earned_gross=$singlepayslipdetails->TOTAL_EARNED_GROSS;
//            $emppayslip->pf_wages=$singlepayslipdetails->PF_WAGES;
//            $emppayslip->pf_wages_arrear_epfr=$singlepayslipdetails->PF_WAGES_ARREAR_EPFR;
//            $emppayslip->epfr=$singlepayslipdetails->EPFR;
//            $emppayslip->epfr_arrear=$singlepayslipdetails->EPFR_ARREAR;
//            $emppayslip->edli_charges=$singlepayslipdetails->EDLI_CHARGES;
//            $emppayslip->edli_charges_arrears=$singlepayslipdetails->EDLI_CHARGES_ARREARS;
//            $emppayslip->pf_admin_charges=$singlepayslipdetails->PF_ADMIN_CHARGES;
//            $emppayslip->pf_admin_charges_arrears=$singlepayslipdetails->PF_ADMIN_CHARGES_ARREARS;
//            $emppayslip->employer_esi=$singlepayslipdetails->EMPLOYER_ESI;
//            $emppayslip->employer_lwf=$singlepayslipdetails->Employer_LWF;
//            $emppayslip->ctc=$singlepayslipdetails->CTC;
//            $emppayslip->epf_ee=$singlepayslipdetails->EPF_EE;
//            $emppayslip->epf_ee_arrear=$singlepayslipdetails->EPF_EE_ARREAR;
//            $emppayslip->employee_esic=$singlepayslipdetails->EMPLOYEE_ESIC;
//            $emppayslip->prof_tax=$singlepayslipdetails->PROF_TAX;
//            $emppayslip->income_tax=$singlepayslipdetails->income_tax;
//            $emppayslip->sal_adv=$singlepayslipdetails->SAL_ADV;
//            $emppayslip->canteen_dedn=$singlepayslipdetails->CANTEEN_DEDN;
//            $emppayslip->other_deduc=$singlepayslipdetails->OTHER_DEDUC;
//            $emppayslip->lwf=$singlepayslipdetails->LWF;
//            $emppayslip->total_deductions=$singlepayslipdetails->TOTAL_DEDUCTIONS;
//            $emppayslip->net_take_home=$singlepayslipdetails->NET_TAKE_HOME;
//            $emppayslip->rupees=$singlepayslipdetails->Rupees;
//            $emppayslip->el_opn_bal=$singlepayslipdetails->EL_Opn_Bal;
//            $emppayslip->availed_el=$singlepayslipdetails->Availed_EL;
//            $emppayslip->balance_el=$singlepayslipdetails->Balance_EL;
//            $emppayslip->sl_opn_bal=$singlepayslipdetails->SL_Opn_Bal;
//            $emppayslip->availed_sl=$singlepayslipdetails->Availed_SL;
//            $emppayslip->balance_sl=$singlepayslipdetails->Balance_SL;
//            $emppayslip->greetings=$singlepayslipdetails->Greetings;
//            $emppayslip->travel_conveyance=$singlepayslipdetails->travel_conveyance;
//            $emppayslip->other_earnings=$singlepayslipdetails->other_earnings;
//            $emppayslip->save();

//          }

// $payroll_month= VmtPayroll::whereMonth('payroll_date', $month)
//                                      ->whereYear('payroll_date', $year)->first();

//  $emp_payslip_id =VmtEmployeePayroll::where('user_id','144')->get('id');
//  $query_payslips=array();
//   foreach ($emp_payslip_id as $key => $singleuserid) {

// //     $query_payslips[] = VmtEmployeePaySlipV2::where('emp_payroll_id',$singleuserid->id)
// //                                     ->orderBy('emp_payroll_id', 'ASC')
// //                                     ->get(['id','NET_TAKE_HOME','TOTAL_DEDUCTIONS','TOTAL_EARNED_GROSS']);
//  }
//         $month='08';
//          $year='2022';
//          $user_id ='144';

//          $response['payslip_data'] = User::with([
//                                     'getEmployeeDetails' => function($query){
//                                        $query->select(['id','userid','dob','doj','location','pan_number','bank_id','bank_account_number','bank_ifsc_code']);
//                                     },
//                                     'getEmployeeOfficeDetails' => function($query){
//                                             $query->select(['id','user_id','designation']);
//                                     },
//                                     'getStatutoryDetails' =>function($query){
//                                         $query->select(['id','user_id','epf_number','esic_number','uan_number']);
//                                     },
//                                     'single_payslip_empid' =>function($query){
//                                         $query->select(['user_id']);
//                                     },
//                                     'single_payslip_month' =>function($query) use($month , $year){
//                                         $query->whereMonth('payroll_date', $month)
//                                               ->whereYear('payroll_date', $year)
//                                               ->select(['payroll_date']);
//                                     },
//                                     'single_payslip_detail' => function($query) {
//                                             $query->select(['id','month_days as MONTH_DAYS','worked_Days as Worked_Days','lop as LOP','arrears_Days as ArrearS_Days','basic as BASIC','hra as HRA','spl_alw as SPL_ALW',
//                                                     'overtime as Overtime','travel_conveyance','total_earned_gross as TOTAL_EARNED_GROSS','prof_tax as PROF_TAX','income_tax','sal_adv as SAL_ADV','other_deduc as OTHER_DEDUC','total_deductions as TOTAL_DEDUCTIONS','epfr as EPFR','employee_esic as EMPLOYEE_ESIC',
//                                                     'net_take_home as NET_TAKE_HOME','employer_esi as EMPLOYER_ESI']);
//                                         },
//                                     ])
//                                     ->where('users.id','144')
//                                     ->get(['users.id','users.name','users.user_code','users.email']);

//   dd( $response['payslip_data']);
// $year='2022';
// $month='10';

//         $query_payslips = VmtEmployeePaySlipV2::leftjoin('vmt_emp_payroll','vmt_emp_payroll.id','=','vmt_employee_payslip_v2.emp_payroll_id')
//                                              ->leftjoin('vmt_payroll','vmt_payroll.id','=','vmt_emp_payroll.payroll_id')
//                                              ->leftjoin('users','users.id','=','vmt_emp_payroll.user_id')
//                                              ->whereYear('vmt_payroll.payroll_date', $year)
//                                              ->whereMonth('vmt_payroll.payroll_date',$month)
//                                             ->where('users.is_ssa','0')
//                                             ->where('users.active','1')
//                                             ->get(['payroll_date','users.name','users.id']);                                                                        // "max_loan_amount as max_eligible_amount",
// "loan_amt_interest as interest_rate",
// "deduction_starting_months",
// "max_tenure_months",
//                                                                         $multiple_months=array();

//                                                                         $user_id=auth()->user()->id;
//         $doj=Carbon::parse(VmtEmployee::where('userid', $user_id)->first()->doj);
//         $avaliable_int_loans=VmtInterestFreeLoanSettings::orderBy('min_month_served','DESC')->get();

//      $client_data = Users::where('id',auth()->user()->id)->first();

//             $loan_withinterest_setting_data =VmtLoanInterestSettings::get();

//             $loan_setting_count =count($loan_withinterest_setting_data);
//             for($i=0; $i<$loan_setting_count; $i++)
//             {
//             $deduction_months = array();

//             for($j=1; $j<=$loan_withinterest_setting_data[$i]->deduction_starting_months; $j++)
//             {
//                $deduction_months[]= Carbon::now()->addMonths($j)->format('Y-m-d');
//             }

//             $loan_withinterest_setting_data[$i]->deduction_starting_months = $deduction_months;
//            }
//             //array_push( $loan_withinterest_setting_data,$deduction_starting_months);

// dd( $loan_withinterest_setting_data );

//             $loan_withinterest_setting_data =VmtLoanInterestSettings::get();

//            foreach ($loan_withinterest_setting_data as $key => $singledata) {

// echo ($singledata['deduction_starting_months']);
//             $deduction_months = array();

//             for($j=1; $<=$singledata['deduction_starting_months']; $i++)
//             {
//                $deduction_months[]= Carbon::now()->addMonths($j)->format('Y-m-d');
//             }

//             $$singledata['deduction_starting_months']= $deduction_months;
//            }
//             //array_push( $loan_withinterest_setting_data,$deduction_starting_months);

// dd( $loan_withinterest_setting_data );

// $payroll_month=VmtPayroll::whereYear('payroll_date','2022')->groupby('payroll_date')->pluck('payroll_date');
//         for($i=0; $i < count($payroll_month); $i++)
//         {

//             $payroll_month[$i] = date("m",strtotime($payroll_month[$i]));
//         }
//         $payroll_available_months = array_unique($payroll_month->toArray());

// dd($payroll_available_months);

// $query_docs = User::whereIn('id',[174, 177, 179])->get();
// dd($query_docs);

// $timestamp = (strtotime('2023-03-01 08:56:04'));
// $date = date('Y-j-n', $timestamp);
// $time = date('H:i:s', $timestamp);
// echo ($date .'<br>'.$time)

// $attendanceCheckOut = \DB::table('vmt_staff_attenndance_device')
//                         ->select('user_Id', \DB::raw('MAX(date) as check_out_time'))
//                         ->whereDate('date', '2023-06-26')
//                         ->where('user_Id', 'PLIPL009')
//                         ->first(['check_out_time']);

//                         dd($attendanceCheckOut );

//dd($attendanceCheckOut );

//                     uploadDocument($client_id,$fileObject){

// try{
//         $emp_code = User::find($emp_id)->user_code;

//         $Client_logo= VmtClientMaster::where('client_id', $client_id);

//         //check if document already uploaded

//         }
//         else
//         {
//             $employee_documents = new VmtEmployeeDocuments;
//             $employee_documents->user_id = $emp_id;
//             $employee_documents->doc_id = $onboard_doc_id;
//         }

//         $date = date('d-m-Y_H-i-s');
//         $fileName =  str_replace(' ', '', $onboard_document_type).'_'.$emp_code.'_'.$date.'.'.$fileObject->extension();
//         $path = $emp_code.'/onboarding_documents';
//         $filePath = $fileObject->storeAs($path,$fileName, 'private');
//         $employee_documents->doc_url = $fileName;

//         $employee_documents_status = VmtEmployeeDocuments::where('user_id', $emp_id)
//                                                            ->where('doc_id',$onboard_doc_id);

//         if($employee_documents_status->exists() ){
//                 $employee_documents_status = $employee_documents_status->first()->status;
//            if($employee_documents_status == 'Approved')
//                 $employee_documents->status = $employee_documents_status;
//            else{
//             $employee_documents->status ='Pending';
//            }
//         }else{

//             $employee_documents->status = 'Pending';
//          }

//         $employee_documents->save();
//     }
//     catch(\Exception $e){
//         dd("Error :: uploadDocument() ".$e);
//     }

//     return "success";

// $flowCheck	="1";

// $assignment_period_year =	"2023";
// $calendar_type	="financial_year";
// $hidden_calendar_year=	"April+-+2022+to+March+-+2023";
// $frequency	="quarterly";
// $assignment_period_start=	"q3";
// $department=	"6";
// $employees =['246','247','248'];
// $reviewer[]="245";
// $hr_id	="245";
// $selected_kpi_form_id=	"1";

//     //$reviewerMailId  = VmtEmployee::join('vmt_employee_office_details',  'user_id', '=', 'vmt_employee_details.userid')->whereIn('userid', explode(',',$kpi_AssignedTable->reviewer_id))->pluck('officical_mail','userid')->toArray();
//      $assigneeName = User::whereIn('id',$employees)->pluck('name')->first();
//     //             $assignerName = User::where('id',auth::user()->id)->pluck('name')->first();
//                $comments_employee = '';
//     $login_Link = request()->getSchemeAndHttpHost();

//      $is_sent=\Mail::to('vvishva185@gmail.com')
//                         ->send(new VmtPMSMail_Assignee("none",$flowCheck,
//                                                        $assigneeName,
//                                                        $hidden_calendar_year." - ".strtoupper($assignment_period_start),
//                                                        'vishnu',
//                                                        $comments_employee,
//                                                        $login_Link));
// if($is_sent){
//     echo 'hii';
// }else{
//     echo 'bye';
// }
// $query_document =VmtDocuments::all();
//              $query_doc_id = array();
//           foreach ($query_document as $key => $Singledocid)
//             {
//                 $query_doc_id[] = $Singledocid;
//             }

//              $query_user_doc_id = array();
//           foreach ($query_doc_id as $key => $Singledocid)
//             {
//                 $query_user_doc_id[] = VmtEmployeeDocuments::where('user_id','236')->where('doc_id',$Singledocid['id'])->first();
//              }

//              dd(  $query_doc_id );
//              $reponse= array_diff($query_user_doc_id,$query_doc_id);

//     $query_document =VmtDocuments::all()->toarray();

//     $query_user_doc_id = VmtEmployeeDocuments::where('user_id','236')->get()->toarray();

//     $present_doc= $query_document->diff($query_user_doc_id);

//     $missing_doc=$query_document->diff($present_doc);
//  $emp_documents=array();
//  foreach ($present_doc as $key => $singledata) {

//      if($docid){
//         $emp_documents[$key]=
//         $emp_documents[$key]['document_name']=VmtDocuments::where('id',$singledata->id)->first()->document_name;
//      }else{
//         $emp_documents[$j]['document_name']=VmtDocuments::where('id',$singledocid)->first()->document_name;
//         $emp_documents[$j]['status']=null;
//      }
//      $i++;
//     }

//      $missing_doc_id= $query_document->diff($query_user_doc_id);
//      $present_doc_id= $query_document->diff($missing_doc);
//      $emp_documents=array();
//                $i=0;
//      foreach ($present_doc_id as $key => $singledocid) {
//              $emp_documents[$i]= VmtEmployeeDocuments::where('user_id','236')->where('doc_id',$singledocid)->first();
//              $emp_documents[$i]['document_name']=VmtDocuments::where('id',$singledocid)->first()->document_name;
//              $i++;
//            }
//            $j=$i;
//    foreach ($missing_doc_id as $key => $singledocid) {
//               $emp_documents[$j]['document_name']=VmtDocuments::where('id',$singledocid)->first()->document_name;
//               $emp_documents[$j]['status']=null;
//               $j++;
//          }

$gross = 50000;

$basic = ($gross / 100) * 60;

$hra = ($basic / 100) * 50;

$communication_allowance = 0;

$food_allowance = 0;

if ($gross > 40000) {
    $communication_allowance = 2000;
}

$leave_travel_allowance = 0;

if ($gross > 50000) {
    $leave_travel_allowance = 2000;
}

$special_allowance = $gross - ($basic + $hra + $communication_allowance + $leave_travel_allowance);

$epf_employer = 0;
$epf_employee = 0;

if ($gross - $hra > 15000) {
    $epf_employer = (15000 / 100) * 12;
    $epf_employee = (15000 / 100) * 12;
} else {
    $epf_employer = (($gross - $hra) / 100) * 12;
    $epf_employee = (($gross - $hra) / 100) * 12;
}

$esi_employer = 0;
$esi_employee = 0;

if ($gross > 21000) {
    $esi_employer = 0;
    $esi_employee = 0;
} else {
    $esi_employer = ($gross / 100) * 3.25;
    $esi_employee = ($gross / 100) * 0.75;
}
$insurance = 0;

$professional_tax = 208;

$ctc = $gross + $epf_employer + $esi_employer + $insurance;

$net_take_home = $gross - ($epf_employee + $esi_employee + $professional_tax);

// dd([ 'basic' =>$basic,
//      'hra'=> $hra,
//      'communication_allowance'=>$communication_allowance,
//      'leave_travel_allowance' =>$leave_travel_allowance,
//      'food_allowance' =>$food_allowance,
//      'special_allowance'=>$special_allowance,
//      'gross'=>$gross,
//      'epf_employer' =>  $epf_employer,
//      'esi_employer' =>$esi_employer,
//      'insurance '  =>$insurance,
//      'ctc' =>$ctc,
//      'epf_employee' =>$epf_employee ,
//      'esi_employee ' =>$esi_employee,
//      'professional_tax' =>$professional_tax,
//      'net_take_home' =>$net_take_home,

// ]);

// $anniversary_date = Carbon::now()->addDay()->format('m-d');;

// $users_With_anniversary = VmtEmployee::join('users','vmt_employee_details.userid','=','users.id')
//                                   ->join('vmt_employee_office_details','vmt_employee_office_details.user_id','=','users.id')
//                                   ->whereRaw("DATE_FORMAT(doj, '%m-%d') = '$anniversary_date'")
//                                   ->where('users.active','<>','-1')
//                                   ->get();

// dd($users_With_anniversary);
// $result = $date1->eq($date2);

// // dd($result);
// $employeeData =[
//     "employee_code" => "ENBL301",
//       "employee_name" => "Virat Ganesh",
//       "email" => "vishnu@abshrms.com",
//       "gender" => "male",
//       "doj" => 45171,
//       "location" => "Chennai",
//       "dob" => "09-01-2000",
//       "pan_no" => "FBVPD0808N",
//       "pan_ack" => 0.0,
//       "aadhar" => 823456789032.0,
//       "marital_status" => "unmarried",
//       "mobile_number" => 8056099319.0,
//       "bank_name" => "Axis bank",
//       "bank_ifsc" => "UTIB0000006",
//       "account_no" => 12234567932178.0,
//       "current_address" => "Tambaram Chennai-600045",
//       "permanent_address" => "Tambaram Chennai-600045",
//       "father_name" => "Singh Kumar",
//       "father_gender" => "Male",
//       "father_dob" => "09-10-1967",
//       "mother_name" => "Sakshi",
//       "mother_gender" => "Female",
//       "mother_dob" => "06-10-1967",
//       "spouse_name" => "jk",
//       "spouse_dob" => "09-09-2002",
//       "no_of_child" => 0.0,
//       "child_name" => 0.0,
//       "child_dob" => 0.0,
//       "department" => "HR",
//       "process" => "Operations",
//       "designation" => "HR Executive",
//       "cost_center" => 0.0,
//       "confirmation_period" => "30-09-2023",
//       "holiday_location" => "Chennai",
//       "l1_manager_code" => "BA001",
//       "l1_manager_name" => "Hemachandran",
//       "work_location" => "Chennai",
//       "official_mail" => "dondebijeff@gmail.com",
//       "official_mobile" => 8056099319.0,
//       "emp_notice" => 30,
//       "basic" => 12330,
//       "hra" => 12788,
//       "statutory_bonus" => 0.0,
//       "child_education_allowance" => 0.0,
//       "food_coupon" => 0.0,
//       "lta" => 0.0,
//       "special_allowance" => 12342,
//       "other_allowance" => 0.0,
//       "epf_employer_contribution" => 1800,
//       "esic_employer_contribution" => 0.0,
//       "insurance" => 0.0,
//       "graduity" => 0.0,
//       "epf_employee" => 1800,
//       "esic_employee" => 0.0,
//       "professional_tax" => 0.0,
//       "labour_welfare_fund" => 0.0,
//       "net_income" => 35000,
//       "uan_number" => 0.0,
//       "pf_applicable" => "Yes",
//       "esic_applicable" => "Yes",
//       "ptax_location" => 0.0,
//       "tax_regime" => "New",
//       "lwf_location" => 0.0,
//       "dearness_allowance" => 0.0,
//     ];

//  $empNameString  = $employeeData['employee_name'];
//         $filename = 'appoinment_letter_' . $empNameString . '_' . time() . '.pdf';
//         $data = $employeeData;
//         $data['basic_monthly'] = $employeeData['basic'];
//         $data['basic_yearly'] = intval($employeeData['basic']) * 12;
//         $data['hra_monthly'] = $employeeData['hra'];
//         $data['hra_yearly'] = intval($employeeData['hra']) * 12;
//         $data['spl_allowance_monthly'] = $employeeData['special_allowance'];
//         $data['spl_allowance_yearly'] = intval($employeeData['special_allowance']) * 12;
//         $data['gross_monthly'] = $employeeData["basic"] + $employeeData["hra"] + $employeeData["statutory_bonus"] + $employeeData["child_education_allowance"] + $employeeData["food_coupon"] + $employeeData["lta"] + $employeeData["special_allowance"] + $employeeData["other_allowance"];
//         $data['gross_yearly'] = intval($data['gross_monthly']) * 12;
//         $data['employer_epf_monthly'] = $employeeData['epf_employer_contribution'];
//         $data['employer_epf_yearly'] = intval($employeeData['epf_employer_contribution']) * 12;
//         $data['employer_esi_monthly'] = $employeeData['esic_employer_contribution'];
//         $data['employer_esi_yearly'] = intval($employeeData['esic_employer_contribution']) * 12;
//         $data['ctc_monthly'] = $data['gross_monthly'];
//         $data['ctc_yearly'] = intval($data['gross_monthly']) * 12;
//         $data['employee_epf_monthly'] =  $employeeData["epf_employer_contribution"];
//         $data['employee_epf_yearly'] = intval($employeeData["epf_employer_contribution"]) * 12;
//         $data['employer_pt_monthly'] = $employeeData["professional_tax"];
//         $data['employer_pt_yearly'] =  intval($employeeData["professional_tax"]) * 12;
//         $data['net_take_home_monthly'] = $employeeData["net_income"];
//         $data['net_take_home_yearly'] = intval($employeeData["net_income"]) * 12;

//         $VmtClientMaster = VmtClientMaster::first();
//         $image_view = url('/') . $VmtClientMaster->client_logo;
//         $appoinmentPath = "";

//        // if (fetchMasterConfigValue("can_send_appointmentletter_after_onboarding") == "true") {

//             //Fetch appointment letter based on client name
//             $client_name = str_replace(' ', '', sessionGetSelectedClientName());
//             //$client_name = Str::lower(str_replace(' ', '', getCurrentClientName()) );
//             //$viewfile_appointmentletter = 'vmt_appointment_templates.vmt_appointment_templates.appointmentletter_breezetech.blade.php';

//     //         //check if template exists
//     //         if (view()->exists($viewfile_appointmentletter)) {

//     //             $html =  view($viewfile_appointmentletter, compact('data'));

//     //         }
//     //    // }

//          $html = view('appointment_mail_templates.appointment_Letter_Priti_Sales');

// return $html;
//                 $options = new Options();
//                 $options->set('isHtml5ParserEnabled', true);
//                 $options->set('isRemoteEnabled', true);
//                 $pdf = new Dompdf($options);
//                 $pdf->loadhtml($html, 'UTF-8');
//                 $pdf->setPaper('A4', 'portrait');
//                 $pdf->render();
//                 $pdf->stream(['breezetech.pdf']);

// $data =numberToWord("123");
// dd(str_replace(" ","",$data));
//                 $docUploads =  $pdf->output();
//                  dd( $docUploads);
//         \File::put(public_path('appoinmentLetter/') . $filename, $docUploads);
//         $appoinmentPath = public_path('appoinmentLetter/') . $filename;
//     }
// }

// $notification_user = User::where('id', auth()->user()->id)->first();
// $message = "Employee Bulk OnBoard was Created   ";

// Notification::send($notification_user, new ViewNotification($message . $employeeData['employee_name']));
// $isSent    = \Mail::to($employeeData['email'])->send(new WelcomeMail($employeeData['employee_code'], 'Abs@123123', request()->getSchemeAndHttpHost(),  $appoinmentPath, $image_view));

// return $isSent;
//  }
// $comp_data = ['Basic',
// 'Dearness Allowance',
// 'Variable Dearness Allowance',
// 'House Rent Allowance',
// 'Child Education Allowance',
// 'Communication Allowance',
// 'Statutory Bonus',
// 'Food Allowance',
// 'Leave Travel Allowance',
// 'Special Allowance',
// 'Other Allowance',
// 'Washing Allowance',
// 'Uniform Allowance',
// 'Vehicle Reimbursement',
// 'Driver Salary',
// 'Fuel Reimbursement',
// 'Telephone Reimbursement',
// 'Overtime',
// 'Incentive',
// 'Other Earnings',
// 'Leave Encashment',
// 'Referral Bonus',
// 'Statutory Bonus',
// 'Ex-Gratia',
// 'Gift Payment',
// 'Attendance Bonus',
// 'Daily Allowance',
// 'EPF_Employer',
// 'Employer ESIC',
// 'Employer LWF',
// 'EPF_Employee',
// 'VPF_Employee',
// 'Employee ESIC',
// 'Professional Tax',
// 'Income Tax',
// 'Salary Advance',
// 'Medical Deductions',
// 'Canteen Deduction',
// 'Uniform Deduction',
// 'Loan Deductions',
// 'Other Deductions'];

// $comp_data = str_replace(" ","_",array_map('strtolower', $comp_data));

// $data =   [" 50% from CTC ",
//       "50% from Gross",
// "Based on MW Table",
// "Based on MW Table",
// "50% from Basic Salary",
// "200 Maximum, if the person married",
// "3000 Max",
// "If the Basic is Less then 21K then we can give this",
// "2200 Max",
// "10% from Basic Salary",
// "Open Amount",
// "Open Amount",
// "Open Amount",
// "Open Amount",
// "2400 Max",
// "900 Max",
// "3000 Max",
// "3000 Max",
// "Gross/Month Days/8*Overtime Hours*2 or Gross/Month Days/8*Overtime Hours*2 or Basic/Month Days/8*Overtime Hours*2 or Formula can be typed",
// "Open Amount",
// "Open Amount",
// "Open Amount",
// "Open Amount",
// "Open Amount",
// "Open Amount",
// "Open Amount",
// "Open Amount",
// "Open Amount",
// "Rule Given",
// "Rule Given",
// "Rule Given",
// "Rule Given",
// "Rule Given",
// "Rule Given",
// "From Table",
// "From Table",
// "Open Amount",
// "Open Amount",
// "Open Amount",
// "Open Amount",
// "Open Amount",
// "Open Amount",];

//  $array_data =array();
//  $i=1;
// foreach ($data as $key => $value) {
//     if(strpos($value, '%') !== false){
//         preg_match_all('/(\d+%)(?:\s*(?:from\s*)?)(CTC|Gross|Basic|Max)/i', $value, $calci_data, PREG_SET_ORDER);
//         foreach ($calci_data as $key => $single_calci_data) {
//             $array_data[$i]['value'] = $single_calci_data[1];
//             $array_data[$i]['action'] = $single_calci_data[2];
//             $array_data[$i]['comp_name'] =$comp_data[$i] ;
//            $i++;
//         }
//      }
//      else{
//         preg_match_all('/(\d+%)(?:\s*(?:from\s*)?)(CTC|Gross|Basic|Max)/i', $value, $calci_data, PREG_SET_ORDER);
//          foreach ($calci_data as $key => $single_calci_data) {
//             $array_data[$i]['value'] = $single_calci_data[1];
//             $array_data[$i]['action'] = $single_calci_data[2];
//             $array_data[$i]['comp_name'] =$comp_data[$i] ;
//            $i++;
//         }
//      }

// }

// //dd($array_data);

// // $inputSentence = "50% from Basic Salary";

//  $array_data =array();
//  $i=0;
// foreach ($data as $key => $value) {
//     if(strpos($value, '%') !== false){
//         preg_match_all('/(\d+%)(?:\s*(?:from\s*)?)(CTC|Gross|Basic|Max)/i', $value, $calci_data, PREG_SET_ORDER);
//         foreach ($calci_data as $key => $single_calci_data) {
//             $numericValue = rtrim($single_calci_data[1], '%');
//             $array_data[$i]['value'] = (float)($numericValue) / 100;;
//             $array_data[$i]['action'] = $single_calci_data[2];
//             $array_data[$i]['comp_name'] =$comp_data[$i] ;
//            $i++;
//         }
//      }
//      else{

//         preg_match_all('/(\d+ Max)/', $value, $calci_data, PREG_SET_ORDER);
//          foreach ($calci_data as $key => $single_calci_data) {

//             $array_data[$i]['value'] = $single_calci_data[1];
//             $array_data[$i]['action'] = "";
//             $array_data[$i]['comp_name'] =$comp_data[$i] ;
//            $i++;
//         }
//      }

// // foreach ($matches as $match) {
// //     $percentage = $match[1]."_".$match[2];
// // }
// // dd($matches);

//dd($array_data);

// // $pattern = '/\bBasic\s*(?:is)?\s*(Less\s*than|<)\s*(\d+K)\b/i';
// // preg_match($pattern, $input, $matches);

// // if (count($matches) > 0) {
// //     $condition = "basic " . $matches[1] . " " . $matches[2];
// //     echo $condition;
// // } else {
// //     echo "Pattern not found.";
// // }
// // $input = "50% from CTC or 50% from Gross";

// // $pattern = '/\(([^)]+)\s*<\s*(\d+)\)/';
// // preg_match_all($pattern, $input, $matches, PREG_SET_ORDER);

// // foreach ($matches as $match) {
// //     $condition = $match[1];
// //     $value = $match[2];
// //     echo "Condition: $condition Value: $value" . PHP_EOL;
// // }

// $inputSentence = "200 Max, if the person married";
// $pattern = '/(\d+)(?:\s*(?:from\s*)?)\s*(?:|Max|Maximum)./i';

// preg_match_all('/(\d+%)(?:\s*(?:Max\s*)?)(Maximum|Max)/i', $inputSentence, $calci_data, PREG_SET_ORDER);

// if (isset($matches[1])) {
//     $maxValue = (int)$matches[1];
//     echo  $maxValue;
// } else {
//     echo "No max value found.";
// }

// $sentence = "200 Maximum, if the person married";

// // Extract the maximum value using regular expression
// if (preg_match('/(\d+)\s*Maximum/', $sentence, $matches)) {
//     $maxValue = (int)$matches[1];
//     if ($maxValue <= 200) {
//         // Do something with the maximum value
//         echo "Maximum value is: " . $maxValue;
//     } else {
//         // Handle the case when the value is greater than 200
//         echo "Maximum value exceeds 200.";
//     }
// } else {
//     // Handle the case when the pattern is not found in the sentence
//     echo "Pattern not found.";
// }

// $sentence = "30000 Maximum, if the person married";
// $pattern = '/(\d+ Max)/';

// if (preg_match($pattern, $sentence, $matches)) {
//     dd($matches);
//     $result = Str::of($matches[0])->trim();
//     echo $result;
// } else {
//     // Pattern not found
//     echo "Pattern not found in the sentence.";
// }
// $sentence = "Basic is Less then 21K then we can give this";
// $pattern = '/(\d+)K/';
//     preg_match($pattern, $sentence, $matches);

//     if (isset($matches[1])) {
//         // Convert the extracted value to an integer and multiply by 1000
//         $numericValue = intval($matches[1]) * 1000;

//         // Replace the original sentence with the formatted result
//         $formattedSentence = str_replace($matches[0], "< $numericValue", $sentence);

//         dd($formattedSentence);
//     }


$inv_emp = VmtInvFEmpAssigned::pluck('user_id')->toArray();
$salary_data['headers'] = [];

$Employee_details = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
    ->leftjoin('vmt_employee_statutory_details', 'vmt_employee_statutory_details.user_id', '=', 'users.id')
    ->where('users.active', '1')
    //->where('users.client_id', $client_id)
    ->whereIn('users.id', $inv_emp)
    ->get(['users.id as user_id', 'users.user_code as Employee Code', 'users.name as Employee Name', 'vmt_employee_details.gender as Gender', 'vmt_employee_details.pan_number as PAN Number', 'vmt_employee_details.dob as Date Of Birth', 'vmt_employee_details.doj as Date Of Joining', 'vmt_employee_statutory_details.tax_regime as Tax Regime']);

 array_push($salary_data['headers'],"Employee Code","Employee Name","Gender","PAN Number","Date Of Birth","Date Of Joining","Tax Regime");
$v_form_template = [];
foreach ($Employee_details as $key => $single_user) {

    $employee_salary_details[$key]["Employee Code"] =$single_user['Employee Code'] ;
    $employee_salary_details[$key]["Employee Name"] =$single_user['Employee Name'] ;
    $employee_salary_details[$key]["Gender"] =$single_user['Gender'];
    $employee_salary_details[$key]["PAN Number"] =$single_user['PAN Number'];
    $employee_salary_details[$key]["Date Of Birth"] =$single_user['Date Of Birth'];
    $employee_salary_details[$key]["Date Of Joining"] =$single_user['Date Of Joining'];
    $employee_salary_details[$key]["Tax Regime"] =$single_user['Tax Regime'];

    $v_form_template[] = VmtInvFormSection::leftjoin('vmt_inv_section', 'vmt_inv_section.id', '=', 'vmt_inv_formsection.section_id')
        ->leftjoin('vmt_inv_section_group', 'vmt_inv_section_group.id', '=', 'vmt_inv_section.sectiongroup_id')
        ->leftjoin('vmt_inv_emp_formdata', 'vmt_inv_emp_formdata.fs_id', '=', 'vmt_inv_formsection.id')
        ->leftjoin('vmt_inv_f_emp_assigned', 'vmt_inv_f_emp_assigned.id', '=', 'vmt_inv_emp_formdata.f_emp_id')
        ->leftjoin('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'vmt_inv_f_emp_assigned.user_id')
        ->leftjoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'vmt_employee_compensatory_details.user_id')
        ->where('vmt_inv_f_emp_assigned.user_id', $single_user['user_id'])
        ->get(['vmt_inv_section_group.section_group', 'vmt_inv_section.particular', 'vmt_inv_section.max_amount', 'vmt_inv_emp_formdata.dec_amount', 'vmt_inv_emp_formdata.json_popups_value', 'vmt_employee_compensatory_details.gross', 'vmt_employee_compensatory_details.basic', 'vmt_inv_f_emp_assigned.regime', 'vmt_inv_f_emp_assigned.updated_at', 'vmt_employee_compensatory_details.hra', 'vmt_employee_compensatory_details.special_allowance', 'vmt_employee_compensatory_details.professional_tax', 'vmt_employee_compensatory_details.child_education_allowance', 'vmt_employee_compensatory_details.lta', 'vmt_employee_details.doj', 'vmt_employee_details.dob'])
        ->toArray();
}

//dd($v_form_template);
/*------------------------Take the code from here da simma frfc ---------------------------------*/

// $tax_reports_Section_column = [];
// $tax_reports_Excemption_column = [];
// $employee_section_details = [];
// $employee_excemption_details = [];

// foreach ($v_form_template as $form_key => $single_emp_form_data) {

//     foreach ($single_emp_form_data as $key => $single_user_data) {



//             if (!in_array($single_user_data['particular'], $tax_reports_Section_column) ) {

//                 array_push($tax_reports_Section_column, $single_user_data['particular']);
//                 array_push($salary_data['headers'], $single_user_data['particular'] );

//             }

//             $employee_salary_details[$form_key][$single_user_data['particular']] = $single_user_data['dec_amount'];
//             $employee_section_details[$form_key][$single_user_data['particular']] = $single_user_data['dec_amount'];

        }
    }
}


    if (!in_array("Section 80CCE Total",$tax_reports_Section_column )) {
            array_push($tax_reports_Section_column, 'Section 80CCE Total');
    }


     foreach ($v_form_template as $form_key => $single_emp_form_data) {
        foreach ($single_emp_form_data as $key => $single_user_data) {
         if (trim($single_user_data['section_group']) == 'Other Excemptions') {

//                 if (!in_array($single_user_data['particular'], $tax_reports_Excemption_column)) {

//                     array_push($tax_reports_Excemption_column, $single_user_data['particular']);
//                     array_push($salary_data['headers'], $single_user_data['particular']);
//                 }

//                 if ($single_user_data['dec_amount'] >= $single_user_data['max_amount']) {

//                     $employee_salary_details[$form_key][$single_user_data['particular']] = $single_user_data['max_amount'];
//                     $employee_excemption_details[$form_key][$single_user_data['particular']] = $single_user_data['max_amount'];
//                 } else {

                    $employee_salary_details[$form_key][$single_user_data['particular']] = $single_user_data['dec_amount'];
                    $employee_excemption_details[$form_key][$single_user_data['particular']] = $single_user_data['dec_amount'];
                }
            }
        }
}

if (!in_array('10.Aggregate of deductible amount under Chapter VI-A',$tax_reports_Excemption_column )) {

// array_push($tax_reports_Excemption_column, '10.Aggregate of deductible amount under Chapter VI-A');

// }

$section_count=0;


foreach ($employee_salary_details as $section_key => $single_section_data) {

    foreach ($tax_reports_Section_column as $key => $single_section_column) {

//         if (!in_array($single_section_column, array_keys($single_section_data))) {

//             $employee_salary_details[$section_key][$single_section_column] = 0;
//             $employee_section_details[$section_key][$single_section_column] = 0;
//         }

//     }

}


    // for ($i=0; $i < count($tax_reports_Section_column); $i++) {

    //     array_push($salary_data['headers'],$tax_reports_Section_column[$i]);
    // }
    // for ($i=0; $i < count($tax_reports_Excemption_column); $i++) {

    //     array_push($salary_data['headers'],$tax_reports_Excemption_column[$i]);
    // }

//     /*----------------------------------------------------------------------end--------------------------------------------------------*/

       dd($employee_salary_details,$salary_data['headers']);



?>
@endsection
