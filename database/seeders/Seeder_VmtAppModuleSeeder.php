<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\VmtAppModules;
use App\Models\VmtClientMaster;
use App\Models\VmtAppSubModuleslink;


class Seeder_VmtAppModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('vmt_app_modules')->truncate();

        DB::table('vmt_app_modules')->insert([
            ['id'=>'1','module_name'=>'MOBILE APP SETTINGS',"title"=>'Mobile App Settings'],
            ['id'=>'2','module_name'=>'MAIN DASHBOARD',"title"=>'Dashboard'],
            ['id'=>'3','module_name'=>'CRM',"title"=>'CRM'],
            ['id'=>'4','module_name'=>'ATTENDANCE TIMESHEET',"title"=>'Attendance'],
            ['id'=>'5','module_name'=>'LEAVE',"title"=>'Leave'],
            ['id'=>'6','module_name'=>'ORGANIZATION',"title"=>'Organization'],
            ['id'=>'7','module_name'=>'APPROVALS',"title"=>'Approvals'],
            ['id'=>'8','module_name'=>'PMS',"title"=>'PMS'],
            ['id'=>'9','module_name'=>'PAYROLL',"title"=>'Payroll'],
            ['id'=>'10','module_name'=>'PAYCHECK',"title"=>'Paycheck'],
            ['id'=>'11','module_name'=>'CLAIM',"title"=>'Claims'],
            ['id'=>'12','module_name'=>'REPORT',"title"=>'Reports'],
            ['id'=>'13','module_name'=>'MASTER CONFIG',"title"=>'Master Config'],
            ['id'=>'14','module_name'=>'CLIENT ONBOARDING',"title"=>'Client Onboarding'],
            ['id'=>'15','module_name'=>'DOCUMENT TEMPLATES',"title"=>'Document Templates'],
            ['id'=>'16','module_name'=>'DOCUMENT SETTINGS',"title"=>'Document Settings'],
            ['id'=>'17','module_name'=>'LEAVE SETTINGS',"title"=>'Leave Settings'],
            ['id'=>'18','module_name'=>'ATTENDANCE SETTINGS',"title"=>'Attendance Settings'],
            ['id'=>'19','module_name'=>'INVESTMENT SETTINGS',"title"=>'Investment Settings'],

        ]);
        DB::table('vmt_app_sub_modules')->truncate();

        DB::table('vmt_app_sub_modules')->insert([
            ['id'=>'1','sub_module_name'=>'IS_ENABLED',"title"=>'Enable'],
            ['id'=>'2','sub_module_name'=>'CAN_CHECKIN',"title"=>'Check-In'],
            ['id'=>'3','sub_module_name'=>'CAN_CHECKOUT',"title"=>'Check-Out'],
            ['id'=>'4','sub_module_name'=>'CAN_CAPTURE_CHECKIN_LOCATION',"title"=>'Check-In with Location'],
            ['id'=>'5','sub_module_name'=>'CAN_CAPTURE_CHECKOUT_LOCATION',"title"=>'Check-Out with Location'],
            ['id'=>'6','sub_module_name'=>'CAN_CAPTURE_CHECKIN_SELFIE',"title"=>'Check-In with Selfie'],
            ['id'=>'7','sub_module_name'=>'CAN_CAPTURE_CHECKOUT_SELFIE',"title"=>'Check-Out with Selfie'],
            ['id'=>'8','sub_module_name'=>'CAN_CAPTURE_REIMBURSEMENT_ON_CHECKOUT',"title"=>'Reimbursement while Check-out'],
            ['id'=>'9','sub_module_name'=>'Absent Regularization',"title"=>'Absent Regularization'],
            ['id'=>'10','sub_module_name'=>'Attendance Regularization',"title"=>'Attendance Regularization'],
            ['id'=>'11','sub_module_name'=>'CAN_SHOW_ATT_REGULARIZATION_APPROVAL',"title"=>'Attendance Regularization Approval'],
            ['id'=>'12','sub_module_name'=>'CAN_APPLY_LEAVE',"title"=>'Leave Apply'],
            ['id'=>'13','sub_module_name'=>'CAN_SHOW_LEAVE_APPROVAL',"title"=>'Leave Approval'],
            ['id'=>'14','sub_module_name'=>'Salary Advance and Loan',"title"=>'Salary Advance And Loan'],
            ['id'=>'15','sub_module_name'=>'Investments',"title"=>'Investments'],
            ['id'=>'16','sub_module_name'=>'PMS',"title"=>'PMS'],
            ['id'=>'17','sub_module_name'=>'Exit Apply',"title"=>'Exit Apply'],

            ['id'=>'18','sub_module_name'=>'VENDOR',"title"=>'Vendor'],
            ['id'=>'19','sub_module_name'=>'CLIENT',"title"=>'Client'],

            ['id'=>'20','sub_module_name'=>'DASHBOARD',"title"=>'Dashboard'],
            ['id'=>'21','sub_module_name'=>'TIME_SHEET',"title"=>'Time Sheet'],

            ['id'=>'22','sub_module_name'=>'MANAGE_EMPLOYEES',"title"=>'Manage Employees'],
            ['id'=>'23','sub_module_name'=>'ORG_STRUCTURE',"title"=>'ORG Structure'],
            ['id'=>'24','sub_module_name'=>'ONBOARDING',"title"=>'Onboarding'],
            ['id'=>'25','sub_module_name'=>'ONBOARDING_BULK_UPLOAD',"title"=>'Bulk Onboarding'],
            ['id'=>'26','sub_module_name'=>'ONBOARDING_QUICK_UPLOAD',"title"=>'Quick Onboarding'],
            ['id'=>'27','sub_module_name'=>'MANAGE_WELCOMEMAIL_STATUS',"title"=>'Manage Welcome Mail Status'],
            ['id'=>'28','sub_module_name'=>'ROLES_AND_PERMISSION',"title"=>'Roles and Permission'],

            ['id'=>'29','sub_module_name'=>'ONBOARDING',"title"=>'Onboarding'],
            ['id'=>'30','sub_module_name'=>'LEAVES',"title"=>'Leaves'],
            ['id'=>'31','sub_module_name'=>'ATTENDANCE_REGULARIZATION',"title"=>'Attendance Regularization'],
            ['id'=>'32','sub_module_name'=>'REIMBURSEMENT',"title"=>'Reimbursement'],
            ['id'=>'33','sub_module_name'=>'TAXATIONS',"title"=>'Taxations'],
            ['id'=>'34','sub_module_name'=>'EMPLOYEE_DETAILS',"title"=>'Employee Details'],
            ['id'=>'35','sub_module_name'=>'LOAN_AND_SALARY_ADVANCE',"title"=>'Loan and Salary Advance'],

            ['id'=>'36','sub_module_name'=>'SELF_APPRAISAL',"title"=>'Self-Appraisal'],
            ['id'=>'37','sub_module_name'=>'TEAM_APPRAISAL',"title"=>'Team Appraisal'],
            ['id'=>'38','sub_module_name'=>'ORG_APPRAISAL',"title"=>'Org Appraisal'],
            ['id'=>'39','sub_module_name'=>'PMS_CONFIG',"title"=>'PMS Config'],
            ['id'=>'40','sub_module_name'=>'PMS_FORMS_MANAGEMENT',"title"=>'PMS Forms Management'],

            ['id'=>'41','sub_module_name'=>'ANALYTICS',"title"=>'Analytics'],
            ['id'=>'42','sub_module_name'=>'PAYRUN',"title"=>'Pay Run'],
            ['id'=>'43','sub_module_name'=>'MANAGE_PAYSLIPS',"title"=>'Manage Payslip'],
            ['id'=>'44','sub_module_name'=>'CLAIM',"title"=>'Claim'],
            ['id'=>'45','sub_module_name'=>'REPORTS',"title"=>'Reports'],

            ['id'=>'47','sub_module_name'=>'SALARY_DETAILS',"title"=>'Salary details'],
            ['id'=>'48','sub_module_name'=>'INVESTMENTS',"title"=>'Investments'],
            ['id'=>'49','sub_module_name'=>'FORM_16',"title"=>'Form 16'],
            ['id'=>'50','sub_module_name'=>'LOAN_AND_SALARY_ADVANCE',"title"=>'Loan and Salary Advance'],

            ['id'=>'51','sub_module_name'=>'REIMBURSEMENTS',"title"=>'Reimbursement'],

            ['id'=>'52','sub_module_name'=>'SALARY ADVANCE',"title"=>'Salary Advance'],
            ['id'=>'53','sub_module_name'=>'Form 24Q',"title"=>'Form 24Q'],

            ['id'=>'54','sub_module_name'=>'PAYRUNUPLOAD',"title"=>'Pay Run upload'],
        ]);

        DB::table('vmt_app_sub_modules_links')->truncate();
        DB::table('vmt_app_sub_modules_links')->insert([
            ['id'=>'1','module_id'=>'1','sub_module_id'=>'1'],
            ['id'=>'2','module_id'=>'1','sub_module_id'=>'2'],
            ['id'=>'3','module_id'=>'1','sub_module_id'=>'3'],
            ['id'=>'4','module_id'=>'1','sub_module_id'=>'4'],
            ['id'=>'5','module_id'=>'1','sub_module_id'=>'5'],
            ['id'=>'6','module_id'=>'1','sub_module_id'=>'6'],
            ['id'=>'7','module_id'=>'1','sub_module_id'=>'7'],
            ['id'=>'8','module_id'=>'1','sub_module_id'=>'8'],
            ['id'=>'9','module_id'=>'1','sub_module_id'=>'9'],
            ['id'=>'10','module_id'=>'1','sub_module_id'=>'10'],
            ['id'=>'11','module_id'=>'1','sub_module_id'=>'11'],
            ['id'=>'12','module_id'=>'1','sub_module_id'=>'12'],
            ['id'=>'13','module_id'=>'1','sub_module_id'=>'13'],
            ['id'=>'14','module_id'=>'1','sub_module_id'=>'14'],
            ['id'=>'15','module_id'=>'1','sub_module_id'=>'15'],
            ['id'=>'16','module_id'=>'1','sub_module_id'=>'16'],
            ['id'=>'17','module_id'=>'1','sub_module_id'=>'17'],

            ['id'=>'18','module_id'=>'2','sub_module_id'=>'1'],

            ['id'=>'19','module_id'=>'3','sub_module_id'=>'1'],
            ['id'=>'20','module_id'=>'3','sub_module_id'=>'18'],
            ['id'=>'21','module_id'=>'3','sub_module_id'=>'19'],

            ['id'=>'22','module_id'=>'4','sub_module_id'=>'1'],
            ['id'=>'23','module_id'=>'4','sub_module_id'=>'20'],
            ['id'=>'24','module_id'=>'4','sub_module_id'=>'21'],

            ['id'=>'25','module_id'=>'5','sub_module_id'=>'1'],

            ['id'=>'26','module_id'=>'6','sub_module_id'=>'1'],
            ['id'=>'27','module_id'=>'6','sub_module_id'=>'22'],
            ['id'=>'28','module_id'=>'6','sub_module_id'=>'23'],
            ['id'=>'29','module_id'=>'6','sub_module_id'=>'24'],
            ['id'=>'30','module_id'=>'6','sub_module_id'=>'25'],
            ['id'=>'31','module_id'=>'6','sub_module_id'=>'26'],
            ['id'=>'32','module_id'=>'6','sub_module_id'=>'27'],
            ['id'=>'33','module_id'=>'6','sub_module_id'=>'28'],

            ['id'=>'34','module_id'=>'7','sub_module_id'=>'1'],
            ['id'=>'35','module_id'=>'7','sub_module_id'=>'29'],
            ['id'=>'36','module_id'=>'7','sub_module_id'=>'30'],
            ['id'=>'37','module_id'=>'7','sub_module_id'=>'31'],
            ['id'=>'38','module_id'=>'7','sub_module_id'=>'32'],
            ['id'=>'39','module_id'=>'7','sub_module_id'=>'33'],
            ['id'=>'40','module_id'=>'7','sub_module_id'=>'34'],
            ['id'=>'41','module_id'=>'7','sub_module_id'=>'35'],

            ['id'=>'42','module_id'=>'8','sub_module_id'=>'1'],
            ['id'=>'43','module_id'=>'8','sub_module_id'=>'36'],
            ['id'=>'44','module_id'=>'8','sub_module_id'=>'37'],
            ['id'=>'45','module_id'=>'8','sub_module_id'=>'38'],
            ['id'=>'46','module_id'=>'8','sub_module_id'=>'39'],
            ['id'=>'47','module_id'=>'8','sub_module_id'=>'40'],

            ['id'=>'48','module_id'=>'9','sub_module_id'=>'1'],
            ['id'=>'49','module_id'=>'9','sub_module_id'=>'41'],
            ['id'=>'50','module_id'=>'9','sub_module_id'=>'42'],
            ['id'=>'51','module_id'=>'9','sub_module_id'=>'43'],
            ['id'=>'52','module_id'=>'9','sub_module_id'=>'44'],
            ['id'=>'53','module_id'=>'9','sub_module_id'=>'45'],

            ['id'=>'54','module_id'=>'10','sub_module_id'=>'1'],
            ['id'=>'55','module_id'=>'10','sub_module_id'=>'18'],
            ['id'=>'56','module_id'=>'10','sub_module_id'=>'47'],
            ['id'=>'57','module_id'=>'10','sub_module_id'=>'48'],
            ['id'=>'58','module_id'=>'10','sub_module_id'=>'49'],
            ['id'=>'59','module_id'=>'10','sub_module_id'=>'50'],

            ['id'=>'60','module_id'=>'11','sub_module_id'=>'1'],
            ['id'=>'61','module_id'=>'11','sub_module_id'=>'51'],

            ['id'=>'62','module_id'=>'12','sub_module_id'=>'1'],
            ['id'=>'63','module_id'=>'13','sub_module_id'=>'1'],
            ['id'=>'64','module_id'=>'14','sub_module_id'=>'1'],
            ['id'=>'65','module_id'=>'15','sub_module_id'=>'1'],
            ['id'=>'66','module_id'=>'16','sub_module_id'=>'1'],
            ['id'=>'67','module_id'=>'17','sub_module_id'=>'1'],
            ['id'=>'68','module_id'=>'18','sub_module_id'=>'1'],
            ['id'=>'69','module_id'=>'19','sub_module_id'=>'1'],
            ['id'=>'70','module_id'=>'10','sub_module_id'=>'52'],
            ['id'=>'71','module_id'=>'10','sub_module_id'=>'53'],
            ['id'=>'72','module_id'=>'9','sub_module_id'=>'54'],





        ]);



    }
}
