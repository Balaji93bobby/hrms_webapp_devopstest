<?php

namespace App\Services;

use App\Models\VmtReimbursementVehicleType;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\VmtEmployeeReimbursements;
use App\Models\VmtClientMaster;
use App\Models\VmtReimbursements;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VmtReimbursementsService {
    protected $instance;

    /**
     * Constructs a new cart object.
     *
     * @param Illuminate\Session\SessionManager $session
     */
    public function __construct(SessionManager $session)
    {
        //$query_LocalConveyance = VmtLocalConveyanceVehicles::all();
    }

    private function getLocalConveyanceCost($vehicle_type){

        switch ($vehicle_type) {
            case "Bike":
                return $this->kmsCost_2_wheeler;
            case "Car":
                return $this->kmsCost_4_wheeler;
            case "Public Transport":
                return $this->kmsCost_misc;
            default:
                return null;
        }
    }

    public function getModeOfTransports(){
        $query_mode_of_transports = VmtReimbursementVehicleType::all(['id','vehicle_type','cost_per_km']);
        $response = array();

        foreach($query_mode_of_transports as $singleRecord)
        {
            array_push($response, [
                "label" => $singleRecord->vehicle_type,
                "value" => $singleRecord->vehicle_type,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message'=> 'Fetched Mode of transport types',
            'data'=> $response
        ]);
    }

    public function getReimbursementClaimTypes()
    {
        try{

            $reimbursement_claim_types = VmtReimbursements::all(['id','reimbursement_type']);
            $response = array();

            foreach($reimbursement_claim_types as $singleRecord)
            {
                array_push($response, [
                    "label" => $singleRecord->reimbursement_type,
                    "value" => $singleRecord->reimbursement_type,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message'=> 'Fetched Reimbursement claim types',
                'data'=> $response
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 'failure',
                'message'=> 'Error while getting Reimbursement Claim Types',
                'data'=> $e->getMessage()
            ]);
        }
    }

    public function saveReimbursementData_Claims($user_code, $date, $reimbursement_type, $claim_amount, $reimbursement_remarks, $file_upload, $entry_mode){

        $validator = Validator::make(
            $data = [
                    'user_code' => $user_code,
                    'date' => $date,
                    'reimbursement_type' => $reimbursement_type,
                    'claim_amount' => $claim_amount,
                    'reimbursement_remarks'=> $reimbursement_remarks,
                    'file_upload'=> $file_upload,
                    'entry_mode'=> $entry_mode,
                ],
                $rules = [
                    'user_code' => 'required|exists:users,user_code',
                    'date' => 'required',
                    'reimbursement_type' => 'required|exists:vmt_reimbursements,reimbursement_type',
                    'claim_amount' => 'required',
                    'reimbursement_remarks'=> 'required',
                    'file_upload'=> 'required',
                    'entry_mode'=> 'required',
                ],
                $messages = [
                    "required" => "Field :attribute is missing",
                    "exists" => "Field :attribute is invalid",
                ]
            );


            if($validator->fails()){
                return response()->json([
                        'status' => 'failure',
                        'message' => $validator->errors()->all()
                ]);
            }

            try{


                //check if reimbursements already applied for the given date by the user..
                $query_reimbursements_exists = VmtEmployeeReimbursements::where('user_id', User::where('user_code', $user_code)->first()->id)
                                                ->where('date', $date);


                if($query_reimbursements_exists->exists())
                {
                    return response()->json([
                        "status" => "failure",
                        "message" => "Reimbursement Claims already applied for the given date",
                        "data"=> ""
                    ]);
                }

                //Save the reimbursement data
                $emp_reimbursement_data = new VmtEmployeeReimbursements;
                $emp_reimbursement_data->date = $date;
                $emp_reimbursement_data->reimbursement_type_id = VmtReimbursements::where('reimbursement_type',$reimbursement_type)->first()->id;
                $emp_reimbursement_data->user_id = User::where('user_code',$user_code)->first()->id;
                $emp_reimbursement_data->status = "Pending";
                $emp_reimbursement_data->entry_mode = empty($entry_mode) ? "" : $entry_mode;
                $emp_reimbursement_data->user_comments = $reimbursement_remarks ?? "";
                $emp_reimbursement_data->total_expenses  = $claim_amount;

                //Convert the BASE64 file to disk file and save the path in DB
                    //$claims_doc_file_path = base64_decode($file_upload);

                    $base64_data = base64_decode( explode('base64,',$file_upload)[1] );
                    $extension = explode('/', mime_content_type($file_upload))[1];
                   // dd("File Extension : ".$extension);
                    //dd("File Data : ".$base64_data);

                    $date = date('d-m-Y_H-i-s');
                    $fileName =  'ClaimsDoc_'. $user_code .'__'. $date . '.' . $extension;

                    $path = $user_code . '/reimbursement_documents';

                    if(Storage::disk('private')->put($path."/".$fileName, $base64_data))
                    {
                        //File saved successfully
                        $emp_reimbursement_data->doc_path = $path."/".$fileName;

                    }
                    else
                    {

                        return response()->json([
                            'status' => 'failure',
                            'message'=> 'Error while saving the document file. Please check the uploaded file.',
                            'data'=> ''
                        ]);
                    }



                $emp_reimbursement_data->save();

                return response()->json([
                    'status' => 'success',
                    'message'=> 'Reimbursement Claims details saved successfully',
                    'data'=> ''
                ]);
            }
            catch(\Exception $e){
                return response()->json([
                    'status' => 'failure',
                    'message'=> 'Failed to save Reimbursement Claims data !',
                    'data'=> $e->getMessage()
                ]);
            }

    }

    public function saveReimbursementData_LocalConveyance($user_code, $date, $reimbursement_type, $entry_mode, $vehicle_type, $from, $to, $distance_travelled, $user_comments)
    {

        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
                'date' => $date,
                'reimbursement_type' => $reimbursement_type,
                'vehicle_type' => $vehicle_type,
                'from' => $from,
                'to' => $to,
                'distance_travelled' => $distance_travelled,
                'user_comments' => $user_comments,
                'entry_mode' => $entry_mode,
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "date" => "required",
                "reimbursement_type" => 'required|exists:vmt_reimbursements,reimbursement_type',
                "vehicle_type" => "required|exists:vmt_reimbursement_vehicle_types,vehicle_type",
                "from" => "required",
                "to" => "required",
                "distance_travelled" => "required",
                "user_comments" => "nullable",
                "entry_mode" => "nullable", //make this mandatory once the flutter side also updated
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid"
            ]
        );

        if($validator->fails()){
            return response()->json([
                    'status' => 'failure',
                    'message' => $validator->errors()->all()
            ]);
        }

        try{


            //check if reimbursements already applied for the given date by the user..
            $query_reimbursements_exists = VmtEmployeeReimbursements::where('user_id', User::where('user_code', $user_code)->first()->id)
                                            ->where('date', $date);


            if($query_reimbursements_exists->exists())
            {
                return response()->json([
                    "status" => "failure",
                    "message" => "Reimbursement data already applied for the given date",
                    "data"=> ""
                ]);
            }



            $query_reimbursements_vehicle_types = VmtReimbursementVehicleType::where('vehicle_type', $vehicle_type)->first();

            //Save the reimbursement data
            $emp_reimbursement_data = new VmtEmployeeReimbursements;
            $emp_reimbursement_data->date = $date;
            $emp_reimbursement_data->reimbursement_type_id = VmtReimbursements::where('reimbursement_type',$reimbursement_type)->first()->id;
            $emp_reimbursement_data->user_id = User::where('user_code',$user_code)->first()->id;
            $emp_reimbursement_data->status = "Pending";
            $emp_reimbursement_data->entry_mode = empty($entry_mode) ? "" : $entry_mode;

            //reimbursement details
            $emp_reimbursement_data->from = $from;
            $emp_reimbursement_data->to = $to;
            $emp_reimbursement_data->vehicle_type_id = $query_reimbursements_vehicle_types->id;
            $emp_reimbursement_data->distance_travelled = $distance_travelled;
            $emp_reimbursement_data->user_comments = $user_comments ?? "";

            $emp_reimbursement_data->total_expenses  = $distance_travelled *  $query_reimbursements_vehicle_types->cost_per_km;

            $emp_reimbursement_data->save();

            return response()->json([
                'status' => 'success',
                'message'=> 'Reimbursement details saved',
                'data'=> ''
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 'failure',
                'message'=> 'Failed to save reimbursement data !',
                'data'=> $e->getMessage()
            ]);
        }
    }

    public function getReimbursementVehicleTypes(){
        $query_reimbursement_vehicle_types =  VmtReimbursementVehicleType::all(['id','vehicle_type','cost_per_km']);

        //convert 'cost_per_km' to non-string value
       // dd($query_reimbursement_vehicle_types);
        foreach($query_reimbursement_vehicle_types as $singleReimbursementVehicleType)
        {
            $singleReimbursementVehicleType['cost_per_km'] = intval($singleReimbursementVehicleType['cost_per_km']);
        }

        return $query_reimbursement_vehicle_types;
    }

    public function getReimbursementTypes(){
        return VmtReimbursements::all(['id','reimbursement_type']);
    }

    function fetchAllReimbursementsAsGroups($year, $month, $status ,$selected_reimbursement_type){


        $client_id =null;
        if(!empty(session('client_id'))){

                if(session('client_id') == 1){

                $client_id =VmtClientMaster::pluck('id');
                }else{
                    $client_id =[session('client_id')];
                }

        }else{

            $client_id =[auth()->user()->client_id];
        }
        $json_response = array();

        //Fetch how many unique users for the given filters
        //SELECT distinct user_id FROM `vmt_employee_reimbursements` where MONTH(date) = '3' AND YEAR(date) = '2023';
        $array_unique_users = VmtEmployeeReimbursements::leftJoin('users','users.id','=','vmt_employee_reimbursements.user_id')
                                ->whereYear('vmt_employee_reimbursements.date',$year)
                                ->whereMonth('vmt_employee_reimbursements.date',$month)
                                ->whereIn('users.client_id',$client_id)
                                ->groupBy('user_code')
                                ->select('vmt_employee_reimbursements.user_id as user_id','users.name as employee_name',
                                'users.user_code as user_code',DB::raw('sum(distance_travelled) as total_distance_travelled'),
                                DB::raw('sum(total_expenses) as total_total_expenses'));

        if($status!=null){
            $array_unique_users=$array_unique_users->where('vmt_employee_reimbursements.status', $status);
        }

        $array_unique_users=$array_unique_users->get();

        foreach($array_unique_users as $single_user){

            //dd($single_user->user_id);
            $single_user_data["employee_name"] = $single_user->employee_name;
            $single_user_data["user_code"] = $single_user->user_code;
            $single_user_data["user_id"] = $single_user->user_id;
            $single_user_data["total_distance_travelled"]=$single_user->total_distance_travelled;
            $single_user_data["total_expenses"]=$single_user->total_total_expenses;


            //Get all the reimbursement data for the given user_id
            $reimbursement_data = VmtEmployeeReimbursements::where('user_id',$single_user->user_id)
                                ->join('vmt_reimbursement_vehicle_types','vmt_reimbursement_vehicle_types.id','=','vmt_employee_reimbursements.vehicle_type_id')
                                ->join('vmt_reimbursements','vmt_reimbursements.id','=','vmt_employee_reimbursements.reimbursement_type_id')
                                ->whereYear('vmt_employee_reimbursements.date',$year)
                                ->whereMonth('vmt_employee_reimbursements.date',$month)
                                ->select('vmt_employee_reimbursements.id','vmt_employee_reimbursements.reimbursement_type_id','vmt_reimbursements.reimbursement_type','vmt_employee_reimbursements.date',
                                'vmt_employee_reimbursements.from','vmt_employee_reimbursements.to','user_comments','vmt_reimbursement_vehicle_types.vehicle_type','distance_travelled','total_expenses','status');

            //If reimbursement type filter is given, then filter the query data
            if(!empty($selected_reimbursement_type))
            {
                dd('ERROR : Reimbursement type filtering is not implemented');
                $reimbursement_data = $reimbursement_data->where('vmt_employee_reimbursements.reimbursement_type_id',$selected_reimbursement_type);
            }


            if($status!=null){
                $reimbursement_data = $reimbursement_data->where('vmt_employee_reimbursements.status', $status);
            }

            $reimbursement_data = $reimbursement_data->get();

           foreach($reimbursement_data as $singledata){
                if($singledata->status=='Pending'){
                    $single_user_data["has_pending_reimbursements"] = "true";
                    break;
                }else{
                    $single_user_data["has_pending_reimbursements"] = "false";
                }
                 //dd();
           }
            $single_user_data["overall_expenses"] = "0";    //TODO : Need to calculate the overall expenses
              //TODO : Need to find if any pending reimbursement there for the given user.

            //dd($reimbursement_data->toArray());
            $single_user_data["reimbursement_data"] = $reimbursement_data->toArray();

           // dd($single_user_data);

            array_push($json_response, $single_user_data);

        }


        return $json_response;

    }

    public function processReimbursementBulkApprovals($data){
        $reimbursement_data = $data['reimbursement_id']["reimbursement_data"];
      //  dd( $reimbursement_data);
             for($i=0;$i<count($reimbursement_data);$i++){
                if($reimbursement_data[$i]['status']=='Pending'){
                    VmtEmployeeReimbursements::where('id',$reimbursement_data[$i]['id'])
                                            ->update([
                                                'status' => $data['status']
                                            ]);
                }

             }


    }

    public function fetchEmployeeReimbursement($user_id,$year,$month){

        $employee_reimbursement_data_query = VmtEmployeeReimbursements::leftjoin('vmt_reimbursements','vmt_reimbursements.id','=','vmt_employee_reimbursements.reimbursement_type_id')
                                                                      ->leftjoin('vmt_reimbursement_vehicle_types','vmt_reimbursement_vehicle_types.id','=','vmt_employee_reimbursements.vehicle_type_id')
                                                                      ->where('user_id',$user_id)
                                                                      ->whereYear('date',$year)
                                                                      ->whereMonth('date',$month)
                                                                      ->get(['date','vmt_reimbursements.reimbursement_type','from','to','vmt_reimbursement_vehicle_types.vehicle_type','vmt_reimbursement_vehicle_types.cost_per_km',
                                                                       'distance_travelled','total_expenses','user_comments','entry_mode']);

            return $employee_reimbursement_data_query;
    }

    public function isReimbursementAppliedOrNot($user_code,$date){
        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
                'date' => $date,
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "date" => 'required',
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
               $query_user =User::where('user_code',$user_code)->first();

                $employee_reimbursement_applied_data_query = VmtEmployeeReimbursements::where('user_id',$query_user->id)
                                                                      ->where('date',$date)->exists();

                if($employee_reimbursement_applied_data_query){
                    $response = 1;
                    $message = "Reimbursement already applied for the given date";
                }else{
                    $response = 0;
                    $message = "Reimbursement not applied for the given date";

                }

                return response()->json([
                    'status' => 'success',
                    'message' => $message,
                    'data' =>$response
                ]);

        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 'failure',
                'message' => "Error while getting isReimbursementAppliedOrNot data ",
                'data' => $e->getmessage()
            ]);
        }


    }
}
