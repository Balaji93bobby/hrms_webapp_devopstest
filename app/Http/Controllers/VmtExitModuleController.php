<?php

namespace App\Http\Controllers;

use App\Services\VmtCoreService;
use Illuminate\Http\Request;
use App\Services\VmtExitModuleService;
use Carbon\Carbon;

class VmtExitModuleController extends Controller
{

    public function getResignationType(Request $request, VmtExitModuleService $exitModuleService)
    {
        return $exitModuleService->getResignationType();
    }

    public function applyResignation(Request $request, VmtExitModuleService $exitModuleService)
    {
        return $exitModuleService->applyResignation(
            $request->request_date,
            $request->user_id,
            $request->resignation_type_id,
            $request->resignation_reason,
            $request->notice_period_date,
            $request->expected_last_working_day,
            $request->last_payroll_date,
            $request->reason_for_dol_change,
        );
    }

    public function saveResignationSetting(Request $request, VmtExitModuleService $exitModuleService)
    {
        return $exitModuleService->saveResignationSetting(
            $request->client_id,
            $request->can_apply_resignation,
            $request->manager_can_submit_resignation_for_emp,
            $request->hr_can_submit_resignation_for_emp,
            $request->emp_can_edit_last_working_day,
            $request->resignation_auto_approve,
            $request->resignation_approver_flow,
            $request->email_reminder_for_resignation
        );
    }

    public function getClientlistForResignationSettings(Request $request, VmtCoreService $vmtCoreService)
    {
        return $vmtCoreService->getAllClients();
    }

    public function employeeResignationDetails(Request $request, VmtExitModuleService $exitModuleService)
    {
        return $exitModuleService->employeeResignationDetails($request->user_code);
    }

    public function calculateLastWorkingDay(Request $request, VmtExitModuleService $exitModuleService)
    {
        return $exitModuleService->calculateLastWorkingDay($request->user_code, Carbon::today(), $request->notice_period_days);
    }
}
