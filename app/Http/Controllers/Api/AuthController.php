<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Services\VmtLoginService;


class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'user_code' => 'required',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => "failure",
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['user_code', 'password']))) {
                return response()->json([
                    'status' => "failure",
                    'message' => 'EmployeeCode & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('user_code', $request->user_code)->where('is_ssa', '0')->whereIn('active', array(0,1))->first();

            if (empty($user)) {
                return response()->json([
                    'status' => "failure",
                    'message' => "You are not authorized to access the mobile. Please contact your Administrator"
                ], 400);
            }

            $access_token = $this->generateToken($user);
            return response()->json([
                'status' => "success",
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'access_token' => $access_token
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => "failure",
                'message' => $th->getMessage()
            ], 500);
        }
    }
    /*
        Process :
        1. First, compare the OTP received with existing OTP .
        2. If matches, then use $request->new_password to update Users table


    */
    public function updatePassword(Request $request)
    {
        // $current_user_id = '';

        // if (isset($request->password)) {
        //     $currentUser = User::where('id',$current_user_id )->first();
        //     $currentUser->password = Hash::make($request->password);
        //     $currentUser->is_default_password_updated = '1';
        //     $currentUser->save();

        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Password updated successfully.',
        //     ]);
        // } else {
        //     return response()->json([
        //         'status' => 'failure',
        //         'message' => 'Password should not be empty.',
        //     ]);
        // }
    }

    public function sendPasswordResetLink(Request $request, VmtLoginService $serviceVmtLoginService)
    {
        return $serviceVmtLoginService->sendPasswordResetLink($request->user_code, $request->email);
    }


    protected function generateToken($user)
    {

        $payload = [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_role' => $user->org_role,
            'client_id' => $user->client_id,
            'is_onboarded' => $user->is_onboarded,
            'active' => $user->active,
            'exp' => time() + 3600 * 3, //# Hours
        ];

        $secret_token = env('APP_KEY');
        // dd($secret_token);

        return JWT::encode($payload, $secret_token, 'HS256');
    }

    // Otp Requested For Forget Password
    public function requestOtp(Request $request, VmtLoginService $serviceVmtLoginService)
    {
        return $serviceVmtLoginService->requestOtp($request->email);
    }

    public function verifyOtp(Request $request, VmtLoginService $serviceVmtLoginService)
    {
        return $serviceVmtLoginService->verifyOtp($request->user_code, $request->otp);
    }
    public function updatePasswordFromOtp(Request $request, VmtLoginService $serviceVmtLoginService)
    {
        return $serviceVmtLoginService->updatePasswordFromOtp($request->user_code, $request->password, $request->otp);
    }

    public function validateAndFetchEmployeeEmail(Request $request, VmtLoginService $serviceVmtLoginService){
       return $serviceVmtLoginService->validateAndFetchEmployeeEmail($request->abs_client_code , $request->user_code);
    }
}
