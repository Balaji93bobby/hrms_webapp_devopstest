<?php

namespace App\Http\Controllers\Investments;

use App\Models\Compensatory;
use App\Models\VmtEmployee;
use App\Models\VmtInvestmentForm;
use App\Models\VmtInvFormSection;
use App\Models\VmtInvEmpFormdata;
use App\Models\VmtInvFEmpAssigned;
use App\Models\VmtEmployeePayroll;
use App\Models\AbsSalaryProjection;
use App\Http\Controllers\Controller;
use App\Models\VmtOrgTimePeriod;
use App\Models\VmtPayroll;
use App\Services\VmtInvestmentsService;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VmtEmpInvRentalDetails;
use Carbon\Carbon;




class VmtInvestmentsController extends Controller
{

    public function getInvestmentsFormDetailsTemplate(Request $request, VmtInvestmentsService $serviceVmtInvestmentsService)
    {
        //  dd($request->all());

        return $serviceVmtInvestmentsService->getInvestmentsFormDetailsTemplate($request->form_name);
    }

    public function saveEmpInvSecDetails(Request $request, VmtInvestmentsService $serviceVmtInvestmentsService)
    {
        //dd($request->all());

        return $serviceVmtInvestmentsService->saveEmpInvSecDetails($request->user_code, $request->section_name, $request->section_data);
    }

    public function ImportInvestmentForm_Excel(Request $request, VmtInvestmentsService $serviceVmtInvestmentsService)
    {
        // dd($request->all());

        return $serviceVmtInvestmentsService->ImportInvestmentForm_Excel($request->form_name, $request->excel_file);
    }


    // Common Save function Saving Investment Form
    public function SaveInvDetails(Request $request)
    {
        // dd($request->all());
        $form_id = $request->form_id;
        $user_id = User::where('user_code', $request->user_code)->first()->id;
        $form_data = $request->formDataSource;
        $current_date = date("Y-m-d");


        $query_femp = VmtInvFEmpAssigned::where('user_id', $user_id);

        if ($query_femp->exists()) {
            $query_assign = $query_femp->first();
        } else {

            $emp_assign_form = new VmtInvFEmpAssigned;
            $emp_assign_form->user_id = $user_id;
            $emp_assign_form->form_id = $form_id;
            $emp_assign_form->year = $current_date;
            $emp_assign_form->is_sumbit = $request->is_submitted;

            $emp_assign_form->save();
            $query_assign = $emp_assign_form;
        }

        // dd($form_data);
        $assigned_form_user_id = VmtInvFEmpAssigned::where('user_id', $user_id)->first()->id;

        if (isset($form_data)) {

            foreach ($form_data as $singleFormData) {

                $emp_formdata = VmtInvEmpFormdata::where('f_emp_id', $assigned_form_user_id)->where('fs_id', $singleFormData['fs_id'])->first();

                if (empty($emp_formdata)) {

                    $emp_formdata = new VmtInvEmpFormdata;
                    $emp_formdata->f_emp_id = $query_assign->id;
                    $emp_formdata->fs_id = $singleFormData['fs_id'];
                    $emp_formdata->dec_amount = $singleFormData['declaration_amount'];
                    $emp_formdata->selected_section_options = $singleFormData['select_option'] ?? '';
                    //   $emp_formdata->json_popups_value = $sima ?? "none";
                    $emp_formdata->save();
                } else {

                    $emp_formdata->f_emp_id = $query_assign->id;
                    $emp_formdata->fs_id = $singleFormData['fs_id'];
                    $emp_formdata->dec_amount = $singleFormData['declaration_amount'];
                    $emp_formdata->selected_section_options = $singleFormData['select_option'] ?? '';
                    //    $emp_formdata->json_popups_value = $singleFormData['json_popups_value'];

                    //   $emp_formdata->json_popups_value = $sima ?? "none";
                    $emp_formdata->save();
                }
            }
        } else {

            $assigned_form_user_id = VmtInvFEmpAssigned::where('user_id', $user_id)->first();

            if ($assigned_form_user_id->exists()) {

                $assigned_form_user_id->is_sumbit = $request->is_submitted;
                $assigned_form_user_id->save();
            }

            return "sumbit";
        }
    }

    // Common Function For Saving All Popup In Investment Form's
    public function saveSectionPopups(Request $request)
    {
        // dd($request->all());
        $json_decodeHra = json_encode($request->all());
        $current_date = date("Y-m-d");

        // dd($json_decodeHra);

        $form_id = "1";

        $fs_id = $request->fs_id;

        // dd($fs_id);
        $user_id = User::where('user_code', $request->user_code)->first()->id;

        $query_femp = VmtInvFEmpAssigned::where('user_id', $user_id);


        if ($query_femp->exists()) {
            $query_assign = $query_femp->first();
        } else {

            $emp_assign_form = new VmtInvFEmpAssigned;
            $emp_assign_form->user_id = $user_id;
            $emp_assign_form->form_id = $form_id;
            $emp_assign_form->year = $current_date;
            $emp_assign_form->is_sumbit = $request->is_submitted;
            $emp_assign_form->save();
            $query_assign = $emp_assign_form;
        }

        if (empty($request->id)) {

            $Hra_save = new VmtInvEmpFormdata;
            $Hra_save->fs_id = $fs_id;
            $Hra_save->f_emp_id = $query_assign->id;
            $Hra_save->dec_amount = "0";
            $Hra_save->json_popups_value = $json_decodeHra;
            $Hra_save->save();
        } else {

            $assigned_form_user_id = VmtInvFEmpAssigned::where('user_id', $user_id)->first()->id;

            $emp_formdata = VmtInvEmpFormdata::where('f_emp_id', $assigned_form_user_id)->where('id', $request->id)->first();

            $emp_formdata->f_emp_id = $query_assign->id;
            $emp_formdata->fs_id = $fs_id;
            $emp_formdata->dec_amount = "0";
            $emp_formdata->json_popups_value = $json_decodeHra;

            $emp_formdata->save();
        }


        return 'saved';
    }

    // Get And Delete for HRA in Investment's Forms
    public function fetchEmpRentalDetails(Request $request, VmtInvestmentsService $serviceVmtInvestmentsService)
    {
        $user_code = $request->user_code;
        $fs_id = $request->fs_id;

        return $serviceVmtInvestmentsService->fetchEmpRentalDetails($user_code, $fs_id);
    }

    // Get And Delete for House Property in Investment's Forms
    public function fetchHousePropertyDetails(Request $request, VmtInvestmentsService $serviceVmtInvestmentsService)
    {
        $user_code = $request->user_code;
        $fs_id = $request->hop;

        return $serviceVmtInvestmentsService->fetchHousePropertyDetails($user_code, $fs_id);
    }
    public function fetchOtherExemptionDetails(Request $request, VmtInvestmentsService $serviceVmtInvestmentsService)
    {
        $user_code = $request->user_code;
        $fs_id = $request->otherExe;

        return $serviceVmtInvestmentsService->fetchHousePropertyDetails($user_code, $fs_id);
    }
    public function deleteHousePropertyDetails(Request $request, VmtInvestmentsService $serviceVmtInvestmentsService)
    {

        return $serviceVmtInvestmentsService->deleteHousePropertyDetails($request->current_table_id);
    }

    public function saveSection80(Request $request)
    {
        // dd($request->all());
        $json_decodeHra = json_encode($request->all());
        $current_date = date("Y-m-d");
        // dd($json_decodeHra);

        $form_id = "1";

        $dec_amount = $request->interest_amount_paid;

        $fs_id = $request->fs_id;

        $user_id = User::where('user_code', $request->user_code)->first()->id;

        // $form_data = $request->formDataSource;

        $query_femp = VmtInvFEmpAssigned::where('user_id', $user_id);


        if ($query_femp->exists()) {
            $query_assign = $query_femp->first();
        } else {

            $emp_assign_form = new VmtInvFEmpAssigned;
            $emp_assign_form->user_id = $user_id;
            $emp_assign_form->form_id = $form_id;
            $emp_assign_form->year = $current_date;
            $emp_assign_form->save();
            $query_assign = $emp_assign_form;
        }

        $assigned_form_user_id = VmtInvFEmpAssigned::where('user_id', $user_id)->first()->id;

        $emp_formdata = VmtInvEmpFormdata::where('f_emp_id', $assigned_form_user_id)->where('fs_id', $fs_id)->first();

        if (empty($emp_formdata)) {

            $Hra_save = new VmtInvEmpFormdata;
            $Hra_save->f_emp_id = $query_assign->id;
            $Hra_save->fs_id = $fs_id;
            $Hra_save->dec_amount = $dec_amount;
            $Hra_save->json_popups_value = $json_decodeHra;
            $Hra_save->selected_section_options = '0';
            $Hra_save->save();
        } else {
            $emp_formdata->f_emp_id = $query_assign->id;
            $emp_formdata->fs_id = $fs_id;
            $emp_formdata->dec_amount = $dec_amount;
            $emp_formdata->json_popups_value = $json_decodeHra;
            $emp_formdata->selected_section_options = '0';
            $emp_formdata->save();
        }


        return 'saved';
    }


    public function showInvestmentsFormMgmtPage(Request $request)
    {
        //dd($request->all());

        return view('investments_forms_mgmt');
    }

    public function declarationSummaryCalculation(Request $request)
    {

        $user_id = User::where('user_code', auth()->user()->user_code)->first()->id;

        // $v_form_template = VmtInvFEmpAssigned::leftjoin('vmt_inv_emp_formdata', 'vmt_inv_emp_formdata.f_emp_id', '=', 'vmt_inv_f_emp_assigned.id')
        //     ->leftjoin('vmt_inv_formsection', 'vmt_inv_emp_formdata.fs_id', '=', 'vmt_inv_formsection.id')
        //     ->leftjoin('vmt_inv_section', 'vmt_inv_section.id', '=', 'vmt_inv_formsection.section_id')
        //     ->leftjoin('vmt_inv_section_group', 'vmt_inv_section_group.id', '=', 'vmt_inv_section.sectiongroup_id')
        //    ->where('vmt_inv_f_emp_assigned.user_id',$user_id)

        $v_form_template = VmtInvFormSection::leftjoin('vmt_inv_section', 'vmt_inv_section.id', '=', 'vmt_inv_formsection.section_id')
            ->leftjoin('vmt_inv_section_group', 'vmt_inv_section_group.id', '=', 'vmt_inv_section.sectiongroup_id')
            ->leftjoin('vmt_inv_emp_formdata', 'vmt_inv_emp_formdata.fs_id', '=', 'vmt_inv_formsection.id')
            ->leftjoin('vmt_inv_f_emp_assigned', 'vmt_inv_f_emp_assigned.id', '=', 'vmt_inv_emp_formdata.f_emp_id')
            ->leftjoin('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'vmt_inv_f_emp_assigned.user_id')
            ->leftjoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'vmt_employee_compensatory_details.user_id')
            ->where('vmt_inv_f_emp_assigned.user_id', $user_id)
            ->get(
                [
                    'vmt_inv_formsection.section_id',
                    'vmt_inv_section.section',
                    'vmt_inv_section.particular',
                    'vmt_inv_section.reference',
                    'vmt_inv_section.max_amount',
                    'vmt_inv_section_group.section_group',
                    'vmt_inv_formsection.id as fs_id',
                    'vmt_inv_section.section_option_1',
                    'vmt_inv_section.section_option_2',
                    'vmt_inv_emp_formdata.dec_amount',
                    'vmt_inv_emp_formdata.json_popups_value',
                    'vmt_employee_compensatory_details.gross',
                    'vmt_employee_compensatory_details.basic',
                    'vmt_employee_compensatory_details.hra',
                    'vmt_employee_compensatory_details.special_allowance',
                    'vmt_employee_compensatory_details.professional_tax',
                    'vmt_employee_details.doj',
                ]
            )->toArray();

        // dd( $v_form_template);


        $res = array();
        $hra = array('section_name' => 'HRA', 'dec_amount' => 0, 'proof_submitted' => 0, 'amount_rejected' => 0, 'amount_accepted' => 0);
        $section80 = array('section_name' => 'Section 80C & 80CC', 'dec_amount' => 0, 'proof_submitted' => 0, 'amount_rejected' => 0, 'amount_accepted' => 0);
        $otherExemption = array('section_name' => 'Other Excemptions', 'dec_amount' => 0, 'proof_submitted' => 0, 'amount_rejected' => 0, 'amount_accepted' => 0);
        $houseProperty = array('section_name' => 'House Properties', 'dec_amount' => 0, 'proof_submitted' => 0, 'amount_rejected' => 0, 'amount_accepted' => 0);
        $reimbersument = array('section_name' => 'Reimbersument', 'dec_amount' => 0, 'proof_submitted' => 0, 'amount_rejected' => 0, 'amount_accepted' => 0);
        $previousEmployerIncome = array('section_name' => 'Previous Employer Income', 'dec_amount' => 0, 'proof_submitted' => 0, 'amount_rejected' => 0, 'amount_accepted' => 0);
        $otherSourceIncome = array('section_name' => 'Other Source Of  Income', 'dec_amount' => 0, 'proof_submitted' => 0, 'amount_rejected' => 0, 'amount_accepted' => 0);

        $sumOfSec = 0;
        $sumOfHra = 0;
        $sumOfotherExemption = 0;
        $sumOfHouseProperty = 0;
        $sumOfReimbersument = 0;
        $sumOfPreviousEmployerIncome = 0;
        $sumOfOtherSourceIncome = 0;
        $totalSumOfExemption = 0;
        $sumOfOtherExemptionDec = 0;
        $chapterexe = 0;


        foreach ($v_form_template as $dec_amt) {
            //dd( $dec_amt);
            $empGeneralInfo['gross'] = $dec_amt['gross'];
            $empGeneralInfo['basic'] = $dec_amt['basic'];
            $empGeneralInfo['hra'] = $dec_amt['hra'];
            $empGeneralInfo['special_allowance'] = $dec_amt['special_allowance'];
            $empGeneralInfo['professional_tax'] = $dec_amt['professional_tax'];
            $empGeneralInfo['doj'] = $dec_amt['doj'];

            // dd($empGeneralInfo);


            if ($dec_amt['section_group'] == "HRA") {
                // dd($dec_amt['section_group'] == "HRA");
                $hraTotalRent = (json_decode($dec_amt["json_popups_value"], true));
                $sumOfHra += $hraTotalRent['total_rent_paid'];
                $totalSumOfExemption += $hraTotalRent['total_rent_paid'];
                $hra['section_name'] = $dec_amt['section_group'];
                $hra['dec_amount'] = $sumOfHra;
                $hra['proof_submitted'] = 0;
                $hra['amount_rejected'] = 0;
                $hra['amount_accepted'] = $sumOfHra;
            }

            $empBasic = $dec_amt['basic'] * 12;

            $hraexamtions = intval($sumOfHra) - intval($empBasic * 10 / 100);


            if ($dec_amt['section_group'] == "Section 80C & 80CC ") {

                $sumOfSec += $dec_amt['dec_amount'];
                $totalSumOfExemption += $dec_amt['dec_amount'];
                $section80['section_name'] = $dec_amt['section_group'];
                $section80['dec_amount'] = $sumOfSec;
                $section80['proof_submitted'] = 0;
                if ($sumOfSec > 150000) {
                    $section80['amount_rejected'] = 150000 - $sumOfSec;
                } else {
                    $section80['amount_rejected'] = 0;
                }
                if ($sumOfSec > 150000) {
                    $section80['amount_accepted'] = $sumOfSec - abs(150000 - $sumOfSec);
                } else {
                    $section80['amount_accepted'] = $sumOfSec;
                }
            }
            if ($dec_amt['section_group'] == "Other Excemptions ") {
                $sumOfOtherExemptionDec += $dec_amt['max_amount'];
                $sumOfotherExemption += $dec_amt['dec_amount'];
                $totalSumOfExemption += $dec_amt['dec_amount'];
                $otherExemption['section_name'] = $dec_amt['section_group'];
                $otherExemption['dec_amount'] = $sumOfotherExemption;
                $otherExemption['proof_submitted'] = 0;

                if ($dec_amt['max_amount'] == 0) {
                    $chapterexe += $dec_amt['dec_amount'];
                }

                if ($dec_amt['dec_amount'] > $dec_amt['max_amount']) {
                    $chapterexe += $dec_amt['max_amount'];
                }
                if ($dec_amt['dec_amount'] < $dec_amt['max_amount']) {
                    $chapterexe += $dec_amt['dec_amount'];
                }

                $otherExemption['amount_accepted'] = $chapterexe;

                $otherExemption['amount_rejected'] = $chapterexe - $sumOfotherExemption;



                // if ($sumOfotherExemption > $sumOfOtherExemptionDec) {
                //     $otherExemption['amount_rejected'] = $sumOfOtherExemptionDec - $sumOfotherExemption;
                // } else {
                //     $otherExemption['amount_rejected'] = 0;
                // }
                // if ($sumOfotherExemption > $sumOfOtherExemptionDec) {
                //     $otherExemption['amount_accepted'] = $sumOfOtherExemptionDec - $sumOfotherExemption;
                // } else {
                //     $otherExemption['amount_accepted'] = 0;
                // }
            }
            if ($dec_amt['section_group'] == "House Properties ") {
                $totalIntersetPaid = (json_decode($dec_amt["json_popups_value"], true));
                $sumOfHouseProperty += $totalIntersetPaid["income_loss"];
                $houseProperty['section_name'] = $dec_amt['section_group'];
                $houseProperty['dec_amount'] = $sumOfHouseProperty;
                $houseProperty['proof_submitted'] = 0;
                $houseProperty['amount_rejected'] = 0;

                if ($sumOfHouseProperty > 200000) {
                    $houseProperty['amount_accepted'] = 200000;
                } else {
                    $houseProperty['amount_accepted'] = $sumOfHouseProperty;
                }
                if ($sumOfHouseProperty > 200000) {
                    $houseProperty['amount_rejected'] = 200000 - $sumOfHouseProperty;
                } else {
                    $houseProperty['amount_rejected'] = 0;
                }
            }
            if ($dec_amt['section_group'] == "Reimbersument ") {
                $sumOfReimbersument += $dec_amt['dec_amount'];
                $totalSumOfExemption += $dec_amt['dec_amount'];
                $reimbersument['section_name'] = $dec_amt['section_group'];
                $reimbersument['dec_amount'] = $sumOfReimbersument;
                $reimbersument['proof_submitted'] = 0;
                $reimbersument['amount_rejected'] = 0;
                $reimbersument['amount_accepted'] = $sumOfReimbersument;
            }
            if ($dec_amt['section_group'] == "Previous Employer Income") {
                $sumOfPreviousEmployerIncome += $dec_amt['dec_amount'];
                $totalSumOfExemption += $dec_amt['dec_amount'];
                $previousEmployerIncome['section_name'] = $dec_amt['section_group'];
                $previousEmployerIncome['dec_amount'] = $sumOfPreviousEmployerIncome;
                $previousEmployerIncome['proof_submitted'] = 0;
                $previousEmployerIncome['amount_rejected'] = 0;
                $previousEmployerIncome['amount_accepted'] = $sumOfPreviousEmployerIncome;
            }

            if ($dec_amt['section_group'] == "Other Source Of  Income") {
                $sumOfOtherSourceIncome += $dec_amt['dec_amount'];
                $totalSumOfExemption += $dec_amt['dec_amount'];
                $otherSourceIncome['section_name'] = $dec_amt['section_group'];
                $otherSourceIncome['dec_amount'] = $sumOfOtherSourceIncome;
                $otherSourceIncome['proof_submitted'] = 0;
                $otherSourceIncome['amount_rejected'] = 0;
                $otherSourceIncome['amount_accepted'] = $sumOfOtherSourceIncome;
            }
        }
        // dd($sumOfOtherExemptionDec);
        //dd($hra);
        // array_push($res,$section80,$otherExemption,$houseProperty,$reimbersument ,$previousEmployerIncome,$otherSourceIncome);
        array_push(
            $res,
            $hra,
            $section80,
            $houseProperty,
            $otherExemption,
            $reimbersument,
            $previousEmployerIncome,
            $otherSourceIncome,
        );

        return $res;
    }

    public function subChargeCalculation($total_income)
    {

        if ($total_income >= 5000000 && $total_income < 10000000) {
            $subcharge = $total_income * 10 / 100;
            return $subcharge;
        } else if ($total_income >= 10000000 && $total_income < 20000000) {
            $subcharge = $total_income * 15 / 100;
            return $subcharge;
        } else if ($total_income >= 20000000 && $total_income < 50000000) {
            $subcharge = $total_income * 25 / 100;
            return $subcharge;
        } else if ($total_income > 50000000) {
            $subcharge = $total_income * 37 / 100;
            return $subcharge;
        }
    }

    public function oldRegimeTaxCalculation($regime, $age, $total_income)
    {

        if ($regime == "old") {
            if ($age < 60) {
                if ($total_income <= 250000) {
                    return $taxable_amt = 0;
                } else if ($total_income > 250000 && $total_income <= 500000) {
                    $deduction = $total_income - 250000;
                    $taxable_amount = $deduction * 5 / 100;
                    $total_amount = round($taxable_amount + 12500);
                    $heath_and_education = $total_amount * 4 / 100;
                    $final_value = $total_amount + $heath_and_education;
                    return $final_value;
                } else if ($total_income > 500000 && $total_income <= 1000000) {
                    $deduction = $total_income - 500000;
                    $taxable_amount = $deduction * 20 / 100;
                    $total_amount = round($taxable_amount + 12500);
                    $heath_and_education = $taxable_amount * 4 / 100;
                    $final_value = $total_amount + $heath_and_education;
                    return $final_value;
                } else if ($total_income > 1000000) {
                    $subcharge = '';
                    $heath_and_education = 0;
                    $deduction = $total_income - 1000000;
                    $taxable_amount = $deduction * 30 / 100;
                    $total_amount = round($taxable_amount + 112500);
                    $subcharge = $this->subChargeCalculation($total_income);

                    if ($subcharge) {
                        $heath_and_education = ($taxable_amount + $subcharge) * 4 / 100;
                        $final_value = ($total_amount) + ($subcharge) + ($heath_and_education);
                        return round($final_value);
                    } else {
                        $heath_and_education = $total_amount * 4 / 100;
                        $final_value = $total_amount + $heath_and_education;
                        return round($final_value);
                    }
                } else {
                    return $total_income;
                }
            } else if ($age >= 60 && $age <= 80) {
                if ($total_income > 300000 && $total_income <= 500000) {
                    $deduction = $total_income - 300000;
                    $taxable_amount = $deduction * 5 / 100;
                    $heath_and_education = $taxable_amount * 4 / 100;
                    $final_value = round($taxable_amount + $heath_and_education);
                    return $final_value;
                } else
                    if ($total_income > 500000 && $total_income < 1000000) {
                    // 5% (tax rebate u/s 87A is available)
                    $deduction = $total_income - 500000;
                    $taxable_amount = $deduction * 20 / 100;
                    $heath_and_education = $taxable_amount * 4 / 100;
                    $final_value = round($taxable_amount + 10000 + $heath_and_education);
                    return $final_value;
                } else if ($total_income > 1000000) {
                    $deduction = $total_income - 1000000;
                    $taxable_amount = $deduction * 30 / 100;
                    $total_amount = floor($taxable_amount + 110000);
                    $subcharge = $this->subChargeCalculation($total_income);
                    $heath_and_education = ($taxable_amount + $subcharge) * 4 / 100;
                    $final_value = $total_amount + $subcharge + $heath_and_education;
                    return $final_value;
                } else {

                    return $total_income;
                }
            } else if ($age > 80) {

                if ($total_income > 500000 && $total_income <= 1000000) {
                    $deduction = $total_income - 500000;
                    $taxable_amount = $deduction * 20 / 100;
                } else
                    if ($total_income > 1000000) {
                    $deduction = $total_income - 1000000;
                    $taxable_amount = $deduction * 30 / 100;
                    $total_amount = floor($taxable_amount + 112500);
                    $subcharge = $this->subChargeCalculation($total_income);
                    $heath_and_education = ($taxable_amount + $subcharge) * 4 / 100;
                    $final_value = $total_amount + $subcharge + $heath_and_education;

                    return $final_value;
                } else {
                    return $total_income;
                }
            }
        }
    }


    public function newRegimeTaxCalculation($regime, $total_income)
    {

        if ($regime == 'new') {
            // Employeer Income Is Greater than 300000 and Less Than  600000
            if ($total_income > 300000 && $total_income <= 600000) {
                $taxable_amount = ($total_income - 300000) * 5 / 100;
                $total_amount = round($taxable_amount);
                $subcharge = $this->subChargeCalculation($total_income);
                $heath_and_education = $subcharge ? ($total_amount + $subcharge) * 4 / 100 : $total_amount * 4 / 100;
                $final_value = $total_amount + $subcharge + $heath_and_education;
                return round($final_value);
            } else
                // Employeer Income Is Greater than 600000 and Less Than  900000
                if ($total_income > 600000 && $total_income <= 900000) {
                    $taxable_amount = ($total_income - 600000) * 10 / 100;
                    $total_amount = round($taxable_amount + 15000);
                    $subcharge = $this->subChargeCalculation($total_income);
                    $heath_and_education = $subcharge ? ($total_amount + $subcharge) * 4 / 100 : $total_amount * 4 / 100;
                    $final_value = $total_amount + $subcharge + $heath_and_education;
                    return round($final_value);
                } else
                    // Employeer Income Is Greater than 900000 and Less Than  1200000
                    if ($total_income > 900000 && $total_income <= 1200000) {
                        $taxable_amount = ($total_income - 900000) * 15 / 100;
                        $total_amount = floor($taxable_amount + 45000);
                        $subcharge = $this->subChargeCalculation($total_income);
                        $heath_and_education = $subcharge ? ($total_amount + $subcharge) * 4 / 100 : $total_amount * 4 / 100;
                        $final_value = $total_amount + $subcharge + $heath_and_education;
                        return floor($final_value);
                    } else
                        // Employeer Income Is Greater than 1200000 and Less Than  1500000
                        if ($total_income > 1200000 && $total_income < 1500000) {
                            $taxable_amount = ($total_income - 1200000) * 20 / 100;
                            $total_amount = floor($taxable_amount + 90000);
                            $subcharge = $this->subChargeCalculation($total_income);
                            $heath_and_education = $subcharge ? ($total_amount + $subcharge) * 4 / 100 : $total_amount * 4 / 100;
                            $final_value = $total_amount + $subcharge + $heath_and_education;
                            return floor($final_value);
                        } else
                            // Employeer Income Is Greater than 1500000
                            if ($total_income > 1500000) {

                                $taxable_amount = ($total_income - 1500000) * 30 / 100;
                                $total_amount = floor($taxable_amount + 150000);
                                $subcharge = $this->subChargeCalculation($total_income);
                                $heath_and_education = $subcharge ? ($total_amount + $subcharge) * 4 / 100 : $total_amount * 4 / 100;
                                $final_value = $total_amount + $subcharge + $heath_and_education;
                                return floor($final_value);
                            }
        }
    }


    public function taxDeclaration()
    {

        $user_id = User::where('user_code', auth()->user()->user_code)->first();

        $v_form_template = VmtInvFormSection::leftjoin('vmt_inv_section', 'vmt_inv_section.id', '=', 'vmt_inv_formsection.section_id')
            ->leftjoin('vmt_inv_section_group', 'vmt_inv_section_group.id', '=', 'vmt_inv_section.sectiongroup_id')
            ->leftjoin('vmt_inv_emp_formdata', 'vmt_inv_emp_formdata.fs_id', '=', 'vmt_inv_formsection.id')
            ->leftjoin('vmt_inv_f_emp_assigned', 'vmt_inv_f_emp_assigned.id', '=', 'vmt_inv_emp_formdata.f_emp_id')
            ->leftjoin('vmt_employee_compensatory_details', 'vmt_employee_compensatory_details.user_id', '=', 'vmt_inv_f_emp_assigned.user_id')
            ->leftjoin('vmt_employee_details', 'vmt_employee_details.userid', '=', 'vmt_employee_compensatory_details.user_id')
            ->where('vmt_inv_f_emp_assigned.user_id', $user_id->id)
            ->get(
                [
                    'vmt_inv_section_group.section_group',
                    'vmt_inv_section.particular',
                    'vmt_inv_section.max_amount',
                    'vmt_inv_emp_formdata.dec_amount',
                    'vmt_inv_emp_formdata.json_popups_value',
                    'vmt_employee_compensatory_details.gross',
                    'vmt_employee_compensatory_details.basic',
                    'vmt_inv_f_emp_assigned.regime',
                    'vmt_inv_f_emp_assigned.updated_at',
                    'vmt_employee_compensatory_details.hra',
                    'vmt_employee_compensatory_details.special_allowance',
                    'vmt_employee_compensatory_details.professional_tax',
                    'vmt_employee_compensatory_details.child_education_allowance',
                    'vmt_employee_compensatory_details.lta',
                    'vmt_employee_details.doj',
                    'vmt_employee_details.dob',
                ]
            )->toArray();

        // dd($v_form_template);



        $res = array();
        $total_gross = array('sno' => 'a', 'section' => 'Total Gross Income', 'old_regime' => 0, 'new_regime' => 0);
        $Other_Source = array('sno' => 'b', 'section' => 'Other Source of Income', 'old_regime' => 0, 'new_regime' => 0);
        $pre_emp_income = array('sno' => 'c', 'Add: Previous Employer Income ', 'old_regime' => 0, 'new_regime' => 0);
        $Reimbursement = array('sno' => 'd', 'section' => 'Reimbursement Exemptions', 'old_regime' => 0, 'new_regime' => 0);
        $allowance_tax = array('sno' => 'e', 'section' => 'Allowance Exemptions (Sec 10)', 'old_regime' => 0, 'new_regime' => 0);
        $tax_section_16 = array('sno' => 'f', 'section' => 'Less: Deductions under section 16', 'old_regime' => 0, 'new_regime' => 0);
        $tax_on_emp = array('sno' => 'g', 'section' => 'Tax on Employment (Sec 16)', 'old_regime' => 0, 'new_regime' => 0);
        $exemption = array('sno' => 'h', 'section' => 'Exemptions under Sec 80', 'old_regime' => 0, 'new_regime' => 0);
        $total_tax_income = array('sno' => 'i', 'section' => 'Total Taxable Income', 'old_regime' => 0, 'new_regime' => 0);
        $total_tax_laibilty = array('sno' => 'j', 'section' => 'Total Tax Laibility', 'old_regime' => 0, 'new_regime' => 0);

        $sumOfHradeclared = 0;
        $sumOfReimbersument = 0;
        $sumOfOtherSourceOfIncome = 0;
        $chapter80s = 0;
        $sumof80s = 0;
        $standardDeducation = 0;
        $professional_tax = 0;
        $perviousEmployeeProfessionalTax = 0;
        $sumOfpreviousempincome = 0;
        $ExemptionsUnder80s = 0;
        $SumOfHousPropsInNew = 0;
        $SumOfHousPropsInOld = 0;
        $tax_calc_new_redime = 0;
        $otherAllowance = 0;
        $sumOfOtherExemptionDec = 0;
        $sumOfOtherExemptionMax = 0;
        $chapterexe = 0;
        $old_regime_tax = 0;
        $new_regime_tax = 0;
        $inv_stantard_deduction = 0;
        $inv_previous_emp_pt = 0;
        $sumofletout = 0;

        // $payroll_month = carbon::now()->format('Y-m-d');

        $payroll_month = carbon::parse("2023-04-01");


        foreach ($v_form_template as $dec_amt) {

            $perviousEmployeeProfessionalTax = 1000;

            $current_year = date('Y'); // Get Current Year
            $dob = date_parse($dec_amt['dob']); // Employeer Dob
            $year = $dob["year"];
            $empAge = ($current_year - $year);


            $totalIntersetPaid = (json_decode($dec_amt["json_popups_value"], true));
            $hraTotalRent = (json_decode($dec_amt["json_popups_value"], true));
            // $empHra = $dec_amt['hra'] * 12;
            $empBasic = $dec_amt['basic'] * 12;

            $hraexamtions = intval($sumOfHradeclared) - intval($empBasic * 10 / 100);

            if ($dec_amt['section_group'] == "HRA") {
                $sumOfHradeclared += $hraTotalRent['total_rent_paid'];
                // $totalSumOfExemption += $hraTotalRent['total_rent_paid'];
            }

            if ($dec_amt['section_group'] == "Section 80C & 80CC ") {
                $sumof80s += $dec_amt['dec_amount'];

                if ($sumof80s > 150000) {
                    $chapter80s = 150000;
                } else {
                    $chapter80s = $sumof80s;
                }
            }

            if ($dec_amt['section_group'] == "Other Excemptions ") {

                if ($dec_amt['max_amount'] == 0) {
                    $chapterexe += $dec_amt['dec_amount'];
                }

                if ($dec_amt['dec_amount'] > $dec_amt['max_amount']) {
                    $chapterexe += $dec_amt['max_amount'];
                }
                if ($dec_amt['dec_amount'] < $dec_amt['max_amount']) {
                    $chapterexe += $dec_amt['dec_amount'];
                }
            }

            if ($dec_amt['section_group'] == "Reimbersument ") {
                $sumOfReimbersument += $dec_amt['dec_amount'];
                // $ExemptionsUnder80s += $dec_amt['dec_amount'];
            }

            if ($dec_amt['section_group'] == "Previous Employer Income") {
                $sumOfpreviousempincome += $dec_amt['dec_amount'];

                if ($dec_amt['particular'] == "Previous Employer Standard Deduction") {
                    $inv_stantard_deduction = $dec_amt['dec_amount'];
                }

                if ($dec_amt['particular'] == "Previous Employer PT") {
                    $inv_previous_emp_pt = $dec_amt['dec_amount'];
                }
            }

            if ($dec_amt['section_group'] == "Other Source Of  Income") {
                $sumOfOtherSourceOfIncome = $dec_amt['dec_amount'];
                // $ExemptionsUnder80s += $dec_amt['dec_amount'];
            }

            $standardDeduction = $dec_amt['gross'];

            // dd( $standardDeduction);

            if ($standardDeduction >= 50000) {
                $standardDeducation = 50000;
            } else {
                $standardDeducation = intval($dec_amt['gross']);
            }

            $previous_standard = $standardDeducation + $inv_stantard_deduction;

            if ($previous_standard >= 50000) {
                $final_standard = 50000;
            } else {
                $final_standard = $previous_standard;
            }

            if ($dec_amt['professional_tax'] >= 2500) {
                $professional_tax = 2500;
            } else {
                // $professional_tax = intval($dec_amt['professional_tax']) + $perviousEmployeeProfessionalTax;
                $professional_tax = 2500;
            }

            if ($professional_tax + $inv_previous_emp_pt >= 2500) {
                $final_emp_pt = 2500;
            } else {
                $final_emp_pt = $professional_tax + $inv_previous_emp_pt;
            }

            // Compare standard deduction and pervious standard deduction
            //  50,000

            // Calculate Total Sum Of Declaration Amount

            // $ExemptionsUnder80s += $dec_amt['dec_amount'];

            if ($dec_amt['section_group'] == "House Properties ") {
                $SumOfHousPropsInOld += $totalIntersetPaid['income_loss'];
                if ($totalIntersetPaid['property_type'] == "Let Out Property") {
                    $SumOfHousPropsInNew = $totalIntersetPaid['income_loss'];
                    $tax_calc_new_redime += $totalIntersetPaid['income_loss'];
                }
            }

            if ($tax_calc_new_redime > 200000) {
                $sumofletout = 200000;
            } else if (-200000 > $tax_calc_new_redime) {
                $sumofletout = -200000;
            } else {
                $sumofletout = $tax_calc_new_redime;
            }


            if ($SumOfHousPropsInOld > 200000) {
                $sumofhouseproperty = 200000;
            } else if (-200000 > $SumOfHousPropsInOld) {
                $sumofhouseproperty = -200000;
            } else {
                $sumofhouseproperty = $SumOfHousPropsInOld;
            }

           $annual_gross =  $this->annual_projection($payroll_month, $user_id->id, $user_id->client_id)['Annual Gross Salary'];

        //    dd($annual_gross);

            // sum pervious employee gross with actual gross
            $total_gross['sno'] = "a";
            $total_gross['section'] = "Total Gross Salary";
            $total_gross['old_regime'] = $annual_gross;
            $total_gross['new_regime'] = $annual_gross;



            $Other_Source['sno'] = "b";
            $Other_Source['section'] = "Add: Other Source of Income";
            $Other_Source['old_regime'] = $sumOfOtherSourceOfIncome;
            $Other_Source['new_regime'] = $sumOfOtherSourceOfIncome;


            $pre_emp_income['sno'] = "c";
            $pre_emp_income['section'] = "Add: Previous Employer Income ";
            $pre_emp_income['old_regime'] = $sumOfpreviousempincome;
            $pre_emp_income['new_regime'] = $sumOfpreviousempincome;

            $Reimbursement['sno'] = "d";
            $Reimbursement['section'] = "Less: Reimbursement Exemptions";
            $Reimbursement['old_regime'] = $sumOfReimbersument;
            $Reimbursement['new_regime'] = $sumOfReimbersument;

            $sumofsection10 = intval($hraexamtions) + intval($dec_amt['child_education_allowance']) * 12;

            $allowance_tax['sno'] = "e";
            $allowance_tax['section'] = "Less: Allowances to the extent exempt under section 10";
            $allowance_tax['old_regime'] = $sumofsection10;
            $allowance_tax['new_regime'] = 0;

            $sumofSec16 = $final_standard + $final_emp_pt;

            $tax_section_16['sno'] = "f";
            $tax_section_16['section'] = "Less: Deductions under section 16";
            // Sum Previous Employer Standard Deduction  and Previous Employer PT
            $tax_section_16['old_regime'] = $sumofSec16;
            $tax_section_16['new_regime'] = $final_standard;


            // Values in negative
            $tax_on_emp['sno'] = "g";
            $tax_on_emp['section'] = "Add: Income or loss from house property (Section 24)";
            $tax_on_emp['old_regime'] = $sumofhouseproperty;
            $tax_on_emp['new_regime'] = $sumofletout;

            $sumofchap6a = $chapter80s + $chapterexe;

            $exemption['sno'] = "h";
            $exemption['section'] = "Less: Deduction under Chapter VI-A";
            $exemption['old_regime'] = $sumofchap6a;
            $exemption['new_regime'] = 0;

            $total_tax_income['sno'] = "i";
            $total_tax_income['section'] = "Total Taxable Income";
            $total_old_tax = $annual_gross + $sumOfOtherSourceOfIncome + $sumOfpreviousempincome - ($sumOfReimbersument + $sumofsection10 + $sumofSec16 + $sumofchap6a) + $sumofhouseproperty;
            $total_tax_income['old_regime'] = $total_old_tax;
            $total_new_tax = $annual_gross + $sumOfOtherSourceOfIncome + $sumOfpreviousempincome - ($sumOfReimbersument + 0 + $final_standard + 0) + $sumofletout;
            $total_tax_income['new_regime'] = $total_new_tax;


            $total_tax_laibilty['sno'] = "j";
            $total_tax_laibilty['section'] = "Total Tax Laibility";
            $total_tax_laibilty['old_regime'] = $this->oldRegimeTaxCalculation("old", $empAge, $total_old_tax);
            $total_tax_laibilty['new_regime'] = $this->newRegimeTaxCalculation("new", $total_new_tax);
            $total_tax_laibilty['age'] = $empAge;
            $total_tax_laibilty['regime'] = $dec_amt['regime'];
            $total_tax_laibilty['last_updated'] = $dec_amt['updated_at'];
        }



        array_push(
            $res,
            $total_gross,
            $Other_Source,
            $pre_emp_income,
            $Reimbursement,
            $allowance_tax,
            $tax_section_16,
            $tax_on_emp,
            $exemption,
            $total_tax_income,
            $total_tax_laibilty,


        );

        return ($res);
    }

    public function saveEmpTaxRegime(Request $request)
    {

        $user_id = User::where('user_code', auth()->user()->user_code)->first()->id;

        $query_femp = VmtInvFEmpAssigned::where('user_id', $user_id);


        if ($query_femp->exists()) {
            $query_assign = $query_femp->first();
            $query_assign->regime = $request->regime;
            $query_assign->save();
        }
        return "Saved";
    }

    public function monthTaxDashboard(Request $request)
    {

        $time_period = VmtOrgTimePeriod::where('status', '1')->first();
        $start_date =  Carbon::parse($time_period->start_date)->subMonth();
        $diff_months =  $start_date->diffInMonths(Carbon::now());

        $res = [];
        for ($i = 1; $i < $diff_months; $i++) {
            $sima  = $start_date->addMonths()->format('Y-m-d');
            array_push($res, $sima);
        }

        $payroll_details  =  VmtPayroll::join('vmt_emp_payroll', 'vmt_emp_payroll.payroll_id', '=', 'vmt_payroll.id')
            ->join('vmt_employee_payslip_v2', 'vmt_employee_payslip_v2.emp_payroll_id', '=', 'vmt_emp_payroll.id')
            ->where('user_id', auth()->user()->id)->whereIn('payroll_date', $res)
            // ->toSql();
            ->get()->toArray();
        // dd($payroll_details);

        $single = 0;
        foreach ($payroll_details as $single_details) {
            $single += $single_details['income_tax'];
        }

        $tax_deduction =  $this->taxDeclaration();
        $tax_calc_income_old = ($tax_deduction[9]['old_regime']);
        $tax_calc_income_old = ($tax_deduction[9]['new_regime']);

        $emp_assign = VmtInvFEmpAssigned::where('user_id', auth()->user()->id)->first();

        if ($emp_assign) {

            if ($emp_assign->regime == "old" || $emp_assign->regime == "") {
                $tax_calc_income_old = ($tax_deduction[9]['old_regime']);
            } else if ($emp_assign->regime == "new") {
                $tax_calc_income_old = ($tax_deduction[9]['new_regime']);
            }
        } else {
            $tax_calc_income_old = 0;
        }

        // dd($tax_calc_income_old);

        $taxcalculation['Tax Paid Till Now'] = $single;
        $taxcalculation['Total Tax Payable'] = $tax_calc_income_old;
        $taxcalculation['Remaining Tax Amount'] = $tax_calc_income_old - $single;

        //  return ($taxcalculation);


        $time_period = VmtOrgTimePeriod::where('status', '1')->first();
        $start_date = Carbon::parse($time_period->start_date);
        $end_date = Carbon::parse($time_period->end_date);
        $current_date = Carbon::now();

        $month_cal_previous = 0;
        $month_cal_next = 0;
        $res1 = array();
        $simm = [];
        while ($start_date->lte($end_date)) {
            $start_date = Carbon::parse($start_date)->addMonth();

            $dates = Carbon::parse($start_date)->submonth()->format('M Y');

            if ($start_date->lte($current_date)) {

                $payroll_details  =  VmtPayroll::join('vmt_emp_payroll', 'vmt_emp_payroll.payroll_id', '=', 'vmt_payroll.id')
                    ->join('vmt_employee_payslip_v2', 'vmt_employee_payslip_v2.emp_payroll_id', '=', 'vmt_emp_payroll.id')
                    ->where('user_id', auth()->user()->id)->whereIn('payroll_date', $res)
                    ->get()->toArray();

                foreach ($payroll_details as $single_payroll_details) {
                    $monthy_tax = (int)$single_payroll_details['income_tax'];
                    $simm[$dates] = $monthy_tax;
                    $month_cal_previous += $monthy_tax;
                }
            } else {

                $remainder_months  = ($current_date)->diffInMonths($end_date);
                $add_months_remainders =  $remainder_months + 1;
                $monthy_tax = $taxcalculation['Remaining Tax Amount'] / $add_months_remainders;
                $simm[$dates] = $monthy_tax;
                $month_cal_next += $monthy_tax;
                $month_cal = $month_cal_next - $month_cal_previous;
            }

            array_push($res1, $simm);
        }

        $res1[11]['Total'] = $month_cal;
        $mos['date'] = $res1[11];
        $mos['taxcalculation'] = $taxcalculation;

        return $mos;
    }


    public function monthTaxDeductionDetails(Request $request, VmtInvestmentsService $serviceVmtInvestmentsService)
    {
        //  dd($request->all());

        return $serviceVmtInvestmentsService->monthTaxDeductionDetails();
    }


    public function grossEarningsFromEmployment(Request $request, VmtInvestmentsService $serviceVmtInvestmentsService)
    {
        //  dd($request->all());

        return $serviceVmtInvestmentsService->grossEarningsFromEmployment();
    }

    public function taxableIncomeFromAllHeads(Request $request, VmtInvestmentsService $serviceVmtInvestmentsService)
    {
        //  dd($request->all());

        return $serviceVmtInvestmentsService->taxableIncomeFromAllHeads();
    }


    public function annual_projection($payroll_month,$user_id,$client_id){

        $reportsdata = array();

        // $inv_emp = VmtInvFEmpAssigned::where()->pluck('user_id')->toArray();

        $Employee_details = User::join('vmt_employee_details', 'vmt_employee_details.userid', '=', 'users.id')
            ->leftjoin('vmt_employee_statutory_details', 'vmt_employee_statutory_details.user_id', '=', 'users.id')
            ->where("users.active", "1")
            ->where("users.client_id", $client_id)
            ->where('users.id', $user_id)
            ->get([
                'users.id as user_id',
                'users.user_code as Employee Code',
                'users.name as Employee Name',
                'vmt_employee_details.gender as Gender',
                'vmt_employee_details.pan_number as PAN Number',
                'vmt_employee_details.dob as Date Of Birth',
                'vmt_employee_details.doj as Date Of Joining',
                'vmt_employee_statutory_details.tax_regime as Tax Regime'
            ]);

     $employee_salary_details = array();

        foreach ($Employee_details as $key => $single_user) {
            $payroll_date = VmtPayroll::where('payroll_date',  $payroll_month)->where('client_id', $client_id)->first();

            if (!empty($payroll_date)) {
                $emp_payroll = VmtEmployeePayroll::where('payroll_id', $payroll_date->id)->where('user_id', $single_user['user_id']);
            }

            if ($emp_payroll->exists()) {
                 $emp_payroll =$emp_payroll->first();
                 $employee_projected_salary = AbsSalaryProjection::where('vmt_emp_payroll_id', $emp_payroll->id);
            }


            if ($employee_projected_salary->exists()) {
                $employee_salary_details["Arrears"] = $employee_projected_salary->sum('basic_arrear')+ $employee_projected_salary->sum('dearness_allowance_arrear') + $employee_projected_salary->sum('vda_arrear') + $employee_projected_salary->sum('hra_arrear')+$employee_projected_salary->sum('hra_arrear') +
                                                            $employee_projected_salary->sum('child_edu_allowance_arrear') + $employee_projected_salary->sum('earned_stats_arrear') + $employee_projected_salary->sum('medical_allowance_arrear')
                                                            +$employee_projected_salary->sum('communication_allowance_arrear')  + $employee_projected_salary->sum('food_allowance_arrear') + $employee_projected_salary->sum('lta_arrear') + $employee_projected_salary->sum('spl_alw_arrear') + $employee_projected_salary->sum('other_allowance_arrear')
                                                            + $employee_projected_salary->sum('washing_allowance_arrear') + $employee_projected_salary->sum('uniform_allowance_arrear') + $employee_projected_salary->sum('vehicle_reimbursement_arrear') +$employee_projected_salary->sum('driver_salary_arrear');

                $employee_salary_details["Annual Gross Salary"] =$employee_projected_salary->sum('earned_basic') + $employee_projected_salary->sum('dearness_allowance_earned') + $employee_projected_salary->sum('vda_earned')
                                                                     +$employee_projected_salary->sum('earned_hra') +$employee_projected_salary->sum('earned_child_edu_allowance') + $employee_projected_salary->sum('medical_allowance_earned')
                                                                     + $employee_projected_salary->sum('communication_allowance_earned')+ $employee_projected_salary->sum('earned_lta') +$employee_projected_salary->sum('food_allowance_earned')
                                                                     +$employee_projected_salary->sum('earned_spl_alw')+$employee_projected_salary->sum('other_allowance_earned')+$employee_projected_salary->sum('washing_allowance_earned')+
                                                                     $employee_projected_salary->sum('uniform_allowance_earned');
            }
        }
        return ($employee_salary_details);
    }

}
