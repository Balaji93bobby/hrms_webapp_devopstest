<?php

namespace App\Http\Controllers\PMS;

use App\Exports\PMSV2ReviewerReviewFormExport;
use App\Exports\PMSV2ReviewFormExport;
use App\Mail\VmtPMSMail_HR;
use App\Models\User;
use App\Models\Department;
use App\Models\VmtPMS_KPIFormAssignedModel;
use App\Models\VmtPMS_KPIFormModel;
use App\Models\VmtEmployee;
use App\Models\VmtPMS_KPIFormDetailsModel;
use App\Models\ConfigPms;
use App\Models\VmtMasterConfig;
use App\Models\VmtEmployeePMSGoals;
use App\Models\VmtEmployeeOfficeDetails;
use App\Http\Controllers\Controller;
use App\Models\VmtPMS_KPIFormReviewsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\SampleKPIFormExport;
use App\Mail\VmtPMSMail_NotifyManager;
use App\Mail\PMSV2EmployeeAppraisalGoal;
use App\Mail\VmtAssignGoals;
use App\Mail\VmtPMSMail_Assignee;
use App\Mail\VmtPMSMail_Reviewer;
use App\Mail\VmtPMSMail_PublishForm;
use App\Models\VmtPMSRating;
use App\Notifications\ViewNotification;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Mailer\Exception\TransportException;

// use Maatwebsite\Excel\Facades\Excel;
/*
    New PMS Controller

*/

class VmtPMSModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // flow 1 pms V2
    public function showPMSDashboard()
    {
        $table_pmsConfig = ConfigPms::find('1');

        $calendar_type =  $table_pmsConfig->calendar_type;
        $year = $table_pmsConfig->year;
        $frequency = $table_pmsConfig->frequency;
        $assignment_period = $table_pmsConfig->assignment_period;

        // checkConfigPms();

        //Get existing KPI forms
        $existingKPIForms = VmtPMS_KPIFormModel::where('author_id', auth::user()->id)->get(['id','form_name']);

        // get Departments data
        $departments = Department::where('is_active', 1)->get();



        //Dashboard vars
        /*$employeesGoalsSetCount = \DB::table('vmt_pms_kpiform_reviews')->count(); //0;
        $totalEmployeesCount = User::where('active',1)->where('is_ssa',0)->count();
        $employeesAssessedCount = \DB::table('vmt_pms_kpiform_reviews')
                                ->where('is_reviewer_submitted', 'Not Like', '%null%')
                                ->count();

        $selfReviewCount =  \DB::table('vmt_pms_kpiform_reviews')
                                ->where('is_assignee_submitted', 1)
                                ->count();

        $totalSelfReviewCount = \DB::table('vmt_pms_kpiform_reviews')->count();*/

        $employees = VmtEmployee::rightJoin('users', 'users.id', '=', 'vmt_employee_details.userid')
            ->select(
                'users.name as emp_name',
                'users.id as id',
                'users.avatar as avatar',
            )
            ->where('users.active','1')
            ->where('users.is_ssa','0')
            ->orderBy('vmt_employee_details.created_at', 'ASC')
            ->get();

        // function to get dashboard Card data
        $dashboardCountersData = $this->getPerformanceDashboardSummaryStats();

        /*$dashboardCountersData['employeesGoalsSetCount'] = $employeesGoalsSetCount;
        $dashboardCountersData['totalEmployeesCount'] = $totalEmployeesCount;
        $dashboardCountersData['employeesAssessedCount'] = $employeesAssessedCount;
        $dashboardCountersData['selfReviewCount'] = $selfReviewCount;
        $dashboardCountersData['totalSelfReviewCount'] = $totalSelfReviewCount;
        $dashboardCountersData['finalScoreCount'] =  $finalScoreCount;*/

           // $pmsKpiAssigneeDetails = VmtPMS_KPIFormAssignedModel::with('getPmsKpiFormReviews')->WhereRaw("find_in_set(".auth()->user()->id.", reviewer_id)")->orWhereRaw("find_in_set(".auth()->user()->id.", assignee_id)")->orderBy('id','DESC')->get();
        $pmsKpiAssigneeDetails = VmtPMS_KPIFormAssignedModel::with('getPmsKpiFormReviews')->orderBy('id','DESC')->get();

        $flowCheck = 1;


        $allEmployeesList = User::leftJoin('vmt_employee_office_details','users.id','=','vmt_employee_office_details.user_id')
            ->leftJoin('vmt_employee_details','users.id','=','vmt_employee_details.userid')
            ->select('users.name','users.id','users.user_code','vmt_employee_office_details.designation')
            ->get();

        $allEmployeesWithoutLoggedUserList = User::leftJoin('vmt_employee_office_details','users.id','=','vmt_employee_office_details.user_id')
            ->leftJoin('vmt_employee_details','users.id','=','vmt_employee_details.userid')
            ->where('users.id','!=',Auth::id())
            ->select('users.name','users.id','users.user_code','vmt_employee_office_details.designation')
            ->get();

        $loggedInUser = Auth::user();

        $canShowOverallScoreCard_SelfAppraisal_Dashboard = fetchPMSConfigValue('can_show_overallscorecard_in_selfappraisal_dashboard');

        return view('pms.vmt_pms_dashboard_v2', compact('canShowOverallScoreCard_SelfAppraisal_Dashboard','dashboardCountersData','existingKPIForms','departments','employees','pmsKpiAssigneeDetails','flowCheck','allEmployeesList','allEmployeesWithoutLoggedUserList','loggedInUser','calendar_type','year','frequency','assignment_period'));
    }

    // function uised for get KPI Form Names in Dashboard Dropdown  through AJAX
    public function getKPIFormNameInDropdown(){
        try{
            $existingKPIForms = VmtPMS_KPIFormModel::where('author_id', auth::user()->id)->get(['id','form_name']);
            return response()->json(['status' => true, 'message' => 'Get Form Data Successfully','result' => $existingKPIForms]);
        }catch(Exception $e){
            return response()->json(['status' => true, 'message' => $e->getMessage()]);
        }
    }

    // flow 2 pms V2
    public function showPMSDashboardForManager()
    {
        $loggedUserId = Auth::id();
        $loggedUserDetails = User::findorfail($loggedUserId);
        $existingKPIForms = VmtPMS_KPIFormModel::where('author_id', $loggedUserId)->get(['id','form_name']);

        $table_pmsConfig = ConfigPms::find('1');

        $calendar_type =  $table_pmsConfig->calendar_type;
        $year = $table_pmsConfig->year;
        $frequency = $table_pmsConfig->frequency;
        $assignment_period = $table_pmsConfig->assignment_period;
        // get Departments data
        $departments = Department::where('is_active', 1)->get();

        //Dashboard vars
        /* $employeesGoalsSetCount = 0;
        $totalEmployeesCount = User::where('active',1)->where('is_ssa',0)->count();
        $employeesAssessedCount = 0;
        $selfReviewCount = 0;
        $totalSelfReviewCount = 0;*/

        $employees = VmtEmployee::rightJoin('users', 'users.id', '=', 'vmt_employee_details.userid')
            ->select(
                'users.name as emp_name',
                'users.id as id',
                'users.avatar as avatar',
            )
            ->where('users.active','1')
            ->where('users.is_ssa','0')
            ->orderBy('vmt_employee_details.created_at', 'ASC')
            ->get();

        // Get logged in user Employee deatils
        $loggedUserManagerNumber = User::where('id',$loggedUserId)->first()->user_code;

        // Get logged in Manager Employees List
        $loggedManagerEmployees = User::leftJoin('vmt_employee_office_details','users.id','=','vmt_employee_office_details.user_id')
            ->leftJoin('vmt_employee_details','users.id','=','vmt_employee_details.userid')
            ->where('l1_manager_code',$loggedUserManagerNumber)
            ->select('users.name','users.id','users.user_code','vmt_employee_office_details.designation','users.avatar as avatar')
            ->get();

        $loggedManagerEmployeesIDs = [];
        if(count($loggedManagerEmployees) > 0){
            $loggedManagerEmployeesIDs = $loggedManagerEmployees->pluck('id')->toArray();
        }
        $loggedManagerEmployeesIDs = implode(',',$loggedManagerEmployeesIDs);

        // Get logged in user office deatils and its parent code
        $loggedUserManagerOfficeDetails = VmtEmployeeOfficeDetails::where('user_id', $loggedUserId)->value('l1_manager_code');
        // From its parent code can get childs (same level managers of loggedIn Manager)
        $getSameLevelManagers = [];
        if(!empty($loggedUserManagerOfficeDetails)){
            $getSameLevelManagers = VmtEmployeeOfficeDetails::where('l1_manager_code',$loggedUserManagerOfficeDetails)
                                    ->leftJoin('users','vmt_employee_office_details.user_id','=','users.id')
                                    ->select('users.name','users.id','vmt_employee_office_details.designation')
                                    ->get();
        }

        $dashboardCountersData = $this->getPerformanceDashboardSummaryStats();
        /*$dashboardCountersData['employeesGoalsSetCount'] = $employeesGoalsSetCount;
        $dashboardCountersData['totalEmployeesCount'] = $totalEmployeesCount;
        $dashboardCountersData['employeesAssessedCount'] = $employeesAssessedCount;
        $dashboardCountersData['selfReviewCount'] = $selfReviewCount;
        $dashboardCountersData['totalSelfReviewCount'] = $totalSelfReviewCount;
        $dashboardCountersData['finalScoreCount'] =  $finalScoreCount;*/
            $pmsKpiAssigneeDetails = VmtPMS_KPIFormAssignedModel::with('getPmsKpiFormReviews')->WhereRaw("find_in_set(".$loggedUserId.", reviewer_id)")/*->orWhereRaw("find_in_set(".$loggedUserId.", assignee_id)")*/->orderBy('id','DESC')->get();

        $loggedInUser = Auth::user();

        $flowCheck = 2;

        $canShowOverallScoreCard_SelfAppraisal_Dashboard = fetchPMSConfigValue('can_show_overallscorecard_in_selfappraisal_dashboard');

        return view('pms.vmt_pms_dashboard_v2', compact('canShowOverallScoreCard_SelfAppraisal_Dashboard','dashboardCountersData','existingKPIForms','departments','employees','pmsKpiAssigneeDetails','loggedManagerEmployees','loggedUserDetails','getSameLevelManagers','flowCheck','loggedInUser','loggedManagerEmployeesIDs','calendar_type','year','frequency','assignment_period'));
    }

    // flow 3 pms V2
    public function showPMSDashboardForEmployee(){
        $loggedUserId = Auth::id();

        $existingKPIForms = VmtPMS_KPIFormModel::where('author_id', $loggedUserId)->get(['id','form_name']);
        $table_pmsConfig = ConfigPms::find('1');
        $calendar_type =  $table_pmsConfig->calendar_type;
        $year = $table_pmsConfig->year;
        $frequency = $table_pmsConfig->frequency;
        $assignment_period = $table_pmsConfig->assignment_period;

        // get Departments data
        $departments = Department::where('is_active', 1)->get();

        //Dashboard vars
        /*$employeesGoalsSetCount = 0;
        $totalEmployeesCount = User::where('active',1)->where('is_ssa',0)->count();
        $employeesAssessedCount = 0;
        $selfReviewCount = 0;
        $totalSelfReviewCount = 0;*/
        $employees = VmtEmployee::rightJoin('users', 'users.id', '=', 'vmt_employee_details.userid')
            ->select(
                'users.name as emp_name',
                'users.id as id',
                'users.avatar as avatar',
            )
            ->where('users.active','1')
            ->where('users.is_ssa','0')
            ->orderBy('vmt_employee_details.created_at', 'ASC')
            ->get();

        // check leveles L1,L2,L3 in pms config
        $pmsConfigData = ConfigPms::first();
        $selectedReviewLevel = '';
        if(isset($pmsConfigData) && isset($pmsConfigData->selected_reviewlevel)){
            $selectedReviewLevel = $pmsConfigData->selected_reviewlevel;
        }

        $parentUserCode = VmtEmployeeOfficeDetails::where('user_id',$loggedUserId)->value('l1_manager_code');

        // Get logged in user Employee details
        $parentReviewerNames = [];
        $parentReviewerIds = [];

        $employeeManagerDetail = getEmployeeManager([$loggedUserId]);
        $parentReviewerNames = $employeeManagerDetail->pluck('name')->toArray();
        $parentReviewerIds = $employeeManagerDetail->pluck('id')->toArray();

        // Level 2
        if($selectedReviewLevel == '' || $selectedReviewLevel == 'L2' || $selectedReviewLevel == 'L3'){
            foreach($parentReviewerIds as $reviewerId){
                $reviewerManagerDetail = getEmployeeManager([$reviewerId]);
                $reviewerName = $reviewerManagerDetail->pluck('name')->first();
                $reviewerId = $reviewerManagerDetail->pluck('id')->first();
                if(!empty($reviewerName) && !empty($reviewerId)){
                    if(!in_array($reviewerName,$parentReviewerNames)){
                        array_push($parentReviewerNames,$reviewerName);
                    }
                    if(!in_array($reviewerId,$parentReviewerIds)){
                        array_push($parentReviewerIds,$reviewerId);
                    }
                }
            }
        }

        // Level 3
        if($selectedReviewLevel == '' || $selectedReviewLevel == 'L3'){
            foreach($parentReviewerIds as $reviewerId){
                $reviewerManagerDetail = getEmployeeManager([$reviewerId]);
                $reviewerName = $reviewerManagerDetail->pluck('name')->first();
                $reviewerId = $reviewerManagerDetail->pluck('id')->first();

                if(!empty($reviewerName) && !empty($reviewerId)){
                    if(!in_array($reviewerName,$parentReviewerNames)){
                        array_push($parentReviewerNames,$reviewerName);
                    }
                    if(!in_array($reviewerId,$parentReviewerIds)){
                        array_push($parentReviewerIds,$reviewerId);
                    }
                }
            }
        }
        $parentReviewerIds = implode(',',$parentReviewerIds);
        $parentReviewerNames = implode(',',$parentReviewerNames);

        $dashboardCountersData =  $this->getPerformanceDashboardSummaryStats();
        /*[];
        $dashboardCountersData['employeesGoalsSetCount'] = $employeesGoalsSetCount;
        $dashboardCountersData['totalEmployeesCount'] = $totalEmployeesCount;
        $dashboardCountersData['employeesAssessedCount'] = $employeesAssessedCount;
        $dashboardCountersData['selfReviewCount'] = $selfReviewCount;
        $dashboardCountersData['totalSelfReviewCount'] = $totalSelfReviewCount;
        */
            $pmsKpiAssigneeDetails = VmtPMS_KPIFormAssignedModel::with('getPmsKpiFormReviews')/*->WhereRaw("find_in_set(".$loggedUserId.", reviewer_id)")->*/->orWhereRaw("find_in_set(".$loggedUserId.", assignee_id)")->orderBy('id','DESC')->get();

        $loggedInUser = Auth::user();

        $flowCheck = 3;


        $assignedUserDetails = VmtEmployee::join('users', 'users.id', '=', 'vmt_employee_details.userid')
            ->leftJoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
            ->select(
                'users.name',
                'users.user_code',
                'vmt_employee_office_details.department_id',
                'vmt_employee_office_details.designation',
                'vmt_employee_office_details.l1_manager_code',
                'vmt_employee_office_details.l1_manager_name',
                'vmt_employee_office_details.l1_manager_designation'
            )
            ->where('users.active', '1')
            ->where('users.is_ssa', '0')
            ->where('users.id',Auth::user()->id)
            ->first();

        $reportingManagerName = "---";

        if($assignedUserDetails)
            $reportingManagerName =User::where('user_code',$assignedUserDetails->l1_manager_code)->value('name');

        //// Rating calculation
        // Get assigned Details
        $assignedGoals  = VmtPMS_KPIFormAssignedModel::where('vmt_pms_kpiform_reviews.assignee_id',Auth::user()->id)->join('vmt_pms_kpiform_reviews','vmt_pms_kpiform_reviews.vmt_pms_kpiform_assigned_id','=','vmt_pms_kpiform_assigned.id')->first();

        // rating details
        $ratingDetail['performance'] ='-';
        $ratingDetail['ranking'] = '-';
        $ratingDetail['action'] = '-';
        $ratingDetail['rating'] = '-';

        //Get the Overall Rating for this User.(Includes all the KPI form)
       // $overallRatingDetails = calculateOverallReviewRating(Auth::user()->id);

        // if($assignedGoals!=''){
        //     // Calculation and check All Reviewers Rating
        //     // dD($assignedGoals->reviewer_kpi_percentage);
        //     $percentageVal = 0;
        //     $howManyPercCount = 0;
        //     // dd(json_decode($assignedGoals->reviewer_kpi_percentage, true));
        //     $allReviewerPercentages = isset($assignedGoals->reviewer_kpi_percentage) ? json_decode($assignedGoals->reviewer_kpi_percentage, true) : [];
        //     if(count($allReviewerPercentages) > 0){
        //         foreach($allReviewerPercentages as $percentage){
        //             $arraySumPercentage = array_sum($percentage);
        //             $percentageVal += $arraySumPercentage;
        //             $howManyPercCount += count($percentage);
        //         }
        //     }
        //     if ($howManyPercCount > 0) {
        //         $ratingDetail['rating'] = $percentageVal / $howManyPercCount;
        //         // calculate Rating Based on Table Dynamic Data
        //         $pmsConfigRatingDetails = VmtPMSRating::orderBy('sort_order','DESC')->get();
        //         if(count($pmsConfigRatingDetails) > 0){
        //             foreach($pmsConfigRatingDetails as $ratings){

        //                 $rangeCheck = explode('-',$ratings->score_range);
        //                 if($ratingDetail['rating'] >= $rangeCheck[0] && $ratingDetail['rating'] <= $rangeCheck[1]){
        //                     $ratingDetail['performance'] = $ratings->performance_rating;
        //                     $ratingDetail['ranking'] = $ratings->ranking;
        //                     $ratingDetail['action'] = $ratings->action;
        //                 }elseif($ratingDetail['rating'] >= 100){
        //                     if($ratings->score_range == '90 - 100'){
        //                         $ratingDetail['performance'] = $ratings->performance_rating;
        //                         $ratingDetail['ranking'] = $ratings->ranking;
        //                         $ratingDetail['action'] = $ratings->action;
        //                     }else{
        //                         $ratingDetail['performance'] = "Exceptionally Exceeds Expectations";
        //                         $ratingDetail['ranking'] = 5;
        //                         $ratingDetail['action'] = '20%';
        //                     }
        //                 }else{
        //                     $ratingDetail['performance'] = "error";
        //                     $ratingDetail['ranking'] = 000;
        //                     $ratingDetail['action'] = '0000%';
        //                 }
        //             }
        //         }
        //     }
        // }


        //// Rating calculation -ends

        //dd($ratingDetail);
        $canShowOverallScoreCard_SelfAppraisal_Dashboard = fetchPMSConfigValue('can_show_overallscorecard_in_selfappraisal_dashboard');

        return view('pms.vmt_pms_dashboard_v2', compact('dashboardCountersData','canShowOverallScoreCard_SelfAppraisal_Dashboard','ratingDetail','reportingManagerName','existingKPIForms','assignedUserDetails','departments','employees','pmsKpiAssigneeDetails','flowCheck','loggedInUser','parentReviewerIds','parentReviewerNames','parentReviewerIds','calendar_type','year','frequency','assignment_period'));
    }

    // KPI Form

    public function showKPICreateForm($year = null){
        $selectedYear = isset($year) ? $year : null;

        $config = ConfigPms::first();
        $show['dimension'] = 'true';
        $show['kpi'] = 'true';
        $show['operational'] = 'true';
        $show['measure'] = 'true';
        $show['frequency'] = 'true';
        $show['target'] = 'true';
        $show['stretchTarget'] = 'true';
        $show['source'] = 'true';
        $show['kpiWeightage'] = 'true';

        if ($config) {
            $config->header = json_decode($config->column_header, true);
            $show['dimension'] = $config->selected_columns && in_array('dimension', explode(',', $config->selected_columns)) ? 'true': 'false';
            $show['kpi'] = $config->selected_columns && in_array('kpi', explode(',', $config->selected_columns)) ? 'true': 'false';
            $show['operational'] = $config->selected_columns && in_array('operational', explode(',', $config->selected_columns)) ? 'true': 'false';
            $show['measure'] = $config->selected_columns && in_array('measure', explode(',', $config->selected_columns)) ? 'true': 'false';
            $show['frequency'] = $config->selected_columns && in_array('frequency', explode(',', $config->selected_columns)) ? 'true': 'false';
            $show['target'] = $config->selected_columns && in_array('target', explode(',', $config->selected_columns)) ? 'true': 'false';
            $show['stretchTarget'] = $config->selected_columns && in_array('stretchTarget', explode(',', $config->selected_columns)) ? 'true': 'false';
            $show['source'] = $config->selected_columns && in_array('source', explode(',', $config->selected_columns)) ? 'true': 'false';
            $show['kpiWeightage'] = $config->selected_columns && in_array('kpi_weightage', explode(',', $config->selected_columns)) ? 'true': 'false';
           // dd( $config->selected_columns);
        }
        //dd($show);
        return view('pms.vmt_pms_kpiform_create',compact('config','show','selectedYear'));
    }

    /*
        Save the KPI form created

    */
    public function saveKPIForm(Request $request){

        // dd($request->dimension);
        $config = ConfigPms::first();
        //  dd($config->selected_columns);
        $kpiTable  = new VmtPMS_KPIFormModel;

        $kpiTable->available_columns        =    $config->selected_columns;
        $kpiTable->author_id       =    auth::user()->id;
        $kpiTable->form_name     =    $request->name;
        $kpiTable->save();
        $KpiLAST = $kpiTable->id;

        $totRows  = count($request->dimension);
        for ($i=0; $i < $totRows; $i++) {
                $kpiRow = new VmtPMS_KPIFormDetailsModel;
                $kpiRow->vmt_pms_kpiform_id   =    $KpiLAST;
                $kpiRow->dimension   =    isset($request->dimension) && isset($request->dimension[$i]) ? $request->dimension[$i] : '';
                $kpiRow->kpi         =    isset($request->kpi) && isset($request->kpi[$i]) ? $request->kpi[$i] : '';
                $kpiRow->operational_definition   = isset($request->operational) && isset($request->operational[$i]) ? $request->operational[$i]: '' ;
                $kpiRow->measure     =    isset($request->measure) && isset($request->measure[$i]) ? $request->measure[$i] : '';
                $kpiRow->frequency   =    isset($request->frequency) && isset($request->frequency[$i]) ? $request->frequency[$i] : '';
                $kpiRow->target      =    isset($request->target) && isset($request->target[$i]) ? $request->target[$i] : '';
                $kpiRow->stretch_target  =    isset($request->stretchTarget) && isset($request->stretchTarget[$i]) ? $request->stretchTarget[$i] : '';
                $kpiRow->source          =    isset($request->source) && isset($request->source[$i]) ? $request->source[$i] : '';
                $kpiRow->kpi_weightage   =    isset($request->kpiWeightage) && isset($request->kpiWeightage[$i]) ? $request->kpiWeightage[$i] : '';
                // $kpiRow->author_id       =    auth::user()->id;
                // $kpiRow->author_name     =    str_replace(' ', '_', strtolower($request->name));
                $kpiRow->save();

        }
        return "Question Created Successfully";

    }


    public function deleteAssignedKPIForm(Request $request){

        $status="failure";
        $message = "Failed to delete the Assigned KPI form";

        //Delete the data from VmtPMS_KPIFormAssignedModel and VmtPMS_KPIFormReviewsModel
        if(VmtPMS_KPIFormAssignedModel::where('id', $request->assignedKPIFormID)->first()->exists()){

            $deleted_row_count = VmtPMS_KPIFormAssignedModel::where('id', $request->assignedKPIFormID)->first()->delete();

            if($deleted_row_count > 0)
            {
                VmtPMS_KPIFormReviewsModel::where('vmt_pms_kpiform_assigned_id',$request->assignedKPIFormID)->first()->delete();

                $message = "Assigned KPI form deleted successfully";
                $status = "success";
            }
        }


       return $response = [
            'status' => $status,
            'message' => $message,
        ];

    }

    /*
        Generate Sample KPI excel-sheet based on the columns
        enabled in the ConfigPMS table

    */
    public function generateSampleKPIExcelSheet($selectedYear = null)
    {
        // dD($selectedYear);
        $data = ConfigPms::first();
        $array_selectedKPIColumnsHeader = [];
        if(!empty($data)){
            $array_selectedKPIColumns = str_getcsv($data->selected_columns);
            if(count($array_selectedKPIColumns) > 0){
                foreach($array_selectedKPIColumns as $kpiColumnName){
                    $decodedColumnHeader = isset($data->column_header) ? json_decode($data->column_header,true) : '';
                    if($decodedColumnHeader != ''){
                        $array_selectedKPIColumnsHeader[] = isset($decodedColumnHeader[$kpiColumnName]) ? $decodedColumnHeader[$kpiColumnName] : '';
                    }
                }
            }
        }

        if(count($array_selectedKPIColumnsHeader) > 0){
            return \Excel::download(new SampleKPIFormExport($array_selectedKPIColumnsHeader,$selectedYear), 'Template_SampleKPIForm.xlsx');
        }else{
            return '';
        }

   }

   /*
        Publish the KPIForm by assigned to the given assignees,assigners.
   */
    public function publishKPIForm(Request $request)
    {

       // dd($request->all());

        $validator = Validator::make($request->all(), [
            'calendar_type' => 'required',
            'hidden_calendar_year' => 'required',
            'frequency' => 'required',
            'assignment_period_start' => 'required',
            'department' => 'required',
            'employees' => 'required',
            'reviewer' => 'required',
            'selected_kpi_form_id' => 'required',
        ],$messages = [
            'calendar_type.required' => 'Calendar Type is Required',
            'hidden_calendar_year.required' => 'Year is Required',
            'frequency.required' => 'Frequency is Required',
            'assignment_period_start.required' => 'Assignment Period is Required',
            'department.required' => 'Department is Required',
            'employees.required' => 'Employee is Required',
            'reviewer.required' => 'Reviewer is Required',
            'selected_kpi_form_id.required' => 'KPI Form is Required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['status' => false,'message'=>$validator->messages()->first()]);
        }
        try{
            $hr_details = getOrganization_HR_Details();
            //dd($hr_details);
            if(empty($hr_details))
            {
                return response()->json(['status' => false,'message'=>'Please assign an HR in Master Configuration settings']);
            }

            $loggedUser = Auth::user();

            $reviewersList = is_array($request->reviewer) ? $request->reviewer : explode(",",$request->reviewer);
            $employeesList = is_array($request->employees) ? $request->employees : explode(",",$request->employees);

            // check if employee is available in reviewer list
            if(count($reviewersList) > 0){
                foreach($reviewersList as $reviewerCheckAsEmployee){
                    if(in_array($reviewerCheckAsEmployee, $employeesList)){
                        return response()->json(['status' => false, 'message' => "Same User Can't be Employee as well as Reviewer"]);
                    }
                }
            }
            if(isset($request->hr_id) && !empty($request->hr_id)){
                if(!in_array($request->hr_id,$reviewersList)){
                    array_push($reviewersList, $request->hr_id);
                }
            }

            $kpi_AssignedTable  = new VmtPMS_KPIFormAssignedModel;

            $kpi_AssignedTable->vmt_pms_kpiform_id        =   $request->selected_kpi_form_id;
            $kpi_AssignedTable->assignee_id               =   is_array($request->employees) ? implode(",",$request->employees) : $request->employees;
            $kpi_AssignedTable->reviewer_id               =   is_array($request->reviewer) ? implode(",",$request->reviewer) : $request->reviewer;
            $kpi_AssignedTable->assigner_id               =   auth::user()->id;
            $kpi_AssignedTable->calendar_type             =   $request->calendar_type;
            $kpi_AssignedTable->year                      =   $request->hidden_calendar_year;
            $kpi_AssignedTable->frequency                 =   $request->frequency;
            $kpi_AssignedTable->assignment_period         =   $request->assignment_period_start;
            $kpi_AssignedTable->department_id             =   $request->department;

            $kpi_AssignedTable->save();

            // get parent id from logged used id
            $parent_user_code = VmtEmployeeOfficeDetails::where('user_id',$loggedUser->id)->value('l1_manager_code');
            $parentUserID = User::where('user_code',$parent_user_code)->value('id');


            //Based on assignee count, you create records in review table
            $assigneeIdsAll = explode(',',$kpi_AssignedTable->assignee_id );
            $explodedReviewersIds = explode(',',$kpi_AssignedTable->reviewer_id);

            $reviewerAcceptedData = [];
            $reviewerSubmittedData = [];
            foreach($explodedReviewersIds as $reviewer){
                $reviewerAcceptedData[$reviewer] = "1";
                if(isset($request->flowCheck) && $request->flowCheck == 3 && $parentUserID == $reviewer){
                    $reviewerAcceptedData[$reviewer] = null;
                }

                $reviewerSubmittedData[$reviewer] = null;
            }

            if(count($assigneeIdsAll) > 0){
                foreach($assigneeIdsAll as $assignee){
                    $assigneeReview = new VmtPMS_KPIFormReviewsModel();
                    $assigneeReview->vmt_pms_kpiform_assigned_id = $kpi_AssignedTable->id;
                    $assigneeReview->assignee_id = $assignee;
                    $assigneeReview->assignee_kpi_status = null;
                    $assigneeReview->reviewer_kpi_status = null;
                    $assigneeReview->is_assignee_submitted = null;
                    if(isset($request->flowCheck) && ($request->flowCheck == 1 || $request->flowCheck == 3))
                    {
                        $assigneeReview->is_assignee_accepted = '1';
                    }else{
                        $assigneeReview->is_assignee_accepted = null;
                    }
                    $assigneeReview->is_reviewer_submitted = json_encode($reviewerSubmittedData);
                    $assigneeReview->is_reviewer_accepted = json_encode($reviewerAcceptedData);
                    $assigneeReview->save();

                    if($request->flowCheck == 1 || $request->flowCheck == 2){
                        $assigneeMailId  = VmtEmployee::join('vmt_employee_office_details',  'user_id', '=', 'vmt_employee_details.userid')->where('userid', $assignee)->pluck('officical_mail','userid')->first();

                        $assigneeName = User::where('id',$assignee)->pluck('name')->first();
                        $assignerName = User::where('id',auth::user()->id)->pluck('name')->first();
                        $comments_employee = '';
                        $login_Link=request()->getSchemeAndHttpHost();
                        // dd($hr_details);
                        $emp_avatar    =  json_decode(newgetEmployeeAvatarOrShortName(auth()->user()->id),true);

                        $emp_neutralgender  = getGenderNeutralTerm(auth()->user()->id);

                        //Send mail when flow is 1 or 2 (Flow Checked inside VmtPMSMail_PublishForm)
                        if(!empty($assigneeMailId)){

                            //Send mail to assignee
                            \Mail::to($assigneeMailId)
                                  ->cc($hr_details->officical_mail)
                                  ->send(new VmtPMSMail_PublishForm("none", $assigneeName,
                                                                    $request->hidden_calendar_year,
                                                                    strtoupper($request->assignment_period_start),
                                                                    $assignerName,
                                                                    $comments_employee,
                                                                    $request->flowCheck,
                                                                    $login_Link,
                                                                    $emp_avatar,
                                                                    $emp_neutralgender
                                                                ));
                        }
                    }
                }
            }

            if($request->flowCheck == 3){
                $reviewerMailId  = VmtEmployee::join('vmt_employee_office_details',  'user_id', '=', 'vmt_employee_details.userid')->whereIn('userid', explode(',',$kpi_AssignedTable->reviewer_id))->pluck('officical_mail','userid')->toArray();

                $assigneeName = User::where('id',$assignee)->pluck('name')->first();
                $assignerName = User::where('id',auth::user()->id)->pluck('name')->first();
                $comments_employee = '';
                $login_Link=request()->getSchemeAndHttpHost();

                if(count($reviewerMailId) > 0){
                    foreach($reviewerMailId as $reviewerId => $reviewerMailSend){
                        $receiverDetails = User::findorfail($reviewerId);
                        $receiverName = isset($receiverDetails) && !empty($receiverDetails->name) ? $receiverDetails->name : '';

                    $emp_avatar    =  json_decode(newgetEmployeeAvatarOrShortName(auth()->user()->id),true);

                    $emp_neutralgender  = getGenderNeutralTerm(auth()->user()->id);

                        \Mail::to($reviewerMailSend)
                        ->cc($hr_details->officical_mail)
                        ->send(new VmtPMSMail_Assignee("none",$request->flowCheck,
                                                       $assigneeName,
                                                       $request->hidden_calendar_year." - ".strtoupper($request->assignment_period_start),
                                                       $receiverName,
                                                       $comments_employee,
                                                       $login_Link,
                                                       $emp_avatar,
                                                       $emp_neutralgender
                                                    ));
                    }
                }
            }
            //Create review record with some default values for :
            //status of assignee,assigner,reviewer ("Pending")
            return response()->json(['status' => true, 'message' => "KPI Published Successfully"]);
            // return "KPI Published Successfully";
           }
           catch(TransportException $e){
                 return response()->json(['status' => true, 'message' => 'KPI Published Successfully','error_verbose' => $e->getMessage()]);

           }
           catch(Exception $e){
                Log::info('Publish KPI Form V2 Error: '.$e->getMessage());
                //dd($e);
                return response()->json(['status' => false, 'message' => 'Something went wrong!','error_verbose' => $e->getMessage()]);
        }
    }

    /*
        Shown for both Assignee and Reviewer


    */
    public function showKPIReviewPage_Assignee(Request $request)
    {

        //dd($request->all());
        // Flow 1 HR creates Form and Assignee
        $kpiFormAssignedDetails = VmtPMS_KPIFormAssignedModel::findorfail($request->assignedFormid);

        $config = VmtPMS_KPIFormModel::findorfail($kpiFormAssignedDetails->vmt_pms_kpiform_id);
        $show['dimension'] = 'true';
        $show['kpi'] = 'true';
        $show['operational'] = 'true';
        $show['measure'] = 'true';
        $show['frequency'] = 'true';
        $show['target'] = 'true';
        $show['stretchTarget'] = 'true';
        $show['source'] = 'true';
        $show['kpiWeightage'] = 'true';
        $show['appraiser'] = false;
        $show['manager'] = false;
       //  dd($config);
        if ($config) {
            $config->header = json_decode($config->column_header, true);
            $show['dimension'] = $config->available_columns && in_array('dimension', explode(',', $config->available_columns)) ? 'true': 'false';
            $show['kpi'] = $config->available_columns && in_array('kpi', explode(',', $config->available_columns)) ? 'true': 'false';
            $show['operational'] = $config->available_columns && in_array('operational', explode(',', $config->available_columns)) ? 'true': 'false';
            $show['measure'] = $config->available_columns && in_array('measure', explode(',', $config->available_columns)) ? 'true': 'false';
            $show['frequency'] = $config->available_columns && in_array('frequency', explode(',', $config->available_columns)) ? 'true': 'false';
            $show['target'] = $config->available_columns && in_array('target', explode(',', $config->available_columns)) ? 'true': 'false';
            $show['stretchTarget'] = $config->available_columns && in_array('stretchTarget', explode(',', $config->available_columns)) ? 'true': 'false';
            $show['source'] = $config->available_columns && in_array('source', explode(',', $config->available_columns)) ? 'true': 'false';
            $show['kpiWeightage'] = $config->available_columns && in_array('kpi_weightage', explode(',', $config->available_columns)) ? 'true': 'false';
        }
      // dd($show);
        $review  =  VmtPMS_KPIFormAssignedModel::join('vmt_pms_kpiform_details','vmt_pms_kpiform_details.vmt_pms_kpiform_id','=','vmt_pms_kpiform_assigned.vmt_pms_kpiform_id')
        ->join('vmt_pms_kpiform_reviews','vmt_pms_kpiform_reviews.vmt_pms_kpiform_assigned_id','=','vmt_pms_kpiform_assigned.id')
        ->where('vmt_pms_kpiform_reviews.assignee_id','=',$request->assigneeId)
        ->get();

        //dd($review);
        foreach($review as $ff){
            $assignersName = User::whereRaw("id IN($ff->reviewer_id)")->pluck('name')->toArray();
            if ($assignersName) {
                $assignersName = implode(',', $assignersName);
            }
            if($ff->reviewer_kpi_review != null){
                $reviewArray = (json_decode($ff->reviewer_kpi_review, true)) ? (json_decode($ff->reviewer_kpi_review, true)) : [];
                $percentArray = (json_decode($ff->reviewer_kpi_percentage, true)) ? (json_decode($ff->reviewer_kpi_percentage, true)) : [];
                $commentArray = (json_decode($ff->reviewer_kpi_comments, true)) ? (json_decode($ff->reviewer_kpi_comments, true)) : [];
            }
        }
          //dd($show);
        $kpiRows      =  VmtPMS_KPIFormDetailsModel::where('vmt_pms_kpiform_id', $kpiFormAssignedDetails->vmt_pms_kpiform_id)->get();
        $reviewCompleted = false;
        $kpiRowsId = VmtPMS_KPIFormDetailsModel::where('vmt_pms_kpiform_id', $kpiFormAssignedDetails->vmt_pms_kpiform_id)->pluck('id')->toArray();
        $kpiRowsId = implode(',',$kpiRowsId);

        // Get assigned Details
        $assignedGoals  = VmtPMS_KPIFormAssignedModel::where('vmt_pms_kpiform_assigned.id',$request->assignedFormid)
                                                      ->where('vmt_pms_kpiform_reviews.assignee_id',$request->assigneeId)
                                                      ->join('vmt_pms_kpiform_reviews','vmt_pms_kpiform_reviews.vmt_pms_kpiform_assigned_id','=','vmt_pms_kpiform_assigned.id')->first();



        $assignedUserDetails = User::where('id',$request->assigneeId)->with('getEmployeeDetails','getEmployeeOfficeDetails')->first();
        $assignedUserDepartment = Department::where('id',$assignedUserDetails->getEmployeeOfficeDetails->department_id)->first();
        $assignedEmployee_Userdata = User::where('id',  $request->assigneeId)->first();
        $assignedEmployeeOfficeDetails = VmtEmployeeOfficeDetails::where('user_id', $request->assigneeId)->first();
        $empSelected = true;
        $employeeData = VmtEmployee::where('userid', $request->assigneeId)->first();


        $reviewersId = explode(',',$assignedGoals->reviewer_id);

        // check if all reviewers has submitted the review or not
        $isAllReviewersSubmittedData = [];
        $isAllReviewersSubmittedOrNot = false;
        if(isset($assignedGoals->is_reviewer_submitted)){
            $isAllReviewersSubmittedData = json_decode($assignedGoals->is_reviewer_submitted,true);
            if(!in_array('0',$isAllReviewersSubmittedData) && !in_array(null,$isAllReviewersSubmittedData)){
                $isAllReviewersSubmittedOrNot = true;
            }
        }

        // check if all reviewers has Accepted the review or not

        $isAllReviewersAcceptedData = [];
        $isAllReviewersAcceptedOrNot = false;
        if(isset($assignedGoals->is_reviewer_accepted)){
            $isAllReviewersAcceptedData = json_decode($assignedGoals->is_reviewer_accepted,true);
            if(!in_array('0',$isAllReviewersAcceptedData) && !in_array(null,$isAllReviewersAcceptedData)){
                $isAllReviewersAcceptedOrNot = true;
            }
        }

        // VMS Pms Ratings get from vmt_pms_rating table
        $pmsRatingDetails = VmtPMSRating::orderBy('sort_order')->get();

        // config pms data for header columns dynamic
        $pmsConfigData = ConfigPms::first();
        $headerColumnsDynamic = [];
        if(!empty($pmsConfigData)){
            $headerColumnsDynamic = json_decode($pmsConfigData->column_header,true);
        }
        // dD($headerColumnsDynamic);

        $canShowOverallScoreCard_ReviewPage = fetchPMSConfigValue('can_show_overallscorecard_in_reviewpage');
        //$canShowOverallScoreCard_SelfApprisal_Dashboard = fetchPMSConfigValue('can_show_overallscorecard_in_selfappraisal_dashboard');
        $canShowRatingCard = fetchPMSConfigValue('can_show_ratingcard_in_reviewpage');

        //Calculate score for the currently selected form
        $ratingDetail = calculateReviewRatings($request->assignedFormid, $request->assigneeId);
        $overallRatingDetails = calculateOverallReviewRating($request->assigneeId);

        // check if logged in user is assignee or not
        if($request->assigneeId == auth()->user()->id){
            return view('pms.vmt_pms_kpiappraisal_review_assignee', compact('review','canShowRatingCard','canShowOverallScoreCard_ReviewPage','assignedUserDetails','assignedUserDepartment','assignedGoals','empSelected','assignersName','config','show','ratingDetail','overallRatingDetails','kpiRowsId','kpiRows','reviewCompleted','isAllReviewersSubmittedOrNot','reviewersId','isAllReviewersSubmittedData','isAllReviewersAcceptedData','isAllReviewersAcceptedOrNot','pmsRatingDetails','kpiFormAssignedDetails','headerColumnsDynamic'));
        }

        // check if logged in user is reviewer or not
        if(in_array(Auth::id(), $reviewersId)){
           // $assigneeId = $request->assigneeId;
            $enableButton = true;
            return view('pms.vmt_pms_kpiappraisal_review_reviewer', compact('review','assignedUserDetails','canShowOverallScoreCard_ReviewPage','canShowRatingCard','assignedUserDepartment','assignedGoals','empSelected','assignersName','config','show','ratingDetail','overallRatingDetails','kpiRowsId','kpiRows','reviewCompleted','reviewersId','isAllReviewersSubmittedOrNot','isAllReviewersSubmittedData','isAllReviewersAcceptedData','isAllReviewersAcceptedOrNot','pmsRatingDetails','kpiFormAssignedDetails','headerColumnsDynamic', 'enableButton'));
        }
        $enableButton = false;

        return view('pms.vmt_pms_kpiappraisal_review_reviewer', compact('review','canShowRatingCard','canShowOverallScoreCard_ReviewPage','assignedUserDetails','assignedUserDepartment','assignedGoals','empSelected','assignersName','config','show','ratingDetail','overallRatingDetails','kpiRowsId','kpiRows','reviewCompleted','reviewersId','isAllReviewersSubmittedOrNot','isAllReviewersSubmittedData','isAllReviewersAcceptedData','isAllReviewersAcceptedOrNot','pmsRatingDetails','kpiFormAssignedDetails','headerColumnsDynamic', 'enableButton'));



    }


    // function used for Save assignee form Reviews
    public function saveAssigneeReviews(Request $request)
    {
        try{
            $hr_details = getOrganization_HR_Details();

            $assigneeUser = Auth::user();
            $kpiReviewCheck = VmtPMS_KPIFormReviewsModel::where('id',$request->kpiReviewId)->where('assignee_id',$assigneeUser->id)->with('getPmsKpiFormAssigned')->first();
            if(empty($kpiReviewCheck)){
                return response()->json(['status'=>false,'message'=>'Review Data Not Found']);
            }
            $kpiReviewCheck->assignee_kpi_review = $request->assignee_kpi_review;
            $kpiReviewCheck->assignee_kpi_percentage = $request->assignee_kpi_percentage;
            $kpiReviewCheck->assignee_kpi_comments = $request->assignee_kpi_comments;
            if($request->formSubmitType == 0){
                $kpiReviewCheck->is_assignee_submitted =  '0';
                $kpiReviewCheck->update();
                return response()->json(['status'=>true,'message'=>'Saved as draft']);
            }else{
                $kpiReviewCheck->is_assignee_submitted =  '1';
                $kpiReviewCheck->update();

                // get reviewer ids from vmt_pms_kpiform_assigned table
                $kpiFormAssignedReviewers = [];
                $kpiFormAssignedReviewersOfficialMails = [];
                if(isset($kpiReviewCheck->getPmsKpiFormAssigned)){
                    $kpiFormAssignedReviewers = explode(',',$kpiReviewCheck->getPmsKpiFormAssigned->reviewer_id);
                }
                // dd($hr_details);
                // check Multiple Reviewers
                if(count($kpiFormAssignedReviewers) > 0){
                    foreach($kpiFormAssignedReviewers as $reviewer){
                        $userEmployeeDetails = User::where('id',$reviewer)->with('getEmployeeOfficeDetails')->first();
                        if(isset($userEmployeeDetails->getEmployeeOfficeDetails) && !empty($userEmployeeDetails->getEmployeeOfficeDetails->officical_mail)){

                            // office details of assignee employee
                            $currentUser_empDetails = VmtEmployeeOfficeDetails::where('user_id', $assigneeUser->id)->first();
                            array_push($kpiFormAssignedReviewersOfficialMails,$userEmployeeDetails->getEmployeeOfficeDetails->officical_mail);

                            $assignment_period =  $kpiReviewCheck->getPmsKpiFormAssigned->year." - ".strtoupper($kpiReviewCheck->getPmsKpiFormAssigned->assignment_period);

                            $emp_gender  =  getGenderNeutralTerm($assigneeUser->id);

                            // Send mail to All Reviewers
                            \Mail::to($userEmployeeDetails->getEmployeeOfficeDetails->officical_mail)
                                    ->cc($hr_details->officical_mail)
                                    ->send(new VmtPMSMail_NotifyManager($assigneeUser->name,
                                                                        $currentUser_empDetails->designation,
                                                                        $userEmployeeDetails->name,
                                                                        $assignment_period,
                                                                        request()->getSchemeAndHttpHost(),
                                                                        $emp_gender ));

                            $message = "Employee has submitted KPI Assessment.  ";
                            // Send notification to All Revie
                                Notification::send($assigneeUser ,new ViewNotification($message.$assigneeUser->name));
                        }

                    }
                }
                // all reviewers office mails
                $kpiFormAssignedReviewersOfficialMails = implode(',',$kpiFormAssignedReviewersOfficialMails);
                if(!empty($kpiFormAssignedReviewersOfficialMails)){
                    return response()->json(['status'=>true,'message'=>"Published Review successfully.Sent mail to manager ".$kpiFormAssignedReviewersOfficialMails]);
                }
                return response()->json(['status'=>true,'message'=>'Published Review successfully' , 'mail_status'=>'true']);
            }

        }
        catch(TransportException $e){

            return response()->json(['status'=>true,'message'=>'Published Review successfully', 'mail_status'=>'failure']);
        }
        catch(Exception $e){
            Log::info('save or submit assignee review error: '.$e->getMessage());
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    // Save and Submit Review by Reviewer
    public function saveReviewerReviews(Request $request)
    {
        //dd($request->all());

        try{
            $kpiReviewCheck = VmtPMS_KPIFormReviewsModel::where('id',$request->kpiReviewId)->first();

            if(empty($kpiReviewCheck)){
                return response()->json(['status'=>false,'message'=>'Review Data Not Found']);
            }
            $decodedKpiReviewerReview = json_decode($kpiReviewCheck->reviewer_kpi_review,true);
            $decodedKpiReviewerPerc = json_decode($kpiReviewCheck->reviewer_kpi_percentage,true);
            $decodedIsKpiReviewerSubmitted = json_decode($kpiReviewCheck->is_reviewer_submitted,true);

            $decodedKpiReviewerReview[Auth::id()] = $request->reviewer_kpi_review[Auth::id()];
            $decodedKpiReviewerPerc[Auth::id()] = $request->reviewer_kpi_percentage[Auth::id()];

            $kpiReviewCheck->reviewer_kpi_review = $decodedKpiReviewerReview;
            $kpiReviewCheck->reviewer_kpi_percentage = $decodedKpiReviewerPerc;
            $kpiReviewCheck->reviewer_appraisal_comments = $request->appraiser_comments;

            if($request->formSubmitType == 0){
                $decodedIsKpiReviewerSubmitted[Auth::id()] = '0';
                $kpiReviewCheck->is_reviewer_submitted = $decodedIsKpiReviewerSubmitted;
                $kpiReviewCheck->update();
                return response()->json(['status'=>true,'message'=>'Saved as draft']);
            }else{
                //$hr_emp =  User::where('org_role','2')->pluck('id');//Admin
                //$hr_emp_details =   VmtEmployeeOfficeDetails::whereIn('user_id', $hr_emp);
                $hr_details = getOrganization_HR_Details();

                if(empty($hr_details->name))
                {
                    //dd("HR doesnt exist");
                    return response()->json(['status'=>false,'message'=>'Please assign a HR/Admin in your organisation. Contact the support team.']);

                }

                $decodedIsKpiReviewerSubmitted[Auth::id()] = '1';
                $kpiReviewCheck->is_reviewer_submitted = $decodedIsKpiReviewerSubmitted;
                $kpiReviewCheck->update();

                $kpiForAssignedDetails = VmtPMS_KPIFormAssignedModel::where('id',$kpiReviewCheck->vmt_pms_kpiform_assigned_id)->first();

                //Get the ASSIGNER_ID for sending mail
                //$hrReview = User::find($kpiForAssignedDetails->assigner_id);

                $assigneeDetails = User::where('id', $request->assignee_id)->first();
                $assigneeOfficeDetails = VmtEmployeeOfficeDetails::where('user_id', $request->assignee_id)->first();
                $login_link= request()->getSchemeAndHttpHost();
                $notification_user = User::where('id',auth::user()->id)->first();
                //dd($hr_details);
                $emp_gender  =  getGenderNeutralTerm(Auth::user()->id);
                //dd($kpiForAssignedDetails->toArray());
                //Send mail to employee stating that Manager has submitted his review
                \Mail::to($assigneeOfficeDetails->officical_mail)
                        ->cc($hr_details->officical_mail)
                        ->queue(new VmtPMSMail_Reviewer(
                                        "completed",
                                         $assigneeDetails->name,
                                         $kpiForAssignedDetails->year,
                                         strtoupper($kpiForAssignedDetails->assignment_period) ,
                                         Auth::user()->name,
                                         "",
                                         $login_link,
                                         $emp_gender
                                         )
                                );

                //Send mail to HR stating that KPI review is completed
               // \Mail::to($hr_details->officical_mail)->send(new VmtPMSMail_HR( $hr_details->name , $assigneeDetails->name, auth::user()->name, $kpiForAssignedDetails->year, $kpiForAssignedDetails->assignment_period, request()->getSchemeAndHttpHost() ));

                $message = "Manager has submitted KPI Assessment.  ";
                Notification::send($notification_user ,new ViewNotification($message.auth()->user()->name));

                return response()->json(['status'=>true,'message'=>"Published Review successfully. Sent mail to HR and Employee.  ".$hr_details->officical_mail." , ".$assigneeOfficeDetails->officical_mail]);
            }

        }
        catch(TransportException $e){
            return response()->json(['status'=>true,'message'=>'Published Review successfully. Mail sending failed/dalayed' , 'mail_status'=>'failure', 'error'=>$e]);
        }
        catch(Exception $e){
            Log::info('save or submit reviewer review error: '.$e->getMessage());
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /*
        Returns employees for the given reviewers emp_code list

    */
    public function getEmployeesOfManager(Request $request)
    {
        // dd($request->all());
         $currentEmpCode = User::whereIn('id',explode(',', $request->emp_id))->pluck('user_code');

        $employeesList = User::leftJoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                         ->whereIn('vmt_employee_office_details.l1_manager_code', $currentEmpCode)
                         ->where('users.active','1')
                         ->where('users.is_ssa','0')
                         ->get(['users.name','users.id']);
                        // dd($currentEmpCode);

        return $employeesList;

    }

    /*
        Returns manager for the given employees_id list

    */
    public function getManagersForEmployees($employees_id)
    {
        //Fetch all the managers for the given employees_id list
        $managersList = User::leftJoin('vmt_employee_office_details', 'vmt_employee_office_details.user_id', '=', 'users.id')
                         ->whereIn('vmt_employee_office_details.user_id', $employees_id)
                         ->distinct()->get(['vmt_employee_office_details.l1_manager_code'])
                         ->where('users.active','1')
                         ->where('users.is_ssa','0')
                         ->toArray();

        //Fetch the manager details from user table
        $managersDetailList = User::wherein('user_code',$managersList)->get(['id','name']);

        return $managersDetailList;
    }

    /*

        Returns all Reviewers
    */
    public function getAllEmployees()
    {
        $reviewerList = User::where('active',1)->where('is_ssa',0)->get(['id','name']);

        return $reviewerList;
    }

    /*
        Get PMS config for the current user
    */
    public function getUserPMSConfig($user_id)
    {
        $config = ConfigPms::first();
        $show['dimension'] = 'true';
        $show['kpi'] = 'true';
        $show['operational'] = 'true';
        $show['measure'] = 'true';
        $show['frequency'] = 'true';
        $show['target'] = 'true';
        $show['stretchTarget'] = 'true';
        $show['source'] = 'true';
        $show['kpiWeightage'] = 'true';
        if ($config) {
            $config->header = json_decode($config->column_header, true);
            $show['dimension'] = $config->selected_columns && in_array('dimension', explode(',', $config->selected_columns)) ? 'true': 'false';
            $show['kpi'] = $config->selected_columns && in_array('kpi', explode(',', $config->selected_columns)) ? 'true': 'false';
            $show['operational'] = $config->selected_columns && in_array('operational', explode(',', $config->selected_columns)) ? 'true': 'false';
            $show['measure'] = $config->selected_columns && in_array('measure', explode(',', $config->selected_columns)) ? 'true': 'false';
            $show['frequency'] = $config->selected_columns && in_array('frequency', explode(',', $config->selected_columns)) ? 'true': 'false';
            $show['target'] = $config->selected_columns && in_array('target', explode(',', $config->selected_columns)) ? 'true': 'false';
            $show['stretchTarget'] = $config->selected_columns && in_array('stretchTarget', explode(',', $config->selected_columns)) ? 'true': 'false';
            $show['source'] = $config->selected_columns && in_array('source', explode(',', $config->selected_columns)) ? 'true': 'false';
            $show['kpiWeightage'] = $config->selected_columns && in_array('kpiWeightage', explode(',', $config->selected_columns)) ? 'true': 'false';
        }

        return $config;
    }

    /*
    * function used for download excel sheet from review form
    */
    public function downloadExcelReviewForm($kpiAssignedId,$key,$yearAssignmentPeriod = null){
        try{

            $sheetName = 'review-page-sheet.xlsx';
            if(isset($yearAssignmentPeriod)){
                $yearAssignmentPeriod = preg_replace('/[\t\n\r\0\x0B]/', '', $yearAssignmentPeriod);
                $yearAssignmentPeriod = preg_replace('/([\s])\1+/', ' ', $yearAssignmentPeriod);
                $yearAssignmentPeriod = trim($yearAssignmentPeriod);

                $sheetName = 'review-page-'.$yearAssignmentPeriod.'.xlsx';
            }

            // $key => 1 assignee and 2 reviewer
            $assignedKpiFormDetails = VmtPMS_KPIFormAssignedModel::where('id',$kpiAssignedId)->with('getPmsKpiFormColumnDetails.getPmsKpiFormDetails')->first();

            $finalDownloadedResult = [];
            if(isset($assignedKpiFormDetails->getPmsKpiFormColumnDetails)){
                if(isset($assignedKpiFormDetails->getPmsKpiFormColumnDetails->getPmsKpiFormDetails)){
                    $vmtKpiForm = $assignedKpiFormDetails->getPmsKpiFormColumnDetails;
                    $getAvailableColumns = str_getcsv($vmtKpiForm->available_columns);

                    $dynamicTableCoumns = [];
                    $headerColumnsInSheet = [];
                    $configPmsData = ConfigPms::first();
                    $decodedColumnHeader = [];
                    if(!empty($configPmsData)){
                        $decodedColumnHeader = (json_decode($configPmsData->column_header,true));
                    }

                    $show['dimension'] = $getAvailableColumns && in_array('dimension', $getAvailableColumns) ? array_push($dynamicTableCoumns,'dimension'): '';
                    $show['kpi'] = $getAvailableColumns && in_array('kpi', $getAvailableColumns) ? array_push($dynamicTableCoumns,'kpi'): '';
                    $show['operational'] = $getAvailableColumns && in_array('operational', $getAvailableColumns) ? array_push($dynamicTableCoumns,'operational_definition'): '';
                    $show['measure'] = $getAvailableColumns && in_array('measure', $getAvailableColumns) ? array_push($dynamicTableCoumns,'measure'): '';
                    $show['frequency'] = $getAvailableColumns && in_array('frequency', $getAvailableColumns) ? array_push($dynamicTableCoumns,'frequency'): '';
                    $show['target'] = $getAvailableColumns && in_array('target', $getAvailableColumns) ? array_push($dynamicTableCoumns,'target'): '';
                    $show['stretchTarget'] = $getAvailableColumns && in_array('stretchTarget', $getAvailableColumns) ? array_push($dynamicTableCoumns,'stretch_target'): '';
                    $show['source'] = $getAvailableColumns && in_array('source', $getAvailableColumns) ? array_push($dynamicTableCoumns,'source'): '';
                    $show['kpiWeightage'] = $getAvailableColumns && in_array('kpiWeightage', $getAvailableColumns) ? array_push($dynamicTableCoumns,'kpi_weightage'): '';

                    foreach($show as $columnKey => $columnsCheck){
                        if($columnsCheck != ''){
                            if(isset($decodedColumnHeader[$columnKey])){
                                array_push($headerColumnsInSheet, $decodedColumnHeader[$columnKey]);
                            }else{
                                array_push($headerColumnsInSheet, $columnKey);

                            }
                        }
                    }


                    $finalDownloadedResult = VmtPMS_KPIFormDetailsModel::where('vmt_pms_kpiform_id',$vmtKpiForm->id)->select($dynamicTableCoumns)->get();
                }

            }

            if(count($finalDownloadedResult) > 0){
                if($key =='1'){
                    $assigneeReviewColumns = [
                        'KPI-Achievement (Self Review)',
                        'Self KPI Achievement %',
                        'Comments',
                    ];
                    $finalColumns = array_merge($headerColumnsInSheet, $assigneeReviewColumns);
                    // dd($finalDownloadedResult);
                    return Excel::download(new PMSV2ReviewFormExport($finalDownloadedResult, $finalColumns), $sheetName);
                }else{
                    $reviewerReviewColumns = [
                        'KPI - Achievement (Manager Review)',
                        'Manager KPI Achievement %',
                    ];
                    $finalColumns = array_merge($headerColumnsInSheet, $reviewerReviewColumns);
                    return Excel::download(new PMSV2ReviewerReviewFormExport($finalDownloadedResult, $finalColumns), $sheetName);
                }
            }
            // $assignedKpiFormReviews = VmtPMS_KPIFormReviewsModel::where('vmt_pms_kpiform_assigned_id',$kpiAssignedId)->where('assignee_id',$assigneeId)->first();
            // dd($assignedKpiFormDetails, $assignedKpiFormReviews);
        }catch(Exception $e){

            Log::info('excel sheet download form review page pms v2: '.$e->getMessage());
            return '';
        }
    }

    /*
    * function used for Accept/Reject review By Assignee
    */
    public function acceptRejectAssigneeReview(Request $request){
        try{
            $hr_details = getOrganization_HR_Details();

            $emp_avatar    =  json_decode(newgetEmployeeAvatarOrShortName(auth()->user()->id),true);

            $vmtAssignedFormReview = VmtPMS_KPIFormReviewsModel::where('id',$request->assigneeGoalId)->with('getPmsKpiFormAssigned')->first();
            if(empty($vmtAssignedFormReview)){
                return response()->json(['status'=>false,'message'=>"Assigned Form Review is not Available"]);
            }
            $isApproveOrReject = $request->isApproveOrReject; // 1 => Accept & 0 => Reject
            $vmtAssignedFormReview->is_assignee_accepted = $isApproveOrReject;
            $vmtAssignedFormReview->update();
            if(isset($vmtAssignedFormReview->getPmsKpiFormAssigned)){
                $comments_employee = '';
                $login_Link = request()->getSchemeAndHttpHost();
                $vmtAssignedDetails = $vmtAssignedFormReview->getPmsKpiFormAssigned;
                $mailingList = VmtEmployeeOfficeDetails::where('user_id', $vmtAssignedDetails->reviewer_id)->pluck('officical_mail');
                $assignedUserDetails = User::where('id',$vmtAssignedFormReview->assignee_id)->first();
                $reviewerUserDetails = User::where('id',$vmtAssignedDetails->reviewer_id)->first();
                if($vmtAssignedFormReview->is_assignee_accepted == "1")
                {

                    $users_details = User::where('name',$assignedUserDetails->name)->first();

                    $user_gender  =  getGenderNeutralTerm($users_details->id);

                    $reviewer_name = User::where('name',$reviewerUserDetails->name)->first();

                    $reviewer_gender =  getGenderNeutralTerm($reviewer_name->id);

                    \Mail::to($mailingList)
                    ->cc($hr_details->officical_mail)
                    ->send(new VmtPMSMail_Assignee( "accepted","2",$assignedUserDetails->name,$vmtAssignedDetails->year." - ".strtoupper($vmtAssignedDetails->assignment_period),$reviewerUserDetails->name,$comments_employee,$login_Link,$emp_avatar,$user_gender,$reviewer_gender));
                    $returnMsg = 'KPI has been accepted. Mail notification sent';
                    $message = "KPI has been accepted.  ";
                    Notification::send($assignedUserDetails ,new ViewNotification($message.auth()->user()->name));
                    return response()->json(['status'=>true,'message'=>$returnMsg]);
                }
                elseif($vmtAssignedFormReview->is_assignee_accepted == "0")
                {
                    if(isset($request->reject_comment) && $request->reject_comment != ''){
                        $vmtAssignedFormReview->assignee_rejection_comments = $request->reject_comment;
                        $vmtAssignedFormReview->update();
                        $command_emp = $vmtAssignedFormReview->assignee_rejection_comments;
                    }

                    $users_details = User::where('name',$assignedUserDetails->name)->first();

                    $user_gender  =  getGenderNeutralTerm($users_details->id);

                    $reviewer_name = User::where('name',$reviewerUserDetails->name)->first();

                    $reviewer_gender =  getGenderNeutralTerm($reviewer_name->id);


                    \Mail::to($mailingList)
                    ->cc($hr_details->officical_mail)
                    ->send(new VmtPMSMail_Assignee( "rejected","2",
                                                    $assignedUserDetails->name,
                                                    $vmtAssignedDetails->year." - ".strtoupper($vmtAssignedDetails->assignment_period),
                                                    $reviewerUserDetails->name,
                                                    $command_emp,request()->getSchemeAndHttpHost(),
                                                    $emp_avatar,
                                                    $user_gender,
                                                    $reviewer_gender
                                                ));

                    $returnMsg = 'KPI has been rejected. Mail notification sent';
                    $message = "KPI has been rejected.  ";
                    Notification::send($assignedUserDetails ,new ViewNotification($message.auth()->user()->name));
                    return response()->json(['status'=>true,'message'=>$returnMsg]);
                }
            }
            return response()->json(['status'=>false,'message'=>'Something Went Wrong!']);

        }
        catch(Exception $e){
            Log::info('accept/reject review by assignee error: '.$e->__toString());
            return response()->json(['status'=>false,'message'=>$e->getMessage(),'error_verbose'=>$e->__toString()]);
        }
    }

    /*
    * function used for Accept/Reject review By Reviewer
    */
    public function acceptRejectReviewerReview(Request $request){
        try{
            $hr_details = getOrganization_HR_Details();

            // dD($request->all());
            $vmtAssignedFormReview = VmtPMS_KPIFormReviewsModel::where('id',$request->assigneeGoalId)->with('getPmsKpiFormAssigned')->first();
            if(empty($vmtAssignedFormReview)){
                return response()->json(['status'=>false,'message'=>"Assigned Form Review is not Available"]);
            }
            $isApproveOrReject = $request->isApproveOrReject; // 1 => Accept & 0 => Reject
            $isReviewerAccepted = json_decode($vmtAssignedFormReview->is_reviewer_accepted,true);
            $isReviewerAccepted[Auth::id()] = $isApproveOrReject;
            $vmtAssignedFormReview->is_reviewer_accepted =$isReviewerAccepted;
            $login_Link = request()->getSchemeAndHttpHost();
            // dd($vmtAssignedFormReview->is_reviewer_accepted);

            // $vmtAssignedFormReview->is_assignee_accepted = $isApproveOrReject;
            $vmtAssignedFormReview->update();
            if(isset($vmtAssignedFormReview->getPmsKpiFormAssigned)){
                $rejectedReason = '';
                $vmtAssignedDetails = $vmtAssignedFormReview->getPmsKpiFormAssigned;
                $mailingList = VmtEmployeeOfficeDetails::where('user_id', $vmtAssignedDetails->assignee_id)->pluck('officical_mail');
                $receiverDetails = User::where('id',$vmtAssignedFormReview->assignee_id)->first();
                $senderDetails = Auth::user();
                $sender_gender =  getGenderNeutralTerm($senderDetails->id);
                if($isApproveOrReject == "1")
                {
                    \Mail::to($mailingList)
                            ->cc($hr_details->officical_mail)
                            ->send(new VmtPMSMail_Reviewer("approved",

                                                             $receiverDetails->name,
                                                             $request->hidden_calendar_year,
                                                             $vmtAssignedDetails->year." - ".strtoupper($vmtAssignedDetails->assignment_period) ,
                                                             $senderDetails->name,
                                                             $rejectedReason,
                                                             $login_Link,
                                                             $sender_gender,
                                                             )
                            );

                    $returnMsg = 'KPI has been accepted. Mail notification sent';
                    $message = "KPI has been accepted.  ";
                    Notification::send($receiverDetails ,new ViewNotification($message.auth()->user()->name));
                    return response()->json(['status'=>true,'message'=>$returnMsg]);
                }
                elseif($isApproveOrReject == "0")
                {
                    if(isset($request->reject_comment) && $request->reject_comment != ''){
                        $vmtAssignedFormReview->assignee_rejection_comments = $request->reject_comment;
                        $vmtAssignedFormReview->update();
                        $rejectedReason = $vmtAssignedFormReview->assignee_rejection_comments;
                    }

                    \Mail::to($mailingList)
                            ->cc($hr_details->officical_mail)
                            ->send(new VmtPMSMail_Reviewer("rejected",
                                                             $receiverDetails->name,
                                                             $request->hidden_calendar_year,
                                                             $vmtAssignedDetails->year." - ".strtoupper($vmtAssignedDetails->assignment_period) ,
                                                             $senderDetails->name,
                                                             $rejectedReason,
                                                             $login_Link,
                                                             $sender_gender
                                                             )
                            );

                    $returnMsg = 'KPI has been rejected. Mail notification sent';
                    $message = "KPI has been rejected.  ";
                    Notification::send($receiverDetails ,new ViewNotification($message.auth()->user()->name));
                    return response()->json(['status'=>true,'message'=>$returnMsg]);
                }
            }
            return response()->json(['status'=>false,'message'=>'Something Went Wrong!']);

        }catch(Exception $e){
            Log::info('accept/reject review by assignee error: '.$e->getMessage());
            return response()->json(['status'=>false,'message'=>$e->getMessage(),'verbose'=>$e]);
        }
    }

    /*

        //check whether the form is already assigned for the selected user
        for the given assignment period
    */
    public function isKPIAlreadyAssignedForGivenAssignmentPeriod(Request $request){
        //dd($request->all());
        try{
            if(!empty($request->selectedEmployeeId)){

                //check whether the form is already assigned for the selected user for the given assignment period
                $assignedEmployeesForGivenPeriod = VmtPMS_KPIFormAssignedModel::where('assignment_period',$request->assignmentPeriod)
                                                                                ->where('year',$request->year)
                                                                                ->pluck('assignee_id');

                //dd($assignedEmployeesForGivenPeriod);

                //store the employee ids in collection and check whether given employees has already been assigned forms
                $collection = collect();
                foreach($assignedEmployeesForGivenPeriod as $singleRecord)
                    $collection->push( explode(',', $singleRecord));

                //return matching employee ids from both arrays .
                $collection = array_intersect($request->selectedEmployeeId, Arr::collapse($collection));

                //Find their names and send as response
                $result = User::whereIn('id',$collection)->pluck('name');

                if(count($result) > 0)
                    return response()->json(['status'=>true,'message'=>'The following employees has already assigned KPIs for the selected Year & Assignment Period : ','result'=>$result]);
                else
                    return response()->json(['status'=>false,'message'=>'','result'=>'']);
            }
            return response()->json(['status'=>'error','message'=>'Param : selectedEmployeeId is empty !']);

        }catch(Exception $e){
            Log::info('isKPIAlreadyAssignedForGivenAssignmentPeriod error: '.$e->getMessage());
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }

    public function getReviewerOfSelectedEmployee(Request $request){
        try{
            if(isset($request->selectedEmployeeId) && count($request->selectedEmployeeId) > 0){

                $pmsConfigData = ConfigPms::first();
                $selectedReviewLevel = '';
                if(isset($pmsConfigData) && isset($pmsConfigData->selected_reviewlevel)){
                    $selectedReviewLevel = $pmsConfigData->selected_reviewlevel;
                }
                $authDetails = Auth::user();
                // Level 1
                $employeeManagerDetail = getEmployeeManager($request->selectedEmployeeId);
                $reviewerNames = $employeeManagerDetail->pluck('name')->toArray();
                $reviewerIds = $employeeManagerDetail->pluck('id')->toArray();

                // Level 2
                if($selectedReviewLevel == '' || $selectedReviewLevel == 'L2' || $selectedReviewLevel == 'L3'){
                    foreach($reviewerIds as $reviewerId){
                        $reviewerManagerDetail = getEmployeeManager([$reviewerId]);
                        $reviewerName = $reviewerManagerDetail->pluck('name')->first();
                        $reviewerId = $reviewerManagerDetail->pluck('id')->first();
                        if(!empty($reviewerName) && !empty($reviewerId)){
                            if(!in_array($reviewerName,$reviewerNames)){
                                array_push($reviewerNames,$reviewerName);
                            }
                            if(!in_array($reviewerId,$reviewerIds)){
                                array_push($reviewerIds,$reviewerId);
                            }
                        }
                    }
                }

                // Level 3
                if($selectedReviewLevel == '' || $selectedReviewLevel == 'L3'){
                    foreach($reviewerIds as $reviewerId){
                        $reviewerManagerDetail = getEmployeeManager([$reviewerId]);
                        $reviewerName = $reviewerManagerDetail->pluck('name')->first();
                        $reviewerId = $reviewerManagerDetail->pluck('id')->first();

                        if(!empty($reviewerName) && !empty($reviewerId)){
                            if(!in_array($reviewerName,$reviewerNames)){
                                array_push($reviewerNames,$reviewerName);
                            }
                            if(!in_array($reviewerId,$reviewerIds)){
                                array_push($reviewerIds,$reviewerId);
                            }
                        }
                    }
                }

                $removeSelectedEmployee = [];
                foreach($request->selectedEmployeeId as $employeeExistsCheck)
                {
                    if(in_array($employeeExistsCheck,$reviewerIds)){
                        array_push($removeSelectedEmployee, $employeeExistsCheck);
                    }
                }

                $result = [
                    'reviewerNames' => $reviewerNames,
                    'reviewerIds' => $reviewerIds,
                    'removeSelectedEmployee' => $removeSelectedEmployee
                ];
                return response()->json(['status'=>true,'message'=>'Get Reviewers Details Done','result'=>$result]);
            }
            return response()->json(['status'=>false,'message'=>'Something went wrong!']);
        }catch(Exception $e){
            Log::info('Get Reviewer Of Selected Employee flow 1 HR PMS V2 error: '.$e->getMessage());
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }
    public function getSameLevelOfReviewer(Request $request){
        try{
            if(isset($request->reviewerId)){
                $currentEmpCode = VmtEmployeeOfficeDetails::where('user_id',$request->reviewerId)->pluck('l1_manager_code')->first();
                if(empty($currentEmpCode)){
                    return response()->json(['status'=>false,'message'=> 'Reviewer Not Exists']);
                }

                $getSameLevelManagers = VmtEmployeeOfficeDetails::where('l1_manager_code',$currentEmpCode)
                                    ->leftJoin('users','vmt_employee_office_details.user_id','=','users.id')
                                    ->select('users.name','users.id','vmt_employee_office_details.designation')
                                    ->where('users.id','!=',$request->reviewerId)
                                    ->get()
                                    ->toArray();

                                    // dd($getSameLevelManagers);
                $result = [
                    'getSameLevelManagers' => $getSameLevelManagers,
                ];
                Log::info('Get Reviewers Of Same level flow 1 HR PMS V2 error: Something Went Wrong=> '.$request->reviewerId);
                return response()->json(['status'=>true,'message'=>'','result'=>$result]);
            }
            return response()->json(['status'=>false,'message'=>'']);
        }catch(Exception $e){
            Log::info('Get Reviewers Of Same level flow 1 HR PMS V2 error: '.$e->getMessage());
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function changeReviewerSelection(Request $request){
        try{
            // get new and old reviewer details, id and name
            $newReviwerName =  User::findorfail($request->newReviewerName);
            $oldReviewerName = User::findorfail($request->oldReviewerName);

            $reviewersIds = explode(',',$request->reviewersIds);
            dD($request->all());
            $reviewersName = explode(',',$request->reviewersName);
            $existingReviewerIds = [];

            foreach($reviewersIds as $reviewerId){
                // checking old reviewer and remove from array
                if($reviewerId != $request->oldReviewerName  && isset($request->oldReviewerName)){
                    array_push($existingReviewerIds, $reviewerId);
                }

                // checking new reviewer and add in array
                if(!in_array($request->newReviewerName, $existingReviewerIds) && isset($request->newReviewerName)){
                    array_push($existingReviewerIds, $request->newReviewerName);
                }
            }


            $existingReviewerNames = User::whereIn('id',$existingReviewerIds)->pluck('name')->toArray();

            $result = [
                'existingReviewerIds' => implode(',',$existingReviewerIds),
                'existingReviewerNames' => implode(',',$existingReviewerNames),
            ];
            return response()->json(['status'=>true,'message'=>'','data'=>$result]);
        }catch(Exception $e){
            Log::info('Change Reviewer Selection flow 1 HR PMS V2 error: '.$e->getMessage());
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function republishForm($kpiAssignedId){
        $kpiAssignedDetails = VmtPMS_KPIFormAssignedModel::where('id',$kpiAssignedId)->with('getPmsKpiFormColumnDetails.getPmsKpiFormDetails')->first();
        // dD($kpiAssignedDetails);

        $configDetails = ConfigPms::first();
        // dD($configDetails);
        $configHeader = $kpiAssignedDetails->getPmsKpiFormColumnDetails->available_columns;
        // dD($configHeader);
        $configHeaderFormName = $kpiAssignedDetails->getPmsKpiFormColumnDetails->form_name;
        $configHeader = explode(',',$configHeader);

        // dd(json_decode($configDetails->column_header));
        $columnHeader = [];
        if(count($configHeader) > 0){

            foreach($configHeader as $header){
                $decodedColumnHeader = json_decode($configDetails->column_header,true);
                $decodedColumnHeaderValueCheck = explode(',', $configDetails->selected_columns);
                if(in_array($header,$decodedColumnHeaderValueCheck)){
                    $columnHeader[$header] = $decodedColumnHeader[$header];
                }
            }
        }
        $data = $kpiAssignedDetails->getPmsKpiFormColumnDetails->getPmsKpiFormDetails;
        return view('pms.vmt_pms_kpiform__reviewer_republish',compact('columnHeader','configHeaderFormName','data','kpiAssignedId'));
    }

    public function republishFormEdited(Request $request){
        $kpiAssignedDetails = VmtPMS_KPIFormAssignedModel::where('id',$request->kpiAssignedId)->with('getPmsKpiFormColumnDetails.getPmsKpiFormDetails')->first();

        $formDetails  = $kpiAssignedDetails->getPmsKpiFormColumnDetails->getPmsKpiFormDetails;
        foreach($formDetails as $key => $form){
            if(isset($request->dimension) && $request->dimension[$key]){
                $form->dimension =  $request->dimension[$key];
            }
            if(isset($request->kpi) && $request->kpi[$key]){
                $form->kpi =  $request->kpi[$key];
            }
            if(isset($request->operational) && $request->operational[$key]){
                $form->operational_definition =  $request->operational[$key];
            }
            if(isset($request->measure) && $request->measure[$key]){
                $form->measure =  $request->measure[$key];
            }
            if(isset($request->frequency) && $request->frequency[$key]){
                $form->frequency =  $request->frequency[$key];
            }
            if(isset($request->target) && $request->target[$key]){
                $form->target =  $request->target[$key];
            }
            if(isset($request->stretchTarget) && $request->stretchTarget[$key]){
                $form->stretch_target =  $request->stretchTarget[$key];
            }
            if(isset($request->source) && $request->source[$key]){
                $form->source =  $request->source[$key];
            }
            if(isset($request->kpiWeightage) && $request->kpiWeightage[$key]){
                $form->kpi_weightage =  $request->kpiWeightage[$key];
            }
            $form->update();
        }



        $reviewDetails = VmtPMS_KPIFormReviewsModel::where('vmt_pms_kpiform_assigned_id',$request->kpiAssignedId)->get();
        if(count($reviewDetails) > 0){
            foreach($reviewDetails as $review){
                if($kpiAssignedDetails->assignee_id == $kpiAssignedDetails->assigner_id){
                    $arrayIsReviewAccepted = json_decode($review->is_reviewer_accepted,true);
                    if(is_array($arrayIsReviewAccepted)){
                        foreach($arrayIsReviewAccepted as $reviewerId => $isReviewer){
                            if($isReviewer == "0"){
                                $arrayIsReviewAccepted[$reviewerId] = null;
                            }
                        }
                    }
                    $review->is_reviewer_accepted = $arrayIsReviewAccepted;
                    $review->update();
                }else{
                    if($review->is_assignee_accepted == '0'){
                        $review->is_assignee_accepted = null;
                        $review->update();
                    }
                }
            }
        }
        return true;
    }

    public function changeEmployeeProfileIconsOnEdit(Request $request){
        $html = '';
        $html .= '<div class="employees-card"><div class="employees-profile">';
        $employeesList = [];
        if(isset($request->selectedEmployeesId) && count($request->selectedEmployeesId) > 0){
            $employeesList = User::whereIn('id',$request->selectedEmployeesId)->select('id','name','avatar')->get()->toArray();
            foreach($employeesList as $key => $employeeAvatar){
                if($key < 4){
                    $avatarProfilePic = \URL::asset('images/'. $employeeAvatar['avatar']);
                    $defaultProfilePic = \URL::asset('default/default_profile.jpg');
                    if(!empty($employeeAvatar['avatar']) && file_exists(public_path('images/'.$employeeAvatar['avatar']))){
                        $html .= '<img title="'. $employeeAvatar['name'] .'" src="'.$avatarProfilePic.'" alt="'. $employeeAvatar['name'] .'">';
                    }else{
                        $html .= '<img title="'. $employeeAvatar['name'] .'" src="'.$defaultProfilePic.'" alt="'.$employeeAvatar['name'] .'">';
                    }
                }
            }

            // <span class="employees-profile editProfile employeeEditButton">Edit</span>
        }
        $editSaveText = 'Add';
        if(count( $employeesList) > 0){
            if(count($employeesList) > 4){
                $html .= '<span class="employees-profile counting btn btn-orange">+ '. count($employeesList) - 4 .'</span>';
            }
            $editSaveText = 'Edit';
        }
        $html .= '<span class="employees-profile editProfile employeeEditButton btn btn-orange">'.$editSaveText.'</span>';
        return response()->json(['status'=>true,'html'=>$html]);
    }


    public function getEmployeesOfReviewer(Request $request){
        try{
// dd($request->selectedReviewer);
            if(isset($request->selectedReviewer)){
                $reviewerEmpNo = User::where('id',$request->selectedReviewer)->first()->user_code;

                if(!empty($reviewerEmpNo)){
                    $employees = User::leftJoin('vmt_employee_office_details','users.id','=','vmt_employee_office_details.user_id')
                                ->leftJoin('vmt_employee_details','users.id','=','vmt_employee_details.userid')
                                ->where('users.is_ssa','0')
                                ->where('vmt_employee_office_details.l1_manager_code',$reviewerEmpNo)
                                ->select('users.name','users.id','users.user_code','vmt_employee_office_details.designation')
                                ->get()
                                ->toArray();

                    return response()->json(['status'=>false,'message' => '','result' => $employees]);
                }
            }
            return response()->json(['status'=>false,'message' => 'Reviewer not found!']);
        }catch(Exception $e){
            return response()->json(['status'=>false,'message' => $e->getMessage()]);
        }
    }

    /**
     *  getPerformanceDashboardSummaryStats
     *  table : vmt_pms_kpiform_reviews
     *
     *
     */
    protected function getPerformanceDashboardSummaryStats(){

        //Note : We need to show the Performance stats based on current frequency(month/quarter/half-yearly/yearly)
        $current_pms_config_data = ConfigPms::first();
        //dd($current_pms_config_data);
       // dd($current_pms_config_data->assignment_period);

        //Get the current PMS config details
        $calendar_type = $current_pms_config_data->calendar_type;
        $year = "April - 2022 to March - 2023"; //Hardcoded for now
        $assignment_period = 'q3'; //Need to add this as a new option in pmsconfig


        //Dashboard vars

        //EMPLOYEE GOALS
        $totalEmployeesCount = User::where('active',1)->where('is_ssa','0')->count();

            //Get all the forms assigned for the current period
            $assignedForms_currentReviewPeriod = \DB::table('vmt_pms_kpiform_assigned')
                                    ->where('calendar_type', $calendar_type)
                                    ->where('year', $year)
                                    ->where('assignment_period', $assignment_period);

            //Get their ids only
            $assignedFormsIds_currentReviewPeriod = $assignedForms_currentReviewPeriod->pluck('id');

        $employeesGoalsSetCount_currentReviewPeriod = $assignedForms_currentReviewPeriod->count();


        ////SELF-REVIEW
        $selfReviewCount_currentReviewPeriod =  \DB::table('vmt_pms_kpiform_reviews')
                                ->whereIn('vmt_pms_kpiform_assigned_id', $assignedFormsIds_currentReviewPeriod)
                                ->where('is_assignee_submitted', '1')
                                ->count();

            //dd($selfReviewCount_currentReviewPeriod);

        ////EMPLOYEES ASSESSED

        $employeesAssessedCount_currentReviewPeriod = \DB::table('vmt_pms_kpiform_reviews')
                                ->whereIn('vmt_pms_kpiform_assigned_id', $assignedFormsIds_currentReviewPeriod)
                                ->where('is_reviewer_submitted', 'Not Like', '%null%')
                                ->count();


        ////Final Score Published(When HR review is also done)

        $finalScoreCount  =  \DB::table('vmt_pms_kpiform_reviews')
                                ->whereIn('vmt_pms_kpiform_assigned_id', $assignedFormsIds_currentReviewPeriod)
                                ->where('is_reviewer_submitted', 'Not Like', '%null%')
                                ->count();





        $totalReviewedCount = \DB::table('vmt_pms_kpiform_reviews')->count();

        $dashboardCountersData['totalEmployeesCount'] = $totalEmployeesCount;
        $dashboardCountersData['employeesGoalsSetCount'] = $employeesGoalsSetCount_currentReviewPeriod;
        $dashboardCountersData['selfReviewCount'] = $selfReviewCount_currentReviewPeriod;
        $dashboardCountersData['employeesAssessedCount'] = $employeesAssessedCount_currentReviewPeriod;
        $dashboardCountersData['totalReviewedCount'] = $totalReviewedCount;
        $dashboardCountersData['finalScoreCount'] =  $finalScoreCount;

        return $dashboardCountersData;
    }

    /*
        Revoke a manager reviewed form. It can be done by HR .

        Todo : In future, manager also can revoke the form based on end date. After that, he cant .
                This is controlled via PMS settings page.

    */
    public function revokeSubmittedForm(Request $request){
        //dd($request->all());

        $vmtAssignedFormReview = VmtPMS_KPIFormReviewsModel::where('id',$request->assigneeGoalId)->first();

        $json_values = json_decode($vmtAssignedFormReview->is_reviewer_submitted, true);

        foreach($json_values as $key => $value)
        {
            $json_values[$key] = "0";
            //dd(json_encode($json_values));
            $vmtAssignedFormReview->is_reviewer_submitted = json_encode($json_values);
            $vmtAssignedFormReview->save();
        }
        return response()->json([
            "status" => "success"
        ]);
    }

}
