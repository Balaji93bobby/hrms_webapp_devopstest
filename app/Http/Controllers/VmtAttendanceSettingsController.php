<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\VmtEmployeeWorkShifts;
use App\Models\VmtWorkShifts;
use App\Services\VmtAttendanceService;
use App\Services\VmtAttendanceSettingsService;
class VmtAttendanceSettingsController extends Controller
{
    //

    public function showAttendanceSettingsPage(Request $request)
    {
        return view('configurations.attendance_settings');
    }

    public function assignEmployeesWorkShift(Request $request)
    {

        //VmtEmployeeWorkShifts
    }

    public function fetchEmployeeDetails(Request $request)
    {

        $query_emp_details = User::leftJoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
            ->leftJoin('vmt_department', 'vmt_department.id', '=', 'vmt_employee_office_details.department_id')
            ->where('users.is_ssa', '0')
            ->get(['users.id as user_id', 'user_code as emp_code', 'users.name as employee_name', 'designation', 'work_location', 'department_id', 'vmt_department.name as department_name']);

        return $query_emp_details;
    }

    /*
        Assigns the selected employees to workshifts
    */
    public function assignEmployeesToWorkShift(Request $request)
    {

        //vmt_employee_workshifts
        //dd($request->all());

        $req_workshift_name = $request->workshift_name;
        $array_emp_ids = $request->selectedEmployees;

        //check if shift name already exists
        if (VmtWorkShifts::where('shift_type', $req_workshift_name)->count() > 0) {
            return [
                "status" => "failure",
                "message" => "Shift name already exists! Please enter a new name",

            ];
        } else {
            //Create New workshift
            $workshift = new VmtWorkShifts;
            $workshift->shift_type = $req_workshift_name;
            $workshift->shift_start_time = $request->shift_start_time;
            $workshift->shift_end_time = $request->shift_end_time;
            $workshift->save();
        }

        //assign employees into the created shift
        foreach ($array_emp_ids as $singleEmpID) {

            $emp_workshift = new VmtEmployeeWorkShifts;
            $emp_workshift->user_id = $singleEmpID;
            $emp_workshift->work_shift_id = $singleEmpID;
        }
    }

    public function saveWorkShiftSettings(Request $request, VmtAttendanceSettingsService $vmtAttendanceSettingsService)
    {

        $shift_code = 'FS';
        $shift_name = 'First Shift';
        $is_default = 1;
        $shift_timerange_type = 'fixed';
        $flexible_gross_hours = null;
        $shift_start_time = '09:30:00';
        $shift_end_time = '18:30:00';
        $grace_time = '15';
        $week_off_days = array('Saturday' => '2,4', 'Sunday' => 'all');
        $week_off_days = json_encode($week_off_days);
        $specific_days_shift_time = array('shift_start_time' => '10:00:00', 'shift_end_time' => '15:30:00');
        $custom_shift_time_for_specific_days = array('Tuesday' => json_encode($specific_days_shift_time));
        $break_timerange_type = 'flexiable';
        $flexible_gross_break = '01:15:00';
        $breaktime_morning = null;
        $breaktime_lunch = null;
        $breaktime_evening = null;
        $halfday_min_workhrs = '04:00:00';
        $fullday_min_workhrs = '08:00:00';
        $response=$vmtAttendanceSettingsService->saveWorkShiftSettings(
            $shift_code,
            $shift_name,
            $is_default,
            $shift_timerange_type,
            $flexible_gross_hours,
            $shift_start_time,
            $shift_end_time,
            $grace_time,
            $week_off_days,
            $custom_shift_time_for_specific_days,
            $break_timerange_type,
            $flexible_gross_break,
            $breaktime_morning,
            $breaktime_lunch,
            $breaktime_evening,
            $halfday_min_workhrs,
            $fullday_min_workhrs
        );
        dd($response);
    }

    public function jsonFormatForDummyWeekOffDays(Request $request, VmtAttendanceSettingsService $vmtAttendanceSettingsService){

            return  $vmtAttendanceSettingsService->jsonFormatForDummyWeekOffDays();
    }
}
