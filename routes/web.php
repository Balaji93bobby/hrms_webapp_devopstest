<?php

use App\Http\Controllers\PMS\VmtPMSModuleController;
use App\Http\Controllers\Onboarding\VmtEmployeeOnboardingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HRMSBaseAPIController;
use App\Http\Controllers\VmtMainDashboardController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!

*/

Auth::routes();
//Language Translation
//Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::get('/vuejs', function () {
    return view('test_vuejs.app');
});

Route::get('/create-offer', function () {
    return view('offer_letter/Create_OfferLetter.blade.php');
})->name('create-offer');

Route::get('/offer-letter', function () {
    return view('offer_letter/View_OfferLetter');
})->name('offer-letter');


Route::get('/integrations', function () {
    return view('Integrations_Auth');
})->name('integrations');

Route::get('/paycheckDashboard', function () {
    return view('paycheckDashboard');
})->name('paycheckDashboard');


Route::get('/create-holiday', function () {
    return view('createHoliday');
})->name('create-holiday');


Route::get('/testing_praveen', function () {
    return view('testing_praveen');
});


// Route::post('/employee_profile', [App\Http\Controllers\Api\VmtAPIAttendanceController::class, 'employeeProfile'])->name('employeeProfile');
Route::get('/employee_profile', [App\Http\Controllers\VmtAttendanceController::class, 'employeeProfile'])->name('employeeProfile');


Route::middleware(['auth', 'EnsureDefaultPasswordUpdated'])->group(function () {

    //Basic DB data
    Route::get('/db/getBankDetails', [App\Http\Controllers\VmtBankController::class, 'getBankDetails'])->name('vmt_getBankDetails');
    Route::get('/db/getCountryDetails', [App\Http\Controllers\VmtDBDataController::class, 'getCountryDetails'])->name('vmt_getCountryDetails');
    Route::get('/db/getStatesDetails', [App\Http\Controllers\VmtDBDataController::class, 'getStatesDetails'])->name('vmt_getStatesDetails');

    Route::get('/db/getAllEmployees', [App\Http\Controllers\VmtDBDataController::class, 'getAllEmployees']);

    Route::get('/new_main_dashboard', [App\Http\Controllers\VmtMainDashboardController::class, 'showMainDashboardPage'])->name('new-main-dashboard');
    Route::get('/', [App\Http\Controllers\VmtMainDashboardController::class, 'index'])->name('index');
    // Route::get('/old_main_dashboard', [App\Http\Controllers\VmtMainDashboardController::class, 'index'])->name('old-main-dashboard');

    //404 error page
    Route::get('/page-not-found', function () {
        return view('page404');
    })->name('page-not-found');

    //Get current logged-in user
    Route::get('/currentUser', function () {

        return auth()->user()->id;
    });

    //Get current logged-in user name
    Route::get('/currentUserName', function () {

        return auth()->user()->name;
    });


    Route::get('/currentUserCode', function () {

        return auth()->user()->user_code;
    });

    Route::get('/currentUserRole', function () {

        return auth()->user()->org_role;
    });
    Route::get('/currentUseris_ssa', function () {

        return auth()->user()->is_ssa;
    });

    Route::get('/getCurrentSessionClientId', [App\Http\Controllers\VmtMainDashboardController::class, 'getCurrentSessionClientId'])->name('getCurrentSessionClientId');

    Route::get('/getCurrentSessionClientId', [App\Http\Controllers\VmtMainDashboardController::class, 'getCurrentSessionClientId'])->name('getCurrentSessionClientId');
    Route::get('/getClientName', [App\Http\Controllers\VmtMainDashboardController::class, 'getCurrentClientName'])->name('getCurrentClientName');




    //Department
    Route::post('/department-add', [App\Http\Controllers\VmtDepartmentController::class, 'addDepartment'])->name('department-add');
    Route::post('/session-update-globalClient', [App\Http\Controllers\VmtMainDashboardController::class, 'updateGlobalClientSelection'])->name('session-update-globalClient');
    Route::get('/session-sessionselectedclient', [App\Http\Controllers\VmtMainDashboardController::class, 'sessionSelectedClient'])->name('session-sessionselectedclient');
    Route::get('/isEmailExists/{email?}', function ($email) {

        return isEmailExists($email);
    })->name('isEmailExists');

    // Profile Page
    Route::get('/profile-pages/saveDocumentDetails', [App\Http\Controllers\VmtProfilePagesController::class, 'saveDocumentDetails']);
    Route::get('/profile-pages/getDocumentDetails', [App\Http\Controllers\VmtProfilePagesController::class, 'getDocumentDetails']);
    Route::post('/profile-pages/getProfilePicture', [App\Http\Controllers\VmtProfilePagesController::class, 'getProfilePicture']);
    Route::post('/profile-pages/getAdminProfilePicture', [App\Http\Controllers\VmtProfilePagesController::class, 'getAdminProfilePicture']);
    Route::post('/profile-pages/updateProfilePicture', [App\Http\Controllers\VmtProfilePagesController::class, 'updateProfilePicture']);
    Route::post('/profile-pages/updateReportingManager', [App\Http\Controllers\VmtProfilePagesController::class, 'updateReportingManager'])->name('profile-pages-update-reporting-mgr');
    Route::post('/profile-pages/updateDepartment', [App\Http\Controllers\VmtProfilePagesController::class, 'updateDepartment'])->name('profile-pages-updatedepartment');
    Route::post('/profile-pages/getEmployeeDocumentDetails', [App\Http\Controllers\VmtProfilePagesController::class, 'getEmployeeDocumentDetails'])->name('getEmployeeDocumentDetails');
    Route::post('/profile-pages/updateEmployeeDocumentDetails', [App\Http\Controllers\VmtProfilePagesController::class, 'updateEmployeeDocumentDetails'])->name('updateEmployeeDocumentDetails');
    Route::get('getDesignation', [App\Http\Controllers\VmtProfilePagesController::class, 'getDesignation'])->name('getDesignation');

    Route::post('/profile-pages/updateEmployeeDesignation', [App\Http\Controllers\VmtProfilePagesController::class, 'updateEmployeeDesignation'])->name('updateEmployeeDesignation');


    Route::get('/addDepartment/{emp_code?}', function ($emp_code) {

        return isEmpCodeExists($emp_code);
    })->name('isEmpCodeExists');

    Route::controller(VmtEmployeeOnboardingController::class)->group(function () {
        Route::get('/employee-onboarding', 'showNormalOnboardingPage')->name('employee-onboarding');

        //normal onboarding checks
        Route::get('/personal-mail-exists/{mail}', 'isEmployeePersonalEmailAlreadyExists')->name('personal-mail-exists');
        Route::get('/user-code-exists/{user_code}', 'isEmployeeCodeAlreadyExists')->name('user-code-exists');
        Route::get('/aadhar-no-exists/{aadhar_number}', 'isAadharNoAlreadyExists')->name('aadhar-no-exists');
        Route::get('/pan-no-exists/{pan_number}', 'isPanCardAlreadyExists')->name('pan-no-exists');
        Route::get('/mobile-no-exists/{mobile_number}', 'isMobileNoAlreadyExists')->name('mobile-no-exists');
        Route::get('/ac-no-exists/{ac_no}', 'isAcNoAlreadyExists')->name('ac-no-exists');
        Route::get('/getMandatoryDocumentDetails', 'getMandatoryDocumentDetails')->name('getMandatoryDocumentDetails');

        //Fetch quick onboarded emp details
        Route::post('fetch-quickonboarded-emp-details', 'fetchQuickOnboardedEmployeeData')->name('fetch-quickonboarded-emp-details');

        Route::post('/employee-documents-details', 'getEmployeeAllDocumentDetails')->name('employee-documents-details');
        //change client_code on masterconfig
        Route::get('/update-MasterConfig-ClientCode', 'updateMasterConfigClientCode')->name('updateMasterConfigClientCode');
    });




    //Attendance
    Route::get('/attendance-dashboard', [App\Http\Controllers\VmtAttendanceController::class, 'showDashboard'])->name('attendance-dashboard');
    Route::post('/get-attendance-dashboard', [App\Http\Controllers\VmtAttendanceController::class, 'getAttendanceDashboardData_v2'])->name('getAttendanceDashboardData');
    Route::get('/attendance-leave', [App\Http\Controllers\VmtAttendanceController::class, 'showAttendanceLeavePage'])->name('attendance-leave');



    Route::get('/attendance-leavesettings', [App\Http\Controllers\VmtAttendanceController::class, 'showAttendanceLeaveSettings'])->name('attendance-leavesettings');
    Route::get('/attendance-leavereports', [App\Http\Controllers\VmtAttendanceController::class, 'showAttendanceLeaveReportsPage'])->name('attendance-leavereports');


    Route::get('/attendance-timesheet', [App\Http\Controllers\VmtAttendanceController::class, 'showTimesheet'])->name('attendance-timesheet');
    Route::post('/attendance-req-regularization', [App\Http\Controllers\VmtAttendanceController::class, 'applyRequestAttendanceRegularization'])->name('attendance-req-regularization');
    Route::post('/attendance-req-absent-regularization', [App\Http\Controllers\VmtAttendanceController::class, 'applyRequestAbsentRegularization'])->name('attendance-req-absent-regularization');
    Route::post('/approveRejectAbsentRegularization', [App\Http\Controllers\VmtAttendanceController::class, 'approveRejectAbsentRegularization'])->name('approveRejectAbsentRegularization');
    Route::post('/attendance/getAttendanceRegularizationStatus', [App\Http\Controllers\VmtAttendanceController::class, 'getAttendanceRegularizationStatus'])->name('getAttendanceRegularizationStatus');
    Route::post('/fetch-regularization-data', [App\Http\Controllers\VmtAttendanceController::class, 'fetchRegularizationData'])->name('fetch-regularization-data');
    Route::get('/getAttendanceStatus', [App\Http\Controllers\VmtAttendanceController::class, 'getAttendanceStatus'])->name('getAttendanceStatus');

    //Admin Apply Access
    Route::post('checkAbsentEmployeeAdminStatus', [App\Http\Controllers\VmtAttendanceController::class, 'checkAbsentEmployeeAdminStatus'])->name('checkAbsentEmployeeAdminStatus');
    Route::post('checkAttendanceEmployeeAdminStatus', [App\Http\Controllers\VmtAttendanceController::class, 'checkAttendanceEmployeeAdminStatus'])->name('checkAttendanceEmployeeAdminStatus');
    Route::post('/applyLeaveRequest_AdminRole', [App\Http\Controllers\VmtAttendanceController::class, 'applyLeaveRequest_AdminRole'])->name('applyLeaveRequest_AdminRole');
    Route::post('/leave/getLeaveNotifyToList', [App\Http\Controllers\VmtAttendanceController::class, 'getLeaveNotifyToList'])->name('getLeaveNotifyToList');


    Route::get('/reports-pmsforms-page', [App\Http\Controllers\Reports\VmtPMSReportsController::class, 'showPMSFormsDownloadPage'])->name('reports-pmsforms-page');
    Route::get('/fetch-assigned-pmsforms', [App\Http\Controllers\Reports\VmtPMSReportsController::class, 'fetchAllAssignedPMSForms'])->name('fetch-assigned-pmsforms');
    Route::get('/fetchAssignmentPeriodForGivenYear', [App\Http\Controllers\Reports\VmtPMSReportsController::class, 'fetchAssignmentPeriodForGivenYear'])->name('fetchAssignmentPeriodForGivenYear');
    Route::get('/report-download-pmsforms', [App\Http\Controllers\Reports\VmtPMSReportsController::class, 'downloadPMSForm'])->name('downloadPMSForm'); //Leave Balance Calculation
    Route::get('/process-employee-leave-balance', [App\Http\Controllers\VmtEmployeeLeaveController::class, 'processEmployeeLeaveBalance'])->name('processEmployeeLeaveBalance');

    Route::get('/upload/leave-balance', [App\Http\Controllers\VmtEmployeeLeaveController::class, 'showLeaveBalanceUpload']);
    Route::post('/import-leave-balance', [App\Http\Controllers\VmtEmployeeLeaveController::class, 'importLeaveBalanceData']);

    //PMS forms management
    //Route::get('/pms-forms-mgmt/getAssignedPMSFormTemplates', [App\Http\Controllers\PMS\VmtPMSFormsMgmtController::class, 'getAssignedPMSFormTemplates'])->name('getAssignedPMSFormTemplates');
    Route::get('/pms-forms-mgmt/get-PMS-score-averge-for-given-assingement-period', [App\Http\Controllers\PMS\VmtPMSFormsMgmtController::class, 'getPMSScoreAvergeForGivenAssingementPeriod'])->name('getPMSScoreAvergeForGivenAssingementPeriod');
    Route::get('/pms-forms-mgmt/get-employee-PMS-form-template-excel', [App\Http\Controllers\PMS\VmtPMSFormsMgmtController::class, 'getEmployeePMSFormTemplate_AsExcel'])->name('getEmployeePMSFormTemplate_AsExcel');
    Route::get('/pms-forms-mgmt/fetch-PMS-form-details', [App\Http\Controllers\PMS\VmtPMSFormsMgmtController::class, 'fetchPMSFormDetails'])->name('fetchPMSFormDetails');
    //Route::get('/pms-forms-mgmt/get-all-PMS-form-Templates', [App\Http\Controllers\PMS\VmtPMSFormsMgmtController::class, 'getAllPMSFormTemplates'])->name('getAllPMSFormTemplates');
    Route::get('/pms-forms-mgmt/get-all-PMS-form-Authors', [App\Http\Controllers\PMS\VmtPMSFormsMgmtController::class, 'getAllPMSFormAuthors'])->name('getAllPMSFormAuthors');
    Route::post('/pms-forms-mgmt/getPMSFormUsageDetails', [App\Http\Controllers\PMS\VmtPMSFormsMgmtController::class, 'getPMSFormUsageDetails'])->name('getPMSFormUsageDetails');
    Route::post('/pms-forms-mgmt/getPMSFormTemplateDetails', [App\Http\Controllers\PMS\VmtPMSFormsMgmtController::class, 'getPMSFormTemplateDetails'])->name('getPMSFormTemplateDetails');
    // Route::get('/pms-forms-mgmt/self-view', [App\Http\Controllers\PMS\VmtPMSFormsMgmtController::class, 'showPMSFormsMgmtPage_SelfView'])->name('showPMSFormsMgmtPage_SelfView');
    // Route::get('/pms-forms-mgmt/team-view', [App\Http\Controllers\PMS\VmtPMSFormsMgmtController::class, 'showPMSFormsMgmtPage_TeamView'])->name('showPMSFormsMgmtPage_TeamView');
    // Route::get('/pms-forms-mgmt/hr-view', [App\Http\Controllers\PMS\VmtPMSFormsMgmtController::class, 'showPMSFormsMgmtPage_HRView'])->name('showPMSFormsMgmtPage_HRView');
    Route::get('/pms-forms-mgmt', [App\Http\Controllers\PMS\VmtPMSFormsMgmtController::class, 'showPMSFormsMgmtPage'])->name('showPMSFormsMgmtPage');

    //Attendance - AJAX
    Route::post('/fetch-attendance-user-timesheet', [App\Http\Controllers\VmtAttendanceController::class, 'fetchAttendanceDailyReport_PerMonth_v3'])->name('fetchAttendanceDailyReport_PerMonth_v3');
    Route::post('/fetch-team-members', [App\Http\Controllers\VmtAttendanceController::class, 'fetchTeamMembers'])->name('fetch-team-members');
    Route::get('/fetch-org-members', [App\Http\Controllers\VmtAttendanceController::class, 'fetchOrgMembers'])->name('fetch-org-members');
    //Route::get('/fetch-org-leaves-balance', [App\Http\Controllers\VmtAttendanceController::class, 'fetchOrgEmployeesPendingLeaves'])->name('fetch-org-leaves');
    Route::post('/fetch-team-leaves-balance', [App\Http\Controllers\VmtAttendanceController::class, 'fetchTeamEmployeesPendingLeaves'])->name('fetch-team-leaves');
    Route::post('/fetch-org-leaves-balance', [App\Http\Controllers\VmtAttendanceController::class, 'fetchOrgLeaveBalance'])->name('fetchOrgLeaveBalance');
    Route::post('/fetch-team-leave-balance', [App\Http\Controllers\VmtAttendanceController::class, 'fetchTeamLeaveBalance'])->name('fetchTeamLeaveBalance');



    //Leave Balance fetchEmployeeLeaveBalance
    Route::post('/get-employee-leave-balance', [App\Http\Controllers\VmtAttendanceController::class, 'getEmployeeLeaveBalance'])->name('getEmployeeLeaveBalance');
    Route::post('/is_leave_balance_available', [App\Http\Controllers\VmtAttendanceController::class, 'isLeaveBalanceAvailable'])->name('isLeaveBalanceAvailable');

    //upload leave balance

    Route::post('updateEmployeeLeaveBalanceData', [App\Http\Controllers\VmtEmployeeLeaveController::class, 'updateEmployeeLeaveBalanceData'])->name('updateEmployeeLeaveBalanceData');
    Route::get('uploadLeaveBalanceData', [App\Http\Controllers\VmtEmployeeLeaveController::class, 'showEmployeeLeaveBalanceDatapage'])->name('uploadLeaveBalanceData');

    //Leave history pages


    Route::get('/attendance-leave-policydocument', [App\Http\Controllers\VmtAttendanceController::class, 'showLeavePolicyDocument'])->name('attendance-leave-policydocument');
    Route::get('/attendance-leavehistory/{type}', [App\Http\Controllers\VmtAttendanceController::class, 'showLeaveHistoryPage'])->name('attendance-leavehistory');

    Route::get('/attendance-leave-approvals', [App\Http\Controllers\VmtAttendanceController::class, 'showLeaveApprovalPage'])->name('attendance-leave-approvals');
    Route::get('/attendance-admin-timesheet', [App\Http\Controllers\VmtAttendanceController::class, 'showAllEmployeesTimesheetPage'])->name('attendance-admin-timesheet');
    Route::get('/attendance-employee-timesheet', [App\Http\Controllers\VmtAttendanceController::class, 'showEmployeeTimeSheetPage'])->name('attendance-employee-timesheet');
    Route::post('/fetch-leave-policy-details', [App\Http\Controllers\VmtAttendanceController::class, 'fetchLeavePolicyDetails'])->name('vmt-fetch-leave-policy-details');
    Route::get('/fetch-leaverequests-based-on-currentrole', [App\Http\Controllers\VmtAttendanceController::class, 'getLeaveRequestDetailsBasedOnCurrentRole'])->name('fetch-leaverequests-based-on-currentrole');

    //Leave History
    Route::post('/attendance/getEmployeeLeaveDetails', [App\Http\Controllers\VmtAttendanceController::class, 'getEmployeeLeaveDetails'])->name('getEmployeeLeaveDetails');
    Route::post('/attendance/getTeamEmployeesLeaveDetails', [App\Http\Controllers\VmtAttendanceController::class, 'getTeamEmployeesLeaveDetails'])->name('getTeamEmployeesLeaveDetails');
    Route::post('/attendance/getAllEmployeesLeaveDetails', [App\Http\Controllers\VmtAttendanceController::class, 'getAllEmployeesLeaveDetails'])->name('getAllEmployeesLeaveDetails');
    Route::post('/attendance/getLeaveInformation', [App\Http\Controllers\VmtAttendanceController::class, 'getLeaveInformation'])->name('getLeaveInformation');


    Route::get('/get-singleleavepolicy-record/{id}', [App\Http\Controllers\VmtAttendanceController::class, 'fetchSingleLeavePolicyRecord'])->name('get-singleleavepolicy-record');
    Route::post('/set-singleleavepolicy-record', [App\Http\Controllers\VmtAttendanceController::class, 'updateSingleLeavePolicyRecord'])->name('set-singleleavepolicy-record');
    Route::post('/attendance-applyleave', [App\Http\Controllers\VmtAttendanceController::class, 'saveLeaveRequestDetails'])->name('attendance-applyleave');
    Route::post('/applyLeaveRequest', [App\Http\Controllers\VmtAttendanceController::class, 'applyLeaveRequest'])->name('applyLeaveRequest');
    Route::post('/restrictedDaysForLeaveApply',[App\Http\Controllers\VmtAttendanceController::class,'restrictedDaysForLeaveApply'])->name('restrictedDaysForLeaveApply');

    Route::post('/attendance-approve-rejectleave', [App\Http\Controllers\VmtAttendanceController::class, 'approveRejectRevokeLeaveRequest'])->name('processLeaveRequest');
    Route::get('/attendance-leave-getdetails', [App\Http\Controllers\VmtAttendanceController::class, 'fetchLeaveDetails'])->name('attendance-leave-getdetails');
    //Route::get('/fetch-employee-compensatory-days/{user_id}', [App\Http\Controllers\VmtAttendanceController::class, 'fetchEmployeeCompensatoryOffDays'])->name('fetch-employee-compensatory-days');
    Route::get('/fetch-employee-unused-compensatory-days', [App\Http\Controllers\VmtAttendanceController::class, 'fetchUnusedCompensatoryOffDays'])->name('fetch-employee-unused-compensatory-days');

    //Attendance Settings route
    Route::get('/save-work-shift', [App\Http\Controllers\VmtAttendanceSettingsController::class, 'saveWorkShiftSettings'])->name('saveWorkShiftSettings');

    //Ajax For Leave withdraw
    Route::post('/leave/withdrawLeave', [App\Http\Controllers\VmtAttendanceController::class, 'withdrawLeave'])->name('withdrawLeave');

    //Leave Policy
    Route::get('/fetch-holidays', [App\Http\Controllers\VmtLeavePolicyController::class, 'fetchHolidays'])->name('fetch-getHolidays');


    //Att Regularize
    Route::get('/attendance-regularization-approvals', [App\Http\Controllers\VmtAttendanceController::class, 'showRegularizationApprovalPage'])->name('attendance-regularization-approvals');
    Route::post('/attendance-regularization-approvals', [App\Http\Controllers\VmtAttendanceController::class, 'approveRejectAttendanceRegularization'])->name('process-attendance-regularization-approvals');
    Route::post('/fetch-att-regularization-data', [App\Http\Controllers\VmtAttendanceController::class, 'fetchAttendanceRegularizationData'])->name('fetch-regularization-approvals');
    Route::post('/fetch-absent-regularization-data', [App\Http\Controllers\VmtAttendanceController::class, 'fetchAbsentRegularizationData'])->name('fetch-absent-regularization-approvals');
    Route::get('/fetch-onboarded-doc', [App\Services\VmtEmployeeService::class, 'fetchAllEmployeesDocumentsAsGroups'])->name('fetch-onboarded-doc');

    //Update User Details

    Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');
    Route::post('/store-personal-info/{id}', [App\Http\Controllers\HomeController::class, 'storePersonalInfo'])->name('updatePersonalInformation');
    Route::post('/store-profile-image/{id}', [App\Http\Controllers\HomeController::class, 'storeProfileImage'])->name('storeProfileImage');
    Route::post('/update-bank-info/{id}', [App\Http\Controllers\HomeController::class, 'updateBankInfo'])->name('updateBankInfo');
    Route::post('/update-personal-info/{id}', [App\Http\Controllers\HomeController::class, 'updatePersonalInfo'])->name('updatePersonalInfo');
    Route::post('/update-leave-info/{id}', [App\Http\Controllers\HomeController::class, 'updateLeaveInfo'])->name('updateLeaveInfo');
    Route::post('/update-experience-info/{id}', [App\Http\Controllers\HomeController::class, 'updateExperienceInfo'])->name('updateExperienceInfo');
    Route::post('/update-emergency-info/{id}', [App\Http\Controllers\HomeController::class, 'updateEmergencyInfo'])->name('updateEmergencyInfo');
    Route::post('/update-family-info/{id}', [App\Http\Controllers\HomeController::class, 'updateFamilyInfo'])->name('updateFamilyInfo');
    Route::post('/update-checkin', [App\Http\Controllers\HomeController::class, 'updateCheckin'])->name('updateCheckin');
    Route::get('/attendance/isAlreadyCheckedIn', [App\Http\Controllers\HomeController::class, 'isAlreadyCheckedIn'])->name('isAlreadyCheckedIn');
    Route::get('/topbar-settings', [App\Http\Controllers\HomeController::class, 'vmt_topbar_settings'])->name('vmt_topbar_settings');

    //new profile page
    Route::get('/pages-profile-new', [App\Http\Controllers\VmtProfilePagesController::class, 'showProfilePage'])->name('pages-profile-new');
    Route::post('/profile-pages-update-generalinfo/{id}', [App\Http\Controllers\VmtProfilePagesController::class, 'updateGeneralInfo'])->name('updateGeneralInfo');
    Route::post('/profile-pages-update-contactinfo/{id}', [App\Http\Controllers\VmtProfilePagesController::class, 'updateContactInfo'])->name('updateContactInfo');
    Route::post('/profile-pages-update-address_info/{id}', [App\Http\Controllers\VmtProfilePagesController::class, 'updateAddressInfo'])->name('addressInfo');
    Route::post('/add-family-info/{id}', [App\Http\Controllers\VmtProfilePagesController::class, 'addFamilyInfo'])->name('addFamilyInfo');
    Route::post('/update-family-info/{id}', [App\Http\Controllers\VmtProfilePagesController::class, 'updateFamilyInfo'])->name('updateFamilyInfo');
    Route::post('/delete-family-info/{id}', [App\Http\Controllers\VmtProfilePagesController::class, 'deleteFamilyInfo'])->name('deleteFamilyInfo');
    Route::post('/add-experience-info/{id}', [App\Http\Controllers\VmtProfilePagesController::class, 'addExperienceInfo'])->name('addExperienceInfo');
    Route::post('/update-experience-info/{id}', [App\Http\Controllers\VmtProfilePagesController::class, 'updateExperienceInfo'])->name('updateExperienceInfo');
    Route::post('/delete-experience-info/{id}', [App\Http\Controllers\VmtProfilePagesController::class, 'deleteExperienceInfo'])->name('deleteExperienceInfo');
    Route::post('/update-bank-info/{id}', [App\Http\Controllers\VmtProfilePagesController::class, 'updatetempBankInfo'])->name('updatetempBankInfo');
    Route::post('/update-Pancard-info/{id}', [App\Http\Controllers\VmtProfilePagesController::class, 'updatetempPancardInfo'])->name('updatetempPancardInfo');
    Route::post('/update-EmplpoyeeName-info/{id}', [App\Http\Controllers\VmtProfilePagesController::class, 'updatetempEmployeeName'])->name('updatetempEmployeeName');
    Route::post('/update-statutory-info/{id}', [App\Http\Controllers\VmtProfilePagesController::class, 'updateStatutoryInfo'])->name('updateStatutoryInfo');
    Route::post('/store-personal-info/{id}', [App\Http\Controllers\VmtProfilePagesController::class, 'storePersonalInfo'])->name('updatePersonalInformation');
    Route::get('/profile-page/employee_payslip/{user_id?}', [App\Http\Controllers\VmtProfilePagesController::class, 'showPaySlip_HTMLView'])->name('vmt_employee_payslip_htmlview');
    Route::get('/profile-page/pdfview/{emp_code?}/{selectedPaySlipMonth?}', [App\Http\Controllers\VmtProfilePagesController::class, 'showPaySlip_PDFView'])->name('vmt_employee_payslip_pdf');
    Route::post('/profile-page/uploadEmployeeDocs', [App\Http\Controllers\VmtProfilePagesController::class, 'uploadEmployeeDocument'])->name('uploadEmployeeDocument');
    Route::post('/profile-page/uploadEmployeeDetails', [App\Http\Controllers\VmtProfilePagesController::class, 'updateEmployeeOfficialDetails'])->name('updateEmployeeOfficialDetails');
    Route::post('/profile-page/getEmployeeApprovedDocumentsFile', [App\Http\Controllers\VmtProfilePagesController::class, 'getEmployeeApprovedDocumentsFile'])->name('getEmployeeApprovedDocumentsFile');

    //save profile page documents
    Route::post('/profile-page/saveEmployeeDocument', [App\Http\Controllers\VmtProfilePagesController::class, 'saveEmployeeDocument'])->name('saveEmployeeDocument');
    //save profile page documents


    Route::get('pages-profile', [App\Http\Controllers\HomeController::class, 'showProfile'])->name('pages-profile');

    Route::get('/testing-file-upload', [App\Http\Controllers\VmtTestingController::class, 'viewpdf'])->name('viewpdf');

    Route::post('/fileUploadingTest', [App\Http\Controllers\VmtTestingController::class, 'fileUploadingTest'])->name('fileUploadingTest');

    Route::get('/retrive-files', [App\Http\Controllers\VmtTestingController::class, 'retriveFiles'])->name('retriveFiles');
    Route::get('/testSendBulkMail', [App\Http\Controllers\VmtTestingController::class, 'testSendBulkMail'])->name('testSendBulkMail');
    Route::get('/testSendHTMLEmail', [App\Http\Controllers\VmtTestingController::class, 'sendHTMLEmail'])->name('sendHTMLEmail');
    Route::get('/test_getTeamEmployeesLeaveDetails', [App\Http\Controllers\VmtTestingController::class, 'test_getTeamEmployeesLeaveDetails'])->name('test_getTeamEmployeesLeaveDetails');
    Route::get('/LeaveBalanceReport',[App\http\Controllers\VmtTestingController::class,'LeaveBalanceReport'])->name('LeaveBalanceReport');


    // Route::get('email-test', function () {

    //     $details['email'] = 'sheltonfdo23@gmail.com';

    //     dispatch(new App\Jobs\SendEmailJob($details));

    //     dd('done');
    // });

    //update user details with proof

    Route::get('/fetch-proof-doc', [App\Services\VmtEmployeeService::class, 'fetchAllEmployeesDocumentsProof'])->name('fetch-proof-doc');
    Route::Post('/approvals/EmployeeProof-docs-approve-reject', [App\Http\Controllers\VmtProfilePagesController::class, 'SingleDocumentProofApproval'])->name('SingleDocumentProofApproval');
    Route::post('/approvals/EmployeeProof-bulkdocs-approve-reject', [App\Http\Controllers\VmtProfilePagesController::class, 'BulkDocumentProofApprovals'])->name('BulkDocumentProofApprovals');
    Route::post('view/getEmpProfileProofPrivateDoc', [App\Http\Controllers\VmtProfilePagesController::class, 'getEmpProfileProofPrivateDoc'])->name('getEmpProfileProofPrivateDoc');


    // notifications
    Route::get('/notifications/{id}', [App\Http\Controllers\HomeController::class, 'delete'])->name('delete');

    //notifications
    Route::post('/poll-voting', [App\Http\Controllers\HomeController::class, 'poll_voting'])->name('poll_voting');
    Route::post('/signin', [App\Http\Controllers\HomeController::class, 'signin'])->name('signin');

    Route::get('/showDocumentPayslip', [App\Http\Controllers\HomeController::class, 'showDocumentPayslip'])->name('showDocumentPayslip');




    Route::get('/registerNewAccount', function () {
        return view('/auth/register');
    })->name('registerNewAccount');


    // Route::get('pages-profile-settings', [App\Http\Controllers\HomeController::class, 'showProfilePage'])->name('pages-profile-settings');

    Route::get('test-email', 'App\Http\Controllers\HomeController@testEmail');


    // General Settings
    Route::get('vmt-general-settings', [App\Http\Controllers\HomeController::class, 'generalSettings']);
    Route::post('vmt-general-settings', [App\Http\Controllers\HomeController::class, 'storeGeneralSettings']);


    // Route::get('/vendor', function () {
    //     return view('vmt_vendor');
    // })->name('vmt-vendor-route');

    Route::get('/vendor', function () {
        return view('vmt_vendor');
    })->name('vmt-vendor-route');

    Route::get('/view-offer', function () {
        return view('offer_letter.View_OfferLetter');
    })->name('view-offer');

    Route::get('/create-offer', function () {
        return view('offer_letter.create_offerletter');
    })->name('create-offer');

    Route::get('clients', 'App\Http\Controllers\VmtClientController@showAllClients')->name('vmt-clients-route');

    Route::post('/clients-fetchAll', 'App\Http\Controllers\VmtClientController@fetchAllClients')->name('vmt-clients-fetchall');
    Route::post('/getABSClientCode', [App\Http\Controllers\VmtClientController::class, 'getABSClientCode'])->name('getABSClientCode');

    // Permission Roles Routing
    Route::get('/roles_permissions', [App\Http\Controllers\RolesPermissions\VmtRolesPermissionsController::class, 'showRolesPermissionsPage'])->name('showRolesPermissionsPage');
    Route::get('/getAllRoles', [App\Http\Controllers\RolesPermissions\VmtRolesPermissionsController::class, 'getAllRoles'])->name('getAllRoles');
    Route::get('/getAllPermissions', [App\Http\Controllers\RolesPermissions\VmtRolesPermissionsController::class, 'getAllPermissions'])->name('getAllPermissions');
    Route::get('/getAssignedUsers_ForGivenRole', [App\Http\Controllers\RolesPermissions\VmtRolesPermissionsController::class, 'getAssignedUsers_ForGivenRole'])->name('getAssignedUsers_ForGivenRole');
    Route::get('/createRole', [App\Http\Controllers\RolesPermissions\VmtRolesPermissionsController::class, 'createRole'])->name('createRole');
    Route::get('/getRoleDetails', [App\Http\Controllers\RolesPermissions\VmtRolesPermissionsController::class, 'getRoleDetails'])->name('getRoleDetails');
    Route::get('/updateRoleDetails', [App\Http\Controllers\RolesPermissions\VmtRolesPermissionsController::class, 'updateRoleDetails'])->name('updateRoleDetails');
    Route::get('/deleteRole', [App\Http\Controllers\RolesPermissions\VmtRolesPermissionsController::class, 'deleteRole'])->name('deleteRole');
    Route::get('/createPermission', [App\Http\Controllers\RolesPermissions\VmtRolesPermissionsController::class, 'createPermission'])->name('createPermission');
    Route::get('/assignRoleToUsers', [App\Http\Controllers\RolesPermissions\VmtRolesPermissionsController::class, 'assignRoleToUsers'])->name('assignRoleToUsers');
    Route::get('/removeRoleToUsers', [App\Http\Controllers\RolesPermissions\VmtRolesPermissionsController::class, 'removeRoleToUsers'])->name('removeRoleToUsers');
    Route::get('/getPermissionDetails', [App\Http\Controllers\RolesPermissions\VmtRolesPermissionsController::class, 'getPermissionDetails'])->name('getPermissionDetails');


    //360 Review Module Routing
    Route::get('vmt-360-questions', 'App\Http\Controllers\Review360ModuleController@showQuestionsPage');
    Route::get('vmt-360-questions/create', 'App\Http\Controllers\Review360ModuleController@showQuestionForm');
    Route::get('vmt-360-questions/{id}', 'App\Http\Controllers\Review360ModuleController@showFormsEdit');
    Route::post('vmt-360-questions/delete', 'App\Http\Controllers\Review360ModuleController@deleteQuestion');
    Route::post('vmt-360-questions/store', 'App\Http\Controllers\Review360ModuleController@saveReviewQuestios');

    // dashboard post task
    Route::post('vmt-dashboard-post', 'App\Http\Controllers\VmtMainDashboardController@DashBoardPost');
    Route::post('vmt-dashboard-announcement', 'App\Http\Controllers\VmtMainDashboardController@DashBoardAnnouncement');
    Route::post('vmt-dashboard-polling-question', 'App\Http\Controllers\VmtMainDashboardController@DashBoardPollingQuestions');
    Route::post('vmt-dashboard-praise', 'App\Http\Controllers\VmtMainDashboardController@DashBoardPraise');

    Route::get('vmt-dashboard-post-view/{id}', 'App\Http\Controllers\VmtMainDashboardController@DashBoardPostView');


    // 360 Module Form : CRUD
    Route::get('vmt-360-forms', 'App\Http\Controllers\Review360ModuleController@showFormIndex');
    Route::get('vmt-360-forms/create', 'App\Http\Controllers\Review360ModuleController@showFormsPage');
    Route::post('vmt-360-forms', 'App\Http\Controllers\Review360ModuleController@storeOrUpdateForms');
    Route::get('vmt-360-forms/{id}', 'App\Http\Controllers\Review360ModuleController@editReviewForm');

    Route::get('vmt-360-forms/{id}/view-form', 'App\Http\Controllers\Review360ModuleController@viewForm');

    Route::get('vmt-360-forms/{id}/assign-to-user', 'App\Http\Controllers\Review360ModuleController@assignToUser');

    Route::get('vmt-360-forms/{id}/remove-assigned-user', 'App\Http\Controllers\Review360ModuleController@unassignView');

    Route::post('vmt-360-forms/{id}/remove-assigned-user', 'App\Http\Controllers\Review360ModuleController@unassignUserStore');

    Route::post('vmt-360-forms/{id}/assign-to-user', 'App\Http\Controllers\Review360ModuleController@assignForm');

    Route::post('vmt-360-forms/delete', 'App\Http\Controllers\Review360ModuleController@deleteReviewForm');

    Route::get('vmt_360review', 'App\Http\Controllers\Review360ModuleController@viewAssignUserForm');

    ////Employee Hierarchy routes
    Route::get('employee-hierarchy', 'App\Http\Controllers\VmtOrgTreeController@index')->name('showOrgTree');

    //AJAX parts
    Route::get('employee-hierarchy/root-node', 'App\Http\Controllers\VmtOrgTreeController@getLogoLevelOrgTree')->name('getLogoLevelOrgTree');

    Route::get('employee-hierarchy/{user_code}', 'App\Http\Controllers\VmtOrgTreeController@getTwoLevelOrgTree')->name('getTwoLevelOrgTree');
    Route::get('employee-hierarchy/getParentForUser/{user_code}', 'App\Http\Controllers\VmtOrgTreeController@getParentForUser')->name('getParentForUser');
    Route::get('employee-hierarchy/getChildrenForUser/{user_code}', 'App\Http\Controllers\VmtOrgTreeController@getChildrenForUser')->name('getChildrenForUser');
    Route::get('employee-hierarchy/getSiblingsForUser/{user_code}', 'App\Http\Controllers\VmtOrgTreeController@getSiblingsForUser')->name('getSiblingsForUser');

    //Fetch Mangaers Names
    Route::get('fetch-managers-name', [App\Http\Controllers\VmtEmployeeController::class, 'fetchManagerName'])->name('fetch-managers-name');

    Route::get('/fetch-departments', [App\Http\Controllers\VmtEmployeeController::class, 'fetchDepartmentDetails'])->name('fetch-departments');
    Route::get('/fetch-location', [App\Http\Controllers\VmtEmployeeController::class, 'fetchLocationDetails'])->name('fetch-loaction');
    Route::get('/fetch-marital-details', [App\Http\Controllers\VmtEmployeeController::class, 'fetchMaritalStatus'])->name('fetch-marital-details');
    Route::get('/fetch-blood-groups', [App\Http\Controllers\VmtEmployeeController::class, 'fetchBloodGroups'])->name('fetch-blood-groups');
    Route::get('/get-all-employees', [App\Http\Controllers\VmtEmployeeController::class, 'getAllEmployees'])->name('get-all-employees');
    Route::get('/get-current-employee', [App\Http\Controllers\VmtEmployeeController::class, 'getCurrentEmployeeDetails'])->name('getCurrentEmployeeDetails');
    Route::get('/get-client-code', [App\Http\Controllers\VmtEmployeeController::class, 'fetchclientcode'])->name('get-client-code');

    // store employee
    Route::post('vmt-employee-store', 'App\Http\Controllers\VmtEmployeeController@storeEmployeeData');

    Route::post('/vmt-employee-onboard', 'App\Http\Controllers\Onboarding\VmtEmployeeOnboardingController@processEmployeeOnboardForm_Normal');
    Route::post('/quicktesting', [App\Http\Controllers\VmtOnboardingTestingController::class, 'storeBulkOnboardEmployees']);

    Route::get('bulkEmployeeOnboarding', [App\Http\Controllers\Onboarding\VmtEmployeeOnboardingController::class, 'showBulkOnboardUploadPage'])->name('bulkEmployeeOnboarding');
    Route::post('vmt-employess/bulk-upload', 'App\Http\Controllers\Onboarding\VmtEmployeeOnboardingController@importBulkOnboardEmployeesExcelData');
    //onboarding data version2

    Route::post('/onboarding/storeQuickOnboardEmployees', [App\Http\Controllers\Onboarding\VmtEmployeeOnboardingController::class, 'storeQuickOnboardEmployees'])->name('storeQuickOnboardEmployees');
    Route::post('/onboarding/storeBulkOnboardEmployees', [App\Http\Controllers\Onboarding\VmtEmployeeOnboardingController::class, 'storeBulkOnboardEmployees'])->name('storeBulkOnboardEmployees');

    // onboarding data

    Route::get('/onboarding/getEmployeeMandatoryDetails', [App\Http\Controllers\Onboarding\VmtEmployeeOnboardingController::class, 'getEmployeeMandatoryDetails'])->name('getEmployeeMandatoryDetails');

    // Bulk upload employees for quick Onboarding
    Route::get('quickEmployeeOnboarding', 'App\Http\Controllers\Onboarding\VmtEmployeeOnboardingController@showQuickOnboardUploadPage')->name('quickEmployeeOnboarding');
    Route::post('vmt-employess/quick-onboarding/upload', 'App\Http\Controllers\Onboarding\VmtEmployeeOnboardingController@importQuickOnboardEmployeesExcelData');

    //Route::get('vmt-employee/complete-onboarding', 'App\Http\Controllers\VmtEmployeeOnboardingController@showEmployeeOnboardingPage');
    Route::post('vmt-employee/complete-onboarding', 'App\Http\Controllers\VmtEmployeeController@storeQuickOnboardForm');

    //upload Financial components
    Route::post('vmt-Fin-Components/upload', [App\Http\Controllers\VmtImportPayrollComponentsController::class, 'storeBulkFinComponentsPayslips'])->name('Fin-Components/upload');
    Route::post('saveComponentsUploadPage', [App\Http\Controllers\VmtImportPayrollComponentsController::class, 'storeBulkFinComponentsPayslips'])->name('storeBulkFinComponentsPayslips');

    //Payroll generalSettings
    Route::post('get-genral-payroll-settings', [App\Http\Controllers\VmtPayrollSettingsController::class, 'getGenralPayrollSettingsDetails'])->name('getGenralPayrollSettingsDetails');
    Route::post('save-genral-payroll-settings', [App\Http\Controllers\VmtPayrollSettingsController::class, 'saveOrUpdateGenralPayrollSettings'])->name('saveGenralPayrollSettings');
    Route::post('updateGenralPayrollSettings', [App\Http\Controllers\VmtPayrollSettingsController::class, 'updateGenralPayrollSettings'])->name('updateGenralPayrollSettings');
    Route::post('saveAttendanceCutoffData', [App\Http\Controllers\VmtPayrollSettingsController::class, 'saveAttendanceCutoffData'])->name('saveAttendanceCutoffData');
    Route::get('getAttendanceDatadropdown', [App\Http\Controllers\VmtPayrollSettingsController::class, 'getAttendanceDatadropdown'])->name('getAttendanceDatadropdown');

    //payroll investments declaration && proof  settings
    Route::post('savePayrollFinanceSettings', [App\Http\Controllers\VmtPayrollSettingsController::class, 'savePayrollFinanceSettings'])->name('savePayrollFinanceSettings');
    Route::post('savePayrollFinanceSettings', [App\Http\Controllers\VmtPayrollSettingsController::class, 'savePayrollFinanceSettings'])->name('savePayrollFinanceSettings');
    Route::get('getFinDropdownListDetails', [App\Http\Controllers\VmtPayrollSettingsController::class, 'getFinDropdownListDetails'])->name('getFinDropdownListDetails');

    //payroll statutory PT settings
    Route::post('fetchProfessionalTaxSettings', [App\Http\Controllers\VmtPayrollSettingsController::class, 'fetchProfessionalTaxSettings'])->name('fetchProfessionalTaxSettings');
    Route::post('saveProfessionalTaxSettings', [App\Http\Controllers\VmtPayrollSettingsController::class, 'saveProfessionalTaxSettings'])->name('saveProfessionalTaxSettings');
    Route::post('updateProfessionalTaxSettings', [App\Http\Controllers\VmtPayrollSettingsController::class, 'updateProfessionalTaxSettings'])->name('updateProfessionalTaxSettings');

    //payroll statutory LWF settings
    Route::post('fetchlwfSettingsDetails', [App\Http\Controllers\VmtPayrollSettingsController::class, 'fetchlwfSettingsDetails'])->name('fetchlwfSettingsDetails');
    Route::post('savelwfSettings', [App\Http\Controllers\VmtPayrollSettingsController::class, 'savelwfSettings'])->name('savelwfSettings');
    Route::post('updatelwfSettings', [App\Http\Controllers\VmtPayrollSettingsController::class, 'updatelwfSettings'])->name('updatelwfSettings');

    //get payroll dropdown data

    Route::get('getDropdownListDetails', [App\Http\Controllers\VmtPayrollSettingsController::class, 'getDropdownListDetails'])->name('getDropdownListDetails');
    //Get Attendance For run payroll
    Route::post('/fetch-attendance-data', [App\Http\Controllers\VmtPayRunController::class, 'fetch_attendance_data'])->name('fetch-attendance-data');


    Route::get('manageEmployees', 'App\Http\Controllers\VmtEmployeeController@showManageEmployeePage')->name('manageEmployees');
    Route::get('showManageEmployeePage_v2', 'App\Http\Controllers\VmtEmployeeController@showManageEmployeePage_v2')->name('showManageEmployeePage_v2');
    Route::get('vmt-activeemployees-fetchall', 'App\Http\Controllers\VmtEmployeeController@fetchAllActiveEmployees')->name('vmt-activeemployees-fetchall');
    Route::get('vmt-exitemployees-fetchall', 'App\Http\Controllers\VmtEmployeeController@fetchAllExitEmployees')->name('vmt-exitemployees-fetchall');
    Route::get('vmt-yet-to-activeemployees-fetchall', 'App\Http\Controllers\VmtEmployeeController@fetchAllYetToActiveEmployees')->name('vmt-yet-to-activeemployees-fetchall');

    Route::post('vmt-kpi/data', 'App\Http\Controllers\VmtEmployeeController@showKpiData')->name('kpi-data');
    Route::post('vmt-employess/status', 'App\Http\Controllers\VmtEmployeeController@updateUserAccountStatus')->name('updateUserAccountStatus');

    //payrolltax calculation

    Route::post('/paycheck/getEmployeeTDSWorksheetAsPDF', [App\Http\Controllers\VmtPayrollTaxController::class, 'getEmployeeTDSWorksheetAsPDF']);
    Route::post('/paycheck/getEmployeeTDSWorksheetAsHTML', [App\Http\Controllers\VmtPayrollTaxController::class, 'getEmployeeTDSWorksheetAsHTML']);

    Route::get('annualProjection', [App\Http\Controllers\VmtPayrollTaxController::class, 'annualProjection']);

    Route::get('downloadInvestmentReport', [App\Http\Controllers\VmtPayrollTaxController::class, 'downloadInvestmentReport']);

    Route::get('downloadInvestReport', [App\Http\Controllers\VmtPayrollTaxController::class, 'downloadInvestReport']);

    Route::get('downloadAnnaulProjectionReport', [App\Http\Controllers\VmtPayrollTaxController::class, 'annaulProjectionReport']);

    Route::get('oldregime', [App\Http\Controllers\VmtPayrollTaxController::class, 'oldRegimeTaxReportCalculation']);



    //Asset Inventory
    Route::get('assetinventory-index', 'App\Http\Controllers\VmtAssetInventoryController@index')->name('assetinventory-index');

    // asset investory bulk upload starts
    Route::get('vmt-assetinventory-bulk-upload', 'App\Http\Controllers\VmtAssetInventoryController@bulkUploadAsset')->name('vmt-assetinventory-bulk-upload');
    Route::post('vmt-assetinventory-bulk-upload', 'App\Http\Controllers\VmtAssetInventoryController@storeBulkUploadAsset')->name('vmt-assetinventory-bulk-upload-post');
    // asset investory bulk upload ends

    Route::post('vmt-assetinventory-add', 'App\Http\Controllers\VmtAssetInventoryController@addAsset')->name('vmt-assetinventory-add');
    Route::get('vmt-assetinventory-fetch/{id}', 'App\Http\Controllers\VmtAssetInventoryController@fetchAsset')->name('vmt-assetinventory-fetch');
    Route::get('vmt-assetinventory-fetchAll', 'App\Http\Controllers\VmtAssetInventoryController@fetchAll')->name('vmt-assetinventory-fetchall');
    Route::post('vmt-assetinventory-edit', 'App\Http\Controllers\VmtAssetInventoryController@updateAsset')->name('vmt-assetinventory-edit');
    Route::post('vmt-assetinventory-delete', 'App\Http\Controllers\VmtAssetInventoryController@deleteAsset')->name('vmt-assetinventory-delete');

    // end route //

    // General Info
    Route::post('vmt-general-info', [App\Http\Controllers\HomeController::class, 'storeGeneralInfo']);

    Route::get('/getEmployeeName', [App\Http\Controllers\VmtEmployeeController::class, 'getEmployeeName'])->name('get-employee-name');


    Route::get('/employeeOnboarding', [App\Http\Controllers\Onboarding\VmtEmployeeOnboardingController::class, 'showEmployeeOnboardingPage'])->name('employeeOnboarding');
    Route::post('/state', [App\Http\Controllers\VmtEmployeeController::class, 'getState'])->name('state');

    //Normal Onboarding v2
    // Route::get('/employeeOnboarding_v2',  [App\Http\Controllers\VmtEmployeeController::class, 'showEmployeeOnboardingPageV2'])->name('employeeOnboarding_v2');



    //Payroll module
    Route::get('payRun', 'App\Http\Controllers\VmtPayrollController@showPayRunPage')->name('showPayRunPage');
    //Route::post('vmt-payslip', 'App\Http\Controllers\VmtPayCheckController@importBulkEmployeesPayslipExcelData');
    Route::post('employee-payrun-data', 'App\Services\VmtEmployeePayCheckService@storeBulkEmployeesPayslips');

    Route::get('payroll-claims', [App\Http\Controllers\VmtPayrollController::class, 'showPayrollClaimsPage'])->name('showPayrollClaimsPage');
    Route::get('payroll-analytics', [App\Http\Controllers\VmtPayrollController::class, 'showPayrollAnalyticsPage'])->name('showPayrollAnalyticsPage');
    Route::get('payroll-run', [App\Http\Controllers\VmtPayrollController::class, 'showPayrollRunPage'])->name('showPayrollRunPage');

    Route::get('/showManagePayslipsPage', [App\Http\Controllers\VmtPayrollController::class, 'showManagePayslipsPage'])->name('showManagePayslipsPage');
    Route::post('/payroll/paycheck/getAllEmployeesPayslipDetails', [App\Http\Controllers\VmtPayCheckController::class, 'getAllEmployeesPayslipDetails'])->name('getAllEmployeesPayslipDetails');
    Route::post('/payroll/paycheck/getEmployeeAllPayslipList', [App\Http\Controllers\VmtPayCheckController::class, 'getEmployeeAllPayslipList'])->name('getEmployeeAllPayslipList');
    Route::post('/payroll/paycheck/getEmployeePayslipDetailsAsHTML', [App\Http\Controllers\VmtPayCheckController::class, 'getEmployeePayslipDetailsAsHTML'])->name('vmt_paycheck_employee_payslip_htmlview');
    Route::post('/payroll/paycheck/getEmployeePayslipDetailsAsPDF', [App\Http\Controllers\VmtPayCheckController::class, 'getEmployeePayslipDetailsAsPDF'])->name('getEmployeePayslipDetailsAsPDF');
    Route::post('/payroll/paycheck/sendMail_employeePayslip', [App\Http\Controllers\VmtPayCheckController::class, 'sendMail_employeePayslip'])->name('sendMail_employeePayslip');
    Route::post('/payroll/paycheck/updatePayslipReleaseStatus', [App\Http\Controllers\VmtPayCheckController::class, 'updatePayslipReleaseStatus'])->name('update-PayslipReleaseStatus');
    Route::post('/payroll/paycheck/getAllEmployeesPayslipDetails_v2', [App\Http\Controllers\VmtPayCheckController::class, 'getAllEmployeesPayslipDetails_v2'])->name('getAllEmployeesPayslipDetails_v2');
    Route::post('/payroll/paycheck/sendAllEmployeePayslipPdf', [App\Http\Controllers\VmtPayCheckController::class, 'sendAllEmployeePayslipPdf'])->name('sendAllEmployeePayslipPdf');
    Route::get('/payroll/paycheck/downloadBulkEmployeePayslip', [App\Http\Controllers\VmtPayCheckController::class, 'downloadBulkEmployeePayslip'])->name('downloadBulkEmployeePayslip');


    Route::get('payroll-setup', [App\Http\Controllers\VmtPayrollController::class, 'showPayrollSetup'])->name('showPayrollSetup');
    Route::get('payroll/work_location', [App\Http\Controllers\VmtPayrollController::class, 'showWorkLocationSetup'])->name('showWorkLocationSetup');


    //Pay Check module
    Route::get('/paycheckDashboard', [App\Http\Controllers\VmtPayCheckController::class, 'showPaycheckDashboard'])->name('paycheckDashboard');
    Route::get('/salary_details', [App\Http\Controllers\VmtPayCheckController::class, 'showSalaryDetailsPage_v2'])->name('vmt_salary_details');
    Route::get('/investments_details', [App\Http\Controllers\VmtPayCheckController::class, 'showInvestmentsPage'])->name('vmt_investments_details');
    Route::get('/form16_details', [App\Http\Controllers\VmtPayCheckController::class, 'showForm16Page'])->name('vmt_form16_details');
    Route::get('/pdfview/{emp_code?}/{selectedPaySliMonth?}', [App\Http\Controllers\VmtPayCheckController::class, 'getEmployeePayslipDetailsAsPDF'])->name('getEmployeePayslipDetailsAsPDF');

    //Paygroup module
    Route::get('/Paygroup/fetchPayRollComponents', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'fetchPayRollComponents'])->name('fetchPayRollComponents');
    Route::post('/Paygroup/CreatePayRollComponents', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'CreatePayRollComponents'])->name('CreatePayRollComponents');
    Route::post('/Paygroup/UpdatePayRollEarningsComponents', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'UpdatePayRollEarningsComponents'])->name('UpdatePayRollEarningsComponents');
    Route::post('/Paygroup/DeletePayRollComponents', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'DeletePayRollComponents'])->name('DeletePayRollComponents');
    Route::post('/Paygroup/EnableDisableComponents', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'EnableDisableComponents'])->name('EnableDisableComponents');

    // Salary Adhoc Components
    Route::post('/Paygroup/AddAdhocAllowDetectComp', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'AddAdhocAllowanceDetectionComp'])->name('AddAdhocAllowanceDetectionComp');
    Route::post('/Paygroup/UpdateAdhocAllowDetectComp', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'UpdateAdhocAllowanceDetectionComp'])->name('UpdateAdhocAllowanceDetectionComp');

    // Salary Reimbursement Components
    Route::post('/Paygroup/AddReimbursementComponents', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'AddReimbursementComponents'])->name('AddReimbursementComponents');
    Route::post('/Paygroup/UpdateReimbursementComponents', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'UpdateReimbursementComponents'])->name('UpdateReimbursementComponents');

    // Salary software integration
    Route::get('/Paygroup/fetchPayrollAppIntegrations', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'fetchPayrollAppIntegration'])->name('fetchPayrollAppIntegration');
    Route::post('/Paygroup/addPayrollAppIntegrations', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'addPayrollAppIntegrations'])->name('addPayrollAppIntegrations');
    Route::post('/Paygroup/EnableDisableAppIntegration', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'EnableDisableAppIntegration'])->name('EnableDisableAppIntegration');


    //paygroup structure
    Route::get('/Paygroup/fetchPayGroupEmpComponents', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'fetchPayGroupEmpComponents'])->name('fetchPayGroupEmpComponents');
    // Route::post('/Paygroup/addPaygroupCompStructure', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'addPaygroupCompStructure'])->name('addPaygroupCompStructure');
    Route::post('/Paygroup/updatePaygroupCompStructure', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'updatePaygroupCompStructure'])->name('updatePaygroupCompStructure');
    Route::post('/Paygroup/deletePaygroupComponents', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'deletePaygroupComponents'])->name('deletePaygroupComponents');


    //Epf employee
    Route::post('/Paygroup/saveOrUpdatePayrollEpfDetails', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'saveOrUpdatePayrollEpfDetails'])->name('CreatePayrollEpf');
    Route::post('/Paygroup/updatePayrollEpf', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'updatePayrollEpf'])->name('updatePayrollEpf');
    Route::post('/Paygroup/deleteEpfEmployee', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'deleteEpfEmployee'])->name('deleteEpfEmployee');
    Route::post('/Paygroup/authorizeEpfEmployee', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'authorizeEpfEmployee'])->name('authorizeEpfEmployee');

    //Esi employee
    Route::post('/Paygroup/CreatePayrollEsi', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'CreatePayrollEsi'])->name('CreatePayrollEsi');
    Route::post('/Paygroup/updatePayrollEsi', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'updatePayrollEsi'])->name('updatePayrollEsi');
    Route::post('/Paygroup/deleteEsiEmployee', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'deleteEsiEmployee'])->name('deleteEsiEmployee');
    Route::post('/Paygroup/authorizeEsiEmployee', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'authorizeEsiEmployee'])->name('authorizeEsiEmployee');

    //EmpAbryPmrpy employee
    Route::post('/Paygroup/CreateEmpAbryPmrpy', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'CreateEmpAbryPmrpy'])->name('CreateEmpAbryPmrpy');
    Route::post('/Paygroup/removeEmpAbryPmrpy', [App\Http\Controllers\Payroll\VmtPayrollComponentsController::class, 'removeEmpAbryPmrpy'])->name('removeEmpAbryPmrpy');

    // testing template
    Route::get('/testingController', [App\Http\Controllers\VmtTestingController::class, 'index'])->name('testingController');
    //employee attendanceLCreport data
    Route::get('/getEmployeeLcReportData', [App\Http\Controllers\VmtAttendanceController::class, 'checkEmployeeLcPermission'])->name('checkEmployeeLcPermission');
    // end

    Route::get('/config-pms', [App\Http\Controllers\ConfigPmsController::class, 'index'])->name('vmt_config_pms');
    Route::post('/vmt-config-pms/{id?}', [App\Http\Controllers\ConfigPmsController::class, 'store'])->name('store_config_pms');
    Route::post('/config-pms-rating', [App\Http\Controllers\ConfigPmsController::class, 'storePMSRating'])->name('store_config_pms_rating');


    Route::get('/config-master', [App\Http\Controllers\VmtMasterConfigController::class, 'index'])->name('view-config-master');
    Route::post('/vmt-config-master', [App\Http\Controllers\VmtMasterConfigController::class, 'store'])->name('store-config-master');

    //Onboarding pages

    Route::get('/clientOnboarding', function () {
        return view('vmt_clientOnboarding');
    })->name('vmt_clientOnboarding-route');

    // config menu (document tamplate view)
    Route::get('/document_preview', 'App\Http\Controllers\HomeController@showDocumentTemplate')->name('document_preview');

    //Route::get('/documents', [App\Http\Controllers\VmtEmployeeController::class, 'showEmployeeDocumentsPage'])->name('vmt-documents-route');
    // Route::get('/employee-documents',  [App\Http\Controllers\VmtEmployeeController::class, 'fetchDocsForUser'])->name('vmt-documents-routes');
    Route::post('vmt-documents-route', 'App\Http\Controllers\Onboarding\VmtEmployeeOnboardingController@storeEmployeeDocuments')->name('vmt-storedocuments-route');

    Route::post('/onboarding/updateEmployeeActive', [App\Http\Controllers\Onboarding\VmtEmployeeOnboardingController::class, 'updateEmployeeActiveStatus'])->name('updateEmployeeActiveStatus');


    //Documents Approvals
    Route::get('approvals-documents', 'App\Http\Controllers\VmtApprovalsController@showDocumentsApprovalPage')->name('vmt-approvals-emp-documents');
    //Route::get('/employee-documents/{user_code}', 'App\Http\Controllers\VmtApprovalsController@fetchDocsForUser')->name('vmt-documents-routes');
    Route::get('/documents-review-page/{user_code}', 'App\Http\Controllers\VmtApprovalsController@showDocumentsReviewPage')->name('vmt-emp-documents-review');
    Route::post('documents-review', 'App\Http\Controllers\VmtApprovalsController@storeDocumentsReviewByAdmin')->name('vmt-store-documents-review');
    //Route::post('documents-review-approve-all', 'App\Http\Controllers\VmtApprovalsController@approveAllDocumentByAdmin')->name('vmt-store-documents-review-approve-all');

    //Employee Details Documents Approvals
    Route::get('Employee-Details-approvals', 'App\Http\Controllers\VmtApprovalsController@showEmployeeDetailsDocApprovalPage')->name('Employee-Details-approvals');

    //PMS Approvals
    Route::post('/approvals-pms', 'App\Http\Controllers\VmtApprovalsController@approveRejectPMSForm')->name('vmt-approvals-pms');

    //Missed appersial controller routes

    // Performanse Appraisal Question
    Route::get('vmt-apraisal-questions', 'App\Http\Controllers\VmtApraisalController@index');
    Route::get('vmt-apraisal-question/edit/{id}', 'App\Http\Controllers\VmtApraisalController@edit');

    Route::post('vmt-apraisal-question/update/{id}', 'App\Http\Controllers\VmtApraisalController@update');

    Route::post('vmt-apraisal-question/delete', 'App\Http\Controllers\VmtApraisalController@delete');

    Route::post('vmt-apraisal-question/bulk-upload', 'App\Http\Controllers\VmtApraisalController@bulkUploadQuestion');

    Route::post('vmt-apraisal-question/save', 'App\Http\Controllers\VmtApraisalController@addNewQuestion');

    Route::get('vmt-approvereject-kpitable', 'App\Http\Controllers\VmtApraisalController@approveRejectKPITable');
    Route::post('vmt-approvereject-command', 'App\Http\Controllers\VmtApraisalController@approveRejectCommandKPITable');

    Route::post('vmt-pms-saveKPItableDraft_Manager', 'App\Http\Controllers\VmtApraisalController@saveKPItableDraft_Manager');

    Route::post('vmt-pms-saveKPItableDraft_Employee', 'App\Http\Controllers\VmtApraisalController@saveKPItableDraft_Employee');

    Route::post('vmt-pmsappraisal-review', 'App\Http\Controllers\VmtApraisalController@storeEmployeeApraisalReview');

    // to view employees reviews for manager
    Route::get('pms-employee-reviews', 'App\Http\Controllers\VmtApraisalController@showManagerApraisalReview');
    Route::post('vmt-pms-saveKPItableFeedback_Manager', 'App\Http\Controllers\VmtApraisalController@saveManagerFeedback');
    // store review given by manager
    Route::post('vmt-pmsappraisal-managerreview', 'App\Http\Controllers\VmtApraisalController@storeManagerApraisalReview');

    Route::post('/upload_file', [App\Http\Controllers\VmtApraisalController::class, 'uploadFile'])->name('upload-file');
    Route::post('/upload_file_review', [App\Http\Controllers\VmtApraisalController::class, 'uploadFileReview'])->name('upload-file-review');
    Route::get('/download_file/{id}', [App\Http\Controllers\VmtApraisalController::class, 'downloadFile'])->name('download-file');



    Route::post('vmt-pms-appraisal-review', 'App\Http\Controllers\VmtApraisalController@storeEmployeeApraisalReview');

    //
    Route::post('vmt_clientOnboarding', 'App\Http\Controllers\VmtClientController@store');
    Route::Post('/department', 'App\Http\Controllers\VmtDepartmentController@showPage')->name('department');


    Route::get('/getPMSRatingJSON', [App\Http\Controllers\ConfigPmsController::class, 'getPMSRating'])->name('getPMSRatingJSON');

    //PMS Approvals
    Route::get('/approvals_pms', [App\Http\Controllers\VmtApprovalsController::class, 'showPMSApprovalPage'])->name('showPMSApprovalPage');
    Route::get('/fetch_pending_pmsforms', [App\Http\Controllers\VmtApprovalsController::class, 'fetchPendingPMSForms'])->name('fetchPendingPMSForms');
    Route::get('/fetch_approvals_pmsforms', [App\Http\Controllers\VmtApprovalsController::class, 'fetchApprovals_PMSForms'])->name('fetchApprovalsPMSForms');

    //Reimbursement Approvals
    Route::get('/employee_reimbursements', [App\Http\Controllers\VmtReimbursementController::class, 'showReimbursementsPage'])->name('showReimbursementsPage');
    Route::get('/approval_reimbursements', [App\Http\Controllers\VmtApprovalsController::class, 'showReimbursementApprovalPage'])->name('showReimbursementApprovalPage');
    Route::get('/fetch_all_reimbursements', [App\Http\Controllers\VmtApprovalsController::class, 'fetchAllReimbursements'])->name('fetchAllReimbursements');
    Route::post('/fetch_all_reimbursements_as_groups', [App\Http\Controllers\VmtApprovalsController::class, 'fetchAllReimbursementsAsGroups'])->name('fetch_all_reimbursements_as_groups');
    Route::post('/reimbursements_bulk_approval', [App\Http\Controllers\VmtApprovalsController::class, 'processReimbursementBulkApprovals'])->name('processReimbursementBulkApprovals');
    Route::post('/reimbursements-approve-reject', [App\Http\Controllers\VmtApprovalsController::class, 'approveRejectReimbursements'])->name('approveRejectReimbursements');
    Route::post('/approvals/onboarding-docs-approve-reject', [App\Http\Controllers\VmtApprovalsController::class, 'processSingleDocumentApproval'])->name('processSingleDocumentApproval');
    Route::post('/approvals/onboarding-bulkdocs-approve-reject', [App\Http\Controllers\VmtApprovalsController::class, 'processBulkDocumentApprovals'])->name('processBulkDocumentApprovals');
    Route::post('/approvals/onboarding/isAllOnboar/reimbursements/saveReimbursementsDatadingDocumentsApproved', [App\Http\Controllers\VmtApprovalsController::class, 'isAllOnboardingDocumentsApproved'])->name('isAllOnboardingDocumentsApproved');
    Route::post('/reimbursements/saveReimbursementsData', [App\Http\Controllers\VmtReimbursementController::class, 'saveReimbursementsData'])->name('saveReimbursementsData');
    Route::post('/reimbursements/saveReimbursementData_Claims', [App\Http\Controllers\VmtReimbursementController::class, 'saveReimbursementData_Claims'])->name('saveReimbursementData_Claims');
    Route::get('/reimbursements/getModeOfTransports', [App\Http\Controllers\VmtReimbursementController::class, 'getModeOfTransports'])->name('getModeOfTransports');

    Route::post('/getLocalConveyanceCost', [App\Http\Controllers\VmtReimbursementController::class, 'getLocalConveyanceCost'])->name('getLocalConveyanceCost');
    Route::post('/testCreateLocalCovergance', [App\Http\Controllers\VmtReimbursementController::class, 'testCreateLocalCovergance'])->name('testCreateLocalCovergance');
    Route::get('/reimbursements/getReimbursementClaimTypes', [App\Http\Controllers\VmtReimbursementController::class, 'getReimbursementClaimTypes'])->name('getReimbursementClaimTypes');

    //Employee Wise Reimbursement Data
    Route::post('/fetch_employee_reimbursement_data', [App\Http\Controllers\VmtReimbursementController::class, 'fetchEmployeeReimbursement'])->name('fetchReimbursementsData');
    //Route::post('/fetch_employee_reimbursement_data',[App\Http\Controllers\VmtReimbursementController::class,'fetchEmployeeReimbursement'])->name('fetchReimbursementsData');



    //PMS v2
    Route::get('/pms', [App\Http\Controllers\PMS\VmtPMSModuleController::class, 'showPMSDashboard'])->name('pms-dashboard');
    Route::get('/pms/revokeSubmittedForm', [App\Http\Controllers\PMS\VmtPMSModuleController::class, 'revokeSubmittedForm'])->name('pms-revokeSubmittedForm');



    // flow 2 starts
    Route::get('team-appraisal', [VmtPMSModuleController::class, 'showPMSDashboardForManager'])->name('team-appraisal-pms-dashboard');
    // flow 2 ends
    Route::get('vmt-pmsgetAllEmployees', 'App\Http\Controllers\PMS\VmtPMSModuleController@getEmployeesOfManager');
    Route::get('/pms-createform/{year?}', [App\Http\Controllers\PMS\VmtPMSModuleController::class, 'showKPICreateForm'])->name('showKPICreateForm');
    //Route::get('/pms-modifyform',[App\Http\Controllers\PMS\VmtPMSModuleController::class, 'showKPICreateForm'])->name('showKPICreateForm');
    Route::post('saveKPIForm', [App\Http\Controllers\PMS\VmtPMSModuleController::class, 'saveKPIForm'])->name('saveKPIForm');
    Route::post('publishKPIForm', 'App\Http\Controllers\PMS\VmtPMSModuleController@publishKPIForm')->name('publishKPIForm');

    // flow 2 starts
    Route::get('employee-appraisal', [VmtPMSModuleController::class, 'showPMSDashboardForEmployee'])->name('employee-appraisal-pms-dashboard');
    // flow 2 ends

    //Show Review Page
    Route::get('/pms-showReviewPage', [App\Http\Controllers\PMS\VmtPMSModuleController::class, 'showKPIReviewPage_Assignee'])->name('showKPIReviewPage_Assignee');
    Route::get('/pms-showReviewerReviewPage', [App\Http\Controllers\PMS\VmtPMSModuleController::class, 'showKPIReviewPage_Reviewer'])->name('showKPIReviewPage_Reviewer');
    Route::get('/pms-showAssignerReviewPage', [App\Http\Controllers\PMS\VmtPMSModuleController::class, 'showKPIReviewPage_Assigner'])->name('showKPIReviewPage_Assigner');

    //ACCEPT/REJECT by Employee, Manager
    Route::post('/updateFormApprovalStatus-Assignee', [App\Http\Controllers\PMS\VmtPMSModuleController::class, 'updateFormApprovalStatus_Assignee'])->name('updateFormApprovalStatus-Assignee');
    Route::post('/updateFormApprovalStatus-Reviewer', [App\Http\Controllers\PMS\VmtPMSModuleController::class, 'updateFormApprovalStatus_Reviewer'])->name('updateFormApprovalStatus-Reviewer');

    //Save Reviews
    Route::post('/saveAssigneeReviews', [VmtPMSModuleController::class, 'saveAssigneeReviews'])->name('saveAssigneeReviews');
    Route::post('/saveReviewerReviews', [VmtPMSModuleController::class, 'saveReviewerReviews'])->name('saveReviewerReviews');
    Route::post('/saveAssignerReviews', [VmtPMSModuleController::class, 'saveAssignerReviews'])->name('saveAssignerReviews');
    // hr apprasial review
    Route::get('vmt-pms-appraisal-review', 'App\Http\Controllers\PMS\VmtPMSModuleController@showKPIReviewPage_Assignee');
    //test
    Route::get('/generateSampleKPIExcelSheet/{selectedYear?}', [VmtPMSModuleController::class, 'generateSampleKPIExcelSheet'])->name('generate.sample.KPI.excel.sheet');

    // route for download excel sheet from review pgae
    Route::get('/downloadExcelReviewForm/{kpiAssignedId}/{key}/{yearAssignmentPeriod?}', [VmtPMSModuleController::class, 'downloadExcelReviewForm'])->name('download.excelsheet.pmsv2.review.form');

    // routes for accept/reject review by Assignee
    Route::post('acceptRejectAssigneeReview', [VmtPMSModuleController::class, 'acceptRejectAssigneeReview'])->name('acceptRejectAssigneeReview');
    Route::post('acceptRejectReviewerReview', [VmtPMSModuleController::class, 'acceptRejectReviewerReview'])->name('acceptRejectReviewerReview');

    // republish form flow 2
    Route::get('/republishForm/{kpiAssignedId}', [VmtPMSModuleController::class, 'republishForm'])->name('republishForm');
    Route::post('/deleteAssignedKPIForm', [VmtPMSModuleController::class, 'deleteAssignedKPIForm'])->name('deleteAssignedKPIForm');
    Route::post('/republishFormEdited', [VmtPMSModuleController::class, 'republishFormEdited'])->name('republishFormEdited');

    // routes for get related manager of employee in Flow 1
    Route::post('getReviewerOfSelectedEmployee', [VmtPMSModuleController::class, 'getReviewerOfSelectedEmployee'])->name('getReviewerOfSelectedEmployee');
    Route::post('isKPIAlreadyAssignedForGivenAssignmentPeriod', [VmtPMSModuleController::class, 'isKPIAlreadyAssignedForGivenAssignmentPeriod'])->name('isKPIAlreadyAssignedForGivenAssignmentPeriod');
    Route::post('getSameLevelOfReviewer', [VmtPMSModuleController::class, 'getSameLevelOfReviewer'])->name('getSameLevelOfReviewer');
    Route::post('changeReviewerSelection', [VmtPMSModuleController::class, 'changeReviewerSelection'])->name('changeReviewerSelection');
    Route::post('getEmployeesOfReviewer', [VmtPMSModuleController::class, 'getEmployeesOfReviewer'])->name('getEmployeesOfReviewer');
    Route::get('getKPIFormNameInDropdown', [VmtPMSModuleController::class, 'getKPIFormNameInDropdown'])->name('getKPIFormNameInDropdown');

    // route for change employee profile icons on edit
    Route::post('changeEmployeeProfileIconsOnEdit', [VmtPMSModuleController::class, 'changeEmployeeProfileIconsOnEdit'])->name('changeEmployeeProfileIconsOnEdit');

    Route::get('dayWiseStaffAttendance', [App\Http\Controllers\VmtAttendanceController::class, 'dayWiseStaffAttendance'])->name('dayWiseStaffAttendance');


    //--- PMS v3 START ---
    Route::get('/performance', [App\Http\Controllers\PMS\VmtPMSModuleController_v3::class, 'showPMSDashboard']);
    Route::get('/pms/saveOrUpdateKpiFormDetails', [App\Http\Controllers\PMS\VmtPMSModuleController_v3::class, 'saveOrUpdateKpiFormDetails']);
    Route::get('/pms/publishPmsform', [App\Http\Controllers\PMS\VmtPMSModuleController_v3::class, 'publishPmsform']);
    Route::get('/pms/TeamAppraisalReviewerFlow', [App\Http\Controllers\PMS\VmtPMSModuleController_v3::class, 'TeamAppraisalReviewerFlow']);
    Route::get('/pms/ApproveOrReject', [App\Http\Controllers\PMS\VmtPMSModuleController_v3::class, 'ApproveOrReject']);
    Route::get('/pms/assigneReviews', [App\Http\Controllers\PMS\VmtPMSModuleController_v3::class, 'assigneReviews']);
    Route::get('/pms/selfDashBoardDetails', [App\Http\Controllers\PMS\VmtPMSModuleController_v3::class, 'selfDashBoardDetails']);
    Route::get('/pms/getCurrentPMSConfig', [App\Http\Controllers\PMS\VmtPMSModuleController_v3::class, 'getCurrentPMSConfig']);






    //--- PMS v3 END ---

    ////Reports
    ///for current year

    Route::get('get-department', [App\Http\Controllers\VmtReportsController::class, 'department'])->name('department');
    // Route::get('/reports', [App\Http\Controllers\VmtReportsController::class, 'showReportsPage'])->name('showReportsPage');

    Route::post('/get-filter-months-for-reports', [App\Http\Controllers\VmtReportsController::class, 'getCurrentFinancialYear'])->name('getCurrentFinancialYear');
    //filter client
    Route::get('/filter-client-ids', [App\Http\Controllers\VmtReportsController::class, 'filterClient'])->name('filterClient');
    ///for ctc  report
    Route::post('/fetch-employee-ctc-report', [App\Http\Controllers\VmtReportsController::class, 'getEmployeesCTCDetails'])->name('getEmployeesCTCDetails');
    Route::post('/generate-employee-ctc-report', [App\Http\Controllers\VmtReportsController::class, 'generateEmployeesCTCReportData'])->name('generateEmployeesCTCReportData');
    //payroll reports

    Route::get('/reports-payroll', [App\Http\Controllers\Reports\VmtPayrollReportsController::class, 'showPayrollReportsPage'])->name('showPayrollReportsPage');
    Route::get('/reports/generatePayrollReports', [App\Http\Controllers\Reports\VmtPayrollReportsController::class, 'generatePayrollReports'])->name('generatePayrollReports');
    Route::get('/payroll-filter-info', [App\Http\Controllers\Reports\VmtPayrollReportsController::class, 'fetchPayrollReport'])->name('payroll-filter-info');

    //employeemasterreports
    Route::post('/fetch-master-employee-report', [App\Http\Controllers\VmtReportsController::class, 'getEmployeesMasterCTCData'])->name('getEmployeesMasterCTCDatas');
    Route::post('/generate-master-employee-report-data', [App\Http\Controllers\VmtReportsController::class, 'generateEmployeesMasterDetails'])->name('generateEmployeesMasterDetails');
    //Ajax For Fetch Month For Given Year for payroll
    Route::get('/fetch-payroll-month-for-given-year', [App\Http\Controllers\Reports\VmtPayrollReportsController::class, 'fetchPayrollMonthForGivenYear'])->name('fetchPayrollMonthForGivenYear');


    //Attendance Reports
    Route::get('/reports/attendance', [App\Http\Controllers\VmtReportsController::class, 'showAttendanceReport'])->name('showAttendanceReport');
    Route::get('/reports/fetchDetailedAttendanceReport/{user_id}/{month}/{year}', [App\Http\Controllers\VmtReportsController::class, 'fetchDetailedAttendanceReport'])->name('fetchDetailedAttendanceReport'); //By Praveen April 27th

    Route::get('/reports-basic-attendance-report', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'showBasicAttendanceReport'])->name('showBasicAttendanceReport');
    Route::get('/reports-detailed-attendance-report', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'showDetailedAttendanceReport'])->name('showDetailedAttendanceReport');
    Route::get('/reports-latecoming-attendance-report', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'showLateComingReport'])->name('showLateComingReport');
    Route::get('/reports-earlygoing-attendance-report', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'showEarlygoingReport'])->name('showEarlygoingReport');
    Route::get('/reports-absent-attendance-report', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'showAbsentReport'])->name('showAbsentReport');
    Route::get('/reports-attendane-overtime-report', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'showOvertimeReport'])->name('showOvertimeReport');
    Route::get('/reports-half-dayabsent-attendance-report', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'showHalfdayAbsentReport'])->name('showHalfdayAbsentReport');

    Route::post('/reports/generate-detailed-attendance-report', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'generateDetailedAttendanceReports'])->name('generateDetailedAttendanceReports');
    Route::get('/fetch-detailed-attendance-data', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'fetchDetailedAttendancedata'])->name('fetchDetailedAttendancedata');
    Route::post('/fetch-overtime-report-data', [\App\Http\Controllers\VmtEmployeeAttendanceController::class, 'fetchOvertimeReportData']);
    Route::post('/fetch-EG-report-data', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'fetchEGReportData']);
    Route::post('/fetch-absent-report-data', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'fetchAbsentReportData']);
    Route::post('/fetch-half-day-data', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'fetchHalfDayReportData'])->name('fetchHalfDayReportData');
    Route::post('/report/download-absent-report', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'downloadAbsentReport']);
    Route::post('/fetch-LC-report-data', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'fetchLCReportData']);
    Route::get('/fetchSandwidchReportData', [App\Http\Controllers\VmtAttendanceControllerV2::class, 'fetchSandwidchReportData']);


    Route::post('/fetch-half-day-report', [\App\Http\Controllers\VmtEmployeeAttendanceController::class, 'fetchHalfDayReportData']);
    Route::post('/report/download-early-going-report', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'downloadEGReport']);
    Route::post('/report/download-late-coming-report', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'downloadLCReport']);
    Route::post('/report/download-over-time-report', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'downloadOvertimeReport']);
    Route::post('/report/download-half-day-report', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'downloadHalfDayReport']);
    Route::post('/report/download-consolidate-report', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'downloadConsolidateReport']);
    Route::post('/fetch-consolidate-report', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'fetchConsolidateAttendancedata']);
    Route::get('/shiftwork', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'shiftTimeForEmployee']);




    Route::post('/fetch-mip-mop-report', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'fetchMIPOrMOPReportData'])->name('fetchMIPOrMOPReportData');

    Route::post('/report/download/mip-mop-report', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'downloadMipMopReport'])->name('downloadMipMopReport');

    Route::get('getSandWidchData', [App\Http\Controllers\VmtOnboardingTestingController::class, 'getSandWidchData'])->name('getSandWidchData');

    // testing controller
    Route::get('testing', [App\Http\Controllers\VmtTestingController::class, 'testing']);

    //Pay Check Reports
    Route::get('/reports/generate-annual-earned-report', [App\Http\Controllers\VmtReportsController::class, 'generateAnnualEarnedReport'])->name('generateAnnualEarnedReport');
    //Reimbursements Reports
    Route::get('/reports/generate-manager-reimbursements-reports', [App\Http\Controllers\VmtReportsController::class, 'generateManagerReimbursementsReports'])->name(' generateManagerReimbursementsReports');
    Route::get('/reports/generate-employee-reimbursements-reports', [App\Http\Controllers\VmtReportsController::class, 'generateEmployeeReimbursementsReports'])->name('generateEmployeeReimbursementsReports');

    //basic Attedance Report
    Route::post('/reports/generate-basic-attendance', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'basicAttendanceReport'])->name('basicAttendanceReport');
    Route::get('fetch-attendance-month-for-given-year', [App\Http\Controllers\VmtEmployeeAttendanceController::class, 'fetchAttendanceMonthForGivenYear'])->name('fetchAttendanceMonthForGivenYear');
    //Ajax Part
    Route::get('/attendance-filter-info', [App\Http\Controllers\VmtReportsController::class, 'fetchAttendanceInfo'])->name('fetchAttendanceInfo');
    //Ajax For Fetch Month For Given Year fetchAttendanceForGivenYear
    Route::get('/fetch-attendance-for-given-year', [App\Http\Controllers\VmtReportsController::class, 'fetchAttendanceForGivenYear'])->name('fetchAttendanceForGivenYear');

    //pms reviwes report

    Route::get('/reports/pmsreviews', [App\Http\Controllers\VmtReportsController::class, 'showPmsReviewsReportPage'])->name('showPmsReviewsReportPage');
    Route::post('/reports/generatePmsReviewsReports', [App\Http\Controllers\VmtReportsController::class, 'generatePmsReviewsReports'])->name('generatePmsReviewsReports');


    //Ajax Part fetchPmsInfo
    Route::get('/pms-filter-info', [App\Http\Controllers\VmtReportsController::class, 'filterPmsReport'])->name('pms-filter-info');

    //Vmt Correction Controller
    Route::get('/processsExpense', [App\Http\Controllers\VmtCorrectionController::class, 'processsExpense'])->name('processsExpense');
    Route::get('/adding-reimbursement-data', [App\Http\Controllers\VmtCorrectionController::class, 'addingReimbursementsDataForSpecificMonth'])->name('addingReimbursementsDataForSpecificMonth');
    Route::get('/check-allemployee-onboardingstatus', [App\Http\Controllers\VmtCorrectionController::class, 'checkallemployeeonboardingstatus'])->name('checkallemployeeonboardingstatus');
    Route::get('/addAllEmployeePayslipDetails', [App\Http\Controllers\VmtCorrectionController::class, 'addAllEmployeePayslipDetails'])->name('addAllEmployeePayslipDetails');
    Route::get('/addElbalancewithjsonString', [App\Http\Controllers\VmtCorrectionController::class, 'addElbalancewithjsonString'])->name('addElbalancewithjsonString');
    Route::get('/changeAttendanceBioMatricIdToHrmsUserid', [App\Http\Controllers\VmtCorrectionController::class, 'changeAttendanceBioMatricIdToHrmsUserid'])->name('changeAttendanceBioMatricIdToHrmsUserid');
    Route::get('/adding-work-shift-for-all-employees', [App\Http\Controllers\VmtCorrectionController::class, 'addingWorkShiftForAllEmployees'])->name('addingWorkShiftForAllEmployees');


    //PMS V3 Migreation
    Route::get('/migreatePMSFromDetailsToPMSV3FormDetails', [App\Http\Controllers\VmtCorrectionController::class, 'migreatePMSFromDetailsToPMSV3FormDetails'])->name('migreatePMSFromDetailsToPMSV3FormDetails');
    Route::get('/migreateAssignementSettings', [App\Http\Controllers\VmtCorrectionController::class, 'migreateAssignementSettings'])->name('migreateAssignementSettings');

    // dunamis designation changes
    Route::get('/departmentDesignationChanges', [App\Http\Controllers\VmtCorrectionController::class, 'departmentDesignationChanges'])->name('departmentDesignationChanges');


    // Import
    Route::get('/updateMasterdataUploads', [App\Http\Controllers\VmtCorrectionController::class, 'updateMasterdataUploads'])->name('updateMasterdataUploads');
    Route::post('/vmt_employess/Master_upload', [App\Http\Controllers\VmtCorrectionController::class, 'storeMasterdEmployeesData'])->name('masterEmployeeOnboarding');

    Route::get('/salary_adv', [App\Http\Controllers\VmtCorrectionController::class, 'setFinanceidHrid'])->name('setFinanceidHrid');

    Route::get('/saveEmployeeAnnualProjection', [App\Http\Controllers\VmtCorrectionController::class, 'saveEmployeeAnnualProjection'])->name('saveEmployeeAnnualProjection');
    Route::get('/convert-user-code-to-user-id', [App\Http\Controllers\VmtCorrectionController::class, 'convertUserCodeToUserId'])->name('convertUserCodeToUserId');
    Route::get('/setAnnualProjection', [App\Http\Controllers\VmtCorrectionController::class, 'setAnnualProjection'])->name('setAnnualProjection');
    Route::post('/formSubmit', [App\Http\Controllers\VmtTestingController::class, 'formSubmit'])->name('formSubmit');
    //mobile Settings

    //Manual Attendance Fetching
    Route::get('/sync-att-intr-table', [App\Http\Controllers\VmtAttendanceControllerV2::class, 'syncattintrtable'])->name('downloadDetailedAttendanceReport');

    Route::post('/updateEmployeesPermissionStatus', [App\Http\Controllers\VmtMasterConfigController::class, 'updateEmployeesPermissionStatus'])->name('updateEmployeesPermissionStatus');
    Route::post('/updateClientModuleStatus', [App\Http\Controllers\VmtMasterConfigController::class, 'updateClientModuleStatus'])->name('updateClientModuleStatus');
    Route::post('/getEmployeesFilterData', [App\Http\Controllers\VmtMasterConfigController::class, 'getEmployeesFilterData'])->name('getEmployeesFilterData');
    Route::get('/getAllDropdownFilterSetting', [App\Http\Controllers\VmtMasterConfigController::class, 'getAllDropdownFilterSetting'])->name('getAllDropdownFilterSetting');
    Route::post('/GetAllEmpModuleActiveStatus', [App\Http\Controllers\VmtMasterConfigController::class, 'GetAllEmpModuleActiveStatus'])->name('GetAllEmpModuleActiveStatus');
    Route::post('/getClient_MobileModulePermissionDetails', [App\Http\Controllers\VmtMasterConfigController::class, 'getClient_MobileModulePermissionDetails'])->name('getClient_MobileModulePermissionDetails');
    Route::get('/Settings-Mobile', [App\Http\Controllers\VmtMasterConfigController::class, 'showMobileSettingsPage'])->name('showMobileSettingsPage');
    Route::get('/getClient_AllModulePermissionDetails', [App\Http\Controllers\VmtMasterConfigController::class, 'getClient_AllModulePermissionDetails'])->name('getClient_AllModulePermissionDetails');
    Route::get('/getClient_AllModuleDetails', [App\Http\Controllers\VmtMasterConfigController::class, 'getClient_AllModuleDetails'])->name('getClient_AllModuleDetails');
    Route::post('/update_AllClientModuleStatus', [App\Http\Controllers\VmtMasterConfigController::class, 'update_AllClientModuleStatus'])->name('update_AllClientModuleStatus');


    //sidebar module settings

    Route::get('module-settings', [App\Http\Controllers\HomeController::class, 'showModuleSettingsPage'])->name('showModuleSettingsPage');

    //Configrations
    ////Attendance Settings
    Route::get('/attendance_settings', [App\Http\Controllers\VmtAttendanceSettingsController::class, 'showAttendanceSettingsPage'])->name('showAttendanceSettingsPage');
    Route::get('/attendance_settings/fetch-emp-details', [App\Http\Controllers\VmtAttendanceSettingsController::class, 'fetchEmployeeDetails'])->name('attendance_settings-fetchEmployeeDetails');
    Route::post('/attendance_settings/save-shiftdetails', [App\Http\Controllers\VmtAttendanceSettingsController::class, 'assignEmployeesToWorkShift'])->name('attendance_settings-save-shiftdetails');
    Route::get('/json-format-for-dummy-week-off-days', [App\Http\Controllers\VmtAttendanceSettingsController::class, 'jsonFormatForDummyWeekOffDays'])->name('jsonFormatForDummyWeekOffDays');
    // Document Setting
    Route::get('/documents_settings', function () {
        return view('configurations.vmt_documents_settings');
    })->name('document_settings');

    Route::get('/investment_settings', function () {
        return view('configurations.investment_setting');
    })->name('investment_settings');

    Route::get('/documents/employee_doc_settings', [App\Http\Controllers\VmtEmployeeDocumentsController::class, 'getEmployeeDocumentsSettings'])->name('getEmployeeDocumentsSettings');
    Route::post('/documents/update_employee_doc_settings', [App\Http\Controllers\VmtEmployeeDocumentsController::class, 'updateEmployeeDocumentsSettings'])->name('updateEmployeeDocumentsSettings');

    //Holidays

    //get holidays images

    Route::get('/holiday/getHolidaysPicture', [App\Http\Controllers\VmtHolidaysController::class, 'getHolidaysPicture'])->name('getHolidaysPicture');
    Route::get('/holiday/getHolidayslistPicture', [App\Http\Controllers\VmtHolidaysController::class, 'getHolidaysListImages'])->name('getHolidayslistPicture');

    ////Holidays creation
    Route::get('/holiday/master-page', [App\Http\Controllers\VmtHolidaysController::class, 'showHolidaysMasterPage'])->name('holiday-masterpage');
    Route::post('holiday/create_holiday', [App\Http\Controllers\VmtHolidaysController::class, 'createHoliday'])->name('holiday-create-holiday');
    Route::get('/holiday/edit_holiday/{id}/', [App\Http\Controllers\VmtHolidaysController::class, 'editHoliday'])->name('edit-holiday');
    Route::post('holidays/update_holiday', [App\Http\Controllers\VmtHolidaysController::class, 'updateHoliday'])->name('update_holiday');
    Route::post('holidays/delete_holiday', [App\Http\Controllers\VmtHolidaysController::class, 'deleteHoliday'])->name('delete_holiday');
    Route::get('/holidays/add_holidays', function () {
        return view('holidays.test_ui.add_holidays');
    })->name('add-holidays');

    //holiday list
    Route::get('/holiday/visit-page', [App\Http\Controllers\VmtHolidaysController::class, 'showHolidaysList'])->name('holiday-masterpage');
    Route::post('holiday/create_holidaylist', [App\Http\Controllers\VmtHolidaysController::class, 'createHolidayList'])->name('holiday-create-holidaylist');
    Route::get('/holidays/show_holidaysListDetails', [App\Http\Controllers\VmtHolidaysController::class, 'holidaysListDetails'])->name('show-holidaysListDetails');
    Route::get('/holidays/add_holidayslist', [App\Http\Controllers\VmtHolidaysController::class, 'fetchHolidays'])->name('add-holidayslist');
    Route::get('/holiday/edit_holiday_list/{id}/', [App\Http\Controllers\VmtHolidaysController::class, 'editHolidayList'])->name('edit-holiday-list');
    Route::post('holidays/update_holiday_list/{id}/', [App\Http\Controllers\VmtHolidaysController::class, 'updateHolidayList'])->name('update_holiday-list');
    Route::get('holidays/delete_holiday_list/{id}/', [App\Http\Controllers\VmtHolidaysController::class, 'deleteHolidayList'])->name('delete_holiday-list');


    //location
    Route::post('holiday/create_holidaylocation', [App\Http\Controllers\VmtHolidaysController::class, 'createHolidayLocation'])->name('holiday-create-holidaylocation');
    Route::get('/holidays/add_holidayslocation', [App\Http\Controllers\VmtHolidaysController::class, 'fetchlocation'])->name('add-holidays-location');


    //Profile Pages v3
    // Route::get('/profile-page', [App\Http\Controllers\VmtProfilePagesController::class, 'showProfilePage_v3'])->name('profile-page-v3');
    Route::get('/profile-pages-getEmpDetails/{user_id}', [App\Http\Controllers\VmtProfilePagesController::class, 'fetchEmployeeProfilePagesDetails'])->name('profile-pages-getEmpDetails');


    //Investments

    Route::post('/investments/ImportInvestmentForm_Excel', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'ImportInvestmentForm_Excel'])->name('ImportInvestmentForm_Excel');
    Route::get('/investments/showInvestmentsFormMgmtPage', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'showInvestmentsFormMgmtPage'])->name('showInvestmentsFormMgmtPage');
    Route::post('/investments/investments-form-details-template', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'getInvestmentsFormDetailsTemplate'])->name('getInvestmentsFormDetailsTemplate');

    Route::get('/investments/saveEmpInvSecDetails', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'saveEmpInvSecDetails'])->name('saveEmpInvSecDetails');
    Route::post('/investments/fetchEmpRentalDetails', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'fetchEmpRentalDetails'])->name('fetchEmpRentalDetails');
    // Route::post('/investments/deleteEmpRentalDetails', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'deleteRentalDetails'])->name('deleteRentalDetails');
    Route::post('/investments/fetchHousePropertyDetails', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'fetchHousePropertyDetails'])->name('fetchHousePropertyDetails');
    Route::post('/investments/fetchOtherExemption', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'fetchOtherExemptionDetails'])->name('fetchOtherExemptionDetails');
    Route::post('/investments/deleteHousePropertyDetails', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'deleteHousePropertyDetails'])->name('deleteHousePropertyDetails');

    Route::post('/investments/saveEmpdetails', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'SaveInvDetails']);

    Route::post('/investments/saveSectionPopups', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'saveSectionPopups']);
    Route::post('/investments/saveSection80', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'saveSection80']);
    Route::get('/investments/monthTaxDashboard', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'monthTaxDashboard']);
    Route::get('/investments/TaxDeclaration', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'taxDeclaration']);
    Route::post('/investments/saveRegime', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'saveEmpTaxRegime']);
    Route::get('/investments/investment-summary', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'declarationSummaryCalculation']);
    Route::get('/monthTaxDeductionDetails', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'monthTaxDeductionDetails']);
    Route::get('/grossEarningsFromEmployment', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'grossEarningsFromEmployment']);
    Route::get('/taxableIncomeFromAllHeads', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'taxableIncomeFromAllHeads']);
    Route::get('/annual_projection', [App\Http\Controllers\Investments\VmtInvestmentsController::class, 'annual_projection']);


    //Salary Advance

    Route::get('/AssignEmpSalaryAdv', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'AssignEmpSalaryAdv']);
    Route::get('/getAllDropdownFilter', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'getAllDropdownFilterSetting']);
    Route::post('/showAssignEmp', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'SalAdvSettingsTable']);
    Route::post('/saveSalaryAdvanceSetting', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'saveSalaryAdvanceSettings']);
    Route::get('/showEmployeeview', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'SalAdvShowEmployeeView']);
    Route::post('/EmpSaveSalaryAmt', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'SalAdvEmpSaveSalaryAmt']);
    Route::get('/SalAdvApproverFlow', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'SalAdvApproverFlow']);
    Route::get('/getEmpsaladvDetails', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'getEmpsaladvDetails']);
    Route::get('/showSAemployeeView', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'showSAemployeeView'])->name('showSAemployeeView');
    Route::get('/showSAapprovalView', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'showSAapprovalView'])->name('showSAapprovalView');
    Route::get('/showSAsettingsView', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'showSAsettingsView'])->name('showSAsettingsView');
    Route::post('/rejectOrApprovedSaladv', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'rejectOrApprovedSaladv']);
    Route::get('/settingDetails', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'settingDetails']);
    Route::post('/salAdvSettingEdit', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'salAdvSettingEdit']);
    Route::post('/salAdvSettingDelete', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'salAdvSettingDelete']);
    Route::get('/salAdvAmtApprovedEmp', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'salAdvAmtApprovedEmp']);
    Route::post('imporExistingSalaryAdvanceData', [App\Http\Controllers\ImportExistingSADataController::class, 'storeExistingLoanAmount'])->name('imporExistingSalaryAdvanceData');
    Route::get('saveSalaryAdvanceUploadPage', [App\Http\Controllers\ImportExistingSADataController::class, 'saveSalaryAdvanceUploadPage'])->name('saveSalaryAdvanceUploadPage');
    Route::get('getActiveEmployeedata', [App\Http\Controllers\VmtEmployeeController::class, 'getEmployeeLoanDetails'])->name('getEmployeeLoanDetails');
    //Travel Advance

    Route::post('/saveTravelAdvanceSettings', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'saveTravelAdvanceSettings']);

    Route::get('/can-edit-profile-page', [\App\Http\Controllers\VmtProfilePagesController::class, 'canEditProfilePage'])->name('canEditProfilePage');
    //Testing Excel Download
    Route::get('/download-quick-onbaord-excel', [App\Http\Controllers\VmtExcelGeneratorController::class, 'downloadQuickOnbaordExcel'])->name('downloadQuickOnbaordExcel');
    Route::get('/download-bulk-onbaord-excel', [App\Http\Controllers\VmtExcelGeneratorController::class, 'downloadBulkOnbaordExcel'])->name('downloadBulkOnbaordExcel');
    //interest free loan
    Route::get('/show-interest-free-loan-employeeinfo', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'showInterestFreeLoanEmployeeinfo']);
    Route::post('/save-int-and-int-free-loan-settings', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'saveIntersetAndIntersetFreeLoanSettings']);
    Route::post('/show-eligible-interest-free-loan-details', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'showEligibleInterestFreeLoanDetails']);
    Route::post('/apply-loan', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'applyLoan']);
    Route::post('/employee-loan-history', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'EmployeeLoanHistory']);
    Route::post('/loan-and-salAdv-current-status', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'loanAndSalAdvCurrentStatus']);
    Route::post('/change-client-id-sts-for-loan', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'changeClientIdStsForLoan']);
    Route::post('/interest-and-interestfree-loan-settings-details', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'interestAndInterestfreeLoanSettingsDetails']);
    Route::get('/disable-or-enable-interest-and-interest-free-loan-setting', [\App\Http\Controllers\VmtSalaryAdvanceController::class, 'disableOrEnableInterestAndInterestFreeLoanSetting']);
    //Loan Approval changeClientIdStsForLoan
    Route::post('/fetch-employee-for-loan-approval', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'fetchEmployeeForLoanApprovals']);
    Route::post('/reject-or-approve-loan', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'rejectOrApproveLoan']);
    Route::post('/enable-or-disable-loan-settings', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'enableOrDisableLoanSettings']);
    Route::post('/is-eligible-for-loan-and-advance', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'isEligibleForLoanAndAdvance']);
    Route::get('/upload-previous-loan-data', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'empLoanAndAdvUploads']);
    Route::post('/inmport-loan-adv-excel-data', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'inmportLoanAdvExcelData']);

    Route::post('/employee-dashboard-loan-and-advance', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'employeeDashboardLoanAndAdvance']);

    Route::get('/testing-karthi', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'testingKarthi']);

    Route::get('/get-pending-requested-for-loan-and-advance', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'getApprovedRequestedForLoanAndAdvance'])->name('getApprovedRequestedForLoanAndAdvance');
    //loan with intrest
    Route::get('/saveLoanWithIntrest', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'saveLoanWithInterestSettings'])->name('save-LoanWithIntrestSettings');

    Route::get('/loan-transection-record', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'loanTransectionRecord']);

    //Loan And Advance Client Settings Route
    Route::post('/get-clients-for-loan-adv', [App\Http\Controllers\VmtSalaryAdvanceController::class, 'getClientForLoanAndAdv'])->name('getClientForLoanAndAdv');




    //Emp Mail Notifications
    Route::get('/getAllEmployees_WelcomeMailStatus_Details', [App\Http\Controllers\Admin\VmtEmployeeMailNotifManagementController::class, 'getAllEmployees_WelcomeMailStatus_Details'])->name('getAllEmployees_WelcomeMailStatus_Details');
    Route::post('/send_WelcomeMailNotification', [App\Http\Controllers\Admin\VmtEmployeeMailNotifManagementController::class, 'send_WelcomeMailNotification'])->name('send_WelcomeMailNotification');
    Route::post('/send_AccActivationMailNotification', [App\Http\Controllers\Admin\VmtEmployeeMailNotifManagementController::class, 'send_AccActivationMailNotification'])->name('send_AccActivationMailNotification');

    //welcomemailstatus

    Route::view('/manage_welcome_mails_status', 'ManageWelcomeMailStatus')->name('manage_welcome_mails_status');


    //New Dashboard URL
    Route::get('/get-maindashboard-data', [App\Http\Controllers\VmtMainDashboardController::class, 'getMainDashboardData']);
    Route::get('/get-hrmaindashboard-data', [App\Http\Controllers\VmtMainDashboardController::class, 'getHrMainDashboardData']);
    Route::get('/get-employees_count-detail', [App\Http\Controllers\VmtMainDashboardController::class, 'getEmployeesCountDetails']);
    Route::post('/getNotifications', [App\Http\Controllers\VmtMainDashboardController::class, 'getNotifications']);
    Route::post('/readNotification', [App\Http\Controllers\VmtMainDashboardController::class, 'readNotification']);
    Route::post('/performAttendanceCheckIn', [App\Http\Controllers\VmtMainDashboardController::class, 'performAttendanceCheckIn']);
    Route::get('/fetchEmpLastAttendanceStatus', [App\Http\Controllers\VmtMainDashboardController::class, 'fetchEmpLastAttendanceStatus']);
    Route::get('/getAllEventsDashboard', [App\Http\Controllers\VmtMainDashboardController::class, 'getAllEventsDashboard']);
    Route::get('/getEmployeeLeaveBalanceDashboards', [App\Http\Controllers\VmtMainDashboardController::class, 'getEmployeeLeaveBalanceDashboards']);
    Route::get('/getAllNewDashboardDetails', [App\Http\Controllers\VmtMainDashboardController::class, 'getAllNewDashboardDetails']);
    Route::get('/fetchAttendanceDailyReport_PerMonth', [App\Http\Controllers\VmtMainDashboardController::class, 'fetchAttendanceDailyReport_PerMonth']);


    // generate payslip

    Route::post('/generatePayslip', [App\Http\Controllers\VmtPayCheckController::class, 'generateEmployeePayslip'])->name('generateEmployeePayslip');
    Route::post('/viewPayslipdetails', [App\Http\Controllers\VmtPayCheckController::class, 'viewPayslipdetails'])->name('viewPayslipdetails');
    Route::post('/empGeneratePayslipPdfMail', [App\Http\Controllers\VmtPayCheckController::class, 'empGeneratePayslipPdfMail'])->name('empGeneratePayslipPdfMail');
    Route::post('/empViewPayslipdetails', [App\Http\Controllers\VmtPayCheckController::class, 'empViewPayslipdetails'])->name('empViewPayslipdetails');
    Route::get('/generatetemplates', [App\Http\Controllers\VmtPayCheckController::class, 'generatetemplates'])->name('generatetemplates');
    Route::get('/payslipYearwiseDropdown', [App\Http\Controllers\VmtPayCheckController::class, 'payslipYearwiseDropdown'])->name('payslipYearwiseDropdown');






    //Testing controller
    Route::get('/view-private-file', [App\Http\Controllers\VmtTestingController::class, 'viewPrivateFile'])->name('viewPrivateFile');
    Route::get('/view-base64-private-file', [App\Http\Controllers\VmtTestingController::class, 'viewBASE64_PrivateFile'])->name('viewBASE64_PrivateFile');
    Route::get('/download-private-file', [App\Http\Controllers\VmtTestingController::class, 'downloadPrivateFile'])->name('downloadPrivateFile');
    Route::post('/view-profile-private-file', [App\Http\Controllers\VmtProfilePagesController::class, 'getEmployeePrivateDocumentFile'])->name('viewprofileprivatefile');
    Route::get('/mail-test/appointment-letter', [App\Http\Controllers\VmtTestingController::class, 'mailTest_sendAppointmentLetter'])->name('mailTest_sendAppointmentLetter');
    Route::post('/postLeaves', [App\Http\Controllers\Api\VmtAPIAttendanceController::class, 'applyLeaveRequest'])->name('applyLeaveRequest');

    Route::get('/testinginvestment', [App\Http\Controllers\VmtTestingController::class, 'investmenttesting']);
    Route::post('/paycheck/employee_payslip/downloadPayslip', [App\Http\Controllers\VmtTestingController::class, 'downloadPaySlip_pdfView'])->name('downloadPaySlip_pdfView');
    Route::get('users/export', [App\Http\Controllers\VmtTestingController::class, 'exportattenance']);

    Route::view('/testing_simma', 'testing_narasimman');


    Route::get('/testing_shelly', function () {
        return view('testing_shelly');
    });

   //testing url

    Route::get('/checkEmployeeSandwichstatus', [App\Http\Controllers\VmtAttendanceControllerV2::class, 'checkEmployeeSandwichstatus']);
    Route::get('/tds_work_sheet', [App\Http\Controllers\VmtTestingController::class, 'Tesingtdsworksheet']);

    //get Finacial year for leave balance page
    Route::get('/get-financial-years', [App\Http\Controllers\VmtAttendanceController::class, 'getOrgTimePeriod']);


    //investment testing

    Route::view('/investmenttest', 'testing.excellimport');
    Route::get('/sendhratesting', [App\Http\Controllers\VmtTestingController::class, 'testinginvest']);


    //notification

    // Route::get('/home', [App\Http\Controllers\MobileNotificationController::class, 'index'])->name('home');
    // Route::post('/save-token', [App\Http\Controllers\MobileNotificationController::class, 'saveToken'])->name('save-token');
    // Route::post('/send-notification', [App\Http\Controllers\MobileNotificationController::class, 'sendNotification'])->name('send.notification');

    // invest excell
    Route::view('/sample', 'testing.testings')->name('sample');
    Route::get('/sendhratestingsss', [App\Http\Controllers\VmtTestingController::class, 'importexcell']);


    Route::get('/testinginestmentsectionss', [App\Http\Controllers\VmtTestingController::class, 'testinginestmentsection']);

    Route::post('/payroll/getAllEmployeesPayslipDetails', [App\Http\Controllers\VmtPayCheckController::class, 'getAllEmployeesPayslipDetails'])->name('getAllEmployeesPayslipDetails');
    Route::get('/payroll/generateEmployeePayslip', [App\Http\Controllers\VmtPayCheckController::class, 'generateEmployeePayslip'])->name('generateEmployeePayslip');
    Route::get('/payroll/downloadBulkEmployeePayslip', [App\Http\Controllers\VmtPayCheckController::class, 'downloadBulkEmployeePayslip'])->name('downloadBulkEmployeePayslip');
});

Route::get('/testEmployeeDocumentsJoin', [App\Http\Controllers\VmtTestingController::class, 'testEmployeeDocumentsJoin']);




Route::post('updatePassword', 'App\Http\Controllers\VmtEmployeeController@updatePassword')->name('vmt-updatepassword');
Route::get('/resetPassword', 'App\Http\Controllers\Auth\LoginController@showResetPasswordPage')->name('vmt-resetpassword-page');


Route::get('/reset-password', function () {
    return view('auth.reset_password');
})->name('reset-password');

Route::get('/forgetPassword', 'App\Http\Controllers\Auth\LoginController@showForgetPasswordPage')->name('vmt-forgetpassword-page');

Route::post('/send-passwordresetlink', [App\Http\Controllers\Auth\LoginController::class, 'sendPasswordResetLink'])->name('vmt-send-passwordresetlink');
Route::get('/signed-passwordresetlink', 'App\Http\Controllers\Auth\LoginController@processSignedPasswordResetLink')->name('vmt-signed-passwordresetlink');

//checkonboarded status
Route::get('checkEmployeeOnboardStatus', [App\Http\Controllers\VmtMainDashboardController::class, 'checkEmployeeOnboardStatus'])->name('checkEmployeeOnboardStatus');

//login page v3
Route::get('/showLoginPage', [App\Http\Controllers\Auth\LoginController::class, 'showLoginPage'])->name('showLoginPage');

//
Route::get('/syncStaffAttendanceFromDeviceDatabase/{can_debug?}', [App\Http\Controllers\VmtStaffAttendanceController::class, 'syncStaffAttendanceFromDeviceDatabase']);

Route::get('/IsAppEnableCorrection', [App\Http\Controllers\VmtCorrectionController::class, 'IsAppEnableCorrection'])->name('IsAppEnableCorrection');
Route::get('/correctionForDunamisCore', [App\Http\Controllers\VmtCorrectionController::class, 'correctionForDunamisCore'])->name('correctionForDunamisCore');

//Sandwich reports
Route::post('/saveSandwichSettingsdata', [App\Http\Controllers\VmtAttendanceController::class, 'saveSandwichSettingsdata'])->name('saveSandwichSettingsdata');
Route::get('/setEmployeeAbsentRegularization', [App\Http\Controllers\VmtCorrectionController::class, 'setEmployeeAbsentRegularization'])->name('setEmployeeAbsentRegularization');


//TESTING ROUTES
//// SASS TESTING
Route::get('/app-internals', [App\Http\Controllers\VmtAppInternalsController::class, 'showLoginPage']);
Route::post('/app-internals/login', [App\Http\Controllers\VmtAppInternalsController::class, 'login'])->name('authenticateSALogin');
Route::get('/app-internals/main_page', [App\Http\Controllers\VmtAppInternalsController::class, 'showAppInternalsMainPage'])->name('app-internals-mainpage');
Route::get('/app-internals/git-pull', [App\Http\Controllers\VmtAppInternalsController::class, 'executeCommand_GitPull'])->name('app-internals-gitpull');

Route::get('generatePayslip', [App\Http\Controllers\VmtTestingController::class, 'generatePayslip']);
Route::get('TestingMail', [App\Http\Controllers\VmtTestingController::class, 'TestingMail']);

//Testing : Queues
Route::post('/testing/test_queues/checkMailSpeed', [App\Http\Controllers\VmtTestingController::class, 'checkMailSpeed']);

Route::get('/testing_sass', function () {

    return view('testing_views.sassTest');
});

Route::get('/clear_cache', [App\Http\Controllers\VmtMainDashboardController::class, 'clearCache'])->name('clearCache');

// Route::get('payroll/test_getPayrollJournalData', [App\Http\Controllers\VmtPayrollController::class, 'test_getPayrollJournalData'])->name('test_getPayrollJournalData');
// Route::get('payroll/saveTallyResponse_onPayrollProcessStatus', [App\Http\Controllers\VmtPayrollController::class, 'saveTallyResponse_onPayrollProcessStatus'])->name('saveTallyResponse_onPayrollProcessStatus');

//DONT WRITE ANT ROUTES BELOW THIS
// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('{any}', function () {
    return view('layouts.master');
})->where('any', '.*');
