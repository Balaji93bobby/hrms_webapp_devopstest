<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

/*
    Handles Employees managements funcs such as,
    1. Sending password reset links to employees.
    2. Toggle mobile login for employees.

*/
class VmtEmployeeManagementController extends Controller
{

    public function index(Request $request)
    {
        $employees = User::where(['is_ssa','0'],['is_onboarded','1']);
        return view('vmt_manageEmployees',compact('employees'));
    }

}
