<?php

namespace App\Services;

use App\Models\ResignationSetting;
use App\Models\ResignationType;
use App\Models\User;
use App\Models\VmtClientMaster;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtEmployeeResignation;
use App\Models\VmtEmployeeWorkShifts;
use App\Models\VmtHolidayList;
use App\Models\vmtHolidays;
use App\Models\VmtPayroll;
use App\Models\VmtWorkShifts;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class VmtExitModuleService
{
    public function getResignationType()
    {
        try {
            $resignation_types = ResignationType::all();
            return response()->json([
                'status' => 'success',
                'message' => '',
                'data' => $resignation_types
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error While get Resignation Types',
                'error' => $e->getMessage(),
                'error_line' => $e->getTraceAsString()
            ]);
        }
    }
    public function applyResignation(
        $request_date,
        $user_id,
        $resignation_type_id,
        $resignation_reason,
        $notice_period_date,
        $expected_last_working_day,
        $last_payroll_date,
        $reason_for_dol_change
    ) {
        $validator = Validator::make(
            $data = [
                'request_date' => $request_date,
                'user_id' => $user_id,
                'resignation_type_id' => $resignation_type_id,
                'resignation_reason' => $resignation_reason,
                'notice_period_date' => $notice_period_date,
                'expected_last_working_day' => $expected_last_working_day,
                'last_payroll_date' => $last_payroll_date,
                'reason_for_dol_change' => $reason_for_dol_change
            ],
            $rules = [
                'request_date' => 'required',
                'user_id' => 'required|exists:users,id',
                'resignation_type_id' => 'required|exists:vmt_resignation_type,id',
                'resignation_reason' => 'nullable',
                'notice_period_date' => 'required',
                'expected_last_working_day' => 'required',
                'last_payroll_date' => 'required',
                'reason_for_dol_change' => 'nullable'
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
            $emp_resignation_query = new VmtEmployeeResignation;
            $emp_resignation_query->request_date = $request_date;
            $emp_resignation_query->user_id = $user_id;
            $emp_resignation_query->vmt_resignation_type_id = $resignation_type_id;
            $emp_resignation_query->resignation_reason = $resignation_reason;
            $emp_resignation_query->notice_period_date = $notice_period_date;
            $emp_resignation_query->expected_last_working_day = $expected_last_working_day;
            $emp_resignation_query->last_payroll_date = $last_payroll_date;
            $emp_resignation_query->reason_for_dol_change = $last_payroll_date;
            // $emp_resignation_query->approval_status = ;
            if ($emp_resignation_query->save()) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Resignation Settings Saved SucessFully'
                ]);
            } else {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Error While Saving Resignation Request in Database'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error While Apply Resignation',
                'error' => $e->getMessage(),
                'error_line' => $e->getTraceAsString()
            ]);
        }
    }
    public function saveResignationSetting(
        $client_id,
        $can_apply_resignation,
        $manager_can_submit_resignation_for_emp,
        $hr_can_submit_resignation_for_emp,
        $emp_can_edit_last_working_day,
        $resignation_auto_approve,
        $resignation_approver_flow,
        $email_reminder_for_resignation
    ) {
        $validator = Validator::make(
            $data = [
                "client_id" => $client_id,
                "can_apply_resignation" => $can_apply_resignation,
                "manager_can_submit_resignation_for_emp" => $manager_can_submit_resignation_for_emp,
                "hr_can_submit_resignation_for_emp" => $hr_can_submit_resignation_for_emp,
                "emp_can_edit_last_working_day" => $emp_can_edit_last_working_day,
                "resignation_auto_approve" => $resignation_auto_approve,
                "resignation_approver_flow" => $resignation_approver_flow,
                "email_reminder_for_resignation" => $email_reminder_for_resignation
            ],
            $rules = [
                'client_id' => 'required',
                //'client_id' => ['required', Rule::in(VmtClientMaster::pluck('id')->toArray())],
                'can_apply_resignation' => ['required', Rule::in([0, 1])],
                'manager_can_submit_resignation_for_emp' => ['required', Rule::in([0, 1])],
                'emp_can_edit_last_working_day' => ['required', Rule::in([0, 1])],
                'resignation_auto_approve' => ['required', Rule::in([0, 1])],
                'resignation_approver_flow' => 'required',
                'email_reminder_for_resignation' => ['required', Rule::in([0, 1])]
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
            foreach ($client_id as $single_client_id) {
                if (ResignationSetting::where('client_id', $client_id)->exists()) {
                    $resignation_setting_query = ResignationSetting::where('client_id', $client_id)->first();
                    $message = 'Resignation Settings Updated Successfully';
                } else {
                    $resignation_setting_query = new ResignationSetting;
                    $message = 'Resignation Settings Saved Successfully';
                }
                $resignation_setting_query->client_id = $single_client_id;
                $resignation_setting_query->emp_can_apply_resignation = $can_apply_resignation;
                $resignation_setting_query->manager_can_submit_resignation_for_emp = $manager_can_submit_resignation_for_emp;
                $resignation_setting_query->hr_can_submit_resignation_for_emp = $hr_can_submit_resignation_for_emp;
                $resignation_setting_query->emp_can_edit_last_working_day = $emp_can_edit_last_working_day;
                $resignation_setting_query->resignation_auto_approve = $resignation_auto_approve;
                $resignation_setting_query->resignation_approver_flow = json_encode($resignation_approver_flow, true);
                $resignation_setting_query->email_reminder_for_resignation = $email_reminder_for_resignation;
                if ($resignation_setting_query->save()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => $message,
                    ]);
                } else {
                    return response()->json([
                        'status' => 'failure',
                        'message' => 'Error While Save Resignation Settings',
                        'error' => 'Error While Save Resignation Settings In Database',
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error While Save Resignation Settings',
                'error' => $e->getMessage(),
                'error_line' => $e->getTraceAsString()
            ]);
        }
    }
    public function employeeResignationDetails($user_code)
    {
        try {
            $user_query = User::where('user_code', $user_code)->first();
            $user_id = $user_query->id;
            $emp_off_details_query = VmtEmployeeOfficeDetails::where('user_id', $user_id)->first();
            $notice_period_days = 0;
            $last_payroll_date = null;
            if (!empty($emp_off_details_query->emp_notice)) {
                $notice_period_days = $emp_off_details_query->emp_notice;
            }
            if ($notice_period_days != 0) {
                $last_working_day = $this->calculateLastWorkingDay($user_code, Carbon::today(), $notice_period_days)->getData()->data;
            } else {
                $last_working_day = null;
            }
            $last_payroll_date_query = VmtPayroll::where('client_id', $user_query->client_id)->orderBy('payroll_date', 'DESC')->first();
            if ($last_payroll_date_query != null) {
                $last_payroll_date = $last_payroll_date_query->payroll_date;
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Employee Resignation Details Fetched Successfully',
                'data' => [
                    'noticed_period_day' => $notice_period_days,
                    'last_working_day' => $last_working_day,
                    'last_payroll_date' => $last_payroll_date
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error While get Employee Resignation Details',
                'error' => $e->getMessage(),
                'error_line' => $e->getTraceAsString()
            ]);
        }
    }

    public function calculateLastWorkingDay($user_code, $date, $notice_period_days)
    {
        try {
            $user_id = User::where('user_code', $user_code)->first()->id;
            $date = $date->addDays($notice_period_days);
            $date_str = $date->format('Y-m-d');
            $weekOffJson = json_decode(VmtEmployeeWorkShifts::join('vmt_work_shifts', 'vmt_work_shifts.id', '=', 'vmt_employee_workshifts.work_shift_id')
                ->where('user_id', $user_id)->first()->week_off_days, true);
            $days_for_per_week = array('Sunday' => 0, 'Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6);
            for ($i = 0; $i < 30; $i++) {
                $given_date_day = $date->format('l');
                $day_in_number = number_format($date->format('d'));
                $date = $date->format('Y-m-d');
                $week_of_month = (int) (ceil($day_in_number / 7));
                $week_of_month_in_string = 'week_' . $week_of_month;
                // dd($days_for_per_week);
                if (
                    $weekOffJson[$days_for_per_week[$given_date_day]]['all_week'] != 1 &&
                    $weekOffJson[$days_for_per_week[$given_date_day]][$week_of_month_in_string] != 1
                ) {
                    if (!(vmtHolidays::where('holiday_date', $date)->exists())) {
                        return response()->json([
                            'status' => 'success',
                            'message' => 'last working day Calculated Successfully',
                            'data' => $date
                        ]);
                    } else {
                        $date = Carbon::parse($date_str)->subDays($i);
                    }
                } else {
                    $date = Carbon::parse($date_str)->subDays($i);
                }

            }
            return response()->json([
                'status' => 'failure',
                'message' => 'calculateLastWorkingDay',
                'error' => 'Error In For Loope Or Holiday And Week off in 30 days'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'calculateLastWorkingDay',
                'error' => $e->getMessage(),
                'error_line' => $e->getTraceAsString()
            ]);
        }
    }
}
