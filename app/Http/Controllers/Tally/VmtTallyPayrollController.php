<?php

namespace App\Http\Controllers\Tally;

use App\Http\Controllers\Controller;
use App\Services\VmtTallyPayrollService;
use Illuminate\Http\Request;

class VmtTallyPayrollController extends Controller
{
    protected $tallyPayrollService;

    public function __construct(VmtTallyPayrollService $tallyPayrollService){
        $this->tallyPayrollService = $tallyPayrollService;
    }
}
