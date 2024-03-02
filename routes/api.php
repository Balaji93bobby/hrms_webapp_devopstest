<?php

use App\Http\Controllers\Api\VmtAPIPMSModuleController_v3;
use App\Http\Controllers\VmtEmployeeOnboardingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HRMSBaseAPIController;
use App\Http\Controllers\Api\VmtAPIPMSModuleController;
use App\Http\Controllers\Api\VmtAPIDashboardController;
use App\Http\Controllers\Api\VmtAPIAttendanceController;
use App\Http\Controllers\Api\VmtAPIPaySlipController;
use App\Http\Controllers\Api\VmtAPIProfilePagesController;
use App\Http\Controllers\Api\VmtAPIInvestmentsController;
use App\Http\Controllers\Api\VmtAPIPayrollTaxController;
use App\Http\Controllers\Api\VmtApiNotificationsController;
use App\Http\Controllers\Api\VmtAPIReimbursementsController;
use App\Http\Controllers\Api\VmtAPILoanAndSalaryAdvanceController;
use App\Http\Controllers\Api\VmtApiOnboardingController;
use App\Http\Controllers\VmtAnnouncementsController;
use App\Imports\VmtEmployee;
use App\Http\Controllers\VmtProfilePagesController;
use App\Http\Controllers\VmtTestingController;
use Illuminate\Support\Facades\Cache;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});


Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::post('/auth/send-passwordresetlink', [AuthController::class, 'sendPasswordResetLink']);
Route::post('/auth/updatePassword', [AuthController::class, 'updatePassword']);
Route::post('/auth/validateAndFetchEmployeeEmail', [AuthController::class, 'validateAndFetchEmployeeEmail']);

Route::post('/clearCache', function () {
  Cache::flush();
  return response()->json(['message' => 'Cache cleared successfully']);
});

Route::post('/auth/requestOtp', [AuthController::class, 'requestOtp'])->name('requestOtp');
Route::post('/auth/verifyOtp', [AuthController::class, 'verifyOtp']);
Route::post('/auth/updatePasswordFromOtp', [AuthController::class, 'updatePasswordFromOtp']);

Route::post('payroll/getPayrollJournalData', [App\Http\Controllers\VmtPayrollController::class, 'getPayrollJournalData'])->name('getPayrollJournalData');
Route::post('payroll/getDefaultPayrollJournalData', [App\Http\Controllers\VmtPayrollController::class, 'getDefaultPayrollJournalData'])->name('getDefaultPayrollJournalData');
Route::post('payroll/saveTallyResponse_onPayrollProcessStatus', [App\Http\Controllers\VmtPayrollController::class, 'saveTallyResponse_onPayrollProcessStatus'])->name('saveTallyResponse_onPayrollProcessStatus');

//core APIs

Route::get('/clients/getAllClients', [ App\Http\Controllers\VmtClientController::class, 'fetchAllClients']);

Route::group(['middleware' => ['auth:sanctum']], function () {

  //CORE
  Route::get('/getAllUsers', [HRMSBaseAPIController::class, 'getAllUsers']);
  Route::get('/getAllBloodgroups', [HRMSBaseAPIController::class, 'getAllBloodgroups']);
  Route::get('/getAllMaritalStatus', [HRMSBaseAPIController::class, 'getAllMaritalStatus']);
  Route::get('/getAllLeaveTypes', [HRMSBaseAPIController::class, 'getAllLeaveTypes']);
  Route::post('/getEmployeeRole', [HRMSBaseAPIController::class, 'getEmployeeRole']);
  Route::post('/getOrgTimePeriod', [HRMSBaseAPIController::class, 'getOrgTimePeriod']);

  Route::get('/getFCMToken', [HRMSBaseAPIController::class, 'getFCMToken']);
  Route::get('/updateFCMToken', [HRMSBaseAPIController::class, 'updateFCMToken']);
  Route::get('/getAppConfig', [HRMSBaseAPIController::class, 'getAppConfig']);
  Route::post('/permissions/getClientMobilePermissionsDetails', [HRMSBaseAPIController::class, 'getClientMobilePermissionsDetails']);
  Route::post('/permissions/getEmployee_MobileModulePermissionsDetails', [HRMSBaseAPIController::class, 'getEmployee_MobileModulePermissionsDetails']);

  Route::post('/get-maindashboard-data', [VmtAPIDashboardController::class, 'getMainDashboardData']);

  //HOLIDAYS
  Route::get('/holidays/getAllHolidays', [HRMSBaseAPIController::class, 'getAllHolidays']);

  // module settings
  Route::post('/getEmployeePermission', [HRMSBaseAPIController::class, 'getEmployeePermission']);
  Route::post('/getAllModuleSettings', [HRMSBaseAPIController::class, 'getAllModuleSettings']);

  //PMS Forms
  Route::post('getAssigneeKPIForms', [VmtAPIPMSModuleController::class, 'getAssigneeKPIForms']);
  Route::post('getKPIFormDetails', [VmtAPIPMSModuleController::class, 'getKPIFormDetails']);
  Route::post('getReviewerKPIForms', [VmtAPIPMSModuleController::class, 'getReviewerKPIForms']);
  Route::get('getAssigneeReviews', 'App\Http\Controllers\Api\VmtAPIPMSModuleController@getAssigneeReviews');
  Route::post('saveAssigneeReviews', 'App\Http\Controllers\Api\VmtAPIPMSModuleController@saveAssigneeReviews');
  Route::get('getReviewerReviews', 'App\Http\Controllers\Api\VmtAPIPMSModuleController@getReviewerReviews');
  Route::post('saveReviewerReviews', 'App\Http\Controllers\Api\VmtAPIPMSModuleController@saveReviewerReviews');

  //Reimbursements
  Route::post('/reimbursements/save_reimbursement_data', [VmtAPIReimbursementsController::class, 'saveReimbursementData']);
  Route::post('/reimbursements/save_reimbursement_claims', [VmtAPIReimbursementsController::class, 'saveReimbursementData_Claims']);
  Route::get('/reimbursements/getReimbursementVehicleTypes', [VmtAPIReimbursementsController::class, 'getReimbursementVehicleTypes']);
  Route::get('/reimbursements/getReimbursementTypes', [VmtAPIReimbursementsController::class, 'getReimbursementTypes']);
  Route::get('/reimbursements/getReimbursementClaimTypes', [App\Http\Controllers\VmtReimbursementController::class, 'getReimbursementClaimTypes'])->name('getReimbursementClaimTypes');

  Route::post('/reimbursements/isReimbursementAppliedOrNot', [VmtAPIReimbursementsController::class, 'isReimbursementAppliedOrNot']);

  ////Attendance

  //Check-in/ Check-out
  Route::post('attendance_checkin', [VmtAPIAttendanceController::class, 'performAttendanceCheckIn']);
  Route::post('attendance_checkout', [VmtAPIAttendanceController::class, 'performAttendanceCheckOut']);
  Route::post('/attendance/get_attendance_status', [VmtAPIAttendanceController::class, 'getAttendanceStatus']);
  Route::post('/attendance/get_last_attendance_status', [VmtAPIAttendanceController::class, 'getLastAttendanceStatus']);
  Route::post('/attendance/getEmployeeWorkShiftTimings', [VmtAPIAttendanceController::class, 'getEmployeeWorkShiftTimings']);

  //Leave
  Route::post('/attendance/apply_leave', [VmtAPIAttendanceController::class, 'applyLeaveRequest']);
  Route::post('/attendance/approveRejectRevoke-att-leave', [VmtAPIAttendanceController::class, 'approveRejectRevokeLeaveRequest']);
  Route::post('/attendance/getData-att-unused-compensatory-days', [VmtAPIAttendanceController::class, 'getUnusedCompensatoryDays']);
  Route::post('/attendance/getEmployeeLeaveBalance', [VmtAPIAttendanceController::class, 'getEmployeeLeaveBalance']);
  Route::post('/attendance/getEmployeeLeaveDetails', [VmtAPIAttendanceController::class, 'getEmployeeLeaveDetails']);
  Route::post('/attendance/getAllEmployeesLeaveDetails', [VmtAPIAttendanceController::class, 'getAllEmployeesLeaveDetails']);
  Route::post('/attendance/getTeamEmployeesLeaveDetails', [VmtAPIAttendanceController::class, 'getTeamEmployeesLeaveDetails']);

  //Attendance Reports
  Route::post('/attendance/monthStatsReport', [VmtAPIAttendanceController::class, 'getAttendanceMonthStatsReport']);
  Route::post('/attendance/dailyReport-PerMonth', [VmtAPIAttendanceController::class, 'getAttendanceDailyReport_PerMonth_v2']);

  //Attendance Regularize
  Route::post('/attendance/apply-att-regularization', [VmtAPIAttendanceController::class, 'applyRequestAttendanceRegularization']);
  Route::post('/attendance/approveReject-att-regularization', [VmtAPIAttendanceController::class, 'approveRejectAttendanceRegularization']);
  Route::post('/attendance/approveReject-absent-regularization', [VmtAPIAttendanceController::class, 'approveRejectAbsentRegularization']);
  Route::post('/attendance/getData-att-regularization', [VmtAPIAttendanceController::class, 'getAttendanceRegularizationData']);
  Route::post('/attendance/getAbsentRegularizationStatus', [VmtAPIAttendanceController::class, 'fetchEmployeeAbsentRegularizationData']);
  Route::post('/attendance/applyRequestAbsentRegularization', [VmtAPIAttendanceController::class, 'applyRequestAbsentRegularization']);
  Route::post('/attendance/countOfAttendanceRegularization', [VmtAPIAttendanceController::class, 'getCountForAttRegularization']);
  Route::post('/attendance/fetchAttendadnceRegularization', [VmtAPIAttendanceController::class, 'getfetchAttendadnceRegularization']);


  //Payslip API
  Route::post('/payroll/payslip/getEmployeePayslipDetails', [VmtAPIPaySlipController::class, 'getEmployeePayslipDetails']);
  Route::post('/payroll/payslip/getEmployeePayslipDetailsAsPDF', [VmtAPIPaySlipController::class, 'getEmployeePayslipDetailsAsPDF']);
  Route::post('/payroll/payslip/getEmployeePayslipDetailsAsHTML', [VmtAPIPaySlipController::class, 'getEmployeePayslipDetailsAsHTML']);
  Route::post('/payroll/payslip/sendEmployeePayslipMail', [VmtAPIPaySlipController::class, 'sendEmployeePayslipMail']);
  Route::post('/payroll/payslip/getEmployeeAllPayslipList', [VmtAPIPaySlipController::class, 'getEmployeeAllPayslipList']);
  Route::post('/payroll/getEmployeeCompensatoryDetails', [VmtAPIPaySlipController::class, 'getEmployeeCompensatoryDetails']);
  Route::post('/payroll/getEmployeeYearlyAndMonthlyCTC', [VmtAPIPaySlipController::class, 'getEmployeeYearlyAndMonthlyCTC']);
  Route::post('/payroll/getMobileEmployeePayslipDetails', [VmtAPIPaySlipController::class, 'getMobileEmployeePayslipDetails']);
  Route::post('/payroll/getEmpMobilePayrollDashboardDetails', [VmtAPIPaySlipController::class, 'getEmpMobilePayrollDashboardDetails']);



  //Profile pages
  Route::post('/profile-pages-getEmpDetails', [VmtAPIProfilePagesController::class, 'fetchEmployeeProfileDetails']);
  Route::post('/profile-pages/getProfilePicture', [VmtAPIProfilePagesController::class, 'getProfilePicture']);
  Route::post('/profile-pages/updateProfilePicture', [VmtAPIProfilePagesController::class, 'updateProfilePicture']);
  Route::post('/profile-pages/deleteProfilePicture', [VmtAPIProfilePagesController::class, 'deleteProfilePicture']);
  Route::post('/profile-pages/updateEmployeeGeneralInformation', [VmtAPIProfilePagesController::class, 'updateEmployeeGeneralInformation']);
  Route::post('/profile-pages/updateEmployeeContactInformation', [VmtAPIProfilePagesController::class, 'updateEmployeeContactInformation']);
  Route::post('/profile-pages/updateEmployeeBankDetails', [VmtAPIProfilePagesController::class, 'updateEmployeeBankDetails']);
  Route::post('/profile-pages/addEmployeeFamilyDetails', [VmtAPIProfilePagesController::class, 'addEmployeeFamilyDetails']);
  Route::post('/profile-pages/updateEmployeeFamilyDetails', [VmtAPIProfilePagesController::class, 'updateEmployeeFamilyDetails']);
  Route::post('/profile-pages/deleteEmployeeFamilyDetails', [VmtAPIProfilePagesController::class, 'deleteEmployeeFamilyDetails']);
  Route::post('/profile-pages/addEmployeeExperianceDetails', [VmtAPIProfilePagesController::class, 'addEmployeeExperianceDetails']);
  Route::post('/profile-pages/updateEmployeeExperianceDetails', [VmtAPIProfilePagesController::class, 'updateEmployeeExperianceDetails']);
  Route::post('/profile-pages/deleteEmployeeExperianceDetails', [VmtAPIProfilePagesController::class, 'deleteEmployeeExperianceDetails']);
  Route::post('/profile-pages/saveDocumentDetails', [VmtProfilePagesController::class, 'saveDocumentDetails']);
  Route::post('/profile-page/uploadEmployeeDetails', [VmtProfilePagesController::class, 'updateEmployeeOfficialDetails']);
  Route::post('/profile-page/updateEmployeeName', [VmtProfilePagesController::class, 'updateEmployeeName']);




  //Investments
  Route::post('/investments/saveSection80', [VmtAPIInvestmentsController::class, 'saveSection80']);
  Route::post('/investments/saveSectionPopups', [VmtAPIInvestmentsController::class, 'saveSectionPopups']);
  Route::post('/investments/SaveInvDetails', [VmtAPIInvestmentsController::class, 'SaveInvDetails']);
  Route::post('/investments/getInvestmentsFormDetailsTemplate', [VmtAPIInvestmentsController::class, 'getInvestmentsFormDetailsTemplate']);
  Route::post('/investments/fetchHousePropertyDetails', [VmtAPIInvestmentsController::class, 'fetchHousePropertyDetails']);
  Route::post('/investments/fetchEmpRentalDetails', [VmtAPIInvestmentsController::class, 'fetchEmpRentalDetails']);
  Route::post('/investments/deleteHousePropertyDetails', [VmtAPIInvestmentsController::class, 'deleteHousePropertyDetails']);


  //TDS
  Route::post('/investments/deleteHousePropertyDetails', [VmtAPIInvestmentsController::class, 'deleteHousePropertyDetails']);
  Route::post('/payroll/getEmployeeTDSWorksheetAsPDF', [VmtAPIPayrollTaxController::class, 'getEmployeeTDSWorksheetAsPDF']);
  Route::post('/payroll/getEmployeeTDSWorksheetAsHTML', [VmtAPIPayrollTaxController::class, 'getEmployeeTDSWorksheetAsHTML']);


  //Notifications
  Route::post('/notifications/getNotifications', [VmtApiNotificationsController::class, 'getNotifications']);
  Route::post('/notifications/saveNotification', [VmtApiNotificationsController::class, 'saveNotification']);
  Route::post('/notifications/updateNotificationReadStatus', [VmtApiNotificationsController::class, 'updateNotificationReadStatus']);

  //Onboarding
  Route::post('/approvals/onboarding/isAllOnboardingDocumentsApproved', [App\Http\Controllers\VmtApprovalsController::class, 'isAllOnboardingDocumentsApproved']);

  Route::post('/onboarding/getEmployeeOnboardingDetails_Mobile', [App\Http\Controllers\Api\VmtApiOnboardingController::class, 'getEmployeeOnboardingDetails_Mobile']);
  Route::post('/onboarding/getEmployeeActiveStatus', [App\Http\Controllers\Api\VmtApiOnboardingController::class, 'getEmployeeActiveStatus']);
  Route::post('/onboarding/getMandatoryDocumentDetails_Mobile', [App\Http\Controllers\Api\VmtApiOnboardingController::class, 'getMandatoryDocumentDetails_Mobile']);
  Route::post('/onboarding/saveEmployeeOnboardingPersonalDetails_Mobile', [App\Http\Controllers\Api\VmtApiOnboardingController::class, 'saveEmployeeOnboardingPersonalDetails_Mobile']);
  Route::post('/onboarding/saveEmployeeOnboardingFamilyDetails_Mobile', [App\Http\Controllers\Api\VmtApiOnboardingController::class, 'saveEmployeeOnboardingFamilyDetails_Mobile']);
  Route::post('/onboarding/saveEmployeeOnboardingAddressDetails_Mobile', [App\Http\Controllers\Api\VmtApiOnboardingController::class, 'saveEmployeeOnboardingAddressDetails_Mobile']);
  Route::post('/onboarding/saveEmployeeOnboardingBankDetails_Mobile', [App\Http\Controllers\Api\VmtApiOnboardingController::class, 'saveEmployeeOnboardingBankDetails_Mobile']);
  Route::post('/onboarding/saveEmployeeOnboardedStatus_Mobile', [App\Http\Controllers\Api\VmtApiOnboardingController::class, 'saveEmployeeOnboardedStatus_Mobile']);
  Route::post('/onboarding/downloadEmployeeCompensatoryDetails_Mobile', [App\Http\Controllers\Api\VmtApiOnboardingController::class, 'downloadEmployeeCompensatoryDetails_Mobile']);

  Route::post('/onboarding/saveEmployeeOnboardingdocumentDetails_Mobile', [App\Http\Controllers\Api\VmtApiOnboardingController::class, 'saveEmployeeOnboardingdocumentDetails_Mobile']);


  //Payroll

  Route::post('/payroll/getCurrentPayrollDates', [App\Http\Controllers\VmtPayrollController::class, 'getCurrentPayrollMonth'])->name('payroll/getCurrentPayrollDates');

  //payroll statutory PT settings
  Route::post('fetchProfessionalTaxSettings', [App\Http\Controllers\VmtPayrollSettingsController::class, 'fetchProfessionalTaxSettings'])->name('fetchProfessionalTaxSettings');
  Route::post('saveProfessionalTaxSettings', [App\Http\Controllers\VmtPayrollSettingsController::class, 'saveProfessionalTaxSettings'])->name('saveProfessionalTaxSettings');
  Route::post('updateProfessionalTaxSettings', [App\Http\Controllers\VmtPayrollSettingsController::class, 'updateProfessionalTaxSettings'])->name('updateProfessionalTaxSettings');

  //payroll statutory LWF settings
  Route::post('fetchlwfSettingsDetails', [App\Http\Controllers\VmtPayrollSettingsController::class, 'fetchlwfSettingsDetails'])->name('fetchlwfSettingsDetails');
  Route::post('savelwfSettings', [App\Http\Controllers\VmtPayrollSettingsController::class, 'savelwfSettings'])->name('savelwfSettings');
  Route::post('updatelwfSettings', [App\Http\Controllers\VmtPayrollSettingsController::class, 'updatelwfSettings'])->name('updatelwfSettings');



  //loanandadvance
  Route::post('/loanandsalaryadvance/getEmpLoanAndSalaryAdvance', [VmtAPILoanAndSalaryAdvanceController::class, 'getEmpLoanAndSalaryAdvance']);
  Route::post('/loanandsalaryadvance/getEmployeeLoanSalaryAdvanceStatsAndEligibilityDetails', [VmtAPILoanAndSalaryAdvanceController::class, 'getEmployeeLoanSalaryAdvanceStatsAndEligibilityDetails']);
  Route::post('/loanandsalaryadvance/getEmployeeLoanAndSalaryAdvanceDetails', [VmtAPILoanAndSalaryAdvanceController::class, 'getEmployeeLoanAndSalaryAdvanceDetails']);
  Route::post('/loanandsalaryadvance/getEligibleSalraryAdvanceDetails', [App\Http\Controllers\Api\VmtAPILoanAndSalaryAdvanceController::class, 'getEligibleSalraryAdvanceDetails']);
  Route::post('/loanandsalaryadavnce/applySalaryAdvance', [App\Http\Controllers\Api\VmtAPILoanAndSalaryAdvanceController::class, 'applySalaryAdvance']);
  Route::post('/loanandsalaryadavnce/loanAndSalaryAdvanceTimeline', [App\Http\Controllers\Api\VmtAPILoanAndSalaryAdvanceController::class, 'loanAndSalaryAdvanceTimeline']);



  Route::post('checkAbsentEmployeeAdminStatus', [App\Http\Controllers\VmtAttendanceController::class, 'checkAbsentEmployeeAdminStatus'])->name('checkAbsentEmployeeAdminStatus');
  Route::post('checkAttendanceEmployeeAdminStatus', [App\Http\Controllers\VmtAttendanceController::class, 'checkAttendanceEmployeeAdminStatus'])->name('checkAttendanceEmployeeAdminStatus');
  Route::post('applyLeaveRequest_AdminRole', [App\Http\Controllers\VmtAttendanceController::class, 'applyLeaveRequest_AdminRole'])->name('applyLeaveRequest_AdminRole');


});

//attendance regularization

Route::post('withdrawAttendanceRegularization', [App\Http\Controllers\VmtAttendanceController::class, 'withdrawAttendanceRegularization']);
Route::post('withdrawAbsentRegularization', [App\Http\Controllers\VmtAttendanceController::class, 'withdrawAbsentRegularization']);

// Announcement

Route::post('createAnnouncementsDetails', [VmtAnnouncementsController::class, 'createAnnouncementsDetails']);
Route::post('getAnnouncementsDetails', [VmtAnnouncementsController::class, 'getAnnouncementsDetails']);


Route::get('/reCalculateConsoliData',[App\Http\Controllers\VmtEmployeeAttendanceController::class,'reCalculateConsoliData']);
//Attendance Reports
Route::post('/fetch-mip-mop-report', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'fetchMIPOrMOPReportData'])->name('fetchMIPOrMOPReportData');
Route::post('/report/download/mip-mop-report', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'downloadMipMopReport'])->name('downloadMipMopReport');
//sandwich reports
  Route::post('/fetchSandwidchReportData', [App\Http\Controllers\VmtEmployeeAttendanceController::class,'fetchSandwidchReportData']);
  Route::post('/saveSandwichSettingsdata', [App\Http\Controllers\VmtAttendanceController::class, 'saveSandwichSettingsdata']);



//Payroll
Route::post('/payroll/getCurrentPayrollDates', [App\Http\Controllers\VmtPayrollController::class, 'getCurrentPayrollMonth']);
Route::post('/payroll/getPayrollOutcomes', [App\Http\Controllers\VmtPayrollController::class, 'getPayrollOutcomes']);
Route::post('/payroll/getOrgPayrollMonths', [App\Http\Controllers\VmtPayrollController::class, 'getOrgPayrollMonths']);

//Runpayroll
//leave
Route::post('/payroll/getAllEmployeesLeaveFilterDetails', [App\Http\Controllers\VmtPayrollController::class, 'getAllEmployeesLeaveFilterDetails']);
//attendance
Route::post('/payroll/getAllEmployeesConsolidatedMonthlyAttendanceDetails', [App\Http\Controllers\VmtPayrollController::class, 'getAllEmployeesConsolidatedMonthlyAttendanceDetails']);
//allclientleavetype
Route::post('/payroll/getclientleavetypes', [App\Http\Controllers\VmtPayrollController::class, 'getclientleavetypes']);
// Route::post('/payroll/getEmployeeLopSummaryDetail', [App\Http\Controllers\VmtPayrollController::class,'getEmployeeLopSummaryDetail']);
//new joinee
Route::post('/payroll/getNewJoineesDetails', [App\Http\Controllers\VmtPayrollController::class, 'getNewJoineesDetails']);
//exit employee
Route::post('/payroll/getExitEmployeeDetails', [App\Http\Controllers\VmtPayrollController::class, 'getExitEmployeeDetails']);
//LOP summary
Route::post('/payroll/getEmployeeLopdetail', [App\Http\Controllers\VmtPayrollController::class, 'getEmployeeLopdetail']);
//LOP revoke
Route::post('/payroll/getEmployeeRevokeLopDetails', [App\Http\Controllers\VmtPayrollController::class, 'getEmployeeRevokeLopDetails']);

Route::post('/payroll/fetchAttendanceReport', [App\Http\Controllers\VmtPayrollController::class, 'fetchAttendanceReport']);

//PAYROLL SETTINGS
Route::get('/payroll/getPayrollSettingsDropdownDetails', [App\Http\Controllers\VmtPayrollSettingsController::class, 'getPayrollSettingsDropdownDetails']);
Route::post('/payroll/saveOrUpdateGenralPayrollSettings', [App\Http\Controllers\VmtPayrollSettingsController::class, 'saveOrUpdateGenralPayrollSettings']);
Route::post('/payroll/getGenralPayrollSettingsDetails', [App\Http\Controllers\VmtPayrollSettingsController::class, 'getGenralPayrollSettingsDetails']);

    //epf & esi settings
    Route::get('/payroll/getPayrollEpfDetails', [App\Http\Controllers\payroll\VmtPayrollComponentsController::class, 'getPayrollEpfDetails']);
    Route::get('/payroll/getNonPfEmployeesDetails', [App\Http\Controllers\payroll\VmtPayrollComponentsController::class, 'getNonPfEmployeesDetails']);
    Route::post('/payroll/saveOrUpdatePayrollEpfDetails', [App\Http\Controllers\payroll\VmtPayrollComponentsController::class, 'saveOrUpdatePayrollEpfDetails']);
    Route::post('/payroll/deleteEpfEmployee', [App\Http\Controllers\payroll\VmtPayrollComponentsController::class, 'deleteEpfEmployee']);
    Route::get('/payroll/getPayrollEsiDetails', [App\Http\Controllers\payroll\VmtPayrollComponentsController::class, 'getPayrollEsiDetails']);
    Route::post('/payroll/saveOrUpdatePayrollEsiDetails', [App\Http\Controllers\payroll\VmtPayrollComponentsController::class, 'saveOrUpdatePayrollEsiDetails']);
    Route::post('/payroll/deleteEsiEmployee', [App\Http\Controllers\payroll\VmtPayrollComponentsController::class, 'deleteEsiEmployee']);

    //ProfessionalTax and lwf Settings
    Route::get('/payroll/fetchProfessionalTaxSettings', [App\Http\Controllers\payroll\VmtPayrollComponentsController::class, 'fetchProfessionalTaxSettings']);
    Route::post('/payroll/saveUpdateProfessionalTaxSettings', [App\Http\Controllers\payroll\VmtPayrollComponentsController::class, 'saveUpdateProfessionalTaxSettings']);
    Route::get('/payroll/fetchlwfSettingsDetails', [App\Http\Controllers\payroll\VmtPayrollComponentsController::class, 'fetchlwfSettingsDetails']);
    Route::post('/payroll/saveUpdatelwfSettings', [App\Http\Controllers\payroll\VmtPayrollComponentsController::class, 'saveUpdatelwfSettings']);

//Paygroup module
Route::get('/payroll/fetchPayRollComponents', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'fetchPayRollComponents']);
Route::post('/payroll/CreatePayRollComponents', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'CreatePayRollComponents']);
Route::post('/payroll/UpdatePayRollEarningsComponents', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'UpdatePayRollEarningsComponents']);
Route::post('/payroll/DeletePayRollComponents', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'DeletePayRollComponents']);
Route::post('/payroll/EnableDisableComponents', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'EnableDisableComponents']);

// Salary Adhoc Components
Route::post('/payroll/AddAdhocAllowanceDetectionComp', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'AddAdhocAllowanceDetectionComp']);
Route::post('/payroll/UpdateAdhocAllowanceDetectionComp', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'UpdateAdhocAllowanceDetectionComp']);

// Salary Reimbursement Components
Route::post('/payroll/AddReimbursementComponents', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'AddReimbursementComponents']);
Route::post('/payroll/UpdateReimbursementComponents', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'UpdateReimbursementComponents']);

// Salary software integration
Route::get('/payroll/fetchPayrollAppIntegrations', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'fetchPayrollAppIntegration']);
Route::post('/payroll/addPayrollAppIntegrations', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'addPayrollAppIntegrations']);
Route::post('/payroll/EnableDisableAppIntegration', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'EnableDisableAppIntegration']);

Route::get('/payroll/fetchPayGroupEmpComponents', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'fetchPayGroupEmpComponents']);
Route::post('/payroll/addPaygroupCompStructure', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'addPaygroupCompStructure']);
Route::post('/payroll/updatePaygroupCompStructure', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'updatePaygroupCompStructure']);

     //salary revision
Route::get('/payroll/saveEmployeesSalaryRevisionDetails', [App\Http\Controllers\VmtSalaryRevisionController::class, 'saveEmployeesSalaryRevisionDetails']);
Route::get('/payroll/getSalaryRevisiedEmplyeeDetails', [App\Http\Controllers\VmtSalaryRevisionController::class, 'getSalaryRevisiedEmplyeeDetails']);
Route::get('/payroll/processEmployeesSalaryRevisionDetails', [App\Http\Controllers\VmtSalaryRevisionController::class, 'processEmployeesSalaryRevisionDetails']);


Route::post('/payroll/assignPaySlipTemplateToClient', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'assignPaySlipTemplateToClient']);
Route::get('/payroll/updateCompensatoryDataToNewtable', [App\Http\Controllers\VmtPayrollController::class, 'updateCompensatoryDataToNewtable']);

//Leave Module
Route::post('/leave/getLeaveNotifyToList', [App\Http\Controllers\VmtAttendanceController::class, 'getLeaveNotifyToList'])->name('getLeaveNotifyToList');

//Exit Module
require __DIR__.'/exit_module.php';


//Payroll External App Integrations
require __DIR__.'/api_app_integrations.php';

//Salary Revision
require __DIR__.'/api_salary_revision.php';

//Onboarding
require __DIR__.'/onboarding_module.php';

// Pms
require __DIR__.'/pmsv3_module.php';

