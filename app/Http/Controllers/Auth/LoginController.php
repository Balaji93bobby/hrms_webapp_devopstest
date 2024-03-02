<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth as auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\VmtClientMaster;
use App\Models\User;

use Illuminate\Support\Facades\Cache;
use App\Mail\PasswordResetLinkMail;
use Illuminate\Support\Facades\URL;
use App\Services\VmtLoginService;

use App\Http\Controllers\VmtStaffAttendanceController;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        $Clientinfo = VmtClientMaster::first();
        $clientList = VmtClientMaster::all(['id','client_name']);
        //dd($Clientinfo);
        $cacheStatus = "";

        // $cookies = \Cookie::get();

        // foreach($cookies as $key => $value)
        // {
        //    // dd($key);
        //     \Cookie::queue(\Cookie::forget($key));
        // }

        if(Cache::flush())
            $cacheStatus = "Cache cleared";
        else
            $cacheStatus = "Cache not cleared";


        return view('auth.login', compact('Clientinfo','clientList','cacheStatus'));
    }

    public function showForgetPasswordPage(Request $request){
        $Clientinfo = VmtClientMaster::first();

        return view('forget_password',compact('Clientinfo'));
    }

    public function login(Request $request)
    {

        $request->session()->invalidate();
        $request->session()->regenerateToken();


        $request->validate([
            'user_code' => 'required',
            'password' => 'required',
        ]);

        // Remember token set to false
        $save_credentials = false;
        $user = User::where('user_code', $request->user_code)->where('can_login', 1)->first();

        if($user)
        {
            $isDefaultPasswordUpdated = $user->is_default_password_updated;

            //If client_code selected
            // if(isset($request->client_code))
            // {
            //     if(str_contains( $user->user_code , $request->client_code) || str_contains( $user->user_code , 'EMP'))
            //     {
            //         $credentials = $request->only('user_code', 'password');
            //         if (Hash::check($request->password, $user->password)) {
            //         // if (Auth::attempt($credentials)) {
            //             // Auth::login($user, $save_credentials);
            //             if (auth::attempt(['user_code' => $request->user_code, 'password' => $request->password], $save_credentials)) {

            //                 if($isDefaultPasswordUpdated == '1')
            //                 {

            //                     // Sync Staff attendance data from device
            //                   //  $this->syncStaffAttendance();

            //                     //If User has already updated password, so redirect to dashboard page
            //                     return redirect(route('index'));
            //                  }
            //                  else
            //                  {
            //                     //If User has to update password, then redirect to reset password page
            //                     return redirect(route('vmt-resetpassword-page'));

            //                  }

            //             }
            //         }
            //         else
            //         {
            //             $errors = ['Invalid credentials provided'];
            //             return redirect()->back()->withErrors($errors);
            //         }

            //     }
            //     else
            //     {
            //         //Invalid client-code selected
            //         $errors = ['Employee is not part of selected Client'];
            //         return redirect()->back()->withErrors($errors);
            //     }

            //     // return redirect()->back();
            // }
          //  else
           // {
                //If no client_code selected, then perform login based on username and pwd
                //$credentials = $request->only('user_code', 'password');
                if (Hash::check($request->password, $user->password)) {

                    if (auth::attempt(['user_code' => $request->user_code, 'password' => $request->password], $save_credentials))
                    {
                        if($isDefaultPasswordUpdated == "1")
                        {
                           // Sync Staff attendance data from device
                           //$this->syncStaffAttendance();

                           //If User has already updated password, so redirect to dashboard page
                         //  return redirect(route('main-dashboard'));
                           return redirect(route('index'));
                        }
                        else
                        {
                           //If User has to update password, then redirect to reset password page
                           return $this->showResetPasswordPage($request);

                        }
                    }
                }
                else
                {
                    $errors = ['Invalid credentials provided'];
                    return redirect()->back()->withErrors($errors);
                }

           // }
        }
        else
        {
            $errors = ['Your Account is not Active.'];
            return redirect()->back()->withErrors($errors);
            // return back()->withErrors('Your Account is not Active.');
        }

        return redirect()->back();

    }

    public function showResetPasswordPage(Request $request)
    {
        $Clientinfo = VmtClientMaster::first();

        return view('auth.reset_password',compact('Clientinfo'));
    }

    public function sendPasswordResetLink(Request $request, VmtLoginService $serviceVmtLoginService){

        //User can either send USER_CODE or EMAIL . So one of them might be null value.
        return $serviceVmtLoginService->sendPasswordResetLink($request->user_code, $request->email);
    }

    public function processSignedPasswordResetLink(Request $request){

        if ($request->hasValidSignature()) {
            return redirect('/resetPassword')->with('uid', $request->uid);
        }
        else{
            $error_message =  "Reset password link is expired. Please try again";

            return redirect('/forgetPassword')->with('error_message', $error_message);
        }

    }

   function isEmail($email) {
        if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
             return true;
        } else {
             return false;
        }
   }


    protected function syncStaffAttendance(){

        $deviceAttendanceController  = new VmtStaffAttendanceController;

        try {
            $deviceAttendanceController->syncStaffAttendanceFromDeviceDatabase();
        } catch (\Exception $e) {

        }


    }
    public function showLoginPage(){

      return view('login_page_v3');

    }
}
