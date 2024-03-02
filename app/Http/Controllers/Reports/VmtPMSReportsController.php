<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConfigPms;
use App\Models\User;
use App\Models\VmtPMS_KPIFormAssignedModel;
use App\Models\VmtPMS_KPIFormReviewsModel;
use App\Services\PMSReportsService\VmtPMSReportsService;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VmtPmsReviewsReport;

class VmtPMSReportsController extends Controller
{



    public function showPMSFormsDownloadPage(Request $request){
        $query_configPms= ConfigPms::first(['calendar_type','frequency']);
        $query_years= VmtPMS_KPIFormAssignedModel::groupby('year')->pluck('year');
        return view('reports.pms_reports.vmt_pmsforms_page',compact('query_configPms','query_years'));
    }

    /*
        Get assignment_period Based On given Year
    */

    public function fetchAssignmentPeriodForGivenYear(Request $request){

        $query_assignment_period=VmtPMS_KPIFormAssignedModel::where('year',$request->year)->groupby('assignment_period')->pluck('assignment_period');

        return  $query_assignment_period;
    }

    /*
        Download the selected PMS form as excelsheet
    */
    public function downloadPMSForm(Request $request,VmtPMSReportsService $pmsReportsService){
               //For Testing Purpose
               //dd(1);
               $pms_assignedFormID=2;
               return $pmsReportsService->exportExcel_PMSForm($pms_assignedFormID);

    }

    /*
        Fetch all the assigned PMS forms for the given assignment period.
    */
    public function fetchAllAssignedPMSForms(Request $request, VmtPMSReportsService $pmsReportsService){

        $status = "failure";
        $message = "";
        // $calendar_type = $request->calendar_type;
        // $year = $request->year;
        // $assignment_period = $request->assignment_period;

        //For Testing Purpose
        $year='April - 2022 to March - 2023';
        $assignment_period='q2';
        $calendar_type=null;
       // dd($year);
        //call the service method
        $output = $pmsReportsService->getAllAssignedPMSForms($calendar_type, $year, $assignment_period);

        return $responseJSON = [
            'status' => $status,
            'message' => $message,
            'data' => $output,
        ];

    }

    public function showPmsReviewsReportPage(Request $request){
        $query_configPms= ConfigPms::first(['calendar_type','frequency']);
        $query_years= VmtPMS_KPIFormAssignedModel::groupby('year')->pluck('year');
        $username=User::groupby('id')->pluck('name','id');
        $username=json_decode($username, true);

        //dd($query_years);
        //dd($query_years->value('year'));
        return view('reports.pms_reports.vmt_showPmsReviewsReports', compact('query_configPms','query_years','username'));

    }

    public function filterPmsReport(Request $request){
        //dd($request->reviewed_status);
       $query_pms_data=VmtPMS_KPIFormReviewsModel::
       leftJoin('users','users.id', '=','vmt_pms_kpiform_reviews.assignee_id')
       ->leftJoin('vmt_pms_kpiform_assigned','vmt_pms_kpiform_assigned.id', '=', 'vmt_pms_kpiform_reviews.vmt_pms_kpiform_assigned_id')
       ->where('vmt_pms_kpiform_assigned.year','=',$request->year)
       //->orWhere('vmt_pms_kpiform_assigned.assignment_period','=',$request->assignment_period)
       ->select(
                 'users.user_code',
                 'users.name',
                 'vmt_pms_kpiform_assigned.calendar_type',
                 'vmt_pms_kpiform_assigned.year',
                 'vmt_pms_kpiform_assigned.frequency',
                 'vmt_pms_kpiform_assigned.assignment_period',
                 'vmt_pms_kpiform_reviews.is_assignee_submitted',
                  //'vmt_pms_kpiform_reviews.is_reviewer_accepted', //For Manager name
                  'vmt_pms_kpiform_reviews.is_reviewer_submitted',
                );
      //dd($query_pms_data);
       if($request->assignment_period!="All"){
           $query_pms_data= $query_pms_data-> where('vmt_pms_kpiform_assigned.assignment_period','=',$request->assignment_period);
       }
       if($request->submission_status=="1"){

           $query_pms_data= $query_pms_data-> where('vmt_pms_kpiform_reviews.is_assignee_submitted','=',1);
       }else if($request->submission_status==""){
           $query_pms_data= $query_pms_data-> where('vmt_pms_kpiform_reviews.is_assignee_submitted','=',null);
       }
       if($request->reviewed_status=="1"){
           $query_pms_data= $query_pms_data-> where('vmt_pms_kpiform_reviews.is_reviewer_submitted','like','%"1"}');
       }else if($request->reviewed_status==""){
           $query_pms_data= $query_pms_data-> where('vmt_pms_kpiform_reviews.is_reviewer_submitted','not like','%"1"}');
       }

       if (session('client_id') != '1') {
           $query_pms_data= $query_pms_data-> where('users.client_id', session('client_id'));
           //return ($payroll_data);
       }

       return $query_pms_data->get();
   }

   public function generatePmsReviewsReports(Request $request){
        //$filename = 'PmsReports_'.$request->calender_type.'.xlsx';
        //dd($request->all());

        return Excel::download(new VmtPmsReviewsReport($request->calender_type,
                                                    $request->year,
                                                    $request->assignment_period,
                                                    $request->is_assignee_submitted,
                                                    $request->is_reviewer_accepted,
                                                    $request->getHttpHost()
                                                    ), 'Pms Reports.xlsx');

    }

}
