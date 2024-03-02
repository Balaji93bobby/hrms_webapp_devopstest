<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VmtStaffAttendanceDevice;
use App\Services\VmtAttendanceServiceV2;
use App\Models\User;
use App\Models\VmtClientMaster;
use Carbon\Carbon;

class VmtStaffAttendanceController extends Controller
{
    //

    /*
        Fetch staff attendance From biometric databse
        Storing data in to vmt_staff_attenndance_device table
    */
    public function syncStaffAttendanceFromDeviceDatabase(Request $request, VmtAttendanceServiceV2 $attendance_services,string $can_debug = null){

        $current_client_list = VmtClientMaster::where('client_code','<>','')->get(['client_code','client_name','client_fullname'])->keyBy('client_code')->toArray();
        //dd($current_client_list);
        try{
            $array_result = array();

            foreach($current_client_list as $single_client)
            {
                //check if the current client is valid
                $client_db_details = $this->getClientDBDetails($single_client['client_code']);

                if(!empty($client_db_details))
                {
                  // dd($client_db_details);

                   $array_result[] = $this->pullDataFromAttendanceDB( client_db_connection_name: $client_db_details["client_db_connection_name"], att_client_name : $client_db_details["att_client_name"]);
                }
                else
                {
                    $array_result[] = 'Client DB Details not found for the given Client Code : '.$single_client['client_code'];
                }

             }
             $sync_intermediate_table_with_staffattendance = (new VmtAttendanceControllerV2)->attendanceJob($request,$attendance_services);

            return [
                'status' => 'success',
                'message' => 'Biometric Attendance data import success',
                'data' =>['biometric_response'=> $array_result,
                           'intermediate_response'=>$sync_intermediate_table_with_staffattendance]
            ];
        }
        catch(\Exception $e){
            return [
                "status" => "failure",
                "message" => "Error [ syncStaffAttendanceFromDeviceDatabase() ] : Error while fetching biometric attendance data for client list :: ".json_encode($current_client_list),
                "data" => $array_result,
                "error" =>$e->getMessage().' | Line : '.$e->getLine(),
                "error_verbose" => (!empty($can_debug) && $can_debug  == "1") ? $e->getTrace() : '** Debug Mode is disabled **',

            ];

        }
    }


    private function pullDataFromAttendanceDB($client_db_connection_name, $att_client_name){

        //Fetch the last attendance details from the local db
        $recentDeviceData  = VmtStaffAttendanceDevice::where('att_server',$att_client_name)
                                ->orderBy('date', 'DESC')->first();

        $attendanceData = null;
        $error_message = '';

        //dd($recentDeviceData);
        if($recentDeviceData){
            $attendanceData  = \DB::connection($client_db_connection_name)->table('staff_attenndance')
                                ->where('att_server', $att_client_name)
                                ->where('date', '>', $recentDeviceData->date)
                                ->get();



        }else{
            //If local db data is null, then we need to pull all data from remote att db
            $attendanceData  = \DB::connection($client_db_connection_name)->table('staff_attenndance')
                                ->where('att_server', $att_client_name)
                                ->get();

            //If no data is available in remote db, then we need to inform user to check remote db
            if($attendanceData->count() == 0){
                $error_message = 'No data found in remote attendance database. Kindly verify client biometric database';
            }
        }

        $data_count = 0;

        if(!empty($attendanceData) || $attendanceData->count() == 0){
            foreach ($attendanceData as $key => $value) {
                $this->insertDataFromExternalAttendanceTable($value);
                $data_count++;
            }
        }

        return [
            "Att Client Name" =>$att_client_name ,
            "Start Date" => $recentDeviceData->date ?? "-",
            "Data Count" => $data_count,
            "Error message" => $error_message
        ];

    }


    /*

        Should add the db connection name in database.php before running this.
    */
    private function getClientDBDetails($client_code){

        if(empty($client_code)){
            return null;
        }

        switch($client_code){
            case "DM":
                return [
                  "client_db_connection_name" => "attendanceDB_Dunamis" ,
                  "att_client_name" => "dunamis"
                ];
            case "DMC":
                return [
                  "client_db_connection_name" => "attendanceDB_Dunamis" ,
                  "att_client_name" => "dunamis"
                ];
            case "ABS":
                return [
                  "client_db_connection_name" => "attendanceDB" ,
                  "att_client_name" => "ess"
                ];
            case "BA":
            case "AL":
                return [
                    "client_db_connection_name" => "attendanceDB" ,
                    "att_client_name" => "brandavatar"
                ];
            case "VASA":
            case "LAL":
            case "PSC":
            case "IMA":
            case "UCIPL":
                return [
                    "client_db_connection_name" => "attendanceDB",
                    "att_client_name" => "vasa"
                ];
            case "PLIPL":
                return [
                    "client_db_connection_name" => "attendanceDB" ,
                    "att_client_name" => "protocol"
                ];
            default:
                return null;
        }

    }


    // inserting device data in to vmt_staff_attenndance_device table
    protected function insertDataFromExternalAttendanceTable($data){
        $staffAttendace     = new  VmtStaffAttendanceDevice;
        $staffAttendace->id = $data->id;
        $staffAttendace->att_server = $data->att_server;
        $staffAttendace->location   = $data->location;
        $staffAttendace->table_name = $data->table_name;
        $staffAttendace->device_log_Id = $data->device_log_Id;
        $staffAttendace->device_Id     = $data->device_Id;
        $staffAttendace->user_Id       = $data->user_Id;
        $staffAttendace->direction     = $data->direction;
        $staffAttendace->verification_mode  = $data->verification_mode;
        $staffAttendace->date = $data->date;
        $staffAttendace->timezone  = $data->timezone;
        $staffAttendace->created_on  = $data->created_on;
        $staffAttendace->save();
    }


}
