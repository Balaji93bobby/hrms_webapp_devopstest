<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\VmtClientMaster;
use Dompdf\Dompdf;
use \stdClass;
use App\Models\User;
use App\Models\VmtEmployee;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MobileNotificationController;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtNotifications;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class VmtNotificationsService {

    protected $leave_module;


    public function __construct(){
        $this->leave_module = [
                        "employee_applies_leave" =>
                        [
                            "title" => "Leave Request",
                            "body" => "has applied leave. Kindly check."
                        ],
                        "manager_approves_leave" => [
                            "title" => "Leave Status",
                            "body" => "has approved your leave request. Kindly check."
                        ],
                        "manager_rejects_leave" => [
                            "title" => "Leave Status",
                            "body" => "has rejected your leave request. Kindly check."
                        ],
                        "manager_revokes_leave" => [
                            "title" => "Leave Status",
                            "body" => "has revokes his/her leave approval. Kindly check your updated leave status."
                        ],

        ];

        $this->attendance_regularization = [
                        "employee_applies_lc" =>
                        [
                            "title" => "Attendance Regularization Request",
                            "body" => "has applied LC attendance regularization. Kindly check."
                        ],
                        "employee_applies_eg" => [
                            "title" => "Attendance Regularization Request",
                            "body" => "has applied EG attendance regularization. Kindly check."
                        ],
                        "employee_applies_mip" => [
                            "title" => "Attendance Regularization Request",
                            "body" => "has applied MIP attendance regularization. Kindly check."
                        ],
                        "employee_applies_mop" => [
                            "title" => "Attendance Regularization Request",
                            "body" => "has applied MOP attendance regularization. Kindly check."
                        ],
                        "manager_approves_attendance_reg" => [
                            "title" => "Attendance Regularization Approved",
                            "body" => "has approved your attendance regularization. Kindly check."
                        ],
                        "manager_rejects_attendance_reg" => [
                            "title" => "Attendance Regularization Rejected",
                            "body" => "has rejected your attendance regularization. Kindly check."
                        ],

        ];


    }

    public function getNotifications($user_code){
        //Validate
        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
            ],
            $rules = [
                'user_code' => 'required|exists:users,user_code',
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

            //Get the user record and update avatar column
            $query_notifications = User::with('array_notifications')
                               ->where('users.user_code',$user_code)
                               ->first(['users.id','users.name', 'users.user_code']);

            //Add recipient name
            foreach($query_notifications['array_notifications'] as $singleNotification){

                $singleNotification["recipient_name"] = User::find($singleNotification["recipient_user_id"])->name;
            }

            return response()->json([
                "status" => "success",
                "message" => "",
                "data" => $query_notifications,
            ]);

        }
        catch(\Exception $e){

            return response()->json([
                "status" => "failure",
                "message" => "Unable to fetch notifications",
                "data" => $e,
            ]);

        }
    }

    public function updateNotificationReadStatus($recipient_user_code, $record_id, $read_status){

        //Validate
        $validator = Validator::make(
            $data = [
                'recipient_user_code' => $recipient_user_code,
                'record_id' => $record_id,
                'read_status' => $read_status
            ],
            $rules = [
                'recipient_user_code' => 'required|exists:users,user_code',
                'record_id' => 'required|exists:vmt_notifications,id',
                'read_status' => 'required',
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
            $query_user = User::where('user_code',$recipient_user_code)->first();

            //Check if the notification id belongs to this user
            $query_record = VmtNotifications::where('id',$record_id)
                            ->where('recipient_user_id',$query_user->id)->first();

            if(empty($query_record))
            {

                return response()->json([
                    'status' => 'failure',
                    'message' => "Given record id not related to the given user"
                ]);

            }

           // $query_notif_record = VmtNotifications::find('id',$record_id);
            //$query_notif_record->is_read = $read_status;

            //Update the read status
            $query_record->is_read = $read_status;
            $query_record->save();

            return response()->json([
                "status" => "success",
                "message" => "Notification status updated successfully",
                "data" => '',
            ]);

        }
        catch(\Exception $e){

            return response()->json([
                "status" => "failure",
                "message" => "Unable to update notification status",
                "data" => $e,
            ]);

        }
    }


    /*
        Sends an FCM notification

    */
    public function sendLeaveApplied_FCMNotification($manager_user_code, $notif_user_id,$leave_module_type,$notifications_users_id =null)
    {

        //Validate
        $validator = Validator::make(
            $data = [
                'manager_user_code' => $manager_user_code,
            ],
            $rules = [
                'manager_user_code' => 'required|exists:users,user_code',
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
            //Get manager FCM Token

            //    echo json_encode($leave_module["employee_applies_leave"]["title"]);

            $notif_title = $this->leave_module[$leave_module_type]["title"];
            $notif_body = $this->leave_module[$leave_module_type]["body"];
            $employee_data= User::where('user_code', $notif_user_id)->first();
            $manager_data= User::where('user_code', $manager_user_code)->first();



                //Send Firebase notifications
          if($leave_module_type =='employee_applies_leave'){

                  $notify_users_fcm_token=array();
             if(!empty($notifications_users_id)){

            foreach ($notifications_users_id as $single_user_id) {

                $notify_users_data= User::where('id', $single_user_id)->first();

                    if( !empty($notify_users_data)){

                        $notify_users_fcm_token[]=$notify_users_data->fcm_token;
                    }

            }
        }
           $notify_users_fcm_token[]=$manager_data->fcm_token;


            $notif_body=$employee_data->name.' '.$notif_body;

                    $response =(new MobileNotificationController)->sendMobNotification($notif_title,$notif_body,$notify_users_fcm_token);

            $savenotification =$this->saveNotification($employee_data->user_code, $notif_title, $notif_body, $redirect_to_module ='Leave Module', $manager_data->user_code, $is_read='0');

                   return $response;

          }
          else if($leave_module_type =='manager_approves_leave' || $leave_module_type =='manager_revokes_leave' ||$leave_module_type =='manager_rejects_leave')
           {
            $notif_body=$manager_data->name.' '.$notif_body;

                 $response =(new MobileNotificationController)->sendMobNotification($notif_title,$notif_body,$employee_data->fcm_token);

            $savenotification =$this->saveNotification($employee_data->user_code, $notif_title, $notif_body, $redirect_to_module ='Leave Module', $manager_data->user_code, $is_read='0');

                  return $response;
          }

        }
        catch(\Exception $e){
            return response()->json([
                "status" => "failure",
                "message" => "Unable to send FCM notification",
                "data" => $e,
            ]);
        }


    }
    public function send_attendance_regularization_FCMNotification($manager_user_code, $notif_user_id,$attendance_regularization_type)
    {

        //Validate
        $validator = Validator::make(
            $data = [
                'manager_user_code' => $manager_user_code,
            ],
            $rules = [
                'manager_user_code' => 'required|exists:users,user_code',
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
            //Get manager FCM Token

            //    echo json_encode($leave_module["employee_applies_leave"]["title"]);

            $notif_title = $this->attendance_regularization[$attendance_regularization_type]["title"];
            $notif_body = $this->attendance_regularization[$attendance_regularization_type]["body"];
            $employee_data= User::where('id', $notif_user_id)->first();
            $manager_data= User::where('user_code', $manager_user_code)->first();



                //Send Firebase notifications
          if($attendance_regularization_type =='employee_applies_lc' ||$attendance_regularization_type =='employee_applies_eg'||$attendance_regularization_type =='employee_applies_mop'||$attendance_regularization_type =='employee_applies_mip'){

            //       $notify_users_fcm_token=array();
            //  if(!empty($notifications_users_id)){

            // foreach ($notifications_users_id as $single_user_id) {

            //     $notify_users_data= User::where('id', $single_user_id)->first();

            //         if( !empty($notify_users_data)){

            //             $notify_users_fcm_token[]=$notify_users_data->fcm_token;
            //         }

           //  }
       // }
           $notify_users_fcm_token=$manager_data->fcm_token;


            $notif_body=$employee_data->name.' '.$notif_body;

                    $response =(new MobileNotificationController)->sendMobNotification($notif_title,$notif_body,$notify_users_fcm_token);

            $savenotification =$this->saveNotification($employee_data->user_code, $notif_title, $notif_body, $redirect_to_module ='attendance_regularization', $manager_data->user_code, $is_read='0');

                   return $response;

          }
          else if($attendance_regularization_type =='manager_approves_attendance_reg' || $attendance_regularization_type =='manager_rejects_attendance_reg')
           {
            $notif_body=$manager_data->name.' '.$notif_body;


                 $response =(new MobileNotificationController)->sendMobNotification($notif_title,$notif_body,$employee_data->fcm_token);

            $savenotification =$this->saveNotification($employee_data->user_code, $notif_title, $notif_body, $redirect_to_module ='attendance_regularization', $manager_data->user_code, $is_read='0');

                  return $response;
          }

        }
        catch(\Exception $e){
            return response()->json([
                "status" => "failure",
                "message" => "Unable to send FCM notification",
                "data" => $e,
            ]);
        }


    }

    public function saveNotification($user_code, $notification_title, $notification_body, $redirect_to_module, $recipient_user_code, $is_read){
        //Validate
        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
                'notification_title' => $notification_title,
                'notification_body' => $notification_body,
                'redirect_to_module' => $redirect_to_module,
                'recipient_user_code' => $recipient_user_code,
                'is_read' => $is_read,
            ],
            $rules = [
                'user_code' => 'required|exists:users,user_code',
                'notification_title' => 'required',
                'notification_body' => 'required',
                'redirect_to_module' => 'required',
                'recipient_user_code' => 'required',
                'is_read' => 'required',
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

            //Get the user record and update avatar column
            $query_notifications = new VmtNotifications;
            $query_notifications->user_id = User::where('user_code', $user_code)->first()->id;

            $query_notifications->notification_title = $notification_title;
            $query_notifications->notification_body = $notification_body;
            $query_notifications->redirect_to_module = $redirect_to_module;

            $query_notifications->recipient_user_id = User::where('user_code', $recipient_user_code)->first()->id;

            $query_notifications->save();

            return response()->json([
                "status" => "success",
                "message" => "Notification saved successfully",
                "data" => '',
            ]);

        }
        catch(\Exception $e){

            return response()->json([
                "status" => "failure",
                "message" => "Unable to save notifications",
                "data" => $e,
            ]);
        }
    }
}
