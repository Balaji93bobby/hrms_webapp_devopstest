<?php

namespace App\Services\Testing;

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
use App\Models\VmtDocuments;
use App\Notifications\ViewNotification;
use Illuminate\Support\Facades\Notification;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class VmtTestingService {

    public function sendTestMail(){


        try{

            $query_user = User::where('user_code',$user_code)->first();

            // $mandatory_doc_ids = VmtDocuments::where('is_mandatory','1')->pluck('id');

            $query_user_docs_count = VmtEmployeeDocuments::join('vmt_documents','vmt_documents.id','=','vmt_employee_documents.doc_id')
                                        ->where('vmt_employee_documents.user_id', $query_user->id)
                                        ->where('vmt_employee_documents.status', '<>','Approved')
                                        ->get()->count();


            return response()->json([
                'status' => 'success',
                'message' => "",
                'data' => $query_user_docs_count > 0 ? false : true
            ]);

        }
        catch(\Exception $e)
        {
            return response()->json([
                'status' => 'failure',
                'message' => "Error[ isAllOnboardingDocumentsApproved() ] ",
                'data' => $e
            ]);
        }

    }

    public function sendTestBulkMails(){

    }
}
