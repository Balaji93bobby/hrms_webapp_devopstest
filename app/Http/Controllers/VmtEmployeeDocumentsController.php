<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VmtEmployeeDocumentsService;


class VmtEmployeeDocumentsController extends Controller
{
    public function getEmployeeDocumentsSettings(Request $request, VmtEmployeeDocumentsService $serviceVmtEmployeeDocumentsService){
        return $serviceVmtEmployeeDocumentsService->getEmployeeDocumentsSettings();
    }

    public function updateEmployeeDocumentsSettings(Request $request, VmtEmployeeDocumentsService $serviceVmtEmployeeDocumentsService){
        return $serviceVmtEmployeeDocumentsService->updateEmployeeDocumentsSettings($request->all());
    }

}
