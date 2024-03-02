<?php

namespace App\Services;

use App\Models\AbsSalaryProjection;
use App\Models\VmtEmployee;
use App\Models\VmtEmployeePayroll;
use App\Models\VmtOrgTimePeriod;
use App\Models\VmtPaygroup;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use \DateTime;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Dompdf\Options;
use \stdClass;
use App\Models\User;
use App\Models\VmtInvFormSection;
use App\Models\VmtInvFEmpAssigned;
use App\Models\VmtPayroll;
use Carbon\CarbonPeriod;
use App\Models\VmtSnapchatEmpPaysheet;
use App\Models\VmtPayrollCycle;
use App\Models\VmtAttendanceCycle;
use App\Models\VmtDocuments;
use App\Models\VmtEmployeeDocuments;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Validation\Rule;


class VmtPayrollTaxService
{



    public function getEmpAnnualProjectionForPdf($user_id, $month)
    {

        $timeperiod = VmtOrgTimePeriod::where('status', '1')->first();
        $start_date = Carbon::parse($timeperiod->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($timeperiod->end_date)->format('Y-m-01');
        $end_date = Carbon::parse($end_date)->format('Y-m-d');
        $current_date = Carbon::now()->format('Y-m-01');
        $current_date_sub1 = Carbon::now()->subMonth()->format('Y-m-01');

        // dd($current_date_addM);

        $single_user_id = User::where('id', $user_id)->first();

        $payroll_date = VmtPayroll::where('payroll_date',  $month)->where('client_id', $single_user_id->client_id)->first();

        if (!empty($payroll_date)) {
            $emp_payroll = VmtEmployeePayroll::where('payroll_id', $payroll_date->id)->where('user_id', $user_id);
        }

        if ($emp_payroll->exists()) {
            $emp_payroll = $emp_payroll->first();
            $employee_projected_salary = AbsSalaryProjection::where('vmt_emp_payroll_id', $emp_payroll->id);
            $employee_projected = AbsSalaryProjection::where('vmt_emp_payroll_id', $emp_payroll->id);
        }

        $actual_months_datas  = $employee_projected_salary->whereBetween('payroll_months', [$start_date, $current_date_sub1]);
        $projection_months_datas  = $employee_projected->whereBetween('payroll_months', [$current_date, $end_date]);

        /*------------ sum of actual month salary --------------*/

        $employee_actual_details["Basic"] = $actual_months_datas->sum('earned_basic');
        $employee_actual_details["Basic Arrears"] = $actual_months_datas->sum('basic_arrear');
        $employee_actual_details["Dearness Allowance"] = $actual_months_datas->sum('dearness_allowance_earned');
        $employee_actual_details["Dearness Allowance Arrears"] = $actual_months_datas->sum('dearness_allowance_arrear');
        $employee_actual_details["Variable Dearness Allowance"] = $actual_months_datas->sum('vda_earned');
        $employee_actual_details["Variable Dearness Allowance Arrears"] = $actual_months_datas->sum('vda_arrear');
        $employee_actual_details["HRA"] = $actual_months_datas->sum('earned_hra');
        $employee_actual_details["HRA Arrears"] = $actual_months_datas->sum('hra_arrear');
        $employee_actual_details["Child Education Allowance"] = $actual_months_datas->sum('earned_child_edu_allowance');
        $employee_actual_details["Child Education Allowance Arrears"] = $actual_months_datas->sum('child_edu_allowance_arrear');
        $employee_actual_details["Statutory Bonus"] = $actual_months_datas->sum('earned_stats_bonus');
        $employee_actual_details["Statutory Bonus Arrears"] = $actual_months_datas->sum('earned_stats_arrear');
        $employee_actual_details["Medical Allowance"] = $actual_months_datas->sum('medical_allowance_earned');
        $employee_actual_details["Medical Allowance Arrears"] = $actual_months_datas->sum('medical_allowance_arrear');
        $employee_actual_details["Communicaton Allowance"] = $actual_months_datas->sum('communication_allowance_earned');
        $employee_actual_details["Communication Allowance Arrears"] = $actual_months_datas->sum('communication_allowance_arrear');
        $employee_actual_details["Leave Travel Allowance"] = $actual_months_datas->sum('earned_lta');
        $employee_actual_details["Leave Travel Allowance Arrears"] = $actual_months_datas->sum('lta_arrear');
        $employee_actual_details["Food Allowance"] = $actual_months_datas->sum('food_allowance_earned');
        $employee_actual_details["Food Allowance Arrears"] = $actual_months_datas->sum('food_allowance_arrear');
        $employee_actual_details["Special Allowance"] = $actual_months_datas->sum('earned_spl_alw');
        $employee_actual_details["Special Allowance Arrears"] = $actual_months_datas->sum('spl_alw_arrear');
        $employee_actual_details["Other Allowance"] = $actual_months_datas->sum('other_allowance_earned');
        $employee_actual_details["Other Allowance Arrears"] = $actual_months_datas->sum('other_allowance_arrear');
        $employee_actual_details["Washing Allowance"] = $actual_months_datas->sum('washing_allowance_earned');
        $employee_actual_details["Washing Allowance Arrears"] = $actual_months_datas->sum('washing_allowance_arrear');
        $employee_actual_details["Uniform Allowance"] = $actual_months_datas->sum('uniform_allowance_earned');
        $employee_actual_details["Uniform Allowance Arrears"] = $actual_months_datas->sum('uniform_allowance_arrear');
        $employee_actual_details["Vehicle Reimbursement"] = $actual_months_datas->sum('vehicle_reimbursement_earned');
        $employee_actual_details["Vehicle Reimbursement Arrears"] = $actual_months_datas->sum('vehicle_reimbursement_arrear');
        $employee_actual_details["Driver Salary Reimbursement"] = $actual_months_datas->sum('driver_salary_earned');
        $employee_actual_details["Driver Salary Reimbursement Arrears"] = $actual_months_datas->sum('driver_salary_arrear');
        $employee_actual_details["Professional Tax"] = $actual_months_datas->sum('prof_tax');
        $employee_actual_details["Income Tax"] = $actual_months_datas->sum('income_tax');
        $employee_actual_details["Overtime"] = $actual_months_datas->sum('overtime');
        $employee_actual_details["Overtime Arrears"] = $actual_months_datas->sum('overtime_arrear');
        $employee_actual_details["Incentive"] = $actual_months_datas->sum('incentive');
        $employee_actual_details["Other Earnings"] = $actual_months_datas->sum('other_earnings');
        $employee_actual_details["Referral Bonus"] = $actual_months_datas->sum('referral_bonus');
        $employee_actual_details["Annual Statutory Bonus"] = $actual_months_datas->sum('earned_stats_bonus');
        $employee_actual_details["Ex-Gratia"] = $actual_months_datas->sum('ex_gratia');
        $employee_actual_details["Attendance Bonus"] = $actual_months_datas->sum('attendance_bonus');
        $employee_actual_details["Daily Allowance"] = $actual_months_datas->sum('daily_allowance');
        $employee_actual_details["Leave Encashments"] = $actual_months_datas->sum('leave_encashment');
        $employee_actual_details["Gift"] = $actual_months_datas->sum('gift_payment');

        /* --------------------- sum of projection month salary ---------------*/

        $employee_projection_details["Basic"] = $projection_months_datas->sum('earned_basic');
        $employee_projection_details["Basic Arrears"] = $projection_months_datas->sum('basic_arrear');
        $employee_projection_details["Dearness Allowance"] = $projection_months_datas->sum('dearness_allowance_earned');
        $employee_projection_details["Dearness Allowance Arrears"] = $projection_months_datas->sum('dearness_allowance_arrear');
        $employee_projection_details["Variable Dearness Allowance"] = $projection_months_datas->sum('vda_earned');
        $employee_projection_details["Variable Dearness Allowance Arrears"] = $projection_months_datas->sum('vda_arrear');
        $employee_projection_details["HRA"] = $projection_months_datas->sum('earned_hra');
        $employee_projection_details["HRA Arrears"] = $projection_months_datas->sum('hra_arrear');
        $employee_projection_details["Child Education Allowance"] = $projection_months_datas->sum('earned_child_edu_allowance');
        $employee_projection_details["Child Education Allowance Arrears"] = $projection_months_datas->sum('child_edu_allowance_arrear');
        $employee_projection_details["Statutory Bonus"] = $projection_months_datas->sum('earned_stats_bonus');
        $employee_projection_details["Statutory Bonus Arrears"] = $projection_months_datas->sum('earned_stats_arrear');
        $employee_projection_details["Medical Allowance"] = $projection_months_datas->sum('medical_allowance_earned');
        $employee_projection_details["Medical Allowance Arrears"] = $projection_months_datas->sum('medical_allowance_arrear');
        $employee_projection_details["Communicaton Allowance"] = $projection_months_datas->sum('communication_allowance_earned');
        $employee_projection_details["Communication Allowance Arrears"] = $projection_months_datas->sum('communication_allowance_arrear');
        $employee_projection_details["Leave Travel Allowance"] = $projection_months_datas->sum('earned_lta');
        $employee_projection_details["Leave Travel Allowance Arrears"] = $projection_months_datas->sum('lta_arrear');
        $employee_projection_details["Food Allowance"] = $projection_months_datas->sum('food_allowance_earned');
        $employee_projection_details["Food Allowance Arrears"] = $projection_months_datas->sum('food_allowance_arrear');
        $employee_projection_details["Special Allowance"] = $projection_months_datas->sum('earned_spl_alw');
        $employee_projection_details["Special Allowance Arrears"] = $projection_months_datas->sum('spl_alw_arrear');
        $employee_projection_details["Other Allowance"] = $projection_months_datas->sum('other_allowance_earned');
        $employee_projection_details["Other Allowance Arrears"] = $projection_months_datas->sum('other_allowance_arrear');
        $employee_projection_details["Washing Allowance"] = $projection_months_datas->sum('washing_allowance_earned');
        $employee_projection_details["Washing Allowance Arrears"] = $projection_months_datas->sum('washing_allowance_arrear');
        $employee_projection_details["Uniform Allowance"] = $projection_months_datas->sum('uniform_allowance_earned');
        $employee_projection_details["Uniform Allowance Arrears"] = $projection_months_datas->sum('uniform_allowance_arrear');
        $employee_projection_details["Vehicle Reimbursement"] = $projection_months_datas->sum('vehicle_reimbursement_earned');
        $employee_projection_details["Vehicle Reimbursement Arrears"] = $projection_months_datas->sum('vehicle_reimbursement_arrear');
        $employee_projection_details["Driver Salary Reimbursement"] = $projection_months_datas->sum('driver_salary_earned');
        $employee_projection_details["Driver Salary Reimbursement Arrears"] = $projection_months_datas->sum('driver_salary_arrear');
        $employee_projection_details["Professional Tax"] = $projection_months_datas->sum('prof_tax');
        $employee_projection_details["Income Tax"] = $projection_months_datas->sum('income_tax');
        $employee_projection_details["Overtime"] = $projection_months_datas->sum('overtime');
        $employee_projection_details["Overtime Arrears"] = $projection_months_datas->sum('overtime_arrear');
        $employee_projection_details["Incentive"] = $projection_months_datas->sum('incentive');
        $employee_projection_details["Other Earnings"] = $projection_months_datas->sum('other_earnings');
        $employee_projection_details["Referral Bonus"] = $projection_months_datas->sum('referral_bonus');
        $employee_projection_details["Annual Statutory Bonus"] = $projection_months_datas->sum('earned_stats_bonus');
        $employee_projection_details["Ex-Gratia"] = $projection_months_datas->sum('ex_gratia');
        $employee_projection_details["Attendance Bonus"] = $projection_months_datas->sum('attendance_bonus');
        $employee_projection_details["Daily Allowance"] = $projection_months_datas->sum('daily_allowance');
        $employee_projection_details["Leave Encashments"] = $projection_months_datas->sum('leave_encashment');
        $employee_projection_details["Gift"] = $projection_months_datas->sum('gift_payment');


        /* --------------------- End ---------------*/



        //  if same key sum of actual and projection value

        $res = [];
        foreach ($employee_actual_details as $key => $value) {
            if (isset($employee_projection_details[$key])) {
                $res[$key]  =  $employee_projection_details[$key] + $employee_actual_details[$key];
            } else {
                $res[$key]  = $employee_actual_details[$key];
            }
        }

        return $res;
    }


    public function getEmployeeTDSWorksheet($user_code, $payroll_month, $output_format_type)
    {

        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
                'payroll_month' => $payroll_month,
                'output_format_type' => $output_format_type
            ],
            $rules = [
                'user_code' => 'required|exists:users,user_code',
                'payroll_month' => 'required|exists:vmt_payroll,payroll_date',
                'output_format_type' => ['required', Rule::in(['html', 'pdf'])],
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try
        {
            //Get the user id
            $user_id = User::where('user_code',$user_code)->first()->id;

            $inv_users = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->join('vmt_inv_f_emp_assigned', 'vmt_inv_f_emp_assigned.user_id', '=', 'users.id')
                ->where('vmt_inv_f_emp_assigned.user_id', $user_id)
                ->first([
                    'users.id',
                    'users.name',
                    'vmt_employee_details.pan_number as Pan Number',
                    'vmt_employee_office_details.designation as Designation',
                    'vmt_inv_f_emp_assigned.regime'
                ]);


            $v_form_template = VmtInvFormSection::leftjoin('vmt_inv_section', 'vmt_inv_section.id', '=', 'vmt_inv_formsection.section_id')
                ->leftjoin('vmt_inv_section_group', 'vmt_inv_section_group.id', '=', 'vmt_inv_section.sectiongroup_id')
                ->leftjoin('vmt_inv_emp_formdata', 'vmt_inv_emp_formdata.fs_id', '=', 'vmt_inv_formsection.id')
                ->leftjoin('vmt_inv_f_emp_assigned', 'vmt_inv_f_emp_assigned.id', '=', 'vmt_inv_emp_formdata.f_emp_id')
                ->leftjoin('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'vmt_inv_f_emp_assigned.user_id')
                ->leftjoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'vmt_employee_compensatory_details.user_id')
                ->where('vmt_inv_f_emp_assigned.user_id', $inv_users->id)
                ->get(
                    [
                        'vmt_inv_section_group.section_group',
                        'vmt_inv_section.section',
                        'vmt_inv_section.particular',
                        'vmt_inv_emp_formdata.dec_amount',
                        'vmt_inv_section.max_amount',
                        'vmt_inv_emp_formdata.json_popups_value',
                        'vmt_inv_f_emp_assigned.regime',
                        'vmt_inv_f_emp_assigned.updated_at',
                        'vmt_employee_compensatory_details.gross',
                        'vmt_employee_compensatory_details.basic',
                        'vmt_employee_compensatory_details.hra',
                        'vmt_employee_compensatory_details.special_allowance',
                        'vmt_employee_compensatory_details.professional_tax',
                        'vmt_employee_compensatory_details.child_education_allowance',
                        'vmt_employee_compensatory_details.lta',
                        'vmt_employee_details.doj',
                        'vmt_employee_details.dob',
                    ]
                )->toArray();

            $template_value = $v_form_template;


            $res = [
                "User_details" => [],
                "Gross_Earnings" => ["1) Gross Earnings" => []],
                "under_section_10" => ["2) Allowance to the extent exampt under section 10" => []],
                "Total_after_excemption" => ["3) Total after excemption (1 - 2)" => []],
                "Under_Previous_employment" => ["4) Taxable Income Under Previous employment" => []],
                "Gross_Total" => ["5) Gross Total (3 - 4)" => []],
                "Under_section_16" => ["6) Under section 16" => []],
                "Under_the_Head_Salaries" => ["7) Income Chargeable Under the Head Salaries (5 - 6)" => []],
                "reported_by_the_employee" => ["8) Any other income reported by the employee" => []],
                "Gross_Total_income" => ["9) Gross Total income" => []],
                "Decuction_Under_chapter_6a" => ["10) Decuction Under chapter VI - A" => []],
                "Total_income" => ["11) Total income (Round By 10 Rupees) (9 - 10)" => []],
                "Tax_Calculation" => ["12) Tax Calculation" => []],
                "Total_Tax_on_income" => ["13) Total Tax on income" => []],
                "Surcharge_amt" => [],
                "Relief_Under_Section_89" => ["14) Tax Payable including Education Cess minus of Relief Under Section 89" => []],
                "Source_us_192" => ["15) Tax Deduction at Source u/s 192" => []],
                "Hra_exception_calc" => [],
                "Final_result" => ["final_result_value" => []],
            ];

            // User Details

            $get_emp_annual =  $this->getEmpAnnualProjectionForPdf($user_id, $payroll_month);


            $emp_childrens_allow = $get_emp_annual['Child Education Allowance'] + $get_emp_annual['Child Education Allowance Arrears'];
            $emp_lta_allow = $get_emp_annual['Leave Travel Allowance'] + $get_emp_annual['Leave Travel Allowance Arrears'];

            array_push($res["User_details"], $inv_users->toArray());

            // 1) Gross Earnings

            $Gross_earnings['particulars']    = $this->getAnnualProjection($user_id, $payroll_month);
            $Gross_earnings['actual']    =  0;
            $Gross_earnings['projection']    = 0;
            $Gross_earnings['total']    = 0;

            array_push($res["Gross_Earnings"]["1) Gross Earnings"], $Gross_earnings);


            //  2) Allowance to the extent exampt under section 10

            $hra_excemption = $this->HraExceptionCalc($user_id, $payroll_month)['Total_Expect_amt'];

            $allowance_under_sec_10['particular'] = [
                "House Rent Allowance",
            ];

            $allowance_under_sec_10['actual'] = $hra_excemption;
            $allowance_under_sec_10['projection'] = ['Child Education Allowance' => $emp_childrens_allow, 'Leave Travel Allowance' => $emp_lta_allow];
            $allowance_under_sec_10['total'] = $allowance_under_sec_10['actual'] + $emp_childrens_allow + $emp_lta_allow;

            array_push($res["under_section_10"]["2) Allowance to the extent exampt under section 10"], $allowance_under_sec_10);



            // 3) Total after excemption (1 - 2);    - $allowance_under_sec_10['total']

            $total_after_exemption['total'] = $Gross_earnings['particulars']['Total Income'] - $allowance_under_sec_10['total'];
            array_push($res["Total_after_excemption"]["3) Total after excemption (1 - 2)"], $total_after_exemption);

            // 4) Taxable Income Under Previous employment
            $previous_gross = 0;
            $previous_pt = 0;
            $previous_std_deduction = 0;
            $previous_income_tax = 0;
            foreach ($v_form_template as $dec_amt) {
                if ($dec_amt['section_group'] == "Previous Employer Income") {

                    if ($dec_amt['particular'] == 'Previous Employer Gross') {
                        $previous_gross = $dec_amt['dec_amount'];
                    }
                    if ($dec_amt['particular'] == 'Previous Employer PT') {
                        $previous_pt =  $dec_amt['dec_amount'];
                    }
                    if ($dec_amt['particular'] == 'Previous Employer Standard Deduction') {
                        $previous_std_deduction +=  $dec_amt['dec_amount'];
                    }
                    if ($dec_amt['particular'] == 'Previous Employer Income Tax Deduction') {
                        $previous_income_tax +=  $dec_amt['dec_amount'];
                    }
                }
            }


            $taxincome_preEmployment['particular'] = [
                'i) Income After Exception' => $previous_gross,
                'ii) Less: Professional Tax' => $previous_pt,
            ];

            $taxincome_preEmployment['actual'] = 0;
            $taxincome_preEmployment['projection'] = 'Total taxable income under Previous employment';
            $taxincome_preEmployment['total'] = $previous_gross + $previous_pt;

            // dd($taxincome_preEmployment);

            array_push($res["Under_Previous_employment"]["4) Taxable Income Under Previous employment"], $taxincome_preEmployment);

            // 5) Gross Total (3 - 4)

            $Gross_total['total'] = $total_after_exemption['total'] + $taxincome_preEmployment['total'];
            array_push($res["Gross_Total"]["5) Gross Total (3 - 4)"], $Gross_total);

            // 6) Under section 16

            $professional_tax  =  $get_emp_annual['Professional Tax'];
            $Basic  =  $get_emp_annual['Basic'];
            $income_tax  =  $get_emp_annual['Income Tax'];

            $professinaltax = (($previous_pt ?? 0) + $professional_tax) > 2500 ? 2500 : $previous_pt + $professional_tax;
            $std_deduc = (($previous_std_deduction ?? 0) + $Basic) > 50000 ? 50000 : $previous_std_deduction + $Basic;

            $undersection['particulars'] =
                [
                    'a) Entertainment allowance' => 0,
                    'b) Tax on employment' => $professinaltax,
                    'c) Standard Deduction' => $std_deduc
                ];
            $undersection['Total Under Section 16'] = 0;
            $undersection['projection'] = 0;
            $undersection['total'] = $professinaltax + $std_deduc;


            array_push($res["Under_section_16"]["6) Under section 16"], $undersection);

            // 7) Income Chargeable Under the Head Salaries (5 - 6)

            $income_charge_head_salaries['total'] = $Gross_total['total'] - $undersection['total'];
            array_push($res["Under_the_Head_Salaries"]["7) Income Chargeable Under the Head Salaries (5 - 6)"], $income_charge_head_salaries);

            // dd($res);

            // 8) Any other income reported by the employee

            $property_type = [];
            $property_value = [];
            $SumOfHousPropsInOld = 0;
            foreach ($v_form_template as $dec_amt) {

                if ($dec_amt['section_group'] == "House Properties ") {

                    $totalIntersetPaid = (json_decode($dec_amt["json_popups_value"], true));
                    if ($totalIntersetPaid['property_type'] == 'Self Occupied Property') {
                        $property_type[] = $totalIntersetPaid['property_type'];
                        $property_value[]  = (-1 * $totalIntersetPaid['income_loss']);
                        $SumOfHousPropsInOld  += (-1 * $totalIntersetPaid['income_loss']);
                    }
                    if ($totalIntersetPaid['property_type'] == 'Let Out Property') {
                        $property_type[] = $totalIntersetPaid['property_type'];
                        $property_value[]  = $totalIntersetPaid['income_loss'];
                        $SumOfHousPropsInOld  += $totalIntersetPaid['income_loss'];
                    }
                    if ($totalIntersetPaid['property_type'] == 'Deemed Let Out Property') {
                        $property_type[] = $totalIntersetPaid['property_type'];
                        $property_value[]  = $totalIntersetPaid['income_loss'];
                        $SumOfHousPropsInOld  += $totalIntersetPaid['income_loss'];
                    }
                }
            }
            // dd($SumOfHousPropsInOld);


            if (-200000 > $SumOfHousPropsInOld) {
                $sumofhouseproperty = -200000;
            } else {
                $sumofhouseproperty = $SumOfHousPropsInOld;
            }


            $other_income_report['particular'] = $property_type;
            $other_income_report['actual'] = $property_value;
            $other_income_report['projection'] = 0;
            $other_income_report['total'] = $sumofhouseproperty;

            array_push($res["reported_by_the_employee"]["8) Any other income reported by the employee"], $other_income_report);


            // 9) Gross Total income

            $gorsstotalincome['total'] = $income_charge_head_salaries['total'] + $other_income_report['total'];
            array_push($res["Gross_Total_income"]["9) Gross Total income"], $gorsstotalincome);

            $dec_amount80c = 0;
            $count = 0;
            foreach ($v_form_template as $dec_amt) {
                if ($dec_amt['section_group'] == "Section 80C & 80CC ") {

                    $dec_amount80c += $dec_amt['dec_amount'];

                    if (!array_key_exists($dec_amt["section"], $v_form_template)) {
                        $v_form_template[$dec_amt["section"]] = array();
                        array_push($v_form_template[$dec_amt["section"]], $dec_amt);
                    } else {
                        array_push($v_form_template[$dec_amt["section"]], $dec_amt);
                    }
                }
                //remove from outer json
                unset($v_form_template[$count]);
                $count++;
            }


            $sumof_max80ccd1 = 0;
            $sumof_dec80ccd1 = 0;
            $sumof_max80ccd2 = 0;
            $sumof_dec80ccd2 = 0;
            $sumof_max80d = 0;
            $sumof_dec80d = 0;
            $sumof_max80dd = 0;
            $sumof_dec80dd = 0;
            $sumof_max80ddb = 0;
            $sumof_dec80ddb = 0;
            $sumof_max80u = 0;
            $sumof_dec80u = 0;
            $sumof_max80e = 0;
            $sumof_dec80e = 0;
            $sumof_max80ee = 0;
            $sumof_dec80ee = 0;
            $sumof_max80eea = 0;
            $sumof_dec80eea = 0;
            $sumof_max80eeb = 0;
            $sumof_dec80eeb = 0;
            $sumof_max80g = 0;
            $sumof_dec80g = 0;
            $sumof_max80tta = 0;
            $sumof_dec80tta = 0;
            $sumof_max80ttb = 0;
            $sumof_dec80ttb = 0;


            $count = 0;
            foreach ($template_value as $dec_amt) {
                if ($dec_amt['section_group'] == "Other Excemptions ") {
                    //    dd($dec_amt);

                    if ($dec_amt['section'] == '80CCD (1B)') {
                        $sumof_max80ccd1  += $dec_amt['max_amount'];
                        $sumof_dec80ccd1  += $dec_amt['dec_amount'];
                    }

                    if ($dec_amt['section'] == '80CCD (2)') {
                        $sumof_max80ccd2 += $dec_amt['max_amount'];
                        $sumof_dec80ccd2 += $dec_amt['dec_amount'];
                    }

                    if ($dec_amt['section'] == '80D') {
                        $sumof_max80d  += $dec_amt['max_amount'];
                        $sumof_dec80d  += $dec_amt['dec_amount'];
                    }

                    if ($dec_amt['section'] == '80DD') {
                        $sumof_max80dd  += $dec_amt['max_amount'];
                        $sumof_dec80dd  += $dec_amt['dec_amount'];
                    }

                    if ($dec_amt['section'] == '80DDB') {
                        $sumof_max80ddb  += $dec_amt['max_amount'];
                        $sumof_dec80ddb  += $dec_amt['dec_amount'];
                    }

                    if ($dec_amt['section'] == '80U') {
                        $sumof_max80u  += $dec_amt['max_amount'];
                        $sumof_dec80u  += $dec_amt['dec_amount'];
                    }

                    if ($dec_amt['section'] == '80E') {
                        $sumof_max80e  += $dec_amt['max_amount'];
                        $sumof_dec80e  += $dec_amt['dec_amount'];
                    }

                    if ($dec_amt['section'] == '80EE') {
                        $sumof_max80ee  += $dec_amt['max_amount'];
                        $sumof_dec80ee  += $dec_amt['dec_amount'];
                    }

                    if ($dec_amt['section'] == '80EEA') {
                        $sumof_max80eea  += $dec_amt['max_amount'];
                        $sumof_dec80eea  += $dec_amt['dec_amount'];
                    }

                    if ($dec_amt['section'] == '80EEB') {
                        $sumof_max80eeb  += $dec_amt['max_amount'];
                        $sumof_dec80eeb  += $dec_amt['dec_amount'];
                    }

                    if ($dec_amt['section'] == '80G') {
                        $sumof_max80g  += $dec_amt['max_amount'];
                        $sumof_dec80g  += $dec_amt['dec_amount'];
                    }

                    if ($dec_amt['section'] == '80TTA') {
                        $sumof_max80tta  += $dec_amt['max_amount'];
                        $sumof_dec80tta  += $dec_amt['dec_amount'];
                    }

                    if ($dec_amt['section'] == '80TTB') {
                        $sumof_max80ttb  += $dec_amt['max_amount'];
                        $sumof_dec80ttb  += $dec_amt['dec_amount'];
                    }

                    if (!array_key_exists($dec_amt["section"], $template_value)) {
                        $template_value[$dec_amt["section"]] = array();
                        array_push($template_value[$dec_amt["section"]], $dec_amt);
                    } else {
                        array_push($template_value[$dec_amt["section"]], $dec_amt);
                    }
                }
                //remove from outer json
                unset($template_value[$count]);
                $count++;
            }

            if ($sumof_max80g == 0) {
                $value_of_80g = $sumof_dec80g;
            } elseif ($sumof_dec80g < $sumof_max80g) {
                $value_of_80g = $sumof_max80g;
            }

            $sum_of_section_amt['80CCD (1B)'] = $sumof_dec80ccd1  > $sumof_max80ccd1 ? $sumof_max80ccd1 : $sumof_dec80ccd1;
            $sum_of_section_amt['80CCD (2)'] =  $sumof_dec80ccd2 > $sumof_max80ccd2 ? $sumof_max80ccd2 : $sumof_dec80ccd2;
            $sum_of_section_amt['80D'] =  $sumof_dec80d > $sumof_max80d ? $sumof_max80d : $sumof_dec80d;
            $sum_of_section_amt['80DD'] =  $sumof_dec80dd > $sumof_max80dd ? $sumof_max80dd : $sumof_dec80dd;
            $sum_of_section_amt['80DDB'] = $sumof_dec80ddb > $sumof_max80ddb ? $sumof_max80ddb : $sumof_dec80ddb;
            $sum_of_section_amt['80U'] = $sumof_dec80u > $sumof_max80u ? $sumof_max80u : $sumof_dec80u;
            $sum_of_section_amt['80E'] = $sumof_dec80e > $sumof_max80e ? $sumof_max80e : $sumof_dec80e;
            $sum_of_section_amt['80EE'] = $sumof_dec80ee > $sumof_max80ee ? $sumof_max80ee : $sumof_dec80ee;
            $sum_of_section_amt['80EEA'] = $sumof_dec80eea > $sumof_max80eea ? $sumof_max80eea : $sumof_dec80eea;
            $sum_of_section_amt['80EEB'] = $sumof_dec80eeb > $sumof_max80eeb ? $sumof_max80eeb : $sumof_dec80eeb;
            $sum_of_section_amt['80G'] = $value_of_80g;
            $sum_of_section_amt['80TTA'] = $sumof_dec80tta > $sumof_max80tta ? $sumof_max80tta : $sumof_dec80tta;
            $sum_of_section_amt['80TTB'] =  $sumof_dec80ttb > $sumof_max80ttb ? $sumof_max80ttb : $sumof_dec80ttb;

            $sumofotherexception = 0;
            foreach ($sum_of_section_amt as $key => $single_value) {
                $sumofotherexception += $single_value;
            }

            $total_of_chapterVIa = (int)$sumofotherexception + ($dec_amount80c > 150000 ? 150000 : $dec_amount80c);

            // dd($sum_of_section_amt);

            // 10) Decuction Under chapter VI - A

            $deductablecapterVIA['particular'] = [$v_form_template, $template_value, 'Total of Deduction under Chapter VI-A'];
            $deductablecapterVIA['Total(80C+80CCC+80CCD)'] = $dec_amount80c > 150000 ? 150000 : $dec_amount80c;
            $deductablecapterVIA['projection'] = $sum_of_section_amt;
            $deductablecapterVIA['total_of_chapterVIa'] = $total_of_chapterVIa;
            array_push($res["Decuction_Under_chapter_6a"]["10) Decuction Under chapter VI - A"], $deductablecapterVIA);

            // 11) Total income (Round By 10 Rupees) (9 - 10)

            $total_income_9_10['total'] = $gorsstotalincome['total'] - $deductablecapterVIA['total_of_chapterVIa'];
            array_push($res["Total_income"]["11) Total income (Round By 10 Rupees) (9 - 10)"], $total_income_9_10);

            // dd($total_income_9_10);
            // 12) Tax Calculation

            $employee = VmtEmployee::where('userid', $user_id)->first();
            $get_age = Carbon::createFromDate($employee->dob)->diff(Carbon::now())->format('%y');
            $emp_assign =  VmtInvFEmpAssigned::where('user_id', $user_id)->first();

            if ($emp_assign->regime == "old" || $emp_assign->regime == "") {
                $tax_amount = $this->oldRegimeTaxCalc($total_income_9_10['total'], $get_age);
            } else if ($emp_assign->regime == "new") {
                $tax_amount =  $this->newRegimeTaxCalc($total_income_9_10['total']);
            }

            $tax_calculation['particular'] = $tax_amount;
            $tax_calculation['actual'] = 0;
            $tax_calculation['projection'] = 0;
            $tax_calculation['total'] = 0;
            array_push($res["Tax_Calculation"]["12) Tax Calculation"], $tax_calculation);

            // 13) Total Tax on income
            // dd($tax_calculation);

            $total_tax_income['total'] = $tax_calculation['particular']['Tax on total Income'] ?? 0;
            $total_tax_income1 = $tax_calculation['particular']['Tax on total Income'] ?? 0;
            array_push($res["Total_Tax_on_income"]["13) Total Tax on income"], $total_tax_income);

            // 14) Tax Payable including Education Cess minus of Relief Under Section 89

            $surcharge_amount['surchage Amount'] = $this->subChargeCalculation($total_tax_income1);
            $surcharge_amount['Education Cess 4% of ' . $total_tax_income1] = $total_tax_income1 * 0.04;
            $surcharge_amount['Less : Releif Under Section 89'] = 0;
            array_push($res["Surcharge_amt"], $surcharge_amount);

            $sumofhealthcess = 0;
            foreach ($surcharge_amount as $single_value) {
                $sumofhealthcess  += $single_value;
            }

            $tax_payable_ecucation['total'] = $sumofhealthcess + $total_tax_income1;
            array_push($res["Relief_Under_Section_89"]["14) Tax Payable including Education Cess minus of Relief Under Section 89"], $tax_payable_ecucation);

            // 15) Tax Deduction at Source u/s 192
            $current_month =  Carbon::parse($payroll_month)->addMonth()->format('F');

            $timeperiod = VmtOrgTimePeriod::where('status', '1')->first();
            $end_date = Carbon::parse($timeperiod->end_date);
            $end_date = Carbon::parse($end_date)->floorMonth();
            $current = Carbon::now()->floorMonth();

            $diffmonths = $current->diffInMonths($end_date) + 1;

            $tax_deduction_192['i) TDS till last month'] = $income_tax;
            $tax_deduction_192['ii) TDS for ' . $current_month] = $tax_payable_ecucation['total'] / $diffmonths;
            $tax_deduction_192['iii) TDS by Previous Employer'] = $previous_income_tax;
            $tax_deduction_192['A) Total Tax Deduction at Source (i + ii + iii)'] =  ($income_tax) + ($tax_payable_ecucation['total'] / $diffmonths) + ($previous_income_tax);
            $tax_deduction_192['Tax Payable / Refundable (14 - 15(A))'] = ($tax_payable_ecucation['total']) - (($income_tax) + ($tax_payable_ecucation['total'] / $diffmonths) + ($previous_income_tax));

            array_push($res["Source_us_192"]["15) Tax Deduction at Source u/s 192"], $tax_deduction_192);

            // hra exception calcuation

            array_push($res["Hra_exception_calc"], $this->HraExceptionCalc($user_id, $payroll_month));

            // final result

            $tax_final_result['TDS for ' . $current_month] = $tax_payable_ecucation['total'] / $diffmonths;

            array_push($res["Final_result"]["final_result_value"], $tax_final_result);


            // dd($res);

            $html = view('investmentTdsWorkSheet.TDS_work_sheet', $res);

            if($output_format_type == 'html')
            {
                return $html;
            }
            else
            {
                $options = new Options();
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isRemoteEnabled', true);

                $pdf = new Dompdf($options);
                $pdf->loadhtml($html, 'UTF-8');
                $pdf->setPaper('A4', 'portrait');
                $pdf->render();

                $pdf->stream('tds_pdf');

            }
        }
        catch(\Exception $e){
            return response()->json([
                "status" => "failure",
                "message" => "Error while fetching the TDS worksheet data for the user_code : ".$user_code,
                "data" => "",
                "error" =>$e->getMessage().' | Line : '.$e->getLine(),
                "error_verbose" => $e->getTraceAsString(),
           ],400);
        }
    }



    public function annualProjection()
    {

        $user_id = '144';
        $payroll_date = VmtPayroll::where('payroll_date', '2023-04-01')->where('client_id', '3')->first();
        $emp_payroll = VmtEmployeePayroll::where('payroll_id', $payroll_date->id)->where('user_id', $user_id)->first();
        $timeperiod = VmtOrgTimePeriod::where('status', '1')->first();
        $start_date = Carbon::parse($timeperiod->start_date)->subMonth(1);
        $end_date = Carbon::parse($timeperiod->end_date);
        $current_date = Carbon::now();

        $res = [];
        while ($start_date->lte($end_date)) {

            $start_date = Carbon::parse($start_date)->addMonth();
            if ($start_date->lt($current_date)) {

                $payslip_data = User::join('vmt_emp_payroll', 'vmt_emp_payroll.user_id', '=', 'users.id')
                    ->join('vmt_payroll', 'vmt_payroll.id', '=', 'vmt_emp_payroll.payroll_id')
                    ->join('vmt_employee_payslip_v2', 'vmt_employee_payslip_v2.emp_payroll_id', '=', 'vmt_emp_payroll.id')
                    ->where('vmt_emp_payroll.user_id', $user_id)
                    ->where('payroll_date', $start_date)
                    ->first();

                if ($payslip_data) {
                    $salary_project_data = new AbsSalaryProjection;
                    $salary_project_data->vmt_emp_payroll_id = $emp_payroll->id;
                    $salary_project_data->earned_basic = $payslip_data['earned_basic'];
                    $salary_project_data->earned_hra = $payslip_data['earned_hra'];
                    $salary_project_data->earned_child_edu_allowance = $payslip_data['earned_child_edu_allowance'];
                    $salary_project_data->earned_spl_alw = $payslip_data['earned_spl_alw'];
                    $salary_project_data->total_earned_gross = $payslip_data['total_earned_gross'];
                    $salary_project_data->save();
                }

                array_push($res, $payslip_data);
            } else {

                $compensatory_details = User::join('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'users.id')
                    ->where('user_id', $user_id)->first();

                $salary_project_data = new AbsSalaryProjection;
                $salary_project_data->vmt_emp_payroll_id = $emp_payroll->id;
                $salary_project_data->earned_basic = $compensatory_details['basic'];
                $salary_project_data->earned_hra = $compensatory_details['hra'];
                $salary_project_data->earned_child_edu_allowance = $compensatory_details['child_education_allowance'];
                $salary_project_data->earned_spl_alw = $compensatory_details['special_allowance'];
                $salary_project_data->total_earned_gross = $compensatory_details['gross'];
                $salary_project_data->save();

                array_push($res, $compensatory_details);
            }
        }
        dd("saved");
    }

    public function getAnnualProjection($user_id, $month)
    {

        $timeperiod = VmtOrgTimePeriod::where('status', '1')->first();
        $start_date = Carbon::parse($timeperiod->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($timeperiod->end_date)->format('Y-m-01');
        $end_date = Carbon::parse($end_date)->format('Y-m-d');
        $current_date = Carbon::now()->format('Y-m-01');
        $current_date_sub1 = Carbon::now()->subMonth()->format('Y-m-01');

        // dd($current_date_addM);

        $single_user_id = User::where('id', $user_id)->first();

        $payroll_date = VmtPayroll::where('payroll_date',  $month)->where('client_id', $single_user_id->client_id)->first();

        if (!empty($payroll_date)) {
            $emp_payroll = VmtEmployeePayroll::where('payroll_id', $payroll_date->id)->where('user_id', $user_id);
        }

        if ($emp_payroll->exists()) {
            $emp_payroll = $emp_payroll->first();
            $employee_projected_salary = AbsSalaryProjection::where('vmt_emp_payroll_id', $emp_payroll->id);
            $employee_projected = AbsSalaryProjection::where('vmt_emp_payroll_id', $emp_payroll->id);
        }

        $actual_months_datas  = $employee_projected_salary->whereBetween('payroll_months', [$start_date, $current_date_sub1]);
        $projection_months_datas  = $employee_projected->whereBetween('payroll_months', [$current_date, $end_date]);

        /*------------ sum of actual month salary --------------*/

        $employee_actual_details["Basic"] = $actual_months_datas->sum('earned_basic');
        $employee_actual_details["Basic Arrears"] = $actual_months_datas->sum('basic_arrear');
        $employee_actual_details["Dearness Allowance"] = $actual_months_datas->sum('dearness_allowance_earned');
        $employee_actual_details["Dearness Allowance Arrears"] = $actual_months_datas->sum('dearness_allowance_arrear');
        $employee_actual_details["Variable Dearness Allowance"] = $actual_months_datas->sum('vda_earned');
        $employee_actual_details["Variable Dearness Allowance Arrears"] = $actual_months_datas->sum('vda_arrear');
        $employee_actual_details["HRA"] = $actual_months_datas->sum('earned_hra');
        $employee_actual_details["HRA Arrears"] = $actual_months_datas->sum('hra_arrear');
        $employee_actual_details["Child Education Allowance"] = $actual_months_datas->sum('earned_child_edu_allowance');
        $employee_actual_details["Child Education Allowance Arrears"] = $actual_months_datas->sum('child_edu_allowance_arrear');
        $employee_actual_details["Statutory Bonus"] = $actual_months_datas->sum('earned_stats_bonus');
        $employee_actual_details["Statutory Bonus Arrears"] = $actual_months_datas->sum('earned_stats_arrear');
        $employee_actual_details["Medical Allowance"] = $actual_months_datas->sum('medical_allowance_earned');
        $employee_actual_details["Medical Allowance Arrears"] = $actual_months_datas->sum('medical_allowance_arrear');
        $employee_actual_details["Communicaton Allowance"] = $actual_months_datas->sum('communication_allowance_earned');
        $employee_actual_details["Communication Allowance Arrears"] = $actual_months_datas->sum('communication_allowance_arrear');
        $employee_actual_details["Leave Travel Allowance"] = $actual_months_datas->sum('earned_lta');
        $employee_actual_details["Leave Travel Allowance Arrears"] = $actual_months_datas->sum('lta_arrear');
        $employee_actual_details["Food Allowance"] = $actual_months_datas->sum('food_allowance_earned');
        $employee_actual_details["Food Allowance Arrears"] = $actual_months_datas->sum('food_allowance_arrear');
        $employee_actual_details["Special Allowance"] = $actual_months_datas->sum('earned_spl_alw');
        $employee_actual_details["Special Allowance Arrears"] = $actual_months_datas->sum('spl_alw_arrear');
        $employee_actual_details["Other Allowance"] = $actual_months_datas->sum('other_allowance_earned');
        $employee_actual_details["Other Allowance Arrears"] = $actual_months_datas->sum('other_allowance_arrear');
        $employee_actual_details["Washing Allowance"] = $actual_months_datas->sum('washing_allowance_earned');
        $employee_actual_details["Washing Allowance Arrears"] = $actual_months_datas->sum('washing_allowance_arrear');
        $employee_actual_details["Uniform Allowance"] = $actual_months_datas->sum('uniform_allowance_earned');
        $employee_actual_details["Uniform Allowance Arrears"] = $actual_months_datas->sum('uniform_allowance_arrear');
        $employee_actual_details["Vehicle Reimbursement"] = $actual_months_datas->sum('vehicle_reimbursement_earned');
        $employee_actual_details["Vehicle Reimbursement Arrears"] = $actual_months_datas->sum('vehicle_reimbursement_arrear');
        $employee_actual_details["Driver Salary Reimbursement"] = $actual_months_datas->sum('driver_salary_earned');
        $employee_actual_details["Driver Salary Reimbursement Arrears"] = $actual_months_datas->sum('driver_salary_arrear');
        $professinal_income["Professional Tax"] = $actual_months_datas->sum('prof_tax');
        $professinal_income["Income Tax"] = $actual_months_datas->sum('income_tax');
        $employee_actual_details["Overtime"] = $actual_months_datas->sum('overtime');
        $employee_actual_details["Overtime Arrears"] = $actual_months_datas->sum('overtime_arrear');
        $employee_actual_details["Incentive"] = $actual_months_datas->sum('incentive');
        $employee_actual_details["Other Earnings"] = $actual_months_datas->sum('other_earnings');
        $employee_actual_details["Referral Bonus"] = $actual_months_datas->sum('referral_bonus');
        $employee_actual_details["Annual Statutory Bonus"] = $actual_months_datas->sum('earned_stats_bonus');
        $employee_actual_details["Ex-Gratia"] = $actual_months_datas->sum('ex_gratia');
        $employee_actual_details["Attendance Bonus"] = $actual_months_datas->sum('attendance_bonus');
        $employee_actual_details["Daily Allowance"] = $actual_months_datas->sum('daily_allowance');
        $employee_actual_details["Leave Encashments"] = $actual_months_datas->sum('leave_encashment');
        $employee_actual_details["Gift"] = $actual_months_datas->sum('gift_payment');

        /* --------------------- sum of projection month salary ---------------*/

        $employee_projection_details["Basic"] = $projection_months_datas->sum('earned_basic');
        $employee_projection_details["Basic Arrears"] = $projection_months_datas->sum('basic_arrear');
        $employee_projection_details["Dearness Allowance"] = $projection_months_datas->sum('dearness_allowance_earned');
        $employee_projection_details["Dearness Allowance Arrears"] = $projection_months_datas->sum('dearness_allowance_arrear');
        $employee_projection_details["Variable Dearness Allowance"] = $projection_months_datas->sum('vda_earned');
        $employee_projection_details["Variable Dearness Allowance Arrears"] = $projection_months_datas->sum('vda_arrear');
        $employee_projection_details["HRA"] = $projection_months_datas->sum('earned_hra');
        $employee_projection_details["HRA Arrears"] = $projection_months_datas->sum('hra_arrear');
        $employee_projection_details["Child Education Allowance"] = $projection_months_datas->sum('earned_child_edu_allowance');
        $employee_projection_details["Child Education Allowance Arrears"] = $projection_months_datas->sum('child_edu_allowance_arrear');
        $employee_projection_details["Statutory Bonus"] = $projection_months_datas->sum('earned_stats_bonus');
        $employee_projection_details["Statutory Bonus Arrears"] = $projection_months_datas->sum('earned_stats_arrear');
        $employee_projection_details["Medical Allowance"] = $projection_months_datas->sum('medical_allowance_earned');
        $employee_projection_details["Medical Allowance Arrears"] = $projection_months_datas->sum('medical_allowance_arrear');
        $employee_projection_details["Communicaton Allowance"] = $projection_months_datas->sum('communication_allowance_earned');
        $employee_projection_details["Communication Allowance Arrears"] = $projection_months_datas->sum('communication_allowance_arrear');
        $employee_projection_details["Leave Travel Allowance"] = $projection_months_datas->sum('earned_lta');
        $employee_projection_details["Leave Travel Allowance Arrears"] = $projection_months_datas->sum('lta_arrear');
        $employee_projection_details["Food Allowance"] = $projection_months_datas->sum('food_allowance_earned');
        $employee_projection_details["Food Allowance Arrears"] = $projection_months_datas->sum('food_allowance_arrear');
        $employee_projection_details["Special Allowance"] = $projection_months_datas->sum('earned_spl_alw');
        $employee_projection_details["Special Allowance Arrears"] = $projection_months_datas->sum('spl_alw_arrear');
        $employee_projection_details["Other Allowance"] = $projection_months_datas->sum('other_allowance_earned');
        $employee_projection_details["Other Allowance Arrears"] = $projection_months_datas->sum('other_allowance_arrear');
        $employee_projection_details["Washing Allowance"] = $projection_months_datas->sum('washing_allowance_earned');
        $employee_projection_details["Washing Allowance Arrears"] = $projection_months_datas->sum('washing_allowance_arrear');
        $employee_projection_details["Uniform Allowance"] = $projection_months_datas->sum('uniform_allowance_earned');
        $employee_projection_details["Uniform Allowance Arrears"] = $projection_months_datas->sum('uniform_allowance_arrear');
        $employee_projection_details["Vehicle Reimbursement"] = $projection_months_datas->sum('vehicle_reimbursement_earned');
        $employee_projection_details["Vehicle Reimbursement Arrears"] = $projection_months_datas->sum('vehicle_reimbursement_arrear');
        $employee_projection_details["Driver Salary Reimbursement"] = $projection_months_datas->sum('driver_salary_earned');
        $employee_projection_details["Driver Salary Reimbursement Arrears"] = $projection_months_datas->sum('driver_salary_arrear');
        $professinal_income["Professional Tax"] = $projection_months_datas->sum('prof_tax');
        $professinal_income["Income Tax"] = $projection_months_datas->sum('income_tax');
        $employee_projection_details["Overtime"] = $projection_months_datas->sum('overtime');
        $employee_projection_details["Overtime Arrears"] = $projection_months_datas->sum('overtime_arrear');
        $employee_projection_details["Incentive"] = $projection_months_datas->sum('incentive');
        $employee_projection_details["Other Earnings"] = $projection_months_datas->sum('other_earnings');
        $employee_projection_details["Referral Bonus"] = $projection_months_datas->sum('referral_bonus');
        $employee_projection_details["Annual Statutory Bonus"] = $projection_months_datas->sum('earned_stats_bonus');
        $employee_projection_details["Ex-Gratia"] = $projection_months_datas->sum('ex_gratia');
        $employee_projection_details["Attendance Bonus"] = $projection_months_datas->sum('attendance_bonus');
        $employee_projection_details["Daily Allowance"] = $projection_months_datas->sum('daily_allowance');
        $employee_projection_details["Leave Encashments"] = $projection_months_datas->sum('leave_encashment');
        $employee_projection_details["Gift"] = $projection_months_datas->sum('gift_payment');


        /* --------------------- End ---------------*/


        // remove empty and null value in actual data

        foreach ($employee_actual_details as $key => $single_details) {
            if ($single_details == "0" || $single_details == null || $single_details == 0) {
                unset($employee_actual_details[$key]);
            }
        }

        // remove empty and null value in projection data

        foreach ($employee_projection_details as $key => $single_details) {
            if ($single_details == "0" || $single_details == null) {
                unset($employee_projection_details[$key]);
            }
        }

        // if diff key set zero value

        $emp_projection_value = [];
        foreach ($employee_actual_details as $key => $value) {
            if (isset($employee_projection_details[$key])) {
                $emp_projection_value[$key]  =  $employee_projection_details[$key];
            } else {
                $emp_projection_value[$key]  = 0;
            }
        }


        //  if same key sum of actual and projection value

        $res = [];
        foreach ($employee_actual_details as $key => $value) {
            if (isset($emp_projection_value[$key])) {
                $res[$key]  =  $emp_projection_value[$key] + $employee_actual_details[$key];
            } else {
                $res[$key]  = $employee_actual_details[$key];
            }
        }

        // sum of array value

        $total_income  = array_sum(array_values($res));


        return (["Actual" => $employee_actual_details, "Projection" => $emp_projection_value, "Total" => $res, "Total Income" => $total_income]);
    }


    public function HraExceptionCalc($user_id, $month)
    {

        $timeperiod = VmtOrgTimePeriod::where('status', '1')->first();
        $start_date = Carbon::parse($timeperiod->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($timeperiod->end_date)->format('Y-m-01');
        $end_date = Carbon::parse($end_date)->format('Y-m-d');

        $date_range = CarbonPeriod::create($start_date, '1 month', $end_date);


        $date = [];
        foreach ($date_range as $key => $value) {
            $date[] = $value->format('M Y');
        }

        $single_user_id = User::where('id', $user_id)->first();

        $payroll_date = VmtPayroll::where('payroll_date',  $month)->where('client_id', $single_user_id->client_id)->first();

        if (!empty($payroll_date)) {
            $emp_payroll = VmtEmployeePayroll::where('payroll_id', $payroll_date->id)->where('user_id', $user_id);
        }

        if ($emp_payroll->exists()) {
            $emp_payroll = $emp_payroll->first();
            $employee_projected_salary = AbsSalaryProjection::where('vmt_emp_payroll_id', $emp_payroll->id)->get([
                'earned_basic',
                'basic_arrear',
                'earned_hra',
                'hra_arrear'
            ]);
        }

        $v_form_template = VmtInvFormSection::leftjoin('vmt_inv_section', 'vmt_inv_section.id', '=', 'vmt_inv_formsection.section_id')
            ->leftjoin('vmt_inv_section_group', 'vmt_inv_section_group.id', '=', 'vmt_inv_section.sectiongroup_id')
            ->leftjoin('vmt_inv_emp_formdata', 'vmt_inv_emp_formdata.fs_id', '=', 'vmt_inv_formsection.id')
            ->leftjoin('vmt_inv_f_emp_assigned', 'vmt_inv_f_emp_assigned.id', '=', 'vmt_inv_emp_formdata.f_emp_id')
            ->leftjoin('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'vmt_inv_f_emp_assigned.user_id')
            ->leftjoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'vmt_employee_compensatory_details.user_id')
            ->where('vmt_inv_f_emp_assigned.user_id', $user_id)
            ->get(
                [
                    'vmt_inv_section_group.section_group',
                    'vmt_inv_section.section',
                    'vmt_inv_section.particular',
                    'vmt_inv_emp_formdata.dec_amount',
                    'vmt_inv_section.max_amount',
                    'vmt_inv_emp_formdata.json_popups_value',
                    'vmt_inv_f_emp_assigned.regime',
                    'vmt_inv_f_emp_assigned.updated_at',
                    'vmt_employee_compensatory_details.gross',
                    'vmt_employee_compensatory_details.basic',
                    'vmt_employee_compensatory_details.hra',
                    'vmt_employee_compensatory_details.special_allowance',
                    'vmt_employee_compensatory_details.professional_tax',
                    'vmt_employee_compensatory_details.child_education_allowance',
                    'vmt_employee_compensatory_details.lta',
                    'vmt_employee_details.doj',
                    'vmt_employee_details.dob',
                ]
            )->toArray();

        $json_rentpaid = 0;
        foreach ($v_form_template as $single_value) {
            if ($single_value['section_group'] == "HRA") {
                $json_rent = json_decode($single_value['json_popups_value'], true);
                $json_rentpaid  += $json_rent['total_rent_paid'];
            }
        }

        foreach ($employee_projected_salary as $key => $single_value) {
            $emp_salary_hra[$key]['date'] = $date[$key];
            $emp_salary_hra[$key]['Basic'] = ($employee_projected_salary[$key]['earned_basic'] + $employee_projected_salary[$key]['basic_arrear']) * 0.50;
            $emp_salary_hra[$key]['Hra'] = $employee_projected_salary[$key]['earned_hra'] + $employee_projected_salary[$key]['hra_arrear'];
            $emp_salary_hra[$key]['excess_of_rent_paid'] =   ($json_rentpaid / 12) - (($employee_projected_salary[$key]['earned_basic'] + $employee_projected_salary[$key]['basic_arrear']) * 0.10);
            $emp_salary_hra[$key]['Excemption_amount'] =   $json_rentpaid == 0 ? 0 : min([($employee_projected_salary[$key]['earned_basic'] + $employee_projected_salary[$key]['basic_arrear']) * 0.50,  $employee_projected_salary[$key]['earned_hra'] + $employee_projected_salary[$key]['hra_arrear'], (($json_rentpaid / 12) - (($employee_projected_salary[$key]['earned_basic'] + $employee_projected_salary[$key]['basic_arrear']) * 0.10))]);
        }

        $emp_basic = 0;
        $emp_hra = 0;
        $emp_Excess_rent = 0;
        $emp_excp_amt = 0;

        foreach ($emp_salary_hra as $key => $single_salary) {
            $emp_basic += $emp_salary_hra[$key]['Basic'];
            $emp_hra += $emp_salary_hra[$key]['Hra'];
            $emp_Excess_rent += $emp_salary_hra[$key]['excess_of_rent_paid'];
            $emp_excp_amt += $emp_salary_hra[$key]['Excemption_amount'];
        }



        return ['Total_basic' => $emp_basic, 'Total_Hra' => $emp_hra, 'Total_Excess_rent_10' => $emp_Excess_rent, 'Total_Expect_amt' => $emp_excp_amt, 'hra_months' => $emp_salary_hra];
    }


    public function fetchInvestmentTaxReports()
    {
        $reportsdata = array();

        // $client_id = ["2","3","4"];

        $payroll_month = "2023-08-01";

        // $inv_emp = VmtInvFEmpAssigned::pluck('user_id')->toArray();

        // $inv_emp = ['146','147'];

        // dd($inv_emp);

        $user_details = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
            ->join('vmt_employee_statutory_details', 'vmt_employee_statutory_details.user_id', '=', 'users.id')
            ->join('vmt_inv_f_emp_assigned', 'vmt_inv_f_emp_assigned.user_id', '=', 'users.id')
            ->where("users.active", "1");
        // ->where("users.id", "167");
        // ->where("vmt_inv_f_emp_assigned.user_id", "182");
        // ->whereIn("users.client_id", $client_id)
        // ->whereIn("users.id", $inv_emp)


        $Employee_details = $user_details->get([
            'users.id as user_id',
            'users.user_code as Employee Code',
            'users.name as Employee Name',
            'vmt_employee_details.gender as Gender',
            'vmt_employee_details.pan_number as PAN Number',
            'vmt_employee_details.dob as Date Of Birth',
            'vmt_employee_details.doj as Date Of Joining',
            'vmt_employee_statutory_details.tax_regime as Tax Regime'
        ])->toArray();

        $inv_emp = $user_details->pluck("users.id")->toarray();

        // dd($Employee_details,$inv_emp );

        $employee_salary_details = array();
        $professinal_income = array();

        foreach ($Employee_details as $key => $single_user) {

            $single_user_id = User::where('id', $single_user['user_id'])->first();

            $payroll_date = VmtPayroll::where('payroll_date',  $payroll_month)->where('client_id', $single_user_id->client_id)->first();

            if (!empty($payroll_date)) {

                $emp_payroll = VmtEmployeePayroll::where('payroll_id', $payroll_date->id)->where('user_id', $single_user['user_id']);
            }

            if ($emp_payroll->exists()) {
                $emp_payroll = $emp_payroll->first();
                $employee_projected_salary = AbsSalaryProjection::where('vmt_emp_payroll_id', $emp_payroll->id);
            }

            if ($employee_projected_salary->exists()) {

                $employee_salary_details[$key]["Employee Code"] = $single_user['Employee Code'];
                $employee_salary_details[$key]["Employee Name"] = $single_user['Employee Name'];
                $employee_salary_details[$key]["Gender"] = $single_user['Gender'];
                $employee_salary_details[$key]["PAN Number"] = $single_user['PAN Number'];
                $employee_salary_details[$key]["Date Of Birth"] = Carbon::parse($single_user['Date Of Birth'])->format('d-m-Y');
                $employee_salary_details[$key]["Date Of Joining"] = Carbon::parse($single_user['Date Of Joining'])->format('d-m-Y');
                $employee_salary_details[$key]["Tax Regime"] = ucfirst($single_user['Tax Regime']) . " Regime";
                $professinal_income[$key]["Regime"] = $single_user['Tax Regime'];
                $employee_salary_details[$key]["Basic"] = $employee_projected_salary->sum('earned_basic');
                $employee_salary_details[$key]["Basic Arrears"] = $employee_projected_salary->sum('basic_arrear');
                $employee_salary_details[$key]["Dearness Allowance"] = $employee_projected_salary->sum('dearness_allowance_earned');
                $employee_salary_details[$key]["Dearness Allowance Arrears"] = $employee_projected_salary->sum('dearness_allowance_arrear');
                $employee_salary_details[$key]["Variable Dearness Allowance"] = $employee_projected_salary->sum('vda_earned');
                $employee_salary_details[$key]["Variable Dearness Allowance Arrears"] = $employee_projected_salary->sum('vda_arrear');
                $employee_salary_details[$key]["HRA"] = $employee_projected_salary->sum('earned_hra');
                $employee_salary_details[$key]["HRA Arrears"] = $employee_projected_salary->sum('hra_arrear');
                $employee_salary_details[$key]["Child Education Allowance"] = $employee_projected_salary->sum('earned_child_edu_allowance');
                $employee_salary_details[$key]["Child Education Allowance Arrears"] = $employee_projected_salary->sum('child_edu_allowance_arrear');
                $employee_salary_details[$key]["Statutory Bonus"] = $employee_projected_salary->sum('earned_stats_bonus');
                $employee_salary_details[$key]["Statutory Bonus Arrears"] = $employee_projected_salary->sum('earned_stats_arrear');
                $employee_salary_details[$key]["Medical Allowance"] = $employee_projected_salary->sum('medical_allowance_earned');
                $employee_salary_details[$key]["Medical Allowance Arrears"] = $employee_projected_salary->sum('medical_allowance_arrear');
                $employee_salary_details[$key]["Communicaton Allowance"] = $employee_projected_salary->sum('communication_allowance_earned');
                $employee_salary_details[$key]["Communication Allowance Arrears"] = $employee_projected_salary->sum('communication_allowance_arrear');
                $employee_salary_details[$key]["Leave Travel Allowance"] = $employee_projected_salary->sum('earned_lta');
                $employee_salary_details[$key]["Leave Travel Allowance Arrears"] = $employee_projected_salary->sum('lta_arrear');
                $employee_salary_details[$key]["Food Allowance"] = $employee_projected_salary->sum('food_allowance_earned');
                $employee_salary_details[$key]["Food Allowance Arrears"] = $employee_projected_salary->sum('food_allowance_arrear');
                $employee_salary_details[$key]["Special Allowance"] = $employee_projected_salary->sum('earned_spl_alw');
                $employee_salary_details[$key]["Special Allowance Arrears"] = $employee_projected_salary->sum('spl_alw_arrear');
                $employee_salary_details[$key]["Other Allowance"] = $employee_projected_salary->sum('other_allowance_earned');
                $employee_salary_details[$key]["Other Allowance Arrears"] = $employee_projected_salary->sum('other_allowance_arrear');
                $employee_salary_details[$key]["Washing Allowance"] = $employee_projected_salary->sum('washing_allowance_earned');
                $employee_salary_details[$key]["Washing Allowance Arrears"] = $employee_projected_salary->sum('washing_allowance_arrear');
                $employee_salary_details[$key]["Uniform Allowance"] = $employee_projected_salary->sum('uniform_allowance_earned');
                $employee_salary_details[$key]["Uniform Allowance Arrears"] = $employee_projected_salary->sum('uniform_allowance_arrear');
                $employee_salary_details[$key]["Vehicle Reimbursement"] = $employee_projected_salary->sum('vehicle_reimbursement_earned');
                $employee_salary_details[$key]["Vehicle Reimbursement Arrears"] = $employee_projected_salary->sum('vehicle_reimbursement_arrear');
                $employee_salary_details[$key]["Driver Salary Reimbursement"] = $employee_projected_salary->sum('driver_salary_earned');
                $employee_salary_details[$key]["Driver Salary Reimbursement Arrears"] = $employee_projected_salary->sum('driver_salary_arrear');
                $professinal_income[$key]["Professional Tax"] = $employee_projected_salary->sum('prof_tax');
                $professinal_income[$key]["Income Tax"] = $employee_projected_salary->sum('income_tax');
                $employee_salary_details[$key]["Overtime"] = $employee_projected_salary->sum('overtime');
                $employee_salary_details[$key]["Overtime Arrears"] = $employee_projected_salary->sum('overtime_arrear');

                $employee_salary_details[$key]["Arrears"] = $employee_projected_salary->sum('basic_arrear') + $employee_projected_salary->sum('dearness_allowance_arrear') + $employee_projected_salary->sum('vda_arrear') + $employee_projected_salary->sum('hra_arrear') + $employee_projected_salary->sum('hra_arrear') +
                    $employee_projected_salary->sum('child_edu_allowance_arrear') + $employee_projected_salary->sum('earned_stats_arrear') + $employee_projected_salary->sum('medical_allowance_arrear')
                    + $employee_projected_salary->sum('communication_allowance_arrear')  + $employee_projected_salary->sum('food_allowance_arrear') + $employee_projected_salary->sum('lta_arrear') + $employee_projected_salary->sum('spl_alw_arrear') + $employee_projected_salary->sum('other_allowance_arrear')
                    + $employee_projected_salary->sum('washing_allowance_arrear') + $employee_projected_salary->sum('uniform_allowance_arrear') + $employee_projected_salary->sum('vehicle_reimbursement_arrear') + $employee_projected_salary->sum('driver_salary_arrear');


                $employee_salary_details[$key]["Incentive"] = $employee_projected_salary->sum('incentive');
                $employee_salary_details[$key]["Other Earnings"] = $employee_projected_salary->sum('other_earnings');
                $employee_salary_details[$key]["Referral Bonus"] = $employee_projected_salary->sum('referral_bonus');
                $employee_salary_details[$key]["Annual Statutory Bonus"] = $employee_projected_salary->sum('earned_stats_bonus');
                $employee_salary_details[$key]["Ex-Gratia"] = $employee_projected_salary->sum('ex_gratia');
                $employee_salary_details[$key]["Attendance Bonus"] = $employee_projected_salary->sum('attendance_bonus');
                $employee_salary_details[$key]["Daily Allowance"] = $employee_projected_salary->sum('daily_allowance');
                $employee_salary_details[$key]["Leave Encashments"] = $employee_projected_salary->sum('leave_encashment');
                $employee_salary_details[$key]["Gift"] = $employee_projected_salary->sum('gift_payment');
                $employee_salary_details[$key]["Annual Gross Salary"] =   $employee_projected_salary->sum('earned_basic') + $employee_projected_salary->sum('basic_arrear') +  $employee_projected_salary->sum('dearness_allowance_earned') +
                    $employee_projected_salary->sum('dearness_allowance_arrear') + $employee_projected_salary->sum('vda_earned') + $employee_projected_salary->sum('vda_arrear') +
                    $employee_projected_salary->sum('earned_hra') + $employee_projected_salary->sum('hra_arrear') + $employee_projected_salary->sum('earned_child_edu_allowance') + $employee_projected_salary->sum('child_edu_allowance_arrear') +
                    $employee_projected_salary->sum('earned_stats_bonus') + $employee_projected_salary->sum('earned_stats_arrear') + $employee_projected_salary->sum('medical_allowance_earned') + $employee_projected_salary->sum('medical_allowance_arrear') +
                    $employee_projected_salary->sum('communication_allowance_earned') + $employee_projected_salary->sum('communication_allowance_arrear') + $employee_projected_salary->sum('earned_lta') + $employee_projected_salary->sum('lta_arrear') +
                    $employee_projected_salary->sum('food_allowance_earned') + $employee_projected_salary->sum('food_allowance_arrear') + $employee_projected_salary->sum('earned_spl_alw') + $employee_projected_salary->sum('spl_alw_arrear') +
                    $employee_projected_salary->sum('other_allowance_earned') +  $employee_projected_salary->sum('other_allowance_arrear') +  $employee_projected_salary->sum('washing_allowance_earned') + $employee_projected_salary->sum('washing_allowance_arrear') +
                    $employee_projected_salary->sum('uniform_allowance_earned') + $employee_projected_salary->sum('uniform_allowance_arrear') + $employee_projected_salary->sum('vehicle_reimbursement_earned') + $employee_projected_salary->sum('vehicle_reimbursement_arrear') +
                    $employee_projected_salary->sum('driver_salary_earned') + $employee_projected_salary->sum('driver_salary_arrear') + $employee_projected_salary->sum('overtime') + $employee_projected_salary->sum('overtime_arrear') + $employee_projected_salary->sum('incentive') +
                    $employee_projected_salary->sum('other_earnings') + $employee_projected_salary->sum('referral_bonus') + $employee_projected_salary->sum('earned_stats_bonus') + $employee_projected_salary->sum('ex_gratia') + $employee_projected_salary->sum('attendance_bonus') +
                    $employee_projected_salary->sum('daily_allowance') + $employee_projected_salary->sum('leave_encashment') + $employee_projected_salary->sum('gift_payment');
            }
        }

        // dd($employee_salary_details);

        $salary_data['headers'] = array(
            'Employee Code', 'Employee Name', 'Gender', 'PAN Number', 'Date Of Birth', 'Date Of Joining', 'Tax Regime', 'Basic', 'Basic Arrears',
            'Dearness Allowance', 'Dearness Allowance Arrears', 'Variable Dearness Allowance', 'Variable Dearness Allowance Arrears', 'HRA', 'HRA Arrears', 'Child Education Allowance',
            'Child Education Allowance Arrears', 'Statutory Bonus', 'Statutory Bonus Arrears', 'Medical Allowance', 'Medical Allowance Arrears', 'Communicaton Allowance', 'Communication Allowance Arrears', 'Leave Travel Allowance',
            'Leave Travel Allowance Arrears', 'Food Allowance', 'Food Allowance Arrears', 'Special Allowance', 'Special Allowance Arrears', 'Other Allowance', 'Other Allowance Arrears',
            'Washing Allowance', 'Washing Allowance Arrears', 'Uniform Allowance', 'Uniform Allowance Arrears', 'Vehicle Reimbursement', 'Vehicle Reimbursement Arrears', 'Driver Salary Reimbursement',
            'Driver Salary Reimbursement Arrears', 'Overtime', 'Overtime Arrears', 'Arrears', 'Incentive', 'Other Earnings', 'Referral Bonus', 'Annual Statutory Bonus', 'Ex-Gratia', 'Attendance Bonus',
            'Daily Allowance', 'Leave Encashments', 'Gift', 'Annual Gross Salary', 'HRA Exceptions', 'CEA Exceptions', 'LTA Exceptions', 'Previous Employer Gross', 'Previous Employer PT',
            'Previous Employer Standard Deduction', 'Gross Total Income', '(a) salary as per provision as containeds in sec.17(1)', '(b) Value of Prequisites u/s 17 (2)', '(c) Profits in lie u of salary under section 13(3)',
            '(d) Total', '2. Less: Allowance to the extent exempt u/s 10', '3. Balance (1-2)', '(a) Standard Deduction u/s 16(ia)', '(b) Entertainment allowance u/s 16(ii)', '(c) Tax on employment u/s 16(iii)',
            '5. Aggregate of 4(a), (b) and (c)', '6. Income chargeable under head salaries(3-5)', '(a) Deductions u/s 24 - Interest', '(b) Other Source Of Income', '(c) 80EE Additional interest on House property', '8. Gross total income (6+7)'
        );

        // dd($salary_data['headers'],$employee_salary_details);

        // dd($professinal_income);


        $v_form_template = [];

        foreach ($inv_emp as $single_inv_users) {

            $v_form_template[] = VmtInvFormSection::leftjoin('vmt_inv_section', 'vmt_inv_section.id', '=', 'vmt_inv_formsection.section_id')
                ->leftjoin('vmt_inv_section_group', 'vmt_inv_section_group.id', '=', 'vmt_inv_section.sectiongroup_id')
                ->leftjoin('vmt_inv_emp_formdata', 'vmt_inv_emp_formdata.fs_id', '=', 'vmt_inv_formsection.id')
                ->leftjoin('vmt_inv_f_emp_assigned', 'vmt_inv_f_emp_assigned.id', '=', 'vmt_inv_emp_formdata.f_emp_id')
                ->leftjoin('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'vmt_inv_f_emp_assigned.user_id')
                ->leftjoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'vmt_employee_compensatory_details.user_id')
                ->where('vmt_inv_f_emp_assigned.user_id', $single_inv_users)
                ->get(
                    [
                        'vmt_inv_f_emp_assigned.user_id',
                        'vmt_inv_section_group.section_group',
                        'vmt_inv_section.section',
                        'vmt_inv_section.particular',
                        'vmt_inv_emp_formdata.dec_amount',
                        'vmt_inv_section.max_amount',
                        'vmt_inv_emp_formdata.json_popups_value',
                        'vmt_inv_f_emp_assigned.regime',
                        'vmt_inv_f_emp_assigned.updated_at',
                        'vmt_employee_compensatory_details.gross',
                        'vmt_employee_compensatory_details.basic',
                        'vmt_employee_compensatory_details.hra',
                        'vmt_employee_compensatory_details.special_allowance',
                        'vmt_employee_compensatory_details.professional_tax',
                        'vmt_employee_compensatory_details.child_education_allowance',
                        'vmt_employee_compensatory_details.lta',
                        'vmt_employee_details.doj',
                        'vmt_employee_details.dob',
                    ]
                )->toArray();
        }



        foreach ($Employee_details as $key => $single_user) {
            $value =  $this->HraExceptionCalc(User::where('user_code', $single_user['Employee Code'])->first()->id, $payroll_month)['Total_Expect_amt'];
            $cea_lta_computation  =  $this->getEmpAnnualProjectionForPdf(User::where('user_code', $single_user['Employee Code'])->first()->id, $payroll_month);
            $employee_salary_details[$key]["HRA Exceptions"] = $value;
            $employee_salary_details[$key]["CEA Exceptions"] = $cea_lta_computation['Child Education Allowance'] + $cea_lta_computation['Child Education Allowance Arrears'];
            $employee_salary_details[$key]["LTA Exceptions"] = $cea_lta_computation['Leave Travel Allowance'] + $cea_lta_computation['Leave Travel Allowance Arrears'];
        }

        // Previous employeer income

        foreach ($inv_emp as $single_inv_users) {
            foreach ($v_form_template as $dec_amt) {
                foreach ($dec_amt as $single_value) {
                    if (in_array($single_inv_users, $single_value)) {
                        if ($single_value['section_group'] == 'Previous Employer Income') {
                            foreach ($Employee_details as $key => $single_user) {
                                if ($single_inv_users == User::where('user_code', $single_user['Employee Code'])->first()->id) {
                                    $employee_salary_details[$key][$single_value['particular']] = $single_value['dec_amount'];
                                }
                            }
                        }
                    }
                }
            }
        }


        //          $sumofprevious_emp =0;
        //          foreach($inv_emp as $single_inv_users){
        //           foreach($v_form_template as $dec_amt){
        //                  foreach($dec_amt as $single_value){
        //                     if($single_value['particular'] == 'Previous Employer Gross'){
        //                       if(in_array($single_inv_users,$single_value)){
        //                 foreach ($Employee_details as $key => $single_user) {
        //                     if($single_inv_users == User::where('user_code',$single_user['Employee Code'])->first()->id){
        //                         $sumofprevious_emp  += $single_value['dec_amount'];
        //                       $employee_salary_details[$key]["Gross Total Income"] = $sumofprevious_emp + $employee_salary_details[$key]["Annual Gross Salary"];
        //                     }
        //                     }
        //                 }
        //             }else{
        //                     $employee_salary_details[$key]["Gross Total Income"] = $employee_salary_details[$key]["Annual Gross Salary"];
        //                     }
        //         }
        //     }
        // }

        $sumofpreEmpgross = [];
        foreach ($inv_emp as $single_inv_users) {
            foreach ($v_form_template as $dec_amt) {
                foreach ($dec_amt as $single_value) {
                    if (in_array($single_inv_users, $single_value)) {
                        if ($single_value['particular'] == 'Previous Employer Gross') {
                            foreach ($Employee_details as $key => $single_user) {
                                if ($single_inv_users == User::where('user_code', $single_user['Employee Code'])->first()->id) {
                                    $sumofpreEmpgross[$single_inv_users][$single_value['dec_amount']] = $single_value['dec_amount'];
                                }
                            }
                        }
                    }
                }
            }
        }

        // dd($sumofpreEmpgross);

        $preEmpGross = [];
        $sim = [];
        foreach ($inv_emp as $key11 => $single_inv_users) {
            if (array_key_exists($single_inv_users, $sumofpreEmpgross)) {
                foreach ($sumofpreEmpgross as $key => $single_value) {
                    if ($single_inv_users == $key) {

                        // array_sum(array_values($single_value));
                        $preEmpGross[$single_inv_users] =  array_sum(array_values($single_value)) + $employee_salary_details[$key11]["Annual Gross Salary"];
                    }
                }
            } else {

                $preEmpGross[$single_inv_users] = $employee_salary_details[$key11]["Annual Gross Salary"];
            }
        }

        //  dd($preEmpGross);

        foreach ($inv_emp as $single_inv_users) {
            foreach ($Employee_details as $key => $single_user) {
                if ($single_inv_users == User::where('user_code', $single_user['Employee Code'])->first()->id) {
                    $employee_salary_details[$key]['Gross Total Income'] = $preEmpGross[$single_inv_users];
                }
            }
        }



        $inv_stantard_deduction = [];
        $inv_previous_emp_pt = [];
        $inv_previous_emp_inv_dec = [];
        $sumOfOtherSourceOfIncome = [];
        $sumof80Ee = [];
        $othersource = [];
        $sumOfpreviousempincome = [];


        foreach ($inv_emp as $single_inv_users) {
            foreach ($v_form_template as $dec_amt) {
                foreach ($dec_amt as $single_value) {
                    if (in_array($single_inv_users, $single_value)) {
                        foreach ($Employee_details as $key => $single_user) {
                            if ($single_inv_users == User::where('user_code', $single_user['Employee Code'])->first()->id) {
                                if ($single_value['section_group'] == "Previous Employer Income") {
                                    // $sumOfpreviousempincome += $single_value['dec_amount'];
                                    // $sumOfpreviousempincome[$single_inv_users][$single_value['dec_amount']] = $single_value['dec_amount'];

                                    if ($single_value['particular'] == "Previous Employer Standard Deduction") {
                                        $inv_stantard_deduction[$single_inv_users] = $single_value['dec_amount'];
                                    }

                                    if ($single_value['particular'] == "Previous Employer PT") {
                                        $inv_previous_emp_pt[$single_inv_users] = $single_value['dec_amount'];
                                    }

                                    if ($single_value['particular'] == "Previous Employer Income Tax Deduction") {
                                        $inv_previous_emp_inv_dec[$single_inv_users] = $single_value['dec_amount'];
                                        $inv_previous_emp_inv_perticular = 'Previous Employer Income Tax Deduction';
                                    }
                                }
                                if ($single_value['particular'] == "Income earned from other sources") {
                                    $othersource[$single_inv_users] = $single_value['dec_amount'];
                                }

                                if ($single_value['section'] == "80EE") {
                                    $sumof80Ee[$single_inv_users] = $single_value['dec_amount'];
                                }
                            }
                        }
                    }
                }
            }
        }


        $sumofothersource = [];
        foreach ($inv_emp as $key11 => $single_inv_users) {
            if (array_key_exists($single_inv_users, $othersource)) {
                foreach ($othersource as $key => $single_value) {
                    if ($single_inv_users == $key) {
                        $sumofothersource[$single_inv_users] =  $othersource[$single_inv_users];
                    }
                }
            } else {
                $sumofothersource[$single_inv_users] = 0;
            }
        }


        $valueof_80ee = [];
        foreach ($inv_emp as $key11 => $single_inv_users) {
            if (array_key_exists($single_inv_users, $sumof80Ee)) {
                foreach ($sumof80Ee as $key => $single_value) {
                    if ($single_inv_users == $key) {
                        $valueof_80ee[$single_inv_users] =  $sumof80Ee[$single_inv_users];
                    }
                }
            } else {
                $valueof_80ee[$single_inv_users] = 0;
            }
        }

        $sumofstddeduction = [];
        foreach ($inv_emp as $key11 => $single_inv_users) {
            if (array_key_exists($single_inv_users, $inv_stantard_deduction)) {
                foreach ($inv_stantard_deduction as $key => $single_value) {
                    if ($single_inv_users == $key) {
                        $sumofstddeduction[$single_inv_users] =  ($inv_stantard_deduction[$key] + $employee_salary_details[$key11]["Annual Gross Salary"]) >= 50000 ? 50000 : $inv_stantard_deduction[$key] + $employee_salary_details[$key11]["Annual Gross Salary"];
                    }
                }
            } else {
                $sumofstddeduction[$single_inv_users] = $employee_salary_details[$key11]["Annual Gross Salary"] >= 50000 ? 50000 : $employee_salary_details[$key11]["Annual Gross Salary"];
            }
        }

        // dd($sumofstddeduction);
        $sumofptvalue = [];
        foreach ($inv_emp as $key11 => $single_inv_users) {
            if (array_key_exists($single_inv_users, $inv_previous_emp_pt)) {
                foreach ($inv_previous_emp_pt as $key => $single_value) {
                    if ($single_inv_users == $key) {
                        $sumofptvalue[$single_inv_users] =  ($inv_previous_emp_pt[$key] + $professinal_income[$key11]["Professional Tax"]) >= 2500 ? 2500 : $inv_previous_emp_pt[$key] + $professinal_income[$key11]["Professional Tax"];
                    }
                }
            } else {
                $sumofptvalue[$single_inv_users] = $professinal_income[$key11]["Professional Tax"] >= 2500 ? 2500 : $professinal_income[$key11]["Professional Tax"];
            }
        }


        foreach ($inv_emp as $single_inv_users) {

            foreach ($Employee_details as $key => $single_user) {
                if ($single_inv_users == User::where('user_code', $single_user['Employee Code'])->first()->id) {
                    $employee_salary_details[$key]["(a) salary as per provision as containeds in sec.17(1)"] = ($employee_salary_details[$key]["Gross Total Income"]);
                    $employee_salary_details[$key]["(b) Value of Prequisites u/s 17 (2)"] = 0;
                    $employee_salary_details[$key]["(c) Profits in lie u of salary under section 13(3)"] = 0;
                    $employee_salary_details[$key]["(d) Total"] = ($employee_salary_details[$key]["(a) salary as per provision as containeds in sec.17(1)"]) + ($employee_salary_details[$key]["(b) Value of Prequisites u/s 17 (2)"]) + ($employee_salary_details[$key]["(c) Profits in lie u of salary under section 13(3)"]);
                    $employee_salary_details[$key]["2. Less: Allowance to the extent exempt u/s 10"] = ($employee_salary_details[$key]["HRA Exceptions"]) - ($employee_salary_details[$key]["CEA Exceptions"]) +  ($employee_salary_details[$key]["LTA Exceptions"]);
                    $employee_salary_details[$key]["3. Balance (1-2)"] = ($employee_salary_details[$key]["(d) Total"])  - ($employee_salary_details[$key]["2. Less: Allowance to the extent exempt u/s 10"]);
                    $employee_salary_details[$key]["(a) Standard Deduction u/s 16(ia)"] = $sumofstddeduction[$single_inv_users];
                    $employee_salary_details[$key]["(b) Entertainment allowance u/s 16(ii)"] = 0;
                    $employee_salary_details[$key]["(c) Tax on employment u/s 16(iii)"] = $sumofptvalue[$single_inv_users];
                    $employee_salary_details[$key]["5. Aggregate of 4(a), (b) and (c)"] = $sumofstddeduction[$single_inv_users] + 0 + $sumofptvalue[$single_inv_users];
                    $employee_salary_details[$key]["6. Income chargeable under head salaries(3-5)"] = $employee_salary_details[$key]["3. Balance (1-2)"] - $employee_salary_details[$key]["5. Aggregate of 4(a), (b) and (c)"];
                    $employee_salary_details[$key]['(a) Deductions u/s 24 - Interest'] = 0;
                    $employee_salary_details[$key]['(b) Other Source Of Income'] = $sumofothersource[$single_inv_users];
                    $employee_salary_details[$key]['(c) 80EE Additional interest on House property'] = $valueof_80ee[$single_inv_users];
                    $employee_salary_details[$key]['8. Gross total income (6+7)'] = $employee_salary_details[$key]["6. Income chargeable under head salaries(3-5)"] + $employee_salary_details[$key]['(a) Deductions u/s 24 - Interest'] + $employee_salary_details[$key]['(b) Other Source Of Income'] + $employee_salary_details[$key]['(c) 80EE Additional interest on House property'];
                }
            }
        }


        $v_form_template_header = VmtInvFormSection::leftjoin('vmt_inv_section', 'vmt_inv_section.id', '=', 'vmt_inv_formsection.section_id')
            ->leftjoin('vmt_inv_section_group', 'vmt_inv_section_group.id', '=', 'vmt_inv_section.sectiongroup_id')
            ->get()->toArray();

        foreach ($v_form_template_header as $single_value) {
            if ($single_value['section_group'] == "Section 80C & 80CC ") {
                array_push($salary_data['headers'], $single_value['particular']);
            }
        }
        // inv emp data Section 80C & 80CC

        $sumofsection80cc = [];
        foreach ($inv_emp as $single_inv_users) {
            foreach ($v_form_template as $dec_amt) {
                foreach ($dec_amt as $single_value) {
                    if (in_array($single_inv_users, $single_value)) {
                        if ($single_value['section_group'] == 'Section 80C & 80CC ') {
                            foreach ($Employee_details as $key => $single_user) {
                                if ($single_inv_users == User::where('user_code', $single_user['Employee Code'])->first()->id) {
                                    $employee_salary_details[$key][$single_value['particular']] = $single_value['dec_amount'];
                                    $sumofsection80cc[$single_inv_users][$single_value['dec_amount']] = $single_value['dec_amount'];
                                }
                            }
                        }
                    }
                }
            }
        }



        array_push($salary_data['headers'], 'Section 80CCE Total');


        foreach ($inv_emp as $key11 => $single_inv_users) {
            if (array_key_exists($single_inv_users, $sumofsection80cc)) {
                foreach ($sumofsection80cc as $key => $single_value) {
                    if ($single_inv_users == $key) {
                        $sumofsection80 =  array_sum(array_values($single_value));
                        $employee_salary_details[$key11]['Section 80CCE Total'] =  $sumofsection80 >= 150000 ? 150000 : $sumofsection80;
                    }
                }
            } else {
                $employee_salary_details[$key11]['Section 80CCE Total'] = 0;
            }
        }


        foreach ($v_form_template_header as $single_value) {
            if ($single_value['section_group'] == "Other Excemptions ") {
                array_push($salary_data['headers'], $single_value['particular']);
            }
        }
        // inv emp data otherexception

        $sumofotherexception = [];
        foreach ($inv_emp as $single_inv_users) {
            foreach ($v_form_template as $dec_amt) {
                foreach ($dec_amt as $single_value) {
                    // dd($single_inv_users);
                    if (in_array($single_inv_users, $single_value)) {
                        if ($single_value['section_group'] == 'Other Excemptions ') {
                            foreach ($Employee_details as $key => $single_user) {
                                if ($single_inv_users == User::where('user_code', $single_user['Employee Code'])->first()->id) {
                                    if ($single_value['max_amount'] == 0) {
                                        $max_decamount = $single_value['dec_amount'];
                                    } elseif ($single_value['max_amount'] < $single_value['dec_amount']) {
                                        $max_decamount = $single_value['max_amount'];
                                    } else {
                                        $max_decamount = $single_value['dec_amount'];
                                    }
                                    $employee_salary_details[$key][$single_value['particular']] = $max_decamount;
                                    $sumofotherexception[$single_inv_users][$max_decamount] =  $max_decamount;
                                }
                            }
                        }
                    }
                }
            }
        }


        array_push($salary_data['headers'], '10. Aggregate of deductible amount under Chapter VI-A');

        $sum_execption = [];

        foreach ($inv_emp as $key11 => $single_inv_users) {
            if (array_key_exists($single_inv_users, $sumofotherexception)) {
                foreach ($sumofotherexception as $key => $single_value) {
                    if ($single_inv_users == $key) {
                        $sumofother =  array_sum(array_values($single_value));
                        $employee_salary_details[$key11]['10. Aggregate of deductible amount under Chapter VI-A'] = $sumofother + $employee_salary_details[$key11]['Section 80CCE Total'];
                        $sum_execption[$single_inv_users] = $sumofother;
                    }
                }
            } else {
                $employee_salary_details[$key11]['10. Aggregate of deductible amount under Chapter VI-A'] = 0 + $employee_salary_details[$key11]['Section 80CCE Total'];
                $sum_execption[$single_inv_users] = 0;
            }
        }

        $income = [];

        foreach ($inv_emp as $key11 => $single_inv_users) {
            foreach ($sum_execption as $key => $single_value) {
                if ($single_inv_users == $key) {
                    if ($professinal_income[$key11]["Regime"] == "old" || $professinal_income[$key11]["Regime"] == "") {
                        $income[$single_inv_users] =  $employee_salary_details[$key11]['Gross Total Income'] - $employee_salary_details[$key11]['Section 80CCE Total'] - $sum_execption[$key];
                    } else if ($professinal_income[$key11]["Regime"] == "new") {
                        $income[$single_inv_users] = $employee_salary_details[$key11]["Annual Gross Salary"] - $employee_salary_details[$key11]["(a) Standard Deduction u/s 16(ia)"] -  $employee_salary_details[$key11]['(a) Deductions u/s 24 - Interest'];
                    }
                }
            }
        }

        $tax_amount = [];
        foreach ($inv_emp as $key11 => $single_inv_users) {
            foreach ($income as $key => $single_value) {
                if ($single_inv_users == $key) {
                    if ($professinal_income[$key11]["Regime"] == "old" || $professinal_income[$key11]["Regime"] == "") {
                        $tax_amount[$single_inv_users] =   $this->oldRegimeTaxCalc($income[$single_inv_users], "58")['Tax on total Income'];
                    } else if ($professinal_income[$key11]["Regime"] == "new") {
                        $tax_amount[$single_inv_users] =  $this->newRegimeTaxCalc($income[$single_inv_users])['Tax on total Income'];
                    }
                }
            }
        }


        $rebate_amt = [];
        foreach ($inv_emp as $key11 => $single_inv_users) {
            foreach ($sum_execption as $key => $single_value) {
                if ($single_inv_users == $key) {
                    if ($professinal_income[$key11]["Regime"] == "old" || $professinal_income[$key11]["Regime"] == "") {
                        $rebate_amt[$single_inv_users] =  $this->rebateUs87acalc("old", $income[$single_inv_users], $tax_amount[$single_inv_users]);
                    } else if ($professinal_income[$key11]["Regime"] == "new") {
                        $rebate_amt[$single_inv_users] = $this->rebateUs87acalc("new", $income[$single_inv_users], $tax_amount[$single_inv_users]);
                    }
                }
            }
        }

        //  dd($rebate_amt);

        array_push(
            $salary_data['headers'],
            '11.Total Income (8-10)',
            '12.Tax on total income',
            '13. Rebate',
            '14.Total Income Tax',
            '15.Surcharge',
            '16.Education Cess @4% (On Tax computed at (14 & 15)',
            '17.Tax Payable (14+15+16)',
            '18.Less: Relief under section 89',
            '19.Tax Payable (17-18)',
            '20.Tax Deducted Till Date',
            '21.Previous Employer TDS',
            '22.Tax Due (19-20-21)',
        );

        foreach ($inv_emp as $single_inv_users) {
            foreach ($Employee_details as $key => $single_user) {
                if ($single_inv_users == User::where('user_code', $single_user['Employee Code'])->first()->id) {
                    $employee_salary_details[$key]['11.Total Income (8-10)'] = $income[$single_inv_users];
                    $employee_salary_details[$key]['12.Tax on total income'] = $tax_amount[$single_inv_users];
                    $employee_salary_details[$key]['13. Rebate'] = $rebate_amt[$single_inv_users];
                    $employee_salary_details[$key]['14.Total Income Tax'] = round($employee_salary_details[$key]['12.Tax on total income'] - $employee_salary_details[$key]['13. Rebate']);
                    $employee_salary_details[$key]['15.Surcharge'] = round($this->subChargeCalculation($employee_salary_details[$key]['11.Total Income (8-10)']));
                    $employee_salary_details[$key]['16.Education Cess @4% (On Tax computed at (14 & 15)'] = round(($employee_salary_details[$key]['14.Total Income Tax'] + $employee_salary_details[$key]['15.Surcharge']) * 0.04);
                    $employee_salary_details[$key]['17.Tax Payable (14+15+16)'] = round($employee_salary_details[$key]['14.Total Income Tax'] + $employee_salary_details[$key]['15.Surcharge'] + $employee_salary_details[$key]['16.Education Cess @4% (On Tax computed at (14 & 15)']);
                    $employee_salary_details[$key]['18.Less: Relief under section 89'] = 0;
                    $employee_salary_details[$key]['19.Tax Payable (17-18)'] = round($employee_salary_details[$key]['17.Tax Payable (14+15+16)'] - $employee_salary_details[$key]['18.Less: Relief under section 89']);
                    $employee_salary_details[$key]['20.Tax Deducted Till Date'] = round($professinal_income[$key]["Income Tax"]);
                    $employee_salary_details[$key]['21.Previous Employer TDS'] = 0;
                    $employee_salary_details[$key]['22.Tax Due (19-20-21)'] = round($employee_salary_details[$key]['19.Tax Payable (17-18)'] - $employee_salary_details[$key]['20.Tax Deducted Till Date'] - 0);
                }
            }
        }

        array_push($salary_data['headers'], '23.Tax Deduction Per Month');

        $timeperiod = VmtOrgTimePeriod::where('status', '1')->first();
        $end_date = Carbon::parse($timeperiod->end_date);
        $end_date = Carbon::parse($end_date)->floorMonth();
        $current = Carbon::now()->floorMonth();

        $diffmonths = $current->diffInMonths($end_date) + 1;


        foreach ($inv_emp as $single_inv_users) {
            foreach ($Employee_details as $key => $single_user) {
                if ($single_inv_users == User::where('user_code', $single_user['Employee Code'])->first()->id) {
                    $employee_salary_details[$key]['23.Tax Deduction Per Month'] = round($employee_salary_details[$key]['22.Tax Due (19-20-21)'] / $diffmonths);
                }
            }
        }

        $salary_data['rows'] = $employee_salary_details;

        $temp_ar = array();
        $final_ar = array();
        foreach ($salary_data['rows'] as $single_emp) {
            foreach ($salary_data['headers'] as  $single_headers) {
                if (array_key_exists($single_headers, $single_emp)) {
                    $temp_ar[$single_headers] = (string)$single_emp[$single_headers];
                } else {
                    $temp_ar[$single_headers] = "0";
                }
            }
            array_push($final_ar, $temp_ar);
            unset($temp_ar);
        }


        array_push($reportsdata, $salary_data['headers'], $final_ar);

        return ($reportsdata);
    }

    public function fetchInvestmentsReports()
    {

        $payroll_month = "2023-08-01";

        $user_details = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
            ->join('vmt_employee_statutory_details', 'vmt_employee_statutory_details.user_id', '=', 'users.id')
            ->join('vmt_inv_f_emp_assigned', 'vmt_inv_f_emp_assigned.user_id', '=', 'users.id')
            ->where("users.active", "1");

        $Employee_details = $user_details->get([
            'users.id as user_id',
            'users.user_code as Employee Code',
            'users.name as Employee Name',
            'vmt_employee_details.gender as Gender',
            'vmt_employee_details.pan_number as PAN Number',
            'vmt_employee_details.dob as Date Of Birth',
            'vmt_employee_details.doj as Date Of Joining',
            'vmt_employee_statutory_details.tax_regime as Tax Regime'
        ])->toArray();

        $inv_emp = $user_details->pluck("users.id")->toarray();

        foreach ($inv_emp as $single_inv_users) {

            $v_form_template[] = VmtInvFormSection::leftjoin('vmt_inv_section', 'vmt_inv_section.id', '=', 'vmt_inv_formsection.section_id')
                ->leftjoin('vmt_inv_section_group', 'vmt_inv_section_group.id', '=', 'vmt_inv_section.sectiongroup_id')
                ->leftjoin('vmt_inv_emp_formdata', 'vmt_inv_emp_formdata.fs_id', '=', 'vmt_inv_formsection.id')
                ->leftjoin('vmt_inv_f_emp_assigned', 'vmt_inv_f_emp_assigned.id', '=', 'vmt_inv_emp_formdata.f_emp_id')
                ->leftjoin('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'vmt_inv_f_emp_assigned.user_id')
                ->leftjoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'vmt_employee_compensatory_details.user_id')
                ->where('vmt_inv_f_emp_assigned.user_id', $single_inv_users)
                ->get(
                    [
                        'vmt_inv_f_emp_assigned.user_id',
                        'vmt_inv_section_group.section_group',
                        'vmt_inv_section.section',
                        'vmt_inv_section.particular',
                        'vmt_inv_emp_formdata.dec_amount',
                        'vmt_inv_section.max_amount',
                        'vmt_inv_emp_formdata.json_popups_value',
                        'vmt_inv_f_emp_assigned.regime',
                        'vmt_inv_f_emp_assigned.updated_at',
                        'vmt_employee_compensatory_details.gross',
                        'vmt_employee_compensatory_details.basic',
                        'vmt_employee_compensatory_details.hra',
                        'vmt_employee_compensatory_details.special_allowance',
                        'vmt_employee_compensatory_details.professional_tax',
                        'vmt_employee_compensatory_details.child_education_allowance',
                        'vmt_employee_compensatory_details.lta',
                        'vmt_employee_details.doj',
                        'vmt_employee_details.dob',
                    ]
                )->toArray();
        }

        $salary_data['headers'] = array('Employee Code', 'Employee Name', 'Gender', 'PAN Number', 'Date Of Birth', 'Date Of Joining', 'Tax Regime');

        $inv_section['headers1'] = array('Employee Details', 'Employee Details', 'Employee Details', 'Employee Details', 'Employee Details', 'Employee Details', 'Employee Details');

        foreach ($Employee_details as $key => $single_user) {

            $employee_salary_details[$key]["Employee Code"] = $single_user['Employee Code'];
            $employee_salary_details[$key]["Employee Name"] = $single_user['Employee Name'];
            $employee_salary_details[$key]["Gender"] = $single_user['Gender'];
            $employee_salary_details[$key]["PAN Number"] = $single_user['PAN Number'];
            $employee_salary_details[$key]["Date Of Birth"] = Carbon::parse($single_user['Date Of Birth'])->format('d-m-Y');
            $employee_salary_details[$key]["Date Of Joining"] = Carbon::parse($single_user['Date Of Joining'])->format('d-m-Y');
            $employee_salary_details[$key]["Tax Regime"] = ucfirst($single_user['Tax Regime']) . " Regime";
        }


        // get all investment section header

        $v_form_template_header = VmtInvFormSection::leftjoin('vmt_inv_section', 'vmt_inv_section.id', '=', 'vmt_inv_formsection.section_id')
            ->leftjoin('vmt_inv_section_group', 'vmt_inv_section_group.id', '=', 'vmt_inv_section.sectiongroup_id')
            ->get()->toArray();

        //   dd($v_form_template_header);

        // get emp investment HRA data

        foreach ($v_form_template_header as $single_value) {
            if ($single_value['section_group'] == "HRA") {
                array_push($salary_data['headers'], $single_value['particular']);
                array_push($inv_section['headers1'], $single_value['section']);
            }
        }

        foreach ($inv_emp as $single_inv_users) {
            foreach ($v_form_template as $dec_amt) {
                foreach ($dec_amt as $single_value) {
                    if (in_array($single_inv_users, $single_value)) {
                        if ($single_value['section_group'] == 'HRA') {
                            foreach ($Employee_details as $key => $single_user) {
                                if ($single_inv_users == User::where('user_code', $single_user['Employee Code'])->first()->id) {
                                    $employee_salary_details[$key][$single_value['particular']] = json_decode($single_value['json_popups_value'], true)['total_rent_paid'];
                                }
                            }
                        }
                    }
                }
            }
        }


        // get emp investment Section 80C & 80CC data

        foreach ($v_form_template_header as $single_value) {
            if ($single_value['section_group'] == "Section 80C & 80CC ") {
                array_push($salary_data['headers'], $single_value['particular']);
                array_push($inv_section['headers1'], $single_value['section']);
            }
        }

        foreach ($inv_emp as $single_inv_users) {
            foreach ($v_form_template as $dec_amt) {
                foreach ($dec_amt as $single_value) {
                    if (in_array($single_inv_users, $single_value)) {
                        if ($single_value['section_group'] == 'Section 80C & 80CC ') {
                            foreach ($Employee_details as $key => $single_user) {
                                if ($single_inv_users == User::where('user_code', $single_user['Employee Code'])->first()->id) {
                                    $employee_salary_details[$key][$single_value['particular']] = $single_value['dec_amount'];
                                }
                            }
                        }
                    }
                }
            }
        }


        // get emp investment other excemptions  data

        foreach ($v_form_template_header as $single_value) {
            if ($single_value['section_group'] == "Other Excemptions ") {
                array_push($salary_data['headers'], $single_value['particular']);
                array_push($inv_section['headers1'], $single_value['section']);
            }
        }

        foreach ($inv_emp as $single_inv_users) {
            foreach ($v_form_template as $dec_amt) {
                foreach ($dec_amt as $single_value) {
                    if (in_array($single_inv_users, $single_value)) {
                        if ($single_value['section_group'] == 'Other Excemptions ') {
                            foreach ($Employee_details as $key => $single_user) {
                                if ($single_inv_users == User::where('user_code', $single_user['Employee Code'])->first()->id) {
                                    $employee_salary_details[$key][$single_value['particular']] = $single_value['dec_amount'];
                                }
                            }
                        }
                    }
                }
            }
        }


        // get emp investment House Properties  data

        foreach ($v_form_template_header as $single_value) {
            if ($single_value['section_group'] == "House Properties ") {
                array_push($salary_data['headers'], $single_value['particular']);
                array_push($inv_section['headers1'], $single_value['section']);
            }
        }

        foreach ($inv_emp as $single_inv_users) {
            foreach ($v_form_template as $dec_amt) {
                foreach ($dec_amt as $single_value) {
                    if (in_array($single_inv_users, $single_value)) {
                        if ($single_value['section_group'] == 'House Properties ') {
                            foreach ($Employee_details as $key => $single_user) {
                                if ($single_inv_users == User::where('user_code', $single_user['Employee Code'])->first()->id) {
                                    $employee_salary_details[$key][$single_value['particular']] = json_decode($single_value['json_popups_value'], true)['income_loss'];
                                }
                            }
                        }
                    }
                }
            }
        }


        // get emp investment Previous Employer Income  data

        foreach ($v_form_template_header as $single_value) {
            if ($single_value['section_group'] == "Previous Employer Income") {
                array_push($salary_data['headers'], $single_value['particular']);
                array_push($inv_section['headers1'], $single_value['section']);
            }
        }

        foreach ($inv_emp as $single_inv_users) {
            foreach ($v_form_template as $dec_amt) {
                foreach ($dec_amt as $single_value) {
                    if (in_array($single_inv_users, $single_value)) {
                        if ($single_value['section_group'] == 'Previous Employer Income') {
                            foreach ($Employee_details as $key => $single_user) {
                                if ($single_inv_users == User::where('user_code', $single_user['Employee Code'])->first()->id) {
                                    $employee_salary_details[$key][$single_value['particular']] = $single_value['dec_amount'];
                                }
                            }
                        }
                    }
                }
            }
        }


        // get emp investment other source of income  data

        foreach ($v_form_template_header as $single_value) {
            if ($single_value['section_group'] == "Other Source Of  Income") {
                array_push($salary_data['headers'], $single_value['particular']);
                array_push($inv_section['headers1'], $single_value['section']);
            }
        }

        foreach ($inv_emp as $single_inv_users) {
            foreach ($v_form_template as $dec_amt) {
                foreach ($dec_amt as $single_value) {
                    if (in_array($single_inv_users, $single_value)) {
                        if ($single_value['section_group'] == 'Other Source Of  Income') {
                            foreach ($Employee_details as $key => $single_user) {
                                if ($single_inv_users == User::where('user_code', $single_user['Employee Code'])->first()->id) {
                                    $employee_salary_details[$key][$single_value['particular']] = $single_value['dec_amount'];
                                }
                            }
                        }
                    }
                }
            }
        }

        // header arr key set all emp array key

        $temp_ar = array();
        $final_ar = array();
        foreach ($employee_salary_details as $single_emp) {
            foreach ($salary_data['headers'] as  $single_headers) {
                if (array_key_exists($single_headers, $single_emp)) {
                    $temp_ar[$single_headers] = (string)$single_emp[$single_headers];
                } else {
                    $temp_ar[$single_headers] = "0";
                }
            }
            array_push($final_ar, $temp_ar);
            unset($temp_ar);
        }


        return ([$salary_data, $inv_section, $final_ar]);
    }


    public function annualSalaryReport()
    {


        $payroll_month = "2023-08-01";

        $user_details = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
            ->join('vmt_employee_statutory_details', 'vmt_employee_statutory_details.user_id', '=', 'users.id')
            ->where("users.active", "1");


        $Employee_details = $user_details->get([
            'users.id as user_id',
            'users.user_code as Employee Code',
            'users.name as Employee Name',
            'vmt_employee_details.gender as Gender',
            'vmt_employee_details.pan_number as PAN Number',
            'vmt_employee_details.dob as Date Of Birth',
            'vmt_employee_details.doj as Date Of Joining',
            'vmt_employee_statutory_details.tax_regime as Tax Regime'
        ])->toArray();

        $annual_salary_projection = array();

        $employee_salary_details = array();

        foreach ($Employee_details as $key => $single_user) {

            $single_user_id = User::where('id', $single_user['user_id'])->first();

            $payroll_date = VmtPayroll::where('payroll_date',  $payroll_month)->where('client_id', $single_user_id->client_id)->first();

            if (!empty($payroll_date)) {

                $emp_payroll = VmtEmployeePayroll::where('payroll_id', $payroll_date->id)->where('user_id', $single_user['user_id']);
            }

            if ($emp_payroll->exists()) {
                $emp_payroll = $emp_payroll->first();
                $employee_projected_salary = AbsSalaryProjection::where('vmt_emp_payroll_id', $emp_payroll->id);
                // dd($employee_projected_salary);
            }

            if ($employee_projected_salary->exists()) {

                $employee_salary_details[$key]["Employee Code"] = $single_user['Employee Code'];
                $employee_salary_details[$key]["Employee Name"] = $single_user['Employee Name'];
                $employee_salary_details[$key]["Gender"] = $single_user['Gender'];
                $employee_salary_details[$key]["PAN Number"] = $single_user['PAN Number'];
                $employee_salary_details[$key]["Date Of Birth"] = Carbon::parse($single_user['Date Of Birth'])->format('d-m-Y');
                $employee_salary_details[$key]["Date Of Joining"] = Carbon::parse($single_user['Date Of Joining'])->format('d-m-Y');
                $employee_salary_details[$key]["Tax Regime"] = ucfirst($single_user['Tax Regime']) . " Regime";
                // $professinal_income[$key]["Regime"] = $single_user['Tax Regime'];
                $employee_salary_details[$key]["Basic"] = $employee_projected_salary->sum('earned_basic');
                $employee_salary_details[$key]["Basic Arrears"] = $employee_projected_salary->sum('basic_arrear');
                $employee_salary_details[$key]["Dearness Allowance"] = $employee_projected_salary->sum('dearness_allowance_earned');
                $employee_salary_details[$key]["Dearness Allowance Arrears"] = $employee_projected_salary->sum('dearness_allowance_arrear');
                $employee_salary_details[$key]["Variable Dearness Allowance"] = $employee_projected_salary->sum('vda_earned');
                $employee_salary_details[$key]["Variable Dearness Allowance Arrears"] = $employee_projected_salary->sum('vda_arrear');
                $employee_salary_details[$key]["HRA"] = $employee_projected_salary->sum('earned_hra');
                $employee_salary_details[$key]["HRA Arrears"] = $employee_projected_salary->sum('hra_arrear');
                $employee_salary_details[$key]["Child Education Allowance"] = $employee_projected_salary->sum('earned_child_edu_allowance');
                $employee_salary_details[$key]["Child Education Allowance Arrears"] = $employee_projected_salary->sum('child_edu_allowance_arrear');
                $employee_salary_details[$key]["Statutory Bonus"] = $employee_projected_salary->sum('earned_stats_bonus');
                $employee_salary_details[$key]["Statutory Bonus Arrears"] = $employee_projected_salary->sum('earned_stats_arrear');
                $employee_salary_details[$key]["Medical Allowance"] = $employee_projected_salary->sum('medical_allowance_earned');
                $employee_salary_details[$key]["Medical Allowance Arrears"] = $employee_projected_salary->sum('medical_allowance_arrear');
                $employee_salary_details[$key]["Communicaton Allowance"] = $employee_projected_salary->sum('communication_allowance_earned');
                $employee_salary_details[$key]["Communication Allowance Arrears"] = $employee_projected_salary->sum('communication_allowance_arrear');
                $employee_salary_details[$key]["Leave Travel Allowance"] = $employee_projected_salary->sum('earned_lta');
                $employee_salary_details[$key]["Leave Travel Allowance Arrears"] = $employee_projected_salary->sum('lta_arrear');
                $employee_salary_details[$key]["Food Allowance"] = $employee_projected_salary->sum('food_allowance_earned');
                $employee_salary_details[$key]["Food Allowance Arrears"] = $employee_projected_salary->sum('food_allowance_arrear');
                $employee_salary_details[$key]["Special Allowance"] = $employee_projected_salary->sum('earned_spl_alw');
                $employee_salary_details[$key]["Special Allowance Arrears"] = $employee_projected_salary->sum('spl_alw_arrear');
                $employee_salary_details[$key]["Other Allowance"] = $employee_projected_salary->sum('other_allowance_earned');
                $employee_salary_details[$key]["Other Allowance Arrears"] = $employee_projected_salary->sum('other_allowance_arrear');
                $employee_salary_details[$key]["Washing Allowance"] = $employee_projected_salary->sum('washing_allowance_earned');
                $employee_salary_details[$key]["Washing Allowance Arrears"] = $employee_projected_salary->sum('washing_allowance_arrear');
                $employee_salary_details[$key]["Uniform Allowance"] = $employee_projected_salary->sum('uniform_allowance_earned');
                $employee_salary_details[$key]["Uniform Allowance Arrears"] = $employee_projected_salary->sum('uniform_allowance_arrear');
                $employee_salary_details[$key]["Vehicle Reimbursement"] = $employee_projected_salary->sum('vehicle_reimbursement_earned');
                $employee_salary_details[$key]["Vehicle Reimbursement Arrears"] = $employee_projected_salary->sum('vehicle_reimbursement_arrear');
                $employee_salary_details[$key]["Driver Salary Reimbursement"] = $employee_projected_salary->sum('driver_salary_earned');
                $employee_salary_details[$key]["Driver Salary Reimbursement Arrears"] = $employee_projected_salary->sum('driver_salary_arrear');
                // $professinal_income[$key]["Professional Tax"] =$employee_projected_salary->sum('prof_tax');
                // $professinal_income[$key]["Income Tax"] =$employee_projected_salary->sum('income_tax');
                $employee_salary_details[$key]["Overtime"] = $employee_projected_salary->sum('overtime');
                $employee_salary_details[$key]["Overtime Arrears"] = $employee_projected_salary->sum('overtime_arrear');

                $employee_salary_details[$key]["Arrears"] = $employee_projected_salary->sum('basic_arrear') + $employee_projected_salary->sum('dearness_allowance_arrear') + $employee_projected_salary->sum('vda_arrear') + $employee_projected_salary->sum('hra_arrear') + $employee_projected_salary->sum('hra_arrear') +
                    $employee_projected_salary->sum('child_edu_allowance_arrear') + $employee_projected_salary->sum('earned_stats_arrear') + $employee_projected_salary->sum('medical_allowance_arrear')
                    + $employee_projected_salary->sum('communication_allowance_arrear')  + $employee_projected_salary->sum('food_allowance_arrear') + $employee_projected_salary->sum('lta_arrear') + $employee_projected_salary->sum('spl_alw_arrear') + $employee_projected_salary->sum('other_allowance_arrear')
                    + $employee_projected_salary->sum('washing_allowance_arrear') + $employee_projected_salary->sum('uniform_allowance_arrear') + $employee_projected_salary->sum('vehicle_reimbursement_arrear') + $employee_projected_salary->sum('driver_salary_arrear');


                $employee_salary_details[$key]["Incentive"] = $employee_projected_salary->sum('incentive');;
                $employee_salary_details[$key]["Other Earnings"] = $employee_projected_salary->sum('other_earnings');
                $employee_salary_details[$key]["Referral Bonus"] = $employee_projected_salary->sum('referral_bonus');
                $employee_salary_details[$key]["Annual Statutory Bonus"] = $employee_projected_salary->sum('earned_stats_bonus');
                $employee_salary_details[$key]["Ex-Gratia"] = $employee_projected_salary->sum('ex_gratia');
                $employee_salary_details[$key]["Attendance Bonus"] = $employee_projected_salary->sum('attendance_bonus');
                $employee_salary_details[$key]["Daily Allowance"] = $employee_projected_salary->sum('daily_allowance');
                $employee_salary_details[$key]["Leave Encashments"] = $employee_projected_salary->sum('leave_encashment');
                $employee_salary_details[$key]["Gift"] = $employee_projected_salary->sum('gift_payment');
                $employee_salary_details[$key]["Annual Gross Salary"] = $employee_projected_salary->sum('earned_basic') + $employee_projected_salary->sum('dearness_allowance_earned') + $employee_projected_salary->sum('vda_earned')
                    + $employee_projected_salary->sum('earned_hra') + $employee_projected_salary->sum('earned_child_edu_allowance') + $employee_projected_salary->sum('medical_allowance_earned')
                    + $employee_projected_salary->sum('communication_allowance_earned') + $employee_projected_salary->sum('earned_lta') + $employee_projected_salary->sum('food_allowance_earned')
                    + $employee_projected_salary->sum('earned_spl_alw') + $employee_projected_salary->sum('other_allowance_earned') + $employee_projected_salary->sum('washing_allowance_earned') +
                    $employee_projected_salary->sum('uniform_allowance_earned');
            }
        }


        $salary_data['headers'] = array(
            'Employee Code', 'Employee Name', 'Gender', 'PAN Number', 'Date Of Birth', 'Date Of Joining', 'Tax Regime', 'Basic', 'Basic Arrears',
            'Dearness Allowance', 'Dearness Allowance Arrears', 'Variable Dearness Allowance', 'Variable Dearness Allowance Arrears', 'HRA', 'HRA Arrears', 'Child Education Allowance',
            'Child Education Allowance Arrears', 'Statutory Bonus', 'Statutory Bonus Arrears', 'Medical Allowance', 'Medical Allowance Arrears', 'Communicaton Allowance', 'Communication Allowance Arrears', 'Leave Travel Allowance',
            'Leave Travel Allowance Arrears', 'Food Allowance', 'Food Allowance Arrears', 'Special Allowance', 'Special Allowance Arrears', 'Other Allowance', 'Other Allowance Arrears',
            'Washing Allowance', 'Washing Allowance Arrears', 'Uniform Allowance', 'Uniform Allowance Arrears', 'Vehicle Reimbursement', 'Vehicle Reimbursement Arrears', 'Driver Salary Reimbursement',
            'Driver Salary Reimbursement Arrears', 'Overtime', 'Overtime Arrears', 'Arrears', 'Incentive', 'Other Earnings', 'Referral Bonus', 'Annual Statutory Bonus', 'Ex-Gratia', 'Attendance Bonus',
            'Daily Allowance', 'Leave Encashments', 'Gift', 'Annual Gross Salary'
        );

        $payroll_date  = Carbon::parse($payroll_month)->format("M Y");

        array_push($annual_salary_projection, $salary_data['headers'], $employee_salary_details, $payroll_month);

        return $annual_salary_projection;
    }

    /* -------------  Formulas ----------------*/

    private function newRegimeTaxCalc($total_income)
    {

        if ($total_income > 300000) {

            $deducted_total_income['Exception ₹300000 and the balance amount'] = $total_income;
            $deducted_total_income_1s = $total_income;


            if ($deducted_total_income_1s > 300000 && $deducted_total_income_1s < 600000) {
                $deducted_total_income['For ₹' . $deducted_total_income_1s . ' - ₹600000 : Tax - 5% Tax Amount'] = abs($deducted_total_income_1s - 300000) * 0.05;
            }

            if ($deducted_total_income_1s > 600000 && $deducted_total_income_1s < 900000) {
                $deducted_total_income['For ₹300000 - ₹600000 : Tax - 5% Tax Amount'] = abs(600000 - 300000) * 0.05;
                $deducted_total_income['For ₹600000 - ₹' . $deducted_total_income_1s . ' : Tax - 10% Tax Amount'] = abs($deducted_total_income_1s - 600000) * 0.10;
            }

            if ($deducted_total_income_1s > 900000 && $deducted_total_income_1s < 1200000) {
                $deducted_total_income['For ₹300000 - ₹600000 : Tax - 5% Tax Amount'] = abs(600000 - 300000) * 0.05;
                $deducted_total_income['For ₹600000 - ₹900000 : Tax - 10% Tax Amount'] = abs(900000 - 600000) * 0.10;
                $deducted_total_income['For ₹900000 - ₹' . $deducted_total_income_1s . ' : Tax - 15% Tax Amount'] = abs($deducted_total_income_1s - 900000) * 0.15;
            }

            if ($deducted_total_income_1s > 1200000 && $deducted_total_income_1s < 1500000) {
                $deducted_total_income['For ₹300000 - ₹600000 : Tax - 5% Tax Amount'] = abs(600000 - 300000) * 0.05;
                $deducted_total_income['For ₹600000 - ₹900000 : Tax - 10% Tax Amount'] = abs(900000 - 600000) * 0.10;
                $deducted_total_income['For ₹900000 - ₹1200000 : Tax - 15% Tax Amount'] = abs(1200000 - 900000) * 0.15;
                $deducted_total_income['For ₹1200000 - ₹' . $deducted_total_income_1s . ' : Tax - 20% Tax Amount'] = abs($deducted_total_income_1s - 1200000) * 0.20;
            }

            if ($deducted_total_income_1s > 1500000) {
                $deducted_total_income['For ₹300000 - ₹600000 : Tax - 5% Tax Amount'] = abs(600000 - 300000) * 0.05;
                $deducted_total_income['For ₹600000 - ₹900000 : Tax - 10% Tax Amount'] = abs(900000 - 600000) * 0.10;
                $deducted_total_income['For ₹900000 - ₹1200000 : Tax - 15% Tax Amount'] = abs(1200000 - 900000) * 0.15;
                $deducted_total_income['For ₹1200000 - ₹1500000 : Tax - 20% Tax Amount'] = abs(1500000 - 1200000) * 0.20;
                $deducted_total_income['For ₹1500000 - ₹' . $deducted_total_income_1s . ' : Tax - 30% Tax Amount'] = abs(1500000 - $deducted_total_income_1s) * 0.30;
            }
        }

        $sumOftax = 0;
        foreach ($deducted_total_income as $key => $tax_calculate) {
            if ($key == 'Exception ₹300000 and the balance amount') {
                $sumOftax += 0;
            } else {
                $sumOftax += $tax_calculate;
            }
        }
        $deducted_total_income['Tax on total Income'] = $sumOftax;

        $deducted_total_income['Less : Rebate Under Section 87A'] = $this->rebateUs87acalc('new', $total_income, $sumOftax);

        $deducted_total_income['Note : if taxable income is less than ₹500000, tax rebate of a maximum of ₹12500 is provided under Section 87A'] = 0;

        return $deducted_total_income;
    }

    private function oldRegimeTaxCalc($total_income, $age)
    {

        // $cur = '₹';

        if ($age < 60) {
            if ($total_income <= 250000) {
                return $overall_deduction = 0;
            } else
              if ($total_income > 250000) {

                $deducted_total_income['Exception ₹250000 and the balance amount'] = $total_income - 250000;
                $deducted_total_income_1s = $total_income - 250000;


                if ($deducted_total_income_1s > 250000) {
                    $deducted_total_income['For ₹250000 : Tax - 5% Tax Amount'] = 12500;
                    $deducted_total_income_2s = $deducted_total_income_1s - 250000;

                    if ($deducted_total_income_2s < 500000) {
                        $deducted_total_income['For ' . '₹' . $deducted_total_income_2s . ' : Tax - 20% Tax Amount'] = $deducted_total_income_2s * 0.20;
                    }

                    if ($deducted_total_income_2s > 500000) {
                        $deducted_total_income['For ₹500000 : Tax - 20% Tax Amount'] = 100000;
                        $deducted_total_income_3s = $deducted_total_income_2s - 500000;

                        if ($deducted_total_income_3s < 1000000) {
                            $deducted_total_income['For ' . '₹' . $deducted_total_income_3s . ' : Tax - 30% Tax Amount'] = $deducted_total_income_3s * 0.30;
                        }

                        if ($deducted_total_income_3s > 1000000) {
                            $deducted_total_income['For ' . '₹' . $deducted_total_income_3s . ' : Tax - 30% Tax Amount'] = $deducted_total_income_3s * 0.30;
                        }
                    }
                }
            }
        } else if ($age >= 60 && $age <= 80) {

            if ($total_income < 300000) {
                return $overall_deduction = 0;
            } else
              if ($total_income > 300000) {
                $deducted_total_income['For ₹300000 : Tax - 5% Tax Amount'] = 15000;
                $deducted_total_income_2s = $total_income - 300000;

                if ($deducted_total_income_2s < 500000) {
                    $deducted_total_income['For ' . $deducted_total_income_2s . ' Tax 5% Tax Amount'] = $deducted_total_income_2s * 0.05;
                }

                if ($deducted_total_income_2s > 500000) {
                    $deducted_total_income['For ₹500000 : Tax - 20% Tax Amount'] = 100000;
                    $deducted_total_income_3s = $deducted_total_income_2s - 500000;

                    if ($deducted_total_income_3s < 1000000) {
                        $deducted_total_income['For ' . '₹' . $deducted_total_income_3s . ' Tax 20% Tax Amount'] = $deducted_total_income_3s * 0.20;
                    }

                    if ($deducted_total_income_3s > 1000000) {
                        $deducted_total_income['For ' . '₹' . $deducted_total_income_3s . ' Tax 30% Tax Amount'] = $deducted_total_income_3s * 0.30;
                    }
                }
            }
        } else if ($age > 80) {

            if ($total_income < 500000) {
                return $overall_deduction = 0;
            } else
              if ($total_income > 500000) {
                $deducted_total_income['For ₹500000 : Tax - 20% Tax Amount'] = 100000;
                $deducted_total_income_2s = $total_income - 500000;

                if ($deducted_total_income_2s < 1000000) {
                    $deducted_total_income['For_' . '₹' . $deducted_total_income_2s . ' : Tax - 20% Tax Amount'] = $deducted_total_income_2s * 0.20;
                }

                if ($deducted_total_income_2s > 1000000) {
                    $deducted_total_income['For_' . '₹' . $deducted_total_income_2s . ' Tax - 30% Tax Amount'] = $deducted_total_income_2s * 0.30;
                }
            }
        }

        $sumOftax = 0;
        foreach ($deducted_total_income as $key => $tax_calculate) {
            if ($key == 'Exception ₹250000 and the balance amount') {
                $sumOftax += 0;
            } else {
                $sumOftax += $tax_calculate;
            }
        }
        $deducted_total_income['Tax on total Income'] = $sumOftax;

        $deducted_total_income['Less : Rebate Under Section 87A'] = 0;

        $deducted_total_income['Note : if taxable income is less than ₹500000, tax rebate of a maximum of ₹12500 is provided under Section 87A'] = 0;

        return $deducted_total_income;
    }

    private function subChargeCalculation($total_income)
    {
        if ($total_income < 5000000) {
            return $subcharge = 0;
        } else if ($total_income >= 5000000 && $total_income < 10000000) {
            $subcharge = $total_income * 10 / 100;
            return $subcharge;
        } else if ($total_income >= 10000000 && $total_income < 20000000) {
            $subcharge = $total_income * 15 / 100;
            return $subcharge;
        } else if ($total_income >= 20000000 && $total_income < 50000000) {
            $subcharge = $total_income * 25 / 100;
            return $subcharge;
        } else if ($total_income > 50000000) {
            $subcharge = $total_income * 37 / 100;
            return $subcharge;
        }
    }

    private function rebateUs87acalc($regime, $taxable_income, $tax_income)
    {

        if ($regime == "new") {
            if ($taxable_income > 700000) {
                $rebate = 0;
                return $rebate;
            } else {
                if ($tax_income >= 25000) {
                    $rebate = 25000;
                    return $rebate;
                } elseif ($tax_income < 25000) {
                    $rebate = $tax_income;
                    return $rebate;
                }
            }
        } elseif ($regime == "old") {
            if ($taxable_income > 500000) {
                $rebate = 0;
                return $rebate;
            } else {
                if ($tax_income >= 12500) {
                    $rebate = 12500;
                    return $rebate;
                } elseif ($tax_income < 12500) {
                    $rebate = $tax_income;
                    return $rebate;
                }
            }
        }
    }

    /* ------------- End ----------------*/
}
