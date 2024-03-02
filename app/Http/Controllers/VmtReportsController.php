<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Bank;

use App\Models\ConfigPms;
use App\Models\VmtPMS_KPIFormAssignedModel;
use App\Models\VmtPMS_KPIFormReviewsModel;
use App\Models\VmtEmployeePaySlip;
use App\Models\VmtEmployeeOfficeDetails;

use App\Models\VmtPayroll;
use App\Models\Department;
use App\Models\VmtEmployeePayslipV2;
use App\Models\User;
use App\Models\VmtWorkShifts;
use App\Models\VmtEmployeeLeaves;
use App\Models\VmtEmployeeAttendanceRegularization;
use Illuminate\Support\Facades\DB;
use App\Exports\VmtPmsReviewsReport;
use App\Exports\ManagerReimbursementsExport;
use App\Exports\EmployeeReimbursementsExport;
use App\Exports\AnnualEarnedExport;
use App\Models\VmtEmployeeAttendance;
use App\Exports\EmployeeBasicCtcExport;
use App\Exports\EmployeeMasterExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\VmtEmployeeReimbursements;
use App\Services\VmtReimbursementsService;
use App\Services\VmtReportsservice;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\VmtClientMaster;
use App\Models\VmtOrgTimePeriod;

class VmtReportsController extends Controller
{
    public function showReportsPage()
    {

        return view('reports.vmt_reports_page');
    }

    public function showPayrollReportsPage(Request $request)
    {
        // $payroll_months = [
        //     "Nov 2022"=>"01-11-2022",
        //     "Dec 2022"=>"01-12-2022"
        // ];
        $query_payroll_year = VmtPayroll::groupby('payroll_date')->pluck('payroll_date');
        $work_location = VmtEmployeeOfficeDetails::groupby('work_location')->pluck('work_location');
        $designation = VmtEmployeePaySlipV2::leftjoin('vmt_emp_payroll', 'vmt_emp_payroll.id', '=', 'vmt_employee_payslip_v2.emp_payroll_id')
            ->leftjoin('vmt_payroll', 'vmt_payroll.id', '=', 'vmt_emp_payroll.payroll_id')
            ->leftjoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'vmt_emp_payroll.user_id')
            ->groupby('vmt_employee_office_details.designation')->pluck('vmt_employee_office_details.designation');

        for ($i = 0; $i < count($query_payroll_year); $i++) {
            $query_payroll_year[$i] = date("Y", strtotime($query_payroll_year[$i]));
        }

        $payroll_available_years = array_unique($query_payroll_year->toArray());
        // $payroll_months = [];
        // for($i=0;$i<count($query_payroll_months);$i++){
        //     $array_values = explode('-', $query_payroll_months[$i]);
        //         if($array_values[1]=='01'){
        //             $each_month=[
        //                 'January ' . $array_values[0]=>$query_payroll_months[$i]
        //             ];
        //         }else if($array_values[1]=='02'){
        //             $each_month=[
        //                 'February ' . $array_values[0]=>$query_payroll_months[$i]
        //             ];
        //         }else if($array_values[1]=='03'){
        //             $each_month=[
        //                 'March ' . $array_values[0]=>$query_payroll_months[$i]
        //             ];
        //         }else if($array_values[1]=='04'){
        //             $each_month=[
        //                 'April ' . $array_values[0]=>$query_payroll_months[$i]
        //             ];
        //             //dd($each_month);
        //         }else if($array_values[1]=='05'){
        //             $each_month=[
        //                 'May ' . $array_values[0]=>$query_payroll_months[$i]
        //             ];
        //         }else if($array_values[1]=='06'){
        //             $each_month=[
        //                 'Jun ' . $array_values[0]=>$query_payroll_months[$i]
        //             ];
        //         }else if($array_values[1]=='07'){
        //             $each_month=[
        //                 'July ' . $array_values[0]=>$query_payroll_months[$i]
        //             ];
        //         }else if($array_values[1]=='08'){
        //             $each_month=[
        //                 'August ' . $array_values[0]=>$query_payroll_months[$i]
        //             ];
        //         }else if($array_values[1]=='09'){
        //             $each_month=[
        //                 'September ' . $array_values[0]=>$query_payroll_months[$i]
        //             ];
        //         }else if($array_values[1]=='10'){
        //             $each_month=[
        //                 'October ' . $array_values[0]=>$query_payroll_months[$i]
        //             ];
        //         }else if($array_values[1]=='11'){
        //             $each_month=[
        //                 'November ' . $array_values[0]=>$query_payroll_months[$i]
        //             ];
        //         }else if($array_values[1]=='12'){
        //             $each_month=[
        //                 'December ' . $array_values[0]=>$query_payroll_months[$i]
        //             ];
        //         }
        //         $payroll_months=array_merge($payroll_months, $each_month);
        // }

        return view('reports.vmt_showPayrollReports', compact('work_location', 'designation', 'payroll_available_years'));
    }

    // Retrieves all months payroll for the given Year

    public function fetchPayrollMonthForGivenYear(Request $request)
    {
        $payroll_month = VmtPayroll::whereYear('payroll_date', $request->payroll_year)->groupby('payroll_date')->pluck('payroll_date');
        for ($i = 0; $i < count($payroll_month); $i++) {

            $payroll_month[$i] = date("m", strtotime($payroll_month[$i]));
        }
        $payroll_available_months = array_unique($payroll_month->toArray());

        return $payroll_available_months;
    }

    public function generatePayrollReports(Request $request)
    {

        $filename = 'PayrollReports_' . $request->payroll_month . '.xlsx';
        return Excel::download(new VmtPayrollReports($request->payroll_month), $filename, null, [\Maatwebsite\Excel\Excel::XLSX]);
    }

    public function isLeaveRequestApplied($user_id, $attendance_date, $year, $month)
    {
        // dd($year);

        $leave_Details = VmtEmployeeLeaves::join('vmt_leaves', 'vmt_leaves.id', '=', 'vmt_employee_leaves.leave_type_id')
            ->where('user_id', $user_id)
            ->whereYear('end_date', $year)
            ->whereMonth('end_date', $month)
            ->get(['start_date', 'end_date', 'status', 'vmt_leaves.leave_type', 'total_leave_datetime']);

        if ($leave_Details->count() == 0) {
            return null;
        } else {
            foreach ($leave_Details as $single_leave_details) {
                $startDate = Carbon::parse($single_leave_details->start_date)->subDay();
                $endDate = Carbon::parse($single_leave_details->end_date);
                $currentDate =  Carbon::parse($attendance_date);
                // dd($startDate.'-----'.$currentDate.'------------'.$endDate.'-----');
                if ($currentDate->gt($startDate) && $currentDate->lte($endDate)) {
                    // dd($single_leave_details);
                    return $single_leave_details;
                } else {
                    $single_leave_details = null;
                }
            }
            return $single_leave_details;
        }


        //check whether leave applied.If yes, check leave status
        $leave_record = VmtEmployeeLeaves::where('user_id', $user_id)->whereDate('end_date', $attendance_date);

        if ($leave_record->exists()) {
            return $leave_record->first();
        } else {
            return null;
        }
    }



    private function isRegularizationRequestApplied($user_id, $attendance_date, $regularizeType)
    {

        $regularize_record = VmtEmployeeAttendanceRegularization::where('attendance_date', $attendance_date)
            ->where('user_id',  $user_id)->where('regularization_type', $regularizeType);

        // dd($user_id ." , ". $attendance_date." , ".$regularizeType);

        if ($regularize_record->exists()) {
            return $regularize_record->value('status');
        } else {
            return "None";
        }
    }


    public function fetchPayrollReport(Request $request)
    {
        //  dd($request->all());
        $payroll_data = VmtEmployeePaySlipV2::leftjoin('vmt_emp_payroll', 'vmt_emp_payroll.id', '=', 'vmt_employee_payslip_v2.emp_payroll_id')
            ->leftjoin('vmt_payroll', 'vmt_payroll.id', '=', 'vmt_emp_payroll.payroll_id')
            ->leftJoin('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'vmt_emp_payroll.user_id')
            ->leftJoin('users', 'users.id', '=', 'vmt_emp_payroll.user_id')
            ->leftJoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'vmt_emp_payroll.user_id')
            ->leftJoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'vmt_emp_payroll.user_id')
            ->leftJoin('vmt_employee_statutory_details', 'vmt_employee_statutory_details.user_id', '=', 'vmt_emp_payroll.user_id')
            ->whereYear('vmt_payroll.payroll_date', $request->payroll_year)
            // ->orWhere('vmt_employee_office_details.work_location',$request->work_location)
            ->select(
                'users.user_code',
                'users.name',

                'vmt_employee_office_details.DESIGNATION',
                'vmt_employee_details.doj',
                'vmt_employee_details.dob',

                'vmt_employee_office_details.work_location',

                'vmt_employee_details.Aadhar_Number',
                'vmt_employee_details.PAN_Number',

                'vmt_employee_statutory_details.uan_number',
                'vmt_employee_statutory_details.epf_number',
                'vmt_employee_statutory_details.esic_number',

                'vmt_employee_details.bank_id',
                'vmt_employee_details.bank_account_number',
                'vmt_employee_details.bank_ifsc_code',
                'vmt_employee_details.mobile_number',

                'vmt_employee_office_details.officical_mail',

                //Abry and Enitiy
                'vmt_payroll.payroll_date as PAYROLL_MONTH',
                //Total Emoluments
                'vmt_employee_payslip_v2.basic as BASIC',
                'vmt_employee_payslip_v2.hra as HRA',
                'vmt_employee_payslip_v2.spl_alw as SPL_ALW',
                'vmt_employee_payslip_v2.total_fixed_gross as TOTAL_FIXED_GROSS',

                'vmt_employee_statutory_details.esic_applicable',

                'vmt_employee_payslip_v2.month_days as MONTH_DAYS',
                'vmt_employee_payslip_v2.worked_Days as Worked_Days',
                'vmt_employee_payslip_v2.arrears_Days as Arrears_Days',
                'vmt_employee_payslip_v2.lop as LOP',
                'vmt_employee_payslip_v2.earned_basic as Earned_BASIC',
                'vmt_employee_payslip_v2.basic_arrear as BASIC_ARREAR',
                'vmt_employee_payslip_v2.earned_hra as Earned_HRA',
                'vmt_employee_payslip_v2.hra_arrear as HRA_ARREAR',
                'vmt_employee_payslip_v2.earned_spl_alw as Earned_SPL_ALW',
                'vmt_employee_payslip_v2.spl_alw_arrear as SPL_ALW_ARREAR',
                'vmt_employee_payslip_v2.overtime as Overtime',
                //Overtime Arrears
                'vmt_employee_payslip_v2.total_earned_gross as TOTAL_EARNED_GROSS',
                'vmt_employee_payslip_v2.pf_wages as PF_WAGES',
                'vmt_employee_payslip_v2.pf_wages_arrear_epfr as PF_WAGES_ARREAR_EPFR',
                'vmt_employee_payslip_v2.epfr as EPFR',
                'vmt_employee_payslip_v2.epfr_arrear as EPFR_ARREAR',
                'vmt_employee_payslip_v2.edli_charges as EDLI_CHARGES',
                'vmt_employee_payslip_v2.edli_charges_arrears as EDLI_CHARGES_ARREARS',
                'vmt_employee_payslip_v2.pf_admin_charges as PF_ADMIN_CHARGES',
                'vmt_employee_payslip_v2.pf_admin_charges_arrears as PF_ADMIN_CHARGES_ARREARS',
                'vmt_employee_payslip_v2.employer_esi as EMPLOYER_ESI',
                'vmt_employee_payslip_v2.employer_lwf as Employer_LWF',
                'vmt_employee_payslip_v2.ctc as CTC',
                'vmt_employee_payslip_v2.epf_ee as EPF_EE',
                //VPF
                'vmt_employee_payslip_v2.epf_ee_arrear as EPF_EE_ARREAR',
                'vmt_employee_payslip_v2.employee_esic as EMPLOYEE_ESIC',
                'vmt_employee_payslip_v2.prof_tax as PROF_TAX',
                //'vmt_employee_payslip_v2.TDS',
                //incomeTax
                'vmt_employee_payslip_v2.sal_adv as SAL_ADV',
                'vmt_employee_payslip_v2.canteen_dedn as CANTEEN_DEDN',
                'vmt_employee_payslip_v2.other_deduc as OTHER_DEDUC',
                'vmt_employee_payslip_v2.LWF',
                'vmt_employee_payslip_v2.total_deductions as TOTAL_DEDUCTIONS',
                'vmt_employee_payslip_v2.net_take_home as NET_TAKE_HOME'
            );

        // For Filter Option

        if ($request->payroll_month != "all") {
            $payroll_data = $payroll_data->whereMonth('vmt_payroll.payroll_date', $request->payroll_month);
        }


        if ($request->work_location != "all") {
            $payroll_data = $payroll_data->where('vmt_employee_office_details.work_location', $request->work_location);
        }

        if (session('client_id') != '1') {
            $payroll_data = $payroll_data->where('users.client_id', session('client_id'));
            //return ($payroll_data);
        }

        //fetch bank names
        $payroll_data = $payroll_data->get();

        foreach ($payroll_data as $singlePayrollData) {
            // $singlePayrollData['bank_name'] = Bank::find($singlePayrollData->bank_id)->bank_name;
            $singlePayrollData['bank_name'] = Bank::find($singlePayrollData->bank_id);
            if ($singlePayrollData['bank_name']) {
                $singlePayrollData['bank_name'] = $singlePayrollData['bank_name']->bank_name;
            } else {
                $singlePayrollData['bank_name'] = '';
            }
        }

        //dd($payroll_data->get());
        //dd( $payroll_data);
        return $payroll_data;
    }


    public function showPmsReviewsReportPage(Request $request)
    {
        $query_configPms = ConfigPms::first(['calendar_type', 'frequency']);
        $query_years = VmtPMS_KPIFormAssignedModel::groupby('year')->pluck('year');
        $username = User::groupby('id')->pluck('name', 'id');
        $username = json_decode($username, true);

        //dd($query_years);
        //dd($query_years->value('year'));
        return view('reports.pms_reports.vmt_showPmsReviewsReports', compact('query_configPms', 'query_years', 'username'));
    }

    public function filterPmsReport(Request $request)
    {
        // dd($request->all());
        $query_pms_data = VmtPMS_KPIFormReviewsModel::leftJoin('users', 'users.id', '=', 'vmt_pms_kpiform_reviews.assignee_id')
            ->leftJoin('vmt_pms_kpiform_assigned', 'vmt_pms_kpiform_assigned.id', '=', 'vmt_pms_kpiform_reviews.vmt_pms_kpiform_assigned_id')
            ->where('vmt_pms_kpiform_assigned.year', '=', $request->year)
            //->orWhere('vmt_pms_kpiform_assigned.assignment_period','=',$request->assignment_period)
            ->select(
                'users.user_code',
                'users.name',
                'vmt_pms_kpiform_assigned.calendar_type',
                'vmt_pms_kpiform_assigned.year',
                'vmt_pms_kpiform_assigned.frequency',
                'vmt_pms_kpiform_assigned.assignment_period',
                'vmt_pms_kpiform_reviews.is_assignee_submitted',
                //'vmt_pms_kpiform_reviews.is_reviewer_accepted', //For Manager name
                'vmt_pms_kpiform_reviews.is_reviewer_submitted',
            );
        //dd($query_pms_data);
        if ($request->assignment_period != "All") {
            $query_pms_data = $query_pms_data->where('vmt_pms_kpiform_assigned.assignment_period', '=', $request->assignment_period);
        }
        if ($request->submission_status == "1") {

            $query_pms_data = $query_pms_data->where('vmt_pms_kpiform_reviews.is_assignee_submitted', '=', 1);
        } else if ($request->submission_status == "") {
            $query_pms_data = $query_pms_data->where('vmt_pms_kpiform_reviews.is_assignee_submitted', '=', null);
        }
        if ($request->reviewed_status == "1") {
            $query_pms_data = $query_pms_data->where('vmt_pms_kpiform_reviews.is_reviewer_submitted', 'like', '%"1"}');
        } else if ($request->reviewed_status == "") {
            $query_pms_data = $query_pms_data->where('vmt_pms_kpiform_reviews.is_reviewer_submitted', 'not like', '%"1"}');
        }
        if ($request->emp_accepted_status == "1") {
            $query_pms_data = $query_pms_data->where('vmt_pms_kpiform_reviews.is_assignee_accepted', '=', 1);
        } else if ($request->emp_accepted_status == "") {
            $query_pms_data = $query_pms_data->where('vmt_pms_kpiform_reviews.is_assignee_accepted', '=', null);
        }
        if ($request->mangr_accepted_status == "1") {
            $query_pms_data = $query_pms_data->where('vmt_pms_kpiform_reviews.is_reviewer_accepted', 'like', '%"1"}');
        } else if ($request->mangr_accepted_status == "") {
            $query_pms_data = $query_pms_data->where('vmt_pms_kpiform_reviews.is_reviewer_accepted', 'not like', '%"1"}');
        }

        if (session('client_id') != '1') {
            $query_pms_data = $query_pms_data->where('users.client_id', session('client_id'));
            //return ($payroll_data);
        }

        return $query_pms_data->get();
    }

    public function generatePmsReviewsReports(Request $request)
    {
        //$filename = 'PmsReports_'.$request->calender_type.'.xlsx';
        // dd($request->all());

        return Excel::download(new VmtPmsReviewsReport(
            $request->calender_type,
            $request->year,
            $request->assignment_period,
            $request->is_assignee_submitted,
            $request->is_reviewer_submitted,
            $request->is_reviewer_accepted,
            $request->is_emp_accepted,
            $request->getHttpHost()
        ), 'Pms Reports.xlsx');
    }

    public function showAttendanceReport(Request $request)
    {
        $attendance_year = VmtEmployeeAttendance::groupby('date')->pluck('date');

        for ($i = 0; $i < count($attendance_year); $i++) {
            $attendance_year[$i] = date("Y", strtotime($attendance_year[$i]));
        }

        $attendance_available_years = array_unique($attendance_year->toArray());

        return view('reports.vmt_attendance_reports', compact('attendance_available_years'));
    }

    /*
        Retrieves all months attendance for the
        given Year

    */
    public function fetchAttendanceForGivenYear(Request $request)
    {

        $attendance_month = VmtEmployeeAttendance::whereYear('vmt_employee_attendance.date', $request->attendance_year)->groupby('date')->pluck('date');
        for ($i = 0; $i < count($attendance_month); $i++) {

            $attendance_month[$i] = date("m", strtotime($attendance_month[$i]));
        }
        $attendance_available_months = array_unique($attendance_month->toArray());

        return $attendance_available_months;
    }

    public function fetchAttendanceInfo(Request $request)
    {
        //    dd($request->attendance_year);
        $attendance_data = VmtEmployeeAttendance::leftJoin('users as us', 'us.id', '=', 'vmt_employee_attendance.user_id')
            ->leftjoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'us.id')
            ->leftjoin('vmt_employee_attendance_regularizations', 'vmt_employee_attendance_regularizations.user_id', '=', 'us.id')
            ->whereYear('vmt_employee_attendance.date', $request->attendance_year)
            ->select(
                'user_code',
                'name',
                'designation',
                'checkin_time',
                'checkout_time',
                'regularization_type',
                'status'
            );
        //dd($attendance_data);
        if ($request->attendance_month != "All") {
            $attendance_data = $attendance_data->whereMonth('vmt_employee_attendance.date', $request->attendance_month);
        }

        return $attendance_data->get();
    }


    private function getManagerReimbursementsReports($year, $month, $status)
    {
        //dd($year);

        $reimbursements_details = User::leftJoin(
            'vmt_employee_office_details',
            'vmt_employee_office_details.user_id',
            '=',
            'users.id'
        )
            ->leftJoin('vmt_department', 'vmt_department.id', '=', 'vmt_employee_office_details.department_id')
            ->join('vmt_employee_reimbursements', 'vmt_employee_reimbursements.user_id', '=', 'users.id')
            ->where('is_ssa', 0)->where('active', '1')
            ->whereYear('vmt_employee_reimbursements.date', $year)
            ->whereMonth('vmt_employee_reimbursements.date', $month)
            ->groupBy('users.id')
            ->select(
                'users.user_code',
                'users.name',
                'vmt_employee_office_details.designation',
                'vmt_department.name as department',
                DB::raw('sum(vmt_employee_reimbursements.distance_travelled) as total_distance'),
                DB::raw('sum(vmt_employee_reimbursements.total_expenses) as total_expenses'),
                'vmt_employee_office_details.l1_manager_name'
            );


        if ($status != "undefined") {
            $reimbursements_details = $reimbursements_details->where('vmt_employee_reimbursements.status', $status);
        }
        // dd($reimbursements_details->get());

        return $reimbursements_details->get();
    }

    public function generateManagerReimbursementsReports(Request $request)
    {
        // dd($request->selected_status);
        $year = $request->selected_year;
        $month = $request->selected_month;
        $status = $request->selected_status;
        $overall_distance = 0;
        $overall_expense = 0;

        $reimbursements_details = $this->getManagerReimbursementsReports($year, $month, $status);
        //dd($reimbursements_details);
        foreach ($reimbursements_details as $single_details) {
            $overall_distance = $overall_distance + $single_details->total_distance;
            $overall_expense = $overall_expense + $single_details->total_expenses;
        }
        //$totals = array('',"Total","","",$overall_distance, $overall_expense);
        $totals = array("Total" => "Total", "overall_distance" => $overall_distance, "overall_Expense" => $overall_expense);
        //dd($totals);

        // ->sum('vmt_employee_reimbursements.distance_travelled');
        // dd(gettype($user_details));
        //  dd(count($reimbursements_details));
        $client_name = sessionGetSelectedClientName();
        if ($client_name == 'Protocol') {
            $legal_entity = 'PROTOCOL LABELS INDIA PRIVATE LIMITED';
            $client_name = strtolower($client_name);
        } else {
            $legal_entity =  $client_name;
            $client_name = strtolower($client_name);
        }
        $file_name = date("F", strtotime('00-' . $month . '-01')) . "-" . $year;
        $month_name = strtoupper(date("F", strtotime('00-' . $month . '-01')));
        return Excel::download(new ManagerReimbursementsExport(
            $reimbursements_details,
            $totals,
            $legal_entity,
            $month_name,
            $year,
            $client_name
        ), $file_name . ' Reimbursements Reports.xlsx');
    }
    public function fetchManagerReimbursementsReports(Request $request)
    {
        $month = "2022";
        $year = "12";
        $status = "Pending";
        return  $this->getManagerReimbursementsReports($year, $month, $status);
    }

    public function generateEmployeeReimbursementsReports(Request $request, VmtReimbursementsService $reimbursementService)
    {

        $user_id = auth()->user()->id;
        //dd($request->all());
        $year = $request->selected_year;
        $month = $request->selected_month;
        $overall_distance = 0;
        $overall_expense = 0;
        $reimbursement_data = array();

        $employee_details = User::join('vmt_employee_details AS details', 'details.userid', '=', 'users.id')
            ->leftjoin('vmt_employee_office_details AS office','office.user_id','=','users.id')
            ->leftjoin('vmt_department AS dep', 'dep.id', '=', 'office.department_id')
            ->where('users.id', auth()->user()->id)
            ->select('users.user_code', 'users.name AS name', 'dep.name AS department', 'details.location')->first();

        foreach ($reimbursementService->fetchEmployeeReimbursement($user_id, $year, $month) as $single_data) {

            $overall_distance = $overall_distance + (int)$single_data->distance_travelled;
            $overall_expense = $overall_expense + (int) $single_data->total_expenses;


            $single_reimbursement_data = array(
                Carbon::parse($single_data->date)->format('d-M-y'),
                $single_data->reimbursement_type, $single_data->from,
                $single_data->to, $single_data->vehicle_type,
                $single_data->distance_travelled, $single_data->amt_per_km,
                $single_data->total_expenses, $single_data->user_comments
            );
            //dd($single_data->user_comments);
            array_push($reimbursement_data, $single_reimbursement_data);
            $totals = array("Total" => "Total", "overall_distance" => $overall_distance, "overall_Expense" => $overall_expense);
            unset($single_reimbursement_data);
        }

        //dd($reimbursement_data);


        $client_name = sessionGetSelectedClientName();

        if ($client_name == 'Protocol') {
            $legal_entity = 'PROTOCOL LABELS INDIA PRIVATE LIMITED';
            $client_name = strtolower($client_name);
        } else {
            $legal_entity =  $client_name;
            $client_name = strtolower($client_name);
        }

        $client_logo_path = session()->get('client_logo_url');

        $file_name = date("F", strtotime('00-' . $month . '-01')) . "-" . $year;
        $month_name = strtoupper(date("F", strtotime('00-' . $month . '-01')));

        //dd($employee_details);


        return  Excel::download(
            new EmployeeReimbursementsExport(
                $employee_details,
                $reimbursement_data,
                $legal_entity,
                $month_name,
                $year,
                $client_name,
                $client_logo_path,
                $totals
            ),
            $employee_details['user_code'] . '_' . $employee_details['name'] . '_' . $file_name . ' Reimbursements Reports.xlsx'
        );
    }


    public function generateAnnualEarnedReport(Request $request, VmtReportsservice $reportsService)
    {
        $headings = array();
        $start_date = '2022-04-01';
        $end_date = '2023-03-31';
        $response = $reportsService->fetchAnnualEarnedDetails($start_date, $end_date);
        foreach ($response[0] as $key => $value) {
            array_push($headings, $key);
        }

        return Excel::download(new AnnualEarnedExport($response, $headings), 'Annual Earned Report.xlsx');
    }
    public function getEmployeesCTCDetails(Request $request, VmtReportsservice $reportsService)
    {


        return  $reportsService->getEmployeesCTCDetails($request->type, $request->legal_entity, $request->active_status, $request->department_id, $request->date);
    }

    public function generateEmployeesCTCReportData(Request $request, VmtReportsservice $reportsService)
    {

        $date = Carbon::now()->format('M-y');
        $request->type;
        $period_date = carbon::parse($request->date)->format('d-m-Y');
        $emp_ctc_data = $reportsService->getEmployeesCTCDetails($request->type, $request->legal_entity, $request->active_status, $request->department_id, $request->date);
        $headers = array();
        if (empty($request->active_status)) {
            $active_status = 'Active,Resigned,Yet to activate';
        } else {
            $active_status = '';
            foreach ($request->active_status as $single_sts) {
                if ($single_sts == '0') {
                    $active_status = $active_status . 'Yet to activate,';
                } else if ($single_sts == '1') {
                    $active_status = $active_status . 'Active,';
                } else if ($single_sts == '-1') {
                    $active_status = $active_status . 'Resigned,';
                } else {
                }
            }
        }
        //  dd( $emp_ctc_data);
        $client_name = sessionGetSelectedClientName();
        $client_logo_path = session()->get('client_logo_url');
        $public_client_logo_path = public_path($client_logo_path);
        return Excel::download(new EmployeeBasicCtcExport($request->type, $emp_ctc_data['rows'], $emp_ctc_data['headers'], $client_name, $public_client_logo_path, $request->date, $period_date, $active_status), 'Employees CTC Report.xlsx');
    }
    public function getEmployeesMasterCTCData(Request $request, VmtReportsservice $reportsService)
    {

        return  $reportsService->getEmployeesMasterDetails($request->type, $request->legal_entity, $request->active_status, $request->department_id, $request->date);
    }

    public function generateEmployeesMasterDetails(Request $request, VmtReportsservice $reportsService)
    {
        $date = Carbon::now()->format('M-y');
        $emp_mas_ctc_data = $reportsService->getEmployeesMasterDetails($request->type, $request->legal_entity, $request->active_status, $request->department_id, $request->date);
        // dd( $request->legal_entity);
        if (empty($request->active_status)) {
            $active_status = 'Active,Resigned,Yet to activate';
        } else {
            $active_status = '';
            foreach ($request->active_status as $single_sts) {
                if ($single_sts == '0') {
                    $active_status = $active_status . 'Yet to activate,';
                } else if ($single_sts == '1') {
                    $active_status = $active_status . 'Active,';
                } else if ($single_sts == '-1') {
                    $active_status = $active_status . 'Resigned,';
                } else {
                }
            }
        }
        if (empty($request->legal_entity)) {
            $client_name = 'All';
        } else {
            $client_name = '';
            foreach ($request->legal_entity as $single_id) {
                $single_client_name = VmtClientMaster::where('id', $single_id)->first()->client_name;
                if ($single_client_name != 'All') {
                    $client_name =   $client_name . $single_client_name . ', ';
                }
            }
        }
        //  $client_name = sessionGetSelectedClientName();
        $client_logo_path = session()->get('client_logo_url');
        $public_client_logo_path = public_path($client_logo_path);
        // dd($emp_mas_ctc_data);
        return Excel::download(new EmployeeMasterExport($request->type, $emp_mas_ctc_data['rows'], $emp_mas_ctc_data['headers'], $client_name, $public_client_logo_path, $request->date, $active_status), 'Employees Master Report.xlsx');
    }

    public function getCurrentFinancialYear()
    {
        // dd('sjfdbvd');
        $current_year = VmtOrgTimePeriod::where('status', 1)->first();
        // dd($current_year->start_date);

        $response = array();
        $temp_ar = array();
        foreach (CarbonPeriod::create($current_year->start_date, '1 month', Carbon::now()->format('Y') . '-' . Carbon::now()->format('m') . '-01') as $single_month) {
            $temp_ar['date'] = $single_month->format('Y-m-d');
            $temp_ar['month'] = $single_month->format('M-Y');
            array_push($response, $temp_ar);
            unset($temp_ar);
        }
        // $temp_ar['date'] = 'custom_date';
        // $temp_ar['month'] = 'Custom Date';
        // array_push($response, $temp_ar);
        return $response;
    }

    public function filterClient()
    {
        //dd(sessionGetSelectedClientName());
        // if (sessionGetSelectedClientName() == 'VASA GROUPS' || sessionGetSelectedClientName() == 'All') {
        //     return VmtClientMaster::where('client_fullname', '<>', 'All')->get(['id', 'abs_client_code', 'client_fullname']);
        // } else {
        //     return VmtClientMaster::where('client_fullname', sessionGetSelectedClientName())->get(['id', 'abs_client_code', 'client_fullname']);
        // }
        return VmtClientMaster::get(['id', 'abs_client_code', 'client_fullname']);
    }


    public function department()
    {

        $get_department =   Department::all(['id', 'name']);
        return $get_department;
    }
}
