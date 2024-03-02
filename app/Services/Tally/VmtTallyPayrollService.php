<?php

namespace App\Services\Tally;

use App\Models\VmtReimbursementVehicleType;
use App\Interfaces\Payroll\Tally\VmtTallyPayroll_RepInterface;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


use Illuminate\Support\Facades\DB;

class VmtTallyPayrollService {


    protected $tallyPayrollRepository;

    public function __construct(VmtTallyPayroll_RepInterface $vmtTallyPayrollRepository){
        $this->tallyPayrollRepository = $vmtTallyPayrollRepository;
    }

    public function getDefaultPayrollJournalData($company_name, $payroll_date, $payroll_outcome_data){
        $this->tallyPayrollRepository->getDefaultPayrollJournalData($company_name, $payroll_date, $payroll_outcome_data);
    }
}
