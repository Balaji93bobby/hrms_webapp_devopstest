<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use App\Models\VmtEmployeeDetails;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtDocuments;
use App\Models\VmtEmployeeDocuments;
use Illuminate\Support\Facades\DB;
use App\Models\Department;
use App\Models\VmtClientMaster;
use App\Models\Bank;
use App\Models\Experience;
use App\Models\EmployeeProfileTempDetails;
use App\Models\VmtTempEmpNames;
use App\Models\gender;
use App\Models\VmtBloodGroup;
use App\Models\VmtEmployee;
use Illuminate\Http\Request;
use App\Models\VmtEmployeeFamilyDetails;
use App\Models\VmtEmployeeStatutoryDetails;
use App\Models\VmtEmployeePaySlip;
use App\Models\VmtEmployeePaySlipV2;
use App\Models\VmtPayroll;
use App\Models\VmtEmpPayroll;
use App\Models\VmtMaritalStatus;
use App\Models\VmtTempEmployeeProofDocuments;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Services\VmtApprovalsService;
use App\Http\Controllers\VmtProfilePagesController;

class VmtProfilePagesService
{


    /*
        Store employee profile pic in 'storage\employees\PLIPL068\profile_pic'
        Add entry in Users table
    */
    public function updateProfilePicture($user_id, $file_object)
    {

        // dd($user_code,$file_object);

        //Validate
        $validator = Validator::make(
            $data = [
                'user_id' => $user_id,
                'file_object' => $file_object
            ],
            $rules = [
                'user_id' => 'required|exists:users,id',
                'file_object' => 'required'
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



        try {
            $user_code = User::where('id', $user_id)->first()->user_code;
            //Create file name
            $date = date('d-m-Y_H-i-s');
            $file_name =  'pic_' . $user_code . '_' . $date . '.' . $file_object->extension();
            $path = $user_code . '/profile_pics';

            //Store the file in private path
            $file_object->storeAs($path, $file_name, 'private');

            //Get the user record and update avatar column
            $query_user = User::where('user_code', $user_code)->first();
            $query_user->avatar = $file_name;
            $query_user->save();

            return response()->json([
                "status" => "success",
                "message" => "Profile picture updated successfully",
                "data" => '',
            ]);
        } catch (\Exception $e) {

            //dd("Error :: uploadDocument() ".$e);

            return response()->json([
                "status" => "failure",
                "message" => "Failed to save profile picture",
                "data" => $e->getmessage(),
            ]);
        }
    }

    public function getProfilePicture($user_id)
    {
        //Validate
        $validator = Validator::make(
            $data = [
                'user_id' => $user_id,
            ],
            $rules = [
                'user_id' => 'required|exists:users,id',
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

        try {


            $user_code = User::where('id', $user_id)->first()->user_code;
            //Get the user record and update avatar column
            $avatar_filename = User::where('id', $user_id)->first()->avatar;

            //Get the image from PRIVATE disk and send as BASE64
            $response = Storage::disk('private')->get($user_code . "/profile_pics/" . $avatar_filename);


            if ($response) {
                $response = base64_encode($response);
            } else // If no file found, then send this
            {
                return response()->json([
                    'status' => 'failure',
                    'message' => "Profile picture doesnt exist for the given user"
                ]);
            }

            return response()->json([
                "status" => "success",
                "message" => "Profile picture fetched successfully",
                "data" => $response,
            ]);
        } catch (\Exception $e) {

            //dd("Error :: uploadDocument() ".$e);

            return response()->json([
                "status" => "failure",
                "message" => "Unable to fetch profile picture",
                "data" => $e->getmessage(),
            ]);
        }
    }

    public function deleteProfilePicture($user_id)
    {
        //Validate
        $validator = Validator::make(
            $data = [
                'user_id' => $user_id,
            ],
            $rules = [
                'user_id' => 'required|exists:users,id',
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

        try {


            $user_code = User::where('id', $user_id)->first()->user_code;
            //Get the user record and update avatar column
            $avatar_filename = User::where('id', $user_id)->first()->avatar;

            $response = Storage::disk('private')->delete($user_code . "/profile_pics/" . $avatar_filename);

            return response()->json([
                "status" => "success",
                "message" => "Profile picture deleted successfully",
                "data" => $response,
            ]);
        } catch (\Exception $e) {

            //dd("Error :: uploadDocument() ".$e);

            return response()->json([
                "status" => "failure",
                "message" => "Unable to delete profile picture",
                "data" => $e->getmessage(),
            ]);
        }
    }

    /*

        Get employee details related to profile pages.

    */

    public function getEmployeeProfileDetails($user_id)
    {

        $response = User::with(
            [
                'getEmployeeDetails',
                'getEmployeeOfficeDetails',
                'getFamilyDetails',
                'getExperienceDetails',
                'getStatutoryDetails',
                'getEmergencyContactsDetails',
                // 'getEmployeeDocuments',
            ]
        )
            ->where('users.id', $user_id)
            ->first();

        $current_exp = [
            "id" => null,
            "emp_id" => "",
            "user_id" => $user_id,
            "company_name" => VmtClientMaster::where('id', $response->client_id)->first()->client_fullname ?? null,
            "location" => $response->toArray()['get_employee_office_details']['work_location'] ?? null,
            "job_position" => $response->toArray()['get_employee_office_details']['designation'] ?? null,
            "period_from" => $response->toArray()['get_employee_details']['doj'] ?? null,
            "period_to" => "present",
            "created_at" => null,
            "updated_at" => null
        ];

        $response_docs = $this->getEmployeeAllDocumentDetails($user_id);

        // check wheather employee proof documents approved or not .
        $emp_proof_docs = VmtTempEmployeeProofDocuments::join('vmt_documents', 'vmt_documents.id', '=', 'vmt_temp_employee_proof_documents.doc_id')
            ->where('vmt_temp_employee_proof_documents.user_id', $response->id)
            ->get();

        $employee_proof_doc_list = array(
            'Pan Card' => 'updatePancardInfo', 'Cheque leaf/Bank Passbook' => 'updateBankInfo',
            'Aadhar Card Front' => 'updateEmplpoyeeName', 'Birth Certificate' => 'updateEmplpoyeeName',
            'Passport' => 'updatePassportInfo', 'Voter ID' => 'updatevoteridInfo', 'Driving License' => 'updatedrivinglicenseInfo'
        );

        $update_user_data = array();
        if (!empty($emp_proof_docs)) {

            foreach ($employee_proof_doc_list  as $singledoc => $updateuserdata) {

                $emp_doc_status = $emp_proof_docs->Where('document_name', $singledoc)->first();

                if (!empty($emp_doc_status)) {

                    if ($emp_doc_status->doc_type != '' && $emp_doc_status->status == 'Approved') {

                        $update_user_data = $this->replaceEmpTempDataToOrginalDetails($user_id, $emp_doc_status->doc_id);
                    } else if ($emp_doc_status->status == 'Approved') {

                        $update_user_data = (new VmtProfilePagesController)->$updateuserdata($user_id, $emp_doc_status->doc_id);
                    }
                }
            }
        }

        $user_short_name = getUserShortName($user_id);

        $response['user_short_name'] = getUserShortName($user_id);

        $response['short_name_Color'] = shortNameBGColor($user_short_name);

        $current_user_short_name = getUserShortName(auth()->user()->id);

        $response['current_user_short_name'] = getUserShortName(auth()->user()->id);

        $response['current_short_name_Color'] = shortNameBGColor($current_user_short_name);

        $user_client_data = User::where('id', $user_id)->first();


        $response['client_details'] = VmtClientMaster::where('id', $user_client_data->client_id)->first();

        if (empty($response['client_details'])) {
            $response['client_details'] = '';
        }

        $general_info = \DB::table('vmt_client_master')->first();

        $query_client_logo = request()->getSchemeAndHttpHost() . '' . $general_info->client_logo;

        $response['client_logo'] = $query_client_logo;

        $response['employee_documents'] = $response_docs;

        $response['employee_documents_proof'] = $update_user_data;

        // $response['Current_login_user'] = User::where('id', auth()->user()->id)->first();

        $payroll_summary = VmtEmployeePaySlipV2::join('vmt_emp_payroll', 'vmt_emp_payroll.id', '=', 'vmt_employee_payslip_v2.emp_payroll_id')
            ->join('vmt_payroll', 'vmt_payroll.id', 'vmt_emp_payroll.payroll_id')
            ->join('users', 'users.id', 'vmt_emp_payroll.user_id')
            ->where('users.id', '=', $user_id)
            ->orderBy('vmt_payroll.updated_at', 'DESC')
            ->first([
                'vmt_payroll.payroll_date',
                'vmt_employee_payslip_v2.worked_Days',
                'vmt_employee_payslip_v2.lop'
            ]);

        if (!empty($payroll_summary)) {

            $days_in_months = Carbon::parse($payroll_summary['payroll_date'])->daysInMonth;
            $paroll_date = Carbon::parse($payroll_summary['payroll_date'])->format('Y-m-' . $days_in_months . '');
            $payroll_summary['payroll_date'] = $paroll_date;

            $response['payroll_summary'] = $payroll_summary;
        } else {
            $response['payroll_summary'] = '';
        }
        //Add the documents details

        $response['avatar'] = $this->getProfilePicture($user_id)->getData();

        if (!empty($response['getEmployeeOfficeDetails']['department_id']))
            $response['getEmployeeOfficeDetails']['department_name'] = Department::find($response['getEmployeeOfficeDetails']['department_id'])->name ?? 'NA';

        if (!empty($response['getEmployeeOfficeDetails']['l1_manager_code'])) {
            $response['getEmployeeOfficeDetails']['l1_manager_name'] = strtoupper(User::where('user_code', $response['getEmployeeOfficeDetails']['l1_manager_code'])->first()->name) ?? 'NA';
            $response['getEmployeeOfficeDetails']['l1_manager_code'] = strtoupper($response['getEmployeeOfficeDetails']['l1_manager_code']) ?? 'NA';
        }


        if (!empty($response['']['bank_id'])) {
            $response['getEmployeeDetails']['bank_name'] = Bank::find($response['getEmployeeDetails']['bank_id'])->bank_name;
        }
        if (!empty($response['getEmployeeDetails']['bank_id'])) {
            $response['getEmployeeDetails']['bank_name'] = Bank::find($response['getEmployeeDetails']['bank_id'])->bank_name;
        }

        if (!empty($response['getEmployeeDetails']['blood_group_id'])) {
            $response['getEmployeeDetails']['blood_group_name'] = VmtBloodGroup::where('id', $response['getEmployeeDetails']['blood_group_id'])->first()->name ?? '';
        }

        if (!empty($response['getEmployeeDetails']['marital_status_id'])) {
            $query = VmtMaritalStatus::where('id', $response['getEmployeeDetails']['marital_status_id']);

            // $response['getEmployeeDetails']['marital_status'] = VmtMaritalStatus::where('id',$response['getEmployeeDetails']['marital_status_id'])->first()->name;

            if ($query->exists()) {
                $response['getEmployeeDetails']['marital_status'] = $query->first()->name;
            } else {
                $response['getEmployeeDetails']['marital_status'] = 'Undefined';
            }
        }

        $response['profile_completeness'] = calculateProfileCompleteness($user_id);

        $response = $response->toArray();
        $response['get_experience_details'][] = $current_exp;
        $array_rev = array_reverse($response['get_experience_details']);
        $response['get_experience_details'] = $array_rev;
        //Remove ID from user table
        unset($response['id']);
        //dd($response['getEmployeeDetails']);
        if (!empty($response['getEmployeeDetails'])) {
            foreach ($response['getEmployeeDetails']->toArray() as $key => $value) {
                if ($value == null || empty($value) || $value == 'none') {
                    $response['getEmployeeDetails'][$key] = '';
                }
            }
            // $response['getEmployeeDetails']['current_address_line_1'] = $response['getEmployeeDetails']['current_address_line_1'].','.$response['getEmployeeDetails']['current_address_line_2'];
            // $response['getEmployeeDetails']['permanent_address_line_1'] =  $response['getEmployeeDetails']['permanent_address_line_1'].','.$response['getEmployeeDetails']['permanent_address_line_2'];
        }
        //dd($response['getEmployeeDetails']);
        if (!empty($response['getEmployeeOfficeDetails'])) {
            foreach ($response['getEmployeeOfficeDetails']->toArray() as $key => $value) {
                if ($value == null || empty($value) || $value == 'none') {
                    $response['getEmployeeOfficeDetails'][$key] = '';
                }
            }
        }

        if (!empty($response['getFamilyDetails'])) {
            foreach ($response['getFamilyDetails']->toArray() as $key => $value) {
                if ($value == null || empty($value) || $value == 'none') {
                    $response['getFamilyDetails'][$key] = '';
                }
            }
        }

        if (!empty($response['getExperienceDetails'])) {
            foreach ($response['getExperienceDetails']->toArray() as $key => $value) {
                if ($value == null || empty($value) || $value == 'none') {
                    $response['getExperienceDetails'][$key] = '';
                }
            }
        }

        if (!empty($response['getStatutoryDetails'])) {
            foreach ($response['getStatutoryDetails']->toArray() as $key => $value) {
                if ($value == null || empty($value) || $value == 'none') {
                    $response['getStatutoryDetails'][$key] = '';
                }
            }
        }

        if (!empty($response['getEmployeeDetails'])) {
            foreach ($response['getEmergencyContactsDetails']->toArray() as $key => $value) {
                if ($value == null || empty($value) || $value == 'none') {
                    $response['getEmergencyContactsDetails'][$key] = '';
                }
            }
        }

        return $response;
    }
    public function getEmployeePrivateDocumentFile($user_id, $doc_name, $emp_doc_record_id = null)
    {
        // dd($user_code);
        $validator = Validator::make(
            $data = [
                'user_id' => $user_id,
                'doc_name' => $doc_name,
                'emp_doc_record_id' => $emp_doc_record_id,
            ],
            $rules = [
                "user_id" => 'nullable|exists:users,id',
                "doc_name" => 'nullable|exists:vmt_documents,document_name',
                "emp_doc_record_id" => 'nullable|exists:vmt_employee_documents,id',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
            ]

        );
        if ($validator->fails()) {
            return $response = ([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }
        try {

            $user_id = $user_id;

            $user_code = "";

            if (empty($emp_doc_record_id)) {
                $user_data = User::where('id', $user_id)->first();
                $user_code = $user_data->user_code;
                $doc_id = VmtDocuments::where('document_name', $doc_name)->first()->id;

                $doc_filename = VmtEmployeeDocuments::where('user_id', $user_id)->where('doc_id', $doc_id)->first()->doc_url;
            } else {
                //Get the filename directly from the record_id
                $query_emp_doc = VmtEmployeeDocuments::find($emp_doc_record_id);
                $user_code = User::find($query_emp_doc->user_id)->user_code;
                $doc_filename = $query_emp_doc->doc_url;
            }

            //Get the image from PRIVATE disk and send as BASE64
            $response = Storage::disk('private')->get($user_code . "/onboarding_documents/" . $doc_filename);

            if ($response) {
                $response = base64_encode($response);
            } else // If no file found, then send this
            {
                return $response = ([
                    'status' => 'failure',
                    'message' => "Employee document doesnt exist for the given user",
                    "data" => '',
                ]);
            }

            return $response = ([
                "status" => "success",
                "message" => "Employee document fetched successfully",
                "data" => $response,
            ]);
        } catch (\Exception $e) {

            //dd("Error :: uploadDocument() ".$e);

            return $response = ([
                "status" => "failure",
                "message" => "Unable to fetch profile picture",
                "data" => $e->getmessage(),
            ]);
        }
    }

    public function updateEmployeeGeneralInformation($user_id, $birthday, $gender, $marital_status, $blood_group, $phy_challenged)
    {

        try {

            $details = VmtEmployee::where('userid', $user_id)->first();
            $details->dob = $birthday;
            $details->gender = $gender;
            $details->marital_status_id = VmtMaritalStatus::where('name', $marital_status)->first()->id;
            $details->blood_group_id = VmtBloodGroup::where('name', $blood_group)->first()->id;
            $details->physically_challenged = $phy_challenged;
            $details->save();

            return $response = [
                'status' => 'success',
                'message' => "General details updated successfully",
            ];
        } catch (\Exception $e) {
            return $response = [
                'status' => 'failure',
                'message' => 'Error while updateing General Information ',
                'error_message' => $e->getMessage()
            ];
        }
    }

    public function updateEmployeeContactInformation($user_code, $personal_email, $office_email, $mobile_number, $current_address_line_1, $current_address_line_2, $permanent_address_line_1, $permanent_address_line_2)
    {


        try {
            $query_user = user::where('user_code', $user_code)->first();
            $query_user->email = $personal_email;
            $query_user->save();

            $employee_office_details = VmtEmployeeOfficeDetails::where('user_id', $query_user->id)->first();
            $employee_office_details->officical_mail = $office_email;
            // $employee_office_details->official_mobile = $mobile_number;
            $employee_office_details->save();

            $details = VmtEmployee::where('userid', $query_user->id)->first();

            // dd($details);

            if ($details->exists()) {
                $details->mobile_number = $mobile_number;

                $details->current_address_line_1 = $current_address_line_1;
                $details->current_address_line_2 = $current_address_line_2;
                $details->permanent_address_line_1 = $permanent_address_line_1;
                $details->permanent_address_line_2 = $permanent_address_line_2;

                $details->save();
            }

            return $response = [
                'status' => 'success',
                'message' => "Contact details updated successfully"
            ];
        } catch (\Exception $e) {
            return $response = [
                'status' => 'failure',
                'message' => 'Error while updateing Contact Information ',
                'data' => $e->getMessage()
            ];
        }
    }


    public function addFamilyDetails($user_code, $name, $relationship, $dob, $phone_number)
    {
        try {
            // dd($request->all());
            $user_id = user::where('user_code', $user_code)->first()->id;
            $emp_familydetails = new VmtEmployeeFamilyDetails;
            $emp_familydetails->user_id = $user_id;
            $emp_familydetails->name = $name;
            $emp_familydetails->relationship = $relationship;
            $emp_familydetails->dob = $dob;
            $emp_familydetails->phone_number = $phone_number;
            $emp_familydetails->save();

            return  $response = [
                'status' => 'success',
                'message' => "Family details Added successfully"
            ];
        } catch (\Exception $e) {
            return $response = [
                'status' => 'failure',
                'message' => 'Error while Adding Family Information ',
                'error_message' => $e->getMessage()
            ];
        }
    }
    public function UpdateFamilyDetails($record_id, $name, $relationship, $dob, $phone_number)
    {
        try {
            //dd($request->all());
            //$user_id = user::where('user_code', $user_code)->first()->id;
            $emp_familydetails = VmtEmployeeFamilyDetails::where('id', $record_id)->first();
            $emp_familydetails->name = $name;
            $emp_familydetails->relationship = $relationship;
            $emp_familydetails->dob = $dob;
            $emp_familydetails->phone_number = $phone_number;
            $emp_familydetails->save();

            $response = [
                'status' => 'success',
                'message' => 'Family Details Upadated Successfully ',
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => 'Error while updateing Family Information ',
                'error_message' => $e->getMessage()
            ];
        }
        return $response;
    }
    public function deleteEmployeeFamilyDetails($record_id, $user_code)
    {
        try {



            $familyDetails = VmtEmployeeFamilyDetails::where('id', $record_id)->delete();
            return $response = [
                'status' => 'success',
                'message' => "Family details deleted successfully"
            ];
        } catch (\Exception $e) {
            return   $response = [
                'status' => 'failure',
                'message' => 'Error while Deletining Family Information ',
                'error_message' => $e->getMessage()
            ];
        }
    }
    public function updateEmployeeBankDetails($user_id, $bank_id, $bank_ifsc_code, $bank_account_number, $pan_number)
    {

        try {

            $details = VmtEmployee::where('userid', $user_id)->first();
            $details->bank_id = $bank_id;
            $details->bank_ifsc_code = $bank_ifsc_code;
            $details->bank_account_number = $bank_account_number;
            $details->pan_number = $pan_number;
            $details->save();


            return $response = [
                'status' => 'success',
                'message' => 'Bank details updated successfully',
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => 'Error while updateing Bank Details ',
                'error_message' => $e->getMessage()
            ];
        }
    }
    public function addEmployeeExperianceDetails($user_code, $company_name, $location, $job_position, $period_from, $period_to)
    {


        try {
            //  dd($request->all());
            $user_id = user::where('user_code', $user_code)->first()->id;
            $exp = new Experience;
            $exp->user_id = $user_id;
            $exp->company_name = $company_name;
            $exp->location = $location;
            $exp->job_position = $job_position;
            $exp->period_from = $period_from;
            $exp->period_to = $period_to;
            $exp->save();
            $response = [
                'status' => 'success',
                'message' => "Experiance details Added successfully"
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => 'Error while updateing Experiance Details ',
                'error_message' => $e->getMessage()
            ];
        }

        return $response;
    }
    public function updateEmployeeExperianceDetails($user_code, $company_name, $location, $job_position, $period_from, $period_to, $exp_current_table_id)
    {


        try {

            $user_id = user::where('user_code', $user_code)->first()->id;

            $exp = Experience::where('id', $exp_current_table_id)->first();
            $exp->user_id = $user_id;
            $exp->company_name = $company_name;
            $exp->location = $location;
            $exp->job_position = $job_position;
            $exp->period_from = $period_from;
            $exp->period_to = $period_to;
            $exp->save();
            $response = [
                'status' => 'success',
                'message' => "Experiance details updated successfully"
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => 'Error while updateing Experience Information',
                'error_message' => $e->getMessage()
            ];
        }

        return $response;
    }
    public function deleteEmployeeExperianceDetails($exp_current_table_id)
    {


        try {
            $ExperianceDetails = Experience::where('id', $exp_current_table_id)->delete();
            $response = [
                'status' => 'success',
                'message' => "Experiance details deleted successfully"
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => 'Error while deleting Experience Information ',
                'error_message' => $e->getMessage()
            ];
        }


        return $response;
    }
    public function uploadProofDocument($emp_id, $fileObject, $onboard_document_type, $doc_type)
    {
        // dd($fileObject);
        try {
            $emp_code = User::find($emp_id)->user_code;

            if (empty($fileObject))
                return null;


            $onboard_doc_id = VmtDocuments::where('document_name', $onboard_document_type)->first();


            if ($onboard_doc_id->exists()) {
                $onboard_doc_id = $onboard_doc_id->id;
            } else
                return null;

            $employee_documents = VmtTempEmployeeProofDocuments::where('user_id', $emp_id)->where('doc_id', $onboard_doc_id);

            //check if document already uploaded
            if ($employee_documents->exists()) {

                $employee_documents = $employee_documents->first();

                $file_path = '/' . $emp_code . '/onboarding_documents' . '/' . $employee_documents->doc_url;

                //fetch the existing document and delete its file from STORAGE folder
                $file_exists_status = Storage::disk('private')->exists($file_path);
                if ($file_exists_status) {

                    //delete the file
                    Storage::disk('private')->delete($file_path);
                }
            } else {
                $employee_documents = new VmtTempEmployeeProofDocuments;
                $employee_documents->user_id = $emp_id;
                $employee_documents->doc_id = $onboard_doc_id;
            }


            $date = date('d-m-Y_H-i-s');
            $fileName =  str_replace(' ', '', $onboard_document_type) . '_' . $emp_code . '_' . $date . '.' . $fileObject->extension();
            $path = $emp_code . '/onboarding_documents';
            $filePath = $fileObject->storeAs($path, $fileName, 'private');
            $employee_documents->doc_url = $fileName;
            $employee_documents->status = 'Pending';

            if ($doc_type == "document") {
                $employee_documents->doc_type = '1';
            }
            $employee_documents->save();

            return "success";
        } catch (\Exception $e) {
            return  $response = [
                'status' => 'failure',
                'message' => 'Error while updateing employee data ',
                'error_message' => $e->getMessage()
            ];
        }
    }
    public function getEmpProfileProofPrivateDoc($user_id, $doc_name, $emp_doc_record_id = null)
    {
        // dd($user_code);
        $validator = Validator::make(
            $data = [
                'user_id' => $user_id,
                'doc_name' => $doc_name,
                'emp_doc_record_id' => $emp_doc_record_id,
            ],
            $rules = [
                "user_id" => 'nullable|exists:users,id',
                "doc_name" => 'nullable|exists:vmt_documents,document_name',
                "emp_doc_record_id" => 'nullable|exists:vmt_employee_documents,id',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
            ]

        );
        if ($validator->fails()) {
            return $response = ([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try {


            //Get the filename directly from the record_id
            if (empty($emp_doc_record_id)) {
                $user_data = User::where('id', $user_id)->first();
                $user_code = $user_data->user_code;
                $doc_id = VmtDocuments::where('document_name', $doc_name)->first()->id;

                $doc_filename = VmtEmployeeDocuments::where('user_id', $user_id)->where('doc_id', $doc_id)->first()->doc_url;
            } else {

                $query_emp_doc = VmtTempEmployeeProofDocuments::find($emp_doc_record_id);
                $user_code = User::find($query_emp_doc->user_id)->user_code;
                $doc_filename = $query_emp_doc->doc_url;
            }


            //Get the image from PRIVATE disk and send as BASE64
            $response = Storage::disk('private')->get($user_code . "/onboarding_documents/" . $doc_filename);

            if ($response) {
                $response = base64_encode($response);
            } else // If no file found, then send this
            {
                return $response = ([
                    'status' => 'failure',
                    'message' => "Employee proof proof document doesnt exist for the given user"
                ]);
            }

            return $response = ([
                "status" => "success",
                "message" => "Employee document fetched successfully",
                "data" => $response,
            ]);
        } catch (\Exception $e) {

            //dd("Error :: uploadDocument() ".$e);

            return $response = ([
                "status" => "failure",
                "message" => "Unable to fetch profile picture",
                "data" => $e->getmessage(),
            ]);
        }
    }

    public function getEmployeeAllDocumentDetails($user_id)
    {


        //Validate
        $validator = Validator::make(
            $data = [
                'user_id' => $user_id,
            ],
            $rules = [
                "user_id" => 'required|exists:users,id',
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


        try {

            $query_document = VmtDocuments::all();
            $query_doc_id = array();
            foreach ($query_document as $key => $Singledocid) {
                $query_doc_id[] = $Singledocid;
            }

            $query_user_doc_id = array();
            foreach ($query_doc_id as $key => $Singledocid) {
                $query_user_doc_id[] = VmtEmployeeDocuments::where('user_id', $user_id)->where('doc_id', $Singledocid['id'])->first();
            }

            $reponse = array_diff($query_user_doc_id, $query_doc_id);
            $emp_documents = array();
            $i = 0;
            foreach ($reponse as $key => $docid) {

                if ($docid) {
                    $emp_documents[$i] = $docid;
                    $emp_documents[$i]['document_name'] = VmtDocuments::where('id', ($key + 1))->first()->document_name;
                } else {
                    $emp_documents[$i]['document_name'] = VmtDocuments::where('id', ($key + 1))->first()->document_name;
                    $emp_documents[$i]['status'] = null;
                }
                $i++;
            }
            return $response = $emp_documents;
        } catch (\Exception $e) {
            return $response = ([
                'status' => 'failure',
                'message' => 'Error while fetching employee document details',
                'data' => $e
            ]);
        }
    }
    public function updateEmployeeOfficialDetails($user_id, $employee_name, $onboard_document_type, $emp_doc, $department_id, $manager_user_code)
    {


        //Validate
        $validator = Validator::make(
            $data = [
                'user_id' => $user_id,

            ],
            $rules = [
                "user_id" => 'required|exists:users,id',
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


        try {


            $employee_profile_details = [
                'department_id' => 'department_id',
                'manager_user_code' => 'manager_user_code',

            ];

            if (!empty($onboard_document_type) && !empty($emp_doc)) {

                $save_Employee_details = $this->updatetempEmployeeName($user_id, $employee_name, $onboard_document_type, $emp_doc);
            }

            foreach ($data as $data_key => $single_data) {
                if (collect($data)->contains($data_key)) {
                    $Employeeofficialdetails = VmtEmployeeOfficeDetails::where('user_id', $user_id)->first();
                    $Employeeofficialdetails->data_key = $single_data;
                    $Employeeofficialdetails->save();
                }
            }

            return $response = [
                'status' => 'success',
                'message' => "employee details updated successfully",
            ];
        } catch (\Exception $e) {
            return $response = ([
                'status' => 'failure',
                'message' => 'Error while fetching update employee details',
                'data' => $e
            ]);
        }
    }
    public function updatetempEmployeeName($user_id, $Employee_name, $onboard_document_type, $emp_doc)
    {

        $validator = Validator::make(
            $data = [
                'user_id' => $user_id,
                'Employee_name' => $Employee_name,
                'onboard_document_type' => $onboard_document_type,
                'emp_doc'  => $emp_doc,
            ],
            $rules = [
                "user_id" => 'required|exists:users,id',
                'Employee_name' => 'required',
                'onboard_document_type' => 'required|exists:vmt_documents,document_name',
                'emp_doc'  => 'required',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
            ]

        );

        if ($validator->fails()) {
            return [
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ];
        }



        try {

            $employee_details = VmtTempEmpNames::where('user_id', $user_id)->first();

            if (!empty($employee_details)) {

                $details = $employee_details;
            } else {
                $details = new VmtTempEmpNames;
            }
            $details->user_id = $user_id;
            $details->name = $Employee_name;
            $details->save();

            $emp_file = $this->uploadProofDocument($user_id, $emp_doc, $onboard_document_type, null);

           return  $response = [
                'status' => 'success',
                'message' => 'Employee data updated successfully',
                'data' => ''
            ];
        } catch (\Exception $e) {
          return   $response = [
                'status' => 'failure',
                'message' => 'Error while updateing employee data ',
                'error_message' => $e->getMessage()
            ];
        }
    }
    public function getEmployeeDocumentDetails($user_id)
    {

        try {

            $employee_profile_details = [
                'id', 'user_code', 'name', 'gender', 'dob', 'blood_group', 'gaurdian_name', 'gaurdian_type', 'spouse_name', 'father_name', 'aadhar_number', 'aadhar_enrollment_number',
                'aadhar_address', 'pan_number', 'license_number', 'license_issue_date', 'license_expires_on', 'license_address', 'passport_country_code', 'passport_type',
                'passport_number', 'passport_date_of_issue', 'passport_place_of_issue', 'passport_place_of_birth', 'passport_expire_on',
                'voter_id_number', 'voter_id_issued_on', 'voterid_address'
            ];

            $response = array();
            $emp_prof_details = User::leftjoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                ->leftjoin('vmt_employee_documents', 'vmt_employee_documents.user_id', '=', 'users.id')
                ->leftjoin('vmt_documents', 'vmt_documents.id', '=', 'vmt_employee_documents.doc_id')
                ->leftjoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->leftjoin('vmt_employee_family_details', 'vmt_employee_family_details.user_id', '=', 'users.id')
                ->leftjoin('vmt_bloodgroup', 'vmt_bloodgroup.id', '=', 'vmt_employee_details.blood_group_id')
                ->where('users.id', $user_id);


            $aadhar_details = $emp_prof_details->first([
                'users.name as name',
                'vmt_employee_details.gender as gender',
                'vmt_employee_details.dob as dob',
                'vmt_employee_details.aadhar_number as aadhar_number',
                'vmt_employee_details.aadhar_enrollment_number as aadhar_enrollment_number',
                'vmt_employee_details.permanent_address_line_1 as aadhar_address',
                //'vmt_documents.document_name as document_name',
            ]);
            $pan_card_details = $emp_prof_details->first([
                'users.name as name',
                'vmt_employee_details.gender as gender',
                'vmt_employee_details.dob as dob',
                'vmt_employee_family_details.name as father_name',
                'vmt_employee_details.pan_number as pan_number'
            ]);

            $license_details = $emp_prof_details->first([
                'users.name as name',
                'vmt_employee_details.gender as gender',
                'vmt_employee_details.dob as dob',
                'vmt_bloodgroup.name as blood_group',
                'vmt_employee_family_details.name as father_name',
                'vmt_employee_details.dl_no as license_number',
                'vmt_employee_details.dl_issue_date as license_issue_date',
                'vmt_employee_details.dl_expire_on as license_expires_on',
                'vmt_employee_details.dl_emp_address as license_address',
            ]);

            $passport_details = $emp_prof_details->first([
                'users.name as name',
                'vmt_employee_details.gender as gender',
                'vmt_employee_details.dob as dob',
                'vmt_employee_details.passport_country_code as passport_country_code',
                'vmt_employee_details.passport_type as passport_type',
                'vmt_employee_details.passport_number as passport_number',
                'vmt_employee_details.passport_date_of_issue as passport_date_of_issue',
                'vmt_employee_details.passport_place_of_issue as passport_place_of_issue',
                'vmt_employee_details.passport_place_of_birth as passport_place_of_birth',
                'vmt_employee_details.passport_expire_on as passport_expire_on',

            ]);

            $voterId_details = $emp_prof_details->first([
                'users.name as name',
                'vmt_employee_details.gender as gender',
                'vmt_employee_details.dob as dob',
                'vmt_bloodgroup.name as blood_group',
                'vmt_employee_family_details.name as father_name',
                'vmt_employee_details.voter_id_number as voter_id_number',
                'vmt_employee_details.voter_id_issued_on as voter_id_issued_on',
                'vmt_employee_details.voterid_emp_address as voterid_emp_address',

            ]);


            //  $emp_prof_details = $emp_prof_details->clone()->get(['vmt_documents.id']);


            $response['aadhar_card_details'] =  $aadhar_details;
            $response['pan_card_details'] =  $pan_card_details;
            $response['license_details'] =  $license_details;
            $response['passport_details'] =  $passport_details;
            $response['voterId_details'] =  $voterId_details;

            //   return $response;


            //work in process
            $query_document = VmtDocuments::where('id', '!=', '2')->pluck('id');

            $document_name = VmtDocuments::where('id', '!=', '2')->pluck('document_name')->toarray();

            $document_name  = [
                "Aadhar_Card_Front" => $aadhar_details,
                "Pan_Card" => $pan_card_details,
                "Passport" => $passport_details,
                "Voter_ID" => $voterId_details,
                "Driving_License" => $license_details,
                "Education_Certificate" => "",
                "Relieving_Letter" => "",
                "Birth_Certificate" => "",
                "Cheque_leaf/Bank_Passbook" => ""
            ];

            $query_user_doc = VmtEmployeeDocuments::where('user_id', $user_id)->whereIn('doc_id', $query_document)->get();

            $father_name = VmtEmployeeFamilyDetails::where('relationship', 'Father')->first()->name ?? "";

            $reponse = $query_document->diff($query_user_doc);

            $emp_documents = array();
            $i = 0;
            foreach ($reponse as $key => $docid) {

                $emp_temp_doc = VmtTempEmployeeProofDocuments::where('user_id', $user_id)->where('doc_id', $docid)->first();

                $employee_documents = VmtEmployeeDocuments::leftjoin('users', 'vmt_employee_documents.user_id', '=', 'users.id')
                    ->leftjoin('vmt_documents', 'vmt_documents.id', '=', 'vmt_employee_documents.doc_id')
                    ->where('user_id', $user_id)->where('doc_id', $docid)->first();

                if (!empty($employee_documents)) {

                    $doc_name = str_replace(" ", "_", $employee_documents['document_name']);

                    if (in_array($doc_name, array_keys($document_name))) {

                        $emp_documents[$key]['title'] = $doc_name == 'Aadhar_Card_Front' ? 'Aadhar Card' : $doc_name;
                        $emp_documents[$key]['value'] = $document_name[$doc_name];
                        $emp_documents[$key]['doc_status'] = $employee_documents['status'];
                        $emp_documents[$key]['image'] = $this->getEmployeePrivateDocumentFile($user_id, $employee_documents['document_name'])['data'];
                        $emp_documents[$key]['doc_rec_id'] = $employee_documents['vmt_employee_documents.id'];
                        $document_name[$key]['value']['father_name'] = $father_name;
                    }
                } else {

                    $doc_name = VmtDocuments::where('id', $docid)->first()->document_name;
                    $doc_name = str_replace(" ", "_", $doc_name);

                    if (in_array($doc_name, array_keys($document_name))) {

                        if (!empty($document_name[$doc_name])) {

                            $emp_documents[$key]['title'] = $doc_name == 'Aadhar_Card_Front' ? 'Aadhar Card' : $doc_name;
                            $emp_documents[$key]['value'] = $document_name[$doc_name];
                            $emp_documents[$key]['doc_status'] = 'Pending';
                            $emp_documents[$key]['$doc_rec_id'] = $emp_temp_doc ? $emp_temp_doc->id : '';
                            $document_name[$doc_name]['father_name'] = $father_name;
                        } else {

                            $emp_documents[$key]['title'] = $doc_name == 'Aadhar_Card_Front' ? 'Aadhar Card' : $doc_name;
                            $emp_documents[$key]['value'] = '';
                            $emp_documents[$key]['$doc_rec_id'] = $emp_temp_doc ? $emp_temp_doc->id : '';
                            $emp_documents[$key]['doc_status'] = null;
                        }
                    }
                }
                $i++;
            }

            return $response = [
                'status' => 'success',
                'message' => 'data fetch successfully',
                'data' => $emp_documents
            ];
        } catch (\Exception $e) {
            return $response = ([
                'status' => 'failure',
                'message' => 'Error while update employee aadhar details',
                'data' => $e->getMessage() . "   " . $e->getline()
            ]);
        }
    }
    public function updateEmployeeDocumentDetails($data, $user_id, $onboard_document_type)
    {
        try {


            // $employee_profile_details = [
            //     'user_id'=>'user_id',
            //     'name' => 'name',
            //     'gender' => 'gender',
            //     'dob' => 'dob',
            //     'blood_group_id' => 'blood_group_id',
            //     'spouse' => 'spouse',
            //     'father_name' => 'father_name',
            //     'doc_type' => 'doc_type',
            //     'aadhar_number' => 'aadhar_number',
            //     'aadhar_enrollment_number' => 'aadhar_enrollment_number',
            //     'aadhar_address' => 'aadhar_address',
            //     'pan_number' => 'pan_number',
            //     'license_number' => 'license_number',
            //     'license_issue_date' => 'license_issue_date',
            //     'license_expires_on' => 'license_expires_on',
            //     'license_address' => 'license_address',
            //     'passport_country_code' => 'passport_country_code',
            //     'passport_type' => 'passport_type',
            //     'passport_number' => 'passport_number',
            //     'passport_date_of_issue' => 'passport_date_of_issue',
            //     'passport_place_of_issue' => 'passport_place_of_issue',
            //     'passport_place_of_birth' => 'passport_place_of_birth',
            //     'passport_expire_on' => 'passport_expire_on',
            //     'voter_id_issued_on' => 'voter_id_issued_on',
            //     'voterid_emp_address' => 'voterid_emp_address',
            //     'voter_id_number' => 'voter_id_number',
            //     "emp_docs"=> "emp_docs",
            // ];

            if (!empty($data['emp_docs'])) {

                $emp_documents = $data['emp_docs'];

                if (!empty($data)) {
                    $EmployeeProfileTempDetails = new EmployeeProfileTempDetails;
                    $EmployeeProfileTempDetails->name = $data['name'] ?? '';
                    $EmployeeProfileTempDetails->user_id = $data['user_id'];
                    $EmployeeProfileTempDetails->gender = $data['gender'] ?? null;
                    $EmployeeProfileTempDetails->spouse = $data['spouse'] ?? null;
                    $EmployeeProfileTempDetails->doc_type = VmtDocuments::where('document_name', ucwords($data['onboard_document_type']))->first()->id ?? null;
                    $EmployeeProfileTempDetails->dob = $data['dob'] ?? null;
                    $EmployeeProfileTempDetails->blood_group_id = $data['blood_group_id'] ?? null;
                    $EmployeeProfileTempDetails->father_name = $data['father_name'] ?? null;
                    $EmployeeProfileTempDetails->aadhar_number = $data['aadhar_number'] ?? null;
                    $EmployeeProfileTempDetails->aadhar_enrollment_number = $data['aadhar_enrollment_number'] ?? null;
                    $EmployeeProfileTempDetails->aadhar_address = $data['aadhar_address'] ?? null;
                    $EmployeeProfileTempDetails->pan_number = $data['pan_number'] ?? null;
                    $EmployeeProfileTempDetails->license_number = $data['license_number'] ?? null;
                    $EmployeeProfileTempDetails->license_issue_date = $data['license_issue_date'] ?? null;
                    $EmployeeProfileTempDetails->license_expires_on = $data['license_expires_on'] ?? null;
                    $EmployeeProfileTempDetails->license_address = $data['license_address'] ?? null;
                    $EmployeeProfileTempDetails->passport_country_code = $data['passport_country_code'] ?? null;
                    $EmployeeProfileTempDetails->passport_type = $data['passport_type'] ?? null;
                    $EmployeeProfileTempDetails->passport_number = $data['passport_number'] ?? null;
                    $EmployeeProfileTempDetails->passport_date_of_issue = $data['passport_date_of_issue'] ?? null;
                    $EmployeeProfileTempDetails->passport_place_of_issue = $data['passport_place_of_issue'] ?? null;
                    $EmployeeProfileTempDetails->passport_place_of_birth = $data['passport_place_of_birth'] ?? null;
                    $EmployeeProfileTempDetails->passport_expire_on = $data['passport_expire_on'] ?? null;
                    $EmployeeProfileTempDetails->voter_id_issued_on = $data['voter_id_issued_on'] ?? null;
                    $EmployeeProfileTempDetails->voter_id_number = $data['voterid_number'] ?? null;
                    $EmployeeProfileTempDetails->voterid_emp_address = $data['voterid_emp_address'] ?? null;
                    $EmployeeProfileTempDetails->save();
                }
            }

            $save_emp_aadhar_doc = $this->uploadProofDocument($user_id, $emp_documents, $onboard_document_type, $doc_type = "document");

            return $response = [
                'status' => 'success',
                'message' => "employee " . $data['onboard_document_type'] . " details updated successfully",
                'data' => "",
            ];
        } catch (\Exception $e) {
            return $response = ([
                'status' => 'failure',
                'message' => 'Error while update employee aadhar details',
                'data' => $e->getmessage()
            ]);
        }
    }
    public function updateEmplpoyeeName($user_id, $doc_id)
    {
        try {

            $Emp_details = VmtTempEmpNames::where('user_id', $user_id)->get();

            $emp_doc = VmtTempEmployeeProofDocuments::where('user_id', $user_id)->Where('doc_id', $doc_id)->first();

            if (!empty($Emp_details)) {

                $employee_details = User::where('id', $user_id)->first();
                $employee_details->name = $Emp_details->name;
                $employee_details->save();

                if (!empty($emp_doc)) {
                    $employee_doc_data = VmtEmployeeDocuments::where('user_id', $user_id)->Where('doc_id', $emp_doc->doc_id)->first();
                    if ($employee_doc_data) {
                        $employee_documents = $employee_doc_data;
                    } else {
                        $employee_documents = new VmtEmployeeDocuments;
                    }

                    $employee_documents->user_id = $emp_doc->user_id;
                    $employee_documents->doc_id = $emp_doc->doc_id;
                    $employee_documents->doc_url = $emp_doc->doc_url;
                    $employee_documents->status = $emp_doc->status;
                    $employee_documents->save();
                    $emp_doc->delete();
                    $Emp_details->delete();
                }

                $response = [
                    'status' => 'success',
                    'message' => 'Employee Name updated successfully',
                    'data' => ''
                ];
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Employee Name uptodate for this user',
                ];
            }
        } catch (\Exception $e) {
            $response = [
                'status' => 'failure',
                'message' => 'Error while updateing Employee Name ',
                'error_message' => $e->getMessage()
            ];
        }
        return response()->json($response);
    }


    public function uploadDocument($emp_id, $fileObject, $onboard_document_type)
    {

        try {

            if (!empty($fileObject)) {
                $emp_code = User::find($emp_id)->user_code;

                $onboard_doc_id = VmtDocuments::where('document_name', $onboard_document_type);

                if ($onboard_doc_id->exists()) {
                    $onboard_doc_id = $onboard_doc_id->first()->id;
                } else
                    return null;

                $employee_documents = VmtEmployeeDocuments::where('user_id', $emp_id)->where('doc_id', $onboard_doc_id);

                //check if document already uploaded
                if ($employee_documents->exists()) {

                    $employee_documents = $employee_documents->first();

                    $file_path = '/' . $emp_code . '/onboarding_documents' . '/' . $employee_documents->doc_url;

                    //fetch the existing document and delete its file from STORAGE folder
                    $file_exists_status = Storage::disk('private')->exists($file_path);
                    if ($file_exists_status) {

                        //delete the file
                        Storage::disk('private')->delete($file_path);
                    }
                } else {
                    $employee_documents = new VmtEmployeeDocuments;
                    $employee_documents->user_id = $emp_id;
                    $employee_documents->doc_id = $onboard_doc_id;
                }


                $date = date('d-m-Y_H-i-s');
                $fileName =  str_replace(' ', '', $onboard_document_type) . '_' . $emp_code . '_' . $date . '.' . $fileObject->extension();
                $path = $emp_code . '/onboarding_documents';
                $filePath = $fileObject->storeAs($path, $fileName, 'private');
                $employee_documents->doc_url = $fileName;

                $employee_documents_status = VmtEmployeeDocuments::where('user_id', $emp_id)
                    ->where('doc_id', $onboard_doc_id);

                if ($employee_documents_status->exists()) {
                    $employee_documents_status = $employee_documents_status->first()->status;
                    if ($employee_documents_status == 'Approved')
                        $employee_documents->status = $employee_documents_status;
                    else {
                        $employee_documents->status = 'Pending';
                    }
                } else {

                    $employee_documents->status = 'Pending';
                }


                $employee_documents->save();
            }
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'failure',
                'message' => '',
                'data' => "Error while saving record : " . $e->getMessage()
            ]);
        }

        return "success";
    }

    public function replaceEmpTempDataToOrginalDetails($user_id, $doc_id)
    {
        try {

            $employee_doc = EmployeeProfileTempDetails::where('user_id', $user_id);

            $emp_doc = VmtTempEmployeeProofDocuments::where('user_id', $user_id)->Where('doc_id', $doc_id)->first();

            // dd($emp_doc);

            $employee_profile_details = [
                'name' => 'name',
                'gender' => 'gender',
                'dob' => 'dob',
                'blood_group_id' => 'blood_group_id',
                'spouse' => 'relationship',
                'father_name' => 'relationship',
                'aadhar_number' => 'aadhar_number',
                'aadhar_enrollment_number' => 'aadhar_enrollment_number',
                'aadhar_address' => 'permanent_address_line_1',
                'pan_number' => 'pan_number',
                'license_number' => 'dl_no',
                'license_issue_date' => 'dl_issue_date',
                'license_expires_on' => 'dl_expire_on',
                'license_address' => 'dl_emp_address',
                'passport_country_code' => 'passport_country_code',
                'passport_type' => 'passport_type',
                'passport_number' => 'passport_number',
                'passport_date_of_issue' => 'passport_date_of_issue',
                'passport_place_of_issue' => 'passport_place_of_issue',
                'passport_place_of_birth' => 'passport_place_of_birth',
                'passport_expire_on' => 'passport_expire_on',
                'voter_id_issued_on' => 'voter_id_issued_on',
                'voterid_address' => 'voterid_address',
                'voter_id_number' => 'voter_id_number',
            ];


            $employee_doc_details = $employee_doc->first()->toarray();

            // $update_user_personel_data = VmtEmployee::where('userid', $user_id)->first();

            foreach ($employee_doc_details as $data_key => $single_data) {

                if ($data_key == "aadhar_address") {

                    $update_user_personel_data = VmtEmployee::where('userid', $user_id)->first();
                    $update_user_personel_data->permanent_address_line_1 = $single_data;
                    $update_user_personel_data->save();
                }
                if (in_array($data_key, $employee_profile_details)) {

                    if (!empty($single_data) && $single_data != 0  && $single_data != '0000-00-00') {

                        if ($data_key == "name") {

                            $update_name = User::where('id', $user_id)->first();
                            $update_name->name = $single_data;
                            $update_name->save();
                        } else if ($data_key == "spouse") {

                            $update_spouse_data = VmtEmployeeFamilyDetails::where('userid', $user_id)->where('relationship', 'spouse')->first();
                            if (!empty($update_spouse_data)) {
                                $update_spouse_data->relationship = $single_data;
                                $update_spouse_data->save();
                            }
                        } else if ($data_key == "father_name") {

                            $update_father_data = VmtEmployeeFamilyDetails::where('userid', $user_id)->where('relationship', 'father')->first();
                            if (!empty($update_father_data)) {
                                $update_father_data->relationship = $single_data;
                                $update_father_data->save();
                            }
                        } else {

                            $assigned_data  = $employee_profile_details[$data_key];
                            $update_user_personel_data = VmtEmployee::where('userid', $user_id)->first();
                            $update_user_personel_data->$assigned_data = $single_data;
                            $update_user_personel_data->save();
                        }
                    }
                }
            }

            if (!empty($employee_doc)) {

                if (!empty($emp_doc)) {
                    $employee_doc_data = VmtEmployeeDocuments::where('user_id', $user_id)->Where('doc_id', $emp_doc->doc_id)->first();
                    if ($employee_doc_data) {
                        $employee_documents = $employee_doc_data;
                    } else {
                        $employee_documents = new VmtEmployeeDocuments;
                    }

                    $employee_documents->user_id = $emp_doc->user_id;
                    $employee_documents->doc_id = $emp_doc->doc_id;
                    $employee_documents->doc_url = $emp_doc->doc_url;
                    $employee_documents->status = $emp_doc->status;
                    $employee_documents->save();
                    $emp_doc->delete();
                    $employee_doc->first()->delete();
                }

                $response = [
                    'status' => 'success',
                    'message' => 'Employee Name updated successfully',
                    'data' => ''
                ];
            } else {
                $response = [
                    'status' => 'success',
                    'message' => 'Employee Name uptodate for this user',
                ];
            }
        } catch (\Exception $e) {

            $response = [
                'status' => 'failure',
                'message' => 'Error while updateing Employee Name ',
                'data' => '',
                'error_message' => $e->getMessage() . " " . $e->getline()
            ];
        }
        return response()->json($response);
    }

    public function updateEmployeeDesignation($user_code, $designation_name)
    {

        $validator = Validator::make(
            $data = [
                'user_id' => $user_code,
            ],
            $rules = [
                "user_id" => 'required|exists:users,user_code',
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


        try {

            $user_id = User::where('user_code', $user_code)->first()->id;

            $query_EmpOfficeDetails = VmtEmployeeOfficeDetails::where('user_id', $user_id)->first();

            if ($query_EmpOfficeDetails) {
                $query_EmpOfficeDetails->designation = $designation_name;
                $query_EmpOfficeDetails->save();
            } else {
                return $response = [
                    'status' => 'failure',
                    'message' => 'employee office details not found',
                ];
            }

            return $response = [
                'status' => 'success',
                'message' => 'Designation updated successfully',
                'data' => ''
            ];
        } catch (\Exception $e) {

            $response = [
                'status' => 'failure',
                'message' => 'Error while updateing Employee designation',
                'data' => '',
                'error_message' => $e->getMessage() . " " . $e->getline()
            ];
        }
    }
}
