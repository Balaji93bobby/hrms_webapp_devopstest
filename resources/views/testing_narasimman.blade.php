<?php

use App\Models\User;
use Carbon\Carbon;
use App\Models\VmtEmployeeDetails;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtDocuments;
use App\Models\VmtEmployeeDocuments;
use Illuminate\Support\Facades\DB;
use App\Models\Department;
use App\Models\Bank;
use App\Models\Experience;
use App\Models\gender;
use App\Models\VmtBloodGroup;
use App\Models\VmtEmployee;
use Illuminate\Http\Request;
use App\Models\VmtEmployeeFamilyDetails;
use App\Models\VmtEmployeeStatutoryDetails;
use App\Models\VmtEmployeePaySlip;
use App\Models\VmtEmployeePaySlipV2;
use App\Models\VmtPayroll;
use App\Models\VmtEmpPayroll;
use App\Models\VmtMaritalStatus;
use App\Models\VmtTempEmployeeProofDocuments;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Services\VmtApprovalsService;
use App\Http\Controllers\VmtProfilePagesController;



//   //Get the user record and update avatar column
//  $avatar_filename = User::where('user_code',auth()->user()->user_code)->first()->avatar;

// // //Get the image from PRIVATE disk and send as BASE64

// $response = Storage::disk('private')->get(auth()->user()->user_code."/profile_pics/".$avatar_filename);

// // dd($response);

// $base_codeimg = base64_encode($response);

// dd($base_codeimg);



$user_id = "149";

$simma  = getEmpgenderinfo($user_id);

dd($simma);

?>
