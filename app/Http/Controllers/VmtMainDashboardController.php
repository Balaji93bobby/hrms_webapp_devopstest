<?php

namespace App\Http\Controllers;

use App\Mail\DashboardAnnouncementMail;
use App\Models\VmtOrgTimePeriod;
use App\Services\VmtAttendanceService;
use App\Services\VmtDashboardService;
use App\Services\VmtHolidayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\VmtGeneralSettings;
use App\Models\VmtClientMaster;
use App\Services\VmtAppPermissionsService;
use App\Models\VmtEmployeeDocuments;
use App\Models\VmtEmployee;
use App\Models\vmt_dashboard_posts;
// use App\Models\VmtAnnouncement;
use App\Models\VmtEmployeeAttendance;
use App\Models\vmtHolidays;
use App\Models\Polling;
use App\Models\PollVoting;
use App\Models\Compensatory;
use App\Models\VmtEmployeeHierarchy;
use App\Models\Countries;
use App\Models\State;
use App\Models\Department;
use App\Models\Bank;
use Session as Ses;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use App\Notifications\ViewNotification;
use Illuminate\Support\Facades\Notification;
use App\Mail\VmtAssignGoals;
use App\Mail\NotifyPMSManager;
use App\Models\VmtEmployeeOfficeDetails;
use App\Mail\PMSReviewCompleted;
use App\Models\VmtPraise;
use App\Http\Controllers\VmtEmployeeController;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;


class VmtMainDashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, VmtDashboardService $VmtDashboardService)
    {

        $client =  VmtClientMaster::get()->count();

        if ($client == 0) {

            return view('on_run_first_client_onboarding');
        } else {

            if (auth()->user()->active == 0) {


                if (auth()->user()->is_onboarded == 0) {

                    if (auth()->user()->onboard_type == 'quick') {

                        //User record already exists. So fetch it and show in normal onboard form
                        $encr_user_id = Crypt::encrypt(auth()->user()->id);

                        // return redirect()->to('simma');

                        return redirect()->to( request()->getSchemeAndHttpHost().'/Organization/employee-onboarding/'.auth()->user()->id);
                    } else
                    if (auth()->user()->onboard_type == 'bulk') {

                        return redirect()->to( request()->getSchemeAndHttpHost().'/documents');
                    } else
                        if (auth()->user()->onboard_type == 'normal') {
                        //This wont happen since HR is onboarding and so it should not come. But wrote for safety
                        return redirect()->to( request()->getSchemeAndHttpHost().'/Information');
                    }
                } else
                if (auth()->user()->is_onboarded == 1) {
                    //Check all the docs are approved or not
                    $all_document_approved = VmtEmployeeDocuments::where('user_id', auth()->user()->id);

                    if ($all_document_approved->exists()) {

                        $all_document_approval_count = $all_document_approved->where('Status', 'Rejected')->count();
                    } else {

                        $all_document_approval_count = '0';
                    }
                    //check the login epolyee is active or not
                    $active_status = User::where('id', auth()->user()->id)->first()->active;

                    if ($all_document_approval_count > '0' && $active_status == '0') {
                        // dd("dfgsdfg");
                        return view('vmt_documents');
                    } else {
                        // Profile is not activated . Show a message
                        return view('vmt_profile_under_review');
                    }
                }
            } else
            if (auth()->user()->active == -1) {
                //For employees who left the company.Show account terminated page.
                return view('vmt_profile_terminated');
            }


            ////Update the session vars for sub-clients selection
            if (Str::contains(currentLoggedInUserRole(), ["Super Admin", "Admin", "HR"])) {
                //dd(session());

                //Set the session client_id to default client if not set
                if (!$request->session()->has('client_id')) {
                    $this->updateSessionVariables(null);
                }
            } else
        if (Str::contains(currentLoggedInUserRole(), ["Manager"])) {
                if (!$request->session()->has('client_id')) {
                    //get the employee client_code
                    $assigned_client_id = getEmployeeClientDetails(auth()->user()->id);

                    $this->updateSessionVariables($assigned_client_id);
                }
            } else
        if (Str::contains(currentLoggedInUserRole(), ["Employee"])) {
                if (!$request->session()->has('client_id')) {
                    //get the employee client_code
                    $assigned_client_id = getEmployeeClientDetails(auth()->user()->id);

                    $this->updateSessionVariables($assigned_client_id);
                }
            }

            //Promote user to Manager if any employees reporting him
            $reporteesCount = VmtEmployeeOfficeDetails::where('l1_manager_code', auth()->user()->user_code)->get()->count();

            if ($reporteesCount > 0) {
                $currentUser = User::find(auth()->user()->id);

                //change only if current user is employee
                if ($currentUser->org_role == '5')
                    $currentUser->org_role = '4';

                $currentUser->save();
            }


            ////Employee Event details

            $employeesEventDetails = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                ->join('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                ->select(
                    'users.id',
                    'users.name',
                    'users.avatar',
                    'vmt_employee_office_details.designation',
                    'vmt_employee_details.dob',
                    'vmt_employee_details.doj'
                )
                ->where('users.is_ssa', '=', '0')
                ->where('users.active', '=', '1')
                ->where('users.is_onboarded', '=', '1')
                ->whereNotNull('vmt_employee_details.doj')
                ->whereNotNull('vmt_employee_details.dob');

            //Employee events for the current month only
            $dashboardEmployeeEventsData = [];
            $dashboardEmployeeEventsData['birthday'] = $employeesEventDetails->whereMonth('vmt_employee_details.dob', '>=', Carbon::now()->month)
                ->whereMonth('vmt_employee_details.dob', '<=', Carbon::now()->month + 1)
                ->get()->sortBy(function ($singleData, $key) {
                    return Carbon::createFromFormat('Y-m-d', $singleData["dob"])->dayOfYear;
                });

            $dashboardEmployeeEventsData['work_anniversary'] = $employeesEventDetails->whereMonth('vmt_employee_details.doj', '>=', Carbon::now()->month)
                ->whereMonth('vmt_employee_details.doj', '<=', Carbon::now()->month + 1)
                ->get()->sortBy(function ($singleData, $key) {
                    return Carbon::createFromFormat('Y-m-d', $singleData["doj"])->dayOfYear;
                });

            $dashboardEmployeeEventsData['hasData'] = 'true';


            //dd($dashboardEmployeeEventsData['birthday']->toArray());

            //If any events found, then set 'hasData' to TRUE else FALSE
            if (
                count($dashboardEmployeeEventsData['birthday']) == 0 &&
                count($dashboardEmployeeEventsData['work_anniversary']) == 0
            )
                $dashboardEmployeeEventsData['hasData'] = 'false';
            else
                $dashboardEmployeeEventsData['hasData'] = 'true';

            //$dashboardEmployeeEventsData['hasData'] =
            //$dashboardEmployeeEventsData['wedding_anniversary'] = $employeesEventDetails;

            //dd($dashboardEmployeeEventsData);
            //get the last attendance data for the current user

            $last_checkout_data = $VmtDashboardService->fetchEmpLastAttendanceStatus(auth()->user()->user_code);

            $checked = VmtEmployeeAttendance::where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'DESC')->first();
            $effective_hours = "";

            //If user already checkout, then send time difference to blade
            if (!empty($checked->checkout_time)) {
                $to = Carbon::createFromFormat('H:i:s', $checked->checkout_time);
            }
            if (!empty($checked->checkin_time)) {
                $from = Carbon::createFromFormat('H:i:s', $checked->checkin_time);
            }


            if (!empty($to) && !empty($from)) {
                $effective_hours = gmdate('H:i:s', $to->diffInSeconds($from));
            }


            // dd($effective_hours);


            $dashboardpost = vmt_dashboard_posts::all();
            // $holidays = vmtHolidays::orderBy('holiday_date', 'ASC')->get();
            $todayDate = date('Y-m-d');

            // getting upcoming holiday list
            $upcomingHolidays = vmtHolidays::where('holiday_date', '>=', $todayDate)->orderBy('holiday_date', 'ASC')->get();


            if (count($upcomingHolidays) > 0) {
                $upcomingHolidayIds = $upcomingHolidays->pluck('id');
                // getting past holiday list
                $pastHolidays = vmtHolidays::whereNotIn('id', $upcomingHolidayIds)->orderBy('holiday_date', 'ASC')->get();
                // merge upcoming holiday with past holiday
                $holidays = $upcomingHolidays->merge($pastHolidays);
            } else {
                $holidays = vmtHolidays::orderBy('holiday_date', 'ASC')->get();
            }


            $polling = Polling::first();
            if ($polling) {
                $selectedPoll = PollVoting::where('user_id', auth()->user()->id)->where('polling_id', $polling->id)->first();
                if ($selectedPoll) {
                    $polling->data = $selectedPoll->selected_option;
                }
            }

            ////Dashboard counters data
            $session_client_id = session('client_id');


            //New Joinees Count
            $currentDate = Carbon::now();
            $currentDate->setTimezone("Asia/Kolkata");
            $dateDifferenceForNewJoinees = 30; //Right now, showing 1 week old joinees


            //Total Employees Count
            //if '1', then show all client's employees
            if ($session_client_id == '1') {
                $totalEmployeesCount = User::where('users.is_ssa', '0')->count();

                $newEmployeesCount = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                    ->whereRaw('DATEDIFF(? , vmt_employee_details.doj) <= ?', [$currentDate, $dateDifferenceForNewJoinees])
                    //->where('users.active', '0')
                    ->where('users.is_ssa', '0')
                    ->get()->count();

                $query_todaysCheckedinEmployees = User::join('vmt_employee_attendance', 'vmt_employee_attendance.user_id', '=', 'users.id')
                    ->whereDate('vmt_employee_attendance.date', '=', $currentDate)
                    ->whereNull('vmt_employee_attendance.checkout_time')
                    ->where('users.is_ssa', '0');

                //Employees Leave today count
                $todayEmployeesCheckedInCount = $query_todaysCheckedinEmployees->get()->count();

                //Employees who checked-in today
                $todayEmployeesCheckedIn = $query_todaysCheckedinEmployees->get(['name', 'user_code']);


                $todayEmployeesOnLeaveCount = $totalEmployeesCount - $todayEmployeesCheckedInCount;
                //dd($newEmployeesCount);



            } else {
                $totalEmployeesCount = User::where('users.is_ssa', '0')->where('client_id', $session_client_id)->count();

                $newEmployeesCount = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
                    ->whereRaw('DATEDIFF(? , vmt_employee_details.doj) <= ?', [$currentDate, $dateDifferenceForNewJoinees])
                    //->where('users.active', '0')
                    ->where('users.client_id', $session_client_id)
                    ->where('users.is_ssa', '0')
                    ->get()->count();

                $query_todaysCheckedinEmployees = User::join('vmt_employee_attendance', 'vmt_employee_attendance.user_id', '=', 'users.id')
                    ->whereDate('vmt_employee_attendance.date', '=', $currentDate)
                    ->whereNull('vmt_employee_attendance.checkout_time')
                    ->where('users.client_id', $session_client_id)
                    ->where('users.is_ssa', '0');

                //Employees Leave today count
                $todayEmployeesCheckedInCount = $query_todaysCheckedinEmployees->get()->count();

                //Employees who checked-in today
                $todayEmployeesCheckedIn = $query_todaysCheckedinEmployees->get(['name', 'user_code']);


                $todayEmployeesOnLeaveCount = $totalEmployeesCount - $todayEmployeesCheckedInCount;
                //dd($newEmployeesCount);

            }

            //For Manager dashboard only
            //Get all Team employees for this logged-in user
            if (auth()->user()->org_role == '4') {
                $totalTeamEmployeesCount = VmtEmployeeOfficeDetails::where('l1_manager_code', auth()->user()->user_code)->get()->count();

                //TODO : Need to fetch biometric and employee_attendance table data and filter based on team members.
                $todayTeamEmployeesOnline = 0;
                $todayTeamEmployeesOffline = 0;
            }

            //Parse into json
            $dashboardCountersData = [];
            $dashboardCountersData['totalEmployeesCount'] = $totalEmployeesCount;
            $dashboardCountersData['newEmployeesCount'] = $newEmployeesCount;
            $dashboardCountersData['todayEmployeesCheckedInCount'] = $todayEmployeesCheckedInCount;
            $dashboardCountersData['todayEmployeesCheckedIn'] = $todayEmployeesCheckedIn;
            $dashboardCountersData['todayEmployeesOnLeaveCount'] = $todayEmployeesOnLeaveCount;
            $dashboardCountersData['todayTeamEmployeesCount'] = $totalTeamEmployeesCount ?? '-';
            $dashboardCountersData['todayTeamEmployeesOnline'] = $todayTeamEmployeesOnline ?? '-';
            $dashboardCountersData['todayTeamEmployeesOffline'] = $todayTeamEmployeesOffline ?? '-';

            //dd($dashboardCountersData);

            $json_dashboardCountersData = json_encode($dashboardCountersData);

            // get announcement data
            // $announcementData = VmtAnnouncement::orderBy('created_at', 'DESC')->where('notify_employees', '1')->get();

            // get praise data
            $praiseData = VmtPraise::orderBy('created_at', 'DESC')->get();

            if (Str::contains(currentLoggedInUserRole(), ["Super Admin", "Admin", "HR", "Manager"])) {
                return view('vmt_hr_dashboard', compact('dashboardEmployeeEventsData', 'checked', 'effective_hours', 'holidays', 'polling', 'dashboardpost', 'json_dashboardCountersData'));
            }
            // else
            // if(Str::contains( currentLoggedInUserRole(), ["Manager"]) )
            // {
            //     return view('vmt_manager_dashboard', compact( 'dashboardEmployeeEventsData','checked','effective_hours', 'holidays', 'polling','dashboardpost','json_dashboardCountersData','announcementData'));
            // }
            else
            if (Str::contains(currentLoggedInUserRole(), ["Employee"])) {
                return view('vmt_hr_dashboard', compact('dashboardEmployeeEventsData', 'checked', 'effective_hours', 'holidays', 'polling', 'dashboardpost', 'json_dashboardCountersData', 'praiseData'));
            } else {
                return "No Roles assigned for this user. Kindly contact the admin";
            }
        }
    }

    public function showMainDashboardPage(Request $request)
    {

        if (auth()->user()->active == 0) {

            if (auth()->user()->is_onboarded == 0) {

                if (auth()->user()->onboard_type == 'quick') {

                    //User record already exists. So fetch it and show in normal onboard form
                    $encr_user_id = Crypt::encrypt(auth()->user()->id);

                    return redirect()->route('employee-onboarding', ['uid' => $encr_user_id]);
                } else
                    if (auth()->user()->onboard_type == 'bulk') {

                    return redirect()->route('vmt-documents-route');
                } else
                        if (auth()->user()->onboard_type == 'normal') {
                    //This wont happen since HR is onboarding and so it should not come. But wrote for safety
                    return view('vmt_profile_under_review');
                }
            } else
                if (auth()->user()->is_onboarded == 1) {
                //Check all the docs are approved or not
                $all_document_approved = VmtEmployeeDocuments::where('user_id', auth()->user()->id);

                if ($all_document_approved->exists()) {

                    $all_document_approval_count = $all_document_approved->where('Status', 'Rejected')->count();
                } else {

                    $all_document_approval_count = '0';
                }
                //check the login epolyee is active or not
                $active_status = User::where('id', auth()->user()->id)->first()->active;

                if ($all_document_approval_count > '0' && $active_status == '0') {
                    // dd("dfgsdfg");
                    return view('vmt_documents');
                } else {
                    // Profile is not activated . Show a message
                    return view('vmt_profile_under_review');
                }
            }
        } else
            if (auth()->user()->active == -1) {
            //For employees who left the company.Show account terminated page.
            return view('vmt_profile_terminated');
        }


        ////Update the session vars for sub-clients selection
        if (Str::contains(currentLoggedInUserRole(), ["Super Admin", "Admin", "HR"])) {
            //dd(session());

            //Set the session client_id to default client if not set
            if (!$request->session()->has('client_id')) {
                $this->updateSessionVariables(null);
            }
        } else
            if (Str::contains(currentLoggedInUserRole(), ["Manager"])) {
            if (!$request->session()->has('client_id')) {
                //get the employee client_code
                $assigned_client_id = getEmployeeClientDetails(auth()->user()->id);

                $this->updateSessionVariables($assigned_client_id);
            }
        } else
                if (Str::contains(currentLoggedInUserRole(), ["Employee"])) {
            if (!$request->session()->has('client_id')) {
                //get the employee client_code
                $assigned_client_id = getEmployeeClientDetails(auth()->user()->id);

                $this->updateSessionVariables($assigned_client_id);
            }
        }

        //Promote user to Manager if any employees reporting him
        $reporteesCount = VmtEmployeeOfficeDetails::where('l1_manager_code', auth()->user()->user_code)->get()->count();

        if ($reporteesCount > 0) {
            $currentUser = User::find(auth()->user()->id);

            //change only if current user is employee
            if ($currentUser->org_role == '5')
                $currentUser->org_role = '4';

            $currentUser->save();
        }

        return view('vmt_main_dashboard_v2');
    }

    private function updateSessionVariables($client_id)
    {

        if (empty($client_id)) {

            session()->put('client_id', VmtClientMaster::first()->id);
            session()->put('client_logo_url', VmtClientMaster::first()->client_logo);
        } else {
            $query_client = VmtClientMaster::find($client_id);
            session()->put('client_id', $query_client->id);
            session()->put('client_logo_url', $query_client->client_logo);
        }
    }

    public function sessionSelectedClient()
    {
        if (sessionGetSelectedClientName()) {

            if (sessionGetSelectedClientName() == 'All') {
                return  $logoSrc = getSessionCurrentlySelectedClient();
            } else {
                return $logoSrc = getSessionCurrentlySelectedClient();
            }
        } else {

            return  $logoSrc =  getSessionCurrentlySelectedClient(auth()->user()->id);
        }
    }





    public function updateGlobalClientSelection(Request $request)
    {

        $this->updateSessionVariables($request->client_id);

        return "client_id : " . $request->client_id . " saved in session";
    }

    public function DashBoardPost(Request $request)
    {
        $id = auth()->user()->id;
        $file = $request->file('image_src');
        $data_dashboard = new vmt_dashboard_posts;
        $data_dashboard->message = $request->post_menu;
        $data_dashboard->author_id = $id;
        // dd($file);
        if ($file) {
            $filename = 'post-' . '.' . $file->getClientOriginalName();
            // dd($filename);
            $destination = public_path('/images');
            $file->move($destination, $filename);
            $data_dashboard->post_image = $filename;
        }
        $data_dashboard->save();
        $notification_user = User::where('id', auth::user()->id)->first();

        $message = "Post Added By ";

        // code email 4

        $title_data = null;
        $details_data = null;
        $hrList = User::role(['HR', 'Employee', 'admin', 'Admin'])->get();
        $hrUsers = $hrList->pluck('id');
        $officialMailList = VmtEmployeeOfficeDetails::whereIn('user_id', $hrUsers)->pluck('officical_mail');
        $user_emp_name = $request->post_menu;
        \Mail::to($officialMailList)->send(new PMSReviewCompleted('post', $user_emp_name, $title_data, $details_data));
        // end email
        Notification::send($notification_user, new ViewNotification($message . auth()->user()->name));
        $dashboardpost = vmt_dashboard_posts::where('author_id', $id)->pluck('message', 'post_image');
        return $dashboardpost;
    }

    public function DashBoardPostView($id, Request $request)
    {
        $dashboardpost = vmt_dashboard_posts::where('author_id', $id)->pluck('message');
        return $dashboardpost;
    }

    // public function DashBoardAnnouncement(Request $request)
    // {
    //     $Announcement_data = new VmtAnnouncement;
    //     $id = auth()->user()->id;
    //     $details_data = $request->input('details_data');
    //     $title_data = $request->input('title_data');
    //     $Announcement_data->title_data = $request->input('title_data');
    //     $Announcement_data->ann_author_id = $id;
    //     $Announcement_data->details_data = $request->input('details_data');
    //     $Announcement_data->date = $request->input('date');
    //     $Announcement_data->notify_employees = isset($request->notify_employees) ? $request->input('notify_employees') : '0';
    //     $Announcement_data->require_acknowledgement = isset($request->require_acknowledgement) ? $request->input('require_acknowledgement') : '0';
    //     $Announcement_data->hide_after = isset($request->hide_after) ? $request->input('hide_after') : '0';
    //     $Announcement_data->save();
    //     // dd($Announcement_data);
    //     $notification_user = User::where('id', auth::user()->id)->first();

    //     $message = "Announcement Added By ";
    //     // code email

    //     $employeesList = User::all()->pluck('id');

    //     $officialMailList = VmtEmployeeOfficeDetails::whereIn('user_id', $employeesList)->where('officical_mail', '!=', null)->whereNotNull('officical_mail')->pluck('officical_mail');
    //     //dd($officialMailList->toArray());
    //     $user_emp_name = $message . auth()->user()->name;
    //     // var_dump($officialMailList);
    //     if (!empty($officialMailList) && $Announcement_data->notify_employees == '1') {
    //         \Mail::to($officialMailList)->send(new DashboardAnnouncementMail($user_emp_name, $title_data, $details_data));
    //     }
    //     // end email
    //     Notification::send($notification_user, new ViewNotification($message . auth()->user()->name));
    //     $dashboardannoun = VmtAnnouncement::where('ann_author_id', $id)->pluck('title_data', 'ann_author_id', 'details_data');
    //     return $dashboardannoun;
    // }

    // function used for store dashboard polling questions section
    public function DashBoardPollingQuestions(Request $request)
    {
        try {
            $id = auth()->user()->id;
            $encodedOptions = json_encode($request->options);
            $pollingQuestionAdd = new Polling;
            $pollingQuestionAdd->poll_author_id = $id;
            $pollingQuestionAdd->question = $request->question;
            $pollingQuestionAdd->options = $encodedOptions;
            $pollingQuestionAdd->date = $request->date;
            $pollingQuestionAdd->notify_employees = isset($request->notify_employees) ? $request->notify_employees : '0';
            $pollingQuestionAdd->anonymous_poll = isset($request->anonymous_poll) ? $ruseequest->anonymous_poll : '0';
            $pollingQuestionAdd->save();
            if ($pollingQuestionAdd) {
                return response()->json(['status' => true, 'message' => 'Pooling Question added successfully']);
            }
            return response()->json(['status' => false, 'message' => 'Pooling Question not added']);
        } catch (Exception $e) {
            Log::info('dashboard polling question added error: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function DashBoardPraise(Request $request)
    {
        try {
            $id = auth()->user()->id;
            $praiseAdd = new VmtPraise();
            $praiseAdd->praise_data = $request->praise_data;
            $praiseAdd->praise_author_id = $id;
            $praiseAdd->save();
            if ($praiseAdd) {
                return response()->json(['status' => true, 'message' => 'Praise added successfully']);
            }
            return response()->json(['status' => false, 'message' => 'Praise not added']);
        } catch (Exception $e) {
            Log::info('dashboard praise added error: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function getMainDashboardData(Request $request, VmtDashboardService $serviceVmtDashboardService, VmtAttendanceService $serviceVmtAttendanceService, VmtHolidayService $serviceHolidayService)
    {

        //Fetch the data
        return $serviceVmtDashboardService->getMainDashboardData($request->user_code, $serviceVmtAttendanceService, $serviceHolidayService);


    }


    //Employee New Main Dashboard

    public function getNotifications(Request $request, VmtDashboardService $serviceVmtDashboardService)
    {

        //Fetch the data
        $user_code =  auth()->user()->user_code;
        return $serviceVmtDashboardService->getNotifications($user_code);
    }

    public function readNotification(Request $request, VmtDashboardService $serviceVmtDashboardService)
    {

        //Fetch the data
        // $request->record_id = "23";

        return $serviceVmtDashboardService->readNotification($request->record_id);
    }


    public function performAttendanceCheckIn(Request $request, VmtDashboardService $serviceVmtDashboardService)
    {
        //  dd($request->all());

        return $serviceVmtDashboardService->performAttendanceCheckIn($request->checked);
    }


    public function getAllEventsDashboard(Request $request, VmtDashboardService $serviceVmtDashboardService)
    {

        //Fetch the data
        return $serviceVmtDashboardService->getAllEventsDashboard($request->client_id);
    }

    public function getEmployeeLeaveBalanceDashboards(Request $request, VmtDashboardService $serviceVmtDashboardService)
    {
        //Accrued Leave Year Frame
        if (empty($request->all())) {
            $time_periods_of_year_query = VmtOrgTimePeriod::where('status', 1)->first();
        } else {
            $time_periods_of_year_query = VmtOrgTimePeriod::whereYear('start_date',)->whereMonth('start_date',)
                ->whereYear('end_date',)->whereMonth('end_date',)->first();
        }
        $start_date = $time_periods_of_year_query->start_date;
        $end_date = $time_periods_of_year_query->end_date;
        $calender_type = $time_periods_of_year_query->abbrevation;
        // $time_frame = array( $start_date.'/'. $end_date=>$calender_type.' '.substr($start_date, 0, 4).'-'.substr($end_date, 0, 4));
        $time_frame = $calender_type . ' ' . substr($start_date, 0, 4) . '-' . substr($end_date, 0, 4);
        $leave_balance_details = $serviceVmtDashboardService->getEmployeeLeaveBalanceDashboards(auth::user()->id, $start_date, $end_date);
        return $leave_balance_details;
    }

    public function getAllNewDashboardDetails(Request $request, VmtDashboardService $serviceVmtDashboardService,  VmtAttendanceService $serviceVmtAttendanceService)
    {
        $year = date("Y");
        $month = date("n");
        if (empty($request->all())) {
            $time_periods_of_year_query = VmtOrgTimePeriod::where('status', 1)->first();
        } else {
            $time_periods_of_year_query = VmtOrgTimePeriod::whereYear('start_date',)->whereMonth('start_date',)
                ->whereYear('end_date',)->whereMonth('end_date',)->first();
        }
        $start_date = $time_periods_of_year_query->start_date;
        $end_date = $time_periods_of_year_query->end_date;
        $calender_type = $time_periods_of_year_query->abbrevation;
        // $time_frame = array( $start_date.'/'. $end_date=>$calender_type.' '.substr($start_date, 0, 4).'-'.substr($end_date, 0, 4));
        $time_frame = $calender_type . ' ' . substr($start_date, 0, 4) . '-' . substr($end_date, 0, 4);


        return $serviceVmtDashboardService->getAllNewDashboardDetails(auth::user()->id, $start_date, $end_date, $year, $month, $serviceVmtAttendanceService);
    }


    public function fetchAttendanceDailyReport_PerMonth(Request $request, VmtDashboardService $serviceVmtDashboardService)
    {
        // LAL0002
        //Fetch the data
        $request->user_code = auth()->user()->user_code;
        $request->year = date("Y");
        $request->month = date("n");

        return $serviceVmtDashboardService->fetchAttendanceDailyReport_PerMonth($request->user_code, $request->year, $request->month);
    }
    public function fetchEmpLastAttendanceStatus(Request $request, VmtDashboardService $serviceVmtDashboardService,)
    {

        $request->user_code = auth()->user()->user_code;


        $response = $serviceVmtDashboardService->fetchEmpLastAttendanceStatus($request->user_code);

        if (!empty($response->checkout_date)) {
            $to = "";
            $from = "";


            if (!empty($response->checkout_time)) {
                $to = Carbon::createFromFormat('H:i:s', $response->checkout_time);
            }

            if (!empty($response->checkin_time)) {
                $from = Carbon::createFromFormat('H:i:s', $response->checkin_time);
            }

            if (!empty($from) && !empty($to)) {
                $effective_hours = gmdate('H:i:s', $to->diffInSeconds($from));
            }
            // $response['effective_hours'] = $effective_hours;
        }
        // if(!empty($response->checkin_date))
        // {
        //     $response['effective_hours'] =null;
        // }
        return $response;
        //return  $serviceVmtAttendanceService->getLastAttendanceStatus($request->user_code);
    }
public function getEmployeesCountDetails(Request $request, VmtDashboardService $serviceVmtDashboardService)
{
    $client_id=null;
      if(session('client_id') == 1){
        $client_id = VmtClientMaster::pluck('id')->toarray();
       }else{
        $client_id =[session('client_id')];
       }
    //HR New Main Dashboard
    return $serviceVmtDashboardService->getEmployeesCountDetails( $client_id );

}

    function getCurrentClientName()
    {
        $client_name = VmtClientMaster::all()->value('client_name');
        //dd($client_name);
        return $client_name;
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');

        return response()->json(['message' => 'Cache cleared successfully']);
    }

    public function  getOrgDashBoardDeatail( Request $request,VmtDashboardService  $VmtDashBoardService)
    {
        return $VmtDashBoardService->getOrgDashBoardDeatail();
    }

    public function getMobLoginCount(Request $request,VmtDashboardService  $VmtDashBoardService)
{
    return  $VmtDashBoardService->getMobLoginCount();
}
    public function checkEmployeeOnboardStatus(Request $request,VmtDashboardService  $VmtDashBoardService)
{
    return  $VmtDashBoardService->checkEmployeeOnboardStatus();
}

public function getCurrentSessionClientId(Request $request,VmtDashboardService  $VmtDashBoardService)
{
    return  $VmtDashBoardService->getCurrentSessionClientId();
}

}
