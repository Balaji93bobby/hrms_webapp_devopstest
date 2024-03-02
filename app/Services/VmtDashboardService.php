<?php

namespace App\Services;

use App\Models\VmtEmployeesLeavesAccrued;
use App\Models\VmtEmployeeWorkShifts;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\VmtEmployeeAttendanceRegularization;
use App\Models\VmtEmployeeLeaves;
use Illuminate\Support\Facades\Storage;
use App\Models\VmtEmployeeDocuments;
use App\Models\VmtEmployee;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\vmtHolidays;
use App\Models\VmtEmployeeAttendance;
use App\Models\VmtEmpAttIntrTable;
use App\Models\VmtEmployeeCompensatoryLeave;
use App\Models\VmtLeaves;
use App\Models\VmtWorkShifts;
use App\Models\VmtClientMaster;
use App\Mail\VmtAttendanceMail_Regularization;
use App\Mail\RequestLeaveMail;
use App\Models\VmtOrgRoles;
use App\Models\VmtStaffAttendanceDevice;
use App\Models\VmtNotifications;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DatePeriod;
use DateInterval;
use \Datetime;
use App\Services\VmtAttendanceService;
use App\Services\VmtMasterConfigService;
use App\Services\VmtHolidayService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VmtDashboardService
{


    public function getMainDashboardData($user_code, VmtAttendanceService $serviceVmtAttendanceService, VmtHolidayService $serviceHolidayService)
    {

        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
            ],
            $rules = [
                'user_code' => 'required|exists:users,user_code',
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
            ]);
        }

        $response = array();
        $profile_pic = '';
        $employee_details_query = User::where('user_code', $user_code)->get(['id', 'user_code', 'name', 'avatar', 'org_role', 'active', 'client_id'])->first();
        $employee_designation = VmtEmployeeOfficeDetails::where('user_id', $employee_details_query->id)->first()->designation ?? '';


        $avatar_filename = User::where('id', $employee_details_query->id)->first()->avatar;

        //Get the image from PRIVATE disk and send as BASE64
        $get_profile_pic = Storage::disk('private')->get($user_code . "/profile_pics/" . $avatar_filename);


        if ($get_profile_pic) {
            $profile_pic = base64_encode($get_profile_pic);
        } else // If no file found, then send this
        {
            $profile_pic = null;
        }

        //Get the current year and month
        $year = (int) date("Y");
        $month = (int) date("m");
        // $day = date('d');
        // $present_count = 0;
        // $absent_count = 0;
        // $leave_count = 0;
        //dd( $user_code, $year,$month);
        //Get monthly attendance report data
        $attendance_DailyReport_PerMonth = $serviceVmtAttendanceService->fetchAttendanceDailyReport_PerMonth_v3($user_code, $year, $month);
        $attendance_DailyReport_PerMonth= json_decode($attendance_DailyReport_PerMonth->content(), true);


        //If there is some error in above line, then throw failure message
        if (!empty($attendance_DailyReport_PerMonth["status"]) && $attendance_DailyReport_PerMonth["status"] == 'failure') {
            return $attendance_DailyReport_PerMonth;
        }

        //Get the Month details array only.
        $array_att_month_details = $attendance_DailyReport_PerMonth['data'];

        // for ($i = 01; $i <= $day; $i++) {
        //     $month = date('m');
        //     if ($i < 10) {
        //         $i = '0' . $i;
        //     }
        //     $date = $year . '-' . $month . '-' . $i;
        //     if ($array_att_month_details[$date]['checkin_time'] || $array_att_month_details[$date]['checkout_time']) {
        //         $present_count++;
        //     } else if ($array_att_month_details[$date]['isAbsent']) {
        //         if ($array_att_month_details[$date]['absent_status'] == 'Approved') {
        //             $leave_count++;
        //         } else {
        //             $is_sunday_or_holiday = $serviceVmtAttendanceService->checkingGivenDateHolidayOrNot($year, $month, $i);
        //             if (!$is_sunday_or_holiday) {
        //                 $absent_count++;
        //             }
        //         }
        //     }
        // }


        $response['name'] = $employee_details_query->name;
        $response['user_id'] = $employee_details_query->id;
        $response['user_code'] = $employee_details_query->user_code;
        $response['designation'] = $employee_designation;
        $response['active'] = $employee_details_query->active;

        $response['client_code'] = VmtClientMaster::find($employee_details_query->client_id)->client_code;

        //Get the employee profile pic
        $response["profile_pic"] = $profile_pic; //BASE 64
        $response["org_role_id"] = $employee_details_query->org_role;
        $response["org_role_name"] = VmtOrgRoles::find($employee_details_query->org_role)->name;


        //Get the Present, Leave, Absent data from above JSON response
        // $response["attendance"]["present_count"] = $present_count;
        // $response["attendance"]["absent_count"] = $absent_count;
        // $response["attendance"]["leave_count"] = $leave_count;

        $response["attendance"] = $serviceVmtAttendanceService->fetchAttendanceDailyReport_PerMonth_v3_count($array_att_month_details);

        //Get current day attendance checkin/checkout status

        $response["attendance"]["current_day_attendance_status"] = $serviceVmtAttendanceService->fetchAttendanceStatus($user_code, date("Y-m-d"));
        //$response["holidays"] = $serviceHolidayService->getAllHolidays();
        $response["events"] = $this->getAllEventsDashboard($employee_details_query->client_id)->getData()->data;

        return response()->json([
            'status' => 'success',
            'message' => '',
            'data' => $response
        ]);
    }

    public function getAllUsersDOJ_DOB()
    {
        return User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
            ->get(['users.name', 'users.name', 'vmt_employee_details.doj', 'vmt_employee_details.dob']);
    }

    /*
        Events such as Birthday event, work anniversary, etc


    */
    public function getAllEventsDashboard($client_id)
    {

        try {

            // $client_id = null;
            // if (!empty(session('client_id'))) {

            //     if (session('client_id') == 1) {

            //         $client_id = VmtClientMaster::pluck('id')->toarray();
            //     } else {

            //         //    }else{

            //         $client_id = [session('client_id')];
            //     }
            // } else {
            //     $client_id = [auth()->user()->client_id];
            // }

            $array_client_ids = [];

            if (empty($client_id)) {
                return response()->json([
                    "status" => "failure",
                    "message" => "Unable to fetch Allevent since client id is null",
                    "data" => null,
                ]);
            } else {

                //If client_id=1 , then show events of all clients
                if ($client_id == 1) {
                    $array_client_ids = VmtClientMaster::all()->pluck('id');
                } else {
                    //Show the events for this client_id only .convert this to array
                    $array_client_ids[] = $client_id;

                }

            }

            // dd($array_client_ids);

            $employeesEventDetails = User::leftjoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                ->leftjoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->select(
                    'users.id',
                    'users.name',
                    'users.avatar',
                    'vmt_employee_office_details.designation',
                    'vmt_employee_details.dob',
                    'vmt_employee_details.doj'
                )
                ->where('users.is_ssa', '=', '0')
                ->where('users.active', '=', '1')
                ->whereIn('users.client_id', $array_client_ids)
                ->where('users.is_onboarded', '=', '1')
                ->whereNotNull('vmt_employee_details.doj')
                ->whereNotNull('vmt_employee_details.dob');
            // dd($employeesEventDetails->get());

            //Employee events for the current month only
            $dashboardEmployeeEventsData_birthday = $employeesEventDetails->whereMonth('vmt_employee_details.dob', '>=', Carbon::now()->month)
                ->whereMonth('vmt_employee_details.dob', '<=', Carbon::now()->month + 1)
                ->get()->sortBy(function ($singleData, $key) {
                    return Carbon::createFromFormat('Y-m-d', $singleData["dob"])->dayOfYear;
                });
            // dd($employeesEventDetails->get());
            $dashboardEmployeeEventsData_workanniversery = $employeesEventDetails
                ->whereMonth('vmt_employee_details.doj', '>=', Carbon::now()->month)
                ->whereMonth('vmt_employee_details.doj', '<=', Carbon::now()->month + 1)
                ->get()->sortBy(function ($singleData, $key) {
                    return Carbon::createFromFormat('Y-m-d', $singleData["doj"])->dayOfYear;
                });
            //    dd($dashboardEmployeeEventsData_workanniversery);
            $emp_event = [];
            foreach ($dashboardEmployeeEventsData_birthday as $single_emp_birthday) {

                $emp_birth_datails['id'] = $single_emp_birthday['id'];
                $emp_birth_datails['avatar'] = newgetEmployeeAvatarOrShortName($single_emp_birthday['id']);
                $emp_birth_datails['name'] = $single_emp_birthday['name'];
                //  $emp_birth_datails['avatar']  =  $single_emp_birthday['avatar'];
                $emp_birth_datails['designation'] = $single_emp_birthday['designation'];
                $emp_birth_datails['dob'] = $single_emp_birthday['dob'];
                $emp_birth_datails['doj'] = $single_emp_birthday['doj'];
                $emp_birth_datails['type'] = "birthday";

                array_push($emp_event, $emp_birth_datails);
            }


            foreach ($dashboardEmployeeEventsData_workanniversery as $single_emp_work) {

                $emp_work_datails['id'] = $single_emp_work['id'];
                $emp_work_datails['avatar'] = newgetEmployeeAvatarOrShortName($single_emp_work['id']);
                $emp_work_datails['name'] = $single_emp_work['name'];
                //  $emp_work_datails['avatar']  =  $single_emp_work['avatar'];
                $emp_work_datails['designation'] = $single_emp_work['designation'];
                $emp_work_datails['dob'] = $single_emp_work['dob'];
                $emp_work_datails['doj'] = $single_emp_work['doj'];
                $emp_work_datails['type'] = "work anniversery";

                array_push($emp_event, $emp_work_datails);
            }


            return response()->json([
                "status" => "success",
                "message" => "",
                "data" => $emp_event,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                "status" => "failure",
                "message" => "Unable to fetch Allevent",
                "data" => $e->getmessage(),
            ]);
        }
    }



    private function getAllEmployeeBirthdayDetails()
    {
    }

    private function getAllHolidays()
    {
    }


    public function performAttendanceCheckIn($checked)
    {


        $vmt_employee_workshift = VmtEmployeeWorkShifts::where('user_id', auth()->user()->id)->where('is_active', '1')->first();

        if (empty($vmt_employee_workshift->work_shift_id)) {
            return response()->json([
                'status' => 'failure',
                'message' => 'No work-shift has been assigned.Please contact Admin.',
                'data' => ""
            ]);
        }

        // $checked = $check_in;
        if ($checked == 'true') {

            //Check if the user already checked-out.
            $attendance = VmtEmployeeAttendance::where('user_id', auth()->user()->id)
                ->where('date', date('Y-m-d'))->first();

            $checkout_attendance = VmtEmployeeAttendance::where('user_id', auth()->user()->id)
                ->where('checkout_date', date('Y-m-d'))->first();

            $save_check_in_att_intermediate = VmtEmpAttIntrTable::where('user_id', auth()->user()->id)->where('date', date('Y-m-d'))->first();

            if (!empty($save_check_in_att_intermediate)) {

                if (empty($save_check_in_att_intermediate['checkin_time'])) {

                    $save_check_in_att_intermediate->vmt_employee_workshift_id = $vmt_employee_workshift->work_shift_id;
                    $save_check_in_att_intermediate->date = date('Y-m-d');
                    $save_check_in_att_intermediate->checkin_time = Carbon::now()->format('H:i:s');
                    $save_check_in_att_intermediate->attendance_mode_checkin = 'web';
                    $save_check_in_att_intermediate->checkin_date = date('Y-m-d');
                    $save_check_in_att_intermediate->save();
                } else {
                    return response()->json([
                        'status' => 'failure',
                        'message' => 'You have already Check-in for the day',
                        'time' => ""
                    ]);
                }
            } else {
                $save_check_in_att_intermediate = new VmtEmpAttIntrTable;
                $save_check_in_att_intermediate->user_id = auth()->user()->id;
                $save_check_in_att_intermediate->vmt_employee_workshift_id = $vmt_employee_workshift->work_shift_id;
                $save_check_in_att_intermediate->date = date('Y-m-d');
                $save_check_in_att_intermediate->checkin_time = Carbon::now()->format('H:i:s');
                $save_check_in_att_intermediate->attendance_mode_checkin = 'web';
                $save_check_in_att_intermediate->checkin_date = date('Y-m-d');
                $save_check_in_att_intermediate->save();
            }



            if (!empty($attendance->date) && !empty($attendance->checkin_time)) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Check-in already done',
                    'time' => ""
                ]);
            } else if (
                (!empty($attendance) && $checkout_attendance->date != date('Y-m-d')) &&
                !empty($checkout_attendance->checkout_date) && empty($checkout_attendance->checkin_time)
            ) {

                return response()->json([
                    'status' => 'failure',
                    'message' => 'Check-in already done',
                    'time' => ""
                ]);
            }

            $attendance = new VmtEmployeeAttendance;
            $attendance->user_id = auth()->user()->id;
            $attendance->date = date('Y-m-d');
            $currentTime = new DateTime("now", new \DateTimeZone('Asia/Kolkata'));
            $attendance->checkin_time = $currentTime;
            $attendance->vmt_employee_workshift_id = $vmt_employee_workshift->work_shift_id;
            $attendance->attendance_mode_checkin = "web";
            $attendance->save();


            //Check whether if its LC/EG
            // $regularization_type = checkRegularizationType($currentTime, "check-in");
            // $isSent = null;
            // $user_mail = VmtEmployeeOfficeDetails::where('user_id',$attendance->user_id)->first()->officical_mail;

            //Send mail if its LC
            // if( !empty($regularization_type) &&  $regularization_type == "LC")
            // {
            // dd("adsf");
            // $VmtClientMaster = VmtClientMaster::first();
            // $image_view = url('/') . $VmtClientMaster->client_logo;
            // $emp_avatar = json_decode(getEmployeeAvatarOrShortName(auth::user()->id),true);
            // dd($emp_avatar);
            // $isSent    = \Mail::to($user_mail)->send(new AttendanceCheckinCheckoutNotifyMail(
            //     auth::user()->name,
            //     auth::user()->user_code,
            //     Carbon::parse($attendance->date)->format('M jS, Y'),
            //     Carbon::parse($currentTime)->format('h:i:s A'),
            //     $image_view,
            //     $emp_avatar,
            //     request()->getSchemeAndHttpHost(),
            // Carbon::parse($leave_request_date)->format('M jS Y'),
            //     $regularization_type
            // ));
            //  }



            return response()->json([
                'status' => 'success',
                'message' => 'You have successfully checkedin!',
                'time' => $attendance->checkin_time,
                // 'regularization_type' => $regularization_type,
                // 'regularization_mail_sent' => $isSent ? "True" : $isSent
            ]);
        } else {

            $last_checkout_data = $this->fetchEmpLastAttendanceStatus(auth()->user()->user_code);
            $user_data = User::where('id', auth()->user()->id)->first();
            $attendance = VmtEmployeeAttendance::where('user_id', $user_data->id)
                ->where('date', date('Y-m-d'))
                ->first();
            if ($last_checkout_data['date'] == date('Y-m-d')) {

                $save_check_out_att_intermediate = VmtEmpAttIntrTable::where('user_id', auth()->user()->id)->where('date', date('Y-m-d'))->first();

            } else if (empty($last_checkout_data['checkout_date']) && empty($last_checkout_data['checkout_time'])) {

                $save_check_out_att_intermediate = VmtEmpAttIntrTable::where('user_id', auth()->user()->id)->where('date', $last_checkout_data['date'])->first();

            }

            if (!empty($save_check_out_att_intermediate)) {

                if (empty($save_check_out_att_intermediate['checkout_time'])) {
                    $save_check_out_att_intermediate->vmt_employee_workshift_id = $vmt_employee_workshift->work_shift_id;
                    $save_check_out_att_intermediate->date = (empty($last_checkout_data['checkout_date']) && empty($last_checkout_data['checkout_time'])) ? $last_checkout_data['date'] : date('Y-m-d');
                    $save_check_out_att_intermediate->checkout_time = Carbon::now()->format('H:i:s');
                    $save_check_out_att_intermediate->attendance_mode_checkout = 'web';
                    $save_check_out_att_intermediate->checkout_date = date('Y-m-d');
                    $save_check_out_att_intermediate->save();
                } else {
                    return response()->json([
                        'status' => 'failure',
                        'message' => 'You have already checked-out for the day',
                        'time' => ""
                    ]);
                }

            }



            if (!empty($attendance)) {
                if (!empty($attendance->checkin_date) && !empty($attendance->checkin_time)) {
                    return response()->json([
                        'status' => 'failure',
                        'message' => 'You have already checked-out for the day',
                        'time' => ""
                    ]);
                }
            }


            $checkout_time = null;




            $bio_att_checkin_id = \DB::table('vmt_staff_attenndance_device')
                ->select('id', 'user_Id', \DB::raw('min(date) as check_in_time'))
                ->whereDate('date', $last_checkout_data['checkin_date'])
                ->where('user_Id', $user_data->user_code)
                ->first(['check_in_time', 'date']);

            // dd(empty($last_checkout_data->checkout_date) && empty($last_checkout_data->checkout_time) && $last_checkout_data->attendance_mode_checkin ='biometric');
//dd(empty($attendance), $last_checkout_data['checkin_date'], empty($last_checkout_data['checkout_date']) , empty($last_checkout_data['checkout_time']) , $last_checkout_data['attendance_mode_checkin'] == 'biometric');

            if (empty($attendance) && empty($last_checkout_data['checkout_date']) && empty($last_checkout_data['checkout_time']) && $last_checkout_data['attendance_mode_checkin'] == 'biometric') {

                $attendance_bio_data = VmtEmployeeAttendance::where('user_id', $user_data->id)
                    ->where('date', $last_checkout_data['checkin_date'])->first();

                if (!empty($attendance_bio_data)) {
                    $attendance_bio_data = $attendance_bio_data;
                } else {
                    $attendance_bio_data = new VmtEmployeeAttendance;
                }

                $attendance_bio_data->user_id = auth()->user()->id;
                $attendance_bio_data->date = $last_checkout_data['checkin_date'];
                $attendance_bio_data->vmt_employee_workshift_id = $vmt_employee_workshift->work_shift_id;
                $currentTime = Carbon::now();
                $attendance_bio_data->checkout_time = $currentTime;
                $attendance_bio_data->checkout_date = Carbon::today()->toDateString();
                $attendance_bio_data->attendance_mode_checkin = "biometric";
                $attendance_bio_data->attendance_mode_checkout = "web";
                $attendance_bio_data->staff_attendance_id = $bio_att_checkin_id->id;
                $attendance_bio_data->save();
                $checkout_time = Carbon::parse($currentTime)->format('H:i:s');

            } else if (empty($last_checkout_data['checkout_date']) && empty($last_checkout_data['checkout_time']) && ($last_checkout_data['attendance_mode_checkin'] == 'web' || $last_checkout_data['attendance_mode_checkin'] == 'mobile')) {

                $attendance_web_data = VmtEmployeeAttendance::where('user_id', $user_data->id)
                    ->where('date', $last_checkout_data['checkin_date'])->first();

                $currentTime = new DateTime("now", new \DateTimeZone('Asia/Kolkata'));
                $attendance_web_data->checkout_time = $currentTime;
                $attendance_web_data->checkout_date = Carbon::today()->toDateString();
                $attendance_web_data->attendance_mode_checkout = "web";
                $attendance_web_data->save();
                $checkout_time = $attendance_web_data->checkout_time;
            } else if ($attendance->checkout_date == Carbon::today()->toDateString()) {

                $currentTime = new DateTime("now", new \DateTimeZone('Asia/Kolkata'));
                $attendance->checkout_time = $currentTime;
                $attendance->checkout_date = Carbon::today()->toDateString();
                $attendance->attendance_mode_checkout = "web";
                $attendance->save();
                $checkout_time = $attendance->checkout_time;
            } else {

                $attendance = VmtEmployeeAttendance::where('user_id', $user_data->id)
                    ->where('date', $last_checkout_data['checkin_date'])->first();
                $currentTime = new DateTime("now", new \DateTimeZone('Asia/Kolkata'));
                $attendance->checkout_time = $currentTime;
                $attendance->checkout_date = Carbon::today()->toDateString();
                $attendance->attendance_mode_checkout = "web";
                $attendance->save();
                $checkout_time = $attendance->checkout_time;
            }



            $user_details = $user_details = User::where('user_code', $user_code)->first();

            $checked = VmtEmpAttIntrTable::where('user_id', $user_details->id)->whereNotNull('checkin_time')->orderby('date', 'DESC')->first();
            //Get the time diff
            // $checked = VmtEmployeeAttendance::where('user_id', auth()->user()->id)
            //     ->where('checkout_date', $attendance_bio_data->checkout_date)
            //     ->first();
            if (!empty($checked->checkout_time)) {
                $to = Carbon::createFromFormat('H:i:s', $checked->checkout_time);
            }
            if (!empty($checked->checkin_time)) {
                $from = Carbon::createFromFormat('H:i:s', $checked->checkin_time);
            }

            if (!empty($from) && !empty($to)) {
                $effective_hours = gmdate('H:i:s', $to->diffInSeconds($from));
            }


            // dd($effective_hours);

            return response()->json([
                'status' => 'success',
                'message' => 'You have successfully checked out!',
                'time' => $checkout_time,
                'effective_hours' => $effective_hours,
            ]);
        }
    }




    public function fetchAttendanceDailyReport_PerMonth($user_code, $year, $month)
    {
        try {

            //Get the user_code
            $user_id = User::where('user_code', $user_code)->first()->id;


            //TODO : Hardcoded now. Need to fetch based on assigned shift for this employee

            $regularTime = VmtWorkShifts::join('vmt_employee_workshifts', 'vmt_work_shifts.id', '=', 'vmt_employee_workshifts.work_shift_id')
                ->where('vmt_employee_workshifts.is_active', '1')
                ->where('vmt_employee_workshifts.user_id', $user_id);

            if ($regularTime->exists()) {
                $regularTime = $regularTime->first();
            } else {
                $regularTime = VmtWorkShifts::where('shift_name', 'First Shift')->first();
            }

            ////Fetch the attendance reports
            //Create date array
            $requestedDate = $year . '-' . $month . '-01';
            $currentDate = Carbon::now();
            $monthDateObj = Carbon::parse($requestedDate);
            $startOfMonth = $monthDateObj->startOfMonth(); //->format('Y-m-d');
            $endOfMonth = $monthDateObj->endOfMonth(); //->format('Y-m-d');

            // dd($endOfMonth);


            if ($currentDate->lte($endOfMonth)) {
                $lastAttendanceDate = $currentDate; //->format('Y-m-d');
            } else {
                $lastAttendanceDate = $endOfMonth; //->format('Y-m-d');
            }



            $totalDays = $lastAttendanceDate->format('d');
            $firstDateStr = $monthDateObj->startOfMonth()->toDateString();


            // attendance details from vmt_staff_attenndance_device table
            $deviceData = [];
            for ($i = 0; $i < ($totalDays); $i++) {
                // code...
                $dayStr = Carbon::parse($firstDateStr)->addDay($i)->format('l');

                if ($dayStr != 'Sunday') {

                    $dateString = Carbon::parse($firstDateStr)->addDay($i)->format('Y-m-d');

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

                    $deviceCheckOutTime = empty($attendanceCheckOut->check_out_time) ? null : explode(' ', $attendanceCheckOut->check_out_time)[1];
                    $deviceCheckInTime = empty($attendanceCheckIn->check_in_time) ? null : explode(' ', $attendanceCheckIn->check_in_time)[1];

                    if ($deviceCheckOutTime != null || $deviceCheckInTime != null) {
                        $deviceData[] = array(
                            'date' => $dateString,
                            'checkin_time' => $deviceCheckInTime,
                            'checkout_time' => $deviceCheckOutTime,
                            'attendance_mode_checkin' => 'biometric',
                            'attendance_mode_checkout' => 'biometric'
                        );
                    }
                }
            }

            // attendance details from vmt_employee_attenndance table
            $attendance_WebMobile = VmtEmployeeAttendance::where('user_id', $user_id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->orderBy('checkin_time', 'asc')
                ->get(['date', 'checkin_time', 'checkout_time', 'attendance_mode_checkin', 'attendance_mode_checkout', 'selfie_checkin', 'selfie_checkout']);

            $attendanceResponseArray = [];

            //Create empty month array with all dates.

            if ($month < 10)
                $month = "0" . $month;


            $days_count = date('t', mktime(0, 0, 0, $month, 1, $year));


            for ($i = 1; $i <= $totalDays; $i++) {
                $date = "";

                if ($i < 10)
                    $date = "0" . $i;
                else
                    $date = $i;

                $fulldate = $year . "-" . $month . "-" . $date;

                $attendanceResponseArray[$fulldate] = array(
                    "user_id" => $user_id,
                    "isAbsent" => false,
                    "attendance_mode_checkin" => null,
                    "attendance_mode_checkout" => null,
                    "absent_status" => null,
                    "leave_type" => null,
                    "checkin_time" => null,
                    "checkout_time" => null,
                    "selfie_checkin" => null,
                    "selfie_checkout" => null,
                    "isLC" => false,
                    "lc_status" => null,
                    "lc_reason" => null,
                    "lc_reason_custom" => null,
                    "isEG" => false,
                    "eg_status" => null,
                    "eg_reason" => null,
                    "eg_reason_custom" => null,
                    "isMIP" => false,
                    "mip_status" => null,
                    "isMOP" => false,
                    "mop_status" => null
                );

                //echo "Date is ".$fulldate."\n";
                ///$month_array[""]
            }


            // merging result from both table
            $merged_attendanceData = array_merge($deviceData, $attendance_WebMobile->toArray());
            $dateCollectionObj = collect($merged_attendanceData);

            $sortedCollection = $dateCollectionObj->sortBy([
                ['date', 'asc'],
            ]);

            $dateWiseData = $sortedCollection->groupBy('date'); //->all();
            //dd($merged_attendanceData);
            //dd($dateWiseData);

            foreach ($dateWiseData as $key => $value) {

                // dd($value[0]);

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

                //selfies
                //format : http://127.0.0.1:8000/employees/PLIPL068/selfies/checkout.png
                if ($singleValue["checkin_time"] && !empty($singleValue["selfie_checkin"]))
                    $attendanceResponseArray[$key]["selfie_checkin"] = 'employees/' . $user_code . '/selfies/' . $singleValue["selfie_checkin"];

                if ($singleValue["checkout_time"] && !empty($singleValue["selfie_checkout"]))
                    $attendanceResponseArray[$key]["selfie_checkout"] = 'employees/' . $user_code . '/selfies/' . $singleValue["selfie_checkout"];
            }
            //dd($attendanceResponseArray);

            $shiftStartTime = Carbon::parse($regularTime->shift_start_time);
            $shiftEndTime = Carbon::parse($regularTime->shift_end_time);


            //dd($regularTime);
            ////Logic to check LC,EG,MIP,MOP,Leave status
            foreach ($attendanceResponseArray as $key => $value) {

                $checkin_time = $attendanceResponseArray[$key]["checkin_time"];
                $checkout_time = $attendanceResponseArray[$key]["checkout_time"];


                //LC Check
                if (!empty($checkin_time)) {

                    $parsedCheckIn_time = Carbon::parse($checkin_time);

                    //Check whether checkin done on-time
                    $isCheckin_done_ontime = $parsedCheckIn_time->lte($shiftStartTime);

                    if ($isCheckin_done_ontime) {
                        //employee came on time....

                    } else {
                        //employee came on time....
                        //dd("Checkin NOT on-time");

                        //then LC
                        $attendanceResponseArray[$key]["isLC"] = true;

                        //check whether regularization applied.
                        $regularization_status = $this->isRegularizationRequestApplied($user_id, $key, 'LC');

                        //check regularization status
                        $attendanceResponseArray[$key]["lc_status"] = $regularization_status;
                    }
                }

                //EG Check
                //check if its EG
                if (!empty($checkout_time)) {

                    $parsedCheckOut_time = Carbon::parse($checkout_time);

                    //Check whether checkin done on-time
                    $isCheckOut_doneEarly = $parsedCheckOut_time->lte($shiftEndTime);

                    if ($isCheckOut_doneEarly) {
                        //employee left early on time....

                        //then EG
                        $attendanceResponseArray[$key]["isEG"] = true;

                        //check whether regularization applied.
                        $regularization_status = $this->isRegularizationRequestApplied($user_id, $key, 'EG');

                        //check regularization status
                        $attendanceResponseArray[$key]["eg_status"] = $regularization_status;
                    } else {
                        //employee left late

                    }
                }


                //for absent
                if ($checkin_time == null && $checkout_time == null) {

                    $attendanceResponseArray[$key]["isAbsent"] = true;

                    //Check whether leave is applied or not.
                    $t_leaveRequestDetails = $this->isLeaveRequestApplied($user_id, $key, $year, $month);

                    if (empty($t_leaveRequestDetails)) {

                        $attendanceResponseArray[$key]["absent_status"] = "Not Applied";
                        $attendanceResponseArray[$key]["leave_type"] = null;
                    } else {
                        $attendanceResponseArray[$key]["absent_status"] = $t_leaveRequestDetails->status;
                        $attendanceResponseArray[$key]["leave_type"] = $t_leaveRequestDetails->leave_type;
                    }
                } elseif ($checkin_time != null && $checkout_time == null) {

                    //Since its MOP

                    $attendanceResponseArray[$key]["isMOP"] = true;

                    ////Is any permission applied
                    $attendanceResponseArray[$key]["mop_status"] = $this->isRegularizationRequestApplied($user_id, $key, 'MOP');

                    if ($attendanceResponseArray[$key]["mop_status"] == "Approved") {

                        //If Approved, then set the regularize time as checkin time
                        $attendanceResponseArray[$key]["checkout_time"] = VmtEmployeeAttendanceRegularization::where('attendance_date', $key)
                            ->where('user_id', $user_id)->where('regularization_type', 'MOP')->first()->regularize_time;

                        //  $attendanceResponseArray[$key]["checkin_time"] = ""
                    }
                } elseif ($checkin_time == null && $checkout_time != null) {

                    //Since its MIP
                    $attendanceResponseArray[$key]["isMIP"] = true;

                    ////Is any permission applied
                    $attendanceResponseArray[$key]["mip_status"] = $this->isRegularizationRequestApplied($user_id, $key, 'MIP');

                    if ($attendanceResponseArray[$key]["mip_status"] == "Approved") {

                        //If Approved, then set the regularize time as checkin time
                        $attendanceResponseArray[$key]["checkin_time"] = VmtEmployeeAttendanceRegularization::where('attendance_date', $key)
                            ->where('user_id', $user_id)->where('regularization_type', 'MIP')->first()->regularize_time;

                        //  $attendanceResponseArray[$key]["checkin_time"] = ""
                    }
                }
            } //for each

            // return ($attendanceResponseArray);


            $count = 0;
            $count1 = 0;
            $count2 = 0;


            foreach ($attendanceResponseArray as $key => $attendancedash) {
                //dd($attendanceResponseArray);
                $dayStr = Carbon::parse($key)->format('l');

                $is_holiday = VmtHolidays::where('holiday_date', $key);

                if ($attendancedash['isAbsent'] && $attendancedash['absent_status'] != "Approved" && $dayStr != "Sunday" && $is_holiday->doesntExist()) {
                    $count++;
                }
                if (!$attendancedash['isAbsent'] || $attendancedash['absent_status'] == "Approved" || $dayStr == "Sunday" || $is_holiday->exists()) {
                    $count1++;
                }

                if ($attendancedash['absent_status'] == "Approved" && $dayStr != "Sunday" && $is_holiday->doesntExist()) {
                    $count2++;
                }
            }

            $current_mnth = ["absent" => $count, "present" => $count1, "not_applied" => $count2];

            //array_push($res, $current_mnth);

            return response()->json([
                "status" => "success",
                "message" => "",
                "data" => $current_mnth,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                "status" => "failure",
                "message" => "Unable to fetch attenance report per_month",
                "data" => $e->getTraceAsString(),
            ]);
        }
    }

    private function isRegularizationRequestApplied($user_id, $attendance_date, $regularizeType)
    {

        $regularize_record = VmtEmployeeAttendanceRegularization::where('attendance_date', $attendance_date)
            ->where('user_id', $user_id)->where('regularization_type', $regularizeType);

        // dd($user_id ." , ". $attendance_date." , ".$regularizeType);

        if ($regularize_record->exists()) {
            return $regularize_record->first()->status;
        } else {
            return "None";
        }
    }


    public function isLeaveRequestApplied($user_id, $attendance_date, $year, $month)
    {
        // dd($attendance_date);

        $leave_Details = VmtEmployeeLeaves::join('vmt_leaves', 'vmt_leaves.id', '=', 'vmt_employee_leaves.leave_type_id')
            ->where('user_id', $user_id)
            ->whereYear('end_date', $year)
            ->whereMonth('end_date', $month)
            ->get(['start_date', 'end_date', 'status', 'vmt_leaves.leave_type', 'total_leave_datetime']);

        // dd($leave_Details);

        if ($leave_Details->count() == 0) {
            return null;
        } else {
            $single_leave_details = "";
            foreach ($leave_Details as $single_leave_details) {
                $startDate = Carbon::parse($single_leave_details->start_date)->subDay();
                $endDate = Carbon::parse($single_leave_details->end_date);
                $currentDate = Carbon::parse($attendance_date);
                // echo $currentDate;
                //dd($startDate.'-----'.$currentDate.'------------'.$endDate.'-----');
                if ($currentDate->gt($startDate) && $currentDate->lte($endDate)) {

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

    public function getNotifications($user_code)
    {
        //Validate
        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
            ],
            $rules = [
                'user_code' => 'required|exists:users,user_code',
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

            $user_id = User::where('user_code', $user_code)->first()->id;

            //Get the user record and update avatar column
            $query_notifications = User::join('vmt_notifications', 'vmt_notifications.user_id', '=', 'users.id')
                ->where('users.id', $user_id)
                ->where('vmt_notifications.is_read', '0')->get();

            return response()->json([
                "status" => "success",
                "message" => "",
                "data" => $query_notifications,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                "status" => "failure",
                "message" => "Unable to fetch notifications",
                "data" => $e,
            ]);
        }
    }

    public function readNotification($record_id)
    {

        $validator = Validator::make(
            $data = [
                'record_id' => $record_id,
            ],
            $rules = [
                'record_id' => 'required|exists:vmt_notifications,id',
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


        $get_notification = VmtNotifications::where('id', $record_id)->first();

        if ($get_notification) {
            $get_notification->is_read = "1";
            $get_notification->save();
        }
    }





    public function getEmployeeLeaveBalanceDashboards($user_id, $start_time_period, $end_time_period)
    {
        // TODO:: Which Leave Types we Have to Find availed And Balance //Need To Change In Setting Page

        //  $visible_leave_types = array('Casual/Sick Leave'=>1,'Earned Leave'=>2);

        try {

            $leave_balance_for_all_types = array();
            $availed_leaves = array();
            $response = array();
            $accrued_leave_types = VmtLeaves::get();
            $temp_leave = array();
            $gender = VmtEmployee::where('userid', $user_id);
            if ($gender->exists()) {
                $gender = $gender->first()->gender;
            } else {
                $gender = '';
            }
            if (empty($gender) || $gender == null) {
                $gender = '';
            } else {
                $gender = strtolower($gender);
            }
            if ($gender == 'male') {
                $remove_leave = 'Maternity Leave';
            } else if ($gender == 'female') {
                $remove_leave = 'Paternity Leave';
            } else {
                $remove_leave = 'no leave';
            }
            foreach ($accrued_leave_types as $single_leave_types) {
                if ($single_leave_types->leave_type == $remove_leave) {
                    continue;
                    // dd($single_leave_types->leave_type);
                }
                if ($single_leave_types->is_finite == 1) {
                    if ($single_leave_types->is_carry_forward != 1) {
                        $total_availed_leaves = VmtEmployeeLeaves::where('user_id', $user_id)
                            ->whereBetween('start_date', [$start_time_period, $end_time_period])
                            ->where('leave_type_id', $single_leave_types->id)
                            ->whereIn('status', array('Approved', 'Pending'))
                            ->sum('total_leave_datetime');
                        $total_accrued = VmtEmployeesLeavesAccrued::where('user_id', $user_id)
                            ->whereBetween('date', [$start_time_period, $end_time_period])
                            ->where('leave_type_id', $single_leave_types->id)
                            ->sum('accrued_leave_count');
                        if ($single_leave_types->leave_type == 'Compensatory Off') {
                            $leave_balance = count($this->fetchUnusedCompensatoryOffDays($user_id));
                        } else {
                            $leave_balance = $total_accrued - $total_availed_leaves;
                            $leave_balance_for_all_types[$single_leave_types->leave_type] = $leave_balance;
                            $availed_leaves[$single_leave_types->leave_type] = $total_availed_leaves;
                        }
                        $temp_leave['leave_type'] = $single_leave_types->leave_type;
                        $temp_leave['leave_balance'] = $leave_balance;
                        $temp_leave['availed_leaves'] = $total_availed_leaves;
                        // $leave_balance_for_all_types[$single_leave_types->leave_type]= $leave_balance;
                        // $availed_leaves[$single_leave_types->leave_type] =  $total_availed_leaves ;
                        //$temp_leave=array('leave_type'=>$single_leave_types->leave_type,'leave_balance'=>$leave_balance,'availed_leaves'=>$total_availed_leaves);

                    } else if ($single_leave_types->is_carry_forward == 1) {

                        $total_accrued = VmtEmployeesLeavesAccrued::where('user_id', $user_id)
                            ->where('leave_type_id', $single_leave_types->id)
                            ->sum('accrued_leave_count');
                        $total_availed_leaves = VmtEmployeeLeaves::where('user_id', $user_id)
                            ->whereBetween('start_date', [$start_time_period, $end_time_period])
                            ->where('leave_type_id', $single_leave_types->id)
                            ->whereIn('status', array('Approved', 'Pending'))
                            ->sum('total_leave_datetime');
                        $leave_balance = $total_accrued - $total_availed_leaves;
                        // $leave_balance_for_all_types[$single_leave_types->leave_type] = $leave_balance;
                        // $availed_leaves[$single_leave_types->leave_type] =  $total_availed_leaves ;
                        $temp_leave['leave_type'] = $single_leave_types->leave_type;
                        $temp_leave['leave_balance'] = $leave_balance;
                        $temp_leave['availed_leaves'] = $total_availed_leaves;
                    }
                } else {
                    $total_availed_leaves = VmtEmployeeLeaves::where('user_id', $user_id)
                        ->whereBetween('start_date', [$start_time_period, $end_time_period])
                        ->where('leave_type_id', $single_leave_types->id)
                        ->whereIn('status', array('Approved', 'Pending'))
                        ->sum('total_leave_datetime');
                    $availed_leaves[$single_leave_types->leave_type] = $total_availed_leaves;
                    $temp_leave['leave_type'] = $single_leave_types->leave_type;
                    $temp_leave['leave_balance'] = 0;
                    $temp_leave['availed_leaves'] = $total_availed_leaves;
                }
                array_push($response, $temp_leave);

                unset($temp_leave);
            }
            $leave_details = array('Leave Balance' => $leave_balance_for_all_types, 'availed Leaves' => $availed_leaves);
            // return $response;
            return response()->json([
                "status" => "success",
                "message" => "",
                "data" => $response,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                "status" => "failure",
                "message" => "Unable to fetch LeaveBalance",
                "data" => $e,
                "line" => $e->getTraceAsString()
            ]);
        }
    }

    public function fetchUnusedCompensatoryOffDays($user_id)
    {

        $final_emp_unused_compdays = array();

        //Get all the comp work days
        $emp_comp_off_days = $this->fetchEmployeeCompensatoryOffDays($user_id);

        //dd($emp_comp_off_days);

        //Check whether its used or not ( Leave request should be Rejected or Not applied)
        //// Create a new array with (k,v)=(attendance_id, [attendance_id, attendance_date])

        $map_comp_off_days = array();

        foreach ($emp_comp_off_days as $singleDay) {
            //$map_comp_off_days[ $singleDay["id"] ] = $singleDay["date"];
            // array_push($map_comp_off_days, array("emp_attendance_id" => $singleDay["id"],
            //                                      "emp_attendance_date" => $singleDay["date"]));
            $map_comp_off_days[$singleDay["id"]] = array(
                "emp_attendance_id" => $singleDay["id"],
                "emp_attendance_date" => $singleDay["date"]
            );
            //dd($singleDay["id"]);
        }


        //Check whether the comp days exists in this table
        $query_emp_comp_leaves = VmtEmployeeCompensatoryLeave::whereIn('employee_attendance_id', array_keys($map_comp_off_days))->get(['employee_leave_id', 'employee_attendance_id']);

        // $i = 0;
        //Check whether its leave request is Rejected
        foreach ($query_emp_comp_leaves as $singleEmpCompLeave) {
            //dd($singleEmpCompLeave);
            $emp_leave = VmtEmployeeLeaves::find($singleEmpCompLeave->employee_leave_id);
            if ($emp_leave->exists()) {
                //dd($emp_leave->status);
                //check the leave status
                if ($emp_leave->status != "Rejected") {
                    //Remove from $map_comp_off_days
                    unset($map_comp_off_days[$singleEmpCompLeave->employee_attendance_id]);
                }
            } else {
                dd("ERROR : employee_leave_id " . $singleEmpCompLeave . " doesnt exist in vmt_employee_leave table.");
            }
        }

        //Remove the keys and send only the values.
        return array_values($map_comp_off_days);
    }

    public function fetchEmployeeCompensatoryOffDays($user_id)
    {

        //Need to move to separate table settings
        $work_leave_days = ['Sunday'];

        //Final array response
        //Get list of holidays
        $query_holidays = vmtHolidays::selectRaw('DATE(holiday_date) as holiday_date')->pluck('holiday_date');

        //Remove the year part
        $query_holidays = $query_holidays->map(function ($item, $key) {
            return substr($item, 5);
        });

        $array_query_holidays = $query_holidays->toArray();

        //Get list of attendance days
        $query_emp_attendanceDetails = VmtEmployeeAttendance::where('user_id', $user_id)->get(['id', 'date'])->keyBy('date')->toArray();
        //dd($query_emp_attendanceDetails);

        //Get only the keys
        $dates_emp_attendanceDetails = array_keys($query_emp_attendanceDetails);
        //dd($dates_emp_attendanceDetails);


        foreach ($dates_emp_attendanceDetails as $singleAttendanceDate) {

            ////Need to check whether the given date is in holiday AND given date is in leave days(Eg : Sunday , saturday)
            $timestamp = strtotime($singleAttendanceDate);
            $day = date('l', $timestamp);

            //Test : Checking whether emp worked in work_leave_days
            /*
                    if(in_array($day, $work_leave_days)){
                     dd("Worked in leave days : ".$singleAttendanceDate);
                    }else
                    {
                       dd("Not Worked in leave days : ".$singleAttendanceDate);

                    }
                */
            //Test : End

            $trimmed_date = substr($singleAttendanceDate, 5);


            //Check whether not worked in Holidays or not in work_leave days
            if (!in_array($trimmed_date, $array_query_holidays) && !in_array($day, $work_leave_days)) {
                //If not in holiday, then remove from array
                unset($query_emp_attendanceDetails[$singleAttendanceDate]);
            }
        }

        //dd($query_emp_attendanceDetails);

        return $query_emp_attendanceDetails;
    }

    public function getAllNewDashboardDetails($user_id, $start_time_period, $end_time_period, $year, $month, VmtAttendanceService $serviceVmtAttendanceService)
    {

        $user_code = auth()->user()->user_code;
        $client_id = auth()->user()->client_id;

        try {

            $getAllEvent = $this->getAllEventsDashboard($client_id);
            $getEmpLeaveBalance = $this->getEmployeeLeaveBalanceDashboards($user_id, $start_time_period, $end_time_period);
            $getAttenanceReportpermonth = $serviceVmtAttendanceService->fetchAttendanceDailyReport_PerMonth_v3($user_code, $year, $month);
            $getAttenanceReportpermonth = $getAttenanceReportpermonth->getData(true)['data'];


            $getAttendanceLoginCount = $this->getOrgDashBoardDeatail();
            return response()->json(
                [
                    "all_events" => json_decode($getAllEvent->content(), true)['data'],
                    "leave_balance_per_month" => json_decode($getEmpLeaveBalance->content(), true)['data'],
                    "attenance_report_permonth" => $serviceVmtAttendanceService->fetchAttendanceDailyReport_PerMonth_v3_count($getAttenanceReportpermonth),
                    "attendance_login_count" => $getAttendanceLoginCount,
                ]
            );
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Unable to fetch Attendance details",
                "data" => $e->getTraceAsString(),
            ]);
        }
    }
    // public function fetchEmpLastAttendanceStatus($user_code)
    // {

    //     //Web/bio/mobile attendance
    //     try {
    //         $response = null;

    //         $query_web_mobile_response = VmtEmployeeAttendance::join('users', 'users.id', '=', 'vmt_employee_attendance.user_id')
    //             ->join('vmt_work_shifts', 'vmt_work_shifts.id', '=', 'vmt_employee_attendance.vmt_employee_workshift_id')
    //             ->where('users.user_code', $user_code)
    //             ->orderBy('vmt_employee_attendance.date', 'desc')
    //             ->first([
    //                 'users.user_code as employee_code',
    //                 'vmt_employee_attendance.date',
    //                 'vmt_employee_attendance.checkin_time as checkin_time',
    //                 'vmt_employee_attendance.date as checkin_date',
    //                 'vmt_employee_attendance.checkout_time as checkout_time',
    //                 'vmt_employee_attendance.checkout_date as checkout_date',
    //                 'vmt_employee_attendance.attendance_mode_checkin as attendance_mode_checkin',
    //                 'vmt_employee_attendance.attendance_mode_checkout as attendance_mode_checkout',
    //             ]);

    //         // Biometric
    //         $query_biometric_response = \DB::table('vmt_staff_attenndance_device')->leftjoin('users', 'users.user_code', '=', 'vmt_staff_attenndance_device.user_Id')
    //             ->leftjoin('vmt_employee_workshifts', 'vmt_employee_workshifts.user_id', '=', 'users.id')
    //             ->leftjoin('vmt_work_shifts', 'vmt_work_shifts.id', '=', 'vmt_employee_workshifts.work_shift_id')
    //             ->where('users.user_code', $user_code)
    //             ->orderby('vmt_staff_attenndance_device.date', 'desc')
    //             ->first([
    //                 'users.user_code as employee_code',
    //                 'vmt_staff_attenndance_device.date'
    //             ]);

    //         if (!empty($query_biometric_response)) {
    //             $query_biometric_response->checkin_time = null;
    //             $query_biometric_response->checkin_date = null;
    //             $query_biometric_response->checkout_time = null;
    //             $query_biometric_response->checkout_date = null;
    //             $query_biometric_response->attendance_mode_checkin = null;
    //             $query_biometric_response->attendance_mode_checkout = null;
    //         }


    //         //dd($query_biometric_response,$query_web_mobile_response);
    //         //get dates from emp_attedance and staff_attedance and store it in an array

    //         $boimetric_basic_attedance_date = array();
    //         $query_web_mobile_response_date = null;
    //         if (!empty($query_web_mobile_response)) {
    //             array_push($boimetric_basic_attedance_date, $query_web_mobile_response->date);
    //             $query_web_mobile_response_date = date("Y-m-d", strtotime($query_web_mobile_response->date));
    //         }

    //         $query_biometric_response_date = null;
    //         if (!empty($query_biometric_response)) {
    //             array_push($boimetric_basic_attedance_date, $query_biometric_response->date);
    //             $query_biometric_response_date = date("Y-m-d", strtotime($query_biometric_response->date));
    //         }


    //         //Compare which one is recent date
    //         $recent_attedance_data = null;
    //         if (!empty($query_biometric_response) || !empty($query_web_mobile_response)) {
    //             $max = max(array_map('strtotime', $boimetric_basic_attedance_date));
    //             $recent_attedance_data =  date('Y-m-d', $max);
    //         }

    //         $user_data = User::where('user_code', $user_code)->first();
    //         $user_client_code = VmtClientMaster::find($user_data->client_id ?? "1");
    //         $user_client_code = $user_client_code->client_code;

    //         if (
    //             $user_client_code == "ABS" || $user_client_code == "DMC" ||
    //             $user_client_code == "DM" ||  $user_client_code == "VASA GROUPS" || $user_client_code == "PSC" || $user_client_code == "IMA"  || $user_client_code == "LAL"
    //             || $user_client_code == "PLIPL"
    //         ) {

    //             $bio_attendanceCheckIn = \DB::table('vmt_staff_attenndance_device')
    //                 ->select('user_Id', \DB::raw('MIN(date) as check_in_time'))
    //                 ->whereDate('date', $recent_attedance_data)
    //                 ->where('user_Id', $user_code)
    //                 ->first(['check_in_time', 'date']);

    //             // if($dateString == "2023-07-05")
    //             //     dd($dateString);
    //             $bio_attendanceCheckOut = \DB::table('vmt_staff_attenndance_device')
    //                 ->select('user_Id', \DB::raw('MAX(date) as check_out_time'))
    //                 ->whereDate('date', $recent_attedance_data)
    //                 ->where('user_Id', $user_code)
    //                 ->first(['check_out_time', 'date']);
    //         } else //If direction is only "in" and "out"
    //         {
    //             $bio_attendanceCheckIn = \DB::table('vmt_staff_attenndance_device')
    //                 ->select('user_Id', \DB::raw('MIN(date) as check_in_time'))
    //                 ->whereDate('date', $recent_attedance_data)
    //                 ->where('direction', 'in')
    //                 ->where('user_Id', $user_code)
    //                 ->first(['check_in_time', 'date']);

    //             $bio_attendanceCheckOut = \DB::table('vmt_staff_attenndance_device')
    //                 ->select('user_Id', \DB::raw('MAX(date) as check_out_time'))
    //                 ->whereDate('date', $recent_attedance_data)
    //                 ->where('direction', 'out')
    //                 ->where('user_Id', $user_code)
    //                 ->first(['check_out_time', 'date']);
    //         }

    //         $user_data = User::where('user_code', $user_code)->first();



    //         if ($bio_attendanceCheckIn->check_in_time  ==  $bio_attendanceCheckOut->check_out_time && ($bio_attendanceCheckIn->check_in_time != null && $bio_attendanceCheckOut->check_out_time != null)) {

    //             $checkintime = carbon::parse($bio_attendanceCheckIn->check_in_time)->format('h:i:s');
    //             $checkouttime = carbon::parse($bio_attendanceCheckOut->check_out_time)->format('h:i:s');
    //             $query_workShifts = VmtWorkShifts::all()->keyBy('id');
    //             $shift_time = $this->getShiftTimeForEmployee($user_data->id, $checkintime, $checkouttime);

    //             $shiftStartTime  = Carbon::parse($query_workShifts[$shift_time->id]->shift_start_time);
    //             $shiftEndTime  = Carbon::parse($query_workShifts[$shift_time->id]->shift_end_time);

    //             $employee_checkIn_CheckOut = $this->findMIPOrMOP($bio_attendanceCheckIn->check_in_time, $shiftStartTime, $shiftEndTime);

    //             if (!empty($employee_checkIn_CheckOut["checkin_time"])) {
    //                 $bio_attendanceCheckIn->check_in_time  = $bio_attendanceCheckIn->check_in_time;
    //                 $bio_attendanceCheckOut->check_out_time = null;
    //             } else {
    //                 $bio_attendanceCheckIn->check_in_time  = null;
    //                 $bio_attendanceCheckOut->check_out_time = $bio_attendanceCheckOut->check_out_time;
    //             }
    //         }
    //         //dd($bio_attendanceCheckIn,$bio_attendanceCheckOut);
    //         //dd($query_web_mobile_response->attendance_mode_checkin == 'biometric' &&  empty($query_web_mobile_response->checkin_time));
    //         //check wheather employee mode of check-in and check-out is present or not

    //         if ((empty($query_biometric_response) && empty($query_web_mobile_response))) {

    //             $response = null;
    //         } //check employee mode of check-in and check-out in both employee attedance and staff attedance
    //         else if ($query_web_mobile_response_date == $recent_attedance_data && $query_biometric_response_date == $recent_attedance_data) {
    //             //check which attendance_mode is empty in employee attadance table


    //             if ($query_web_mobile_response->attendance_mode_checkin == 'biometric' &&  empty($query_web_mobile_response->checkin_time)) {

    //                 $query_web_mobile_response->checkin_time =  empty($bio_attendanceCheckIn->check_in_time) ? null : date("H:i:s", strtotime($bio_attendanceCheckIn->check_in_time));
    //                 $query_web_mobile_response->checkin_date =  empty($bio_attendanceCheckIn->check_in_time) ? null : date("Y-m-d", strtotime($bio_attendanceCheckIn->check_in_time));
    //                 $query_web_mobile_response->attendance_mode_checkin = empty($bio_attendanceCheckIn->check_in_time) ? null : 'biometric';
    //                 $response = $query_web_mobile_response;
    //             } else if (empty($query_web_mobile_response->attendance_mode_checkin) || empty($query_web_mobile_response->attendance_mode_checkout)) {
    //                 //if is it checkin then directly check on staff attedance table
    //                 if (empty($query_web_mobile_response->attendance_mode_checkin)) {

    //                     $query_web_mobile_response->checkin_time =  empty($bio_attendanceCheckIn->check_in_time) ? null : date("H:i:s", strtotime($bio_attendanceCheckIn->check_in_time));
    //                     $query_web_mobile_response->checkin_date =  empty($bio_attendanceCheckIn->check_in_time) ? null : date("Y-m-d", strtotime($bio_attendanceCheckIn->check_in_time));
    //                     $query_web_mobile_response->attendance_mode_checkin = empty($bio_attendanceCheckIn->check_in_time) ? null : 'biometric';
    //                 } //if is it checkout then directly check on staff attedance table
    //                 else if (empty($query_web_mobile_response->attendance_mode_checkout)) {

    //                     $query_web_mobile_response->checkout_time = empty($bio_attendanceCheckOut->check_out_time) ? null : date("H:i:s", strtotime($bio_attendanceCheckOut->check_out_time));
    //                     $query_web_mobile_response->checkout_date = empty($bio_attendanceCheckOut->check_out_time) ? null : date("Y-m-d", strtotime($bio_attendanceCheckOut->check_out_time));
    //                     $query_web_mobile_response->attendance_mode_checkout = empty($bio_attendanceCheckOut->check_out_time) ? null : 'biometric';
    //                 }
    //                 $response = $query_web_mobile_response;
    //             } else {

    //                 $response = $query_web_mobile_response;
    //             }
    //         } //check employee mode of check-in and check-out in  employee attedance
    //         else if ($query_web_mobile_response_date == $recent_attedance_data) {

    //             //if both attedance modes are present then retrun $query_web_mobile_response
    //             if (!empty($query_web_mobile_response->attendance_mode_checkin) && !empty($query_web_mobile_response->attendance_mode_checkout)) {

    //                 $response = $query_web_mobile_response;
    //             } //else check which attendance_mode is empty in staff attedance table
    //             else if (empty($query_web_mobile_response->attendance_mode_checkin) || empty($query_web_mobile_response->attendance_mode_checkout)) {

    //                 if (empty($query_web_mobile_response->attendance_mode_checkin)) {

    //                     $query_web_mobile_response->checkin_time =  empty($bio_attendanceCheckIn->check_in_time) ? null : date("H:i:s", strtotime($bio_attendanceCheckIn->check_in_time));
    //                     $query_web_mobile_response->checkin_date =  empty($bio_attendanceCheckIn->check_in_time) ? null : date("Y-m-d", strtotime($bio_attendanceCheckIn->check_in_time));
    //                     $query_web_mobile_response->attendance_mode_checkin = empty($bio_attendanceCheckIn->check_in_time) ? null : 'biometric';
    //                 } else if (empty($query_web_mobile_response->attendance_mode_checkout)) {

    //                     $query_web_mobile_response->checkout_time = empty($bio_attendanceCheckOut->check_out_time) ? null : date("H:i:s", strtotime($bio_attendanceCheckOut->check_out_time));
    //                     $query_web_mobile_response->checkout_date = empty($bio_attendanceCheckOut->check_out_time) ? null : date("Y-m-d", strtotime($bio_attendanceCheckOut->check_out_time));
    //                     $query_web_mobile_response->attendance_mode_checkout = empty($bio_attendanceCheckOut->check_out_time) ? null : 'biometric';
    //                 }

    //                 $response = $query_web_mobile_response;
    //             }
    //         } //check employee mode of check-in and check-out in staff attedance biometric
    //         //else if($query_biometric_response_date == $recent_attedance_data && $biometric_attendanceCheckInTime && $biometric_attendanceCheckoutTime ){
    //         else if ($query_biometric_response_date == $recent_attedance_data) {

    //             if (!empty($bio_attendanceCheckIn->check_in_time) && !empty($bio_attendanceCheckOut->check_out_time)) {
    //                 /*original  data split into date and time in biometric and assign the time to checkin and checkout ,
    //             then date to Checkin checkout date */

    //                 $query_biometric_response->date = $recent_attedance_data;
    //                 $query_biometric_response->checkin_time = date("H:i:s", strtotime($bio_attendanceCheckIn->check_in_time));
    //                 $query_biometric_response->checkout_time = date("H:i:s", strtotime($bio_attendanceCheckOut->check_out_time));
    //                 $query_biometric_response->checkin_date = date("Y-m-d", strtotime($bio_attendanceCheckIn->check_in_time));
    //                 $query_biometric_response->checkout_date = date("Y-m-d", strtotime($bio_attendanceCheckOut->check_out_time));
    //                 $query_biometric_response->attendance_mode_checkin = 'biometric';
    //                 $query_biometric_response->attendance_mode_checkout = 'biometric';

    //                 $response = $query_biometric_response;
    //             } else if (empty($bio_attendanceCheckIn->check_in_time) && empty($bio_attendanceCheckOut->check_out_time)) {
    //                 $query_biometric_response->date = $recent_attedance_data;
    //                 $query_biometric_response->checkin_time = null;
    //                 $query_biometric_response->checkin_date =  null;
    //                 $query_biometric_response->attendance_mode_checkin = null;
    //                 $query_biometric_response->checkout_time = null;
    //                 $query_biometric_response->checkout_date = null;
    //                 $query_biometric_response->attendance_mode_checkout = null;

    //                 $response = $query_biometric_response;
    //             } elseif ((empty($bio_attendanceCheckIn->check_in_time) || empty($bio_attendanceCheckOut->check_out_time))) {

    //                 if (empty($bio_attendanceCheckIn->check_in_time)) {

    //                     $query_biometric_response->date = $recent_attedance_data;
    //                     $query_biometric_response->checkin_time =  empty($query_web_mobile_response->check_in_time) ? null : date("H:i:s", strtotime($query_web_mobile_response->check_in_time));
    //                     $query_biometric_response->checkin_date =  empty($query_web_mobile_response->check_in_time) ? null : date("Y-m-d", strtotime($query_web_mobile_response->check_in_time));
    //                     $query_biometric_response->attendance_mode_checkin = empty($query_web_mobile_response->attendance_mode_checkin) ? null : $query_web_mobile_response->attendance_mode_checkin;
    //                     $query_biometric_response->checkout_time = date("H:i:s", strtotime($bio_attendanceCheckOut->check_out_time));
    //                     $query_biometric_response->checkout_date = date("Y-m-d", strtotime($bio_attendanceCheckOut->check_out_time));
    //                     $query_biometric_response->attendance_mode_checkout = 'biometric';
    //                 } else if (empty($bio_attendanceCheckOut->check_out_time)) {

    //                     $query_biometric_response->date = $recent_attedance_data;
    //                     $query_biometric_response->checkin_time = date("H:i:s", strtotime($bio_attendanceCheckIn->check_in_time));
    //                     $query_biometric_response->checkin_date = date("Y-m-d", strtotime($bio_attendanceCheckIn->check_in_time));
    //                     $query_biometric_response->attendance_mode_checkin = 'biometric';
    //                     $query_biometric_response->checkout_time = empty($query_web_mobile_response->check_out_time) ? null : date("H:i:s", strtotime($query_web_mobile_response->check_out_time));
    //                     $query_biometric_response->checkout_date = empty($query_web_mobile_response->check_out_time) ? null : date("Y-m-d", strtotime($query_web_mobile_response->check_out_time));
    //                     $query_biometric_response->attendance_mode_checkout = empty($query_web_mobile_response->attendance_mode_checkout) ? null : $query_web_mobile_response->attendance_mode_checkout;
    //                 }
    //                 $response = $query_biometric_response;
    //             }
    //         }

    //         return $response;
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Error while get latest attedance status',
    //             'data'   => $e->getTraceasString(),
    //         ]);
    //     }
    // }
    public function fetchEmpLastAttendanceStatus($user_code)
    {

        //Web/bio/mobile attendance
        try {
            $response = null;
            $user_details = User::where('user_code', $user_code)->first();

            $get_employee_attendance_details = VmtEmpAttIntrTable::where('user_id', $user_details->id)->whereNotNull('checkin_time')->orderby('date', 'DESC')->first();

            $response = array();

            $response["employee_code"] = $user_code;
            $response["date"] = $get_employee_attendance_details['date'];
            $response["checkin_time"] = $get_employee_attendance_details['checkin_time'];
            $response["checkin_date"] = $get_employee_attendance_details['checkin_date'];
            $response["checkout_time"] = $get_employee_attendance_details['checkout_time'];
            $response["checkout_date"] = $get_employee_attendance_details['checkout_date'];
            $response["attendance_mode_checkin"] = $get_employee_attendance_details['attendance_mode_checkin'];
            $response["attendance_mode_checkout"] = $get_employee_attendance_details['attendance_mode_checkout'];



            return $response;
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'success',
                'message' => 'Error while get latest attedance status',
                'data' => $e->getTraceasString(),
            ]);
        }
    }


    // public function getHrMainDashboardData($serviceVmtDashboardService)
    // {

    //     /*

    //     Employee count status :
    //         1)Total Employee count
    //         2) New Employee count
    //         3) Employee in Absent count
    //         4)Employee on Leave count

    //     */

    //     $current_date = Carbon::now()->format('Y-m-d');
    //     $Current_month = Carbon::now()->format('m');

    //     $employee_count = array();
    //     //Total Employee count
    //     //   $employee_count['totalEmpCount'] = user::where('is_ssa', '0')->where('active', '!=', '-1')->count();
    //     //    dd( $employee_count);
    //     // New Employee count
    //     //$employee_count['newEmpCount'] = user::join('vmt_employee_details', 'users.id', '=', 'vmt_employee_details.userid')->whereMonth('vmt_employee_details.doj',  Carbon::now('m'))->where('is_ssa', '!=', '1')->where('active', '=', '1')->count();

    //     $client_id = sessionGetSelectedClientid();

    //     $user_code =  auth()->user()->user_code;


    //     $user_data = User::where("user_code", $user_code)->first();


    //     $employees_data = "";

    //     if ($user_data['org_role'] == "2" || $user_data['org_role'] == "3" || $user_data['org_role'] == "1") {

    //         $employees_data = user::where('is_ssa', '0')->where('active', '=', '1')->get();

    //         $employee_count['activeEmpCount'] = count($employees_data);

    //         $employee_count['newEmpCount'] = user::join('vmt_employee_details', 'users.id', '=', 'vmt_employee_details.userid')->wheredate('vmt_employee_details.doj',   $current_date)->where('is_ssa', '!=', '1')->where('active', '=', '1')->count();
    //     } else if ($user_data['org_role'] == "4") {

    //         $employees_data = VmtEmployeeOfficeDetails::where('l1_manager_code', $user_code)->get(['user_id']);

    //         $employee_count['activeEmpCount'] = user::whereIn('id', $employees_data)->where('is_ssa', '0')->where('active', '=', '1')->get()->count();

    //         $employee_count['newEmpCount'] = user::join('vmt_employee_details', 'users.id', '=', 'vmt_employee_details.userid')->wheredate('vmt_employee_details.doj', $current_date)->where('is_ssa', '!=', '1')->where('active', '=', '1')->whereIn('users.id', $employees_data)->count();
    //     }

    //     $absent_count = 0;

    //     foreach ($employees_data as $key => $single_user_data) {

    //         $absent_employee_data  = VmtEmployeeAttendance::Where('user_id', $single_user_data['user_id'])->whereDate('date', $current_date)->first();

    //         if (empty($absent_employee_data)) {

    //             $absent_employee_count[$key]['absentEmployeeCount'] = $absent_employee_data;

    //             $emp_user_code = user::where('id', $single_user_data['user_id'])->first('user_code');

    //             $emp_bio_attendance = $this->getBioMetricAttendanceData($emp_user_code, $current_date);

    //             if (empty($emp_bio_attendance)) {
    //                 $absent_count++;
    //             }
    //         }
    //     }
    //     $employee_count['emp_absent_count'] =  $absent_count;


    //     $leave_employee_count = array();
    //     $i = 0;

    //     foreach ($employees_data as $key => $single_user_data) {

    //         $user_data = User::where('id', $single_user_data['user_id'])->first();

    //         $emp_leave_data = VmtEmployeeLeaves::Where('user_id', $single_user_data['user_id'])->whereMonth('start_date', $Current_month)->get()->toarray();

    //         if (!empty($emp_leave_data)) {

    //             $start_Date = Carbon::parse($emp_leave_data['0']['start_date'])->format('Y-m-d');
    //             $end_Date = Carbon::parse($emp_leave_data['0']['end_date'])->format('Y-m-d');

    //             $dateRange = CarbonPeriod::create($start_Date, $end_Date);

    //             foreach ($dateRange as $single_date) {

    //                 $leave_date = $single_date->format('Y-m-d');

    //                 if ($leave_date == $current_date) {
    //                     $leave_employee_count[$i]['id'] =  $single_user_data['user_id'];
    //                     $leave_employee_count[$i]['user_code'] =  $user_data->user_code;
    //                     $leave_employee_count[$i]['user_name'] =  $user_data->name;
    //                     $leave_employee_count[$i]['leave_date'] = $leave_date;
    //                     $i++;
    //                 }
    //             }
    //         }
    //     }

    //     $employee_count['emp_leave_count'] = count($leave_employee_count);
    // }
    public function getEmployeesCountDetails($client_id)
    {
        try {
            $current_date = Carbon::now()->format('Y-m-d');
            $Current_month = Carbon::now()->format('m');

            $user_code = auth()->user()->user_code;

            $user_data = User::where("user_code", $user_code)->first();

            $emp_details_count = array();

            $pending_request_count = array();

            $graph_chart_count = array();

            $employees_data = array();

            if ($user_data['org_role'] == "2" || $user_data['org_role'] == "3" || $user_data['org_role'] == "1") {

                $employees_data = user::where('is_ssa', '0')->whereIn('client_id', $client_id)->where('active', '=', '1')->get(['id']); //foractiveemployee


                $emp_details_count['total_employees'] = User::join('vmt_employee_office_details as off', 'off.user_id', '=', 'users.id')
                    ->leftJoin('vmt_department as dep', 'dep.id', '=', 'off.department_id')
                    ->leftJoin('vmt_employee_details as det', 'det.userid', '=', 'users.id')
                    ->where('users.is_ssa', '0')->where('users.active', '!=', '-1')
                    ->whereIn('users.client_id', $client_id)
                    ->get(['users.user_code as Employee_Code', 'users.name as Employee_Name', 'dep.name as Department', 'off.process as Process', 'det.doj', 'det.location as Location']);
                $emp_details_count['total_employee_count'] = $emp_details_count['total_employees']->count(); //fortotalemployee

                $emp_details_count['new_employees'] = user::join('vmt_employee_office_details as off', 'off.user_id', '=', 'users.id')
                    ->leftJoin('vmt_employee_details as det', 'det.userid', '=', 'users.id')
                    ->leftJoin('vmt_department as dep', 'dep.id', '=', 'off.department_id')
                    ->wheredate('det.doj', $current_date)->where('users.is_ssa', '!=', '1')->where('users.active', '=', '1')
                    ->whereIn('users.client_id', $client_id)
                    ->get(['users.user_code as Employee_Code', 'users.name as Employee_Name', 'dep.name as Department', 'off.process as Process', 'det.doj', 'det.location as Location']);
                $emp_details_count['new_employee_count'] = $emp_details_count['new_employees']->count();

                // dd( $emp_details_count['newEmpCount']);
                $emp_details_count['active_employees'] = User::join('vmt_employee_details as det', 'det.userid', '=', 'users.id', )
                    ->join('vmt_employee_office_details as off', 'off.user_id', '=', 'users.id')
                    ->leftJoin('vmt_department as dep', 'dep.id', '=', 'off.department_id')
                    ->where('users.active', '1')
                    ->where('users.is_ssa', '0')
                    ->whereIn('users.client_id', $client_id)
                    ->get(['users.user_code as Employee_Code', 'users.name as Employee_Name', 'dep.name as Department', 'off.process as Process', 'det.doj', 'det.location as Location']);
                $emp_details_count['active_employee_count'] = $emp_details_count['active_employees']->count();

                $emp_details_count['yet_to_active_employees'] = User::join('vmt_employee_details as det', 'det.userid', '=', 'users.id', )
                    ->join('vmt_employee_office_details as off', 'off.user_id', '=', 'users.id')
                    ->leftJoin('vmt_department as dep', 'dep.id', '=', 'off.department_id')
                    ->where('users.active', '0')
                    ->whereIn('users.client_id', $client_id)
                    ->get(['users.user_code as Employee_Code', 'users.name as Employee_Name', 'dep.name as Department', 'off.process as Process', 'det.doj', 'det.location as Location']);
                $emp_details_count['yet_to_active_employee_count'] = $emp_details_count['yet_to_active_employees']->count();

                $emp_details_count['exit_employees'] = User::join('vmt_employee_details as det', 'det.userid', '=', 'users.id', )
                    ->join('vmt_employee_office_details as off', 'off.user_id', '=', 'users.id')
                    ->leftJoin('vmt_department as dep', 'dep.id', '=', 'off.department_id')
                    ->where('users.active', '-1')
                    ->whereIn('users.client_id', $client_id)
                    ->get(['users.user_code as Employee_Code', 'users.name as Employee_Name', 'dep.name as Department', 'off.process as Process', 'det.doj', 'det.dol', 'det.location as Location']);
                $emp_details_count['exit_employee_count'] = $emp_details_count['exit_employees']->count();

                $graph_chart_count['male_employee_count'] = VmtEmployee::join("users", "users.id", "=", "vmt_employee_details.userid")->whereIn('users.client_id', $client_id)->where('vmt_employee_details.gender', 'Male')->where('users.active', '1')->get()->count();

                $graph_chart_count['female_employee_count'] = VmtEmployee::join("users", "users.id", "=", "vmt_employee_details.userid")->whereIn('users.client_id', $client_id)->where('vmt_employee_details.gender', 'Female')->where('users.active', '1')->get()->count();

                $graph_chart_count['others_count'] = VmtEmployee::join("users", "users.id", "=", "vmt_employee_details.userid")->whereIn('users.client_id', $client_id)->where('vmt_employee_details.gender', 'others')->where('users.active', '1')->whereIn('users.id', $employees_data)->get()->count();


                // $pending_request_count['get_leave_request_data'] = VmtEmployeeLeaves::whereDate('leaverequest_date', $current_date)->count();
            } else if ($user_data['org_role'] == "4") {

                $employees_data = VmtEmployeeOfficeDetails::where('l1_manager_code', $user_code)->get(['user_id as id']);
                $emp_details_count['total_employees'] = User::join('vmt_employee_office_details as off', 'off.user_id', '=', 'users.id')
                    ->leftJoin('vmt_department as dep', 'dep.id', '=', 'off.department_id')
                    ->leftJoin('vmt_employee_details as det', 'det.userid', '=', 'users.id')
                    ->where('users.is_ssa', '0')->where('users.active', '!=', '-1')->where('off.l1_manager_code', $user_code)
                    ->whereIn('users.client_id', $client_id)
                    ->get(['users.user_code as Employee_Code', 'users.name as Employee_Name', 'dep.name as Department', 'off.process as Process', 'det.doj', 'det.location as Location']);
                $emp_details_count['total_employee_count'] = $emp_details_count['total_employees']->count();


                $emp_details_count['new_employees'] = user::join('vmt_employee_office_details as off', 'off.user_id', '=', 'users.id')
                    ->leftJoin('vmt_employee_details as det', 'det.userid', '=', 'users.id')
                    ->leftJoin('vmt_department as dep', 'dep.id', '=', 'off.department_id')
                    ->wheredate('det.doj', $current_date)->where('users.is_ssa', '!=', '1')->where('users.active', '=', '1')
                    ->whereIn('users.client_id', $client_id)
                    ->whereIn('users.id', $employees_data)
                    ->get(['users.user_code as Employee_Code', 'users.name as Employee_Name', 'dep.name as Department', 'off.process as Process', 'det.doj', 'det.location as Location']);
                $emp_details_count['new_employee_count'] = $emp_details_count['new_employees']->count();

                $emp_details_count['active_employees'] = User::join('vmt_employee_details as det', 'det.userid', '=', 'users.id', )
                    ->join('vmt_employee_office_details as off', 'off.user_id', '=', 'users.id')
                    ->leftJoin('vmt_department as dep', 'dep.id', '=', 'off.department_id')
                    ->where('users.active', '1')
                    ->where('users.is_ssa', '0')
                    ->whereIn('users.client_id', $client_id)
                    ->whereIn('users.id', $employees_data)
                    ->get(['users.user_code as Employee_Code', 'users.name as Employee_Name', 'dep.name as Department', 'off.process as Process', 'det.doj', 'det.location as Location']);
                $emp_details_count['active_employee_count'] = $emp_details_count['active_employees']->count();

                $emp_details_count['yet_to_active_employees'] = User::join('vmt_employee_details as det', 'det.userid', '=', 'users.id', )
                    ->join('vmt_employee_office_details as off', 'off.user_id', '=', 'users.id')
                    ->leftJoin('vmt_department as dep', 'dep.id', '=', 'off.department_id')
                    ->where('users.active', '0')
                    ->whereIn('users.client_id', $client_id)
                    ->whereIn('users.id', $employees_data)
                    ->get(['users.user_code as Employee_Code', 'users.name as Employee_Name', 'dep.name as Department', 'off.process as Process', 'det.doj', 'det.location as Location']);
                $emp_details_count['yet_to_active_employee_count'] = $emp_details_count['yet_to_active_employees']->count();


                $emp_details_count['exit_employees'] = User::join('vmt_employee_details as det', 'det.userid', '=', 'users.id', )
                    ->join('vmt_employee_office_details as off', 'off.user_id', '=', 'users.id')
                    ->leftJoin('vmt_department as dep', 'dep.id', '=', 'off.department_id')
                    ->where('users.active', '-1')
                    ->whereIn('users.client_id', $client_id)
                    ->whereIn('users.id', $employees_data)
                    ->get(['users.user_code as Employee_Code', 'users.name as Employee_Name', 'dep.name as Department', 'off.process as Process', 'det.doj', 'det.dol', 'det.location as Location']);
                $emp_details_count['exit_employee_count'] = $emp_details_count['exit_employees']->count();

                // $pending_request_count['get_leave_request_data'] = VmtEmployeeLeaves::whereDate('leaverequest_date', $current_date)->count();

                $graph_chart_count['male_employee_count'] = VmtEmployee::join("users", "users.id", "=", "vmt_employee_details.userid")->whereIn('users.client_id', $client_id)->where('vmt_employee_details.gender', 'Male')->where('users.active', '1')->get()->count();

                $graph_chart_count['female_employee_count'] = VmtEmployee::join("users", "users.id", "=", "vmt_employee_details.userid")->whereIn('users.client_id', $client_id)->where('vmt_employee_details.gender', 'Female')->where('users.active', '1')->get()->count();

                $graph_chart_count['others_count'] = VmtEmployee::join("users", "users.id", "=", "vmt_employee_details.userid")->whereIn('users.client_id', $client_id)->where('vmt_employee_details.gender', 'others')->where('users.active', '1')->whereIn('users.id', $employees_data)->get()->count();


                // $emp_details_count['reimbursement_count'] = VmtEmployeeReimbursements::where('user_id','')

            }

            $emp_leave_data = VmtEmployeeLeaves::WhereIn('user_id', $employees_data)->whereMonth('start_date', $Current_month)->where('status', "Pending")->get()->toarray();

            $pending_request_count['Leave Requests'] = count($emp_leave_data);
            // if (!empty($emp_leave_data)) {

            //     $start_Date = Carbon::parse($emp_leave_data['0']['start_date'])->format('Y-m-d');
            //     $end_Date = Carbon::parse($emp_leave_data['0']['end_date'])->format('Y-m-d');

            //     $dateRange = CarbonPeriod::create($start_Date, $end_Date);

            //     foreach ($dateRange as $single_date) {

            //         $leave_date = $single_date->format('Y-m-d');

            //         if ($leave_date == $current_date) {
            //             $leave_employee_count[$i]['id'] =  $single_user_data['id'];
            //             $leave_employee_count[$i]['user_code'] =  $user_data->user_code;
            //             $leave_employee_count[$i]['user_name'] =  $user_data->name;
            //             $leave_employee_count[$i]['leave_date'] = $leave_date;
            //             $i++;
            //         }
            //     }
            // }
            // $pending_request_count['Leave Employees'] =  $leave_employee_count;

            // foreach ($employees_data as $key => $single_user_data) {

            //     $absent_employee_data  = VmtEmployeeAttendance::Where('user_id', $single_user_data['id'])->whereDate('date', $current_date)->first();

            //     if (empty($absent_employee_data)) {

            //         $absent_employee_count[$key]['absentEmployeeCount'] = $absent_employee_data;

            //         $emp_user_code = user::where('id', $single_user_data['id'])->first('user_code');

            //         $emp_bio_attendance = $this->getBioMetricAttendanceData($emp_user_code, $current_date);

            //         if (empty($emp_bio_attendance)) {
            //             $absent_count++;
            //         }
            //     }
            // }

            // $pending_request_count['employee_absent_count'] =  $absent_count;

            $get_document_update_data = VmtEmployeeDocuments::whereIn('user_id', $employees_data)->where('status', 'Pending')->get()->toarray();
            $get_attendance_regularization_data = VmtEmployeeAttendanceRegularization::whereIn('user_id', $employees_data)->where('status', 'pending')->get()->toarray();
            $pending_request_count['Document Approvals'] = count($get_document_update_data);
            $pending_request_count['Attendance Regularization'] = count($get_attendance_regularization_data);

            $mob_login_count = $this->getMobLoginCount();

            $graph_chart_count['app-checkin-ins'] = $mob_login_count['app_checkin_count'];

            $graph_chart_count['active_apps'] = $mob_login_count['app_active_count'];

            $graph_chart_count['inactive_apps'] = $mob_login_count['app_inactive_count'];

            $response = ['employee_details_count' => $emp_details_count, 'pending_request_count' => $pending_request_count, 'graph_chart_count' => $graph_chart_count];
            return ($response);
        } catch (\Exception $e) {
            return $response = ([
                'status' => 'failure',
                'message' => 'Error while fetch data',
                'data' => $e->getmessage() . " Error Line :  " . $e->getline(),
            ]);
        }
    }


    public function getHrMainDashboardData()
    {

        $user_code = auth()->user()->user_code;

        $user_data = User::where("user_code", $user_code)->first();
    }



    public function getBioMetricAttendanceData($user_code, $current_date)
    {
        $deviceData = array();
        if (
            sessionGetSelectedClientCode() == "DM" || sessionGetSelectedClientCode() == 'VASA GROUPS' || sessionGetSelectedClientCode() == 'LAL' ||
            sessionGetSelectedClientCode() == 'PSC' || sessionGetSelectedClientCode() == 'IMA' || sessionGetSelectedClientCode() == 'PA' || sessionGetSelectedClientCode() == 'DMC' || sessionGetSelectedClientCode() == 'ABS'
        ) {
            $attendanceCheckOut = \DB::table('vmt_staff_attenndance_device')
                ->select('user_Id', \DB::raw('MAX(date) as check_out_time'))
                ->whereDate('date', $current_date)
                ->where('user_Id', $user_code)
                ->first(['check_out_time']);

            $attendanceCheckIn = \DB::table('vmt_staff_attenndance_device')
                ->select('user_Id', \DB::raw('MIN(date) as check_in_time'))
                ->whereDate('date', $current_date)
                ->where('user_Id', $user_code)
                ->first(['check_in_time']);
        } else {
            $attendanceCheckOut = \DB::table('vmt_staff_attenndance_device')
                ->select('user_Id', \DB::raw('MAX(date) as check_out_time'))
                ->whereDate('date', $current_date)
                ->where('direction', 'out')
                ->where('user_Id', $user_code)
                ->first(['check_out_time']);

            $attendanceCheckIn = \DB::table('vmt_staff_attenndance_device')
                ->select('user_Id', \DB::raw('MIN(date) as check_in_time'))
                ->whereDate('date', $current_date)
                ->where('direction', 'in')
                ->where('user_Id', $user_code)
                ->first(['check_in_time']);
        }
        //dd($attendanceCheckIn);

        $deviceCheckOutTime = empty($attendanceCheckOut->check_out_time) ? null : explode(' ', $attendanceCheckOut->check_out_time)[1];
        $deviceCheckInTime = empty($attendanceCheckIn->check_in_time) ? null : explode(' ', $attendanceCheckIn->check_in_time)[1];
        //    dd($deviceCheckInTime);
        if ($deviceCheckOutTime != null || $deviceCheckInTime != null) {
            $deviceData[] = ([
                'date' => $current_date,
                'checkin_time' => $deviceCheckInTime,
                'checkout_time' => $deviceCheckOutTime,
                'attendance_mode_checkin' => 'biometric',
                'attendance_mode_checkout' => 'biometric'
            ]);
        }
        return $deviceData;
    }

    public function getOrgDashBoardDeatail()
    {
        try {
            $current_date = Carbon::now();
            $user_code = auth()->user()->user_code;
            $user_data = User::where("user_code", $user_code)->first();
            $check_in_data = VmtStaffAttendanceDevice::where('user_id', $user_data['user_code'])->whereDate('date', $current_date)->first();
            $login_data = VmtEmployeeAttendance::where('user_id', $user_data['id'])->whereDate('date', $current_date)->first();
            if (!empty($login_data)) {
                $attendance_mode = $login_data['attendance_mode_checkin'];
            } else {
                $attendance_mode = $check_in_data = 'biomatric';
            }
            $response = ['login_type' => $attendance_mode];
            return $response;
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Unable to fetch Attendance details",
                "data" => $response,
            ]);
        }
    }

    public function getMobLoginCount()
    {
        try {
            $current_date = carbon::now()->format('Y-m-d');
            $app_checkin_count = VmtEmpAttIntrTable::join('users', 'vmt_emp_att_intrtable.user_id', '=', 'users.id')
                ->where('active', "1")->where('is_ssa', "0")->where('attendance_mode_checkin', 'mobile')
                ->whereDate('date', $current_date)->get()->count();

            $active_count = VmtEmpAttIntrTable::join('users', 'vmt_emp_att_intrtable.user_id', '=', 'users.id')->where('attendance_mode_checkin', 'mobile')
                ->where('active', "1")->where('is_ssa', "0")->get()->unique('user_id')->count();

            $user_data = User::where('active', "1")->where('is_ssa', "0")->get()->count();
            $inactive_count = $user_data - $active_count;

            $response = ["app_checkin_count" => $app_checkin_count, "app_active_count" => $active_count, "app_inactive_count" => $inactive_count];
            return $response;
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Unable to fetch Attendance details",
                "data" => $e->getmessage(),
            ]);
        }
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
    public function getShiftTimeForEmployee($user_id, $checkin_time, $checkout_time)
    {

        $emp_work_shift = VmtEmployeeWorkShifts::where('user_id', $user_id)->where('is_active', '1')->get();

        if (count($emp_work_shift) == 1) {
            $regularTime = VmtWorkShifts::where('id', $emp_work_shift->first()->work_shift_id)->first();
            return $regularTime;
        } else if (count($emp_work_shift) > 1) {
            //dd($emp_work_shift);
            for ($i = 0; $i < count($emp_work_shift); $i++) {
                $regularTime = VmtWorkShifts::where('id', $emp_work_shift[$i]->work_shift_id)->first();
                $shift_start_time = Carbon::parse($regularTime->shift_start_time)->addMinutes($regularTime->grace_time);
                $shift_end_time = Carbon::parse($regularTime->shift_end_time);

                $diffInMinutesInCheckinTime = $shift_start_time->diffInMinutes(Carbon::parse($checkin_time['date'] ?? $checkin_time), false);
                $diffInMinutesInCheckOutTime = $shift_end_time->diffInMinutes(Carbon::parse($checkout_time['date'] ?? $checkout_time), false);
                // if ($user_id == '192' && $checkin_time == "13:56:01");
                // dd($diffInMinutesInCheckinTime);
                if ($checkin_time == null && $checkout_time == null) {
                    return $regularTime;
                } else if ($diffInMinutesInCheckinTime > -65 && $diffInMinutesInCheckinTime < 275) {
                    return $regularTime;
                } else if ($diffInMinutesInCheckOutTime > -65 && $diffInMinutesInCheckOutTime < 65) {
                    return $regularTime;
                }
                if ($i == count($emp_work_shift) - 1) {
                    return $regularTime;
                }
            }
        }
    }
    public function checkEmployeeOnboardStatus()
    {
        try {

            if (auth()->user()->active == 0) {


                if (auth()->user()->is_onboarded == 0) {

                    if (auth()->user()->onboard_type == 'quick') {

                        $onboard_type = "quick";
                        $is_onboarded = auth()->user()->is_onboarded;
                        $is_active = auth()->user()->active;
                    }
                    if (auth()->user()->onboard_type == 'bulk') {

                        $onboard_type = "bulk";
                        $is_onboarded = auth()->user()->is_onboarded;
                        $is_active = auth()->user()->active;
                    }
                    if (auth()->user()->onboard_type == 'normal') {

                        $onboard_type = "normal";
                        $is_onboarded = auth()->user()->is_onboarded;
                        $is_active = auth()->user()->active;
                    }

                }
            } else {
                $onboard_type = auth()->user()->onboard_type;
                $is_onboarded = auth()->user()->is_onboarded;
                $is_active = auth()->user()->active;
            }
            $response['onboard_type'] = $onboard_type;
            $response['is_onboarded'] = $is_onboarded;
            $response['is_active'] = $is_active;

            return $response = ([
                'status' => 'success',
                "message" => "data fetch successfully",
                "data" => $response,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                "status" => "failure",
                "message" => "Unable to fetch Employee onboard status",
                "data" => $e->getmessage() . " " . $e->getline(),
            ]);
        }
    }

    public function getCurrentSessionClientId()
    {
        $query_client = VmtClientMaster::find(session('client_id'));
        if (!empty($query_client))
            return $query_client->id;
        else
            return "";
    }
}
