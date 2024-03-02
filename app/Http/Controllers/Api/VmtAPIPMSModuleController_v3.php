<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PMS\VmtPMSModuleService_v3;
use Illuminate\Http\Request;

class VmtAPIPMSModuleController_v3 extends Controller
{

    public function populateNewGoalsAssignScreenUI(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        return $servicesVmtPMSModuleService_v3->populateNewGoalsAssignScreenUI($request->flow_type, $request->user_code);
    }

    public function saveOrUpdateKpiFormDetails(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        // dd( $request->all());
        return $servicesVmtPMSModuleService_v3->saveOrUpdateKpiFormDetails($request->user_code, $request->form_name, $request->form_details,$request->form_id);
    }

    public function getKPIFormsList(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {

        return $servicesVmtPMSModuleService_v3->getKPIFormsList($request->user_code);
    }

    public function getSelectedKPIForm(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {

        return $servicesVmtPMSModuleService_v3->getSelectedKPIForm($request->form_id);
    }

    public function updateFormRowDetails(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        return $servicesVmtPMSModuleService_v3->updateFormRowDetails($request->record_id, $request->json_formrow_details);
    }

    public function deleteFormRowDetails(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        return $servicesVmtPMSModuleService_v3->deleteFormRowDetails($request->record_id);
    }

    public function publishKpiForm(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        return $servicesVmtPMSModuleService_v3->publishKpiform($request->kpi_form_id, $request->assignee_id, $request->reviewer_id, $request->department_id, $request->flow_type, $request->assignment_id);
    }

    public function getSelfAppraisalFormDetails(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        return $servicesVmtPMSModuleService_v3->getSelfAppraisalFormDetails($request->user_code,$request->date);
    }
    public function TeamAppraisalReviewerFlow(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        return $servicesVmtPMSModuleService_v3->TeamAppraisalReviewerFlow($request->user_code,$request->date);
    }
    public function ApproveOrReject(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        return $servicesVmtPMSModuleService_v3->ApproveOrReject($request->user_code, $request->record_id, $request->status, $request->reviewer_comments);
    }

    public function AcceptOrReject(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        return $servicesVmtPMSModuleService_v3->AcceptOrReject($request->user_id, $request->record_id, $request->status, $request->reviewer_comments);
    }
    public function saveAssigneeReview(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        return $servicesVmtPMSModuleService_v3->saveAssigneeReview($request->assignee_user_code, $request->assigned_form_id, $request->assignee_reviews, $request->assignee_is_submitted);
    }

    public function saveReviewsReview(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        // dd($request->all());
        return $servicesVmtPMSModuleService_v3->saveReviewsReview($request->reviewer_user_code, $request->assigned_form_id, $request->reviewer_review, $request->reviewer_is_submitted);
    }

    public function savePmsConfigSetting(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->all());
        return $servicesVmtPMSModuleService_v3->savePmsConfigSetting($request->pms_calendar_settings,
                                                                    $request->pms_basic_settings,
                                                                    $request->pms_dashboard_page,
                                                                    $request->remainder_alert,
                                                                    $request->pms_metrics,
                                                                    $request->goal_settings,
                                                                    $request->score_card,
                                                                    $request->client_id,
                                                                    $request->assignment_id
                                                                );
    }

    public function getPmsConfigSettings(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {

        return $servicesVmtPMSModuleService_v3->getPmsConfigSettings($request->client_code);
    }
    public function getTeamAppraisalDashboardCounters(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {

        return $servicesVmtPMSModuleService_v3->getTeamAppraisalDashboardCounters();
    }



    public function getDashboardCardDetails_SelfAppraisal(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        return $servicesVmtPMSModuleService_v3->getDashboardCardDetails_SelfAppraisal($request->user_code,$request->assignment_setting_id,$request->assinged_record_id);
    }

    public function getAssignedTimelineDetails(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->user_code);
        return $servicesVmtPMSModuleService_v3->getAssignedTimelineDetails($request->assigned_form_id);
    }

    public function pmsSampleKpiFormExcellV3(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
        return $servicesVmtPMSModuleService_v3->pmsSampleKpiFormExcellV3($request->user_code);
    }
    public function withdrawEmployeeAssignedForm(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {

        return $servicesVmtPMSModuleService_v3->withdrawEmployeeAssignedForm($request->record_id);

    }
    public function managerRevokeApprovedOrRejectedAssignedForm(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {

        return $servicesVmtPMSModuleService_v3->managerRevokeApprovedOrRejectedAssignedForm($request->assigned_form_id,$request->type);

    }
    public function getDefaultConfigSetting(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {

        return $servicesVmtPMSModuleService_v3->getDefaultConfigSetting();

    }

    public function pmsformReminders(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {

        return $servicesVmtPMSModuleService_v3->pmsformReminders();

    }
    public function getExistingAssignmentPeriodsList(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {

        return $servicesVmtPMSModuleService_v3->getExistingAssignmentPeriodsList($request->client_code,$request->selected_year);

    }

    public function getAssignedPMSFormsList_selfAppraisal(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {

        return $servicesVmtPMSModuleService_v3->getAssignedPMSFormsList_selfAppraisal($request->user_code,$request->selected_year,$request->assignment_period);

    }

    // public function getAssignedPMSFormsList_TeamAppraisal(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    // {

    //     return $servicesVmtPMSModuleService_v3->getAssignedPMSFormsList_TeamAppraisal($request->client_code,$request->selected_year);

    // }
    public function setEmptyAssigneeReview(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {

        return $servicesVmtPMSModuleService_v3->setEmptyAssigneeReview($request->assigne_id);

    }
    public function getAllAssignmentSettings(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->all());
        return $servicesVmtPMSModuleService_v3->getAllAssignmentSettings($request->client_code,$request->year,$request->month);

    }
    public function getPMSSetting_forGivenAssignmentPeriod(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->assignment_period);
        return $servicesVmtPMSModuleService_v3->getPMSSetting_forGivenAssignmentPeriod($request->assignment_period);

    }
    public function selfAppraisalEditedFormPublish(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->all());
        return $servicesVmtPMSModuleService_v3->selfAppraisalEditedFormPublish($request->assigned_record_id);

    }

    public function getDashboardCardDetails_TeamAppraisal(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->all());
        return $servicesVmtPMSModuleService_v3->getDashboardCardDetails_TeamAppraisal($request->user_code,$request->type);

    }

    public function recordFormFinalKpiScore(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->all());
        return $servicesVmtPMSModuleService_v3->recordFormFinalKpiScore($request->record_id);

    }

    public function getAssignmentPeriodDropdown(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->all());
        return $servicesVmtPMSModuleService_v3->getAssignmentPeriodDropdown($request->user_code,$request->client_id);

    }

    public function PerformanceRatingGraph(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->all());
        return $servicesVmtPMSModuleService_v3->PerformanceRatingGraph($request->user_code,$request->assignment_setting_id,$request->status);

    }
    public function pmsDashboardSelfReviewsScore(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->all());
        return $servicesVmtPMSModuleService_v3->pmsDashboardSelfReviewsScore($request->user_code,$request->assignment_setting_id,$request->status);

    }
    public function pmsDashboardReviewerScore(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->all());
        return $servicesVmtPMSModuleService_v3->pmsDashboardReviewerScore($request->user_code,$request->assignment_setting_id,$request->status);

    }
    public function pmsDashboardQuaterlyScoreCard(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->all());
        return $servicesVmtPMSModuleService_v3->pmsDashboardQuaterlyScoreCard($request->user_code,$request->assignment_setting_id,$request->status);

    }
    public function pmsSelfReviewOnTime(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->all());
        return $servicesVmtPMSModuleService_v3->pmsSelfReviewOnTime($request->user_code,$request->assignment_setting_id);

    }
    public function pmsReviewerReviewOnTime(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->all());
        return $servicesVmtPMSModuleService_v3->pmsReviewerReviewOnTime($request->user_code,$request->assignment_setting_id);

    }

    public function pmsDashboardprocess(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->all());
        return $servicesVmtPMSModuleService_v3->pmsDashboardprocess($request->user_code,$request->assignment_setting_id,$request->status);

    }

    public function pmsDashboardsTendListAssingement_Period(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->all());
        return $servicesVmtPMSModuleService_v3->pmsDashboardsTendListAssingement_Period($request->user_code,$request->assignment_setting_id);

    }
    public function pmsDashboardsTendList(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->all());
        return $servicesVmtPMSModuleService_v3->pmsDashboardsTendList($request->user_code,$request->assignment_id);

    }

    public function orgAppraisalFlow(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->all());
        return $servicesVmtPMSModuleService_v3->orgAppraisalFlow($request->date);

    }
    public function pmsScoreExportReport(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->all());
        return $servicesVmtPMSModuleService_v3->pmsScoreExportReport($request->assignment_setting_id,$request->client_id,$request->type);

    }

    public function pmsFormExcellExport(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->all());
        return $servicesVmtPMSModuleService_v3->pmsFormExcellExport($request->assinged_formid);

    }

    public function pmsMasterReportExcellExport(Request $request, VmtPMSModuleService_v3 $servicesVmtPMSModuleService_v3)
    {
            // dd($request->all());
        return $servicesVmtPMSModuleService_v3->pmsMasterReportExcellExport($request->client_id,$request->assignment_setting_id,$request->type);

    }
}
