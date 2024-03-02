<?php

namespace App\Services;

use App\Models\VmtInvFEmpAssigned;
use Illuminate\Http\Request;
use App\Models\VmtEmployeeAttendance;
use App\Models\VmtClientMaster;
use App\Models\User;
use App\Models\VmtEmployeeLeaves;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtLeaves;
use App\Models\VmtAttendanceSettings;
use App\Models\VmtStaffAttendanceDevice;
use App\Models\VmtWorkShifts;
use App\Models\VmtEmployeePayroll;
use App\Models\VmtPayroll;
use App\Models\AbsSalaryProjection;
use App\Models\VmtEmployeeWorkShifts;
use App\Models\VmtEmployeeAttendanceRegularization;
use App\Models\vmtHolidays;
use Illuminate\Support\Facades\Validator;
use App\Models\Department;
use \Datetime;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use DatePeriod;
use DateInterval;
use App\Exports\DetailedAttendanceExport;
use App\Exports\BasicAttendanceExport;
use App\Models\VmtEmpAttConsolidate;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Ramsey\Uuid\Type\Integer;
use Exception;
use App\Models\VmtEmpAttIntrTable;
use Illuminate\Validation\Rule;
use Nette\Utils\Floats;

class VmtAttendanceReportsService
{

    public function isRegularizationRequestApplied($user_id, $date, $regularizeType)
    {
        $regularize_record = VmtEmployeeAttendanceRegularization::where('attendance_date', $date)
            ->where('user_id',  $user_id)->where('regularization_type', $regularizeType);
        if ($regularize_record->exists()) {
            return $regularize_record->value('status');
        } else {
            return 'Not Applied';
        }
    }
    public function canCalculateOt($user_code)
    {
        $ot_ids = array(
            'DM007', 'DM009', 'DM012', 'DM016', 'DM018', 'DM019', 'DM022', 'DM028', 'DM029', 'DM032', 'DM034', 'DM038',
            'DM045', 'DM054', 'DM059', 'DM069', 'DM088', 'DM091', 'DM101', 'DM103', 'DM104', 'DM107', 'DM112', 'DM113', 'DM120', 'DM123',
            'DM124', 'DM125', 'DM127', 'DM128', 'DM134', 'DM140', 'DM145', 'DM146', 'DM148', 'DM149', 'DM150', 'DM151', 'DM153', 'DM156',
            'DM160', 'DM161', 'DM162', 'DM163', 'DM165', 'DM166', 'DM167', 'DM169', 'DM170', 'DM175', 'DM176', 'DM177', 'DM178', 'DM179',
            'DM180', 'DM181', 'DM182', 'DM183', 'DMC069', 'DMC072', 'DMC083', 'DMC084', 'DMC086', 'DMC087', 'DMC089', 'DMC090', 'DMC091',
            'DMC092', 'DMC093', 'DMC094', 'DMC095', 'DMC097', 'DMC101', 'DMC102', 'DMC103', 'DMC104', 'DMC105', 'DMC106', 'DMC107', 'DMC108',
            'DMC110', 'DMC111', 'DMC114', 'DMC115', 'DMC116', 'DMC118', 'DMC119', 'DMC120', 'DMC121', 'DMC123', 'DMC124', 'DMC125', 'DMC126',
            'DMC128', 'DMC129', 'DMC130', 'DMC133', 'DMC136', 'DMC137', 'DMC138', 'DMC139', 'DMC142', 'DMC143', 'DMC144', 'DMC145', 'DMC146',
            'DMC147', 'DMC148', 'DMC149', 'DMC150', 'DMC151', 'DMC152', 'DMC153', 'DMC154', 'DMC155', 'DMC156', 'DMC158', 'DMC159', 'DMC161',
            'DMC162', 'DMC163', 'DMC164', 'DMC165', 'DMC166', 'DMC168', 'DMC169', 'DMC170', 'DMC173', 'DMC174', 'DMC176', 'DMC177',
            'DM192', 'DM194', 'DM195', 'DM196', 'DM197', 'DM198', 'DM199', 'DM200', 'DM201', 'DM202', 'DM203', 'DM205', 'DM207', 'DM208', 'DM209',
            'DM211', 'DM212', 'DM213', 'DM214', 'DM215',
        );
        if (sessionGetSelectedClientCode() == "DM" || sessionGetSelectedClientCode() == "DMC") {
            if (in_array($user_code,  $ot_ids)) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function findMIPOrMOP($time, $shiftStartTime, $shiftEndTime)
    {
        $response = array();
        $shift_start_time = $shiftStartTime->subHours(1)->format('Y-m-d H:i:0');
        $first_half_end_time =  $shiftStartTime->addHours(5);

        if (Carbon::parse($time)->between(Carbon::parse($shift_start_time), $first_half_end_time, true)) {
            $response['checkin_time'] = $time;
            $response['checkout_time'] = null;
        } else {
            $response['checkin_time'] = null;
            $response['checkout_time'] = $time;
        }
        return $response;
    }

    public function RegularizationRequestStatus($user_id, $date, $regularizeType)
    {
        $regularize_record = VmtEmployeeAttendanceRegularization::where('attendance_date', $date)
            ->where('user_id',  $user_id)->where('regularization_type', $regularizeType);
        $reg_sts = array();
        $reg_sts['sts'] = 'Not Applied';
        $reg_sts['time'] = null;
        $reg_sts['id'] = null;
        if ($regularize_record->exists()) {
            $reg_sts['sts'] = $regularize_record->first()->status;
            $reg_sts['time'] = $regularize_record->first()->regularize_time;
            $reg_sts['id'] = $regularize_record->first()->id;
            return $reg_sts;
        } else {
            return  $reg_sts;
        }
    }

    public function getShiftTimeForEmployee($user_id, $checkin_time, $checkout_time)
    {

        $emp_work_shift = VmtEmployeeWorkShifts::where('user_id', $user_id)->where('is_active', '1')->get();

        if (count($emp_work_shift) == 1) {
            $regularTime  = VmtWorkShifts::where('id', $emp_work_shift->first()->work_shift_id)->first();
            return  $regularTime;
        } else if (count($emp_work_shift) > 1) {
            //dd($emp_work_shift);
            for ($i = 0; $i < count($emp_work_shift); $i++) {
                $regularTime  = VmtWorkShifts::where('id', $emp_work_shift[$i]->work_shift_id)->first();
                $shift_start_time = Carbon::parse($regularTime->shift_start_time)->addMinutes($regularTime->grace_time);
                $shift_end_time = Carbon::parse($regularTime->shift_end_time);
                $diffInMinutesInCheckinTime = $shift_start_time->diffInMinutes(Carbon::parse($checkin_time), false);
                $diffInMinutesInCheckOutTime =   $shift_end_time->diffInMinutes(Carbon::parse($checkout_time), false);
                // if ($user_id == '192' && $checkin_time == "13:56:01");
                // dd($diffInMinutesInCheckinTime);
                if ($checkin_time == null && $checkout_time == null) {
                    return  $regularTime;
                } else  if ($diffInMinutesInCheckinTime > -65 &&    $diffInMinutesInCheckinTime < 275) {
                    return  $regularTime;
                } else if ($diffInMinutesInCheckOutTime > -65 &&  $diffInMinutesInCheckOutTime < 65) {
                    return  $regularTime;
                }
                if ($i == count($emp_work_shift) - 1) {
                    return  $regularTime;
                }
            }
        }
    }



    public function checkWeekOffStatus($date, $weekOffJson, $checkin_time, $checkout_time)
    {
        $days_for_per_week = array('Sunday' => 0, 'Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6);
        $date =  Carbon::parse($date);
        $given_date_day = $date->format('l');
        $day_in_number = number_format($date->format('d'));

        $weekOffJson = json_decode($weekOffJson, true);
        if ($weekOffJson[$days_for_per_week[$given_date_day]]['all_week'] == 1) {

            return   $checkin_time == null && $checkout_time == null ? true : false;
        } else {
            //logic for nth week of day week off
            $week_of_month = (int)(ceil($day_in_number / 7));
            $week_of_month_in_string = 'week_' . $week_of_month;
            if ($weekOffJson[$days_for_per_week[$given_date_day]][$week_of_month_in_string] == 1) {
                return   $checkin_time == null && $checkout_time == null ? true : false;
            } else {
                return false;
            }
        }
    }
    public function attendanceSettingsinfos($work_shift_id)
    {
        $lc_enable = false;
        $eg_enable = false;
        $lop_status_settings = array();
        if ($work_shift_id == null) {
            $all_work_shift = VmtWorkShifts::all();
            foreach ($all_work_shift as $single_shift) {
                if ($single_shift->is_lc_applicable == 1) {
                    $lc_enable = true;
                }
                if ($single_shift->is_eg_applicable == 1) {
                    $eg_enable = true;
                }
            }
            $lop_status_settings['lc_status'] = $lc_enable;
            $lop_status_settings['eg_status'] = $eg_enable;
            return  $lop_status_settings;
        } else {
            $work_shift = VmtWorkShifts::where('id', $work_shift_id)->first();
            if ($work_shift->is_lc_applicable == 1) {
                $lc_enable = true;
            }
            if ($work_shift->is_eg_applicable == 1) {
                $eg_enable = true;
            }

            $lop_status_settings['lc_status'] = $lc_enable;
            $lop_status_settings['eg_status'] = $eg_enable;
            return  $lop_status_settings;
        }
    }

    public function basicAttendanceReport($start_date,  $end_date, $department_id, $client_id)
    {
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
                ->leftJoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->where('is_ssa', '0')
                ->where('active',  "1")
                ->where('vmt_employee_details.doj', '<', Carbon::parse($end_date));

            if (!empty($client_id)) {
                $users =  $users->whereIn('client_id', $client_id);
            }
            if (!empty($department_id)) {
                $users =  $users->whereIn('vmt_employee_office_details.department_id', $department_id);
            }
            $users = $users->get([
                'users.id as id',
                'users.user_code as user_code',
                'users.name as name',
                'vmt_employee_office_details.designation as designation',
                'vmt_employee_details.dob as dob',
                'vmt_employee_details.doj as doj',
                'vmt_employee_details.dol as dol'
            ]);

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
            $attendance_setting_details = $this->attendanceSettingsinfos(null);
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
            $reportresponse['headings'] = $heading_dates;
            foreach ($users_data as $single_user) {
                $current_date = Carbon::parse($start_date);
                $temp_ar = array();
                array_push($temp_ar, $single_user->user_code, $single_user->name, $single_user->designation, Carbon::parse($single_user->doj)->format('d-M-Y'));
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
                $total_lc_lop = 0;
                $total_eg_lop = 0;
                while ($current_date->between(Carbon::parse($start_date), Carbon::parse($end_date))) {
                    if ($single_user->dol == null && Carbon::parse($single_user->doj)->lte($current_date) || $current_date->between($single_user->doj, Carbon::parse($single_user->dol))) {
                        if (!VmtEmpAttIntrTable::where('user_id', $single_user->id)->whereDate('date', $current_date)->exists()) {
                            dd($single_user, $current_date);
                        }
                        $att_detail = VmtEmpAttIntrTable::where('user_id', $single_user->id)->whereDate('date', $current_date)->first();
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
                            if (in_array('HD', $sts_ar)) {
                                $total_present = $total_present + 0.5;
                                $total_absent = $total_absent + 0.5;
                            } else if ($sts_ar[0] == 'P') {
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
                        array_push($temp_ar, $status);
                    } else {
                        array_push($temp_ar, 'N');
                    }
                    $current_date->addDay();
                }
                $work_shift = VmtWorkShifts::where('id', $att_detail->vmt_employee_workshift_id)->first();
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
                $total_payable_days = ($total_weekoff + $total_holiday + $total_present + $total_leave + $total_half_day + $total_on_duty) - $total_late_lop;
                array_push($temp_ar, $total_weekoff, $total_holiday, $total_present, $total_absent, $total_late_lop, $total_leave, $total_half_day, $total_on_duty);
                if ($attendance_setting_details['lc_status'] == 1) {
                    array_push($temp_ar, $total_LC);
                }
                if ($attendance_setting_details['eg_status'] == 1) {
                    array_push($temp_ar,  $total_EG);
                }
                array_push($temp_ar, $total_payable_days);
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

    public function shiftTimeForEmployee($start_date, $end_date, $client_domain)
    {
        ini_set('max_execution_time', 3000);
        //dd($month);
        $reportresponse = array();
        $user = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
            ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
            ->where('is_ssa', '0')
            ->where('active', '1')
            ->where('vmt_employee_details.doj', '<', Carbon::parse($end_date));

        if (sessionGetSelectedClientid() != 1) {
            $user = $user->where('client_id', sessionGetSelectedClientid());
        }
        $user =  $user->get(['users.id', 'users.user_code', 'users.name', 'vmt_employee_office_details.designation', 'vmt_employee_details.doj']);
        $holidays = vmtHolidays::whereBetween('holiday_date', [$start_date, $end_date])->pluck('holiday_date');
        foreach ($user as $singleUser) {

            $total_present = 0;
            $total_absent = 0;
            $total_weekoff = 0;
            $total_holidays = 0;
            $total_leave = 0;
            $total_halfday = 0;
            $total_OD = 0;
            $total_LC = 0;
            $total_EG = 0;
            $total_lop = 0;

            $arrayReport = array($singleUser->user_code, $singleUser->name, $singleUser->designation, $singleUser->doj);

            $firstDateStr = $start_date;
            $lastAttendanceDate = Carbon::parse($end_date);
            $totalDays =  $lastAttendanceDate->diffInDays(Carbon::parse($firstDateStr));
            $deviceData = [];
            for ($i = 0; $i < ($totalDays); $i++) {
                // code...

                $dayStr = Carbon::parse($firstDateStr)->addDay($i)->format('l');


                $dateString  = Carbon::parse($firstDateStr)->addDay($i)->format('Y-m-d');
                //dd($dateString);


                if (
                    sessionGetSelectedClientCode() == "DM" || sessionGetSelectedClientCode() == 'VASA GROUPS' || sessionGetSelectedClientCode() == 'LAL'
                    || sessionGetSelectedClientCode() == 'PSC' || sessionGetSelectedClientCode() ==  'IMA' || sessionGetSelectedClientCode() ==  'PA' || sessionGetSelectedClientCode() ==  'DMC'
                ) {
                    $attendanceCheckOut = \DB::table('vmt_staff_attenndance_device')
                        ->select('user_Id', \DB::raw('MAX(date) as check_out_time'))
                        ->whereDate('date', $dateString)
                        ->where('user_Id', $singleUser->user_code)
                        ->first(['check_out_time']);

                    $attendanceCheckIn = \DB::table('vmt_staff_attenndance_device')
                        ->select('user_Id', \DB::raw('MIN(date) as check_in_time'))
                        ->whereDate('date', $dateString)
                        ->where('user_Id',  $singleUser->user_code)
                        ->first(['check_in_time']);
                } else {
                    $attendanceCheckOut = \DB::table('vmt_staff_attenndance_device')
                        ->select('user_Id', \DB::raw('MAX(date) as check_out_time'))
                        ->whereDate('date', $dateString)
                        ->where('direction', 'out')
                        ->where('user_Id', $singleUser->user_code)
                        ->first(['check_out_time']);

                    $attendanceCheckIn = \DB::table('vmt_staff_attenndance_device')
                        ->select('user_Id', \DB::raw('MIN(date) as check_in_time'))
                        ->whereDate('date', $dateString)
                        ->where('direction', 'in')
                        ->where('user_Id', $singleUser->user_code)
                        ->first(['check_in_time']);
                }
                //dd($attendanceCheckIn);

                $deviceCheckOutTime = empty($attendanceCheckOut->check_out_time) ? null : explode(' ', $attendanceCheckOut->check_out_time)[1];
                $deviceCheckInTime  = empty($attendanceCheckIn->check_in_time) ? null : explode(' ', $attendanceCheckIn->check_in_time)[1];
                //    dd($deviceCheckOutTime.'-----------'.$deviceCheckInTime);
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



            // attendance details from vmt_employee_attenndance table
            $attendance_WebMobile = VmtEmployeeAttendance::
                // where('user_id', $request->user_id)
                where('user_id', $singleUser->id)
                //->whereMonth('date', $request->month)
                ->whereBetween('date', [$start_date, $end_date])
                ->orderBy('checkin_time', 'asc')
                ->get(['date', 'checkin_time', 'checkout_time', 'attendance_mode_checkin', 'attendance_mode_checkout']);

            // dd($attendance_WebMobile);


            $attendanceResponseArray = [];

            //Create empty month array with all dates.
            // $month = $request->month;


            //$days_count = cal_days_in_month(CAL_GREGORIAN,$month,$year);
            //dd($totalDays );
            //For Excel Sheet Headers
            $heading_dates = array("Emp Code", "Name", "Designation", "DOJ");
            for ($i = 0; $i <= $totalDays; $i++) {
                $fulldate = Carbon::parse($firstDateStr)->addDay($i)->format('Y-m-d');
                $date = Carbon::parse($firstDateStr)->addDay($i)->format('d');

                $date_day = $date . ' - ' . Carbon::parse($fulldate)->format('l');
                array_push($heading_dates, $date_day);

                $attendanceResponseArray[$fulldate] = array(
                    //"user_id"=>$request->user_id,
                    "user_id" => $singleUser->id, "DOJ" => $singleUser->doj, "isAbsent" => false, "isLeave" => false,
                    "is_weekoff" => false, "isLC" => null, "isEG" => null, "date" => $fulldate, "is_holiday" => false,
                    "attendance_mode_checkin" => null, "attendance_mode_checkout" => null, "absent_status" => false,
                    "checkin_time" => null, "checkout_time" => null, "leave_type" => null, "half_day_status" => null, "half_day_type" => null
                );

                //echo "Date is ".$fulldate."\n";
                ///$month_array[""]
            }

            // dd($attendanceResponseArray);

            array_push($heading_dates, "Total Weekoff", "Total Holiday", "Total Present", "Total Absent", "Total Late LOP", "Total Leave", "Total Halfday", "Total On Duty");

            $attendance_setting_details = $this->attendanceSettingsinfos(null);

            if ($attendance_setting_details['lc_status'] == 1) {
                array_push($heading_dates, 'Total LC');
            }
            if ($attendance_setting_details['eg_status'] == 1) {
                array_push($heading_dates, 'Total EG');
            }
            array_push($heading_dates, "Total Payable Days");





            // merging result from both table
            //dd($attendance_WebMobile->toArray());
            //dd($deviceData);
            $merged_attendanceData  = array_merge($deviceData, $attendance_WebMobile->toArray());

            $dateCollectionObj    =  collect($merged_attendanceData);
            $sortedCollection   =   $dateCollectionObj->sortBy([
                ['date', 'asc'],
            ]);

            $dateWiseData         =  $sortedCollection->groupBy('date'); //->all();
            //dd($merged_attendanceData);
            //dd($dateWiseData);
            // dd($attendanceResponseArray);
            foreach ($dateWiseData  as $key => $value) {
                //dd($key);
                //dd($value[0]);

                /*
                     Here $key is the date. i.e : 2022-10-01

                     $value is ::

                         [
                             date=>2022-11-05
                             checkin_time=18:06:00
                             checkout_time=18:06:00
                             attendance_mode="web"
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
                    //Find the min of checkin
                    //dd($singleValue);

                    if ($checkin_min == null) {
                        $checkin_min = $singleValue["checkin_time"];

                        $attendance_mode_checkin = $singleValue["attendance_mode_checkin"];
                    } else
                     if ($checkin_min > $singleValue["checkin_time"]) {
                        $checkin_min = $singleValue["checkin_time"];
                        $attendance_mode_checkin = $singleValue["attendance_mode_checkin"];
                    }

                    //dd("Min value found : " . $singleValue["checkin_time"]);

                    //Find the max of checkin
                    if ($checkout_max == null) {
                        $checkout_max = $singleValue["checkout_time"];
                        $attendance_mode_checkout = $singleValue["attendance_mode_checkout"];
                    } else
                     if ($checkout_max < $singleValue["checkout_time"]) {
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
            }

            // dd($attendanceResponseArray );
            foreach ($attendanceResponseArray as $key => $value) {

                //get Shift Time for day

                $shift_settings = $this->getShiftTimeForEmployee($singleUser->id, $value['checkin_time'], $value['checkout_time']);
                $shiftStartTime  = Carbon::parse($shift_settings->shift_start_time);
                $shiftEndTime  = Carbon::parse($shift_settings->shift_end_time);
                $weekOffDays =  $shift_settings->week_off_days;


                if ($attendanceResponseArray[$key]['checkin_time'] != null && $attendanceResponseArray[$key]['checkout_time'] != null && $attendanceResponseArray[$key]['checkout_time'] == $attendanceResponseArray[$key]['checkin_time']) {
                    $attendance_time = $this->findMIPOrMOP($attendanceResponseArray[$key]['checkin_time'], $shiftStartTime, $shiftEndTime);

                    $attendanceResponseArray[$key]['checkin_time'] = $attendance_time['checkin_time'];
                    $attendanceResponseArray[$key]['checkout_time'] = $attendance_time['checkout_time'];
                }



                //Logic For Check week off or not

                if (!array_key_exists('date', $attendanceResponseArray[$key]))
                    dd("Missing for : " . $key);

                // if (
                //     Carbon::parse($attendanceResponseArray[$key]['date'])->format('l') == "Sunday"
                //     && $attendanceResponseArray[$key]['checkin_time'] == null &&
                //     $attendanceResponseArray[$key]["checkout_time"] == null
                // ) {
                //     $attendanceResponseArray[$key]['is_weekoff'] = true;
                // }
                $attendanceResponseArray[$key]['is_weekoff'] = $this->checkWeekOffStatus($attendanceResponseArray[$key]['date'], $weekOffDays, $attendanceResponseArray[$key]['checkin_time'], $attendanceResponseArray[$key]["checkout_time"]);

                //Logic For Check Holiday Or Not
                foreach ($holidays as $holiday) {
                    if (
                        Carbon::parse($holiday)->eq(Carbon::parse($attendanceResponseArray[$key]['date']))
                        && $attendanceResponseArray[$key]['checkin_time'] == null &&
                        $attendanceResponseArray[$key]["checkout_time"] == null &&
                        !$attendanceResponseArray[$key]['is_weekoff']
                    ) {
                        $attendanceResponseArray[$key]['is_holiday'] = true;
                    }
                }

                //Logic For Check Leave,Half day, Absent
                //dd($attendanceResponseArray[$key]['user_id']);
                if (
                    $attendanceResponseArray[$key]['checkin_time'] == null &&
                    $attendanceResponseArray[$key]["checkout_time"] == null &&
                    $attendanceResponseArray[$key]['is_weekoff'] == false
                ) {

                    $leave_Details = VmtEmployeeLeaves::where('user_id', $attendanceResponseArray[$key]['user_id']);

                    if (empty($leave_Details)) {
                        $leave_Details =   $leave_Details->get(['start_date', 'end_date', 'status', 'leave_type_id', 'total_leave_datetime']);
                    } else {
                        $leave_Details =   $leave_Details->WhereBetween('start_date', [$start_date, $end_date]);
                        $leave_Details =   $leave_Details->WhereBetween('end_date', [$start_date, $end_date])
                            ->get(['start_date', 'end_date', 'status', 'leave_type_id', 'total_leave_datetime']);
                        // if ($key == '2023-08-12')
                        // dd($leave_Details);
                    }
                    if ($leave_Details->count() == 0) {
                        // dd( $leave_Details->count());
                        $attendanceResponseArray[$key]['isAbsent'] = true;
                    } else {
                        foreach ($leave_Details as $single_leave_details) {
                            $startDate = Carbon::parse($single_leave_details->start_date)->subDays(1);
                            $endDate = Carbon::parse($single_leave_details->end_date);
                            $currentDate =  Carbon::parse($attendanceResponseArray[$key]['date']);
                            //   dd($startDate.'-----'.$currentDate.'-----');
                            if ($currentDate->gt($startDate) && $currentDate->lte($endDate)) {
                                if (substr($single_leave_details->total_leave_datetime, -1) == 'N') {
                                    // Logic Get FN or AN Value From total Leave date time
                                    $attendanceResponseArray[$key]['half_day_type'] = preg_replace("/([^a-zA-Z]+)/i", "",  $single_leave_details->total_leave_datetime);
                                    $attendanceResponseArray[$key]['half_day_status'] = $single_leave_details->status;
                                } else if (
                                    $attendanceResponseArray[$key]['checkin_time'] == null &&
                                    $attendanceResponseArray[$key]["checkout_time"] == null &&
                                    $single_leave_details->status == 'Approved'
                                ) {
                                    $attendanceResponseArray[$key]['isLeave'] = true;
                                    $leave_type = VmtLeaves::where('id', $single_leave_details->leave_type_id)
                                        ->pluck('leave_type');
                                    //  dd( $leave_type[0]);
                                    if ($leave_type[0] == 'Sick Leave / Casual Leave') {
                                        $attendanceResponseArray[$key]['leave_type'] = 'SL/CL';
                                    } else if ($leave_type[0] == 'Casual/Sick Leave') {
                                        $attendanceResponseArray[$key]['leave_type'] = 'CL/SL';
                                    } else if ($leave_type[0] == 'LOP Leave') {
                                        $attendanceResponseArray[$key]['leave_type'] = 'LOP LE';
                                    } else if ($leave_type[0] == 'Earned Leave') {
                                        $attendanceResponseArray[$key]['leave_type'] = 'EL';
                                    } else if ($leave_type[0] == 'Maternity Leave') {
                                        $attendanceResponseArray[$key]['leave_type'] = 'ML';
                                    } else if ($leave_type[0] == 'Paternity Leave') {
                                        $attendanceResponseArray[$key]['leave_type'] = 'PTL';
                                    } else if ($leave_type[0] == 'On Duty') {
                                        $attendanceResponseArray[$key]['leave_type'] = 'OD';
                                    } else if ($leave_type[0] == 'Permission') {
                                        $attendanceResponseArray[$key]['leave_type'] = "PI";
                                    } else if ($leave_type[0] == 'Compensatory Off') {
                                        $attendanceResponseArray[$key]['leave_type'] = 'CO';
                                    } else if ($leave_type[0] == 'Casual Leave') {
                                        $attendanceResponseArray[$key]['leave_type'] = 'CL';
                                    } else if ($leave_type[0] == 'Sick Leave') {
                                        $attendanceResponseArray[$key]['leave_type'] = 'SL';
                                    } else if ($leave_type[0] == 'Compensatory Leave') {
                                        $attendanceResponseArray[$key]['leave_type'] = 'CO';
                                    } else if ($leave_type[0] == 'Flexi day-off Leave') {
                                        $attendanceResponseArray[$key]['leave_type'] = 'FO L';
                                    }
                                    continue;
                                } else {
                                    $attendanceResponseArray[$key]['isAbsent'] = true;
                                    continue;
                                }
                            } else {
                                $attendanceResponseArray[$key]['isAbsent'] = true;
                                continue;
                            }
                        }
                    }
                }

                $checkin_time = $attendanceResponseArray[$key]["checkin_time"];
                $checkout_time = $attendanceResponseArray[$key]["checkout_time"];

                //Code For Check LC
                if (!empty($checkin_time)) {
                    $parsedCheckIn_time  = Carbon::parse($checkin_time);
                    //Check whether checkin done on-time
                    $isCheckin_done_ontime = $parsedCheckIn_time->lte($shiftStartTime);
                    if ($isCheckin_done_ontime) {
                        //employee came on time....
                    } else {
                        //dd("Checkin NOT on-time");
                        //check whether regularization applied.
                        $user_id = $attendanceResponseArray[$key]['user_id'];
                        $date = $attendanceResponseArray[$key]['date'];
                        $regularization_status = $this->isRegularizationRequestApplied($user_id, $date, 'LC');
                        $attendanceResponseArray[$key]["isLC"] = $regularization_status;
                    }
                }
                //Code For Check EG
                if (!empty($checkout_time)) {
                    $parsedCheckOut_time  = Carbon::parse($checkout_time);
                    //Check whether checkin out on-time
                    $isCheckout_done_ontime = $parsedCheckOut_time->lte($shiftEndTime);
                    if ($isCheckout_done_ontime) {
                        //employee left early on time....
                        $user_id = $attendanceResponseArray[$key]['user_id'];
                        $date = $attendanceResponseArray[$key]['date'];
                        $regularization_status = $this->isRegularizationRequestApplied($user_id, $date, 'EG');
                        $attendanceResponseArray[$key]["isEG"] = $regularization_status;
                    } else {
                        //employee left late....
                    }
                }
            }


            foreach ($attendanceResponseArray as $key => $value) {
                $current_date = Carbon::parse($attendanceResponseArray[$key]['date']);
                $doj = Carbon::parse($attendanceResponseArray[$key]['DOJ']->format('d-m-Y'));

                if ($doj->gt($current_date)) {
                    array_push($arrayReport, 'N');
                } else if ($attendanceResponseArray[$key]['is_weekoff']) {
                    array_push($arrayReport, 'WO');
                    $total_weekoff++;
                } else if ($attendanceResponseArray[$key]['is_holiday']) {
                    array_push($arrayReport, 'HO');
                    $total_holidays++;
                } else if (
                    $attendanceResponseArray[$key]['isAbsent'] && !$attendanceResponseArray[$key]['isLeave']
                    && !$attendanceResponseArray[$key]['is_holiday'] && $attendanceResponseArray[$key]['half_day_status'] == null
                ) {
                    array_push($arrayReport, 'A');
                    $total_absent++;
                } else if ($attendanceResponseArray[$key]['half_day_status'] == 'Approved') {
                    if ($attendanceResponseArray[$key]['half_day_type'] == 'FN') {
                        array_push($arrayReport, 'HD/P');
                    } else if ($attendanceResponseArray[$key]['half_day_type'] == 'AN') {
                        array_push($arrayReport, 'P/HD');
                    }
                    $total_present = $total_present + 0.5;
                    $total_halfday = $total_halfday + 0.5;
                } else if ($attendanceResponseArray[$key]['half_day_status'] == 'Pending' || $attendanceResponseArray[$key]['half_day_status'] == 'Rejected') {
                    if ($attendanceResponseArray[$key]['half_day_type'] == 'AN') {
                        array_push($arrayReport, 'A/P');
                    } else if ($attendanceResponseArray[$key]['half_day_type'] == 'FN') {
                        array_push($arrayReport, 'P/A');
                    }
                    $total_present = $total_present + 0.5;
                    $total_absent = $total_absent + 0.5;
                } else if ($attendanceResponseArray[$key]['isLeave']) {
                    // dd($attendanceResponseArray[$key]);
                    if ($attendanceResponseArray[$key]['leave_type'] == 'OD') {
                        array_push($arrayReport, $attendanceResponseArray[$key]['leave_type']);
                        $total_OD++;
                    } else {
                        array_push($arrayReport, $attendanceResponseArray[$key]['leave_type']);
                        $total_leave++;
                    }
                } else if ($attendanceResponseArray[$key]['checkin_time'] != null || $attendanceResponseArray[$key]['checkout_time'] != null) {


                    if ($shift_settings->is_lc_applicable == 1 ||  $shift_settings->is_eg_applicable == 1) {
                        $lc_eg_day_att = 'P';
                        if ($attendanceResponseArray[$key]['isLC'] == 'Rejected' || $attendanceResponseArray[$key]['isLC'] == 'Not Applied') {
                            if ($shift_settings->is_lc_applicable == 1) {
                                $lc_eg_day_att = $lc_eg_day_att . '/LC';
                                if ($total_LC >= $shift_settings->lc_limit_permonth && $shift_settings->lc_limit_permonth != null) {
                                    $total_lop =  $total_lop + $shift_settings->lc_exceed_lop_day;
                                }
                            }
                        }
                        if ($attendanceResponseArray[$key]['isEG'] == 'Rejected' || $attendanceResponseArray[$key]['isEG'] == 'Not Applied') {
                            if ($shift_settings->is_eg_applicable == 1) {
                                $lc_eg_day_att = $lc_eg_day_att . '/EG';
                                if ($total_EG >= $shift_settings->eg_limit_permonth && $shift_settings->eg_limit_permonth != null) {
                                    $total_lop =  $total_lop + $shift_settings->lc_exceed_lop_day;
                                }
                            }
                        }
                        array_push($arrayReport,  $lc_eg_day_att);
                        $total_present++;
                    } else {
                        array_push($arrayReport, 'P');
                        $total_present++;
                    }


                    //Count For LG AND EG
                    if ($attendanceResponseArray[$key]['isLC'] != null) {
                        $total_LC++;
                    }

                    if ($attendanceResponseArray[$key]['isEG'] != null) {
                        $total_EG++;
                    }
                } else {
                    array_push($arrayReport, ' ');
                }
            }

            array_push($arrayReport, $total_weekoff, $total_holidays, $total_present, $total_absent, $total_lop, $total_leave, $total_halfday, $total_OD,);
            if ($attendance_setting_details['lc_status'] == 1) {
                array_push($arrayReport, $total_LC);
            }
            if ($attendance_setting_details['eg_status'] == 1) {
                array_push($arrayReport, $total_EG);
            }
            $total_payable_days = ($total_weekoff + $total_holidays + $total_present + $total_leave + $total_halfday + $total_OD) - $total_lop;
            array_push($arrayReport,  $total_payable_days);
            array_push($reportresponse, $arrayReport);
            unset($arrayReport);
        }


        $data = array($heading_dates, $reportresponse);
        return $data;
    }

    public function detailedAttendanceReport($start_date, $end_date, $department_id, $client_id)
    {
        set_time_limit(3000);
        // dd(ini_get('max_execution_time'));
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

            $current_date = Carbon::parse($start_date);
            if (Carbon::parse($end_date)->gt(Carbon::today())) {
                $end_date = Carbon::today()->format('Y-m-d');
            }
            //dd($start_date,$end_date,Carbon::parse($end_date));
            $users = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                ->leftjoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->where('vmt_employee_details.doj', '<=', Carbon::parse($end_date))
                ->where('is_ssa', '0')
                ->where('active', '1')->when(!empty($client_id), function ($query) use ($client_id) {
                    return $query->whereIn('client_id', $client_id);
                })
                ->when(!empty($department_id), function ($query) use ($department_id) {
                    return $query->whereIn('vmt_employee_office_details.department_id', $department_id);
                })->get([
                    'users.id as id',
                    'users.user_code as user_code',
                    'users.name as name',
                    'vmt_employee_office_details.designation as designation',
                    'vmt_employee_details.dob as dob',
                    'vmt_employee_details.doj as doj',
                    'vmt_employee_details.dol as dol'
                ]);

            $users_data = array();
            foreach ($users as $key => $single_user) {

                if ($single_user->dol === null || $single_user->dol > $start_date) {
                    $users_data[$key] = $single_user;
                }
            }

            $heading_dates = array("Emp Code", "Name", "Designation", "DOJ");
            $header_2 = array('', '', '', '');
            $attendance_setting_details = $this->attendanceSettingsinfos(null);
            $response['rows'] = array();
            $header_date = Carbon::parse($start_date);
            $heading_dates_2 = array();
            while ($header_date->between(Carbon::parse($start_date), Carbon::parse($end_date))) {
                array_push($heading_dates, $header_date->format('d') . ' - ' .  $header_date->format('l'));
                array_push($heading_dates_2, $header_date->format('d') . ' - ' .  $header_date->format('l'));
                $header_date->addDay();
                array_push($header_2, 'InPunch', 'OutPunch', 'OT');
                if ($attendance_setting_details['lc_status'] == 1) {
                    array_push($header_2, 'LC Minutes', 'Status');
                } else {
                    array_push($header_2, 'Status');
                }
            }
            //dd(count($users_data));
            foreach ($users_data as $single_user) {

                $current_date = Carbon::parse($start_date);
                $temp_ar = array();
                array_push($temp_ar, $single_user->user_code, $single_user->name, $single_user->designation, Carbon::parse($single_user->doj)->format('d-M-Y'));
                $total_LC_mins = 0;
                $total_ot_min = 0;
                $total_ot_words = 0;
                $total_ot_hours = 0;
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
                $total_lop_days = 0;
                $total_lc_lop = 0;
                $total_eg_lop = 0;
                while ($current_date->between(Carbon::parse($start_date), Carbon::parse($end_date))) {

                    $currentDate = $current_date->format('Y-m-d');
                    $userDoj = Carbon::parse($single_user->doj)->format('Y-m-d');
                    if ($single_user->dol === null || ($userDoj <= $currentDate && $currentDate <= $single_user->dol)) {
                        $checkin_time = '-';
                        $checkout_time = '-';
                        $current_ot = '-';
                        $lc_mins = '-';
                        if (!VmtEmpAttIntrTable::where('user_id', $single_user->id)->whereDate('date', $current_date)->exists()) {
                            if ($attendance_setting_details['lc_status'] == 1) {
                                array_push($temp_ar, $checkin_time, $checkout_time, $current_ot, $lc_mins, 'N');
                            } else {
                                array_push($temp_ar, $checkin_time, $checkout_time, $current_ot, 'N');
                            }
                        } else {
                            $att_detail = VmtEmpAttIntrTable::where('user_id', $single_user->id)->whereDate('date', $current_date)->first();
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
                                if (in_array('HD', $sts_ar)) {
                                    $total_absent = $total_absent + 0.5;
                                    $total_present = $total_present + 0.5;
                                } else if ($sts_ar[0] == 'P') {
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
                                $total_holiday = $total_holiday + 1;
                            } else if ($att_detail->status == 'WO') {
                                $total_weekoff = $total_weekoff + 1;
                            }
                            if ($att_detail->regularized_checkin_time != null) {
                                $checkin_time = $att_detail->regularized_checkin_time;
                            } else if ($att_detail->checkin_time != null) {
                                $checkin_time = $att_detail->checkin_time;
                            }

                            if ($att_detail->regularized_checkout_time != null) {
                                $checkout_time = $att_detail->regularized_checkout_time;
                            } else if ($att_detail->checkout_time != null) {
                                $checkout_time = $att_detail->checkout_time;
                            }
                            if ($att_detail->lc_minutes != 0) {
                                $lc_mins = $att_detail->lc_minutes;
                            }




                            // For Calculating ot

                            $ot_ar = CarbonInterval::minutes($att_detail->overtime)->cascade();
                            $ot_hrs = (int) $ot_ar->totalHours;
                            $ot_mins = $ot_ar->toArray()['minutes'];
                            $current_ot =    $ot_hrs . ' Hrs:' .  $ot_mins . ' Minutes';
                            $total_ot_min = $total_ot_min + $att_detail->overtime;

                            if ($attendance_setting_details['lc_status'] == 1) {
                                array_push($temp_ar, $checkin_time, $checkout_time, $current_ot, $lc_mins, $att_detail->status);
                            } else {
                                array_push($temp_ar, $checkin_time, $checkout_time, $current_ot, $att_detail->status);
                            }
                        }
                        // if ($single_user->id == 300 && $current_date->format('Y-m-d') == '2023-10-13') {
                        //     dd($temp_ar);
                        // }
                    } else {
                        array_push($temp_ar, 0, 0, 0);
                        if ($attendance_setting_details['lc_status'] == 1) {
                            array_push($temp_ar, '0 Minutes');
                        }
                        array_push($temp_ar, 'N');
                    }
                    $current_date->addDay();
                }
                $work_shift = VmtWorkShifts::where('id', $att_detail->vmt_employee_workshift_id)->first();

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

                $total_payable_days = ($total_weekoff + $total_holiday + $total_present + $total_leave + $total_half_day) - $total_late_lop;
                if ($total_ot_min > 0) {
                    $total_ot_words =  CarbonInterval::minutes($total_ot_min)->cascade()->forHumans();
                    $total_ot_hours = intdiv($total_ot_min, 60) . '.' . ($total_ot_min % 60);
                }
                array_push($temp_ar, $total_weekoff, $total_holiday,  $total_ot_words, $total_ot_hours, $total_ot_min, $total_present, $total_absent, $total_late_lop, $total_leave, $total_half_day, $total_on_duty, $total_LC, $total_EG, $total_payable_days);
                array_push($response['rows'], $temp_ar);
                unset($temp_ar);
            }
            //dd($response ['rows']);
            array_push($heading_dates, 'Total Calculation');
            array_push($header_2, "Total Weekoff", "Total Holiday", "Total Over Time", "Total Over Time Hours", "Total Over Time Minutes", "Total Present", "Total Absent", "Total Late LOP", "Total Leave", "Total Halfday", "Total On Duty", 'Total LC', 'Total EG', 'Total Payable Days');
            $response['heading_dates'] = $heading_dates;
            $response['header_2'] = $header_2;
            $response['heading_dates_2'] = $heading_dates_2;
            // dd($response);
            return $response;
        } catch (Exception $e) {

            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
                'data' => $e->getTraceAsString(),
            ]);
        }
    }


    public function fetch_attendance_data($start_date, $end_date, $department_id, $client_id, $type, $active_status)
    {
        try {
            if (empty($client_id)) {
                $client_id = VmtClientMaster::pluck('id')->toArray();
            } else {
                $client_id =  $client_id;
            }
            // dd($client_id);

            if (empty($active_status)) {
                $active_status = ['1', '0', '-1'];
            } else {
                $active_status = $active_status;
            }
            if (empty($date_req)) {
                $date_req = Carbon::now()->format('Y-m-d');
            }


            ini_set('max_execution_time', 3000);
            $reportresponse = array();
            $user = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->whereIn('users.client_id', $client_id)
                ->whereIn('users.active', $active_status)
                ->whereDate('vmt_employee_details.doj', '<', $end_date);


            // if (sessionGetSelectedClientid() != 1) {
            //     $user = $user->where('client_id', sessionGetSelectedClientid());
            // }
            if (!empty($department_id)) {
                $user  = $user->whereIn('vmt_employee_office_details.department_id', $department_id);
            }
            $user =  $user->get(['users.id', 'users.user_code', 'users.name', 'vmt_employee_office_details.designation', 'vmt_employee_details.doj']);
            //  dd(  $user);
            $holidays = vmtHolidays::whereBetween('holiday_date', [$start_date, $end_date])->pluck('holiday_date');
            foreach ($user as $singleUser) {

                $firstDateStr = $start_date;
                $lastAttendanceDate = Carbon::parse($end_date);
                $totalDays =  $lastAttendanceDate->diffInDays(Carbon::parse($firstDateStr));
                $deviceData = [];

                for ($i = 0; $i < ($totalDays); $i++) {
                    // code...

                    $dayStr = Carbon::parse($firstDateStr)->addDay($i)->format('l');


                    $dateString  = Carbon::parse($firstDateStr)->addDay($i)->format('Y-m-d');
                    //dd($dateString);


                    if (
                        sessionGetSelectedClientCode() == "DM" || sessionGetSelectedClientCode() == 'VASA GROUPS' || sessionGetSelectedClientCode() == 'LAL'
                        || sessionGetSelectedClientCode() == 'PSC' || sessionGetSelectedClientCode() ==  'IMA' || sessionGetSelectedClientCode() ==  'PA' || sessionGetSelectedClientCode() ==  'DMC' || sessionGetSelectedClientCode() ==  'ABS'
                    ) {
                        $attendanceCheckOut = \DB::table('vmt_staff_attenndance_device')
                            ->select('user_Id', \DB::raw('MAX(date) as check_out_time'))
                            ->whereDate('date', $dateString)
                            ->where('user_Id', $singleUser->user_code)
                            ->first(['check_out_time']);

                        $attendanceCheckIn = \DB::table('vmt_staff_attenndance_device')
                            ->select('user_Id', \DB::raw('MIN(date) as check_in_time'))
                            ->whereDate('date', $dateString)
                            ->where('user_Id',  $singleUser->user_code)
                            ->first(['check_in_time']);
                    } else {
                        $attendanceCheckOut = \DB::table('vmt_staff_attenndance_device')
                            ->select('user_Id', \DB::raw('MAX(date) as check_out_time'))
                            ->whereDate('date', $dateString)
                            ->where('direction', 'out')
                            ->where('user_Id', $singleUser->user_code)
                            ->first(['check_out_time']);

                        $attendanceCheckIn = \DB::table('vmt_staff_attenndance_device')
                            ->select('user_Id', \DB::raw('MIN(date) as check_in_time'))
                            ->whereDate('date', $dateString)
                            ->where('direction', 'in')
                            ->where('user_Id', $singleUser->user_code)
                            ->first(['check_in_time']);
                    }
                    // dd($attendanceCheckIn);

                    $deviceCheckOutTime = empty($attendanceCheckOut->check_out_time) ? null : explode(' ', $attendanceCheckOut->check_out_time)[1];
                    $deviceCheckInTime  = empty($attendanceCheckIn->check_in_time) ? null : explode(' ', $attendanceCheckIn->check_in_time)[1];
                    //    dd($deviceCheckOutTime.'-----------'.$deviceCheckInTime);
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



                // attendance details from vmt_employee_attenndance table
                $attendance_WebMobile = VmtEmployeeAttendance::
                    // where('user_id', $request->user_id)
                    where('user_id', $singleUser->id)
                    //->whereMonth('date', $request->month)
                    ->whereBetween('date', [$start_date, $end_date])
                    ->orderBy('checkin_time', 'asc')
                    ->get(['date', 'checkin_time', 'checkout_time', 'attendance_mode_checkin', 'attendance_mode_checkout']);

                //dd($attendance_WebMobile);


                $attendanceResponseArray = [];

                //Create empty month array with all dates.
                // $month = $request->month;


                //$days_count = cal_days_in_month(CAL_GREGORIAN,$month,$year);
                //dd($totalDays );
                //For Excel Sheet Headers
                $heading_dates = array("Emp Code", "Name", "Designation", "DOJ");


                for ($i = 0; $i <= $totalDays; $i++) {
                    $fulldate = Carbon::parse($firstDateStr)->addDay($i)->format('Y-m-d');
                    $date = Carbon::parse($firstDateStr)->addDay($i)->format('d');

                    $date_day = $date . ' - ' . Carbon::parse($fulldate)->format('l');
                    array_push($heading_dates, $date_day);

                    $attendanceResponseArray[$fulldate] = array(
                        //"user_id"=>$request->user_id,
                        "user_id" => $singleUser->id, "user_code" => $singleUser->user_code, "name" => $singleUser->name,
                        "DOJ" => $singleUser->doj, "isAbsent" => false, "isLeave" => false, "is_weekoff" => false, "isLC" => null, "isEG" => null, "date" => $fulldate, "is_holiday" => false, "attendance_mode_checkin" => null, "attendance_mode_checkout" => null, "absent_status" => null, "checkin_time" => null, "checkout_time" => null, "leave_type" => null, "half_day_status" => null, "half_day_type" => null, 'date_day' => $date_day, 'work_shift_id' => null, 'isMIP' => null, 'isMOP' => null, 'reged_checkin_time' => null,
                        'reged_checkout_time' => null, 'permission_id' => null, 'checkinRegId' => null, 'checkoutRegId' => null,
                    );

                    //echo "Date is ".$fulldate."\n";
                    ///$month_array[""]
                }
                array_push($heading_dates, "Total Weekoff", "Total Holiday", "Total Present", "Total Absent", "Total Late LOP", "Total Leave", "Total Halfday", "Total On Duty");
                $attendance_setting_details =  $this->attendanceSettingsinfos(null);

                if ($attendance_setting_details['lc_status'] == 1) {
                    array_push($heading_dates, 'Total LC');
                }
                if ($attendance_setting_details['eg_status'] == 1) {
                    array_push($heading_dates, 'Total EG');
                }
                array_push($heading_dates, "Total Payable Days");





                // merging result from both table
                //dd($attendance_WebMobile->toArray());
                // dd($deviceData);
                $merged_attendanceData  = array_merge($deviceData, $attendance_WebMobile->toArray());

                $dateCollectionObj    =  collect($merged_attendanceData);
                $sortedCollection   =   $dateCollectionObj->sortBy([
                    ['date', 'asc'],
                ]);
                $dateWiseData         =  $sortedCollection->groupBy('date'); //->all();
                //dd($merged_attendanceData);
                //dd($dateWiseData);
                // dd($attendanceResponseArray);
                foreach ($dateWiseData  as $key => $value) {
                    //dd($key);
                    //dd($value[0]);

                    /*
                     Here $key is the date. i.e : 2022-10-01

                     $value is ::

                         [
                             date=>2022-11-05
                             checkin_time=18:06:00
                             checkout_time=18:06:00
                             attendance_mode="web"
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
                        //Find the min of checkin
                        //dd($singleValue);

                        if ($checkin_min == null) {
                            $checkin_min = $singleValue["checkin_time"];

                            $attendance_mode_checkin = $singleValue["attendance_mode_checkin"];
                        } else
                     if ($checkin_min > $singleValue["checkin_time"]) {
                            $checkin_min = $singleValue["checkin_time"];
                            $attendance_mode_checkin = $singleValue["attendance_mode_checkin"];
                        }

                        //dd("Min value found : " . $singleValue["checkin_time"]);

                        //Find the max of checkin
                        if ($checkout_max == null) {
                            $checkout_max = $singleValue["checkout_time"];
                            $attendance_mode_checkout = $singleValue["attendance_mode_checkout"];
                        } else
                     if ($checkout_max < $singleValue["checkout_time"]) {
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
                }

                foreach ($attendanceResponseArray as $key => $value) {

                    //get Shift Time for day

                    $shift_settings =  $this->getShiftTimeForEmployee($singleUser->id, $value['checkin_time'], $value['checkout_time']);
                    $shiftStartTime  = Carbon::parse($shift_settings->shift_start_time);
                    $shiftEndTime  = Carbon::parse($shift_settings->shift_end_time);
                    $weekOffDays =  $shift_settings->week_off_days;
                    $attendanceResponseArray[$key]['work_shift_id'] =  $shift_settings->id;

                    if ($attendanceResponseArray[$key]['checkin_time'] != null && $attendanceResponseArray[$key]['checkout_time'] != null && $attendanceResponseArray[$key]['checkout_time'] == $attendanceResponseArray[$key]['checkin_time']) {
                        $attendance_time = $this->findMIPOrMOP($attendanceResponseArray[$key]['checkin_time'], $shiftStartTime, $shiftEndTime);

                        $attendanceResponseArray[$key]['checkin_time'] = $attendance_time['checkin_time'];
                        $attendanceResponseArray[$key]['checkout_time'] = $attendance_time['checkout_time'];
                    }




                    //Logic For Check week off or not
                    //    dd( $attendanceResponseArray);
                    if (!array_key_exists('date', $attendanceResponseArray[$key]))
                        dd("Missing for : " . $key);

                    // if (
                    //     Carbon::parse($attendanceResponseArray[$key]['date'])->format('l') == "Sunday"
                    //     && $attendanceResponseArray[$key]['checkin_time'] == null &&
                    //     $attendanceResponseArray[$key]["checkout_time"] == null
                    // ) {
                    //     $attendanceResponseArray[$key]['is_weekoff'] = true;
                    // }
                    $attendanceResponseArray[$key]['is_weekoff'] =   $this->checkWeekOffStatus($attendanceResponseArray[$key]['date'], $weekOffDays, $attendanceResponseArray[$key]['checkin_time'], $attendanceResponseArray[$key]["checkout_time"]);

                    //Logic For Check Holiday Or Not
                    foreach ($holidays as $holiday) {
                        if (
                            Carbon::parse($holiday)->eq(Carbon::parse($attendanceResponseArray[$key]['date']))
                            && $attendanceResponseArray[$key]['checkin_time'] == null &&
                            $attendanceResponseArray[$key]["checkout_time"] == null &&
                            !$attendanceResponseArray[$key]['is_weekoff']
                        ) {
                            $attendanceResponseArray[$key]['is_holiday'] = true;
                        }
                    }

                    //Logic For Check Leave,Half day, Absent
                    //dd($attendanceResponseArray[$key]['user_id']);
                    if (
                        $attendanceResponseArray[$key]['checkin_time'] == null &&
                        $attendanceResponseArray[$key]["checkout_time"] == null &&
                        $attendanceResponseArray[$key]['is_weekoff'] == false
                    ) {
                        $leave_Details = VmtEmployeeLeaves::where('user_id', $attendanceResponseArray[$key]['user_id']);

                        if (empty($leave_Details)) {
                            $leave_Details =   $leave_Details->get(['start_date', 'end_date', 'status', 'leave_type_id', 'total_leave_datetime']);
                        } else {
                            $leave_Details =   $leave_Details->WhereBetween('start_date', [$start_date, $end_date]);
                            $leave_Details =   $leave_Details->WhereBetween('end_date', [$start_date, $end_date])
                                ->get(['start_date', 'end_date', 'status', 'leave_type_id', 'total_leave_datetime']);
                            // if ($key == '2023-08-12')
                            // dd($leave_Details);
                        }
                        if ($leave_Details->count() == 0) {
                            $attendanceResponseArray[$key]['isAbsent'] = true;
                        } else {
                            foreach ($leave_Details as $single_leave_details) {
                                $startDate = Carbon::parse($single_leave_details->start_date)->subDays(1);
                                $endDate = Carbon::parse($single_leave_details->end_date);
                                $currentDate =  Carbon::parse($attendanceResponseArray[$key]['date']);
                                //   dd($startDate.'-----'.$currentDate.'-----');
                                if ($currentDate->gt($startDate) || $currentDate->lte($endDate)) {
                                    if (substr($single_leave_details->total_leave_datetime, -1) == 'N') {
                                        // Logic Get FN or AN Value From total Leave date time
                                        $attendanceResponseArray[$key]['half_day_type'] = preg_replace("/([^a-zA-Z]+)/i", "",  $single_leave_details->total_leave_datetime);
                                        $attendanceResponseArray[$key]['half_day_status'] = $single_leave_details->status;
                                    } else if (
                                        $attendanceResponseArray[$key]['checkin_time'] == null &&
                                        $attendanceResponseArray[$key]["checkout_time"] == null &&
                                        $single_leave_details->status == 'Approved'
                                    ) {
                                        $attendanceResponseArray[$key]['isLeave'] = true;
                                        $leave_type = VmtLeaves::where('id', $single_leave_details->leave_type_id)
                                            ->pluck('leave_type');
                                        if ($leave_type[0] == 'Sick Leave / Casual Leave') {
                                            $attendanceResponseArray[$key]['leave_type'] = 'SL/CL';
                                        } else if ($leave_type[0] == 'Casual/Sick Leave') {
                                            $attendanceResponseArray[$key]['leave_type'] = 'CL/SL';
                                        } else if ($leave_type[0] == 'LOP Leave') {
                                            $attendanceResponseArray[$key]['leave_type'] = 'LOP LE';
                                        } else if ($leave_type[0] == 'Earned Leave') {
                                            $attendanceResponseArray[$key]['leave_type'] = 'EL';
                                        } else if ($leave_type[0] == 'Maternity Leave') {
                                            $attendanceResponseArray[$key]['leave_type'] = 'ML';
                                        } else if ($leave_type[0] == 'Paternity Leave') {
                                            $attendanceResponseArray[$key]['leave_type'] = 'PTL';
                                        } else if ($leave_type[0] == 'On Duty') {
                                            $attendanceResponseArray[$key]['leave_type'] = 'OD';
                                        } else if ($leave_type[0] == 'Permission') {
                                            $attendanceResponseArray[$key]['leave_type'] = "PI";
                                            $attendanceResponseArray[$key]['permission_id'] = $single_leave_details->id;
                                        } else if ($leave_type[0] == 'Compensatory Off') {
                                            $attendanceResponseArray[$key]['leave_type'] = 'CO';
                                        } else if ($leave_type[0] == 'Casual Leave') {
                                            $attendanceResponseArray[$key]['leave_type'] = 'CL';
                                        } else if ($leave_type[0] == 'Sick Leave') {
                                            $attendanceResponseArray[$key]['leave_type'] = 'SL';
                                        } else if ($leave_type[0] == 'Compensatory Leave') {
                                            $attendanceResponseArray[$key]['leave_type'] = 'CO';
                                        } else if ($leave_type[0] == 'Flexi day-off Leave') {
                                            $attendanceResponseArray[$key]['leave_type'] = 'FO L';
                                        }
                                        continue;
                                    } else {
                                        $attendanceResponseArray[$key]['isAbsent'] = true;
                                        continue;
                                    }
                                } else {
                                    $attendanceResponseArray[$key]['isAbsent'] = true;
                                    continue;
                                }
                            }
                        }
                    }

                    $checkin_time = $attendanceResponseArray[$key]["checkin_time"];
                    $checkout_time = $attendanceResponseArray[$key]["checkout_time"];

                    //Code For Check LC
                    if (!empty($checkin_time)) {
                        $parsedCheckIn_time  = Carbon::parse($checkin_time);
                        //Check whether checkin done on-time
                        $isCheckin_done_ontime = $parsedCheckIn_time->lte($shiftStartTime);
                        if ($isCheckin_done_ontime) {
                            //employee came on time....
                        } else {
                            //dd("Checkin NOT on-time");
                            //check whether regularization applied.
                            $user_id = $attendanceResponseArray[$key]['user_id'];
                            $date = $attendanceResponseArray[$key]['date'];
                            $regularization_status =  $this->RegularizationRequestStatus($user_id, $date, 'LC');
                            $attendanceResponseArray[$key]["isLC"] = $regularization_status['sts'];
                            $attendanceResponseArray[$key]["checkinRegId"] = $regularization_status['id'];
                            $attendanceResponseArray[$key]["reged_checkin_time"] = $regularization_status['time'];
                        }
                    } else if (empty($checkin_time) && !empty($checkout_time)) {
                        $user_id = $attendanceResponseArray[$key]['user_id'];
                        $date = $attendanceResponseArray[$key]['date'];
                        $regularization_status =  $this->RegularizationRequestStatus($user_id, $date, 'MIP');
                        $attendanceResponseArray[$key]["isMIP"] = $regularization_status['sts'];
                        $attendanceResponseArray[$key]["checkinRegId"] = $regularization_status['id'];
                        $attendanceResponseArray[$key]["reged_checkin_time"] = $regularization_status['time'];
                    }
                    //Code For Check EG
                    if (!empty($checkout_time)) {
                        $parsedCheckOut_time  = Carbon::parse($checkout_time);
                        //Check whether checkin out on-time
                        $isCheckout_done_ontime = $parsedCheckOut_time->lte($shiftEndTime);
                        if ($isCheckout_done_ontime) {
                            //employee left early on time....
                            $user_id = $attendanceResponseArray[$key]['user_id'];
                            $date = $attendanceResponseArray[$key]['date'];
                            $regularization_status =   $this->RegularizationRequestStatus($user_id, $date, 'EG');
                            $attendanceResponseArray[$key]["isEG"] = $regularization_status['sts'];
                            $attendanceResponseArray[$key]["checkoutRegId"] = $regularization_status['id'];
                            $attendanceResponseArray[$key]["reged_checkout_time"] = $regularization_status['time'];
                        } else if (!empty($checkin_time) && empty($checkout_time)) {
                            $user_id = $attendanceResponseArray[$key]['user_id'];
                            $date = $attendanceResponseArray[$key]['date'];
                            $regularization_status =   $this->RegularizationRequestStatus($user_id, $date, 'MOP');
                            $attendanceResponseArray[$key]["isMOP"] = $regularization_status['sts'];
                            $attendanceResponseArray[$key]["checkoutRegId"] = $regularization_status['id'];
                            $attendanceResponseArray[$key]["reged_checkout_time"] = $regularization_status['time'];
                        } else {
                            //employee left late....
                        }
                    }
                }
                array_push($reportresponse, $attendanceResponseArray);
                unset($attendanceResponseArray);
            }
        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => 'Error while fetching data',
                'error' =>  $e->getMessage(),
                'line' => $e->getTraceAsString(),
                'error_verbose' => $e->getLine()
            ];
        }
        // dd($reportresponse);
        return  $reportresponse;
    }



    public function fetchAbsentReportData($start_date, $end_date, $department_id, $client_id)
    {

        //   dd($start_date, $end_date, $department_id, $client_id);
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

            ini_set('max_execution_time', 3000);

            $response = array();
            $absent_data = array();
            $temp_ar = array();

            if (Carbon::parse($end_date)->gt(Carbon::today())) {
                $end_date = Carbon::today()->format('Y-m-d');
            }

            $attendance_data = user::Join('vmt_emp_att_intrtable', 'vmt_emp_att_intrtable.user_id', '=', 'users.id')
                ->join('vmt_work_shifts', 'vmt_work_shifts.id', '=', 'vmt_emp_att_intrtable.vmt_employee_workshift_id')
                ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->whereBetween('date', [$start_date, $end_date]);
            // dd($attendance_data);
            if (!empty($client_id)) {
                $attendance_data =  $attendance_data->whereIn('client_id', $client_id);
            }
            if (!empty($department_id)) {
                $attendance_data = $attendance_data->whereIn('vmt_employee_office_details.department_id', $department_id);
            }
            $attendance_data =  $attendance_data->get();

            foreach ($attendance_data as $single_data) {

                $sts_ar = explode('/', $single_data['status']);

                if ($single_data->regularized_checkin_time != null) {
                    $checkin_time = $single_data->regularized_checkin_time;
                } else {
                    $checkin_time =  $single_data->checkin_time;
                }

                if ($single_data->regularized_checkout_time != null) {
                    $checkout_time =   $single_data->regularized_checkout_time;
                } else {
                    $checkout_time =   $single_data->checkout_time;
                }
                if ($single_data['status'] == 'A' || $checkin_time == null || $checkout_time == null) {

                    $temp_ar['Employee Code'] = $single_data['user_code'];
                    $temp_ar['Employee Name'] = $single_data['name'];
                    $temp_ar['Date'] =  Carbon::parse($single_data['date'])->format('d-M-Y');
                    $temp_ar['Shift Name'] =  $single_data['shift_name'];
                    $temp_ar['In Punch'] = $checkin_time == null ? '-' : $checkin_time;
                    $temp_ar['Out Punch']  = $checkout_time == null ? '-' : $checkout_time;
                    $temp_ar['Status'] = 'Absent';
                    $temp_ar['Day Status'] = 'Full day Absent';
                    array_push($absent_data, $temp_ar);
                    unset($temp_ar);
                } else if (in_array('P', $sts_ar)) {


                    $diff_minutes = (Carbon::parse($checkin_time))->diffInMinutes(Carbon::parse($checkout_time));
                    $forenoon = Carbon::parse($single_data['shift_start_time'])->addMinutes($single_data['halfday_min_workhrs'])->format('H:i:s');
                    $afternoon = Carbon::parse($forenoon)->addMinutes($single_data['halfday_min_workhrs'])->format('H:i:s');
                    //  if($single_data['user_code']=='DM161'){
                    //     dd($fullday_hrs <= $diff_minutes);
                    //  }
                    if ($diff_minutes <= $single_data['halfday_min_workhrs']) {
                        $temp_ar['Employee Code'] = $single_data['user_code'];
                        $temp_ar['Employee Name'] = $single_data['name'];
                        $temp_ar['Date'] =  Carbon::parse($single_data['date'])->format('d-M-Y');
                        $temp_ar['Shift Name'] =  $single_data['shift_name'];
                        $temp_ar['In Punch'] = $checkin_time == null ? '-' : $checkin_time;
                        $temp_ar['Out Punch']  = $checkout_time == null ? '-' : $checkout_time;
                        $temp_ar['Status'] = 'Absent';
                        $temp_ar['Day Status'] = 'Full day Absent';
                        array_push($absent_data, $temp_ar);
                        unset($temp_ar);
                    } else if ($diff_minutes > $single_data['halfday_min_workhrs'] || $diff_minutes < $single_data['halfday_min_workhrs']) {

                        if ($forenoon <= $checkout_time && $forenoon <= $checkin_time) {
                            $temp_ar['Employee Code'] = $single_data['user_code'];
                            $temp_ar['Employee Name'] = $single_data['name'];
                            $temp_ar['Date'] =  Carbon::parse($single_data['date'])->format('d-M-Y');
                            $temp_ar['Shift Name'] =  $single_data['shift_name'];
                            $temp_ar['In Punch'] = $checkin_time;
                            $temp_ar['Out Punch']  = $checkout_time;
                            $temp_ar['Status'] = 'Half Day';
                            $temp_ar['Day Status'] = 'FN Absent';
                            array_push($absent_data, $temp_ar);
                        } else if (($forenoon >= ($checkout_time) && ($forenoon >= $checkin_time))) {
                            $temp_ar['Employee Code'] = $single_data['user_code'];
                            $temp_ar['Employee Name'] = $single_data['name'];
                            $temp_ar['Date'] =  Carbon::parse($single_data['date'])->format('d-M-Y');
                            $temp_ar['Shift Name'] =  $single_data['shift_name'];
                            $temp_ar['In Punch'] = $checkin_time;
                            $temp_ar['Out Punch']  = $checkout_time;
                            $temp_ar['Status'] = 'Half Day';
                            $temp_ar['Day Status'] = 'AN Absent';
                            array_push($absent_data, $temp_ar);
                        }
                    }
                }
            }
            $response['headers'] = array('Employee Code', 'Employee Name', 'Date', 'Shift Name', 'In Punch', 'Out Punch', 'Status', 'Day Status');
            $response['rows'] = $absent_data;
        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => 'Error while fetching data',
                'error' =>  $e->getMessage(),
                'error_verbose' => $e->getLine() . "  " . $e->getfile(),
            ];
        }

        return $response;
    }

    public function fetchHalfDayReportData($start_date, $end_date, $department_id, $client_id)
    {

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
            $response = array();
            $halfday_data = array();
            $temp_ar = array();

            if (Carbon::parse($end_date)->gt(Carbon::today())) {
                $end_date = Carbon::today()->format('Y-m-d');
            }

            $attendance_data = user::Join('vmt_emp_att_intrtable', 'vmt_emp_att_intrtable.user_id', '=', 'users.id')
                ->join('vmt_work_shifts', 'vmt_work_shifts.id', '=', 'vmt_emp_att_intrtable.vmt_employee_workshift_id')
                ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->whereBetween('date', [$start_date, $end_date]);
            if (!empty($client_id)) {
                $attendance_data = $attendance_data->whereIn('client_id', $client_id);
            }
            if (!empty($department_id)) {
                $attendance_data = $attendance_data->whereIn('vmt_employee_office_details.department_id', $department_id);
            }
            $attendance_data = $attendance_data->get();

            foreach ($attendance_data as $single_data) {
                if ($single_data->regularized_checkin_time != null) {
                    $checkin_time = $single_data->regularized_checkin_time;
                } else {
                    $checkin_time =  $single_data->checkin_time;
                }

                if ($single_data->regularized_checkout_time != null) {
                    $checkout_time =   $single_data->regularized_checkout_time;
                } else {
                    $checkout_time =   $single_data->checkout_time;
                }
                $sts_ar = explode('/', $single_data['status']);

                if (in_array('P', $sts_ar)) {


                    $diff_minutes = (Carbon::parse($checkin_time))->diffInMinutes(Carbon::parse($checkout_time));
                    $forenoon = Carbon::parse($single_data['shift_start_time'])->addMinutes($single_data['halfday_min_workhrs'])->format('H:i:s');
                    $afternoon = Carbon::parse($forenoon)->addMinutes($single_data['halfday_min_workhrs'])->format('H:i:s');
                    //  if($single_data['user_code']=='DM161'){
                    //     dd($fullday_hrs <= $diff_minutes);
                    //  }
                    if ($diff_minutes > $single_data['halfday_min_workhrs'] && $checkin_time != null && $checkout_time != null) {
                        if ($forenoon <= $checkout_time && $forenoon <= $checkin_time) {
                            $temp_ar['Employee Code'] = $single_data['user_code'];
                            $temp_ar['Employee Name'] = $single_data['name'];
                            $temp_ar['Date'] =  Carbon::parse($single_data['date'])->format('d-M-Y');
                            $temp_ar['Shift Name'] =  $single_data['shift_name'];
                            $temp_ar['In Punch'] = $checkin_time;
                            $temp_ar['Out Punch']  = $checkout_time;
                            $temp_ar['Status'] = 'Half Day';
                            $temp_ar['Day Status'] = 'FN Absent';
                            array_push($halfday_data, $temp_ar);
                        } else if (($forenoon >= ($checkout_time) && ($forenoon >= $checkin_time))) {
                            $temp_ar['Employee Code'] = $single_data['user_code'];
                            $temp_ar['Employee Name'] = $single_data['name'];
                            $temp_ar['Date'] =  Carbon::parse($single_data['date'])->format('d-M-Y');
                            $temp_ar['Shift Name'] =  $single_data['shift_name'];
                            $temp_ar['In Punch'] = $checkin_time;
                            $temp_ar['Out Punch']  = $checkout_time;
                            $temp_ar['Status'] = 'Half Day';
                            $temp_ar['Day Status'] = 'AN Absent';
                            array_push($halfday_data, $temp_ar);
                        }
                    }
                }
            }

            $response['headers'] = array('Employee Code', 'Employee Name', 'Date', 'Shift Name', 'In Punch', 'Out Punch', 'Status', 'Day Status');
            $response['rows'] = $halfday_data;
        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => 'Error while fetching data',
                'error' =>  $e->getMessage(),
                'error_verbose' => $e->getLine() . "  " . $e->getfile(),
            ];
        }
        return $response;
    }

    public function fetchLCReportData($start_date, $end_date, $department_id, $client_id)
    {
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


        // try {

        $lcData = array();
        $response = array();
        $temp_ar = array();
        // dd($start_date,$end_date);
        if (Carbon::parse($end_date)->gt(Carbon::today())) {
            $end_date = Carbon::today()->format('Y-m-d');
        }
        $attendance_data = user::Join('vmt_emp_att_intrtable', 'vmt_emp_att_intrtable.user_id', '=', 'users.id')
            ->join('vmt_work_shifts', 'vmt_work_shifts.id', '=', 'vmt_emp_att_intrtable.vmt_employee_workshift_id')
            ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
            ->whereBetween('date', [$start_date, $end_date]);
        if (!empty($client_id)) {
            $attendance_data = $attendance_data->whereIn('client_id', $client_id);
        }
        if (!empty($department_id)) {
            $attendance_data = $attendance_data->whereIn('vmt_employee_office_details.department_id', $department_id);
        }
        $attendance_data = $attendance_data->get();

        foreach ($attendance_data as $single_data) {
            $sts_ar = explode('/', $single_data['status']);
            if (in_array('LC', $sts_ar) || $single_data['lc_id'] != null) {
                $temp_ar['Employee Code'] = $single_data['user_code'];
                $temp_ar['Employee Name'] = $single_data['name'];
                $temp_ar['Date'] = Carbon::parse($single_data['date'])->format('d-M-Y');
                $temp_ar['Shift Name'] = $single_data['shift_name'];
                $temp_ar['In Punch'] = $single_data['checkin_time'];
                $temp_ar['Out Punch'] = $single_data['checkout_time'];
                if ($single_data['regularized_checkin_time'] != null) {
                    $temp_ar['In Punch'] = $single_data['regularized_checkin_time'];
                }
                $temp_ar['Late Coming Duration'] =  CarbonInterval::minutes($single_data['lc_minutes'])->cascade()->forHumans();
                // if($temp_ar['Out Punch'] == null ){
                //     $temp_ar['Day Status'] ='Half Day';
                // }else if(Carbon::parse(  $temp_ar['In Punch'])->diffInMinutes( $temp_ar['Out Punch'])<$single_data['fullday_min_workhrs']){
                //     $temp_ar['Day Status'] ='Half Day';
                // }else{
                //     $temp_ar['Day Status'] ='Full Day';
                // }
                if ($single_data['lc_id'] != null) {
                    $regularized_sts = 'Yes';
                    $user = VmtEmployeeAttendanceRegularization::where('id', $single_data['lc_id'])->first();
                    $reason = $user->reason_type == 'Others' ? $user->custom_reason : $user->reason_type;
                    $approved_by = user::where('id', $user->reviewer_id)->first()->name;
                    $approved_on = $user->reviewer_reviewed_date;
                    $approved_cmts = $user->reviewer_comments;
                } else {
                    $regularized_sts = 'No';
                    $reason = "-";
                    $approved_by = "-";
                    $approved_on = "-";
                    $approved_cmts = "-";
                }
                $temp_ar['Regularise Status'] = $regularized_sts;
                $temp_ar['Employee Reason For Late Coming'] = $reason;
                $temp_ar['Approved By'] = $approved_by;
                $temp_ar['Approved On'] = $approved_on;
                $temp_ar['Approver Comments'] = $approved_cmts;
                array_push($lcData, $temp_ar);
                unset($temp_ar);
            }
        }



        $response['headers'] = array(
            'Employee Code', 'Employee Name', 'Date', 'Shift Name', 'In Punch', 'Out Punch', 'Late Coming Duration', 'Regularise Status',
            'Employee Reason For Late Coming', 'Approved By', 'Approved On', 'Approver Comments'
        );
        $response['rows'] = $lcData;
        // } catch (\Exception $e) {
        //     return  $response = [
        //         'status' => 'failure',
        //         'message' => 'Error while fetching data',
        //         'error' =>  $e->getMessage(),
        //         'error_verbose' => $e->getLine() . "  " . $e->getfile(),
        //         'trace line' => $e->getTraceAsString(),
        //         'data' => $single_data,
        //     ];
        // }
        return $response;
    }


    public function fetchEGReportData($start_date, $end_date, $department_id, $client_id)
    {

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

            $attendance_data = user::Join('vmt_emp_att_intrtable', 'vmt_emp_att_intrtable.user_id', '=', 'users.id')
                ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->join('vmt_work_shifts', 'vmt_work_shifts.id', '=', 'vmt_emp_att_intrtable.vmt_employee_workshift_id')
                ->whereBetween('date', [$start_date, $end_date]);
            if (!empty($client_id)) {
                $attendance_data =  $attendance_data->where('client_id', $client_id);
            }
            if (!empty($department_id)) {
                $attendance_data = $attendance_data->whereIn('vmt_employee_office_details.department_id', $department_id);
            }
            $attendance_data =  $attendance_data->get();
            $ecData = array();
            $response = array();
            $temp_ar = array();

            foreach ($attendance_data as $single_data) {
                $sts_ar = explode('/', $single_data['status']);
                if (in_array('EG', $sts_ar) || $single_data['eg_id'] != null) {
                    $temp_ar['Employee Code'] = $single_data['user_code'];
                    $temp_ar['Employee Name'] = $single_data['name'];
                    $temp_ar['Date'] = Carbon::parse($single_data['date'])->format('d-M-Y');
                    $temp_ar['Shift Name'] = $single_data['shift_name'];
                    $temp_ar['In Punch'] = $single_data['checkin_time'];
                    $temp_ar['Out Punch'] = $single_data['checkout_time'];
                    if ($single_data['regularized_checkout_time'] != null) {
                        $temp_ar['Out Punch'] = $single_data['regularized_checkout_time'];
                    }
                    $temp_ar['Early Going Duration'] =  CarbonInterval::minutes($single_data['eg_minutes'])->cascade()->forHumans();
                    // if($temp_ar['Out Punch'] == null ){
                    //     $temp_ar['Day Status'] ='Half Day';
                    // }else if(Carbon::parse(  $temp_ar['In Punch'])->diffInMinutes( $temp_ar['Out Punch'])<$single_data['fullday_min_workhrs']){
                    //     $temp_ar['Day Status'] ='Half Day';
                    // }else{
                    //     $temp_ar['Day Status'] ='Full Day';
                    // }
                    if ($single_data['eg_id'] != null) {
                        $regularized_sts = 'Yes';
                        $user = VmtEmployeeAttendanceRegularization::where('id', $single_data['eg_id'])->first();
                        $reason = $user->reason_type == 'Others' ? $user->custom_reason : $user->reason_type;
                        $approved_by = user::where('id', $user->reviewer_id)->first()->name;
                        $approved_on = $user->reviewer_reviewed_date;
                        $approved_cmts = $user->reviewer_comments;
                    } else {
                        $regularized_sts = 'No';
                        $reason = "-";
                        $approved_by = "-";
                        $approved_on = "-";
                        $approved_cmts = "-";
                    }
                    $temp_ar['Regularise Status'] = $regularized_sts;
                    $temp_ar['Employee Reason For Early Going'] = $reason;
                    $temp_ar['Approved By'] = $approved_by;
                    $temp_ar['Approved On'] = $approved_on;
                    $temp_ar['Approver Comments'] = $approved_cmts;
                    array_push($ecData, $temp_ar);
                    unset($temp_ar);
                }
            }

            $response['headers'] = array(
                'Employee Code', 'Employee Name', 'Date', 'Shift Name', 'In Punch', 'Out Punch', 'Early Going Duration', 'Regularise Status',
                'Employee Reason For Early Going', 'Approved By', 'Approved On', 'Approver Comments'
            );
            $response['rows'] =  $ecData;
        } catch (\Exception $e) {
            return  $response = [
                'status' => 'failure',
                'message' => 'Error while fetching data',
                'error' =>  $e->getMessage(),
                'error_verbose' => $e->getLine() . "  " . $e->getfile(),
                'trace line' => $e->getTraceAsString(),
                // 'data' => $single_data[$key]
            ];
        }
        return $response;
    }
    public function fetchMIPOrMOPReportData($start_date, $end_date, $department_id, $client_id, $type)
    {

        $validator = Validator::make(
            $data = [
                'client_id' => $client_id,
                'department_id' => $department_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'type' => $type
            ],
            $rules = [
                'client_id' => 'nullable|exists:vmt_client_master,id',
                'department_id' => 'nullable|exists:vmt_department,id',
                'start_date' => 'required',
                'end_date' => 'required',
                'type' => ['required', Rule::in(['MIP', 'MOP'])],

            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'in' => 'Field :attribute is invalid'
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
            $attendance_data = user::Join('vmt_emp_att_intrtable', 'vmt_emp_att_intrtable.user_id', '=', 'users.id')
                ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->join('vmt_work_shifts', 'vmt_work_shifts.id', '=', 'vmt_emp_att_intrtable.vmt_employee_workshift_id')
                ->whereBetween('date', [$start_date, $end_date]);
            if (!empty($client_id)) {
                $attendance_data =  $attendance_data->where('client_id', $client_id);
            }
            if (!empty($department_id)) {
                $attendance_data = $attendance_data->whereIn('vmt_employee_office_details.department_id', $department_id);
            }
            $attendance_data =  $attendance_data->get();
            $mip_mop_data = array();
            $response = array();
            $temp_ar = array();
            if ($type == 'MIP') {
                $query_type = 'mip_id';
                $type_abbreviation = 'Missed In Punch';
            } else if ($type == 'MOP') {
                $type_abbreviation = 'Missed Out Punch';
                $query_type = 'mop_id';
            }
            foreach ($attendance_data as $single_data) {
                $sts_ar = explode('/', $single_data['status']);

                if (in_array($type, $sts_ar) || $single_data[$query_type] != null) {
                    $temp_ar['Employee Code'] = $single_data['user_code'];
                    $temp_ar['Employee Name'] = $single_data['name'];
                    $temp_ar['Date'] = Carbon::parse($single_data['date'])->format('d-M-Y');
                    $temp_ar['Shift Name'] = $single_data['shift_name'];
                    $temp_ar['In Punch'] = $single_data['checkin_time'];
                    $temp_ar['Out Punch'] = $single_data['checkout_time'];
                    if ($type == 'MIP') {
                        if ($single_data['regularized_checkin_time'] != null) {
                            $temp_ar['In Punch'] = $single_data['regularized_checkin_time'];
                        } else {
                            $temp_ar['In Punch'] = '-';
                        }
                    } else if ($type == 'MOP') {
                        if ($single_data['regularized_checkout_time'] != null) {
                            $temp_ar['Out Punch'] = $single_data['regularized_checkout_time'];
                        } else {
                            $temp_ar['Out Punch'] = '-';
                        }
                    }
                    if ($single_data[$query_type] != null) {
                        $regularized_sts = 'Yes';
                        $user = VmtEmployeeAttendanceRegularization::where('id', $single_data[$query_type])->first();
                        $reason = $user->reason_type == 'Others' ? $user->custom_reason : $user->reason_type;
                        $reviewer_query = user::where('id', $user->reviewer_id);
                        if ($reviewer_query->exists()) {
                            $approved_by  =  $reviewer_query->first()->name;
                        } else {
                            $approved_by  = '';
                        }

                        $approved_on = $user->reviewer_reviewed_date;
                        $approved_cmts = $user->reviewer_comments;
                    } else {
                        $regularized_sts = 'No';
                        $reason = "-";
                        $approved_by = "-";
                        $approved_on = "-";
                        $approved_cmts = "-";
                    }
                    $temp_ar['Regularise Status'] = $regularized_sts;
                    $temp_ar['Employee Reason For ' . $type_abbreviation] = $reason;
                    $temp_ar['Approved By'] = $approved_by;
                    $temp_ar['Approved On'] = $approved_on;
                    $temp_ar['Approver Comments'] = $approved_cmts;
                    array_push($mip_mop_data, $temp_ar);
                    unset($temp_ar);
                }
            }


            $response['headers'] = array(
                'Employee Code', 'Employee Name', 'Date', 'Shift Name', 'In Punch', 'Out Punch', 'Regularise Status',
                'Employee Reason For ' . $type_abbreviation, 'Approved By', 'Approved On', 'Approver Comments'
            );
            $response['rows'] =  $mip_mop_data;

            return $response;
        } catch (\Exception $e) {
            return response()->json([
                'status' => "failure",
                'message' => "",
                'data' => $e->getmessage(),
                'line' => $e->getTraceAsString()
            ]);
        }
    }

    public function fetchOvertimeReportData($start_date, $end_date, $department_id, $client_id)
    {
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

            $attendance_data = user::Join('vmt_emp_att_intrtable', 'vmt_emp_att_intrtable.user_id', '=', 'users.id')
                ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->join('vmt_work_shifts', 'vmt_work_shifts.id', '=', 'vmt_emp_att_intrtable.vmt_employee_workshift_id')
                ->whereBetween('date', [$start_date, $end_date])
                ->where('vmt_emp_att_intrtable.overtime', '>', '0');
            if (!empty($client_id)) {
                $attendance_data =  $attendance_data->where('client_id', $client_id);
            }
            if (!empty($department_id)) {
                $attendance_data = $attendance_data->whereIn('vmt_employee_office_details.department_id', $department_id);
            }
            $attendance_data =  $attendance_data->get();
            $otData = array();
            $response = array();
            $temp_ar = array();
            foreach ($attendance_data as $single_data) {
                $temp_ar['Employee Code'] = $single_data['user_code'];
                $temp_ar['Employee Name'] = $single_data['name'];
                $temp_ar['Date'] = Carbon::parse($single_data['date'])->format('d-M-Y');
                $temp_ar['Shift Name'] = $single_data['shift_name'];
                $temp_ar['In Punch'] = $single_data['checkin_time'];
                $temp_ar['Out Punch'] = $single_data['checkout_time'];
                $temp_ar['OverTime Duration'] = CarbonInterval::minutes($single_data['overtime'])->cascade()->forHumans();
                array_push($otData,  $temp_ar);
                unset($temp_ar);
            }

            $response['headers'] = array('Employee Code', 'Employee Name', 'Date', 'Shift Name', 'In Punch', 'Out Punch', 'OverTime Duration');
            $response['rows'] = $otData;
        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => 'Error while fetching data',
                'error' =>  $e->getMessage(),
                'error_verbose' => $e->getLine() . "  " . $e->getfile(),
            ];
        }
        return $response;
    }
    public function fetchSandwidchReportData($start_date, $end_date,$user_id)
    {

        ini_set('max_execution_time', 3000);
        $validator = Validator::make(
            $data = [
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
            $sandwich_settings_data =  VmtAttendanceSettings::first();

            if (!empty($sandwich_settings_data)) {
                $response = array();
                $halfday_data = array();
                $temp_ar = array();

                if (Carbon::parse($end_date)->gt(Carbon::today())) {
                    $end_date = Carbon::today()->format('Y-m-d');
                }

                $attendance_data = user::Join('vmt_emp_att_intrtable', 'vmt_emp_att_intrtable.user_id', '=', 'users.id')
                    ->join('vmt_work_shifts', 'vmt_work_shifts.id', '=', 'vmt_emp_att_intrtable.vmt_employee_workshift_id')
                    ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                    ->whereBetween('date', [$start_date, $end_date])
                    ->orderBy('vmt_emp_att_intrtable.date', 'ASC');

                if (!empty($user_id)) {

                    $attendance_data = $attendance_data->where('vmt_emp_att_intrtable.user_id', $user_id);
                }
                if (!empty($client_id)) {
                    $attendance_data = $attendance_data->whereIn('client_id', $client_id);
                }
                if (!empty($department_id)) {
                    $attendance_data = $attendance_data->whereIn('vmt_employee_office_details.department_id', $department_id);
                }
                $attendance_data = $attendance_data->get();

                $is_weekOff_applicable = $sandwich_settings_data->is_weekoff_applicable;
                $is_holiday_applicable = $sandwich_settings_data->is_holiday_applicable;
                $is_leave_applicable = $sandwich_settings_data->can_consider_approved_leaves;
                $data = array();
                $data_array = [];
                $current_client_code = VmtClientMaster::where('id', auth()->user()->id == '1' ? '1' : auth()->user()->client_id)->first();

                //ho-holiday and WO - week off

                if ($current_client_code->client_code == "DM"|| $current_client_code->client_code == "BA") {

                    foreach ($attendance_data as $single_data) {

                        if ($single_data['status'] == "HO" || $single_data['status'] == "WO") {

                            $leave_type_array  = array("SL/CL", "SL/CL", "CL/SL", "LOP LE", "EL", "ML", "PTL", "OD", "PI", "CO", "CL", "FO L", "SL", "FO L");

                            $wo_ho_response = $this->getWeekoffHolidaySandwidchDetails($single_data['date'], $single_data['user_id'], $is_leave_applicable);


                            if (!empty($wo_ho_response)) {

                                $sandwidch_date = array();

                                if (($is_leave_applicable == "1" ? in_array($wo_ho_response['before_status'][0], $leave_type_array) ? true : false : false) && ($is_leave_applicable == "1" ? in_array($wo_ho_response['after_status'][0], $leave_type_array) ? true : false : false)) {
                                    $count = true;
                                    $k = 1;
                                    $z = 1;

                                    while ($count) {

                                        array_push($sandwidch_date, $wo_ho_response['is_emp_absent_after']['date'], $wo_ho_response['is_emp_absent_before']['date']);

                                        $after_date = Carbon::createFromFormat('Y-m-d', $wo_ho_response['is_emp_absent_after']['date'])->adddays($k)->format('Y-m-d');
                                        $before_date = Carbon::createFromFormat('Y-m-d', $wo_ho_response['is_emp_absent_before']['date'])->subdays($z)->format('Y-m-d');
                                        $day_before_date = Carbon::createFromFormat('Y-m-d', $after_date)->subdays()->format('Y-m-d');

                                        $is_emp_absent_after = $this->getAfterBeforeDateOfdate($after_date, $wo_ho_response['is_emp_absent_after']['user_id']);
                                        $is_emp_absent_before = $this->getAfterBeforeDateOfdate($before_date, $wo_ho_response['is_emp_absent_after']['user_id']);
                                        $is_emp_absent_day_before = $this->getAfterBeforeDateOfdate($day_before_date, $wo_ho_response['is_emp_absent_before']['user_id']);

                                        $after_status =   !empty($is_emp_absent_after) ? explode('/', $is_emp_absent_after->status) : null;
                                        $before_status =   !empty($is_emp_absent_before) ? explode('/', $is_emp_absent_before->status) : null;

                                        if (empty($after_status)) {
                                            $sandwidch_date =$this->checkEmployeeAbsentstatus($wo_ho_response['current_status'],$single_data['date'],$wo_ho_response['before_status'],$wo_ho_response['is_emp_absent_before']['date'],$wo_ho_response['after_status'],$wo_ho_response['is_emp_absent_after']['date'],$sandwidch_date);

                                            $count = false;
                                        }else{
                                            $sandwidch_date =$this->checkEmployeeAbsentstatus($wo_ho_response['current_status'],$single_data['date'],$wo_ho_response['before_status'],$wo_ho_response['is_emp_absent_before']['date'],$wo_ho_response['after_status'],$wo_ho_response['is_emp_absent_after']['date'],$sandwidch_date);

                                        }

                                        if (!empty($is_emp_absent_after)) {

                                            if ($wo_ho_response['after_status'][0] == "A") {

                                              //  array_push($sandwidch_date, $single_data['date'], $wo_ho_response['is_emp_absent_before']['date'], $wo_ho_response['is_emp_absent_after']['date']);
                                            }

                                            if ($is_emp_absent_after->status == "A") {

                                              //  array_push($sandwidch_date, $single_data['date'], $wo_ho_response['is_emp_absent_before']['date'], $wo_ho_response['is_emp_absent_after']['date'], $after_date);
                                                $count = true;
                                                $k++;
                                            } else if (in_array('WO', $after_status)) {

                                                array_push($sandwidch_date, ['date'=>$after_date,'status'=>'WO']);
                                                $count = true;
                                                $k++;
                                            } else if (in_array('HO', $after_status)) {

                                                array_push($sandwidch_date, ['date'=>$after_date,'status'=>'HO']);
                                                $count = true;
                                                $k++;
                                            } else if (in_array($is_emp_absent_after->status, $leave_type_array)) {
                                                if ($is_leave_applicable == "1") {
                                                    array_push($sandwidch_date, ['date'=>$after_date,'status'=>$is_emp_absent_after->status]);
                                                    $count = true;
                                                    $k++;
                                                }
                                            } else if (in_array('P', $after_status)) {
                                                $count = false;
                                                $sandwidch_date = [];
                                            } else {

                                                $day_before_status =   !empty($is_emp_absent_day_before) ? explode('/', $is_emp_absent_day_before->status) : null;

                                                if (!in_array('A', $day_before_status)) {

                                                    $sandwidch_date = [];
                                                    $k++;
                                                }
                                                $count = false;
                                            }
                                        }
                                        if (!empty($is_emp_absent_before)) {

                                            if (in_array('A', $before_status)) {
                                              //  array_push($sandwidch_date, $before_date);
                                                $z++;
                                            } else {

                                                $before_date = null;
                                                $is_emp_absent_day_before = null;
                                            }
                                        }
                                    }
                                }
                                if (($wo_ho_response['before_status'][0] == "A" || ($is_leave_applicable == "1" ? in_array($wo_ho_response['before_status'][0], $leave_type_array) ? true : false : false)) && (($wo_ho_response['after_status'][0] == 'WO' || $wo_ho_response['after_status'][0] == "A") && $is_weekOff_applicable == '1')) {

                                    $count = true;
                                    $i = 1;
                                    $x = 1;
                                    while ($count) {

                                        $after_date = Carbon::createFromFormat('Y-m-d', $wo_ho_response['is_emp_absent_after']['date'])->adddays($i)->format('Y-m-d');
                                        $before_date = Carbon::createFromFormat('Y-m-d', $wo_ho_response['is_emp_absent_before']['date'])->subdays($x)->format('Y-m-d');
                                        $day_before_date = Carbon::createFromFormat('Y-m-d', $after_date)->subdays()->format('Y-m-d');

                                        $is_emp_absent_after = $this->getAfterBeforeDateOfdate($after_date, $wo_ho_response['is_emp_absent_after']['user_id']);
                                        $is_emp_absent_before = $this->getAfterBeforeDateOfdate($before_date, $wo_ho_response['is_emp_absent_after']['user_id']);
                                        $is_emp_absent_day_before = $this->getAfterBeforeDateOfdate($day_before_date, $wo_ho_response['is_emp_absent_before']['user_id']);

                                        $after_status =   !empty($is_emp_absent_after) ? explode('/', $is_emp_absent_after->status) : null;
                                        $before_status =   !empty($is_emp_absent_before) ? explode('/', $is_emp_absent_before->status) : null;


                                        if (empty($after_status)) {
                                            $sandwidch_date =$this->checkEmployeeAbsentstatus($wo_ho_response['current_status'],$single_data['date'],$wo_ho_response['before_status'],$wo_ho_response['is_emp_absent_before']['date'],$wo_ho_response['after_status'],$wo_ho_response['is_emp_absent_after']['date'],$sandwidch_date);

                                            $count = false;
                                        }else{
                                            $sandwidch_date =$this->checkEmployeeAbsentstatus($wo_ho_response['current_status'],$single_data['date'],$wo_ho_response['before_status'],$wo_ho_response['is_emp_absent_before']['date'],$wo_ho_response['after_status'],$wo_ho_response['is_emp_absent_after']['date'],$sandwidch_date);

                                        }

                                        if (!empty($is_emp_absent_after)) {


                                            if ($is_emp_absent_after->status == "A") {

                                               // array_push($sandwidch_date, $single_data['date'], $wo_ho_response['is_emp_absent_before']['date'], $wo_ho_response['is_emp_absent_after']['date'], $after_date);
                                                $count = true;
                                                $i++;
                                            } else if (in_array('WO', $after_status)) {

                                                array_push($sandwidch_date, ['date'=>$after_date,'status'=>'WO']);
                                                $count = true;
                                                $i++;
                                            } else if (in_array($is_emp_absent_after->status, $leave_type_array)) {
                                                if ($is_leave_applicable == "1") {
                                                    array_push($sandwidch_date, $after_date);
                                                    $count = true;
                                                    $i++;
                                                }
                                            } else if (in_array('P', $after_status)) {

                                                $count = false;
                                            } else {

                                                $day_before_status =   !empty($is_emp_absent_day_before) ? explode('/', $is_emp_absent_day_before->status) : null;
                                                if (!in_array('A', $day_before_status)) {

                                                    $sandwidch_date = [];
                                                    $i++;
                                                }
                                                $count = false;
                                            }
                                        }
                                        if (!empty($is_emp_absent_before)) {

                                            if (in_array('A', $before_status)) {
                                             //   array_push($sandwidch_date, $before_date);
                                                $x++;
                                                $count = true;
                                            } else {
                                                $before_date = null;
                                                $is_emp_absent_day_before = null;
                                            }
                                        }
                                    }
                                }

                                if (($wo_ho_response['before_status'][0] == "A" || ($is_leave_applicable == "1" ? in_array($wo_ho_response['before_status'][0], $leave_type_array) ? true : false : false)) && (($wo_ho_response['after_status'][0] == 'HO' || $wo_ho_response['after_status'][0] == "A") && $is_holiday_applicable == '1')) {

                                    $count = true;
                                    $j = 1;
                                    $y = 1;
                                    while ($count) {

                                        $after_date = Carbon::createFromFormat('Y-m-d', $wo_ho_response['is_emp_absent_after']['date'])->adddays($j)->format('Y-m-d');
                                        $before_date = Carbon::createFromFormat('Y-m-d', $wo_ho_response['is_emp_absent_before']['date'])->subdays($y)->format('Y-m-d');
                                        $day_before_date = Carbon::createFromFormat('Y-m-d', $after_date)->subdays()->format('Y-m-d');

                                        $is_emp_absent_before = $this->getAfterBeforeDateOfdate($before_date, $wo_ho_response['is_emp_absent_after']['user_id']);
                                        $is_emp_absent_day_before = $this->getAfterBeforeDateOfdate($day_before_date, $wo_ho_response['is_emp_absent_before']['user_id']);
                                        $is_emp_absent_after = $this->getAfterBeforeDateOfdate($after_date, $wo_ho_response['is_emp_absent_after']['user_id']);

                                        $after_status =   !empty($is_emp_absent_after) ? explode('/', $is_emp_absent_after->status) : null;
                                        $before_status =   !empty($is_emp_absent_before) ? explode('/', $is_emp_absent_before->status) : null;

                                        if (empty($after_status)) {


                                            $sandwidch_date =$this->checkEmployeeAbsentstatus($wo_ho_response['current_status'],$single_data['date'],$wo_ho_response['before_status'],$wo_ho_response['is_emp_absent_before']['date'],$wo_ho_response['after_status'],$wo_ho_response['is_emp_absent_after']['date'],$sandwidch_date);

                                            $count = false;

                                        }else{
                                            $sandwidch_date =$this->checkEmployeeAbsentstatus($wo_ho_response['current_status'],$single_data['date'],$wo_ho_response['before_status'],$wo_ho_response['is_emp_absent_before']['date'],$wo_ho_response['after_status'],$wo_ho_response['is_emp_absent_after']['date'],$sandwidch_date);

                                        }


                                        if (!empty($is_emp_absent_after)) {


                                            if ($is_emp_absent_after->status == "A") {

                                               // array_push($sandwidch_date, $single_data['date'], $wo_ho_response['is_emp_absent_before']['date'], $wo_ho_response['is_emp_absent_after']['date']);
                                                $count = true;
                                                $j++;

                                            } else if (in_array('HO', $after_status)) {

                                                array_push($sandwidch_date, ['date'=>$after_date,'status'=>'HO']);
                                                $count = true;
                                                $j++;
                                            } else if (in_array('P', $after_status)) {

                                                $count = false;
                                            } else {
                                                $day_before_status =   !empty($is_emp_absent_day_before) ? explode('/', $is_emp_absent_day_before->status) : null;

                                                if (!in_array('A', $day_before_status)) {

                                                    $sandwidch_date = [];
                                                    $j++;
                                                }
                                                $count = false;
                                            }
                                        }
                                        if (!empty($is_emp_absent_before)) {

                                            if (in_array('A', $before_status)) {
                                               // array_push($sandwidch_date, $before_date);
                                                $y++;
                                                $count = true;
                                            } else {
                                                $before_date = null;
                                                $is_emp_absent_day_before = null;
                                            }
                                        }
                                    }

                                }

                               $sandwidch_date = collect($sandwidch_date)->unique();
                                array_push($data_array, $sandwidch_date);

                                foreach ($sandwidch_date as $key => $single_date) {

                                    $update_empl_att_status = VmtEmpAttIntrTable::where('date', $single_date['date'])->where('user_id', $single_data['user_id'])->first();
                                    $update_empl_att_status->status =$single_date['status'][0].""."/SW";
                                    $update_empl_att_status->save();
                                }
                            }
                        }
                    }
                    $response = [
                        'status' => 'success',
                        'message' => 'sandwidch policy applied successfully',
                        'data' => $data_array
                    ];
                } else {
                    $response = [
                        'status' => 'failure',
                        'message' => 'you are not eligible to access sandwidch policy',
                        'data' => ''
                    ];
                }
            } else {
                $response = [
                    'status' => 'failure',
                    'message' => 'sandwidch policy is not enabled',
                    'data' => ''
                ];
            }
        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => 'Error while fetching data',
                'error' =>  $e->getMessage(),
                'error_verbose' => $e->getLine() . "  " . $e->getfile(),
            ];
        }
        return response()->json($response);
    }

    public function checkEmployeeAbsentstatus($current_status,$current_date,$before_status,$is_emp_absent_before,$after_status,$is_emp_absent_after,$sandwidch_date)
    {
        try {



            if(!in_array("A",$current_status)){

                array_push($sandwidch_date, ['date'=>$current_date,'status'=>$current_status]);

            }
            if(!in_array("A",$before_status)){

                array_push($sandwidch_date,['date'=>$is_emp_absent_before,'status'=>$before_status]);

            }
            if(!in_array("A",$after_status)){

                array_push($sandwidch_date, ['date'=>$is_emp_absent_after,'status'=>$after_status]);
            }

            return $sandwidch_date;
        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => 'Error while fetching data',
                'error' =>  $e->getMessage(),
                'error_verbose' => $e->getLine() . "  " . $e->getfile(),
            ];
        }
    }
    public function checkEmployeeSandwichstatus($date,$user_id)
    {
        try {

             $i=1;  $j=1;

            $after_date = Carbon::createFromFormat('Y-m-d',$date )->adddays($i)->format('Y-m-d');

            $get_employee_att_status = VmtEmpAttIntrTable::where('date', $after_date)->where('user_id', $user_id)->first();

            $after_status =   !empty($get_employee_att_status) ? explode('/', $get_employee_att_status->status) : null;

            if(!empty($after_status)?(in_array('WO',$after_status) || in_array('HO',$after_status)):false){

                $status =$after_status;
            }else{
                $status =[!empty($get_employee_att_status)?$get_employee_att_status->status:" "];
            }

            While(in_array('SW',$status)){

                 $get_employee_att_status = VmtEmpAttIntrTable::where('date', $after_date)->where('user_id', $user_id)->first();
                 $get_employee_att_status->status =$status[0];
                 $get_employee_att_status->save();
                    ++$i;

                  $after_date = Carbon::createFromFormat('Y-m-d',$date )->adddays($i)->format('Y-m-d');
                  $get_employee_att_status = VmtEmpAttIntrTable::where('date', $after_date)->where('user_id', $user_id)->first();
                  $after_status =   !empty($get_employee_att_status) ? explode('/', $get_employee_att_status->status) : null;

                if(in_array('WO',$after_status) || in_array('HO',$after_status)){

                    $status =$after_status;

                }else{
                    $status =[$get_employee_att_status->status];
                }

            }

            $before_date = Carbon::createFromFormat('Y-m-d',$date)->subdays($j)->format('Y-m-d');

            $get_employee_att_before_status = VmtEmpAttIntrTable::where('date', $before_date)->where('user_id', $user_id)->first();
            $before_status =   !empty($get_employee_att_before_status) ? explode('/', $get_employee_att_before_status->status) : null;

            if(!empty($after_status)?in_array('WO',$before_status) || in_array('HO',$before_status):false){

                $status = $before_status;
            }else{
                $status =[!empty($get_employee_att_before_status)?$get_employee_att_before_status->status:" "];
            }

            While(in_array('SW',$status)){

                 $get_employee_att_before_status = VmtEmpAttIntrTable::where('date', $before_date)->where('user_id', $user_id)->first();
                 $get_employee_att_before_status->status =$status[0];
                 $get_employee_att_before_status->save();
                    ++$j;

                  $before_date = Carbon::createFromFormat('Y-m-d',$date )->subdays($j)->format('Y-m-d');
                  $get_employee_att_before_status = VmtEmpAttIntrTable::where('date', $before_date)->where('user_id', $user_id)->first();
                  $before_status =   !empty($get_employee_att_before_status) ? explode('/', $get_employee_att_before_status->status) : null;

                if(in_array('WO',$before_status) || in_array('HO',$before_status)){

                    $status =$before_status;

                }else{
                    $status =[$get_employee_att_before_status->status];
                }
            }

        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => 'Error while fetching data',
                'error' =>  $e->getMessage(),
                'error_verbose' => $e->getLine() . "  " . $e->getfile(),
            ];
        }
    }
    public function getWeekoffHolidaySandwidchDetails($date, $user_id, $is_leave_applicable)
    {
        try {
            $response = array();

            $before_date = Carbon::createFromFormat('Y-m-d', $date)->subdays(1)->format('Y-m-d');
            $after_date = Carbon::createFromFormat('Y-m-d',   $date)->adddays(1)->format('Y-m-d');


            $is_emp_absent_current = $this->getAfterBeforeDateOfdate($date, $user_id);
            $is_emp_absent_before = $this->getAfterBeforeDateOfdate($before_date, $user_id);
            $is_emp_absent_after = $this->getAfterBeforeDateOfdate($after_date, $user_id);

            $current_status = explode('/', $is_emp_absent_current->status);
            $before_status = explode('/', $is_emp_absent_before->status);
            $after_status = explode('/', $is_emp_absent_after->status);

            $leave_type_array  = array("SL/CL", "SL/CL", "CL/SL", "LOP LE", "EL", "ML", "PTL", "OD", "PI", "CO", "CL", "FO L", "SL", "FO L");

            if (!empty($is_emp_absent_before) && !empty($is_emp_absent_after)) {

                //  if ((in_array('A', $before_status) && in_array('A', $after_status)) || ($is_leave_applicable == "1" ? (in_array($is_emp_absent_before->status, $leave_type_array) && in_array($is_emp_absent_after->status, $leave_type_array)) ? true : false : false)) {

                $response['is_emp_absent_before'] = $is_emp_absent_before->toarray();
                $response['is_emp_absent_after'] = $is_emp_absent_after->toarray();
                $response['before_status'] = $before_status;
                $response['after_status'] = $after_status;
                $response['current_status'] = $current_status;

                // } else {

                //     $response['is_emp_absent_before'] = $is_emp_absent_before->toarray();
                //     $response['is_emp_absent_after'] = $is_emp_absent_after->toarray();
                //     $response['before_status'] = $before_status;
                //     $response['after_status'] = $after_status;
                // }
            }
            return $response;
        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => 'Error while fetching data',
                'error' =>  $e->getMessage(),
                'error_verbose' => $e->getLine() . "  " . $e->getfile(),
            ];
        }
    }
    public function getAfterBeforeDateOfdate($date, $user_id)
    {
        $response = VmtEmpAttIntrTable::where('date', $date)->where('user_id', $user_id)->first();
        return $response;
    }


    public function fetchConsolidateReportData($start_date, $end_date, $department_id, $client_id)
    {
        // $start_date = '2023-04-26';  // For testing
        // $end_date = '2023-05-25';    // For testing

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
            $temp_ar = array();
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
            $heading_dates = array("Employee Code", "Employee Name", "Designation", "DOJ");
            $attendance_setting_details = $this->attendanceSettingsinfos(null);
            $reportresponse['rows'] = array();
            array_push($heading_dates, "Total Weekoff", "Total Holiday", "Total Present", "Total Absent", "Total Late LOP", "Total Leave", "Total Halfday", "Total On Duty");
            if ($attendance_setting_details['lc_status'] == 1) {
                array_push($heading_dates, 'Total LC');
            }
            if ($attendance_setting_details['eg_status'] == 1) {
                array_push($heading_dates, 'Total EG');
            }
            array_push($heading_dates, "Total Payable Days");
            $reportresponse['headers'] = $heading_dates;
            foreach ($users as $single_user) {
                $current_date = Carbon::parse($start_date);
                $temp_ar = array();
                $temp_ar['Employee Code'] = $single_user->user_code;
                $temp_ar['Employee Name'] = $single_user->name;
                $temp_ar['Designation'] = $single_user->designation;
                $temp_ar['DOJ'] = Carbon::parse($single_user->doj)->format('d-M-Y');
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
                $att_detail = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                    ->whereBetween('date', [$start_date, $end_date]);
                $total_weekoff = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                    ->whereBetween('date', [$start_date, $end_date])->where('status', 'like', 'WO%')->count();
                $total_holiday = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                    ->whereBetween('date', [$start_date, $end_date])->where('status', 'like', 'HO%')->count();
                $total_present = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                    ->whereBetween('date', [$start_date, $end_date])->where('status', 'like', 'P%')->count();
                $total_absent = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                    ->whereBetween('date', [$start_date, $end_date])->where('status', 'like', '%A%')->count();
                // $total_leave = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                //     ->whereBetween('date', [$start_date, $end_date])->orWhere('status', 'like', '%SL/CL%')
                //     ->orWhere('status', 'like', '%CL/SL%')
                //     ->orWhere('status', 'like', '%LOP LE%')
                //     ->orWhere('status', 'like', '%EL%')
                //     ->orWhere('status', 'like', '%ML%')
                //     ->orWhere('status', 'like', '%PTL%')
                //     ->orWhere('status', 'like', '%PI%')
                //     ->orWhere('status', 'like', '%CO%')
                //     ->orWhere('status', 'like', '%CL%')
                //     ->orWhere('status', 'like', '%SL%')
                //     ->orWhere('status', 'like', '%FO L%')
                //     ->count();

                $total_leave = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                    ->whereBetween('date', [$start_date, $end_date])
                    ->where('status', 'not like', '%A%')
                    ->where('status', 'not like', '%P%')
                    ->whereNotNull('emp_leave_id')
                    ->count();

                $total_half_day = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                    ->whereBetween('date', [$start_date, $end_date])->Where('status', 'like', '%HD%')->count();
                //  dd($total_half_day);
                $total_on_duty = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                    ->whereBetween('date', [$start_date, $end_date])->Where('status', 'like', '%OD%')->count();

                $total_present =  $total_present + $total_half_day / 2;
                $total_absent =  $total_absent + $total_half_day / 2;
                $temp_ar['Total Weekoff'] = $total_weekoff;
                $temp_ar['Total Holiday'] = $total_holiday;
                $temp_ar['Total Present'] =  $total_present;
                $temp_ar['Total Absent'] = $total_absent;
                $temp_ar['Total Late LOP'] = $total_late_lop;
                $temp_ar['Total Leave'] =  $total_leave;
                $temp_ar['Total Halfday'] = $total_half_day;
                $temp_ar['Total On Duty'] = $total_on_duty;
                if ($attendance_setting_details['lc_status'] == 1) {
                    $total_LC  = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                        ->whereBetween('date', [$start_date, $end_date])->where('status', 'like', '%LC%')->count();
                    $temp_ar['Total LC'] = $total_LC;
                }
                if ($attendance_setting_details['eg_status'] == 1) {
                    $total_EG = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                        ->whereBetween('date', [$start_date, $end_date])->where('status', 'like', '%EG%')->count();
                    $temp_ar['Total EG'] = $total_EG;
                }

                $total_payable_days = ($total_weekoff + $total_holiday + $total_present + $total_leave + $total_on_duty) - $total_late_lop;
                $temp_ar['Total Payable Days'] = $total_payable_days;
                array_push($reportresponse['rows'], $temp_ar);
                unset($temp_ar);
            }
            return $reportresponse;
        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => 'Error while fetching data',
                'error' =>  $e->getMessage(),
                'error_verbose' => $e->getLine() . "  " . $e->getfile(),
            ];
        }
        return $response;
    }


    public function fetchConsolidateReportDatav2($start_date, $end_date, $department_id, $client_id)
    {
        // $start_date = '2023-04-26';  // For testing
        // $end_date = '2023-05-25';    // For testing
        $month = '11'; //For Testing

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
            $temp_ar = array();
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
            $heading_dates = array("Employee Code", "Employee Name", "Designation", "DOJ");
            $attendance_setting_details = $this->attendanceSettingsinfos(null);
            $reportresponse['rows'] = array();
            $reportresponse['headers'] = array();
            array_push($heading_dates, "Total Weekoff", "Total Holiday", "Total Present", "Total Absent", "Total Late LOP", "Total Leave", "Total Halfday", "Total On Duty");
            if ($attendance_setting_details['lc_status'] == 1) {
                array_push($heading_dates, 'Total LC');
            }
            if ($attendance_setting_details['eg_status'] == 1) {
                array_push($heading_dates, 'Total EG');
            }
            array_push($heading_dates, "Total Payable Days");
            $reportresponse['headers'] = $heading_dates;
            foreach ($users as $single_user) {
                $temp_ar = array();
                $temp_ar['Employee Code'] = $single_user->user_code;
                $temp_ar['Employee Name'] = $single_user->name;
                $temp_ar['Designation'] = $single_user->designation;
                $temp_ar['DOJ'] = Carbon::parse($single_user->doj)->format('d-M-Y');
                $consol_query = VmtEmpAttConsolidate::whereMonth('month', $month)->where('user_id', $single_user->id)->first();
                $temp_ar['Total Weekoff'] = $consol_query->weekoff;
                $temp_ar['Total Holiday'] = $consol_query->holiday;
                $temp_ar['Total Present'] =  $consol_query->present;
                $temp_ar['Total Absent'] = $consol_query->absent;
                $temp_ar['Total Late LOP'] = $consol_query->lc_eg_lop;
                $temp_ar['Total Leave'] =  $consol_query->leave;
                $temp_ar['Total Halfday'] = $consol_query->halfday;
                $temp_ar['Total On Duty'] = $consol_query->on_duty;
                if ($attendance_setting_details['lc_status'] == 1) {
                    $temp_ar['Total LC'] = $consol_query->lc;
                }
                if ($attendance_setting_details['eg_status'] == 1) {
                    $temp_ar['Total EG'] = $consol_query->eg;
                }
                $temp_ar['Total Payable Days'] = $consol_query->payable_days;
                array_push($reportresponse['rows'], $temp_ar);
                unset($temp_ar);
            }
            return $reportresponse;
        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => 'Error while fetching data',
                'error' =>  $e->getMessage(),
                'error_verbose' => $e->getLine() . "  " . $e->getfile(),
            ];
        }
        return $response;
    }

    public function reCalculateConsoliData($start_date, $end_date, $month)
    {
        // dd($month);
        try {
            if (Carbon::parse($end_date)->gt(Carbon::today())) {
                $end_date = Carbon::today()->format('Y-m-d');
            }
            $users = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->where('is_ssa', '0')
                ->where('active',  "1")
                ->where('vmt_employee_details.doj', '<', Carbon::parse($end_date));
            $users =   $users->get(['users.id', 'users.user_code', 'users.name', 'vmt_employee_office_details.designation', 'vmt_employee_details.doj']);
            $attendance_setting_details = $this->attendanceSettingsinfos(null);
            foreach ($users as $single_user) {
                $current_date = Carbon::parse($start_date);
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
                $att_detail = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                    ->whereBetween('date', [$start_date, $end_date]);
                $total_weekoff = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                    ->whereBetween('date', [$start_date, $end_date])->where('status', 'like', 'WO%')->count();
                $total_holiday = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                    ->whereBetween('date', [$start_date, $end_date])->where('status', 'like', 'HO%')->count();
                $total_present = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                    ->whereBetween('date', [$start_date, $end_date])->where('status', 'like', 'P%')->count();
                $total_absent = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                    ->whereBetween('date', [$start_date, $end_date])->where('status', 'like', '%A%')->count();
                // $total_leave = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                //     ->whereBetween('date', [$start_date, $end_date])->orWhere('status', 'like', '%SL/CL%')
                //     ->orWhere('status', 'like', '%CL/SL%')
                //     ->orWhere('status', 'like', '%LOP LE%')
                //     ->orWhere('status', 'like', '%EL%')
                //     ->orWhere('status', 'like', '%ML%')
                //     ->orWhere('status', 'like', '%PTL%')
                //     ->orWhere('status', 'like', '%PI%')
                //     ->orWhere('status', 'like', '%CO%')
                //     ->orWhere('status', 'like', '%CL%')
                //     ->orWhere('status', 'like', '%SL%')
                //     ->orWhere('status', 'like', '%FO L%')
                //     ->count();

                $total_leave = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                    ->whereBetween('date', [$start_date, $end_date])
                    ->where('status', 'not like', '%A%')
                    ->where('status', 'not like', '%P%')
                    ->whereNotNull('emp_leave_id')
                    ->count();

                $total_half_day = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                    ->whereBetween('date', [$start_date, $end_date])->Where('status', 'like', '%HD%')->count();
                //  dd($total_half_day);
                $total_on_duty = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                    ->whereBetween('date', [$start_date, $end_date])->Where('status', 'like', '%OD%')->count();

                $total_present =  $total_present + $total_half_day / 2;
                $total_absent =  $total_absent + $total_half_day / 2;
                if ($attendance_setting_details['lc_status'] == 1) {
                    $total_LC  = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                        ->whereBetween('date', [$start_date, $end_date])->where('status', 'like', '%LC%')->count();
                }
                if ($attendance_setting_details['eg_status'] == 1) {
                    $total_EG = VmtEmpAttIntrTable::where('user_id', $single_user->id)
                        ->whereBetween('date', [$start_date, $end_date])->where('status', 'like', '%EG%')->count();
                }

                $total_payable_days = ($total_weekoff + $total_holiday + $total_present + $total_leave + $total_on_duty) - $total_late_lop;
                $vmt_emp_att_consol_intrtable = new VmtEmpAttConsolidate;
                $vmt_emp_att_consol_intrtable->month = $month;
                $vmt_emp_att_consol_intrtable->user_id = $single_user->id;
                $vmt_emp_att_consol_intrtable->weekoff = $total_weekoff;
                $vmt_emp_att_consol_intrtable->holiday = $total_holiday;
                $vmt_emp_att_consol_intrtable->present = $total_present;
                $vmt_emp_att_consol_intrtable->absent = $total_absent;
                $vmt_emp_att_consol_intrtable->lc_eg_lop = $total_late_lop;
                $vmt_emp_att_consol_intrtable->leave = $total_leave;
                $vmt_emp_att_consol_intrtable->halfday = $total_half_day;
                $vmt_emp_att_consol_intrtable->on_duty = $total_on_duty;
                $vmt_emp_att_consol_intrtable->lc = $total_LC;
                $vmt_emp_att_consol_intrtable->eg = $total_EG;
                $vmt_emp_att_consol_intrtable->payable_days = $total_payable_days;
                if (!($vmt_emp_att_consol_intrtable->save())) {
                    return $response = [
                        'status' => 'failure',
                        'message' => 'while saving in ConsolidateReportData',
                        'user_id' => $single_user->id

                    ];
                }
            }
            return  $response = [
                'status' => 'success',
                'message' => 'Consolidate Data updated',
            ];
        } catch (\Exception $e) {
            return $response = [
                'status' => 'failure',
                'message' => 'fetchConsolidateReportData',
                'error' =>  $e->getMessage(),
                'error_verbose' => $e->getLine() . "  " . $e->getfile(),
            ];
        }
    }
}
