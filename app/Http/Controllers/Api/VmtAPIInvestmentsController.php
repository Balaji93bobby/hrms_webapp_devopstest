<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\VmtInvestmentsService;

class VmtAPIInvestmentsController extends Controller
{


    public function getInvestmentsFormDetailsTemplate(Request $request, VmtInvestmentsService $serviceVmtInvestmentsService){
        //  dd($request->all());
          return $serviceVmtInvestmentsService->getInvestmentsFormDetailsTemplate($request->form_name);
    }


    public function SaveInvDetails(Request $request, VmtInvestmentsService $serviceVmtInvestmentsService){
        //dd($request->all());

        return $serviceVmtInvestmentsService->SaveInvDetails($request->user_code , $request->form_id , $request->is_submitted, $request->formDataSource);
    }

    public function saveSectionPopups(Request $request, VmtInvestmentsService $serviceVmtInvestmentsService){
       // dd($request->all());

        return $serviceVmtInvestmentsService->saveSectionPopups($request->all());
    }
    public function saveSection80(Request $request, VmtInvestmentsService $serviceVmtInvestmentsService){
       // dd($request->all());

        return $serviceVmtInvestmentsService->saveSection80($request->all());
    }


    public function fetchHousePropertyDetails(Request $request, VmtInvestmentsService $serviceVmtInvestmentsService){
       // dd($request->all());

        return $serviceVmtInvestmentsService->fetchHousePropertyDetails($request->user_code, $request->fs_id);
    }
    public function fetchEmpRentalDetails(Request $request, VmtInvestmentsService $serviceVmtInvestmentsService){
       // dd($request->all());

        return $serviceVmtInvestmentsService->fetchEmpRentalDetails($request->user_code, $request->fs_id);
    }

    public function deleteHousePropertyDetails(Request $request, VmtInvestmentsService $serviceVmtInvestmentsService){
       // dd($request->all());

        return $serviceVmtInvestmentsService->deleteHousePropertyDetails($request->currentTableId);
    }


}


