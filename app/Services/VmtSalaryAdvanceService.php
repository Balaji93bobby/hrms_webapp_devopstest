<?php

namespace App\Services;

use App\Models\Compensatory;
use App\Models\VmtEmpSalAdvDetails;
use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtEmployee;
use App\Models\VmtEmployeePayroll;
use App\Models\VmtLoanInterestSettings;
use App\Models\VmtSalaryAdvSettings;
use Carbon\Carbon;
use App\Models\VmtEmpAssignSalaryAdvSettings;
use App\Models\VmtInterestFreeLoanTransaction;
use App\Models\VmtInterestFreeLoanSettings;
use App\Models\VmtEmployeeInterestFreeLoanDetails;
use App\Models\VmtEmpInterestLoanDetails;
use App\Models\VmtSalaryAdvanceMasterModel;
use App\Models\VmtSalAdvTransactionRecord;
use App\Models\VmtPayroll;
use App\Models\Department;
use App\Models\State;
use App\Models\Bank;
use Exception;
use App\Models\VmtClientMaster;
use Mail;
use App\Mail\ApproveRejectLoanAndSaladvMail;
use App\Models\VVmtInterestFreeLoanTransaction;
use App\Models\VmtLoanWithInterestTransactionRecord;
use App\Mail\ApproverejectloanMail;
use App\Mail\EmpApplyLoanMail;
use App\Mail\FinanceApproverejectloanMail;
use App\Mail\ManagerApproveloanMail;
use App\Models\VmtOrgTimePeriod;
use Symfony\Component\Mailer\Exception\TransportException;




class VmtSalaryAdvanceService
{

    public function getEmpapproverjson($settings_flow, $user_id)
    {
        $settings_flow = json_decode($settings_flow, true);
        $approver_flow = array();
        $temp_ar = array();
        foreach ($settings_flow as $single_ar) {

            $temp_ar['order'] = $single_ar['order'];

            $temp_column = $single_ar['approver'];
            $temp_ar['approver'] = VmtEmployeeOfficeDetails::where('user_id', $user_id)->first()->$temp_column;
            if ($temp_column == 'l1_manager_code') {
                $temp_ar['approver'] = User::where('user_code', $temp_ar['approver'])->first()->id;
            }
            $temp_ar['status'] = 0;
            if ($temp_ar['approver'] == null || empty($temp_ar['approver'])) {
                return ('Error While Creating Approver Flow json');
            }
            array_push($approver_flow, $temp_ar);
            unset($temp_ar);
        }
        return (json_encode($approver_flow, true));
    }

    public function applyLoanAndAdvanceMail($user_id, $requestid, $loan_type, $emp_image, $applied_loan_details)
    {
        $status = "success";
        try {

            $emp_name = User::where('id', $user_id)->first()->name;

            $emp_mail = VmtEmployeeOfficeDetails::where('user_id', $user_id)->first()->officical_mail;
            $empApplyLoanMail = \Mail::to($emp_mail)
                ->send(new EmpApplyLoanMail(
                    $emp_name,
                    $loan_type,
                    $requestid,
                    request()->getSchemeAndHttpHost(),
                    $emp_image
                ));


            if ($loan_type == "Salary Advance") {

                $order_first =  json_decode(($applied_loan_details->emp_approver_flow), true);
                foreach ($order_first as $single_order) {
                    if ($single_order['order'] == 1) {
                        $appvr_image = json_decode(newgetEmployeeAvatarOrShortName($single_order['approver']), true);
                        $approver_details = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                            ->where('user_id', $single_order['approver'])->first();
                    }
                }
            } else if ($loan_type == "Interest Free Loan") {

                $order_first =  json_decode(($applied_loan_details->approver_flow), true);
                foreach ($order_first as $single_order) {
                    if ($single_order['order'] == 1) {
                        $appvr_image = json_decode(newgetEmployeeAvatarOrShortName($single_order['approver']), true);
                        $approver_details = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                            ->where('user_id', $single_order['approver'])->first();
                    }
                }
            } else if ($loan_type == "Interest With Loan") {

                $order_first =  json_decode(($applied_loan_details->approver_flow), true);
                foreach ($order_first as $single_order) {
                    if ($single_order['order'] == 1) {
                        $appvr_image = json_decode(newgetEmployeeAvatarOrShortName($single_order['approver']), true);
                        $approver_details = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                            ->where('user_id', $single_order['approver'])->first();
                    }
                }
            }



            $approveRejectLoanAndSaladvMail   = \Mail::to($approver_details->officical_mail)
                ->send(new ApproveRejectLoanAndSaladvMail(
                    $approver_details->name,
                    $applied_loan_details->name,
                    $applied_loan_details->request_id,
                    $loan_type,
                    $applied_loan_details->borrowed_amount,
                    $applied_loan_details->dedction_date,
                    $applied_loan_details->tenure_months,
                    request()->getSchemeAndHttpHost(),
                    $appvr_image
                ));


            $data['msg'] = $loan_type . " Applied Successfully";
        } catch (TransportException $e) {
            $status = 'failure';
            $data['msg'] = $loan_type . ' Applied Successfully due to some techinal error mail not send';
            $data['error'] = $e->getMessage();
            $data['error_verbose'] = $e;
        }

        $response['status'] = $status;
        $response['data'] = $data;
        return $response;
    }

    public function approveOrRejectLoan($result,  $loan_type, $approver_user_id, $loan_details_id, $cmds, $emp_image)
    {

        try {
            if ($loan_type == 'Interest Free Loan') {
                $loan_detail_query = VmtEmployeeInterestFreeLoanDetails::where('id', $loan_details_id)->first();
                $designation_flow = VmtInterestFreeLoanSettings::where('id', $loan_detail_query->vmt_int_free_loan_id)->first()->approver_flow;
            } else if ($loan_type == 'Loan With Interest') {
                $loan_detail_query = VmtEmpInterestLoanDetails::where('id', $loan_details_id)->first();
                $designation_flow = VmtLoanInterestSettings::where('id', $loan_detail_query->vmt_int_loan_id)->first()->approver_flow;
            } else if ($loan_type == 'Salary Advance') {
                $loan_detail_query = VmtEmpSalAdvDetails::join(
                    'vmt_emp_assign_salary_adv_setting',
                    'vmt_emp_assign_salary_adv_setting.id',
                    '=',
                    'vmt_emp_sal_adv_details.vmt_emp_assign_salary_adv_id'
                )->join(
                    'vmt_salary_adv_setting',
                    'vmt_salary_adv_setting.id',
                    '=',
                    'vmt_emp_assign_salary_adv_setting.salary_adv_id',
                )->where('vmt_emp_sal_adv_details.id', $loan_details_id)->first(
                    [
                        'vmt_emp_assign_salary_adv_setting.user_id as user_id',
                        'vmt_emp_sal_adv_details.emp_approver_flow as approver_flow',
                        'vmt_emp_sal_adv_details.request_id as request_id',
                        'vmt_emp_sal_adv_details.borrowed_amount as borrowed_amount',
                        'vmt_emp_sal_adv_details.dedction_date as dedction_date',
                        'vmt_salary_adv_setting.approver_flow as designation_flow'
                    ]
                );
                $designation_flow =  $loan_detail_query->designation_flow;
            }

            $user_id =  $loan_detail_query->user_id;
            $emp_mail = VmtEmployeeOfficeDetails::where('user_id',  $user_id)->first()->officical_mail;
            $approver_name = User::where('id', $approver_user_id)->first()->name;
            $approvalFlow = json_decode($loan_detail_query->approver_flow, true);
            $designation_flow  = json_decode($designation_flow, true);
            $next = '';
            if ($result == 'Rejected') {
                foreach ($approvalFlow as $key => $value) {
                    if (($value['approver']) == $approver_user_id) {
                        if ($designation_flow[$key]['approver'] == 'fa_user_id') {
                            if (array_key_exists($key - 1, $approvalFlow)) {
                                $prvs_apvr_mail = VmtEmployeeOfficeDetails::where('user_id', $approvalFlow[$key - 1]['approver'])->first()->officical_mail;
                                $rejectMail = \Mail::to($emp_mail)
                                    ->cc($prvs_apvr_mail)
                                    ->send(new FinanceApproverejectloanMail(
                                        $result,
                                        $loan_detail_query->request_id,
                                        User::where('id', $user_id)->first()->name,
                                        $loan_type,
                                        $emp_image,
                                        $cmds,
                                        request()->getSchemeAndHttpHost(),
                                    ));
                            } else {
                                $rejectMail = \Mail::to($emp_mail)
                                    ->send(new FinanceApproverejectloanMail(
                                        $result,
                                        $loan_detail_query->request_id,
                                        User::where('id', $user_id)->first()->name,
                                        $loan_type,
                                        $emp_image,
                                        $cmds,
                                        request()->getSchemeAndHttpHost(),
                                    ));
                            }
                        } else {
                            $rejectMail = \Mail::to($emp_mail)
                                ->send(new ApproverejectloanMail(
                                    User::where('id', $approver_user_id)->first()->name,
                                    User::where('id', $user_id)->first()->name,
                                    $loan_detail_query->request_id,
                                    $result,
                                    request()->getSchemeAndHttpHost(),
                                    $result,
                                    $emp_image,
                                    $cmds,
                                    $next,
                                    $approver_name,
                                    $loan_type
                                ));
                        }
                    }
                }
            } else if ($result == 'Approved') {
                foreach ($approvalFlow as $key => $value) {
                    if (($value['approver']) == $approver_user_id) {
                        if (array_key_exists($key + 1, $approvalFlow)) {
                            $next_approver = VmtEmployeeOfficeDetails::where('user_id', $approvalFlow[$key + 1]['approver'])->first()->officical_mail;
                            $next_appr_name =  User::where('id',  $approvalFlow[$key + 1]['approver'])->first()->name;
                            $emp_name = User::where('id', $user_id)->first()->name;
                            $requestid =  $loan_detail_query->request_id;
                            $request_amt = $loan_detail_query->borrowed_amount;
                            $requested_date = null;
                            $tenure_month = null;
                            $appvr_image = json_decode(newgetEmployeeAvatarOrShortName($approvalFlow[$key + 1]['approver']), true);

                            if ($loan_type == 'Salary Advance') {
                                $requested_date = $loan_detail_query->dedction_date;
                            } else {
                                $tenure_month = $loan_detail_query->tenure_months;
                            }
                            if (array_key_exists('reason', $approvalFlow[$key + 1])) {
                                $remarks = $approvalFlow[$key + 1]['reason'];
                            } else {
                                $remarks = $cmds;
                            }
                            $notf_mail_next_approver =  \Mail::to($next_approver)
                                ->send(new ManagerApproveloanMail(
                                    $emp_name,
                                    $requestid,
                                    $approver_name,
                                    $next_appr_name,
                                    $loan_type,
                                    $request_amt,
                                    $requested_date,
                                    $tenure_month,
                                    $remarks,
                                    $appvr_image,
                                    request()->getSchemeAndHttpHost(),
                                ));
                        }
                        $crt_emp_img = json_decode(newgetEmployeeAvatarOrShortName($user_id), true);
                        if ($designation_flow[$key]['approver'] == 'fa_user_id') {
                            $approve_mail = \Mail::to($emp_mail)
                                ->send(new FinanceApproverejectloanMail(
                                    $result,
                                    $loan_detail_query->request_id,
                                    User::where('id', $user_id)->first()->name,
                                    $loan_type,
                                    $crt_emp_img,
                                    $cmds,
                                    request()->getSchemeAndHttpHost(),
                                ));
                        } else {
                            $approve_mail = \Mail::to($emp_mail)
                                ->send(new ApproverejectloanMail(
                                    User::where('id', $approver_user_id)->first()->name,
                                    User::where('id', $user_id)->first()->name,
                                    $loan_detail_query->request_id,
                                    $result,
                                    request()->getSchemeAndHttpHost(),
                                    $result,
                                    $crt_emp_img,
                                    $cmds,
                                    $next,
                                    $designation_flow[$key]['name'],
                                    $loan_type
                                ));
                        }
                    }
                }
            }

            $status = 'success';
            $data['msg'] = $loan_type . ' ' . $result . ' Successfully';
        } catch (TransportException $e) {
            $status = 'success';
            $data['msg'] = $loan_type . ' ' . $result . ' Successfully due to some techinal error mail not send';
            $data['error'] = $e->getMessage();
            $data['error_verbose'] = $e;
        }

        $response['status'] = $status;
        $response['data'] = $data;
        return $response;
    }

    public function getAllDropdownFilterSetting()
    {

        $current_client_id = auth()->user()->client_id;


        try {

            $queryGetDept = Department::select('id', 'name')->get();

            $queryGetDesignation = VmtEmployeeOfficeDetails::select('designation')->where('designation', '<>', 'S2 Admin')->distinct()->get();

            $queryGetLocation = VmtEmployeeOfficeDetails::select('work_location')->distinct()->get();

            $queryGetstate = State::select('id', 'state_name')->distinct()->get();

            if ($current_client_id == 1) {

                $queryGetlegalentity = VmtClientMaster::select('id', 'client_name')->distinct()->get();
            } elseif ($current_client_id == 0) {

                $queryGetlegalentity = VmtClientMaster::select('id', 'client_name')->distinct()->get();
            } elseif ($current_client_id == 2) {

                $queryGetlegalentity = VmtClientMaster::where('id', $current_client_id)->distinct()->get(['id', 'client_name']);
            } elseif ($current_client_id == 3) {

                $queryGetlegalentity = VmtClientMaster::where('id', $current_client_id)->distinct()->get(['id', 'client_name']);
            } elseif ($current_client_id == 4) {

                $queryGetlegalentity = VmtClientMaster::where('id', $current_client_id)->distinct()->get(['id', 'client_name']);
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

    public function SalAdvSettingsTable($department_id, $designation, $work_location, $client_name)
    {

        try {

            $select_employee = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->join('vmt_department', 'vmt_department.id', '=', 'vmt_employee_office_details.department_id')
                ->join('vmt_client_master', 'vmt_client_master.id', '=', 'users.client_id')
                ->where('process', '<>', 'S2 Admin')
                ->select(
                    'users.id',
                    'users.name',
                    'users.user_code',
                    'vmt_department.name as department_name',
                    'vmt_employee_office_details.designation',
                    'vmt_employee_office_details.work_location',
                    'vmt_client_master.client_name',
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
            $assigned_emp_user_ids = VmtEmpAssignSalaryAdvSettings::pluck('user_id');
            if (!empty($assigned_emp_user_ids)) {
                $assigned_emp_user_codes = array();
                foreach ($assigned_emp_user_ids as $single_id) {
                    array_push($assigned_emp_user_codes, User::where('id', $single_id)->first()->user_code);
                }
                return  $select_employee->whereNotIn('user_code',  $assigned_emp_user_codes)->get();
            }

            return $select_employee->get();
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error fetching the employee",
                "data" => $e,
            ]);
        }
    }


    public function SalAdvShowEmployeeView($user_id)
    {

        try {

            $current_user_id = $user_id;
            // dd($current_user_id);

            $employee_user_id = VmtEmpAssignSalaryAdvSettings::where('user_id', $current_user_id)->first();


            if (isset($employee_user_id)) {

                $emp_compensatory = Compensatory::where('user_id', $current_user_id)->first();

                $employee_salary_adv = VmtSalaryAdvSettings::join('vmt_emp_assign_salary_adv_setting', 'vmt_emp_assign_salary_adv_setting.salary_adv_id', '=', 'vmt_salary_adv_setting.id')
                    ->where('vmt_emp_assign_salary_adv_setting.user_id', $current_user_id)->first();

                // $get_salary_emp = VmtEmpSalAdvDetails::where('requested_date', date("Y-m-d"))->get();
                $current_date = Carbon::now();
                $get_salary_emp = VmtEmpSalAdvDetails::join('vmt_emp_assign_salary_adv_setting', 'vmt_emp_assign_salary_adv_setting.id', 'vmt_emp_sal_adv_details.vmt_emp_assign_salary_adv_id')
                    ->whereYear('vmt_emp_sal_adv_details.requested_date', $current_date->format('Y'))
                    ->whereMonth('vmt_emp_sal_adv_details.requested_date',   $current_date->format('m'))
                    ->whereIn('vmt_emp_sal_adv_details.sal_adv_crd_sts', [0, 1])
                    ->where('vmt_emp_assign_salary_adv_setting.user_id', $current_user_id)->get();

                $sal_borrowed = 0;
                foreach ($get_salary_emp as $single_salary_emmp) {
                    $sal_borrowed += $single_salary_emmp['borrowed_amount'];
                }
                // dd($sal_borrowed);

                $calculatevalue = ($emp_compensatory->net_income) * ($employee_salary_adv->percent_salary_adv) / 100;

                $calculate_max = $calculatevalue - $sal_borrowed;

                //  dd($calculate_max);
                $multiple_months = array();
                for ($i = 1; $i <= $employee_salary_adv->deduction_period_of_months; $i++) {

                    $repayment_months = Carbon::now()->addMonths($i)->format('Y-m-d');
                    $dates['date'] = $repayment_months;
                    array_push($multiple_months, $dates);
                }

                // dd( $repayment_months);

                $salary_adv['your_monthly_income'] = $emp_compensatory->net_income;
                $salary_adv['max_eligible_amount'] = $calculate_max;
                $salary_adv['Repayment_date'] = $multiple_months;
                $salary_adv['eligible'] = VmtSalaryAdvanceMasterModel::where('client_id', User::where('id', $employee_user_id->user_id)->first()->client_id)->first()->sal_adv;
                $salary_adv['percent_salary_amt'] = $employee_salary_adv->percent_salary_adv;

                // dd($salary_adv);

                return response()->json($salary_adv);
            } else {

               
                $salary_adv['your_monthly_income'] = 0;
                $salary_adv['max_eligible_amount'] =0;
                $salary_adv['Repayment_date'] = 0;
                $salary_adv['eligible'] = 0;
                $salary_adv['percent_salary_amt'] = 0;

                return response()->json($salary_adv);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error fetching the employee",
                "error_message" => $e->getMessage(),
                "data" => $e->getTraceAsString(),
            ]);
        }
    }

    public function SalAdvEmpSaveSalaryAmt($user_id, $mxe, $ra, $repdate, $reason)
    {


        $current_user_id = $user_id;

        $request_type = "Salary Advance";

        $employee_sal_sett = VmtEmpAssignSalaryAdvSettings::join('vmt_salary_adv_setting', 'vmt_salary_adv_setting.id', '=', 'vmt_emp_assign_salary_adv_setting.salary_adv_id')
            ->where('user_id', $current_user_id)->first();

        $employee_sal_sett_id = VmtEmpAssignSalaryAdvSettings::where('user_id', $current_user_id)->first();

        if ($employee_sal_sett->can_borrowed_multiple == "1") {

            try {

                $EmpApplySalaryAmt = new VmtEmpSalAdvDetails;
                $EmpApplySalaryAmt->vmt_emp_assign_salary_adv_id = $employee_sal_sett_id->id;

                $get_lasting = VmtEmpSalAdvDetails::get()->sortByDesc('id')->first();
                if (empty($get_lasting)) {
                    $EmpApplySalaryAmt->request_id = "ABSSA001";
                } else {
                    $substrid = substr($get_lasting->request_id, 5);
                    $add1 = ($substrid + 1);
                    $tostring = ((string) ($add1));
                    $strlenth = strlen($tostring);

                    if ($strlenth == 1) {
                        $requestid = "ABSSA" . "00" . $add1;
                        $EmpApplySalaryAmt->request_id = $requestid;
                    } else if ($strlenth == 2) {
                        $requestid = "ABSSA" . "0" . $add1;
                        $EmpApplySalaryAmt->request_id = $requestid;
                    } else {
                        $requestid = "ABSSA" . $add1;
                        $EmpApplySalaryAmt->request_id = $requestid;
                    }
                }
                $EmpApplySalaryAmt->eligible_amount = $mxe;
                $EmpApplySalaryAmt->borrowed_amount = $ra;
                $EmpApplySalaryAmt->requested_date = date('Y-m-d');
                $EmpApplySalaryAmt->dedction_date = $repdate;
                $EmpApplySalaryAmt->reason = $reason;
                $EmpApplySalaryAmt->emp_approver_flow = $this->getEmpapproverjson($employee_sal_sett->approver_flow, $employee_sal_sett->user_id);
                $EmpApplySalaryAmt->sal_adv_crd_sts = "0";
                $EmpApplySalaryAmt->sal_adv_status = "Pending";
                $EmpApplySalaryAmt->save();

                $emp_details =  User::join('vmt_emp_assign_salary_adv_setting', 'vmt_emp_assign_salary_adv_setting.user_id', '=', 'users.id')
                    ->join('vmt_emp_sal_adv_details', 'vmt_emp_sal_adv_details.vmt_emp_assign_salary_adv_id', '=', 'vmt_emp_assign_salary_adv_setting.id')
                    ->where('vmt_emp_sal_adv_details.id', $EmpApplySalaryAmt->id)
                    ->first();

                $emp_img = json_decode(newgetEmployeeAvatarOrShortName($current_user_id), true);
                $mail_sts = $this->applyLoanAndAdvanceMail($current_user_id, $EmpApplySalaryAmt->request_id, $request_type, $emp_img, $emp_details);

                return response()->json([
                    'status' => 'success',
                    'message' => 'applied and mail send  successfully',


                ]);
            } catch (\Exception $e) {
                return response()->json([
                    "status" => "failure",
                    "message" => "Applied Failure",
                    "data" => $e->getMessage(),
                ]);
            }
        } else if ($employee_sal_sett->can_borrowed_multiple == "0") {

            $already_applied = VmtEmpAssignSalaryAdvSettings::join('vmt_emp_sal_adv_details', 'vmt_emp_sal_adv_details.vmt_emp_assign_salary_adv_id', '=', 'vmt_emp_assign_salary_adv_setting.id')
                ->where('user_id', $current_user_id)
                ->whereYear('requested_date', date("Y"))
                ->whereMonth('requested_date', date("m"))
                ->first();



            if (!empty($already_applied)) {
                return response()->json([
                    "status" => "failure",
                    "message" => "Already applied this month",
                ]);
            } else {

                try {

                    $EmpApplySalaryAmt = new VmtEmpSalAdvDetails;
                    $EmpApplySalaryAmt->vmt_emp_assign_salary_adv_id = $employee_sal_sett_id->id;

                    $get_lasting = VmtEmpSalAdvDetails::get()->sortByDesc('id')->first();
                    if (empty($get_lasting)) {
                        $EmpApplySalaryAmt->request_id = "ABSSA001";
                    } else {
                        $substrid = substr($get_lasting->request_id, 5);
                        $add1 = ($substrid + 1);
                        $tostring = ((string) ($add1));
                        $strlenth = strlen($tostring);

                        if ($strlenth == 1) {
                            $requestid = "ABSSA" . "00" . $add1;
                            $EmpApplySalaryAmt->request_id = $requestid;
                        } else if ($strlenth == 2) {
                            $requestid = "ABSSA" . "0" . $add1;
                            $EmpApplySalaryAmt->request_id = $requestid;
                        } else {
                            $requestid = "ABSSA" . $add1;
                            $EmpApplySalaryAmt->request_id = $requestid;
                        }
                    }
                    $EmpApplySalaryAmt->eligible_amount = $mxe;
                    $EmpApplySalaryAmt->borrowed_amount = $ra;
                    $EmpApplySalaryAmt->requested_date = date('Y-m-d');
                    $EmpApplySalaryAmt->dedction_date = $repdate;
                    $EmpApplySalaryAmt->reason = $reason;
                    $EmpApplySalaryAmt->emp_approver_flow = $this->getEmpapproverjson($employee_sal_sett->approver_flow, $employee_sal_sett->user_id);
                    $EmpApplySalaryAmt->sal_adv_crd_sts = "0";
                    $EmpApplySalaryAmt->sal_adv_status = "Pending";
                    $EmpApplySalaryAmt->save();


                    $emp_details =  User::join('vmt_emp_assign_salary_adv_setting', 'vmt_emp_assign_salary_adv_setting.user_id', '=', 'users.id')
                        ->join('vmt_emp_sal_adv_details', 'vmt_emp_sal_adv_details.vmt_emp_assign_salary_adv_id', '=', 'vmt_emp_assign_salary_adv_setting.id')
                        ->where('vmt_emp_sal_adv_details.id', $EmpApplySalaryAmt->id)
                        ->first();

                    $emp_img = json_decode(newgetEmployeeAvatarOrShortName($current_user_id), true);
                    $mail_sts = $this->applyLoanAndAdvanceMail($current_user_id, $EmpApplySalaryAmt->request_id, $request_type, $emp_img, $emp_details);

                    return response()->json([
                        'status' => 'success',
                        'message' => 'applied and mail send  successfully',


                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        "status" => "failure",
                        "message" => "Applied Failure",
                        "data" => $e,
                    ]);
                }
            }
        }
    }


    public function saveSalaryAdvanceSettings($eligibleEmployee, $perOfSalAdvance, $deductMethod, $approvalflow, $payroll_cycle, $SA)
    {

        $salary_adv_name = VmtSalaryAdvSettings::where('settings_name', $SA)->first();

        if ($salary_adv_name) {

            $already_assigned = VmtSalaryAdvSettings::where('percent_salary_adv', $perOfSalAdvance)
                ->where('deduction_period_of_months', $deductMethod)
                ->where('can_borrowed_multiple', $payroll_cycle)->first();

            if ($already_assigned) {

                $json_approvalflow = json_encode($approvalflow);

                $master = VmtSalaryAdvSettings::where('approver_flow', $json_approvalflow)->first();

                if ($master) {

                    return response()->json([
                        'status' => 'failure',
                        'message' => 'already using the settings',
                    ]);
                }
            }
        }

        $json_approvalflow = json_encode($approvalflow);

        $res = array();
        foreach ($eligibleEmployee as $emplo) {

            $user_detailss = User::where('user_code', $emplo['user_code'])->first();

            $already_assignd_emp = vmtEmpAssignSalaryAdvSettings::where('user_id', $user_detailss->id)->first();

            if (!empty($already_assignd_emp)) {

                $user_name  =  User::where('id', $already_assignd_emp->user_id)->first();
                array_push($res, $user_name->name);
            }
        }

        if (!empty($res)) {
            $res = implode(',', $res);
            return response()->json([
                'status' => 'failure',
                'message' => $res . ' These Employees are already assigned to another setting , so please remove this employees from that settings and add to this settings',
                'data' => $res,

            ]);
        }


        try {

            $saveSettingSALaryAdv = new VmtSalaryAdvSettings;
            $saveSettingSALaryAdv->settings_name = $SA;
            $saveSettingSALaryAdv->percent_salary_adv = $perOfSalAdvance;
            $saveSettingSALaryAdv->deduction_period_of_months = $deductMethod;
            $saveSettingSALaryAdv->approver_flow = $json_approvalflow;
            $saveSettingSALaryAdv->can_borrowed_multiple = $payroll_cycle;
            $saveSettingSALaryAdv->save();

            $SalaryAdvSettings = $saveSettingSALaryAdv;

            foreach ($eligibleEmployee as $employee) {

                $user_id = User::where('user_code', $employee['user_code'])->first();

                $vmtEmpAssignSalaryAdvSettings = new VmtEmpAssignSalaryAdvSettings;
                $vmtEmpAssignSalaryAdvSettings->user_id = $user_id->id;
                $vmtEmpAssignSalaryAdvSettings->salary_adv_id = $SalaryAdvSettings->id;
                $vmtEmpAssignSalaryAdvSettings->active = "0";
                $vmtEmpAssignSalaryAdvSettings->save();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'save successfully',


            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "",
                "data" => $e,
            ]);
        }
    }

    public function settingDetails()
    {

        $getsetting   = VmtSalaryAdvSettings::get(['id', 'settings_name', 'percent_salary_adv', 'deduction_period_of_months', 'can_borrowed_multiple'])->toArray();

        // dd($getsetting );

        $res = array();
        foreach ($getsetting  as $single_settings) {

            $data['settings'] = $single_settings;

            $data['settings']['emp_count'] =  VmtEmpAssignSalaryAdvSettings::where('salary_adv_id', $single_settings['id'])->get()->count();

            $getsetting_details = VmtSalaryAdvSettings::join('vmt_emp_assign_salary_adv_setting', 'vmt_emp_assign_salary_adv_setting.salary_adv_id', '=', 'vmt_salary_adv_setting.id')
                ->join('users', 'users.id', '=', 'vmt_emp_assign_salary_adv_setting.user_id')->where('salary_adv_id', $single_settings['id'])->get()->toArray();

            $getdetails = VmtSalaryAdvSettings::join('vmt_emp_assign_salary_adv_setting', 'vmt_emp_assign_salary_adv_setting.salary_adv_id', '=', 'vmt_salary_adv_setting.id')
                ->join('users', 'users.id', '=', 'vmt_emp_assign_salary_adv_setting.user_id')->where('salary_adv_id', $single_settings['id'])
                ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->join('vmt_department', 'vmt_department.id', '=', 'vmt_employee_office_details.department_id')
                ->join('vmt_client_master', 'vmt_client_master.id', '=', 'users.client_id')
                ->get([
                    'vmt_salary_adv_setting.settings_name',
                    'users.id',
                    'users.name',
                    'users.user_code',
                    'vmt_department.name as department_name',
                    'vmt_employee_office_details.designation',
                    'vmt_employee_office_details.work_location',
                    'vmt_client_master.client_name'
                ])->toArray();


            foreach ($getsetting_details as $single_arr) {

                $res1 = array(
                    'settings_id' => $single_arr['salary_adv_id'],
                    'settings_name' => $single_arr['settings_name'],
                    'percent_salary_adv' => $single_arr['percent_salary_adv'],
                    'deduction_period_of_months' => $single_arr['deduction_period_of_months'],
                    'approver_flow' => json_decode($single_arr['approver_flow'], true),
                    'can_borrowed_multiple' => $single_arr['can_borrowed_multiple'],
                    'assigned_emp' => [],
                );

                foreach ($getdetails as $get_single) {

                    if (in_array($get_single['settings_name'], $get_single)) {

                        $get_details_settings['id'] =  $get_single['id'];
                        $get_details_settings['name'] =  $get_single['name'];
                        $get_details_settings['user_code'] =  $get_single['user_code'];
                        $get_details_settings['department_name'] =  $get_single['department_name'];
                        $get_details_settings['designation'] =  $get_single['designation'];
                        $get_details_settings['work_location'] =  $get_single['work_location'];
                        $get_details_settings['client_name'] =  $get_single['client_name'];

                        array_push($res1['assigned_emp'], $get_details_settings);
                    }
                }
            }

            $data['settings']['view_details'] = $res1;

            array_push($res, $data);
        }

        return ($res);
    }

    public function SalAdvApproverFlow()
    {

        $user_id = auth()->user()->id;
        $temp_ar = array();
        $all_pending_loans = VmtEmpSalAdvDetails::join('vmt_emp_assign_salary_adv_setting', 'vmt_emp_assign_salary_adv_setting.id', '=', 'vmt_emp_sal_adv_details.vmt_emp_assign_salary_adv_id')
            ->join('users', 'users.id', '=', 'vmt_emp_assign_salary_adv_setting.user_id')
            ->where('sal_adv_crd_sts', 0)->get([

                'vmt_emp_sal_adv_details.id',
                'vmt_emp_assign_salary_adv_setting.user_id',
                'users.name',
                'users.user_code',
                'vmt_emp_sal_adv_details.request_id',
                'vmt_emp_sal_adv_details.eligible_amount',
                'vmt_emp_sal_adv_details.borrowed_amount',
                'vmt_emp_sal_adv_details.requested_date',
                'vmt_emp_sal_adv_details.dedction_date',
                'vmt_emp_sal_adv_details.reason',
                'vmt_emp_sal_adv_details.emp_approver_flow',
                'vmt_emp_sal_adv_details.sal_adv_crd_sts',
                'vmt_emp_sal_adv_details.sal_adv_status',

            ]);

        // dd($all_pending_loans);

        foreach ($all_pending_loans as $single_record) {
            //dd($single_record);
            $approver_flow = collect(json_decode($single_record->emp_approver_flow, true))->sortBy('order');

            $ordered_approver_flow = array();
            foreach ($approver_flow as $key => $value) {
                $ordered_approver_flow[$value['order']] = $value;
            }
            // dd( $ordered_approver_flow);
            foreach ($ordered_approver_flow as $single_ar) {

                if ($user_id == $single_ar['approver']) {
                    $current_user_order = $single_ar['order'];
                    if ($current_user_order == 1) {
                        if ($ordered_approver_flow[$current_user_order]['status'] == 0) {
                            array_push($temp_ar, $single_record);
                        }
                    } else if ($current_user_order == 2) {
                        if ($ordered_approver_flow[$current_user_order - 1]['status'] == 1 && $ordered_approver_flow[$current_user_order]['status'] == 0) {
                            array_push($temp_ar, $single_record);
                        }
                    } else if ($current_user_order == 3) {
                        if ($ordered_approver_flow[$current_user_order - 1]['status'] == 1 && $ordered_approver_flow[$current_user_order]['status'] == 0) {
                            array_push($temp_ar, $single_record);
                        }
                    } else if ($current_user_order == 4) {
                        if ($ordered_approver_flow[$current_user_order - 1]['status'] == 1 && $ordered_approver_flow[$current_user_order]['status'] == 0) {
                            array_push($temp_ar, $single_record);
                        }
                    }
                }

                // dd($current_user_order);
                // dd();
            }
            // if($single_record->user_id==214)
            // dd($temp_ar);

            unset($ordered_approver_flow);
        }

        //return ($temp_ar);

        $pending = array();
        foreach ($temp_ar as $all_pending_advance) {

            // dd($all_pending_advance);

            $sal_adv['id'] = $all_pending_advance['id'];
            $sal_adv['user_id'] = $all_pending_advance['user_id'];
            $sal_adv['request_id'] = $all_pending_advance['request_id'];
            $sal_adv['name'] = $all_pending_advance['name'];
            $sal_adv['user_code'] = $all_pending_advance['user_code'];
            $sal_adv['eligible_amount'] = $all_pending_advance['eligible_amount'];
            $sal_adv['advance_amount'] = $all_pending_advance['borrowed_amount'];
            $sal_adv['dedction_date'] = $all_pending_advance['dedction_date'];
            $sal_adv['reason'] = $all_pending_advance['reason'];
            $sal_adv['status'] = $all_pending_advance['sal_adv_crd_sts'];
            $sal_adv['status_flow'] = $all_pending_advance['sal_adv_status'];
            $sal_adv['emp_prevdetails'] = $this->getEmpsaladvDetails($all_pending_advance['user_id']);

            array_push($pending, $sal_adv);
        }

        return ($pending);
    }


    public function getEmpsaladvDetails($user_id, $year, $month)
    {

        if (empty($month) || empty($year)) {
            $current_time_period =  VmtOrgTimePeriod::where('status', 1)->first();
            $start_date =  $current_time_period->start_date;
            $end_date = $current_time_period->end_date;
        } else {
            $current_month = Carbon::parse($year . '-' . $month . '-01');
            $start_date = $current_month->clone()->format('Y-m-d');
            $end_date =  $current_month->clone()->endOfMonth()->format('Y-m-d');
        }


        $getempdetails = VmtEmpAssignSalaryAdvSettings::join('vmt_emp_sal_adv_details', 'vmt_emp_sal_adv_details.vmt_emp_assign_salary_adv_id', '=', 'vmt_emp_assign_salary_adv_setting.id')
            ->where('vmt_emp_assign_salary_adv_setting.user_id', $user_id)
            ->whereBetween('vmt_emp_sal_adv_details.requested_date', [$start_date, $end_date])
            ->get(
                [
                    'vmt_emp_sal_adv_details.request_id',
                    'vmt_emp_sal_adv_details.borrowed_amount',
                    'vmt_emp_sal_adv_details.requested_date',
                    'vmt_emp_sal_adv_details.dedction_date',
                    'vmt_emp_sal_adv_details.sal_adv_crd_sts as sal_adv_credited_status',
                    'vmt_emp_sal_adv_details.sal_adv_status',
                    'vmt_emp_sal_adv_details.reason as reason',
                    'vmt_emp_sal_adv_details.emp_approver_flow'

                ]
            );

        foreach ($getempdetails as $single_details) {
            $single_details->over_all_status = 'Approved';
            if ($single_details->sal_adv_credited_status == 1) {
                $single_details->over_all_status = 'Loan Credited';
                continue;
            } else {
                $emp_approver_flow = json_decode($single_details->emp_approver_flow, true);
                foreach ($emp_approver_flow as $single_emp_flow) {
                    if ($single_emp_flow['status'] == -1 ||  $single_emp_flow['status'] == 0) {
                        if ($single_emp_flow['status'] == 0) {
                            $single_details->over_all_status = 'Pending';
                            break;
                        } else if ($single_emp_flow['status'] == -1) {
                            $single_details->over_all_status = 'Rejected';
                            break;
                        }
                    }
                }
            }
        }


        return $getempdetails;
    }

    public function salAdvSettingEdit($record_id, $user_id)
    {

        foreach ($user_id as $single_userid) {

            $new_emp_assign = new VmtEmpAssignSalaryAdvSettings;
            $new_emp_assign->user_id  = $single_userid;
            $new_emp_assign->salary_adv_id  = $record_id;
            $new_emp_assign->save();
        }
    }
    public function salAdvSettingDelete($user_id)
    {

        foreach ($user_id as $single_userid) {

            $new_emp_assign = VmtEmpAssignSalaryAdvSettings::where('user_id', $single_userid)->first();
            $new_emp_assign->delete();
        }
    }

    public function salAdvAmtApprovedEmp()
    {

        $get_details =  VmtEmpSalAdvDetails::join('vmt_emp_assign_salary_adv_setting', 'vmt_emp_assign_salary_adv_setting.id', '=', 'vmt_emp_sal_adv_details.vmt_emp_assign_salary_adv_id')
            ->where('sal_adv_crd_sts', '0')->get();

        //    dd($get_details);

        $getsaldetails = [];
        foreach ($get_details as $single_details) {

            $simam['user_id'] = $single_details->user_id;
            $simam['request_id'] = $single_details->request_id;
            $simam['eligible_amount'] = $single_details->eligible_amount;
            $simam['borrowed_amount'] = $single_details->borrowed_amount;
            $simam['requested_date'] = $single_details->requested_date;
            $simam['dedction_date'] = $single_details->dedction_date;
            $simam['json_flow'] = json_decode($single_details->emp_approver_flow, true);

            array_push($getsaldetails, $simam);
        }


        $res11 = [];
        foreach ($getsaldetails as $single_getdetails) {

            for ($i = 0; $i < count($single_getdetails['json_flow']); $i++) {

                if ($single_getdetails['json_flow'][$i]['status'] == 1) {

                    array_push($res11, $single_getdetails);
                }
            }
        }
        dd($res11);
    }




    public function saveIntersetAndIntersetFreeLoanSettings(
        $loan_type,
        $client_id,
        $name,
        $loan_applicable_type,
        $min_month_served,
        $max_loan_limit,
        $percent_of_ctc,
        $loan_amt_interest,
        $deduction_starting_months,
        $max_tenure_months,
        $approver_flow
    ) {
        $sucess_msg = array();


        $validator = Validator::make(
            $data = [
                "loan_type" => $loan_type,
                "client_id" => $client_id,
                "name" => $name,
                'loan_applicable_type' => $loan_applicable_type,
                "min_month_served" => $min_month_served,
                "max_loan_limit" => $max_loan_limit,
                "percent_of_ctc" => $percent_of_ctc,
                "loan_amt_interest" => $loan_amt_interest,
                "deduction_starting_months" => $deduction_starting_months,
                "max_tenure_months" => $max_tenure_months,
                "approver_flow" => $approver_flow
            ],
            $rules = [
                "loan_type" => "required",
                "client_id" => "required",
                "name" => "required",
                'loan_applicable_type' => "required",
                "min_month_served" => "required",
                "deduction_starting_months" => "required",
                "max_tenure_months" => "required",
                "approver_flow" => "required"
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
        $approver_flow = json_encode($approver_flow);
        // $client_id = explode(",", $client_id);
        //dd($approver_flow);

        foreach ($client_id as $single_cl_id) {
            try {
                $client_name = VmtClientMaster::where('id', $single_cl_id)->first()->client_name;
                if ($loan_type == 'InterestFreeLoan') {
                    $setting_for_loan = new VmtInterestFreeLoanSettings;

                    //Here Checking This setting Name Already Exists in table
                    $existing_record = VmtInterestFreeLoanSettings::where('client_id', $single_cl_id);
                    if ($existing_record->where('name', $name)->exists()) {
                        // Sending The Reord id and break One loop here

                        $temp = array();
                        $temp['heading'] = $client_name;
                        $temp['Message'] = 'This Setting Name Already Exist  For Another Settings in ' . $client_name . ' Please Change The Setting Name';
                        $temp['record_id'] = $existing_record->where('name', $name)->first()->id;
                        array_push($sucess_msg, $temp);
                        unset($temp);
                        continue;
                    }
                } else if ($loan_type = 'InterestWithLoan') {
                    $setting_for_loan = new VmtLoanInterestSettings;
                    $setting_for_loan->loan_amt_interest = $loan_amt_interest;
                    //Here Checking This setting Name Already Exists in table
                    $existing_record =  VmtLoanInterestSettings::where('client_id', $single_cl_id);
                    if ($existing_record->where('name', $name)->exists()) {
                        // Sending The Reord id and break One loop here
                        $temp = array();
                        $temp['heading'] = $client_name;
                        $temp['Message'] = 'This Setting Name Already Exist  For Another Settings Please Change The Setting Name';
                        $temp['record_id'] = $existing_record->first()->id;
                        array_push($sucess_msg, $temp);
                        unset($temp);
                        continue;
                    }
                } else {
                    return response()->json([
                        'status' => 'failure',
                        'message' => 'Undefined Loan type'
                    ]);
                }

                $existing_record = $existing_record->where('loan_applicable_type', $loan_applicable_type)->where('name', $name);

                if ($loan_applicable_type == 'percnt') {
                    $existing_record = $existing_record->where('percent_of_ctc', $percent_of_ctc);
                } else if ($loan_applicable_type == 'fixed') {
                    $existing_record = $existing_record->where('max_loan_amount', $max_loan_limit);
                }
                $existing_record =  $existing_record->where('min_month_served', $min_month_served)
                    ->where('deduction_starting_months', $deduction_starting_months)
                    ->where('max_tenure_months', $max_tenure_months)
                    ->where('approver_flow', $approver_flow);
                if ($existing_record->exists()) {
                    $temp = array();
                    $temp['heading'] = $client_name;
                    $temp['Message'] = 'This Setting Already Exist Please Change The Settings';
                    $temp['record_id'] = $existing_record->first()->id;
                    array_push($sucess_msg, $temp);
                    unset($temp);
                    continue;
                }


                $setting_for_loan->client_id = $single_cl_id;
                $setting_for_loan->name = $name;
                $setting_for_loan->loan_applicable_type = $loan_applicable_type;
                if ($loan_applicable_type == 'percnt') {
                    $setting_for_loan->percent_of_ctc = $percent_of_ctc;
                } else if ($loan_applicable_type == 'fixed') {
                    $setting_for_loan->max_loan_amount = $max_loan_limit;
                }
                $setting_for_loan->min_month_served = $min_month_served;
                $setting_for_loan->deduction_starting_months = $deduction_starting_months;
                $setting_for_loan->max_tenure_months = $max_tenure_months;
                $setting_for_loan->approver_flow = $approver_flow;
                $setting_for_loan->active = 1;
                $setting_for_loan->save();
                $temp = array();
                $temp['heading'] = $client_name;
                $temp['Message'] = 'This Setting Assigned For ' . $client_name;
                array_push($sucess_msg, $temp);
                unset($temp);
                continue;
            } catch (Exception $e) {
                return response()->json([
                    "status" => "failure",
                    "message" => "Failed to save interest Free loan setting",
                    "data" => $e->getMessage(),
                ]);
            }
        }

        if (empty($sucess_msg)) {
            return response()->json([
                'status' => 'success',
                'message' => "Interest free and int loan setiings Saved Sucessfully"
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => $sucess_msg
            ]);
        }
    }



    public function showEligibleInterestFreeLoanDetails($loan_type)
    {
        $validator = Validator::make(
            $data = [
                "loan_type" => $loan_type,
            ],
            $rules = [
                "loan_type" => "required",
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
        $user_id = auth()->user()->id;
        //dd($user_id);
        $doj = Carbon::parse(VmtEmployee::where('userid', $user_id)->first()->doj);
        $last_payroll_month = VmtEmployeePayroll::join('vmt_payroll', 'vmt_payroll.id', '=', 'vmt_emp_payroll.payroll_id')
            ->where('user_id', $user_id)->orderBy('vmt_payroll.payroll_date', 'DESC')->first();

        if (empty($last_payroll_month)) {
            $last_payroll_month = VmtPayroll::orderBy('payroll_date', 'DESC')->first();
            if (empty($last_payroll_month)) {
                $last_payroll_month = Carbon::now()->addMonth()->format('Y-m-d');
            } else {
                $last_payroll_month = $last_payroll_month->payroll_date;
            }
        } else {
            $last_payroll_month = $last_payroll_month->payroll_date;
        }
        if ($loan_type == 'InterestWithLoan') {
            $avaliable_int_loans = VmtLoanInterestSettings::where('client_id', sessionGetSelectedClientid())
                ->where('active', 1)->orderBy('min_month_served', 'DESC')->get();
        } else if ($loan_type == 'InterestFreeLoan') {
            $avaliable_int_loans = VmtInterestFreeLoanSettings::where('client_id', sessionGetSelectedClientid())
                ->where('active', 1)->orderBy('min_month_served', 'DESC')->get();
            //  dd($avaliable_int_loans );
        } else {
            return response()->json([
                'status' => 'failure',
                'message' => 'Undefined Loan type'
            ]);
        }
        $exp_month = $doj->diffInMonths(Carbon::now());
        //dd(36);
        foreach ($avaliable_int_loans as $single_record) {
            if ($single_record->min_month_served <= $exp_month) {
                $applicable_loan_info['loan_settings_id'] = $single_record->id;
                if ($single_record->loan_applicable_type == 'fixed') {
                    $applicable_loan_info['max_loan_amount'] = $single_record->max_loan_amount;
                } else if ($single_record->loan_applicable_type == 'percnt') {
                    $yearly_ctc = Compensatory::where('user_id', $user_id)->first()->cic * 12;
                    $applicable_loan_info['max_loan_amount'] = $yearly_ctc * $single_record->percent_of_ctc / 100;
                }
                $max_tenure_month = array();
                for ($i = 1; $i <= $single_record->max_tenure_months; $i++) {
                    $month['month'] = $i;
                    array_push($max_tenure_month, $month);
                }
                $deduction_starting_month = array();
                for ($i = 1; $i <= $single_record->deduction_starting_months; $i++) {
                    $dedct_month['date'] = Carbon::parse($last_payroll_month)
                        ->addMonths($i)->format('Y-m-d');
                    array_push($deduction_starting_month, $dedct_month);
                }
                $applicable_loan_info['max_tenure_months'] = $max_tenure_month;
                $applicable_loan_info['deduction_starting_month'] = $deduction_starting_month;

                if ($loan_type == 'InterestWithLoan') {
                    $applicable_loan_info['loan_amt_interest'] = $single_record->loan_amt_interest;
                }

                return response()->json($applicable_loan_info);
            };
        }
        return null;
    }


    public function applyLoan(
        $loan_type,
        $loan_setting_id,
        $eligible_amount,
        $borrowed_amount,
        $interest_rate,
        $deduction_starting_month,
        $deduction_ending_month,
        $emi_per_month,
        $tenure_months,
        $reason
    ) {


        $validator = Validator::make(
            $data = [
                "loan_type" => $loan_type,
                "loan_setting_id" => $loan_setting_id,
                "eligible_amount" => $eligible_amount,
                "borrowed_amount" => $borrowed_amount,
                "deduction_starting_month" => $deduction_starting_month,
                "deduction_ending_month" => $deduction_ending_month,
                "emi_per_month" => $emi_per_month,
                "tenure_months" => $tenure_months,
                "reason" => $reason,
                "interest_rate" => $interest_rate
            ],
            $rules = [
                "loan_type" => "required",
                "loan_setting_id" => "required",
                "eligible_amount" => "required",
                "borrowed_amount" => "required",
                "deduction_starting_month" => "required",
                "deduction_ending_month" => "required",
                "emi_per_month" => "required",
                "tenure_months" => "required",
                "reason" => "required",
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
        $user_id = auth()->user()->id;

        $getallintrestfreeemp = VmtEmployeeInterestFreeLoanDetails::get()->sortByDesc('id')->first();

        $getallintrestwithemp = VmtEmpInterestLoanDetails::get()->sortByDesc('id')->first();


        try {
            if ($loan_type == 'InterestFreeLoan') {
                $type = 'Interest Free Loan';
                $loan_details = new VmtEmployeeInterestFreeLoanDetails;
                $loan_details->vmt_int_free_loan_id = $loan_setting_id;

                if (empty($getallintrestfreeemp)) {
                    $loan_details->request_id = "ABSIF001";
                } else {
                    $substrid = substr($getallintrestfreeemp->request_id, 5);
                    $add1 = ($substrid + 1);
                    $tostring = ((string) ($add1));
                    $strlenth = strlen($tostring);

                    if ($strlenth == 1) {
                        $requestid = "ABSIF" . "00" . $add1;
                        $loan_details->request_id = $requestid;
                    } else if ($strlenth == 2) {
                        $requestid = "ABSIF" . "0" . $add1;
                        $loan_details->request_id = $requestid;
                    } else {
                        $requestid = "ABSIF" . $add1;
                        $loan_details->request_id = $requestid;
                    }
                }
                $settings_flow = VmtInterestFreeLoanSettings::where('id', $loan_setting_id)->first()->approver_flow;
            } else if ($loan_type = 'InterestWithLoan') {
                $type = 'Interest With Loan';
                $loan_details = new VmtEmpInterestLoanDetails;
                $loan_details->vmt_int_loan_id = $loan_setting_id;
                if (empty($getallintrestwithemp)) {
                    $loan_details->request_id = "ABSIL001";
                } else {
                    $substrid = substr($getallintrestwithemp->request_id, 5);
                    $add1 = ($substrid + 1);
                    $tostring = ((string) ($add1));
                    $strlenth = strlen($tostring);

                    if ($strlenth == 1) {
                        $requestid = "ABSIL" . "00" . $add1;
                        $loan_details->request_id = $requestid;
                    } else if ($strlenth == 2) {
                        $requestid = "ABSIL" . "0" . $add1;
                        $loan_details->request_id = $requestid;
                    } else {
                        $requestid = "ABSIL" . $add1;
                        $loan_details->request_id = $requestid;
                    }
                }

                $settings_flow = VmtLoanInterestSettings::where('id', $loan_setting_id)->first()->approver_flow;
                $loan_details->interest_rate = $interest_rate;
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Undefined Loan type'
                ]);
            }
            $loan_details->user_id = $user_id;
            $loan_details->eligible_amount = $eligible_amount;
            $loan_details->borrowed_amount = $borrowed_amount;
            $loan_details->requested_date = Carbon::now();
            $loan_details->deduction_starting_month = $deduction_starting_month;
            $loan_details->deduction_ending_month = $deduction_ending_month;
            $loan_details->emi_per_month = $emi_per_month;
            $loan_details->tenure_months = $tenure_months;
            $loan_details->reason = $reason;
            $loan_details->approver_flow = $this->getEmpapproverjson($settings_flow, $user_id);
            $loan_details->loan_crd_sts = 0;
            $loan_details->loan_status = 'Pending';
            $loan_details->save();


            if ($loan_type == "InterestFreeLoan") {

                $emp_details = VmtInterestFreeLoanSettings::join('vmt_emp_int_free_loan_details', 'vmt_emp_int_free_loan_details.vmt_int_free_loan_id', '=', 'vmt_int_free_loan_settings.id')
                    ->join('users', 'users.id', '=', 'vmt_emp_int_free_loan_details.user_id')
                    ->where('vmt_emp_int_free_loan_details.id', $loan_details->id)
                    ->first();
            } else if ($loan_type == "InterestWithLoan") {

                $emp_details = VmtLoanInterestSettings::join('vmt_emp_int_loan_details', 'vmt_emp_int_loan_details.vmt_int_loan_id', '=', 'vmt_loan_interest_settings.id')
                    ->join('users', 'users.id', '=', 'vmt_emp_int_loan_details.user_id')
                    ->where('vmt_emp_int_loan_details.id', $loan_details->id)
                    ->first();
            }

            $emp_img = json_decode(newgetEmployeeAvatarOrShortName($user_id), true);
            $mail_sts = $this->applyLoanAndAdvanceMail($user_id,  $loan_details->request_id, $type,  $emp_img, $emp_details);

            return response()->json([
                'status' => 'Success',
                'message' => $mail_sts['data']['msg'],
                'data' => $mail_sts['data']

            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Loan Applied failed Please Contact your Adminsator ",
                "data" => $e->getMessage(),
            ]);
        }
    }

    public function fetchEmployeeForLoanApprovals($loan_type)
    {
        $validator = Validator::make(
            $data = [
                "loan_type" => $loan_type,
            ],
            $rules = [
                "loan_type" => "required",
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

        $user_id = auth()->user()->id;
        $temp_ar = array();
        if ($loan_type == 'InterestFreeLoan') {
            $all_pending_loans = VmtEmployeeInterestFreeLoanDetails::where('loan_crd_sts', 0)->get();
        } else if ($loan_type == 'InterestWithLoan') {
            $all_pending_loans = VmtEmpInterestLoanDetails::where('loan_crd_sts', 0)->get();
        }

        foreach ($all_pending_loans as $single_record) {
            //dd($single_record);
            $approver_flow = collect(json_decode($single_record->approver_flow, true))->sortBy('order');
            $ordered_approver_flow = array();
            foreach ($approver_flow as $key => $value) {
                $ordered_approver_flow[$value['order']] = $value;
            }
            foreach ($ordered_approver_flow as $single_ar) {
                if ($user_id == $single_ar['approver']) {
                    $current_user_order = $single_ar['order'];
                    if ($current_user_order == 1) {
                        if ($ordered_approver_flow[$current_user_order]['status'] == 0) {
                            array_push($temp_ar, $single_record);
                        }
                    } else if ($current_user_order == 2) {
                        if ($ordered_approver_flow[$current_user_order - 1]['status'] == 1 && $ordered_approver_flow[$current_user_order]['status'] == 0) {
                            array_push($temp_ar, $single_record);
                        }
                    } else if ($current_user_order == 3) {
                        if ($ordered_approver_flow[$current_user_order - 1]['status'] == 1 && $ordered_approver_flow[$current_user_order]['status'] == 0) {
                            array_push($temp_ar, $single_record);
                        }
                    } else if ($current_user_order == 4) {
                        if ($ordered_approver_flow[$current_user_order - 1]['status'] == 1 && $ordered_approver_flow[$current_user_order]['status'] == 0) {
                            array_push($temp_ar, $single_record);
                        }
                    }
                }

                // dd($current_user_order);
                // dd();
            }
            // if($single_record->user_id==214)
            // dd($temp_ar);

            unset($ordered_approver_flow);
        }
        $emp_loan_history = array();
        $loan_history = array();
        foreach ($temp_ar as $single_record) {

            // dd($single_record);

            $loan_history['id'] = $single_record['id'];
            $loan_history['request_id'] = $single_record['request_id'];
            $loan_history['user_code'] = User::where('id', $single_record['user_id'])->first()->user_code;
            $loan_history['name'] = User::where('id', $single_record['user_id'])->first()->name;
            $loan_history['eligible_amount'] = $single_record['eligible_amount'];
            $loan_history['loan_amount'] = $single_record['borrowed_amount'];
            if ($loan_type == 'InterestWithLoan') {
                $loan_history['interest_rate'] = $single_record['interest_rate'];
                $loan_history['total amount'] = $single_record['borrowed_amount'] + ($single_record['borrowed_amount'] * $single_record['interest_rate']) / 100;
            }
            $loan_history['reason'] = $single_record['reason'];
            $loan_history['deduction_starting_month'] = $single_record['deduction_starting_month'];
            $loan_history['deduction_ending_month'] = $single_record['deduction_ending_month'];
            $loan_history['monthly_emi'] = $single_record['emi_per_month'];
            $loan_history['tenure'] = $single_record['tenure_months'];
            $loan_history['status'] = $single_record['loan_status'];
            $loan_history['emp_prevdetails'] = $this->EmployeeLoanHistory($single_record['user_id'], $loan_type, '', '');

            array_push($emp_loan_history, $loan_history);
            unset($loan_history);
        }

        return $emp_loan_history;
    }

    public function rejectOrApproveLoan(
        $loan_type,
        $record_id,
        $status,
        $reason
    ) {
        $validator = Validator::make(
            $data = [
                "loan_type" => $loan_type,
                "record_id" => $record_id,
                "status" => $status,
                'reason' => $reason
            ],
            $rules = [
                "loan_type" => "required",
                "record_id" => "required",
                "status" => "required",
                'reason' => "required",
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
            $user_id = auth()->user()->id;
            //  dd($loan_type);
            if ($loan_type == 'InterestFreeLoan') {
                $loan_type_name = 'Interest Free Loan';
                // dd($record_id);
                $loan_details = VmtEmployeeInterestFreeLoanDetails::where('id', $record_id)->first();
                $loan_settings_id =  $loan_details->vmt_int_free_loan_id;
                $loan_settings_approver_flow = VmtInterestFreeLoanSettings::where('id', $loan_settings_id)->first()->approver_flow;
            } else if ($loan_type == 'InterestWithLoan') {
                $loan_type_name = 'Loan With Interest';
                $loan_details = VmtEmpInterestLoanDetails::where('id', $record_id)->first();
                $loan_settings_id =  $loan_details->vmt_int_loan_id;
                $loan_settings_approver_flow = VmtLoanInterestSettings::where('id', $loan_settings_id)->first()->approver_flow;
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Undefined Loan type'
                ]);
            }
            $approver_flow = json_decode($loan_details->approver_flow, true);
            $loan_settings_approver_flow = json_decode($loan_settings_approver_flow, true);
            //dd(  $loan_settings_approver_flow);
            for ($i = 0; $i < count($approver_flow); $i++) {
                if ($approver_flow[$i]['approver'] == $user_id) {
                    if ($status == 1) {
                        $approver_flow[$i]['status'] = $status;
                        $approver_flow[$i]['reason'] = $reason;
                        $loan_details->loan_status =  'Approved By ' . $loan_settings_approver_flow[$i]['name'];
                    } else if ($status == -1) {
                        $approver_flow[$i]['status'] = $status;
                        $approver_flow[$i]['reason'] = $reason;
                        $loan_details->loan_status =  'Rejected By ' . $loan_settings_approver_flow[$i]['name'];
                        $loan_details->loan_crd_sts = -1;
                    }
                }
            }
            $loan_details->approver_flow = json_encode($approver_flow, true);
            $loan_details->save();
            $emp_image = json_decode(newgetEmployeeAvatarOrShortName($user_id), true);
            if ($status == -1) {
                $message = $this->approveOrRejectLoan('Rejected', $loan_type_name, $user_id, $record_id, $reason, $emp_image)['data']['msg'];
                $msg_sts = 'Success';
            } else if ($status == 1) {
                $message = $this->approveOrRejectLoan('Approved', $loan_type_name, $user_id, $record_id, $reason, $emp_image)['data']['msg'];
                $msg_sts = 'Success';
            } else {
                $message = 'Error Occured While Approve Loan';
                $msg_sts = 'Failure';
            }

            return response()->json([
                'status' =>  $msg_sts,
                'message' =>  $message,

            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Approve Or Reject Loan Failed",
                "data" => $e->getMessage(),
            ]);
        }
    }

    public function rejectOrApprovedSaladv($record_id, $status, $reviewer_comments)
    {

        try {

            $user_id = auth()->user()->id;

            $sal_adv_details = VmtEmpSalAdvDetails::where('id', $record_id)->first();
            $sal_adv_settings_id = VmtEmpAssignSalaryAdvSettings::where('id', $sal_adv_details->vmt_emp_assign_salary_adv_id)->first();
            $sal_adv_settings = VmtSalaryAdvSettings::where('id', $sal_adv_settings_id->salary_adv_id)->first();

            $approver_flow = json_decode($sal_adv_details->emp_approver_flow, true);
            $sal_adv_settings_approver_flow = json_decode($sal_adv_settings->approver_flow, true);

            // dd($approver_flow);

            for ($i = 0; $i < count($approver_flow); $i++) {

                if ($approver_flow[$i]['approver'] == $user_id) {

                    $current_order  = $approver_flow[$i]['order'];
                    if ($status == 1) {
                        $approver_flow[$i]['status'] = $status;
                        $approver_flow[$i]['reason'] = $reviewer_comments;
                        $sal_adv_details->sal_adv_status =  'Approved By ' .  $sal_adv_settings_approver_flow[$i]['name'];
                    } else if ($status == -1) {
                        $approver_flow[$i]['status'] = $status;
                        $approver_flow[$i]['reason'] = $reviewer_comments;
                        $sal_adv_details->sal_adv_status =  'Rejected By ' . $sal_adv_settings_approver_flow[$i]['name'];
                        $sal_adv_details->sal_adv_crd_sts = -1;
                    }
                }
            }

            $sal_adv_details->emp_approver_flow = json_encode($approver_flow, true);
            $sal_adv_details->save();

            $loan_type_name = "Salary Advance";

            $emp_image = json_decode(newgetEmployeeAvatarOrShortName(auth()->user()->id), true);

            if ($status == -1) {
                $message = $this->approveOrRejectLoan('Rejected', $loan_type_name, $user_id, $record_id, $reviewer_comments, $emp_image)['data']['msg'];
                $msg_sts = 'success';
            } else if ($status == 1) {
                $message = $this->approveOrRejectLoan('Approved', $loan_type_name, $user_id, $record_id, $reviewer_comments, $emp_image)['data']['msg'];
                $msg_sts = 'success';
            } else {
                $message = 'Error Occured While Approve Loan';
                $msg_sts = 'Failure';
            }




            return response()->json([
                'status' =>  $msg_sts,
                'message' =>  $message,

            ]);
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Approve Or Reject salary_adv  Failed",
                "data" => $e->getMessage(),
            ]);
        }
    }


    public function EmployeeLoanHistory($user_id, $loan_type, $year, $month)
    {

        $validator = Validator::make(
            $data = [
                "loan_type" => $loan_type,
                "user_id" => $user_id,
                "month" => $month,
                "year" => $year
            ],
            $rules = [
                "loan_type" => "required",
                "user_id" => "required",
                "month" => "nullable",
                "year" => "nullable",
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
            if (empty($month) || empty($year)) {
                $current_time_period =  VmtOrgTimePeriod::where('status', 1)->first();
                $start_date =  $current_time_period->start_date;
                $end_date = $current_time_period->end_date;
            } else {
                $current_month = Carbon::parse($year . '-' . $month . '-01');
                $start_date = $current_month->clone()->format('Y-m-d');
                $end_date =  $current_month->clone()->endOfMonth()->format('Y-m-d');
            }
            //  $loan_history = array();
            if ($loan_type == 'InterestFreeLoan') {
                $loan_history = VmtEmployeeInterestFreeLoanDetails::where('user_id', $user_id)
                    ->whereBetween('requested_date', [$start_date, $end_date])
                    ->get();
            } else if ($loan_type == 'InterestWithLoan') {
                $loan_history = VmtEmpInterestLoanDetails::where('user_id', $user_id)
                    ->whereBetween('requested_date', [$start_date, $end_date])
                    ->get();
            }
            if (!empty($loan_history)) {
                foreach ($loan_history as $single_details) {
                    $single_details->over_all_status = 'Approved';
                    if ($single_details->loan_crd_sts == 1) {
                        $single_details->over_all_status = 'Loan Credited';
                        continue;
                    } else {
                        $emp_approver_flow = json_decode($single_details->approver_flow, true);
                        foreach ($emp_approver_flow as $single_emp_flow) {
                            if ($single_emp_flow['status'] == -1 ||  $single_emp_flow['status'] == 0) {
                                if ($single_emp_flow['status'] == 0) {
                                    $single_details->over_all_status = 'Pending';
                                    break;
                                } else if ($single_emp_flow['status'] == -1) {
                                    $single_details->over_all_status = 'Rejected';
                                    break;
                                }
                            }
                        }
                    }
                }
            }


            return $loan_history;
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Employee Loan History",
                "data" => $e->getMessage(),
            ]);
        }
    }

    public function interestAndInterestfreeLoanSettingsDetails($loan_type)
    {
        $validator = Validator::make(
            $data = [
                "loan_type" => $loan_type,
            ],
            $rules = [
                "loan_type" => "required",
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

        $response = array();

        if (VmtClientMaster::count() == 1) {
            if ($loan_type == 'InterestFreeLoan') {
                $loan_settings = VmtInterestFreeLoanSettings::join('vmt_client_master', 'vmt_client_master.id', 'vmt_int_free_loan_settings.client_id')
                    ->get([
                        'vmt_client_master.id as client_id',
                        'vmt_client_master.abs_client_code as abs_client_code',
                        'vmt_client_master.client_code as client_code',
                        'vmt_client_master.client_fullname as client_fullname',
                        'vmt_client_master.client_name as client_name',
                        'vmt_int_free_loan_settings.id as loan_id',
                        'vmt_int_free_loan_settings.name as name',
                        'vmt_int_free_loan_settings.loan_applicable_type as loan_applicable_type',
                        'vmt_int_free_loan_settings.min_month_served as min_month_served',
                        'vmt_int_free_loan_settings.max_loan_amount as max_loan_amount',
                        'vmt_int_free_loan_settings.percent_of_ctc as percent_of_ctc',
                        'vmt_int_free_loan_settings.deduction_starting_months as deduction_starting_months',
                        'vmt_int_free_loan_settings.max_tenure_months as max_tenure_months',
                        'vmt_int_free_loan_settings.approver_flow as approver_flow',
                        'vmt_int_free_loan_settings.active as active',
                    ]);
            } else  if ($loan_type == 'InterestWithLoan') {
                $loan_settings = VmtLoanInterestSettings::join('vmt_client_master', 'vmt_client_master.id', 'vmt_loan_interest_settings.client_id')
                    ->get([
                        'vmt_client_master.id as client_id',
                        'vmt_client_master.abs_client_code as abs_client_code',
                        'vmt_client_master.client_code as client_code',
                        'vmt_client_master.client_fullname as client_fullname',
                        'vmt_client_master.client_name as client_name',
                        'vmt_loan_interest_settings.id as loan_id',
                        'vmt_loan_interest_settings.name as name',
                        'vmt_loan_interest_settings.loan_applicable_type as loan_applicable_type',
                        'vmt_loan_interest_settings.min_month_served as min_month_served',
                        'vmt_loan_interest_settings.max_loan_amount as max_loan_amount',
                        'vmt_loan_interest_settings.percent_of_ctc as percent_of_ctc',
                        'vmt_loan_interest_settings.loan_amt_interest as loan_amt_interest',
                        'vmt_loan_interest_settings.deduction_starting_months as deduction_starting_months',
                        'vmt_loan_interest_settings.max_tenure_months as max_tenure_months',
                        'vmt_loan_interest_settings.loan_amt_interest as loan_amt_interest',
                        'vmt_loan_interest_settings.approver_flow as approver_flow',
                        'vmt_loan_interest_settings.active as active',
                    ]);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Undefined Loan Type'
                ]);
            }
        } else {
            if (sessionGetSelectedClientid() == 1) {
                if ($loan_type == 'InterestFreeLoan') {
                    $loan_settings = VmtInterestFreeLoanSettings::join('vmt_client_master', 'vmt_client_master.id', 'vmt_int_free_loan_settings.client_id')
                        ->get([
                            'vmt_client_master.id as client_id',
                            'vmt_client_master.abs_client_code as abs_client_code',
                            'vmt_client_master.client_code as client_code',
                            'vmt_client_master.client_fullname as client_fullname',
                            'vmt_client_master.client_name as client_name',
                            'vmt_int_free_loan_settings.id as loan_id',
                            'vmt_int_free_loan_settings.name as name',
                            'vmt_int_free_loan_settings.loan_applicable_type as loan_applicable_type',
                            'vmt_int_free_loan_settings.min_month_served as min_month_served',
                            'vmt_int_free_loan_settings.max_loan_amount as max_loan_amount',
                            'vmt_int_free_loan_settings.percent_of_ctc as percent_of_ctc',
                            'vmt_int_free_loan_settings.deduction_starting_months as deduction_starting_months',
                            'vmt_int_free_loan_settings.max_tenure_months as max_tenure_months',
                            'vmt_int_free_loan_settings.approver_flow as approver_flow',
                            'vmt_int_free_loan_settings.active as active',
                        ]);
                } else  if ($loan_type == 'InterestWithLoan') {
                    $loan_settings = VmtLoanInterestSettings::join('vmt_client_master', 'vmt_client_master.id', 'vmt_loan_interest_settings.client_id')->get(
                        [
                            'vmt_client_master.id as client_id',
                            'vmt_client_master.abs_client_code as abs_client_code',
                            'vmt_client_master.client_code as client_code',
                            'vmt_client_master.client_fullname as client_fullname',
                            'vmt_client_master.client_name as client_name',
                            'vmt_loan_interest_settings.id as loan_id',
                            'vmt_loan_interest_settings.name as name',
                            'vmt_loan_interest_settings.loan_applicable_type as loan_applicable_type',
                            'vmt_loan_interest_settings.min_month_served as min_month_served',
                            'vmt_loan_interest_settings.max_loan_amount as max_loan_amount',
                            'vmt_loan_interest_settings.percent_of_ctc as percent_of_ctc',
                            'vmt_loan_interest_settings.loan_amt_interest as loan_amt_interest',
                            'vmt_loan_interest_settings.deduction_starting_months as deduction_starting_months',
                            'vmt_loan_interest_settings.max_tenure_months as max_tenure_months',
                            'vmt_loan_interest_settings.approver_flow as approver_flow',
                            'vmt_loan_interest_settings.active as active',
                        ]
                    );
                } else {
                    return response()->json([
                        'status' => 'failure',
                        'message' => 'Undefined Loan Type'
                    ]);
                }
            } else {
                if ($loan_type == 'InterestFreeLoan') {
                    $loan_settings = VmtInterestFreeLoanSettings::join('vmt_client_master', 'vmt_client_master.id', 'vmt_int_free_loan_settings.client_id')->where('vmt_int_free_loan_settings.client_id', sessionGetSelectedClientid())
                        ->get([
                            'vmt_client_master.id as client_id',
                            'vmt_client_master.abs_client_code as abs_client_code',
                            'vmt_client_master.client_code as client_code',
                            'vmt_client_master.client_fullname as client_fullname',
                            'vmt_client_master.client_name as client_name',
                            'vmt_int_free_loan_settings.id as loan_id',
                            'vmt_int_free_loan_settings.name as name',
                            'vmt_int_free_loan_settings.loan_applicable_type as loan_applicable_type',
                            'vmt_int_free_loan_settings.min_month_served as min_month_served',
                            'vmt_int_free_loan_settings.max_loan_amount as max_loan_amount',
                            'vmt_int_free_loan_settings.percent_of_ctc as percent_of_ctc',
                            'vmt_int_free_loan_settings.deduction_starting_months as deduction_starting_months',
                            'vmt_int_free_loan_settings.max_tenure_months as max_tenure_months',
                            'vmt_int_free_loan_settings.approver_flow as approver_flow',
                            'vmt_int_free_loan_settings.active as active',
                        ]);
                } else  if ($loan_type == 'InterestWithLoan') {
                    $loan_settings = VmtLoanInterestSettings::join('vmt_client_master', 'vmt_client_master.id', 'vmt_loan_interest_settings.client_id')->where('vmt_loan_interest_settings.client_id', sessionGetSelectedClientid())->get([
                        'vmt_client_master.id as client_id',
                        'vmt_client_master.abs_client_code as abs_client_code',
                        'vmt_client_master.client_code as client_code',
                        'vmt_client_master.client_fullname as client_fullname',
                        'vmt_client_master.client_name as client_name',
                        'vmt_loan_interest_settings.id as loan_id',
                        'vmt_loan_interest_settings.name as name',
                        'vmt_loan_interest_settings.loan_applicable_type as loan_applicable_type',
                        'vmt_loan_interest_settings.min_month_served as min_month_served',
                        'vmt_loan_interest_settings.max_loan_amount as max_loan_amount',
                        'vmt_loan_interest_settings.percent_of_ctc as percent_of_ctc',
                        'vmt_loan_interest_settings.loan_amt_interest as loan_amt_interest',
                        'vmt_loan_interest_settings.deduction_starting_months as deduction_starting_months',
                        'vmt_loan_interest_settings.max_tenure_months as max_tenure_months',
                        'vmt_loan_interest_settings.approver_flow as approver_flow',
                        'vmt_loan_interest_settings.active as active',
                    ]);
                } else {
                    return response()->json([
                        'status' => 'failure',
                        'message' => 'Undefined Loan Type'
                    ]);
                }
            }
        }
        foreach ($loan_settings as $single_settings) {
            $temp_ar = array();
            $temp_ar['name'] = $single_settings->name;
            $temp_ar['client_id'] = $single_settings->client_id;
            $temp_ar['client_name'] = $single_settings->client_name;
            $temp_ar['record_id'] = $single_settings->loan_id;
            $temp_ar['Active'] = $single_settings->active;
            if ($single_settings->loan_applicable_type == 'percnt') {
                $temp_ar['loan_type'] = 'Percentage Of CTC';
                $temp_ar['perct'] = $single_settings->percent_of_ctc;
            } else if ($single_settings->loan_applicable_type == 'fixed') {
                $temp_ar['loan_type'] = 'Percentage Of CTC';
                $temp_ar['loan_amt'] = $single_settings->max_loan_amount;
            }
            if ($single_settings->deduction_starting_months < 2) {
                $temp_ar['dedction_period'] = 'Deduct the amount in the Upcomming Payroll';
            } else {
                $temp_ar['dedction_period'] = 'Deduct the amount in the Upcomming ' . $single_settings->deduction_starting_months . ' Payroll';
            }
            $temp_ar['setting_prev_details'] = $single_settings;
            array_push($response, $temp_ar);
            unset($temp_ar);
        }
        $res['settings'] = $response;

        return  $res;
    }
    public function loanTransectionRecord($loan_type, $loan_detail_id)
    {
        //dd($loan_type);

        {
            if ($loan_type == 'InterestFreeLoan') {
                // dd($record_id);
                $loan_details = VmtEmployeeInterestFreeLoanDetails::where('id', $loan_detail_id)->first();
            } else if ($loan_type == 'InterestWithLoan') {
                $loan_details = VmtEmpInterestLoanDetails::where('id', $loan_detail_id)->first();
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Undefined Loan type'
                ]);
            }
            $borrowed_amount = $loan_details->borrowed_amount;
            $tenure_months =  $loan_details->tenure_months;
            $deduction_starting_month = $loan_details->deduction_starting_month;
            for ($i = 0; $i < $tenure_months; $i++) {
                $loan_detail = new VmtInterestFreeLoanTransaction;
                $loan_detail->emp_loan_details_id = $loan_detail_id;
                $loan_detail->expected_emi =  $borrowed_amount / $tenure_months;
                if ($i == 0) {
                    $loan_detail->payroll_date =  $deduction_starting_month;
                }
                $loan_detail->payroll_date = Carbon::parse($deduction_starting_month)->addMonth($i);
                $loan_detail->save();

                // $posts = VmtInterestFreeLoanTransaction::where('status', '=', 1)->whereDate('created_at', '=', $month)->get();
            }
            //dd(gettype($deduction_starting_month));

        }
    }



    public function enableOrDisableLoanSettings($loan_type, $loan_setting_id, $status)
    {
        $validator = Validator::make(
            $data = [
                "loan_type" => $loan_type,
                "loan_setting_id" => $loan_setting_id,
                "status" => $status
            ],
            $rules = [
                "loan_type" => "required",
                "loan_setting_id" => "required",
                "status" => "required",
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


        $msg = '';
        if ($loan_type == 'InterestFreeLoan') {
            $loan_details = VmtInterestFreeLoanSettings::where('id',  $loan_setting_id)->first();
        } else if ($loan_type == 'InterestWithLoan') {
            $loan_details = VmtLoanInterestSettings::where('id', $loan_setting_id)->first();
        } else {
            return response()->json([
                'status' => 'failure',
                'message' => 'Undefined Loan type'
            ]);
        }

        try {
            if ($status == 0) {
                $loan_details->active = 0;
                $msg = 'Loan Disenabled Successfully';
            } else if ($status == 1) {
                $loan_details->active = 1;
                $msg = 'Loan Enabled Successfully';
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Undefined status'
                ]);
            }
            $loan_details->save();
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "enableOrDisableLoanSettings",
                "data" => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => "enableOrDisableLoanSettings",
            'data' => $msg
        ]);
    }

    public function getApprovedRequestedForLoanAndAdvance()
    {
        $response = array();
        //For Interest Free Loan
        $interest_free_loan_query = VmtEmployeeInterestFreeLoanDetails::get();
        foreach ($interest_free_loan_query as $key => $single_record) {
            foreach (json_decode($single_record->approver_flow, true) as $single_approver) {
                if ($single_approver['status'] != 1) {
                    $interest_free_loan_query->forget($key);
                    break;
                }
            }
        }
        if (!empty($interest_free_loan_query)) {
            foreach ($interest_free_loan_query as $single_rcrd) {
                $temp_ar = array();
                $temp_ar['name'] = User::where('id', $single_rcrd->user_id)->first()->name;
                $temp_ar['loan_req_id'] = $single_rcrd->request_id;
                $temp_ar['nature_of_payment'] = 'Interesr Free Loan';
                $temp_ar['amt_borrow'] = $single_rcrd->borrowed_amount;
                $temp_ar['loan_req_date'] = $single_rcrd->requested_date;
                $temp_ar['bank'] = Bank::find(VmtEmployee::where('userid', $single_rcrd->user_id)->first()->bank_id)->bank_name;
                array_push($response,  $temp_ar);
                unset($temp_ar);
            }
        }

        //For Interest With Loan
        $loan_with_interest_query = VmtEmpInterestLoanDetails::get();
        foreach ($loan_with_interest_query as $key => $single_record) {
            foreach (json_decode($single_record->approver_flow, true) as $single_approver) {
                if ($single_approver['status'] != 1) {
                    $loan_with_interest_query->forget($key);
                    break;
                }
            }
        }
        if (!empty($loan_with_interest_query)) {
            foreach ($loan_with_interest_query as $single_rcrd) {
                $temp_ar = array();
                $temp_ar['name'] = User::where('id', $single_rcrd->user_id)->first()->name;
                $temp_ar['loan_req_id'] = $single_rcrd->request_id;
                $temp_ar['nature_of_payment'] = 'Loan With Interest';
                $temp_ar['amt_borrow'] = $single_rcrd->borrowed_amount;
                $temp_ar['loan_req_date'] = $single_rcrd->requested_date;
                $temp_ar['bank'] = Bank::find(VmtEmployee::where('userid', $single_rcrd->user_id)->first()->bank_id)->bank_name;
                array_push($response,  $temp_ar);
                unset($temp_ar);
            }
        }

        //For Salary Advance
        $sal_adv_query = VmtEmpSalAdvDetails::get();
        foreach ($sal_adv_query as $key => $single_record) {
            foreach (json_decode($single_record->emp_approver_flow, true) as $single_approver) {
                if ($single_approver['status'] != 1) {
                    $sal_adv_query->forget($key);
                    break;
                }
            }
        }

        if (!empty($sal_adv_query)) {
            foreach ($sal_adv_query as $single_rcrd) {
                $temp_ar = array();
                $user_id = VmtEmpAssignSalaryAdvSettings::find($single_rcrd->vmt_emp_assign_salary_adv_id)->user_id;
                $temp_ar['name'] = User::where('id',   $user_id)->first()->name;
                $temp_ar['loan_req_id'] = $single_rcrd->request_id;
                $temp_ar['nature_of_payment'] = 'Salary Advance';
                $temp_ar['amt_borrow'] = $single_rcrd->borrowed_amount;
                $temp_ar['loan_req_date'] = $single_rcrd->requested_date;
                $temp_ar['bank'] = Bank::find(VmtEmployee::where('userid',   $user_id)->first()->bank_id)->bank_name;
                array_push($response,  $temp_ar);
                unset($temp_ar);
            }
        }
        return $response;
    }

    public function isEligibleForLoanAndAdvance($loan_type, $user_id)
    {
        try {
            if ($loan_type == "int_free_loan") {
                $loan_type_name = "Interest Free Loan";
            } else if ($loan_type == "loan_with_int") {
                $loan_type_name = "Interest With Loan";
            } else if ($loan_type == "sal_adv") {
                $loan_type_name = "Salary Advance";
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Undefined Loan type'
                ]);
            }
            $enable_status = VmtSalaryAdvanceMasterModel::where('client_id', $client_id = sessionGetSelectedClientid())->first()[$loan_type];
            if ($enable_status == 0) {
                return response()->json([
                    'status' => 'failure',
                    'data' => 0,
                    'message' =>  $loan_type_name . ' Feature is not enabled for your organization'
                ]);
            } else if ($enable_status == 1) {
                $doj = Carbon::parse(VmtEmployee::where('userid', $user_id)->first()->doj);
                if ($loan_type == 'loan_with_int') {
                    $avaliable_int_loans = VmtLoanInterestSettings::where('client_id', sessionGetSelectedClientid())
                        ->where('active', 1)->orderBy('min_month_served', 'DESC')->get();
                } else if ($loan_type == 'int_free_loan') {
                    $avaliable_int_loans = VmtInterestFreeLoanSettings::where('client_id', sessionGetSelectedClientid())
                        ->where('active', 1)->orderBy('min_month_served', 'DESC')->get();
                } else if ($loan_type = "sal_adv") {
                    $assigned_sal_adv = VmtEmpAssignSalaryAdvSettings::where('user_id', $user_id)->first();
                    if (isset($assigned_sal_adv)) {
                        return response()->json([
                            'status' => 'success',
                            'data' => 1,
                            'message' =>  "Eligible For " . $loan_type_name
                        ]);
                    } else {
                        return response()->json([
                            'status' => 'failure',
                            'data' => 0,
                            'message' => "You are not eligible for " . $loan_type_name
                        ]);
                    }
                }
                $exp_month = $doj->diffInMonths(Carbon::now());
                foreach ($avaliable_int_loans as $single_record) {
                    if ($single_record->min_month_served <= $exp_month) {
                        return response()->json([
                            'status' => 'success',
                            'data' => 1,
                            'message' =>  "Eligible For " . $loan_type_name
                        ]);
                    }
                }

                return response()->json([
                    'status' => 'failure',
                    'data' => 0,
                    'message' => "You are not eligible for " . $loan_type_name
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Employee Loan History",
                "data" => $e->getMessage(),
            ]);
        }
    }

    public function employeeDashboardLoanAndAdvance($loan_type, $user_id, $year, $month)
    {
        $total_borrowed_amt = 0;
        $total_repaid_amt = 0;
        $balance_amt = 0;
        $pending_request = 0;
        $compeleted_request = 0;
        $response = array();
        if (empty($month) || empty($year)) {
            $current_time_period =  VmtOrgTimePeriod::where('status', 1)->first();
            $start_date =  $current_time_period->start_date;
            $end_date = $current_time_period->end_date;
        } else {
            $current_month = Carbon::parse($year . '-' . $month . '-01');
            $start_date = $current_month->clone()->format('Y-m-d');
            $end_date =  $current_month->clone()->endOfMonth()->format('Y-m-d');
        }
        if ($loan_type == 'loan_with_int') {
            $loan_amt_query = VmtLoanWithInterestTransactionRecord::join(
                'vmt_emp_int_loan_details',
                'vmt_emp_int_loan_details.id',
                '=',
                'vmt_loan_with_int_transaction_record.emp_loan_details_id'
            )->where('vmt_emp_int_loan_details.loan_crd_sts', 1)
                ->whereBetween('vmt_emp_int_loan_details.requested_date', [$start_date, $end_date])
                ->where('vmt_emp_int_loan_details.user_id', $user_id)
                ->get([
                    'vmt_loan_with_int_transaction_record.payroll_date as payroll_date',
                    'vmt_loan_with_int_transaction_record.expected_emi as expected_emi',
                    'vmt_loan_with_int_transaction_record.paid_emi as paid_emi',
                ]);
            $pending_request_query = VmtEmpInterestLoanDetails::where('user_id', $user_id)
                ->whereBetween('requested_date', [$start_date, $end_date])
                ->where('loan_crd_sts', 0)->count();
            $compeleted_request_query = VmtEmpInterestLoanDetails::where('user_id', $user_id)
                ->whereBetween('requested_date', [$start_date, $end_date])
                ->whereIn('loan_crd_sts', [1, -1])->count();
        } else if ($loan_type == 'int_free_loan') {
            $loan_amt_query = VmtInterestFreeLoanTransaction::join(
                'vmt_emp_int_free_loan_details',
                'vmt_emp_int_free_loan_details.id',
                '=',
                'vmt_int_free_loan_transaction_record.emp_loan_details_id'
            )
                ->where('vmt_emp_int_free_loan_details.loan_crd_sts', 1)->where('vmt_emp_int_free_loan_details.user_id', $user_id)
                ->whereBetween('vmt_emp_int_free_loan_details.requested_date', [$start_date, $end_date])
                ->get([
                    'vmt_int_free_loan_transaction_record.payroll_date as payroll_date',
                    'vmt_int_free_loan_transaction_record.expected_emi as expected_emi',
                    'vmt_int_free_loan_transaction_record.paid_emi as paid_emi',
                ]);
            $pending_request_query = VmtEmployeeInterestFreeLoanDetails::where('user_id', $user_id)
                ->whereBetween('requested_date', [$start_date, $end_date])
                ->where('loan_crd_sts', 0)->count();
            $compeleted_request_query = VmtEmployeeInterestFreeLoanDetails::where('user_id', $user_id)
                ->whereBetween('requested_date', [$start_date, $end_date])
                ->whereIn('loan_crd_sts', [1, -1])->count();
        } else if ($loan_type == 'sal_adv') {
            $loan_amt_query = VmtSalAdvTransactionRecord::join(
                'vmt_emp_sal_adv_details',
                'vmt_emp_sal_adv_details.id',
                '=',
                'vmt_sal_adv_transaction_record.sal_adv_details_id'
            )->join('vmt_emp_assign_salary_adv_setting', 'vmt_emp_assign_salary_adv_setting.id', '=', 'vmt_emp_sal_adv_details.vmt_emp_assign_salary_adv_id')

                ->where('vmt_emp_sal_adv_details.sal_adv_crd_sts', 1)->where('vmt_emp_assign_salary_adv_setting.user_id', $user_id)
                ->whereBetween('vmt_emp_sal_adv_details.requested_date', [$start_date, $end_date])
                ->get([
                    'vmt_sal_adv_transaction_record.payroll_date as payroll_date',
                    'vmt_sal_adv_transaction_record.expected_amt as expected_emi',
                    'vmt_sal_adv_transaction_record.paid_amt as paid_emi',
                    'vmt_emp_sal_adv_details.borrowed_amount as borrowed_amount'
                ]);

            $pending_request_query = VmtEmpSalAdvDetails::join('vmt_emp_assign_salary_adv_setting', 'vmt_emp_assign_salary_adv_setting.id', '=', 'vmt_emp_sal_adv_details.vmt_emp_assign_salary_adv_id')
                ->where('user_id', $user_id)->where('sal_adv_crd_sts', 0)
                ->whereBetween('vmt_emp_sal_adv_details.requested_date', [$start_date, $end_date])
                ->count();
            $compeleted_request_query = VmtEmpSalAdvDetails::join('vmt_emp_assign_salary_adv_setting', 'vmt_emp_assign_salary_adv_setting.id', '=', 'vmt_emp_sal_adv_details.vmt_emp_assign_salary_adv_id')->where('user_id', $user_id)
                ->whereBetween('vmt_emp_sal_adv_details.requested_date', [$start_date, $end_date])
                ->whereIn('sal_adv_crd_sts', [1, -1])->count();
        } else {
            return response()->json([
                'status' => 'failure',
                'message' => 'Undefined Loan type'
            ]);
        }
        foreach ($loan_amt_query  as $single_record) {
            $total_borrowed_amt = $total_borrowed_amt + $single_record->expected_emi;
            $total_repaid_amt = $total_repaid_amt + $single_record->paid_emi;
            $balance_amt =   $total_borrowed_amt -  $total_repaid_amt;
        }
        $pending_request =  $pending_request_query;
        $compeleted_request =   $compeleted_request_query;
        $response['total_borrowed_amt'] = $total_borrowed_amt;
        $response['balance_amt'] = $balance_amt;
        $response['total_repaid_amt'] = $total_repaid_amt;
        $response['pending_request'] = $pending_request;
        $response['compeleted_request'] = $compeleted_request;

        return response()->json([
            'status' => 'success',
            'message' => "",
            'data' => $response,
        ]);
    }

    public function loanAndSalaryAdvanceTimeline($loan_type, $request_id)
    {

        try {
            $response = array();
            $time_line = array();
            if ($loan_type == 'loan_with_int') {
                $loan_sal_adv_details_query = VmtEmpInterestLoanDetails::join(
                    'vmt_loan_interest_settings as settings',
                    'settings.id',
                    '=',
                    'vmt_emp_int_loan_details.vmt_int_loan_id'
                )->where('request_id', $request_id)->first([
                    'vmt_emp_int_loan_details.eligible_amount as eligible_amount',
                    'vmt_emp_int_loan_details.borrowed_amount as borrowed_amount',
                    'vmt_emp_int_loan_details.approver_flow as emp_approver_flow',
                    'settings.approver_flow as approver_flow',
                ]);;
            } else if ($loan_type == 'int_free_loan') {
                $loan_sal_adv_details_query = VmtEmployeeInterestFreeLoanDetails::join(
                    'vmt_int_free_loan_settings as settings',
                    'settings.id',
                    '=',
                    'vmt_emp_int_free_loan_details.vmt_int_free_loan_id'
                )->where('request_id', $request_id)->first([
                    'vmt_emp_int_free_loan_details.eligible_amount as eligible_amount',
                    'vmt_emp_int_free_loan_details.borrowed_amount as borrowed_amount',
                    'vmt_emp_int_free_loan_details.approver_flow as emp_approver_flow',
                    'settings.approver_flow as approver_flow',
                ]);
            } else if ($loan_type == 'sal_adv') {
                $loan_sal_adv_details_query = VmtEmpSalAdvDetails::join(
                    'vmt_emp_assign_salary_adv_setting',
                    'vmt_emp_assign_salary_adv_setting.id',
                    '=',
                    'vmt_emp_sal_adv_details.vmt_emp_assign_salary_adv_id'
                )->join(
                    'vmt_salary_adv_setting',
                    'vmt_salary_adv_setting.id',
                    '=',
                    'vmt_emp_assign_salary_adv_setting.salary_adv_id'
                )->where('request_id', $request_id)->first();
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Undefined Loan type'
                ]);
            }
            $approver_flow = json_decode($loan_sal_adv_details_query->approver_flow, true);
            $emp_approver_flow = json_decode($loan_sal_adv_details_query->emp_approver_flow, true);
            foreach ($approver_flow as $single_approver_flow) {
                foreach ($emp_approver_flow as $single_emp_approver_flow) {
                    if ($single_approver_flow['order'] == $single_emp_approver_flow['order']) {
                        $temp_ar = array();
                        $temp_ar['heading'] = $single_approver_flow['name'];
                        if ($single_emp_approver_flow['status'] == 0) {
                            $temp_ar['status'] = 'Pending';
                        } else if ($single_emp_approver_flow['status'] == 1) {
                            $temp_ar['status'] = 'Approved';
                        } else if ($single_emp_approver_flow['status'] == -1) {
                            $temp_ar['status'] = 'Rejected';
                        }
                        if (array_key_exists('reason', $single_emp_approver_flow)) {
                            $temp_ar['reason'] = $single_emp_approver_flow['reason'];
                        } else {
                            $temp_ar['reason'] = '';
                        }
                        array_push($time_line, $temp_ar);
                        unset($temp_ar);
                    }
                }
            }
            krsort($time_line);
            $response['borrowed_amount'] = $loan_sal_adv_details_query->borrowed_amount;
            $response['time_line'] = $time_line;
            return response()->json([
                'status' => 'success',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ loanAndSalaryAdvanceTimeline() ] ",
                'error' => $e->getMessage(),
                'data' => $e->getTraceAsString()
            ]);
        }
    }
}
