<?php

namespace App\Http\Controllers;


use App\Models\VmtEmployeeAbsentRegularization;
use App\Models\VmtEmployeeWorkShifts;
use App\Services\VmtEmployeeLeaveModel;
use App\Services\VmtAttendanceService;
use App\Mail\ApproveRejectLeaveMail;
use App\Mail\RequestLeaveMail;
use App\Mail\VmtAbsentMail_Regularization;
use App\Mail\VmtAttendanceMail_Regularization;
use App\Models\VmtClientMaster;
use App\Models\User;
use App\Services\VmtAttendanceReportsService;
use App\Models\VmtEmployee;
use App\Models\VmtEmployeeAttendance;
use App\Models\VmtEmployeeLeaves;
use App\Models\VmtEmployeeCompensatoryLeave;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtLeaves;

use App\Models\VmtStaffAttendanceDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Mail\WelcomeMail;
use App\Models\VmtWorkShifts;
use App\Models\VmtEmployeeAttendanceRegularization;
use App\Models\VmtOrgTimePeriod;
use App\Services\VmtNotificationsService;
use App\Models\VmtTimePeriod;
use App\Services\VmtCoreService;
use \Datetime;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DatePeriod;
use DateInterval;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Mailer\Exception\TransportException;


class VmtAttendanceController extends Controller
{
    public function checkWeekOffStatus($date, $weekOffJson, $checkin_time, $checkout_time)
    {
        $days_for_per_week = array('Sunday' => 0, 'Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6);
        $date = Carbon::parse($date);
        $given_date_day = $date->format('l');
        $day_in_number = number_format($date->format('d'));
        $weekOffJson = json_decode($weekOffJson, true);
        if ($weekOffJson[$days_for_per_week[$given_date_day]]['all_week'] == 1) {

            return $checkin_time == null && $checkout_time == null ? true : false;
        } else {
            //logic for nth week of day week off
            $week_of_month = (int) (ceil($day_in_number / 7));
            $week_of_month_in_string = 'week_' . $week_of_month;
            if ($weekOffJson[$days_for_per_week[$given_date_day]][$week_of_month_in_string] == 1) {
                return $checkin_time == null && $checkout_time == null ? true : false;
            } else {
                return false;
            }
        }
    }

    public function showDashboard(Request $request)
    {

        $Total_Active_Employees = User::where('active', '1')

            ->where('is_ssa', '0')
            ->count();

        return view('attendance_dashboard', compact('Total_Active_Employees'));
    }
    public function findMIPOrMOP($time, $shiftStartTime, $shiftEndTime)
    {
        $response = array();
        $shift_start_time = $shiftStartTime->subHours(1)->format('Y-m-d H:i:0');
        $first_half_end_time = $shiftStartTime->addHours(5);

        if (Carbon::parse($time)->between(Carbon::parse($shift_start_time), $first_half_end_time, true)) {
            $response['checkin_time'] = $time;
            $response['checkout_time'] = null;
        } else {
            $response['checkin_time'] = null;
            $response['checkout_time'] = $time;
        }
        return $response;
    }

    public function showAttendanceLeavePage(Request $request)
    {

        $allEmployeesList = User::all();
        $leaveTypes = VmtLeaves::all();
        $leaveData_Team = null;
        $leaveData_Org = null;

        $leaveData_currentUser = VmtEmployeeLeaves::where('user_id', auth::user()->id);
        // dd( $leaveData_currentUser->get());
        //Get how many leaves taken for each leave_type
        $leaveData_currentUser = getLeaveCountDetails(auth::user()->id);

        //dd($leaveData_currentUser->toArray());

        //Accrued Leave Year Frame
        $available_time_frames = array();
        $time_periods_of_year_query = VmtOrgTimePeriod::where('status', 1)->first();
        $start_date = $time_periods_of_year_query->start_date;
        $end_date = $time_periods_of_year_query->end_date;
        $calender_type = $time_periods_of_year_query->abbrevation;
        // $time_frame = array( $start_date.'/'. $end_date=>$calender_type.' '.substr($start_date, 0, 4).'-'.substr($end_date, 0, 4));
        $available_time_frame_query = VmtOrgTimePeriod::get();
        foreach ($available_time_frame_query as $single_time_frame) {
            $time_frame_start_date = $single_time_frame->start_date;
            $time_frame_end_date = $single_time_frame->end_date;
            $available_time_frames[$single_time_frame->start_date . "/" . $single_time_frame->end_date] = $single_time_frame->abbrevation . ' ' . substr($time_frame_start_date, 0, 4) . '-' . substr($time_frame_end_date, 0, 4);
        }
        $time_frame = $calender_type . ' ' . substr($start_date, 0, 4) . '-' . substr($end_date, 0, 4);




        //Generate Team leave data
        if (Str::contains(currentLoggedInUserRole(), ['Manager'])) {
            //dd(auth::user()->id);
            $teamMembers_UserIDs = getTeamMembersUserIds(auth::user()->id);

            $leaveData_Team = VmtEmployeeLeaves::whereIn('user_id', $teamMembers_UserIDs)->get();
        }

        //Generate Org leave data
        if (Str::contains(currentLoggedInUserRole(), ['Super Admin', 'Admin', 'HR'])) {
            $leaveData_Org = VmtEmployeeLeaves::all();
        }
        //Calculate Leave Balance
        //   $leave_balance_details = calculateLeaveDetails(auth::user()->id,$start_date,$end_date);

        //dd(  $leave_balance_details);
        //dd($leaveTypes->toArray());
        return view('attendance_leave', compact('allEmployeesList', 'leaveTypes', 'leaveData_Org', 'leaveData_Team', 'leaveData_currentUser', 'time_frame', 'available_time_frames', 'time_frame'));
    }

    public function showAttendanceLeaveSettings(Request $request)
    {
        return view('attendance_leave_settings');
    }

    public function showAttendanceLeaveReportsPage(Request $request)
    {
        return view('attendance_leaveReports');
    }

    public function showLeaveHistoryPage(Request $request)
    {
        $allEmployeesList = User::all(['id', 'name']);

        if ($request->type == 'org') {
            return view('leave_history_org', compact('allEmployeesList'));
        } else
            if ($request->type == 'team') {
                return view('leave_history_team', compact('allEmployeesList'));
            } else
                if ($request->type == 'employee') {
                    return view('leave_history_employee', compact('allEmployeesList'));
                }
    }

    public function showLeaveApprovalPage(Request $request)
    {
        $allEmployeesList = User::all(['id', 'name']);

        return view('attendance_leave_approvals', compact('allEmployeesList'));
    }


    public function approveRejectRevokeLeaveRequest(Request $request, VmtAttendanceService $serviceVmtAttendanceService, VmtNotificationsService $serviceNotificationsService)
    {

        return $serviceVmtAttendanceService->approveRejectRevokeLeaveRequest(
            $request->record_id,
            $request->approver_user_code ?? auth()->user()->user_code,
            $request->status,
            $request->user_type,
            $request->review_comment,
            $serviceNotificationsService
        );
    }

    public function getEmployeeLeaveDetails(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {
        return $serviceVmtAttendanceService->getEmployeeLeaveDetails($request->user_code, $request->filter_month, $request->filter_year, $request->filter_leave_status);
    }

    public function getTeamEmployeesLeaveDetails(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {
        //dd($request->all());
        return $serviceVmtAttendanceService->getTeamEmployeesLeaveDetails($request->manager_code, $request->filter_month, $request->filter_year, $request->filter_leave_status);
    }

    public function getAllEmployeesLeaveDetails(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {
        $client_id = auth()->user()->client_id;
        return $serviceVmtAttendanceService->getAllEmployeesLeaveDetails($request->filter_month, $request->filter_year, $request->filter_leave_status, $client_id);
    }


    /*
        Fetches all leave details
        Also used VJS and gridjs table

        used in leave approvals page only

    */
    public function getLeaveRequestDetailsBasedOnCurrentRole(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {
        $response = $serviceVmtAttendanceService->getLeaveRequestDetailsBasedOnCurrentRole();

        return response()->json([
            "status" => "success",
            "message" => "",
            "data" => $response
        ]);
    }

    public function fetchSingleLeavePolicyRecord($id)
    {
        $temp = VmtLeaves::find($id);
        return $temp;
    }

    public function updateSingleLeavePolicyRecord(Request $request)
    {
        $vmtLeave = VmtLeaves::find($request->leave_policy_id);
        $vmtLeave->days_annual = $request->days_annual;
        $vmtLeave->days_monthly = $request->days_month;
        $vmtLeave->days_restricted = $request->days_restricted;


        $vmtLeave->save();
        $response = [
            'status' => 'success',
            'message' => 'Leave details updated',
            'error' => '',
            'error_verbose' => ''
        ];

        return $response;
    }

    /*
         Get leave info based on given leave_id
    */
    public function getLeaveInformation(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {
        return $serviceVmtAttendanceService->getLeaveInformation($request->record_id);
    }

    /*
        For VJS Leave Approvals table

        Returns all leave status types

    */
    private function createLeaveRange($start_date, $end_date)
    {
        $start_date = new DateTime($start_date);
        $end_date = new DateTime($end_date);

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($start_date, $interval, $end_date);

        return $daterange;
    }

    public function applyLeaveRequest_AdminRole(Request $request, VmtAttendanceService $serviceVmtAttendanceService, VmtNotificationsService $serviceVmtNotificationsService)
    {

        $response = null;
        try {


            $response = $serviceVmtAttendanceService->applyLeaveRequest_AdminRole(
                $request->admin_user_code,
                $request->user_code,
                $request->leave_request_date,
                $request->start_date,
                $request->end_date,
                $request->hours_diff,
                $request->no_of_days,
                $request->compensatory_work_days_ids,
                $request->leave_session,
                $request->leave_type_name,
                $request->leave_reason,
                $request->notifications_users_id,
                $serviceVmtNotificationsService
            );





            return $response;
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error while doing regularization",
                'data' => $e->getMessage()
            ]);
        }
    }

    public function getLeaveNotifyToList(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {
        return $serviceVmtAttendanceService->getLeaveNotifyToList($request->user_code);
    }

    public function applyLeaveRequest(Request $request, VmtAttendanceService $serviceAttendanceService, VmtNotificationsService $serviceVmtNotificationsService)
    {

        return $serviceAttendanceService->applyLeaveRequest(
            user_code: $request->user_code,
            leave_request_date: $request->leave_request_date,
            start_date: $request->start_date,
            end_date: $request->end_date,
            hours_diff: $request->hours_diff,
            no_of_days: $request->no_of_days,
            compensatory_work_days_ids: $request->compensatory_work_days_ids,
            leave_session: $request->leave_session,
            leave_type_name: $request->leave_type_name,
            leave_reason: $request->leave_reason,
            user_type: "Employee",
            notifications_users_id: $request->notifications_users_id,
            serviceNotificationsService: $serviceVmtNotificationsService
        );
    }


    public function withdrawLeave(Request $request, VmtAttendanceService $serviceAttendanceService)
    {
        return $serviceAttendanceService->withdrawLeave($request->leave_id, $request->withdraw_comment);
    }

    /*
        Show the attendance IN/OUT time for the given month

    */
    public function showEmployeeTimeSheetPage(Request $request)
    {

        //TODO : get the attendance data for the given month
        $employeeAttendanceData = VmtEmployeeAttendance::all();


        //dd($employeeAttendanceData);
        return view('old_vmt_attendance_timesheet', compact('employeeAttendanceData'));
    }

    /*
        Fetch timesheet data via AJAX
        Input :

    */
    // public function fetchTimesheetData(Request $request)
    // {
    //     $month = $request->month;
    //     $user_id  =$request->user_id;

    //     $employeeAttendanceData = VmtEmployeeAttendance::whereMonth('checkin_time',$month)
    //                                 ->where('user_id',$user_id)
    //                                 ->get();

    //     return $employeeAttendanceData;
    // }

    public function showAllEmployeesTimesheetPage(Request $request)
    {


        return view('vmt_admin_attendance_timesheet', compact('employeeAttendanceData'));
    }

    public function fetchLeavePolicyDetails(Request $request, VmtAttendanceService $attendance_service)
    {
        // $currentuser_gender = getCurrentUserGender();

        // if ($currentuser_gender == 'male') {
        //     $query_leavePolicyDetails = VmtLeaves::where('leave_type', '<>', 'Maternity Leave')->get();
        // } else
        // if ($currentuser_gender == 'female') {
        //     $query_leavePolicyDetails = VmtLeaves::where('leave_type', '<>', 'Paternity Leave')->get();
        // } else {
        //     return "invalid gender";
        // }

        // return $query_leavePolicyDetails;
        $leave_balance_details = collect();
        $temp_ar = array();
        $org_time_period = VmtOrgTimePeriod::where('status', 1)->first();
        $user_id = auth()->user()->id;
        if (!empty($request->user_code)) {
            $user_id = User::where('user_code', $request->user_code)->first()->id;
        }
        $leave_balance = $attendance_service->calculateEmployeeLeaveBalance($user_id, $org_time_period->start_date, $org_time_period->end_date);
        foreach ($leave_balance as $single_leave_types) {
            $temp_ar['is_finite'] = VmtLeaves::where('leave_type', $single_leave_types['leave_type'])->first()->is_finite;
            $temp_ar['leave_value'] = $single_leave_types['leave_type'];
            if ($temp_ar['is_finite'] == 1) {
                $temp_ar['leave_type'] = $single_leave_types['leave_type'] . '(' . $single_leave_types['leave_balance'] . ')';
            } else {
                $temp_ar['leave_type'] = $single_leave_types['leave_type'];
            }
            $temp_ar['leave_balance'] = $single_leave_types['leave_balance'];
            $leave_balance_details->push($temp_ar);
            unset($temp_ar);
        }
        return $leave_balance_details;
    }



    /**
     * dayWiseStaffAttendance
     * table: users, vmt_staff_attenndance_device
     * input param: date
     *
     */
    protected function dayWiseStaffAttendance(Request $request)
    {
        $date = $request->has('date') ? $request->date : Carbon::now()->format('Y-m-d');

        $attendanceJoin = \DB::table('vmt_staff_attenndance_device')
            ->select('user_Id', \DB::raw('MAX(date) as check_out_time'), \DB::raw('MIN(date) as check_in_time'))
            ->whereDate('date', $date)
            ->groupBy('user_Id');

        $users = \DB::table('users')->select('id', 'name', 'user_code', 'check_in_time', 'check_out_time')
            ->leftJoinSub($attendanceJoin, 'vmt_staff_attenndance_device', function ($join) {
                $join->on('users.user_code', '=', 'vmt_staff_attenndance_device.user_Id');
            })->get();

        //Shift timings
        $shift_timings = VmtWorkShifts::where('shift_name', 'First Shift')->first();

        return view('vmt_daily_staff_attendance', compact('users', 'shift_timings'));
    }





    /////////////////////// New routing methods


    public function showTimesheet(Request $request)
    {
        $shift_start_time = VmtWorkShifts::where('shift_name', "First Shift")->value('shift_start_time');
        $shift_end_time = VmtWorkShifts::where('shift_name', "First Shift")->value('shift_end_time');
        $leaveTypes = VmtLeaves::all();
        $leaveData_currentUser = VmtEmployeeLeaves::where('user_id', auth::user()->id);
        //Get how many leaves taken for each leave_type
        $leaveData_currentUser = getLeaveCountDetails(auth::user()->id);


        //Show the single employee timesheet detail in sidepanel

        $current_employee_detail = User::leftJoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
            ->where('users.id', auth::user()->id)
            ->first(['users.id', 'users.name', 'vmt_employee_office_details.designation']);

        $current_employee_detail->employee_avatar = getEmployeeAvatarOrShortName($current_employee_detail->id);

        return view('attendance_timesheet', compact('current_employee_detail', 'shift_start_time', 'shift_end_time', 'leaveTypes'));
    }
    public function getShiftTimeForEmployee($user_id, $checkin_time, $checkout_time)
    {
        $emp_work_shift = VmtEmployeeWorkShifts::where('user_id', $user_id)->where('is_active', '1')->get();

        if (count($emp_work_shift) == 1) {
            $regularTime = VmtWorkShifts::where('id', $emp_work_shift->first()->work_shift_id)->first();
            return $regularTime;
        } else if (count($emp_work_shift) > 1) {
            foreach ($emp_work_shift as $single_work_shift) {
                $regularTime = VmtWorkShifts::where('id', $single_work_shift->work_shift_id)->first();
                $shift_start_time = Carbon::parse($regularTime->shift_start_time)->addMinutes($regularTime->grace_time);
                $shift_end_time = Carbon::parse($regularTime->shift_end_time);
                $diffInMinutesInCheckinTime = $shift_start_time->diffInMinutes(Carbon::parse($checkin_time), false);
                $diffInMinutesInCheckOutTime = $shift_end_time->diffInMinutes(Carbon::parse($checkout_time), false);
                if ($checkin_time == null && $checkout_time == null) {
                    return $regularTime;
                } else if ($diffInMinutesInCheckinTime > -65 && $diffInMinutesInCheckinTime < 275) {
                    return $regularTime;
                } else if ($diffInMinutesInCheckOutTime > -65 && $diffInMinutesInCheckOutTime < 65) {
                    return $regularTime;
                } else {
                    return $regularTime;
                }
            }
        } else {
            return null;
        }
    }

    // public function fetchAttendanceDailyReport_PerMonth_v2(Request $request, VmtAttendanceService $vmtAttendanceServices)
    // {
    //     $response = $vmtAttendanceServices->fetchAttendanceDailyReport_PerMonth_v2($request->user_code, $request->year, $request->month);

    //     return response()->json($response);
    // }
    public function fetchAttendanceDailyReport_PerMonth_v3(Request $request, VmtAttendanceService $vmtAttendanceServices)
    {

        $response = $vmtAttendanceServices->fetchAttendanceDailyReport_PerMonth_v3($request->user_code, $request->year, $request->month);

        return $response;
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
                $currentDate = Carbon::parse($attendance_date);
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


    /*
        TODO : DUPLICATION!! . Need to replace this with service class function to prevent


    */
    private function isRegularizationRequestApplied($user_id, $attendance_date, $regularizeType)
    {

        $regularize_record = VmtEmployeeAttendanceRegularization::where('attendance_date', $attendance_date)
            ->where('user_id', $user_id)->where('regularization_type', $regularizeType);

        // dd($user_id ." , ". $attendance_date." , ".$regularizeType);
        $record = array();
        if ($regularize_record->exists()) {
            unset($record);
            $record['status'] = $regularize_record->value('status');
            $record['regularized_time'] = $regularize_record->value('regularize_time');
            // dd($regularize_record->value('reason_type'));
            if ($regularize_record->value('reason_type') == 'Others') {
                $record['reason'] = $regularize_record->value('reason_type');
                $record['cst_reason'] = $regularize_record->value('custom_reason');
            } else {
                $record['reason'] = $regularize_record->value('reason_type');
                $record['cst_reason'] = null;
            }
        } else {
            unset($record);
            $record['status'] = "None";
            $record['reason'] = "None";
            $record['cst_reason'] = null;
            $record['regularized_time'] = null;
        }
        return $record;
    }

    /*
        Fetch regularization data for the given user id

    */
    public function fetchRegularizationData(Request $request)
    {

        //dd($request->all());

        $regularize_record = VmtEmployeeAttendanceRegularization::where('attendance_date', $request->selected_date)
            ->where('user_id', $request->user_id)->where('regularization_type', $request->regularization_type)->first();

        //dd($regularize_record);

        return $regularize_record;
    }

    public function fetchTeamMembers(Request $request)
    {

        //Get the team members of the given user
        if (!empty($request->user_code)) {
            $user_code = $request->user_code;
        } else {
            $user_code = auth()->user()->user_code;
        }
        $reportees_id = VmtEmployeeOfficeDetails::where('l1_manager_code', $user_code)->get('user_id');

        $reportees_details = User::leftJoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
            ->whereIn('users.id', $reportees_id)->where('users.is_ssa', '0')->where('users.active', '1')
            ->get(['users.id', 'users.user_code', 'users.name', 'vmt_employee_office_details.designation']);


        //dd($reportees_details->toArray());
        foreach ($reportees_details as $singleItem) {
            $singleItem->employee_avatar = getEmployeeAvatarOrShortName($singleItem->id);
        }


        return $reportees_details;
    }

    public function fetchOrgMembers(Request $request)
    {
        //Get the team members of the given user
        //$reportees_id = VmtEmployeeOfficeDetails::where('l1_manager_code', $request->user_code)->get('user_id');

        $client_id = null;

        if (session('client_id') == 1) {
            $client_id = VmtClientMaster::pluck('id');
        } else {
            $client_id = [session('client_id')];
        }

        $all_employees = User::leftJoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
            ->whereIn('users.client_id', $client_id)
            ->where('users.is_ssa', '0')
            ->where('users.active', '1')
            ->get(['users.id', 'users.user_code', 'users.name', 'vmt_employee_office_details.designation']);


        //dd($reportees_details->toArray());
        foreach ($all_employees as $singleItem) {
            $singleItem->employee_avatar = getEmployeeAvatarOrShortName($singleItem->id);
        }

        return $all_employees;
    }

    /*
        Also known as Attendance Regularization

    */
    public function showRegularizationApprovalPage(Request $request)
    {


        return view('attendance_regularization_approvals');
    }

    /*

        Fetch Attendance Regularization data

        Todo : Need to restrict employee access
    */
    public function fetchAttendanceRegularizationData(Request $request, VmtAttendanceService $attendanceService)
    {

        $response = null;

        //Check whether the current employee is Manager
        // dd(Str::contains(currentLoggedInUserRole(), ['Manager']));
        if (Str::contains(currentLoggedInUserRole(), ['Manager'])) {
            //fetch team level data
            //  dd(auth()->user()->user_code);
            $response = $attendanceService->fetchAttendanceRegularizationData($request->month, $request->year, auth()->user()->user_code);
        } else {

            //Fetch all data
            $response = $attendanceService->fetchAttendanceRegularizationData($request->month, $request->year, null);
        }

        return $response;
    }

    /*
        Fetch Absent Regularization data

        Todo : Need to restrict employee access
    */
    public function fetchAbsentRegularizationData(Request $request, VmtAttendanceService $attendanceService)
    {

        $response = null;

        //Check whether the current employee is Manager

        if (Str::contains(currentLoggedInUserRole(), ['Manager'])) {
            //fetch team level data
            $response = $attendanceService->fetchAbsentRegularizationData($request->month, $request->year, auth()->user()->user_code);
        } else {

            //Fetch all data
            $response = $attendanceService->fetchAbsentRegularizationData($request->month, $request->year, null);
        }

        return $response;
    }


    /*
        Fetch all regularization data.
    */
    public function fetchAllRegularizationData(Request $request)
    {


        $allEmployees_lateComing = '';

        $map_allEmployees = User::all(['id', 'name'])->keyBy('id');


        $allEmployees_lateComing = null;

        //If manager ID set, then show only the team level employees
        if (isset($request->manager_id)) {
            //Get all the employees ID for the given manager_id
            $manager_emp_code = User::find($request->manager_id)->user_code;

            dd($manager_emp_code);
            $employees_id = VmtEmployeeOfficeDetails::where('l1_manager_code', '');

            $allEmployees_lateComing = VmtEmployeeAttendanceRegularization::whereIn();
        } else {
            $allEmployees_lateComing = VmtEmployeeAttendanceRegularization::all();
        }

        //dd($map_allEmployees->toArray());
        //dd($allEmployees_lateComing->toArray());

        foreach ($allEmployees_lateComing as $singleItem) {

            //check whether user_id from regularization table exists in USERS table
            if (array_key_exists($singleItem->user_id, $map_allEmployees->toArray())) {

                $singleItem->employee_name = $map_allEmployees[$singleItem->user_id]["name"];
                $singleItem->employee_avatar = getEmployeeAvatarOrShortName($singleItem->user_id);

                //If reviewer_id = 0, then its not yet reviewed
                if ($singleItem->reviewer_id != 0) {
                    $singleItem->reviewer_name = $map_allEmployees[$singleItem->reviewer_id]["name"];
                    $singleItem->reviewer_avatar = getEmployeeAvatarOrShortName($singleItem->reviewer_id);
                }
            } else {
                //  dd("Missing User ID : " . $singleItem->user_id);
            }
        }

        // dd($allEmployees_lateComing);
        return $allEmployees_lateComing;
    }

    /*
        Employee send request to HR for attendance regularization

    */
    public function checkAttendanceEmployeeAdminStatus(Request $request, VmtAttendanceService $serviceVmtAttendanceService, VmtNotificationsService $serviceVmtNotificationsService)
    {

        try {

            $admin_user_code = $request->admin_user_code;

            $is_admin = User::where('user_code', $admin_user_code)->where('org_role', "2")->orWhere('org_role', "1")->first();

            if (!empty($is_admin)) {

                $response = $serviceVmtAttendanceService->applyRequestAttendanceRegularization(
                    user_code: $request->user_code,
                    attendance_date: $request->attendance_date,
                    regularization_type: $request->regularization_type,
                    user_time: $request->user_time,
                    regularize_time: $request->regularize_time,
                    reason: $request->reason,
                    custom_reason: $request->custom_reason,
                    user_type: "Admin",
                    serviceVmtNotificationsService: $serviceVmtNotificationsService
                );

                if ($response['status'] == "success") {

                    $user_data = User::where('user_code', $request->user_code)->first();

                    $record_id = VmtEmployeeAttendanceRegularization::where('user_id', $user_data->id)->where('attendance_date', $request->attendance_date)->first();

                    $response = $serviceVmtAttendanceService->approveRejectAttendanceRegularization(
                        approver_user_code: $admin_user_code,
                        record_id: $record_id->id,
                        status: "Approved",
                        status_text: "---",
                        user_type: "Admin",
                        serviceVmtNotificationsService: $serviceVmtNotificationsService
                    );
                } else {
                    return $response;
                }
            }

            return $response;
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error while doing regularization",
                'data' => $e->getMessage()
            ]);
        }
    }
    public function applyRequestAttendanceRegularization(Request $request, VmtAttendanceService $serviceVmtAttendanceService, VmtNotificationsService $serviceVmtNotificationsService)
    {
        return $serviceVmtAttendanceService->applyRequestAttendanceRegularization(
            user_code: $request->user_code,
            attendance_date: $request->attendance_date,
            regularization_type: $request->regularization_type,
            user_time: $request->user_time,
            regularize_time: $request->regularize_time,
            reason: $request->reason,
            custom_reason: $request->custom_reason,
            user_type: "manager",
            serviceVmtNotificationsService: $serviceVmtNotificationsService
        );
    }

    public function checkAbsentEmployeeAdminStatus(Request $request, VmtAttendanceService $serviceVmtAttendanceService, VmtNotificationsService $serviceVmtNotificationsService, VmtAttendanceReportsService $serviceVmtAttendanceReportsService)
    {

        try {
            $admin_user_code = $request->admin_user_code;

            $is_admin = User::where('user_code', $admin_user_code)->where('org_role', "2")->orWhere('org_role', "1")->first();

            if (!empty($is_admin)) {



                $response = $serviceVmtAttendanceService->applyRequestAbsentRegularization(
                    user_code: $request->user_code,
                    attendance_date: $request->attendance_date,
                    regularization_type: $request->regularization_type,
                    checkin_time: $request->checkin_time,
                    checkout_time: $request->checkout_time,
                    reason: $request->reason,
                    custom_reason: $request->custom_reason,
                    user_type: "Admin",
                );


                if ($response['status'] == "success") {

                    $user_data = User::where('user_code', $request->user_code)->first();

                    $record_id = VmtEmployeeAbsentRegularization::where('user_id', $user_data->id)->where('attendance_date', $request->attendance_date)->first();

                    $response_data = $serviceVmtAttendanceService->approveRejectAbsentRegularization(
                        approver_user_code: $admin_user_code,
                        record_id: $record_id->id,
                        status: "Approved",
                        status_text: "---",
                        user_type: "Admin",
                        serviceVmtAttendanceReportsService: $serviceVmtAttendanceReportsService
                    );
                } else {
                    return response()->json([
                        'status' => 'failure',
                        'message' => "Error while Apply regularization",
                        'data' => $response,
                    ]);
                }
            }

            return $response;
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error while doing regularization",
                'data' => $e->getTraceAsString(),
            ]);
        }
    }


    public function applyRequestAbsentRegularization(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {

        return $serviceVmtAttendanceService->applyRequestAbsentRegularization(
            user_code: $request->user_code,
            attendance_date: $request->attendance_date,
            regularization_type: $request->regularization_type,
            checkin_time: $request->checkin_time,
            checkout_time: $request->checkout_time,
            reason: $request->reason,
            custom_reason: $request->custom_reason,
            user_type: "manager",
        );
    }

    public function getAttendanceRegularizationStatus(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {

        return $serviceVmtAttendanceService->getAttendanceRegularizationStatus(
            user_code: $request->user_code,
            regularization_date: $request->regularization_date,
            regularization_type: $request->regularization_type
        );
    }

    public function approveRejectAbsentRegularization(Request $request, VmtAttendanceService $serviceVmtAttendanceService, VmtAttendanceReportsService $serviceVmtAttendanceReportsService)
    {

        return $serviceVmtAttendanceService->approveRejectAbsentRegularization(
            approver_user_code: $request->user_code,
            record_id: $request->record_id,
            status: $request->status,
            status_text: $request->status_text,
            user_type: "manager",
            serviceVmtAttendanceReportsService: $serviceVmtAttendanceReportsService
        );
    }

    public function approveRejectAttendanceRegularization(Request $request, VmtAttendanceService $serviceVmtAttendanceService, VmtNotificationsService $serviceVmtNotificationsService)
    {

        // dd($request->all());
        return $serviceVmtAttendanceService->approveRejectAttendanceRegularization(
            approver_user_code: $request->approver_user_code,
            record_id: $request->record_id,
            status: $request->status,
            status_text: $request->status_text,
            user_type: "manager",
            serviceVmtNotificationsService: $serviceVmtNotificationsService
        );
    }

    public function showLeavePolicyDocument(Request $request)
    {
        $client_name = "";

        //For testing only.
        if (isset($request->client_name)) {
            $client_name = $request->client_name;
        } else {
            //get the client name from client table
            $client_name = VmtClientMaster::find(session('client_id'))->client_name;
            $client_name = str_replace(' ', '', $client_name);
            //dd($client_name);
        }

        //If no sub-client selected, then show a default template
        if ($client_name == "All") {
            $viewPage = 'leave_policy_default';
        } else {
            //choose the blade file
            $viewPage = 'leave_policy_' . strtolower($client_name);
        }

        if (!view()->exists('leave_policy_templates.' . $viewPage)) {
            $viewPage = 'leave_policy_default';
        }

        // dd($viewPage);
        return view('leave_policy_templates.' . $viewPage);
    }

    public function fetchOrgEmployeesPendingLeaves(Request $request)
    {

        $final_output = array("leave_types" => [], "employees" => []);

        $leave_types = VmtLeaves::all()->pluck('days_annual', 'leave_type');

        //store all leave types to show as column header in UI
        $final_output["leave_types"] = array_keys($leave_types->toArray());

        //Create leave array template for storing leave count for each leave type for a given employee
        $array_template_leaveTypes = array();

        //Set the total leaves for each leave type as per the system
        foreach ($leave_types as $key_singleLeaveType => $value) {
            $array_template_leaveTypes[$key_singleLeaveType] = $value;
        }

        $leave_balance_data = User::leftJoin('vmt_employee_leaves', 'vmt_employee_leaves.user_id', '=', 'users.id')
            ->leftJoin('vmt_leaves', 'vmt_leaves.id', '=', 'vmt_employee_leaves.leave_type_id')
            ->where('users.is_ssa', '0')
            ->select('users.id as user_id', 'user_code', 'avatar', 'name', 'leave_type_id', 'leave_type', 'total_leave_datetime')
            ->get();
        //dd($leave_balance_data->toArray());

        //For each employee, check how much leave taken for each leave type. This applies for emps who already applied leaves. Else it will be NULL
        foreach ($leave_balance_data as $single_leave_balance_data) {

            //If key not found, create one
            if (!array_key_exists($single_leave_balance_data->user_id, $final_output["employees"])) {
                //add to main array
                $final_output["employees"][$single_leave_balance_data->user_id] = new VmtEmployeeLeaveModel(
                    $single_leave_balance_data->user_id,
                    $single_leave_balance_data->name,
                    $array_template_leaveTypes
                );
            }

            //Only if the user has any leaves, this should run else leave details will be NULL. Need to handle this in front-end VueJS table
            if (!empty($single_leave_balance_data->leave_type_id)) {
                //Remove text chars from 'total_leave_datetime' value such as FN, AN.
                $processed_val_total_leave_balance_data = preg_replace("/[^0-9.]/", "", $single_leave_balance_data->total_leave_datetime);


                //Subtract the leave count in this array for the given leave_type
                $final_output["employees"][$single_leave_balance_data->user_id]
                    ->array_leave_details[$single_leave_balance_data->leave_type] -= $processed_val_total_leave_balance_data;
            }
        }

        //TODO : Ignore the keys and get their values..
        $final_output["employees"] = array_values($final_output["employees"]);

        //dd($final_output);
        return $final_output;
    }

    /*
        Team level leave balance

    */
    public function fetchTeamEmployeesPendingLeaves(Request $request)
    {

        //dd($request->all());

        $manager_user_code = User::find($request->user_id)->user_code;

        $final_output = array("leave_types" => [], "employees" => []);

        $leave_types = VmtLeaves::all()->pluck('days_annual', 'leave_type');

        //store all leave types to show as column header in UI
        $final_output["leave_types"] = array_keys($leave_types->toArray());

        //Create leave array template for storing leave count for each leave type for a given employee
        $array_template_leaveTypes = array();

        //Set the total leaves for each leave type as per the system
        foreach ($leave_types as $key_singleLeaveType => $value) {
            $array_template_leaveTypes[$key_singleLeaveType] = $value;
        }

        $leave_balance_data = VmtEmployeeLeaves::join('users', 'users.id', '=', 'vmt_employee_leaves.user_id')
            ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'vmt_employee_leaves.user_id')
            ->join('vmt_leaves', 'vmt_leaves.id', '=', 'vmt_employee_leaves.leave_type_id')
            ->select('vmt_employee_leaves.user_id', 'user_code', 'avatar', 'name', 'leave_type_id', 'leave_type', 'total_leave_datetime')
            ->where('vmt_employee_office_details.l1_manager_code', '=', $manager_user_code)
            ->get();

        //For each employee, check how much leave taken for each leave type
        foreach ($leave_balance_data as $single_leave_balance_data) {

            //If key not found, create one
            if (!array_key_exists($single_leave_balance_data->user_id, $final_output["employees"])) {
                //add to main array
                $final_output["employees"][$single_leave_balance_data->user_id] = new VmtEmployeeLeaveModel(
                    $single_leave_balance_data->user_id,
                    $single_leave_balance_data->name,
                    $array_template_leaveTypes
                );
            }

            //dd($single_leave_balance_data);

            //Remove text chars from 'total_leave_datetime' value such as FN, AN.
            $processed_val_total_leave_balance_data = preg_replace("/[^0-9.]/", "", $single_leave_balance_data->total_leave_datetime);

            //Add the leave count in this array for the given leave_type
            $final_output["employees"][$single_leave_balance_data->user_id]->array_leave_details[$single_leave_balance_data->leave_type] -= $processed_val_total_leave_balance_data;
        }

        //TODO : Ignore the keys and get their values..
        $final_output["employees"] = array_values($final_output["employees"]);

        //dd($final_output);
        return $final_output;
    }

    public function fetchUnusedCompensatoryOffDays(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {

        //TODO : Need to get current user_id instead of fetching from req params.
        $user_id = auth()->user()->id;
        return $serviceVmtAttendanceService->fetchUnusedCompensatoryOffDays($user_id);
    }

    public function employeeProfile(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {

        return $serviceVmtAttendanceService->employeeProfile($request);
    }

    public function getEmployeeLeaveBalance(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {
        //Accrued Leave Year Frame
        if (empty($request->all())) {
            $time_periods_of_year_query = VmtOrgTimePeriod::where('status', 1)->first();
        } else {
            $time_periods_of_year_query = VmtOrgTimePeriod::where('id', $request->id)->first();
        }
        $start_date = $time_periods_of_year_query->start_date;
        $end_date = $time_periods_of_year_query->end_date;
        $calender_type = $time_periods_of_year_query->abbrevation;
        if (!empty($request->month)) {
            $end_date = Carbon::parse($request->month)->endOfMonth()->format('Y-m-d');
        }
        $leave_balance_details = $serviceVmtAttendanceService->calculateEmployeeLeaveBalance(auth::user()->id, $start_date, $end_date);
        return $leave_balance_details;
    }

    // public function fetchEmployeeLeaveBalance(Request $request){
    //     $leave_balance_details = calculateLeaveDetails(auth::user()->id,$request->start_date,$request->end_date);
    //     return $leave_balance_details;
    // }


    public function fetchOrgLeaveBalance(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {
        //dd($request->all());
        // if (!empty($request->all())) {
        //     $date = carbon::createFromFormat('d/m/Y', $request->date);
        //     $start_date  =   $date->startOfMonth()->format('Y-m-d');
        //     $end_date =   $date->endOfMonth()->format('Y-m-d');
        //     $end_date_ar = explode("-", $end_date);
        //     $month = $end_date_ar[1];
        // } else {
        //     $org_time = VmtOrgTimePeriod::where('status', 1)->first();
        //     $today = Carbon::now();
        //     $start_date = $org_time->start_date;
        //     $end_date = $today->format('Y-m-d');
        //     $month = $today->format('m');
        // }
        if (empty($request->all())) {
            $org_time = VmtOrgTimePeriod::where('status', 1)->first();
        } else {
            $org_time = VmtOrgTimePeriod::where('id', $request->id)->first();
        }
        $start_date = $org_time->start_date;
        $end_date = $org_time->end_date;
        if (!empty($request->month)) {
            $end_date = Carbon::parse($request->month)->endOfMonth()->format('Y-m-d');
        }
        $month = Carbon::parse($org_time->end_date)->format('m');
        $year = Carbon::parse($org_time->end_date)->format('Y');


        $response = $serviceVmtAttendanceService->fetchOrgLeaveBalance($start_date, $end_date, $month, $year);
        return $response;
    }

    public function fetchTeamLeaveBalance(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {

        // if (!empty($request->all())) {
        //     //  dd($request->date);
        //     $date = carbon::createFromFormat('d/m/Y', $request->date);
        //     $start_date  =   $date->startOfMonth()->format('Y-m-d');
        //     $end_date_carbon = $date->endOfMonth();
        //     $end_date =    $end_date_carbon->clone()->format('Y-m-d');
        //     $month = $end_date_carbon->clone()->format('m');
        //     $year =  $end_date_carbon->clone()->format('Y');
        // } else {
        //     $org_time = VmtOrgTimePeriod::where('status', 1)->first();
        //     $today = Carbon::now();
        //     $start_date = $org_time->start_date;
        //     $end_date = $today->format('Y-m-d');
        //     $month = $today->format('m');
        //     $year = $today->format('Y');
        //}
        if (empty($request->all())) {
            $org_time = VmtOrgTimePeriod::where('status', 1)->first();
        } else {
            $org_time = VmtOrgTimePeriod::where('id', $request->id)->first();
        }
        $today = Carbon::now();
        $start_date = $org_time->start_date;
        $end_date = $org_time->end_date;
        if (!empty($request->month)) {
            $end_date = Carbon::parse($request->month)->endOfMonth()->format('Y-m-d');
        }
        $month = Carbon::parse($end_date)->format('m');
        $year = Carbon::parse($end_date)->format('Y');
        // dd($start_date,$end_date,$month,$year);
        $response = $serviceVmtAttendanceService->teamLeaveBalance($start_date, $end_date, $month, $year);

        return $response;
    }

    public function isLeaveBalanceAvailable(Request $request, VmtAttendanceService $serviceAttendanceService)
    {
        return $serviceAttendanceService->isLeaveBalanceAvailable(
            user_code: $request->user_code,
            leave_type_name: $request->leave_type_name,
            current_applied_leave_count: $request->current_applied_leave_count
        );
    }

    public function getAttendanceStatus(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {
        return $serviceVmtAttendanceService->fetchAttendanceStatus($request->user_code, $request->date);
    }

    // public function getAttendanceDashboardData(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    // {

    //     return  $serviceVmtAttendanceService->getAttendanceDashboardData($request->department_id);
    // }
    public function getAttendanceDashboardData_v2(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {

        return $serviceVmtAttendanceService->getAttendanceDashboardData_v2($request->department_id, $request->date);
    }
    // public function getWorkShiftDetails(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    // {
    //     return  $serviceVmtAttendanceService->getWorkShiftDetails();
    // }

    public function checkEmployeeLcPermission(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $user_id = $request->user_id;
        return $serviceVmtAttendanceService->checkEmployeeLcPermission($month, $year, $request->user_id);
    }
    public function saveSandwichSettingsdata(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {

        return $serviceVmtAttendanceService->saveSandwichSettingsdata($request->is_sandwich_applicable, $request->is_weekoff_applicable, $request->is_holiday_applicable, $request->can_consider_approved_leaves);
    }
    public function getOrgTimePeriod(Request $request, VmtCoreService $vmtCoreService)
    {
        return $vmtCoreService->getOrgTimePeriod();
    }

    public function restrictedDaysForLeaveApply(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {
        $user_code = $request->user_code;
        return $serviceVmtAttendanceService->restrictedDaysForLeaveApply($user_code);
    }
}
