<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\VmtEmployeeMailNotifMgmtService;
use Illuminate\Http\Request;
/*
    DB Table columns:

    $table->text("welcome_mail_status");
    $table->text("onboard_docs_approval_status");
    $table->text("acc_activation_mail_status");


*/
class VmtEmployeeMailNotifManagementController extends Controller
{

    public function getAllEmployees_WelcomeMailStatus_Details(Request $request,VmtEmployeeMailNotifMgmtService $serviceVmtEmployeeMailNotifMgmtService)
    {
        return $serviceVmtEmployeeMailNotifMgmtService->getAllEmployees_WelcomeMailStatus_Details();
    }

    public function getAllEmployees_AccActivationMailStatus_Details(Request $request)
    {

    }

    public function getAllEmployees_OnboardDocsApprovedMailStatus_Details(Request $request)
    {

    }

    public function send_WelcomeMailNotification(Request $request, VmtEmployeeMailNotifMgmtService $serviceVmtEmployeeMailNotifMgmtService)
    {
        return $serviceVmtEmployeeMailNotifMgmtService->send_WelcomeMailNotification($request->user_code);
    }
    public function send_AccActivationMailNotification(Request $request, VmtEmployeeMailNotifMgmtService $serviceVmtEmployeeMailNotifMgmtService)
    {
        return $serviceVmtEmployeeMailNotifMgmtService->send_AccActivationMailNotification($request->user_code);
    }

    public function send_OnboardDocsApprovedNotification(Request $request)
    {

    }

}
