<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VmtApprovalsService;

class VmtApiApprovalsController extends Controller
{

    public function isAllOnboardingDocumentsApproved(Request $request, VmtApprovalsService $serviceApprovalService){
        return $serviceApprovalService->isAllOnboardingDocumentsApproved($request->user_code);
    }
}
