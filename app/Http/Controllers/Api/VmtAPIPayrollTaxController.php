<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VmtPayrollTaxService;

class VmtAPIPayrollTaxController extends Controller
{
    public function getEmployeeTDSWorksheetAsPDF(Request $request, VmtPayrollTaxService $vmtPayrollTaxService){

        return $vmtPayrollTaxService->getEmployeeTDSWorksheet($request->user_code,$request->payroll_month,'pdf');

    }

    public function getEmployeeTDSWorksheetAsHTML(Request $request, VmtPayrollTaxService $vmtPayrollTaxService){

        return $vmtPayrollTaxService->getEmployeeTDSWorksheet($request->user_code,$request->payroll_month,'html');

    }
}
