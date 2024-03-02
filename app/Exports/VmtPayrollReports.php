<?php

namespace App\Exports;

use App\Models\VmtEmployeePaySlip;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use App\Models\VmtEmployeePaySlipV2;

class VmtPayrollReports extends DefaultValueBinder implements FromCollection,WithColumnWidths,WithStyles,WithHeadings,
WithCustomValueBinder
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $payroll_month;

    function __construct($payroll_month)
    {
        $this->payroll_month = $payroll_month;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 27,
            'C' => 37.43,
            'D' => 11,
            'E' => 11,
            'F' => 12.5,
            'G' => 15.5,
            'H' => 13,
            'I' => 20,
            'J' => 25,
            'K' => 8,
            'L' => 14,
            'M' => 15.5,
            'N' => 14.5,
            'O' => 14.5,
            'P' => 35,
            'Q' => 10.5,
            'R' => 6.5,
            'S' => 6.5,
            'T' => 6.5,
            'U' => 7,
            'V' => 6.5,
            'W' => 6.5,
            'X' => 6.5,
            'Y' => 6.5,
            'Z' => 6.5,
            'BD' => 11.5,






        ];
    }


    public function bindValue(Cell $cell, $value)
    {
        {
            if (is_numeric($value)) {
                $cell->setValueExplicit($value, DataType::TYPE_STRING);

                return true;
            }

            // else return default behavior
            return parent::bindValue($cell, $value);
        }
    }

    public function headings():array{
        return[
            'Employee Code',
            'Employee Name',
            'Designation',
            'DOJ',
            'DOB',
            'Location',
            'Aadhaar Number',
            'PAN',
            'UAN',
            'EPF Number',
            'ESIC Number',
            'Bank Name',
            'Bank Account Number',
            'IFSC Code',
            'Mobile',
            'Email ID',
            'Payroll Month',
            'Basic',
            'HRA',
            'Special Allowance',
            'Total Fixed Gross',
            'ESIC Applicablity',
            'Month Days',
            'Worked Days',
            'Arrears Days',
            'LOP',
            'Basic',
            'BASIC Arrears',
            'HRA',
            'HRA Arrears',
            'Special Allowance',
            'SPL ALW Arrears',
            'Overtime',
            'Total Earned Gross',
            'PF Wages',
            'PF Wages Arrear',
            'EPFR',
            'EPFR Arrears',
            'EDLI Charges',
            'EDLI Charges Arrears',
            'PF Admin Charges',
            'PF Admin Charges Arrears',
            'Employer ESIC',
            'Employer LWF',
            'CTC',
            'EPF EE',
            'EPF EE Arrear',
            'Emplyee ESIC',
            'Professional Tax',
            'Salary Advance',
            'Canteen Deduction',
            'Other Deductions',
            'LWF',
            'Total Deductions',
           'Net'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

        ];
    }

    public function collection()
    {

     $query_payroll_data=VmtEmployeePaySlipV2::leftjoin('vmt_emp_payroll','vmt_emp_payroll.id','=','vmt_employee_payslip_v2.emp_payroll_id')
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
                    'vmt_employee_payslip_v2.pf_wages_arrear_epfr as PF_WAGES_ARREAR_EPFR',
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




       if (session('client_id') == '1')
        return $query_payroll_data->get();
       else
        return $query_payroll_data->where('users.client_id', session('client_id'))->get();


    }
}
