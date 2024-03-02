<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class VmtDepartmentController extends Controller
{

    public function showPage(Request $request)
    {

        $departments  =  Department::simplePaginate(2);
        return view('vmt_department', compact('departments'));
    }

    public function addDepartment(Request $request){
        $onboard_form_data =  array();
        parse_str($request->input('form_data'), $onboard_form_data);

        $response = [];

        if(! Department::where('name',$onboard_form_data['addDep_name'])->exists())
        {
            //Save to DB
            $dept = new Department;
            $dept->name =  $onboard_form_data['addDep_name'];
            $dept->email =  $onboard_form_data['addDep_email'];
            $dept->description =  $onboard_form_data['addDep_description'];
            $dept->is_active =  '1';
            $dept->save();

            $response = [
                'status' => 'success',
                'message' => 'Department added successfully',
            ];
        }
        else{
            $response = [
                'status' => 'failure',
                'message' => 'Department already exists!',
            ];
        }

        return $response;
    }
}
