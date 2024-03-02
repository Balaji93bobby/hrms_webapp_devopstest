<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use \DateTime;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Dompdf\Options;
use \stdClass;
use App\Models\User;
use App\Models\VmtDocuments;
use App\Models\VmtEmployeeDocuments;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class VmtEmployeeDocumentsService
{


    public function getEmployeeAllDocumentDetails($user_code)
    {

        //Validate
        $validator = Validator::make(
            $data = [
                'user_code' => $user_code
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
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

            $query_user_id = User::where('user_code', $user_code)->first()->id;

            $query_document = VmtDocuments::where('is_mandatory', 1)->pluck('id');

            $query_user_doc = VmtEmployeeDocuments::where('user_id', $query_user_id)->whereIn('doc_id', $query_document)->get();

            $reponse = $query_document->diff($query_user_doc);

            $emp_documents = array();
            $i = 0;
            foreach ($reponse as $key => $docid) {

                $employee_documents = VmtEmployeeDocuments::where('user_id', $query_user_id)->where('doc_id', $docid)->first();

                if (!empty($employee_documents)) {

                    $emp_documents[$i] = $employee_documents;
                    $emp_documents[$i]['document_name'] = VmtDocuments::where('id', $docid)->first()->document_name;
                } else {

                    $emp_documents[$i]['document_name'] = VmtDocuments::where('id', $docid)->first()->document_name;
                    $emp_documents[$i]['status'] = null;
                }
                $i++;
            }
            return response()->json([
                'status' => 'success',
                'message' => '',
                'data' => $emp_documents
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Error while fetching employee document details',
                'data' => $e
            ]);
        }
    }

    /*
        Get employee document settings from vmt_documents
        We will set whether a doc is MANDATORY or not, etc


    */
    public function getEmployeeDocumentsSettings()
    {

        try {
            $response = VmtDocuments::all();

            return response()->json([
                "status" => "success",
                "message" => "",
                "data" => $response,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error while fetching from vmt_documents",
                "data" => $e,
            ]);
        }
    }

    public function updateEmployeeDocumentsSettings($data)
    {
        try {
            foreach ($data as $singleRecord) {
                $document = VmtDocuments::where('id', $singleRecord['id'])->first();
                $document->is_onboarding_doc = $singleRecord['is_onboarding_doc'];
                $document->is_mandatory = $singleRecord['is_mandatory'];
                $document->save();
            }


            return response()->json([
                "status" => "success",
                "message" => "Documents settings updated successfully",
                "data" => "",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => "failure",
                "message" => "Error while updating vmt_documents",
                "data" => $e,
            ]);
        }
    }
}
