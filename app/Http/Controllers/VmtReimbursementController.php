<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VmtReimbursementsService;

class VmtReimbursementController extends Controller
{
    public function showReimbursementsPage(Request $request){
       return view('approvals.vmt_employee_reimbursements');
    }

    public function getReimbursementClaimTypes(Request $request, VmtReimbursementsService $serviceVmtReimbursementsService){

        return $serviceVmtReimbursementsService->getReimbursementClaimTypes();
    }

    public function getModeOfTransports(Request $request, VmtReimbursementsService $serviceVmtReimbursementsService){
        return $serviceVmtReimbursementsService->getModeOfTransports();
    }

    public function saveReimbursementsData(Request $request, VmtReimbursementsService $serviceVmtReimbursementsService){

        // dd($request->all());

        return $serviceVmtReimbursementsService->saveReimbursementData_LocalConveyance( user_code: $request->user_code,
                                                                                        date : $request->date,
                                                                                        reimbursement_type: $request->reimbursement_type,
                                                                                        entry_mode: $request->entry_mode,
                                                                                        vehicle_type: $request->vehicle_type,
                                                                                        from:  $request->from,
                                                                                        to: $request->to,
                                                                                        distance_travelled: $request->distance_travelled,
                                                                                        user_comments:   $request->user_comments);

    }

    public function saveReimbursementData_Claims(Request $request, VmtReimbursementsService $serviceVmtReimbursementsService){

        // dd($request->all());

        return $serviceVmtReimbursementsService->saveReimbursementData_Claims( user_code: $request->user_code,
                                                                                        date : $request->date,
                                                                                        reimbursement_type: $request->reimbursement_type,
                                                                                        entry_mode: $request->entry_mode,
                                                                                        claim_amount: $request->claim_amount,
                                                                                        file_upload: $request->file_upload,
                                                                                        reimbursement_remarks:   $request->reimbursement_remarks);

    }



    public function fetchEmployeeReimbursement(Request $request,VmtReimbursementsService $reimbursementService){

        $user_id = auth()->user()->id;
        $year = $request->selected_year;
        $month = $request->selected_month;
         $response = $reimbursementService->fetchEmployeeReimbursement($user_id,$year,$month);
        return $response;
    }
}
