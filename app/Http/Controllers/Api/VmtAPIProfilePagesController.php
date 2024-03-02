<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Validation\Rule;

use App\Services\VmtProfilePagesService;
use App\Services\VmtEmployeeService;

class VmtAPIProfilePagesController extends HRMSBaseAPIController
{

    public function updateProfilePicture(Request $request, VmtProfilePagesService $serviceProfilePagesService){

        $validator = Validator::make(
            $data = [
                'user_code' => $request->user_code,
                'file_object' => $request->file_object,
            ],
            $rules = [
                'user_code' => 'required|exists:users,user_code',
                'file_object' => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

         $user_id = User::where('user_code',$request->user_code)->first()->id;
        return $serviceProfilePagesService->updateProfilePicture($user_id, $request->file_object);
    }

    public function getProfilePicture(Request $request, VmtProfilePagesService $serviceProfilePagesService){

        $validator = Validator::make(
            $data = [
                'user_code' => $request->user_code,
            ],
            $rules = [
                'user_code' => 'required|exists:users,user_code',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }



        $user_id = User::where('user_code',$request->user_code)->first()->id;
        return $serviceProfilePagesService->getProfilePicture($user_id);
    }

    public function deleteProfilePicture(Request $request, VmtProfilePagesService $serviceProfilePagesService){

        $validator = Validator::make(
            $data = [
                'user_code' => $request->user_code,
            ],
            $rules = [
                'user_code' => 'required|exists:users,user_code',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }



        $user_id = User::where('user_code',$request->user_code)->first()->id;
        return $serviceProfilePagesService->deleteProfilePicture($user_id);
    }

    public function uploadDocument(Request $request, VmtEmployeeService $serviceEmployeeService){
        return $serviceEmployeeService->uploadDocument($request->emp_id, $request->fileObject , $request->onboard_document_type);
    }

    public function fetchEmployeeProfileDetails(Request $request, VmtProfilePagesService $serviceVmtProfilePagesService)
    {

   $validator = Validator::make(
            $request->all(),
            $rules = [
                "user_code" => 'required|exists:users,user_code',
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        $user_id = User::where('user_code', $request->user_code)->first()->id;
        $data = $serviceVmtProfilePagesService->getEmployeeProfileDetails($user_id);

        return response()->json([
            'status' => 'success',
            'message' => '',
            'data'   => $data
        ]);
    }

    public function updateEmployeeGeneralInformation(Request $request, VmtProfilePagesService $serviceVmtProfilePagesService, VmtEmployeeService $employeeService)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "birthday" => 'required',
                "gender"  => 'required',
                "marital_status"  => 'required|exists:vmt_marital_status,name',
                "blood_group"  => 'required|exists:vmt_bloodgroup,name',
                "physically_challenged" => 'required',
                "doc_obj" => 'required'
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        $user_id = user::where('user_code', $request->user_code)->first()->id;

        $response = $serviceVmtProfilePagesService->updateEmployeeGeneralInformation(
            user_id: $user_id,
            birthday: $request->birthday,
            gender: $request->gender,
            marital_status: $request->marital_status,
            blood_group: $request->blood_group,
            phy_challenged: $request->phy_challenged,
        );

       $emp_file =$employeeService->uploadDocument($user_id, $request->doc_obj,$onboard_document_type='Birth Certificate' );

        return $response;
    }

    public function updateEmployeeContactInformation(Request $request, VmtProfilePagesService $serviceVmtProfilePagesService)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "personal_email" => 'required|email:rfc,dns',
                "office_email"  => 'required|email:rfc,dns',
                "mobile_number"  => 'required',
                "current_address_line_1"  => 'required',
                "current_address_line_2"  => 'required',
                "permanent_address_line_1"  => 'required',
                "permanent_address_line_2"  => 'required',


            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
                "email" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        $response = $serviceVmtProfilePagesService->updateEmployeeContactInformation(
            user_code: $request->user_code,
            personal_email: $request->personal_email,
            office_email: $request->office_email,
            mobile_number: $request->mobile_number,
            current_address_line_1: $request->current_address_line_1,
            current_address_line_2: $request->current_address_line_1,
            permanent_address_line_1: $request->permanent_address_line_1,
            permanent_address_line_2: $request->permanent_address_line_2,
        );

        return $response;
    }
    public function addEmployeeFamilyDetails(Request $request, VmtProfilePagesService $serviceVmtProfilePagesService)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "name" => 'required',
                "relationship"  => 'required',
                "dob"  => 'required',
                "phone_number"  => 'required',

            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
                "email" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        $response = $serviceVmtProfilePagesService->addFamilyDetails(
            user_code: $request->user_code,
            name: $request->name,
            relationship: $request->relationship,
            dob: $request->dob,
            phone_number: $request->phone_number


        );

        return $response;
    }
    public function updateEmployeeFamilyDetails(Request $request, VmtProfilePagesService $serviceVmtProfilePagesService)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                "record_id" => 'required',
                "name" => 'required',
                "relationship"  => 'required',
                "dob"  => 'required',
                "phone_number"  => 'required',

            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
                "email" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        $response = $serviceVmtProfilePagesService->updateFamilyDetails(
            record_id:$request->record_id,
            name: $request->name,
            relationship: $request->relationship,
            dob: $request->dob,
            phone_number: $request->phone_number


        );

        return $response;
    }
    public function deleteEmployeeFamilyDetails(Request $request, VmtProfilePagesService $serviceVmtProfilePagesService)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                "user_code" => 'required|exists:users,user_code', //not used now
                "record_id" => 'required',
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
                "email" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        $response = $serviceVmtProfilePagesService->deleteEmployeeFamilyDetails(
            user_code:$request->user_code,
            record_id: $request->record_id,



        );

        return $response;
    }
    public function updateEmployeeBankDetails(Request $request, VmtProfilePagesService $serviceVmtProfilePagesService, VmtEmployeeService $employeeService)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                "user_code" => 'required|exists:users,user_code', //not used now
                "bank_id" => 'required',
                "bank_ifsc_code" => 'required',
                "bank_account_number" =>'required',
                "pan_number"=>'required'

            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
                "email" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        $user_id = user::where('user_code', $request->user_code)->first()->id;

        $response = $serviceVmtProfilePagesService->updateEmployeeBankDetails(
            user_id:$user_id,
            bank_id:$request->bank_id,
            bank_ifsc_code: $request->bank_ifsc_code,
            bank_account_number: $request->bank_account_number,
            pan_number: $request->pan_number,

        );

        $emp_file =$employeeService->uploadDocument($user_id, $request->doc_obj,$onboard_document_type='Bank Passbook');


        return $response;


}
    public function addEmployeeExperianceDetails(Request $request, VmtProfilePagesService $serviceVmtProfilePagesService, VmtEmployeeService $employeeService)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                "user_code" => 'required|exists:users,user_code', //not used now
                "company_name" => 'required',
                "location" => 'required',
                "job_position" =>'required',
                "period_from"=>'required',
                "period_to"=>'required',
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
                "email" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        $response = $serviceVmtProfilePagesService->addEmployeeExperianceDetails(
            user_code:$request->user_code,
            company_name:$request->company_name,
            location: $request->location,
            job_position: $request->job_position,
            period_from: $request->period_from,
            period_to: $request->period_to

        );



        return $response;
}
    public function updateEmployeeExperianceDetails(Request $request, VmtProfilePagesService $serviceVmtProfilePagesService, VmtEmployeeService $employeeService)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
                "user_code" => 'required|exists:users,user_code', //not used now
                "company_name" => 'required',
                "location" => 'required',
                "job_position" =>'required',
                "period_from"=>'required',
                "period_to"=>'required',
                "exp_current_table_id" => 'required'
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
                "email" => "Field :attribute is invalid"
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        $response = $serviceVmtProfilePagesService->updateEmployeeExperianceDetails(
            user_code:$request->user_code,
            company_name:$request->company_name,
            location: $request->location,
            job_position: $request->job_position,
            period_from: $request->period_from,
            period_to: $request->period_to,
            exp_current_table_id:$request->exp_current_table_id
        );

        return $response;


}
    public function deleteEmployeeExperianceDetails(Request $request, VmtProfilePagesService $serviceVmtProfilePagesService, VmtEmployeeService $employeeService)
    {

        $validator = Validator::make(
            $request->all(),
            $rules = [
               "exp_current_table_id"=>'required'
            ],
            $messages = [
                "required" => "Field :attribute is missing",
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        $response = $serviceVmtProfilePagesService->deleteEmployeeExperianceDetails(
            exp_current_table_id:$request->exp_current_table_id,
        );

        return $response;
}


}
