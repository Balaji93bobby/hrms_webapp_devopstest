<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VmtEmployeeReimbursements;
use App\Models\User;
use App\Services\VmtReimbursementsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\HRMSBaseAPIController;
use App\Models\VmtEmployeeAttendance;
use App\Models\VmtStaffAttendanceDevice;
use App\Models\VmtReimbursements;
use App\Models\VmtEmployeeLeaves;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Services\VmtAttendanceService;
use App\Services\VmtNotificationsService;
use Illuminate\Support\Facades\Validator;

class VmtAPIAttendanceController extends HRMSBaseAPIController
{

    private $cost_per_km_2wheeler = 3;
    private $cost_per_km_4wheeler = 4;


    public function performAttendanceCheckIn(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {

        $response =  $serviceVmtAttendanceService->performAttendanceCheckIn($request->user_code, $request->date, $request->checkin_time, $request->selfie_checkin, $request->work_mode, $request->attendance_mode_checkin, $request->checkin_lat_long, $request->checkin_full_address);

        return $response;
    }


    public function performAttendanceCheckOut(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "existing_check_in_date" => "required",
                "checkout_time" => "required",
                "work_mode" => "required", //office, work
                "attendance_mode_checkout" => "required", //mobile, web
                "checkout_lat_long" => "nullable", //lat, long
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

        $response =  $serviceVmtAttendanceService->performAttendanceCheckOut(
            $request->user_code,
            $request->existing_check_in_date,
            $request->checkout_time,
            $request->selfie_checkout,
            $request->work_mode,
            $request->attendance_mode_checkout,
            $request->checkout_lat_long,
            $request->checkout_full_address
        );

        return $response;
    }

    /*
        Get the attendance status of the given user
        for the given date


    */
    public function getAttendanceStatus(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {
        $validator = Validator::make(
            $request->all(),
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "date" => "required",
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

        $response = $serviceVmtAttendanceService->fetchAttendanceStatus($request->user_code, $request->date);

        return response()->json([
            'status' => 'success',
            'message' => $validator->errors()->all(),
            'data' => $response
        ]);
    }

    public function getLastAttendanceStatus(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {
        $validator = Validator::make(
            $request->all(),
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

        $response = $serviceVmtAttendanceService->getLastAttendanceStatus($request->user_code);

        return response()->json([
            'status' => 'success',
            'message' => $validator->errors()->all(),
            'data' => $response
        ]);
    }


    /*
        attendanceMonthlyReport():
        Input : date
        DB Table : vmt_employee_attendance
        Output : success/failure response.
    */
    public function getAttendanceMonthStatsReport(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {

        //Validate the request
        $validator = Validator::make(
            $request->all(),
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
            ]);
        }

        //Fetch the data
        $response = $serviceVmtAttendanceService->fetchAttendanceMonthStatsReport($request->user_code, $request->year, $request->month);


        return response()->json([
            'status' => 'success',
            'message' => '',
            'data' => $response
        ]);
    }

    public function getEmployeeLeaveBalance(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {

        return $serviceVmtAttendanceService->getEmployeeLeaveBalance($request->user_code);
    }

    public function applyLeaveRequest(Request $request, VmtAttendanceService $serviceVmtAttendanceService, VmtNotificationsService $serviceVmtNotificationsService)
    {

        $response = $serviceVmtAttendanceService->applyLeaveRequest(
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
            user_type: $request->user_type,
            notifications_users_id: $request->notifications_users_id,
            serviceNotificationsService: $serviceVmtNotificationsService
        );


        return $response;
    }


    public function approveRejectAbsentRegularization(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {

        return $serviceVmtAttendanceService->approveRejectAbsentRegularization(
            approver_user_code: $request->approver_user_code,
            record_id: $request->record_id,
            status: $request->status,
            status_text: $request->status_text,
            user_type: "manager",
        );
    }

    public function approveRejectRevokeLeaveRequest(Request $request, VmtAttendanceService $serviceVmtAttendanceService, VmtNotificationsService $serviceVmtNotificationsService)
    {
        try {

            return $serviceVmtAttendanceService->approveRejectRevokeLeaveRequest(record_id:$request->record_id, approver_user_code:auth()->user()->user_code, status:$request->status, review_comment:$request->review_comment,  user_type:$request->user_type="manager", serviceNotificationsService :$serviceVmtNotificationsService);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ approveRejectRevokeLeaveRequest() ] " . $e->getMessage(),
                'data' => $e->getMessage()
            ]);
        }
    }
    //Fetch the data



    public function getAttendanceDailyReport_PerMonth_v2(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {
        //Fetch the data
        return $serviceVmtAttendanceService->fetchAttendanceDailyReport_PerMonth_v3($request->user_code, $request->year, $request->month);
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

    public function applyRequestAttendanceRegularization(Request $request, VmtAttendanceService $serviceVmtAttendanceService, VmtNotificationsService $serviceVmtNotificationsService)
    {

        //Fetch the data
        $response = $serviceVmtAttendanceService->applyRequestAttendanceRegularization($request->user_code, $request->attendance_date, $request->regularization_type, $request->user_time, $request->regularize_time, $request->reason, $request->custom_reason,"manager",serviceVmtNotificationsService: $serviceVmtNotificationsService);


        return $response;
    }


    public function approveRejectAttendanceRegularization(Request $request, VmtAttendanceService $serviceVmtAttendanceService, VmtNotificationsService $serviceVmtNotificationsService)
    {

      try{
            $approver_record_id[] = $request->record_id;
        foreach ($approver_record_id as $single_record_ids) {

        //Fetch the data
        $response = $serviceVmtAttendanceService->approveRejectAttendanceRegularization(
            approver_user_code: $request->approver_user_code,
            record_id: $single_record_ids,
            status: $request->status,
            status_text: $request->status_text,
            user_type: "manager",
            serviceVmtNotificationsService: $serviceVmtNotificationsService
        );
    }

    return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Attendance regularization ' . $request->status . ' successfully',
                ]
            );
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ approveRejectAttendanceRegularization() ] " . $e->getMessage(),
                'data' => $e->getMessage()
            ]);
        }
        return $response;
    }

    public function getAttendanceRegularizationStatus(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {

        return $serviceVmtAttendanceService->getAttendanceRegularizationStatus(
            user_code: $request->user_code,
            regularization_date: $request->regularization_date,
            regularization_type: $request->regularization_type
        );
    }


    public function getAttendanceRegularizationData(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {


        //Fetch the data
        $response = $serviceVmtAttendanceService->fetchAttendanceRegularizationData(month: $request->month, year: $request->year,manager_user_code: $request->manager_user_code);

        return response()->json($response);
    }
    public function fetchEmployeeAbsentRegularizationData(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {

        //Fetch the data
        $response = $serviceVmtAttendanceService->fetchEmployeeAbsentRegularizationData($request->manager_user_code,$request->month, $request->year, $request->regularization_status);

        return response()->json($response);
    }

    public function getUnusedCompensatoryDays(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {

        $validator = Validator::make(
            $request->all(),
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

        //fetch the data
        $user_id = User::where('user_code', $request->user_code)->first()->id;

        $response = $serviceVmtAttendanceService->fetchUnusedCompensatoryOffDays($user_id);

        return response()->json([
            'status' => 'success',
            'message' => '',
            'data' => $response
        ]);
    }

    public function getEmployeeWorkShiftTimings(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {

        return $serviceVmtAttendanceService->getEmployeeWorkShiftTimings($request->user_code);
    }
    public function getEmployeeLeaveDetails(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {

        return $serviceVmtAttendanceService->getEmployeeLeaveDetails($request->user_code, $request->filter_month, $request->filter_year, $request->filter_leave_status);
    }
    public function getAllEmployeesLeaveDetails(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {

        return $serviceVmtAttendanceService->getAllEmployeesLeaveDetails($request->filter_month, $request->filter_year, $request->filter_leave_status,  $request->client_code);
    }
    public function getTeamEmployeesLeaveDetails(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {
        try {
            $response = array();
            $emp_details = $serviceVmtAttendanceService->getTeamEmployeesLeaveDetails($request->manager_code, $request->filter_month, $request->filter_year, $request->filter_leave_status);

            $emp_details = json_encode($emp_details, true);
            $emp_details = json_decode($emp_details, true);
            foreach ($emp_details['original']['data'] as $single_details) {
                $temp_ar = array();
                $temp_detail_ar = array();
                //$temp_user_code =array();
                $temp_user_code = $single_details['user_code'];
                if (array_key_exists($temp_user_code, $response)) {

                    array_push($response, $single_details);

                } else {
                    // $temp_ar['user_code'] =  $single_details['user_code'];
                    // $temp_ar['name'] =  $single_details['employee_name'];
                    // array_push($temp_detail_ar, $single_details);
                    // $temp_ar = $temp_detail_ar;
                    array_push($response, $single_details);

                }
            }
            $response = array_values($response);
        return response()->json([
            'status' => 'success',
            'message' => '',
            'data' => $response
        ]);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ getAllEmployeesLeaveDetails() ] ",
                'data' => $e
            ]);
        }

    }

    public function getCountForAttRegularization(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {
        $validator = Validator::make(
            $request->all(),
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

        $response =  $serviceVmtAttendanceService->getCountForAttRegularization($request->user_code);

        return $response;
    }

    public function getfetchAttendadnceRegularization(Request $request, VmtAttendanceService $serviceVmtAttendanceService)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "year" => 'required',
                "month" => 'required',
                "status" => 'required|in:Pending,Approved,Rejected',
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
                "in" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }
        $response =  $serviceVmtAttendanceService->getfetchAttendadnceRegularization($request->user_code, $request->year, $request->month, $request->status);

        return $response;
    }
}
