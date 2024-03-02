<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VmtPayrollComponents;
use App\Models\VmtPaygroup;
use App\Models\VmtAppIntegration;
use App\Models\VmtEmpPaygroup;
use App\Models\VmtLabourWelfareFundSettings;
use App\Models\VmtProfessionalTaxSettings;
use App\Models\User;
use App\Models\VmtAttendanceCutoffPeriod;
use App\Models\VmtPaygroupComps;
use App\Services\VmtPayrollComponentsService;

class VmtPayrollComponentsController extends Controller
{
    //

    public function getPayrollEpfDetails(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
       // dd($request->all());
            $response = $serviceVmtPayrollComponentsService->getPayrollEpfDetails();

        return $response;
    }
    public function getNonPfEmployeesDetails(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
       // dd($request->all());
            $response = $serviceVmtPayrollComponentsService->getNonPfEmployeesDetails();

        return $response;
    }

    public function saveOrUpdatePayrollEpfDetails(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
       // dd($request->all());
            $response = $serviceVmtPayrollComponentsService->saveOrUpdatePayrollEpfDetails(
            $request->record_id,
            $request->client_id,
            $request->epf_number,
            $request->epf_deduction_cycle,
            $request->is_epf_policy_default,
            $request->epf_rule,
            $request->epf_contrib_type,
            $request->pro_rated_lop_status,
            $request->can_consider_salcomp_pf,
            $request->employer_contrib_in_ctc,
            $request->employer_edli_contri_in_ctc,
            $request->admin_charges_in_ctc,
            $request->override_pf_contrib_rate,
            $request->is_epf_enabled,
        );

        return $response;
    }

    public function deleteEpfEmployee(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
        $response =$serviceVmtPayrollComponentsService->deleteEpfEmployee($request->epf_id);

        return $response;

    }

    public function getPayrollEsiDetails(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
       // dd($request->all());
            $response = $serviceVmtPayrollComponentsService->getPayrollEsiDetails();

        return $response;
    }
    public function saveOrUpdatePayrollEsiDetails(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
        //  dd($request->status);

            $response = $serviceVmtPayrollComponentsService->saveOrUpdatePayrollEsiDetails(
            $request->record_id,
            $request->client_id,
            $request->esi_number,
            $request->esi_deduction_cycle,
            $request->state,
            $request->location,
            $request->employer_contribution_in_ctc,
        );

        return $response;
    }

    public function deleteEsiEmployee(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
        $response =$serviceVmtPayrollComponentsService->deleteEsiEmployee($request->esi_id);

        return $response;

    }

    public function fetchProfessionalTaxSettings(Request $request,VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
        $response =$serviceVmtPayrollComponentsService->fetchProfessionalTaxSettings();

        return $response;

    }
    public function fetchlwfSettingsDetails(Request $request,VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
        $response =$serviceVmtPayrollComponentsService->fetchlwfSettingsDetails();

        return $response;

    }

    public function saveUpdateProfessionalTaxSettings(Request $request,VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
             //dd($request->all());

            $response =$serviceVmtPayrollComponentsService->saveUpdateProfessionalTaxSettings(
                $request->client_id,
                $request->record_id,
                $request->pt_number,
                $request->state,
                $request->location,
                $request->deduction_cycle,
            );

            return $response;

    }

    public function saveUpdatelwfSettings(Request $request,VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
             //dd($request->all());

            $response =$serviceVmtPayrollComponentsService->saveUpdatelwfSettings(
                $request->client_id,
                $request->record_id,
                $request->state,
                $request->employees_contrib,
                $request->employer_contrib,
                $request->location,
                $request->lwf_number,
                $request->district,
                $request->deduction_cycle,
                $request->status,
            );

            return $response;

    }

    public function fetchPayRollComponents(Request $request  ,VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
        $response =$serviceVmtPayrollComponentsService->fetchPayRollComponents();

        return $response;
    }
    public function CreatePayRollComponents(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
        //  dd($request->all());

        $response =$serviceVmtPayrollComponentsService->CreatePayRollComponents(
            $request->comp_name,
            $request->comp_type_id,
            $request->category_id,
            $request->comp_nature_id,
            $request->calculation_method_id,
            $request->calculation_desc,
            $request->is_part_of_epf,
            $request->is_part_of_esi,
            $request->is_part_of_empsal_structure,
            $request->is_taxable,
            $request->calculate_on_prorate_basis,
            $request->can_show_inpayslip,
            $request->enabled_status

        );

        return $response;
    }
    public function UpdatePayRollEarningsComponents(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {

        $response =$serviceVmtPayrollComponentsService->UpdatePayRollEarningsComponents(
            $request->record_id,
            $request->comp_name,
            $request->comp_type_id,
            $request->category_id,
            $request->comp_nature_id,
            $request->calculation_method_id,
            $request->calculation_desc,
            $request->is_part_of_epf,
            $request->is_part_of_esi,
            $request->is_part_of_empsal_structure,
            $request->is_taxable,
            $request->calculate_on_prorate_basis,
            $request->can_show_inpayslip,
            $request->enabled_status
        );

        return $response;
    }
    public function DeletePayRollComponents(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
        $response =$serviceVmtPayrollComponentsService->DeletePayRollComponents($request->record_id);

        return $response;

    }

    // public function EnableDisableComponents(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    // {
    //     $response =$serviceVmtPayrollComponentsService->authorizeComponents($request->record_id,$request->status);

    //     return $response;
    // }

    public function AddAdhocAllowanceDetectionComp(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
        //dd($request->all());
        $response =$serviceVmtPayrollComponentsService->AddAdhocAllowanceDetectionComp(
            $request->comp_name,
            $request->category_type,
            $request->is_taxable,
            $request->is_tptax_deduc_samemonth,
            $request->is_separate_payment_allowed,
            $request->is_deduc_impacton_gross
        );
        return $response;
    }
    public function UpdateAdhocAllowanceDetectionComp(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {

        $response =$serviceVmtPayrollComponentsService->UpdateAdhocAllowanceDetectionComp(
            $request->record_id,
            $request->comp_name,
            $request->category_type,
            $request->is_taxable,
            $request->is_tptax_deduc_samemonth,
            $request->is_separate_payment_allowed,
            $request->is_deduc_impacton_gross);

        return $response;
    }
    public function AddReimbursementComponents(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
       // dd($request->all());
        $response =$serviceVmtPayrollComponentsService->AddReimbursementComponents(
            $request->comp_name,
            $request->category_id,
            $request->reimburst_max_limit,
            $request->reimburst_status);

        return $response;
    }
    public function UpdateReimbursementComponents(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
        $response =$serviceVmtPayrollComponentsService->UpdateReimbursementComponents(
        $request->record_id,
        $request->comp_name,
        $request->category_id,
        $request->reimburst_max_limit,
        $request->reimburst_status);

        return $response;
    }
    public function fetchPayrollAppIntegration(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
        $response =VmtAppIntegration::get();

        return response()->json([
                "status" => "success",
                "message" => " ",
                "data" => $response,
        ]);

    }
    public function addPayrollAppIntegrations(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
        $response =$serviceVmtPayrollComponentsService->addPayrollAppIntegrations(
        $request->accounting_soft_name,
        $request->accounting_soft_logo,
        $request->description,
        $request->status);

        return $response;
    }
    public function EnableDisableAppIntegration(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
        $response =$serviceVmtPayrollComponentsService->authorizeAppIntegration(
            $request->app_id,
            $request->status);

        return $response;
    }


    public function fetchPayGroupEmpComponents(Request $request , VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {

        $response =$serviceVmtPayrollComponentsService->fetchPayGroupEmpComponents();


        return response()->json($response);
    }

    // public function getAllDropdownFilterSetting(Request $request, VmtSalaryAdvanceService $vmtSalaryAdvanceService)
    // {

    //     return $vmtSalaryAdvanceService->getAllDropdownFilterSetting();
    // }


    // public function ShowAssignEmployeelist(Request $request, VmtPayrollComponentsService $VmtPayrollComponentsService)
    // {
    //     // dd($request->all());

    //     return $VmtPayrollComponentsService->ShowAssignEmployeelist($request->department_id, $request->designation, $request->work_location, $request->client_name);
    // }

    public function addPaygroupCompStructure(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
        // dd($request->all());
            $response = $serviceVmtPayrollComponentsService->addPaygroupCompStructure(
            $request->user_code,
            $request->client_id,
            $request->structureName,
            $request->description,
            $request->pf,
            $request->esi,
            $request->tds,
            $request->fbp,
            $request->selectedComponents,
            $request->assignedEmployees
        );

        return $response;
    }
    public function updatePaygroupCompStructure(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
         $response = $serviceVmtPayrollComponentsService->updatePaygroupCompStructure(
            $request->paygroup_id,
            $request->user_code,
            $request->client_id,
            $request->structureName,
            $request->description,
            $request->pf,
            $request->esi,
            $request->tds,
            $request->fbp,
            $request->selectedComponents,
            $request->assignedEmployees
        );

        return $response;
    }

    public function deletePaygroupComponents(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
        $response =$serviceVmtPayrollComponentsService->deletePaygroupComponents($request->paygroup_id);

        return $response;

    }


    public function CreateEmpAbryPmrpy(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
        $response =$serviceVmtPayrollComponentsService->CreateEmpAbryPmrpy(
        $request->user_id,
        $request->abry_scheme_status,
        $request->pmrpy_scheme_status
    );

        return $response;
    }
    public function removeEmpAbryPmrpy(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    {
        $response =$serviceVmtPayrollComponentsService->removeEmpAbryPmrpy(
        $request->user_id,
        $request->scheme_type,
    );

    }


    // public function ShowPaySlipTemplateMgmtPage(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    // {
    //     return $serviceVmtPayrollComponentsService->ShowPaySlipTemplateMgmtPage();
    // }
    // public function assignPaySlipTemplateToClient(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    // {
    //     return $serviceVmtPayrollComponentsService->assignPaySlipTemplateToClient();
    // }

    // public function authorizeEpfEmployee(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    // {
    //     $response =$serviceVmtPayrollComponentsService->authorizeEpfEmployee($request->epf_id,$request->status);

    //     return $response;
    // }

      // public function updatePayrollEsi( Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService){
    //     $response = $serviceVmtPayrollComponentsService->updatePayrollEsi(
    //         $request->esi_id,
    //         $request->esi_number,
    //         $request->esi_deduction_cycle,
    //         $request->state,
    //         $request->location,
    //         $request->employee_contribution_rate,
    //         $request->employer_contribution_rate,
    //         $request->employer_contribution_in_ctc,
    //         $request->status);

    //         return $response;
    // }
    // public function authorizeEsiEmployee(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    // {
    //     $response =$serviceVmtPayrollComponentsService->authorizeEsiEmployee($request->esi_id,$request->status);

    //     return $response;
    // }
    // public function assignPaySlipTemplateToClient(Request $request,  VmtPayrollComponentsService $serviceVmtPayrollComponentsService)
    // {
    //     $jsonData = ["gross"=> 10000, "operator1"=> "+", "vda"=>5000 , "operator2"=> "*", "percentage"=> 0.12];

    //     $result = 0;

    //         if($jsonData['operator1'] == '+'){
    //             $result += $jsonData["gross"];
    //         }

    //         if($jsonData['operator2'] == '*'){
    //             $result += $jsonData["vda"];
    //             $result *= $jsonData["percentage"];
    //         }
    //         dd($result);

    // }
}

