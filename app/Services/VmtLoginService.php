<?php

namespace App\Services;

use App\Mail\ForgetPasswordOtpMail;
use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use \DateTime;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\VmtClientMaster;
use Dompdf\Dompdf;
use Dompdf\Options;
use \stdClass;
use App\Models\User;
use App\Models\VmtEmployeeDocuments;
use App\Notifications\ViewNotification;
use Illuminate\Support\Facades\Notification;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Mail\PasswordResetLinkMail;
use App\Models\VerificationCode;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Mailer\Exception\TransportException;

class VmtLoginService
{

    public function sendPasswordResetLink($user_code, $email)
    {


        //Validate
        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
                'email' => $email,
            ],
            $rules = [
                "user_code" => 'nullable|exists:users,user_code',
                "email" => 'nullable|exists:users,email',
            ],
            $messages = [
                'exists' => 'Your :attribute is invalid. Kindly enter the proper credentials',
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }


        //The above validator cant check both nullable and so we do it here manually
        if (empty($email) && empty($user_code)) {
            return response()->json([
                'status' => "failure",
                'message' => 'Please enter your registered email or employee code',
                'data'   => ''
            ]);
        }

        //dd("end : ".$user_code." , ".$email);

        try {

            $query_user = null;

            //fetch the email based on the received email or user_code
            if (!empty($email))
                $query_user = User::where('email', $email)->first();
            else
            if (!empty($user_code))
                $query_user = User::where('user_code', $user_code)->first();
            else {
                //This scenario will never happen since we handle this in above code itself.
            }

            $message = "";
            $mail_status = "";
            $status = "";

            //Generate temporary URL
            $passwordResetLink =  URL::temporarySignedRoute('vmt-signed-passwordresetlink', now()->addMinutes(30), ['uid' => $query_user->id]);

            //Then, send mail to that email
            $VmtClientMaster = VmtClientMaster::first();
            $image_view = url('/') . $VmtClientMaster->client_logo;

            $isSent    = \Mail::to($query_user->email)->send(new PasswordResetLinkMail($query_user->name, $query_user->user_code, $passwordResetLink, $image_view));

            if ($isSent) {
                $status = "success";
                $message = "Instructions to reset your password is sent to your mail.";
            } else {
                $status = "failure";
                $message = "Mail Error : There was one or more failures.";
            }


            $response = [
                'status' => $status,
                'message' => $message,
                'data' => '',
            ];

            return $response;
        } catch (\Exception $e) {
            return [
                'status' => "failure",
                'message' => "Error while processing your request",
                'data' => $e,
            ];
        }
    }

    public function requestOtp($email)
    {
        $validator = Validator::make(
            $data = [
                'email' => $email,
            ],
            $rules = [
                "email" => 'nullable|exists:users,email',
            ],
            $messages = [
                'exists' => 'Your :attribute is invalid. Kindly enter the proper credentials',
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try {
            $user_query = User::where('email', $email)->first();
            $user_id = $user_query->id;
            $verificationCodeQuery = VerificationCode::where('user_id', $user_id);

            if ($verificationCodeQuery->exists()) {
                $expire_at = Carbon::parse($verificationCodeQuery->first()->expire_at);
                if (Carbon::now()->isAfter($expire_at)) {
                    $verificationCodeQuery->delete();
                    $verificationCode = new VerificationCode;
                    $verificationCode->user_id = $user_id;
                    $verificationCode->otp = rand(123456, 999999);
                    $verificationCode->expire_at = Carbon::now()->addMinutes(2);
                    $verificationCode->save();
                } else {
                    return [
                        'status' => "success",
                        'message' => "Wait " . Carbon::now()->diffInMinutes($expire_at) . " Minutes For Request New Code",
                    ];
                }
            } else {
                $verificationCode = new VerificationCode;
                $verificationCode->user_id = $user_id;
                $verificationCode->otp = rand(123456, 999999);
                $verificationCode->expire_at = Carbon::now()->addMinutes(2);
                $verificationCode->save();
            }
            $emp_img = json_decode(newgetEmployeeAvatarOrShortName($user_id), true);
            try {

                $sendForgetPasswordMail = \Mail::to($email)
                    ->send(new ForgetPasswordOtpMail(
                        VerificationCode::where('user_id', $user_id)->first()->otp,
                        $user_query->name,
                        $emp_img
                    ));
                return response()->json([
                    'status' => "success",
                    'message' => "OTP has been sent to your personal email!",
                    'data' => array('user_code' => $user_query->user_code)
                ]);
            } catch (TransportException $e) {
                return response()->json([
                    'status' => 'failure',
                    'message' => 'Error While Sending Mail',
                    'error' => $e->getMessage(),
                    'error_verbose' => $e->getTraceAsString()
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => "failure",
                'message' => "Error while Requsting otp for Forget Password",
                'data' => $e->getMessage(),
                'error_line' => $e->getTraceAsString()
            ]);
        }
    }
    public function verifyOtp($user_code, $otp)
    {
        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
                'otp' => $otp,
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "otp" => 'required',
            ],
            $messages = [
                'exists' => 'Your :attribute is invalid. Kindly enter the proper credentials',
                "required" => "Field :attribute is missing",
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
            $verificationCodeQuery = VerificationCode::where('user_id', $user_id)->where('otp', $otp);
            //dd($verificationCodeQuery->exists());

            if ($verificationCodeQuery->exists())
            {
                if( Carbon::parse($verificationCodeQuery->first()->expire_at)->setTimezone('Asia/Kolkata')->isAfter(Carbon::now()))
                {
                    return response()->json([
                        'status' => "success",
                        'message' => "OTP verified successfully",
                        'data' => array('user_code' => $user_code)
                    ], 200);
                }
                else {
                    return response()->json([
                        'status' => "failure",
                        'message' => "OTP expired",
                    ],400);
                }
            } else {
                return response()->json([
                    'status' => "failure",
                    'message' => "Invalid OTP",
                ],400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'status' => "failure",
                'message' => "Error while Verifying OTP for Forget Password",
                'data' => $e->getMessage(),
                'error_line' => $e->getTraceAsString()
            ],400);
        }
    }

    public function updatePasswordFromOtp($user_code, $password, $otp)
    {
        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
                'password' => $password,
                'otp' => $otp,
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                'password' => 'required',
                'otp' => 'required',
            ],
            $messages = [
                'exists' => 'Your :attribute is invalid. Kindly enter the proper credentials',
                "required" => "Field :attribute is missing",
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try {

           $otp_validity_status = $this->verifyOtp($user_code, $otp);

            //Validate whether the OTP is valid or not
           if($otp_validity_status->getData()->status == 'failure')
           {
               return $otp_validity_status;
           }


            $currentUser = User::where('user_code', $user_code)->first();
            $currentUser->password = Hash::make($password);
            $currentUser->save();

            //Update the existing OTP entry
            $verificationCodeQuery = VerificationCode::where('user_id', $currentUser->id)->where('otp', $otp)->first();
            $verificationCodeQuery->token_used_date = Carbon::now();
            $verificationCodeQuery->save();

            return response()->json([
                'status' => "success",
                'message' => "Password Updated Successfully",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => "failure",
                'message' => "Error while updating Password",
                'data' => $e->getMessage(),
                'error_line' => $e->getTraceAsString()
            ]);
        }
    }

    /*
        Get the user email address by validating their ABS Client code and user code.
    */
    public function validateAndFetchEmployeeEmail($abs_client_code, $user_code){
        //Validate
        $validator = Validator::make(
            $data = [
                'abs_client_code' => $abs_client_code,
                'user_code' => $user_code,
            ],
            $rules = [
                "user_code" => 'required|exists:users,user_code',
                "abs_client_code" => 'required|exists:vmt_client_master,abs_client_code',
            ],
            $messages = [
                'exists' => 'Your :attribute is invalid. Kindly enter the proper credentials',
                'required' => 'Your :attribute is missing. Kindly enter the proper credentials',
            ]

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try{

            $email = User::where('user_code', $user_code)->first()->email;

            return response()->json([
                'status' => "success",
                'message' => "ABS Client code and User code validation was successful",
                'data' => $email,
            ],200);

        }
        catch(\Exception $e){
            return response()->json([
                'status' => "failure",
                'message' => "Error while processing your request",
                'data' => $e,
            ],400);
        }

    }
}
