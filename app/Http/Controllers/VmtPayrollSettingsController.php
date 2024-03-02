<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VmtPayrollSettingsService;
use App\Models\VmtProfessionalTaxSettings;
use App\Models\VmtAttendanceCutoffPeriod;
use App\Models\VmtLabourWelfareFundSettings;
use App\Models\State;
class VmtPayrollSettingsController extends Controller
{
    public function getPayrollSettingsDropdownDetails(Request $request,VmtPayrollSettingsService $serviceVmtPayrollSettingsService)
    {
          //  dd($request->all());

            $response =$serviceVmtPayrollSettingsService->getPayrollSettingsDropdownDetails();

            return $response;

    }
    public function getGenralPayrollSettingsDetails(Request $request,VmtPayrollSettingsService $serviceVmtPayrollSettingsService)
    {
          //  dd($request->all());

            $response =$serviceVmtPayrollSettingsService->getGenralPayrollSettingsDetails(
                $request->record_id,
            );

            return $response;

    }
    public function saveOrUpdateGenralPayrollSettings(Request $request,VmtPayrollSettingsService $serviceVmtPayrollSettingsService)
    {
           // dd($request->all());

            $response =$serviceVmtPayrollSettingsService->saveOrUpdateGenralPayrollSettings(
                $request->record_id,
                $request->client_id,
                $request->pay_frequency_id,
                $request->payperiod_start_month,
                $request->payperiod_end_date,
                $request->payment_date,
                $request->attendance_cutoff_date,
                $request->is_attcutoff_diff_payenddate,
                $request->is_payperiod_same_att_period,
                $request->attendance_start_date,
                $request->attendance_end_date,
            );

            return $response;

    }
    public function updateGenralPayrollSettings(Request $request,VmtPayrollSettingsService $serviceVmtPayrollSettingsService)
    {
             //dd($request->all());

            $response =$serviceVmtPayrollSettingsService->updateGenralPayrollSettings(
                $request->record_id,
                $request->pay_frequency,
                $request->payperiod_start_month,
                $request->payperiod_end_date,
                $request->payment_date,
                $request->currency_type,
                $request->remuneration_type,
                $request->att_cutoff_period_id,
                $request->post_attendance_cutoff_date,
                $request->emp_attedance_cutoff_date,
                $request->paydays_in_month,
                $request->include_weekoffs,
                $request->include_holidays
            );

            return $response;

    }


    public function getAttendanceDatadropdown(Request $request)
    {
        try{

        $Attendance_cutoff_data =VmtAttendanceCutoffPeriod::get(["start_date","end_date"]);

        $response = array();
        foreach ($Attendance_cutoff_data as $key => $single_data) {

            $response[]=$single_data['start_date'] ." - ". $single_data['end_date'];
        }

        $response =([
            'status' =>"success",
            'message'=>"data fetch successfully",
            'data'=>$response
        ]);

        return $response ;

      }catch(\Exception $e){

       return $response =([
            'status' =>"success",
            'message'=>"error while fetching data successfully",
            'data'=>$e->getmessage()."  Line ".$e->getline(),
        ]);

      }
    }
    public function saveAttendanceCutoffData(Request $request,VmtPayrollSettingsService $serviceVmtPayrollSettingsService)
    {


        $response =$serviceVmtPayrollSettingsService->saveAttendanceCutoffData($request->start_date,$request->end_date);
        return $response ;

    }
    public function savePayrollFinanceSettings(Request $request,VmtPayrollSettingsService $serviceVmtPayrollSettingsService)
    {
             //dd($request->all());

            $response =$serviceVmtPayrollSettingsService->savePayrollFinanceSettings(
               $request->consider_default_rent_hra,
               $request->allow_emp_to_review_fin_info,
               $request->salary_payment_mode,
               $request->bank_information,
               $request->pf_esi_info,
               $request->pan_info,
               $request->aadhar_info,
               $request->deadline_date_for_OTR,
               $request->newjoine_inv_inout_deadline,
               $request->inv_dec_cutoff_date,
               $request->newjoinee_dec_deadline,
               $request->modify_fy_cutoff_date,
               $request->inv_decl_approval_date,
               $request->is_inv_decl_approval_needed,
               $request->can_notify_emp_inv_dec_release,
               $request->can_sendemail_emp_inv_dec,
               $request->notify_frequency,
               $request->can_release_inv_dec
            );

            return $response;

    }
    public function saveInvestmenstProofSettings(Request $request,VmtPayrollSettingsService $serviceVmtPayrollSettingsService)
    {
             //dd($request->all());

            $response =$serviceVmtPayrollSettingsService->saveInvestmenstProofSettings(
                $request->do_emp_provide_inv_proof,
                $request->is_compulsary_provide_comment,
                $request->can_emp_switch_tax_regime,
                $request->inv_schedule_date_1_enabled,
                $request->inv_schedule_date_1_value,
                $request->inv_schedule_date_2_enabled,
                $request->inv_schedule_date_2_value,
                $request->inv_schedule_date_3_enabled,
                $request->inv_schedule_date_3_value,
               $request->can_notify_emp_inv_dec_release,
               $request->can_sendemail_emp_inv_dec,
               $request->notify_frequency,
               $request->can_release_inv_proof
            );

            return $response;

    }



    public function savelwfSettings(Request $request,VmtPayrollSettingsService $serviceVmtPayrollSettingsService)
    {
             //dd($request->all());

            $response =$serviceVmtPayrollSettingsService->savelwfSettings(
                $request->state,
                $request->employees_contrib,
                $request->emplolyer_contrib,
                $request->deduction_cycle,
                $request->status,
            );

            return $response;

    }

    public function getDropdownListDetails(Request $request,VmtPayrollSettingsService $serviceVmtPayrollSettingsService){
      try{
                $drop_down_list = array();

                //     $getMonth = array();
                //         foreach (range(1, 12) as $m) {

                //         $getMonth[] = date('F', mktime(0, 0, 0, $m, 1));

                //         }
                //  $drop_down_list['months_in_year'] =$getMonth;

                //     $monthl_dates =array();
                //         for($i=1;$i<=31;$i++){
                //             $monthl_dates[]=$i;
                //         }
                // $drop_down_list['date_in_month']=$monthl_dates;

                $queryGetstate = State::select('id', 'state_name')->distinct()->get();

          $response =([
            'status' =>"success",
            'message'=>"data fetch successfully",
            'data'=>$queryGetstate
        ]);

        return $response ;

    }catch(\Exception $e){

       return $response =([
            'status' =>"success",
            'message'=>"error while fetching data successfully",
            'data'=>$e->getmessage()."  Line ".$e->getline(),
        ]);

    }
    }
}
