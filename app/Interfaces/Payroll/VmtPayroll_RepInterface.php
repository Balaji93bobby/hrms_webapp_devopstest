<?php

namespace App\Interfaces\Payroll;

/*
    This interfaces does,
    1. Process payroll data.
    2. Get processed payroll data.
    3. And other data derived from processed payroll data.

*/
interface VmtPayroll_RepInterface
{
    public function executePayrollProcess();

    /*
        Get the processed payroll data.
        For now, these data are fetched from 'vmt_employee_payslip_v2' table.

        TODO : Load from cache in future

    */
    public function loadProcessedPayrollData($client_code, $month, $year);

    public function getPayrollOutcomes($client_code, $month, $year);

    public function getEmployeePayables();

    public function getOverall_EPF();

    public function getOverall_PT();

    public function getOverall_LWF();

    public function getoverall_Others();

    public function getOverall_IT();

    public function empOverallDeposit();

    public function calculateOverallNetSalaryPayables();

}
