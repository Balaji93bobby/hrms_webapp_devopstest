<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Kutia\Larafirebase\Messages\FirebaseMessage;


class MobileNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // public function index()
    // {
    //     return view('webNotification');
    // }

    // public function saveToken(Request $request)
    // {
    //     $savefcmToken=User::where('id',auth()->user()->id)->first();
    //     $savefcmToken->fcm_token =$request->token;
    //     $savefcmToken->save();
    //     return response()->json(['Token successfully stored.']);
    // }



    public function sendMobNotification($title,$body,$fcm_token)

    {

try{
       // $firebaseToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();
        $SERVER_API_KEY = 'AAAAkEKAYyM:APA91bG-5Vq5zchwAdUL4wb0NU2AlmL8LwNOieh0BBDfC_NpK9WMGfpDfuTyOC_OgvcrHiJfnIob_cDfuL8SZBBoikk7tfbtwx3Kaz3cMr49yZZM4nhQYz9QTjIDjST-GCCu6AeYZTt_';

         if($title  <> 'Leave Request'){
                $user_fcm_token =array($fcm_token);
                $data = [
                    "registration_ids" => $user_fcm_token,
                    "notification" => [
                        "title" => $title,
                        "body" => $body,
                    ]
                ];
         }else{
                $data = [
                    "registration_ids" => $fcm_token,
                    "notification" => [
                        "title" => $title,
                        "body" => $body,
                    ]
                ];
         }
       $dataString = json_encode($data);
       $headers = [
           'Authorization: key=' . $SERVER_API_KEY,
           'Content-Type: application/json',
       ];

       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
       $response = curl_exec($ch);

        return response()->json($response);
    }
    catch(\Exception $e){
        return response()->json([
            "status" => "failure",
            "message" => "Unable to send FCM notification",
            "data" => $e,
        ]);
    }
    }


}
