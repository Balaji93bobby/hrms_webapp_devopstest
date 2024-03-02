<?php

namespace App\Http\Controllers\PMS;

use App\Http\Controllers\Controller;
use App\Services\PMS\VmtPMSModuleService_v3;
use App\Models\ConfigPms;
use App\Models\User;
use App\Models\VmtConfigPmsV3;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtPMS_KPIFormAssignedModel;
use App\Models\VmtPMS_KPIFormDetailsModel;
use App\Models\VmtPMS_KPIFormModel;
use App\Models\VmtPMS_KPIFormReviewsModel;
use App\Models\VmtPmsKpiFormAssignedV3;
use App\Models\VmtPmsKpiFormDetailsV3;
use App\Models\VmtPmsKpiFormReviewsV3;
use App\Models\VmtPmsKpiFormV3;
use Exception;
use Illuminate\Http\Request;
use App\Services\VmtPMS;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use LDAP\Result;

class VmtPMSModuleController_v3 extends Controller
{
    public function saveKpiFormDetails(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        return $servicesVmtPMSModuleService_v3->saveKpiFormDetails($request->user_id,$request->form_name,$request->form_details);
    }

    public function publishPmsform(Request $request , VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        return $servicesVmtPMSModuleService_v3->publishPmsform($request->kpiformid,$request->assignee_id,$request->reviewer_id,$request->assigner_id,$request->calender_type,$request->year,$request->frequency,$request->assignment_period,$request->department,$request->org_time_period_id);
    }

    public function TeamAppraisalReviewerFlow(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            return $servicesVmtPMSModuleService_v3->TeamAppraisalReviewerFlow();
    }

    public function ApproveOrReject(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        return $servicesVmtPMSModuleService_v3->ApproveOrReject($request->record_id,$request->status,$request->reviewer_comments);
    }

    public function getSelfAppraisalFormDetails(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        return $servicesVmtPMSModuleService_v3->getSelfAppraisalFormDetails($request->user_code);
    }

    public function getCurrentPMSConfig(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        // $flowcheck = 1;
        return $servicesVmtPMSModuleService_v3->getCurrentPMSConfig($request->flowcheck);
    }

    public function getDepartments(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        return $servicesVmtPMSModuleService_v3->getDepartments();
    }

    public function getKPIFormsList(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        return $servicesVmtPMSModuleService_v3->getKPIFormsList($request->user_id);
    }

    public function getSelectedKPIForm(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        return $servicesVmtPMSModuleService_v3->getSelectedKPIForm($request->form_id);
    }

    public function publishSelfAppraisalForm(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        return $servicesVmtPMSModuleService_v3->publishSelfAppraisalForm();
    }

}
