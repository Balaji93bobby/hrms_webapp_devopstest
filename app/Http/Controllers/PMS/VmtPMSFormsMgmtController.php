<?php

namespace App\Http\Controllers\PMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\PMSReportsService\VmtPMSFormsMgmtService;
use App\Exports\PMSFormsExport;
use App\Exports\PMSScoreExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Excel as ExcelExcel;
class VmtPMSFormsMgmtController extends Controller
{

    public function getAllPMSFormAuthors(Request $request,VmtPMSFormsMgmtService $PMSFormsMgmtService){


      return  $response = $PMSFormsMgmtService->getAllPMSFormAuthors();


    }

    public function getPMSFormUsageDetails(Request $request, VmtPMSFormsMgmtService $pmsFormsMgmtService){
        return $pmsFormsMgmtService->getPMSFormUsageDetails($request->pms_form_id);
    }

    public function getPMSFormTemplateDetails(Request $request, VmtPMSFormsMgmtService $pmsFormsMgmtService){
        return $pmsFormsMgmtService->getPMSFormTemplateDetails($request->pms_form_id);
    }

    public function getEmployeePMSFormTemplate_AsExcel(Request $request,VmtPMSFormsMgmtService $PMSFormsMgmtService){
        $pms_form_id=40;

        //$response = $PMSFormsMgmtService->getPMSFormforGivenPMSFormID( $request->pms_form_id);
        $response = $PMSFormsMgmtService->getPMSTemplateDetails_AsExcel($pms_form_id);
       // dd( $response);
        $form_name = $response['form_name'];
        $headings = $response['headings'];
        $form  = $response['form_details'];
        $end_column = num2alpha(count($headings)-1);
        return Excel::download(new PMSFormsExport( $form_name,$headings,$form,$end_column),$form_name, ExcelExcel::XLSX);

    }

    public function fetchPMSFormDetails(Request $request,VmtPMSFormsMgmtService $PMSFormsMgmtService){
        $pms_form_id=40;

        $response = $PMSFormsMgmtService->getPMSFormforGivenPMSFormID( $pms_form_id);
        return $response;

    }
    public function getAssignedPMSFormTemplates(Request $request,VmtPMSFormsMgmtService $PMSFormsMgmtService){
        $response = $PMSFormsMgmtService->getAssignedPMSFormTemplates($request->user_code);
        return $response;

    }

    public function getPMSScoreAvergeForGivenAssingementPeriod(Request $request,VmtPMSFormsMgmtService $PMSFormsMgmtService){
       $year = 'April - 2022 to March - 2023';
       $assignment_period ='q4';
       $response = $PMSFormsMgmtService->getPMSScoreAvergeForGivenAssingementPeriod($year,$assignment_period);
       //dd(   $response);
       return Excel::download(new PMSScoreExport($response),  $year.' '.$assignment_period, ExcelExcel::XLSX);

    }

    public function showPMSFormsMgmtPage_SelfView(Request $request){
        return view('pms.vmt_pms_forms_mgmt_self_view');
    }


    public function showPMSFormsMgmtPage_TeamView(Request $request){
        return view('pms.vmt_pms_forms_mgmt_team_view');
    }

    public function showPMSFormsMgmtPage_HRView(Request $request){
        return view('pms.vmt_pms_forms_mgmt_hr_view');
    }

    public function showPMSFormsMgmtPage(Request $request){
        return view('pms.vmt_pms_forms_mgmt_main_view');
    }

}
