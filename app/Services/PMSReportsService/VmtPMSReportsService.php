<?php

namespace App\Services\PMSReportsService;

use Illuminate\Support\Collection;
use JSON_AssignedPMSFormDetails;
use App\Models\VmtPMS_KPIFormAssignedModel;
use App\Models\VmtPMS_KPIFormDetailsModel;
use App\Models\VmtPMS_KPIFormModel;
use App\Exports\PMSFormsExport;
use Maatwebsite\Excel\Facades\Excel;

class VmtPMSReportsService {


    /*
        Exports the given form into Excel format
    */
    public function exportExcel_PMSForm($pms_assignedFormID){
        $pms_assignedFormDetails=$this->getSelectedPMSFormDetails($pms_assignedFormID);
        //dd($pms_assignedFormDetails);
        return Excel::download(new PMSFormsExport($pms_assignedFormDetails), 'PMS Forms.xlsx');
    }


    /*
        Fetch all the assigned PMS forms for the given assignment period.

        return JSON structure
    */
    public function getAllAssignedPMSForms($calendar_type, $year, $assignment_period){

        $kpisForm = null;

        $kpisForm = VmtPMS_KPIFormAssignedModel::join('vmt_pms_kpiform','vmt_pms_kpiform.id','=','vmt_pms_kpiform_id')
                                               ->join('users','users.id','=','assignee_id')
                                               ->where('year',$year)
                                               ->select('user_code','name','vmt_pms_kpiform_id');

         if($assignment_period!="All"){
            $kpisForm= $kpisForm->where('assignment_period',$assignment_period);
         }
         $kpisForm =  $kpisForm ->get()->toArray();
        //loop thru all forms
        dd( $kpisForm);


        //end loop

        return  $kpisForm;
    }

    /*
        Get the Assigned form details for the given form id.

    */
    private function getSelectedPMSFormDetails($pms_assignedFormID){
            $pms_available_columns = explode(',',VmtPMS_KPIFormModel::where('id',$pms_assignedFormID)->value('available_columns'));
            $headings_column=array();
            foreach($pms_available_columns as $single_columns){
                   // dd($single_columns);
                    switch($single_columns){
                        case "dimension":
                            array_push($headings_column,"Dimension");
                            break;
                        case "kpi":
                            array_push($headings_column,"Kpi");
                            break;
                        case "operational_definition":
                            array_push($headings_column,"Operational");
                            break;
                        case "measure":
                            array_push($headings_column,"Measure");
                            break;
                        case "frequency":
                            array_push($headings_column,"Frequency");
                            break;
                        case "target":
                            array_push($headings_column,"Target");
                            break;
                        case "stretch_target":
                            array_push($headings_column,"Stretch Target");
                            break;
                        case "Source":
                            array_push($headings_column,"Source");
                            break;
                        case "kpi_weightage":
                            array_push($headings_column,"KPI Weightage ( % )");
                            break;
                    }
            }
            $pms_form_details = VmtPMS_KPIFormDetailsModel::where('vmt_pms_kpiform_id',$pms_assignedFormID)->get($pms_available_columns)->toArray();
            //Create JSON object for each forms
            //$temp = new JSON_AssignedPMSFormDetails($employeeName, $form_data);
            $pms_data=array($headings_column,$pms_form_details);
            return  $pms_data;
    }
}
