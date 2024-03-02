<?php

namespace App\Services;

use App\Models\VmtReimbursementVehicleType;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\VmtClientMaster;
use App\Models\VmtEmployeeReimbursements;
use App\Models\VmtOrgTimePeriod;

use Illuminate\Support\Facades\DB;

class VmtClientService {


    public function getOrgTimePeriod(){

        $response = VmtOrgTimePeriod::all();

        return [
            "status" => "success",
            "message" => "",
            "data"=>$response,
        ];
    }

    /*
        ABS Client code is used to login into mobile app


    */
    public function getABSClientCode($client_code){

        //Validate
        $validator = Validator::make(
            $data = [
                "client_code" => $client_code,
            ],
            $rules = [
                "client_code" => 'required|exists:vmt_client_master,client_code',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
            ]

        );

        if($validator->fails()){
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }




        try{

            $query_abs_clientcode = VmtClientMaster::where('client_code', $client_code)->first()->abs_client_code;

            return response()->json([
                "status" => "success",
                "message" => "",
                "data" => $query_abs_clientcode,
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                "status" => "failure",
                "message" => "Error while fetching client code",
                "data" => $e->getMessage(),
            ]);
        }

    }

}
