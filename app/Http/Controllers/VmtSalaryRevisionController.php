<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VmtSalaryRevision;
use App\Services\VmtSalaryRevisionService;
use App\Services\VmtPayrollService;

class VmtSalaryRevisionController extends Controller
{

    public function getAllEmployeeData(Request $request, VmtSalaryRevisionService $vmtSalaryRevisionService){

        return  $vmtSalaryRevisionService->getAllEmployeeData();
    }

    public function saveEmployeesSalaryRevisionDetails(Request $request, VmtSalaryRevisionService $vmtSalaryRevisionService){


        //     $response= $vmtSalaryRevisionService->saveEmployeesSalaryRevisionDetails(
        //         $request->user_id,
        //         $request->frequency,
        //         $request->increment_on,
        //         $request->percentage,
        //         $request->amount,
        //         $request->revised_amount,
        //         $request->arrear_calculation_type,
        //         $request->effective_date,
        //         $request->reason,
        //         $request->process_status,
        //     );
        // return  $response;
            $response= $vmtSalaryRevisionService->saveEmployeesSalaryRevisionDetails(
                $request->user_id ="156",
                $request->frequency='1',
                $request->increment_on='cic',
                $request->percentage='0.5',
                $request->amount=5000,
                $request->revised_amount=55000,
                $request->arrear_calculation_type='component_wise',
                $request->effective_date='2023-11-01',
                $request->reason ='',
                $request->process_status='1'
            );
        return  $response;

    }
    public function processEmployeesSalaryRevisionDetails(Request $request, VmtSalaryRevisionService $servicevmtSalaryRevisionService,VmtPayrollService $seviceVmtPayrollService){

        $response = $servicevmtSalaryRevisionService->processEmployeesSalaryRevisionDetails($request->user_ids='156',$seviceVmtPayrollService);

       return $response;
    }


    public function getSalaryRevisiedEmplyeeDetails(Request $request, VmtSalaryRevisionService $vmtSalaryRevisionService){

         $response = $vmtSalaryRevisionService->employeeSalaryRevesionCalculation($user_id='156',$amount =18500,$increment_on = 'net_income');
        // $response = $vmtSalaryRevisionService->saveEmployeesSalaryRevisionDetails();

        return response()->json($response);
    }





}
