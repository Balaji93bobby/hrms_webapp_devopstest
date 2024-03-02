<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VmtEmployeeReimbursements;
use App\Models\User;
use App\Models\VmtDocuments;
use App\Models\VmtEmployeeDocuments;
use App\Models\VmtEmployeePayroll;
use App\Models\VmtClientMaster;
use App\Models\VmtPayroll;
use App\Models\VmtEmployeeWorkShifts;
use App\Models\VmtEmployeePaySlipV2;
use App\Models\VmtEmployeePaySlip;
use App\Models\VmtEmployeeLeaves;
use App\Models\VmtStaffAttendanceDevice;
use App\Models\VmtEmployee;
use App\Models\VmtEmployeeStatutoryDetails;
use App\Models\VmtBloodGroup;
use App\Models\VmtMaritalStatus;
use App\Models\Bank;
use App\Models\VmtOrgTimePeriod;
use App\Models\AbsSalaryProjection;
use App\Models\abs;
use App\Models\Department;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\Compensatory;
use App\Models\VmtEmployeeFamilyDetails;
use App\Models\VmtWorkShifts;
use App\Imports\VmtMasterImport;
use App\Mail\VmtAbsentMail_Regularization;
use App\Models\VmtEmployeeAbsentRegularization;
use App\Models\VmtEmpSubModules;
use App\Models\VmtPMS_KPIFormAssignedModel;
use App\Models\VmtPMS_KPIFormModel;
use App\Models\VmtPMS_KPIFormDetailsModel;
use App\Models\VmtPMS_KPIFormReviewsModel;
use App\Models\VmtPmsAssignmentV3;
use App\Models\VmtPmsKpiFormAssignedV3;
use App\Models\VmtPmsKpiFormDetailsV3;
use App\Models\VmtPMSassignment_settings_v3;
use App\Models\VmtPmsKpiFormReviewsV3;
use App\Models\VmtPmsKpiFormV3;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Arr;

use function PHPUnit\Framework\returnSelf;

class VmtCorrectionController extends Controller
{
    public function processsExpense(Request $request)
    {
        $reimbursement_details = VmtEmployeeReimbursements::select('id', 'vehicle_type_id', 'distance_travelled', 'total_expenses')
            ->get();
        foreach ($reimbursement_details as $single_details) {
            if ($single_details->vehicle_type_id == 1) {
                $totalExpense = 3.5 * $single_details->distance_travelled;
                $UpdateDetails = VmtEmployeeReimbursements::where('id', '=', $single_details->id)->first();
                $UpdateDetails->total_expenses = $totalExpense;
                $UpdateDetails->save();
            } else if ($single_details->vehicle_type_id == 2) {
                $totalExpense = 6 * $single_details->distance_travelled;
                $UpdateDetails = VmtEmployeeReimbursements::where('id', '=', $single_details->id)->first();
                $UpdateDetails->total_expenses = $totalExpense;
                $UpdateDetails->save();
                // dd('---------------');

                //  dd( $single_details);
            }
        }
        return $reimbursement_details;
    }

    public function addingReimbursementsDataForSpecificMonth(Request $request)
    {
        $existing_data = VmtEmployeeReimbursements::where('user_id', $request->user_id)
            ->whereMonth('date', $request->month)
            ->get()->toArray();
        $response = array();
        foreach ($existing_data as $single_data) {
            try {
                $new_record = new VmtEmployeeReimbursements;
                $new_record->user_id = $single_data['user_id'];
                $new_record->reimbursement_type_id = $single_data['reimbursement_type_id'];
                $new_record->date = Carbon::parse($single_data['date'])->addMonth()->toDateString();
                $new_record->reviewer_id = $single_data['reviewer_id'];
                $new_record->status = 'Pending';
                $new_record->from = $single_data['from'];
                $new_record->to = $single_data['to'];
                $new_record->vehicle_type_id = $single_data['vehicle_type_id'];
                $new_record->distance_travelled = $single_data['distance_travelled'];
                $new_record->total_expenses = $single_data['total_expenses'];
                $new_record->save();
                $response = array_merge($response, array(Carbon::parse($single_data['date'])->addMonth()->toDateString() => $new_record->toArray()));
            } catch (\Exception $e) {
                dd($e);
            }
        }

        return $response;
    }
    public function checkallemployeeonboardingstatus()
    {

        $query_all_users_details = User::get();
        try {
            foreach ($query_all_users_details as $single_user_data) {
                //get the mandatory document id
                $mandatory_doc_ids = VmtDocuments::where('is_mandatory', '1')->pluck('id');

                //get the employees uploaded documents mandatory id
                $user_uploaded_docs_ids = VmtEmployeeDocuments::whereIn('doc_id', $mandatory_doc_ids)
                    ->where('vmt_employee_documents.user_id', $single_user_data->id)
                    ->pluck('doc_id');

                if (count($mandatory_doc_ids) == count($user_uploaded_docs_ids)) {
                    //set the onboard status to 1
                    $currentUser = User::where('id', $single_user_data->id)->first();
                    $currentUser->is_onboarded = '1';
                    $currentUser->save();
                }
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function addAllEmployeePayslipDetails()
    {

        /*Get all employee payslip details */

        $query_all_payslip = VmtEmployeePaySlip::all();

        /* save single payrollmonth in vmt_payroll*/
        $emp_payroll_month = VmtEmployeePaySlip::whereYear('created_at', '2022')->orwhereYear('created_at', '2023')->distinct('created_at')->orderBy('PAYROLL_MONTH', 'ASC')->pluck('PAYROLL_MONTH');

        $client_details_id = VmtClientMaster::get("id");

        foreach ($client_details_id as $key => $singleclient) {

            foreach ($emp_payroll_month as $key => $singlepayrollmonth) {
                $Payroll_data = VmtPayroll::where('client_id', $singleclient->id)->where('payroll_date', $singlepayrollmonth)->first();
                if (empty($Payroll_data)) {
                    $query_payroll = new Vmtpayroll;
                    $query_payroll->client_id = $singleclient->id;
                    $query_payroll->payroll_date = $singlepayrollmonth;
                    $query_payroll->save();
                }
            }
        }



        /* save user id and payroll id in the table vmt_emp_payroll*/
        foreach ($query_all_payslip as $key => $singleuserdata) {
            $client_id = User::where('id', $singleuserdata->user_id)->first()->client_id;
            $payroll_id = VmtPayroll::where('payroll_date', $singleuserdata->PAYROLL_MONTH)
                ->where('client_id', $client_id)->first()->id;
            $emp_payroll_data = VmtEmployeePayroll::where('payroll_id', $payroll_id)->where('user_id', $singleuserdata->user_id)->first();
            if (empty($emp_payroll_data)) {
                $query_payroll_data = new VmtEmployeePayroll;
                $query_payroll_data->user_id = $singleuserdata->user_id;
                $query_payroll_data->payroll_id = $payroll_id;
                $query_payroll_data->save();
            }
        }
        /*save all employee payslip details in vmt_employee_payslipv2 */

        foreach ($query_all_payslip as $key => $singlepayslipdetails) {

            $client_id = User::where('id', $singlepayslipdetails->user_id)->first()->client_id;
            $payroll_id = VmtPayroll::where('payroll_date', $singlepayslipdetails->PAYROLL_MONTH)
                ->where('client_id', $client_id)->first()->id;
            $emp_payroll_id = VmtEmployeePayroll::where('user_id', $singlepayslipdetails->user_id)->where('payroll_id', $payroll_id)->first()->id;

            /*get payroll id from vmt_emp_payroll in order to filter payroll_date and find emp_payroll_id */
            $emp_payslip_data = VmtEmployeePaySlipV2::where('emp_payroll_id', $emp_payroll_id)->first();
            if (empty($emp_payslip_data)) {
                $emppayslip = new VmtEmployeePaySlipV2;
                $emppayslip->emp_payroll_id = $emp_payroll_id;
                $emppayslip->basic = $singlepayslipdetails->BASIC;
                $emppayslip->hra = $singlepayslipdetails->HRA;
                $emppayslip->child_edu_allowance = $singlepayslipdetails->CHILD_EDU_ALLOWANCE;
                $emppayslip->spl_alw = $singlepayslipdetails->SPL_ALW;
                $emppayslip->total_fixed_gross = $singlepayslipdetails->TOTAL_FIXED_GROSS;
                $emppayslip->month_days = $singlepayslipdetails->MONTH_DAYS;
                $emppayslip->worked_Days = $singlepayslipdetails->Worked_Days;
                $emppayslip->arrears_Days = $singlepayslipdetails->Arrears_Days;
                $emppayslip->lop = $singlepayslipdetails->LOP;
                $emppayslip->earned_basic = $singlepayslipdetails->Earned_BASIC;
                $emppayslip->basic_arrear = $singlepayslipdetails->BASIC_ARREAR;
                $emppayslip->earned_hra = $singlepayslipdetails->Earned_HRA;
                $emppayslip->hra_arrear = $singlepayslipdetails->HRA_ARREAR;
                $emppayslip->earned_child_edu_allowance = $singlepayslipdetails->Earned_CHILD_EDU_ALLOWANCE;
                $emppayslip->child_edu_allowance_arrear = $singlepayslipdetails->CHILD_EDU_ALLOWANCE_ARREAR;
                $emppayslip->earned_spl_alw = $singlepayslipdetails->Earned_SPL_ALW;
                $emppayslip->spl_alw_arrear = $singlepayslipdetails->SPL_ALW_ARREAR;
                $emppayslip->overtime = $singlepayslipdetails->Overtime;
                $emppayslip->total_earned_gross = $singlepayslipdetails->TOTAL_EARNED_GROSS;
                $emppayslip->pf_wages = $singlepayslipdetails->PF_WAGES;
                $emppayslip->pf_wages_arrear = $singlepayslipdetails->PF_WAGES_ARREAR_EPFR;
                $emppayslip->epfr = $singlepayslipdetails->EPFR;
                $emppayslip->epfr_arrear = $singlepayslipdetails->EPFR_ARREAR;
                $emppayslip->edli_charges = $singlepayslipdetails->EDLI_CHARGES;
                $emppayslip->edli_charges_arrears = $singlepayslipdetails->EDLI_CHARGES_ARREARS;
                $emppayslip->pf_admin_charges = $singlepayslipdetails->PF_ADMIN_CHARGES;
                $emppayslip->pf_admin_charges_arrears = $singlepayslipdetails->PF_ADMIN_CHARGES_ARREARS;
                $emppayslip->employer_esi = $singlepayslipdetails->EMPLOYER_ESI;
                $emppayslip->employer_lwf = $singlepayslipdetails->Employer_LWF;
                $emppayslip->ctc = $singlepayslipdetails->CTC;
                $emppayslip->epf_ee = $singlepayslipdetails->EPF_EE;
                $emppayslip->epf_ee_arrear = $singlepayslipdetails->EPF_EE_ARREAR;
                $emppayslip->employee_esic = $singlepayslipdetails->EMPLOYEE_ESIC;
                $emppayslip->prof_tax = $singlepayslipdetails->PROF_TAX;
                $emppayslip->income_tax = $singlepayslipdetails->income_tax;
                $emppayslip->sal_adv = $singlepayslipdetails->SAL_ADV;
                $emppayslip->canteen_dedn = $singlepayslipdetails->CANTEEN_DEDN;
                $emppayslip->other_deduc = $singlepayslipdetails->OTHER_DEDUC;
                $emppayslip->lwf = $singlepayslipdetails->LWF;
                $emppayslip->total_deductions = $singlepayslipdetails->TOTAL_DEDUCTIONS;
                $emppayslip->net_take_home = $singlepayslipdetails->NET_TAKE_HOME;
                $emppayslip->rupees = $singlepayslipdetails->Rupees;
                $emppayslip->el_opn_bal = $singlepayslipdetails->EL_Opn_Bal;
                $emppayslip->availed_el = $singlepayslipdetails->Availed_EL;
                $emppayslip->balance_el = $singlepayslipdetails->Balance_EL;
                $emppayslip->sl_opn_bal = $singlepayslipdetails->SL_Opn_Bal;
                $emppayslip->availed_sl = $singlepayslipdetails->Availed_SL;
                $emppayslip->balance_sl = $singlepayslipdetails->Balance_SL;
                $emppayslip->greetings = $singlepayslipdetails->Greetings;
                $emppayslip->travel_conveyance = $singlepayslipdetails->travel_conveyance;
                $emppayslip->other_earnings = $singlepayslipdetails->other_earnings;
                $emppayslip->save();
            }
        }
    }

    public function addElbalancewithjsonString(Request $request)
    {
        $data = '[{"user_code": "DM001","el_balance": 15},{ "user_code": "DM002", "el_balance": 15},
        {
         "user_code": "DM003",
         "el_balance": 15
        },
        {
         "user_code": "DM004",
         "el_balance": 15
        },
        {
         "user_code": "DM006",
         "el_balance": 5.5
        },
        {
         "user_code": "DM007",
         "el_balance": 6
        },
        {
         "user_code": "DM009",
         "el_balance": 10.5
        },
        {
         "user_code": "DM012",
         "el_balance": 8.5
        },
        {
         "user_code": "DM016",
         "el_balance": 15
        },
        {
         "user_code": "DM018",
         "el_balance": 6
        },
        {
         "user_code": "DM019",
         "el_balance": 9.5
        },
        {
         "user_code": "DM021",
         "el_balance": 1
        },
        {
         "user_code": "DM022",
         "el_balance": 5
        },
        {
         "user_code": "DM024",
         "el_balance": 9
        },
        {
         "user_code": "DM026",
         "el_balance": 8.5
        },
        {
         "user_code": "DM028",
         "el_balance": 6
        },
        {
         "user_code": "DM029",
         "el_balance": 9
        },
        {
         "user_code": "DM032",
         "el_balance": 5
        },
        {
         "user_code": "DM034",
         "el_balance": 12
        },
        {
         "user_code": "DM038",
         "el_balance": 9.5
        },
        {
         "user_code": "DM045",
         "el_balance": 6.5
        },
        {
         "user_code": "DM054",
         "el_balance": 15
        },
        {
         "user_code": "DM059",
         "el_balance": 5
        },
        {
         "user_code": "DM069",
         "el_balance": 13
        },
        {
         "user_code": "DM071",
         "el_balance": 11
        },
        {
         "user_code": "DM079",
         "el_balance": 8.5
        },
        {
         "user_code": "DM088",
         "el_balance": 6
        },
        {
         "user_code": "DM091",
         "el_balance": 3
        },
        {
         "user_code": "DM094",
         "el_balance": 8
        },
        {
         "user_code": "DM095",
         "el_balance": 7
        },
        {
         "user_code": "DM101",
         "el_balance": 5
        },
        {
         "user_code": "DM103",
         "el_balance": 6
        },
        {
         "user_code": "DM104",
         "el_balance": 5
        },
        {
         "user_code": "DM106",
         "el_balance": 9
        },
        {
         "user_code": "DM107",
         "el_balance": 4
        },
        {
         "user_code": "DM109",
         "el_balance": 8
        },
        {
         "user_code": "DM110",
         "el_balance": 7
        },
        {
         "user_code": "DM112",
         "el_balance": 14
        },
        {
         "user_code": "DM113",
         "el_balance": 6
        },
        {
         "user_code": "DM115",
         "el_balance": 7
        },
        {
         "user_code": "DM117",
         "el_balance": 2
        },
        {
         "user_code": "DM118",
         "el_balance": 12.5
        },
        {
         "user_code": "DM120",
         "el_balance": 9
        },
        {
         "user_code": "DM122",
         "el_balance": 6
        },
        {
         "user_code": "DM123",
         "el_balance": 6
        },
        {
         "user_code": "DM124",
         "el_balance": 7
        },
        {
         "user_code": "DM125",
         "el_balance": 5
        },
        {
         "user_code": "DM127",
         "el_balance": 8.5
        },
        {
         "user_code": "DM128",
         "el_balance": 6
        },
        {
         "user_code": "DM131",
         "el_balance": 5
        },
        {
         "user_code": "DM134",
         "el_balance": 6
        },
        {
         "user_code": "DM140",
         "el_balance": 7
        },
        {
         "user_code": "DM141",
         "el_balance": 8.5
        },
        {
         "user_code": "DM145",
         "el_balance": 9
        },
        {
         "user_code": "DM146",
         "el_balance": 7
        },
        {
         "user_code": "DM148",
         "el_balance": 9
        },
        {
         "user_code": "DM149",
         "el_balance": 10
        },
        {
         "user_code": "DM150",
         "el_balance": 8
        },
        {
         "user_code": "DM151",
         "el_balance": 5.5
        },
        {
         "user_code": "DM153",
         "el_balance": 8
        },
        {
         "user_code": "DM154",
         "el_balance": 6
        },
        {
         "user_code": "DM156",
         "el_balance": 9
        },
        {
         "user_code": "DM159",
         "el_balance": 5
        }
       ]';

        $data = preg_replace('/\s+/', '', $data);
        $el_balance_json = json_decode($data, true);
        $leave_type_id = 1;
        foreach ($el_balance_json as $single_user) {
            $user_id = User::where('user_code', $single_user['user_code'])->first();
            if ($user_id == null) {
                dd($single_user['user_code'] . ' does not exists in database');
            } else {

                try {


                    $employee_leave = new VmtEmployeeLeaves;
                    $employee_leave->user_id = $user_id->id;
                    $employee_leave->leave_type_id = $leave_type_id;
                    $employee_leave->start_date = '2022-06-01';
                    $employee_leave->end_date = '2022-06-10';
                    $employee_leave->total_leave_datetime = $single_user['el_balance'];
                    $employee_leave->status = 'Approved';
                    $employee_leave->save();
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            }
        }

        return 'Leave Balance Added Sucessfully';
    }

    public function changeAttendanceBioMatricIdToHrmsUserid(Request $request)
    {
        $dunamis = '[{"attendance_id":"DMC026","user_id": "DM161"},{"attendance_id": "DMC027","user_id": "DM162"},{ "attendance_id": "DMC028", "user_id": "DM163"},
{"attendance_id": "DMC032","user_id":"DM165"},{"attendance_id": "DMC034", "user_id": "DM166"},{"attendance_id": "DMC035", "user_id": "DM167"},{"attendance_id": "DMC041", "user_id": "DM169"},
{"attendance_id": "DMC042","user_id": "DM170"},{"attendance_id": "DMC049","user_id": "DM172"},{"attendance_id": "DMC050","user_id": "DM173"},{ "attendance_id": "DMC051","user_id": "DM175"},
{"attendance_id": "DMC053","user_id": "DM174"},{"attendance_id": "DMC054","user_id": "DM176"},{"attendance_id": "DMC056","user_id": "DM177"}, {"attendance_id": "DMC057","user_id": "DM178"},
{"attendance_id": "DMC062","user_id": "DM179"},{"attendance_id": "DMC063","user_id": "DM180"},{ "attendance_id": "DMC064", "user_id": "DM181"},{ "attendance_id": "DMC066", "user_id": "DM182"},
{"attendance_id": "DMC65","user_id": "DM183"},{"attendance_id": "DMC067","user_id": "DM184"},{"attendance_id": "DMC078","user_id": "DM185"},{"attendance_id": "DMC084","user_id": "DM190"},
{"attendance_id": "DMC079","user_id": "DM188"},{"attendance_id": "DMC077","user_id": "DM187" },{"attendance_id": "DMC083","user_id": "DM189"},{"attendance_id": "DMC087","user_id": "DM192"},
{"attendance_id": "DMC088","user_id": "DM193"},{"attendance_id": "DMC090","user_id": "DM194"},{"attendance_id": "DMC091", "user_id": "DM195"},{"attendance_id": "DMC093","user_id": "DM196"},
{"attendance_id": "DMC095", "user_id": "DM197"},{"attendance_id": "DMC101","user_id": "DM198"},{"attendance_id": "DMC102","user_id": "DM199"},{"attendance_id": "DMC103","user_id": "DM200"},
{"attendance_id": "DMC106","user_id": "DM201"},{"attendance_id": "DMC107","user_id": "DM202"},{"attendance_id": "DMC108","user_id": "DM203" },{"attendance_id": "DMC109","user_id": "DM204"},
{"attendance_id": "DMC115", "user_id": "DM205"},{ "attendance_id": "DMC117","user_id": "DM206"},{"attendance_id": "DMC118","user_id": "DM207"},{"attendance_id": "DMC119","user_id": "DM208"},
{"attendance_id": "DMC121","user_id": "DM209"},{"attendance_id": "DMC122","user_id": "DM210"},{"attendance_id": "DMC123","user_id": "DM211"},{"attendance_id": "DMC126","user_id": "DM212" },
{"attendance_id": "DMC28","user_id": "DM213"},{"attendance_id": "DMC129","user_id": "DM214"},{"attendance_id": "DMC130","user_id": "DM215"},{"attendance_id": "ABS1008","user_id": "ABS1006"},
{"attendance_id": "Jude Ashi","user_id": "ABS1033"},{"attendance_id": "Michael G","user_id": "ABS1032"},{"attendance_id": "DMC086","user_id": "DM217"},{"attendance_id": "DMC089","user_id": "DM218"},
{"attendance_id": "DMC094","user_id": "DM219"},{"attendance_id": "DMC097","user_id": "DM220"},{"attendance_id": "DMC124","user_id": "DM221"},{"attendance_id": "DMC114","user_id": "DM224"},
{"attendance_id": "DMC139","user_id": "DM225"},{"attendance_id": "DMC135","user_id": "DM222"},{"attendance_id": "DMC136","user_id": "DM223"},{"attendance_id": "DMC110","user_id": "DM226"},
{"attendance_id": "DMC144","user_id": "DM227"},{"attendance_id": "DMC145","user_id": "DM228"},{"attendance_id": "DMC147","user_id": "DM229"},{"attendance_id": "DMC158","user_id": "DM230"},
{"attendance_id": "DMC161","user_id": "DM231"},{"attendance_id": "DMC164","user_id": "DM232"},{"attendance_id": "DMC165","user_id": "DM233"},{"attendance_id": "DMC167","user_id": "DM234"},
{"attendance_id": "DMC168","user_id": "DM235"},{"attendance_id": "DMC139","user_id": "DM223"},{"attendance_id": "Intern","user_id": "ABSIN1005"},{"attendance_id": "Deepanraj","user_id": "ABSIN1004"},
{"attendance_id": "Internshi","user_id": "ABS1030"}]';




        //Removing Extra Spaace and white space in string
        // $dunamis = preg_replace('/\s+/', '', $dunamis);
        $dunamis = json_decode($dunamis, true);
        //dd($dunamis);
        $not_existed_user = array('The Give User IDS Does Not Exists In DataBase Please Check Ur Json data');
        $not_existed_attedance_id = array('The Give Attendance IDS Does Not Exists In DataBase Please Check Ur Json data');
        $update_ids = array('Scuessfully Updated');
        foreach ($dunamis as $single_id) {
            if (User::where('user_code', $single_id['user_id'])->exists()) {
                if (VmtStaffAttendanceDevice::where('user_Id', $single_id['attendance_id'])->exists()) {

                    try {
                        $staff_attedance = VmtStaffAttendanceDevice::where('user_Id', $single_id['attendance_id'])
                            ->update(['user_Id' => $single_id['user_id']]);
                        array_push($update_ids, $single_id['user_id']);
                    } catch (\Exception $e) {
                        return $e->getMessage();
                    }
                } else {
                    array_push($not_existed_attedance_id, $single_id['attendance_id']);
                }
            } else {
                array_push($not_existed_user, $single_id['user_id']);
            }
        }

        return response()->json([
            'not_existed_user' => $not_existed_user,
            'not_existed_attedance_id' => $not_existed_attedance_id,
            'update_ids' => $update_ids
        ]);
    }


    //Adding Work Shift for dunamis
    public function addingWorkShiftForAllEmployees(Request $request)
    {
        $number_of_flexi_shift = 3;
        $all_employees = User::where('is_ssa', 0)->get();
        foreach ($all_employees as $single_employee) {
            if (
                $single_employee->user_code == 'DM054' || $single_employee->user_code == 'DM145' || $single_employee->user_code == 'DM178' ||
                $single_employee->user_code == 'DM176' || $single_employee->user_code == 'DM183'
            ) {
                try {
                    $employee_work_shift = new VmtEmployeeWorkShifts;
                    $employee_work_shift->user_id = $single_employee->id;
                    $employee_work_shift->work_shift_id = 2;
                    $employee_work_shift->is_active = 1;
                    $employee_work_shift->flexi_shift_status = 0;
                    $employee_work_shift->save();
                } catch (Exception $e) {
                    dd($e->getMessage());
                }
            } else if ($single_employee->user_code == 'DM109') {
                try {
                    $employee_work_shift = new VmtEmployeeWorkShifts;
                    $employee_work_shift->user_id = $single_employee->id;
                    $employee_work_shift->work_shift_id = 3;
                    $employee_work_shift->is_active = 1;
                    $employee_work_shift->flexi_shift_status = 0;
                    $employee_work_shift->save();
                } catch (Exception $e) {
                    dd($e->getMessage());
                }
            } else if (
                $single_employee->user_code == 'DM182' || $single_employee->user_code == 'DM150' || $single_employee->user_code == 'DM179' || $single_employee->user_code == 'DM095' ||
                $single_employee->user_code == 'DMC101' || $single_employee->user_code == 'DMC136' || $single_employee->user_code == 'DMC133' || $single_employee->user_code == 'DMC129' || $single_employee->user_code == 'DM019' ||
                $single_employee->user_code == 'DM165' || $single_employee->user_code == 'DM153' || $single_employee->user_code == 'DM170' || $single_employee->user_code == 'DMC069' || $single_employee->user_code == 'DM045'
            ) {
                for ($i = 1; $i <= $number_of_flexi_shift; $i++) {
                    try {
                        $employee_work_shift = new VmtEmployeeWorkShifts;
                        $employee_work_shift->user_id = $single_employee->id;
                        $employee_work_shift->work_shift_id = VmtWorkShifts::where('shift_name', 'Shift ' . $i)->first('id')->id;
                        $employee_work_shift->is_active = 1;
                        $employee_work_shift->flexi_shift_status = 1;
                        $employee_work_shift->save();
                    } catch (Exception $e) {
                        dd($e->getMessage());
                    }
                }
            } else {
                try {
                    $employee_work_shift = new VmtEmployeeWorkShifts;
                    $employee_work_shift->user_id = $single_employee->id;
                    $employee_work_shift->work_shift_id = 1;
                    $employee_work_shift->is_active = 1;
                    $employee_work_shift->flexi_shift_status = 0;
                    $employee_work_shift->save();
                } catch (Exception $e) {
                    dd($e->getMessage());
                }
            }
        }

        return "Employee Work Shift Added";
    }
    //update all employee master data

    public function updateMasterdataUploads()
    {

        return view('vmt_MasterEmployeedata_Upload');
    }

    public function importMasetrEmployeesExcelData(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            ['file' => 'required|file|mimes:xls,xlsx'],
            ['required' => 'The :attribute is required.']
        );


        if ($validator->passes()) {

            $importDataArry = \Excel::toArray(new VmtMasterImport, request()->file('file'));
            //DD($importDataArry );
            return $this->storeMasterdEmployeesData($importDataArry);
        } else {
            $data['failed'] = $validator->errors()->all();
            return response()->json($data);
        }
    }

    public function storeMasterdEmployeesData(Request $request)
    {
        $data = $request->all();

        ini_set('max_execution_time', 300);
        //For output jsonresponse
        $data_array = [];
        $isAllRecordsValid = true;
        $modified_data = array();


        foreach ($data as $key => $excelRowdata) {
            $trimmedArray = array_map('trim', str_replace('(dd-mmm-yyyy)',' ', array_keys($excelRowdata)));

            $processed_data = str_replace(array('(dd-mmm-yyyy)',' '),array(' ', '_'), $trimmedArray);
            $processed_array_values = str_replace('-',null,array_values($excelRowdata));
           // $processed_data=array_map('trim', $processed_data);
            $Emp_data = array_combine(array_map('strtolower', $processed_data), $processed_array_values);

            array_push($modified_data, $Emp_data);
        }
//dd($modified_data);
        $corrected_data = $modified_data;

        foreach ($corrected_data as &$Single_data) {

            if (array_key_exists('date_of_birth', $Single_data) && is_int($Single_data['date_of_birth'])) {

                $Single_data['date_of_birth'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Single_data['date_of_birth'])->format('Y-m-d');
            }
            if (array_key_exists('date_of_joined', $Single_data) && is_int($Single_data['date_of_joined'])) {

                $Single_data['date_of_joined'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Single_data['date_of_joined'])->format('Y-m-d');

            }
            if (array_key_exists('last_working_day', $Single_data) && is_int($Single_data['last_working_day'])) {

                $Single_data['last_working_day'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Single_data['last_working_day'])->format('Y-m-d');

            }
            if (array_key_exists('mother_dob', $Single_data) && is_int($Single_data['mother_dob'])) {

                $Single_data['mother_dob'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Single_data['mother_dob'])->format('Y-m-d');

            }
            if (array_key_exists('mother_dob', $Single_data) && is_int($Single_data['mother_dob'])) {

                $Single_data['mother_dob'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Single_data['mother_dob'])->format('Y-m-d');

            }
            if (array_key_exists('spouse_dob', $Single_data) && is_int($Single_data['spouse_dob'])) {

                $Single_data['spouse_dob'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Single_data['spouse_dob'])->format('Y-m-d');

            }

            if (array_key_exists('marriage_date', $Single_data) && is_int($Single_data['marriage_date'])) {

                $Single_data['marriage_date'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Single_data['marriage_date'])->format('Y-m-d');

            }
            if (array_key_exists('child_1_dob', $Single_data) && is_int($Single_data['child_1_dob'])) {

                $Single_data['child_1_dob'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Single_data['child_1_dob'])->format('Y-m-d');

            }
            if (array_key_exists('child_2_dob', $Single_data) && is_int($Single_data['child_2_dob'])) {

                $Single_data['child_2_dob'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Single_data['child_2_dob'])->format('Y-m-d');

            }
        }
        unset($Single_data);


        //dd($corrected_data);
        $rules = [];
        $responseJSON = [
            'status' => 'none',
            'message' => 'none',
            'data' => [],
        ];

        // $excelRowdata = $data[0][0];
        $excelRowdata_row = $corrected_data;

        $currentRowInExcel = 0;
        if (empty($excelRowdata_row)) {
            return $rowdata_response = [
                'status' => 'failure',
                'message' => 'Please fill the excel',
            ];
        } else {
            // foreach ($excelRowdata_row as $key => $excelRowdata) {

            //     $currentRowInExcel++;

            //     //Validation
            //     $rules = [
            //         'employee_code' => 'required|exists:users,user_code',
            //         'name' => 'required|regex:/(^([a-zA-z. ]+)(\d+)?$)/u',
            //         'email' => 'nullable',
            //         'doj' => 'nullable',
            //         'dob' => 'nullable',
            //         'epf_number' => 'nullable|required_unless:epf_number,!=,NULL',
            //         'esic_number' => 'nullable|required_unless:esic_number,!=,NULL',
            //         'uan_number' => 'nullable|required_unless:uan_number,!=,NULL',
            //         //'pan_number' => 'nullable|required_unless:pan_number,!=,null|regex:/(^([A-Z]){3}P([A-Z]){1}([0-9]){4}([A-Z]){1}$)/u',
            //         'pan_number' => [
            //             'nullable',
            //             function ($attribute, $value, $fail) {

            //                 if ($value !== 'NULL') {
            //                     $result = preg_match("/(^([A-Z]){3}P([A-Z]){1}([0-9]){4}([A-Z]){1}$)/u", $value);
            //                     if (!$result) {
            //                         $fail($value . '<b> : ' . $attribute . ' is invalid');
            //                     }
            //                 }
            //             },
            //         ],
            //         //'aadhar_number' => 'nullable|required_unless:aadhar_number,!=,NULL&regex:/(^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$)/u',
            //         'aadhar_number' => [
            //             'nullable',
            //             function ($attribute, $value, $fail) {

            //                 if ($value !== 'NULL') {
            //                     $result = preg_match("/(^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$)/u", $value);
            //                     if (!$result) {
            //                         $fail($value . '<b> : ' . $attribute . ' is invalid');
            //                     }
            //                 }
            //             },
            //         ],
            //         // 'mobile_number' => 'nullable|required_unless:mobile_number,!=,NULL&regex:/^([0-9]{10})?$/u&numeric',
            //         'mobile_number' => [
            //             'nullable',
            //             function ($attribute, $value, $fail) {

            //                 if ($value !== 'NULL') {
            //                     $result = preg_match("/^([0-9]{10})?$/u", $value);
            //                     if (!$result) {
            //                         $fail($value . '<b> : ' . $attribute . ' is invalid');
            //                     }
            //                 }
            //             },
            //         ],
            //         'father_name' => 'nullable|regex:/(^([a-zA-z. ]+)(\d+)?$)/u',
            //         'mother_name' => 'nullable|regex:/(^([a-zA-z. ]+)(\d+)?$)/u',
            //         //'martial_status' => 'nullable|exists:vmt_marital_status,name',
            //         'martial_status' => [
            //             'nullable',
            //             function ($attribute, $value, $fail) {

            //                 if ($value !== 'NULL') {
            //                     $result = VmtMaritalStatus::where('name', $value)->first();

            //                     if (empty($result)) {
            //                         $fail($value . '<b> :' . $attribute . ' doesnt exist in application.Kindly create one');
            //                     }
            //                 }
            //             },
            //         ],
            //         'spouse_name' => 'nullable|regex:/(^([a-zA-z. ]+)(\d+)?$)/u',
            //         'department' => [
            //             'nullable',
            //             function ($attribute, $value, $fail) {

            //                 if ($value !== 'NULL') {
            //                     $result = Department::where('name', $value)->first();

            //                     if (empty($result)) {
            //                         $fail($value . '<b> :' . $attribute . ' doesnt exist in application.Kindly create one');
            //                     }
            //                 }
            //             },
            //         ],
            //         //'blood_group' =>'nullable|required_unless:blood_group,!=,NULL&exists:vmt_bloodgroup,name&regex:/(^([a-zA-z. ]+)(\d+)?$)/u',
            //         'blood_group' => [
            //             'nullable',
            //             function ($attribute, $value, $fail) {

            //                 if ($value !== 'NULL') {
            //                     $result = VmtBloodGroup::where('name', $value)->first();

            //                     if (empty($result)) {
            //                         $fail($value . '<b> :' . $attribute . ' doesnt exist in application.Kindly create one');
            //                     }
            //                 }
            //             },
            //         ],
            //         // 'bank_name' => 'nullable|required_unless:bank_name,!=,null&exists:vmt_banks,bank_name',
            //         'bank_name' => [
            //             'nullable',
            //             function ($attribute, $value, $fail) {

            //                 if ($value !== 'NULL') {
            //                     $result = Bank::where('bank_name', $value)->first();

            //                     if (empty($result)) {
            //                         $fail($value . '<b> :' . $attribute . ' doesnt exist in application.Kindly create one');
            //                     }
            //                 }
            //             },
            //         ],
            //         //'bank_ifsc_code' => 'nullable|required_unless:bank_ifsc_code,!=,NULL|regex:/(^([A-Z]){4}0([A-Z0-9]){6}?$)/u',
            //         'bank_ifsc_code' => 'nullable',
            //         'bank_account_number' => 'nullable|required_unless:bank_account_number,!=,NULL',
            //         'current_address' => 'nullable',
            //         'basic' => 'required|numeric',
            //         'hra' => 'required|numeric',
            //         'statutory_bonus' => 'required|numeric',
            //         'special_allowance' => 'required|numeric',
            //         'child_education_allowance' => 'required|numeric',
            //         'lta' => 'required|numeric',
            //         'transport_allowance' => 'required|numeric',
            //         'medical_allowance' => 'required|numeric',
            //         'education_allowance' => 'required|numeric',
            //         'other_allowance' => 'required|numeric',
            //         'gross' => 'required|numeric',
            //         'epf_employer_contribution' => 'nullable|numeric',
            //         'epf_employee_contribution' => 'nullable|numeric',
            //         'esic_employer_contribution' => 'nullable|numeric',
            //         'esic_employee_contribution' => 'nullable|numeric',
            //         'insurance' => 'required|numeric',
            //         'professional_tax' => 'required|numeric',
            //         'employee_lwf' => 'required|numeric',
            //         'net_income' => 'required|numeric',
            //         'dearness_allowance' => 'required|numeric',

            //     ];

            //     $messages = [
            //         'numeric' => 'Field <b>:attribute</b> should be numeric',
            //         'date' => 'Field <b>:attribute</b> should have the following format DD-MM-YYYY ',
            //         //  'date_format' => 'Field <b>:attribute</b> should have the following format DD/MM/YYYY ',
            //         'in' => 'Field <b>:attribute</b> should have the following values : :values .',
            //         'required' => 'Field <b>:attribute</b> is required',
            //         'regex' => 'Field <b>:attribute</b> is invalid',
            //         'employee_name.regex' => 'Field <b>:attribute</b> should not have special characters',
            //         'unique' => 'Field <b>:attribute</b> should be unique',
            //         'dob.before' => 'Field <b>:attribute</b> should be above 18 years',
            //         'email' => 'Field <b>:attribute</b> is invalid',
            //         'pan_no.required_if' => 'Field <b>:attribute</b> is required if <b>pan ack</b> not provided ',
            //         'pan_ack.required_if' => 'Field <b>:attribute</b> is required if <b>pan no</b> not provided ',
            //         'required_unless' => 'Field <b>:attribute</b> is invalid',
            //         'exists' => 'Field <b>:attribute</b> doesnt exist in application.Kindly create one',

            //     ];

            //     $validator = Validator::make($excelRowdata, $rules, $messages);

            //     if (!$validator->passes()) {

            //         $rowDataValidationResult = [
            //             'row_number' => $currentRowInExcel,
            //             'status' => 'failure',
            //             'message' => 'In Excel Row - ' . $excelRowdata['employee_code'] . ' : ' . $currentRowInExcel . ' has following error(s)',
            //             'error_fields' => json_encode($validator->errors()),
            //         ];

            //         array_push($data_array, $rowDataValidationResult);

            //         $isAllRecordsValid = false;
            //     }
            // }
        } //for loop

        //Runs only if all excel records are valid
        if ($isAllRecordsValid) {
            foreach ($excelRowdata_row as $key => $excelRowdata) {
                $rowdata_response = $this->storeSingleRecord_MasterEmployee($excelRowdata);

                array_push($data_array, $rowdata_response);
            }
            return $responseJSON = [
                'status' => $rowdata_response['status'],
                'message' => "Excelsheet data import success",
                'mail_status' => $rowdata_response['mail_status'] ?? "failure",
                'data' => $data_array,
                'error_data' => $rowdata_response['data']
            ];
        } else {

            return $responseJSON = [
                'status' => 'failure',
                'message' => "Please fix the below excelsheet data",
                'data' => $data_array
            ];
        }

        return response()->json($responseJSON);
    }

    /*

      $outputArray should be passed from parent function.
  */
    private function storeSingleRecord_MasterEmployee($row)
    {

        //DB level validation

        try {

            $response = $this->Update_MasterEmployeeData(data: $row);

            $status = $response['status'];

            if ($response['status'] == "success") {
                $message = $row['employee_code'] . ' added successfully';
            } else {
                $message = $row['employee_code'] . ' has failed';
            }

            $data_count = 0;

            $data_count = $response['data_count'] + $data_count;

            return $rowdata_response = [

                'status' => $response['status'],
                'message' => $message,
                'mail_status' => '',
                'data' => $response['data'],
                'data_count' => $data_count
            ];
        } catch (\Exception $e) {
            //dd($e);
            // $this->deleteUser($user->id);

            return $rowdata_response = [
                'status' => 'failure',
                'message' => 'error while saving data',
                'data' => $e->getTraceAsString(),
            ];
        }
    }


    private function Update_MasterEmployeeData($data)
    {
        try {

           // dd($data);

            $count = 0;
            $user_data = (["employee_name" => "name", "personal_email" => "email","employee_status"=>"active","legal_entity"=>'client_id',"business_unit"=>'business_unit','worker_type'=>'worker_type']);
            $employee_data = ([
                "gender" => "gender",
                "date_of_birth" => " dob",
                "date_of_joined" => " doj",
                "last_working_day" => "dol",
                "pan_number" => "pan_number",
                "aadhaar_number" => "aadhar_number",
                "mobile_number" => "mobile_number",
                "current_address" => "current_address_line_1",
                "permanent_address" => "permanent_address_line_1",
                "martial_status" => "marital_status_id",
                "nationality" => "nationality",
                "bank_name" => "bank_name",
                "bank_account_number" => "bank_account_number",
                "ifsc_code" => "bank_ifsc_code",
                "blood_group" => "blood_group_id",
                "physically_handicapped" => "physically_challenged",
                "salary_payment_mode" => "salary_payment_mode",
            ]);

            $employee_office_details = ([
                "department" => "department",
                "designation" => "designation",
                "location" => "work_location",
                "officical_mail" => "officical_mail",
                "office_mobile_number" => "official_mobile",
                "reporting_manager's_employee_code" => "l1_manager_code",
            ]);

            $employee_family_details = ([
                "father_name" => 'father_name',
                "father_dob" => 'father_dob',
                "mother_name" => 'mother_name',
                "mother_dob" => 'mother_dob',
                "spouse_name" => 'spouse_name',
                "spouse_dob" => 'spouse_dob',
                "child_1_name" => 'child_1_name',
                "child_1_dob" => 'child_1_dob',
                "marriage_date" => 'wedding_date'
            ]);

            $employee_statutory_details = (["prev_uan" => "uan_number", "pf_number" => "epf_number", "esi_eligible" => "esic_applicable", "prev_esi_number" => "esic_number"]);

            $compensatory_data = ([
                "basic" => "basic",
                "house_rent_allowance" => "hra",
                "special_allowance" => "special_allowance",
                "statutory_bonus" => "Statutory_bonus",
                "child_education_allowance" => "child_education_allowance",
                "travel_reimbursement_(lta)" => "lta",
                "transport_allowance" => "transport_allowance",
                "medical_allowance" => "medical_allowance",
                "education_allowance" => "education_allowance",
                "communication_allowance" => "communication_allowance",
                "food_allowance" => "food_allowance",
                "other_allowance" => 'other_allowance',
                "total_fixed_gross" => "gross",
                "vpf_employee" => "vpf_employee",
                "employer_epf" => "epf_employer_contribution",
                "employer_esic" => "esic_employer_contribution",
                "edli_charges" => "edli_charges",
                "pf_admin_charges" => "pf_admin_charges",
                "employer_lwf" => "employer_lwf",
                "employee_insurance" => "employee_insurance",
                "employer_insurance" => "employer_insurance",
                "employee_lwf" => "employee_lwf",
                "insurance" => "insurance",
                "labour_welfare_fund" => "labour_welfare_fund",
                "cost_to_company_(ctc)" => "cic",
                "employee_epf" => "epf_employee",
                "employee_esic" => "esic_employee",
                "dearness_allowance" => "dearness_allowance",
                "vda" => "vda",
                "employee_pt" => "professional_tax",
                "vehicle_reimbursement" => "vehicle_reimbursement",
                "driver_salary" => "driver_salary",
                "washing_allowance" => "washing_allowance",
                "it" => "Income_tax",
                "unifrom_allowance" => "unifrom_allowance",
                "net_take_home" => 'net_income',
                "total_deduction" => 'total_deduction',
                "pf_wages" => 'pf_wages'
            ]);



            $user_data = User::where('user_code', $data['employee_code'])->first();

            if (!empty($user_data)) {
                $count++;
                $user_id = $user_data->id;

                foreach ($data as $data_key => $single_data) {

                    if (collect($user_data)->contains($data_key)) {

                        $update_Userdata = User::where('id', $user_id)->first();

                        if (!empty($update_Userdata)) {
                            $update_Userdata->$data_key = $single_data;
                            $update_Userdata->save();
                        } else {
                            $update_Userdata = new User;
                            $update_Userdata->$data_key = $single_data;
                            $update_Userdata->save();
                        }
                    }

                    // if (collect($employee_data)->contains($data_key)) {

                    //     $update_employee_data = VmtEmployee::where('userid', $user_id)->first();

                    //     if (!empty($update_employee_data)) {

                    //         if ($data_key == 'dob') {

                    //             $dob = $single_data;
                    //             $update_employee_data->dob = $dob ? $this->getdateFormatForDb($dob) : '';
                    //         } else if ($data_key == 'doj') {

                    //             $doj = $single_data;
                    //             $update_employee_data->doj = $doj ? $this->getdateFormatForDb($doj) : '';
                    //         } else if ($data_key == 'dol') {

                    //             $dol = $single_data;
                    //             $update_employee_data->dol = $dol ? $this->getdateFormatForDb($dol) : '';
                    //         } else if ($data_key == 'martial_status') {

                    //             $martial_status_id = VmtMaritalStatus::where('name', ucfirst($single_data ?? ''))->first();
                    //             $update_employee_data->marital_status_id = !empty($martial_status_id) ? $martial_status_id->id : '';
                    //         } else if ($data_key == 'blood_group_id') {
                    //              $blood_group=str_replace(['+VE','Positive'],['-VE','Negative'],$single_data);

                    //             $blood_group_id = VmtBloodGroup::where('name', $blood_group ?? '')->first();
                    //             $update_employee_data->blood_group_id = !empty($blood_group_id) ? $blood_group_id->id : '';
                    //         } else if ($data_key == 'bank_name') {

                    //             $bank_id = Bank::where('bank_name', $single_data ?? '')->first();
                    //             $update_employee_data->bank_id = !empty($bank_id) ? $bank_id->id : '';
                    //         } else {
                    //             $update_employee_data->$data_key = $single_data;
                    //         }

                    //         $update_employee_data->save();
                    //     } else {

                    //         $update_employee_data = new VmtEmployee;
                    //         $update_employee_data->userid = $user_id;
                    //         if ($data_key == 'dob') {

                    //             $dob = $single_data;
                    //             $update_employee_data->dob = $dob ? $this->getdateFormatForDb($dob) : '';
                    //         } else if ($data_key == 'doj') {

                    //             $doj = $single_data;
                    //             $update_employee_data->doj = $doj ? $this->getdateFormatForDb($doj) : '';
                    //         } else if ($data_key == 'dol') {

                    //             $dol = $single_data;
                    //             $update_employee_data->dol = $dol ? $this->getdateFormatForDb($dol) : '';
                    //         } else if ($data_key == 'martial_status') {

                    //             $martial_status_id = VmtMaritalStatus::where('name', ucfirst($single_data ?? ''))->first();
                    //             $update_employee_data->marital_status_id = !empty($martial_status_id) ? $martial_status_id->id : '';
                    //         } else if ($data_key == 'blood_group_id') {

                    //             $blood_group_id = VmtBloodGroup::where('name', $single_data ?? '')->first();
                    //             $update_employee_data->blood_group_id = !empty($blood_group_id) ? $blood_group_id->id : '';
                    //         } else if ($data_key == 'bank_name') {

                    //             $bank_id = Bank::where('bank_name', $single_data ?? '')->first();
                    //             $update_employee_data->bank_id = !empty($bank_id) ? $bank_id->id : '';
                    //         } else {
                    //             $update_employee_data->$data_key = $single_data;
                    //         }

                    //         $update_employee_data->save();
                    //     }
                    // }


                    // if (collect($employee_family_details)->contains($data_key)) {

                    //     $emp_father_data = VmtEmployeeFamilyDetails::where('user_id', $user_id)->where('relationship', 'Father')->first();

                    //     if (!empty($emp_father_data)) {

                    //         if ($data_key == 'father_name') {

                    //             if (!empty($single_data)) {

                    //                 $emp_father_data->name = $single_data;
                    //                 $emp_father_data->gender = 'Male';
                    //                 $emp_father_data->save();
                    //             }
                    //         }
                    //         if ($data_key == 'father_dob') {

                    //             $emp_father_data->dob = $this->getdateFormatForDb($single_data);
                    //             $emp_father_data->save();
                    //         }
                    //     } else {

                    //         $employee_father_data = new VmtEmployeeFamilyDetails;
                    //         $employee_father_data->user_id = $user_id;

                    //         if ($data_key == 'father_name') {

                    //             if (!empty($single_data)) {

                    //                 $employee_father_data->user_id = $user_id;
                    //                 $employee_father_data->name = $single_data;
                    //                 $employee_father_data->gender = "Male";
                    //                 $employee_father_data->relationship = "Father";
                    //                 $employee_father_data->save();
                    //             }
                    //         }
                    //         if ($data_key == 'father_dob') {

                    //             $employee_father_data->dob = $this->getdateFormatForDb($single_data);
                    //             $employee_father_data->save();
                    //         }
                    //     }


                    //     $emp_mother_data = VmtEmployeeFamilyDetails::where('user_id', $user_id)->where('relationship', 'Mother');

                    //     if ($emp_mother_data->exists()) {

                    //         $emp_mother_data = $emp_mother_data->first();

                    //         if ($data_key == 'mother_name') {

                    //             if (!empty($single_data)) {

                    //                 $emp_mother_data->name = $single_data;
                    //                 $emp_mother_data->save();
                    //             }
                    //         } else if ($data_key == 'mother_dob') {

                    //             $emp_mother_data->dob = $this->getdateFormatForDb($single_data);
                    //             $emp_mother_data->save();
                    //         }
                    //     } else {
                    //         $employee_mother_data = new VmtEmployeeFamilyDetails;
                    //         $emp_mother_data->user_id = $user_id;

                    //         if ($data_key == 'mother_name') {

                    //             if (!empty($single_data)) {

                    //                 $employee_mother_data->user_id = $user_id;
                    //                 $employee_mother_data->name = $single_data;
                    //                 $employee_mother_data->gender = "Female";
                    //                 $employee_mother_data->relationship = "Mother";
                    //                 $employee_mother_data->save();
                    //             }
                    //         } else if ($data_key == 'mother_dob') {

                    //             $employee_mother_data->dob = $this->getdateFormatForDb($single_data);
                    //             $employee_mother_data->save();
                    //         }
                    //     }

                    //     $emp_spouse_data = VmtEmployeeFamilyDetails::where('user_id', $user_id)->where('gender', 'Female')->where('relationship', 'Spouse');
                    //     $emp_spouse_male_data = VmtEmployeeFamilyDetails::where('user_id', $user_id)->where('gender', 'male')->where('relationship', 'Spouse');

                    //     if ($emp_spouse_data->exists()) {

                    //         $emp_spouse_data = $emp_spouse_data->first();

                    //         if ($data_key == 'spouse_name') {

                    //             if (!empty($single_data)) {

                    //                 $emp_spouse_data->name = $single_data;
                    //                 $emp_spouse_data->save();
                    //             }
                    //         } else if ($data_key == 'spouse_dob') {

                    //             if (!empty($single_data)) {

                    //                 $emp_spouse_data->dob = $this->getdateFormatForDb($single_data);
                    //                 $emp_spouse_data->save();
                    //             }
                    //         }
                    //     } else if ($emp_spouse_male_data->exists()) {

                    //         $emp_spouse_male_data = $emp_spouse_male_data->first();

                    //         if ($data_key == 'spouse_name') {

                    //             if (!empty($single_data)) {

                    //                 $emp_spouse_male_data->name = $single_data;
                    //                 $emp_spouse_male_data->save();
                    //             }
                    //         } else if ($data_key == 'spouse_dob') {

                    //             if (!empty($single_data)) {

                    //                 $emp_spouse_male_data->dob = $this->getdateFormatForDb($single_data);
                    //                 $emp_spouse_male_data->save();
                    //             }
                    //         }
                    //     } else {
                    //         $employee_spouse_male_data = new VmtEmployeeFamilyDetails;
                    //         $employee_spouse_male_data->user_id = $user_id;

                    //         if ($data_key == 'spouse_name') {

                    //             if (!empty($single_data)) {
                    //                 $spouse_gender = $data['gender'];
                    //                 $employee_spouse_male_data->user_id = $user_id;
                    //                 $employee_spouse_male_data->name = $single_data;
                    //                 $employee_spouse_male_data->gender = $spouse_gender == "Male" ? "Female" : "Male";
                    //                 $employee_spouse_male_data->relationship = "Spouse";
                    //                 $employee_spouse_male_data->save();
                    //             }
                    //         } else if ($data_key == 'spouse_dob') {

                    //             $employee_spouse_male_data->dob = $this->getdateFormatForDb($single_data);
                    //             $employee_spouse_male_data->save();
                    //         }
                    //     }


                    //     $emp_child_data = VmtEmployeeFamilyDetails::where('user_id', $user_id)->where('relationship', 'Child')->first();

                    //     if (!empty($emp_child_data)) {
                    //         $emp_child_data = $emp_child_data;

                    //         if ($data_key == 'child_name') {
                    //             if (!empty($single_data)) {
                    //                 $emp_child_data->name = $single_data;
                    //             }
                    //             $emp_child_data->relationship = 'Children';
                    //             $emp_child_data->gender = '';
                    //             $emp_child_data->save();
                    //         } else if ($data_key == 'child_dob') {
                    //             $emp_child_data->dob = $this->getdateFormatForDb($single_data);
                    //             $emp_child_data->save();
                    //         }
                    //     } else {
                    //         $empolyee_child_data = new VmtEmployeeFamilyDetails;
                    //         $empolyee_child_data->user_id = $user_id;

                    //         if ($data_key == 'child_name') {

                    //             if (!empty($single_data)) {

                    //                 $empolyee_child_data->user_id = $user_id;
                    //                 $empolyee_child_data->name = $single_data;
                    //                 $empolyee_child_data->gender = "";
                    //                 $empolyee_child_data->relationship = "Children";
                    //                 $empolyee_child_data->save();
                    //             }
                    //         } else if ($data_key == 'child_dob') {

                    //             $empolyee_child_data->dob = $this->getdateFormatForDb($single_data);
                    //             $empolyee_child_data->save();
                    //         }
                    //     }
                    // }



                    // if (collect($employee_office_details)->contains($data_key)) {

                    //     $update_empOffice_data = VmtEmployeeOfficeDetails::where('user_id', $user_id)->first();

                    //     if (!empty($update_empOffice_data)) {

                    //         if ($data_key == 'department') {

                    //             if (!empty($single_data) && $single_data != 'NULL') {

                    //                 $department_name = trim($single_data);
                    //                 $department_id = Department::where('name', $department_name);
                    //                 // if($department_id->exists()){
                    //                 $update_empOffice_data->department_id = $department_id->first()->id;
                    //                 // }
                    //             }
                    //         } else {
                    //             $update_empOffice_data->$data_key = $single_data;
                    //         }
                    //         $update_empOffice_data->save();
                    //     } else {
                    //         $update_empOffice_data = new VmtEmployeeOfficeDetails;
                    //         $update_empOffice_data->user_id = $user_id;
                    //         if ($data_key == 'department') {

                    //             if (!empty($single_data) && $single_data != 'NULL') {

                    //                 $department_name = trim($single_data);
                    //                 $department_id = Department::where('name', $department_name);
                    //                 // if($department_id->exists()){
                    //                 $update_empOffice_data->department_id = $department_id->first()->id;
                    //                 // }
                    //             }
                    //         } else {
                    //             $update_empOffice_data->$data_key = $single_data;
                    //         }
                    //         $update_empOffice_data->save();
                    //     }
                    // }


                    // if (collect($employee_statutory_details)->contains($data_key)) {

                    //     $newEmployee_statutoryDetails = VmtEmployeeStatutoryDetails::where('user_id', $user_id);

                    //     if ($newEmployee_statutoryDetails->exists()) {
                    //         $newEmployee_statutoryDetails = $newEmployee_statutoryDetails->first();
                    //     } else {

                    //         $newEmployee_statutoryDetails = new VmtEmployeeStatutoryDetails;
                    //         $newEmployee_statutoryDetails->user_id = $user_id;
                    //     }
                    //     $newEmployee_statutoryDetails->$data_key = $single_data;
                    //     $newEmployee_statutoryDetails->save();
                    // }


                    // if (collect($compensatory_data)->contains($data_key)) {


                    //     $compensatory = Compensatory::where('user_id', $user_id);

                    //     if ($compensatory->exists()) {
                    //         $compensatory = $compensatory->first();
                    //     } else {
                    //         $compensatory = new Compensatory;
                    //         $compensatory->user_id = $user_id;
                    //     }

                    //     $compensatory->$data_key = $single_data;
                    //     $compensatory->save();
                    // }
                }
                return $response = ([
                    'status' => 'success',
                    'message' => 'Master data updated successfully',
                    'data' => '',
                    'data_count' => $count
                ]);
            }
        } catch (\Exception $e) {

            return $response = ([
                'status' => 'failure',
                'message' => 'Error for input date',
                'data' => $e->getmessage() . "" . $e->getline(),

                'data_count' => 0
            ]);
        }
    }
    private function getdateFormatForDb($date)
    {


        try {
            $processed_date = null;
            //Check if its in proper format
            $processed_date_one = \DateTime::createFromFormat('d-m-Y', $date);
            $processed_date_three = \DateTime::createFromFormat('Y-m-d', $date);
            $processed_date_two = \DateTime::createFromFormat('d/m/Y', $date);

            //If date is in 'd-m-y' format, then convert into one
            //If date is in 'd-m-y' format, then convert into one
            if ($processed_date_one) {
                //Then convert to Y-m-d
                $processed_date = $processed_date_one->format('Y-m-d');
            } else if (!empty($processed_date_two)) {

                $processed_date = $processed_date_two->format('Y-m-d');
            } else if ($processed_date_three) {

                $processed_date = $processed_date_three->format('Y-m-d');
            } else {
                $processed_date = '';
            }


            return $processed_date;
        } catch (\Exception $e) {
            return $response = ([
                'status' => 'failure',
                'message' => 'Error for input date',
                'data' => $e->getMessage() . ' error_line ' . $e->getline(),
            ]);
        }
    }

    public function setFinanceidHrid(Request $request)
    {

        //LANGRO INDIA PRIVATE LIMITED

        $userslan = User::where('client_id', '2')->get();

        foreach ($userslan as $single_users) {

            $emp_official_details = VmtEmployeeOfficeDetails::where('user_id', $single_users->id)->first();
            $emp_official_details->hr_user_id = '238';
            $emp_official_details->fa_user__id = '185';
            $emp_official_details->save();
        }

        //    PRITI SALES CORPORATIONS

        $userspri = User::where('client_id', '3')->get();

        foreach ($userspri as $single_users) {

            $emp_official_details = VmtEmployeeOfficeDetails::where('user_id', $single_users->id)->first();
            $emp_official_details->hr_user_id = '182';
            $emp_official_details->fa_user__id = '185';
            $emp_official_details->save();
        }

        //INDCHEM MARKETING AGENCIES

        $usersind = User::where('client_id', '4')->get();

        foreach ($usersind as $single_users) {

            $emp_official_details = VmtEmployeeOfficeDetails::where('user_id', $single_users->id)->first();
            $emp_official_details->hr_user_id = '164';
            $emp_official_details->fa_user__id = '185';
            $emp_official_details->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'updated successfully',
        ]);
    }


    public function saveEmployeeAnnualProjection(Request $request)
    {

        ini_set('max_execution_time', 300);

        try {

            DB::table('abs_salary_projection')->truncate();

            $client_details = VmtClientMaster::Where('client_fullname', "!=", "All")->get(['id', 'client_name'])->toarray();


            $timeperiod = VmtOrgTimePeriod::where('status', '1')->first();
            $start_date = Carbon::parse($timeperiod->start_date)->format('Y-m-d');

            $end_date = Carbon::parse($timeperiod->end_date)->format('Y-m-01');
            $end_date = Carbon::parse($end_date)->format('Y-m-d');
            $current_date = Carbon::now();


            $existing_employee_data = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                ->where('users.active', "1")->where('users.is_ssa', "0")->get(['users.id', 'vmt_employee_details.doj', 'users.client_id'])->toarray();
            // $existing_employee_data = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
            //     ->where('client_id', "3")->where('users.active', "1")->where('users.id', "194")->where('users.is_ssa', "0")->get(['users.id', 'vmt_employee_details.doj', 'users.client_id'])->toarray();
            //  dd($existing_employee_data);


            foreach ($existing_employee_data as $key => $single_users) {


                $fin_end_date = Carbon::parse($timeperiod->end_date);

                if ($single_users['doj'] < $start_date) {

                    $fin_start_date = Carbon::parse($timeperiod->start_date);
                } else if (Carbon::parse($single_users['doj'])->format('m') != Carbon::parse($current_date)->format('m')) {

                    $fin_start_date = Carbon::parse($single_users['doj']);
                }

                $date_range = CarbonPeriod::create($fin_start_date->startOfMonth()->format('Y-m-d'), '1 month', $current_date->endOfMonth()->format('Y-m-d'));


                $finyear_date_range = CarbonPeriod::create($fin_start_date->startOfMonth()->format('Y-m-d'), '1 month', $fin_end_date->endOfMonth()->format('Y-m-d'));


                $previous_month_payslip_date = array();
                $financial_year_date = array();
                $exists_month_data = array();


                foreach ($date_range as $key => $single_date) {

                    $payroll_date = $single_date->format('Y-m-d');

                    $previous_month_payslip_date[] = $payroll_date;

                    array_push($exists_month_data, $previous_month_payslip_date);
                }

                foreach ($finyear_date_range as $key => $single_fin_date) {

                    $fin_year_date = $single_fin_date->format('Y-m-d');

                    $financial_year_date[] = $fin_year_date;
                }



                //dd($previous_month_payslip_date, $financial_year_date);
                // dd( $exists_month_data);



                    $arr = [];
                foreach ($previous_month_payslip_date as $month_key => $single_month) {

                    foreach ($financial_year_date as $key => $single_fin_month) {


                        $emp_payroll = '';

                        $payroll_date = VmtPayroll::where('payroll_date', $single_month)->where('client_id', $single_users['client_id']);

                        if ($payroll_date->exists()) {
                            $payroll_date = $payroll_date->first();
                            $emp_payroll = VmtEmployeePayroll::where('payroll_id', $payroll_date->id)->where('user_id', $single_users['id'])->first();
                        }

                        if (in_array($single_fin_month, $exists_month_data[$month_key])) {

                            $payslip_id = VmtPayroll::join('vmt_emp_payroll', 'vmt_emp_payroll.payroll_id', '=', 'vmt_payroll.id')
                                // ->where('vmt_payroll.client_id',  $single_users['client_id'])
                                ->where('vmt_payroll.payroll_date', $single_fin_month)
                                ->where('vmt_emp_payroll.user_id', $single_users['id'])
                                ->first(['vmt_emp_payroll.id as id']);


                            if (!empty($payslip_id)) {

                                $payslip_details = VmtEmployeePaySlipV2::where('emp_payroll_id', $payslip_id->id)->first();
                            }


                            if (!empty($payslip_details)) {

                                if (!empty($emp_payroll)) {

                                    $salary_project_data = new AbsSalaryProjection;
                                    $salary_project_data->vmt_emp_payroll_id = $emp_payroll->id;
                                    $salary_project_data->payroll_months = $single_fin_month;
                                    $salary_project_data->basic = 0;
                                    $salary_project_data->hra = 0;
                                    $salary_project_data->child_edu_allowance = 0;
                                    $salary_project_data->spl_alw = 0;
                                    $salary_project_data->total_fixed_gross = $payslip_details['total_fixed_gross'];
                                    $salary_project_data->month_days = $payslip_details['month_days'];
                                    $salary_project_data->worked_Days = $payslip_details['worked_Days'];
                                    $salary_project_data->arrears_Days = $payslip_details['arrears_Days'];
                                    $salary_project_data->lop = $payslip_details['lop'];
                                    $salary_project_data->earned_basic = $payslip_details['earned_basic'];
                                    $salary_project_data->basic_arrear = $payslip_details['basic_arrear'];
                                    $salary_project_data->earned_hra = $payslip_details['earned_hra'];
                                    $salary_project_data->hra_arrear = $payslip_details['hra_arrear'];
                                    $salary_project_data->earned_child_edu_allowance = $payslip_details['earned_child_edu_allowance'];
                                    $salary_project_data->child_edu_allowance_arrear = $payslip_details['child_edu_allowance_arrear'];
                                    $salary_project_data->earned_spl_alw = $payslip_details['earned_spl_alw'];
                                    $salary_project_data->spl_alw_arrear = $payslip_details['spl_alw_arrear'];
                                    $salary_project_data->overtime = $payslip_details['overtime'];
                                    $salary_project_data->total_earned_gross = $payslip_details['total_earned_gross'];
                                    $salary_project_data->pf_wages = $payslip_details['pf_wages'];
                                    $salary_project_data->pf_wages_arrear_epfr = $payslip_details['pf_wages_arrear_epfr'];
                                    $salary_project_data->epfr = $payslip_details['epfr'];
                                    $salary_project_data->epfr_arrear = $payslip_details['epfr_arrear'];
                                    $salary_project_data->edli_charges = $payslip_details['edli_charges'];
                                    $salary_project_data->edli_charges_arrears = $payslip_details['edli_charges_arrears'];
                                    $salary_project_data->pf_admin_charges = $payslip_details['pf_admin_charges'];
                                    $salary_project_data->pf_admin_charges_arrears = $payslip_details['pf_admin_charges_arrears'];
                                    $salary_project_data->employer_esi = $payslip_details['employer_esi'];
                                    $salary_project_data->employer_lwf = $payslip_details['employer_lwf'];
                                    $salary_project_data->ctc = $payslip_details['ctc'];
                                    $salary_project_data->epf_ee = $payslip_details['epf_ee'];
                                    $salary_project_data->employee_esic = $payslip_details['employee_esic'];
                                    $salary_project_data->prof_tax = $payslip_details['prof_tax'];
                                    $salary_project_data->income_tax = $payslip_details['income_tax'];
                                    $salary_project_data->sal_adv = $payslip_details['sal_adv'];
                                    $salary_project_data->canteen_dedn = $payslip_details['canteen_dedn'];
                                    $salary_project_data->other_deduc = $payslip_details['other_deduc'];
                                    $salary_project_data->lwf = $payslip_details['lwf'];
                                    $salary_project_data->total_deductions = $payslip_details['total_deductions'];
                                    $salary_project_data->net_take_home = $payslip_details['net_take_home'];
                                    $salary_project_data->rupees = $payslip_details['rupees'];
                                    $salary_project_data->el_opn_bal = $payslip_details['el_opn_bal'];
                                    $salary_project_data->availed_el = $payslip_details['availed_el'];
                                    $salary_project_data->balance_el = $payslip_details['balance_el'];
                                    $salary_project_data->sl_opn_bal = $payslip_details['sl_opn_bal'];
                                    $salary_project_data->availed_sl = $payslip_details['availed_sl'];
                                    $salary_project_data->balance_sl = $payslip_details['balance_sl'];
                                    $salary_project_data->rename = $payslip_details['rename'];
                                    $salary_project_data->greetings = $payslip_details['greetings'];
                                    $salary_project_data->stats_bonus = $payslip_details['stats_bonus'];
                                    $salary_project_data->email = $payslip_details['email'];
                                    $salary_project_data->earned_stats_bonus = $payslip_details['earned_stats_bonus'];
                                    $salary_project_data->earned_stats_arrear = $payslip_details['earned_stats_arrear'];
                                    $salary_project_data->travel_conveyance = $payslip_details['travel_conveyance'];
                                    $salary_project_data->other_earnings = $payslip_details['other_earnings'];
                                    $salary_project_data->dearness_allowance = $payslip_details['dearness_allowance'];
                                    $salary_project_data->dearness_allowance_earned = $payslip_details['dearness_allowance_earned'];
                                    $salary_project_data->dearness_allowance_arrear = $payslip_details['dearness_allowance_arrear'];
                                    $salary_project_data->vda = 0;
                                    $salary_project_data->vda_earned = $payslip_details['vda_earned'];
                                    $salary_project_data->vda_arrear = $payslip_details['vda_arrear'];
                                    $salary_project_data->vpf_arrear = $payslip_details['vpf_arrear'];
                                    $salary_project_data->communication_allowance = 0;
                                    $salary_project_data->communication_allowance_earned = $payslip_details['communication_allowance_earned'];
                                    $salary_project_data->communication_allowance_arrear = $payslip_details['communication_allowance_arrear'];
                                    $salary_project_data->food_allowance_earned = $payslip_details['food_allowance'];
                                    $salary_project_data->food_allowance_arrear = $payslip_details['food_allowance_arrear'];
                                    $salary_project_data->other_allowance = 0;
                                    $salary_project_data->other_allowance_earned = $payslip_details['other_allowance_earned'];
                                    $salary_project_data->other_allowance_arrear = $payslip_details['other_allowance_arrear'];
                                    $salary_project_data->washing_allowance = 0;
                                    $salary_project_data->washing_allowance_earned = $payslip_details['washing_allowance_earned'];
                                    $salary_project_data->washing_allowance_arrear = $payslip_details['washing_allowance_arrear'];
                                    $salary_project_data->uniform_allowance = 0;
                                    $salary_project_data->uniform_allowance_earned = $payslip_details['uniform_allowance_earned'];
                                    $salary_project_data->uniform_allowance_arrear = $payslip_details['uniform_allowance_arrear'];
                                    $salary_project_data->vehicle_reimbursement = 0;
                                    $salary_project_data->vehicle_reimbursement_earned = $payslip_details['vehicle_reimbursement_earned'];
                                    $salary_project_data->vehicle_reimbursement_arrear = $payslip_details['vehicle_reimbursement_arrear'];
                                    $salary_project_data->driver_salary = 0;
                                    $salary_project_data->driver_salary_earned = $payslip_details['driver_salary_earned'];
                                    $salary_project_data->driver_salary_arrear = $payslip_details['driver_salary_arrear'];
                                    $salary_project_data->fuel_reimbursement = 0;
                                    $salary_project_data->fuel_reimbursement_earned = $payslip_details['fuel_reimbursement_earned'];
                                    $salary_project_data->fuel_reimbursement_arrear = $payslip_details['fuel_reimbursement_arrear'];
                                    $salary_project_data->overtime_arrear = $payslip_details['overtime_arrear'];
                                    $salary_project_data->incentive = $payslip_details['incentive'];
                                    $salary_project_data->incentive_arrear = $payslip_details['incentive_arrear'];
                                    $salary_project_data->leave_encashment = $payslip_details['leave_encashment'];
                                    $salary_project_data->leave_encashment_arrear = $payslip_details['leave_encashment_arrear'];
                                    $salary_project_data->referral_bonus = $payslip_details['referral_bonus'];
                                    $salary_project_data->referral_bonus_arrear = $payslip_details['referral_bonus_arrear'];
                                    $salary_project_data->statutory_bonus = $payslip_details['statutory_bonus'];
                                    $salary_project_data->statutory_bonus_arrear = $payslip_details['statutory_bonus_arrear'];
                                    $salary_project_data->ex_gratia = $payslip_details['ex_gratia'];
                                    $salary_project_data->gift_payment = $payslip_details['gift_payment'];
                                    $salary_project_data->gift_payment_arrear = $payslip_details['gift_payment_arrear'];
                                    $salary_project_data->attendance_bonus = $payslip_details['attendance_bonus'];
                                    $salary_project_data->attendance_bonus_arrear = $payslip_details['attendance_bonus_arrear'];
                                    $salary_project_data->daily_allowance_arrear = $payslip_details['daily_allowance_arrear'];
                                    $salary_project_data->salary_adv_arrear = $payslip_details['salary_adv_arrear'];
                                    $salary_project_data->medical_deductions = $payslip_details['medical_deductions'];
                                    $salary_project_data->uniform_deductions = $payslip_details['uniform_deductions'];
                                    $salary_project_data->loan_deductions = $payslip_details['loan_deductions'];
                                    $salary_project_data->save();
                                    $response['saved_payslip_data'][] = 'saved projection months';
                                    array_push($arr,$response);
                                }
                            } else {
                                $response['no_payslip_data'][] = 'no payslip data found for ' . $single_users['id'] . 'user' . " " . $single_month . " " . $single_fin_month;
                                array_push($arr,$response);
                            }


                            //array_push($res, $payslip_details);
                        } else {

                            $compensatory_details = User::join('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'users.id')->where('user_id', $single_users['id'])->first();

                            $salary_project_data = new AbsSalaryProjection;

                            if (!empty($emp_payroll)) {

                                $salary_project_data->vmt_emp_payroll_id = $emp_payroll->id;
                                $salary_project_data->payroll_months = $single_fin_month;
                                $salary_project_data->basic = 0;
                                $salary_project_data->hra = 0;
                                $salary_project_data->child_edu_allowance = 0;
                                $salary_project_data->spl_alw = 0;
                                $salary_project_data->total_fixed_gross = $compensatory_details['gross'] ?? 0;
                                $salary_project_data->month_days = $compensatory_details['month_days'] ?? 0;
                                $salary_project_data->worked_Days = $compensatory_details['worked_Days'] ?? 0;
                                $salary_project_data->arrears_Days = $compensatory_details['arrears_Days'] ?? 0;
                                $salary_project_data->lop = $compensatory_details['lop'] ?? 0;
                                $salary_project_data->earned_basic = $compensatory_details['basic'] ?? 0;
                                $salary_project_data->basic_arrear = $compensatory_details['basic_arrear'] ?? 0;
                                $salary_project_data->earned_hra = $compensatory_details['hra'] ?? 0;
                                $salary_project_data->hra_arrear = $compensatory_details['hra_arrear'] ?? 0;
                                $salary_project_data->earned_child_edu_allowance = $compensatory_details['child_education_allowance'] ?? 0;
                                $salary_project_data->earned_spl_alw = $compensatory_details['special_allowance'] ?? 0;
                                $salary_project_data->overtime = $compensatory_details['overtime'] ?? 0;
                                $salary_project_data->total_earned_gross = $compensatory_details['gross'] ?? 0;
                                $salary_project_data->pf_wages = $compensatory_details['pf_wages'] ?? 0;
                                $salary_project_data->pf_wages_arrear_epfr = $compensatory_details['pf_wages_arrear_epfr'] ?? 0;
                                $salary_project_data->epfr = $compensatory_details['epfr'] ?? 0;
                                $salary_project_data->epfr_arrear = $compensatory_details['epfr_arrear'] ?? 0;
                                $salary_project_data->edli_charges = $compensatory_details['edli_charges'] ?? 0;
                                $salary_project_data->edli_charges_arrears = $compensatory_details['edli_charges_arrears'] ?? 0;
                                $salary_project_data->pf_admin_charges = $compensatory_details['pf_admin_charges'] ?? 0;
                                $salary_project_data->pf_admin_charges_arrears = $compensatory_details['pf_admin_charges_arrears'] ?? 0;
                                $salary_project_data->employer_esi = $compensatory_details['esic_employer_contribution'] ?? 0;
                                $salary_project_data->employer_lwf = $compensatory_details['employer_lwf'] ?? 0;
                                $salary_project_data->ctc = $compensatory_details['cic'] ?? 0;
                                $salary_project_data->epf_ee = $compensatory_details['epf_employee'] ?? 0;
                                $salary_project_data->employee_esic = $compensatory_details['esic_employee'] ?? 0;
                                $salary_project_data->prof_tax = $compensatory_details['professional_tax'] ?? 0;
                                $salary_project_data->income_tax = $compensatory_details['income_tax'] ?? 0;
                                $salary_project_data->sal_adv = $compensatory_details['sal_adv'] ?? 0;
                                $salary_project_data->canteen_dedn = $compensatory_details['canteen_dedn'] ?? 0;
                                $salary_project_data->other_deduc = $compensatory_details['other_deduc'] ?? 0;
                                $salary_project_data->lwf = $compensatory_details['lwf'] ?? 0;
                                $salary_project_data->total_deductions = $compensatory_details['total_deductions'] ?? 0;
                                $salary_project_data->net_take_home = $compensatory_details['net_income'] ?? 0;
                                $salary_project_data->rupees = $compensatory_details['rupees'] ?? 0;
                                $salary_project_data->el_opn_bal = $compensatory_details['el_opn_bal'] ?? 0;
                                $salary_project_data->availed_el = $compensatory_details['availed_el'] ?? 0;
                                $salary_project_data->balance_el = $compensatory_details['balance_el'] ?? 0;
                                $salary_project_data->sl_opn_bal = $compensatory_details['sl_opn_bal'] ?? 0;
                                $salary_project_data->availed_sl = $compensatory_details['availed_sl'] ?? 0;
                                $salary_project_data->balance_sl = $compensatory_details['balance_sl'] ?? 0;
                                $salary_project_data->rename = $compensatory_details['rename'] ?? 0;
                                $salary_project_data->greetings = $compensatory_details['greetings'] ?? 0;
                                $salary_project_data->stats_bonus = $compensatory_details['stats_bonus'] ?? 0;
                                $salary_project_data->email = $compensatory_details['email'] ?? 0;
                                $salary_project_data->earned_stats_bonus = $compensatory_details['Statutory_bonus'] ?? 0;
                                $salary_project_data->earned_stats_arrear = $compensatory_details['earned_stats_arrear'] ?? 0;
                                $salary_project_data->travel_conveyance = $compensatory_details['travel_conveyance'] ?? 0;
                                $salary_project_data->other_earnings = $compensatory_details['other_earnings'] ?? 0;
                                $salary_project_data->dearness_allowance = 0;
                                $salary_project_data->dearness_allowance_earned = $compensatory_details['dearness_allowance'] ?? 0;
                                $salary_project_data->dearness_allowance_arrear = $compensatory_details['dearness_allowance_arrear'] ?? 0;
                                $salary_project_data->vda = 0;
                                $salary_project_data->vda_earned = $compensatory_details['vda'] ?? 0;
                                $salary_project_data->vda_arrear = $compensatory_details['vda_arrear'] ?? 0;
                                $salary_project_data->vpf_arrear = $compensatory_details['vpf_arrear'] ?? 0;
                                $salary_project_data->communication_allowance = 0;
                                $salary_project_data->communication_allowance_earned = $compensatory_details['communication_allowance'] ?? 0;
                                $salary_project_data->communication_allowance_arrear = $compensatory_details['communication_allowance_arrear'] ?? 0;
                                $salary_project_data->food_allowance_earned = $compensatory_details['food_allowance'] ?? 0;
                                $salary_project_data->food_allowance_arrear = $compensatory_details['food_allowance_arrear'] ?? 0;
                                $salary_project_data->other_allowance = 0;
                                $salary_project_data->other_allowance_earned = $compensatory_details['other_allowance'] ?? 0;
                                $salary_project_data->other_allowance_arrear = $compensatory_details['other_allowance_arrear'] ?? 0;
                                $salary_project_data->washing_allowance = 0;
                                $salary_project_data->washing_allowance_earned = $compensatory_details['washing_allowance'] ?? 0;
                                $salary_project_data->washing_allowance_arrear = $compensatory_details['washing_allowance_arrear'] ?? 0;
                                $salary_project_data->uniform_allowance = 0;
                                $salary_project_data->uniform_allowance_earned = $compensatory_details['uniform_allowance'] ?? 0;
                                $salary_project_data->uniform_allowance_arrear = $compensatory_details['uniform_allowance_arrear'] ?? 0;
                                $salary_project_data->vehicle_reimbursement = 0;
                                $salary_project_data->vehicle_reimbursement_earned = $compensatory_details['vehicle_reimbursement'] ?? 0;
                                $salary_project_data->vehicle_reimbursement_arrear = $compensatory_details['vehicle_reimbursement_arrear'] ?? 0;
                                $salary_project_data->driver_salary = 0;
                                $salary_project_data->driver_salary_earned = $compensatory_details['driver_salary'] ?? 0;
                                $salary_project_data->driver_salary_arrear = $compensatory_details['driver_salary_arrear'] ?? 0;
                                $salary_project_data->fuel_reimbursement = 0;
                                $salary_project_data->fuel_reimbursement_earned = $compensatory_details['fuel_reimbursement'] ?? 0;
                                $salary_project_data->fuel_reimbursement_arrear = $compensatory_details['fuel_reimbursement_arrear'] ?? 0;
                                $salary_project_data->overtime_arrear = $compensatory_details['overtime_arrear'] ?? 0;
                                $salary_project_data->incentive = $compensatory_details['incentive'] ?? 0;
                                $salary_project_data->incentive_arrear = $compensatory_details['incentive_arrear'] ?? 0;
                                $salary_project_data->leave_encashment = $compensatory_details['leave_encashment'] ?? 0;
                                $salary_project_data->leave_encashment_arrear = $compensatory_details['leave_encashment_arrear'] ?? 0;
                                $salary_project_data->referral_bonus = $compensatory_details['referral_bonus'] ?? 0;
                                $salary_project_data->referral_bonus_arrear = $compensatory_details['referral_bonus_arrear'] ?? 0;
                                $salary_project_data->statutory_bonus = $compensatory_details['statutory_bonus'] ?? 0;
                                $salary_project_data->statutory_bonus_arrear = $compensatory_details['statutory_bonus_arrear'] ?? 0;
                                $salary_project_data->ex_gratia = $compensatory_details['ex_gratia'] ?? 0;
                                $salary_project_data->gift_payment = $compensatory_details['gift_payment'] ?? 0;
                                $salary_project_data->gift_payment_arrear = $compensatory_details['gift_payment_arrear'] ?? 0;
                                $salary_project_data->attendance_bonus = $compensatory_details['attendance_bonus'] ?? 0;
                                $salary_project_data->attendance_bonus_arrear = $compensatory_details['attendance_bonus_arrear'] ?? 0;
                                $salary_project_data->daily_allowance_arrear = $compensatory_details['daily_allowance_arrear'] ?? 0;
                                $salary_project_data->salary_adv_arrear = $compensatory_details['salary_adv_arrear'] ?? 0;
                                $salary_project_data->medical_deductions = $compensatory_details['medical_deductions'] ?? 0;
                                $salary_project_data->uniform_deductions = $compensatory_details['uniform_deductions'] ?? 0;
                                $salary_project_data->loan_deductions = $compensatory_details['loan_deductions'] ?? 0;
                                $salary_project_data->save();
                            }
                        }
                        //array_push($res, $compensatory_details);
                    }
                }
            }

            return $response = ([
                'status ' => "success",
                "message" => $arr,
                "data" => ""
            ]);
        } catch (\Exception $e) {
            return $response = ([
                "status" => "failure",
                "user_data" => $single_users['id'] . " " . $single_month,
                "user_month" => $single_users['id'] . " " . $single_month,
                "data" => $e->getmessage() . "line" . $e->getline()
            ]);
        }
    }

    public function addingDOLandDOJ()
    {
        $err = array();
        $succ = array();
        $arr = array(
            array(
                "Employee Code" => "DM001",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM002",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM003",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM004",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM006",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM007",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM009",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM012",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM018",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM019",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM021",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM022",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM024",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM026",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM028",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM029",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM032",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM034",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM038",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM045",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM054",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM059",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM069",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM071",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM079",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM088",
                "Date of Joined (dd-mmm-yyyy)" => "01-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM091",
                "Date of Joined (dd-mmm-yyyy)" => "01-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM094",
                "Date of Joined (dd-mmm-yyyy)" => "01-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM101",
                "Date of Joined (dd-mmm-yyyy)" => "01-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM103",
                "Date of Joined (dd-mmm-yyyy)" => "01-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM104",
                "Date of Joined (dd-mmm-yyyy)" => "01-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM106",
                "Date of Joined (dd-mmm-yyyy)" => "01-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM107",
                "Date of Joined (dd-mmm-yyyy)" => "01-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM109",
                "Date of Joined (dd-mmm-yyyy)" => "01-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM110",
                "Date of Joined (dd-mmm-yyyy)" => "01-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM112",
                "Date of Joined (dd-mmm-yyyy)" => "01-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM113",
                "Date of Joined (dd-mmm-yyyy)" => "01-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM115",
                "Date of Joined (dd-mmm-yyyy)" => "01-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM117",
                "Date of Joined (dd-mmm-yyyy)" => "01-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM118",
                "Date of Joined (dd-mmm-yyyy)" => "01-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM120",
                "Date of Joined (dd-mmm-yyyy)" => "01-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM122",
                "Date of Joined (dd-mmm-yyyy)" => "01-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM123",
                "Date of Joined (dd-mmm-yyyy)" => "01-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM124",
                "Date of Joined (dd-mmm-yyyy)" => "03-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM125",
                "Date of Joined (dd-mmm-yyyy)" => "03-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM127",
                "Date of Joined (dd-mmm-yyyy)" => "03-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM128",
                "Date of Joined (dd-mmm-yyyy)" => "03-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM131",
                "Date of Joined (dd-mmm-yyyy)" => "03-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM134",
                "Date of Joined (dd-mmm-yyyy)" => "03-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM140",
                "Date of Joined (dd-mmm-yyyy)" => "03-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM141",
                "Date of Joined (dd-mmm-yyyy)" => "01-04-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM145",
                "Date of Joined (dd-mmm-yyyy)" => "01-08-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM146",
                "Date of Joined (dd-mmm-yyyy)" => "01-08-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM148",
                "Date of Joined (dd-mmm-yyyy)" => "01-08-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM149",
                "Date of Joined (dd-mmm-yyyy)" => "01-08-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM150",
                "Date of Joined (dd-mmm-yyyy)" => "01-08-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM151",
                "Date of Joined (dd-mmm-yyyy)" => "01-08-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM153",
                "Date of Joined (dd-mmm-yyyy)" => "01-08-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM154",
                "Date of Joined (dd-mmm-yyyy)" => "01-08-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM156",
                "Date of Joined (dd-mmm-yyyy)" => "01-08-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM159",
                "Date of Joined (dd-mmm-yyyy)" => "01-08-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM160",
                "Date of Joined (dd-mmm-yyyy)" => "11-07-2022",
                "Last Working Day (dd-mmm-yyyy)" => "29-04-2023"
            ),
            array(
                "Employee Code" => "DM161",
                "Date of Joined (dd-mmm-yyyy)" => "11-07-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM162",
                "Date of Joined (dd-mmm-yyyy)" => "11-07-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM163",
                "Date of Joined (dd-mmm-yyyy)" => "11-07-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM165",
                "Date of Joined (dd-mmm-yyyy)" => "11-07-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM166",
                "Date of Joined (dd-mmm-yyyy)" => "11-07-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM167",
                "Date of Joined (dd-mmm-yyyy)" => "11-07-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM169",
                "Date of Joined (dd-mmm-yyyy)" => "14-07-2022",
                "Last Working Day (dd-mmm-yyyy)" => "03-06-2023"
            ),
            array(
                "Employee Code" => "DM170",
                "Date of Joined (dd-mmm-yyyy)" => "18-07-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM172",
                "Date of Joined (dd-mmm-yyyy)" => "04-08-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM173",
                "Date of Joined (dd-mmm-yyyy)" => "08-08-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM174",
                "Date of Joined (dd-mmm-yyyy)" => "11-08-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM175",
                "Date of Joined (dd-mmm-yyyy)" => "08-08-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM176",
                "Date of Joined (dd-mmm-yyyy)" => "11-08-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM177",
                "Date of Joined (dd-mmm-yyyy)" => "16-08-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM178",
                "Date of Joined (dd-mmm-yyyy)" => "29-08-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM179",
                "Date of Joined (dd-mmm-yyyy)" => "23-09-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM180",
                "Date of Joined (dd-mmm-yyyy)" => "30-09-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM181",
                "Date of Joined (dd-mmm-yyyy)" => "07-10-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM182",
                "Date of Joined (dd-mmm-yyyy)" => "10-10-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM183",
                "Date of Joined (dd-mmm-yyyy)" => "12-10-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM184",
                "Date of Joined (dd-mmm-yyyy)" => "25-10-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM185",
                "Date of Joined (dd-mmm-yyyy)" => "01-04-2023",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM186",
                "Date of Joined (dd-mmm-yyyy)" => "04-11-2022",
                "Last Working Day (dd-mmm-yyyy)" => "28-06-2023"
            ),
            array(
                "Employee Code" => "DM187",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM188",
                "Date of Joined (dd-mmm-yyyy)" => "02-12-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM189",
                "Date of Joined (dd-mmm-yyyy)" => "14-12-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM190",
                "Date of Joined (dd-mmm-yyyy)" => "19-12-2022",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM191",
                "Date of Joined (dd-mmm-yyyy)" => "07-06-2023",
                "Last Working Day (dd-mmm-yyyy)" => "-"
            ),
            array(
                "Employee Code" => "DM095",
                "Date of Joined (dd-mmm-yyyy)" => "01-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "31-12-2021"
            ),
            array(
                "Employee Code" => "DM157",
                "Date of Joined (dd-mmm-yyyy)" => "01-08-2022",
                "Last Working Day (dd-mmm-yyyy)" => "21-12-2022"
            ),
            array(
                "Employee Code" => "DM011",
                "Date of Joined (dd-mmm-yyyy)" => "28-02-2017",
                "Last Working Day (dd-mmm-yyyy)" => "30-11-2021"
            ),
            array(
                "Employee Code" => "DM135",
                "Date of Joined (dd-mmm-yyyy)" => "03-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "06-02-2023"
            ),
            array(
                "Employee Code" => "DM105",
                "Date of Joined (dd-mmm-yyyy)" => "08-07-2021",
                "Last Working Day (dd-mmm-yyyy)" => "31-12-2021"
            ),
            array(
                "Employee Code" => "DM061",
                "Date of Joined (dd-mmm-yyyy)" => "01-03-2020",
                "Last Working Day (dd-mmm-yyyy)" => "30-11-2021"
            ),
            array(
                "Employee Code" => "DM133",
                "Date of Joined (dd-mmm-yyyy)" => "03-01-2022",
                "Last Working Day (dd-mmm-yyyy)" => "30-03-2023"
            ),
            array(
                "Employee Code" => "DM108",
                "Date of Joined (dd-mmm-yyyy)" => "10-07-2021",
                "Last Working Day (dd-mmm-yyyy)" => "21-01-2023"
            ),
            array(
                "Employee Code" => "DM164",
                "Date of Joined (dd-mmm-yyyy)" => "11-07-2022",
                "Last Working Day (dd-mmm-yyyy)" => "03-04-2023"
            ),
            array(
                "Employee Code" => "DM016",
                "Date of Joined (dd-mmm-yyyy)" => "01-12-2021",
                "Last Working Day (dd-mmm-yyyy)" => "27-05-2023"
            )
        );
        foreach ($arr as $single_emp) {
            $user = User::where('user_code', $single_emp['Employee Code']);
            if ($user->exists()) {
                $user_id = $user->first()->id;
                $doj = Carbon::parse($single_emp['Date of Joined (dd-mmm-yyyy)'])->format('Y-m-d');
                if ($single_emp['Last Working Day (dd-mmm-yyyy)'] != '-') {
                    $dol = Carbon::parse($single_emp['Last Working Day (dd-mmm-yyyy)'])->format('Y-m-d');
                } else {
                    $dol = null;
                }
            }
        }
    }

    public function IsAppEnableCorrection(Request $request)
    {

        try {
            $response = array();
            $response['success'] = array();
            $response['failure'] = array();
            $users = User::where('is_ssa', 0)->get();
            foreach ($users as $single_user) {
                if (!VmtEmpSubModules::where('user_id', $single_user->id)->where('app_sub_module_link_id', 1)->exists()) {
                    $emp_sub_modules = new VmtEmpSubModules;
                    $emp_sub_modules->client_id = $single_user->client_id;
                    $emp_sub_modules->user_id = $single_user->id;
                    $emp_sub_modules->app_sub_module_link_id = 1;
                    $emp_sub_modules->status = 1;
                    if ($emp_sub_modules->save()) {
                        array_push($response['success'], 'Added : ' . $single_user->user_code . ' - ' . $single_user->name);
                    } else {
                        array_push($response['failure'], 'Not Added (Save Error ) : ' . $single_user->user_code . ' - ' . $single_user->name);
                    }
                } else {
                    array_push($response['failure'], 'Not Added (Already Exists ) : ' . $single_user->user_code . ' - ' . $single_user->name);
                }
            }
            return $response;
        } catch (\Exception $e) {
            return $response = ([
                "status" => "failure",
                "error" => $e->getMessage(),
                "line" => $e->getTraceAsString()
            ]);
        }
    }
    public function correctionForDunamisCore(Request $request)
    {
        $response = array();
        $data = '[{"user_code":"DMC187","date":"2023-11-09"},{"user_code":"DMC187","date":"2023-11-10"},{"user_code":"DMC187","date":"2023-11-11"},{"user_code":"DMC187","date":"2023-11-15"},{"user_code":"DMC187","date":"2023-11-16"},{"user_code":"DMC187","date":"2023-11-17"},{"user_code":"DMC188","date":"2023-11-08"},{"user_code":"DMC188","date":"2023-11-09"},{"user_code":"DMC188","date":"2023-11-10"},{"user_code":"DMC188","date":"2023-11-11"},{"user_code":"DMC188","date":"2023-11-14"},{"user_code":"DMC188","date":"2023-11-15"},{"user_code":"DMC188","date":"2023-11-16"},{"user_code":"DMC188","date":"2023-11-17"}]';
        $absent_reg_data = json_decode($data, true);
        foreach ($absent_reg_data as $single_data) {
            if (User::where('user_code', $single_data['user_code'])->exists()) {
                $absent_re_query = new VmtEmployeeAbsentRegularization;
                $absent_re_query->user_id = User::where('user_code', $single_data['user_code'])->first()->id;
                $absent_re_query->attendance_date = $single_data['date'];
                $absent_re_query->regularization_type = 'Absent Regularization';
                $absent_re_query->checkin_time = '09:00:00';
                $absent_re_query->checkout_time = '18:00:00';
                $absent_re_query->reason = 'Others';
                $absent_re_query->custom_reason = 'DA';
                $absent_re_query->reviewer_id = 266;
                $absent_re_query->reviewer_comments = '---';
                $absent_re_query->reviewer_reviewed_date = '2023-11-30';
                $absent_re_query->status = 'Approved';
                $absent_re_query->save();
            } else {
                array_push($response, $single_data['user_code'] . ' Not Existed In Database');
            }
        }
        return $response;
    }
    public function setEmployeeAbsentRegularization(Request $request)
    {

        $employee_details = ["DMC113", "DMC134", "DMC157", "DMC186", "DMC112"];
        // $employee_details=["DM185","DM216","DM001","DM002","DM003","DM079","DM191"];
        //$employee_details=["DM185"];

        $attendance_start_date = "2023-10-27";
        $data = array();
        foreach ($employee_details as $key => $single_details) {

            for ($i = 1; $attendance_start_date != '2023-11-25'; $i++) {

                $emp_data = User::where('user_code', $single_details)->first();
                if (empty($emp_data->id)) {
                    dd($single_details);
                }

                $rgularize_data = VmtEmployeeAbsentRegularization::where('user_id', $emp_data->id)->where('attendance_date', $attendance_start_date);

                if ($rgularize_data->exists()) {
                    $rgularize_data = $rgularize_data->first();
                } else {
                    $rgularize_data = new VmtEmployeeAbsentRegularization;
                }

                $rgularize_data->user_id = $emp_data->id;
                $rgularize_data->attendance_date = $attendance_start_date;
                $rgularize_data->regularization_type = 'Absent Regularization';
                $rgularize_data->checkin_time = '09:00:00';
                $rgularize_data->checkout_time = '06:00:00';
                $rgularize_data->reason = 'Others';
                $rgularize_data->custom_reason = 'MSP';
                $rgularize_data->reviewer_id = '266';
                $rgularize_data->reviewer_comments = '---';
                $rgularize_data->reviewer_reviewed_date = '2023-11-30';
                $rgularize_data->status = 'Approved';
                $rgularize_data->save();

                $attendance_start_date = carbon::createFromFormat('Y-m-d', $attendance_start_date)->addday()->format('Y-m-d');

                array_push($data, $attendance_start_date);
            }
            $attendance_start_date = "2023-10-27";
        }
        return $data;
        // return $serviceVmtAttendanceService->saveSandwichSettingsdata($request->is_sandwich_applicable,$request->is_weekoff_applicable, $request->is_holiday_applicable, $request->can_consider_approved_leaves);
    }

    public function migreatePMSFromDetailsToPMSV3FormDetails(Request $request)
    {
        try {
            $kpi_form_id = VmtPMS_KPIFormModel::get(['id', 'form_name', 'available_columns', 'author_id']);
            $response = array();
            $response['migrated_forms'] = array();
            $response['not migrated_form'] = array();
            $response['these_assigned_infos_are_not_migreated'] = array();
            $response['assinged_forms'] = array();
            $temp_json_ar_for_objective_value = array();
            foreach ($kpi_form_id as $single_record) {
                $form_name = $single_record->form_name;
                $form_details_column = $single_record->available_columns;
                $from_details_ar = explode(',', $form_details_column);
                $form_details = VmtPMS_KPIFormDetailsModel::where('vmt_pms_kpiform_id', $single_record->id);
                if ($form_details->exists()) {
                    $form_details = $form_details->get();
                    $pms_kpi_form_v3 = new VmtPmsKpiFormV3;
                    $pms_kpi_form_v3->form_name = $form_name;
                    $pms_kpi_form_v3->selected_headers = $this->getColumnFromOldForm($form_details_column);
                    $pms_kpi_form_v3->author_id = $single_record->author_id;
                    $pms_kpi_form_v3->save();
                    $pms_kpi_form_v3_id = $pms_kpi_form_v3->id;

                    $oldFromDetailsIdAndNewFormDetailsId = array();
                    foreach ($form_details as $single_form_details) {
                        foreach ($from_details_ar as $single_column) {
                            $temp_json_ar_for_objective_value[$single_column] = $single_form_details[$single_column];
                        }
                        $objective_value_string = json_encode($temp_json_ar_for_objective_value, true);
                        $pms_kpi_form_details_v3 = new VmtPmsKpiFormDetailsV3;
                        $pms_kpi_form_details_v3->vmt_pms_kpiform_v3_id = $pms_kpi_form_v3_id;
                        $pms_kpi_form_details_v3->objective_values = $objective_value_string;
                        $pms_kpi_form_details_v3->save();
                        $oldFromDetailsIdAndNewFormDetailsId[$single_form_details->id] = $pms_kpi_form_details_v3->id;
                        unset($temp_json_ar_for_objective_value);
                    }
                    $pms_form_assigned_query = VmtPMS_KPIFormAssignedModel::where('vmt_pms_kpiform_id', $single_record->id);
                    if ($pms_form_assigned_query->exists()) {
                        $pms_form_assigned_query = $pms_form_assigned_query->get();
                        foreach ($pms_form_assigned_query as $single_form_assign_record) {
                            $asingee_id_ar = explode(',', $single_form_assign_record->assignee_id);
                            foreach ($asingee_id_ar as $single_assingee_id) {
                                if ($single_form_assign_record->calendar_type == 'calendar_year') {
                                    $year = substr($single_form_assign_record->year, -4);
                                } else if ($single_form_assign_record->calendar_type == 'financial_year') {
                                    $year = Carbon::parse('01-01-' . substr($single_form_assign_record->year, -4))->subYear()->format('Y');
                                }

                                $query_client_id = User::where('id', $single_assingee_id)->first();

                                if ($query_client_id->exists())
                                    $query_client_id = $query_client_id->client_id;
                                else {
                                    return response()->json([
                                        "status" => "failure",
                                        "error_message" => "Client ID not found for the user_id  : " . $query_client_id,
                                        "error_line" => __LINE__,
                                    ]);
                                }

                                $pms_assignment_setting_id = VmtPMSassignment_settings_v3::where('client_id', $query_client_id)
                                    ->where('calendar_type', $single_form_assign_record->calendar_type)
                                    ->where('year', $year)->where('frequency', $single_form_assign_record->frequency)->first();

                                if (empty($pms_assignment_setting_id)) {
                                    //   dd($pms_assignment_setting_id->id);
                                    $params = $single_assingee_id . " , " . $query_client_id . " , " . $year . " , " . $single_form_assign_record->calendar_type . " , " . $single_form_assign_record->frequency;
                                    return response()->json([
                                        "status" => "failure",
                                        "error_message" => "PMS Assignment settings not found for the given details [ user_id, client_id,  year , calendar_type, frequency ] : " . $params,
                                        "error_line" => __LINE__,
                                    ]);
                                }

                                $pms_assignment_setting_id = $pms_assignment_setting_id->id;

                                $old_form_assignment_period = $this->getOldFromAssignment_Period($single_form_assign_record->calendar_type, $single_form_assign_record->frequency, $single_form_assign_record->assignment_period);

                                // dd('pms_ assignment_settings_id : '.$pms_assignment_setting_id.', cal type : '.$single_form_assign_record->calendar_type.' , Frequency : '. $single_form_assign_record->frequency.', assignment_period : '. $single_form_assign_record->assignment_period);
                                //dd("getOldFromAssignment_Period() : ".$old_form_assignment_period);

                                if (
                                    VmtPmsAssignmentV3::where('pms_assignment_settings_id', $pms_assignment_setting_id)
                                        ->where('assignment_period', $old_form_assignment_period)->exists()
                                ) {
                                    $pms_kpi_form_assigned_v3 = new VmtPmsKpiFormAssignedV3;
                                    $pms_kpi_form_assigned_v3->vmt_pms_kpiform_v3_id = $pms_kpi_form_v3_id;
                                    $pms_kpi_form_assigned_v3->assignee_id = $single_assingee_id;
                                    $pms_kpi_form_assigned_v3->reviewer_id = $single_form_assign_record->reviewer_id;
                                    $pms_kpi_form_assigned_v3->assigner_id = $single_form_assign_record->assigner_id;
                                    $pms_kpi_form_assigned_v3->goal_initiated_date = $single_form_assign_record->created_at;
                                    $pms_kpi_form_assigned_v3->department_id = $single_form_assign_record->department_id;
                                    $pms_kpi_form_assigned_v3->vmt_pms_assignment_v3_id = VmtPmsAssignmentV3::where('pms_assignment_settings_id', $pms_assignment_setting_id)
                                        ->where('assignment_period', $this->getOldFromAssignment_Period($single_form_assign_record->calendar_type, $single_form_assign_record->frequency, $single_form_assign_record->assignment_period))->first()->id;
                                    $pms_kpi_form_assigned_v3->flow_type = 1;
                                    $pms_kpi_form_assigned_v3->save();

                                    //old form review details
                                    $review_details = VmtPMS_KPIFormReviewsModel::where('vmt_pms_kpiform_assigned_id', $single_form_assign_record->id)->where('assignee_id', $single_assingee_id);

                                    if ($review_details->exists()) {
                                        $review_details = $review_details->first();
                                        $pms_kpi_form_review_v3 = new VmtPmsKpiFormReviewsV3;
                                        $pms_kpi_form_review_v3->vmt_kpiform_assigned_v3_id = $pms_kpi_form_assigned_v3->id;
                                        $pms_kpi_form_review_v3->assignee_id = $single_assingee_id;
                                        if ($review_details->is_assignee_accepted == null) {
                                            $pms_kpi_form_review_v3->is_assignee_accepted = '';
                                        } else {
                                            $pms_kpi_form_review_v3->is_assignee_accepted = $review_details->is_assignee_accepted;
                                        }
                                        if ($review_details->is_assignee_submitted == null) {
                                            $pms_kpi_form_review_v3->is_assignee_submitted = '';
                                        } else {
                                            $pms_kpi_form_review_v3->is_assignee_submitted = $review_details->is_assignee_submitted;
                                        }
                                        $pms_kpi_form_review_v3->assignee_rejection_comments = '';
                                        if ($review_details->assignee_kpi_review == null) {
                                            $pms_kpi_form_review_v3->assignee_kpi_review = $this->reviewJson($single_assingee_id, null, null, null, 'asingee', null);
                                        } else {
                                            $pms_kpi_form_review_v3->assignee_kpi_review = $this->reviewJson($single_assingee_id, $review_details->assignee_kpi_review, $review_details->assignee_kpi_percentage, $review_details->assignee_kpi_comments, 'asingee', $oldFromDetailsIdAndNewFormDetailsId);
                                        }
                                        $reviewer_id = array_key_first(json_decode($review_details->is_reviewer_accepted, true));
                                        if (json_decode($review_details->is_reviewer_accepted, true)[$reviewer_id] == null) {
                                            $pms_kpi_form_review_v3->is_reviewer_accepted = '';
                                        } else {
                                            $pms_kpi_form_review_v3->is_reviewer_accepted = json_decode($review_details->is_reviewer_accepted, true)[$reviewer_id];
                                        }
                                        if (json_decode($review_details->is_reviewer_submitted, true)[$reviewer_id] == null) {
                                            $pms_kpi_form_review_v3->is_reviewer_submitted = '';
                                        } else {
                                            $pms_kpi_form_review_v3->is_reviewer_submitted = json_decode($review_details->is_reviewer_submitted, true)[$reviewer_id];
                                        }
                                        if ($review_details->reviewer_kpi_review == null) {
                                            $pms_kpi_form_review_v3->reviewer_kpi_review = $this->reviewJson(array_key_first(json_decode($review_details->is_reviewer_accepted, true)), null, null, null, 'reviewer', null);
                                        } else {
                                            $pms_kpi_form_review_v3->reviewer_kpi_review = $this->reviewJson(array_key_first(json_decode($review_details->is_reviewer_accepted, true)), $review_details->reviewer_kpi_review, $review_details->reviewer_kpi_percentage, $review_details->reviewer_kpi_comments, 'reviewer', $oldFromDetailsIdAndNewFormDetailsId);
                                        }
                                        if ($pms_kpi_form_review_v3->is_reviewer_submitted == 1) {
                                            $pms_kpi_form_review_v3->reviewer_details = $this->oldFormDetails($review_details->is_reviewer_accepted, $review_details->is_reviewer_submitted, $this->findScoreForForm(json_decode($pms_kpi_form_review_v3->reviewer_kpi_review, true)[0]['reviewer_kpi']));
                                        } else {
                                            $pms_kpi_form_review_v3->reviewer_details = $this->oldFormDetails($review_details->is_reviewer_accepted, $review_details->is_reviewer_submitted, 0);
                                        }
                                        if ($review_details->reviewer_appraisal_comments == null) {
                                            $pms_kpi_form_review_v3->reviewer_appraisal_comments = '';
                                        } else {
                                            $pms_kpi_form_review_v3->reviewer_appraisal_comments = $review_details->reviewer_appraisal_comments;
                                        }
                                        // if ($pms_kpi_form_review_v3->is_reviewer_submitted == 1) {
                                        //     $pms_kpi_form_review_v3->reviewer_score  = $this->findScoreForForm(json_decode($pms_kpi_form_review_v3->reviewer_kpi_review, true)['reviewer_kpi']);
                                        // } else if ($pms_kpi_form_review_v3->is_assignee_submitted == 1) {
                                        //     $pms_kpi_form_review_v3->reviewer_score  = $this->findScoreForForm(json_decode($pms_kpi_form_review_v3->assignee_kpi_review, true)['assignee_kpi']);
                                        // } else {
                                        //     $pms_kpi_form_review_v3->reviewer_score  = null;
                                        // }
                                        if ($pms_kpi_form_review_v3->is_assignee_submitted == 1) {
                                            $pms_kpi_form_review_v3->reviewer_score = $this->findScoreForForm(json_decode($pms_kpi_form_review_v3->assignee_kpi_review, true)['assignee_kpi']);
                                        } else {
                                            $pms_kpi_form_review_v3->reviewer_score = 0;
                                        }
                                        $pms_kpi_form_review_v3->save();
                                    }
                                    array_push($response['assinged_forms'], 'assinge primary key - ' . $single_form_assign_record->id . ' --- v3 assinge_form_id - ' . $pms_kpi_form_assigned_v3->id);
                                } else {
                                    $temp_array['vmt_pms_kpiform_assigned primary key '] = $single_form_assign_record->id;
                                    $temp_array['error_reasons____input params'] = 'Missing vmt_pms_assignment_v3 table values for input params ($pms_assignment_setting_id , $old_form_assignment_period ) :  ' . $pms_assignment_setting_id . " , " . $old_form_assignment_period;

                                    array_push($response['these_assigned_infos_are_not_migreated'], $temp_array);
                                }
                            }
                        }
                    }
                    unset($oldFromDetailsIdAndNewFormDetailsId);
                    array_push($response['migrated_forms'], 'form_id - ' . $single_record->id . ' from_name - ' . $form_name);
                } else {
                    array_push($response['not migrated_form'], 'form_id - ' . $single_record->id . ' from_name - ' . $form_name);
                }
            }
            return response()->json([
                "status" => "Success",
                "message" => 'Pms Form Migrated Successfully',
                "data" => $response
            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => $e->getMessage(),
                "error_line" => $e->getLine(),
                "error_message" => $e->getTraceAsString(),
            ]);
        }
    }

    public function migreateAssignementSettings(Request $request)
    {
        try {
            $calender_type = VmtPMS_KPIFormAssignedModel::groupBy('calendar_type')->pluck('calendar_type');
            foreach ($calender_type as $single_calender_type) {
                $year = VmtPMS_KPIFormAssignedModel::where('calendar_type', $single_calender_type)->groupBy('year')->pluck('year');
                foreach ($year as $single_year) {
                    if ($single_calender_type == 'calendar_year') {
                        $v3_year = substr($single_year, -4);
                    } else if ($single_calender_type == 'financial_year') {
                        $v3_year = Carbon::parse('01-01-' . substr($single_year, -4))->subYear()->format('Y');
                    }
                    $frequency = VmtPMS_KPIFormAssignedModel::where('calendar_type', $single_calender_type)->where('year', $single_year)->groupBy('frequency')->pluck('frequency');
                    foreach ($frequency as $single_frequency) {
                        $client_id = VmtClientMaster::pluck('id');
                        foreach ($client_id as $single_client_id) {
                            $pmsv3_assignement_settings_v3 = new VmtPMSassignment_settings_v3;
                            $pmsv3_assignement_settings_v3->client_id = $single_client_id;
                            $pmsv3_assignement_settings_v3->calendar_type = $single_calender_type;
                            $pmsv3_assignement_settings_v3->year = $v3_year;
                            $pmsv3_assignement_settings_v3->frequency = $single_frequency;
                            $pmsv3_assignement_settings_v3->pms_rating_card = '[{"score_range":"0-54","performance_rating":"Not meet the Expectation","ranking":"5","action":"PIP","sort_order":1},{"score_range":"55-74","performance_rating":"Below Expectation","ranking":"4","action":"7","sort_order":2},{"score_range":"75-84","performance_rating":"Meet Expectation","ranking":"3","action":"10","sort_order":3},{"score_range":"85-94","performance_rating":"Exceed Expectation","ranking":"2","action":"12","sort_order":4},{"score_range":"95-100","performance_rating":"Exceptionally Exceed Expectation","ranking":"1","action":"15","sort_order":5}]';
                            $pmsv3_assignement_settings_v3->can_assign_upcoming_goals = "auto";
                            $pmsv3_assignement_settings_v3->annual_score_calc_method = "average";
                            $pmsv3_assignement_settings_v3->can_emp_proceed_next_pms = 1;
                            $pmsv3_assignement_settings_v3->can_org_proceed_next_pms = 1;
                            $pmsv3_assignement_settings_v3->show_overall_score_self_app_scrn = 1;
                            $pmsv3_assignement_settings_v3->show_rating_card_review_page = 1;
                            $pmsv3_assignement_settings_v3->show_overall_scr_review_page = 1;
                            $pmsv3_assignement_settings_v3->save();
                            $this->populateAssignmentV3FromAssignmentSettings($pmsv3_assignement_settings_v3->id, $pmsv3_assignement_settings_v3->calendar_type, $pmsv3_assignement_settings_v3->year, $pmsv3_assignement_settings_v3->frequency, $single_year);
                        }
                    }
                }
            }
            return 'PMS Assignment SettingsSaved';
        } catch (\Exception $e) {
            return $response = ([
                'status' => 'failure',
                'message' => 'migreateAssignementSettings()',
                'data' => $e->getTraceAsString(),
            ]);
        }
    }

    public function populateAssignmentV3FromAssignmentSettings($assignment_setting_id, $calendar_type, $year, $frequency, $full_year)
    {
        if ($calendar_type == 'calendar_year') {
            $start_date = $year . '-01-01';
            $end_date = $year . '-12-31';
        } else if ($calendar_type == 'financial_year') {
            $start_date = $year . '-04-01';
            $end_date = Carbon::parse($year . '-03-31')->addYear()->format('Y-m-d');
        }
        $available_columns = VmtPMS_KPIFormModel::join('vmt_pms_kpiform_assigned', 'vmt_pms_kpiform_assigned.vmt_pms_kpiform_id', '=', 'vmt_pms_kpiform.id')
            ->groupBy('available_columns')
            ->where('year', $full_year)->where('calendar_type', $calendar_type)
            ->first()->available_columns;
        $available_columns_str = $this->getColumnFromOldForm($available_columns);
        if ($frequency == 'monthly') {
            for ($i = 0; $i < 12; $i++) {
                $pms_assignment_v3 = new VmtPmsAssignmentV3;
                $pms_assignment_v3->pms_assignment_settings_id = $assignment_setting_id;
                $pms_assignment_v3->assignment_period = 'M' . $i + 1;
                $pms_assignment_v3->assignment_start_date = Carbon::parse($start_date)->addMonths($i)->startOfMonth()->format('Y-m-d');
                $pms_assignment_v3->assignment_end_date = Carbon::parse($pms_assignment_v3->assignment_start_date)->endOfMonth()->format('Y-m-d');
                $pms_assignment_v3->selected_headers = $available_columns_str;
                $pms_assignment_v3->who_can_set_goal = '["EMP","L1"]';
                $pms_assignment_v3->final_kpi_score_based_on = 'L1';
                $pms_assignment_v3->should_mgr_appr_rej_goals = 1;
                $pms_assignment_v3->should_emp_acp_rej_goals = 1;
                $pms_assignment_v3->should_emp_acp_rej_goals = 1;
                $pms_assignment_v3->reviewers_flow = '[{"order":"1","reviewer_level":"L1","is_review_mandatory":0}]';
                $pms_assignment_v3->save();
            }
        } else if ($frequency == 'quarterly') {
            $k = 0;
            for ($j = 0; $j < 4; $j++) {
                if ($j != 0) {
                    $k = $k + 3;
                }
                $pms_assignment_v3 = new VmtPmsAssignmentV3;
                $pms_assignment_v3->pms_assignment_settings_id = $assignment_setting_id;
                $pms_assignment_v3->assignment_period = 'Q' . $j + 1;
                $pms_assignment_v3->assignment_start_date = Carbon::parse($start_date)->addMonths($k)->startOfMonth()->format('Y-m-d');
                $pms_assignment_v3->assignment_end_date = Carbon::parse($pms_assignment_v3->assignment_start_date)->addMonths(2)->endOfMonth()->format('Y-m-d');
                $pms_assignment_v3->selected_headers = $available_columns_str;
                $pms_assignment_v3->reviewers_flow = '[{"order":"1","reviewer_level":"L1","is_review_mandatory":0}]';
                $pms_assignment_v3->save();
            }
        } else if ($frequency == 'yearly') {
        } else if ($frequency == 'half_yearly') {
        } else if ($frequency == 'weekly') {
        }
    }

    public function getColumnFromOldForm($available_columns)
    {
        //  $available_columns_array = json_decode($available_columns,true)['available_columns'];
        $available_columns_array = explode(',', $available_columns);
        $format_avalilable_column = array();
        foreach ($available_columns_array as $single_column) {
            $temp_ar = array();
            switch ($single_column) {
                case 'dimension':
                    $temp_ar['header_name'] = 'dimension';
                    $temp_ar['header_label'] = 'Dimension';
                    $temp_ar['alias_name'] = '';
                    $temp_ar['is_selected'] = 1;
                    break;
                case 'kra':
                    $temp_ar['header_name'] = 'kra';
                    $temp_ar['header_label'] = 'KRA';
                    $temp_ar['alias_name'] = '';
                    $temp_ar['is_selected'] = 1;
                    break;
                case 'kpi':
                    $temp_ar['header_name'] = 'kpi';
                    $temp_ar['header_label'] = 'KPI';
                    $temp_ar['alias_name'] = '';
                    $temp_ar['is_selected'] = 1;
                    break;
                case 'frequency':
                    $temp_ar['header_name'] = 'frequency';
                    $temp_ar['header_label'] = 'Frequency';
                    $temp_ar['alias_name'] = '';
                    $temp_ar['is_selected'] = 1;
                    break;
                case 'target':
                    $temp_ar['header_name'] = 'target';
                    $temp_ar['header_label'] = 'Target';
                    $temp_ar['alias_name'] = '';
                    $temp_ar['is_selected'] = 1;
                    break;
                case 'kpi_weightage':
                    $temp_ar['header_name'] = 'kpi_weightage';
                    $temp_ar['header_label'] = 'KPI - Weightage %';
                    $temp_ar['alias_name'] = '';
                    $temp_ar['is_selected'] = 1;
                    break;
            }
            array_push($format_avalilable_column, $temp_ar);
        }
        return json_encode($format_avalilable_column, true);
    }

    public function getOldFromAssignment_Period($calendar_type, $frequency, $assignment_period)
    {
        if ($calendar_type == 'calendar_year') {
            if ($frequency == 'monthly') {
                switch ($assignment_period) {
                    case 'jan':
                        return 'M1';
                    case 'feb':
                        return 'M2';
                    case 'mar':
                        return 'M3';
                    case 'apr':
                        return 'M4';
                    case 'may':
                        return 'M5';
                    case 'june':
                        return 'M6';
                    case 'july':
                        return 'M7';
                    case 'aug':
                        return 'M8';
                    case 'sept':
                        return 'M9';
                    case 'oct':
                        return 'M10';
                    case 'nov':
                        return 'M11';
                    case 'dec':
                        return 'M12';
                }
            } else if ($frequency == 'quarterly') {
                return ucfirst($assignment_period);
            }
        } else if ($calendar_type == 'financial_year') {
            if ($frequency == 'monthly') {
                switch ($assignment_period) {
                    case 'apr':
                        return 'M1';
                    case 'may':
                        return 'M2';
                    case 'june':
                        return 'M3';
                    case 'july':
                        return 'M4';
                    case 'aug':
                        return 'M5';
                    case 'sept':
                        return 'M6';
                    case 'oct':
                        return 'M7';
                    case 'nov':
                        return 'M8';
                    case 'dec':
                        return 'M9';
                    case 'jan':
                        return 'M10';
                    case 'feb':
                        return 'M11';
                    case 'mar':
                        return 'M12';
                }
            } else if ($frequency == 'quarterly') {
                return ucfirst($assignment_period);
            }
        }
    }
    public function oldFormDetails($reviewer_accepted, $reviewer_submitted, $reviewer_score)
    {
        $temp_ar = array();
        $response = array();
        $reviewer_accepted_ar = json_decode($reviewer_accepted, true);
        $reviewer_submitted_ar = json_decode($reviewer_submitted, true);
        $user_id = array_key_first($reviewer_accepted_ar);
        $temp_ar['reviewer_id'] = $user_id;
        $temp_ar['reviewer_user_code'] = User::where('id', $user_id)->first()->user_code;
        $temp_ar['reviewer_level'] = 'L1';
        $temp_ar['review_order'] = 1;
        $temp_ar['is_accepted'] = ($reviewer_accepted_ar[$user_id] == null) ? 0 : $reviewer_accepted_ar[$user_id];
        $temp_ar['is_reviewed'] = ($reviewer_submitted_ar[$user_id] == null) ? 0 : $reviewer_submitted_ar[$user_id];
        $temp_ar['acceptreject_date'] = '';
        $temp_ar['reviewed_date'] = '';
        $temp_ar['rejection_comments'] = '';
        $temp_ar['reviewer_score'] = $reviewer_score;
        array_push($response, $temp_ar);
        return json_encode($response, true);
    }
    public function reviewJson($user_id, $kpi_review, $kpi_percentage, $kpi_comments, $type, $kpi_form_ids)
    {
        $response = array();
        if ($type == 'asingee') {
            $response['assignee_id'] = $user_id;
            $response['assignee_user_code'] = User::where('id', $user_id)->first()->user_code;
            if ($kpi_review == null & $kpi_percentage == null & $kpi_comments == null && $kpi_form_ids == null) {
                $assingee_kpi = null;
            } else {
                $assingee_kpi = $this->convertOldJsonFormatToNewJson(json_decode($kpi_review, true), json_decode($kpi_percentage, true), $kpi_comments == null ? null : json_decode($kpi_comments, true), $kpi_form_ids);
            }

            // $response['assignee_score'] = $this->findScoreForForm($assingee_kpi);
            $response['assignee_kpi'] = $assingee_kpi;
        } else if ($type == 'reviewer') {
            $temp_ar = array();
            $temp_ar['reviewer_id'] = $user_id;
            $temp_ar['reviewer_user_code'] = User::where('id', $user_id)->first()->user_code;
            if ($kpi_review == null & $kpi_percentage == null & $kpi_comments == null && $kpi_form_ids == null) {
                $temp_ar['reviewer_kpi'] = null;
            } else {
                $temp_ar['reviewer_kpi'] = $this->convertOldJsonFormatToNewJson(json_decode($kpi_review, true)[$user_id], json_decode($kpi_percentage, true)[$user_id], $kpi_comments == null ? null : json_decode($kpi_comments, true)[$user_id], $kpi_form_ids);
            }
            array_push($response, $temp_ar);
            unset($temp_ar);
        }
        return json_encode($response, true);
    }
    public function convertOldJsonFormatToNewJson($kpi_review_json, $kpi_percentage_json, $kpi_comments_json, $kpi_form_ids)
    {
        $response = array();
        $temp_ar = array();
        foreach ($kpi_form_ids as $old_id => $new_id) {
            $temp_ar['form_details_id'] = $new_id;
            $temp_ar['kpi_review'] = $kpi_review_json[$old_id];
            $temp_ar['kpi_percentage'] = $kpi_percentage_json[$old_id];
            if ($kpi_comments_json != null) {
                if ($kpi_comments_json[$old_id] != null) {
                    $temp_ar['kpi_comments'] = $kpi_comments_json[$old_id];
                } else {
                    $temp_ar['kpi_comments'] = '';
                }
            } else {
                $temp_ar['kpi_comments'] = '';
            }
            array_push($response, $temp_ar);
            unset($temp_ar);
        }
        return $response;
    }

    public function findScoreForForm($reviewer_kpi_review)
    {
        $total = 0;
        if (!empty($reviewer_kpi_review)) {
            foreach ($reviewer_kpi_review as $single_record) {
                $total = $total + (int) $single_record['kpi_percentage'];
            }
        }
        return $total;
    }

    public function departmentDesignationChanges(){

        $employee_json = '[{"Employee ID":"DM004","Designation":"PROCUREMENT HEAD","Department":"Purchase"},{"Employee ID":"DM006","Designation":"ELECTRICAL - HEAD","Department":"Electrical"},{"Employee ID":"DM007","Designation":"TURNER","Department":"Production"},{"Employee ID":"DM009","Designation":"ASSEMBLY TECHNICIAN","Department":"Production"},{"Employee ID":"DM012","Designation":"WELDER","Department":"Production"},{"Employee ID":"DM018","Designation":"SERVICE HEAD","Department":"Services"},{"Employee ID":"DM021","Designation":"RESEARCH & DEVELOPEMENT - HEAD","Department":"Design"},{"Employee ID":"DM022","Designation":"STORE KEEPER","Department":"Stores"},{"Employee ID":"DM024","Designation":"DIGITAL MARKETING EXECUTIVE","Department":"Marketing"},{"Employee ID":"DM026","Designation":"BUFFER","Department":"Production"},{"Employee ID":"DM028","Designation":"SERVICE ENGINEER","Department":"Services"},{"Employee ID":"DM029","Designation":"SERVICE ENGINEER","Department":"Services"},{"Employee ID":"DM032","Designation":"TURNER","Department":"Production"},{"Employee ID":"DM038","Designation":"MAINT. TECHNICIAN","Department":"Production"},{"Employee ID":"DM045","Designation":"MNDR OPERATOR","Department":"Production"},{"Employee ID":"DM054","Designation":"HOUSE KEEPING ASST","Department":"House Keeping"},{"Employee ID":"DM059","Designation":"STORE KEEPER","Department":"Stores"},{"Employee ID":"DM069","Designation":"ASSEMBLY ENGINEER","Department":"Production"},{"Employee ID":"DM071","Designation":"ACCOUNTS MANAGER","Department":"Accounts"},{"Employee ID":"DM079","Designation":"ASST. MANAGER","Department":"Management "},{"Employee ID":"DM088","Designation":"QUALITY CONTROL ENGINEER","Department":"Quality"},{"Employee ID":"DM091","Designation":"WELDER","Department":"Production"},{"Employee ID":"DM094","Designation":"SUPERVISOR","Department":"Production"},{"Employee ID":"DM101","Designation":"ASSEMBLY - HELPER","Department":"Production"},{"Employee ID":"DM103","Designation":"BUFFER","Department":"Production"},{"Employee ID":"DM104","Designation":"ASSEMBLY TECHNICIAN","Department":"Production"},{"Employee ID":"DM106","Designation":"VENDOR DEVPT EXE","Department":"Purchase"},{"Employee ID":"DM107","Designation":"ASSEMBLY TECHNICIAN","Department":"Production"},{"Employee ID":"DM109","Designation":"DRIVER","Department":"Transport and Courier"},{"Employee ID":"DM110","Designation":"DRIVER","Department":"Transport and Courier"},{"Employee ID":"DM112","Designation":"ASSEMBLY TECHNICIAN","Department":"Production"},{"Employee ID":"DM113","Designation":"ASSEMBLY TECHNICIAN","Department":"Production"},{"Employee ID":"DM115","Designation":"TURNER","Department":"Production"},{"Employee ID":"DM118","Designation":"MARKETING EXECUTIVE","Department":"Marketing"},{"Employee ID":"DM120","Designation":"FITTER ASSEMBLY","Department":"Production"},{"Employee ID":"DM122","Designation":"SENIOR TECH","Department":"Production"},{"Employee ID":"DM123","Designation":"FITTER ASSEMBLY","Department":"Production"},{"Employee ID":"DM124","Designation":"WELDER","Department":"Production"},{"Employee ID":"DM125","Designation":"FITTER ","Department":"Production"},{"Employee ID":"DM127","Designation":"WELDER","Department":"Production"},{"Employee ID":"DM128","Designation":"SERVICE TECH","Department":"Services"},{"Employee ID":"DM131","Designation":"GRAPHIC DESIGNER","Department":"Design"},{"Employee ID":"DM134","Designation":"SERVICE COORDINATOR","Department":"Services"},{"Employee ID":"DM140","Designation":"QC ENGINEER","Department":"Quality"},{"Employee ID":"DM141","Designation":"SENIOR TECHNICIAN","Department":"Production"},{"Employee ID":"DM145","Designation":"HOUSE KEEPING ASST","Department":"House Keeping"},{"Employee ID":"DM146","Designation":"SERVICE TECH","Department":"Services"},{"Employee ID":"DM148","Designation":"SERVICE ENGINEER","Department":"Services"},{"Employee ID":"DM149","Designation":"MACHINE OPERATOR","Department":"Production"},{"Employee ID":"DM150","Designation":"CNC OPERATOR","Department":"Production"},{"Employee ID":"DM151","Designation":"STORES ASST. ","Department":"Stores"},{"Employee ID":"DM154","Designation":"VENDOR QUALITY TECHNICIAN","Department":"Purchase"},{"Employee ID":"DM156","Designation":"HELPER - FABRICATION","Department":"Production"},{"Employee ID":"DM159","Designation":"VIDEO EDITOR","Department":"Design"},{"Employee ID":"DM161","Designation":"SERVICE TECHNICIAN","Department":"Services"},{"Employee ID":"DM162","Designation":"SERVICE TECHNICIAN","Department":"Services"},{"Employee ID":"DM165","Designation":"VMC OPERATOR","Department":"Production"},{"Employee ID":"DM166","Designation":"SERVICE TECHNICIAN","Department":"Services"},{"Employee ID":"DM167","Designation":"SERVICE TECHNICIAN","Department":"Services"},{"Employee ID":"DM170","Designation":"VMC OPERATOR","Department":"Production"},{"Employee ID":"DM172","Designation":"TELEMARKETING EXECUTIVE","Department":"Marketing"},{"Employee ID":"DM173","Designation":"TELEMARKETING EXECUTIVE","Department":"Marketing"},{"Employee ID":"DM174","Designation":"TELEMARKETING COORDINATOR","Department":"Marketing"},{"Employee ID":"DM175","Designation":" SERIVICE TECHNICIAN","Department":"Services"},{"Employee ID":"DM176","Designation":"HOUSE KEEPING ASST.","Department":"House Keeping"},{"Employee ID":"DM177","Designation":"ASSEMBLY TECHNICIAN","Department":"Production"},{"Employee ID":"DM178","Designation":"HOUSE KEEPING ASST.","Department":"House Keeping"},{"Employee ID":"DM179","Designation":"CNC OPERATOR","Department":"Production"},{"Employee ID":"DM180","Designation":"ASSEMBLY TECHNICIAN","Department":"Production"},{"Employee ID":"DM181","Designation":"ASSEMBLY TECHNICIAN","Department":"Production"},{"Employee ID":"DM183","Designation":"HOUSE KEEPING ASST.","Department":"House Keeping"},{"Employee ID":"DM184","Designation":"HR EXECUTIVE","Department":"Human Resources"},{"Employee ID":"DM185","Designation":"SENIOR ASSEMBLY TECHNICIAN","Department":"Production"},{"Employee ID":"DM187","Designation":"CNC PROGRAMMER","Department":"Production"},{"Employee ID":"DM188","Designation":"DRIVER","Department":"Transport and Courier"},{"Employee ID":"DM189","Designation":"WELDER","Department":"Production"},{"Employee ID":"DM190","Designation":"ASSEMBLY TECHNICIAN","Department":"Production"},{"Employee ID":"DM191","Designation":"LAB TECHNICIAN","Department":"Production"},{"Employee ID":"DM192","Designation":" SERIVICE TECHNICIAN","Department":"Services"},{"Employee ID":"DM193","Designation":"ACCOUNTS EXECUTIVE","Department":"Accounts"},{"Employee ID":"DM194","Designation":"ASSEMBLY TECHNICIAN","Department":"Production"},{"Employee ID":"DM195","Designation":" SERIVICE TECHNICIAN","Department":"Services"},{"Employee ID":"DM196","Designation":"SERVICE ENGINEER","Department":"Services"},{"Employee ID":"DM198","Designation":"CNC Operator","Department":"Production"},{"Employee ID":"DM199","Designation":"WELDER","Department":"Production"},{"Employee ID":"DM200","Designation":"WELDER","Department":"Production"},{"Employee ID":"DM201","Designation":"HOUSE KEEPING ASST.","Department":"House Keeping"},{"Employee ID":"DM202","Designation":"SERVICE ENGINEER","Department":"Services"},{"Employee ID":"DM203","Designation":" SERIVICE TECHNICIAN","Department":"Services"},{"Employee ID":"DM204","Designation":"TELEMARKETING EXECUTIVE","Department":"Marketing"},{"Employee ID":"DM205","Designation":"WELDER","Department":"Production"},{"Employee ID":"DM206","Designation":"PRODUCTION COORDINATOR","Department":"Production"},{"Employee ID":"DM207","Designation":"SERVICE ASSISTANT","Department":"Services"},{"Employee ID":"DM208","Designation":"WELDER","Department":"Production"},{"Employee ID":"DM209","Designation":"ASSEMBLY HELPER","Department":"Production"},{"Employee ID":"DM210","Designation":"MARKETING EXECUTIVE","Department":"Marketing"},{"Employee ID":"DM211","Designation":"SERVICE TECHNICIAN","Department":"Services"},{"Employee ID":"DM212","Designation":"SERVICE TECHNICIAN","Department":"Services"},{"Employee ID":"DM213","Designation":"Tapping Assistant","Department":"Production"},{"Employee ID":"DM214","Designation":"VMC Operator","Department":"Production"},{"Employee ID":"DM215","Designation":"ASSEMBLY TECHNICIAN","Department":"Production"},{"Employee ID":"DM216","Designation":"PRODUCTION INCHARGE","Department":"Production"},{"Employee ID":"DM217","Designation":"MECHANICAL DESIGN ENGINEER","Department":"Design"},{"Employee ID":"DM218","Designation":"JUNIOR DESIGN ENGINEER","Department":"Design"},{"Employee ID":"DM220","Designation":"Tapping Assistant","Department":"Production"},{"Employee ID":"DM221","Designation":"JUNIOR DESIGN ENGINEER","Department":"Design"},{"Employee ID":"DM222","Designation":"VMC PROGRAMMER","Department":"Production"},{"Employee ID":"DM223","Designation":"VMC OPERATOR","Department":"Production"},{"Employee ID":"DM224","Designation":"TURNER","Department":"Production"},{"Employee ID":"DM225","Designation":"SERVICE TECHNICIAN","Department":"Services"},{"Employee ID":"DM226","Designation":"ASSEMBLY TECHNICIAN","Department":"Production"},{"Employee ID":"DM227","Designation":"ASSEMBLY TECHNICIAN","Department":"Production"},{"Employee ID":"DM228","Designation":"VMC OPERATOR","Department":"Production"},{"Employee ID":"DM229","Designation":"ASSEMBLY TECHNICIAN","Department":"Production"},{"Employee ID":"DM230","Designation":"ASSEMBLY TECHNICIAN","Department":"Production"},{"Employee ID":"DM231","Designation":"TRAINEE DESIGN ENGINEER","Department":"Design"},{"Employee ID":"DM232","Designation":"ASSEMBLY TECHNICIAN","Department":"Production"},{"Employee ID":"DM233","Designation":"QUALITY ASST.","Department":"Quality"},{"Employee ID":"DM234","Designation":"GLOBAL SOURCING EXECUTIVE","Department":"Purchase"},{"Employee ID":"DM235","Designation":"ASSEMBLY TECHNICIAN","Department":"Production"}]';

      $json_decode_duna = json_decode($employee_json,true);

      $arr = [];
      foreach($json_decode_duna as $single_emp){

       $user_id =  User::where('user_code',$single_emp['Employee ID'])->first()->id ?? null;
       if($user_id != null){
            $exists_emp = VmtEmployeeOfficeDetails::where('user_id',$user_id)->first();
            // dd($exists_emp);
        if($exists_emp->exists()){
            $exists_emp->department_id = Department::where('name',$single_emp['Department'])->first()->id ?? 0;
            $exists_emp->designation = $single_emp['Designation'];
            $exists_emp->save();
       }
      }

    }
     return 'sucessfully dept , designation changed';
}

}
