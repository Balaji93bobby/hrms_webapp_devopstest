<?php

namespace App\Services;

use App\Mail\ApproveRejectLeaveMail;
use Illuminate\Support\Facades\Http;
use App\Mail\AttendanceCheckinCheckoutNotifyMail;
use App\Models\User;
use App\Models\VmtEmployeeAttendanceRegularization;
use App\Models\VmtEmployeeLeaves;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\vmtHolidays;
use App\Models\VmtEmployeeAttendance;
use Exception;
use App\Models\VmtEmployeeCompensatoryLeave;
use App\Models\VmtLeaves;
use App\Models\VmtWorkShifts;
use App\Models\VmtAttendanceSettings;
use App\Models\VmtClientMaster;
use App\Models\VmtEmployeesLeavesAccrued;
use App\Models\Department;
use App\Models\VmtEmpAttIntrTable;
use App\Models\VmtStaffAttendanceDevice;
use App\Mail\VmtAbsentMail_Regularization;
use App\Services\VmtNotificationsService;
use Carbon\CarbonInterval;

use App\Mail\VmtAttendanceMail_Regularization;
use App\Mail\RequestLeaveMail;
use App\Models\VmtEmployee;
use App\Models\VmtEmployeeAbsentRegularization;
use App\Models\VmtEmployeeWorkShifts;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DatePeriod;
use DateInterval;
use \Datetime;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use App\Models\VmtOrgTimePeriod;
use Illuminate\Support\Str;
use App\Jobs\EmployeeOverTimeCalculationsJobs;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Mailer\Exception\TransportException;
use App\Jobs\SendEmployeeMails;

class VmtAttendanceService
{
    /*
        Returns the list of users which we will show in Notify To field
        in Leave Apply module.

    */
    public function getLeaveNotifyToList($leave_applying_user_code)
    {

        $validator = Validator::make(
            $data = [
                'leave_applying_user_code' => $leave_applying_user_code,
            ],
            $rules = [
                'leave_applying_user_code' => 'required|exists:users,user_code',
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

            $query_user = User::where('user_code', $leave_applying_user_code)->first();

            $query_l1_manager = User::leftJoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->where('users.user_code', $leave_applying_user_code)
                ->first('vmt_employee_office_details.l1_manager_code');

            $l1_manager_id = User::where('user_code', $query_l1_manager->l1_manager_code)->first()->id;

            $notify_to_userslist = User::where('is_ssa', '0')
                ->where('client_id', $query_user->client_id)
                ->where('active', 1)
                ->whereNotIn('id', [$query_user->id, $l1_manager_id])
                ->get(['id', 'user_code', 'name']);

            return response()->json([
                "status" => "success",
                "data" => $notify_to_userslist
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error [ getLeaveNotifyToList() ]",
                "error" => $e->getMessage() . ' | File : ' . $e->getFile() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTrace(),
            ]);
        }
    }

    public function fetchAttendanceRegularizationData($month, $year, $manager_user_code = null)
    {

        $validator = Validator::make(
            $data = [
                'manager_user_code' => $manager_user_code,
                'month' => $month,
                'year' => $year,
            ],
            $rules = [
                'manager_user_code' => 'nullable|exists:users,user_code',
                'month' => 'required',
                'year' => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'integer' => 'Field :attribute should be integer',
                'in' => 'Field :attribute is invalid',
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
            if (!empty(session('client_id'))) {
                if (session('client_id') == 1) {

                    $client_id = VmtClientMaster::pluck('id');
                } else {
                    $client_id = [session('client_id')];
                }
            } else {

                $client_id = [auth()->user()->client_id];
            }

            $map_allEmployees = User::where('active', '1')->where('is_ssa', "0")->whereIn('client_id', $client_id)->get(['id', 'name'])->keyBy('id');
            $allEmployees_lateComing = null;

            //If manager ID not set, then show all employees
            // dd($manager_user_code);
            if (empty($manager_user_code)) {
                if (empty($month) && empty($year)) {

                    $allEmployees_lateComing = VmtEmployeeAttendanceRegularization::whereIn('user_id', array_keys($map_allEmployees->toarray()))->get();
                } else {
                    // dd(array_keys($map_allEmployees->toarray()));
                    $allEmployees_lateComing = VmtEmployeeAttendanceRegularization::whereYear('attendance_date', $year)
                        ->whereMonth('attendance_date', $month)
                        ->whereIn('user_id', array_keys($map_allEmployees->toarray()))
                        ->get();
                }
            } else {
                //If manager ID set, then show only the team level employees

                $employees_id = VmtEmployeeOfficeDetails::where('l1_manager_code', $manager_user_code)->pluck('user_id');


                if (empty($month) && empty($year)) {
                    $allEmployees_lateComing = VmtEmployeeAttendanceRegularization::whereIn('user_id', $employees_id->toarray())->get();
                } else {
                    $allEmployees_lateComing = VmtEmployeeAttendanceRegularization::whereIn('user_id', $employees_id)
                        ->whereYear('attendance_date', $year)
                        ->whereMonth('attendance_date', $month)
                        ->get();
                }
            }

            //dd($map_allEmployees->toArray());
            // dd($allEmployees_lateComing->toArray());

            foreach ($allEmployees_lateComing as $singleItem) {
                // dd($singleItem);
                //check whether user_id from regularization table exists in USERS table
                if (array_key_exists($singleItem->user_id, $map_allEmployees->toArray())) {

                    $user_code = User::where('id', $map_allEmployees[$singleItem->user_id]["id"])->first()->user_code;
                    $singleItem->employee_name = $map_allEmployees[$singleItem->user_id]["name"];
                    $singleItem->user_code = $user_code;
                    $singleItem->employee_avatar = getEmployeeAvatarOrShortName($singleItem->user_id);

                    //If reviewer_id = 0, then its not yet reviewed4
                    // dd($singleItem->reviewer_id );
                    if (array_key_exists($singleItem->reviewer_id, $map_allEmployees->toArray())) {
                        $singleItem->reviewer_name = $map_allEmployees[$singleItem->reviewer_id]["name"];
                        $singleItem->reviewer_avatar = getEmployeeAvatarOrShortName($singleItem->reviewer_id);
                    } else {
                        $reviewer_code = VmtEmployeeOfficeDetails::where('user_id', $singleItem->user_id)->first()->l1_manager_code;
                        if (empty($reviewer_code)) {
                            $singleItem->reviewer_name = '-';
                            $singleItem->reviewer_avatar = '-';
                        } else {

                            $singleItem->reviewer_name = $map_allEmployees[User::where('user_code', $reviewer_code)->first()->id]["name"];
                            $singleItem->reviewer_avatar = getEmployeeAvatarOrShortName(User::where('user_code', $reviewer_code)->first()->id);
                        }
                    }
                } else {
                    //  dd("Missing User ID : " . $singleItem->user_id);
                }
            }

            return [
                "status" => "success",
                "message" => "Attendance data fetch successfully",
                "data" => $allEmployees_lateComing
            ];
            // // dd($allEmployees_lateComing);
            // return $allEmployees_lateComing;
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error while fetching Attendance Regularization data",
                "error" => $e->getMessage() . ' | File : ' . $e->getFile() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTrace(),
            ]);
        }
    }

    public function fetchEmployeeAbsentRegularizationData($manager_user_code, $month, $year, $regularization_status)
    {

        $validator = Validator::make(
            $data = [
                'manager_user_code' => $manager_user_code,
                'regularization_status' => $regularization_status,
                'month' => $month,
                'year' => $year,
            ],
            $rules = [
                'regularization_status' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $valid_status_data = array("Approved", "Rejected", "Pending");

                        $diff = array_diff($value, $valid_status_data);

                        if (count($diff) != 0)
                            $fail('The ' . $attribute . ' has invalid status types.');
                    },
                ],
                'manager_user_code' => "nullable",
                'month' => 'required',
                'year' => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'integer' => 'Field :attribute should be integer',
                'in' => 'Field :attribute is invalid',
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
            if (!empty(session('client_id'))) {

                if (session('client_id') == 1) {

                    $client_id = VmtClientMaster::pluck('id');
                } else {
                    $client_id = [session('client_id')];
                }
            } else {

                $client_id = [auth()->user()->client_id];
            }

            $map_allEmployees = User::where('active', '1')->where('is_ssa', "0")->whereIn('client_id', $client_id)->get(['id', 'name', 'user_code'])->keyBy('id');

            $allEmployees_lateComing = null;

            //If manager ID not set, then show all employees
            if (empty($manager_user_code)) {
                if (empty($month) && empty($year)) {
                    $allEmployees_lateComing = VmtEmployeeAbsentRegularization::whereIn('user_id', array_keys($map_allEmployees->toarray()))->whereIn('status', $regularization_status)->get();
                } else {
                    $allEmployees_lateComing = VmtEmployeeAbsentRegularization::whereIn('user_id', array_keys($map_allEmployees->toarray()))
                        ->whereYear('attendance_date', $year)
                        ->whereMonth('attendance_date', $month)
                        ->whereIn('status', $regularization_status)
                        ->get();
                }
            } else {
                //If manager ID set, then show only the team level employees

                $employees_id = VmtEmployeeOfficeDetails::where('l1_manager_code', $manager_user_code)->pluck('user_id');


                if (empty($month) && empty($year))
                    $allEmployees_lateComing = VmtEmployeeAbsentRegularization::whereIn('user_id', $employees_id)->whereIn('status', $regularization_status)->get();
                else
                    $allEmployees_lateComing = VmtEmployeeAbsentRegularization::whereIn('user_id', $employees_id)
                        ->whereYear('attendance_date', $year)
                        ->whereMonth('attendance_date', $month)
                        ->whereIn('status', $regularization_status)
                        ->get();
            }

            //dd($map_allEmployees->toArray());
            //dd($allEmployees_lateComing->toArray());

            foreach ($allEmployees_lateComing as $singleItem) {

                //check whether user_id from regularization table exists in USERS table
                if (array_key_exists($singleItem->user_id, $map_allEmployees->toArray())) {
                    $singleItem->employee_user_code = $map_allEmployees[$singleItem->user_id]["user_code"];
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
            return [
                "status" => "success",
                "message" => "Absent data fetch successfully",
                "data" => $allEmployees_lateComing
            ];

            // return $allEmployees_lateComing;
        } catch (\Exception $e) {

            return response()->json([
                "status" => "failure",
                "message" => "Error while fetching Absent Regularization data",
                "error" => $e->getMessage() . ' | File : ' . $e->getFile() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTrace(),
            ]);
        }
    }
    public function fetchAbsentRegularizationData($month, $year, $manager_user_code = null)
    {

        $validator = Validator::make(
            $data = [
                'manager_user_code' => $manager_user_code,
                'month' => $month,
                'year' => $year,
            ],
            $rules = [
                'manager_user_code' => 'nullable|exists:users,user_code',
                'month' => 'required',
                'year' => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'integer' => 'Field :attribute should be integer',
                'in' => 'Field :attribute is invalid',
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
            if (!empty(session('client_id'))) {

                if (session('client_id') == 1) {

                    $client_id = VmtClientMaster::pluck('id');
                } else {
                    $client_id = [session('client_id')];
                }
            } else {

                $client_id = [auth()->user()->client_id];
            }

            $map_allEmployees = User::where('active', '1')->where('is_ssa', "0")->whereIn('client_id', $client_id)->get(['id', 'name'])->keyBy('id');

            $allEmployees_lateComing = null;

            //If manager ID not set, then show all employees
            if (empty($manager_user_code)) {
                if (empty($month) && empty($year)) {
                    $allEmployees_lateComing = VmtEmployeeAbsentRegularization::whereIn('user_id', array_keys($map_allEmployees->toarray()))->get();
                } else {
                    $allEmployees_lateComing = VmtEmployeeAbsentRegularization::whereIn('user_id', array_keys($map_allEmployees->toarray()))
                        ->whereYear('attendance_date', $year)
                        ->whereMonth('attendance_date', $month)
                        ->get();
                }
            } else {
                //If manager ID set, then show only the team level employees

                $employees_id = VmtEmployeeOfficeDetails::where('l1_manager_code', $manager_user_code)->pluck('user_id');


                if (empty($month) && empty($year))
                    $allEmployees_lateComing = VmtEmployeeAbsentRegularization::whereIn('user_id', $employees_id)->get();
                else
                    $allEmployees_lateComing = VmtEmployeeAbsentRegularization::whereIn('user_id', $employees_id)
                        ->whereYear('attendance_date', $year)
                        ->whereMonth('attendance_date', $month)
                        ->get();
            }

            //dd($map_allEmployees->toArray());
            //dd($allEmployees_lateComing->toArray());

            foreach ($allEmployees_lateComing as $singleItem) {

                //check whether user_id from regularization table exists in USERS table
                if (array_key_exists($singleItem->user_id, $map_allEmployees->toArray())) {

                    $singleItem->employee_name = $map_allEmployees[$singleItem->user_id]["name"];
                    $singleItem->employee_avatar = getEmployeeAvatarOrShortName($singleItem->user_id);

                    //If reviewer_id = 0, then its not yet reviewed
                    if (array_key_exists($singleItem->reviewer_id, $map_allEmployees->toArray())) {

                        $singleItem->reviewer_name = $map_allEmployees[$singleItem->reviewer_id]["name"];
                        $singleItem->reviewer_avatar = getEmployeeAvatarOrShortName($singleItem->reviewer_id);
                    } else {
                        $reviewer_code = VmtEmployeeOfficeDetails::where('user_id', $singleItem->user_id)->first()->l1_manager_code;
                        if (!empty($reviewer_code)) {
                            $singleItem->reviewer_name = $map_allEmployees[User::where('user_code', $reviewer_code)->first()->id]["name"];
                            $singleItem->reviewer_avatar = getEmployeeAvatarOrShortName(User::where('user_code', $reviewer_code)->first()->id);
                        }
                    }
                } else {
                    //  dd("Missing User ID : " . $singleItem->user_id);
                }
            }

            // dd($allEmployees_lateComing);
            return [
                "status" => "success",
                "message" => "Absent data fetch successfully",
                "data" => $allEmployees_lateComing
            ];

            // return $allEmployees_lateComing;
        } catch (\Exception $e) {

            return response()->json([
                "status" => "failure",
                "message" => "Error while fetching Absent Regularization data",
                "error" => $e->getMessage() . ' | File : ' . $e->getFile() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTrace(),
            ]);
        }
    }



    /*
         Get the employee's compensatory work days (Worked on holidays and also in leave days(Eg: Sun , Sat))
         This wont check whether these comp days are used by emps
     */
    private function fetchEmployeeCompensatoryOffDays($user_id)
    {

        $user_code = User::where('id', $user_id)->first()->user_code;
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

        //Get list of attendance days only 60 days before today date
        $start_date = Carbon::today()->subMonths(2)->format('Y-m-d');
        $end_date = Carbon::today()->format('Y-m-d');
        $query_emp_attendanceDetails = VmtEmployeeAttendance::where('user_id', $user_id)
            ->whereBetween('date', [$start_date, $end_date])
            ->get(['id', 'date'])->keyBy('date')->toArray();
        $query_biometric_attendance = VmtStaffAttendanceDevice::where('user_id', $user_code)
            ->whereBetween('date', [$start_date, $end_date])
            ->pluck('date');
        $query_biometric_attendance = $query_biometric_attendance->map(function (string $item, int $key) {
            return substr($item, 0, 10);
        });
        //  dd($query_biometric_attendance);
        //Get only the keys
        $dates_emp_attendanceDetails = array_merge(array_keys($query_emp_attendanceDetails), $query_biometric_attendance->toArray());
        $dates_emp_attendanceDetails = array_unique($dates_emp_attendanceDetails);

        $comp_off_days = array();
        foreach ($dates_emp_attendanceDetails as $key => $singleAttendanceDate) {

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
            //dd( $work_leave_days);
            // if ($singleAttendanceDate == '2023-10-01') {
            //     dd($dates_emp_attendanceDetails);
            //     dd(!in_array($trimmed_date, $array_query_holidays) && !in_array($day, $work_leave_days), $singleAttendanceDate);
            // }
            //Check whether not worked in Holidays or not in work_leave days
            if (in_array($trimmed_date, $array_query_holidays)) {
                //If worked in holiday, then add date in array
                array_push($comp_off_days, ['id' => $user_id, 'date' => $singleAttendanceDate]);
            }
            //Check whether not worked in Weekends or not in work_leave days
            if (in_array($day, $work_leave_days)) {
                //If worked in weekend, then add date in array
                array_push($comp_off_days, ['id' => $user_id, 'date' => $singleAttendanceDate]);
            }
        }


        return $comp_off_days;
    }

    /*
         Returns the unused comp off days for the given emp

         Returns a map.

         Eg : {
                "247"                    :  "2023-08-15"
                //("employee_attendance_id" :  "employee_attendance_date")
              }

     */
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


    public function getEmployeeLeaveBalance($user_code)
    {
        $validator = Validator::make(
            $data = [
                "user_code" => $user_code
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
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


            //Accrued Leave Year Frame
            //                if (empty($request->all())) {
            $time_periods_of_year_query = VmtOrgTimePeriod::where('status', 1)->first();
            // } else {
            //     $time_periods_of_year_query = VmtOrgTimePeriod::whereYear('start_date',)->whereMonth('start_date',)
            //         ->whereYear('end_date',)->whereMonth('end_date',)->first();
            // }
            $start_date = $time_periods_of_year_query->start_date;
            $end_date = $time_periods_of_year_query->end_date;
            $calender_type = $time_periods_of_year_query->abbrevation;
            // $time_frame = array( $start_date.'/'. $end_date=>$calender_type.' '.substr($start_date, 0, 4).'-'.substr($end_date, 0, 4));
            $time_frame = $calender_type . ' ' . substr($start_date, 0, 4) . '-' . substr($end_date, 0, 4);


            $leave_balance_details = $this->calculateEmployeeLeaveBalance(auth::user()->id, $start_date, $end_date);

            //convert current json response to older JSON structure
            /*
                     Old structure :
                     {
                         "status": "success",
                         "message": "",
                         "data" :{
                             "Earned Leave" : 1,
                             "Permission" : 0,
                             "Maternity Leave" : 0,
                             "Paternity Leave" : 0,
                         }

                     }
                 */
            // dd($leave_balance_details);
            $final_json = array();

            foreach ($leave_balance_details as $singleLeavebalance) {
                //dd($singleLeavebalance["leave_balance"]);
                $final_json[$singleLeavebalance["leave_type"]] = $singleLeavebalance["leave_balance"];
                // dd($final_json);
            }


            return response()->json([
                "status" => "success",
                "message" => "",
                "data" => $final_json,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error while fetching employee leave balance",
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ]);
        }
    }

    /*
         For VJS Leave Approvals table

         Returns all leave status types

     */
    private function createLeaveRange($start_date, $end_date)
    {
        $start_date = new DateTime($start_date);
        $end_date = new DateTime($end_date);
        $end_date->modify('+1 day'); //For PHP < 8.2, Adding extra date so that the late date is considered. In PHP 8.2 , we have flag to include END DATE

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($start_date, $interval, $end_date);

        return $daterange;
    }

    public function applyLeaveRequest_AdminRole(
        $admin_user_code,
        $user_code,
        $leave_request_date,
        $start_date,
        $end_date,
        $hours_diff,
        $no_of_days,
        $compensatory_work_days_ids,
        $leave_session,
        $leave_type_name,
        $leave_reason,
        $notifications_users_id,
        $serviceNotificationsService
    ) {

        $validator = Validator::make(
            $data = [
                'admin_user_code' => $admin_user_code,
                'user_code' => $user_code,
            ],
            $rules = [
                'admin_user_code' => 'required|exists:users,user_code',
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
            $is_admin = User::where('user_code', $admin_user_code)->whereIn('org_role', array("1", "2"));

            if ($is_admin->exists()) {

                //$is_admin = $is_admin->first();

                $response = $this->applyLeaveRequest(

                    user_code: $user_code,
                    leave_request_date: $leave_request_date,
                    start_date: $start_date,
                    end_date: $end_date,
                    hours_diff: $hours_diff,
                    no_of_days: $no_of_days,
                    compensatory_work_days_ids: $compensatory_work_days_ids,
                    leave_session: $leave_session,
                    leave_type_name: $leave_type_name,
                    leave_reason: $leave_reason,
                    notifications_users_id: $notifications_users_id,
                    user_type: "Admin",
                    serviceNotificationsService: $serviceNotificationsService,
                );

                //dd($response);

                if ($response['status'] == "success") {


                    $user_data = User::where('user_code', $user_code)->first();

                    $record_id = VmtEmployeeLeaves::where('user_id', $user_data->id)->wheredate("start_date", $start_date)->wheredate("end_date", $end_date)->first();

                    $response = $this->approveRejectRevokeLeaveRequest(
                        approver_user_code: $admin_user_code,
                        record_id: $record_id->id,
                        status: "Approved",
                        review_comment: "---",
                        user_type: "Admin",
                        serviceNotificationsService: $serviceNotificationsService


                    );
                }
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->all(),
                    'data' => ""
                ]);
            }
            return $response;
        } catch (\Exception $e) {
            return $response = [
                'status' => 'failure',
                'message' => 'Error while applying leave request',
                'mail_status' => 'failure',
                'notification' => '',
                'data' => $e->getMessage(),
                'error_verbose' => $e->getTraceAsString()
            ];
        }
    }

    /*

         $hours_diff : For permission only
         $no_of_days, $leave_session : For 0.5 and full day leave types

             // compensatory leaves
             $compensatory_work_days_ids

     */
    public function applyLeaveRequest(
        $user_code,
        $leave_request_date,
        $start_date,
        $end_date,
        $hours_diff,
        $no_of_days,
        $compensatory_work_days_ids,
        $leave_session,
        $leave_type_name,
        $leave_reason,
        $notifications_users_id,
        $user_type,
        $serviceNotificationsService
    ) {

        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
                'leave_request_date' => $leave_request_date,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'leave_type_name' => $leave_type_name,
                'leave_reason' => $leave_reason,
                'notifications_users_id' => $notifications_users_id,
                'user_type' => $user_type,
            ],
            $rules = [
                'user_code' => 'required|exists:users,user_code',
                'leave_request_date' => 'required|date',
                'start_date' => "required|date",
                'end_date' => 'required|date',
                'leave_type_name' => 'required|exists:vmt_leaves,leave_type',
                'notifications_users_id' => 'nullable',
                'user_type' => ['required', Rule::in(['Employee', 'Admin'])],
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'integer' => 'Field :attribute should be integer',
                'in' => 'Field :attribute is invalid',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        try {
            //Core values needed
            $query_user = User::where('user_code', $user_code)->first();

            $compensatory_leavetype_id = VmtLeaves::where('leave_type', 'LIKE', '%Compensatory%')->first();

            if (!empty($compensatory_leavetype_id)) {
                $compensatory_leavetype_id = $compensatory_leavetype_id->id;
            }

            $leave_type_id = VmtLeaves::where('leave_type', $leave_type_name)->first()->id;

            //Check whether this user has manager
            $manager_emp_code = VmtEmployeeOfficeDetails::where('user_id', $query_user->id)->first();

            if (empty($manager_emp_code)) {
                return response()->json([
                    "status" => "failure",
                    "message" => "Manager not found for the given user " . $query_user->name . " . Kindly contact the admin"
                ]);
            } else {
                $manager_emp_id = $manager_emp_code->user_id;
                $manager_emp_code = $manager_emp_code->l1_manager_code;
            }
            if ($manager_emp_code == "") {

                return response()->json([
                    "status" => "failure",
                    "message" => "Manager code not defined. Kindly contact the admin"
                ]);
            }
            $query_manager = User::where('user_code', $manager_emp_code)->first();
            $manager_name = $query_manager->name;
            $manager_id = $query_manager->id;


            $reviewer_mail = VmtEmployeeOfficeDetails::where('user_id', $manager_id)->first()->officical_mail;

            if (empty($reviewer_mail)) {
                return response()->json([
                    "status" => "failure",
                    "message" => "Manager mail not defined. Kindly contact the admin"
                ]);
            }

            //Need to split the validation based on leave type so that mandatory fields are checked correctly.
            if (isPermissionLeaveType($leave_type_id)) {

                if (empty($hours_diff)) {
                    return response()->json([
                        "status" => "failure",
                        "message" => "hours_diff is missing for given permission type = " . $leave_type_name
                    ]);
                }
            } else
                if ($leave_type_id == $compensatory_leavetype_id) {
                    if (empty($compensatory_work_days_ids)) {
                        return response()->json([
                            "status" => "failure",
                            "message" => "compensatory work days are missing for given leave type = " . $leave_type_name
                        ]);
                    }
                } else // full day, half-day, custom
                {
                    //if half day
                    if ($no_of_days == '0.5') {
                        if (empty($leave_session)) {
                            return response()->json([
                                "status" => "failure",
                                "message" => "leave_session is missing for given half-day leave type = " . $leave_type_name
                            ]);
                        }
                    } else //fullday and custom
                    {
                        //All the validations are done in API level.
                        //Need to write in common place for using in web request also
                    }
                }

            ////Check whether leave request already exists for the given leave dates

            $leave_month = date('m', strtotime($start_date));

            //get the existing Pending/Approved leaves. No need to check Rejected
            $existingLeavesRequests = VmtEmployeeLeaves::where('user_id', $query_user->id)
                ->whereMonth('start_date', '>=', $leave_month)
                ->whereIn('status', ['Pending', 'Approved'])
                ->get(['start_date', 'end_date', 'status']);

            //dd($existingLeavesRequests);

            foreach ($existingLeavesRequests as $singleExistingLeaveRequest) {

                //If start date and end date of an existing leave request is same, then no need to call createLeaveRange().
                //Just compare start_date with current start_date/end_date leave
                if ($singleExistingLeaveRequest->start_date == $singleExistingLeaveRequest->end_date) {

                    $processedStartDate = substr($singleExistingLeaveRequest->start_date, 0, 10);
                    $processedEndDate = substr($singleExistingLeaveRequest->end_date, 0, 10);

                    if (
                        $processedStartDate == $start_date || $processedEndDate == $start_date ||
                        $processedStartDate == $end_date || $processedEndDate == $end_date
                    ) {
                        //dd("single date leave collision");

                        return $response = [
                            'status' => 'failure',
                            'message' => 'Leave Request already applied for the given dates',
                        ];
                    }
                } else {

                    //create leave range
                    $leave_range = $this->createLeaveRange($singleExistingLeaveRequest->start_date, $singleExistingLeaveRequest->end_date);

                    //check with the user given leave range
                    foreach ($leave_range as $date) {

                        //dd("Given start,end date : ".$start_date. " , ".$end_date);
                        //dd("Currently checking start,end date : ".$date->format('Y-m-d'));

                        //if date already exists in previous leaves
                        // if ($processed_leave_start_date->format('Y-m-d') == $date->format('Y-m-d') || $processed_leave_end_date->format('Y-m-d') == $date->format('Y-m-d'))
                        if ($start_date == $date->format('Y-m-d') || $end_date == $date->format('Y-m-d')) {
                            return $response = [
                                'status' => 'failure',
                                'message' => 'Leave Request already applied for the given dates',
                            ];
                        }
                    }
                }
            }

            //dd("Leave doesnt exists");

            $mailtext_total_leave = " 0-0";


            //Check if its Leave or Permission
            if (isPermissionLeaveType($leave_type_id)) {

                $no_of_days = $hours_diff;
                $mailtext_total_leave = $hours_diff . " Hour(s)";
            } else {
                //Now its leave type

                $text_content = 'ERROR';
                ////Check if its 0.5 day leave, then handle separately

                if ($no_of_days == '0.5') {
                    if ($leave_session == "FN") {
                        $text_content = "Fore-noon";
                    } else
                        if ($leave_session == "AN") {
                            $text_content = "After-noon";
                        }
                } else {
                    //If its not half day leave, then its fullday or custom days
                    $text_content = intval($no_of_days);
                    $leave_session = ''; //reset
                }

                $mailtext_total_leave = $text_content . " Day(s)";
            }


            //Save in DB
            $emp_leave_details = new VmtEmployeeLeaves;
            $emp_leave_details->user_id = $query_user->id;
            $emp_leave_details->leave_type_id = $leave_type_id;
            $emp_leave_details->leaverequest_date = $leave_request_date;
            $emp_leave_details->start_date = $start_date;
            $emp_leave_details->end_date = $end_date;
            $emp_leave_details->leave_reason = $leave_reason;
            $emp_leave_details->total_leave_datetime = $no_of_days . " " . $leave_session;


            //get manager of this employee

            $emp_leave_details->reviewer_user_id = $manager_id;

            if (!empty($notifications_users_id))
                $emp_leave_details->notifications_users_id = $notifications_users_id;

            $emp_leave_details->reviewer_comments = "";
            $emp_leave_details->status = "Pending";

            //dd($emp_leave_details->toArray());
            if ($emp_leave_details->save()) {
                //Logic for add employee leave id in intermediate Table
                $period = CarbonPeriod::create($emp_leave_details->start_date, $emp_leave_details->end_date)->toArray();
                foreach ($period as $single_date) {
                    $emp_att_int_query = VmtEmpAttIntrTable::where('user_id', $query_user->id)->whereDate('date', $single_date->format('Y-m-d'));
                    if ($emp_att_int_query->exists()) {
                        $emp_att_int_query = $emp_att_int_query->first();
                        $emp_att_int_query->emp_leave_id = $emp_leave_details->id;
                        $emp_att_int_query->save();
                    }
                }
            }


            ////If compensatory leave, then store the comp work days in 'vmt_employee_compensatory_leaves'
            if ($leave_type_id == $compensatory_leavetype_id) {
                $array_comp_work_days_ids = $compensatory_work_days_ids == '' ? null : $compensatory_work_days_ids;


                if (!empty($array_comp_work_days_ids) && is_array($array_comp_work_days_ids)) {

                    foreach ($array_comp_work_days_ids as $singleCompWorkDayID) {
                        $emp_compensatory_leave = new VmtEmployeeCompensatoryLeave;
                        $emp_compensatory_leave->employee_leave_id = $emp_leave_details->id;
                        $emp_compensatory_leave->employee_attendance_id = $singleCompWorkDayID;
                        $emp_compensatory_leave->save();
                    }
                }
            }
            ////

            //Need to send mail to 'reviewer' and 'notifications_users_id' list

            $message = "";
            $mail_status = "";

            $VmtClientMaster = VmtClientMaster::first();
            $image_view = url('/') . $VmtClientMaster->client_logo;

            //To store notif emails, if no notif emails given , then send this empty array to Mail::
            $notification_mails = array();
            $array_notif_ids = null;

            if (!empty($notifications_users_id)) {
                //Create array from CSV value
                $array_notif_ids = explode(',', $notifications_users_id);



                // dd($array_notif_ids);
                $notification_mails = VmtEmployeeOfficeDetails::whereIn('user_id', $array_notif_ids)->pluck('officical_mail');
            }

            $emp_avatar = json_decode(getEmployeeAvatarOrShortName($query_user->id), true);
            $manager_avatar = json_decode(getEmployeeAvatarOrShortName($query_manager->id), true);
            $emp_designation = VmtEmployeeOfficeDetails::where('user_id', $query_user->id)->first()->designation;

            //Save in notifications table
            // $serviceNotificationsService->saveNotification(
            //     user_code: $query_user->user_code,
            //     notification_title: "Leave request applied",
            //     notification_body: "Kindly take action",
            //     redirect_to_module: "Leave Approvals",
            //     recipient_user_code: $manager_emp_code,
            //     is_read: 0


            // );

            //send notification
            // $res_notification = $serviceNotificationsService->sendLeaveApplied_FCMNotification(
            //     notif_user_id: $query_user->user_code,
            //     leave_module_type: 'employee_applies_leave',
            //     manager_user_code: $manager_emp_code,
            //     notifications_users_id: $array_notif_ids ?? null,
            // );

            // $mail_status = "";
            $res_notification = "";

            if ($user_type == "Employee") {
                $when = carbon::now()->addSeconds(5);
                $isSent = \Mail::to($reviewer_mail)->cc($notification_mails)->later(
                    $when,
                    new RequestLeaveMail(
                        uEmployeeName: $query_user->name,
                        uEmpCode: $query_user->user_code,
                        //uEmpAvatar: $emp_avatar,
                        uManagerName: $manager_name,
                        uLeaveRequestDate: Carbon::parse($leave_request_date)->format('M jS Y'),
                        uStartDate: Carbon::parse($start_date)->format('M jS Y'),
                        uEndDate: Carbon::parse($end_date)->format('M jS Y'),
                        uReason: $leave_reason,
                        uLeaveType: $leave_type_name,
                        uTotal_leave_datetime: $mailtext_total_leave,
                        //Carbon::parse($request->total_leave_datetime)->format('M jS Y \\, h:i:s A'),
                        loginLink: request()->getSchemeAndHttpHost(),
                        image_view: $image_view,
                        emp_image: $emp_avatar,
                        manager_image: $manager_avatar,
                        emp_designation: $emp_designation
                    )
                );


                if ($isSent) {
                    $mail_status = "success";
                } else {
                    $mail_status = "failure";
                }
            }


            $response = [
                'status' => 'success',
                'message' => 'Leave Request applied successfully',
                'mail_status' => $mail_status ?? "",
                'notification' => $res_notification ?? '',
            ];
            return $response;
        } catch (TransportException $e) {
            return $response = [
                'status' => 'success',
                'message' => 'Leave Request applied successfully',
                'mail_status' => 'failure',
                'notification' => $res_notification ?? '',
                'error' => $e->getMessage(),
                'error_verbose' => $e->getTraceAsString(),
            ];
        } catch (\Exception $e) {
            return $response = [
                'status' => 'failure',
                'message' => 'Error while applying leave request',
                'mail_status' => 'failure',
                'notification' => '',
                'error' => $e->getMessage(),
                'error_verbose' => $e->getTraceAsString()
            ];
        }
    }

    public function approveRejectRevokeLeaveRequest($record_id, $approver_user_code, $status, $user_type, $review_comment, $serviceNotificationsService)
    {

        $validator = Validator::make(
            $data = [
                'record_id' => $record_id,
                'approver_user_code' => $approver_user_code,
                'status' => $status,
                'review_comment' => $review_comment,
            ],
            $rules = [
                'record_id' => 'required|exists:vmt_employee_leaves,id',
                'approver_user_code' => 'required|exists:users,user_code',
                'status' => ['required', Rule::in(['Approved', 'Rejected', 'Revoked'])],
                'review_comment' => 'nullable',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'integer' => 'Field :attribute should be integer',
                'in' => 'Field :attribute is invalid',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        try {
            //Get the user_code
            $query_user = User::where('user_code', $approver_user_code)->first();
            $approver_user_id = $query_user->id;

            // $approval_status = $request->status;
            $leave_record = VmtEmployeeLeaves::where('id', $record_id)->first();

            //Check whether the current status matches with the incoming status.
            if ($leave_record->status == $status) {
                if ($status == "Approved") {
                    $text_status = "approved";
                } else
                    if ($status == "Rejected") {
                        $text_status = "rejected";
                    }

                return $response = [
                    'status' => 'failure',
                    'message' => 'Leave Request has been already ' . $text_status,
                    'mail_status' => 'Not sent',
                    'notification' => 'Not sent',
                    'error' => '',
                    'error_verbose' => ''
                ];
            }

            $start_Date = Carbon::parse($leave_record->start_date)->format('Y-m-d');
            $end_Date = Carbon::parse($leave_record->end_date)->format('Y-m-d');

            $dateRange = CarbonPeriod::create($start_Date, $end_Date);

            if ($status == 'Approved') {

                $leave_type = VmtLeaves::where('id', $leave_record->leave_type_id)->first();
                if (!empty($leave_type)) {

                    switch ($leave_type->leave_type) {

                        case 'Sick Leave / Casual Leave';
                            $leave_type = 'SL/CL';
                            break;
                        case 'Casual/Sick Leave';
                            $leave_type = 'CL/SL';
                            break;
                        case 'LOP Leave';
                            $leave_type = 'LOP LE';
                            break;
                        case 'Earned Leave';
                            $leave_type = 'EL';
                            break;
                        case 'Maternity Leave';
                            $leave_type = 'ML';
                            break;
                        case 'Paternity Leave';
                            $leave_type = 'PTL';
                            break;
                        case 'On Duty';
                            $leave_type = 'OD';
                            break;
                        case 'Permissions';
                            $leave_type = 'PI';
                            break;
                        case 'Permission';
                            $leave_type = 'PI';
                            break;
                        case 'Compensatory Off';
                            $leave_type = 'CO';
                            break;
                        case 'Casual Leave';
                            $leave_type = 'CL';
                            break;
                        case 'Sick Leave';
                            $leave_type = 'SL';
                            break;
                        case 'Compensatory Leave';
                            $leave_type = 'CO';
                            break;
                        case 'Compensatory Leave';
                            $leave_type = 'FO L';
                            break;
                    }
                }

                foreach ($dateRange as $single_date) {

                    $leave_date = $single_date->format('Y-m-d');
                    $employee_leave_status = VmtEmpAttIntrTable::where('user_id', $leave_record->user_id)->where('date', $leave_date);
                    if ($employee_leave_status->exists()) {
                        $employee_leave_status = $employee_leave_status->first();
                        $employee_leave_status->emp_leave_id = $leave_record->id;
                        $employee_leave_status->status = $leave_type;
                        $employee_leave_status->save();
                    }
                }
            } else {
                foreach ($dateRange as $single_date) {

                    $leave_date = $single_date->format('Y-m-d');

                    $employee_leave_status = VmtEmpAttIntrTable::where('user_id', $leave_record->user_id)->where('date', $leave_date);
                    if ($employee_leave_status->exists()) {
                        $employee_leave_status = $employee_leave_status->first();
                        $employee_leave_status->emp_leave_id = $leave_record->id;
                        $employee_leave_status->save();
                    }
                }
            }
            //dd($leave_record);
            //dd( $leave_record);
            //dd( $request->status);
            if ($status == "Revoked") {
                $leave_record->is_revoked = "true";
                $leave_record->status = "Pending";
            } else {
                //For Approved or rejected status
                $leave_record->status = $status;
            }

            $leave_record->reviewer_user_id = $approver_user_id;
            $leave_record->reviewer_comments = $review_comment ?? "";
            $leave_record->reviewed_date = Carbon::now()->format('Y-m-d H:i:s');
            $leave_record->save();

            //Send mail to the employee
            $employee_user_id = $leave_record->user_id;
            $query_employee_mail = VmtEmployeeOfficeDetails::where('user_id', $employee_user_id)->first();
            $employee_mail = $query_employee_mail->officical_mail;

            if (empty($employee_mail)) {

                //If employee official mail is empty, then get the mail from Users table.
                $personal_mail = User::find($employee_user_id)->mail;

                if (empty($personal_mail)) {

                    //Send error message stating that the employee mail is missing.
                    return response()->json([
                        'status' => 'failure',
                        'message' => "No Official or Personal mail found for this employee. Please contact the administrator",
                    ]);
                } else {
                    $employee_mail = $personal_mail;

                    //Copy the personal mail to the official mail column.
                    $query_employee_mail->officical_mail = $personal_mail;
                    $query_employee_mail->save();

                }

            }


            $obj_employee = User::where('id', $employee_user_id)->first();
            $manager_user_id = $leave_record->reviewer_user_id;

            $message = "";
            $mail_status = "";

            $VmtClientMaster = VmtClientMaster::first();
            $image_view = url('/') . $VmtClientMaster->client_logo;

            $emp_avatar = json_decode(getEmployeeAvatarOrShortName($approver_user_id), true);
            $text_status = '';

            if (!empty($user_type) && $user_type == "Admin") {
                $when = carbon::now()->addSeconds(5);
                $isSent = \Mail::to($employee_mail)->later(
                    $when,
                    new ApproveRejectLeaveMail(
                        $obj_employee->name,
                        $obj_employee->user_code,
                        VmtLeaves::find($leave_record->leave_type_id)->leave_type,
                        User::find($manager_user_id)->name,
                        User::find($manager_user_id)->user_code,
                        request()->getSchemeAndHttpHost(),
                        $image_view,
                        $emp_avatar,
                        $status,
                        $user_type = "Admin",
                    )
                );

                if ($isSent) {
                    $mail_status = "Mail sent successfully";
                } else {
                    $mail_status = "There was one or more failures.";
                }
            } else {
                $when = carbon::now()->addSeconds(5);
                $isSent = \Mail::to($employee_mail)->later(
                    $when,
                    new ApproveRejectLeaveMail(
                        $obj_employee->name,
                        $obj_employee->user_code,
                        VmtLeaves::find($leave_record->leave_type_id)->leave_type,
                        User::find($manager_user_id)->name,
                        User::find($manager_user_id)->user_code,
                        request()->getSchemeAndHttpHost(),
                        $image_view,
                        $emp_avatar,
                        $status,
                        $user_type
                    )

                );
                if ($isSent) {
                    $mail_status = "success";
                } else {
                    $mail_status = "failure";
                }


                if ($status == "Approved") {
                    $text_status = "approved";
                    $leave_module_type = 'manager_approves_leave';
                } else
                    if ($status == "Rejected") {
                        $text_status = "rejected";
                        $leave_module_type = 'manager_rejects_leave';
                    } else
                        if ($status == "Revoked") {
                            $text_status = "revoked";
                            $leave_module_type = 'manager_revokes_leave';
                        }

                $users_id = VmtEmployeeOfficeDetails::where('l1_manager_code', $approver_user_code);

                if ($users_id->exists()) {

                    $users_id = $users_id->first()->user_id;

                    $res_notification = $serviceNotificationsService->sendLeaveApplied_FCMNotification(
                        notif_user_id: User::where('id', $users_id)->first()->user_code,
                        leave_module_type: $leave_module_type,
                        manager_user_code: $approver_user_code,
                    );
                }
            }

            $response = [
                'status' => 'success',
                'message' => 'Leave Request ' . $text_status . ' successfully',
                'mail_status' => $mail_status,
                'notification' => $res_notification ?? 'Not sent',
                'error' => '',
                'error_verbose' => ''
            ];

            return $response;
        } catch (TransportException $e) {

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Leave Request ' . $text_status . ' successfully',
                    'mail_status' => 'failure',
                    'error' => $e->getMessage(),
                    'error_verbose' => $e
                ]
            );
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ approveRejectRevokeLeaveRequest() ] " . $e->getMessage(),
                'data' => $e->getMessage()
            ]);
        }
    }


    public function withdrawLeave($leave_id, $withdraw_comment)
    {

        $validator = Validator::make(
            $data = [
                "leave_id" => $leave_id,
                "withdraw_comment" => $withdraw_comment
            ],
            $rules = [
                'leave_id' => 'required|exists:vmt_employee_leaves,id',
                'withdraw_comment' => 'required'
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'in' => 'Field :attribute is invalid',
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        try {
            $leave_details = VmtEmployeeLeaves::find($leave_id);

            //Check whether current loggedin user_id matches with leave's user_id
            if ($leave_details->user_id == auth()->user()->id) {
                $leave_details->status = 'Withdrawn';
                if (!empty($withdraw_comment)) {
                    $leave_details->reviewer_comments = $withdraw_comment;
                }
                if ($leave_details->save()) {
                    //Logic for remove employee leave id in intermediate Table
                    $period = CarbonPeriod::create($leave_details->start_date, $leave_details->end_date)->toArray();
                    foreach ($period as $single_date) {
                        $emp_att_int_query = VmtEmpAttIntrTable::where('user_id', $leave_details->user_id)->whereDate('date', $single_date->format('Y-m-d'));
                        if ($emp_att_int_query->exists()) {
                            $emp_att_int_query = $emp_att_int_query->first();
                            $emp_att_int_query->emp_leave_id = null;
                            $emp_att_int_query->save();
                        }

                    }
                }
            } else {
                //User id mismatching .
                return [
                    'status' => 'failure',
                    'message' => 'You are not authorized to perform this operation',
                    'error' => 'Unable to withdrawn leave due to mismatch in user_id',
                    'error_verbose' => ''
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Leave withdrawn successfully',
                'error' => '',
                'error_verbose' => ''
            ];
        } catch (Exception $e) {
            return [
                'status' => 'failure',
                'message' => 'While Withdrawn Leave Got Error',
                'error' => $e->getMessage(),
                'error_verbose' => $e->getTraceAsString()
            ];
        }
    }
    public function withdrawAttendanceRegularization($att_reg_id, $user_id, $regularize_type)
    {

        $validator = Validator::make(
            $data = [
                "att_reg_id" => $att_reg_id,
            ],
            $rules = [
                'att_reg_id' => 'required|exists:vmt_employee_leaves,id',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'in' => 'Field :attribute is invalid',
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        try {
            $leave_details = VmtEmployeeAttendanceRegularization::find($att_reg_id);

            //Check whether current loggedin user_id matches with leave's user_id
            if ($leave_details->user_id == $user_id) {
                $leave_details->status = 'Withdrawn';
                $leave_details->save();
            } else {
                //User id mismatching .
                return [
                    'status' => 'failure',
                    'message' => 'You are not authorized to perform this operation',
                    'error' => 'Unable to withdrawn ' . $regularize_type . ' due to mismatch in user_id',
                    'error_verbose' => ''
                ];
            }

            return [
                'status' => 'success',
                'message' => $regularize_type . ' withdrawn successfully',
                'error' => '',
                'error_verbose' => ''
            ];
        } catch (Exception $e) {
            return [
                'status' => 'failure',
                'message' => 'While Withdrawn ' . $regularize_type . ' Got Error',
                'error' => $e->getMessage(),
                'error_verbose' => $e->getTraceAsString()
            ];
        }
    }
    public function withdrawAbsentRegularization($absent_reg_id, $user_id)
    {

        $validator = Validator::make(
            $data = [
                "absent_reg_id" => $absent_reg_id,
            ],
            $rules = [
                'absent_reg_id' => 'required|exists:vmt_employee_leaves,id',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'in' => 'Field :attribute is invalid',
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        try {
            $leave_details = VmtEmployeeAbsentRegularization::find($absent_reg_id);

            //Check whether current loggedin user_id matches with leave's user_id
            if ($leave_details->user_id == $user_id) {
                $leave_details->status = 'Withdrawn';
                $leave_details->save();
            } else {
                //User id mismatching .
                return [
                    'status' => 'failure',
                    'message' => 'You are not authorized to perform this operation',
                    'error' => 'Unable to withdrawn Absent Regularization due to mismatch in user_id',
                    'error_verbose' => ''
                ];
            }

            return [
                'status' => 'success',
                'message' => 'Absent Regularization withdrawn successfully',
                'error' => '',
                'error_verbose' => ''
            ];
        } catch (Exception $e) {
            return [
                'status' => 'failure',
                'message' => 'While Withdrawn Absent Regularization Got Error',
                'error' => $e->getMessage(),
                'error_verbose' => $e->getTraceAsString()
            ];
        }
    }

    public function findMIPOrMOP($time, $shiftStartTime, $shiftEndTime)
    {
        $response = array();
        $shift_start_time = $shiftStartTime->subHours(2)->format('Y-m-d H:i:0');
        $first_half_end_time = $shiftStartTime->addHours(6);
        if (Carbon::parse($time)->between(Carbon::parse($shift_start_time), $first_half_end_time, true)) {
            $response['checkin_time'] = $time;
            $response['checkout_time'] = null;
        } else {
            $response['checkin_time'] = null;
            $response['checkout_time'] = $time;
        }
        return $response;
    }

    public function fetchAttendanceMonthStatsReport($user_code, $year, $month)
    {

        //Get the user_code
        $query_user = User::where('user_code', $user_code)->first();
        $user_id = $query_user->id;

        // code...
        $workingCount = $onTimeCount = $lateCount = $leftTimelyCount = $leftEarlyCount = $onLeaveCount = $absentCount = 0;

        //$reportMonth  = $request->has('month') ? $request->month : date('m');

        //$monthlyGroups = VmtEmployeeAttendance::select(\DB::raw('MONTH(date) month'))->where('user_id', $user_id)->groupBy('month')->orderBy('month', 'DESC')->get();
        //$monthlyReport =  [];

        //foreach ($monthlyGroups as $key => $value) {
        // code...
        //dd($value);
        $dailyAttendanceReport = VmtEmployeeAttendance::select('id', 'date', 'user_id', 'checkin_time', 'checkout_time', 'leave_type_id', 'shift_type')
            ->where('user_id', $user_id)
            ->whereYear("date", $year)
            ->whereMonth("date", $month)
            ->orderBy('created_at', 'DESC')
            ->get();


        $workingCount = $dailyAttendanceReport->count();

        if ($workingCount == 0) {
            return null;
        } else {
            $onLeaveCount = $dailyAttendanceReport->whereNotNull('leave_type_id')->count();

            $monthlyReport = array(
                "year_value" => substr($dailyAttendanceReport[0]["date"], 0, 4),
                "month_value" => $month,
                "working_days" => $workingCount,
                "on_time" => $onTimeCount,
                "late" => $lateCount,
                "left_timely" => $leftTimelyCount,
                "left_early" => $leftEarlyCount,
                "on_leave" => $onLeaveCount,
                "absent" => $absentCount,
                "daily_attendance_report" => $dailyAttendanceReport
            );
        }

        return $monthlyReport;
    }


    public function isRegularizationRequestApplied($user_id, $attendance_date, $regularizeType)
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

    public function applyRequestAbsentRegularization(
        $user_code,
        $attendance_date,
        $regularization_type,
        $checkin_time,
        $checkout_time,
        $reason,
        $custom_reason,
        $user_type
    ) {

        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
                "attendance_date" => $attendance_date,
                "regularization_type" => $regularization_type,
                "checkin_time" => $checkin_time,
                "checkout_time" => $checkout_time,
                "reason" => $reason,
                "custom_reason" => $custom_reason,
                // "reviewer_id" => $reviewer_id,
                // "reviewer_comments" => $reviewer_comments,
                // "reviewer_reviewed_date" => $reviewer_reviewed_date,
                // "status" => $status,
            ],
            $rules = [
                'user_code' => 'required|exists:users,user_code',
                'regularization_type' => ['required', Rule::in('Absent Regularization')],
                'attendance_date' => 'required',
                'checkin_time' => 'required',
                'checkout_time' => 'required',
                'reason' => 'required',
                'custom_reason' => 'nullable',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'in' => 'Field :attribute is invalid',
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        try {

            if ($checkin_time == $checkout_time) {

                return $response = ([
                    'status' => 'failure',
                    'message' => "The check-in and check-out times must differ. Please adjust the check-in or check-out time before proceeding.",
                    'data' => "",
                ]);
            }

            if ($checkout_time < $checkin_time) {

                return $response = ([
                    'status' => 'failure',
                    'message' => "Ensure that the check-out time is not earlier than the check-in time on the specified date.",
                    'data' => "",
                ]);
            }
            // if($checkin_time > $checkout_time ){

            //     return $response=([
            //         'status' => 'failure',
            //         'message' => "Check-IN time does not exceed the Check-OUT time on the same date.",
            //         'data' =>"",
            //     ]);
            // }
            $query_user = User::where('user_code', $user_code)->first();

            $user_id = $query_user->id;

            //Check if already applied
            $query_att = VmtEmployeeAbsentRegularization::where('attendance_date', $attendance_date)
                ->where('user_id', $user_id);

            if ($query_att->exists()) {
                return $response = ([
                    'status' => 'failure',
                    'message' => 'Absent Regularization already applied for the given date',
                    'data' => ''
                ]);
            }

            //fetch the data
            $absent_regularization = new VmtEmployeeAbsentRegularization;
            $absent_regularization->user_id = $user_id;
            $absent_regularization->attendance_date = $attendance_date;
            $absent_regularization->regularization_type = $regularization_type;
            $absent_regularization->checkin_time = $checkin_time;
            $absent_regularization->checkout_time = $checkout_time;
            $absent_regularization->reason = $reason;
            $absent_regularization->custom_reason = $custom_reason ?? '';
            $absent_regularization->status = "Pending";
            $absent_regularization->save();

            if ($user_type != "Admin") {
                $update_empl_att_status = VmtEmpAttIntrTable::where('date', $attendance_date)->where('user_id', $user_id)->first();

                if (!empty($update_empl_att_status)) {
                    $update_empl_att_status->absent_reg_id = $absent_regularization->id;
                    $update_empl_att_status->save();
                }
            }
            //Send mail to manager

            $mail_status = "";

            //Get manager details
            $manager_usercode = VmtEmployeeOfficeDetails::where('user_id', $user_id)->first()->l1_manager_code;
            $manager_details = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->where('users.user_code', $manager_usercode)->first(['users.name', 'users.user_code', 'vmt_employee_office_details.officical_mail']);

            //dd($manager_details);


            $VmtClientMaster = VmtClientMaster::first();
            $image_view = url('/') . $VmtClientMaster->client_logo;

            $emp_avatar = json_decode(getEmployeeAvatarOrShortName($user_id));
            $isSent = null;



            if (!empty($user_type) && $user_type != "Admin") {
                if (empty($manager_details)) {
                    //Manager mail is empty or no manager assigned. Cant send mail
                    return response()->json([
                        'status' => 'failure',
                        'message' => "Manager mail is not found. Kindly contact the Admin.",
                        'data' => ''
                    ]);
                } else {
                    //If Manager mail is available, then send mail
                    $when = carbon::now()->addSeconds(5);
                    $isSent = \Mail::to($manager_details->officical_mail)->later(
                        $when,
                        new VmtAbsentMail_Regularization(
                            $query_user->name,
                            $query_user->user_code,
                            $emp_avatar,
                            $attendance_date,
                            $manager_details->name,
                            $manager_details->user_code,
                            request()->getSchemeAndHttpHost(),
                            $image_view,
                            $custom_reason,
                            "Pending",
                            "",
                        )
                    );
                }

                if ($isSent) {
                    $mail_status = "Mail sent successfully";
                } else {
                    $mail_status = "There was one or more failures.";
                }
            }

            return $response = ([
                'status' => 'success',
                'message' => 'Absent Regularization applied successfully',
                'mail_status' => $mail_status,
                'data' => ''
            ]);
        } catch (TransportException $e) {

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Absent Regularization applied successfully',
                    'mail_status' => 'failure',
                    'error' => $e->getMessage(),
                    'error_verbose' => $e
                ]
            );
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ applyRequestAbsentRegularization() ] " . $e->getMessage(),
                'data' => $e->getMessage()
            ]);
        }
    }

    public function getAttendanceRegularizationStatus($user_code, $regularization_date, $regularization_type)
    {

        //Sample Input : ABS1006, 2023-07-29, LC
        //Sample Output : JSON structure of table row

        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
                "regularization_date" => $regularization_date,
                "regularization_type" => $regularization_type,
            ],
            $rules = [
                'user_code' => 'required|exists:users,user_code',
                'regularization_type' => ['required', Rule::in(['LC', 'EG', 'MIP', 'MOP', 'Absent Regularization'])],
                'regularization_date' => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'in' => 'Field :attribute is invalid',
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

            if (Str::contains($regularization_type, ['LC', 'EG', 'MIP', 'MOP'])) {

                //Check if already request applied
                $data = VmtEmployeeAttendanceRegularization::where('attendance_date', $regularization_date)
                    ->where('user_id', $user_id)
                    ->where('regularization_type', $regularization_type);

                if ($data->exists()) {

                    //Adding 'is_exists' key for quick checking in frontend
                    $data = [
                        "is_exists" => 1,
                        "data" => $data->get()
                    ];

                    return $responseJSON = [
                        'status' => 'success',
                        'message' => 'Attendance Regularization status fetched successfully',
                        'data' => $data
                    ];
                } else {
                    //If data doesnt exists, then send 0

                    return $responseJSON = [
                        'status' => 'success',
                        'message' => 'Attendance Regularization status fetched successfully',
                        'data' => [
                            "is_exists" => 0
                        ]
                    ];
                }
            } else
                if (Str::contains($regularization_type, ['Absent Regularization'])) {
                }

            //,'Absent Regularization'

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error while fetching Attendance Regularization Status",
                'data' => "Error[ getAttendanceRegularizationStatus() ] " . $e->getMessage(),
            ]);
        }
    }

    public function applyRequestAttendanceRegularization($user_code, $attendance_date, $regularization_type, $user_time, $regularize_time, $reason, $custom_reason, $user_type, VmtNotificationsService $serviceVmtNotificationsService)
    {

        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
                "attendance_date" => $attendance_date,
                "regularization_type" => $regularization_type,
                "user_time" => $user_time,
                "regularize_time" => $regularize_time,
                "reason" => $reason,
                "custom_reason" => $custom_reason,
            ],
            $rules = [
                'user_code' => 'required|exists:users,user_code',
                "attendance_date" => "required",
                'regularization_type' => ['required', Rule::in(['LC', 'EG', 'MIP', 'MOP'])],
                "user_time" => "nullable",
                "regularize_time" => "required",
                "reason" => "required", //
                "custom_reason" => "nullable",
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
                "required_with" => "Field :attribute is missing",
                'in' => 'Field :attribute is invalid',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try {

            $query_user = User::where('user_code', $user_code)->first();
            $user_id = $query_user->id;

            // $employee_Bio_attendance_data = $this->getBioMetricAttendanceData($user_code, $attendance_date);

            // $checkin_time = "";
            // $checkout_time = "";
            // if (!empty($employee_Bio_attendance_data)) {

            //     $checkin_time = $employee_Bio_attendance_data[0]['checkin_time'];
            //     $checkout_time = $employee_Bio_attendance_data[0]['checkout_time'];
            // }

            // $employee_web_attendance_data = VmtEmpAttIntrTable::where('date', $attendance_date)
            //     ->where('user_id',  $user_id);

            // if ($employee_web_attendance_data->exists()) {

            //     $checkin_time = $employee_web_attendance_data->first()->checkin_time;
            //     $checkout_time = $employee_web_attendance_data->first()->checkout_time;
            // }


            // if ($regularization_type == 'LC' && $regularize_time > $checkin_time) {

            //     return $response = ([
            //         'status' => 'failure',
            //         'message' => "regularize time does not exceed the check-in time on the same date",
            //         'data' => "",
            //     ]);
            // }

            // if ($regularization_type == 'EG' && $regularize_time > $checkout_time) {

            //     return $response = ([
            //         'status' => 'failure',
            //         'message' => "Ensure that the regularzie time is not earlier than the check-out time on the specified date.",
            //         'data' => "",
            //     ]);
            // }
            //Get the user_code


            //Check if already request applied
            $data = VmtEmployeeAttendanceRegularization::where('attendance_date', $attendance_date)
                ->where('user_id', $user_id)
                ->where('regularization_type', $regularization_type);

            if ($data->exists()) {
                //dd("Request already applied");
                return $responseJSON = [
                    'status' => 'failure',
                    'message' => 'Request already applied',
                    'mail_status' => '',
                    'data' => [],
                ];
            } else {

                //dd("Request not applied");

                //For LC, EG : user_time is mandatory , So check it
                if (($regularization_type == 'LC' || $regularization_type == 'EG') && empty($user_time)) {
                    //if user_time is null, then throw error
                    return $responseJSON = [
                        'status' => 'failure',
                        'message' => 'User Time is missing',
                        'mail_status' => '',
                        'data' => [],
                    ];
                } else
                    if ($regularization_type == 'MIP' || $regularization_type == 'MOP')
                        $user_time = null;

                $attendanceRegularizationRequest = new VmtEmployeeAttendanceRegularization;
                $attendanceRegularizationRequest->user_id = $user_id;
                $attendanceRegularizationRequest->attendance_date = $attendance_date;
                $attendanceRegularizationRequest->regularization_type = $regularization_type;
                $attendanceRegularizationRequest->user_time = empty($user_time) ? null : Carbon::createFromFormat('H:i:s', $user_time);
                $attendanceRegularizationRequest->regularize_time = Carbon::createFromFormat('H:i:s', $regularize_time);
                $attendanceRegularizationRequest->reason_type = $reason;
                $attendanceRegularizationRequest->custom_reason = $custom_reason ?? '';
                $attendanceRegularizationRequest->status = 'Pending';

                $attendanceRegularizationRequest->save();
            }



            if ($user_type != "Admin") {

                if (!empty($attendanceRegularizationRequest)) {
                    $att_intr_record = VmtEmpAttIntrTable::where('user_id', $user_id)->whereDate('date', $attendance_date);

                    if ($att_intr_record->exists()) {
                        $att_intr_record = $att_intr_record->first();
                        if ($regularization_type == 'LC') {
                            $att_intr_record->lc_id = $attendanceRegularizationRequest->id;
                        } else if ($regularization_type == 'EG') {
                            $att_intr_record->eg_id = $attendanceRegularizationRequest->id;
                        } else if ($regularization_type == 'MIP') {
                            $att_intr_record->mip_id = $attendanceRegularizationRequest->id;
                        } else if ($regularization_type == 'MOP') {
                            $att_intr_record->mop_id = $attendanceRegularizationRequest->id;
                        }
                        $att_intr_record->save();
                    }
                }
            }
            ////Send mail to Manager
            $res_notification = "";
            $mail_status = "";
            $isSent = "";


            //Get manager details
            $manager_usercode = VmtEmployeeOfficeDetails::where('user_id', $user_id)->first()->l1_manager_code;
            $manager_details = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->where('users.user_code', $manager_usercode)->first(['users.name', 'users.user_code', 'vmt_employee_office_details.officical_mail']);

            if (!empty($user_type) && $user_type != "Admin") {
                //Check if manager's mail exists or not
                if (!empty($manager_details)) {
                    //dd($manager_details);


                    $VmtClientMaster = VmtClientMaster::first();
                    $image_view = url('/') . $VmtClientMaster->client_logo;


                    $emp_avatar = json_decode(getEmployeeAvatarOrShortName($user_id), true);

                    $when = carbon::now()->addSeconds(5);
                    $isSent = \Mail::to($manager_details->officical_mail)->later(
                        $when,
                        new VmtAttendanceMail_Regularization(
                            $query_user->name,
                            $query_user->user_code,
                            $emp_avatar,
                            $attendance_date,
                            $manager_details->name,
                            $manager_details->user_code,
                            request()->getSchemeAndHttpHost(),
                            $image_view,
                            $custom_reason,
                            "Pending",
                            $user_type = "",
                        )
                    );

                    if ($isSent) {
                        $mail_status = "Mail sent successfully";
                    } else {
                        $mail_status = "There was one or more failures.";
                    }
                }


                if ($regularization_type == 'LC') {

                    $attendance_regularization_type = 'employee_applies_lc';
                } else if ($regularization_type == 'EG') {

                    $attendance_regularization_type = 'employee_applies_eg';
                } else if ($regularization_type == 'MOP') {

                    $attendance_regularization_type = 'employee_applies_mop';
                } else if ($regularization_type == 'MIP') {

                    $attendance_regularization_type = 'employee_applies_mip';
                }

                // $res_notification = $serviceVmtNotificationsService->send_attendance_regularization_FCMNotification(
                //     notif_user_id: $user_id,
                //     attendance_regularization_type: $attendance_regularization_type,
                //     manager_user_code: $manager_usercode,
                // );
            }


            return [
                'status' => 'success',
                'message' => 'Request sent successfully!',
                //'notification_status' => $res_notification,
                'mail_status' => $mail_status,
                'data' => [],
            ];
        } catch (TransportException $e) {

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Attendance Regularization applied successfully',
                    'mail_status' => 'failure',
                    'error' => $e->getMessage(),
                    'error_verbose' => $e
                ]
            );
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error while Apply Attendance Regularization",
                'data' => $e->getMessage() . " " . $e->getline()
            ]);
        }
    }

    public function approveRejectAttendanceRegularization($approver_user_code, $record_id, $status, $status_text, $user_type, VmtNotificationsService $serviceVmtNotificationsService)
    {

        //Validate the request
        $validator = Validator::make(
            $data = [
                'approver_user_code' => $approver_user_code,
                'record_id' => $record_id,
                'status' => $status,
                'status_text' => $status_text,
            ],
            $rules = [
                'approver_user_code' => 'required|exists:users,user_code',
                'record_id' => 'required|exists:vmt_employee_attendance_regularizations,id',
                'status' => ['required', Rule::in(['Approved', 'Rejected'])],
                'status_text' => 'nullable',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'integer' => 'Field :attribute should be integer',
                'in' => 'Field :attribute is invalid',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }



        try {
            //Get the user_code
            $query_user = User::where('user_code', $approver_user_code)->first();
            $user_id = $query_user->id;

            $data = VmtEmployeeAttendanceRegularization::find($record_id);
            //dd(!empty($data) && $data->exists());

            if (!empty($data) && $data->exists() && $status == "Revoked") {
                $data->is_revoked = 1;
                $data->status = "Pending";

                $att_intr_record = VmtEmpAttIntrTable::where('user_id', $data->user_id)->whereDate('date', $data->attendance_date);
                if ($att_intr_record->exists()) {
                    $att_intr_record = $att_intr_record->first();
                    if ($data->regularization_type == 'LC') {
                        $att_intr_record->lc_id = null;
                    } else if ($data->regularization_type == 'EG') {
                        $att_intr_record->eg_id = null;
                    } else if ($data->regularization_type == 'MIP') {
                        $att_intr_record->mip_id = null;
                    } else if ($data->regularization_type == 'MOP') {
                        $att_intr_record->mop_id = null;
                    }

                    $sts_arr = explode('/', $att_intr_record->status);
                    if (in_array($data->regularization_type, $sts_arr)) {
                        array_splice($sts_arr, array_search($data->regularization_type, $sts_arr), 1);
                    }
                    if ($data->regularization_type == 'MIP') {
                        $sts_arr[0] = 'P/MIP';
                    }
                    if ($data->regularization_type == 'MOP') {
                        $sts_arr[0] = 'P/MOP';
                    }

                    if ($data->regularization_type == 'LC') {
                        $sts_arr[0] = 'P/LC';
                        $lc_mins = 0;
                    }

                    if ($data->regularization_type == 'EG') {
                        $sts_arr[0] = 'P/EG';
                    }
                }
            } else {
                if (!empty($data) && $data->exists()) {
                    $data->reviewer_id = $user_id;
                    $data->reviewer_reviewed_date = Carbon::now()->format('Y-m-d H:i:s');
                    $data->status = $status;
                    $data->reviewer_comments = $status_text ?? '---';
                    $data->save();
                    if ($data) {
                        $att_intr_record = VmtEmpAttIntrTable::where('user_id', $data->user_id)->whereDate('date', $data->attendance_date);
                        if ($att_intr_record->exists()) {
                            $att_intr_record = $att_intr_record->first();
                            if ($data->regularization_type == 'LC') {
                                $att_intr_record->lc_id = $data->id;
                            } else if ($data->regularization_type == 'EG') {
                                $att_intr_record->eg_id = $data->id;
                            } else if ($data->regularization_type == 'MIP') {
                                $att_intr_record->mip_id = $data->id;
                            } else if ($data->regularization_type == 'MOP') {
                                $att_intr_record->mop_id = $data->id;
                            }


                            if ($data->status == 'Approved') {
                                $sts_arr = explode('/', $att_intr_record->status);
                                if (in_array($data->regularization_type, $sts_arr)) {
                                    array_splice($sts_arr, array_search($data->regularization_type, $sts_arr), 1);
                                }
                                if ($data->regularization_type == 'MIP' || $data->regularization_type == 'MOP') {
                                    $sts_arr[0] = 'P';
                                }

                                if ($data->regularization_type == 'LC') {
                                    $sts_arr[0] = 'P';
                                    $lc_mins = 0;
                                } else {
                                    $lc_mins = $att_intr_record->lc_minutes;
                                }

                                if ($data->regularization_type == 'EG') {
                                    $sts_arr[0] = 'P';
                                    $eg_mins = 0;
                                } else {
                                    $eg_mins = $att_intr_record->eg_minutes;
                                }
                                $att_sts = implode('/', $sts_arr);
                                if ($data->regularization_type == 'MIP' || $data->regularization_type == 'LC') {
                                    $regular_checkin_time = $data->regularize_time;
                                    $regular_checkout_time = $att_intr_record->regularized_checkout_time;
                                } else if ($data->regularization_type == 'MOP' || $data->regularization_type == 'EG') {
                                    $regular_checkin_time = $att_intr_record->regularized_checkin_time;
                                    $regular_checkout_time = $data->regularize_time;
                                }
                                // $calculate_employee_overtime = (new EmployeeOverTimeCalculationsJobs())
                                // ->delay(Carbon::now()->addSeconds(12));

                                // dispatch($calculate_employee_overtime);

                            } else {
                                $att_sts = $att_intr_record->status;
                                $regular_checkin_time = $att_intr_record->regularized_checkin_time;
                                $regular_checkout_time = $att_intr_record->regularized_checkout_time;
                                $lc_mins = $att_intr_record->lc_minutes;
                                $eg_mins = $att_intr_record->eg_minutes;
                                $ot_mins = $att_intr_record->overtime;
                            }
                            $can_calculate_ot = VmtEmployeeWorkShifts::where('user_id', $att_intr_record->user_id)
                                ->where('work_shift_id', $att_intr_record->vmt_employee_workshift_id)->first()->can_calculate_ot;
                            if ($can_calculate_ot == 1) {
                                $shift_settings = VmtWorkShifts::where('id', $att_intr_record->vmt_employee_workshift_id)->first();
                                $shiftStartTime = Carbon::parse($att_intr_record->date . ' ' . $shift_settings->shift_start_time);
                                $shiftEndTime = Carbon::parse($att_intr_record->date . ' ' . $shift_settings->shift_end_time);
                                if ($regular_checkin_time != null) {
                                    $checkin_time_ot = $regular_checkin_time;
                                    // $checkin_time_ot
                                } else {
                                    $checkin_time_ot = $att_intr_record->checkin_date . ' ' . $att_intr_record->checkin_time;
                                }
                                if ($regular_checkout_time != null) {
                                    $checkout_time_ot = $regular_checkout_time;
                                    // $checkin_time_ot
                                } else {
                                    $checkout_time_ot = $att_intr_record->checkout_date . ' ' . $att_intr_record->checkout_time;
                                }
                                if ($checkout_time_ot != null && $checkin_time_ot != null) {
                                    if ($shift_settings->ot_calculation_type == 'shift_time') {
                                        if ($lc_mins != 0) {
                                            $gross_hours = Carbon::parse($checkin_time_ot)->diffInMinutes($checkout_time_ot);
                                        } else {
                                            $gross_hours = $shiftStartTime->diffInMinutes($checkout_time_ot);
                                        }
                                    } else if ($shift_settings->ot_calculation_type == 'actual_time') {
                                        $gross_hours = Carbon::parse($checkin_time_ot)->diffInMinutes($checkout_time_ot);
                                    }
                                    if ($shiftStartTime->diffInMinutes($shiftEndTime) + $shift_settings->minimum_ot_working_mins <= $gross_hours) {
                                        if ($shift_settings->ot_calculation_type == 'shift_time') {
                                            // dd($shiftEndTime, $checkout_time_ot);
                                            $ot_mins = $shiftEndTime->addMinutes($lc_mins)->diffInMinutes(Carbon::parse($checkout_time_ot));
                                        } else if ($shift_settings->ot_calculation_type == 'actual_time') {
                                            $shift_start_ot = $shiftStartTime->diffInMinutes(Carbon::parse($checkin_time_ot));
                                            $shift_end_ot = $shiftEndTime->diffInMinutes(Carbon::parse($checkout_time_ot));
                                            $ot_mins = $shift_start_ot + $shift_end_ot;
                                        }
                                    }
                                }
                            } else {
                                $ot_mins = $att_intr_record->overtime;
                            }
                            $att_intr_record->status = $att_sts;
                            $att_intr_record->regularized_checkin_time = $regular_checkin_time;
                            $att_intr_record->regularized_checkout_time = $regular_checkout_time;
                            $att_intr_record->lc_minutes = $lc_mins;
                            $att_intr_record->eg_minutes = $eg_mins;
                            $att_intr_record->overtime = $ot_mins;
                            $att_intr_record->save();
                        }
                    }
                } else {
                    return $responseJSON = [
                        'status' => 'failure',
                        'message' => 'Record not found',
                        'mail_status' => '',
                        'data' => [],
                    ];
                }
            }

            //Send mail to Employee

            $mail_status = "";
            $res_notification = "";

            // Get employee details
            if (!empty($user_type) && $user_type == "Admin") {

                $employee_details = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                    ->where('users.id', $data->user_id)->first(['users.name', 'users.user_code', 'vmt_employee_office_details.officical_mail']);

                //dd($employee_details->officical_mail);


                $VmtClientMaster = VmtClientMaster::first();
                $image_view = url('/') . $VmtClientMaster->client_logo;
                $emp_avatar = json_decode(getEmployeeAvatarOrShortName($query_user->id));
                $when = carbon::now()->addSeconds(5);
                $isSent = \Mail::to($employee_details->officical_mail)->later(
                    $when,
                    new VmtAttendanceMail_Regularization(
                        $employee_details->name,
                        $employee_details->user_code,
                        $emp_avatar,
                        $data->attendance_date,
                        $query_user->name,
                        $query_user->user_code,
                        request()->getSchemeAndHttpHost(),
                        $image_view,
                        $status_text,
                        $status,
                        $user_type = "Admin",
                    )
                );

                if ($isSent) {
                    $mail_status = "Mail sent successfully";
                } else {
                    $mail_status = "There was one or more failures.";
                }
            } else {

                $employee_details = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                    ->where('users.id', $data->user_id)->first(['users.name', 'users.user_code', 'vmt_employee_office_details.officical_mail']);

                //dd($employee_details->officical_mail);


                $VmtClientMaster = VmtClientMaster::first();
                $image_view = url('/') . $VmtClientMaster->client_logo;
                $emp_avatar = json_decode(newgetEmployeeAvatarOrShortName($query_user->id), true);
                $when = carbon::now()->addSeconds(5);
                $isSent = \Mail::to($employee_details->officical_mail)->later(
                    $when,
                    new VmtAttendanceMail_Regularization(
                        $employee_details->name,
                        $employee_details->user_code,
                        $emp_avatar,
                        $data->attendance_date,
                        $query_user->name,
                        $query_user->user_code,
                        request()->getSchemeAndHttpHost(),
                        $image_view,
                        $status_text,
                        $status,
                        $user_type = "manager",

                    )
                );

                if ($isSent) {
                    $mail_status = "Mail sent successfully";
                } else {
                    $mail_status = "There was one or more failures.";
                }
                if ($status == 'Approved') {

                    $attendance_regularization_type = 'manager_approves_attendance_reg';
                } else if ($status == 'Rejected') {

                    $attendance_regularization_type = 'manager_rejects_attendance_reg';
                }

                $res_notification = $serviceVmtNotificationsService->send_attendance_regularization_FCMNotification(
                    notif_user_id: $data->user_id,
                    attendance_regularization_type: $attendance_regularization_type,
                    manager_user_code: $approver_user_code,
                );
            }

            return $responseJSON = [
                'status' => 'success',
                'message' => 'Regularization done successfully!',
                'notification_status' => $res_notification ?? "",
                'mail_status' => $mail_status ?? "",
                'data' => [],
            ];
        } catch (TransportException $e) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Attendance Regularization approval successful',
                    'mail_status' => 'failure',
                    'error' => $e->getMessage(),
                    'error_string' => $e->getTraceAsString(),
                    'error_verbose' => $e->getline(),
                ]
            );
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ approveRejectAttendanceRegularization() ) ] ",
                'error_string' => $e->getTraceAsString(),
                'data' => $e->getMessage(),
                'error_line' => $e->getline(),
            ]);
        }
    }

    public function approveRejectAbsentRegularization($approver_user_code, $record_id, $status, $status_text, $user_type, $serviceVmtAttendanceReportsService)
    {
        $validator = Validator::make(
            $data = [
                'approver_user_code' => $approver_user_code,
                'record_id' => $record_id,
                'status' => $status,
                'status_text' => $status_text,
            ],
            $rules = [
                'approver_user_code' => 'required|exists:users,user_code',
                'record_id' => 'required|exists:vmt_employee_absent_regularizations,id',
                'status' => ['required', Rule::in(['Approved', 'Rejected', 'Revoked'])],
                'status_text' => 'nullable',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'integer' => 'Field :attribute should be integer',
                'in' => 'Field :attribute is invalid',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }
        try {
            // dd($approver_user_code, $record_id, $status, $status_text);
            //Get the user_code
            $query_user = User::where('user_code', $approver_user_code)->first();
            $user_id = $query_user->id;

            $data = VmtEmployeeAbsentRegularization::find($record_id);
            //dd(!empty($data) && $data->exists());

            if ($status == "Approved") {


                $update_empl_att_status = VmtEmpAttIntrTable::where('date', $data->attendance_date)->where('user_id', $data->user_id)->first();

                if (!empty($update_empl_att_status)) {


                    $update_empl_att_status->absent_reg_id = $data->id;

                    if ($update_empl_att_status->status == "A/SW" || $update_empl_att_status->status == "A") {
                        $update_empl_att_status->status = "P";
                    }
                    $update_empl_att_status->save();
                }

                $check_sandwich_status = $serviceVmtAttendanceReportsService->checkEmployeeSandwichstatus($data->attendance_date, $user_id);
            }

            if ($status == "Revoked") {

                $update_empl_att_status = VmtEmpAttIntrTable::where('date', $data->attendance_date)->where('user_id', $data->user_id)->first();
                $update_empl_att_status->status = "A";
                $update_empl_att_status->save();

                $data->status = "Pending";
                $data->is_revoked = "1";
                $data->save();

                $start_date = Carbon::now()->subMonth()->format('Y-m-26');
                $end_date = Carbon::now()->startofMonth()->adddays('24')->format('Y-m-d');

                $process_sandwich_policy = $serviceVmtAttendanceReportsService->fetchSandwidchReportData($start_date, $end_date, $data->user_id);
            }

            if ($data->exists()) {
                $data->reviewer_id = $user_id;
                $data->reviewer_reviewed_date = Carbon::now()->format('Y-m-d H:i:s');
                $data->status = $status;
                $data->reviewer_comments = $status_text ?? '---';

                $data->save();
            } else {
                return $responseJSON = [
                    'status' => 'failure',
                    'message' => 'Record not found',
                    'mail_status' => '',
                    'data' => [],
                ];
            }



            //Send mail to Employee

            $mail_status = "";
            if (!empty($user_type) && $user_type == "Admin") {

                //Get employee details
                $employee_details = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                    ->where('users.id', $data->user_id)->first(['users.name', 'users.user_code', 'vmt_employee_office_details.officical_mail']);

                //dd($employee_details->officical_mail);


                $VmtClientMaster = VmtClientMaster::first();
                $image_view = url('/') . $VmtClientMaster->client_logo;
                $emp_avatar = json_decode(getEmployeeAvatarOrShortName($query_user->id));
                $when = carbon::now()->addSeconds(5);
                $isSent = \Mail::to($employee_details->officical_mail)->later(
                    $when,
                    new VmtAbsentMail_Regularization(
                        $employee_details->name,
                        $employee_details->user_code,
                        $emp_avatar,
                        $data->attendance_date,
                        $query_user->name,
                        $query_user->user_code,
                        request()->getSchemeAndHttpHost(),
                        $image_view,
                        $status_text,
                        $status,
                        "Admin"
                    )
                );

                if ($isSent) {
                    $mail_status = "Mail sent successfully";
                } else {
                    $mail_status = "There was one or more failures.";
                }
            } else {
                $employee_details = User::join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                    ->where('users.id', $data->user_id)->first(['users.name', 'users.user_code', 'vmt_employee_office_details.officical_mail']);

                //dd($employee_details->officical_mail);


                $VmtClientMaster = VmtClientMaster::first();
                $image_view = url('/') . $VmtClientMaster->client_logo;
                $emp_avatar = json_decode(getEmployeeAvatarOrShortName($query_user->id));
                $when = carbon::now()->addSeconds(5);
                $isSent = \Mail::to($employee_details->officical_mail)->later(
                    $when,
                    new VmtAbsentMail_Regularization(
                        $employee_details->name,
                        $employee_details->user_code,
                        $emp_avatar,
                        $data->attendance_date,
                        $query_user->name,
                        $query_user->user_code,
                        request()->getSchemeAndHttpHost(),
                        $image_view,
                        $status_text,
                        $status,
                        "manager"
                    )
                );

                if ($isSent) {
                    $mail_status = "Mail sent successfully";
                } else {
                    $mail_status = "There was one or more failures.";
                }
            }
            // // if ($status == 'Approved') {

            // //     $attendance_regularization_type = 'manager_approves_attendance_reg';
            // // } else if ($status == 'Rejected') {

            // //     $attendance_regularization_type = 'manager_rejects_attendance_reg';
            // // }

            // // $res_notification = $serviceVmtNotificationsService->send_attendance_regularization_FCMNotification(
            // //     notif_user_id: $data->user_id,
            // //     attendance_regularization_type: $attendance_regularization_type,
            // //     manager_user_code: $approver_user_code,
            // // );

            return $responseJSON = [
                'status' => 'success',
                'message' => 'Absent Regularization' . " $status " . 'successfully!',
                'mail_status' => $mail_status,
                'data' => [],
            ];
        } catch (TransportException $e) {

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Absent Regularization approval successful',
                    'mail_status' => 'failure',
                    'error' => $e->getMessage(),
                    'error_verbose' => $e->getTraceAsString()
                ]
            );
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error while doing absent regularization",
                'data' => $e->getMessage() . "  " . $e->getTraceAsString()
            ]);
        }
    }


    /*
         Get attendance status for the given date


     */
    public function fetchAttendanceStatus($user_code, $date)
    {
        $response = null;
        //Sub-query approach : Need to compare the speed with the below uncommented query
        // $query_web_mobile_response = VmtEmployeeAttendance::where('user_id',  function (Builder $query) use ($user_code) {
        //     $query->select('id')
        //         ->from('users')
        //         ->where('user_code',$user_code);
        // })->get();

        //Joins approach : Need to compare with above query
        $query_web_mobile_response = VmtEmployeeAttendance::join('users', 'users.id', '=', 'vmt_employee_attendance.user_id')
            ->join('vmt_work_shifts', 'vmt_work_shifts.id', '=', 'vmt_employee_attendance.vmt_employee_workshift_id')
            ->where('users.user_code', $user_code)
            ->where('vmt_employee_attendance.date', $date)
            ->first([
                'users.user_code as employee_code',
                'vmt_employee_attendance.date',

                'vmt_work_shifts.shift_name as shift_name',
                'vmt_work_shifts.shift_start_time as shift_start_time',
                'vmt_work_shifts.shift_end_time as shift_end_time',

                'vmt_employee_attendance.checkin_time as checkin_time',
                'vmt_employee_attendance.checkout_time as checkout_time',

                'vmt_employee_attendance.attendance_mode_checkin as attendance_mode_checkin',
                'vmt_employee_attendance.attendance_mode_checkout as attendance_mode_checkout',

            ]);

        $query_biometric_response = \DB::table('vmt_staff_attenndance_device')->leftjoin('users', 'users.user_code', '=', 'vmt_staff_attenndance_device.user_id')
            ->leftjoin('vmt_employee_workshifts', 'vmt_employee_workshifts.user_id', '=', 'users.id')
            ->leftjoin('vmt_work_shifts', 'vmt_work_shifts.id', '=', 'vmt_employee_workshifts.work_shift_id')
            ->where('users.user_code', $user_code)
            ->whereDate('vmt_staff_attenndance_device.date', $date)
            ->groupBy('vmt_staff_attenndance_device.date')
            ->first([
                'users.user_code as employee_code',
                'vmt_staff_attenndance_device.date',

                'vmt_work_shifts.shift_name as shift_name',
                'vmt_work_shifts.shift_start_time as shift_start_time',
                'vmt_work_shifts.shift_end_time as shift_end_time',

                'vmt_staff_attenndance_device.date as checkin_time',
                'vmt_staff_attenndance_device.date as checkout_time',

                'vmt_staff_attenndance_device.date as attendance_mode_checkin',
                'vmt_staff_attenndance_device.date as attendance_mode_checkout',
            ]);


        $bio_attendanceCheckIn = \DB::table('vmt_staff_attenndance_device')
            ->select('user_Id', \DB::raw('MIN(date) as check_in_time'))
            ->whereDate('date', $date)
            ->where('direction', 'in')
            ->where('user_Id', $user_code)
            ->first(['check_in_time']);


        $bio_attendanceCheckOut = \DB::table('vmt_staff_attenndance_device')
            ->select('user_Id', \DB::raw('MAX(date) as check_out_time'))
            ->whereDate('date', $date)
            ->where('direction', 'out')
            ->where('user_Id', $user_code)
            ->first(['check_out_time']);


        if (!empty($query_web_mobile_response->attendance_mode_checkin) && !empty($query_web_mobile_response->attendance_mode_checkout)) {

            $response = $query_web_mobile_response;
        } else if (!empty($bio_attendanceCheckIn->check_in_time) && !empty($bio_attendanceCheckOut->check_out_time)) {

            /*original  date data split into date and time in biometric and assign the time to checkin and checkout ,
                 then date to date and attedance mode.*/
            $query_biometric_response->date = $date;
            $query_biometric_response->checkin_time = date("H:i:s", strtotime($bio_attendanceCheckIn->check_in_time));
            $query_biometric_response->checkout_time = date("H:i:s", strtotime($bio_attendanceCheckOut->check_out_time));
            $query_biometric_response->attendance_mode_checkin = 'biometric';
            $query_biometric_response->attendance_mode_checkout = 'biometric';

            $response = $query_biometric_response;
        } else if (!empty($query_biometric_response) && (empty($bio_attendanceCheckIn->check_in_time) || empty($bio_attendanceCheckOut->check_out_time))) {


            if (empty($bio_attendanceCheckIn->check_in_time)) {

                $query_biometric_response->date = $date;
                $query_biometric_response->checkin_time = empty($query_web_mobile_response->check_in_time) ? null : date("H:i:s", strtotime($query_web_mobile_response->check_in_time));
                $query_biometric_response->attendance_mode_checkin = empty($query_web_mobile_response->attendance_mode_checkin) ? null : $query_web_mobile_response->attendance_mode_checkin;
                $query_biometric_response->checkout_time = date("H:i:s", strtotime($bio_attendanceCheckOut->check_out_time));
                $query_biometric_response->attendance_mode_checkin = 'biometric';
            } else if (empty($bio_attendanceCheckIn->check_out_time)) {

                $query_biometric_response->date = $date;
                $query_biometric_response->checkin_time = date("H:i:s", strtotime($bio_attendanceCheckIn->check_in_time));
                $query_biometric_response->attendance_mode_checkin = 'biometric';
                $query_biometric_response->checkout_time = empty($query_web_mobile_response->check_out_time) ? null : date("H:i:s", strtotime($query_web_mobile_response->check_out_time));
                $query_biometric_response->attendance_mode_checkout = empty($query_web_mobile_response->attendance_mode_checkout) ? null : $query_web_mobile_response->attendance_mode_checkout;
            }
            $response = $query_biometric_response;
        } else if (!empty($query_web_mobile_response) && (empty($query_web_mobile_response->attendance_mode_checkin) || empty($query_web_mobile_response->attendance_mode_checkout))) {


            if (empty($query_web_mobile_response->attendance_mode_checkin)) {

                $query_web_mobile_response['checkin_time'] = empty($bio_attendanceCheckIn->check_in_time) ? null : date("H:i:s", strtotime($bio_attendanceCheckIn->check_in_time));
                $query_web_mobile_response['attendance_mode_checkin'] = empty($bio_attendanceCheckIn->check_in_time) ? null : 'biometric';
            } else if (empty($query_web_mobile_response->attendance_mode_checkout)) {

                $query_web_mobile_response['checkout_time'] = empty($bio_attendanceCheckOut->check_out_time) ? null : date("H:i:s", strtotime($bio_attendanceCheckOut->check_out_time));
                $query_web_mobile_response['attendance_mode_checkout'] = empty($bio_attendanceCheckOut->check_out_time) ? null : 'biometric';
            }

            $response = $query_web_mobile_response;
        } else {

            $response = null;
        }

        return $response;
    }

    /*
         Get the last attendance date status of the given user_code.
         If checkout was not done, then checkout date will be NULL.

     */
    public function getLastAttendanceStatus($user_code)
    {

        //Web/mobile attendance
        try {
            $response = null;

            $query_web_mobile_response = VmtEmployeeAttendance::join('users', 'users.id', '=', 'vmt_employee_attendance.user_id')
                ->join('vmt_work_shifts', 'vmt_work_shifts.id', '=', 'vmt_employee_attendance.vmt_employee_workshift_id')
                ->where('users.user_code', $user_code)
                ->orderBy('vmt_employee_attendance.date', 'desc')
                ->first([
                    'users.user_code as employee_code',
                    'vmt_employee_attendance.date',
                    'vmt_work_shifts.shift_name as shift_name',
                    'vmt_work_shifts.shift_start_time as shift_start_time',
                    'vmt_work_shifts.shift_end_time as shift_end_time',
                    'vmt_employee_attendance.checkin_time as checkin_time',
                    'vmt_employee_attendance.checkout_time as checkout_time',
                    'vmt_employee_attendance.attendance_mode_checkin as attendance_mode_checkin',
                    'vmt_employee_attendance.attendance_mode_checkout as attendance_mode_checkout',
                ]);

            // Biometric
            $query_biometric_response = \DB::table('vmt_staff_attenndance_device')->leftjoin('users', 'users.user_code', '=', 'vmt_staff_attenndance_device.user_id')
                ->leftjoin('vmt_employee_workshifts', 'vmt_employee_workshifts.user_id', '=', 'users.id')
                ->leftjoin('vmt_work_shifts', 'vmt_work_shifts.id', '=', 'vmt_employee_workshifts.work_shift_id')
                ->where('users.user_code', $user_code)
                ->orderby('vmt_staff_attenndance_device.date', 'desc')
                ->first([
                    'users.user_code as employee_code',
                    'vmt_staff_attenndance_device.date',
                    'vmt_work_shifts.shift_name as shift_name',
                    'vmt_work_shifts.shift_start_time as shift_start_time',
                    'vmt_work_shifts.shift_end_time as shift_end_time',
                    'vmt_staff_attenndance_device.date as checkin_time',
                    'vmt_staff_attenndance_device.date as checkout_time',
                    'vmt_staff_attenndance_device.date as attendance_mode_checkin',
                    'vmt_staff_attenndance_device.date as attendance_mode_checkout',
                ]);

            // dd($query_biometric_response,$query_web_mobile_response);
            //get dates from emp_attedance and staff_attedance and store it in an array

            $boimetric_basic_attedance_date = array();
            $query_web_mobile_response_date = null;
            if (!empty($query_web_mobile_response)) {
                array_push($boimetric_basic_attedance_date, $query_web_mobile_response->date);
                $query_web_mobile_response_date = date("Y-m-d", strtotime($query_web_mobile_response->date));
            }

            $query_biometric_response_date = null;
            if (!empty($query_biometric_response)) {
                array_push($boimetric_basic_attedance_date, $query_biometric_response->date);
                $query_biometric_response_date = date("Y-m-d", strtotime($query_biometric_response->date));
            }


            //Compare which one is recent date
            $recent_attedance_data = null;
            if (!empty($query_biometric_response) || !empty($query_web_mobile_response)) {
                $max = max(array_map('strtotime', $boimetric_basic_attedance_date));
                $recent_attedance_data = date('Y-m-d', $max);
            }

            //get check-in and check-out date from staff_attedance

            //   $bio_attendanceCheckOut = \DB::table('vmt_staff_attenndance_device')
            //   ->select('user_Id', \DB::raw('MAX(date) as check_out_time'))
            //   ->whereDate('date', $recent_attedance_data)
            //   ->where('user_Id', $user_code)
            //   ->first(['check_out_time']);
            //   $biometric_attendanceCheckoutTime=date("H:i:s", strtotime($bio_attendanceCheckOut->check_out_time)) > strtotime('12:00:00') ;

            //   $bio_attendanceCheckIn = \DB::table('vmt_staff_attenndance_device')
            //   ->select('user_Id', \DB::raw('MIN(date) as check_in_time'))
            //   ->whereDate('date', $recent_attedance_data)
            //   ->where('user_Id',  $user_code)
            //   ->first(['check_in_time']);
            //   $biometric_attendanceCheckInTime= date("H:i:s", strtotime($bio_attendanceCheckIn->check_in_time)) < strtotime('12:00:00') ;

            $bio_attendanceCheckOut = \DB::table('vmt_staff_attenndance_device')
                ->select('user_Id', \DB::raw('MAX(date) as check_out_time'))
                ->whereDate('date', $recent_attedance_data)
                ->where('direction', 'out')
                ->where('user_Id', $user_code)
                ->first(['check_out_time']);


            $bio_attendanceCheckIn = \DB::table('vmt_staff_attenndance_device')
                ->select('user_Id', \DB::raw('MIN(date) as check_in_time'))
                ->whereDate('date', $recent_attedance_data)
                ->where('direction', 'in')
                ->where('user_Id', $user_code)
                ->first(['check_in_time']);

            //dd($bio_attendanceCheckIn,$bio_attendanceCheckOut);

            //check wheather employee mode of check-in and check-out is present or not
            if ((empty($query_biometric_response) && empty($query_web_mobile_response))) {

                $response = null;
            } //check employee mode of check-in and check-out in both employee attedance and staff attedance biometric
            else if ($query_web_mobile_response_date == $recent_attedance_data && $query_biometric_response_date == $recent_attedance_data) {
                //check which attendance_mode is empty in employee attadance table
                if (empty($query_web_mobile_response->attendance_mode_checkin) || empty($query_web_mobile_response->attendance_mode_checkout)) {
                    //if is it checkin then directly check on staff attedance table
                    if (empty($query_web_mobile_response->attendance_mode_checkin)) {

                        $query_web_mobile_response->checkin_time = empty($bio_attendanceCheckIn->check_in_time) ? null : date("H:i:s", strtotime($bio_attendanceCheckIn->check_in_time));
                        $query_web_mobile_response->attendance_mode_checkin = empty($bio_attendanceCheckIn->check_in_time) ? null : 'biometric';
                    } //if is it checkout then directly check on staff attedance table
                    else if (empty($query_web_mobile_response->attendance_mode_checkout)) {

                        $query_web_mobile_response->checkout_time = empty($bio_attendanceCheckOut->check_out_time) ? null : date("H:i:s", strtotime($bio_attendanceCheckOut->check_out_time));
                        $query_web_mobile_response->attendance_mode_checkout = empty($bio_attendanceCheckOut->check_out_time) ? null : 'biometric';
                    }
                    $response = $query_web_mobile_response;
                } else {

                    $response = $query_web_mobile_response;
                }
            } //check employee mode of check-in and check-out in  employee attedance
            else if ($query_web_mobile_response_date == $recent_attedance_data) {

                //if both attedance modes are present then retrun $query_web_mobile_response
                if (!empty($query_web_mobile_response->attendance_mode_checkin) && !empty($query_web_mobile_response->attendance_mode_checkout)) {

                    $response = $query_web_mobile_response;
                } //else check which attendance_mode is empty in staff attedance table
                else if (empty($query_web_mobile_response->attendance_mode_checkin) || empty($query_web_mobile_response->attendance_mode_checkout)) {

                    if (empty($query_web_mobile_response->attendance_mode_checkin)) {

                        $query_web_mobile_response->checkin_time = empty($bio_attendanceCheckIn->check_in_time) ? null : date("H:i:s", strtotime($bio_attendanceCheckIn->check_in_time));
                        $query_web_mobile_response->attendance_mode_checkin = empty($bio_attendanceCheckIn->check_in_time) ? null : 'biometric';
                    } else if (empty($query_web_mobile_response->attendance_mode_checkout)) {

                        $query_web_mobile_response->checkout_time = empty($bio_attendanceCheckOut->check_out_time) ? null : date("H:i:s", strtotime($bio_attendanceCheckOut->check_out_time));
                        $query_web_mobile_response->attendance_mode_checkout = empty($bio_attendanceCheckOut->check_out_time) ? null : 'biometric';
                    }

                    $response = $query_web_mobile_response;
                }
            } //check employee mode of check-in and check-out in staff attedance biometric
            //else if($query_biometric_response_date == $recent_attedance_data && $biometric_attendanceCheckInTime && $biometric_attendanceCheckoutTime ){
            else if ($query_biometric_response_date == $recent_attedance_data) {

                if (!empty($bio_attendanceCheckIn->check_in_time) && !empty($bio_attendanceCheckOut->check_out_time)) {
                    /*original  data split into date and time in biometric and assign the time to checkin and checkout ,
                 then date to Checkin checkout date */
                    $query_biometric_response->date = $recent_attedance_data;
                    $query_biometric_response->checkin_time = date("H:i:s", strtotime($bio_attendanceCheckIn->check_in_time));
                    $query_biometric_response->checkout_time = date("H:i:s", strtotime($bio_attendanceCheckOut->check_out_time));
                    $query_biometric_response->attendance_mode_checkin = 'biometric';
                    $query_biometric_response->attendance_mode_checkout = 'biometric';

                    $response = $query_biometric_response;
                } else if (empty($bio_attendanceCheckIn->check_in_time) || empty($bio_attendanceCheckOut->check_out_time)) {

                    if (empty($bio_attendanceCheckIn->check_in_time)) {

                        $query_biometric_response->date = $recent_attedance_data;
                        $query_biometric_response->checkin_time = empty($query_web_mobile_response->check_in_time) ? null : date("H:i:s", strtotime($query_web_mobile_response->check_in_time));
                        $query_biometric_response->attendance_mode_checkin = empty($query_web_mobile_response->attendance_mode_checkin) ? null : $query_web_mobile_response->attendance_mode_checkin;
                        $query_biometric_response->checkout_time = date("H:i:s", strtotime($bio_attendanceCheckOut->check_out_time));
                        $query_biometric_response->attendance_mode_checkout = 'biometric';
                    } else if (empty($bio_attendanceCheckOut->check_out_time)) {

                        $query_biometric_response->date = $recent_attedance_data;
                        $query_biometric_response->checkin_time = date("H:i:s", strtotime($bio_attendanceCheckIn->check_in_time));
                        $query_biometric_response->attendance_mode_checkin = 'biometric';
                        $query_biometric_response->checkout_time = empty($query_web_mobile_response->check_out_time) ? null : date("H:i:s", strtotime($query_web_mobile_response->check_out_time));
                        $query_biometric_response->attendance_mode_checkout = empty($query_web_mobile_response->attendance_mode_checkout) ? null : $query_web_mobile_response->attendance_mode_checkout;
                    }
                    $response = $query_biometric_response;
                }
            }

            return $response;
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'success',
                'message' => 'Error while getting latest attendance status',
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ]);
        }
    }



    public function performAttendanceCheckIn($user_code, $date, $checkin_time, $selfie_checkin, $work_mode, $attendance_mode_checkin, $checkin_lat_long, $checkin_full_address)
    {

        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
                "date" => $date,
                "checkin_time" => $checkin_time,
                "selfie_checkin" => $selfie_checkin,
                "work_mode" => $work_mode,
                "attendance_mode_checkin" => $attendance_mode_checkin,
                "checkin_lat_long" => $checkin_lat_long,
                "checkin_full_address" => $checkin_full_address,
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "date" => "required",
                "checkin_time" => "required",
                "selfie_checkin" => "nullable",
                "work_mode" => "required", //office, work
                "attendance_mode_checkin" => "required", //mobile, web
                "checkin_lat_long" => "nullable", //stores in lat , long
                "checkin_full_address" => "nullable",
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

            $query_user = User::where('user_code', $user_code)->first();
            $user_id = $query_user->id;

            /*
         1.get the work_shift_id for the particular user from VmtEmployeeWorkShifts.
         2,then check wheather the user have workshiftid or not.
         */

            //Check if user already checked-in
            $attendanceCheckin = VmtEmployeeAttendance::where('user_id', $user_id)->where("date", $date)->first();

            if ($attendanceCheckin) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Check-in already done',
                    'data' => ""
                ]);
            }

            $vmt_employee_workshift = VmtEmployeeWorkShifts::where('user_id', $user_id)->where('is_active', '1')->first();

            if (empty($vmt_employee_workshift->work_shift_id)) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'No shift has been assigned',
                    'data' => ""
                ]);
            }

            //If check-in not done already , then create new record
            $save_check_in_att_intermediate = $this->updateCheckInOutIntermediateTable($user_id, $date, $checkin_time, $work_mode, $attendance_mode_checkin, $vmt_employee_workshift->work_shift_id, 'check_in');
            $attendanceCheckin = new VmtEmployeeAttendance;
            $attendanceCheckin->date = $date;
            $attendanceCheckin->checkin_time = $checkin_time;
            $attendanceCheckin->user_id = $user_id;
            //$attendanceCheckin->shift_type    = $shift_type; Todo : Need to remove in table
            $attendanceCheckin->work_mode = $work_mode; //office, home
            $attendanceCheckin->checkin_comments = "";
            $attendanceCheckin->attendance_mode_checkin = $attendance_mode_checkin;
            $attendanceCheckin->vmt_employee_workshift_id = $vmt_employee_workshift->work_shift_id; //TODO : Need to fetch from 'vmt_employee_workshifts'
            $attendanceCheckin->checkin_lat_long = $checkin_lat_long ?? '';
            $attendanceCheckin->checkin_full_address = $checkin_full_address ?? '';
            $attendanceCheckin->save();
            // processing and storing base64 files in public/selfies folder
            if (!empty($selfie_checkin)) {

                $emp_selfiedir_path = public_path('employees/' . $user_code . '/selfies/');

                // dd($emp_document_path);
                if (!File::isDirectory($emp_selfiedir_path))
                    File::makeDirectory($emp_selfiedir_path, 0777, true, true);


                $selfieFileEncoded = $selfie_checkin;

                $fileName = $attendanceCheckin->id . '_checkin.png';

                \File::put($emp_selfiedir_path . $fileName, base64_decode($selfieFileEncoded));

                $attendanceCheckin->selfie_checkin = $fileName;
            }

            $attendanceCheckin->save();

            //Check whether check-in time is LC...

            $current_workshift_timings = Carbon::parse(VmtWorkShifts::find($vmt_employee_workshift->work_shift_id)->shift_start_time);
            $parsed_checkin_time = Carbon::parse($checkin_time);
            $isSent = "NA";

            //If its LC, then send mail
            if ($parsed_checkin_time->gt($current_workshift_timings)) {
                //Send notification mail
                $user_mail = VmtEmployeeOfficeDetails::where('user_id', $user_id)->first()->officical_mail;

                $VmtClientMaster = VmtClientMaster::first();
                $image_view = url('/') . $VmtClientMaster->client_logo;
                $emp_avatar = json_decode(newgetEmployeeAvatarOrShortName(auth::user()->id), true);

                // $isSent    = \Mail::to($user_mail)->send(new AttendanceCheckinCheckoutNotifyMail(
                //     $query_user->name,
                //     $query_user->user_code,
                //     Carbon::parse($date)->format('M jS, Y'),
                //     Carbon::parse($checkin_time)->format('h:i:s A'),
                //     $image_view,
                //     $emp_avatar,
                //     request()->getSchemeAndHttpHost(),
                //     "LC"
                // ));
            }


            if ($isSent) {
                $mail_status = "success";
            } else {
                $mail_status = "failure";
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Check-in success',
                'mail_status' => $mail_status ?? 'NA',
                'data' => ''
            ]);
        } catch (TransportException $e) {
            $response = [
                'status' => 'success',
                'message' => 'Check-in success.',
                'mail_status' => 'failure',
                'notification' => '',
                'error' => $e->getMessage(),
                'error_verbose' => $e->getline(),
            ];

            return $response;
        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => 'Error while check-in',
                'mail_status' => 'failure',
                'notification' => '',
                'error' => $e->getMessage(),
                'error_verbose' => $e->getTraceAsString()
            ];

            return $response;
        }
    }

    public function performAttendanceCheckOut($user_code, $existing_check_in_date, $checkout_time, $selfie_checkout, $work_mode, $attendance_mode_checkout, $checkout_lat_long, $checkout_full_address)
    {

        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
                "existing_check_in_date" => $existing_check_in_date,
                "checkout_time" => $checkout_time,
                "selfie_checkout" => $selfie_checkout,
                "work_mode" => $work_mode,
                "attendance_mode_checkout" => $attendance_mode_checkout,
                "checkout_lat_long" => $checkout_lat_long,
                "checkout_full_address" => $checkout_full_address,
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "existing_check_in_date" => "required",
                "checkout_time" => "required",
                "selfie_checkout" => "nullable",
                "work_mode" => "required", //office, work
                "attendance_mode_checkout" => "required", //mobile, web
                "checkout_lat_long" => "nullable", //stores in lat , long
                "checkout_full_address" => "nullable",

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

            $query_user = User::where('user_code', $user_code)->first();
            $user_id = $query_user->id;

            //Check if workshift assigned for user
            $vmt_employee_workshift = VmtEmployeeWorkShifts::where('user_id', $user_id)->where('is_active', '1')->first();

            if (empty($vmt_employee_workshift->work_shift_id)) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'No shift has been assigned',
                    'data' => ""
                ]);
            }

            //Check if user already checked-out
            $existing_att_details = VmtEmployeeAttendance::where('user_id', $user_id)->where("date", $existing_check_in_date)->first();

            //Check if user checked-in or not
            $bio_attendanceCheckIn = \DB::table('vmt_staff_attenndance_device')
                ->select('user_Id', \DB::raw('MIN(date) as check_in_time'))
                ->whereDate('date', $existing_check_in_date)
                ->where('direction', 'in')
                ->where('user_Id', $user_code)
                ->first(['check_in_time']);

            //Checkout date will be current date...
            $t_checkout_date = date("Y-m-d");

            //If check-in exists and checkout doesnt exist, then its normal checkout
            if (!empty($existing_att_details) && empty($existing_att_details->checkout_time)) {

                $save_check_out_att_intermediate = $this->updateCheckInOutIntermediateTable($user_id, $existing_check_in_date, $checkout_time, $work_mode, $attendance_mode_checkout, $vmt_employee_workshift->work_shift_id, 'check_out');

                //TODO : Need to return if check-out is already done

                //Update existing record
                $existing_att_details->checkout_time = $checkout_time;
                $existing_att_details->checkout_date = $t_checkout_date;
                $existing_att_details->checkout_comments = "";
                $existing_att_details->attendance_mode_checkout = $attendance_mode_checkout;
                $existing_att_details->checkout_lat_long = $checkout_lat_long ?? '';
                $existing_att_details->checkout_full_address = $checkout_full_address ?? '';
                $existing_att_details->save();
                // processing and storing base64 files in public/selfies folder
                if (!empty($selfie_checkout)) {

                    $emp_selfiedir_path = public_path('employees/' . $user_code . '/selfies/');

                    // dd($emp_document_path);
                    if (!File::isDirectory($emp_selfiedir_path))
                        File::makeDirectory($emp_selfiedir_path, 0777, true, true);


                    $selfieFileEncoded = $selfie_checkout;

                    $fileName = $existing_att_details->id . '_checkout.png';

                    \File::put($emp_selfiedir_path . $fileName, base64_decode($selfieFileEncoded));

                    $existing_att_details->selfie_checkout = $fileName;
                }

                $existing_att_details->save();
            } else // If existing record not in emp-att table but available in Biometric table, then add new entry in emp-att table
                if (empty($existing_att_details) && !empty($bio_attendanceCheckIn->check_in_time)) {

                    $save_check_out_att_intermediate = $this->updateCheckInOutIntermediateTable($user_id, $existing_check_in_date, $checkout_time, $work_mode, $attendance_mode_checkout, $vmt_employee_workshift->work_shift_id, 'check_out');

                    $existing_att_details = new VmtEmployeeAttendance;
                    $existing_att_details->date = $existing_check_in_date;
                    $existing_att_details->checkout_time = $checkout_time;
                    $existing_att_details->user_id = $user_id;
                    $existing_att_details->work_mode = $work_mode;
                    $existing_att_details->checkout_date = $t_checkout_date;
                    $existing_att_details->checkout_comments = "";
                    $existing_att_details->attendance_mode_checkout = $attendance_mode_checkout;
                    $existing_att_details->vmt_employee_workshift_id = $vmt_employee_workshift->work_shift_id;
                    $existing_att_details->checkout_lat_long = $checkout_lat_long ?? '';
                    $existing_att_details->checkout_full_address = $checkout_full_address ?? '';
                    $existing_att_details->save();

                    // processing and storing base64 files in public/selfies folder
                    if (!empty('selfie_checkout')) {

                        $emp_selfiedir_path = public_path('employees/' . $user_code . '/selfies/');

                        // dd($emp_document_path);
                        if (!File::isDirectory($emp_selfiedir_path))
                            File::makeDirectory($emp_selfiedir_path, 0777, true, true);


                        $selfieFileEncoded = $selfie_checkout;

                        $fileName = $existing_att_details->id . '_checkout.png';

                        \File::put($emp_selfiedir_path . $fileName, base64_decode($selfieFileEncoded));

                        $existing_att_details->selfie_checkout = $fileName;
                    }

                    $existing_att_details->save();
                } else // If record doesnt exist in emp_table and biometric table, then its error
                {
                    return response()->json([
                        'status' => 'failure',
                        'message' => 'Unable to check-out since Check-in is not done for the given date or Check-out is already done',
                        'data' => ""
                    ]);
                }

            //Check whether check-in time is EG...

            $current_workshift_timings = Carbon::parse(VmtWorkShifts::find($vmt_employee_workshift->work_shift_id)->shift_end_time);
            $parsed_checkout_time = Carbon::parse($checkout_time);
            $isSent = "NA";

            //If its EG, then send mail
            if ($parsed_checkout_time->lt($current_workshift_timings)) {
                //Send notification mail
                $user_mail = VmtEmployeeOfficeDetails::where('user_id', $user_id)->first()->officical_mail;

                $VmtClientMaster = VmtClientMaster::first();
                $image_view = url('/') . $VmtClientMaster->client_logo;
                $emp_avatar = json_decode(newgetEmployeeAvatarOrShortName(auth::user()->id), true);

                // $isSent    = \Mail::to($user_mail)->send(new AttendanceCheckinCheckoutNotifyMail(
                //     $query_user->name,
                //     $query_user->user_code,
                //     Carbon::parse($t_checkout_date)->format('M jS, Y'),
                //     Carbon::parse($checkout_time)->format('h:i:s A'),
                //     $image_view,
                //     $emp_avatar,
                //     request()->getSchemeAndHttpHost(),
                //     "EG"
                // ));
            }

            if ($isSent) {
                $mail_status = "success";
            } else {
                $mail_status = "failure";
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Check-out success for the check-in date : ' . $existing_check_in_date,
                'data' => '',
                'mail_status' => $mail_status ?? 'NA'
            ]);
        } catch (TransportException $e) {
            $response = [
                'status' => 'success',
                'message' => 'Check-out success.',
                'mail_status' => 'failure',
                'notification' => '',
                'error' => $e->getMessage(),
                'error_verbose' => $e->getline(),
            ];

            return $response;
        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => 'Error while check-out',
                'mail_status' => 'failure',
                'notification' => '',
                'error' => $e->getMessage(),
                'error_verbose' => $e->getTraceAsString()
            ];

            return $response;
        }
    }

    public function updateCheckInOutIntermediateTable($user_id, $date, $time, $work_mode, $attendance_mode_check_InOut, $work_shift_id, $type)
    {
        try {


            if ($type == 'check_in') {

                $save_check_in_att_intermediate = VmtEmpAttIntrTable::where('user_id', $user_id)->where('date', $date)->first();

                if (!empty($save_check_in_att_intermediate)) {

                    if (empty($save_check_in_att_intermediate['checkin_time'])) {

                        $save_check_in_att_intermediate->vmt_employee_workshift_id = $work_shift_id;
                        $save_check_in_att_intermediate->date = $date;
                        $save_check_in_att_intermediate->checkin_time = $time;
                        $save_check_in_att_intermediate->attendance_mode_checkin = $attendance_mode_check_InOut;
                        $save_check_in_att_intermediate->checkin_date = $date;
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
                    $save_check_in_att_intermediate->user_id = $user_id;
                    $save_check_in_att_intermediate->vmt_employee_workshift_id = $work_shift_id;
                    $save_check_in_att_intermediate->date = $date;
                    $save_check_in_att_intermediate->checkin_time = $time;
                    $save_check_in_att_intermediate->attendance_mode_checkin = $attendance_mode_check_InOut;
                    $save_check_in_att_intermediate->checkin_date = $date;
                    $save_check_in_att_intermediate->save();
                }

            } elseif ($type == "check_out") {


                $save_check_out_att_intermediate = VmtEmpAttIntrTable::where('user_id', $user_id)->where('date', $date)->first();


                if (!empty($save_check_out_att_intermediate)) {

                    $save_check_out_att_intermediate->vmt_employee_workshift_id = $work_shift_id;
                    $save_check_out_att_intermediate->date = $date;
                    $save_check_out_att_intermediate->checkout_time = $time;
                    $save_check_out_att_intermediate->attendance_mode_checkout = $attendance_mode_check_InOut;
                    $save_check_out_att_intermediate->checkout_date = $date;
                    $save_check_out_att_intermediate->save();

                }

            }

            return 'success';


        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error while check_in',
                'error' => $e->getMessage(),
                'error_verbose' => $e->getTraceAsString()
            ]);

        }

    }

    public function getEmployeeWorkShiftTimings($user_code)
    {
        $validator = Validator::make(
            $data = [
                "user_code" => $user_code
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

            //fetch the data
            $response = VmtEmployeeWorkShifts::join('users', 'users.id', '=', 'vmt_employee_workshifts.user_id')
                ->join('vmt_work_shifts', 'vmt_work_shifts.id', '=', 'vmt_employee_workshifts.work_shift_id')
                ->where('users.id', $user_id)
                ->get(['vmt_work_shifts.shift_name', 'vmt_work_shifts.shift_start_time', 'vmt_work_shifts.shift_end_time'])
                ->first();


            return response()->json([
                'status' => 'success',
                'message' => '',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ getEmployeeWorkShiftTimings() ] ",
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ]);
        }
    }

    /*
         Get the Leave information for the selected leave record_id.
         Used in Leave module ...

     */
    public function getLeaveInformation($record_id)
    {

        $validator = Validator::make(
            $data = [
                "record_id" => $record_id,
            ],
            $rules = [
                'record_id' => 'required|exists:vmt_employee_leaves,id',
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
            $leave_details = VmtEmployeeLeaves::find($record_id);

            $leave_details['user_name'] = User::find($leave_details->user_id)->name;
            $leave_details['leave_type'] = VmtLeaves::find($leave_details->leave_type_id)->leave_type;
            // $leave_details['reviewer_name'] = User::find($leave_details->reviewer_user_id)->name;
            $leave_details['approver_name'] = User::find($leave_details->reviewer_user_id)->name;
            $leave_details['approver_designation'] = VmtEmployeeOfficeDetails::where('user_id', $leave_details->user_id)->first()->designation;

            if (!empty($leave_details->notifications_users_id)) {
                $leave_details['notification_userName'] = User::find($leave_details->notifications_users_id)->name;
                $leave_details['notification_designation'] = VmtEmployeeOfficeDetails::where('user_id', $leave_details->user_id)->first()->designation;
            } else
                $leave_details['notification_userName'] = "";

            $leave_details['avatar'] = getEmployeeAvatarOrShortName($leave_details->user_id);

            return response()->json([
                "status" => "success",
                "message" => "",
                "data" => $leave_details
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "",
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ]);
        }
    }

    public function getEmployeeLeaveDetails($user_code, $filter_month, $filter_year, $filter_leave_status)
    {

        $validator = Validator::make(
            $data = [
                "user_code" => $user_code,
                "filter_month" => $filter_month,
                "filter_year" => $filter_year,
                "filter_leave_status" => $filter_leave_status,
            ],
            $rules = [
                'user_code' => 'required|exists:users,user_code',
                'filter_month' => 'required',
                'filter_year' => 'required',
                'filter_leave_status' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $valid_status_data = array("Approved", "Rejected", "Pending", "Withdrawn");

                        $diff = array_diff($value, $valid_status_data);

                        if (count($diff) != 0)
                            $fail('The ' . $attribute . ' has invalid status types.');
                    },
                ],
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'in' => 'Field <b>:attribute</b> should have the following values : :values .',
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

            //fetch the data
            $query_employees_leaves = VmtEmployeeLeaves::join('users', 'users.id', '=', 'vmt_employee_leaves.user_id')
                ->join('vmt_leaves', 'vmt_leaves.id', '=', 'vmt_employee_leaves.leave_type_id')
                ->where('users.id', $user_id)
                ->whereYear('start_date', $filter_year)
                ->whereMonth('start_date', $filter_month)
                ->whereIn('status', $filter_leave_status)
                ->get([
                    "vmt_employee_leaves.id",
                    "vmt_employee_leaves.leaverequest_date",
                    "vmt_employee_leaves.start_date",
                    "vmt_employee_leaves.end_date",
                    "vmt_employee_leaves.total_leave_datetime",
                    "vmt_employee_leaves.leave_reason",
                    "vmt_employee_leaves.reviewer_user_id",
                    "vmt_employee_leaves.reviewed_date",
                    "vmt_employee_leaves.reviewer_comments",
                    "vmt_employee_leaves.status",
                    "vmt_employee_leaves.is_revoked",
                    "name",
                    "user_code",
                    "leave_type",
                ]);
            //  dd($query_employees_leaves->toArray());

            $query_employees_leaves = $query_employees_leaves->toArray();

            for ($i = 0; $i < count($query_employees_leaves); $i++) {

                $query_reviewer = User::find($query_employees_leaves[$i]["reviewer_user_id"]);
                $reviewer_name = $query_reviewer->name;
                $reviewer_usercode = $query_reviewer->user_code;

                $reviewer_designation = VmtEmployeeOfficeDetails::where('user_id', $query_employees_leaves[$i]["reviewer_user_id"])->first();
                if (!empty($reviewer_designation))
                    $reviewer_designation = $reviewer_designation->designation;
                else
                    $reviewer_designation = "";
                $query_employees_leaves[$i]["reviewer_name"] = $reviewer_name;
                $query_employees_leaves[$i]["reviewer_usercode"] = $reviewer_usercode;
                $query_employees_leaves[$i]["reviewer_designation"] = $reviewer_designation;
                $query_employees_leaves[$i]["reviewer_short_name"] = getUserShortName($query_employees_leaves[$i]["reviewer_user_id"]);
                $query_employees_leaves[$i]["user_short_name"] = getUserShortName($user_id);

                //If user_code is the currently loggedin user AND if leave status is PENDING,  then show WITHDRAW button
                //if($user_code == auth()->user()->user_code && $query_employees_leaves[$i]["status"] == "Pending")
                if ($query_employees_leaves[$i]["status"] == "Pending") //We dont have to check auth()->user()->user_code since this is returned for current user only.
                {
                    //Show the Withdraw button in ui
                    $query_employees_leaves[$i]["can_withdraw_leave"] = true;
                } else {
                    //Dont show the Withdraw button in ui
                    $query_employees_leaves[$i]["can_withdraw_leave"] = false;
                }
            }


            return response()->json([
                'status' => 'success',
                'message' => '',
                'data' => $query_employees_leaves
            ]);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ getEmployeeLeaveDetails() ] " . $e->getMessage(),
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ]);
        }
    }

    public function getTeamEmployeesLeaveDetails($manager_code, $filter_month, $filter_year, $filter_leave_status)
    {

        $validator = Validator::make(
            $data = [
                "manager_code" => $manager_code,
                "filter_month" => $filter_month,
                "filter_year" => $filter_year,
                "filter_leave_status" => $filter_leave_status,
            ],
            $rules = [

                'manager_code' => 'required',
                'filter_month' => 'required',
                'filter_year' => 'required',
                'filter_leave_status' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $valid_status_data = array("Approved", "Rejected", "Pending", "Withdrawn");

                        $diff = array_diff($value, $valid_status_data);

                        if (count($diff) != 0)
                            $fail('The ' . $attribute . ' has invalid status types.');
                    },
                ],
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'in' => 'Field <b>:attribute</b> should have the following values : :values .',
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        try {

            $map_allEmployees = User::all(['id', 'name', 'user_code'])->keyBy('id');
            $map_leaveTypes = VmtLeaves::all(['id', 'leave_type'])->keyBy('id');

            //Get the list of employees for the given Manager
            $team_employees_ids = VmtEmployeeOfficeDetails::where('l1_manager_code', $manager_code)->get('user_id');
            $team_employee_user_code = User::whereIn('id', $team_employees_ids)->get('user_code');
            //use wherein and fetch the relevant records
            $employeeLeaves_team = VmtEmployeeLeaves::whereIn('user_id', $team_employees_ids)
                ->whereMonth('start_date', '=', $filter_month)
                ->whereYear('start_date', '=', $filter_year)
                ->whereIn('status', $filter_leave_status)
                ->get();


            //dd($map_allEmployees[1]["name"]);
            foreach ($employeeLeaves_team as $singleItem) {

                if (array_key_exists($singleItem->user_id, $map_allEmployees->toArray())) {
                    $singleItem->employee_name = $map_allEmployees[$singleItem->user_id]["name"];
                    $singleItem->user_code = $map_allEmployees[$singleItem->user_id]["user_code"];
                    $singleItem->employee_avatar = getEmployeeAvatarOrShortName($singleItem->user_id);
                }

                if (array_key_exists($singleItem->reviewer_user_id, $map_allEmployees->toArray())) {

                    $singleItem->reviewer_name = $map_allEmployees[$singleItem->reviewer_user_id]["name"];
                    $singleItem->reviewer_avatar = getEmployeeAvatarOrShortName($singleItem->reviewer_user_id);
                }

                //Map leave types
                $singleItem->leave_type = $map_leaveTypes[$singleItem->leave_type_id]["leave_type"];


                //If leave status is PENDING,  then show WITHDRAW button
                if ($singleItem->status != "Pending") {
                    //Show the Revoke button in ui
                    $singleItem->can_revoke_leave = true;
                } else {
                    //Dont show the Revoke button in ui
                    $singleItem->can_revoke_leave = false;
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => '',
                'data' => $employeeLeaves_team
            ]);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ getTeamEmployeesLeaveDetails() ] " . $e->getMessage(),
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ]);
        }
    }

    public function getAllEmployeesLeaveDetails($filter_month, $filter_year, $filter_leave_status, $client_id)
    {

        /*
        $client_id = null;
        if (!empty(session('client_id'))) {
            if (session('client_id') == 1) {
                $client_id = VmtClientMaster::pluck('id');
            } else {
                $client_id = [session('client_id')];
            }$filter_month, $filter_year, $filter_leave_status, $client_code
        } else {
            $client_id = [auth()->user()->client_id];
        }
        */

        $validator = Validator::make(
            $data = [
                "filter_month" => $filter_month,
                "filter_year" => $filter_year,
                "filter_leave_status" => $filter_leave_status,
                "client_id" => $client_id,
            ],
            $rules = [
                'filter_month' => 'required',
                'filter_year' => 'required',
                'filter_leave_status' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $valid_status_data = array("Approved", "Rejected", "Pending", "Withdrawn");

                        $diff = array_diff($value, $valid_status_data);

                        if (count($diff) != 0)
                            $fail('The ' . $attribute . ' has invalid status types.');
                    },
                ],
                'client_id' => 'required|exists:vmt_client_master,id'
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'in' => 'Field <b>:attribute</b> should have the following values : :values .',
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try {

            //$client_id = VmtClientMaster::where('client_code', $client_id)->first()->id;
            $query_employees_leaves = VmtEmployeeLeaves::join('users', 'users.id', '=', 'vmt_employee_leaves.user_id')
                ->leftjoin('vmt_leaves', 'vmt_leaves.id', '=', 'vmt_employee_leaves.leave_type_id')
                ->whereYear('start_date', $filter_year)
                ->whereMonth('start_date', $filter_month)
                ->whereIn('status', $filter_leave_status)
                ->where('users.client_id', $client_id)
                ->get([
                    "vmt_employee_leaves.id",
                    "vmt_employee_leaves.user_id",
                    "vmt_employee_leaves.leaverequest_date",
                    "vmt_employee_leaves.start_date",
                    "vmt_employee_leaves.end_date",
                    "vmt_employee_leaves.total_leave_datetime",
                    "vmt_employee_leaves.leave_reason",
                    "vmt_employee_leaves.reviewer_user_id",
                    "vmt_employee_leaves.reviewed_date",
                    "vmt_employee_leaves.reviewer_comments",
                    "vmt_employee_leaves.status",
                    "vmt_employee_leaves.is_revoked",
                    "name as employee_name",
                    "user_code",
                    "leave_type",
                ]);
            // dd($query_employees_leaves->toArray());
            $query_employees_leaves = $query_employees_leaves->toArray();

            for ($i = 0; $i < count($query_employees_leaves); $i++) {

                $manager_name = User::find($query_employees_leaves[$i]["reviewer_user_id"])->name;
                $query_employees_leaves[$i]["manager_name"] = $manager_name;
                $query_employees_leaves[$i]["reviewer_short_name"] = getUserShortName($query_employees_leaves[$i]["reviewer_user_id"]);
                $query_employees_leaves[$i]["user_short_name"] = getUserShortName($query_employees_leaves[$i]["user_id"]);
                $query_employees_leaves[$i]["employee_avatar"] = newgetEmployeeAvatarOrShortName($query_employees_leaves[$i]["user_id"]);
            }

            return response()->json([
                'status' => 'success',
                'message' => '',
                'data' => $query_employees_leaves
            ]);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ getAllEmployeesLeaveDetails() ] ",
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ]);
        }
    }



    public function leavetypeAndBalanceDetails($user_id, $start_date, $end_date, $month, $year)
    {
        $leave_details = array();
        $single_user_leave_details = array();
        $accrued_leave_types = VmtLeaves::get();
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
                if ($single_leave_types->is_accrued != 1) {
                    $current_month_availed_leaves = VmtEmployeeLeaves::where('user_id', $user_id)
                        //->whereYear('start_date', $year)
                        //->whereMonth('start_date', $month)
                        ->whereBetween('start_date', [$start_date, $end_date])
                        ->where('leave_type_id', $single_leave_types->id)
                        ->whereIn('status', array('Approved', 'Pending'))
                        ->sum('total_leave_datetime');
                    $till_last_month_availed_leaves = VmtEmployeeLeaves::where('user_id', $user_id)
                        ->whereBetween('start_date', [$start_date, Carbon::parse($end_date)->subMonth()])
                        ->where('leave_type_id', $single_leave_types->id)
                        ->whereIn('status', array('Approved', 'Pending'))
                        ->sum('total_leave_datetime');
                }

                $current_month_availed_leaves = VmtEmployeeLeaves::where('user_id', $user_id)
                    // ->whereBetween('start_date', [$start_date, $end_date])
                    ->whereYear('start_date', $year)
                    ->whereMonth('start_date', $month)
                    ->where('leave_type_id', $single_leave_types->id)
                    ->whereIn('status', array('Approved', 'Pending'))
                    ->sum('total_leave_datetime');
                $till_last_month_availed_leaves = VmtEmployeeLeaves::where('user_id', $user_id)
                    ->whereBetween('start_date', [Carbon::parse($start_date)->startOfDay(), Carbon::parse($end_date)->subMonth()->endOfDay()])
                    ->where('leave_type_id', $single_leave_types->id)
                    ->whereIn('status', array('Approved', 'Pending'))
                    ->sum('total_leave_datetime');
                if ($single_leave_types->is_carry_forward != 1) {

                    if ($single_leave_types->is_accrued == 1) {
                        $total_accrued = VmtEmployeesLeavesAccrued::where('user_id', $user_id)
                            ->whereBetween('date', [$start_date, $end_date])
                            ->where('leave_type_id', $single_leave_types->id)
                            ->sum('accrued_leave_count');
                        // dd($single_leave_types->leave_type);

                    } else {

                        if ($single_leave_types->leave_type == 'Compensatory Off') {
                            $total_accrued = count($this->fetchUnusedCompensatoryOffDays($user_id));
                        } else {
                            $total_accrued = $single_leave_types->days_annual;
                        }
                    }
                } else if ($single_leave_types->is_carry_forward == 1) {
                    $selected_time_period_id = VmtOrgTimePeriod::whereBetween('start_date', [$start_date, $end_date])->first()->id;
                    if (VmtOrgTimePeriod::orderBy('id', 'ASC')->first()->id != $selected_time_period_id) {
                        $start_time_for_accrued_leave = VmtOrgTimePeriod::orderBy('id', 'ASC')->first()->start_date;
                    } else {
                        $start_time_for_accrued_leave = $start_date;
                    }
                    $total_accrued = VmtEmployeesLeavesAccrued::where('user_id', $user_id)
                        ->whereBetween('date', [$start_time_for_accrued_leave, $end_date])
                        ->where('leave_type_id', $single_leave_types->id)
                        ->sum('accrued_leave_count');
                }

                $single_user_leave_details['leave_type'] = $single_leave_types->leave_type;
                $single_user_leave_details['opening_balance'] = $total_accrued - $till_last_month_availed_leaves;
                if ($single_leave_types->leave_type == 'Compensatory Off')
                    $single_user_leave_details['opening_balance'] = 0; //temp Fix for now
                $single_user_leave_details['availed'] = $current_month_availed_leaves;
                $single_user_leave_details['closing_balance'] = $single_user_leave_details['opening_balance'] - $current_month_availed_leaves;
            } else {
                $current_month_availed_leaves = VmtEmployeeLeaves::where('user_id', $user_id)
                    //->whereBetween('start_date', [$start_date, Carbon::parse($end_date)->subMonth()])
                    ->whereYear('start_date', $year)
                    ->whereMonth('start_date', $month)
                    ->where('leave_type_id', $single_leave_types->id)
                    ->whereIn('status', array('Approved', 'Pending'))
                    ->sum('total_leave_datetime');
                $single_user_leave_details['leave_type'] = $single_leave_types->leave_type;
                $single_user_leave_details['opening_balance'] = 0;
                $single_user_leave_details['availed'] = $current_month_availed_leaves;
                $single_user_leave_details['closing_balance'] = 0;
            }
            array_push($leave_details, $single_user_leave_details);
            unset($single_user_leave_details);
        }
        return $leave_details;
    }
    /*

         Get the leave details based on the employee roles.


     */
    public function getLeaveRequestDetailsBasedOnCurrentRole()
    {
        $client_id = null;

        if (session('client_id') == 1) {
            $client_id = VmtClientMaster::pluck('id');
        } else {
            $client_id = [session('client_id')];
        }

        $map_allEmployees = User::where('active', '1')->whereIn('client_id', $client_id)->get(['id', 'name'])->keyBy('id');

        $map_leaveTypes = VmtLeaves::all(['id', 'leave_type'])->keyBy('id');

        $time_periods_of_year_query = VmtOrgTimePeriod::where('status', 1)->first();
        $start_date = $time_periods_of_year_query->start_date;

        $end_date = $time_periods_of_year_query->end_date;

        //Get all the employee's leave details
        if (Str::contains(currentLoggedInUserRole(), ['Super Admin', 'Admin', 'HR'])) {

            $employeeLeaves_Org = VmtEmployeeLeaves::whereIn('user_id', array_keys($map_allEmployees->toarray()))->get();

            foreach ($employeeLeaves_Org as $singleItem) {

                //Map emp names
                if (array_key_exists($singleItem->user_id, $map_allEmployees->toArray())) {

                    $singleItem->employee_name = $map_allEmployees[$singleItem->user_id]["name"];
                    $singleItem->employee_avatar = newgetEmployeeAvatarOrShortName($singleItem->user_id);
                    $singleItem->emp_user_code = User::where('id', $singleItem->user_id)->first()->user_code;
                }

                //Map reviewer names
                if (array_key_exists($singleItem->reviewer_user_id, $map_allEmployees->toArray())) {
                    $singleItem->reviewer_name = $map_allEmployees[$singleItem->reviewer_user_id]["name"];
                    $singleItem->reviewer_avatar = newgetEmployeeAvatarOrShortName($singleItem->reviewer_user_id);
                    $singleItem->reviewer_user_code = User::where('id', $singleItem->reviewer_user_id)->first()->user_code;
                }

                //Map leave types

                $singleItem->leave_type = $map_leaveTypes[$singleItem->leave_type_id]["leave_type"];
            }

            $leave_details = $employeeLeaves_Org;
        } else {
            //Get the manager's employees leave details
            if (Str::contains(currentLoggedInUserRole(), ['Manager'])) {
                //Get the list of employees for the given Manager
                $team_employees_ids = VmtEmployeeOfficeDetails::where('l1_manager_code', auth::user()->user_code)->get('user_id');

                //use wherein and fetch the relevant records
                $employeeLeaves_team = VmtEmployeeLeaves::whereIn('user_id', $team_employees_ids)->get();


                //dd($map_allEmployees[1]["name"]);
                foreach ($employeeLeaves_team as $singleItem) {

                    if (array_key_exists($singleItem->user_id, $map_allEmployees->toArray())) {
                        $singleItem->employee_name = $map_allEmployees[$singleItem->user_id]["name"];
                        $singleItem->employee_avatar = newgetEmployeeAvatarOrShortName($singleItem->user_id);
                        $singleItem->emp_user_code = User::where('id', $singleItem->user_id)->first()->user_code;
                    }

                    if (array_key_exists($singleItem->reviewer_user_id, $map_allEmployees->toArray())) {

                        $singleItem->reviewer_name = $map_allEmployees[$singleItem->reviewer_user_id]["name"];
                        $singleItem->reviewer_avatar = newgetEmployeeAvatarOrShortName($singleItem->reviewer_user_id);
                        $singleItem->reviewer_user_code = User::where('id', $singleItem->reviewer_user_id)->first()->user_code;
                    }

                    //Map leave types
                    $singleItem->leave_type = $map_leaveTypes[$singleItem->leave_type_id]["leave_type"];
                }


                //dd($employeeLeaves_team);
                $leave_details = $employeeLeaves_team;
            } else {
                ///Get the current employee's leave details
                if (Str::contains(currentLoggedInUserRole(), ['Employee'])) {

                    $leave_details = VmtEmployeeLeaves::where('user_id', auth::user()->id)
                        ->whereBetween('start_date', [$start_date, $end_date])->get();
                }
            }
        }
        return $leave_details;
    }

    public function fetchOrgLeaveBalance($start_date, $end_date, $month, $year)
    {

        $client_id = null;

        if (session('client_id') == 1) {
            $client_id = VmtClientMaster::pluck('id');
        } else {
            $client_id = [session('client_id')];
        }
        $response = array();
        $all_active_user = User::leftJoin('vmt_employee_details', 'users.id', '=', 'vmt_employee_details.userid')->leftJoin('vmt_employee_office_details', 'users.id', '=', 'vmt_employee_office_details.user_id')
            ->where('active', 1)->whereIn('users.client_id', $client_id)->where('is_ssa', 0)->get(['users.id', 'users.user_code', 'users.name', 'vmt_employee_details.location', 'vmt_employee_office_details.department_id']);
        // dd( $all_active_user);
        try {
            foreach ($all_active_user as $single_user) {
                $total_leave_balance = 0;
                $total_opening_balance = 0;
                $total_avalied = 0;
                $overall_leave_balance = $this->calculateEmployeeLeaveBalance($single_user->id, $start_date, $end_date);
                //dd($overall_leave_balance);
                $leavetypeAndBalanceDetails = $this->leavetypeAndBalanceDetails($single_user->id, $start_date, $end_date, $month, $year);
                // dd($leavetypeAndBalanceDetails);
                $each_user['user_code'] = $single_user->user_code;
                $each_user['name'] = $single_user->name;
                $each_user['employee_avatar'] = newgetEmployeeAvatarOrShortName($single_user->id);
                $each_user['location'] = $single_user->location;
                if ($single_user->department_id != null) {

                    $each_user['department'] = Department::where('id', $single_user->department_id);
                    if ($each_user['department']->exists()) {
                        $each_user['department'] = $each_user['department']->first()->name;
                    }
                } else {
                    $each_user['department'] = $single_user->department_id;
                }

                foreach ($overall_leave_balance as $single_leave_balance) {
                    $total_leave_balance = $total_leave_balance + $single_leave_balance['leave_balance'];
                }
                foreach ($leavetypeAndBalanceDetails as $single_leave_balance_details) {
                    $total_opening_balance = $total_opening_balance + $single_leave_balance_details['opening_balance'];
                    $total_avalied = $total_avalied + $single_leave_balance_details['availed'];
                }
                $each_user['total_leave_balance'] = $total_leave_balance;
                $each_user['total_opening_balance'] = $total_opening_balance;
                $each_user['total_avalied_balance'] = $total_avalied;
                $each_user['leave_balance_details'] = $leavetypeAndBalanceDetails;
                //  dd( $each_user);
                array_push($response, $each_user);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => $e->getMessage(),
                'data' => $e->getTraceAsString(),
            ]);
        }
        return $response;
    }

    public function teamLeaveBalance($start_date, $end_date, $month, $year)
    {
        $manager_user_code = User::where('id', auth()->user()->id)->first()->user_code;
        $response = array();
        $all_active_user = User::leftJoin('vmt_employee_details', 'users.id', '=', 'vmt_employee_details.userid')->leftJoin('vmt_employee_office_details', 'users.id', '=', 'vmt_employee_office_details.user_id')
            ->where('active', 1)->where('is_ssa', 0)
            ->where('vmt_employee_office_details.l1_manager_code', $manager_user_code)->get(['users.id', 'users.user_code', 'users.name', 'vmt_employee_details.location', 'vmt_employee_office_details.department_id']);
        // dd($all_active_user->all());
        foreach ($all_active_user as $single_user) {
            $total_leave_balance = 0;
            $total_opening_balance = 0;
            $total_avalied = 0;
            $overall_leave_balance = $this->calculateEmployeeLeaveBalance($single_user->id, $start_date, $end_date);
            $leavetypeAndBalanceDetails = $this->leavetypeAndBalanceDetails($single_user->id, $start_date, $end_date, $month, $year);

            $each_user['user_code'] = $single_user->user_code;
            $each_user['name'] = $single_user->name;
            $each_user['employee_avatar'] = newgetEmployeeAvatarOrShortName($single_user->id);
            $each_user['location'] = $single_user->location;
            if ($single_user->department_id == null) {
                $each_user['department'] = $single_user->department_id;
            } else {
                if (Department::where('id', $single_user->department_id)->exists()) {
                    $each_user['department'] = Department::where('id', $single_user->department_id)->first()->name;
                } else {
                    $each_user['department'] = '';
                }
            }

            foreach ($overall_leave_balance as $single_leave_balance) {
                $total_leave_balance = $total_leave_balance + $single_leave_balance['leave_balance'];
            }
            foreach ($leavetypeAndBalanceDetails as $single_leave_balance_details) {
                $total_opening_balance = $total_opening_balance + $single_leave_balance_details['opening_balance'];
                $total_avalied = $total_avalied + $single_leave_balance_details['availed'];
            }
            $each_user['total_leave_balance'] = $total_leave_balance;
            $each_user['total_opening_balance'] = $total_opening_balance;
            $each_user['total_avalied_balance'] = $total_avalied;
            $each_user['leave_balance_details'] = $leavetypeAndBalanceDetails;
            array_push($response, $each_user);
        }
        return $response;
    }
    public function calculateEmployeeLeaveBalance($user_id, $start_time_period, $end_time_period)
    {
        // TODO:: Which Leave Types we Have to Find availed And Balance //Need To Change In Setting Page
        //  $visible_leave_types = array('Casual/Sick Leave'=>1,'Earned Leave'=>2);
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
            }
            if ($single_leave_types->is_finite == 1) {
                if ($single_leave_types->is_accrued != 1) {
                    $total_availed_leaves = VmtEmployeeLeaves::where('user_id', $user_id)
                        ->whereBetween('start_date', [$start_time_period, $end_time_period])
                        ->where('leave_type_id', $single_leave_types->id)
                        ->whereIn('status', array('Approved', 'Pending'))
                        ->sum('total_leave_datetime');
                    $availed_leaves[$single_leave_types->leave_type] = $total_availed_leaves;
                    $temp_leave['leave_type'] = $single_leave_types->leave_type;
                    $temp_leave['leave_balance'] = (int) $single_leave_types->days_annual;
                    $temp_leave['availed_leaves'] = $total_availed_leaves;
                } else {

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
                        $selected_time_period_id = VmtOrgTimePeriod::whereBetween('start_date', [$start_time_period, $end_time_period])->first()->id;
                        if (VmtOrgTimePeriod::orderBy('id', 'ASC')->first()->id != $selected_time_period_id) {
                            $start_time_for_accrued_leave = VmtOrgTimePeriod::orderBy('id', 'ASC')->first()->start_date;
                        } else {
                            $start_time_for_accrued_leave = $start_time_period;
                        }
                        $total_accrued = VmtEmployeesLeavesAccrued::where('user_id', $user_id)
                            ->whereBetween('date', [$start_time_for_accrued_leave, $end_time_period])
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
                }
            } else {
                // dd($single_leave_types);
                $total_availed_leaves = VmtEmployeeLeaves::where('user_id', $user_id)
                    ->whereBetween('start_date', [$start_time_period, $end_time_period])
                    ->where('leave_type_id', $single_leave_types->id)
                    ->whereIn('status', array('Approved', 'Pending'))
                    ->sum('total_leave_datetime');
                $availed_leaves[$single_leave_types->leave_type] = $total_availed_leaves;
                $temp_leave['leave_type'] = $single_leave_types->leave_type;
                // $temp_leave['leave_balance'] = (int)$single_leave_types->days_annual;
                $temp_leave['leave_balance'] = 0;
                $temp_leave['availed_leaves'] = $total_availed_leaves;
            }
            array_push($response, $temp_leave);
            unset($temp_leave);
        }

        $leave_details = array('Leave Balance' => $leave_balance_for_all_types, 'availed Leaves' => $availed_leaves);
        //dd($response);
        //Based on gender, remove Maternity/Paternity leave type

        // $getcurrentusergender = getCurrentUserGender();



        // for ($i = 0; $i < count($response); $i++) {
        //     $singleLeaveType = $response[$i];
        //     if ($getcurrentusergender == 'male') {
        //         if ($response[$i]['leave_type'] == 'Maternity Leave')
        //             unset($response[$i]);
        //     } else
        //     if ($getcurrentusergender == 'female') {
        //         if ($response[$i]['leave_type'] == 'Paternity Leave')
        //             unset($response[$i]);
        //     }
        // }
        return $response;
    }

    //Get Count of Att req for given manager's team memebers
    public function getCountForAttRegularization($user_code)
    {
        //  $user_code = "BA011";
        try {
            $emp_users_query = VmtEmployeeOfficeDetails::where('l1_manager_code', $user_code)->get();
            $emp_users_id = array();
            foreach ($emp_users_query as $single_emp) {
                array_push($emp_users_id, $single_emp->user_id);
            }

            $month = Carbon::now()->format('m');


            $total_count['pending_count'] = VmtEmployeeAttendanceRegularization::whereIn('user_id', $emp_users_id)->whereMonth('attendance_date', $month)
                ->where('status', 'Pending')->count();
            $total_count['approved_count'] = VmtEmployeeAttendanceRegularization::whereIn('user_id', $emp_users_id)->whereMonth('attendance_date', $month)
                ->where('status', 'Approved')->count();
            $total_count['rejected_count'] = VmtEmployeeAttendanceRegularization::whereIn('user_id', $emp_users_id)->whereMonth('attendance_date', $month)
                ->where('status', 'Rejected')->count();

            return $total_count;
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ getCountForAttRegularization ] ",
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ]);
        }
    }

    public function getfetchAttendadnceRegularization($user_code, $year, $month, $status)
    {
        try {
            $response = array();
            $response['att_reg_count'] = $this->getCountForAttRegularization($user_code);
            $user_id = user::where('user_code', $user_code)->first()->id;
            $employees = VmtEmployeeOfficeDetails::where('l1_manager_code', $user_code)->get();
            foreach ($employees as $singleemployee) {
                $temp_arr = array();
                $att_reg_query = VmtEmployeeAttendanceRegularization::where('user_id', $singleemployee->user_id)
                    ->whereYear('attendance_date', $year)->whereMonth('attendance_date', $month);
                if ($status == 'Pending') {
                    $att_reg_query = $att_reg_query->where('status', 'Pending');
                } else if ($status == 'Approved') {
                    $att_reg_query = $att_reg_query->where('status', 'Approved');
                } else if ($status == 'Rejected') {
                    $att_reg_query = $att_reg_query->where('status', 'Rejected');
                }

                if ($att_reg_query->exists()) {
                    $temp_arr['name'] = User::where('id', $singleemployee->user_id)->first()->name;
                    $temp_arr['user_code'] = User::where('id', $singleemployee->user_id)->first()->user_code;
                    $temp_arr['regularization_details'] = $att_reg_query->get();
                    array_push($response, $temp_arr);
                    unset($temp_arr);
                }
            }
            return response()->json([
                'status' => 'success',
                'message' => "",
                'data' => $response
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'failure',
                'message' => "Error[ getCountForAttRegularization ] ",
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ]);
        }
    }

    public function getBioMetricAttendanceData($user_code, $current_date)
    {
        //Get the user client code
        $user_client_id = User::where('user_code', $user_code)->first()->client_id;
        $user_client_id = User::where('user_code', $user_code)->first()->client_id;
        $user_client_code = VmtClientMaster::find($user_client_id)->client_code;

        $deviceData = array();
        if (
            $user_client_code == "DM" || $user_client_code == 'VASA GROUPS' || $user_client_code == 'LAL' ||
            $user_client_code == 'PSC' || $user_client_code == 'IMA' || $user_client_code == 'PA' || $user_client_code == 'DMC' || $user_client_code == 'ABS'
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
        // dd($attendanceCheckIn);

        $deviceCheckOutTime = empty($attendanceCheckOut->check_out_time) ? null : explode(' ', $attendanceCheckOut->check_out_time)[1];
        $deviceCheckInTime = empty($attendanceCheckIn->check_in_time) ? null : explode(' ', $attendanceCheckIn->check_in_time)[1];
        //dd($deviceCheckInTime);
        if ($deviceCheckOutTime != null || $deviceCheckInTime != null) {
            $deviceData[] = ([
                'date' => $current_date,
                'user_code' => $user_code,
                'checkin_time' => $deviceCheckInTime,
                'checkout_time' => $deviceCheckOutTime,
                'attendance_mode_checkin' => 'biometric',
                'attendance_mode_checkout' => 'biometric'
            ]);
        }

        return $deviceData;
    }

    public function getEmpAttendanceAndWorkshift($user_id, $user_code, $current_date)
    {
        //Get the user client code
        $user_client_id = User::where('user_code', $user_code)->first()->client_id;
        $user_client_code = VmtClientMaster::find($user_client_id)->client_code;

        if (
            $user_client_code == "DM" || $user_client_code == 'VASA GROUPS' || $user_client_code == 'LAL' ||
            $user_client_code == 'PSC' || $user_client_code == 'IMA' || $user_client_code == 'PA' || $user_client_code == 'DMC' || $user_client_code == 'ABS'
            || $user_client_code == 'NAT'
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
            // dd($attendanceCheckOut);
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



            $deviceCheckOutTime = empty($attendanceCheckOut->check_out_time) ? null : explode(' ', $attendanceCheckOut->check_out_time)[1];
            $deviceCheckInTime = empty($attendanceCheckIn->check_in_time) ? null : explode(' ', $attendanceCheckIn->check_in_time)[1];
            $web_attendance = VmtEmployeeAttendance::whereDate('date', $current_date)
                ->where('user_id', $user_id)->first();
            $all_att_data = collect();
            $web_checkin_time = null;
            $web_checkout_time = null;
            if (!empty($web_attendance)) {
                $web_checkin_time = $web_attendance->checkin_time;
                $web_checkout_time = $web_attendance->checkout_time;
            }
            if ($web_checkin_time != null) {
                $all_att_data->push(['date' => $web_attendance->date . ' ' . $web_attendance->checkin_time]);
            }

            if ($web_checkout_time != null) {
                $all_att_data->push(['date' => $web_attendance->checkout_date . ' ' . $web_attendance->checkout_time]);
            }

            if ($deviceCheckOutTime != null) {
                $all_att_data->push(['date' => $current_date . ' ' . $deviceCheckOutTime]);
            }

            if ($deviceCheckInTime != null) {
                $all_att_data->push(['date' => $current_date . ' ' . $deviceCheckInTime]);
            }
            $sortedCollection = $all_att_data->sortBy([
                ['date', 'asc'],
            ]);
            $checking_time = $sortedCollection->first();
            $checkout_time = $sortedCollection->last();
            return $response = ['checkin_time' => $checking_time, 'checkout_time' => $checkout_time, 'shift_settings' => $this->getShiftTimeForEmployee($user_id, $checking_time, $checkout_time)];
            return $response;
        }
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

    public function RegularizationRequestStatus($user_id, $date, $regularizeType)
    {
        $regularize_record = VmtEmployeeAttendanceRegularization::where('attendance_date', $date)
            ->where('user_id', $user_id)->where('regularization_type', $regularizeType);
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
            return $reg_sts;
        }
    }

    // public function getEmployeeUpcomingAppliedRequested()
    // {
    //     $on_duty_count = VmtEmployeeLeaves::where('start_date', '>', Carbon::now())
    //         ->where('leave_type_id', VmtLeaves::where('leave_type', 'On Duty')->first()->id)->count();
    //     $leave_count = VmtEmployeeLeaves::where('start_date', '>', Carbon::now())
    //         ->whereNotIn('leave_type_id', [VmtLeaves::where('leave_type', 'On Duty')->first()->id])->count();
    //     return $response = array('on_duty_count' => $on_duty_count, 'leave_count' => $leave_count);
    // }


    public function checkEmployeeLcPermission($month, $year, $user_id)
    {
        $validator = Validator::make(
            $data = [
                'manager_user_code' => $user_id,
                'month' => $month,
                'year' => $year,
            ],
            $rules = [
                'user_code' => 'required|exists:users,user_code',
                'month' => 'required',
                'year' => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
                'integer' => 'Field :attribute should be integer',
                'in' => 'Field :attribute is invalid',
            ]
        );
        try {
            $map_allEmployees = User::all(['id', 'name'])->keyBy('id');
            $Employees_lateComing = VmtEmployeeAttendanceRegularization::where('user_id', $user_id)
                ->whereYear('attendance_date', $year)
                ->whereMonth('attendance_date', $month)
                ->where('regularization_type', 'LC')
                ->where('reason_type', 'Permission')
                ->whereIn('status', ['Approved', 'Pending'])
                ->get();
            // dd($Employees_lateComing);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error while fetching Attendance Regularization LC data",
                "data" => $e,
            ]);
        }
    }
    public function processOutdatedPendingAttRegAsVoid($attendanceResponseArray)
    {
        try {

            $response = array();
            foreach ($attendanceResponseArray as $key => $single_day_Lcstatus) {

                $response[$key] = $single_day_Lcstatus;

                if ($single_day_Lcstatus['isLC'] && $single_day_Lcstatus['lc_status'] != 'Approved') {
                    $Lc_applied_date = $single_day_Lcstatus['date'];
                    $LC_Expires_date = Carbon::parse($single_day_Lcstatus['date'])->addDays(7)->format('Y-m-d');
                    $current_date = carbon::now()->format('Y-m-d');

                    if ($current_date > $LC_Expires_date) {

                        $response[$key]['is_Lc_Voided'] = true;
                    } else {
                        $response[$key]['is_Lc_Voided'] = false;
                    }
                } else {
                    $response[$key]['is_Lc_Voided'] = false;
                }

                //    $Employees_lateComing = VmtEmployeeAttendanceRegularization::where('user_id',$single_day_Lcstatus['user_id'] )
                //    ->whereYear('attendance_date', Carbon::parse($single_day_Lcstatus['date'])->format('Y'))
                //    ->whereMonth('attendance_date', Carbon::parse($single_day_Lcstatus['date'])->format('m'))
                //    ->where('regularization_type', 'LC')
                //    ->where('reason_type', 'Permission')
                //    ->whereIn('status', ['Approved', 'Pending'])
                //    ->get();
                //    $response[$key]['Lc_permission_count'] = $Employees_lateComing->count();
            }

            return $response;
            // dd($response);
            //$employees_lc_data
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error while fetching Attendance Regularization LC data",
                "data" => $e->getMessage(),
            ]);
        }
    }

    public function getAttendanceDashboardData_v2($department_id, $date)
    {
        try {

            $client_id = null;
            if (!empty(session('client_id'))) {

                if (session('client_id') == 1) {
                    $client_id = VmtClientMaster::pluck('id')->toarray();
                } else {
                    $client_id = [session('client_id')];
                }
            } else {
                $client_id = [auth()->user()->client_id];
            }

            $current_date = Carbon::parse($date)->format("Y-m-d");
            //  $current_date = "2023-10-16";

            $attendance_response = array();

            $employees_data = User::leftjoin('vmt_employee_office_details as off', 'off.user_id', '=', 'users.id')
                ->leftJoin('vmt_department as dep', 'dep.id', '=', 'off.department_id')
                ->leftJoin('vmt_employee_details as det', 'det.userid', '=', 'users.id')
                ->leftJoin('vmt_emp_att_intrtable', 'vmt_emp_att_intrtable.user_id', '=', 'users.id')
                ->leftJoin('vmt_work_shifts', 'vmt_work_shifts.id', '=', 'vmt_emp_att_intrtable.vmt_employee_workshift_id')
                ->where('users.is_ssa', '0')->where('users.active', '1')->whereIn('users.client_id', $client_id);

            if (!empty($department_id)) {
                $employees_data = $employees_data->where('off.department_id', $department_id);
            }
            // get absent emp list
            $absent_employee_data = $employees_data->clone()
                ->where('date', $current_date)
                ->where('status', 'LIKE', "A%")
                ->get(['users.id as id', 'users.user_code as Employee_Code', 'users.name as Employee_Name', 'dep.name as Department', 'off.process as Process', 'det.location as Location', 'vmt_emp_att_intrtable.date as date', 'vmt_emp_att_intrtable.emp_leave_id']);

            $attendance_response['absent_count'] = $absent_employee_data->count();
            for ($i = 0; $i < count($absent_employee_data->toarray()); $i++) {
                $absent_employee_data[$i]['shortname_avatar'] = newgetEmployeeAvatarOrShortName($absent_employee_data[$i]['id']);
                if (!empty($absent_employee_data[$i]['emp_leave_id'])) {
                    $absent_employee_data[$i]['status'] = VmtEmployeeLeaves::where('id', $absent_employee_data[$i]['emp_leave_id'])->first()->status;
                } else {
                    $absent_employee_data[$i]['status'] = 'Yet To Checkin';
                }
            }
            $attendance_response['absent_emps'] = $absent_employee_data;

            // get Present emp list
            $attendance_type = array("%P%");
            $present_employee_data = $employees_data->clone()->where('date', $current_date)->where('status', 'LIKE', "P%")->get(['users.id as id', 'users.user_code as Employee_Code', 'users.name as Employee_Name', 'dep.name as Department', 'off.process as Process', 'det.location as Location', 'checkin_time', 'checkout_time']);
            //->where(function ($present_employee_data) use ($attendance_type) {
            //     foreach ($attendance_type as $keyword) {
            //         $present_employee_data->orWhere('status', 'like', '%' . $keyword . '%');
            //     }
            // })
            $attendance_response['present_count'] = $present_employee_data->count();

            for ($i = 0; $i < count($present_employee_data->toarray()); $i++) {
                $present_employee_data[$i]['shortname_avatar'] = newgetEmployeeAvatarOrShortName($present_employee_data[$i]['id']);
            }
            $attendance_response['present_emps'] = $present_employee_data->toarray();

            // get LC emp list
            $lc_employee_data = $employees_data->clone()->where('date', $current_date)
                ->where('status', 'LIKE', "%LC%")
                ->get(['users.id as id', 'users.user_code as Employee_Code', 'users.name as Employee_Name', 'dep.name as Department', 'off.process as Process', 'det.location as Location', 'checkin_time', 'checkout_time', 'vmt_work_shifts.shift_start_time']);
            $attendance_response['lc_count'] = $lc_employee_data->count();

            for ($i = 0; $i < count($lc_employee_data->toarray()); $i++) {
                $diffminutes = Carbon::parse($lc_employee_data[$i]['shift_start_time'])->diffInMinutes(Carbon::parse($lc_employee_data[$i]['checkin_time']));
                $lc_employee_data[$i]['late_min'] = CarbonInterval::minutes($diffminutes)->cascade()->forHumans();
                $lc_employee_data[$i]['shortname_avatar'] = newgetEmployeeAvatarOrShortName($lc_employee_data[$i]['id']);
            }
            $attendance_response['lc_emps'] = $lc_employee_data->toarray();

            // get EG emp list
            $eg_employee_data = $employees_data->clone()->where('date', Carbon::parse($current_date)->subDay()->format('Y-m-d'))->where('status', 'LIKE', "%EG%")
                ->get(['users.id as id', 'users.user_code as Employee_Code', 'users.name as Employee_Name', 'dep.name as Department', 'off.process as Process', 'det.location as Location', 'checkin_time', 'checkout_time', 'vmt_work_shifts.shift_end_time']);
            $attendance_response['eg_count'] = $eg_employee_data->count();
            for ($i = 0; $i < count($eg_employee_data->toarray()); $i++) {
                $diffminutes = Carbon::parse($eg_employee_data[$i]['shift_end_time'])->diffInMinutes(Carbon::parse($eg_employee_data[$i]['checkout_time']));
                $eg_employee_data[$i]['eg_min'] = CarbonInterval::minutes($diffminutes)->cascade()->forHumans();
                $eg_employee_data[$i]['shortname_avatar'] = newgetEmployeeAvatarOrShortName($eg_employee_data[$i]['id']);
            }
            $attendance_response['eg_emps'] = $eg_employee_data;

            // get MIP emp list
            $mip_employee_data = $employees_data->clone()->where('date', Carbon::parse($current_date)->subDay()->format('Y-m-d'))->where('status', 'LIKE', "%MIP%")
                ->get(['users.id as id', 'users.user_code as Employee_Code', 'users.name as Employee_Name', 'dep.name as Department', 'off.process as Process', 'det.location as Location', 'checkin_time', 'checkout_time']);
            $attendance_response['mip_count'] = $mip_employee_data->count();
            for ($i = 0; $i < count($mip_employee_data->toarray()); $i++) {
                $mip_employee_data[$i]['shortname_avatar'] = newgetEmployeeAvatarOrShortName($mip_employee_data[$i]['id']);
            }
            $attendance_response['mip_emps'] = $mip_employee_data->toarray();
            // get MOP emp list
            $mop_employee_data = $employees_data->clone()->where('date', Carbon::parse($current_date)->subDay()->format('Y-m-d'))->where('status', 'LIKE', "%MOP%")
                ->get(['users.id as id', 'users.user_code as Employee_Code', 'users.name as Employee_Name', 'dep.name as Department', 'off.process as Process', 'det.location as Location', 'checkin_time', 'checkout_time']);
            $attendance_response['mop_count'] = $mop_employee_data->count();
            for ($i = 0; $i < count($mop_employee_data->toarray()); $i++) {
                $mop_employee_data[$i]['shortname_avatar'] = newgetEmployeeAvatarOrShortName($mop_employee_data[$i]['id']);
            }
            $attendance_response['mop_emps'] = $mop_employee_data->toarray();

            // get Leave Emp list
            $leave_employee_data = $employees_data->clone()->where('date', $current_date)->whereNotNull('emp_leave_id');
            if ($leave_employee_data->exists()) {
                $leave_employee_data = $leave_employee_data->leftJoin('vmt_employee_leaves as emp_leave', 'emp_leave.id', '=', 'vmt_emp_att_intrtable.emp_leave_id')
                    ->leftJoin('vmt_leaves as leave', 'leave.id', '=', 'emp_leave.leave_type_id')
                    ->leftJoin('users as manager', 'manager.id', '=', 'emp_leave.reviewer_user_id')
                    ->where('emp_leave.status', 'Approved')
                    ->get([
                        'users.id as id',
                        'users.user_code as Employee_Code',
                        'users.name as Employee_Name',
                        'dep.name as Department',
                        'off.process as Process',
                        'det.location as Location',
                        'vmt_emp_att_intrtable.status as attendance_sts',
                        'emp_leave.leaverequest_date as leaverequest_date',
                        'emp_leave.start_date as start_date',
                        'emp_leave.end_date as end_date',
                        'emp_leave.total_leave_datetime as total leave',
                        'emp_leave.leave_reason as leave_reason',
                        'emp_leave.status as leave_status',
                        'leave.leave_type',
                        'manager.name as approver_name'
                    ]);
                $attendance_response['leave_emp_count'] = $leave_employee_data->count();
                for ($i = 0; $i < count($leave_employee_data->toarray()); $i++) {
                    $leave_employee_data[$i]['shortname_avatar'] = newgetEmployeeAvatarOrShortName($leave_employee_data[$i]['id']);
                }
                $attendance_response['leave_emps'] = $leave_employee_data->toarray();
            } else {
                $attendance_response['leave_emp_count'] = 0;
                $attendance_response['leave_emps'] = array();
            }

            $total_active_employees = User::where('is_ssa', 0)->where('active', 1)->count();

            $emp_work_shift = $this->getWorkShiftDetails();

            $on_duty_count = VmtEmployeeLeaves::where('start_date', '>', Carbon::now())
                ->where('leave_type_id', VmtLeaves::where('leave_type', 'On Duty')->first())->count();
            $work_from_home = $on_duty_count = VmtEmployeeLeaves::where('start_date', '>', Carbon::now())
                ->where('leave_type_id', VmtLeaves::where('leave_type', 'Work From Home')->first())->count();

            $leave_count = VmtEmployeeLeaves::where('start_date', '>', Carbon::now())
                ->whereNotIn('leave_type_id', array([VmtLeaves::where('leave_type', 'On Duty')->first()], [VmtLeaves::where('leave_type', 'Work From Home')->first()]))->count();
            $upcomings['On duty'] = $on_duty_count;
            $upcomings['Leave'] = $leave_count;
            $upcomings['Work From Home'] = $work_from_home;

            $response = ["attendance_overview" => $attendance_response, "work_shift" => $emp_work_shift, 'upcomings' => $upcomings, "CheckInMode" => $this->getAllEmployeesCheckInCheckOutMode($department_id), "total_Employees" => $total_active_employees];



            return $response;
        } catch (\Exception $e) {
            return $reponse = ([
                'status' => 'failure',
                'message' => 'getAttendanceDashboardData_v2',
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ]);
        }
    }

    public function getWorkShiftDetails()
    {
        $workshiftCount = array();
        $work_shift_details = VmtWorkShifts::all()->toArray();


        foreach ($work_shift_details as $key => $single_shift_id) {

            $work_shift_assigned_employees = VmtWorkShifts::join('vmt_employee_workshifts', 'vmt_employee_workshifts.work_shift_id', '=', 'vmt_work_shifts.id')
                ->join('users', 'users.id', '=', 'vmt_employee_workshifts.user_id')
                ->where('vmt_employee_workshifts.work_shift_id', '=', $single_shift_id['id'])
                ->where('users.active', '=', 1);

            $employees_id = $work_shift_assigned_employees->clone()->pluck('users.id');

            if ($work_shift_assigned_employees->exists()) {
                $emp_work_shift[$key]["work_shift_employee_data"] = $work_shift_assigned_employees->get(['users.id as id', 'users.user_code as Employee_Code', 'users.name as Employee_Name', 'shift_code', 'shift_name', 'vmt_work_shifts.is_default', 'shift_timerange_type', 'flexible_gross_hours', 'shift_start_time', 'shift_end_time', 'grace_time'])->toarray();
                $emp_work_shift[$key]["work_shift_assigned_employees"] = $work_shift_assigned_employees->count();



                $current_date = carbon::now()->format('Y-m-d');
                // $current_date = "2023-10-16";

                $employee_attendance = VmtEmpAttIntrTable::whereIn('user_id', $employees_id)->where('date', $current_date);

                $emp_work_shift[$key]["present_count"] = $employee_attendance->clone()->where('status', 'LIKE', "P%")->get()->count();
                $emp_work_shift[$key]["absent_count"] = $employee_attendance->clone()->where('status', 'LIKE', "A%")->get()->count();

                //   $emp_work_shift[$key]["biometric_checkin_count"] =$present_data->clone()->where("attendance_mode_checkin","biometric")->get()->count();
                //   $emp_work_shift[$key]["mobile_checkin_count"] =$present_data->clone()->clone()->where("attendance_mode_checkin","mobile")->get()->count();
                //   $emp_work_shift[$key]["web_checkin_count"] =$present_data->clone()->where("attendance_mode_checkin","web")->get()->count();
                //$emp_work_shift[$key]["present_count"]= $present_data->clone()->get()->count();
            }
        }
        return $emp_work_shift;
    }

    public function getAllEmployeesCheckInCheckOutMode($department_id)
    {

        try {

            $client_id = null;
            if (!empty(session('client_id'))) {

                if (session('client_id') == 1) {
                    $client_id = VmtClientMaster::pluck('id')->toarray();
                } else {
                    $client_id = [session('client_id')];
                }
            } else {
                $client_id = [auth()->user()->client_id];
            }
            $employees_data = User::leftjoin('vmt_employee_office_details as off', 'off.user_id', '=', 'users.id')
                ->leftJoin('vmt_department as dep', 'dep.id', '=', 'off.department_id')
                ->where('users.active', 1)
                ->where('users.is_ssa', "0")
                ->whereIn('users.client_id', $client_id);
            if (!empty($department_id)) {
                $employees_data = $employees_data->where('off.department_id', $department_id);
            }
            $employees_data = $employees_data->pluck('users.id as id');
            $response = array();

            $current_date = carbon::now()->format('Y-m-d');
            //$current_date="2023-10-16";

            $employee_attendance = VmtEmpAttIntrTable::whereIn('user_id', $employees_data)->where('date', $current_date);

            $attendance_type = array("%P%");
            $present_data = $employee_attendance->clone()->where(function ($present_data) use ($attendance_type) {
                foreach ($attendance_type as $keyword) {

                    $present_data->orWhere('status', 'like', '%' . $keyword . '%');
                };
            });

            $biometric_checkin_count = $present_data->clone()->where("attendance_mode_checkin", "biometric")->get()->count();

            $mobile_checkin_count = $present_data->clone()->clone()->where("attendance_mode_checkin", "mobile")->get()->count();

            $web_checkin_count = $present_data->clone()->where("attendance_mode_checkin", "web")->get()->count();

            $response[] = ["title" => 'Boimetric', 'value' => $biometric_checkin_count];
            $response[] = ["title" => 'Mobile', 'value' => $mobile_checkin_count];
            $response[] = ["title" => 'Web', 'value' => $web_checkin_count];


            return $response;
        } catch (\Exception $e) {

            return $reponse = ([
                'status' => 'failure',
                'message' => 'Error While Fetch Employees Data',
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error" => $e->getMessage() . ' | Line : ' . $e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
            ]);
        }
    }

    private function saveLatLongaddress($latlongdata, $date, $user_id, $type)
    {

        $checkin_latlong_data = explode(",", $latlongdata);

        $checkin_latlong_data = $checkin_latlong_data[1] . ',' . $checkin_latlong_data[0];

        $response = $this->getLatLongintoaddress($latlongdata);

        if (empty($response['features'])) {

            $response = $this->getLatLongintoaddress($checkin_latlong_data);
        }

        if (empty($response['features'])) {
            return null;
        }

        $Checkin_checkout_address = $response ? $response['features'][0]['place_name'] : null;

        $save_check_in_address = VmtEmployeeAttendance::where('date', $date)->where('user_id', $user_id)->first();

        if (!empty($save_check_in_address)) {

            if ($type == 'check_in') {
                $save_check_in_address->checkin_full_address = $Checkin_checkout_address ?? null;
            } else {
                $save_check_in_address->checkout_full_address = $Checkin_checkout_address ?? null;
            }
            $save_check_in_address->save();
        }

        return $Checkin_checkout_address;
    }
    private function getLatLongintoaddress($latlongdata)
    {

        $data = Http::get('https://api.mapbox.com/geocoding/v5/mapbox.places/' . trim($latlongdata) . '.json?types=address&access_token=pk.eyJ1Ijoia2FydGhpMmsiLCJhIjoiY2xwMHlub3Q5MGhjZzJpbmxxZTkwdHFtbSJ9.bY-o60sH7edn80M-4P55iw');
        $response = $data->json();

        return $response;
    }
    public function fetchAttendanceDailyReport_PerMonth_v3($user_code, $year, $month)
    {
        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
                'year' => $year,
                'month' => $month,
            ],
            $rules = [
                'user_code' => 'required|exists:users,user_code',
                'year' => 'required|integer',
                'month' => 'required|integer',
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
            $startOfMonth = $monthDateObj->startOfMonth(); //->format('Y-m-d');
            $endOfMonth = $monthDateObj->clone()->endOfMonth(); //->format('Y-m-d');
            $employee_doj = VmtEmployee::where('userid', $user_id)->first();
            if ($query_user->client_id == 0) {
                $user_client_code = VmtClientMaster::first();
            } else {
                $user_client_code = VmtClientMaster::find($query_user->client_id);
            }
            $user_client_code = $user_client_code->client_code;

            if (!empty($employee_doj)) {
                $employee_doj = $employee_doj->doj;
            }


            $attendanceResponseArray = [];

            //Create empty month array with all dates.

            if ($month < 10)
                $month = "0" . $month;

            $days_count = days_in_month($month, $year);

            for ($i = 1; $i <= $days_count; $i++) {
                $date = "";

                if ($i < 10)
                    $date = "0" . $i;
                else
                    $date = $i;

                $fulldate = $year . "-" . $month . "-" . $date;


                $attendanceResponseArray[$fulldate] = array(
                    "date" => $fulldate,
                    "user_id" => $user_id,
                    "isAbsent" => true,
                    "attendance_mode_checkin" => null,
                    "attendance_mode_checkout" => null,
                    "user_code" => $user_code,
                    "vmt_employee_workshift_id" => null,
                    "workshift_code" => null,
                    "workshift_name" => null,
                    "absent_status" => 'Not Applied',
                    "leave_type" => null,
                    "leave_status" => null,
                    "checkin_time" => null,
                    "checkout_time" => null,
                    "selfie_checkin" => null,
                    "selfie_checkout" => null,
                    "isLC" => false,
                    "lc_status" => null,
                    "lc_reason" => null,
                    "lc_reason_custom" => null,
                    "lc_regularized_time" => null,
                    "isEG" => false,
                    "eg_status" => null,
                    "eg_reason" => null,
                    "eg_reason_custom" => null,
                    "eg_regularized_time" => null,
                    "isMIP" => false,
                    "mip_status" => null,
                    "mip_reason" => null,
                    "mip_reason_custom" => null,
                    "mip_regularized_time" => null,
                    "isMOP" => false,
                    "mop_status" => null,
                    "mop_reason" => null,
                    "mop_reason_custom" => null,
                    "mop_regularized_time" => null,
                    "absent_reg_status" => 'None',
                    "absent_reg_checkin" => null,
                    "absent_reg_checkout" => null,
                    'absent_reg_reason' => '',
                    'absent_approver_name' => "",
                    "is_holiday" => false,
                    "holiday_name" => "",
                    "holiday_image_url" => "",
                    'checkin_full_address' => null,
                    'checkout_full_address' => null,
                    "attendance_status" => false,
                    'is_sandwich_applicable' => false,
                    'is_week_off' => false,
                    'shift_start_time' => '',
                    'shift_end_time' => ''
                );
            }

            $dateWiseData = VmtEmpAttIntrTable::whereBetween('date', [$startOfMonth, $endOfMonth])->where('user_id', $user_id)->get()->toarray();

            foreach ($dateWiseData as $data_key => $single_value) {
                //dd($dateWiseData);

                $key = $single_value['date'];
                $attendance_WebMobile = VmtEmployeeAttendance::where('user_id', $user_id)->where('date', $single_value['date'])->first();
                $attendanceResponseArray[$key]["checkin_time"] = $single_value['checkin_time'];
                $attendanceResponseArray[$key]["checkout_time"] = $single_value['checkout_time'];
                $attendanceResponseArray[$key]["attendance_mode_checkin"] = $single_value['attendance_mode_checkin'];
                $attendanceResponseArray[$key]["attendance_mode_checkout"] = $single_value['attendance_mode_checkout'];
                $attendanceResponseArray[$key]["check_in_location"] = !empty($attendance_WebMobile) ? $attendance_WebMobile->checkin_lat_long : null;
                $attendanceResponseArray[$key]["check_out_location"] = !empty($attendance_WebMobile) ? $attendance_WebMobile->checkout_lat_long : null;
                $attendanceResponseArray[$key]["checkout_full_address"] = !empty($attendance_WebMobile) ? $attendance_WebMobile->checkout_full_address : null;
                $attendanceResponseArray[$key]["checkin_full_address"] = !empty($attendance_WebMobile) ? $attendance_WebMobile->checkin_full_address : null;

                if ($attendanceResponseArray[$key]["attendance_mode_checkin"] == 'mobile') {

                    if (empty($attendanceResponseArray[$key]["checkin_full_address"]) && !empty($attendanceResponseArray[$key]["check_in_location"])) {

                        $attendanceResponseArray[$key]["checkin_full_address"] = $this->saveLatLongaddress($attendanceResponseArray[$key]["check_in_location"], $attendanceResponseArray[$key]["date"], $user_id, 'check_in');
                    }
                    if (empty($attendanceResponseArray[$key]["checkout_full_address"]) && !empty($attendanceResponseArray[$key]["check_out_location"])) {

                        $attendanceResponseArray[$key]["checkout_full_address"] = $this->saveLatLongaddress($attendanceResponseArray[$key]["check_out_location"], $attendanceResponseArray[$key]["date"], $user_id, 'check_out');
                    }
                }

                //Update Absent status
                if (!empty($single_value["checkin_time"]) || !empty($single_value["checkout_time"]))
                    $attendanceResponseArray[$key]["isAbsent"] = false;
                //selfies

                if ($single_value["checkin_time"] && !empty($attendance_WebMobile->selfie_checkin))
                    $attendanceResponseArray[$key]["selfie_checkin"] = 'employees/' . $user_code . '/selfies/' . $attendance_WebMobile->selfie_checkin;

                if ($single_value["checkout_time"] && !empty($attendance_WebMobile->selfie_checkout))
                    $attendanceResponseArray[$key]["selfie_checkout"] = 'employees/' . $user_code . '/selfies/' . $attendance_WebMobile->selfie_checkout;

                //check holidays status
                $emp_att_reg_status = explode('/', $single_value['status']);

                if (in_array('HO', $emp_att_reg_status) && !in_array('SW', $emp_att_reg_status)) {

                    $current_date = strtotime($single_value["date"]);
                    $query_holiday = vmtHolidays::whereMonth('holiday_date', date('m', $current_date))
                        ->whereDay('holiday_date', date('d', $current_date))->first();

                    if (!empty($query_holiday)) {

                        $attendanceResponseArray[$key]['is_holiday'] = true;
                        $attendanceResponseArray[$key]['holiday_name'] = $query_holiday->holiday_name;
                        $attendanceResponseArray[$key]['holiday_image_url'] = $query_holiday->image;
                        $attendanceResponseArray[$key]["isAbsent"] = true;
                    } else {
                        $attendanceResponseArray[$key]['is_holiday'] = true;
                        $attendanceResponseArray[$key]['holiday_name'] = null;
                        $attendanceResponseArray[$key]['holiday_image_url'] = null;
                        $attendanceResponseArray[$key]["isAbsent"] = true;
                    }
                }
                //check shift if an employee

                $shift_time = $this->getShiftTimeForEmployee($single_value['user_id'], $single_value['checkin_time'], $single_value['checkout_time']);

                $attendanceResponseArray[$key]['vmt_employee_workshift_id'] = $shift_time->id;
                $attendanceResponseArray[$key]['workshift_code'] = $shift_time->shift_code;
                $attendanceResponseArray[$key]['workshift_name'] = $shift_time->shift_name;
                $attendanceResponseArray[$key]["shift_start_time"] = $shift_time->shift_start_time;
                $attendanceResponseArray[$key]["shift_end_time"] = $shift_time->shift_end_time;

                //check absent regularization
                $absent_reg = VmtEmployeeAbsentRegularization::where('user_id', $single_value['user_id'])->where('attendance_date', $single_value['date'])->first();

                if (!empty($single_value['absent_reg_id'])) {

                    $query_absent_reg = VmtEmployeeAbsentRegularization::where('id', $single_value['absent_reg_id'])->first();

                    if (!empty($query_absent_reg)) {
                        $reviewer_details = User::where('id', $query_absent_reg->reviewer_id)->first();
                        $attendanceResponseArray[$key]["absent_reg_status"] = $query_absent_reg->status;
                        $attendanceResponseArray[$key]["absent_reg_checkin"] = $query_absent_reg->checkin_time;
                        $attendanceResponseArray[$key]["absent_reg_checkout"] = $query_absent_reg->checkout_time;
                        $attendanceResponseArray[$key]["absent_approver_name"] = !empty($reviewer_details) ? $reviewer_details->name : " ";
                        $attendanceResponseArray[$key]["absent_reg_reason"] = $query_absent_reg->reason == "Others" ? $query_absent_reg->custom_reason : $query_absent_reg->reason;
                    }
                } else if (!empty($absent_reg)) {
                    $reviewer_details = User::where('id', $absent_reg->reviewer_id)->first();
                    $attendanceResponseArray[$key]["absent_reg_status"] = $absent_reg->status;
                    $attendanceResponseArray[$key]["absent_reg_checkin"] = $absent_reg->checkin_time;
                    $attendanceResponseArray[$key]["absent_reg_checkout"] = $absent_reg->checkout_time;
                    $attendanceResponseArray[$key]["absent_approver_name"] = !empty($reviewer_details) ? $reviewer_details->name : " ";
                    $attendanceResponseArray[$key]["absent_reg_reason"] = $absent_reg->reason == "Others" ? $absent_reg->custom_reason : $absent_reg->reason;
                } else {
                    $attendanceResponseArray[$key]["absent_reg_status"] = 'None';
                }

                if (in_array('WO', $emp_att_reg_status) && !in_array('SW', $emp_att_reg_status)) {

                    $attendanceResponseArray[$key]["is_week_off"] = true;
                }

                //check absent regularization
                if (!empty($single_value['lc_id'])) {
                    $attendanceResponseArray[$key]["isLC"] = true;

                    $regularization_record = VmtEmployeeAttendanceRegularization::where('id', $single_value['lc_id'])->first();

                    if (empty($regularization_record)) {
                        $attendanceResponseArray[$key]["lc_status"] = 'None';
                        $attendanceResponseArray[$key]["lc_reason"] = 'None';
                        $attendanceResponseArray[$key]["lc_reason_custom"] = null;
                        $attendanceResponseArray[$key]["lc_regularized_time"] = null;
                    } else {
                        //check regularization status
                        $attendanceResponseArray[$key]["lc_status"] = $regularization_record->status;
                        $attendanceResponseArray[$key]["lc_reason"] = $regularization_record->reason_type;
                        $attendanceResponseArray[$key]["lc_reason_custom"] = $regularization_record->custom_reason;
                        $attendanceResponseArray[$key]["lc_regularized_time"] = $regularization_record->regularize_time;
                    }
                } elseif (in_array('LC', $emp_att_reg_status)) {

                    $attendanceResponseArray[$key]["isLC"] = true;

                    $attendanceResponseArray[$key]["lc_status"] = 'None';
                    $attendanceResponseArray[$key]["lc_reason"] = 'None';
                    $attendanceResponseArray[$key]["lc_reason_custom"] = null;
                    $attendanceResponseArray[$key]["lc_regularized_time"] = null;
                }


                $leave_type_status = array('SL/CL', 'CL/SL', 'LOP LE', 'EL', 'ML', 'PTL', 'OD', 'PI', 'CO', 'CL', 'SL', 'FO L');




                if (!empty($single_value['eg_id'])) {

                    $attendanceResponseArray[$key]["isEG"] = true;

                    $regularization_record = VmtEmployeeAttendanceRegularization::where('id', $single_value['eg_id'])->first();

                    if (empty($regularization_record)) {
                        $attendanceResponseArray[$key]["eg_status"] = 'None';
                        $attendanceResponseArray[$key]["eg_reason"] = 'None';
                        $attendanceResponseArray[$key]["eg_reason_custom"] = null;
                        $attendanceResponseArray[$key]["eg_regularized_time"] = null;
                    } else {
                        //check regularization status
                        $attendanceResponseArray[$key]["eg_status"] = $regularization_record->status;
                        $attendanceResponseArray[$key]["eg_reason"] = $regularization_record->reason_type;
                        $attendanceResponseArray[$key]["eg_reason_custom"] = $regularization_record->custom_reason;
                        $attendanceResponseArray[$key]["eg_regularized_time"] = $regularization_record->regularize_time;
                    }
                } elseif (in_array('EG', $emp_att_reg_status)) {

                    $attendanceResponseArray[$key]["isEG"] = true;
                    $attendanceResponseArray[$key]["eg_status"] = 'None';
                    $attendanceResponseArray[$key]["eg_reason"] = 'None';
                    $attendanceResponseArray[$key]["eg_reason_custom"] = null;
                    $attendanceResponseArray[$key]["eg_regularized_time"] = null;
                }

                if (!empty($employee_doj) ? $key < $employee_doj : false) {

                    $attendanceResponseArray[$key]["attendance_status"] = true;
                } else if (in_array("SW", $emp_att_reg_status)) {

                    $attendanceResponseArray[$key]["is_sandwich_applicable"] = true;
                } elseif ($single_value['status'] == "A") {

                    $attendanceResponseArray[$key]["isAbsent"] = true;
                }
                if (in_array($single_value['status'], $leave_type_status) || $single_value['emp_leave_id'] != null) {

                    $t_leaveRequestDetails = VmtEmployeeLeaves::where('id', $single_value['emp_leave_id'])->first();

                    $attendanceResponseArray[$key]["leave_status"] = $t_leaveRequestDetails->status;
                    $attendanceResponseArray[$key]["leave_type"] = VmtLeaves::where('id', $t_leaveRequestDetails->leave_type_id)->first()->leave_type;
                } else {

                    $attendanceResponseArray[$key]["absent_status"] = "Not Applied";
                    $attendanceResponseArray[$key]["leave_type"] = null;
                }

                if (!empty($single_value['mop_id'])) {
                    $attendanceResponseArray[$key]["isMOP"] = true;


                    $regularization_record = VmtEmployeeAttendanceRegularization::where('id', $single_value['mop_id'])->first();

                    if (empty($regularization_record)) {
                        $attendanceResponseArray[$key]["mop_status"] = 'None';
                        $attendanceResponseArray[$key]["mop_reason"] = 'None';
                        $attendanceResponseArray[$key]["mop_reason_custom"] = null;
                        $attendanceResponseArray[$key]["mop_regularized_time"] = null;
                    } else {
                        $attendanceResponseArray[$key]["mop_status"] = $regularization_record->status;
                        $attendanceResponseArray[$key]["mop_reason"] = $regularization_record->reason_type;
                        $attendanceResponseArray[$key]["mop_reason_custom"] = $regularization_record->custom_reason;
                        $attendanceResponseArray[$key]["mop_regularized_time"] = $regularization_record->regularize_time;
                        $attendanceResponseArray[$key]["isAbsent"] = false;
                    }
                } else if (in_array('MOP', $emp_att_reg_status)) {

                    $attendanceResponseArray[$key]["isMOP"] = true;


                    $attendanceResponseArray[$key]["mop_status"] = 'None';
                    $attendanceResponseArray[$key]["mop_reason"] = 'None';
                    $attendanceResponseArray[$key]["mop_reason_custom"] = null;
                    $attendanceResponseArray[$key]["mop_regularized_time"] = null;
                }

                if (!empty($single_value['mip_id'])) {
                    $attendanceResponseArray[$key]["isMIP"] = true;
                    $regularization_record = VmtEmployeeAttendanceRegularization::where('id', $single_value['mip_id'])->first();

                    if (empty($regularization_record)) {
                        $attendanceResponseArray[$key]["mip_status"] = 'None';
                        $attendanceResponseArray[$key]["mip_reason"] = 'None';
                        $attendanceResponseArray[$key]["mip_reason_custom"] = null;
                        $attendanceResponseArray[$key]["mip_regularized_time"] = null;
                        $attendanceResponseArray[$key]["__mip_error"] = "Invalid mip_id found!";
                    } else {
                        $attendanceResponseArray[$key]["mip_status"] = $regularization_record->status;
                        $attendanceResponseArray[$key]["mip_reason"] = $regularization_record->reason_type;
                        $attendanceResponseArray[$key]["mip_reason_custom"] = $regularization_record->custom_reason;
                        $attendanceResponseArray[$key]["mip_regularized_time"] = $regularization_record->regularize_time;
                        $attendanceResponseArray[$key]["isAbsent"] = false;
                    }
                } else if (in_array('MIP', $emp_att_reg_status)) {
                    //Since its MIP
                    $attendanceResponseArray[$key]["isMIP"] = true;

                    $attendanceResponseArray[$key]["mip_status"] = 'None';
                    $attendanceResponseArray[$key]["mip_reason"] = 'None';
                    $attendanceResponseArray[$key]["mip_reason_custom"] = null;
                    $attendanceResponseArray[$key]["mip_regularized_time"] = null;
                }

                // if ($user_client_code == "BA") {

                //     $employee_Lc_expire_status = $this->processOutdatedPendingAttRegAsVoid($attendanceResponseArray);
                //     // dd($attendanceResponseArray);
                //     $attendanceResponseArray = $employee_Lc_expire_status;
                // }
            }


            return response()->json([
                'status' => 'success',
                'message' => 'Attendance Monthly Report fetched successfully',
                'data' => $attendanceResponseArray,
            ]);
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

    public function fetchAttendanceDailyReport_PerMonth_v3_count($response_fetchAttendanceDailyReport_PerMonth_v3)
    {
        if (!empty($response_fetchAttendanceDailyReport_PerMonth_v3)) {
            // dd($response_fetchAttendanceDailyReport_PerMonth_v3);
            $data = $response_fetchAttendanceDailyReport_PerMonth_v3;
            $present_count = 0;
            $absent_count = 0;
            $leave_count = 0;
            $weekoff_count = 0;
            $holiday_count = 0;
            // $absent_dates_array = [];//For testing only
            foreach ($data as $singleDate) {

                if ($singleDate['vmt_employee_workshift_id'] && $singleDate['is_week_off'] == false) {
                    if ($singleDate['isAbsent']) {
                        if ($singleDate['leave_status'] == 'Approved') {
                            $leave_count++;
                        } else if ($singleDate['is_holiday']) {
                            $holiday_count++;
                        } else {
                            $absent_count++;
                            //   array_push($absent_dates_array, $singleDate);
                        }
                    } else {
                        $present_count++;
                    }
                } else if ($singleDate['is_week_off']) {
                    $weekoff_count++;
                }
            }
            $present_count = $present_count + $weekoff_count + $holiday_count;
            return $response = [
                "present_count" => $present_count,
                "leave_count" => $leave_count,
                "absent_count" => $absent_count
            ];
        } else {
            return $response = [
                "present_count" => 0,
                "leave_count" => 0,
                "absent_count" => 0
            ];
        }
    }


    public function checkingGivenDateHolidayOrNot($year, $month, $i)
    {

        $holiday_query = vmtHolidays::whereMonth('holiday_date', $month)
            ->whereDay('holiday_date', $i)->get();
        if ($holiday_query->isEmpty()) {
            if (Carbon::parse($year . '-' . $month . '-' . $i)->format('l') == 'Sunday') {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function saveSandwichSettingsdata($is_weekoff_applicable, $is_holiday_applicable, $can_consider_approved_leaves, $is_sandwich_applicable)
    {
        $validator = Validator::make(
            $data = [
                'is_sandwich_applicable' => $is_sandwich_applicable,
                'is_weekoff_applicable' => $is_weekoff_applicable,
                'is_holiday_applicable' => $is_holiday_applicable,
                'can_consider_approved_leaves' => $can_consider_approved_leaves,
            ],
            $rules = [
                'is_sandwich_applicable' => 'required|integer',
                'is_weekoff_applicable' => 'required|integer',
                'is_holiday_applicable' => 'required|integer',
                'can_consider_approved_leaves' => 'required|integer',
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

            $save_sandwich_settings_data = VmtAttendanceSettings::first();
            if (!empty($save_sandwich_settings_data)) {
                $save_sandwich_settings_data = $save_sandwich_settings_data;
            } else {
                $save_sandwich_settings_data = new VmtAttendanceSettings;
            }
            $save_sandwich_settings_data->is_sandwich_applicable = $is_sandwich_applicable;
            $save_sandwich_settings_data->is_weekoff_applicable = $is_weekoff_applicable;
            $save_sandwich_settings_data->is_holiday_applicable = $is_holiday_applicable;
            $save_sandwich_settings_data->can_consider_approved_leaves = $can_consider_approved_leaves;
            $save_sandwich_settings_data->save();
            return $response = [
                'status' => 'success',
                'message' => 'data saved successfully',
                'data' => '',
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

    public function restrictedDaysForLeaveApply($user_code)
    {
        $validator = Validator::make(
            $data = [
                'user_code' => $user_code
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
            ], 400);
        }
        try {

            $user_id = User::where('user_code', $user_code)->first()->id;
            //need Change payroll date once Payroll Module Live
            if (Carbon::today()->format('d') < 26) {
                $previous_month = Carbon::today()->subMonth();
                $start_date = Carbon::parse($previous_month->format('Y') . '-' . $previous_month->format('m') . '-26');
            } else {
                $start_date = Carbon::parse(Carbon::today()->format('Y') . '-' . Carbon::today()->format('m') . '-26');
            }
            $next_month = $start_date->clone()->addMonth();
            $end_date = Carbon::parse($next_month->format('Y') . '-' . $next_month->format('m') . '-25');
            if ($end_date->gt(Carbon::today())) {
                $end_date = Carbon::today();
            }
            $start_date_str = $start_date->format('Y-m-d');
            $end_date_str = $end_date->format('Y-m-d');
            $restricted_leave_details = array();
            $restricted_leave_details['attendance_start_date'] = $start_date_str;
            $restricted_leave_details['restricted_days'] = array();
            for ($i = 1; $start_date->lte($end_date); $i++) {
                if (
                    !VmtEmpAttIntrTable::where('user_id', $user_id)
                        ->whereDate('date', $start_date->clone()->format('Y-m-d'))
                        ->where('status', 'A')->exists()
                ) {
                    array_push($restricted_leave_details['restricted_days'], $start_date->clone()->format('Y-m-d'));
                }

                $start_date = Carbon::parse($start_date_str);
                $start_date->addDay($i);
            }
            return $restricted_leave_details;
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error While Get restrictedDaysForLeaveApply',
                'error' => $e->getMessage(),
                'error_line' => $e->getTraceAsString()
            ], 400);
        }
    }
}
