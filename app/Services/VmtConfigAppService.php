<?php

namespace App\Services;

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
use App\Models\VmtConfigApp;
use App\Models\VmtEmployeeDocuments;
use App\Models\VmtDocuments;
use App\Notifications\ViewNotification;
use Illuminate\Support\Facades\Notification;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class VmtConfigAppService {

    public function getAppConfig(){


        try{

            $response = VmtConfigApp::all();

            return [
                "status" => "success",
                "message" => "",
                "data" => $response

            ];

        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ getAppConfig() ] ",
                'data' => $e
            ]);
        }

    }
}
