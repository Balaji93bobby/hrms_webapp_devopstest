<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtClientMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Auth;

class VmtOrgTreeController extends Controller
{

    public function index()
    {
        return view('vmt_view_employee_hierarchy');
    }


    public function getLogoLevelOrgTree(Request $request)
    {
        $t_user_code = 0;

        if(Str::contains( currentLoggedInUserRole(), ["Super Admin","Admin","HR"]))
        {

            //Get the top-most node
            $topNodeUserIds = VmtEmployeeOfficeDetails::where('l1_manager_code','=','')
                                                ->orWhereNull('l1_manager_code')
                                                ->get();

            //dd($topNodeUserIds);

            $data = [];

            $loggedUserId = Auth::user()->id;

            foreach ($topNodeUserIds as $key => $value) {
                // code...
               // if($value->user_id != $loggedUserId){
                    $t_user_code = User::where('id', $value->user_id)->value('user_code');
                    $nodeObj       = $this->getUserNodeDetails($t_user_code);
                    if(count($nodeObj) > 0)
                        $data[] = $nodeObj;
               // }
            }
        }
        else{

            //Get the current node
            $t_user_code = Auth::user()->user_code;

            // fetching employee office data
            $employeeOfficeData =  VmtEmployeeOfficeDetails::where('user_id', auth::user()->id)->first();

            // checking whether employee has l1 manager or not
            if($employeeOfficeData->l1_manager_code == '' || $employeeOfficeData->l1_manager_code == null ){

                $data[]  = $this->getUserNodeDetails($t_user_code);
                $siblingNode = $this->getSiblingsForUser($t_user_code);
                if(count($siblingNode) > 0){
                    foreach ($siblingNode as $index => $value) {
                        // code...
                        $data[] = $value;
                    }
                }

            }else{
                $data[]  = $this->getUserNodeDetails($t_user_code);
            }



        }


        $client_logo = VmtClientMaster::first()->client_logo;

        if( file_exists(public_path($client_logo)) ){
            $logoSrc     = \URL::asset($client_logo);
            $logoNode  = array("image" => $logoSrc, "relationship" => "001", "user_code" => "LogoNode", "name" =>"", "className" => "logo-level", "image_exist" => true);
        }
        else{
            $client_name = \DB::table('vmt_client_master')->first()->client_name;
            $logoNode  = array("image" => "", "relationship" => "001", "user_code" => "LogoNode", "name" => $client_name, "className" => "logo-level", "image_exist"=> false);
        }


        $logoNode['collapsed'] = false;



        if(count($data) > 0)
            $logoNode['children'] = $data;
        else
            $logoNode['relationship'] =  "000";
            //$logoNode['children'] = ($data);



        return $logoNode;
    }

    public function getTwoLevelOrgTree($user_code, Request $request)
    {

        $data = $this->getUserNodeDetails($user_code);

        if($this->hasChildNodes($user_code))
            $data['children'] =$this->getChildrenForUser( $data['user_code'])['children'];

        /*
         * Grouping the node based on the department wise if department filter is set on
         * request
        */
        if(request()->get('department')){
            $childNodeObj       =  collect($data['children']);
            $db_departmentNodes =  $childNodeObj->groupBy('department')->all();
            $dArray  = [];
            // convert each db obj to node structure
            foreach($db_departmentNodes as $key => $deptNodes ){
                $j= 0;
                foreach ($deptNodes as $nodeKey => $value) {
                    // code...
                    $dArray[$j] = $value;
                    $j++;
                }
            }
            $data['children']  = $dArray;
        }

        return $data;
    }

    public function getParentForUser($user_code)
    {

    }

    public function getSiblingsForUser($user_code)
    {
        $siblingsnode_array = [];

        if($this->hasSiblingsNode($user_code))
        {
            //get the child nodes of the given parent node
            $db_childNodes = $this->fetch_siblingsForGivenUser($user_code);

            /*
             * Grouping the node based on the department wise if department filter is set on
             * request
            */
            if(request()->get('department')){

                $j = 0;

                // grouping children based on the department
                $db_departmentNodes =  $db_childNodes->groupBy('department_id')->all();
                $dArray  = [];

                foreach($db_departmentNodes as $key => $deptNodes ){
                    $depArray  = [];
                    // convert each db obj to node structure
                    foreach ($deptNodes as $value) {
                        // code...
                        $depArray[] = $this->getUserNodeDetails($value->user_code);
                    }

                    $dept  = \DB::table('vmt_department')->where('id', $key)->first();

                    if($dept){
                        $dArray[$j] = array("name" => $dept->name, "className" => "dept-level","relationship" => "111","children" => $depArray);
                    } else{
                        $dArray[$j] = array("name" => $key, "className" => "dept-level","relationship" => "111","children" => $depArray);
                    }

                    $j++;
                }
                $siblingsnode_array[]  = $dArray;
            }
            else{
                //$i = 0;
                $t_array = [];
                //Convert each db obj to node structure
                foreach($db_childNodes as $singleDBChild)
                {
                    if($singleDBChild->user_code != $user_code){
                        $nodeObject = $this->getUserNodeDetails($singleDBChild->user_code);
                        $siblingsnode_array[] = $nodeObject;
                    }
                }
                //$siblingsnode_array  = $t_array;
            }
        }

       return $siblingsnode_array;
    }

    public function getChildrenForUser($user_code){

        $childnode_array['children'] =[];

        if($this->hasChildNodes($user_code))
        {
            //get the child nodes of the given parent node
            $db_childNodes = $this->fetch_childrenForGivenUser($user_code);


            /*
             * Grouping the node based on the department wise if department filter is set on
             * request
            */
            if(request()->get('department')){

                $j = 0;

                // grouping children based on the department
                $db_departmentNodes =  $db_childNodes->groupBy('department_id')->all();
                $dArray  = [];

                foreach($db_departmentNodes as $key => $deptNodes ){
                    $depArray  = [];
                    // convert each db obj to node structure
                    foreach ($deptNodes as $value) {
                        // code...
                        $depArray[] = $this->getUserNodeDetails($value->user_code);
                    }

                    $dept  = \DB::table('vmt_department')->where('id', $key)->first();

                    if($dept){
                        $dArray[$j] = array("name" => $dept->name, "className" => "dept-level","relationship" => "111","children" => $depArray);
                    } else{
                        $dArray[$j] = array("name" => $key, "className" => "dept-level","relationship" => "111","children" => $depArray);
                    }

                    //$dArray[$j] = array("name" => $key, "className" => "dept-level","relationship" => "111","children" => $depArray);
                    $j++;
                }
                $childnode_array['children']  = $dArray;
            }
            else{
                $i = 0;
                $t_array = [];
                //Convert each db obj to node structure
                foreach($db_childNodes as $singleDBChild)
                {
                    $t_array[$i] = $this->getUserNodeDetails($singleDBChild->user_code);
                    $i++;
                }
                $childnode_array['children']  = $t_array;
            }
        }

       //dd(json_encode($data));

       return $childnode_array;
    }


    /*
         Return a tree node data for a given user_code

    */
    private function getUserNodeDetails($user_code)
    {
        $data = array();
        \Log::error($user_code);
        $t_data['relationship']=['0','0','0']; //parent,sibling,child

        //get the given node's username,designation
        $user_data = User::where('user_code',$user_code)->where('org_role','<>','1')->whereNotNull('name')->get();
        if(count($user_data) == 0){
            return $data;
        }
        $data['name'] = $user_data->value('name');
        $data['user_code'] = $user_data->value('user_code');
        $data['image'] =    asset('images/'.$user_data->value('avatar'));

        if(!file_exists(public_path('images/'. $user_data->value('avatar'))) )
            $data['image_exist'] =   false;
        else
            $data['image_exist'] =   true;

        $data['designation'] =  VmtEmployeeOfficeDetails::where('user_id',$user_data->value('id'))->value('designation');

        $data['department'] =  VmtEmployeeOfficeDetails::where('user_id',$user_data->value('id'))->value('department_id');

        ////Check if it has any parent,sibling,child nodes and relationship node

        //check parent node
        $this->hasParentNode($user_code) ? $t_data['relationship'][0]='1' : '';

        //check siblings node
        $this->hasSiblingsNode($user_code) ? $t_data['relationship'][1]='1' : '';

        //check child nodes
        $this->hasChildNodes($user_code) ? $t_data['relationship'][2]='1' : '';

        $data['relationship'] = implode($t_data['relationship']);

        return $data;
    }


    private function hasParentNode($user_code)
    {
        if(count ( $this->fetch_parentForGivenUser($user_code)) > 0)
            return true;
        else
            return false;
    }

    private function hasSiblingsNode($user_code)
    {
        if(count ( $this->fetch_siblingsForGivenUser($user_code)) > 0)
            return true;
        else
            return false;
    }

    private function hasChildNodes($user_code)
    {
        if(count ( $this->fetch_childrenForGivenUser($user_code)) > 0)
            return true;
        else
            return false;
    }

    ///// DB related methods /////

    private function fetch_childrenForGivenUser($user_code)
    {
        $children = User::leftJoin('vmt_employee_office_details','users.id','=','vmt_employee_office_details.user_id')
                            ->leftJoin('vmt_employee_details','users.id','=','vmt_employee_details.userid')
                            // ->where('users.org_role','<>','1')
                            ->where('vmt_employee_office_details.l1_manager_code',$user_code)
                            ->where('users.active','1')
                            ->select('users.name','users.id','users.user_code','vmt_employee_office_details.designation', 'vmt_employee_office_details.department_id')
                            ->get();

        return $children;
    }

    private function fetch_parentForGivenUser($user_code)
    {
        $userid = User::where('user_code',$user_code)->value('id');
        $parent_user_code = VmtEmployeeOfficeDetails::where('user_id',$userid)->value('l1_manager_code');

        $parent = User::where('user_code',$parent_user_code)->get();

        return $parent;
    }

    private function fetch_siblingsForGivenUser($user_code)
    {
        $userid = User::where('user_code', $user_code)->value('id');
        $parent_user_code = VmtEmployeeOfficeDetails::where('user_id',$userid)->value('l1_manager_code');

        $siblings = $this->fetch_childrenForGivenUser($parent_user_code);

        return $siblings;
    }


}
