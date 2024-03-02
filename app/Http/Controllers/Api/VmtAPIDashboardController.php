<?php

namespace App\Http\Controllers\Api;

//use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\HRMSBaseAPIController;
use Illuminate\Http\Request;
use App\Models\VmtEmployeeAttendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Services\VmtDashboardService;
use App\Services\VmtAttendanceService;
use App\Services\VmtHolidayService;

class VmtAPIDashboardController extends HRMSBaseAPIController
{
    public function getMainDashboardData(Request $request, VmtDashboardService $serviceVmtDashboardService, VmtAttendanceService $serviceVmtAttendanceService, VmtHolidayService  $serviceHolidayService ){


        //Fetch the data
        return $serviceVmtDashboardService->getMainDashboardData($request->user_code, $serviceVmtAttendanceService, $serviceHolidayService);


      
    }




}
