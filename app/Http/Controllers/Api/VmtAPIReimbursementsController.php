<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\VmtReimbursementsService;
use Illuminate\Http\Request;
use Carbon\Carbon;
class VmtAPIReimbursementsController extends Controller
{

    public function saveReimbursementData(Request $request, VmtReimbursementsService $serviceVmtReimbursementsService){
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

        return $serviceVmtReimbursementsService->saveReimbursementData_Claims( user_code: $request->user_code,
                                                                                        date : $request->date,
                                                                                        reimbursement_type: $request->reimbursement_type,
                                                                                        entry_mode: $request->entry_mode,
                                                                                        claim_amount: $request->claim_amount,
                                                                                        file_upload: $request->file_upload,
                                                                                        user_comments:   $request->user_comments);

    }


    public function getReimbursementVehicleTypes(Request $request, VmtReimbursementsService $serviceVmtReimbursementsService){
        return $serviceVmtReimbursementsService->getReimbursementVehicleTypes();
    }

    public function getReimbursementTypes(Request $request, VmtReimbursementsService $serviceVmtReimbursementsService){
        return $serviceVmtReimbursementsService->getReimbursementTypes();
    }

    public function getReimbursementClaimTypes(Request $request, VmtReimbursementsService $serviceVmtReimbursementsService){
        return $serviceVmtReimbursementsService->getReimbursementClaimTypes();
    }

    public function isReimbursementAppliedOrNot(Request $request, VmtReimbursementsService $serviceVmtReimbursementsService){
       // dd($request->all());
        $response = $serviceVmtReimbursementsService->isReimbursementAppliedOrNot(
           $request->user_code,
           $request->date,
        );
        return $response;
    }



}
