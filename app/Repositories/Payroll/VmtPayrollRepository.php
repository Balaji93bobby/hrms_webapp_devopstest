<?php

namespace App\Repositories\Payroll;

use App\Interfaces\Payroll\VmtPayroll_RepInterface;
use App\Models\VmtPayroll;
use App\Models\VmtEmployee;
use App\Models\Compensatory;

use Carbon\Carbon;

class VmtPayrollRepository implements VmtPayroll_RepInterface{

    //Stores the payroll details.
    //TODO : Need to cache the data to avoid DB overload
    protected $query_employees_payroll_details;

    public function loadProcessedPayrollData($client_code, $month, $year){

        /*
            Load the processed payroll data from DB and store
            in cache.
        */
        if(empty($this->query_employees_payroll_details)){

            //Get all the employees earnings details

            $this->query_employees_payroll_details = VmtPayroll::leftjoin('vmt_client_master', 'vmt_client_master.id', '=', 'vmt_payroll.client_id')
                ->leftJoin('vmt_emp_payroll', 'vmt_emp_payroll.payroll_id', '=', 'vmt_payroll.id')
                ->leftJoin('users', 'users.id', '=', 'vmt_emp_payroll.user_id')
                ->leftJoin('vmt_employee_payslip_v2', 'vmt_employee_payslip_v2.emp_payroll_id', '=', 'vmt_emp_payroll.id')
                // ->leftjoin('vmt_salary_revisions', 'vmt_salary_revisions.id','=','users.id')
                // ->leftJoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                //->leftJoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->leftJoin('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'users.id')
                ->leftJoin('vmt_employee_statutory_details', 'vmt_employee_statutory_details.user_id', '=', 'users.id')
                //->leftJoin('vmt_department', 'vmt_department.id', '=', 'vmt_employee_office_details.department_id')
                //->leftJoin('vmt_banks', 'vmt_banks.id', '=', 'vmt_employee_details.bank_id')
                // ->orderBy('vmt_salary_revisions.effective_date','DESC')
                ->where('users.is_ssa', '0')
                ->where('active', 1)
                ->where('vmt_client_master.client_code', $client_code)
                ->whereYear('payroll_date', $year)
                ->whereMonth('payroll_date', $month);

        }

        return $this->query_employees_payroll_details;

    }


    public function getPayrollOutcomes($client_code, $month, $year){

        if(empty($this->query_employees_payroll_details)){
            $this->loadProcessedPayrollData($client_code, $month, $year);
        }

        //Base structure of Payroll Outcomes for UI
        $response_data = [
            "currency_type" => "INR",
            "payroll_outcome" => [
                "employee_payables" => [
                    "header" => 'Employee Payable',
                    "bank_transfer" => 0.0,
                    "cheques" => 0.0,
                    "cash" => 0.0,
                ],
                "income_tax" => [
                    "header" => 'Income Tax (TDS-192 B)',
                    "incometax_payable" => 0.0,
                    "no_of_employees" => 0.0,
                    "total amount" => 0.0
                ],
                "EPF" => [
                    'header' => "EPF",
                    "employee_share" => 0.0,
                    "vpf_share" => 0.0,
                    "employer_share" => 0.0,
                    "other_charges" => 0.0,
                    "total amount" => 0.0,

                ],
                "ESIC" => [
                    'header' => "ESIC",
                    "employee_share" => 0.0,
                    "employer_share" => 0.0,
                    "total amount" => 0.0,
                ],
                "professional_tax" => [
                    "header" => "Professional Tax",
                    "tax_payable" => 0.0,
                    "no_of_employees" => 0.0,
                    "states" => 0.0,
                    "total amount" => 0.0,

                ],

                "lwf" => [
                    "header" => "LWF",
                    "employee_lwf" => 0.0,
                    "employer_lwf" => 0.0,
                ],
                "insurance" => [
                    "header" => "Insurance",
                    "employee_share" => 0.0,
                    "employer_share" => 0.0,
                    "total amount" => 0.0,
                ],
                "Other_deduction" => [
                    "header" => "Other Deduction",
                    "canteen_deduction" => 0.0,
                    "sal_adv_deduction" => 0.0,
                    "other_deduction" => 0.0,
                    "total_deduction" => 0.0,
                ],
            ],
            "payroll_stats" => [
                "total_employees" => 0,
                "calendar_days" => 0,
                "payroll_processed" => 0,
                "total_payroll_cost" => 0,
                "employee_deposit" => 0,
                "total_deductions" => 0,
                "total_contributions" => 0,
            ]

        ];

        //dd($this->query_employees_payroll_details->get());

        //get salrevision data
        $sal_rev_data = Compensatory::leftjoin('vmt_salary_revisions', 'vmt_salary_revisions.id', '=', 'vmt_employee_compensatory_details.sal_revision_id')
                        ->orderBy('effective_date', 'DESC');


        $month_days = Carbon::now()->month($month)->daysInMonth;
        $selected_date_format = Carbon::createFromFormat('Y-m-d', $year.'-'.$month.'-01');
        $response_data['selected_start_end_date'] = $selected_date_format->clone()->format('M Y') . "(" . $selected_date_format->clone()->startOfMonth()->format('M d') . " - " . $selected_date_format->clone()->endOfMonth()->format('M d') . "," . $month_days . " Days" . ")";

        $emp_payables =  $this->getEmployeePayables();
        $response_data["payroll_outcome"]["employee_payables"]["header"] = $emp_payables['header'];
        $response_data["payroll_outcome"]["employee_payables"]["bank_transfer"] = $emp_payables['bank_transfer'];
        $response_data["payroll_outcome"]["employee_payables"]["cheques"] = $emp_payables['cheques'];
        $response_data["payroll_outcome"]["employee_payables"]["cash"] = $emp_payables['cash'];
        $response_data["payroll_outcome"]["employee_payables"]["total amount"] = $emp_payables['total amount'];


        $response_data["payroll_outcome"]["EPF"] =  $this->getOverall_EPF();
        $response_data["payroll_outcome"]["ESIC"] = $this->getOverall_ESIC();
        $response_data["payroll_outcome"]["professional_tax"] = $this->getOverall_PT();
        $response_data["payroll_outcome"]["lwf"] = $this->getOverall_LWF();
        $response_data["payroll_outcome"]["Other_deduction"] = $this->getoverall_Others();

        $t_overall_it =  $this->getOverall_IT();
        $response_data["payroll_outcome"]["income_tax"]["incometax_payable"] = $t_overall_it["incometax_payable"];
        $response_data["payroll_outcome"]["income_tax"]["no_of_employees"] = $t_overall_it["no_of_employees"];
        $response_data["payroll_outcome"]["income_tax"]["total amount"] = $t_overall_it["total amount"];


        $exit_emp_details = VmtEmployee::whereMonth('dol', $month)->whereyear('dol', $year)->get();
        $newjoinee_emp_details = VmtEmployee::whereMonth('doj', $month)->whereyear('dol', $year)->get();

        $response_data["payroll_stats"]["calendar_days"] = $month_days;
        $response_data["payroll_stats"]["total_employees"] = $this->query_employees_payroll_details->count();
        $response_data["payroll_stats"]["new_employees"] = count($newjoinee_emp_details);
        $response_data["payroll_stats"]["exit_employees"] = count($exit_emp_details);
        $response_data["payroll_stats"]["payroll_processed"] = $this->query_employees_payroll_details->count() . " Employees";
        $response_data["payroll_stats"]["total_payroll_cost"] = $response_data["payroll_outcome"]["EPF"]["total amount"] +
            $response_data["payroll_outcome"]["ESIC"]["total amount"] +
            $response_data["payroll_outcome"]["income_tax"]["total amount"] +
            $response_data["payroll_outcome"]["insurance"]["total amount"] +
            $response_data["payroll_outcome"]["Other_deduction"]["total_deduction"] +
            $response_data["payroll_outcome"]["professional_tax"]["total amount"] +
            $response_data["payroll_outcome"]["employee_payables"]["total amount"];

        $emp_overall_deposit =  $this->empOverallDeposit();
        $response_data["payroll_stats"]["employee_deposit"] = $emp_overall_deposit;
        $response_data["payroll_stats"]["total_deductions"] = $response_data["payroll_outcome"]["Other_deduction"]["total_deduction"];

        $response_data["payroll_stats"]["total_contributions"] = $response_data["payroll_outcome"]["EPF"]["total amount"] +
            $response_data["payroll_outcome"]["ESIC"]["total amount"] +
            $response_data["payroll_outcome"]["income_tax"]["total amount"] +
            $response_data["payroll_outcome"]["professional_tax"]["total amount"] +
            $response_data["payroll_outcome"]["lwf"]["total amount"] +
            $response_data["payroll_outcome"]["insurance"]["total amount"];

        return $response_data;
    }

    public function executePayrollProcess(){

    }


    public function calculateOverallNetSalaryPayables()        //$array_overall_earnings, $array_overall_contributions, $array_overall_deductions
    {
        if(empty($this->query_employees_payroll_details)){
            return null;
        }

        $overall_net_salary = 0;
        $overall_earnings = 0;
        $overall_contributions = 0;
        $overall_deductions = 0;

        $array_overall_earnings = $this->query_employees_payroll_details->get(
            [
                //'users.user_code as User-code',
                //'users.name as Name',
                'vmt_employee_payslip_v2.earned_basic as Basic',
                'vmt_employee_payslip_v2.earned_hra as HRA',
                'vmt_employee_payslip_v2.earned_stats_bonus as Statuory Bonus',
                'vmt_employee_payslip_v2.other_earnings as Other Earnings',
                'vmt_employee_payslip_v2.earned_spl_alw as Special Allow1ance',
                'vmt_employee_payslip_v2.travel_conveyance as Travel Conveyance ',
                'vmt_employee_payslip_v2.earned_child_edu_allowance as Child Education Allowance',
                'vmt_employee_payslip_v2.communication_allowance_earned as Communication Allowance',
                'vmt_employee_payslip_v2.food_allowance_earned as Food Allowance',
                'vmt_employee_payslip_v2.vehicle_reimbursement_earned as Vehicle Reimbursement',
                'vmt_employee_payslip_v2.driver_salary_earned as Driver Salary',
                'vmt_employee_payslip_v2.earned_lta as Leave Travel Allowance',
                'vmt_employee_payslip_v2.other_allowance_earned as Other Allowance',
                'vmt_employee_payslip_v2.overtime as Overtime',
            ]
        )->toArray();

        $array_overall_contributions = $this->query_employees_payroll_details
            ->get(
                [
                    'vmt_employee_payslip_v2.epf_ee as EPF Employee',
                    'vmt_employee_payslip_v2.employee_esic as ESIC Employee',
                    'vmt_employee_payslip_v2.vpf as VPF',
                ]
            )->toArray();

        $array_overall_deductions = null;

        //calculate the overall earnings
        foreach ($array_overall_earnings as $singleEmployeeEarnings) {
            foreach ($singleEmployeeEarnings as $key => $value) {
                if (!empty($value))
                    $overall_earnings += $value;
            }
        }

        //calculate the overall contributions
        foreach ($array_overall_contributions as $singleEmployeeContributions) {

            foreach ($singleEmployeeContributions as $key => $value) {
                if (!empty($value))
                    $overall_contributions += $value;
            }
        }

        foreach ($array_overall_deductions as $singleEmployeeDeductions) {

            foreach ($singleEmployeeDeductions as $key => $value) {
                if (!empty($value))
                    $overall_deductions += $value;
            }
        }

        $overall_net_salary = $overall_earnings - $overall_contributions - $overall_deductions;

        return $overall_net_salary;
    }

    public function getEmployeePayables()
    {

        if(empty($this->query_employees_payroll_details)){
            return null;
        }

        $emp_payment_mode = $this->query_employees_payroll_details->get();

        $bank_payment = 0;
        $employee_payables = array();
        $cheque_payment = 0;
        $cash_payment = 0;
        foreach ($emp_payment_mode as $single_employee_payment_mode) {

            if ($single_employee_payment_mode->account_number == null) {
                $bank_payment += $single_employee_payment_mode->net_take_home;
            } else {
                $cheque_payment += $single_employee_payment_mode->net_take_home;
            }
        }

        $employee_payables['header'] = "Employee Payables";
        $employee_payables['bank_transfer'] = $bank_payment;
        $employee_payables['cheques'] = $cheque_payment;
        $employee_payables['cash'] = $cash_payment;
        $employee_payables['total amount'] = $bank_payment + $cheque_payment + $cash_payment;
        return $employee_payables;
    }

    public function getOverall_EPF()
    {

        if(empty($this->query_employees_payroll_details)){
            return null;
        }

        $array_overall_epf =  $this->query_employees_payroll_details
        ->get([
            'vmt_employee_payslip_v2.epfr',
            'vmt_employee_payslip_v2.epf_ee',
            'vmt_employee_payslip_v2.vpf',
            'vmt_employee_payslip_v2.edli_charges',
            'vmt_employee_payslip_v2.pf_admin_charges',
        ]);

        $EPF = array();
        $overall_employee_epf = 0;
        $overall_vpf_share = 0;
        $overall_employer_epf = 0;
        $other_charges = 0;
        $epf_total = 0;
        foreach ($array_overall_epf as $single_employee_epf) {
            $overall_employer_epf += (int)$single_employee_epf->epfr;
            $overall_vpf_share += (int)$single_employee_epf->vpf;
            $overall_employee_epf += (int)$single_employee_epf->epf_ee;
            $other_charges  += (int) $single_employee_epf->edli_charges + $single_employee_epf->pf_admin_charges;
            $epf_total = $overall_employee_epf + $overall_vpf_share + $overall_employer_epf + $other_charges;
        }
        $EPF["header"] = "EPF";
        $EPF["employee_share"] = $overall_employee_epf;
        $EPF["VPF_share"] = $overall_vpf_share;
        $EPF["employer_share"] = $overall_employer_epf;
        $EPF["other_charges"] = $other_charges;
        $EPF['total amount'] = $epf_total;
        return $EPF;
    }


    public function getOverall_ESIC()
    {

        if(empty($this->query_employees_payroll_details)){
            return null;
        }

        $array_overall_esic =  $this->query_employees_payroll_details->get([
                                        'vmt_employee_payslip_v2.employer_esi',
                                        'vmt_employee_payslip_v2.employee_esic',
                                    ]);

        $esic_total = 0;
        $ESIC = array();
        $overall_employee_esic = 0;
        $overall_employer_esic = 0;

        foreach ($array_overall_esic as $single_employee_esic) {
            $overall_employee_esic += (int)$single_employee_esic->employee_esic;
            $overall_employer_esic += (int)$single_employee_esic->employer_esi;
            $esic_total = $overall_employee_esic + $overall_employer_esic;
        }
        $ESIC["header"] = "ESIC";
        $ESIC["employee_share"] = $overall_employee_esic;
        $ESIC["employee_share"] = $overall_employee_esic;
        $ESIC["employer_share"] = $overall_employer_esic;
        $ESIC["total amount"] = $esic_total;
        return $ESIC;
    }



    public function getOverall_PT()
    {
        if(empty($this->query_employees_payroll_details)){
            return null;
        }


        $array_overall_PT =  $this->query_employees_payroll_details
            ->get([
                'vmt_employee_payslip_v2.prof_tax',
            ]);


        $professional_tax = array();
        $overall_PT = 0;
        $emp_overall_PT = 0;
        foreach ($array_overall_PT as $single_employee_tax) {
            if ($single_employee_tax->prof_tax >= 0) {
                $overall_PT += (int)$single_employee_tax->prof_tax;
                $emp_overall_PT++;
            }
        }
        $professional_tax["header"] = "Professional Tax";
        $professional_tax["professionaltax_payable"] = $overall_PT;
        $professional_tax["no_of_employee"] = $emp_overall_PT;
        $professional_tax["total amount"] = $overall_PT;
        return $professional_tax;
    }


    public function getOverall_LWF(){

        if(empty($this->query_employees_payroll_details)){
            return null;
        }

        $array_overall_LWF =  $this->query_employees_payroll_details
        ->get([

            'vmt_employee_payslip_v2.employer_lwf',
            'vmt_employee_payslip_v2.employee_lwf',
        ]);


        $lwf_total = 0;
        $LWF = array();
        $overall_employee_lwf = 0;
        $overall_employer_lwf = 0;
        foreach ($array_overall_LWF as $single_employee_lwf) {
            $overall_employee_lwf += (int)$single_employee_lwf->employee_lwf;
            $overall_employer_lwf += (int)$single_employee_lwf->employer_lwf;
            $lwf_total = $overall_employee_lwf + $overall_employer_lwf;
        }
        $LWF["header"] = "LWF";
        $LWF["employee_share"] = $overall_employee_lwf;
        $LWF["employer_share"] = $overall_employer_lwf;
        $LWF["total amount"] = $lwf_total;
        return $LWF;
    }

    public function getoverall_Others(){

        if(empty($this->query_employees_payroll_details)){
            return null;
        }

        $array_overall_others =  $this->query_employees_payroll_details
                        ->get([

                            "vmt_employee_payslip_v2.canteen_dedn",
                            "vmt_employee_payslip_v2.other_deduc",
                            "vmt_employee_payslip_v2.sal_adv",
                        ]);

        $Others = array();
        $canteen_dedct = 0;
        $sal_adv_dedct = 0;
        $other_dedct = 0;
        $total_dedct = 0;

        foreach ($array_overall_others as $single_employee_others) {
            $canteen_dedct += (int)$single_employee_others->canteen_dedn;
            $sal_adv_dedct += (int)$single_employee_others->sal_adv;
            $other_dedct += (int)$single_employee_others->other_deduc;
            $total_dedct = (int)$canteen_dedct + $sal_adv_dedct + $other_dedct;
        }
        $Others["header"] = "Other Deductions";
        $Others["canteen_deduction"] = $canteen_dedct;
        $Others["sal_adv_deduction"] = $sal_adv_dedct;
        $Others["other_deduction"] = $other_dedct;
        $Others["total_deduction"] = $total_dedct;
        return $Others;
    }

    public function getOverall_IT()
    {

        if(empty($this->query_employees_payroll_details)){
            return null;
        }

        $array_overall_IT =   $this->query_employees_payroll_details
            ->get([
                "vmt_employee_payslip_v2.income_tax",
            ]);


        $income_tax = array();
        $overall_IT = 0;
        $emp_overall_IT = 0;
        foreach ($array_overall_IT as $single_employee_tax) {
            if ($single_employee_tax->income_tax > 0) {
                $overall_IT += (int)$single_employee_tax->income_tax;
                $emp_overall_IT++;
            }
        }
        $income_tax["incometax_payable"] = $overall_IT;
        $income_tax["no_of_employees"] = $emp_overall_IT;
        $income_tax["total amount"] = $overall_IT;
        return $income_tax;
    }

    public function empOverallDeposit(){

        if(empty($this->query_employees_payroll_details)){
            return null;
        }

        $emp_overall_deposite =  $this->query_employees_payroll_details
        ->get([

            "vmt_employee_payslip_v2.net_take_home",
        ]);


        $overall_deposit = 0;
        foreach ($emp_overall_deposite as $single_employee_deposite) {
            $overall_deposit += (int)$single_employee_deposite->net_take_home;
        }

        return $overall_deposit;

    }

}
