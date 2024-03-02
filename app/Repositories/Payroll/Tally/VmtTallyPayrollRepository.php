<?php

namespace App\Repositories\Payroll\Tally;

use App\Interfaces\Payroll\Tally\VmtTallyPayroll_RepInterface;
use App\Models\VmtPayroll;

class VmtTallyPayrollRepository implements VmtTallyPayroll_RepInterface{


    public function getDefaultPayrollJournalData($company_name, $payroll_date, $payroll_outcome_data){

        return [
            "company_name" => $company_name,
            "payroll_date" => $payroll_date,
            "payroll_journal" => [
                [
                    "account_name" => "Salaries",
                    "gl_code" => "",
                    "debit" => $payroll_outcome_data["employee_payables"]["total amount"],
                    "credit" => "0.00",
                    "currency" => "INR"
                ],
                [
                    "account_name" => "EPF Payables",
                    "gl_code" => "",
                    "debit" => "0.00",
                    "credit" => $payroll_outcome_data["EPF"]["total amount"],
                    "currency" => "INR"
                ],
                [
                    "account_name" => "ESIC Payables",
                    "gl_code" => "",
                    "debit" => "0.00",
                    "credit" => $payroll_outcome_data["ESIC"]["total amount"],
                    "currency" => "INR"
                ],
                [
                    "account_name" => "TDS Payables - Salary",
                    "gl_code" => "",
                    "debit" => "0.00",
                    "credit" => "0.00",
                    "currency" => "INR"
                ],
                [
                    "account_name" => "Professional Tax Payables",
                    "gl_code" => "",
                    "debit" => "0.00",
                    "credit" => $payroll_outcome_data["professional_tax"]["total amount"],
                    "currency" => "INR"
                ],
                [
                    "account_name" => "LWF Payables",
                    "gl_code" => "",
                    "debit" => $payroll_outcome_data["lwf"]["total amount"],
                    "credit" => "0.00",
                    "currency" => "INR"
                ],
                [
                    "account_name" => "Salary Payables",
                    "gl_code" => "",
                    "debit" => "0.00",
                    "credit" => "---",
                    "currency" => "INR"
                ],
                [
                    "account_name" => "Employee Loan",
                    "gl_code" => "",
                    "debit" => "0.00",
                    "credit" => "---",
                    "currency" => "INR"
                ]
            ]
        ];
    }
}
