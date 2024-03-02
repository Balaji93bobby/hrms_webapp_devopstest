<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use App\Models\vmtHolidays;
use App\Models\VmtEmployeeAttendance;
use App\Services\VmtAttendanceReportsService;
use App\Models\VmtEmployeeLeaves;
use App\Models\VmtLeaves;
use Illuminate\Support\Facades\Validator;
use App\Models\VmtClientMaster;
use App\Models\Department;
use App\Models\VmtEmpAttIntrTable;
use Exception;

class VmtPayRunService
{
    protected $attendance_report_service;
    public function __construct(VmtAttendanceReportsService $attendance_report_service)
    {
        $this->attendance_report_service = $attendance_report_service;
    }
    public function fetch_attendance_data($start_date, $end_date, $department_id, $client_id, $type, $active_status)
    {
        //  dd($start_date,$end_date);
        ini_set('max_execution_time', 3000);
        $validator = Validator::make(
            $data = [
                'client_id' => $client_id,
                'department_id' => $department_id,
                'start_date' => $start_date,
                'end_date' => $end_date
            ],
            $rules = [
                'client_id' => 'nullable|exists:vmt_client_master,id',
                'department_id' => 'nullable|exists:vmt_department,id',
                'start_date' => 'required',
                'end_date' => 'required'
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
            if (Carbon::parse($end_date)->gt(Carbon::today())) {
                $end_date = Carbon::today()->format('Y-m-d');
            }
            $reportresponse = array();
            $users = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->where('is_ssa', '0')
                ->where('active',  "1")
                ->where('vmt_employee_details.doj', '<', Carbon::parse($end_date));

            if (!empty($client_id)) {
                $users =  $users->whereIn('client_id', $client_id);
            }
            if (!empty($department_id)) {
                $users =  $users->whereIn('vmt_employee_office_details.department_id', $department_id);
            }
            $users =   $users->get(['users.id', 'users.user_code', 'users.name', 'vmt_employee_office_details.designation', 'vmt_employee_details.doj']);
            //  dd($users);

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
            $heading_dates = array("Emp Code", "Name", "Designation", "DOJ");
            $attendance_setting_details =  $this->attendance_report_service->attendanceSettingsinfos(null);
            $reportresponse['rows'] = array();
            $header_date = Carbon::parse($start_date);
            while ($header_date->between(Carbon::parse($start_date), Carbon::parse($end_date))) {
                array_push($heading_dates, $header_date->format('d') . ' - ' .  $header_date->format('l'));
                $header_date->addDay();
            }
            array_push($heading_dates, "Total Weekoff", "Total Holiday", "Total Present", "Total Absent", "Total Late LOP", "Total Leave", "Total Halfday", "Total On Duty");
            if ($attendance_setting_details['lc_status'] == 1) {
                array_push($heading_dates, 'Total LC');
            }
            if ($attendance_setting_details['eg_status'] == 1) {
                array_push($heading_dates, 'Total EG');
            }
            array_push($heading_dates, "Total Payable Days");
            $reportresponse['headers'] = $heading_dates;
            foreach ($users_data as $single_user) {
                $current_date = Carbon::parse($start_date);
                $temp_ar = array();
                $temp_ar['Emp Code'] = $single_user->user_code;
                $temp_ar['Name'] = $single_user->name;
                $temp_ar['Designation'] = $single_user->designation;
                $temp_ar['DOJ'] = $single_user->doj;
                $total_weekoff = 0;
                $total_holiday = 0;
                $total_present = 0;
                $total_absent = 0;
                $total_late_lop = 0;
                $total_leave = 0;
                $total_half_day = 0;
                $total_on_duty = 0;
                $total_LC = 0;
                $total_EG = 0;
                while ($current_date->between(Carbon::parse($start_date), Carbon::parse($end_date))) {
                    $current_day = $current_date->format('d') . ' - ' .  $current_date->format('l');
                    if ($single_user->dol == null && Carbon::parse($single_user->doj)->lte($current_date) || $current_date->between($single_user->doj, Carbon::parse($single_user->dol))) {
                        $att_detail = VmtEmpAttIntrTable::where('user_id', $single_user->id)->whereDate('date', $current_date)->first();
                        if (empty($att_detail)) {
                            continue;
                        }
                        //   dd($temp_ar);
                        //  if( $att_detail==null){
                        //                    dd($current_date,$single_user->id);
                        //  }
                        $status = $att_detail->status;
                        $sts_ar =  explode("/", $status);
                        if ($sts_ar[0] == 'P' || $sts_ar[0] == 'A') {
                            if (count($sts_ar) != 1) {
                                if (in_array('LC', $sts_ar)) {
                                    $total_LC =   $total_LC + 1;
                                }
                                if (in_array('EG', $sts_ar)) {
                                    $total_EG = $total_EG + 1;
                                }
                                // if (in_array('MOP', $sts_ar)) {
                                // }
                                // if (in_array('MIP', $sts_ar)) {
                                // }
                            }
                            if ($sts_ar[0] == 'P') {
                                $total_present = $total_present + 1;
                            } else {
                                $total_absent = $total_absent + 1;
                            }
                        } elseif (
                            $status == 'SL/CL' ||  $status == 'CL/SL' ||  $status == 'LOP LE' ||  $status == 'EL' ||  $status == 'ML' || $status == 'PTL' ||
                            $status == 'OD' || $status == 'PI' || $status == 'CO' || $status == 'CL' || $status == 'SL' || $status == 'FO L'
                        ) {
                            // if($status='leave')
                            // dd($att_detail);
                            if ($status == 'OD') {
                                $total_on_duty = $total_on_duty;
                            } else {
                                $total_leave = $total_leave;
                            }
                            $total_present = $total_present + 1;
                        } else if ($att_detail->status == 'A') {
                            $total_absent = $total_absent + 1;
                        } else if ($att_detail->status == 'HO') {
                            $status = $att_detail->status;
                            $total_holiday = $total_holiday + 1;
                        } else if ($att_detail->status == 'WO') {
                            $status = $att_detail->status;
                            $total_weekoff = $total_weekoff + 1;
                        } else {
                            $staus = '-';
                        }
                        $temp_ar[$current_day] = $status;
                    } else {
                        $temp_ar[$current_day] = 'N';
                    }
                    $current_date->addDay();
                }
                $total_payable_days = ($total_weekoff + $total_holiday + $total_present + $total_leave + $total_half_day + $total_on_duty) - $total_late_lop;
                $temp_ar['Total Weekoff'] = $total_weekoff;
                $temp_ar['Total Holiday'] = $total_holiday;
                $temp_ar['Total Present'] =  $total_present;
                $temp_ar['Total Absent'] = $total_absent;
                $temp_ar['Total Late LOP'] = $total_late_lop;
                $temp_ar['Total Leave'] = $total_leave;
                $temp_ar['Total Halfday'] = $total_half_day;
                $temp_ar['Total On Duty'] = $total_on_duty;
                if ($attendance_setting_details['lc_status'] == 1) {
                    $temp_ar['Total LC'] =  $total_LC;
                }
                if ($attendance_setting_details['eg_status'] == 1) {
                    $temp_ar['Total EG'] =  $total_EG;
                }
                $temp_ar['Total Payable Days'] = $total_payable_days;
                array_push($reportresponse['rows'], $temp_ar);
                // dd($reportresponse);
                unset($temp_ar);
            }
            return $reportresponse;
        } catch (Exception $e) {

            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
                'data' => $e->getTraceAsString(),
            ]);
        }
    }
}
