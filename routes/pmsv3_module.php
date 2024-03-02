<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VmtAPIPMSModuleController_v3;

Route::group(['prefix' => 'pms'], function () {

Route::post('/populateNewGoalsAssignScreenUI', [VmtAPIPMSModuleController_v3::class, 'populateNewGoalsAssignScreenUI']);
Route::post('/saveOrUpdateKpiFormDetails', [VmtAPIPMSModuleController_v3::class, 'saveOrUpdateKpiFormDetails']);
Route::post('/getKPIFormsList', [VmtAPIPMSModuleController_v3::class, 'getKPIFormsList']);
Route::post('/getSelectedKPIForm', [VmtAPIPMSModuleController_v3::class, 'getSelectedKPIForm']);
Route::post('/updateFormRowDetails', [VmtAPIPMSModuleController_v3::class, 'updateFormRowDetails']);
Route::post('/deleteFormRowDetails', [VmtAPIPMSModuleController_v3::class, 'deleteFormRowDetails']);
Route::post('/publishKpiform', [VmtAPIPMSModuleController_v3::class, 'publishKpiform']);
Route::post('/getSelfAppraisalFormDetails', [VmtAPIPMSModuleController_v3::class, 'getSelfAppraisalFormDetails']);
Route::post('/TeamAppraisalReviewerFlow', [VmtAPIPMSModuleController_v3::class, 'TeamAppraisalReviewerFlow']);
Route::post('/ApproveOrReject', [VmtAPIPMSModuleController_v3::class, 'ApproveOrReject']);
Route::post('/AcceptOrReject', [VmtAPIPMSModuleController_v3::class, 'AcceptOrReject']);
Route::post('/saveAssigneeReview', [VmtAPIPMSModuleController_v3::class, 'saveAssigneeReview']);
Route::post('/saveReviewsReview', [VmtAPIPMSModuleController_v3::class, 'saveReviewsReview']);
Route::post('/savePmsConfigSetting', [VmtAPIPMSModuleController_v3::class, 'savePmsConfigSetting']);
Route::post('/getPmsConfigSettings', [VmtAPIPMSModuleController_v3::class, 'getPmsConfigSettings']);
Route::post('/getDashboardCardDetails_SelfAppraisal', [VmtAPIPMSModuleController_v3::class, 'getDashboardCardDetails_SelfAppraisal']);
Route::post('/getFormTimelineData', [VmtAPIPMSModuleController_v3::class, 'getFormTimelineData']);
Route::post('/SampleKpiFormExcellV3', [VmtAPIPMSModuleController_v3::class, 'pmsSampleKpiFormExcellV3']);
Route::post('/withdrawEmployeeAssignedForm', [VmtAPIPMSModuleController_v3::class, 'withdrawEmployeeAssignedForm']);
Route::post('/managerRevokeApprovedOrRejectedAssignedForm', [VmtAPIPMSModuleController_v3::class, 'managerRevokeApprovedOrRejectedAssignedForm']);
Route::post('/getAssignedTimelineDetails', [VmtAPIPMSModuleController_v3::class, 'getAssignedTimelineDetails']);
Route::post('/getDefaultConfigSetting', [VmtAPIPMSModuleController_v3::class, 'getDefaultConfigSetting']);
Route::post('/getDashboardCardDetails_TeamAppraisal', [VmtAPIPMSModuleController_v3::class, 'getDashboardCardDetails_TeamAppraisal']);
Route::get('/pmsformReminders', [VmtAPIPMSModuleController_v3::class, 'pmsformReminders']);
Route::post('/getExistingAssignmentPeriodsList', [VmtAPIPMSModuleController_v3::class, 'getExistingAssignmentPeriodsList']);
Route::post('/getAssignedPMSFormsList_selfAppraisal', [VmtAPIPMSModuleController_v3::class, 'getAssignedPMSFormsList_selfAppraisal']);
Route::post('/setEmptyAssigneeReview', [VmtAPIPMSModuleController_v3::class, 'setEmptyAssigneeReview']);
Route::post('/getAllAssignmentSettings', [VmtAPIPMSModuleController_v3::class, 'getAllAssignmentSettings']);
Route::post('/getPMSSetting_forGivenAssignmentPeriod', [VmtAPIPMSModuleController_v3::class, 'getPMSSetting_forGivenAssignmentPeriod']);
Route::post('/selfAppraisalEditedFormPublish', [VmtAPIPMSModuleController_v3::class, 'selfAppraisalEditedFormPublish']);
Route::post('/recordFormFinalKpiScore', [VmtAPIPMSModuleController_v3::class, 'recordFormFinalKpiScore']);
Route::post('/getAssignmentPeriodDropdown', [VmtAPIPMSModuleController_v3::class, 'getAssignmentPeriodDropdown']);
Route::post('/PerformanceRatingGraph', [VmtAPIPMSModuleController_v3::class, 'PerformanceRatingGraph']);
Route::post('/pmsDashboardSelfReviewsScore', [VmtAPIPMSModuleController_v3::class, 'pmsDashboardSelfReviewsScore']);
Route::post('/pmsDashboardReviewerScore', [VmtAPIPMSModuleController_v3::class, 'pmsDashboardReviewerScore']);
Route::post('/pmsDashboardQuaterlyScoreCard', [VmtAPIPMSModuleController_v3::class, 'pmsDashboardQuaterlyScoreCard']);
Route::post('/pmsSelfReviewOnTime', [VmtAPIPMSModuleController_v3::class, 'pmsSelfReviewOnTime']);
Route::post('/pmsReviewerReviewOnTime', [VmtAPIPMSModuleController_v3::class, 'pmsReviewerReviewOnTime']);
Route::post('/pmsDashboardprocess', [VmtAPIPMSModuleController_v3::class, 'pmsDashboardprocess']);
Route::post('/pmsDashboardsTendListAssingement_Period', [VmtAPIPMSModuleController_v3::class, 'pmsDashboardsTendListAssingement_Period']);
Route::post('/pmsDashboardsTendList', [VmtAPIPMSModuleController_v3::class, 'pmsDashboardsTendList']);
Route::post('/orgAppraisalFlow', [VmtAPIPMSModuleController_v3::class, 'orgAppraisalFlow']);
Route::post('/pmsScoreExportReport', [VmtAPIPMSModuleController_v3::class, 'pmsScoreExportReport']);
Route::post('/pmsFormExcellExport', [VmtAPIPMSModuleController_v3::class, 'pmsFormExcellExport']);
Route::post('/pmsMasterReportExcellExport', [VmtAPIPMSModuleController_v3::class, 'pmsMasterReportExcellExport']);

});
