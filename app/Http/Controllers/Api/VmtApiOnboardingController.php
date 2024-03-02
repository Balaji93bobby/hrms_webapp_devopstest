<?php

namespace App\Http\Controllers\Api;

use App\Services\VmtEmployeeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VmtApiOnboardingController extends Controller
{
    public function getAllDropdownFilters(Request $request, VmtEmployeeService $vmtEmployeeService)
    {
        return $vmtEmployeeService->getAllDropdownFilters();
    }
    public function getMandatoryDocumentDetails_Mobile(Request $request, VmtEmployeeService $vmtEmployeeService)
    {
        return $vmtEmployeeService->getMandatoryDocumentDetails_Mobile();
    }
    public function saveEmployeeOnboardingPersonalDetails_Mobile(Request $request, VmtEmployeeService $serviceVmtEmployeeService)
    {

        return $serviceVmtEmployeeService->saveEmployeeOnboardingPersonalDetails_Mobile(
            $request->user_code,
            $request->employee_name,
            $request->email,
            $request->marital_status,
            $request->dob,
            $request->doj,
            $request->gender,
            $request->mobile_number,
            $request->aadhar_number,
            $request->pan_number,
            $request->dl_number,
            $request->nationality,
            $request->blood_group
        );
    }
    public function saveEmployeeOnboardingBankDetails_Mobile(Request $request, VmtEmployeeService $serviceVmtEmployeeService)
    {
        return $serviceVmtEmployeeService->saveEmployeeOnboardingBankDetails_Mobile(
            $request->user_code,
            $request->payment_mode,
            $request->bank_name,
            $request->bank_account_number,
            $request->bank_ifsc_code,
        );
    }
    public function saveEmployeeOnboardingAddressDetails_Mobile(Request $request, VmtEmployeeService $serviceVmtEmployeeService)
    {
        return $serviceVmtEmployeeService->saveEmployeeOnboardingAddressDetails_Mobile(
            $request->user_code,
            $request->current_address_line_1,
            $request->current_address_line_2,
            $request->current_country,
            $request->current_state,
            $request->current_city,
            $request->current_pincode,
            $request->permanent_address_line_1,
            $request->permanent_address_line_2,
            $request->permanent_country,
            $request->permanent_state,
            $request->permanent_city,
            $request->permanent_pincode,
        );
    }
    public function saveEmployeeOnboardingFamilyDetails_Mobile(Request $request, VmtEmployeeService $serviceVmtEmployeeService)
    {
        return $serviceVmtEmployeeService->saveEmployeeOnboardingFamilyDetails_Mobile(
            $request->user_code,
            $request->father_name,
            $request->father_dob,
            $request->father_gender,
            $request->father_age,
            $request->mother_name,
            $request->mother_dob,
            $request->mother_gender,
            $request->mother_age,
        );
    }
    public function getEmployeeOnboardingDetails_Mobile(Request $request, VmtEmployeeService $serviceVmtEmployeeService)
    {
        return $serviceVmtEmployeeService->getEmployeeOnboardingDetails_Mobile($request->user_code);
    }
    public function saveEmployeeOnboardingdocumentDetails_Mobile(Request $request, VmtEmployeeService $serviceVmtEmployeeService)
    {
        $document_details =$request->all();

        $response=null;
        foreach ($document_details as $key => $single_document_details) {

            $response = $serviceVmtEmployeeService->saveEmployeeOnboardingdocumentDetails_Mobile( $single_document_details['user_code'],$single_document_details['document_name'],$single_document_details['document_object']);

            if($response['status'] !='success'){
                 break;
            }
        }
        return $response;

    }



}
