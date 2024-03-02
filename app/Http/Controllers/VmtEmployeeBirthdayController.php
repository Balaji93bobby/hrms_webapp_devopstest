<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VmtEmployee;
use App\Models\User;
use App\Models\VmtEmployeeOfficeDetails;
use Carbon\Carbon;
use App\Mail\BirthdayMail;
use App\Mail\AnniversaryMail;
use \DateTime;
use \Mail;

class VmtEmployeeBirthdayController extends Controller
{
    //


    public function sendBirthdayNotificationtoEmployee(){

        try{

        $isEmailSent =null;
        $birth_date = Carbon::now()->format('m-d');

        $usersWithBirthdays = VmtEmployee::join('users','vmt_employee_details.userid','=','users.id')
                                          ->join('vmt_employee_office_details','vmt_employee_office_details.user_id','=','users.id')
                                          ->whereRaw("DATE_FORMAT(dob, '%m-%d') = '$birth_date'")
                                          ->where('users.active','<>','-1')
                                          ->get();

              $usersWithBirthdays_data=array();

            foreach ($usersWithBirthdays as $key=>$single_user_birtday) {

                $managers_email=$this->getEmployeeManagersCode($single_user_birtday['l1_manager_code']);

             $usersWithBirthdays_data[$key]['userid']=$single_user_birtday['userid'];
             $usersWithBirthdays_data[$key]['user_code']=$single_user_birtday['user_code'];
             $usersWithBirthdays_data[$key]['name']=$single_user_birtday['name'];
             $usersWithBirthdays_data[$key]['dob']=$single_user_birtday['dob'];
             $usersWithBirthdays_data[$key]['email']=$single_user_birtday['email'];
             $usersWithBirthdays_data[$key]['l1_manager_code']=$single_user_birtday['l1_manager_code'];

                $isEmailSent = Mail::to($single_user_birtday['officical_mail'])->cc($managers_email )->send(new BirthdayMail($single_user_birtday['name'],$single_user_birtday['client_id']));

            }

            return $response=([
                'status' => 'success',
                'mail_status' => $isEmailSent ? 'success':'failure',
                'message' => $isEmailSent ? 'Birthday mail send successfully':'error while mail send '." ".$isEmailSent,
                'data' =>$usersWithBirthdays_data,
               ]);

            }catch(\Exception $e){

                return $response=([
                    'status' => 'failure',
                    'mail_status' => 'failure',
                    'message' => 'Error while send Birthday mail',
                    'data' => $e->getmessage(),
                   ]);
            }

    }
    public function sendAniversaryNotificationtoEmployee(){

        try{

        $anniversary_date = Carbon::now()->format('m-d');;

        $users_With_anniversary = VmtEmployee::join('users','vmt_employee_details.userid','=','users.id')
                                          ->join('vmt_employee_office_details','vmt_employee_office_details.user_id','=','users.id')
                                          ->whereRaw("DATE_FORMAT(doj, '%m-%d') = '$anniversary_date'")
                                          ->where('users.active','<>','-1')
                                          ->get();


             $isEmailSent =null;

             $usersWithAnniversary_data =array();
        foreach ($users_With_anniversary as $key=> $single_data) {

             $managers_email=$this->getEmployeeManagersCode($single_data['l1_manager_code']);
             $usersWithAnniversary_data[$key]['userid']=$single_data['userid'];
             $usersWithAnniversary_data[$key]['user_code']=$single_data['user_code'];
             $usersWithAnniversary_data[$key]['name']=$single_data['name'];
             $usersWithAnniversary_data[$key]['dob']=$single_data['dob'];
             $usersWithAnniversary_data[$key]['email']=$single_data['email'];
             $usersWithAnniversary_data[$key]['l1_manager_code']=$single_data['l1_manager_code'];
             $email=empty($single_data['officical_mail'])?$single_data['email']:$single_data['officical_mail'];

            $isEmailSent = Mail::to($email)->cc($managers_email )->send(new AnniversaryMail($single_data['name'],$single_data['client_id']));
           }

           return $response=([
            'status' => 'success',
            'mail_status' => $isEmailSent ? 'success':'failure',
            'message' => $isEmailSent ? 'Anniversary mail send successfully':'error while mail send '." ".$isEmailSent,
            'data' =>$usersWithAnniversary_data,
           ]);

        }catch(\Exception $e){

            return $response=([
                'status' => 'failure',
                'mail_status' => 'failure',
                'message' => 'Error while send Anniversary mail'.$e->getmessage(),
                'data' => $e->getmessage(),
               ]);
        }


    }

    public function getEmployeeManagersCode($l1_manager_code){

        $managers_email = array();

        $l1_manager_data =User::where('user_code',$l1_manager_code)->first();

        if(!empty($l1_manager_data)){

           $l1_manager_mail =User::join('vmt_employee_office_details','vmt_employee_office_details.user_id','=','users.id')
           ->where('users.id','=', $l1_manager_data->id)
           ->first();

           if(!empty($l1_manager_mail->officical_mail)){

            array_push($managers_email, $l1_manager_mail->officical_mail);

           }else if(!empty($l1_manager_mail->email)){

            array_push($managers_email, $l1_manager_mail->email);

           }

        }

        if(!empty($l1_manager_data)){

        $l2_manager_data = VmtEmployeeOfficeDetails::where('user_id',$l1_manager_data->id)->first();

        if(!empty($l2_manager_data)){

           $l2_manager_mail =User::join('vmt_employee_office_details','vmt_employee_office_details.user_id','=','users.id')
                            ->where('users.user_code','=', $l2_manager_data->l1_manager_code)
                            ->first();

           if(!empty($l2_manager_mail->officical_mail)){

            array_push($managers_email, $l2_manager_mail->officical_mail);

           }else if(!empty($l2_manager_mail->email)){
            array_push($managers_email, $l2_manager_mail->email);
           }
        }
    }

        return $managers_email;

    }


}
