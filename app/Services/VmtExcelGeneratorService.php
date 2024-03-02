<?php

namespace App\Services;

use Maatwebsite\Excel\Facades\Excel;
use App\Models\VmtClientMaster;
use App\Models\Department;
use Maatwebsite\Excel\Concerns\ToArray;
use App\Models\VmtMaritalStatus;
use App\Models\VmtBloodGroup;
use App\Models\User;
use App\Models\Bank;

class VmtExcelGeneratorService
{

    public function downloadQuickOnbaordExcel()
    {
        $onbaord_excel_details = array();
        $onbaord_excel_details['title'] = sessionGetSelectedClientName();
        if (VmtClientMaster::count() == 1) {
            $client_list_query = VmtClientMaster::pluck('client_fullname')->toArray();
            $manager_emp_code = User::where('org_role', 4)->pluck('user_code')->toArray();
        } else {
            if (sessionGetSelectedClientid() == 1) {
                $client_list_query = VmtClientMaster::whereNotIn('id', [1])->pluck('client_fullname')->toArray();
                $manager_emp_code = User::where('org_role', 4)->pluck('user_code')->toArray();
            } else {
                $client_list_query = VmtClientMaster::where('id', sessionGetSelectedClientid())->pluck('client_fullname')->toArray();
                $manager_emp_code = User::where('org_role', 4)->where('client_id', sessionGetSelectedClientid())->pluck('user_code')->toArray();
            }
        }

        $onbaord_excel_details['client_list'] = (sprintf('"%s"', implode(',', $client_list_query)));
        $onbaord_excel_details['managr_code'] = (sprintf('"%s"', implode(',', $manager_emp_code)));
        $onbaord_excel_details['marital_status'] = (sprintf('"%s"', implode(',', VmtMaritalStatus::pluck('name')->toArray())));
        $onbaord_excel_details['department'] = (sprintf('"%s"', implode(',', Department::pluck('name')->toArray())));
        $onbaord_excel_details['salary'] = 'CTC';
       // dd($onbaord_excel_details);
        return  $onbaord_excel_details;
    }

    public function downloadBulkOnbaordExcel()
    {
        $onbaord_excel_details = array();
        $onbaord_excel_details['title'] = sessionGetSelectedClientName();

        if (VmtClientMaster::count() == 1) {
            $client_list_query = VmtClientMaster::pluck('client_fullname')->toArray();
            $manager_emp_code = User::where('org_role', 4)->pluck('user_code')->toArray();
        } else {
            if (sessionGetSelectedClientid() == 1) {
                $client_list_query = VmtClientMaster::whereNotIn('id', [1])->pluck('client_fullname')->toArray();
                $manager_emp_code = User::where('org_role', 4)->pluck('user_code')->toArray();
            } else {
                $client_list_query = VmtClientMaster::where('id', sessionGetSelectedClientid())->pluck('client_fullname')->toArray();
                $manager_emp_code = User::where('org_role', 4)->where('client_id', sessionGetSelectedClientid())->pluck('user_code')->toArray();
            }
        }

        $onbaord_excel_details['client_list'] = (sprintf('"%s"', implode(',', $client_list_query)));
        $onbaord_excel_details['managr_code'] = (sprintf('"%s"', implode(',', $manager_emp_code)));
        $onbaord_excel_details['marital_status'] = (sprintf('"%s"', implode(',', VmtMaritalStatus::pluck('name')->toArray())));
        $onbaord_excel_details['blood_group'] = (sprintf('"%s"', implode(',', VmtBloodGroup::pluck('name')->toArray())));
        $onbaord_excel_details['department'] = (sprintf('"%s"', implode(',', Department::pluck('name')->toArray())));
        $onbaord_excel_details['bank_details'] = (sprintf('"%s"', implode(',', Bank::pluck('bank_name')->toArray())));
        $onbaord_excel_details['salary'] = 'CTC';
       // dd($onbaord_excel_details);
        return  $onbaord_excel_details;
    }
}
