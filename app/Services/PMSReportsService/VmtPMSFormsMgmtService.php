<?php

namespace App\Services\PMSReportsService;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\VmtPMS_KPIFormAssignedModel;
use App\Models\VmtPMS_KPIFormDetailsModel;
use App\Models\VmtPMS_KPIFormModel;

use function PHPSTORM_META\map;

class VmtPMSFormsMgmtService
{

    /*
        UNUSED FOR NOW !

        Get all PMS forms for all the users.

        It also needs to contains the following data:
        1. Who created the form ( vmt_pms_kpiform : author_id)
        2. To whom it is assigned (vmt_pms_kpiform_assigned :assignee_id )
        3. Which org_time_period assigned and assignment period (vmt_pms_kpiform_assigned: vmt_org_time_period_id , assignment_period)

    */
    public function getAllPMSFormTemplates(){

        try{
            $all_pms_forms = VmtPMS_KPIFormModel::leftJoin('vmt_pms_kpiform_assigned','vmt_pms_kpiform_assigned.vmt_pms_kpiform_id','=','vmt_pms_kpiform.id')
                            ->orderBy('vmt_pms_kpiform.form_name', 'asc')
                            ->get([
                                'vmt_pms_kpiform.id as pms_form_id',
                                'vmt_pms_kpiform.form_name as form_name',
                                'vmt_pms_kpiform.author_id',
                                'vmt_pms_kpiform_assigned.id as vmt_pms_kpiform_assigned_id',
                                'vmt_pms_kpiform_assigned.assignee_id',
                                'vmt_pms_kpiform_assigned.assignment_period'
                           // ])->groupBy(['form_name','pms_form_id']);
                            ])->groupBy( function($data){

                               return $data->form_name;
                             });

           // $all_pms_forms = User::get(['name','client_id'])->groupBy('client_id');

            //dd($all_pms_forms);
            return response()->json([
                "status" => "success",
                "message" => "PMS form templates fetched successfully",
                "data" =>   $all_pms_forms
            ]);
        } catch(\Exception $e){

            return response()->json([
                "status" => "failure",
                "message" => "Unable to getAllPMSFormTemplates",
                "data" => $e,
            ]);
        }
    }


    /*
        Get all the authors of all PMS forms.


    */
    public function getAllPMSFormAuthors(){
        try{
            $all_pms_forms = VmtPMS_KPIFormModel::leftJoin('users','users.id','=','vmt_pms_kpiform.author_id')
                            ->orderBy('vmt_pms_kpiform.form_name', 'asc')
                            ->get([
                                'vmt_pms_kpiform.author_id',
                                'users.name as author_name',
                                'vmt_pms_kpiform.id as pms_form_id',
                                'vmt_pms_kpiform.form_name as form_name',
                                //'vmt_pms_kpiform_assigned.id as vmt_pms_kpiform_assigned_id'
                            ])->groupBy('author_name');

           // $all_pms_forms = User::get(['name','client_id'])->groupBy('client_id');

            //for each form , check whether its assigned to any user or not
            foreach($all_pms_forms as $singleAuthorRecord){
                foreach($singleAuthorRecord as $singleFormDetail){

                    //This is used in UI to state whether the form is used in PMS review or not
                    $singleFormDetail["is_pmsform_used"] = 0 ;

                    if(! empty($singleFormDetail['pms_form_id']))
                        $singleFormDetail["is_pmsform_used"] = VmtPMS_KPIFormAssignedModel::where('vmt_pms_kpiform_id', $singleFormDetail['pms_form_id'])->exists() ? 1 : 0;

                }


            }



            //dd($all_pms_forms);
            return response()->json([
                "status" => "success",
                "message" => "PMS form authors fetched successfully",
                "data" =>   $all_pms_forms
            ]);
        } catch(\Exception $e){

            return response()->json([
                "status" => "failure",
                "message" => "Error in getAllPMSFormAuthors()",
                "data" => $e,
            ]);
        }
    }

    /*
        Get the PMS form usage details such as to whom it was
        assigned ,etc


    */
    public function getPMSFormUsageDetails($pms_form_id){

        $validator = Validator::make(
            $data = [
                "pms_form_id" => $pms_form_id
            ],
            $rules = [
                "pms_form_id" => 'required|exists:vmt_pms_kpiform,id'
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
            ]
        );

        if($validator->fails()){
            return response()->json([
                "status" => "failure",
                "message" => $validator->errors()->all()
            ]);
        }


        try{

            //Get the assigned details of the given pms_form_id

            $query_pms_form_usage = VmtPMS_KPIFormModel::join('vmt_pms_kpiform_assigned','vmt_pms_kpiform_assigned.vmt_pms_kpiform_id','=','vmt_pms_kpiform.id')
                                    ->join('vmt_org_time_period','vmt_org_time_period.id','=','vmt_pms_kpiform_assigned.vmt_org_time_period_id')
                                    ->where('vmt_pms_kpiform.id',$pms_form_id)
                                    ->get([
                                        'vmt_pms_kpiform_assigned.assignee_id',
                                        'vmt_pms_kpiform_assigned.reviewer_id',
                                        'vmt_pms_kpiform_assigned.assigner_id',
                                        'vmt_pms_kpiform_assigned.assignment_period',
                                        'vmt_pms_kpiform_assigned.vmt_org_time_period_id',

                                        'vmt_org_time_period.abbrevation',
                                        'vmt_org_time_period.start_date',
                                        'vmt_org_time_period.end_date',
                                    ]);

                                    //dd($query_pms_form_usage);
            //Set the employees names
           foreach($query_pms_form_usage as $singleRecord){

                $singleRecord["assignee_name"] = User::find($singleRecord->assignee_id)->name;
                $singleRecord["reviewer_name"] = User::find($singleRecord->reviewer_id)->name;
                $singleRecord["assigner_name"] = User::find($singleRecord->assigner_id)->name;

                //remove the unwanted attribs as it not used in UI
                unset($singleRecord->assignee_id);
                unset($singleRecord->reviewer_id);
                unset($singleRecord->assigner_id);
                unset($singleRecord->vmt_org_time_period_id);

           }

           return response()->json([
                "status" => "success",
                "message" => "",
                "data" => $query_pms_form_usage,
           ]);


        }catch(\Exception $e){
            return response()->json([
                "status" => "failure",
                "message" => "Error while fetching PMS form usage details",
                "data" => $e
            ]);
        }


    }

    /*
        Gets the PMS form details such as KPI, Weightage, Target , etc

    */
    public function getPMSFormTemplateDetails($pms_form_id){

        $validator = Validator::make(
            $data = [
                "pms_form_id" => $pms_form_id
            ],
            $rules = [
                "pms_form_id" => 'required|exists:vmt_pms_kpiform,id'
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
            ]
        );

        if($validator->fails()){
            return response()->json([
                "status" => "failure",
                "message" => $validator->errors()->all()
            ]);
        }


        try{
            $primevue_datatable_columns = array();
            $query_available_cols = VmtPMS_KPIFormModel::find($pms_form_id)->available_columns;
            $temp_available_cols_array = explode(',',$query_available_cols);

            //Generate JSON which is used for display reqd columns in PrimeVue datatable
            foreach($temp_available_cols_array as $singleColumn){
                array_push($primevue_datatable_columns,[
                    "field" => $singleColumn,
                    "header" => $this->getPMSTemplateColumnName($singleColumn)
                ]);
            }

            // dd($primevue_datatable_columns);

            //Add other required columns that has to be fetched from DB
            array_push($temp_available_cols_array,'form_name','vmt_pms_kpiform.id');

            $response = VmtPMS_KPIFormModel::join('vmt_pms_kpiform_details','vmt_pms_kpiform_details.vmt_pms_kpiform_id','=','vmt_pms_kpiform.id')
                                        ->where('vmt_pms_kpiform.id',$pms_form_id)
                                        ->get($temp_available_cols_array)->toArray();



            //Add column data for primevue table
            $response['available_columns_primevue'] = $primevue_datatable_columns;


            return response()->json([
                "status" => "success",
                "message" => "",
                "data" => $response,
            ]);


        }
        catch(\Exception $e){
            return response()->json([
                "status" => "failure",
                "message" => "Error while fetching PMS form template details",
                "data" => $e
            ]);
        }


    }

    /*
        Returns the proper table heading name for the given PMS column name

    */
    private function getPMSTemplateColumnName($column_name){
        switch ($column_name) {
            case 'dimension':
                return "Dimension";
            case 'kpi':
                return "KPI";
            case 'operational_definition':
                return "Operational Definition";
            case 'measure':
                return "Measure";
            case 'frequency':
                return "Frequency";
            case 'target':
                return "Target";
            case 'stretch_target':
                return "Stretch Target";
            case 'source':
                return "Source";
            case 'kpi_weightage':
                return "KPI Weightage";
            default:
                return "Undefined";
        }
    }

    public function getPMSTemplateDetails_AsExcel($pms_form_id){

        $validator = Validator::make(
            $data = [
                "pms_form_id" => $pms_form_id
            ],
            $rules = [
                "pms_form_id" => 'required|exists:vmt_pms_kpiform,id'
            ],
            $messages = [
                "required" => "Field :attribute is missing",
                "exists" => "Field :attribute is invalid",
            ]
        );

        if($validator->fails()){
            return response()->json([
                "status" => "failure",
                "message" => $validator->errors()->all()
            ]);
        }


        try{
            $primevue_datatable_columns = array();
            $query_available_cols = VmtPMS_KPIFormModel::find($pms_form_id)->available_columns;
            $temp_available_cols_array = explode(',',$query_available_cols);
            $headings=array();
            //Generate JSON which is used for display reqd columns in PrimeVue datatable
            foreach($temp_available_cols_array as $singleColumn){
                array_push($headings,$this->getPMSTemplateColumnName($singleColumn));
            }

            // dd($primevue_datatable_columns);



            $form_details= VmtPMS_KPIFormModel::join('vmt_pms_kpiform_details','vmt_pms_kpiform_details.vmt_pms_kpiform_id','=','vmt_pms_kpiform.id')
                                        ->where('vmt_pms_kpiform.id',$pms_form_id)
                                        ->get($temp_available_cols_array)->toArray();
            $form_name= VmtPMS_KPIFormModel::where('id',$pms_form_id)->first()->form_name;


            $response['form_name'] =$form_name;
            $response['headings']=$headings;
            $response['form_details']= $form_details;

            //Excel creation logic goes here
          // dd($response);

            return $response;


        }
        catch(\Exception $e){
            return response()->json([
                "status" => "failure",
                "message" => "Error while downloading PMS form template details",
                "data" => $e
            ]);
        }


    }

    /*
        Unused for now

    public function getAssignedPMSFormTemplates($user_code){
        //Get all forms for a given user_code
        $validator = Validator::make(
            $data = [
                'user_code' => $user_code,
            ],
            $rules = [
                'user_code' => 'required|exists:users,user_code',
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
                'exists' => 'Field :attribute is invalid',
            ]

        );

        if($validator->fails()){
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try{
            $user_id = User::where('user_code', $user_code)->first()->id;

            $emp_assignedpmsfrom=VmtPMS_KPIFormModel::join('vmt_pms_kpiform_details','vmt_pms_kpiform.id','=','vmt_pms_kpiform_details.vmt_pms_kpiform_id')
            ->join('vmt_pms_kpiform_assigned','vmt_pms_kpiform_assigned.vmt_pms_kpiform_id','=','vmt_pms_kpiform_details.vmt_pms_kpiform_id')
            ->join('users','users.id','=','vmt_pms_kpiform_assigned.assignee_id')
            ->where('vmt_pms_kpiform_assigned.assignee_id',$user_id)
            ->get(['users.user_code','users.name','vmt_pms_kpiform.form_name','vmt_pms_kpiform.id as pms_kpiform_id','vmt_pms_kpiform_assigned.year','vmt_pms_kpiform_assigned.assignment_period'])
            ->unique();

            return response()->json([
                "status" => "success",
                "message" => "PMS form templates fetched successfully",
                "data" => $emp_assignedpmsfrom,
            ]);


        }
        catch(\Exception $e){

            //dd("Error :: uploadDocument() ".$e);

            return response()->json([
                "status" => "failure",
                "message" => "Unable to fetch getProfgetEmployeePMSFormTemplate_AsExcelilePicture",
                "data" => $e,
            ]);

        }
    }
    */
    public function getPMSFormforGivenPMSFormID($pms_form_id){

        $validator = Validator::make(
            $data = [
                'pms_form_id' => $pms_form_id
            ],
            $rules = [
                'pms_form_id' =>'required'
            ],
            $messages = [
                'required' => 'Field :attribute is missing',
            ]

        );

        if($validator->fails()){
            return response()->json([
                'status' => 'failure',
                'message' => $validator->errors()->all()
            ]);
        }

        try{

            $pms_single_form = array();
            $pms_form_details = array();
            $pms_form = VmtPMS_KPIFormModel::where('id',$pms_form_id)->first();
            $available_columns =  explode(",",$pms_form['available_columns']);
            $pms_from_details_query = VmtPMS_KPIFormDetailsModel::where('vmt_pms_kpiform_id',$pms_form_id)->get(['dimension','kpi','frequency','target','kpi_weightage']);
            // foreach($pms_from_details_query as $single_record){
            //    foreach($available_columns as $single_columns ){
            //     dd($single_record['kpi_weightage']);
            //     $pms_single_form[$single_columns] = $single_record[$single_columns];
            //    }
            // //    dd($pms_single_form);
            //    array_push($pms_form_details,$pms_single_form);
            //    unset($pms_single_form);
            // }
            $response=array('form_name'=>$pms_form['form_name'],'columns'=>$available_columns,'pms_form_details'=>$pms_from_details_query);
          //dd(  $response);
            return $response;

        }
        catch(\Exception $e){

            //dd("Error :: uploadDocument() ".$e);

            return response()->json([
                "status" => "failure",
                "message" => "getPMSFormforGivenPMSFormID",
                "data" => $e,
            ]);

        }
    }

    public function getPMSScoreAvergeForGivenAssingementPeriod($year,$assignment_period){

        try{
            $manager_rewvied_pms_form = VmtPMS_KPIFormAssignedModel::join('vmt_pms_kpiform_reviews','vmt_pms_kpiform_reviews.vmt_pms_kpiform_assigned_id',
                                                                    '=','vmt_pms_kpiform_assigned.id')
                                                                    ->join('users','users.id','=','vmt_pms_kpiform_assigned.assignee_id')
                                                                    ->where('vmt_pms_kpiform_assigned.year',$year)
                                                                    ->where('vmt_pms_kpiform_assigned.assignment_period',$assignment_period)
                                                                    ->where('vmt_pms_kpiform_reviews.is_reviewer_submitted','like','%"1"}')
                                                                    ->get(['users.user_code','users.name',
                                                                    'vmt_pms_kpiform_assigned.calendar_type','vmt_pms_kpiform_assigned.year','vmt_pms_kpiform_assigned.assignment_period',
                                                                      'vmt_pms_kpiform_reviews.assignee_kpi_percentage','vmt_pms_kpiform_reviews.reviewer_kpi_percentage'])->toArray();

            $pms_avg_for_emp = array();

             foreach( $manager_rewvied_pms_form as $single_array){
                $emp_kpi_avg=0;
                $manager_kpi_avg=0;
                $emp_kpi_json= json_decode($single_array['assignee_kpi_percentage'],true);
                $manager_kpi_json = json_decode($single_array['reviewer_kpi_percentage'],true);
               foreach($emp_kpi_json as $key=>$perchantage){
                $emp_kpi_avg=  $emp_kpi_avg+$perchantage;
               }
               $single_array['assignee_kpi_percentage'] =$emp_kpi_avg;
              foreach( $manager_kpi_json as $manager_user_id=>$kpi_perchantage){
                $approver_name = User::where('id',$manager_user_id)->first('name')->name;
                foreach($kpi_perchantage as $key=>$perchantage){
                    $manager_kpi_avg =   $manager_kpi_avg+$perchantage;
                }
              }
              $single_array['approver_name']=  $approver_name;
              $single_array['reviewer_kpi_percentage'] =$manager_kpi_avg;
              array_push( $pms_avg_for_emp, $single_array);
             }
             return $pms_avg_for_emp;

        }catch(\Exception $e){

            return response()->json([
                "status" => "failure",
                "message" => "Unable to fetch getProfgetEmployeePMSFormTemplate_AsExcelilePicture",
                "data" => $e,
            ]);

        }
    }



    /*
        Get the PMS forms for the given team manager.

    */
    public function getPMSFormsList_ForTeamLevel($manager_code)
    {

    }

    /*
        Get the given PMS form based on ID

    */
    public function getPMSFormDetails($pms_form_id){

    }

    /*
        Save the entire PMS form details


    */
    public function savePMSFormDetails($pms_form_id){

    }





}
