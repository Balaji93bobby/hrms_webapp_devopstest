<?php

namespace App\Http\Controllers;

use \Datetime;
use Carbon\Carbon;
use Session as Ses;
use App\Models\Bank;
use App\Models\User;
use App\Mail\TestEmail;
use App\Mail\AttendanceCheckinCheckoutNotifyMail;
use App\Models\Experience;
use App\Models\PollVoting;
use App\Models\VmtEmployee;
use Illuminate\Http\Request;
use App\Models\VmtClientMaster;

use App\Models\VmtGeneralSettings;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\VmtEmployeeAttendance;
use Illuminate\Support\Facades\Session;
use App\Models\VmtEmployeeFamilyDetails;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtEmployeeEmergencyContactDetails;
use App\Models\VmtEmployeeWorkShifts;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (view()->exists($request->path())) {
            return view($request->path());
        }
        return abort(404);
    }

    public function root()
    {
        return view('index');
    }

    /*Language Translation*/
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Ses::put('lang', $locale);
            Ses::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');

        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
            $user->avatar =  $avatarName;
        }

        $user->update();
        if ($user) {

            // return response()->json([
            //     'isSuccess' => true,
            //     'Message' => "User Details Updated successfully!"
            // ], 200); // Status code here
            return redirect()->back();
        } else {

            // return response()->json([
            //     'isSuccess' => true,
            //     'Message' => "Something went wrong!"
            // ], 200); // Status code here
            return redirect()->back();

        }
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Your Current password does not matches with the password you provided. Please try again."
            ], 200); // Status code
        } else {
            $user = User::find($id);
            $user->password = Hash::make($request->get('password'));
            $user->update();
            if ($user) {
                Ses::flash('message', 'Password updated successfully!');
                Ses::flash('alert-class', 'alert-success');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Password updated successfully!"
                ], 200); // Status code here
            } else {
                Ses::flash('message', 'Something went wrong!');
                Ses::flash('alert-class', 'alert-danger');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Something went wrong!"
                ], 200); // Status code here
            }
        }
    }

    // general Settings
    public function generalSettings(Request $request){
        return view('vmt_appraisalFlow_generalSettings');
    }


    public function updateExperienceInfo(Request $request) {
        // dd($request->all());
        $idArr = $request->input('ids');
        $companyNameArr = $request->input('company_name');
        $locationArr = $request->input('location');
        $jobPositionArr = $request->input('job_position');
        $periodFromArr = $request->input('period_from');
        $periodToArr = $request->input('period_to');
        foreach($request->input('company_name') as $k => $val) {
            if ($idArr[$k] && $idArr[$k] > 0) {
                $exp = Experience::find($idArr[$k]);
            } else {
                $exp = new Experience;
            }
            $exp->user_id = $request->id;
            $exp->company_name = $companyNameArr[$k];
            $exp->location = $locationArr[$k];
            $exp->job_position = $jobPositionArr[$k];
            $exp->period_from = $periodFromArr[$k];
            $exp->period_to = $periodToArr[$k];
            $exp->save();

        }

        Ses::flash('message', 'Bank Details Updated successfully!');
        Ses::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function updateBankInfo(Request $request) {
        $reDetails = VmtEmployee::where('userid', $request->id)->first();
        $details = VmtEmployee::find($reDetails->id);
        $details->bank_id = Bank::where('bank_name',$request->input('bank_name'))->value('id');
        $details->bank_ifsc_code = $request->input('bank_ifsc');
        $details->bank_account_number = $request->input('account_no');
        $details->pan_number = $request->input('pan_no');
        $details->save();
        Ses::flash('message', 'Bank Details Updated successfully!');
        Ses::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function updateFamilyInfo(Request $request) {
       // $familyInfo = 'name'=> $request->input('name'), 'relationship'=> $request->input('relationship'),'dob'=> $request->input('dob'), 'phone'=> $request->input('phone')]);

        //Delete existing family details
        $familyDetails = VmtEmployeeFamilyDetails::where('user_id',$request->id)->delete();

        $count = sizeof($request->input('name'));
       //dd($request->input('phone_number'));

        for($i=0 ; $i < $count ; $i++)
        {
            $emp_familydetails = new VmtEmployeeFamilyDetails;

            $emp_familydetails->user_id = $request->id;
            $emp_familydetails->name = $request->input('name')[$i];
            $emp_familydetails->relationship = $request->input('relationship')[$i];
            $emp_familydetails->dob = $request->input('dob')[$i];
            $emp_familydetails->phone_number = $request->input('phone_number')[$i];

            $emp_familydetails->save();
        }

        return redirect()->back();
    }

    public function updateEmergencyInfo(Request $request) {
        //dd($request->all());
        $contact  = new VmtEmployeeEmergencyContactDetails;
        $contact->user_id =  $request->id;
        $contact->name     = $request->input('name');
        $contact->relationship = $request->input('relationship');
        $contact->phone_number_1 = $request->input('phone_number_1');
        $contact->phone_number_2 = "";
        $contact->save();

        return redirect()->back();
    }

    public function updatePersonalInfo(Request $request) {
       // dd($request->all());
        $reDetails = VmtEmployee::where('userid', $request->id)->first();
        $details = VmtEmployee::find($reDetails->id);
        $details->marital_status = $request->input('marital_status');
        $details->mobile_number = $request->input('mobile_number');
        $details->no_of_children = $request->input('no_of_children');
        $details->spouse_name = $request->input('spouse');
        $details->religion = $request->input('religion');
        $details->nationality = $request->input('nationality');
        $details->passport_date = $request->input('passport_date');
        $details->passport_number = $request->input('passport_number');
        $details->save();
        Ses::flash('message', 'Personal Information Updated successfully!');
        Ses::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function updateLeaveInfo(Request $request) {

         return "Function is not implemented";
     }

    public function storeProfileImage(Request $request) {
        $file = $request->file('profilePic');
        $user = User::find($request->id);
        // $user->name = $request->input('name');
        if ($file) {
            //$filename = 'avatar-'.$request->id.'.'. $file->getClientOriginalExtension();
            $filename = 'avatar_'.$user->user_code.'_'.date("Y-m-d_h_i_sa").'.'. $file->getClientOriginalExtension();
            //dd($filename);
            $destination = public_path('/images');
            $file->move($destination, $filename);
            $user->avatar = $filename;
        }
        $user->save();
        Ses::flash('message', 'User Details Updated successfully!');
        Ses::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    //
    public function storePersonalInfo(Request $request) {
       // dd($request->all());
        $file = $request->file('profilePic');
        $user = User::find($request->id);
        $user->name = $request->input('name');
        $user->email=$request->input('present_email');
        $number = mt_rand(1000000000, 9999999999);
        if ($file) {
            $filename = 'avatar-'.$request->id.$number.'.'. $file->getClientOriginalExtension();
            $destination = public_path('/images/');
            $file->move($destination, $filename);
            $user->avatar = $filename;
        }
        $user->save();

        $details = VmtEmployee::where('userid',$request->id)->first();
        //dd($details);
        $details->dob = $request->input('dob');
        $details->gender = $request->input('gender');

        $details->current_address_line_1 = $request->input('current_address_line_1');
        $details->current_address_line_2 = $request->input('current_address_line_2');
        $details->permanent_address_line_1 = $request->input('permanent_address_line_1');
        $details->permanent_address_line_2 = $request->input('permanent_address_line_2');
        $details->mobile_number = $request->input('mobile_number');
        $details->save();

        //dd($request->all());

        return redirect()->back();
    }

    public function storeGeneralSettings(Request $request){
        //dd($request->all());
        $vmtSettings = VmtGeneralSettings::orderBy('id', 'desc')->first();
        if($vmtSettings){

        }else{
            $vmtSettings = new VmtGeneralSettings;
        }
        $vmtSettings->workflow_component  = $request->has('workflow_component')  ?  $request->workflow_component : null ;// => "Option-2"
        $vmtSettings->associate_wise_template  = $request->has('associate_wise_template')  ?  $request->associate_wise_template : null ;// => "on"
        $vmtSettings->kra_competency  = $request->has('kra_competency')  ?  $request->kra_competency : null ;// => "Option-3"
        $vmtSettings->increment_percentage  = $request->has('increment_percentage')  ? $request->increment_percentage : null  ;//=> "Option-3"
        $vmtSettings->report_component  =  $request->has('report_component')  ? $request->report_component : null ;// => "Option-2"
        $vmtSettings->rating_preference  = $request->has('rating_preference')  ? $request->rating_preference : null  ;// => "Option-2"
        $vmtSettings->annual_score_calculation  = $request->has('annual_score_calculation')  ? $request->annual_score_calculation : null  ;// => "Option-3"
        $vmtSettings->show_employee_review_rating  =  $request->has('show_employee_review_rating')  ? $request->show_employee_review_rating : null ; // => "on"
        $vmtSettings->employee_review_components  =  $request->has('employee_review_components')  ? $request->employee_review_components : null ; // => "Option-1"
        $vmtSettings->percentage_components  =  $request->has('percentage_components')  ? $request->percentage_components : null ; // => "Option-2"
        $vmtSettings->percentage_groupwise  = $request->has('percentage_groupwise')  ? $request->percentage_groupwise : null  ; // => "on"
        $vmtSettings->finalscore_calculation_method  =  $request->has('finalscore_calculation_method')  ? $request->finalscore_calculation_method : null ; // => "Option-2"
        $vmtSettings->achievement_based_rating  =  $request->has('achievement_based_rating')  ? $request->achievement_based_rating : null ; // => "on"
        $vmtSettings->show_all_managers_to_employee  =  $request->has('show_all_managers_to_employee')  ? $request->show_all_managers_to_employee : null ; // => "on"
        $vmtSettings->show_rated_managers  =  $request->has('show_rated_managers')  ? $request->show_rated_managers : null ; // => "on"
        $vmtSettings->rating_period_based  =  $request->has('rating_period_based')  ? $request->rating_period_based : null ; // => "na"
        $vmtSettings->rating_component  =  $request->has('rating_component')  ? $request->rating_component : null ; // => "Option-2"
        $vmtSettings->save();
        return "Settings Saved";
    }

    public function vmt_topbar_settings(Request $request){

        return view('vmt_topbar_settings');
    }

    public function update_client_logo(Request $request){

     //dd($request->all());
     // $user = Auth::user();
        $client_logo_update =VmtClientMaster::first();


        $count = sizeof($request->input('client_logo'));
        for($i=0 ; $i < $count ; $i++)
        {
           // $client_logo_update = new VmtClientMaster;

        $client_logo_update->client_logo = $request->input('client_logo')[$i];

        $client_logo_update->save();
        }
        return redirect()->back();


    }

    public function poll_voting(Request $request) {
        $polling = PollVoting::where('user_id', auth()->user()->id)->where('polling_id', $request->id)->first();
        if ($polling) {
            $poll = PollVoting::find($polling->id);
        } else {
            $poll = new PollVoting;
        }
        $poll->user_id = auth()->user()->id;
        $poll->polling_id = $request->input('id');
        $poll->selected_option = $request->input('polling');
        $poll->save();
        Ses::flash('message', 'Polling Updated successfully!');
        Ses::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    //
    public function storeGeneralInfo(Request $request){
        $VmtClientMaster = VmtClientMaster::first();
        if($VmtClientMaster){

        }else{
            $VmtClientMaster  = new VmtClientMaster;
            //$VmtClientMaster = VmtClientMaster::first();
        }
        //$VmtClientMaster->short_name  = ;
        if ($request->file('logo')) {
            $avatar = $request->file('logo');
            $avatarName = 'client-logo-'.date("Y-m-d_h_i_sa").'.png';
            $avatarPath = public_path('/generalinfo/');
            $avatar->move($avatarPath, $avatarName);
            $VmtClientMaster->client_logo =  '/generalinfo/'.$avatarName;
        }

        if($request->file('background-img')) {
            $avatar = $request->file('background-img');
            $avatarName = time() . '-bg.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/generalinfo/');
            $avatar->move($avatarPath, $avatarName);
            $VmtClientMaster->background_img =  '/generalinfo/'.$avatarName;
        }
        $VmtClientMaster->short_name  = $request->short_name;
        $VmtClientMaster->login_instruction = $request->login_instructions;

        $VmtClientMaster->save();
       // return "General Info Saved";
        return redirect()->back();
    }

    /*
        Check if the current user is already checkedin.
        Used in main dashboard to control that check-in toggle button

    */
    public function isAlreadyCheckedIn(Request $request){

        $query_attendance = VmtEmployeeAttendance::where('id',auth()->user()->id)->orderBy('id','desc');

        if($query_attendance->exists()){
            $query_attendance = $query_attendance->first();

            if(!empty($query_attendance->checkin_time) && empty($query_attendance->checkout_time))
            {
                return response()->json([
                    'status'=> 'success',
                    'message' => 'User already checked-in',
                    'data' => 'true'
                ]);
            }
            else
            if(empty($query_attendance->checkin_time) && empty($query_attendance->checkout_time) )
            {
                return response()->json([
                    'status'=> 'success',
                    'message' => 'No check-in/check-out done',
                    'data' => 'false'
                ]);
            }
            else
            {
                return response()->json([
                    'status'=> 'success',
                    'message' => 'Check-in and check-out already done',
                    'data' => 'false'
                ]);

            }

        }
        else
        {
            //if record doesnt exist
            return response()->json([
                'status'=> 'failure',
                'message' => 'No checkin data exists',
                'data' => 'false'
            ]);

        }

    }

    public function updateCheckin(Request $request) {

        $vmt_employee_workshift =VmtEmployeeWorkShifts::where('user_id', auth()->user()->id)->where('is_active','1')->first();

        if(empty( $vmt_employee_workshift->work_shift_id)){
            return response()->json([
                'status' => 'failure',
                'message' => 'No work-shift has been assigned.Please contact Admin.',
                'data'   => ""
            ]);
        }

        $checked = $request->input('checkin');
        if ($checked == 'true') {

            //Check if the user already checked-out.
            $attendance = VmtEmployeeAttendance::where('user_id', auth()->user()->id)
                        ->where('date', date('Y-m-d'));


            if($attendance->exists())
            {
                return response()->json([
                    'status'=> 'failure',
                    'message' => 'You have already checked-out for the day',
                    'time' => ""
                ]);
            }


            $attendance = new VmtEmployeeAttendance;
            $attendance->user_id = auth()->user()->id;
            $attendance->date = date('Y-m-d');
            $currentTime = new DateTime("now", new \DateTimeZone('Asia/Kolkata') );
            $attendance->checkin_time = $currentTime;
            $attendance->vmt_employee_workshift_id = $vmt_employee_workshift->work_shift_id;
            $attendance->attendance_mode_checkin = "web";
            $attendance->save();

            //Check whether if its LC/EG
            // $regularization_type = checkRegularizationType($currentTime, "check-in");
            // $isSent = null;
            // $user_mail = VmtEmployeeOfficeDetails::where('user_id',$attendance->user_id)->first()->officical_mail;

            //Send mail if its LC
            // if( !empty($regularization_type) &&  $regularization_type == "LC")
            // {
               // dd("adsf");
                // $VmtClientMaster = VmtClientMaster::first();
                // $image_view = url('/') . $VmtClientMaster->client_logo;
                // $emp_avatar = json_decode(getEmployeeAvatarOrShortName(auth::user()->id),true);
                // dd($emp_avatar);
                // $isSent    = \Mail::to($user_mail)->send(new AttendanceCheckinCheckoutNotifyMail(
                //     auth::user()->name,
                //     auth::user()->user_code,
                //     Carbon::parse($attendance->date)->format('M jS, Y'),
                //     Carbon::parse($currentTime)->format('h:i:s A'),
                //     $image_view,
                //     $emp_avatar,
                //     request()->getSchemeAndHttpHost(),
                    // Carbon::parse($leave_request_date)->format('M jS Y'),
                //     $regularization_type
                // ));
          //  }



            return response()->json([
                'status' => 'success',
                'message' => 'You have successfully checkedin!',
                'time' => $attendance->checkin_time,
               // 'regularization_type' => $regularization_type,
               // 'regularization_mail_sent' => $isSent ? "True" : $isSent
            ]);
        } else {
            $attendance = VmtEmployeeAttendance::where('user_id', auth()->user()->id)
                            ->where('date', date('Y-m-d'))
                            ->first();

            //dd($attendance);
            //$attendance->date = date('Y-m-d');
            $currentTime = new DateTime("now", new \DateTimeZone('Asia/Kolkata') );
            $attendance->checkout_time = $currentTime;
            $attendance->checkout_date= Carbon::today()->toDateString();
            $attendance->attendance_mode_checkout = "web";
            $attendance->save();

            //Get the time diff
            $checked = VmtEmployeeAttendance::where('user_id', auth()->user()->id)
                        ->where('date', date('Y-m-d'))
                        ->first();

            $to = Carbon::createFromFormat('H:i:s', $checked->checkout_time);

            $from = Carbon::createFromFormat('H:i:s', $checked->checkin_time);

            $effective_hours = gmdate('H:i:s', $to->diffInSeconds($from));

               // dd($effective_hours);

            return response()->json([
                'status' => 'success',
                'message' => 'You have successfully checked out!',
                'time' => $attendance->checkout_time,
                'effective_hours' => $effective_hours,
            ]);
        }
    }

    // Show Profile info
    public function showProfile(Request $request){
        $user = Auth::user();
        $user_full_details = User::leftjoin('vmt_employee_details','vmt_employee_details.userid', '=', 'users.id')
                        ->leftjoin('vmt_employee_office_details','vmt_employee_office_details.user_id', '=', 'users.id')
                        ->where('users.id', $user->id)->first();

        $emergencyContactDetails = VmtEmployeeEmergencyContactDetails::where('user_id', $user->id)->first();
        $familydetails = VmtEmployeeFamilyDetails::where('user_id',$user->id)->get();

        $bank = Bank::all();
        $exp = Experience::where('user_id',$user->id)->get();

        $maritalStatus = array('unmarried',
                            'married',
                            'divorced',
                            'widowed',
                            'seperated');

        $genderArray = array("Male", "Female", "Other");

        //dd($maritalStatus);
        if(!empty($user_full_details->l1_manager_code))
            $reportingManager = User::where('user_code',$user_full_details->l1_manager_code)->first();
        else
            $reportingManager = null;

        $allEmployees = User::where('user_code','<>',$user->id)->where('active',1)->get(['user_code','name']);
        $profileCompletenessValue  = calculateProfileCompleteness($user->id);

        return view('pages-profile', compact('user','allEmployees', 'maritalStatus','genderArray','user_full_details', 'familydetails','emergencyContactDetails','bank', 'exp', 'reportingManager','profileCompletenessValue'));
    }


    //
    public function testEmail(Request $request){
        //::
        \Mail::to('rahul.sgsits2015@gmail.com')->send(new TestEmail());
    }

     public function delete($id) {
        $user = \Auth::user();
        $notification = $user->notifications()->where('id',$id)->first();
        if ($notification)
        {
            $notification->markAsRead();
            return back();
        }
        else
            return back()->withErrors('we could not found the specified notification');
    }

    public function showDocumentTemplate(Request $request)
    {
        $client_name = "";

        //For testing only.
        if(isset($request->client_name))
        {
            $client_name = $request->client_name;
        }
        else
        {
            //get the client name from client table
            $client_name = str_replace(' ', '', sessionGetSelectedClientName());
      ;
        }

        $viewfile = 'vmt_preview_templates.previewtemplate_'.strtolower($client_name);

        //dd($viewfile);
        if (view()->exists($viewfile))
            return view($viewfile);
        else
        return view("vmt_preview_templates.previewtemplate_nodata");

    }

    public function showDocumentPayslip(){

        return view('preview_dynamicpayslip_template.preview_document_template');



    }

    public function showModuleSettingsPage(){

        return view('sidebar_module_settings');



    }


}
