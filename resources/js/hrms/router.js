import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';

const routes = [

    // {
    //     path: '/login',
    //     name: 'login',
    //     component: () => import('../hrms/modules/login_Page/login_Page.vue'),
    //     meta: { requiresAuth: false }, // Protect this route
    // },

    {
        path: '/',
        name: 'home',
        component: () => import('../hrms/modules/Home/Home.vue'),
        // meta: { requiresAuth: true }, // Protect this route
        children: [
            // Define your other routes here
            {
                path: '/',
                name: '',
                component: () => import('../hrms/modules/dashboard/dashboard.vue'),

            },
            {
                path: '/documents',
                name: 'documents',
                component: () => import('../hrms/modules/profile_pages/EmployeeDocumentsManager.vue'),

            },
            {
                path: '/profile-page',
                name: 'profile-page',
                component: () => import('../hrms/modules/profile_pages/ProfilePageNew.vue'),
            },
            {
                path: '/profile-page/:user_code',
                name: 'profile-page-search',
                component: () => import('../hrms/modules/profile_pages/ProfilePageNew.vue'),

            },
            {
                path: 'Attendance/attendance-dashboard',
                name: 'attendance-dashboard',
                component: () => import('../hrms/modules/attendence/attendanceDashboard/attendanceDashboard.vue'),
            },
            {
                path: '/attendance-timesheet',
                name: 'attendance-timesheet',
                component: () => import('../hrms/modules/attendence/AttendanceModule.vue'),
                // meta: { requiresAuth: true }, // Protect this route
            },
            {
                path: '/attendance-leave',
                name: 'Attendance',
                component: () => import('../hrms/modules/leave_module/LeaveModule.vue'),
                // meta: { requiresAuth: true }, // Protect this route
            },

            // Organization

            {
                path: '/Organization/manage-employees',
                name: 'manage-employees',
                component: () => import('../hrms/modules/Organization/manage_employee/ManageEmployee.vue'),
            },
            {
                path: '/Organization/employee-onboarding',
                name: 'employee-onboarding',
                component: () => import('../hrms/modules/Organization/Normal_Onboarding/NormalOnboarding.vue'),
            },
            {
                path: '/Organization/employee-onboarding/:id',
                name: 'from-quick-employee-onboarding',
                component: () => import('../hrms/modules/Organization/Normal_Onboarding/NormalOnboarding.vue'),
            },
            {
                path: '/Organization/bulk-onboarding',
                name: 'bulk-onboarding',
                component: () => import('../hrms/modules/Organization/BulkOnboarding/BulkOnboarding.vue'),
            },
            {
                path: '/Organization/quick-onboarding',
                name: 'quick-onboarding',
                component: () => import('../hrms/modules/Organization/QuickOnboarding/QuickOnboarding.vue'),
            },
            {
                path: '/Organization/import',
                name: 'import-onboarding',
                component: () => import('../hrms/modules/Organization/QuickOnboarding/ImportQuickOnboarding.vue'),
            },
            {
                path: '/Organization/employee-hierarchy',
                name: 'employee-hierarchy',
                component: () => import('../hrms/components/PageNotFound.vue'),
            },
            {
                path: '/Organization/manage-welcome-mails',
                name: 'manage-welcome-mails',
                component: () => import('../hrms/modules/Organization/manage_welcome_mails_status/ManageWelcomeMailStatus.vue'),
            },

            // Approvals

            {
                path: '/Approvals/Onboarding-documents',
                name: 'Onboarding-documents',
                component: () => import('../hrms/modules/approvals/onboarding/review_document.vue'),
            },
            {
                path: '/Approvals/leave',
                name: 'approval-leave',
                component: () => import('../hrms/modules/approvals/leaves/LeaveApproval.vue'),
            },
            {
                path: '/Approvals/Attendance-regularization',
                name: 'approvals-regularization',
                component: () => import('../hrms/modules/approvals/att_regularization/AttRegularizationApproval.vue'),
            },
            {
                path: '/Approvals/Reimbursements',
                name: 'approvals-Reimbursements',
                component: () => import('../hrms/modules/approvals/reimbursements/ReimbursementsApproval.vue'),
            },
            {
                path: '/Approvals/Employee-Details',
                name: 'approvals-employee-Details',
                component: () => import('../hrms/modules/approvals/employeeDetails_approvals/EmpDetails_approvals.vue'),
            },
            {
                path: '/Approvals/loan-settings',
                name: 'approvals-salary-advance',
                component: () => import('../hrms/modules/approvals/salary_advance_loan/approvals_salary_advance.vue'),
            },

            // Paycheck
            {
                path: '/Paycheck/Salary-Details',
                name: 'Paycheck-Salary-Details',
                component: () => import('../hrms/modules/paycheck/salary_details/salary_details.vue'),
            },
            {
                path: '/Paycheck/form16_details',
                name: 'Paycheck-form16_details',
                component: () => import('../hrms/components/PageNotFound.vue'),
            },
            {
                path: '/Paycheck/Investments',
                name: 'Paycheck-Investments',
                component: () => import('../hrms/modules/paycheck/investments/investment.vue'),
            },
            {
                path: '/Paycheck/Loan-and-salary-advance',
                name: 'Paycheck-Loan-and-salary-advance',
                component: () => import('../hrms/modules/paycheck/salary_advance_loan/employee_salary_loan.vue'),
            },
            {
                path: '/Paycheck/Import-loan-and-salary-advance',
                name: 'Paycheck-Import-loan-and-salary-advance',
                component: () => import('../hrms/modules/salary_loan_setting/salary_advance_excel_import/salary_advance_excel_import.vue'),
            },

            // Performance
            {
                path: '/Performance/Config',
                name: 'Performance-Config',
                component: () => import('../hrms/modules/pms/pmsConfig/pmsConfig.vue'),
            },
            // {
            //     path: '/Performance/Form-Management',
            //     name: 'Performance-Form-Management',
            //     component: () => import('../hrms/modules/pms/pms_forms_mgmt/PMSFormsMgmt.vue'),
            // },
            {
                path: '/Performance/pmsDashboard',
                name: 'Performance-pmsDashboard',
                component: () => import('../hrms/modules/pms/pms_dashboard/pms_main_dashboard.vue'),
            },
            {
                path: '/Performance/pmsMaster',
                name: 'Performance-pmsMaster',
                component: () => import('../hrms/modules/pms/pmsMaster.vue'),
            },
            {
                path: '/Performance/Org-Appraisal',
                name: 'Performance-Org-Appraisal',
                component: () => import('../hrms/modules/pms/pmsMaster.vue'),
            },
            {
                path: '/Performance/Self-Appraisal',
                name: 'Performance-Self-Appraisal',
                // component: () => import('../hrms/modules/pms/selfAppraisal/selfAppraisal.vue'),
                component: () => import('../hrms/modules/pms/pmsMaster.vue'),
            },
            {
                path: '/Performance/Team-Appraisal',
                name: 'Performance-Team-Appraisal',
                component: () => import('../hrms/modules/pms/teamAppraisal/teamAppraisal.vue'),
            },
            {
                path: '/Performance/pms-config',
                name: 'Performance-pms-config',
                component: () => import('../hrms/modules/pms/pmsConfig/pmsConfig.vue'),
            },

            // payroll
            {
                path: '/Payroll/Manage-Payslips',
                name: 'Payroll-Manage-Payslips',
                component: () => import('../hrms/modules/manage_payslips/managePayslipv2/managePayslipV2.vue'),
            },
            // {
            //     path: '/Payroll/Manage-Payslips',
            //     name: 'Payroll-Manage-Payslips',
            //     component: () => import('../hrms/modules/manage_payslips/ManagePayslips.vue'),
            // },
            {
                path: '/Payroll/payroll-analytics',
                name: 'payroll-analytics',
                component: () => import('../hrms/components/PageNotFound.vue'),
            },
            {
                path: '/Payroll/PayRun',
                name: 'Payroll-Pay-Run',
                component: () => import('../hrms/modules/payroll/payRun/payRun.vue'),
            },
            {
                path: '/Payroll/PayRun/Upload',
                name: 'Payroll-Pay-Run-Upload',
                component: () => import('../hrms/modules/payroll/payRun/import_payrun/payrun_excel_import.vue'),
            },
            {
                path: '/Payroll/settings',
                name: 'Payroll-Pay-settings',
                component: () => import('../hrms/modules/payroll/payroll_setting/payroll_setup/payroll_setup.vue'),
            },
            {
                path: '/Payroll/payroll-claims',
                name: 'Payroll-claims',
                component: () => import('../hrms/components/PageNotFound.vue'),
            },
            {
                path: 'Payroll/reports-payroll',
                name: 'Payroll-reports-payroll',
                component: () => import('../hrms/components/PageNotFound.vue'),
            },

            // Reports
            {
                path: '/Reports',
                name: 'Reports',
                component: () => import('../hrms/modules/reports/ReportsMaster.vue'),
            },
            {
                path: '/Integration',
                name: 'Integration',
                component: () => import('../hrms/modules/external_integrations/external_app_integrations.vue'),
            },

            // Configuration
            {
                path: '/Configuration/Client-onboarding',
                name: 'Client-onboarding',
                component: () => import('../hrms/modules/configurations/client_onboarding/client_onboarding_master.vue'),
            },
            // {
            //     path: '/Configuration/Document-template',
            //     name: 'Document-template',
            //     component: () => import('../hrms/modules/reports/ReportsMaster.vue'),
            // },
            {
                path: '/Configuration/Document-settings',
                name: 'Document-settings',
                component: () => import('../hrms/modules/configurations/emp_documents/DocumentsSettings.vue'),
            },
            {
                path: '/Configuration/Attendance-settings',
                name: 'Attendance-settings',
                component: () => import('../hrms/modules/configurations/attendance_settings/Attendance_setting_Master.vue'),
            },
            {
                path: '/Configuration/Loan-and-salaryAdvance-settings',
                name: 'Loan-and-salaryAdvance-settings',
                component: () => import('../hrms/modules/salary_loan_setting/salary_loan_setting.vue'),
            },
            {
                path: '/Configuration/Mobile-settings',
                name: 'Mobile-settings',
                component: () => import('../hrms/modules/configurations/mobile_settings/MobileSettings.vue'),
            },
            {
                path: '/Configuration/Module-settings',
                name: 'Module-settings',
                component: () => import('../hrms/modules/configurations/module_settings/module_settings.vue'),
            },

            // Claims
            {
                path: '/Claims/Employee-reimbursements',
                name: 'Employee-reimbursements',
                component: () => import('../hrms/modules/reimbursements/EmployeeReimbursements.vue')
            },
            {
                path: '/Information',
                name: 'Employee-information',
                component: () => import('../hrms/components/information.vue')
            },
            {
                path: '/test_queues',
                name: 'Testing-Queues',
                component: () => import('../hrms/modules/testings/queues/Test_Queues.vue')
            },
            // integration => tally erp
            {
                path:'/Integration/Tally-ERP',
                name:'Tally ERP',
                component: () => import('../hrms/modules/external_integrations/integration_tally.vue'),
            },
            //self resignation
            {
                path:'/exit/self_resignation',
                name:'Self Resignation',
                component: () => import('../hrms/modules/exit/exit_modulev2/resignation/self_resignation.vue'),
            },
            {
                path:'/exit',
                name:'exit',
                component: () => import('../hrms/modules/exit/master/resignation_approval.vue'),
            },
            {
                path:'/salary-revision',
                name:'salary-revision',
                component: () => import('../hrms/modules/payroll/salary_Revision/salary_Revision.vue'),
            },
            {
                path:'/my-salary',
                name:'my-salary',
                component: () => import('../hrms/modules/payroll/salary_Revision/my_Salary.vue'),
            },
            {
                path:'/exit/resignation_setting',
                name:'Resignation setting',
                component: () => import('../hrms/modules/exit/setting/resignation_setting.vue'),
            },

            // Other routes go here
        ],
        // meta: { requiresAuth: true }, // Protect this route
    },

];
const router = createRouter({
    history: createWebHistory(),
    routes,
});


// Global navigation guard
router.beforeEach((to, from, next) => {


    // Define routes to be ignored (handled by Laravel)
    const ignoredRoutes = ['/app-internals'];

    // Check if the current route should be ignored
    if (ignoredRoutes.includes(to.path)) {
        console.log("terst");
        // Do not process the route in Vue Router, let Laravel handle it
        return next(false);
    }


    if (to.matched.some((record) => record.meta.requiresAuth)) {
        // Check if the user is authenticated by validating the access_token
        const accessToken = localStorage.getItem('access_token'); // Retrieve the access_token from local storage (you can use cookies or a different storage mechanism)

        if (!accessToken) {
            // If the access_token is not present, redirect to the login page
            console.log('Authentication token not present');
            next('/login');
        } else {
            // User is authenticated, proceed to the requested route
            console.log('Authentication token is present');
            next();
        }
    } else {
        // For routes that don't require authentication, proceed
        next();
    }
});

export default router;
