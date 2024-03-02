<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\VmtEmployeePayCheckService;
use App\Services\VmtAttendanceService;

class VmtAPIPaySlipController extends Controller
{
    public function getEmployeePayslipDetails(Request $request, VmtEmployeePayCheckService $serviceEmployeePayslipService,VmtAttendanceService $serviceVmtAttendanceService){

       $response = $serviceEmployeePayslipService->viewPayslipdetails( user_code : $request->user_code,
                                                                    year : $request->year,
                                                                    month : $request->month,
                                                                    serviceVmtAttendanceService:$serviceVmtAttendanceService
                                                               );

      return $response;

    }
    public function getMobileEmployeePayslipDetails(Request $request, VmtEmployeePayCheckService $serviceEmployeePayslipService,VmtAttendanceService $serviceVmtAttendanceService){

       $response = $serviceEmployeePayslipService->getMobileEmployeePayslipDetails( user_code : $request->user_code,
                                                                    year : $request->year,
                                                                    month : $request->month,
                                                                    serviceVmtAttendanceService:$serviceVmtAttendanceService
                                                               );
//dd($response);
      return $response;

    }
    // public function getEmployeePayslipDetails(Request $request, VmtEmployeePayCheckService $serviceEmployeePayslipService){

    //    $response = $serviceEmployeePayslipService->getEmployeePayslipDetails( user_code : $request->user_code,
    //                                                                 year : $request->year,
    //                                                                 month : $request->month
    //                                                             );

    //     return $response;
    // }


    public function getEmployeePayslipDetailsAsPDF(Request $request, VmtEmployeePayCheckService $serviceEmployeePayslipService,VmtAttendanceService $serviceVmtAttendanceService){

             $response = $serviceEmployeePayslipService->generatePayslip( user_code : $request->user_code,
                                                                    year : $request->year,
                                                                    month : $request->month,
                                                                    type:  "pdf",
                                                                    serviceVmtAttendanceService:$serviceVmtAttendanceService
                                                                );

        return $response;
    }

    public function getEmployeePayslipDetailsAsHTML(Request $request, VmtEmployeePayCheckService $serviceEmployeePayslipService,VmtAttendanceService $serviceVmtAttendanceService){

              $response = $serviceEmployeePayslipService->generatePayslip( user_code : $request->user_code,
                                                                    year : $request->year,
                                                                    month : $request->month,
                                                                    type: "html",
                                                                    serviceVmtAttendanceService:$serviceVmtAttendanceService
                                                                );
         return $response;
     }
    public function sendEmployeePayslipMail(Request $request, VmtEmployeePayCheckService $serviceEmployeePayslipService,VmtAttendanceService $serviceVmtAttendanceService){

              $response = $serviceEmployeePayslipService->generatePayslip( user_code : $request->user_code,
                                                                    year : $request->year,
                                                                    month : $request->month,
                                                                    type: "mail",
                                                                    serviceVmtAttendanceService:$serviceVmtAttendanceService
                                                                );

         return $response;
     }

    public function getEmployeeAllPayslipList(Request $request, VmtEmployeePayCheckService $serviceEmployeePayslipService){

       $response = $serviceEmployeePayslipService->getEmployeeAllPayslipList( user_code : $request->user_code);

        return $response;
    }



    public function getEmployeeCompensatoryDetails(Request $request, VmtEmployeePayCheckService $serviceEmployeePayCheckService){
        $response = $serviceEmployeePayCheckService->getEmployeeCompensatoryDetails( user_code : $request->user_code);

         return $response;
    }

    public function getEmployeeYearlyAndMonthlyCTC(Request $request, VmtEmployeePayCheckService $serviceEmployeePayCheckService){
       $response =  $serviceEmployeePayCheckService->getEmployeeYearlyAndMonthlyCTC($request->user_code);
       return $response;
    }
    public function getEmpMobilePayrollDashboardDetails(Request $request, VmtEmployeePayCheckService $serviceEmployeePayCheckService){
       $response =  $serviceEmployeePayCheckService->getEmpMobilePayrollDashboardDetails($request->user_code);
       return $response;
    }



}
