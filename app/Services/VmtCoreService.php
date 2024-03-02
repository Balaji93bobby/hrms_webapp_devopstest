<?php

namespace App\Services;

use App\Models\VmtReimbursementVehicleType;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\VmtClientMaster;
use App\Models\VmtEmployeeReimbursements;
use App\Models\VmtOrgTimePeriod;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class VmtCoreService
{


    public function getOrgTimePeriod()
    {

        $response = VmtOrgTimePeriod::all();
        foreach ($response as $single_year) {
            $start_date = Carbon::parse($single_year->start_date);
            $end_date = Carbon::parse($single_year->end_date);
            $single_year->year = $start_date->clone()->format('M') . '-' . $start_date->clone()->format('Y') . ' - ' . $end_date->clone()->format('M') . '-' .  $end_date->clone()->format('Y');
        }

        return [
            "status" => "success",
            "message" => "",
            "data" => $response,
        ];
    }

    public function getAllClients()
    {
        if (VmtClientMaster::where('client_fullname', 'All')->exists()) {
            $clients_list = VmtClientMaster::whereNotIn('client_fullname', ['All'])->get();
        } else {
            $clients_list = VmtClientMaster::all();
        }
        return response()->json([
            "status" => "success",
            "message" => "clinets list fetched sccessfully",
            "data" =>  $clients_list,
        ]);
    }
}
