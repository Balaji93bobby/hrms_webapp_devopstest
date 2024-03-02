<?php

namespace App\Services;

use App\Interfaces\Payroll\Tally\VmtTallyPayroll_RepInterface;
use App\Interfaces\Payroll\VmtPayroll_RepInterface;

use App\Models\Compensatory;
use App\Models\VmtEmpAttIntrTable;
use App\Models\VmtEmployeeAttendance;
use App\Models\VmtEmployeeOfficeDetails;
use Illuminate\Support\Arr;
use App\Models\vmtHolidays;
use App\Models\VmtLeaves;
use App\Models\VmtEmployee;
use App\Models\VmtOrgTimePeriod;
use App\Models\VmtEmpActivePaygroup;
use App\Models\VmtEmpPayGroupValues;
use App\Models\VmtWorkShifts;
use App\Models\VmtPaygroup;
use App\Models\VmtEmpPaygroup;
use App\Models\VmtPaygroupComps;
use App\Models\VmtPayrollComponents;
use App\Models\VmtEmployeeCompensatoryDetails;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Hash;
use App\Services\VmtPayrollComponentsService;
use Illuminate\Http\Request;
use \DateTime;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Dompdf\Options;
use \stdClass;
use App\Models\User;
use App\Models\VmtClientMaster;
use App\Models\VmtDocuments;
use Carbon\Carbon;
use App\Models\VmtEmployeeDocuments;
use App\Models\VmtPayrollTally;
use App\Models\VmtTallyGLMappings;
use App\Models\VmtPayroll;
use App\Models\VmtEmployeePaySlipV2;
use App\Models\VmtEmployeeAbsentRegularization;
use App\Models\VmtExternalApps;
use App\Models\VmtExternalAppsToken;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;


class VmtPayrollService
{
    private VmtTallyPayroll_RepInterface $tallyPayrollRepository;
    private VmtPayroll_RepInterface $payrollRepository;


    public function __construct(VmtTallyPayroll_RepInterface $tallyPayrollRepository, VmtPayroll_RepInterface $payrollRepository){
        $this->tallyPayrollRepository = $tallyPayrollRepository;
        $this->payrollRepository = $payrollRepository;
    }

    public function getCurrentPayrollMonth()
    {

        // start date and end date of current payroll month from the payroll table

        $current_payroll_date = date("Y-m-d");

        dd($current_payroll_date);
    }

    /*
        For UI :
        Get the payroll outcome section data.
    */
    public function getPayrollOutcomes($client_code, $payroll_date)
    {
        // dd('sdcfc');
        $validator = Validator::make(
            $data = [
                'payroll_date' => $payroll_date,
                'client_code' => $client_code
            ],
            $rules = [
                'payroll_date' => 'exists:vmt_payroll,payroll_date',
                'client_code' => 'exists:vmt_client_master,client_code',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
            ]
        );

        if ($validator->fails()) {
            return $response = ([
                'status' => 'failure',
                'message' => $validator->errors()->all(),
                'data' => ''
            ]);
        }

        $processed_date = strtotime($payroll_date);
        $month = date('m', $processed_date);
        $year = date('Y', $processed_date);

        //dd($month." , ".$year);



        try {

            $payroll_outcomes = $this->payrollRepository->getPayrollOutcomes($client_code, $month, $year);

            return $response = ([
                "status" => "success",
                "message" => "Payroll outcomes fetched successfully",
                "data" => $payroll_outcomes

            ]);
        } catch (\Exception $e) {
            return $response = ([
                "status" => "failure",
                "message" => "Unable to fetch Payroll Outcome details",
                'data' => '',
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ]);
        }
    }

    public function getOrgPayrollMonths($client_id)
    {

        $validator = Validator::make(
            $data = [

                'client_id' => $client_id,
            ],
            $rules = [
                'client_id' => 'required|exists:vmt_client_master,id',
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

            $current_month = Carbon::now()->format('Y-m');
            // $calender_days = carbon::parse($days)->daysInMonth;
            // $client_id = VmtClientMaster::where('client_code', $client_code)->first()->id;
            // $org_payroll_months = VmtPayroll::where('client_id', $client_id)->get();
            $response = array();

            $time_period = VmtOrgTimePeriod::where('status', '1')->first();

            $btmonth = CarbonPeriod::create(carbon::parse($time_period->start_date), '1 month', carbon::parse($time_period->end_date));

            foreach ($btmonth as $dt) {

                if ($current_month == $dt->format('Y-m')) {
                    $payroll_month_details['month'] =  $dt->format("Y-m-d");
                    // $payroll_month_details['days'] =  $dt->format("Y-m-d");
                    $payroll_month_details["status"] = 0;
                } elseif ($current_month > $dt->format('Y-m')) {
                    $payroll_month_details['month'] =  $dt->format("Y-m-d");
                    // $payroll_month_details['days'] =  $dt->format("M-Y");
                    $payroll_month_details["status"] = -1;
                } else {
                    $payroll_month_details['month'] =  $dt->format("Y-m-d");
                    // $payroll_month_details['days'] =  $dt->format("M-Y");
                    $payroll_month_details["status"] = 1;
                }
                // $payroll_month_details['calendar_date'] = $dt->daysInMonth;

                array_push($response, $payroll_month_details);
            }

            return response()->json([
                "status" => "success",
                "message" => "Payroll Months fetched successfully",
                "data" => $response
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Unable to fetch Payroll Months details",
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ], 400);
        }
    }


    public function  getAllEmployeesConsolidatedMonthlyAttendanceDetails($month, $year, $client_id)
    {
        $validator = Validator::make(
            $data = [
                'client_id' => $client_id,
                'start_date' => $month,
                'end_date' => $year
            ],
            $rules = [
                'client_id' => 'nullable|exists:vmt_client_master,id',
                'year' => 'required',
                'month' => 'required'
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

            $client_leave_type = $this->getclientleavetypes();
            $reportresponse = array();
            $temp_ar = array();
            $users = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                //->leftjoin('vmt_employee_office_details', 'vmt_employee_office_details.department_id', '=', 'vmt_department.id')
                ->leftjoin('vmt_department', 'vmt_department.id', '=', 'vmt_employee_office_details.department_id')
                ->leftjoin('vmt_employee_workshifts', 'vmt_employee_workshifts.user_id', '=', 'users.id')
                ->leftjoin('vmt_work_shifts', 'vmt_work_shifts.id', '=', 'vmt_employee_workshifts.work_shift_id')
                ->where('is_ssa', '0')
                ->where('users.client_id', $client_id)
                ->where('active',  "1");
            // ->where('vmt_employee_details.doj', '<', Carbon::parse($end_date));
            // dd($users);


            $attendance_data = $users->get([
                'users.user_code as user_code', 'users.id as id', 'users.name as name', 'vmt_employee_office_details.designation as  designation', 'vmt_department.name as department', 'vmt_employee_workshifts.work_shift_id'

            ]);
            //  dd($attendance_data->toarray());
            //foreach ($attendance_data as $single_user) {
            for ($i = 0; $i < count($attendance_data); $i++) {

                $temp_ar = array();
                $temp_ar['employee_name'] = $attendance_data[$i]['name'];
                $temp_ar['user_code'] = $attendance_data[$i]['user_code'];
                $temp_ar['designation'] = $attendance_data[$i]['designation'];
                $temp_ar['department'] = $attendance_data[$i]['department'];
                $total_present = 0;
                $total_holiday = 0;
                $total_half_day = 0;
                $total_LC = 0;
                $total_EG = 0;
                $total_OT = 0;
                $total_leave = 0;
                $employee_att_details = VmtEmpAttIntrTable::where('user_id', $attendance_data[$i]['id'])
                    ->whereMonth('date', $month)
                    ->whereYear('date', $year);
                //->whereBetween('date', [$start_date, $end_date]);

                $total_present = $employee_att_details->clone()->where('status', 'like', 'P%')->count();
                $total_holiday = $employee_att_details->clone()->where('status', 'like', 'HO%')->count();
                $total_half_day = $employee_att_details->clone()->Where('status', 'like', '%HD%')->count();
                $total_LC  = $employee_att_details->clone()->where('status', 'like', '%LC%')->count();
                $total_EG = $employee_att_details->clone()->where('status', 'like', '%EG%')->count();
                $total_WO = $employee_att_details->clone()->where('status', 'like', '%WO%')->count();
                $total_OD = $employee_att_details->clone()->where('status', 'like', '%OD%')->count();
                $total_OT = $employee_att_details->clone()->where('overtime')->count();
                $temp_ar['pd'] =  $total_present;
                $temp_ar['hd'] = $total_half_day;
                $temp_ar['ho'] = $total_holiday;
                $temp_ar['lc'] = $total_LC;
                $temp_ar['eg'] = $total_EG;
                $temp_ar['ot'] = $total_OT;

                foreach ($client_leave_type as $single_leave_type) {

                    $temp_ar[$single_leave_type] = VmtEmpAttIntrTable::where('user_id', $attendance_data[$i]['id'])
                        ->Where('status', 'like', '%' . $single_leave_type . '%')->count();
                    $total_leave =    $total_leave + $temp_ar[$single_leave_type];
                }
                $work_shift = VmtWorkShifts::where('id', $attendance_data[$i]['work_shift_id'])->first();

                // Logic For Late Coming Calculation
                $total_lc_lop = $total_LC - $work_shift->lc_limit_permonth;
                if ($total_lc_lop > 0) {
                    $total_lc_lop = $work_shift->lc_exceed_lop_day * $total_lc_lop;
                } else {
                    $total_lc_lop = 0;
                }

                //Logic For Early Going Calculation
                $total_eg_lop = $total_EG - $work_shift->eg_limit_permonth;
                if ($total_eg_lop > 0) {
                    $total_eg_lop = $work_shift->eg_exceed_lop_day * $total_eg_lop;
                } else {
                    $total_eg_lop = 0;
                }

                //Calculation For Total LOP Days
                $total_late_lop = $total_lc_lop + $total_eg_lop;

                $total_payable_days = ($total_holiday + $total_present + $total_half_day + $total_leave + $total_WO);
                $temp_ar['Total LOP'] =  $total_late_lop;
                $temp_ar['Total Payable Days'] = $total_payable_days;
                $temp_ar['Total days'] = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                // dd($temp_ar);->whereBetween('date', [$start_date, $end_date])
                array_push($reportresponse, $temp_ar);
                unset($temp_ar);
            }
            return $reportresponse;
        } catch (\Exception $e) {
            return  $response = [
                'status' => 'failure',
                'message' => 'Error while fetching data',
                'error' =>  $e->getMessage(),
                'error_verbose' => $e->getLine() . "  " . $e->getfile(),
            ];
        }
    }

    public function getclientleavetypes()
    {
        $leave = array();
        $current_leave_type = VmtLeaves::pluck('leave_type');

        foreach ($current_leave_type as $key => $value) {

            switch ($value) {
                case 'Sick Leave / Casual Leave';
                    $leave_type = 'sl/cl';
                    break;
                case 'Casual/Sick Leave';
                    $leave_type = 'cl/sl';
                    break;
                case 'LOP Leave';
                    $leave_type = 'lop le';
                    break;
                case 'Earned Leave';
                    $leave_type = 'el';
                    break;
                case 'Maternity Leave';
                    $leave_type = 'ml';
                    break;
                case 'Paternity Leave';
                    $leave_type = 'pl';
                    break;
                case 'On Duty';
                    $leave_type = 'od';
                    break;
                case 'Permission';
                    $leave_type = 'pi';
                    break;
                case 'Compensatory Off';
                    $leave_type = 'co';
                    break;
                case 'Casual Leave';
                    $leave_type = 'cl';
                    break;
                case 'Sick Leave';
                    $leave_type = 'sl';
                    break;
                case 'Compensatory Leave';
                    $leave_type = 'co';
                    break;
                case 'Compensatory Leave';
                    $leave_type = 'fo l';
                    break;
            }
            array_push($leave, $leave_type);
        }
        return $leave;
    }

    // public function getEmployeeLopSummaryDetail($client_id, $current_month, $payroll_year)
    // {
    //     $processed_date = strtotime($current_month);
    //     $current_month = date('m', $processed_date);
    //     $payroll_year = date('Y', $processed_date);
    //     $employee_lop_summary_detail = array();
    //     $users =  VmtPayroll::leftjoin('vmt_client_master', 'vmt_client_master.id', '=', 'vmt_payroll.client_id')
    //         ->leftJoin('vmt_emp_payroll', 'vmt_emp_payroll.payroll_id', '=', 'vmt_payroll.id')
    //         ->Join('users', 'users.id', '=', 'vmt_emp_payroll.user_id')
    //         ->leftJoin('vmt_emp_att_intrtable', 'vmt_emp_att_intrtable.user_id', '=', 'users.id')
    //         // ->where('vmt_client_master.client_code', $client_code)
    //         // ->whereYear('payroll_date', $payroll_year)
    //         ->whereMonth('vmt_emp_att_intrtable.date', $current_month)
    //         ->whereMonth('payroll_date', $current_month)->get();
    //     dd($users->toarray());
    //     $lop_summary_data = $users->get([
    //         'users.user_code as user_code', 'users.id as id', 'users.name as name',
    //     ]);
    //     // dd($lop_summary_data->toarray());
    //     foreach ($lop_summary_data as $single_user) {
    //         $current_month = Carbon::parse($current_month);
    //         $temp_ar = array();
    //         $temp_ar['employee_name'] = $single_user->name;
    //         $temp_ar['user_code'] = $single_user->user_code;
    //         $temp_ar['actual_lop'] = $single_user->actual_lop;
    //         // dd($temp_ar);

    //     }
    // }

    public function getEmployeeLopdetail($start_date, $end_date)
    {
        // $start_date = "2023-11-01";
        // $end_date = "2023-11-15";

        $users = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
            ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
            ->whereDate('vmt_employee_details.doj', '<=', carbon::parse($end_date))
            ->where('is_ssa', '0');
        // dd($users->get()->toarray());

        $users = $users->get([
            'users.id as id',
            'users.user_code as user_code',
            'users.name as name',
            'vmt_employee_details.doj as doj',
            'vmt_employee_details.dol as dol'
        ]);
        // dd($users->toarray());

        $users_data = array();
        foreach ($users as $key => $single_user) {

            if ($single_user->dol != null) {

                if ($single_user->dol > $start_date) {

                    $users_data[$key] = $single_user;
                }
            } else {

                $users_data[$key] = $single_user;
            }
        }
        $temp_ar = array();
        $arr = array();
        foreach ($users as $single_user) {
            $temp_ar = array();
            $temp_ar['employee_name'] = $single_user->name;
            $temp_ar['user_code'] = $single_user->user_code;
            $temp_ar['actual_lop'] = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                ->whereBetween('date', [$start_date, $end_date])
                ->where('status', 'A')->count();
            $temp_ar['lop_adjustment'] = VmtEmployeeAttendance::where('user_id', $single_user->id)
                ->where('is_overridden', '1')->count();
            $temp_ar['final_lop'] = $temp_ar['actual_lop'] - $temp_ar['lop_adjustment'];
            $temp_ar['comments'] = 0;
            // $client_leave_type = $this->fetchAttendanceDailyReport_PerMonth_v2();
            array_push($arr, $temp_ar);
            unset($temp_ar);
        }
        return $arr;
    }
    public function getEmployeeRevokeLopDetails($start_date, $end_date)
    {
        // $start_date = 2023-11-01;
        // $end_date = 2023-11-15;
        // $users = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
        // ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
        // ->whereDate('vmt_employee_details.doj', '<=', carbon::parse($end_date))
        // ->where('is_ssa', '0');
        // $users = $users->get([

        //     'users.id as id',
        //     'users.user_code as user_code',
        //     'users.name as name',
        //     'vmt_employee_details.doj as doj',
        //     'vmt_employee_details.dol as dol'
        // ]);
        // // dd($users->toarray());

        // $users_data = array();
        // foreach ($users as $key => $single_user) {

        //     if ($single_user->dol != null) {

        //         if ($single_user->dol > $start_date) {

        //             $users_data[$key] = $single_user;
        //         }
        //     } else {

        //         $users_data[$key] = $single_user;
        //     }
        // }
        $lop_summary_data = $this->getEmployeeLopdetail($start_date, $end_date);
        // dd($lop_summary_data);
        $temp_arr = array();
        $arr = array();
        foreach ($lop_summary_data as $single_user_data) {
            // dd( $single_user_data);
            $temp_arr = array();
            $temp_arr['employee_name'] = $single_user_data['employee_name'];
            $temp_arr['user_code'] = $single_user_data['user_code'];
            $temp_arr['lop_month'] = Carbon::parse($start_date)->subMonth(1)->format('M');
            $temp_arr['actual_lops'] = $single_user_data['actual_lop'] - $single_user_data['lop_adjustment'];
            $temp_arr['lop_reversal_days'] = VmtEmployeeAttendance::where('user_id', $single_user_data['id'] ?? null)
                ->where('is_overridden', '1')->count();
            $temp_arr['comments'] = 0;
            array_push($arr, $temp_arr);
            unset($temp_ar);
        }
        return $arr;
    }
    public function getNewJoineesDetails($end_date)
    {
        // $processed_date = strtotime($end_date);
        $year = carbon::now()->format('Y');
        $month = carbon::now()->format('m');
        $users = User::leftjoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
            ->whereMonth('vmt_employee_details.doj', '=', $month)
            ->whereYear('vmt_employee_details.doj', '=', $year);

        $emp_new_joinees = $users->get([
            'users.user_code as user_code', 'users.id as id', 'users.name as name', 'vmt_employee_details.doj as doj',
        ]);
        // dd($emp_new_joinees);
        $count = 0;
        $temp_ar = array();
        $arr = array();

        foreach ($emp_new_joinees as $single_emp_new_joinee) {

            $total_working_days = 0;
            $temp_ar['employee_name'] = $single_emp_new_joinee->name;
            $temp_ar['user_code'] = $single_emp_new_joinee->user_code;
            $temp_ar['doj'] = $single_emp_new_joinee->doj;
            $temp_ar['salary'] = VmtEmployeePaySlipV2::where('id', $single_emp_new_joinee->id)
                ->first('total_fixed_gross');
            $temp_ar['no_working_day'] = VmtEmpAttIntrTable::where('user_id', $single_emp_new_joinee->id)
                ->where('status', 'like', 'P%')->count();
            array_push($arr, $temp_ar);
            unset($temp_ar);
        }
        return $arr;
    }
    public function getExitEmployeeDetails($end_date)
    {
        // $processed_date = strtotime($end_date);
        $year = carbon::now()->format('Y');
        $month = carbon::now()->format('m');
        // dd($end_date);
        $users = User::leftjoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
            // ->leftJoin('vmt_emp_payroll', 'vmt_emp_payroll.user_id', '=', 'users.id')
            // ->leftJoin('vmt_payroll', 'vmt_payroll.id', '=', 'vmt_emp_payroll.payroll_id')/
            // ->leftJoin('vmt_emp_att_intrtable', 'vmt_emp_att_intrtable.user_id', '=', 'users.id')
            // ->leftJoin('vmt_employee_payslip_v2', 'vmt_employee_payslip_v2.id', '=', 'users.id')
            // ->where('vmt_emp_att_intrtable.status', 'P')
            ->whereMonth('vmt_employee_details.dol', '=', $month)
            ->whereYear('vmt_employee_details.dol', '=', $year);
        // dd($users->toarray());
        $emp_exit = $users->get([
            'users.user_code as user_code', 'users.id as id', 'users.name as name', 'vmt_employee_details.dol as dol',
        ]);
        $temp_ar = array();
        $arr = array();

        foreach ($emp_exit as $single_emp_exit) {

            $total_working_days = 0;
            $temp_ar['employee_name'] = $single_emp_exit->name;
            $temp_ar['user_code'] = $single_emp_exit->user_code;
            $temp_ar['dol'] = $single_emp_exit->dol;
            $temp_ar['salary'] = VmtEmployeePaySlipV2::where('id', $single_emp_exit->id)
                ->first('total_fixed_gross');
            //   dd( $temp_ar['salary']);
            $temp_ar['no_working_day'] = VmtEmpAttIntrTable::where('user_id', $single_emp_exit->id)
                ->where('status', 'like', 'P%')->count();
            array_push($arr, $temp_ar);
            unset($temp_ar);
        }
        return $arr;
    }
    public function fetchAttendanceReport($user_code, $year, $month, $start_date, $end_date, $vmtAttendanceServices)
    {

        // dd('sdacbb');
        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
                'year' => $year,
                'month' => $month,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ],
            $rules = [
                'user_code' => 'required|exists:users,user_code',
                'year' => 'required|integer',
                'month' => 'required|integer',
                'start_date' => 'required',
                'end_date' => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'integer' => 'Field :attribute should be integer',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ], 400);
        }


        try {
            $query_user = User::where('user_code', $user_code)->first();

            $user_id = $query_user->id;

            $requestedDate = $year . '-' . $month . '-01';
            $currentDate = Carbon::now();
            $monthDateObj = Carbon::parse($requestedDate);
            $start_date = $monthDateObj->startOfMonth(); //->format('Y-m-d');
            // dd( $startdate);
            $end_date   = $monthDateObj->endOfMonth(); //->format('Y-m-d');
            $start_date = "2023-11-01";
            //   $end_date = "2023-11-15";

            if ($currentDate->lte($start_date)) {
                $lastAttendanceDate  = $currentDate; //->format('Y-m-d');
            } else {
                $lastAttendanceDate  = $end_date; //->format('Y-m-d');
            }

            $totalDays  = $lastAttendanceDate->format('d');
            $firstDateStr  = $monthDateObj->startOfMonth()->toDateString();
            // dd($firstDateStr);

            // attendance details from vmt_staff_attenndance_device table
            $deviceData = [];
            for ($i = 0; $i < ($totalDays); $i++) {
                // code...
                $dayStr = Carbon::parse($firstDateStr)->addDay($i)->format('l');

                if ($dayStr != 'Sunday') {

                    $dateString  = Carbon::parse($firstDateStr)->addDay($i)->format('Y-m-d');

                    //Need to process the checkin and checkout time based on the client.
                    //Since some client's biometric data has "in/out" direction and some will have only "in" direction
                    //dd(sessionGetSelectedClientCode());

                    $user_client_code = VmtClientMaster::find($query_user->client_id);
                    $user_client_code = $user_client_code->client_code;


                    //If direction is only "in" or empty or "-"
                    if (
                        $user_client_code == "ABS" || $user_client_code == "DMC" || $user_client_code == "BA" || $user_client_code == "AL" ||
                        $user_client_code == "DM" ||  $user_client_code == "VASA GROUPS" || $user_client_code == "PSC" || $user_client_code == "IMA"  || $user_client_code == "LAL"
                        || $user_client_code == "PLIPL"
                    ) {

                        $attendanceCheckOut = \DB::table('vmt_staff_attenndance_device')
                            ->select('user_Id', \DB::raw('MAX(date) as check_out_time'))
                            ->whereDate('date', $dateString)
                            ->where('user_Id', $user_code)
                            ->first(['check_out_time']);

                        // if($dateString == "2023-07-05")
                        //     dd($dateString);
                        $attendanceCheckIn = \DB::table('vmt_staff_attenndance_device')
                            ->select('user_Id', \DB::raw('MIN(date) as check_in_time'))
                            ->whereDate('date', $dateString)
                            ->where('user_Id', $user_code)
                            ->first(['check_in_time']);
                    } else //If direction is only "in" and "out"
                    {
                        $attendanceCheckOut = \DB::table('vmt_staff_attenndance_device')
                            ->select('user_Id', \DB::raw('MAX(date) as check_out_time'))
                            ->whereDate('date', $dateString)
                            ->where('direction', 'out')
                            ->where('user_Id', $user_code)
                            ->first(['check_out_time']);

                        $attendanceCheckIn = \DB::table('vmt_staff_attenndance_device')
                            ->select('user_Id', \DB::raw('MIN(date) as check_in_time'))
                            ->whereDate('date', $dateString)
                            ->where('direction', 'in')
                            ->where('user_Id', $user_code)
                            ->first(['check_in_time']);
                    }


                    $deviceCheckOutTime = empty($attendanceCheckOut->check_out_time) ? null : explode(' ', $attendanceCheckOut->check_out_time)[1];
                    $deviceCheckInTime  = empty($attendanceCheckIn->check_in_time) ? null : explode(' ', $attendanceCheckIn->check_in_time)[1];

                    // dd($deviceCheckInTime);

                    if ($deviceCheckOutTime  != null || $deviceCheckInTime != null) {
                        $deviceData[] = array(
                            'date' => $dateString,
                            'checkin_time' => $deviceCheckInTime,
                            'checkout_time' => $deviceCheckOutTime,
                            'attendance_mode_checkin' => 'biometric',
                            'attendance_mode_checkout' => 'biometric'
                        );
                    }
                }
            } //for

            //dd($deviceData);

            // attendance details from vmt_employee_attenndance table
            $attendance_WebMobile = VmtEmployeeAttendance::where('user_id', $user_id)
                ->join('vmt_work_shifts', 'vmt_work_shifts.id', '=', 'vmt_employee_attendance.vmt_employee_workshift_id')
                ->whereMonth('date', $month)
                ->orderBy('checkin_time', 'asc')
                ->get(['vmt_work_shifts.shift_code as workshift_code', 'vmt_work_shifts.shift_name as workshift_name', 'vmt_employee_workshift_id', 'date', 'checkin_time', 'checkout_time', 'attendance_mode_checkin', 'attendance_mode_checkout', 'selfie_checkin', 'selfie_checkout']);

            //dd($attendance_WebMobile);


            $attendanceResponseArray = [];

            //Create empty month array with all dates.

            if ($month < 10)
                $month = "0" . $month;

            $year = $year;
            $days_count = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            for ($i = 1; $i <= $days_count; $i++) {
                $date = "";

                if ($i < 10)
                    $date = "0" . $i;
                else
                    $date = $i;

                $fulldate = $year . "-" . $month . "-" . $date;


                $attendanceResponseArray[$fulldate] = array(
                    "date" => $fulldate,
                    "user_id" => $user_id, "isAbsent" => false, "attendance_mode_checkin" => null, "attendance_mode_checkout" => null,
                    "vmt_employee_workshift_id" => null, "workshift_code" => null, "workshift_name" => null,
                    "absent_status" => null, "leave_type" => null, "checkin_time" => null, "checkout_time" => null,
                    "selfie_checkin" => null, "selfie_checkout" => null,
                    "isLC" => false, "lc_status" => null, "lc_reason" => null, "lc_reason_custom" => null, "lc_regularized_time" => null,
                    "isEG" => false, "eg_status" => null, "eg_reason" => null, "eg_reason_custom" => null, "eg_regularized_time" => null,
                    "isMIP" => false, "mip_status" => null, "mip_reason" => null, "mip_reason_custom" => null, "mip_regularized_time" => null,
                    "isMOP" => false, "mop_status" => null, "mop_reason" => null, "mop_reason_custom" => null, "mop_regularized_time" => null,
                    "absent_reg_status" => null, "absent_reg_checkin" => null, "absent_reg_checkout" => null,
                    "is_holiday" => false, "holiday_name" => "", "holiday_image_url" => ""
                );
                // dd( $attendanceResponseArray[$fulldate]);
                //echo "Date is ".$fulldate."\n";

                ///$month_array[""]
            }


            // merging result from both table
            $merged_attendanceData  = array_merge($deviceData, $attendance_WebMobile->toArray());
            $dateCollectionObj    =  collect($merged_attendanceData);
            $sortedCollection   =   $dateCollectionObj->sortBy([
                ['date', 'asc'],
            ]);

            $dateWiseData         =  $sortedCollection->groupBy('date'); //->all();
            //dd($merged_attendanceData);
            //dd($dateWiseData);
            foreach ($dateWiseData  as $key => $value) {
                // dd($dateWiseData);
                // dd($value[0]);

                /*
                Here $key is the date. i.e : 2022-10-01

                $value is ::

                    [
                        date=>2022-11-05
                        checkin_time=18:06:00
                        checkout_time=18:06:00
                        attendance_mode="web"
                        vmt_employee_workshift_id ="1" //Employee shift
                    ],
                    [
                        ....
                        attendance_mode="biometric"

                    ]

            */
                //Compare the checkin,checkout time between all attendance modes and get the min(checkin) and max(checkout)

                $checkin_min = null;
                $checkout_max = null;
                $attendance_mode_checkin = null;
                $attendance_mode_checkout = null;

                foreach ($value as $singleValue) {
                    // if($singleValue["date"] == '2023-08-05')
                    //     dd($singleValue);
                    //Find the employee_workshift. Right now, we are getting from web/mobile checkin only.
                    //For Biometric, we cant know which shift since the biometric table has no column for storing it
                    //dd($singleValue["vmt_employee_workshift_id"]);
                    //If we found 'vmt_employee_workshift_id', then store it. Else store NULL. In future, we have get shift details from biometric attendance
                    // if (!empty($singleValue["vmt_employee_workshift_id"])) {
                    //     $attendanceResponseArray[$key]["vmt_employee_workshift_id"] = $singleValue["vmt_employee_workshift_id"];
                    //     $attendanceResponseArray[$key]["workshift_code"] = $singleValue["workshift_code"];
                    //     $attendanceResponseArray[$key]["workshift_name"] = $singleValue["workshift_name"];
                    // }
                    //dd( $attendanceResponseArray[$key]);
                    //Find the min of checkin
                    if ($checkin_min == null) {


                        $checkin_min = $singleValue["checkin_time"];
                        $attendance_mode_checkin = $singleValue["attendance_mode_checkin"];
                    } else
                if (!empty($singleValue["checkin_time"]) && ($checkin_min > $singleValue["checkin_time"])) {
                        //Bug Fixing
                        // if($singleValue["date"] == '2023-08-05')
                        //     dd($singleValue);

                        $checkin_min = $singleValue["checkin_time"];
                        $attendance_mode_checkin = $singleValue["attendance_mode_checkin"];
                    }

                    //dd("Min value found : " . $singleValue["checkin_time"]);

                    //Find the max of checkout
                    if ($checkout_max == null) {
                        $checkout_max = $singleValue["checkout_time"];
                        $attendance_mode_checkout = $singleValue["attendance_mode_checkout"];
                    } else
                if (!empty($singleValue["checkout_time"]) && $checkout_max < $singleValue["checkout_time"]) {
                        $checkout_max = $singleValue["checkout_time"];
                        $attendance_mode_checkout = $singleValue["attendance_mode_checkout"];
                    }
                }

                //dd("end : Check-in : ".$checkin_min." , Check-out : ".$checkout_max);


                //dd($value[0]["attendance_mode"]);
                $attendanceResponseArray[$key]["checkin_time"] = $checkin_min;
                $attendanceResponseArray[$key]["checkout_time"] = $checkout_max;

                //TODO :: Based on which checkin, checkout time taken, its corresponding attendance modes has to be assigned here
                $attendanceResponseArray[$key]["attendance_mode_checkin"] = $attendance_mode_checkin;
                $attendanceResponseArray[$key]["attendance_mode_checkout"] = $attendance_mode_checkout;

                //selfies
                //format : http://127.0.0.1:8000/employees/PLIPL068/selfies/checkout.png
                if ($singleValue["checkin_time"] && !empty($singleValue["selfie_checkin"]))
                    $attendanceResponseArray[$key]["selfie_checkin"] = 'employees/' . $user_code . '/selfies/' . $singleValue["selfie_checkin"];

                if ($singleValue["checkout_time"] && !empty($singleValue["selfie_checkout"]))
                    $attendanceResponseArray[$key]["selfie_checkout"] = 'employees/' . $user_code . '/selfies/' . $singleValue["selfie_checkout"];
            }

            // dd($attendanceResponseArray);

            //Get all the shift details
            $query_workShifts = VmtWorkShifts::all()->keyBy('id');
            //dd($query_workShifts->toArray()['2']);

            ////Logic to check LC,EG,MIP,MOP,Leave status
            foreach ($attendanceResponseArray as $key => $value) {

                //START : Check whether the given date is holiday or not..
                $current_date =  strtotime($attendanceResponseArray[$key]["date"]);
                //dd("Month:". date('m', $current_date) ." Date:". date('d', $current_date));

                $query_holiday = vmtHolidays::whereMonth('holiday_date', date('m', $current_date))
                    ->whereDay('holiday_date', date('d', $current_date))->first();

                if (!empty($query_holiday)) {
                    $attendanceResponseArray[$key]['is_holiday'] = true;
                    $attendanceResponseArray[$key]['holiday_name'] = $query_holiday->holiday_name;
                    $attendanceResponseArray[$key]['holiday_image_url'] = $query_holiday->image;
                }

                //END : Check whether the given date is holiday or not..
                //dd($attendanceResponseArray);

                $shift_time = $vmtAttendanceServices->getShiftTimeForEmployee($value['user_id'], $value['checkin_time'], $value['checkout_time']);

                //If no shift assigned to user, then return null
                if (!$shift_time) {
                    return response()->json([
                        'status' => 'failure',
                        'message' => 'Unable to fetch Attendance Monthly Report. Shift was not assigned for the date : ' . $current_date,
                        'data' => '',
                    ], 400);
                }

                $attendanceResponseArray[$key]['vmt_employee_workshift_id'] = $shift_time->id;
                $attendanceResponseArray[$key]['workshift_code'] = $shift_time->shift_code;
                $attendanceResponseArray[$key]['workshift_name'] = $shift_time->shift_name;
                //dd($attendanceResponseArray[$key]['vmt_employee_workshift_id']);

                //dd($query_workShifts[$currentdate_workshift]->shift_start_time);
                //dd( $attendanceResponseArray);

                //



                $checkin_time = $attendanceResponseArray[$key]["checkin_time"];
                $checkout_time = $attendanceResponseArray[$key]["checkout_time"];
                //dd($checkin_time);
                $current_time = carbon::now()->format('H:i:s');
                $current_date = carbon::now()->format('Y-m-d');

                // dd(!empty($attendanceResponseArray[$key]['vmt_employee_workshift_id']));
                //Calculate LC, EG only if the current day shifttype is found. If no shifttype found, dont calculate LC, EG. NEED TO CORRECT IT MANUALLY
                if (!empty($attendanceResponseArray[$key]['vmt_employee_workshift_id'])) {

                    //Get the workshift for the current day
                    $currentdate_workshift = $attendanceResponseArray[$key]['vmt_employee_workshift_id'];
                    $shiftStartTime  = Carbon::parse($shift_time->shift_start_time)->addMinutes($shift_time->grace_time);
                    $shiftEndTime  = Carbon::parse($shift_time->shift_end_time);


                    if ($attendanceResponseArray[$key]["checkin_time"] ==  $attendanceResponseArray[$key]["checkout_time"] && ($attendanceResponseArray[$key]["checkin_time"] != null && $attendanceResponseArray[$key]["checkout_time"] != null)) {


                        $employee_checkIn_CheckOut = $vmtAttendanceServices->findMIPOrMOP($attendanceResponseArray[$key]["checkin_time"], $shiftStartTime->clone(), $shiftEndTime);

                        $attendanceResponseArray[$key]["checkin_time"] = $employee_checkIn_CheckOut["checkin_time"];
                        $attendanceResponseArray[$key]["checkout_time"] = $employee_checkIn_CheckOut["checkout_time"];


                        if (!empty($employee_checkIn_CheckOut["checkin_time"])) {
                            $attendanceResponseArray[$key]["attendance_mode_checkin"] =  $attendanceResponseArray[$key]["attendance_mode_checkin"];
                            $attendanceResponseArray[$key]["attendance_mode_checkout"] = "";
                        } else {
                            $attendanceResponseArray[$key]["attendance_mode_checkin"] = "";
                            $attendanceResponseArray[$key]["attendance_mode_checkout"] = $attendanceResponseArray[$key]["attendance_mode_checkout"];
                        }

                        $checkin_time = $employee_checkIn_CheckOut["checkin_time"];
                        $checkout_time = $employee_checkIn_CheckOut["checkout_time"];
                    }



                    //Attendance regularization check : When checkin and checkout is null
                    if (empty($checkin_time) && empty($checkout_time)) {

                        //check whether att regularization is done for the given date.
                        $query_absent_reg = VmtEmployeeAbsentRegularization::where('user_id', $value['user_id'])->where('attendance_date', $key);

                        if ($query_absent_reg->exists()) {
                            $attendanceResponseArray[$key]["absent_reg_status"] =  $query_absent_reg->first()->status;
                            $attendanceResponseArray[$key]["absent_reg_checkin"] =  $query_absent_reg->first()->checkin_time;
                            $attendanceResponseArray[$key]["absent_reg_checkout"] =  $query_absent_reg->first()->checkout_time;
                        } else {
                            $attendanceResponseArray[$key]["absent_reg_status"] =  'None';
                        }
                    }
                    //LC Check
                    if (!empty($checkin_time)) {

                        $parsedCheckIn_time  = Carbon::parse($checkin_time);

                        //Check whether checkin done on-time

                        $isCheckin_done_ontime = $parsedCheckIn_time->lte($shiftStartTime);


                        if ($isCheckin_done_ontime) {
                            //employee came on time....

                        } else {
                            //employee came on time....
                            //dd("Checkin NOT on-time");

                            //then LC
                            if ($shift_time->is_lc_applicable == 1) {
                                $attendanceResponseArray[$key]["isLC"] = true;
                            }

                            //check whether regularization applied.
                            $regularization_record = $vmtAttendanceServices->isRegularizationRequestApplied($user_id, $key, 'LC');

                            //check regularization status
                            $attendanceResponseArray[$key]["lc_status"] =  $regularization_record['status'];
                            $attendanceResponseArray[$key]["lc_reason"] = $regularization_record['reason'];
                            $attendanceResponseArray[$key]["lc_reason_custom"] = $regularization_record['cst_reason'];
                            $attendanceResponseArray[$key]["lc_regularized_time"] = $regularization_record['regularized_time'];
                        }
                    }


                    //EG Check
                    //check if its EG
                    if (!empty($checkout_time)) {

                        $parsedCheckOut_time  = Carbon::parse($checkout_time);

                        //Check whether checkin done on-time
                        $isCheckOut_doneEarly = $parsedCheckOut_time->lte($shiftEndTime);

                        if ($isCheckOut_doneEarly) {
                            //employee left early on time....

                            //then EG
                            if ($shift_time->is_eg_applicable == 1) {
                                $attendanceResponseArray[$key]["isEG"] = true;
                            }
                            //check whether regularization applied.
                            $regularization_record = $vmtAttendanceServices->isRegularizationRequestApplied($user_id, $key, 'EG');
                            //check regularization status


                            $attendanceResponseArray[$key]["eg_status"] = $regularization_record['status'];
                            $attendanceResponseArray[$key]["eg_reason"] = $regularization_record['reason'];
                            $attendanceResponseArray[$key]["eg_reason_custom"] = $regularization_record['cst_reason'];
                            $attendanceResponseArray[$key]["eg_regularized_time"] = $regularization_record['regularized_time'];
                        } else {
                            //employee left late

                        }
                    }
                }

                //for absent
                if ($checkin_time == null && $checkout_time == null) {
                    $attendanceResponseArray[$key]["isAbsent"] = true;

                    //Check whether leave is applied or not.

                    $t_leaveRequestDetails = $vmtAttendanceServices->isLeaveRequestApplied($user_id, $key, $year, $month);

                    if (empty($t_leaveRequestDetails)) {

                        $attendanceResponseArray[$key]["absent_status"] = "Not Applied";
                        $attendanceResponseArray[$key]["leave_type"] = null;
                    } else {
                        $attendanceResponseArray[$key]["absent_status"] = $t_leaveRequestDetails->status;
                        $attendanceResponseArray[$key]["leave_type"] = $t_leaveRequestDetails->leave_type;
                    }
                } elseif ($checkin_time != null && $checkout_time == null && ($current_date != $attendanceResponseArray[$key]["date"]  ? true : $current_time >= $shiftEndTime)) {

                    //Since its MOP
                    $attendanceResponseArray[$key]["isMOP"] = true;

                    ////Is any permission applied
                    //check whether regularization applied.
                    $regularization_record = $vmtAttendanceServices->isRegularizationRequestApplied($user_id, $key, 'MOP');

                    //check regularization status
                    $attendanceResponseArray[$key]["mop_status"] = $regularization_record['status'];
                    $attendanceResponseArray[$key]["mop_reason"] =  $regularization_record['reason'];
                    $attendanceResponseArray[$key]["mop_reason_custom"] = $regularization_record['cst_reason'];
                    $attendanceResponseArray[$key]["mop_regularized_time"] = $regularization_record['regularized_time'];


                    if ($attendanceResponseArray[$key]["mop_status"] == "Approved") {

                        //If Approved, then set the regularize time as checkout time
                        $attendanceResponseArray[$key]["checkout_time"] =  $regularization_record['regularized_time'];
                    }
                } elseif ($checkin_time == null && $checkout_time != null) {

                    //Since its MIP
                    $attendanceResponseArray[$key]["isMIP"] = true;

                    ////Is any permission applied
                    $regularization_record = $vmtAttendanceServices->isRegularizationRequestApplied($user_id, $key, 'MIP');

                    //check regularization status
                    $attendanceResponseArray[$key]["mip_status"] = $regularization_record['status'];
                    $attendanceResponseArray[$key]["mip_reason"] =  $regularization_record['reason'];
                    $attendanceResponseArray[$key]["mip_reason_custom"] = $regularization_record['cst_reason'];
                    $attendanceResponseArray[$key]["mip_regularized_time"] = $regularization_record['regularized_time'];


                    if ($attendanceResponseArray[$key]["mip_status"] == "Approved") {

                        //If Approved, then set the regularize time as checkin time
                        $attendanceResponseArray[$key]["checkin_time"] =  $regularization_record['regularized_time'];

                        //  $attendanceResponseArray[$key]["checkin_time"] = ""
                    }
                }
            } //for each

            // if()
            // if ($user_client_code == "BA") {

            //     $employee_Lc_expire_status = $this->processOutdatedPendingAttRegAsVoid($attendanceResponseArray);
            //     // dd($attendanceResponseArray);
            //     $attendanceResponseArray = $employee_Lc_expire_status;
            // }


            return $response = [
                'status' => 'success',
                'message' => 'Attendance Monthly Report fetched successfully',
                'data' => $attendanceResponseArray,
            ];
        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'failure',
                'message' => 'Error while fetching Attendance Monthly Report',
                'data' => '',
                'error' => $e->getMessage(),
                'error_verbose' => $e->getTraceAsString()
            ], 400);
        }
    }


    public function getExternalAppsList()
    {
        try {
            return response()->json([
                "status" => "success",
                "data" => VmtExternalApps::all(['id', 'name', 'internal_name', 'description', 'app_logo'])
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error while fetching External apps list",
            ], 400);
        }
    }

    /*
        Used to generate the access token for external apps.


    */
    public function generateExternalApp_AccessToken($client_code, $externalapp_internalname, $validity)
    {

        $validator = Validator::make(
            $data = [
                'client_code' => $client_code,
                'externalapp_internalname' => $externalapp_internalname,
                // 'validity' => $validity,
            ],
            $rules = [
                'client_code' => 'required|exists:vmt_client_master,client_code',
                'externalapp_internalname' => 'required|exists:vmt_externalapps,internal_name',
                //'validity' => 'nullable',
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
            ], 400);
        }

        try {
            //Note : For now, the token validity is null.
            // $token_validity = $validity ?? time() + 3600 * 3;

            $payload = [
                'externalapp_internalname' => $externalapp_internalname,
                'client_code' => $client_code,
                'token_validity' => 0,
            ];

            $generated_token = Str::random(40);

            //$secret_token = env('APP_KEY');
            //$generated_token = JWT::encode($payload, $secret_token, 'HS256'); //JWT style
            //$generated_token = $current_user->createToken("TALLY API TOKEN")->plainTextToken; //TODO: Need to use this to link the generated token to an user

            /*
                Save this token in vmt_externalapps_tokens table so that we can track its usage.
                If user regenerates it, delete the old token and save this
            */
            $client_id = VmtClientMaster::where('client_code', $client_code)->first()->id;
            $external_app_id = VmtExternalApps::where('internal_name', $externalapp_internalname)->first()->id;

            //Delete the existing token
            VmtExternalAppsToken::where([['client_id', $client_id], ['extapp_type_id', $external_app_id]])->delete();

            VmtExternalAppsToken::create([
                'client_id' => $client_id,
                'extapp_type_id' => $external_app_id,
                'access_token' => $generated_token,
                'token_validity' => null,
                'additional_data' => '',
                'token_generated_time' => Carbon::now(),
                'recent_token_accessed_time' => null,
            ]);

            return response()->json([
                'status' => "success",
                'message' => 'Access token generated successfully for the External App : ' . $externalapp_internalname,
                'access_token' => $generated_token
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error while generating Access token',
                'data' => '',
                'error' => $e->getMessage(),
                'error_verbose' => $e->getTraceAsString()
            ], 400);
        }
    }

    public function getTally_MappingDropdownValues()
    {
    }

    /*
        Saves the HRMS and Tally GL mappings

        Expected JSON structure

            $client_code = 'BA'

            $jsonarray_gl_mappings =

                [
                    {
                        "payroll_comp_id" : 101,
                        "tally_gl_head" : "gl_head_1",
                        "tally_gl_name" : "gl_name_1",
                    },
                    {
                        "payroll_comp_id" : 102,
                        "tally_gl_head" : "gl_head_1",
                        "tally_gl_name" : "gl_name_1",
                    }

                ]


    */
    public function saveTallyERP_PayrollJournalMappings($client_code, $jsonarray_gl_mappings)
    {

        $validator = Validator::make(
            $data = [
                'client_code' => $client_code,
                'jsonarray_gl_mappings' => $jsonarray_gl_mappings,
            ],
            $rules = [
                'client_code' => 'required|exists:vmt_client_master,client_code',
                'jsonarray_gl_mappings' => 'required',
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
            ], 400);
        }

        /*
        Todo : Validate the '$jsonarray_gl_mappings' values. It should contain valid payroll components only and valid GL head,GL names.

        Note : Payroll component ID mentioned in this mapping is taken from 'vmt_payroll_components' table
               and this is used to check whether the employee has this comp assigned in his paygroup.
               If not assigned, then throw error.
        */

        try {


            //Truncate existing mapping data and save in "vmt_tally_gl_mappings" table

            //VmtTallyGLMappings

            dd("Unimplemented !");

            return response()->json([
                'status' => 'success',
                'message' => 'Payroll Journal Mapping details saved successfully',
                'data' => '',
            ], 200);
        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'failure',
                'message' => 'Error while saving Payroll Journal Mapping details',
                'data' => '',
                'error' => $e->getMessage(),
                'error_verbose' => $e->getTraceAsString()
            ], 400);
        }
    }

    /*
        Get Tally mapping data

    */
    public function getTallyERP_PayrollJournalMappings($client_code)
    {

        $validator = Validator::make(
            $data = [
                'client_code' => $client_code,
            ],
            $rules = [
                'client_code' => 'required|exists:vmt_client_master,client_code',
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
            ], 400);
        }

        try {


            //Fetch data from VmtTallyGLMappings

            $client_id = VmtClientMaster::where('client_code', $client_code)->first()->id;
            $response = VmtTallyGLMappings::where('client_id', $client_id)->get();


            return response()->json([
                'status' => 'success',
                'message' => 'Payroll Journal Mapping details fetched successfully',
                'data' => $response,
            ], 200);
        } catch (\Throwable $e) {

            return response()->json([
                'status' => 'failure',
                'message' => 'Error while fetching Payroll Journal Mapping details',
                'data' => '',
                'error' => $e->getMessage(),
                'error_verbose' => $e->getTraceAsString()
            ], 400);
        }
    }

    /*
        Generates the payroll journal for Tally based on two data,

        1. Generated payroll data
        2. Mapping the generated payroll data to tally mappings



    */
    public function getPayrollJournalData($token, $company_name, $payroll_date)
    {
        /*
        //Check if json is empty or not , required keys are there or not
        if( empty($json_data) ||
            (
                 !array_key_exists('token', $json_data) || !array_key_exists('company_name', $json_data) || !array_key_exists('payroll_date', $json_data) )
            ){

            return response()->json([
                'status' => 'failure',
                'message' => 'Unable to fetch the payroll journal data. Input JSON is invalid.'
            ], 400);
        }
        */


        $validator = Validator::make(
            $data = [
                'json_data' => $token,
                'company_name' => $company_name,
                'payroll_date' => $payroll_date,
            ],
            $rules = [
                'json_data' => 'required',
                'company_name' => 'required',
                'payroll_date' => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'integer' => 'Field :attribute should be integer',
                'validation.array' => 'Field :attribute is invalid',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ], 400);
        }

        //Hardcoded check

        if ($token != '1234567890') {
            return response()->json([
                'status' => 'failure',
                'message' => 'Unable to fetch the payroll journal data. Given token is invalid.'
            ], 400);
        }

        /*
            Todo : For each payroll comps linked in tally , we need to calculate for all the employees.
                    If needed, consolidated value is also calculated.

                    Then, tally mapped names are used in response JSON.

                    Store the json response in 'vmt_payroll_tally' -> 'generated_json_payrolljournal' column

                    Return the json response.
        */

        $current_payroll_date = [
            "company_name" => "INDCHEM MARKETING AGENCIES",
            "payroll_date" => "2023-10-31",
            "payroll_journal" => [
                [
                    "account_name" => "Salaries",
                    "gl_code" => "",
                    "debit" => "22,11,655.00",
                    "credit" => "0.00",
                    "currency" => "INR"
                ],
                [
                    "account_name" => "EPF Payables",
                    "gl_code" => "",
                    "debit" => "0.00",
                    "credit" => "2,76,408.00",
                    "currency" => "INR"
                ],
                [
                    "account_name" => "ESIC Payables",
                    "gl_code" => "",
                    "debit" => "0.00",
                    "credit" => "20,976.00",
                    "currency" => "INR"
                ],
                [
                    "account_name" => "TDS Payables - Salary",
                    "gl_code" => "",
                    "debit" => "0.00",
                    "credit" => "0.00",
                    "currency" => "INR"
                ],
                [
                    "account_name" => "Professional Tax Payables",
                    "gl_code" => "",
                    "debit" => "0.00",
                    "credit" => "17,197.00",
                    "currency" => "INR"
                ],
                [
                    "account_name" => "LWF Payables",
                    "gl_code" => "",
                    "debit" => "0.00",
                    "credit" => "0.00",
                    "currency" => "INR"
                ],
                [
                    "account_name" => "Salary Payables",
                    "gl_code" => "",
                    "debit" => "0.00",
                    "credit" => "18,10,727.00",
                    "currency" => "INR"
                ],
                [
                    "account_name" => "Employee Loan",
                    "gl_code" => "",
                    "debit" => "0.00",
                    "credit" => "78,737.00",
                    "currency" => "INR"
                ]
            ]
        ];


        return response()->json([
            "status" => "success",
            "message" => "Payroll journal data retrieved successfully for the month 2023-10-31",
            "data" => $current_payroll_date
        ]);
    }

    //Returns the default payroll journal data as per Vasa structure.
    public function getDefaultPayrollJournalData($token, $company_name, $payroll_date)
    {

        $validator = Validator::make(
            $data = [
                'json_data' => $token,
                'company_name' => $company_name,
                'payroll_date' => $payroll_date,
            ],
            $rules = [
                'json_data' => 'required',
                'company_name' => 'required|exists:vmt_client_master,client_fullname',
                'payroll_date' => 'required'
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'integer' => 'Field :attribute should be integer',
                'validation.array' => 'Field :attribute is invalid',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ], 400);
        }

        //Hardcoded check

        if ($token != '1234567890') {
            return response()->json([
                'status' => 'failure',
                'message' => 'Unable to fetch the payroll journal data. Given token is invalid.'
            ], 400);
        }

        //Check whether the payroll is available for the client and the given payroll_date

        /*
            Todo : For each payroll comps linked in tally , we need to calculate for all the employees.
                    If needed, consolidated value is also calculated.

                    Then, tally mapped names are used in response JSON.

                    Store the json response in 'vmt_payroll_tally' -> 'generated_json_payrolljournal' column

                    Return the json response.
        */

        $client_id = VmtClientMaster::where('client_fullname', $company_name)->first()->id;
        $is_exists = VmtPayroll::where('payroll_date', $payroll_date)->where('client_id', $client_id)->exists();

        if ($is_exists === false) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Payroll data not found for ' . $company_name . ' for the given payroll date : ' . $payroll_date,
            ], 400);
        }


        $payroll_outcome_data = $this->getPayrollOutcomes($client_id, $payroll_date)['data']['payroll_outcome'];

        $payroll_journal_data = $this->tallyPayrollRepository->getDefaultPayrollJournalData($company_name, $payroll_date, $payroll_outcome_data);


        return response()->json([
            "status" => "success",
            "message" => "Payroll journal data retrieved successfully for the month " . $payroll_date,
            "data" => $payroll_journal_data
        ]);
    }

    /*
        This function is called by tally software when its payroll processing is done.
        Expected JSON structure ,

        {
            "status": "success/failure",
            "message": "Payroll journal data retrieved successfully for the month 2023-10-31",
                / message : "Payroll journal data processing failed in Tally for the month 2023-10-31",
            "data": {
                "company_name": "INDCHEM MARKETING AGENCIES",
                "payroll_date": "2023-10-31"
            }
        }

    */
    public function saveTallyResponse_onPayrollProcessStatus($token, $status, $json_data, $full_json_request)
    {

        $validator = Validator::make(
            $data = [
                'token' => $token,
                'status' => $status,
                'data' => $json_data,
                'full_json_request' => $json_data,
            ],
            $rules = [
                'token' => 'required',
                'status' => ['required', Rule::in(['success', 'failure'])],
                'data' => 'required',
                'full_json_request' => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'integer' => 'Field :attribute should be integer',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ], 400);
        }

        try {

            //validate the JSON contents of Data attribute
            /*
                Expected structure
                    "data": {
                        "company_name": "INDCHEM MARKETING AGENCIES",
                        "payroll_date": "2023-10-31"
                    }
            */

            //Hardcoded check
            if ($token != '1234567890') {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Unable to fetch the payroll journal data. Given token is invalid.'
                ], 400);
            }

            //Check if the payroll-date and company name is valid
            $client_id = VmtClientMaster::where('client_name', $json_data['company_name'])->first();

            if (empty($client_id)) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Request failed. Given client name is invalid. Kindly fix it.',
                ]);
            }

            $client_id = $client_id->id;

            $payroll_id = VmtPayroll::where('client_id', $client_id)->where('payroll_date', $json_data['payroll_date'])
                ->first();

            if (empty($payroll_id)) {

                return response()->json([
                    'status' => 'failure',
                    'message' => 'Request failed. Given payroll date is invalid. Kindly fix it.',
                ]);
            }

            $payroll_id = $payroll_id->id;

            //Save the tally reponse in the vmt_payroll_tally table
            $vmt_tally = new VmtPayrollTally();
            $vmt_tally->vmt_payroll_id = $payroll_id;
            $vmt_tally->status = $status;
            $vmt_tally->json_response_tally = json_encode($full_json_request);
            $vmt_tally->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Tally response has been successfully sent to ABShrms system',
            ]);
        } catch (\Exception $e) {
            //TODO : Need to log the error instead of sending to the tally vendor .

            return response()->json([
                'status' => 'failure',
                'message' => 'Error while saving Tally response into ABShrms system',
                "error" => $e->getMessage() . ' | File : ' . $e->getFile() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTrace()
            ]);
        }
    }

    public function getAllEmployeesLeaveFilterDetails($filter_month, $filter_year, $filter_leave_status, $client_id, $serviceVmtAttendanceService)
    {
        try {

            $response =  $serviceVmtAttendanceService->getAllEmployeesLeaveDetails($filter_month, $filter_year, $filter_leave_status, $client_id);
            $get_leave_data = $response->getData(true);
            $pending_data = array();

            foreach ($get_leave_data['data'] as $key => $single_data) {
                // dd($single_data);
                $pending_data[$key]["employee"] = $single_data['employee_name'];
                $pending_data[$key]["date"] = Carbon::parse($single_data['start_date'])->format('M d,Y') . " - " . Carbon::parse($single_data['end_date'])->format('M d,Y');
                $pending_data[$key]["total_days"] = $single_data['total_leave_datetime'];
                $pending_data[$key]["leave_type"] = $single_data['leave_type'];
                $pending_data[$key]["reason"] = $single_data['leave_reason'];
                $pending_data[$key]["approver"] = $single_data['manager_name'];
            }

            return  $response = ([
                'status' => "success",
                'message' => "data fetched successfully",
                'data' => $pending_data
            ]);
        } catch (\Exception $e) {
            //TODO : Need to log the error instead of sending to the tally vendor .

            return response()->json([
                'status' => 'failure',
                'message' => 'Error while fetch data',
                "error" => $e->getMessage() . ' | File : ' . $e->getFile() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTrace()
            ]);
        }
    }
    // migrate old compensatory to new table
    public function updateCompensatoryDataToNewtable($serviceVmtPayrollComponentsService)
    {
        try {


            $compensatory_data = VmtEmployeeCompensatoryDetails::leftjoin('users', 'users.id', '=', 'vmt_employee_compensatory_details.user_id')
                ->where('users.active', '<>', '-1')
                ->get()->keyby('user_id')->toarray();

            $payroll_component_data = VmtPayrollComponents::get(['id', 'comp_name', 'comp_identifier'])->toarray();

            $paygroup_ids = array();
            $temp_paygroup_id = array();

            $comp_filter_data = array();

            $paygroup_array = array();
            $i = 1;
            $first = 0;
            $second = 0;
            $third = 0;
            $difference = array();
            foreach ($compensatory_data as $comp_key => $single_comp_data) {
                unset($single_comp_data['id']);
                unset($single_comp_data['created_at']);
                unset($single_comp_data['updated_at']);
                // unset($single_comp_data['user_id']);
                unset($single_comp_data['name']);
                unset($single_comp_data['user_code']);
                unset($single_comp_data['client_id']);
                unset($single_comp_data['email']);
                unset($single_comp_data['active']);
                unset($single_comp_data['password']);
                unset($single_comp_data['avatar']);
                unset($single_comp_data['is_onboarded']);
                unset($single_comp_data['onboard_type']);
                unset($single_comp_data['is_default_password_updated']);
                unset($single_comp_data['org_role']);
                unset($single_comp_data['can_login']);
                unset($single_comp_data['fcm_token']);
                $j = 0;
                foreach ($single_comp_data as $key => $single_data) {

                    if ($single_data != '0' && $single_data != ' ' && $single_data != null) {

                        $comp_filter_data[$comp_key][$key] = $single_data;

                        foreach ($payroll_component_data as $paygroup_key => $single_paygroup) {

                            if (in_array($key, $single_paygroup)) {
                                $paygroup_ids[$j]['id'] = $single_paygroup['id'];
                                $temp_paygroup_id[$comp_key][$j] = $single_paygroup['id'];
                                $temp_paygroup_value[$comp_key][$single_paygroup['id']] = $single_data;
                                $j++;
                            }
                        }
                    }
                }
            }
            //dd( $temp_paygroup_name,$temp_paygroup_value);

            $uniqueArrays = array_map('json_encode',  $temp_paygroup_id);
            $uniqueArrays = array_unique($uniqueArrays);
            $uniqueArrays = array_map('json_decode', $uniqueArrays, array_fill(0, count($uniqueArrays), true));
            // dd($temp_paygroup_id, $uniqueArrays);
            $structure_names = array();

            foreach ($uniqueArrays  as $key => $single_unique_array) {

                $structure_names['structure_' . $key] = $single_unique_array;
            }

            // dd($structure_names);
            // dd(in_array($temp_paygroup_id, $structure_names['id']));

            $paygroup_details = array();
            $j = 0;
            foreach ($temp_paygroup_id as $user_id_key => $single_pay_group) {

                if (in_array($single_pay_group, $structure_names)) {

                    $paygroup_details[$user_id_key]['structureName'] = array_search($single_pay_group, $structure_names);
                    $paygroup_details[$user_id_key]['selectedComponents'] = $single_pay_group;
                    $paygroup_details[$user_id_key]['assignedEmployees'] = [$user_id_key];
                    $j++;
                }
            }
            //   dd($paygroup_details);


            foreach ($paygroup_details as $single_key => $single_group_id) {

                $response = $serviceVmtPayrollComponentsService->addPaygroupCompStructure(
                    $user_code = 'SA_ABS',
                    $client_id = '1',
                    $structureName = $single_group_id['structureName'],
                    $description = 'default',
                    $pf = '0',
                    $esi = '0',
                    $tds = '0',
                    $fbp = '0',
                    $selectedComponents = $single_group_id['selectedComponents'],
                    $assignedEmployees = $single_group_id['assignedEmployees']

                );
            }


            foreach ($temp_paygroup_value as $single_user_key => $single_group_data) {

                $user_details = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                    ->leftjoin('vmt_emp_paygroup', 'vmt_emp_paygroup.user_id', '=', 'users.id')
                    ->where('user_id', $single_user_key)
                    ->get(['vmt_employee_details.doj as reviewed_date', 'vmt_emp_paygroup.paygroup_id'])->unique()->toarray();
                // dd( $user_details[0]['reviewed_date']);

                $paygroup_data_response = $this->saveEmployeeNewCompensatorydata($user_id = $single_user_key, $revisied_date = $user_details[0]['reviewed_date'], $effective_date = $user_details[0]['reviewed_date'], $active = 1, $vmt_emp_paygroup_data = $single_group_data);
            }
            //dd($paygroup_data_response);



            return  $response = ([
                'status' => "success",
                'message' => "data fetched successfully",
                'data' => $paygroup_data_response
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'failure',
                'message' => 'Error while fetch data',
                //  "error" => $e->getMessage() . ' | File : ' . $e->getFile() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getMessage()
            ]);
        }
    }

    public function saveEmployeeNewCompensatorydata($user_id, $revisied_date, $effective_date, $active, $vmt_emp_paygroup_data)
    {
        try {
            // dd($user_id,$revisied_date,$effective_date,$active,$vmt_emp_paygroup_data);
            $active_paygroup = VmtEmpActivePaygroup::where('user_id', $user_id)->where('revisied_date', $revisied_date)->where('effective_date', $effective_date);
            if ($active_paygroup->exists()) {

                $save_active_paygroup = $active_paygroup->first();
            } else {

                $save_active_paygroup = new VmtEmpActivePaygroup;
            }
            $save_active_paygroup->user_id = $user_id;
            $save_active_paygroup->revisied_date = $revisied_date;
            $save_active_paygroup->effective_date = $effective_date;
            $save_active_paygroup->active = $active;
            $save_active_paygroup->save();

            $active_paygroup_values = VmtEmpPayGroupValues::where('vmt_emp_active_paygroup_id', $save_active_paygroup->id);

            if ($active_paygroup_values->exists()) {

                $active_paygroup_values = $active_paygroup_values->delete();
            }



            $active_paygroup_id = $save_active_paygroup->id;
            foreach ($vmt_emp_paygroup_data as $values_key => $single_values) {
                $save_active_paygroup_values = new VmtEmpPayGroupValues;
                $save_active_paygroup_values->vmt_emp_active_paygroup_id = $active_paygroup_id;
                $save_active_paygroup_values->vmt_emp_paygroup_id = $values_key;
                $save_active_paygroup_values->Value = $single_values;
                $save_active_paygroup_values->save();
            }



            return  $response = ([
                'status' => "success",
                'message' => $save_active_paygroup_values,
                'data' => ''
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'failure',
                'message' => 'Error while fetch data',
                //  "error" => $e->getMessage() . ' | File : ' . $e->getFile() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getMessage()
            ]);
        }
    }






}
