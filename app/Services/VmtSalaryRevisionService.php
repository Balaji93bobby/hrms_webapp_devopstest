<?php

namespace App\Services;

use App\Models\Compensatory;
use App\Models\VmtEmpSalAdvDetails;
use Illuminate\Support\Collection;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\VmtSalaryRevision;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtEmployee;
use App\Models\VmtEmployeePayroll;
use App\Models\VmtEmpActivePaygroup;
use App\Models\VmtPayrollEpfCalculation;
use App\Models\VmtPayrollComponents;
use App\Models\VmtSalaryAdvSettings;
use Carbon\Carbon;





class VmtSalaryRevisionService
{

    public function getAllEmployeeData()
    {

        try {

            $employee_data = User::where('active', '<>', '-1')->where('is_ssa', '<>', '1')->get(['id', 'name']);

            return $response = ([
                "status" => "success",
                "message" => "Data fetched successfully",
                "data" => $employee_data,
            ]);
        } catch (\Exception $e) {

            return $response = ([

                "status" => "failure",
                "message" => "error while fetch data",
                "data" => $e->getmessage(),

            ]);
        }
    }
    public function saveEmployeesSalaryRevisionDetails($user_id, $frequency, $increment_on, $percentage,$amount,$revised_amount,$arrear_calculation_type, $effective_date, $reason, $process_status,)
    {

        $validator = Validator::make(
            $data = [
                'user_id'=>$user_id,
                'frequency'=>$frequency,
                'increment_on' => $increment_on,
                'percentage' => $percentage,
                'amount' => $amount,
                'revised_amount' => $revised_amount,
                'arrear_calculation_type' =>$arrear_calculation_type,
                'effective_date' => $effective_date,
                'reason' => $reason,
                'process_status' => $process_status,

            ],
            $rules = [
                'user_id'=>'required|exists:users,id',
                'frequency'=>'required',
                'increment_on' => 'required',
                'percentage' => 'required',
                'revised_amount' => 'required',
                'amount' => 'required',
                'arrear_calculation_type' => 'required',
                'effective_date' => 'required',
                'reason' => 'nullable',
                'process_status' => 'required',

            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'numeric' => 'Field <b>:attribute</b> is invalid',
            ]
        );

        if($validator->fails()){
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try {

            $client_id = User::where('id',$user_id)->first()->client_id;
            $is_employee_exists = VmtSalaryRevision::where('user_id',$user_id)->where('client_id',$client_id)->where('effective_date',$effective_date);

            if($is_employee_exists->exists()){

                $save_sal_rev_data = $is_employee_exists->first();
                $message = "Data updated successfully";

            }else{
                $save_sal_rev_data = new VmtSalaryRevision;
                $message = "Data saved successfully";
            }

            $save_sal_rev_data->user_id = $user_id;
            $save_sal_rev_data->client_id = $client_id;
            $save_sal_rev_data->frequency = $frequency;
            $save_sal_rev_data->increment_on = $increment_on;
            $save_sal_rev_data->percentage = $percentage;
            $save_sal_rev_data->amount = $amount;
            $save_sal_rev_data->effective_date = $effective_date;
            $save_sal_rev_data->arrear_calculation_type = $arrear_calculation_type;
            $save_sal_rev_data->reason = $reason;
            $save_sal_rev_data->process_status = $process_status;
            $save_sal_rev_data->save();


            return $response = ([
                "status" => "success",
                "message" => $message,
                "data" => $save_sal_rev_data,
            ]);
        } catch (\Exception $e) {

            return $response = ([

                "status" => "failure",
                "message" => "error while save data",
                "data" => $e->getmessage(),

            ]);
        }
    }
    public function processEmployeesSalaryRevisionDetails($user_ids,$seviceVmtPayrollService)
    {

        try {

            $get_employee_revised_data= VmtSalaryRevision::where('user_id',$user_ids)->first();
           $user_id=$user_ids;
           $amount=(int)$get_employee_revised_data->amount;
           $increment_on=$get_employee_revised_data->increment_on;
           $revised_structured_details = $this->employeeSalaryRevesionCalculation($user_id, $amount ,$increment_on);

           $effective_date = Carbon::createFromFormat('Y-m-d', $get_employee_revised_data->effective_date)->format('Y-m');
           $current_month_year =  Carbon::now()->format('Y-m');
           $current_date =  Carbon::now()->format('Y-m-d');
           $revised_structured_details=array_filter($revised_structured_details);

           $replace_key_with_id = VmtPayrollComponents::whereIn('comp_identifier', array_keys($revised_structured_details))->pluck('id')->toarray();

           $revised_sal_data = array_combine($replace_key_with_id, $revised_structured_details);

           if($effective_date == $current_month_year ){

              $save_revised_structured= $seviceVmtPayrollService->saveEmployeeNewCompensatorydata($user_id, $current_date, $effective_date, $active ='1', $revised_sal_data);
           }

            return $response = ([
                "status" => "success",
                "message" => "Data saved successfully",
                "data" => $revised_structured_details,
            ]);
        } catch (\Exception $e) {

            return $response = ([

                "status" => "failure",
                "message" => "error while save data",
                "data" => $e->getmessage(),

            ]);
        }
    }

    public function employeeSalaryRevesionCalculation($user_id, $amount ,$increment_on)
    {

        try {
            $count = 0;
            $gross=0;
            $previous_sal_details = VmtEmpActivePaygroup::leftjoin('vmt_emp_paygroup_values', 'vmt_emp_paygroup_values.vmt_emp_active_paygroup_id', '=', 'vmt_emp_active_paygroups.id')->where('user_id', $user_id)->pluck('vmt_emp_paygroup_id');
            $emp_sal_components_order = VmtPayrollComponents::whereIn('id', $previous_sal_details)->orderBy('id')->orderBy('comp_order')->get(['id', 'comp_name', 'comp_order', 'comp_identifier', 'category_id','calculation_desc'])->toarray();

            $components_name = array();
            $payroll_components= VmtPayrollComponents::pluck('comp_identifier');

            foreach($payroll_components as $key=>$single_payroll_comp){

                $components_name[$single_payroll_comp] = 0;

            }
            $increment_on_comp = ['cic' => 0, 'net_income' => 0, 'gross' => 0];
            $previous_ctc = VmtEmpActivePaygroup::leftjoin('vmt_emp_paygroup_values', 'vmt_emp_paygroup_values.vmt_emp_active_paygroup_id', '=', 'vmt_emp_active_paygroups.id')
                ->leftjoin('vmt_payroll_components', 'vmt_payroll_components.id', '=', 'vmt_emp_paygroup_values.vmt_emp_paygroup_id')
                ->where('comp_identifier', $increment_on)
                ->where('vmt_emp_active_paygroups.user_id', $user_id)->first();

            $orginal_amount = (int)$previous_ctc['Value'] + $amount;
         //   dd($orginal_amount);
            $increment_on_comp[$increment_on] = $orginal_amount;

            foreach ($emp_sal_components_order as $key => $single_sal_comp) {

        //'category_id'= 1 (earnings)

                if ($single_sal_comp['category_id'] == 1 || $single_sal_comp['category_id'] == 4) {
                    $count++;
                    if ($single_sal_comp['comp_identifier'] == "basic" || $single_sal_comp['comp_identifier'] == "hra" ) {

                          $sal_components = VmtPayrollComponents::where('id', $single_sal_comp['id'])->first()->comp_calculation_json;

                         $decode_data = json_decode($sal_components);

                         foreach ($decode_data as $key => $single_comp) {

                                 if ($single_comp->comp_name =='basic' ? ($single_comp->calculation->operand ==$increment_on  &&$single_comp->active_status == '1') :$single_comp->active_status == '1' ) {

                                        if ($single_comp->comp_calculate_type == 'percentage') {

                                            $calculation_data = $single_comp->calculation;

                                            if (in_array($calculation_data->operand, array_keys($increment_on_comp)) ) {

                                                $calculation_data->operand = $increment_on_comp[$calculation_data->operand];
                                                $components_name[$single_sal_comp['comp_identifier']] =round( $calculation_data->operand);

                                            } else if (in_array($calculation_data->operand, array_keys($components_name))) {

                                                $calculation_data->operand = $components_name[$calculation_data->operand];
                                                $components_name[$single_sal_comp['comp_identifier']] = round( $calculation_data->operand);

                                            }

                                            if ($calculation_data->operator == '*') {

                                                $components_name[$single_sal_comp['comp_identifier']] = round( $components_name[$single_sal_comp['comp_identifier']] * (float)$calculation_data->value);

                                                $gross =round( $gross + $components_name[$single_sal_comp['comp_identifier']]);

                                            }
                               } else {
                                    $calculation_data = $single_comp->calculation;

                                    if (in_array($single_comp->comp_name, array_keys($components_name))) {

                                        $gross = round( $gross + (int)$calculation_data->value);
                                        $components_name[$single_sal_comp['comp_identifier']] = round( (int)$calculation_data->value);
                                }
                            }
                        }
                    }
                }
              }
            }

            $components_name['gross'] = $gross;

                $epf_calculation =VmtPayrollEpfCalculation::where('id','3')->first()->epf_calculation_json;

                $epf_decode_data = json_decode($epf_calculation);
                $epf_calculated_data=0;
                $greater_than_amount=false;

              foreach ($epf_decode_data as $key=>$single_epf_data) {

                  $operand = (gettype($single_epf_data->operand) == "integer" ||gettype($single_epf_data->operand) == "double")? $single_epf_data->operand:$components_name[$single_epf_data->operand];

                  $operator = $single_epf_data->operator;

                  switch ($operator) {
                      case ' ':
                          $epf_calculated_data = $operand;
                          break;
                      case '-':
                          $epf_calculated_data = $epf_calculated_data - $operand;
                          break;
                      case '>':
                          if ($epf_calculated_data > $operand) {
                              $greater_than_amount = true;
                          }
                          break;
                      case '*':
                          if ($greater_than_amount) {
                              $epf_calculated_data = (15000 * $operand);
                          }else{

                              $epf_calculated_data = $epf_calculated_data * $operand;
                          }
                          break;
                  }
              }
              $components_name['epf_employer_contribution']=round( $epf_calculated_data) ;
              $components_name['epf_employee_contribution']=round( $epf_calculated_data);

            if($components_name['gross'] <= '21000'){

                $components_name['esic_employer_contribution'] =round(number_format(($components_name['gross'] / 100) * 3.25,2));
                $components_name['esic_employee'] =round( (float)number_format(($components_name['gross'] / 100) * 0.75,2));


            }
            $total_amount =$components_name['gross']+$components_name['epf_employer_contribution']+$components_name['esic_employer_contribution']+ $components_name['esic_employee'];

            $components_name['net_income'] =$components_name['gross']-($components_name['epf_employee_contribution']+$components_name['esic_employee']);

            $components_name['cic'] =$components_name['gross'] + $components_name['epf_employer_contribution'] + $components_name['esic_employer_contribution'];
            $balancing_amount=$orginal_amount-$components_name['cic'] ;

              $revision_data= $this->getSalaryRevisiedEmplyeeDetails($components_name,$balancing_amount, $user_id,$orginal_amount);

              while(round($orginal_amount) != round($revision_data[ $increment_on])){

                $difference_amount=$orginal_amount-$revision_data[ $increment_on];
                $balancing_amount=$balancing_amount+$difference_amount;
                $revision_data= $this->getSalaryRevisiedEmplyeeDetails($components_name,$balancing_amount, $user_id,$orginal_amount);
              }

             foreach($revision_data as $key=>$single_key){

                $revision_data[$key] = round($single_key);

             }

                $revised_ctc = round($revision_data['cic']);
                $count++;


             if($increment_on == "gross" || $increment_on == "net_income"){

                    $recalculate_data = $this->calculate_basic($user_id, $orginal_amount ,$increment_on ='cic',$increment_amount= $revised_ctc,$revision_data);

                    return $recalculate_data;
             }else{
                    return $revision_data;
             }


        } catch (\Exception $e) {

            return $response = ([

                "status" => "failure",
                "message" => "error while fetch data",
                "data" => $e->gettrace(),

            ]);
        }
    }

    public function getSalaryRevisiedEmplyeeDetails($components_data,$balancing_amount, $user_id,$orginal_amount)
    {
        try {
            $count = 0;
            $previous_sal_details = VmtEmpActivePaygroup::leftjoin('vmt_emp_paygroup_values', 'vmt_emp_paygroup_values.vmt_emp_active_paygroup_id', '=', 'vmt_emp_active_paygroups.id')->where('user_id', $user_id)->pluck('vmt_emp_paygroup_id');
            $emp_sal_components_order = VmtPayrollComponents::whereIn('id', $previous_sal_details)->orderBy('id')->orderBy('comp_order')->get(['id', 'comp_name', 'comp_order', 'comp_identifier', 'category_id','calculation_desc'])->toarray();

            $components_name = $components_data;

           // $increment_on = 'cic';
            // $increment_on_comp = ['cic' => 0, 'net_income' => 0, 'gross' => 0];
            // $previous_ctc = VmtEmpActivePaygroup::leftjoin('vmt_emp_paygroup_values', 'vmt_emp_paygroup_values.vmt_emp_active_paygroup_id', '=', 'vmt_emp_active_paygroups.id')
            //     ->leftjoin('vmt_payroll_components', 'vmt_payroll_components.id', '=', 'vmt_emp_paygroup_values.vmt_emp_paygroup_id')
            //     ->where('comp_identifier', $increment_on)
            //     ->where('vmt_emp_active_paygroups.user_id', $user_id)->first();


            // $increment_on_comp[$increment_on] = (int)$previous_ctc['Value'] + $amount;
            // $components_name[ $increment_on] = $increment_on_comp[$increment_on];
            $total_amount =  $balancing_amount;
            $comp_value = 0;

            foreach ($emp_sal_components_order as $key => $single_sal_comp) {

        //'category_id'= 1 (earnings)

                if ($single_sal_comp['category_id'] == 1 || $single_sal_comp['category_id'] == 4) {
                    $count++;
                    if ($single_sal_comp['comp_identifier'] != "gross" && $single_sal_comp['comp_identifier'] != "cic" && $single_sal_comp['comp_identifier'] != "net_income"&& $single_sal_comp['comp_identifier'] != "basic" && $single_sal_comp['comp_identifier'] != "hra") {

                        $sal_components = VmtPayrollComponents::where('id', $single_sal_comp['id'])->first()->comp_calculation_json;

                        $decode_data = json_decode($sal_components);

                         foreach ($decode_data as $key => $single_comp) {

                                 if ($single_comp->active_status == '1') {

                                        if ($single_comp->comp_calculate_type == 'percentage') {

                                            $calculation_data = $single_comp->calculation;

                                            if (in_array($calculation_data->operand, array_keys($components_name))) {

                                                $calculation_data->operand = $components_name[$calculation_data->operand];
                                                $components_name[$single_sal_comp['comp_identifier']] = $calculation_data->operand;
                                            }

                                            if ($calculation_data->operator == '*') {

                                                $calculated_amount =  $components_name[$single_sal_comp['comp_identifier']] * (float)$calculation_data->value;

                                                if ($calculated_amount <= $total_amount){

                                                $components_name[$single_sal_comp['comp_identifier']] =  $components_name[$single_sal_comp['comp_identifier']] * (float)$calculation_data->value;
                                                $components_name['gross'] =  $components_name['gross'] + $components_name[$single_sal_comp['comp_identifier']];
                                                $total_amount =  $total_amount - $components_name[$single_sal_comp['comp_identifier']];

                                                }elseif(round($total_amount)!= 0){
                                                    $components_name[$single_sal_comp['comp_identifier']] =  $total_amount;
                                                    $comp_value = $comp_value + $total_amount;
                                                    $components_name['gross'] =  $components_name['gross'] + $total_amount;
                                                    $total_amount =  $total_amount - $components_name[$single_sal_comp['comp_identifier']];

                                                }

                                            }
                                } else {

                                    $calculation_data = $single_comp->calculation;

                                    if (in_array($single_comp->comp_name, array_keys($components_name))) {

                                        $given_value = (int)$calculation_data->value;

                                     if ($given_value <= $total_amount){

                                        $components_name['gross'] =  $components_name['gross'] + (int)$calculation_data->value;
                                        $components_name[$single_sal_comp['comp_identifier']] = (int)$calculation_data->value;
                                        $total_amount =  $total_amount - $components_name[$single_sal_comp['comp_identifier']];

                                     }elseif(round($total_amount)!= 0){

                                        $components_name[$single_sal_comp['comp_identifier']] =  $total_amount;
                                        $comp_value = $comp_value + $total_amount;
                                        $components_name['gross'] = $components_name['gross'] + $total_amount;
                                        $total_amount =  $total_amount - $components_name[$single_sal_comp['comp_identifier']];

                                    }
                                }

                          }
                        }
                    }

                  }

                }else if($single_sal_comp['category_id'] == 2){
                    // dd($components_name);
                    $sal_components = VmtPayrollComponents::where('id', $single_sal_comp['id'])->first()->comp_calculation_json;
                    if(round($total_amount) != 0){

                        $components_name['other_allowance'] = $total_amount ;
                        $components_name['gross'] = $components_name['gross'] +  $components_name['other_allowance'] ;
                        $total_amount =$total_amount - $components_name['other_allowance'];

                    };
                        $decode_data = json_decode($sal_components);
                     foreach ($decode_data as $key => $single_comp) {

                                $calculation_data = $single_comp->calculation;

                                if($single_sal_comp['calculation_desc'] == 'Rule Given'){

                                 if($single_sal_comp['comp_identifier']=='epf_employer_contribution'){
                                        $epf_calculation =VmtPayrollEpfCalculation::where('id','3')->first()->epf_calculation_json;

                                        $epf_decode_data = json_decode($epf_calculation);
                                        $epf_calculated_data=0;
                                        $greater_than_amount=false;

                                      foreach ($epf_decode_data as $key=>$single_epf_data) {

                                          $operand = (gettype($single_epf_data->operand) == "integer" ||gettype($single_epf_data->operand) == "double")? $single_epf_data->operand:$components_name[$single_epf_data->operand];
                                          $operator = $single_epf_data->operator;

                                          switch ($operator) {
                                              case ' ':
                                                  $epf_calculated_data = $operand;
                                                  break;
                                              case '-':
                                                  $epf_calculated_data = $epf_calculated_data - $operand;
                                                  break;
                                              case '>':
                                                  if ($epf_calculated_data > $operand) {
                                                      $greater_than_amount = true;
                                                  }
                                                  break;
                                              case '*':
                                                  if ($greater_than_amount) {
                                                      $epf_calculated_data = (15000 * $operand);
                                                  }else{
//dd($components_name['gross'],$components_name['hra'],$epf_calculated_data);
                                                      $epf_calculated_data = $epf_calculated_data * $operand;
                                                  }
                                                  break;
                                          }
                                      }
                                      $components_name['epf_employer_contribution']=$epf_calculated_data ;
                                      $components_name['epf_employee_contribution']=$epf_calculated_data;

                                    }


                                    if($components_name['gross'] <= '21000'){

                                        $components_name['esic_employer_contribution'] =round(number_format(($components_name['gross'] / 100) * 3.25,2));
                                        $components_name['esic_employee'] =round((float)number_format(($components_name['gross'] / 100) * 0.75,2));


                                    }

                                    $components_name['net_income'] = $components_name['epf_employee_contribution']+$components_name['esic_employee'];

                                    $components_name['cic'] =$components_name['epf_employer_contribution'] + $components_name['esic_employer_contribution'];

                        }
                    }
               }
    }


    $components_name['net_income'] = $components_name['gross'] - $components_name['net_income'];
    $components_name['cic'] = $components_name['gross']+ $components_name['cic'];


       return $components_name;

    }catch (\Exception $e) {

            return $response = ([

                "status" => "failure",
                "message" => "error while fetch data",
                "count_data" => $count,
                "data" => $e->getTrace(),

            ]);
        }
    }

    public function calculate_basic($user_id, $orginal_amount ,$increment_on,$increment_amount,$components_data)
    {

        try {

//dd($components_data);
            $count = 0;

            $previous_sal_details = VmtEmpActivePaygroup::leftjoin('vmt_emp_paygroup_values', 'vmt_emp_paygroup_values.vmt_emp_active_paygroup_id', '=', 'vmt_emp_active_paygroups.id')->where('user_id', $user_id)->pluck('vmt_emp_paygroup_id');
            $emp_sal_components_order = VmtPayrollComponents::whereIn('id', $previous_sal_details)->orderBy('id')->orderBy('comp_order')->get(['id', 'comp_name', 'comp_order', 'comp_identifier', 'category_id','calculation_desc'])->toarray();

            $components_name =$components_data;

            $gross = $orginal_amount;
            $amount = 0;

            $increment_on_comp = ['cic' => 0, 'net_income' => 0, 'gross' => 0];
            $previous_ctc = VmtEmpActivePaygroup::leftjoin('vmt_emp_paygroup_values', 'vmt_emp_paygroup_values.vmt_emp_active_paygroup_id', '=', 'vmt_emp_active_paygroups.id')
                ->leftjoin('vmt_payroll_components', 'vmt_payroll_components.id', '=', 'vmt_emp_paygroup_values.vmt_emp_paygroup_id')
                ->where('comp_identifier', $increment_on)
                ->where('vmt_emp_active_paygroups.user_id', $user_id)->first();


            $increment_on_comp[$increment_on] = $increment_amount;
           // $components_name[ $increment_on] = $increment_on_comp[$increment_on];
            $total_amount = 0;
            $balancing_amount =   $increment_on_comp[$increment_on];
            $revised_basic=$increment_amount*0.5;

      while(round($revised_basic) != $components_name['basic'] ){

            foreach ($emp_sal_components_order as $key => $single_sal_comp) {

        //'category_id'= 1 (earnings)

        if ($single_sal_comp['comp_identifier'] != "gross" && $single_sal_comp['comp_identifier'] != "cic" && $single_sal_comp['comp_identifier'] != "net_income") {

                if ($single_sal_comp['category_id'] == 1 || $single_sal_comp['category_id'] == 4) {
                    $count++;
                          $sal_components = VmtPayrollComponents::where('id', $single_sal_comp['id'])->first()->comp_calculation_json;

                         $decode_data = json_decode($sal_components);

                         foreach ($decode_data as $key => $single_comp) {

                                 if ($single_comp->comp_name =='basic' ? ($single_comp->calculation->operand ==$increment_on  &&$single_comp->active_status == '1') :$single_comp->active_status == '1' ) {

                                        if ($single_comp->comp_calculate_type == 'percentage') {

                                            $calculation_data = $single_comp->calculation;

                                            if (in_array($calculation_data->operand, array_keys($increment_on_comp)) ) {

                                                $calculation_data->operand = $increment_on_comp[$calculation_data->operand];
                                                $components_name[$single_sal_comp['comp_identifier']] =round( $calculation_data->operand);

                                            } else if (in_array($calculation_data->operand, array_keys($components_name))) {

                                                $calculation_data->operand = $components_name[$calculation_data->operand];
                                                $components_name[$single_sal_comp['comp_identifier']] = round( $calculation_data->operand);

                                            }

                                            if ($calculation_data->operator == '*') {

                                                $components_name[$single_sal_comp['comp_identifier']] = round( $components_name[$single_sal_comp['comp_identifier']] * (float)$calculation_data->value);
                                                $total_amount =$total_amount+$components_name[$single_sal_comp['comp_identifier']] ;
                                                $balancing_amount =$balancing_amount-$components_name[$single_sal_comp['comp_identifier']] ;
                                            }
                               } else {
                                    $calculation_data = $single_comp->calculation;

                                    if (in_array($single_comp->comp_name, array_keys($components_name))) {

                                        $components_name[$single_sal_comp['comp_identifier']] = round( (int)$calculation_data->value);
                                        $total_amount =$total_amount+$components_name[$single_sal_comp['comp_identifier']] ;
                                        $balancing_amount =$balancing_amount-$components_name[$single_sal_comp['comp_identifier']] ;
                                }
                            }
                        }
                     }
                   }
              }
            }
            if(round($balancing_amount) != 0){

                 $components_name['other_allowance'] = $balancing_amount ;

                $total_amount =$total_amount + $balancing_amount;

                $balancing_amount =$balancing_amount - $balancing_amount;

            };

        }
        $diffrence_gross_amount=$components_name['gross'] - $total_amount;

    if( $diffrence_gross_amount<0){

        $diffrence_gross_amount=$components_name['other_allowance']+$diffrence_gross_amount;

        if(round($diffrence_gross_amount) == 0){
            $components_name['other_allowance']=  0;
        }else{
            $components_name['other_allowance']=  0;
            $components_name['special_allowance']=  $components_name['special_allowance'] + $diffrence_gross_amount;
        }

    }else{
        $components_name['other_allowance']=  $components_name['other_allowance'] - $diffrence_gross_amount;
    }

          return $components_name;

        } catch (\Exception $e) {

            return $response = ([

                "status" => "failure",
                "message" => "error while fetch data",
                "data" => $e->getmessage(),

            ]);
        }
    }
}
