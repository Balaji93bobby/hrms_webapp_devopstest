<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\State;
use App\Models\User;

use Illuminate\Http\Request;
/*
    This controller fetches some basic details
    from DB such as Country, states..

*/
class VmtDBDataController extends Controller
{
    public function getCountryDetails(){
        return Countries::all();
    }

    public function getStatesDetails(){
        return State::all();
    }

    public function getAllEmployees(Request $request)
    {
        $emp_name= User::all();
        return response()->json($emp_name);
    }

}
