<?php

namespace App\Interfaces\Payroll\Tally;

interface VmtTallyPayroll_RepInterface
{
    //Returns the default payroll journal data as per Vasa structure.
    //public function getDefaultPayrollJournalData($company_name, $payroll_date);

    public function getDefaultPayrollJournalData($company_name, $payroll_date, $payroll_outcome_data);

}
