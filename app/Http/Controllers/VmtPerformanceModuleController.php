<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VmtEmployeePaySlip;
use App\Imports\VmtPaySlip;
use Dompdf\Options;
use Dompdf\Dompdf;
use PDF;


class VmtPerformanceModuleController extends Controller
{
  
    // 
    public function payslipView(Request $request){
        $employees = VmtEmployeePaySlip::select('EMP_NO','EMP_NAME')->get(); 
        return view('vmt_employee_pay_slip', compact('employees'));  
    }

    public function showPerformanceDashboard(Request $request)
    {

        return view('indexPerformanceDashboard');          
    }
}
