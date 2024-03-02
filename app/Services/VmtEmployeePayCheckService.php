<?php

namespace App\Services;

use App\Models\AbsActivePayslip;
use App\Models\VmtOrgTimePeriod;
use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Dompdf\Options;
use PDF;
use Carbon\Carbon;
use DateTime;
use App;
use App\Jobs\SendEmployeePayslip;

use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\VmtClientMaster;
use App\Models\VmtEmployeeCompensatoryDetails;
use App\Models\VmtEmployeePaySlipV2;
use App\Models\VmtEmpActivePaygroup;
use App\Models\VmtPayrollComponents;
use App\Models\VmtEmpPayGroupValues;
use App\Models\VmtEmployee;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\Compensatory;
use App\Models\VmtEmployeeStatutoryDetails;
use App\Models\VmtEmployeeFamilyDetails;
use App\Models\VmtEmployeePayslipStatus;
use App\Notifications\ViewNotification;
use Illuminate\Support\Facades\Notification;
use App\Mail\WelcomeMail;
use App\Models\VmtEmployeePaySlip;
use App\Models\VmtEmployeePayroll;
use App\Models\VmtPayroll;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;


use App\Imports\VmtPaySlip;
use App\Models\Bank;

use Mail;
use App\Mail\PayslipMail;
use Illuminate\Support\Facades\Storage;

class VmtEmployeePayCheckService
{

    /*
  class VmtEmployeePayCheckService {

    /*
        NOTE:
        1. For checking wthr user exists, use VmtEmployeeService::isUserExist()
    */

    // public function importBulkEmployeesPayslipExcelData($data)
    // {

    //     $validator =   \Validator::make(
    //         $data,
    //         ['file' => 'required|file|mimes:xls,xlsx'],
    //         ['required' => 'The :attribute is required.']
    //     );

    //     if ($validator->passes()) {
    //         $importDataArry = \Excel::toArray(new VmtPaySlip, request()->file('file'));
    //         return $this->storeBulkEmployeesPayslips($importDataArry);
    //     } else {
    //         $data['failed'] = $validator->errors()->all();
    //         $responseJSON['status'] = 'failure';
    //         $responseJSON['message'] = $data['failed'][0];//"Please fix the below excelsheet data";
    //         //$responseJSON['data'] = $validator->errors()->all();
    //         return response()->json($responseJSON);
    //     }
    //     // linking Manager To the employees;
    //     // $linkToManager  = \Excel::import(new VmtEmployeeManagerImport, request()->file('file'));
    // }

    private function trimArrayElements(&$value)
    {
        $value = trim($value);
        return $value;
    }

    public function storeBulkEmployeesPayslips(Request $request)
    {

        $data = array_filter($request->all());

        ini_set('max_execution_time', 3000);
        //For output jsonresponse
        $data_array = [];
        //For validation
        $isAllRecordsValid = true;

        $rules = [];
        $responseJSON = [
            'status' => 'none',
            'message' => 'none',
            'data' => [],
        ];
        $modified_data = array();

        foreach ($data as $key => $excelRowdata) {
            $trimmedArray = array_map('trim', array_keys($excelRowdata));

            $processed_data = str_replace(' ', '_', $trimmedArray);

            $Emp_data = array_combine(array_map('strtolower', $processed_data), array_values($excelRowdata));

            array_push($modified_data, $Emp_data);
        }

        $corrected_data = $modified_data;
        $j = array_keys($data);

        foreach ($corrected_data as &$Single_data) {


            if (array_key_exists('dob', $Single_data) && is_int($Single_data['dob'])) {

                $Single_data['dob'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Single_data['dob'])->format('Y-m-d');
            }
            if (array_key_exists('doj', $Single_data) && is_int($Single_data['doj'])) {

                $Single_data['doj'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Single_data['doj'])->format('Y-m-d');
            }
            if (array_key_exists('payroll_month', $Single_data) && is_int($Single_data['payroll_month'])) {

                $Single_data['payroll_month'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Single_data['payroll_month'])->format('Y-m-d');
            }
        }
        unset($Single_data);

        // $excelRowdata = $data[0][0];
        $excelRowdata_row = $corrected_data;

        $currentRowInExcel = 0;
        $i = array_keys($excelRowdata_row);

        // if(!in_array('employee_code',array_keys($excelRowdata_row[0]))){
        //    dd($excelRowdata_row['emp_name']);
        // }

        foreach ($excelRowdata_row as $key => $excelRowdata) {
            $currentRowInExcel++;

            $excelRowdata[''] = trim($excelRowdata['employee_code']);
            //Validation
            $rules = [

                'employee_code' => [
                    function ($attribute, $value, $fail) {

                        $emp_client_code = preg_replace('/\d+/', '', $value);
                        $result = User::where('user_code', $value)->exists();

                        if (!$result) {
                            $fail('No matching client exists for the given Employee Code : ' . $value);
                        }
                    },
                ],
                "employee_name" => "nullable",
                "designation" => "nullable",
                "doj" => "nullable",
                "location" => "nullable",
                "dob" => "nullable",
                "father_name" => "nullable",
                "pan_number" => "nullable",
                "aadhar_number" => "nullable",
                "uan" => "nullable",
                "epf_number" => "nullable",
                "bank_name" => "nullable",
                "account_number" => "nullable",
                "bank_ifsc_code" => "nullable",
                "payroll_month" => "nullable",
                "month_days" => "required",
                "worked_days" => "required",
                "arrears_days" => "required",
                "lop" => "required",
                "basic" => "required",
                "hra" => "required",
                "lta" => "nullable",
                "special_allowance" => "required",
                "total_fixed_gross" => "required",
                "earned_basic" => "required",
                "basic_arrear" => "nullable",
                "earned_hra" => "nullable",
                "hra_arrear" => "nullable",
                "earned_lta" => "required",
                "lta_arrear" => "nullable",
                "earned_special_allowance" => "nullable",
                "special_allowance_arrear" => "nullable",
                "child_education_allowance" => "nullable",
                "earned_child_education_allowance" => "nullable",
                "child_education_allowance_arrear" => "nullable",
                "variable_dearness_allowance" => "nullable",
                "earned_variable_dearness_allowance" => "nullable",
                "variable_dearness_allowance_arrear" => "nullable",
                "dearness_allowance" => "nullable",
                "earned_dearness_allowance" => "nullable",
                "dearness_allowance_arrear" => "nullable",
                "food_allowance" => "nullable",
                "earned_food_allowance" => "nullable",
                "food_allowance_arrear" => "nullable",
                "communication_allowance" => "nullable",
                "earned_communication_allowance" => "nullable",
                "communication_allowance_arrear" => "nullable",
                "unifrom_allowance" => "nullable",
                "earned_unifrom_allowance" => "nullable",
                "unifrom_allowance_arrear" => "nullable",
                "washing_allowance" => "nullable",
                "earned_washing_allowance" => "nullable",
                "washing_allowance_arrear" => "nullable",
                "medical_allowance" => "nullable",
                "medical_allowance_earned" => "nullable",
                "medical_allowance_arrear" => "nullable",
                "statutory_bonus" => "nullable",
                "earned_statutory_bonus" => "nullable",
                "statutory_bonus_arrear" => "nullable",
                "other_allowance" => "nullable",
                "vpf" => "nullable",
                "vpf_arrear" => "nullable",
                "total_earned_gross" => "required",
                "other_earnings" => "nullable",
                "daily_allowance" => "nullable",
                "daily_allowance_arrear" => "nullable",
                "overtime" => "nullable",
                "overtime_arrear" => "nullable",
                "epf_employer_contribution" => "nullable",
                "epf_employer_contribution_arrear" => "nullable",
                "esic_employer_contribution" => "nullable",
                "pf_wages" => "nullable",
                "pf_wages_arrear" => "nullable",
                "edli_charges" => "nullable",
                "edli_charges_arrear" => "nullable",
                "pf_admin_charges" => "nullable",
                "pf_admin_charges_arrear" => "nullable",
                "employer_lwf" => "nullable",
                "ctc" => "required",
                "epf_employee_contribution" => "nullable",
                "epf_employee_contribution_arrear" => "nullable",
                "employee_esic_contribution" => "nullable",
                "lwf" => "nullable",
                "professional_tax" => "nullable",
                "income_tax" => "nullable",
                "salary_advance" => "nullable",
                "canteen_deduction" => "nullable",
                "medical_deduction" => "nullable",
                "uniform_deduction" => "nullable",
                "loan_deduction" => "nullable",
                "other_deduction" => "nullable",
                "total_deduction" => "nullable",
                "net_take_home" => "nullable",
                "el_opn_bal" => "nullable",
                "availed_el" => "nullable",
                "balance_el" => "nullable",
                "sl_open_balance" => "nullable",
                "availed_sl" => "nullable",
                "balance_sl" => "nullable",
                "travel_conveyance" => "nullable",
                "vechile_reimburstment" => "nullable",
                "driver_salary" => "nullable",
                "fuel_reimbursement" => "nullable",
                "incentive" => "nullable",
                "leave_encashment" => "nullable",
                "referral_bonus" => "nullable",
                "ex_gratia" => "nullable",
                "gift_payment" => "nullable",
                "attendance_bonus" => "nullable",
            ];

            $messages = [
                'required' => 'Field <b>:attribute</b> is required',
                'exists' => 'Column <b>:attribute</b> with value <b>:input</b> doesnt not exist',
                'regex' => 'Field <b>:attribute</b> is invalid',
                'numeric' => 'Field <b>:attribute</b> is invalid',
            ];

            $validator = Validator::make($excelRowdata, $rules, $messages);

            if (!$validator->passes()) {

                $rowDataValidationResult = [
                    'row_number' => $currentRowInExcel,
                    'status' => 'failure',
                    'message' => 'In Excel Row - ' . $excelRowdata['employee_code'] . ' : ' . $currentRowInExcel . ' has following error(s)',
                    'error_fields' => json_encode($validator->errors()),
                ];

                array_push($data_array, $rowDataValidationResult);

                $isAllRecordsValid = false;
            }
        } //for loop
        //Runs only if all excel records are valid
        if ($isAllRecordsValid) {
            foreach ($excelRowdata_row as $key => $excelRowdata) {
                $rowdata_response = $this->storeSingleRecord_EmployeePayslip($excelRowdata);

                array_push($data_array, $rowdata_response);
            }

            $responseJSON['status'] = 'success';
            $responseJSON['message'] = "Excelsheet data import success";
            $responseJSON['data'] = $data_array;
        } else {
            $responseJSON['status'] = 'failure';
            $responseJSON['message'] = "Please fix the below excelsheet data";
            $responseJSON['data'] = $data_array;
        }

        //dd($responseJSON);

        //$data = ['success'=> $returnsuccessMsg, 'failed'=> $returnfailedMsg, 'failure_json' => $failureJSON, 'success_count'=> $addedCount, 'failed_count'=> $failedCount];
        return response()->json($responseJSON);
    }


    private function storeSingleRecord_EmployeePayslip($row)
    {

        $row['employee_code'] = trim($row['employee_code']);

        $empNo = $row['employee_code'];
        try {

            $user = User::where('user_code', $row['employee_code'])->first();
            $user_id = $user->id;

            //update employee's details 'vmt_employee_details'
            $emp_details = VmtEmployee::where('userid', $user_id);

            //Store the data into vmt_employee_payslip table
            $empPaySlip = new VmtEmployeePaySlipV2;
            $empPaySlip->gender = $row['gender'] ?? null;
            $empPaySlip->designation = $row['designation'];
            $empPaySlip->department = $row['department'] ?? null;
            $empPaySlip->location = $row['location'];
            $empPaySlip->father_name = $row['father_name'] ?? null;
            $empPaySlip->pan_number = $row['pan_number'] ?? null;
            $empPaySlip->aadhar_number = $row['aadhar_number'] ?? null;
            $empPaySlip->uan = $row['uan'] ?? null;
            $empPaySlip->epf_number = $row["epf_number"] ?? null; // => "EPF123"
            $empPaySlip->esic_number = $row["esic_number"] ?? null; // => "Not Applicable",
            $empPaySlip->Bank_Name = $row["bank_name"] ?? null;
            $empPaySlip->account_number = $row["account_number"] ?? null;
            $empPaySlip->bank_ifsc_code = $row["bank_ifsc_code"] ?? null;

            $client_id = User::where('user_code', $row['employee_code'])->first()->client_id;

            $payroll_date = \DateTime::createFromFormat('d-m-Y', $row["payroll_month"])->format('Y-m-d');
            //check already exist or not
            $Payroll_data = VmtPayroll::where('client_id', $client_id)->where('payroll_date', $payroll_date)->first();
            if (empty($Payroll_data)) {
                $empPaySlipmonth = new VmtPayroll;
                $empPaySlipmonth->client_id = $client_id;
                $empPaySlipmonth->payroll_date = $payroll_date;
                $empPaySlipmonth->save();
            }

            $payroll_id = VmtPayroll::where('payroll_date', $payroll_date)->where('client_id', $client_id)->first()->id;
            $emp_payroll_data = VmtEmployeePayroll::where('payroll_id', $payroll_id)->where('user_id', $user_id)->first();
            if (empty($emp_payroll_data)) {
                $query_payroll_data = new VmtEmployeePayroll;
                $query_payroll_data->user_id = $user_id;
                $payroll_id = VmtPayroll::where('payroll_date', $payroll_date)->where('client_id', $client_id)->first()->id;
                $query_payroll_data->payroll_id = $payroll_id;
                $query_payroll_data->save();
            }

            $emp_payroll_id = VmtEmployeePayroll::where('user_id', $user_id)->where('payroll_id', $payroll_id)->first()->id;
            $emp_payslip_data = VmtEmployeePaySlipV2::where('emp_payroll_id', $emp_payroll_id)->first();


            if (empty($emp_payslip_data)) {
                $emp_payroll_id = VmtEmployeePayroll::where('user_id', $user_id)->where('payroll_id', $payroll_id)->first()->id;
                $empPaySlip->emp_payroll_id = $emp_payroll_id;
                $empPaySlip->basic = $row["basic"];
                $empPaySlip->hra = $row["hra"];
                $empPaySlip->child_edu_allowance = $row["child_education_allowance"] ?? 0;
                $empPaySlip->spl_alw = $row["special_allowance"] ?? 0;
                $empPaySlip->total_fixed_gross = $row["total_fixed_gross"] ?? 0;
                $empPaySlip->month_days = $row["month_days"];
                $empPaySlip->worked_days = $row["worked_days"];
                $empPaySlip->arrears_days = $row["arrears_days"];
                $empPaySlip->lop = $row["lop"];
                $empPaySlip->earned_basic = $row["earned_basic"];
                $empPaySlip->basic_arrear = $row["basic_arrear"];
                $empPaySlip->earned_hra = $row["earned_hra"];
                $empPaySlip->hra_arrear = $row["hra_arrear"];

                $empPaySlip->earned_child_edu_allowance = $row["earned_child_education_allowance"] ?? 0;
                $empPaySlip->child_edu_allowance_arrear = $row["child_education_allowance_arrear"] ?? 0;

                $empPaySlip->medical_allowance = $row["medical_allowance"] ?? 0;
                $empPaySlip->medical_allowance_earned = $row["medical_allowance_earned"] ?? 0;
                $empPaySlip->medical_allowance_arrear = $row["medical_allowance_arrear"] ?? 0;

                $empPaySlip->earned_spl_alw = $row["earned_special_allowance"] ?? 0;
                $empPaySlip->spl_alw_arrear = $row["special_allowance_arrear"] ?? 0;

                $empPaySlip->communication_allowance = $row["communication_allowance"] ?? 0;
                $empPaySlip->communication_allowance_earned = $row['earned_communication_allowance'] ?? 0;
                $empPaySlip->communication_allowance_arrear = $row['communication_allowance_arrear'] ?? 0;

                $empPaySlip->food_allowance = $row["food_allowance"] ?? 0;
                $empPaySlip->food_allowance_earned = $row['earned_food_allowance'] ?? 0;
                $empPaySlip->food_allowance_arrear = $row['food_allowance_arrear'] ?? 0;

                $empPaySlip->stats_bonus = $row["statutory_bonus"] ?? 0;
                $empPaySlip->earned_stats_bonus = $row["earned_statutory_bonus"] ?? 0;
                $empPaySlip->earned_stats_arrear = $row["statutory_bonus_arrear"] ?? 0;

                $empPaySlip->washing_allowance = $row['washing_allowance'] ?? 0;
                $empPaySlip->washing_allowance_earned = $row['earned_washing_allowance'] ?? 0;
                $empPaySlip->washing_allowance_arrear = $row['washing_allowance_arrear'] ?? 0;

                $empPaySlip->dearness_allowance = $row['dearness_allowance'] ?? 0;
                $empPaySlip->dearness_allowance_earned = $row['earned_dearness_allowance'] ?? 0;
                $empPaySlip->dearness_allowance_arrear = $row['dearness_allowance_arrear'] ?? 0;

                $empPaySlip->vda = $row['vda'] ?? 0;
                $empPaySlip->vda_earned = $row['earned_vda'] ?? 0;
                $empPaySlip->vda_arrear = $row['vda_arrear'] ?? 0;

                $empPaySlip->uniform_allowance = $row['uniform_allowance'] ?? 0;
                $empPaySlip->uniform_allowance_earned = $row['uniform_allowance_earned'] ?? 0;
                $empPaySlip->uniform_allowance_arrear = $row['uniform_allowance_arrear'] ?? 0;

                $empPaySlip->vehicle_reimbursement = $row["vehicle_reimbursement"] ?? 0;
                $empPaySlip->vehicle_reimbursement_earned = $row["vehicle_reimbursement_earned"] ?? 0;
                $empPaySlip->vehicle_reimbursement_arrear = $row["vehicle_reimbursement_arrear"] ?? 0;

                $empPaySlip->driver_salary = $row["driver_salary"] ?? 0;
                $empPaySlip->driver_salary_earned = $row["driver_salary_earned"] ?? 0;
                $empPaySlip->driver_salary_arrear = $row["driver_salary_arrear"] ?? 0;

                $empPaySlip->fuel_reimbursement = $row["fuel_reimbursement"] ?? 0;
                $empPaySlip->fuel_reimbursement_earned = $row["fuel_reimbursement_earned"] ?? 0;
                $empPaySlip->fuel_reimbursement_arrear = $row["fuel_reimbursement_arrear"] ?? 0;
                $empPaySlip->leave_encashment = $row["leave_encashment"] ?? 0;

                $empPaySlip->incentive = $row["incentive"] ?? 0;
                $empPaySlip->ex_gratia = $row["ex_gratia"] ?? 0;
                $empPaySlip->gift_payment = $row["gift_payment"] ?? 0;
                $empPaySlip->attendance_bonus = $row["attendance_bonus"] ?? 0;

                $empPaySlip->referral_bonus = $row["referral_bonus"] ?? 0;
                $empPaySlip->incentive_arrear = $row["incentive_arrear"] ?? 0;


                $empPaySlip->lta = $row["lta"] ?? 0;
                $empPaySlip->earned_lta = $row["earned_lta"] ?? 0;
                $empPaySlip->lta_arrear = $row["lta_arrear"] ?? 0;

                $empPaySlip->other_allowance = $row["other_allowance"] ?? 0;
                $empPaySlip->other_allowance_earned = $row["other_allowance_earned"] ?? 0;
                $empPaySlip->other_allowance_arrear = $row["other_allowance_arrear"] ?? 0;

                $empPaySlip->overtime = $row["overtime"] ?? 0;
                $empPaySlip->overtime_arrear = $row["overtime_arrear"] ?? 0;

                $empPaySlip->daily_allowance = $row["daily_allowance"] ?? 0;
                $empPaySlip->daily_allowance_arrear = $row["daily_allowance_arrear"] ?? 0;
                $empPaySlip->total_earned_gross = $row["total_earned_gross"];
                $empPaySlip->pf_wages = $row["pf_wages"] ?? 0;
                $empPaySlip->pf_wages_arrear = $row["pf_wages_arrear"] ?? 0;
                $empPaySlip->epfr = $row["epf_employer_contribution"] ?? 0;
                $empPaySlip->epfr_arrear = $row["epf_employer_contribution_arrear"] ?? 0;
                $empPaySlip->edli_charges = $row["edli_charges"] ?? 0;
                $empPaySlip->edli_charges_arrears = $row["edli_charges_arrears"] ?? 0;
                $empPaySlip->pf_admin_charges = $row["pf_admin_charges"] ?? 0;
                $empPaySlip->pf_admin_charges_arrears = $row["pf_admin_charges_arrears"] ?? 0;
                $empPaySlip->employer_esi = $row["esic_employer_contribution"] ?? 0;
                $empPaySlip->employee_lwf = $row["employee_lwf"] ?? 0;
                $empPaySlip->employer_lwf = $row["employer_lwf"] ?? 0;
                $empPaySlip->ctc = $row["ctc"];
                $empPaySlip->epf_ee = $row["epf_employee_contribution"] ?? 0;
                $empPaySlip->epf_ee_arrear = $row['epf_employee_contribution_arrear'] ?? 0;
                $empPaySlip->employee_esic = $row['employee_esic_contribution'] ?? 0;
                $empPaySlip->prof_tax = $row['professional_tax'] ?? 0;
                $empPaySlip->income_tax = $row["income_tax"] ?? 0;
                $empPaySlip->stats_bonus = $row["statutory_bonus"] ?? 0;
                $empPaySlip->earned_stats_bonus = $row["earned_statutory_bonus"] ?? 0;
                $empPaySlip->earned_stats_arrear = $row["statutory_bonus_arrear"] ?? 0;
                $empPaySlip->sal_adv = $row['salary_advance'] ?? 0;

                $empPaySlip->uniform_deductions = $row['uniform_deductions'] ?? 0;
                $empPaySlip->canteen_dedn = $row['canteen_deduction'] ?? 0;
                $empPaySlip->medical_deductions = $row['medical_deduction'] ?? 0;
                $empPaySlip->loan_deductions = $row['loan_deduction'] ?? 0;
                $empPaySlip->other_deduc = $row["other_deduction"] ?? 0;
                $empPaySlip->total_deductions = $row["total_deduction" ?? 0];
                $empPaySlip->net_take_home = $row["net_take_home" ?? 0];
                $empPaySlip->el_opn_bal = $row["el_opn_bal"] ?? 0;
                $empPaySlip->availed_el = $row["availed_el"] ?? 0;
                $empPaySlip->balance_el = $row["balance_el"] ?? 0;
                $empPaySlip->sl_opn_bal = $row["sl_open_balance"] ?? 0;
                $empPaySlip->availed_sl = $row["availed_sl"] ?? 0;
                $empPaySlip->balance_sl = $row["balance_sl"] ?? 0;
                $empPaySlip->travel_conveyance = $row['travel_conveyance'] ?? 0;
                $empPaySlip->vehicle_reimbursement = $row['vechile_reimburstment'] ?? 0;
                $empPaySlip->other_earnings = $row['other_earnings'] ?? 0;
                $empPaySlip->vpf_arrear = $row['vpf_arrear'] ?? 0;
                $empPaySlip->vpf = $row['vpf'] ?? 0;
                $empPaySlip->save();
            }
            //]);

            //dd($empPaySlip );
            //SAVE THE TABLE



            // if (fetchMasterConfigValue("can_send_appointmentmail_after_onboarding") == "true") {
            //     $isEmailSent  = $this->attachApoinmentPdf($row);
            // }

            return $rowdata_response = [
                'row_number' => '',
                'status' => 'success',
                'message' => 'Payslip for ' . $empNo . ' added successfully',
                'error_fields' => [],
            ];
        } catch (\Exception $e) {
            //$this->deleteUser($user->id);

            //dd("For Usercode : ".$row['employee_code']."  -----  ".$e);
            return $rowdata_response = [
                'row_number' => '',
                'status' => 'failure',
                'message' => 'Payslip for ' . $empNo . ' not added',
                'error_fields' => json_encode(['error' => $e->getMessage()]),
                'stack_trace' => $e->getTraceAsString()
            ];
        }
    }

    /*
        Show Employee payslip as HTML
    */
    public function getEmployeePayslipDetailsAsHTML($user_code, $month, $year)
    {

        //Check permissions

        //if(!auth()->user()->can(config('vmt_roles_permissions.permissions.can_view_employees_payslip')) )



        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
                "year" => $year,
                "month" => $month,
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "year" => 'required',
                "month" => 'required',
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

            //If empty, then show current user profile page
            $user = User::where('user_code', $user_code)->first();
            $user_id = $user->id;
            $payroll_month = VmtPayroll::whereMonth('payroll_date', $month)
                ->whereYear('payroll_date', $year)->where('client_id', $user->client_id)->first();
            //dd(payroll_month);
            $emp_payslip_id = VmtEmployeePayroll::where('user_id', $user_id)->where('payroll_id', $payroll_month->id)->first()->id;

            $data['employee_payslip'] = VmtEmployeePaySlipV2::where('emp_payroll_id', $emp_payslip_id)->first();

            $data['emp_payroll_month'] = $payroll_month;
            $data['employee_code'] = $user->user_code;
            $data['employee_name'] = $user->name;
            $data['employee_office_details'] = VmtEmployeeOfficeDetails::where('user_id', $user->id)->first();
            $data['employee_details'] = VmtEmployee::where('userid', $user->id)->first();
            $data['employee_statutory_details'] = VmtEmployeeStatutoryDetails::where('user_id', $user->id)->first();

            $query_client = VmtClientMaster::find($user->client_id);

            $data['client_logo'] = $query_client->client_logo;
            $client_name = $query_client->client_name;

            $processed_clientName = strtolower(str_replace(' ', '', $client_name));


            $html = view('vmt_payslip_templates.template_payslip_' . $processed_clientName, $data);

            return $html;
            return response()->json([
                'status' => 'success',
                'message' => "",
                'data' => $html
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error while fetching payslip data as HTML",
                "data" => $e
            ]);
        }
    }


    /*
        This function will also download PDF in local server

    */
    public function getEmployeePayslipDetailsAsPDF($user_code, $month, $year)
    {

        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
                "year" => $year,
                "month" => $month,
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "year" => 'required',
                "month" => 'required',
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

        $user_id = User::where('user_code', $user_code)->first()->id;

        $user = null;

        //If empty, then show current user profile page
        if (empty($user_id)) {
            $user = auth()->user()->id;
        } else {
            $user = User::find($user_id);
        }
        $user_id = $user->id;
        $payroll_month = VmtPayroll::whereMonth('payroll_date', $month)
            ->whereYear('payroll_date', $year)->where('client_id', $user->client_id)->first();
        //dd(payroll_month);

        $emp_payslip_id = VmtEmployeePayroll::where('user_id', $user_id)->where('payroll_id', $payroll_month->id)->first()->id;

        $data['employee_payslip'] = VmtEmployeePaySlipV2::where('emp_payroll_id', $emp_payslip_id)->first();

        $data['emp_payroll_month'] = $payroll_month;
        $data['employee_code'] = $user->user_code;

        $emp_name = $user->name;

        $month = strtotime($payroll_month->payroll_date);

        $emp_pay_month = date("F", $month);

        $data['employee_name'] = $user->name;
        // dd( $data['employee_name']);
        $data['employee_office_details'] = VmtEmployeeOfficeDetails::where('user_id', $user->id)->first();
        $data['employee_details'] = VmtEmployee::where('userid', $user->id)->first();
        $data['employee_statutory_details'] = VmtEmployeeStatutoryDetails::where('user_id', $user->id)->first();

        $query_client = VmtClientMaster::find($user->client_id);

        $data['client_logo'] = $query_client->client_logo;
        $client_name = $query_client->client_name;

        $processed_clientName = strtolower(str_replace(' ', '', $client_name));


        $html = view('vmt_payslip_templates.template_payslip_' . $processed_clientName, $data);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $pdf = new Dompdf($options);
        $pdf->loadhtml($html, 'UTF-8');
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        //$response=base64_encode($pdf->stream([$client_name.'.pdf']));
        $response = base64_encode($pdf->output([$client_name . '.pdf']));
        ;

        return response()->json([
            'status' => 'success',
            'message' => "",
            'emp_name' => $emp_name,
            'emp_month' => $emp_pay_month,
            'data' => $response
        ]);
    }




    public function getEmployeePayslipDetails($user_code, $month, $year)
    {


        //Validate
        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
                "year" => $year,
                "month" => $month,
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "year" => 'required',
                "month" => 'required',
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

            $user = User::where('user_code', $user_code)->first();
            $user_id = $user->id;


            //Check whether the payslip data exists or not
            $query_payslip = VmtPayroll::where('client_id', $user->client_id)->whereMonth('payroll_date', $month)
                ->whereYear('payroll_date', $year)->first();

            if (empty($query_payslip)) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Payslip not found for the given MONTH and YEAR'
                ]);
            }

            // Normal JOINS style : JSON structure is not coming properly. Keeping here for reference only
            //
            // $response['payslip_data'] = User::join('vmt_employee_details','vmt_employee_details.userid','=','users.id')
            //                             ->join('vmt_employee_office_details','vmt_employee_office_details.user_id','=','users.id')
            //                             ->join('vmt_employee_statutory_details','vmt_employee_statutory_details.user_id','=','users.id')
            //                             ->join('vmt_employee_payslip','vmt_employee_payslip.user_id','=','users.id')
            //                             ->whereMonth('vmt_employee_payslip.PAYROLL_MONTH','=',$month)
            //                             ->whereYear('vmt_employee_payslip.PAYROLL_MONTH','=',$year)
            //                             ->where('users.id','=',$user_id)
            //                             ->get([
            //                                 'vmt_employee_statutory_details.*',
            //                                 'vmt_employee_payslip.*'
            //                             ]);

            /*
                    ::with() works only if you specify the foreign key . Else it will return empty

            */
            $query_payroll_id = $query_payslip->id;


            $query_emp_payroll_id = VmtEmployeePayroll::where('user_id', $user_id)->where('payroll_id', $query_payroll_id)->first();


            $response['payslip_data'] = User::with([
                'getEmployeeDetails' => function ($query) {
                    $query->select(['id', 'userid', 'dob', 'doj', 'location', 'pan_number', 'bank_id', 'bank_account_number', 'bank_ifsc_code']);
                },
                'getEmployeeOfficeDetails' => function ($query) {
                    $query->select(['id', 'user_id', 'designation']);
                },
                'getStatutoryDetails' => function ($query) {
                    $query->select(['id', 'user_id', 'epf_number', 'esic_number', 'uan_number']);
                },
                'single_payslip_empid' => function ($query) {
                    $query->select(['user_id']);
                },
                // 'single_payslip_detail' =>function($query){
                //     $query->get(['id','emp_payroll_id as PAYROLL_MONTH','month_days as MONTH_DAYS','worked_Days as Worked_Days','lop as LOP','arrears_Days as ArrearS_Days','basic as BASIC','hra as HRA','spl_alw as SPL_ALW',
                //     'overtime as Overtime','travel_conveyance','total_earned_gross as TOTAL_EARNED_GROSS','prof_tax as PROF_TAX','income_tax','sal_adv as SAL_ADV','other_deduc as OTHER_DEDUC','total_deductions as TOTAL_DEDUCTIONS','epfr as EPFR','employee_esic as EMPLOYEE_ESIC',
                //     'net_take_home as NET_TAKE_HOME','employer_esi as EMPLOYER_ESI']);
                // },
            ])
                ->where('users.id', $user_id)
                ->get(['users.id', 'users.name', 'users.user_code', 'users.email']);

            $response['single_payslip_detail'] = VmtEmployeePaySlipV2::where('emp_payroll_id', '=', $query_emp_payroll_id->id)
                ->get([
                    'id',
                    'emp_payroll_id as PAYROLL_MONTH',
                    'month_days as MONTH_DAYS',
                    'worked_Days as Worked_Days',
                    'lop as LOP',
                    'arrears_Days as ArrearS_Days',
                    'basic as BASIC',
                    'hra as HRA',
                    'spl_alw as SPL_ALW',
                    'overtime as Overtime',
                    'travel_conveyance',
                    'total_earned_gross as TOTAL_EARNED_GROSS',
                    'prof_tax as PROF_TAX',
                    'income_tax',
                    'sal_adv as SAL_ADV',
                    'other_deduc as OTHER_DEDUC',
                    'total_deductions as TOTAL_DEDUCTIONS',
                    'epfr as EPFR',
                    'employee_esic as EMPLOYEE_ESIC',
                    'net_take_home as NET_TAKE_HOME',
                    'employer_esi as EMPLOYER_ESI'
                ]);

            $response['single_payslip_detail'][0]['PAYROLL_MONTH'] = $query_payslip->payroll_date;

            $response['client_logo'] = '';

            return response()->json([
                "status" => "success",
                "message" => "",
                "data" => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error while fetching payslip data",
                "data" => $e
            ]);
        }
    }

    public function getAllEmployeesPayslipDetails($month, $year)
    {

        //Validate
        $validator = Validator::make(
            $data = [
                "year" => $year,
                "month" => $month,
            ],
            $rules = [
                "year" => 'required',
                "month" => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
            ]

        );


        try {
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->all()
                ]);
            }

            //Check whether "vmt_employee_payslip_status" has record for all the payslips for all the employees
            //If not, then generate for each payroll month. In future, this table record is inserted after payroll processing.

            //For each employees payslip data, get all the missing payrollstatus data in "vmt_employee_payslip_status"

            //Then, create new record for all payslips for all the employees



            $query_payslips = VmtEmployeePaySlipV2::join('vmt_emp_payroll', 'vmt_emp_payroll.id', '=', 'vmt_employee_payslip_v2.emp_payroll_id')
                ->join('vmt_payroll', 'vmt_payroll.id', '=', 'vmt_emp_payroll.payroll_id')
                ->join('users', 'users.id', '=', 'vmt_emp_payroll.user_id')
                ->whereYear('vmt_payroll.payroll_date', $year)
                ->whereMonth('vmt_payroll.payroll_date', $month)
                ->where('users.is_ssa', '0')
                ->where('users.active', '1')
                ->get();



            //  dd($array_emp_payslip_details);
            return response()->json([
                'status' => 'success',
                'message' => $validator->errors()->all(),
                'data' => $query_payslips
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => '',
                'data' => $e
            ]);
        }
    }

    /*
                Fetches for a single employee


        */
    public function getEmployeeAllPayslipList($user_id, $dropdown_yr)
    {

        //Validate
        $validator = Validator::make(
            $data = [
                "user_id" => $user_id,
                "dropdown_yr" => $dropdown_yr,
            ],
            $rules = [
                "user_id" => 'required|exists:users,id',
                "dropdown_yr" => 'required',
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

            $explode_yr = explode(' - ', $dropdown_yr);
            $start_date = Carbon::parse($explode_yr[0]);
            $end_date = Carbon::parse($explode_yr[1]);

            $query_payslips = VmtEmployeePaySlipV2::join('vmt_emp_payroll', 'vmt_emp_payroll.id', '=', 'vmt_employee_payslip_v2.emp_payroll_id')
                ->leftjoin('vmt_payroll', 'vmt_payroll.id', '=', 'vmt_emp_payroll.payroll_id')
                ->where('vmt_emp_payroll.user_id', $user_id)
                ->whereBetween('vmt_payroll.payroll_date', [$start_date, $end_date])
                ->orderBy('vmt_payroll.payroll_date', 'ASC')
                ->get([
                    'vmt_employee_payslip_v2.id as id',
                    'vmt_emp_payroll.is_payslip_released as payslip_release_status',
                    'vmt_payroll.payroll_date as PAYROLL_MONTH',
                    'vmt_employee_payslip_v2.net_take_home as NET_TAKE_HOME',
                    'vmt_employee_payslip_v2.total_deductions as TOTAL_DEDUCTIONS',
                    'vmt_employee_payslip_v2.total_earned_gross as TOTAL_EARNED_GROSS'
                ])->toArray();

            if (!empty($query_payslips)) {
                foreach ($query_payslips as $keys => $single_value) {
                    $salary_details[$keys]['id'] = $single_value['id'];
                    $salary_details[$keys]['payslip_release_status'] = $single_value['payslip_release_status'];
                    $salary_details[$keys]['PAYROLL_MONTH'] = $single_value['PAYROLL_MONTH'];
                    $salary_details[$keys]['NET_TAKE_HOME'] = numberFormat($single_value['NET_TAKE_HOME'], 2);
                    $salary_details[$keys]['TOTAL_DEDUCTIONS'] = numberFormat($single_value['TOTAL_DEDUCTIONS'], 2);
                    $salary_details[$keys]['TOTAL_EARNED_GROSS'] = numberFormat($single_value['TOTAL_EARNED_GROSS'], 2);
                }

                return response()->json([
                    "status" => "success",
                    "message" => "",
                    "data" => $salary_details
                ]);

            } else {
                return response()->json([
                    "status" => "success",
                    "message" => "No records",
                    "data" => []
                ]);

            }

        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error while fetching payslip data",
                "data" => $e,
                "error_line" => $e->getMessage(),
                "error" => $e->getLine(),
            ]);
        }
    }

    public function payslipYearwiseDropdown()
    {
        $get_financial_yr = VmtOrgTimePeriod::all();

        foreach ($get_financial_yr as $key => $single_yr) {
            $get_value[$key]['year_dropdown'] = Carbon::parse($single_yr['start_date'])->format('M-Y') . ' - ' . Carbon::parse($single_yr['end_date'])->format('M-Y');
            $get_value[$key]['start_date'] = $single_yr['start_date'];
            $get_value[$key]['end_date'] = $single_yr['end_date'];
            $get_value[$key]['id'] = $single_yr['id'];
        }

        return response()->json([
            "status" => "success",
            "message" => "",
            "data" => $get_value
        ]);

    }


    // public function sendMail_employeePayslip($user_code, $month, $year)
    // {
    //     $validator = Validator::make(
    //         $data = [
    //             "user_code" => $user_code,
    //             "year" => $year,
    //             "month" => $month,

    //         ],
    //         $rules = [
    //             "user_code" => 'required|exists:users,user_code',
    //             "year" => 'required',
    //             "month" => 'required',
    //         ],
    //         $messages = [
    //             'required' => 'Field :attribute is missing',
    //             'exists' => 'Field :attribute is invalid',
    //         ]

    //     );


    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'failure',
    //             'message' => $validator->errors()->all()
    //         ]);
    //     }


    //     try {


    //         $query_user = User::where('user_code', $user_code)->first();
    //         $user_id = $query_user->id;

    //         //Check if email exists for this user
    //         if (empty($query_user->email)) {
    //             return response()->json([
    //                 'status' => 'failure',
    //                 'message' => 'E-mail not found for the selected use',
    //                 'data' => ''
    //             ]);
    //         }

    //         //Check whether the payslip data exists or not
    //         $payroll_month = VmtPayroll::whereMonth('payroll_date', $month)
    //             ->whereYear('payroll_date', $year)->where('client_id', $query_user->client_id)->first();


    //         if (!$payroll_month->exists()) {
    //             return response()->json([
    //                 'status' => 'failure',
    //                 'message' => 'Payslip not found for the given MONTH and YEAR'
    //             ]);
    //         }

    //         ////Generate the Payslip PDF


    //         $emp_payslip_id = VmtEmployeePayroll::where('user_id', $user_id)->where('payroll_id', $payroll_month->id)->first()->id;

    //         $data['employee_payslip'] = VmtEmployeePaySlipV2::where('emp_payroll_id', $emp_payslip_id)->first();

    //         $data['emp_payroll_month'] = $payroll_month;


    //         $data['employee_code'] = $query_user->user_code;
    //         $data['employee_name'] = $query_user->name;
    //         $data['employee_office_details'] = VmtEmployeeOfficeDetails::where('user_id', $user_id)->first();
    //         $data['employee_details'] = VmtEmployee::where('userid', $user_id)->first();
    //         $data['employee_statutory_details'] = VmtEmployeeStatutoryDetails::where('user_id', $user_id)->first();

    //         $query_client = VmtClientMaster::find($query_user->client_id);

    //         $data['client_logo'] = request()->getSchemeAndHttpHost() . $query_client->client_logo;
    //         $client_name = $query_client->client_name;

    //         $processed_clientName = strtolower(str_replace(' ', '', $client_name));

    //         $html = view('vmt_payslip_templates.template_payslip_' . $processed_clientName, $data);


    //         //Generate PDF
    //         $options = new Options();
    //         $options->set('isHtml5ParserEnabled', true);
    //         $options->set('isRemoteEnabled', true);

    //         $pdf = new Dompdf($options);
    //         $pdf->loadhtml($html);

    //         $pdf->setPaper('A4', 'portrait');
    //         $pdf->render();

    //         $VmtClientMaster = VmtClientMaster::first();
    //         $image_view = url('/') . $VmtClientMaster->client_logo;

    //         // $pdf->stream($client_name.'.pdf');
    //         $isSent    = \Mail::to($query_user->email)->send(new PayslipMail(request()->getSchemeAndHttpHost(), $pdf->output(), $month, $year, $image_view));

    //         if ($isSent) {
    //             return response()->json([
    //                 "status" => "success",
    //                 "message" => "Mail sent successfully !",
    //                 "data" => $payslip_mail_sent = '1'
    //             ]);
    //         } else {
    //             return response()->json([
    //                 "status" => "failure",
    //                 "message" => "Mail Not sent !",
    //                 "data" => $payslip_mail_sent = '0'
    //             ]);
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             "status" => "failure",
    //             "message" => "Error while fetching payslip mail",
    //             "data" => $e->getMessage()
    //         ]);
    //     }
    // }

    public function getEmployeeCompensatoryDetails($user_code)
    {


        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
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

            $response = User::join('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'users.id')
                ->where('users.user_code', $user_code)
                ->get([
                    "basic",
                    "hra",
                    "Statutory_bonus",
                    "child_education_allowance",
                    "food_coupon",
                    "lta",
                    "transport_allowance",
                    "medical_allowance",
                    "education_allowance",
                    "special_allowance",
                    "other_allowance",
                    "gross",
                    "epf_employer_contribution",
                    "esic_employer_contribution",
                    "insurance",
                    "graduity",
                    "cic",
                    "epf_employee",
                    "esic_employee",
                    "professional_tax",
                    "labour_welfare_fund",
                    "net_income",
                    "dearness_allowance"
                ])->first();
            //dd($response);

            $response['yearly_ctc'] = (int) $response->cic * 12;
            return response()->json([
                'status' => 'success',
                'message' => "",
                'data' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ getEmployeeCompensatoryDetails() ] ",
                'data' => $e
            ]);
        }
    }


    public function generatePayslip($user_code, $month, $year, $type, $serviceVmtAttendanceService)
    {

        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
                "year" => $year,
                "month" => $month,
                "type" => $type,

            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "year" => 'required',
                "month" => 'required',
                "type" => 'required',
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


            $user_data = User::where('user_code', $user_code)->first();
            $payroll_data = VmtPayroll::leftJoin('vmt_client_master', 'vmt_client_master.id', '=', 'vmt_payroll.client_id')
                ->leftJoin('vmt_emp_payroll', 'vmt_emp_payroll.payroll_id', '=', 'vmt_payroll.id')
                ->leftJoin('users', 'users.id', '=', 'vmt_emp_payroll.user_id')
                ->leftJoin('vmt_employee_payslip_v2', 'vmt_employee_payslip_v2.emp_payroll_id', '=', 'vmt_emp_payroll.id')
                ->leftJoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                ->leftJoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->leftJoin('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'users.id')
                ->leftJoin('vmt_employee_statutory_details', 'vmt_employee_statutory_details.user_id', '=', 'users.id')
                ->leftJoin('vmt_department', 'vmt_department.id', '=', 'vmt_employee_office_details.department_id')
                ->leftJoin('vmt_banks', 'vmt_banks.id', '=', 'vmt_employee_details.bank_id')
                ->where('user_code', $user_code)
                ->whereYear('payroll_date', $year)
                ->whereMonth('payroll_date', $month);

            if ($payroll_data->doesntExist()) {

                return response()->json([
                    'status' => 'success',
                    'message' => "payslip data not found",
                    'data' => ''
                ]);
            }

            //get leave data
            $start_date = Carbon::create($year, $month)->startOfMonth()->format('Y-m-d');

            $end_date = Carbon::create($year, $month)->lastOfMonth()->format('Y-m-d');

            $org_start_date =VmtOrgTimePeriod::orderBy('id', 'ASC')->first()->start_date;

            $getleavedetails = $serviceVmtAttendanceService->leavetypeAndBalanceDetails($user_data->id, $org_start_date, $end_date, $month, $year);

            $leave_data = array();


            $client_details =VmtClientMaster::where('id', $user_data->client_id)->first();

            //temp Fix For Dunamis
            if (!empty($client_details) && ($client_details->client_code == 'DMC')) {

                $getpersonal['client_details'] = VmtClientMaster::where('id','2')->get(
                    [
                        'client_fullname',
                        'client_logo',
                        'address',
                    ]
                )->toArray();
            }else{
                $getpersonal['client_details'] = VmtClientMaster::where('id', $user_data->client_id)->get(
                    [
                        'client_fullname',
                        'client_logo',
                        'address',
                    ]
                )->toArray();
            }

            if(!empty($client_details) && ($client_details->client_code == 'DM'|| $client_details->client_code == 'DMC')){

                $i=0;
                foreach ($getleavedetails as $key => $single_leave_type) {

                    if ($single_leave_type['leave_type'] <> "Sick Leave / Casual Leave" && $single_leave_type['leave_type'] <> "Earned Leave") {

                        if ($single_leave_type['availed'] != 0) {

                      $leave_data[$i]['leave_type']=$single_leave_type['leave_type'];
                       $leave_data[$i]["opening_balance"] =0;
                       $leave_data[$i]["availed"] = 0;
                       $leave_data[$i]["closing_balance"] =0;
                       $i++;
                        }
                    } else {

                       $leave_data[$i]['leave_type']=$single_leave_type['leave_type'];
                       $leave_data[$i]["opening_balance"] =0;
                       $leave_data[$i]["availed"] = 0;
                       $leave_data[$i]["closing_balance"] =0;
                       $i++;
                    }
                }
            }else{

                foreach ($getleavedetails as $key => $single_leave_type) {

                    if ($single_leave_type['leave_type'] <> "Sick Leave / Casual Leave" && $single_leave_type['leave_type'] <> "Earned Leave") {

                        if ($single_leave_type['availed'] != 0) {

                            array_push($leave_data, $single_leave_type);
                        }
                    } else {
                        array_push($leave_data, $single_leave_type);
                    }
                }
            }

            $getpersonal['leave_data'] = $leave_data;

            // $financial_time   = VmtOrgTimePeriod::where('status','1')->first()->start_date;
            // $start_date =  Carbon::parse($financial_time );
            // $diff_months  = $start_date->diffInMonths(Carbon::now());

            // $months = [];
            // for($i=0; $i<$diff_months; $i++){
            //     $month = Carbon::parse($start_date)->addMonths($i)->format('Y-m-d');
            //     array_push($months,$month);
            // }

            // $months_details =[];
            // for($i=0; $i<count($months); $i++){
            // $vmt_payroll  =  VmtPayroll::join('vmt_emp_payroll','vmt_emp_payroll.payroll_id','=','vmt_payroll.id')
            //             ->join('vmt_employee_payslip_v2','vmt_employee_payslip_v2.emp_payroll_id','=','vmt_emp_payroll.id')
            //             ->where('vmt_emp_payroll.user_id',$user_data->id)
            //             ->where('payroll_date',$months[$i])
            //             ->get()->toArray();
            //             array_push($months_details,$vmt_payroll);
            // }




            $getpersonal['personal_details'] = $payroll_data->clone()
                ->get(
                    [
                        'users.name',
                        'users.user_code',
                        'vmt_employee_details.doj',
                        'vmt_department.name as department_name',
                        'vmt_employee_office_details.designation',
                        'vmt_employee_office_details.officical_mail',
                        'vmt_employee_details.pan_number',
                        'vmt_banks.bank_name',
                        'vmt_employee_details.bank_account_number',
                        'vmt_employee_details.bank_ifsc_code',
                        'vmt_employee_statutory_details.uan_number',
                        'vmt_employee_statutory_details.epf_number',
                        'vmt_employee_statutory_details.esic_number',
                        'vmt_department.name as department_name'
                    ]
                )->unique()->toArray();


                foreach( $getpersonal['personal_details'][0] as $personel_key=>$single_personal_data){

                    if($single_personal_data == "NULL" ||$single_personal_data == "Null"||$single_personal_data == null){
                        $getpersonal['personal_details'][0][ $personel_key]= '-';

                    }else{
                        $getpersonal['personal_details'][0][ $personel_key] =$single_personal_data;
                    }

                }

            $getpersonal['salary_details'] = $payroll_data
                ->first(
                    [
                        'vmt_employee_payslip_v2.month_days',
                        'vmt_employee_payslip_v2.worked_Days',
                        'vmt_employee_payslip_v2.arrears_Days',
                        'vmt_employee_payslip_v2.lop',
                    ]
                )->toArray();

            $getearnings = $payroll_data
                ->get(
                    [
                        'vmt_employee_payslip_v2.earned_basic as Basic',
                        'vmt_employee_payslip_v2.earned_hra as HRA',
                        'vmt_employee_payslip_v2.earned_stats_bonus as Statuory Bonus',
                        'vmt_employee_payslip_v2.other_earnings as Other Earnings',
                        'vmt_employee_payslip_v2.earned_spl_alw as Special Allowance',
                        'vmt_employee_payslip_v2.travel_conveyance as Travel Conveyance ',
                        'vmt_employee_payslip_v2.earned_child_edu_allowance as Child Education Allowance',
                        'vmt_employee_payslip_v2.communication_allowance_earned as Communication Allowance',
                        'vmt_employee_payslip_v2.food_allowance_earned as Food Allowance',
                        'vmt_employee_payslip_v2.vehicle_reimbursement_earned as Vehicle Reimbursement',
                        'vmt_employee_payslip_v2.driver_salary_earned as Driver Salary',
                        'vmt_employee_payslip_v2.earned_lta as Leave Travel Allowance',
                        'vmt_employee_payslip_v2.other_allowance_earned as Other Allowance',
                        'vmt_employee_payslip_v2.overtime as Overtime',
                        'vmt_employee_payslip_v2.incentive as Incentive',
                        'vmt_employee_payslip_v2.dearness_allowance_earned as Dearness Allowance',
                        'vmt_employee_payslip_v2.medical_allowance_earned as Medical Allowance',
                        'vmt_employee_payslip_v2.vda_earned as Variable Dearness Allowance',
                        'vmt_employee_payslip_v2.washing_allowance_earned as Washing Allowance',
                        'vmt_employee_payslip_v2.leave_encashment as Leave Encashment',
                        'vmt_employee_payslip_v2.referral_bonus as Referral Bonus',
                        'vmt_employee_payslip_v2.ex_gratia as Ex-Gratia',
                        'vmt_employee_payslip_v2.gift_payment as Gift Payment',
                        'vmt_employee_payslip_v2.attendance_bonus as Attendance Bonus',
                        'vmt_employee_payslip_v2.fuel_reimbursement_earned as Fuel Reimbursement',
                        'vmt_employee_payslip_v2.daily_allowance as Daily Allowance',
                    ]
                )->toArray();

            $getarrears = $payroll_data
                ->get(
                    [
                        'vmt_employee_payslip_v2.basic_arrear as Basic',
                        'vmt_employee_payslip_v2.hra_arrear as HRA',
                        'vmt_employee_payslip_v2.earned_stats_arrear as Statuory Bonus',
                        'vmt_employee_payslip_v2.spl_alw_arrear  as Special Allowance',
                        'vmt_employee_payslip_v2.child_edu_allowance_arrear as Child Education Allowance',
                        'vmt_employee_payslip_v2.dearness_allowance_arrear as Dearness Allowance',
                        'vmt_employee_payslip_v2.medical_allowance_arrear as Medical Allowance',
                        'vmt_employee_payslip_v2.vda_arrear as Variable Dearness Allowance',
                        'vmt_employee_payslip_v2.food_allowance_arrear as Food Allowance',
                        'vmt_employee_payslip_v2.communication_allowance_arrear as Communication Allowance',
                        'vmt_employee_payslip_v2.other_allowance_arrear as Other Allowance',
                        'vmt_employee_payslip_v2.washing_allowance_arrear as Washing Allowance',
                        'vmt_employee_payslip_v2.leave_encashment_arrear as Leave Encashment',
                        'vmt_employee_payslip_v2.referral_bonus_arrear as  Referral Bonus',
                        'vmt_employee_payslip_v2.gift_payment_arrear as  Gift Payment',
                        'vmt_employee_payslip_v2.attendance_bonus_arrear as Attendance Bonus',
                        'vmt_employee_payslip_v2.fuel_reimbursement_arrear as Fuel Reimbursement',
                        'vmt_employee_payslip_v2.daily_allowance_arrear as Daily Allowance',

                    ]
                )->toArray();
            //need  to add over_time arrears


            $getcontribution = $payroll_data
                ->get(
                    [
                        'vmt_employee_payslip_v2.epf_ee as EPF Employee',
                        'vmt_employee_payslip_v2.employee_esic as ESIC Employee ',
                        'vmt_employee_payslip_v2.vpf as VPF',
                    ]
                )->toArray();


            $gettaxdeduction = $payroll_data
                ->get(
                    [
                        'vmt_employee_payslip_v2.prof_tax as Professional Tax',
                        'vmt_employee_payslip_v2.employee_lwf as Employee LWF',
                        'vmt_employee_payslip_v2.income_tax as Income Tax',
                        'vmt_employee_payslip_v2.sal_adv as Salary Advance',
                        'vmt_employee_payslip_v2.canteen_dedn as Canteen Deduction',
                        'vmt_employee_payslip_v2.other_deduc as Other Deduction',
                        'vmt_employee_payslip_v2.loan_deductions as Loan Deductions',
                        'vmt_employee_payslip_v2.uniform_deductions as Uniform Deductions',
                    ]
                )->toArray();

        $empCompensatorydetails = VmtEmployeeCompensatoryDetails::where('user_id', $user_data->id)->orderBy('revision_date','ASC')->get('revision_date')->toarray();

         $given_date=$year."-".$month."-"."01";
         $revised_date=null ;
         $temp_date = $empCompensatorydetails[0]['revision_date'];
         $count=0;
         foreach ($empCompensatorydetails as $date_key => $single_date) {

                $revised_date = $single_date['revision_date'];

                if($given_date  >= $revised_date  ){

                    $temp_date = $single_date['revision_date'];

                }

         }

          $getCompensatorydata = VmtEmployeeCompensatoryDetails::where('user_id', $user_data->id)->where('revision_date', $temp_date)
                ->get(
                    [
                        'vmt_employee_compensatory_details.basic as Basic',
                        'vmt_employee_compensatory_details.hra as HRA',
                        'vmt_employee_compensatory_details.Statutory_bonus as Statuory Bonus',
                        'vmt_employee_compensatory_details.special_allowance as Special Allowance',
                        'vmt_employee_compensatory_details.child_education_allowance as Child Education Allowance',
                        'vmt_employee_compensatory_details.communication_allowance as Communication Allowance',
                        'vmt_employee_compensatory_details.food_allowance as Food Allowance',
                        'vmt_employee_compensatory_details.vehicle_reimbursement as Vehicle Reimbursement',
                        'vmt_employee_compensatory_details.driver_salary as Driver Salary',
                        'vmt_employee_compensatory_details.lta as Leave Travel Allowance',
                        'vmt_employee_compensatory_details.other_allowance as Other Allowance',
                    ]
                )->unique()->toArray();


            $getpersonal['date_month'] = [
                "Month" => DateTime::createFromFormat('!m', $month)->format('M'),
                "Year" => DateTime::createFromFormat('Y', $year)->format('Y'),
                "abs_logo" => '/assets/clients/ess/logos/AbsLogo1.png',
            ];

            // Total earnings

            $getpersonal['earnings'] = [];
            foreach ($getearnings as $single_payslip) {
                foreach ($single_payslip as $key => $single_details) {

                    if ($single_details == "0" || $single_details == null || $single_details == "") {
                        unset($single_payslip[$key]);
                    }
                }
                array_push($getpersonal['earnings'], $single_payslip);
            }

            $getpersonal['earnings'] = $this->calculate_float_value($getpersonal['earnings']);

            $getpersonal['compensatory_data'] = [];
            foreach ($getCompensatorydata as $single_payslip) {
                foreach ($single_payslip as $key => $single_details) {

                    if ($single_details == "0" || $single_details == null || $single_details == "") {
                        unset($single_payslip[$key]);
                    }

                }
                array_push($getpersonal['compensatory_data'], $single_payslip);
            }

            $getpersonal['compensatory_data'] = $this->calculate_float_value($getpersonal['compensatory_data']);


            $compensatory_absent_column = array_keys(  $getpersonal['compensatory_data']['0']);

            foreach ($getpersonal['earnings']['0'] as $key => $single_value) {

                     if(!in_array( $key, $compensatory_absent_column )){

                        $getpersonal['compensatory_data']['0'][$key]='0.00';

                     }
             }
             $getCompensatorydata = $payroll_data
             ->get(
                 [
                     'vmt_employee_payslip_v2.total_fixed_gross as Total Earnings',
                 ]
             )->toArray();
             $getpersonal['compensatory_data']['0']['Total Earnings']= number_format($getCompensatorydata['0']['Total Earnings'], 2, '.', '');

            $getpersonal['arrears'] = [];

            foreach ($getarrears as $single_payslip) {

                foreach ($single_payslip as $key => $single_details) {

                    if ($single_details == "0" || $single_details == null || $single_details == "") {
                        unset($single_payslip[$key]);
                    }
                }
                array_push($getpersonal['arrears'], $single_payslip);
            }

            $getpersonal['arrears'] = $this->calculate_float_value($getpersonal['arrears']);

            if (!empty($getpersonal['earnings'])) {
                $total_value = 0;

                foreach ($getpersonal['earnings'][0] as $single_data) {

                    $total_value = $total_value + $single_data;
                }
                foreach ($getpersonal['arrears'][0] as $single_arrear) {
                    $total_value = $total_value + $single_arrear;
                }
                $getpersonal['earnings'][0]['Total Earnings'] = number_format($total_value, 2, '.', '');
            }

            $getpersonal['arrears'] = $this->calculate_float_value($getpersonal['arrears']);
            // Total contribution

            $getpersonal['contribution'] = [];
            foreach ($getcontribution as $single_payslip) {
                foreach ($single_payslip as $key => $single_details) {

                    if ($single_details == "0" || $single_details == null || $single_details == "") {
                        unset($single_payslip[$key]);
                    }
                }
                array_push($getpersonal['contribution'], $single_payslip);
            }
            $getpersonal['contribution'] = $this->calculate_float_value($getpersonal['contribution']);

            if (!empty($getpersonal['contribution'])) {

                $total_value = 0;
                foreach ($getpersonal['contribution'][0] as $single_contribution) {
                    $total_value += ((int) $single_contribution);
                }
                $getpersonal['contribution'][0]['Total Contribution'] = number_format($total_value, 2, '.', '');
            }




            // Total deduction

            $getpersonal['Tax_Deduction'] = [];
            foreach ($gettaxdeduction as $single_payslip) {
                foreach ($single_payslip as $key => $single_details) {

                    if ($single_details == "0" || $single_details == null || $single_details == "") {
                        unset($single_payslip[$key]);
                    }
                }
                array_push($getpersonal['Tax_Deduction'], $single_payslip);
            }

            $getpersonal['Tax_Deduction'] = $this->calculate_float_value($getpersonal['Tax_Deduction']);



            if (!empty($getpersonal['Tax_Deduction'])) {

                $total_value = 0;
                foreach ($getpersonal['Tax_Deduction'][0] as $single_data) {
                    $total_value += ((int) $single_data);
                }
                $getpersonal['Tax_Deduction'][0]['Total Deduction'] = number_format($total_value, 2, '.', '');
            }


            if (!empty($getpersonal['earnings']) && !empty($getpersonal['contribution']) && !empty($getpersonal['Tax_Deduction'])) {
                $total_amount = ($getpersonal['earnings'][0]['Total Earnings']) - ($getpersonal['contribution'][0]['Total Contribution']) - ($getpersonal['Tax_Deduction'][0]['Total Deduction']);

                $getpersonal['over_all'] = [
                    [
                        "Net Salary Payable" => number_format($total_amount, 2, '.', ''),
                        "Net Salary in words" => numberToWord($total_amount),
                    ]
                ];
            }



            $get_payslip = AbsActivePayslip::where('is_active', '1')->first();
            $status = "";
            $message = "";
            $payroll_month = VmtPayroll::whereMonth('payroll_date', $month)
                ->whereYear('payroll_date', $year)->where('client_id', $user_data->client_id)->first();

            $emp_payroll_data = VmtEmployeePayroll::where('user_id', $user_data->id)
                ->where('payroll_id', $payroll_month->id)->first();

            if ($type == "pdf") {

                $html = view('dynamic_payslip_templates.dynamic_payslip_template_pdf', $getpersonal);

                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isRemoteEnabled', true);


                $pdf = new Dompdf($options);
                $pdf->loadhtml($html, 'UTF-8');
                $pdf->setPaper('A4', 'portrait');
                $pdf->render();
                // $pdf->stream("payslip.pdf");

                $response['user_code'] = $user_code;
                $response['month'] = $month;
                $response['year'] = $year;
                $response['emp_name'] = $user_data->name;
                $response['payslip'] = base64_encode($pdf->output(['payslip.pdf']));

            } elseif ($type == "html") {

                $html = view('dynamic_payslip_templates.dynamic_payslip_template_view', $getpersonal);
                $response = base64_encode($html);

            } else if ($type == "mail") {

                $html = view('dynamic_payslip_templates.dynamic_payslip_template_pdf', $getpersonal);

                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isRemoteEnabled', true);

                $pdf = new Dompdf($options);
                $pdf->loadhtml($html, 'UTF-8');
                $pdf->setPaper('A4', 'portrait');
                $pdf->render();

                $isSent = \Mail::to($getpersonal['personal_details'][0]['officical_mail'])
                    ->send(new PayslipMail(request()->getSchemeAndHttpHost(), $pdf->output(), $month, $year));

                if ($isSent) {

                    if (!empty($emp_payroll_data)) {
                        //update
                        $employeepaysliprelease = $emp_payroll_data;
                        $employeepaysliprelease->is_payslip_sent = 1;
                        $employeepaysliprelease->payslip_sent_date = carbon::now()->format('Y-m-d');
                        $employeepaysliprelease->save();
                    }

                    $status = "success";
                    $message = "Employee payslip send successfully";

                } else {
                    $status = "failure";
                    $message = "Error while send employee payslip";
                }
                return response()->json([
                    'status' => $status,
                    'message' => $message,
                    'data' => ''
                ]);
            } else if ($type == 'download') {

                return $getpersonal;
            }

            return $response = ([
                'status' => 'success',
                'message' => "data fetch successfully",
                'data' => $response
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'failure',
                'message' => "Error while fetch payslip details ",
                'data' => $e->getmessage() ." ".$e->getline(),
            ]);
        }
    }


    // public function generatetemplates($type)
    // {


    //     if($type =="pdf"){
    //         $html = view('');


    //             $options = new Options();
    //             $options->set('isHtml5ParserEnabled', true);
    //             $options->set('isRemoteEnabled', true);

    //             $pdf = new Dompdf($options);
    //             $pdf->loadhtml($html, 'UTF-8');
    //             $pdf->setPaper('A4', 'portrait');
    //             $pdf->render();
    //             // $pdf->stream("payslip.pdf");
    //             $response = base64_encode($pdf->output(['payslip.pdf']));
    //             return $response;

    //     }elseif($type =="html"){

    //         $html = view('appointment_mail_templates.appointment_Letter_dunamis_machines');

    //         return $html;

    //     }else if($type =="mail"){

    //         $html = view('');

    //         $options = new Options();
    //         $options->set('isHtml5ParserEnabled', true);
    //         $options->set('isRemoteEnabled', true);

    //         $pdf = new Dompdf($options);
    //         $pdf->loadhtml($html, 'UTF-8');
    //         $pdf->setPaper('A4', 'portrait');
    //         $pdf->render();

    //         $isSent = \Mail::to($getpersonal['personal_details'][0]['officical_mail'])
    //         ->send(new PayslipMail(request()->getSchemeAndHttpHost(), $pdf->output(), $month, $year));

    //         if($isSent){
    //             dd('success');
    //         }else{
    //             dd('failure');
    //         }

    //     }

    // }
    public function viewPayslipdetails($user_code, $month, $year, $serviceVmtAttendanceService)
    {

        // $user_code = "BA002";

        try {

            $user_data = User::where('user_code', $user_code)->first();
            $payroll_data = VmtPayroll::leftJoin('vmt_client_master', 'vmt_client_master.id', '=', 'vmt_payroll.client_id')
                ->leftJoin('vmt_emp_payroll', 'vmt_emp_payroll.payroll_id', '=', 'vmt_payroll.id')
                ->leftJoin('users', 'users.id', '=', 'vmt_emp_payroll.user_id')
                ->leftJoin('vmt_employee_payslip_v2', 'vmt_employee_payslip_v2.emp_payroll_id', '=', 'vmt_emp_payroll.id')
                ->leftJoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                ->leftJoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->leftJoin('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'users.id')
                ->leftJoin('vmt_employee_statutory_details', 'vmt_employee_statutory_details.user_id', '=', 'users.id')
                ->leftJoin('vmt_department', 'vmt_department.id', '=', 'vmt_employee_office_details.department_id')
                ->leftJoin('vmt_banks', 'vmt_banks.id', '=', 'vmt_employee_details.bank_id')
                ->where('user_code', $user_code)
                ->whereYear('payroll_date', $year)
                ->whereMonth('payroll_date', $month);

            if ($payroll_data->doesntExist()) {

                return response()->json([
                    'status' => 'success',
                    'message' => "payslip data not found",
                    'data' => ''
                ]);
            }

            //get leave data
            $start_date = Carbon::create($year, $month)->startOfMonth()->format('Y-m-d');

            $end_date = Carbon::create($year, $month)->lastOfMonth()->format('Y-m-d');

            $org_start_date =VmtOrgTimePeriod::orderBy('id', 'ASC')->first()->start_date;

            $getleavedetails = $serviceVmtAttendanceService->leavetypeAndBalanceDetails($user_data->id, $org_start_date, $end_date, $month, $year);

            $leave_data = array();


            $client_details =VmtClientMaster::where('id', $user_data->client_id)->first();

            //temp Fix For Dunamis
            if (!empty($client_details) && ($client_details->client_code == 'DMC')) {

                $getpersonal['client_details'] = VmtClientMaster::where('id','2')->get(
                    [
                        'client_fullname',
                        'client_logo',
                        'address',
                    ]
                )->toArray();
            }else{
                $getpersonal['client_details'] = VmtClientMaster::where('id', $user_data->client_id)->get(
                    [
                        'client_fullname',
                        'client_logo',
                        'address',
                    ]
                )->toArray();
            }

            if(!empty($client_details) && ($client_details->client_code == 'DM'|| $client_details->client_code == 'DMC')){

                $i=0;
                foreach ($getleavedetails as $key => $single_leave_type) {

                    if ($single_leave_type['leave_type'] <> "Sick Leave / Casual Leave" && $single_leave_type['leave_type'] <> "Earned Leave") {

                        if ($single_leave_type['availed'] != 0) {

                      $leave_data[$i]['leave_type']=$single_leave_type['leave_type'];
                       $leave_data[$i]["opening_balance"] =0;
                       $leave_data[$i]["availed"] = 0;
                       $leave_data[$i]["closing_balance"] =0;
                       $i++;
                        }
                    } else {

                       $leave_data[$i]['leave_type']=$single_leave_type['leave_type'];
                       $leave_data[$i]["opening_balance"] =0;
                       $leave_data[$i]["availed"] = 0;
                       $leave_data[$i]["closing_balance"] =0;
                       $i++;
                    }
                }
            }else{

                foreach ($getleavedetails as $key => $single_leave_type) {

                    if ($single_leave_type['leave_type'] <> "Sick Leave / Casual Leave" && $single_leave_type['leave_type'] <> "Earned Leave") {

                        if ($single_leave_type['availed'] != 0) {

                            array_push($leave_data, $single_leave_type);
                        }
                    } else {
                        array_push($leave_data, $single_leave_type);
                    }
                }
            }

            $getpersonal['leave_data'] = $leave_data;

            // $financial_time   = VmtOrgTimePeriod::where('status','1')->first()->start_date;
            // $start_date =  Carbon::parse($financial_time );
            // $diff_months  = $start_date->diffInMonths(Carbon::now());

            // $months = [];
            // for($i=0; $i<$diff_months; $i++){
            //     $month = Carbon::parse($start_date)->addMonths($i)->format('Y-m-d');
            //     array_push($months,$month);
            // }

            // $months_details =[];
            // for($i=0; $i<count($months); $i++){
            // $vmt_payroll  =  VmtPayroll::join('vmt_emp_payroll','vmt_emp_payroll.payroll_id','=','vmt_payroll.id')
            //             ->join('vmt_employee_payslip_v2','vmt_employee_payslip_v2.emp_payroll_id','=','vmt_emp_payroll.id')
            //             ->where('vmt_emp_payroll.user_id',$user_data->id)
            //             ->where('payroll_date',$months[$i])
            //             ->get()->toArray();
            //             array_push($months_details,$vmt_payroll);
            // }




            $getpersonal['personal_details'] = $payroll_data->clone()
                ->get(
                    [
                        'users.name',
                        'users.user_code',
                        'vmt_employee_details.doj',
                        'vmt_department.name as department_name',
                        'vmt_employee_office_details.designation',
                        'vmt_employee_office_details.officical_mail',
                        'vmt_employee_details.pan_number',
                        'vmt_banks.bank_name',
                        'vmt_employee_details.bank_account_number',
                        'vmt_employee_details.bank_ifsc_code',
                        'vmt_employee_statutory_details.uan_number',
                        'vmt_employee_statutory_details.epf_number',
                        'vmt_employee_statutory_details.esic_number',
                        'vmt_department.name as department_name'
                    ]
                )->unique()->toArray();


                foreach( $getpersonal['personal_details'][0] as $personel_key=>$single_personal_data){

                    if($single_personal_data == "NULL" ||$single_personal_data == "Null"||$single_personal_data == null){
                        $getpersonal['personal_details'][0][ $personel_key]= '-';

                    }else{
                        $getpersonal['personal_details'][0][ $personel_key] =$single_personal_data;
                    }

                }

            $getpersonal['salary_details'] = $payroll_data
                ->first(
                    [
                        'vmt_employee_payslip_v2.month_days',
                        'vmt_employee_payslip_v2.worked_Days',
                        'vmt_employee_payslip_v2.arrears_Days',
                        'vmt_employee_payslip_v2.lop',
                    ]
                )->toArray();

            $getearnings = $payroll_data
                ->get(
                    [
                        'vmt_employee_payslip_v2.earned_basic as Basic',
                        'vmt_employee_payslip_v2.earned_hra as HRA',
                        'vmt_employee_payslip_v2.earned_stats_bonus as Statuory Bonus',
                        'vmt_employee_payslip_v2.other_earnings as Other Earnings',
                        'vmt_employee_payslip_v2.earned_spl_alw as Special Allowance',
                        'vmt_employee_payslip_v2.travel_conveyance as Travel Conveyance ',
                        'vmt_employee_payslip_v2.earned_child_edu_allowance as Child Education Allowance',
                        'vmt_employee_payslip_v2.communication_allowance_earned as Communication Allowance',
                        'vmt_employee_payslip_v2.food_allowance_earned as Food Allowance',
                        'vmt_employee_payslip_v2.vehicle_reimbursement_earned as Vehicle Reimbursement',
                        'vmt_employee_payslip_v2.driver_salary_earned as Driver Salary',
                        'vmt_employee_payslip_v2.earned_lta as Leave Travel Allowance',
                        'vmt_employee_payslip_v2.other_allowance_earned as Other Allowance',
                        'vmt_employee_payslip_v2.overtime as Overtime',
                        'vmt_employee_payslip_v2.incentive as Incentive',
                        'vmt_employee_payslip_v2.dearness_allowance_earned as Dearness Allowance',
                        'vmt_employee_payslip_v2.medical_allowance_earned as Medical Allowance',
                        'vmt_employee_payslip_v2.vda_earned as Variable Dearness Allowance',
                        'vmt_employee_payslip_v2.washing_allowance_earned as Washing Allowance',
                        'vmt_employee_payslip_v2.leave_encashment as Leave Encashment',
                        'vmt_employee_payslip_v2.referral_bonus as Referral Bonus',
                        'vmt_employee_payslip_v2.ex_gratia as Ex-Gratia',
                        'vmt_employee_payslip_v2.gift_payment as Gift Payment',
                        'vmt_employee_payslip_v2.attendance_bonus as Attendance Bonus',
                        'vmt_employee_payslip_v2.fuel_reimbursement_earned as Fuel Reimbursement',
                        'vmt_employee_payslip_v2.daily_allowance as Daily Allowance',
                    ]
                )->toArray();

            $getarrears = $payroll_data
                ->get(
                    [
                        'vmt_employee_payslip_v2.basic_arrear as Basic',
                        'vmt_employee_payslip_v2.hra_arrear as HRA',
                        'vmt_employee_payslip_v2.earned_stats_arrear as Statuory Bonus',
                        'vmt_employee_payslip_v2.spl_alw_arrear  as Special Allowance',
                        'vmt_employee_payslip_v2.child_edu_allowance_arrear as Child Education Allowance',
                        'vmt_employee_payslip_v2.dearness_allowance_arrear as Dearness Allowance',
                        'vmt_employee_payslip_v2.medical_allowance_arrear as Medical Allowance',
                        'vmt_employee_payslip_v2.vda_arrear as Variable Dearness Allowance',
                        'vmt_employee_payslip_v2.food_allowance_arrear as Food Allowance',
                        'vmt_employee_payslip_v2.communication_allowance_arrear as Communication Allowance',
                        'vmt_employee_payslip_v2.other_allowance_arrear as Other Allowance',
                        'vmt_employee_payslip_v2.washing_allowance_arrear as Washing Allowance',
                        'vmt_employee_payslip_v2.leave_encashment_arrear as Leave Encashment',
                        'vmt_employee_payslip_v2.referral_bonus_arrear as  Referral Bonus',
                        'vmt_employee_payslip_v2.gift_payment_arrear as  Gift Payment',
                        'vmt_employee_payslip_v2.attendance_bonus_arrear as Attendance Bonus',
                        'vmt_employee_payslip_v2.fuel_reimbursement_arrear as Fuel Reimbursement',
                        'vmt_employee_payslip_v2.daily_allowance_arrear as Daily Allowance',

                    ]
                )->toArray();
            //need  to add over_time arrears


            $getcontribution = $payroll_data
                ->get(
                    [
                        'vmt_employee_payslip_v2.epf_ee as EPF Employee',
                        'vmt_employee_payslip_v2.employee_esic as ESIC Employee ',
                        'vmt_employee_payslip_v2.vpf as VPF',
                    ]
                )->toArray();


            $gettaxdeduction = $payroll_data
                ->get(
                    [
                        'vmt_employee_payslip_v2.prof_tax as Professional Tax',
                        'vmt_employee_payslip_v2.employee_lwf as Employee LWF',
                        'vmt_employee_payslip_v2.income_tax as Income Tax',
                        'vmt_employee_payslip_v2.sal_adv as Salary Advance',
                        'vmt_employee_payslip_v2.canteen_dedn as Canteen Deduction',
                        'vmt_employee_payslip_v2.other_deduc as Other Deduction',
                        'vmt_employee_payslip_v2.loan_deductions as Loan Deductions',
                        'vmt_employee_payslip_v2.uniform_deductions as Uniform Deductions',
                    ]
                )->toArray();

        $empCompensatorydetails = VmtEmployeeCompensatoryDetails::where('user_id', $user_data->id)->orderBy('revision_date','ASC')->get('revision_date')->toarray();

         $given_date=$year."-".$month."-"."01";
         $revised_date=null ;
         $temp_date = $empCompensatorydetails[0]['revision_date'];
         $count=0;
         foreach ($empCompensatorydetails as $date_key => $single_date) {

                $revised_date = $single_date['revision_date'];

                if($given_date  >= $revised_date  ){

                    $temp_date = $single_date['revision_date'];

                }

         }

          $getCompensatorydata = VmtEmployeeCompensatoryDetails::where('user_id', $user_data->id)->where('revision_date', $temp_date)
                ->get(
                    [
                        'vmt_employee_compensatory_details.basic as Basic',
                        'vmt_employee_compensatory_details.hra as HRA',
                        'vmt_employee_compensatory_details.Statutory_bonus as Statuory Bonus',
                        'vmt_employee_compensatory_details.special_allowance as Special Allowance',
                        'vmt_employee_compensatory_details.child_education_allowance as Child Education Allowance',
                        'vmt_employee_compensatory_details.communication_allowance as Communication Allowance',
                        'vmt_employee_compensatory_details.food_allowance as Food Allowance',
                        'vmt_employee_compensatory_details.vehicle_reimbursement as Vehicle Reimbursement',
                        'vmt_employee_compensatory_details.driver_salary as Driver Salary',
                        'vmt_employee_compensatory_details.lta as Leave Travel Allowance',
                        'vmt_employee_compensatory_details.other_allowance as Other Allowance',
                    ]
                )->unique()->toArray();


            $getpersonal['date_month'] = [
                "Month" => DateTime::createFromFormat('!m', $month)->format('M'),
                "Year" => DateTime::createFromFormat('Y', $year)->format('Y'),
                "abs_logo" => '/assets/clients/ess/logos/AbsLogo1.png',
            ];

            // Total earnings

            $getpersonal['earnings'] = [];
            foreach ($getearnings as $single_payslip) {
                foreach ($single_payslip as $key => $single_details) {

                    if ($single_details == "0" || $single_details == null || $single_details == "") {
                        unset($single_payslip[$key]);
                    }
                }
                array_push($getpersonal['earnings'], $single_payslip);
            }

            $getpersonal['earnings'] = $this->calculate_float_value($getpersonal['earnings']);

            $getpersonal['compensatory_data'] = [];
            foreach ($getCompensatorydata as $single_payslip) {
                foreach ($single_payslip as $key => $single_details) {

                    if ($single_details == "0" || $single_details == null || $single_details == "") {
                        unset($single_payslip[$key]);
                    }

                }
                array_push($getpersonal['compensatory_data'], $single_payslip);
            }

            $getpersonal['compensatory_data'] = $this->calculate_float_value($getpersonal['compensatory_data']);


            $compensatory_absent_column = array_keys(  $getpersonal['compensatory_data']['0']);

            foreach ($getpersonal['earnings']['0'] as $key => $single_value) {

                     if(!in_array( $key, $compensatory_absent_column )){

                        $getpersonal['compensatory_data']['0'][$key]='0.00';

                     }
             }
             $getCompensatorydata = $payroll_data
             ->get(
                 [
                     'vmt_employee_payslip_v2.total_fixed_gross as Total Earnings',
                 ]
             )->toArray();
             $getpersonal['compensatory_data']['0']['Total Earnings']= number_format($getCompensatorydata['0']['Total Earnings'], 2, '.', '');

            $getpersonal['arrears'] = [];

            foreach ($getarrears as $single_payslip) {

                foreach ($single_payslip as $key => $single_details) {

                    if ($single_details == "0" || $single_details == null || $single_details == "") {
                        unset($single_payslip[$key]);
                    }
                }
                array_push($getpersonal['arrears'], $single_payslip);
            }

            $getpersonal['arrears'] = $this->calculate_float_value($getpersonal['arrears']);

            if (!empty($getpersonal['earnings'])) {
                $total_value = 0;

                foreach ($getpersonal['earnings'][0] as $single_data) {

                    $total_value = $total_value + $single_data;
                }
                foreach ($getpersonal['arrears'][0] as $single_arrear) {
                    $total_value = $total_value + $single_arrear;
                }
                $getpersonal['earnings'][0]['Total Earnings'] = number_format($total_value, 2, '.', '');
            }

            $getpersonal['arrears'] = $this->calculate_float_value($getpersonal['arrears']);
            // Total contribution

            $getpersonal['contribution'] = [];
            foreach ($getcontribution as $single_payslip) {
                foreach ($single_payslip as $key => $single_details) {

                    if ($single_details == "0" || $single_details == null || $single_details == "") {
                        unset($single_payslip[$key]);
                    }
                }
                array_push($getpersonal['contribution'], $single_payslip);
            }
            $getpersonal['contribution'] = $this->calculate_float_value($getpersonal['contribution']);

            if (!empty($getpersonal['contribution'])) {

                $total_value = 0;
                foreach ($getpersonal['contribution'][0] as $single_contribution) {
                    $total_value += ((int) $single_contribution);
                }
                $getpersonal['contribution'][0]['Total Contribution'] = number_format($total_value, 2, '.', '');
            }




            // Total deduction

            $getpersonal['Tax_Deduction'] = [];
            foreach ($gettaxdeduction as $single_payslip) {
                foreach ($single_payslip as $key => $single_details) {

                    if ($single_details == "0" || $single_details == null || $single_details == "") {
                        unset($single_payslip[$key]);
                    }
                }
                array_push($getpersonal['Tax_Deduction'], $single_payslip);
            }

            $getpersonal['Tax_Deduction'] = $this->calculate_float_value($getpersonal['Tax_Deduction']);



            if (!empty($getpersonal['Tax_Deduction'])) {

                $total_value = 0;
                foreach ($getpersonal['Tax_Deduction'][0] as $single_data) {
                    $total_value += ((int) $single_data);
                }
                $getpersonal['Tax_Deduction'][0]['Total Deduction'] = number_format($total_value, 2, '.', '');
            }


            if (!empty($getpersonal['earnings']) && !empty($getpersonal['contribution']) && !empty($getpersonal['Tax_Deduction'])) {
                $total_amount = ($getpersonal['earnings'][0]['Total Earnings']) - ($getpersonal['contribution'][0]['Total Contribution']) - ($getpersonal['Tax_Deduction'][0]['Total Deduction']);

                $getpersonal['over_all'] = [
                    [
                        "Net Salary Payable" => number_format($total_amount, 2, '.', ''),
                        "Net Salary in words" => numberToWord($total_amount),
                    ]
                ];
            }
            // dd($getpersonal);

            return response()->json([
                'status' => 'success',
                'message' => "",
                'data' => $getpersonal
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error while fetchingdata ",
                'data' => $e->getMessage()
            ]);
        }
    }

    public function calculate_float_value($calculate_amount)
    {

        foreach ($calculate_amount[0] as $key => $single_value) {

            $calculate_amount[0][$key] = number_format($single_value, 2, '.', '');
        }

        return $calculate_amount;
    }
    public function getEmployeeYearlyAndMonthlyCTC($user_code)
    {
        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
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
            $profile_pic = null;
            //Get the user record and update avatar column
            $user_query = User::where('user_code', $user_code)->first();
            $avatar_filename = $user_query->avatar;
            //Get the image from PRIVATE disk and send as BASE64
            $profile_pic = Storage::disk('private')->get($user_code . "/profile_pics/" . $avatar_filename);
            if ($profile_pic) {
                $profile_pic = base64_encode($profile_pic);
            }
            $compensatory_query = Compensatory::where('user_id', $user_query->id)->first();
            $response['profile_pic'] = $profile_pic;
            $response['profile_name'] = $user_query->name;
            $response['monthly_ctc'] = $compensatory_query->cic;
            $response['yearly_ctc'] = $response['monthly_ctc'] * 12;
            return response()->json([
                'status' => 'success',
                'message' => "",
                'data' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error in [getEmployeeYearlyAndMonthlyCTC()]",
                "data" => $e
            ]);
        }
    }
    //manage payslip v2
    public function getAllEmployeesPayslipDetails_v2($month, $year, $department_id, $legal_entity, $location)
    {

        //Validate
        $validator = Validator::make(
            $data = [
                "year" => $year,
                "month" => $month,
                "department_id" => $department_id,
            ],
            $rules = [
                "year" => 'required',
                "month" => 'required',
                "department_id" => 'nullable|exists:vmt_department,id',
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

            $client_id = null;

            if (empty($legal_entity)) {

                $client_id = VmtClientMaster::pluck('id');
            } else {

                $client_id = $legal_entity;
            }

            $query_payslips = VmtEmployeePaySlipV2::leftjoin('vmt_emp_payroll', 'vmt_emp_payroll.id', '=', 'vmt_employee_payslip_v2.emp_payroll_id')
                ->leftjoin('vmt_payroll', 'vmt_payroll.id', '=', 'vmt_emp_payroll.payroll_id')
                ->leftjoin('users', 'users.id', '=', 'vmt_emp_payroll.user_id')
                ->leftjoin('vmt_client_master', 'vmt_client_master.id', '=', 'users.client_id')
                ->leftjoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->leftjoin('vmt_department', 'vmt_department.id', '=', 'vmt_employee_office_details.department_id')
                ->whereYear('vmt_payroll.payroll_date', $year)
                ->whereMonth('vmt_payroll.payroll_date', $month)
                ->whereIn('users.client_id', $client_id)
                ->where('users.is_ssa', '0')
                ->where('users.active', '1');

            if (!empty($department_id)) {

                $query_payslips = $query_payslips->whereIn('vmt_department.id', $department_id);
            }
            if (!empty($location)) {

                $query_payslips = $query_payslips->whereIn('vmt_employee_office_details.work_location', $location);
            }

            $query_payslips = $query_payslips->get([
                "users.id",
                "users.name as Employee_name",
                "users.user_code as Employee_code",
                "vmt_client_master.client_fullname as Buisness_unit",
                "vmt_payroll.payroll_date as Payroll_month",
                "vmt_department.name as Department_name",
                "vmt_employee_office_details.work_location as Location",
                "vmt_emp_payroll.is_payslip_released",
                "vmt_emp_payroll.payslip_release_date",
                "vmt_emp_payroll.is_payslip_sent",
                "vmt_emp_payroll.payslip_sent_date",
                "vmt_emp_payroll.payslip_revoked_date"
            ]);


            $query_payslips = $query_payslips->map(function ($item) {

                $item->Employee_name = collect(explode(' ', $item->Employee_name))->map(function ($word) {
                    return ucfirst(strtolower($word));
                })->implode(' ');
                $item->Buisness_unit = collect(explode(' ', $item->Buisness_unit))->map(function ($word) {
                    return ucfirst(strtolower($word));
                })->implode(' ');
                $item->Department_name = collect(explode(' ', $item->Department_name))->map(function ($word) {
                    return ucfirst(strtolower($word));
                })->implode(' ');
                $item->Location = collect(explode(' ', $item->Location))->map(function ($word) {
                    return ucfirst(strtolower($word));
                })->implode(' ');
                return $item;
            });

            foreach ($query_payslips as $key => $single_data) {
                $query_payslips[$key]["avatar"] = getEmployeeAvatarOrShortName($single_data->id);
            }


            return response()->json([
                'status' => 'success',
                'message' => 'data fetch successfully',
                'data' => $query_payslips
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => '',
                'data' => $e->getmessage(),
            ]);
        }
    }
    public function sendAllEmployeePayslipPdf($user_data, $serviceVmtAttendanceService)
    {

        try {

            $send_employee_payslip = (new SendEmployeePayslip($user_data))

                ->delay(Carbon::now()->addSeconds(5));

            dispatch($send_employee_payslip);

            return response()->json([
                'status' => 'success',
                'message' => 'Mail Send successfully',
                'data' => ''
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => '',
                'data' => $e->getmessage(),
            ]);
        }
    }
    public function updatePayslipReleaseStatus($user_code, $month, $year, $release_status)
    {


        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
                "month" => $month,
                "year" => $year,
                "status" => $release_status
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "month" => 'required',
                "year" => 'required',
                "status" => 'required',
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
            // to get user id
            $user_data = User::where('user_code', $user_code)->get();

            foreach ($user_data as $key => $single_data) {

                //check if already exists
                $payroll_month = VmtPayroll::whereMonth('payroll_date', $month)
                    ->whereYear('payroll_date', $year)->where('client_id', $single_data['client_id'])->first();


                $emp_payroll_data = VmtEmployeePayroll::where('user_id', $single_data['id'])
                    ->where('payroll_id', $payroll_month->id)->first();


                if (!empty($emp_payroll_data)) {
                    //update

                    $employeepaysliprelease = $emp_payroll_data;
                    $employeepaysliprelease->is_payslip_released = $release_status;
                    $employeepaysliprelease->payslip_release_date = carbon::now()->format('Y-m-d');
                    if ($release_status == "0") {
                        $employeepaysliprelease->payslip_revoked_date = carbon::now()->format('Y-m-d');
                    }
                    $employeepaysliprelease->save();
                } else {

                    //create new record
                    $query_payroll = new Vmtpayroll;
                    $query_payroll->client_id = $single_data['client_id'];
                    $query_payroll->payroll_date = $year . '-' . $month . '-01';
                    $query_payroll->save();
                    $payroll_month = VmtPayroll::whereMonth('payroll_date', $month)
                        ->whereYear('payroll_date', $year)->where('client_id', $single_data['client_id'])->first();
                    $employeepaysliprelease = new VmtEmployeePayroll;
                    $employeepaysliprelease->user_id = $single_data['id'];
                    $employeepaysliprelease->payroll_id = $payroll_month->id;
                    $employeepaysliprelease->is_payslip_released = $release_status;
                    $employeepaysliprelease->payslip_release_date = carbon::now()->format('Y-m-d');
                    if ($release_status == "0") {
                        $employeepaysliprelease->payslip_revoked_date = carbon::now()->format('Y-m-d');
                    }
                    $employeepaysliprelease->save();
                }
            }


            return response()->json([
                'status' => 'success',
                'message' => "",
                'data' => $employeepaysliprelease
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error while fetching payslip release status data",
                'data' => $e
            ]);
        }
    }
    public function getEmpMobilePayrollDashboardDetails($user_code)
    {


        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,

            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',

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
            $user_details = User::leftjoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
            ->leftJoin('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'users.id')
            ->where('user_code',$user_code)->first();
            // dd($user_details);
            // $employee_active_paygroup = VmtEmpActivePaygroup::where('user_id', $user_details->id)->where('is_released', '1')->orderBy('id', 'desc');

            // $employee_paygroup_values = VmtEmpPayGroupValues::where('vmt_emp_active_paygroup_id', $single_paygroup_data['id'])->pluck('Value','vmt_emp_paygroup_id')->toarray();
            // //get earnings values
            // $replace_key_with_compname = VmtPayrollComponents::whereIn('id', array_keys($employee_paygroup_values))
            //                                         ->pluck('comp_identifier','id')->toarray();


                if(!empty($user_details)){
                    $response['name']= $user_details->name;
                    $response['doj']= $user_details->doj;
                    $response['mothly_ctc']= number_format(round($user_details->cic), 2, '.', '');
                    $response['yearly_ctc']=  number_format(round($user_details->cic*12), 2, '.', '');
                }

            return response()->json([
                'status' => 'success',
                'message' => "data fetched successfully",
                'data' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error while fetching payslip release status data",
                'data' => $e
            ]);
        }
    }


    public function getMobileEmployeePayslipDetails($user_code, $month, $year, $serviceVmtAttendanceService)
    {

        // $user_code = "BA002";

        try {

            $user_data = User::where('user_code', $user_code)->first();
            $payroll_data = VmtPayroll::join('vmt_client_master', 'vmt_client_master.id', '=', 'vmt_payroll.client_id')
                ->leftJoin('vmt_emp_payroll', 'vmt_emp_payroll.payroll_id', '=', 'vmt_payroll.id')
                ->leftJoin('users', 'users.id', '=', 'vmt_emp_payroll.user_id')
                ->leftJoin('vmt_employee_payslip_v2', 'vmt_employee_payslip_v2.emp_payroll_id', '=', 'vmt_emp_payroll.id')
                ->leftJoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                ->leftJoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->leftJoin('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'users.id')
                ->leftJoin('vmt_employee_statutory_details', 'vmt_employee_statutory_details.user_id', '=', 'users.id')
                ->leftJoin('vmt_department', 'vmt_department.id', '=', 'vmt_employee_office_details.department_id')
                ->leftJoin('vmt_banks', 'vmt_banks.id', '=', 'vmt_employee_details.bank_id')
                ->where('user_code', $user_code)
                ->whereYear('payroll_date', $year)
                ->whereMonth('payroll_date', $month);


            //get leave data
            $start_date = Carbon::create($year, $month)->startOfMonth()->format('Y-m-d');
            $end_date = Carbon::create($year, $month)->lastOfMonth()->format('Y-m-d');

            // $getleavedetails = $serviceVmtAttendanceService->leavetypeAndBalanceDetails($user_data->id, $start_date, $end_date, $month,$year);

            $leave_data = array();

            if( $payroll_data->exists()){



            $getpersonal['salary_details'] = $payroll_data
                ->get(
                    [
                        'vmt_employee_payslip_v2.worked_Days',
                        'vmt_employee_payslip_v2.lop',
                    ]
                )->toArray();

            $getearnings = $payroll_data
                ->get(
                    [
                        'vmt_employee_payslip_v2.earned_basic as Basic',
                        'vmt_employee_payslip_v2.earned_hra as HRA',
                        'vmt_employee_payslip_v2.earned_stats_bonus as Statuory Bonus',
                        'vmt_employee_payslip_v2.other_earnings as Other Earnings',
                        'vmt_employee_payslip_v2.earned_spl_alw as Special Allowance',
                        'vmt_employee_payslip_v2.travel_conveyance as Travel Conveyance ',
                        'vmt_employee_payslip_v2.earned_child_edu_allowance as Child Education Allowance',
                        'vmt_employee_payslip_v2.communication_allowance_earned as Communication Allowance',
                        'vmt_employee_payslip_v2.food_allowance_earned as Food Allowance',
                        'vmt_employee_payslip_v2.vehicle_reimbursement_earned as Vehicle Reimbursement',
                        'vmt_employee_payslip_v2.driver_salary_earned as Driver Salary',
                        'vmt_employee_payslip_v2.earned_lta as Leave Travel Allowance',
                        'vmt_employee_payslip_v2.other_allowance_earned as Other Allowance',
                        'vmt_employee_payslip_v2.overtime as Overtime',
                    ]
                )->toArray();



                $getarrears = $payroll_data
                ->get(
                    [
                        'vmt_employee_payslip_v2.basic_arrear as Basic',
                        'vmt_employee_payslip_v2.hra_arrear as HRA',
                        'vmt_employee_payslip_v2.earned_stats_arrear as Statuory Bonus',
                        'vmt_employee_payslip_v2.spl_alw_arrear  as Special Allowance',
                        'vmt_employee_payslip_v2.child_edu_allowance_arrear as Child Education Allowance',
                        'vmt_employee_payslip_v2.spl_alw_arrear as Special Allowance Arrear',
                        'vmt_employee_payslip_v2.communication_allowance_arrear as Communication Allowance Arrear',
                        'vmt_employee_payslip_v2.food_allowance_arrear as Food Allowance Arrear',
                        'vmt_employee_payslip_v2.vehicle_reimbursement_arrear as Vehicle Reimbursement Arrear',
                        'vmt_employee_payslip_v2.driver_salary_arrear as Driver Salary Arrear',
                        'vmt_employee_payslip_v2.lta_arrear as Leave Travel Allowance Arrear',
                        'vmt_employee_payslip_v2.other_allowance_arrear as  Other Allowance Arrear',
                        'vmt_employee_payslip_v2.overtime_arrear as Overtime Arrear',
                    ]
                )->toArray();


                $getcontribution = $payroll_data
                ->get(
                    [
                        'vmt_employee_payslip_v2.epf_ee as EPF Employee',
                        'vmt_employee_payslip_v2.employee_esic as ESIC Employee ',
                        'vmt_employee_payslip_v2.vpf as VPF',
                        'vmt_employee_payslip_v2.prof_tax as Professional Tax',
                        'vmt_employee_payslip_v2.employee_lwf as LWF',
                        'vmt_employee_payslip_v2.income_tax as Income Tax',
                        'vmt_employee_payslip_v2.sal_adv as Salary Advance',
                        'vmt_employee_payslip_v2.canteen_dedn as Canteen Deduction',
                        'vmt_employee_payslip_v2.other_deduc as Other Deduction',
                    ]
                )->toArray();


       // Total Earnings calculation


            $getpersonal['Paid Days'] =  $getpersonal['salary_details'][0]['worked_Days'];
            $getpersonal['LOP Days'] = $getpersonal['salary_details'][0]['lop'];
            $getpersonal['earnings'] = [];
            foreach ($getearnings as $earning_key=>$single_payslip) {
                foreach ($single_payslip as $key => $single_details) {

                    if ($single_details == "0" || $single_details == null || $single_details == "") {
                        unset($single_payslip[$key]);
                    }
                }
                $getpersonal['earnings']= $single_payslip;
            }

            $getpersonal['earnings'] = $this->convert_FloatValue_SalaryDetails( $getpersonal['earnings']);

            $getpersonal['arrears'] = [];
            foreach ($getarrears as $single_payslip) {

                foreach ($single_payslip as $key => $single_details) {

                    if ($single_details == "0" || $single_details == null || $single_details == "") {
                        unset($single_payslip[$key]);
                    }
                }
                $getpersonal['arrears']= $single_payslip;

            }

            $getpersonal['arrears'] = $this->convert_FloatValue_SalaryDetails( $getpersonal['arrears']);

            if (!empty($getpersonal['earnings'])) {
                $total_value =0;

                foreach ($getpersonal['earnings'] as $single_data) {

                    $total_value = $total_value+$single_data;
                }
                foreach ($getpersonal['arrears'] as $single_arrear) {
                    $total_value = $total_value + $single_arrear;
                }
                $getpersonal['gross'] =number_format($total_value, 2, '.', '') ;
            }

            $getpersonal['arrears'] = $this->convert_FloatValue_SalaryDetails( $getpersonal['arrears']);

      // Total deduction calculation

            $getpersonal['Deduction'] = [];
            foreach ($getcontribution as $single_payslip) {
                foreach ($single_payslip as $key => $single_details) {

                    if ($single_details == "0" || $single_details == null || $single_details == "") {
                        unset($single_payslip[$key]);
                    }
                }
            $getpersonal['Deduction']= $single_payslip;
            }
            //set totaol deduction as float value
            $getpersonal['Deduction'] = $this->convert_FloatValue_SalaryDetails( $getpersonal['Deduction']);


            if (!empty($getpersonal['Deduction'])) {

                $total_value = 0;
                foreach ($getpersonal['Deduction'] as $single_contribution) {
                    $total_value += ((int) $single_contribution);
                }

                $getpersonal['Total Deduction'] =number_format($total_value, 2, '.', '');
            }

            if (!empty($getpersonal['earnings']) && !empty($getpersonal['Deduction'])) {
                $total_amount = ( $getpersonal['gross']) - $getpersonal['Total Deduction'];

                $getpersonal['Net Income'] =number_format($total_amount, 2, '.', '');
            }

            unset( $getpersonal['salary_details']);
            unset($getpersonal['arrears']);


            return response()->json([
                'status' => 'success',
                'message' => "",
                'data' => $getpersonal
            ]);
        }else{
            return response()->json([
                'status' => 'success',
                'message' => "No data found for given user",
                'data' => ''
            ]);
        }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error while fetchingdata ",
                'data' => $e->getMessage()."  ". $e->getLine()
            ]);
        }
    }

    public function convert_FloatValue_SalaryDetails($calculate_amount)
    {

        foreach ($calculate_amount as $key=>$single_value) {

         $calculate_amount[$key]=number_format($single_value, 2, '.', '');
        }

        return $calculate_amount;
    }
    public function downloadBulkEmployeePayslip($serviceVmtAttendanceService)
    {

        try {
            ini_set('max_execution_time', 300);
            //       $user_id=[ '324','322','330','336','323','331','333','329','327','328','174','326','332','334','177','369','1007','1013','1014','339','349','366','340','347',
            // '338'];
            $user_id = ['324'];

            $data = VmtEmployeePaySlipV2::leftjoin('vmt_emp_payroll', 'vmt_emp_payroll.id', '=', 'vmt_employee_payslip_v2.emp_payroll_id')
                ->leftjoin('vmt_payroll', 'vmt_payroll.id', '=', 'vmt_emp_payroll.payroll_id')
                ->leftjoin('users', 'users.id', '=', 'vmt_emp_payroll.user_id')->whereYear('vmt_payroll.payroll_date', '2023')
                ->whereMonth('vmt_payroll.payroll_date', '09')
                ->whereIn('users.id', $user_id)
                ->get(['users.user_code']);

            foreach ($data as $key => $single_data) {

                $response_data = $this->generatePayslip($single_data['user_code'], '09', '2023', 'download', $serviceVmtAttendanceService);


                if (is_array($response_data)) {

                    $response[] = $response_data;
                    // $html[]=view('dynamic_payslip_templates.dynamic_payslip_template_pdf',$response_data);
                }
            }

            //     $options = new Options();
            //     $options->set('isHtml5ParserEnabled', true);
            //     $options->set('isPhpEnabled', true);
            //    //$options->set(['margin-top' => 10, 'margin-bottom' => 10]);


            //     $pdf = new Dompdf($options);
            //     $pdfContent = '';

            foreach ($response as $data) {


                $pdf = PDF::loadView('dynamic_payslip_templates.dynamic_payslip_template_download_pdf', ['data' => $data]);

                $pdf->save(storage_path('app/pdf_output/' . 'filename' . '.pdf'));
            }

            // $pdf->setPaper('A4','portrait');
            // $pdf->loadHtml($pdfContent,'UTF-8');
            // $pdf->render();
            // $pdf->stream('bulk.pdf');

            // return response()->stream(function () use ($pdf) {
            //     readfile($pdf);
            // }, 200, [
            //     'Content-Type' => 'application/pdf',
            //     'Content-Disposition' => 'attachment; filename="your-pdf-file.pdf"',
            // ]);
        } catch (\Exception $e) {
            return $response = ([
                'status' => 'failure',
                'message' => "Error[ getEmployeeCompensatoryDetails() ] ",
                'data' => $e->getmessage()
            ]);
        }
    }
}
