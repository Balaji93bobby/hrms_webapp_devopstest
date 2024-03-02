<?php

namespace App\Http\Controllers;
use App\Models\VmtPayrollCompTypes;
use App\Models\VmtPayrollCompCategory;
use App\Models\VmtPayrollCompNature;
use App\Models\VmtPayrollCalculatiomMethod;
use App\Models\VmtPayrollComponents;
use App\Imports\VmtFinancialComponents;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class VmtImportPayrollComponentsController extends Controller
{
    //
    public function saveComponentsUploadPage(){

        return view('vmt__PayrollComponents_Upload');

    }

    // public function importFinancialComponentsExcelData(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|file|mimes:xls,xlsx'
    //     ]);

    //     $importDataArry = \Excel::toArray(new VmtFinancialComponents, request()->file('file'));

    //     return $this->storeBulkFinComponentsPayslips($importDataArry);

    // }
    public function storeBulkFinComponentsPayslips(Request $request)
    {

        $data= $request->all();
        $modified_data=array();

        foreach ($data  as $key => $excelRowdata) {
            $trimmedArray = array_map('trim', array_keys($excelRowdata));

            $processed_data = str_replace(' ', '_', $trimmedArray);

            $Emp_data = array_combine(array_map('strtolower', $processed_data), array_values($excelRowdata));

            array_push($modified_data, $Emp_data);
        }

        $comp_data=$modified_data;

        ini_set('max_execution_time', 300);
        //For output jsonresponse
        $data_array = [];
        //For validation
        $isAllRecordsValid = true;

        $rules = [];
        $responseJSON = [
            'status' => 'none',
            'message' => 'none',
            'data' => [],
        ];

        // $excelRowdata = $data[0][0];
        $excelRowdata_row = $comp_data;

        $currentRowInExcel = 0;
$i=array_keys($excelRowdata_row);

      foreach ($excelRowdata_row as $key => $excelRowdata) {

            $currentRowInExcel++;

            $rules = [
                 'component_name'=>'nullable',
                 'componant_type'=>'nullable',
                 'component_nature'=>'nullable',
                 'category'=>'nullable',
                 'calculation_method'=>'nullable',
                 'calculation_desc'=>'nullable',
                 'taxability'=>'nullable',
                 'is_part_of_epf'=>'nullable',
                 'is_part_of_esi'=>'nullable',
                 'is_part_of_pt'=>'nullable',
                 'is_part_of_lwf'=>'nullable',
                 'comp_calculation_json'=>'nullable',
                 'status'=>'nullable',
                 'is_part_of_empsal_structure'=>'nullable',
                 'is_taxable'=>'nullable',
                 'calculate_on_prorate_basis'=>'nullable',
                 'can_show_inpayslip'=>'nullable',
                 'is_default'=>'nullable',



            ];

            $messages = [
                            'required' => 'Field <b>:attribute</b> is required',
                            'exists' => 'Column <b>:attribute</b> with value <b>:input</b> doesnt not exist',
            ];

            $validator = Validator::make($excelRowdata, $rules, $messages);

            if (!$validator->passes()) {

                $rowDataValidationResult = [
                    'row_number' => $currentRowInExcel,
                    'status' => 'failure',
                    'error_fields' => json_encode($validator->errors()),
                ];

                array_push($data_array, $rowDataValidationResult);

                $isAllRecordsValid = false;
            }


        } //for loop

        //Runs only if all excel records are valid
        if ($isAllRecordsValid) {
            foreach ($excelRowdata_row  as $key => $excelRowdata) {
                $rowdata_response = $this->storeSingle_Components($excelRowdata);

                array_push($data_array, $rowdata_response);
            }
         if($rowdata_response['status']=='success'){

                $responseJSON['status'] = 'success';
                $responseJSON['message'] = "Excelsheet data import success";
                $responseJSON['data'] = $data_array;


         }else if($rowdata_response['status']=='SUCCESS'){
            $responseJSON['status'] = 'success';
            $responseJSON['message'] = "Given data is already added";
            $responseJSON['data'] = $data_array;
         }
         else{
            $responseJSON['status'] = 'failure';
            $responseJSON['message'] = 'error while uploading excel sheet';
            $responseJSON['data'] = $data_array;
         }
        } else {
            $responseJSON['status'] = 'failure';
            $responseJSON['message'] = "Please fix the below excelsheet data";
            $responseJSON['data'] = $data_array;
        }

        //dd($responseJSON);

        //$data = ['success'=> $returnsuccessMsg, 'failed'=> $returnfailedMsg, 'failure_json' => $failureJSON, 'success_count'=> $addedCount, 'failed_count'=> $failedCount];
        return response()->json($responseJSON);
    }


    private function storeSingle_Components($row)
    {

        try{

            $comp_calculation_array=[
                'basic'=>[["comp_name"=>"basic","comp_calculate_type"=>"percentage","active_status"=> 0,'calculation'=>["operand"=>'gross',"operator"=>'*',"value"=>"0.5"]],
                          ["comp_name"=>"basic","comp_calculate_type"=>"percentage","active_status"=> 1,'calculation'=>["operand"=>'cic',"operator"=>'*',"value"=>"0.5"]]],

                'overtime'=>[["comp_name"=>"overtime","comp_calculate_type"=>"percentage","active_status"=> 1,'calculation'=>["operand"=>'gross',"operator"=>'/',"operand_1"=>'Month_days',"operator_1"=>'/',"operand_2"=>'8',"operator_2"=>'*',"operand_3"=>'over_time_hours',"operator_3"=>'*']],
                          ["comp_name"=>"overtime","comp_calculate_type"=>"percentage","active_status"=> 0,'calculation'=>["operand"=>'ctc',"operator"=>'*',"value"=>"0.5"]]],

                'hra'=>[["comp_name"=>"hra","comp_calculate_type"=>"percentage","active_status"=> 1,'calculation'=>["operand"=>'basic',"operator"=>'*',"value"=>"0.5"]]],

                'lta'=>[["comp_name"=>"lta","comp_calculate_type"=>"percentage","active_status"=> 1,'calculation'=>["operand"=>'basic',"operator"=>'*',"value"=>"0.1"]]],

                'vehicle_reimbursement'=>[["comp_name"=>"vehicle_reimbursement","comp_calculate_type"=>"percentage","active_status"=> 1,'calculation'=>["operand"=>'basic',"operator"=>'*',"value"=>"2400"]]],

                'driver_salary'=>[["comp_name"=>"driver_salary","comp_calculate_type"=>"percentage","active_status"=> 1,'calculation'=>["operand"=>'basic',"operator"=>'*',"value"=>"900"]]],

                'fuel_reimbursement'=>[["comp_name"=>"fuel_reimbursement","comp_calculate_type"=>"percentage","active_status"=> 1,'calculation'=>["operand"=>'basic',"operator"=>'*',"value"=>"3000"]]],

                'child_education_allowance'=>[["comp_name"=>"child_education_allowance","comp_calculate_type"=>"amount","active_status"=> 1,'calculation'=>["operand"=>'',"operator"=>'',"value"=>"200"]]],

                'communication_allowance'=>[["comp_name"=>"communication_allowance","comp_calculate_type"=>"amount","active_status"=> 1,'calculation'=>["operand"=>'',"operator"=>'',"value"=>"3000"]]],

                'Statutory_bonus'=>[["comp_name"=>"Statutory_bonus","comp_calculate_type"=>"percentage","active_status"=> 1,'calculation'=>["operand"=>'basic',"operator"=>'>',"value"=>"21000"]]],

                'food_allowance'=>[["comp_name"=>"food_allowance","comp_calculate_type"=>"amount","active_status"=> 1,'calculation'=>["operand"=>'',"operator"=>'',"value"=>"2200"]]],

                'mw_table'=>[["comp_name"=>"","comp_calculate_type"=>"mw_table","active_status"=> 1,'calculation'=>["operand"=>'',"operator"=>'',"value"=>"0"]]],

                'open_amount'=>[["comp_name"=>"","comp_calculate_type"=>"open_amount","active_status"=> 1,'calculation'=>["operand"=>'',"operator"=>'',"value"=>"0"]]],

                'from_table'=>[["comp_name"=>"","comp_calculate_type"=>"from_table","active_status"=> 1,'calculation'=>["operand"=>'',"operator"=>'',"value"=>"0"]]],

                'rule_given'=>[["comp_name"=>"","comp_calculate_type"=>"rule_given","active_status"=> 1,'calculation'=>["operand"=>'',"operator"=>'',"value"=>"0"]]],

            ];

        //     $paygroup_components =VmtPayrollComponents::first('comp_calculation_json');
        // $data= json_decode($paygroup_components);

        // $data=

            $component_type =VmtPayrollCompTypes::where('name',strtolower($row["componant_type"]))->first();
            $paygroup_components =VmtPayrollComponents::where('comp_name',$row["component_name"])->where('comp_type_id',$component_type->id)->first();
        //    $comp_identifier = strtolower(str_replace(" ","_", $row["component_name"]));
            if(empty($paygroup_components)){
                $fin_components = new VmtPayrollComponents;
                $fin_components->comp_name =$row["component_name"];
                $fin_components->comp_type_id =  $component_type->id;
                $component_nature =VmtPayrollCompNature::where('name',strtolower($row["component_nature"]))->first();
                $fin_components->comp_nature_id =$component_nature->id;
                $component_category =VmtPayrollCompCategory::where('name',strtolower($row["category"]))->first();
                $fin_components->category_id =$component_category->id;
                $calculation_method_id =VmtPayrollCalculatiomMethod::where('name',strtolower($row["calculation_method"]))->first();
                $fin_components->calculation_method_id =$calculation_method_id->id;
                $fin_components->calculation_desc = $row["calculation_desc"];
                if($row['comp_calculation_json'] =='mw_table'||$row['comp_calculation_json'] =='open_amount'||$row['comp_calculation_json'] =='from_table'||$row['comp_calculation_json'] =='rule_given'){
                    $comp_calculation_array[$row['comp_calculation_json']][0]['comp_name'] =$row['comp_identifier'];
                    $fin_components->comp_calculation_json =json_encode($comp_calculation_array[$row['comp_calculation_json']]);
                }else{
                    $fin_components->comp_calculation_json =json_encode($comp_calculation_array[$row['comp_calculation_json']]);
                }
                $fin_components->comp_identifier =$row['comp_identifier'];
                $fin_components->is_part_of_epf =$row["is_part_of_epf"];
                $fin_components->is_part_of_esi =$row["is_part_of_esi"];
                $fin_components->is_part_of_pt =$row["is_part_of_pt"];
                $fin_components->is_part_of_lwf =$row["is_part_of_lwf"];
                $fin_components->comp_order =$row["comp_order"];
                $fin_components->is_deduc_impacton_gross =$row["impact_on_gross"];
                $fin_components->is_part_of_empsal_structure =$row["is_part_of_empsal_structure"];
                $fin_components->is_taxable =$row["is_taxable"];
                $fin_components->calculate_on_prorate_basis =$row["calculate_on_prorate_basis"];
                $fin_components->can_show_inpayslip =$row["can_show_inpayslip"];
                $fin_components->enabled_status =$row["status"];
                $fin_components->is_default =$row["is_default"];
                $fin_components->save();


            return $rowdata_response = [

                'status' => 'success',
                'error_fields' => [],
            ];
        }else{
            return $rowdata_response = [

                'status' => 'SUCCESS',
                'message'=>'given data is already added',
                'error_fields' => [],
            ];
        }
        } catch (\Exception $e) {
            //$this->deleteUser($user->id);

            //dd("For Usercode : ".$row['emp_no']."  -----  ".$e);
            return $rowdata_response = [
                'row_number' => '',
                'status' => 'failure',
                'error_fields' => json_encode(['error' =>$e->getMessage()]),
                'stack_trace' => $e->getTraceAsString()
            ];
        }
    }
}
