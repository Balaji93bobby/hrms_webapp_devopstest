<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bank;

use App\Models\ConfigPms;
use App\Models\VmtPMS_KPIFormAssignedModel;
use App\Models\VmtPMS_KPIFormReviewsModel;
use App\Models\VmtEmployeePaySlip;
use App\Models\VmtEmployeePaySlipV2;
use App\Models\VmtPayroll;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Exports\VmtPayrollReports;
use App\Exports\VmtPmsReviewsReport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

//test
class VmtPayrollReportsController extends Controller
{

    public function showPayrollReportsPage(Request $request){

        $query_payroll_year = VmtPayroll::groupby('payroll_date')->pluck('payroll_date');
        $work_location= VmtEmployeeOfficeDetails::groupby('work_location')->pluck('work_location');
        $designation = VmtEmployeePaySlipV2::leftjoin('vmt_emp_payroll','vmt_emp_payroll.id','=','vmt_employee_payslip_v2.emp_payroll_id')
                                            ->leftjoin('vmt_payroll','vmt_payroll.id','=','vmt_emp_payroll.payroll_id')
                                            ->leftjoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id','=','vmt_emp_payroll.user_id')
                                            ->groupby('vmt_employee_office_details.designation')->pluck('vmt_employee_office_details.designation');

        for($i=0; $i < count($query_payroll_year); $i++)
        {
            $query_payroll_year[$i] = date("Y",strtotime($query_payroll_year[$i]));
        }

        $payroll_available_years = array_unique($query_payroll_year->toArray());


        return view('reports.vmt_showPayrollReports', compact('work_location','designation','payroll_available_years'));
    }

    public function fetchPayrollMonthForGivenYear(Request $request){
        $payroll_month=VmtPayroll::whereYear('payroll_date',$request->payroll_year)->groupby('payroll_date')->pluck('payroll_date');
        for($i=0; $i < count($payroll_month); $i++)
        {

            $payroll_month[$i] = date("m",strtotime($payroll_month[$i]));
        }
        $payroll_available_months = array_unique($payroll_month->toArray());

        return $payroll_available_months;
    }


    public function generatePayrollReports(Request $request){

        $filename = 'PayrollReports_'.$request->payroll_month.'.xlsx';
        return Excel::download(new VmtPayrollReports($request->payroll_month), $filename ,null, [\Maatwebsite\Excel\Excel::XLSX]);
    }

    public function fetchPayrollReport(Request $request){
        // dd($request->all());
        $payroll_data=VmtEmployeePaySlipV2::leftjoin('vmt_emp_payroll','vmt_emp_payroll.id','=','vmt_employee_payslip_v2.emp_payroll_id')
         ->leftjoin('vmt_payroll','vmt_payroll.id','=','vmt_emp_payroll.payroll_id')
         ->leftJoin('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'vmt_emp_payroll.user_id')
        ->leftJoin('users', 'users.id', '=', 'vmt_emp_payroll.user_id')
        ->leftJoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'vmt_emp_payroll.user_id')
        ->leftJoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'vmt_emp_payroll.user_id')
        ->leftJoin('vmt_employee_statutory_details', 'vmt_employee_statutory_details.user_id', '=', 'vmt_emp_payroll.user_id')
        ->whereYear('vmt_payroll.payroll_date', $request->payroll_year)
        // ->orWhere('vmt_employee_office_details.work_location',$request->work_location)
        ->select('users.user_code',
                 'users.name',

                 'vmt_employee_office_details.DESIGNATION',
                 'vmt_employee_details.doj',
                 'vmt_employee_details.dob',

                 'vmt_employee_office_details.work_location',

                  'vmt_employee_details.Aadhar_Number',
                  'vmt_employee_details.PAN_Number',

                 'vmt_employee_statutory_details.uan_number',
                 'vmt_employee_statutory_details.epf_number',
                 'vmt_employee_statutory_details.esic_number',

                 'vmt_employee_details.bank_id',
                 'vmt_employee_details.bank_account_number',
                 'vmt_employee_details.bank_ifsc_code',
                 'vmt_employee_details.mobile_number',

                 'vmt_employee_office_details.officical_mail',

                 //Abry and Enitiy
                 'vmt_payroll.payroll_date as PAYROLL_MONTH',
                 //Total Emoluments
                 'vmt_employee_payslip_v2.basic as BASIC',
                 'vmt_employee_payslip_v2.hra as HRA',
                 'vmt_employee_payslip_v2.spl_alw as SPL_ALW',
                 'vmt_employee_payslip_v2.total_fixed_gross as TOTAL_FIXED_GROSS',

                 'vmt_employee_statutory_details.esic_applicable',

                 'vmt_employee_payslip_v2.month_days as MONTH_DAYS',
                 'vmt_employee_payslip_v2.worked_Days as Worked_Days',
                 'vmt_employee_payslip_v2.arrears_Days as Arrears_Days',
                 'vmt_employee_payslip_v2.lop as LOP',
                 'vmt_employee_payslip_v2.earned_basic as Earned_BASIC',
                 'vmt_employee_payslip_v2.basic_arrear as BASIC_ARREAR',
                 'vmt_employee_payslip_v2.earned_hra as Earned_HRA',
                 'vmt_employee_payslip_v2.hra_arrear as HRA_ARREAR',
                 'vmt_employee_payslip_v2.earned_spl_alw as Earned_SPL_ALW',
                 'vmt_employee_payslip_v2.spl_alw_arrear as SPL_ALW_ARREAR',
                 'vmt_employee_payslip_v2.overtime as Overtime',
                 //Overtime Arrears
                 'vmt_employee_payslip_v2.total_earned_gross as TOTAL_EARNED_GROSS',
                 'vmt_employee_payslip_v2.pf_wages as PF_WAGES',
                 'vmt_employee_payslip_v2.pf_wages_arrear as PF_WAGES_ARREAR_EPFR',
                 'vmt_employee_payslip_v2.epfr as EPFR',
                 'vmt_employee_payslip_v2.epfr_arrear as EPFR_ARREAR',
                 'vmt_employee_payslip_v2.edli_charges as EDLI_CHARGES',
                 'vmt_employee_payslip_v2.edli_charges_arrears as EDLI_CHARGES_ARREARS',
                 'vmt_employee_payslip_v2.pf_admin_charges as PF_ADMIN_CHARGES',
                 'vmt_employee_payslip_v2.pf_admin_charges_arrears as PF_ADMIN_CHARGES_ARREARS',
                 'vmt_employee_payslip_v2.employer_esi as EMPLOYER_ESI',
                 'vmt_employee_payslip_v2.employer_lwf as Employer_LWF',
                 'vmt_employee_payslip_v2.ctc as CTC',
                 'vmt_employee_payslip_v2.epf_ee as EPF_EE',
                 //VPF
                 'vmt_employee_payslip_v2.epf_ee_arrear as EPF_EE_ARREAR',
                 'vmt_employee_payslip_v2.employee_esic as EMPLOYEE_ESIC',
                 'vmt_employee_payslip_v2.prof_tax as PROF_TAX',
                 //'vmt_employee_payslip_v2.TDS',
                 //incomeTax
                 'vmt_employee_payslip_v2.sal_adv as SAL_ADV',
                 'vmt_employee_payslip_v2.canteen_dedn as CANTEEN_DEDN',
                 'vmt_employee_payslip_v2.other_deduc as OTHER_DEDUC',
                 'vmt_employee_payslip_v2.LWF',
                 'vmt_employee_payslip_v2.total_deductions as TOTAL_DEDUCTIONS',
                 'vmt_employee_payslip_v2.net_take_home as NET_TAKE_HOME'
        );

        // For Filter Option

        if($request->payroll_month!="all"){
            $payroll_data=$payroll_data->whereMonth('vmt_payroll.payroll_date',$request->payroll_month);
        }


        if($request->work_location !="all"){
            $payroll_data = $payroll_data->where('vmt_employee_office_details.work_location',$request->work_location);
        }

        if (session('client_id') != '1') {
            $payroll_data = $payroll_data-> where('users.client_id', session('client_id'));
            //return ($payroll_data);
        }

        //fetch bank names
        $payroll_data = $payroll_data->get();

        foreach($payroll_data as $singlePayrollData)
        {
            $singlePayrollData['bank_name'] = Bank::find($singlePayrollData->bank_id)->bank_name;
        }

        //dd($payroll_data->get());
        //dd( $payroll_data);
        return $payroll_data;
    }

}
