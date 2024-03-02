<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\WelcomeMail;
use App\Models\VmtEmployee as EmployeeModel;
use App\Models\VmtEmployeeOfficeDetails;
use App\Models\VmtClientMaster;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class VmtEmployee implements ToModel,  WithHeadingRow,WithCalculatedFormulas
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        //dd($row);
        if($row['employee_name'] != null){

            $user =  User::create([
                'name' => $row['employee_name'],
                'email' => $row["email"],
                'password' => Hash::make('abcd@1234'),
                'avatar' =>  'avatar-1.jpg',
            ]);
            $user->assignRole("Employee");

            $newEmployee = new EmployeeModel;

            $clientData  = VmtClientMaster::first();
            $maxId  = EmployeeModel::max('id')+1;
            if ($clientData) {
                $empNo = $clientData->client_code.$maxId;
            } else {
                $empNo = $maxId;
            }
            $newEmployee->userid = $user->id;
            //dd($row['reporting_manager']);
            //$newEmployee->email   = $row["email"];
            //$newEmployee->emp_no   =    $empNo;
            //$newEmployee->employee_name   =    $row["employee_name"];
            $newEmployee->gender   =    $row["gender"];
            //$newEmployee->manager_emp_id = $row['reporting_manager'];
            //$newEmployee->designation   =    $row["designation"];
            //$newEmployee->department   =    $row["department"];
            $newEmployee->doj   =    $row["doj"];
            $newEmployee->dol   =    $row["doj"];
            $newEmployee->location   =    $row["work_location"];
            $newEmployee->dob   =    $row["dob"];
            $newEmployee->father_name   =    $row["father_name"];
            $newEmployee->pan_number   =    $row["pan_no"];
            $newEmployee->aadhar_number = $row["aadhar"];

            $newEmployee->save();


            $empOffice = new VmtEmployeeOfficeDetails;
            $empOffice->emp_id   = $newEmployee->id;
            $empOffice->user_id = $user->id;
            $empOffice->department = $row["department"];// => "lk"
            $empOffice->designation = $row["designation"];// => "k"
            //$empOffice->l1_manager_  = $row["reporting_manager"];// => "k"
            $empOffice->officical_mail = $row["official_mail"];
            $empOffice->save();

            \Mail::to($row["email"])->send(new WelcomeMail($row["email"], 'abcd@1234', url('login')  ));

            return $newEmployee;

        }

    }
}
